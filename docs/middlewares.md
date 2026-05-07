# Middlewares

Un middleware est du code qui s'exécute **avant ou après** le contrôleur d'une route.

---

## Ajouter un middleware à une route

```php
$app->routeur->get('/profil', [ProfilControleur::class, 'index'])
             ->middleware(ConnexionMiddleware::class);

// Plusieurs middlewares (exécutés dans l'ordre)
$app->routeur->get('/admin', [AdminControleur::class, 'index'])
             ->middleware(ConnexionMiddleware::class, AdminMiddleware::class);
```

---

## Créer un middleware

Un middleware implémente l'interface `Middleware` avec la méthode `traiter()`.

```php
// src/Middlewares/ConnexionMiddleware.php
namespace Fleche\Middlewares;

use Fleche\Middleware;
use Fleche\Requete;
use Fleche\Reponse;
use Fleche\Session;

class ConnexionMiddleware implements Middleware
{
    public function traiter(Requete $requete, callable $suivant): Reponse
    {
        if (!Session::a('utilisateur_id')) {
            return Reponse::json(['erreur' => 'Vous devez être connecté.'], 401);
        }

        return $suivant($requete);
    }
}
```

---

## Exécuter du code après le contrôleur

```php
class JournalMiddleware implements Middleware
{
    public function traiter(Requete $requete, callable $suivant): Reponse
    {
        // Avant le contrôleur
        $debut = microtime(true);

        $reponse = $suivant($requete); // Appel du contrôleur

        // Après le contrôleur
        $duree = round((microtime(true) - $debut) * 1000);
        error_log("Requête traitée en {$duree}ms");

        return $reponse;
    }
}
```

---

## Middleware inclus

### ConnexionMiddleware

Vérifie qu'un utilisateur est connecté via la session. Retourne `401` sinon.

```php
use Fleche\Middlewares\ConnexionMiddleware;

$app->routeur->get('/tableau-de-bord', [DashboardControleur::class, 'index'])
             ->middleware(ConnexionMiddleware::class);
```
