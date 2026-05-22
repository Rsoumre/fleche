# Contrôleurs

Les contrôleurs regroupent la logique de traitement dans des classes séparées.

---

## Créer un contrôleur

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
        $page     = (int) $req->obtenir('page', 1);
        $paginator = DB::table('articles')
            ->trier('created_at', 'DESC')
            ->paginer($page, 15);

        return $this->vue('articles.liste', ['paginator' => $paginator]);
    }

    public function afficher(Requete $req): Reponse
    {
        $article = DB::table('articles')
            ->filtrer('id', $req->parametre('id'))
            ->premier();

        if (!$article) {
            return Reponse::json(['erreur' => 'Article introuvable'], 404);
        }

        return $this->vue('articles.detail', compact('article'));
    }

    public function creer(Requete $req): Reponse
    {
        $validateur = $req->validerSans([
            'titre'   => 'requis|chaine|max:200',
            'contenu' => 'requis|chaine',
        ]);

        if ($validateur->echoue()) {
            return Reponse::json(['erreurs' => $validateur->erreurs()], 422);
        }

        $id = DB::table('articles')->inserer([
            'titre'      => $req->entree('titre'),
            'contenu'    => $req->entree('contenu'),
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return Reponse::json(['id' => $id], 201);
    }

    public function supprimer(Requete $req): Reponse
    {
        DB::table('articles')
            ->filtrer('id', $req->parametre('id'))
            ->supprimer();

        Session::flash('succes', 'Article supprimé.');
        return Reponse::rediriger('/articles');
    }
}
```

---

## Enregistrer les routes

```php
use Fleche\Controleurs\ArticleControleur;

$app->routeur->get('/articles',         [ArticleControleur::class, 'liste']);
$app->routeur->get('/articles/{id}',    [ArticleControleur::class, 'afficher']);
$app->routeur->post('/articles',        [ArticleControleur::class, 'creer']);
$app->routeur->put('/articles/{id}',    [ArticleControleur::class, 'modifier']);
$app->routeur->delete('/articles/{id}', [ArticleControleur::class, 'supprimer']);
```

---

## Référence — Requete

| Méthode | Description |
|---|---|
| `$req->parametre($cle)` | Lire un paramètre d'URL (`/articles/{id}`) |
| `$req->entree($cle, $defaut)` | Lire une donnée POST ou JSON |
| `$req->obtenir($cle, $defaut)` | Lire un paramètre GET (`?page=2`) |
| `$req->tous()` | Toutes les données fusionnées |
| `$req->a($cle)` | Vérifier si une clé existe |
| `$req->estJson()` | Vrai si la requête envoie du JSON |
| `$req->estAjax()` | Vrai si requête XMLHttpRequest |
| `$req->ip()` | Adresse IP du client |
| `$req->entete($nom)` | Lire un en-tête HTTP |
| `$req->fichier($cle)` | Obtenir les infos d'un fichier uploadé |
| `$req->valider($regles)` | Valider (lève une exception si échec) |
| `$req->validerSans($regles)` | Valider (retourne le Validateur) |
