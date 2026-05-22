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

## Middleware sur un groupe

```php
$app->routeur->groupe([
    'prefixe'     => '/admin',
    'middlewares' => [ConnexionMiddleware::class, AdminMiddleware::class],
], function ($r) {
    $r->get('/tableau',      [AdminControleur::class, 'tableau']);
    $r->get('/utilisateurs', [AdminControleur::class, 'utilisateurs']);
});
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
            return Reponse::rediriger('/connexion');
        }

        return $suivant($requete);
    }
}
```

---

## Exécuter du code après le contrôleur

```php
class PerformanceMiddleware implements Middleware
{
    public function traiter(Requete $requete, callable $suivant): Reponse
    {
        $debut = microtime(true);

        $reponse = $suivant($requete); // ← Appel du contrôleur

        $duree = round((microtime(true) - $debut) * 1000, 2);
        Journalisation::debug("Requête traitée en {$duree}ms", ['uri' => $requete->uri]);

        return $reponse;
    }
}
```

---

## Middleware CSRF

```php
use Fleche\Middleware;
use Fleche\Jeton;

class CsrfMiddleware implements Middleware
{
    public function traiter(Requete $requete, callable $suivant): Reponse
    {
        Jeton::verifierRequete($requete);
        return $suivant($requete);
    }
}
```

---

## Middlewares inclus

### `ConnexionMiddleware`

Vérifie qu'un utilisateur est connecté via la session.

```php
use Fleche\Middlewares\ConnexionMiddleware;

$app->routeur->get('/tableau-de-bord', [DashboardControleur::class, 'index'])
             ->middleware(ConnexionMiddleware::class);
```

### `AuthMiddleware`

Vérifie la présence d'un en-tête `Authorization` (pour les API).

```php
use Fleche\Middlewares\AuthMiddleware;

$app->routeur->get('/api/profil', [ApiControleur::class, 'profil'])
             ->middleware(AuthMiddleware::class);
```

---

## Ordre d'exécution

Les middlewares s'exécutent dans l'ordre de déclaration (pipeline) :

```
Requête → Middleware1 → Middleware2 → Contrôleur → Middleware2 → Middleware1 → Réponse
```

---

## Référence — Interface Middleware

```php
interface Middleware
{
    public function traiter(Requete $requete, callable $suivant): Reponse;
}
```
