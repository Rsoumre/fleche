# Contrôleurs

Les contrôleurs regroupent la logique de traitement des requêtes dans des classes séparées.

---

## Créer un contrôleur

Un contrôleur étend la classe `Controleur` et ses méthodes reçoivent un objet `Requete` et retournent une `Reponse`.

```php
// src/Controleurs/ArticleControleur.php
namespace Fleche\Controleurs;

use Fleche\Controleur;
use Fleche\Requete;
use Fleche\Reponse;
use Fleche\DB;

class ArticleControleur extends Controleur
{
    public function liste(Requete $req): Reponse
    {
        $articles = DB::table('articles')
            ->ordonner('created_at', 'DESC')
            ->tout();

        return $this->vue('articles/liste', compact('articles'));
    }

    public function afficher(Requete $req): Reponse
    {
        $article = DB::table('articles')
            ->filtrer('id', $req->parametres['id'])
            ->premier();

        if (!$article) {
            return Reponse::json(['erreur' => 'Article introuvable'], 404);
        }

        return $this->vue('articles/detail', compact('article'));
    }

    public function creer(Requete $req): Reponse
    {
        $erreurs = $req->valider([
            'titre'   => 'requis|chaine|max:200',
            'contenu' => 'requis|chaine',
        ]);

        if (!empty($erreurs)) {
            return Reponse::json(['erreurs' => $erreurs], 422);
        }

        $id = DB::table('articles')->inserer([
            'titre'   => $req->entree('titre'),
            'contenu' => $req->entree('contenu'),
        ]);

        return Reponse::json(['id' => $id], 201);
    }

    public function supprimer(Requete $req): Reponse
    {
        DB::table('articles')
            ->filtrer('id', $req->parametres['id'])
            ->supprimer();

        return Reponse::rediriger('/articles');
    }
}
```

---

## Enregistrer les routes

```php
// public/index.php
use Fleche\Controleurs\ArticleControleur;

$app->routeur->get('/articles',         [ArticleControleur::class, 'liste']);
$app->routeur->get('/articles/{id}',    [ArticleControleur::class, 'afficher']);
$app->routeur->post('/articles',        [ArticleControleur::class, 'creer']);
$app->routeur->delete('/articles/{id}', [ArticleControleur::class, 'supprimer']);
```

---

## Méthodes disponibles dans un contrôleur

| Méthode | Description |
|---|---|
| `$this->vue($nom, $donnees)` | Retourner une vue HTML |
| `$req->parametres['cle']` | Lire un paramètre d'URL (`/articles/{id}`) |
| `$req->entree('cle')` | Lire une donnée POST ou JSON |
| `$req->obtenir('cle')` | Lire un paramètre GET (`?page=2`) |
| `$req->valider([...])` | Valider les données reçues |
| `$req->aFichier('cle')` | Vérifier si un fichier a été envoyé |
