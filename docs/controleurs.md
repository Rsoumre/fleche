# Contrôleurs

Les contrôleurs organisent la logique de l'application dans des classes séparées.

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
        $articles = DB::table('articles')->tout();
        return $this->vue('articles/liste', ['articles' => $articles]);
    }

    public function afficher(Requete $req): Reponse
    {
        $article = DB::table('articles')
            ->filtrer('id', $req->parametres['id'])
            ->premier();

        if (!$article) {
            return Reponse::json(['erreur' => 'Article introuvable'], 404);
        }

        return $this->vue('articles/detail', ['article' => $article]);
    }

    public function creer(Requete $req): Reponse
    {
        $erreurs = $req->valider([
            'titre'  => 'requis|chaine|max:200',
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
}
```

## Méthodes disponibles

| Méthode | Description |
|---|---|
| `$this->vue($nom, $donnees)` | Retourner une vue HTML |
| `$req->parametres['cle']` | Lire un paramètre d'URL |
| `$req->entree('cle')` | Lire une donnée POST/JSON |
| `$req->obtenir('cle')` | Lire un paramètre GET |
| `$req->valider([...])` | Valider les données |
