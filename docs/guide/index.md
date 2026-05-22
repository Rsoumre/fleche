# Démarrage rapide

Bienvenue dans la documentation de **Flèche**. Suivez ce guide pour créer votre première application en quelques minutes.

---

## Installation

```bash
git clone https://github.com/Rsoumre/fleche.git mon-projet
cd mon-projet
composer install
cp .env.exemple .env
php -S localhost:8080 -t public
```

---

## Première route

Ouvrez `public/index.php` :

```php
<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Fleche\Application;
use Fleche\Reponse;

$app = new Application();

$app->routeur->get('/', function () {
    return Reponse::json(['message' => 'Bonjour le monde !']);
});

$app->demarrer();
```

Visitez [http://localhost:8080](http://localhost:8080) — vous devriez voir :

```json
{ "message": "Bonjour le monde !" }
```

---

## Structure du projet

```
mon-projet/
├── public/
│   └── index.php          # Point d'entrée unique
├── src/
│   ├── Controleurs/       # Vos contrôleurs
│   ├── Middlewares/       # Vos middlewares
│   ├── Modeles/           # Vos modèles ORM
│   └── vues/              # Templates PHP
│       ├── layouts/
│       └── partials/
├── stockage/logs/         # Fichiers de logs
├── .env                   # Configuration locale
└── composer.json
```

---

## Étapes suivantes

<div class="grid cards" markdown>

- :material-map-marker-path: **[Routeur](../routeur.md)** — Définir des routes GET, POST, PUT, DELETE
- :material-view-dashboard: **[Contrôleurs](../controleurs.md)** — Organiser la logique dans des classes
- :material-palette: **[Vues](../vues.md)** — Templates PHP avec héritage de gabarit
- :material-database: **[Base de données](../base-de-donnees.md)** — Requêteur fluide et ORM
- :material-shield-check: **[Sécurité](../securite.md)** — CSRF, hachage bcrypt, XSS
- :material-check-all: **[Validation](../validation.md)** — Valider les données utilisateur

</div>
