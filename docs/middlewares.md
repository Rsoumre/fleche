# Middlewares

Les middlewares s'exécutent avant ou après chaque requête.

## Utiliser un middleware

```php
$app->routeur->get('/profil', [ProfilControleur::class, 'index'])
             ->middleware(ConnexionMiddleware::class);

// Plusieurs middlewares
$app->routeur->get('/admin', [AdminControleur::class, 'index'])
             ->middleware(ConnexionMiddleware::class, AdminMiddleware::class);
```

## Créer un middleware

```php
// src/Middlewares/MonMiddleware.php
namespace Fleche\Middlewares;

use Fleche\Middleware;
use Fleche\Requete;
use Fleche\Reponse;

class MonMiddleware implements Middleware
{
    public function traiter(Requete $requete, callable $suivant): Reponse
    {
        // Code exécuté AVANT le contrôleur
        
        $reponse = $suivant($requete); // Appel du contrôleur
        
        // Code exécuté APRÈS le contrôleur
        
        return $reponse;
    }
}
```

## Middleware inclus

### ConnexionMiddleware

Vérifie qu'un utilisateur est connecté via la session.

```php
use Fleche\Middlewares\ConnexionMiddleware;

$app->routeur->get('/tableau-de-bord', [DashboardControleur::class, 'index'])
             ->middleware(ConnexionMiddleware::class);
```

Retourne `401` si l'utilisateur n'est pas connecté :

```json
{ "erreur": "Vous devez être connecté." }
```
