# Flèche ⚡

Flèche est un framework PHP léger avec une API entièrement en français.

## Prérequis

- PHP >= 8.0
- Composer
- MySQL / MariaDB

## Installation

```bash
composer require rsoumre/fleche
```

Ou cloner le projet :

```bash
git clone https://github.com/Rsoumre/fleche.git mon-projet
cd mon-projet
composer install
cp .env.exemple .env
php -S localhost:8080 -t public
```

## Démarrage rapide

```php
<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Fleche\Application;
use Fleche\Reponse;

$app = new Application();

$app->routeur->get('/', function () {
    return Reponse::texte('Bonjour le monde !');
});

$app->demarrer();
```

## Pages de la documentation

- [Routeur](routeur.md)
- [Contrôleurs](controleurs.md)
- [Vues](vues.md)
- [Base de données](base-de-donnees.md)
- [Validation](validation.md)
- [Réponse](reponse.md)
- [Upload de fichiers](fichiers.md)
- [Middlewares](middlewares.md)
- [Sessions](sessions.md)
- [Variables d'environnement](env.md)
