# Flèche ⚡

Un framework PHP léger avec une API entièrement en français.

## Installation

```bash
composer create-project fleche/fleche mon-projet
cd mon-projet
cp .env.exemple .env
php -S localhost:8080 -t public
```

## Démarrage rapide

```php
// public/index.php
$app = new Fleche\Application();

$app->routeur->get('/', function () {
    return Fleche\Reponse::texte('Bonjour le monde !');
});

$app->demarrer();
```

---

## Routeur

```php
$app->routeur->get('/articles/{slug}', [ArticleControleur::class, 'afficher']);
$app->routeur->post('/articles',       [ArticleControleur::class, 'creer']);
```

## Contrôleurs

```php
namespace Fleche\Controleurs;

use Fleche\Controleur;
use Fleche\Requete;
use Fleche\Reponse;

class ArticleControleur extends Controleur
{
    public function afficher(Requete $req): Reponse
    {
        return $this->vue('article', ['slug' => $req->parametres['slug']]);
    }
}
```

## Vues

```php
// src/vues/article.php
<h1><?= htmlspecialchars($slug) ?></h1>
```

## Base de données

```php
use Fleche\DB;

// Lire
$articles = DB::table('articles')->tout();
$article  = DB::table('articles')->filtrer('id', 1)->premier();
$nombre   = DB::table('articles')->compter();

// Écrire
DB::table('articles')->inserer(['titre' => 'Mon article']);
DB::table('articles')->filtrer('id', 1)->modifier(['titre' => 'Nouveau titre']);
DB::table('articles')->filtrer('id', 1)->supprimer();
```

## Validation

```php
$erreurs = $req->valider([
    'titre' => 'requis|chaine|max:200',
    'email' => 'requis|email',
    'age'   => 'requis|entier',
]);

if (!empty($erreurs)) {
    return Reponse::json(['erreurs' => $erreurs], 422);
}
```

| Règle | Description |
|---|---|
| `requis` | Champ obligatoire |
| `chaine` | Doit être du texte |
| `entier` | Doit être un entier |
| `numerique` | Doit être un nombre |
| `email` | Email valide |
| `min:X` | Minimum X caractères |
| `max:X` | Maximum X caractères |

## Middlewares

```php
$app->routeur->get('/profil', [ProfilControleur::class, 'index'])
             ->middleware(ConnexionMiddleware::class);
```

```php
class MonMiddleware implements Fleche\Middleware
{
    public function traiter(Requete $requete, callable $suivant): Reponse
    {
        // avant
        $reponse = $suivant($requete);
        // après
        return $reponse;
    }
}
```

## Sessions

```php
use Fleche\Session;

Session::definir('utilisateur_id', 42);
Session::obtenir('utilisateur_id');
Session::a('utilisateur_id');
Session::supprimer('utilisateur_id');
Session::vider();

// Messages flash (lus une seule fois)
Session::flash('succes', 'Enregistré !');
Session::obtenirFlash('succes');
```

## Variables d'environnement

```env
APP_NOM=MonApp
APP_ENV=developpement
DB_HOTE=localhost
DB_NOM=ma_base
DB_UTILISATEUR=root
DB_MOT_DE_PASSE=secret
```

```php
env('APP_NOM');           // "MonApp"
env('DB_PORT', 3306);     // valeur par défaut si absent
```

---

## Configuration requise

- PHP >= 8.0
- Composer
- MySQL / MariaDB

## Licence

MIT
