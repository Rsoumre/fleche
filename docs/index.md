# Flèche

**Flèche** est un framework PHP léger avec une API entièrement en français. Conçu pour être simple, lisible et facile à apprendre.

---

## Pourquoi Flèche ?

- **API en français** — méthodes, classes et fonctions nommées en français
- **Léger** — aucune dépendance inutile, code minimal
- **Expressif** — syntaxe fluide et lisible
- **Complet** — routeur, contrôleurs, BDD, validation, sessions, middlewares

---

## Prérequis

| Outil | Version minimale |
|---|---|
| PHP | 8.0 |
| Composer | 2.x |
| MySQL / MariaDB | 5.7 / 10.3 |

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

## Démarrage rapide

Ouvrez `public/index.php` et créez vos premières routes :

```php
<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Fleche\Application;
use Fleche\Reponse;

$app = new Application();

$app->routeur->get('/', function () {
    return Reponse::json(['message' => 'Bonjour le monde !']);
});

$app->routeur->get('/utilisateurs/{id}', function ($req) {
    $id = $req->parametres['id'];
    return Reponse::json(['id' => $id]);
});

$app->demarrer();
```

---

## Structure du projet

```
mon-projet/
├── public/
│   └── index.php         # Point d'entrée
├── src/
│   ├── Controleurs/      # Contrôleurs de l'application
│   ├── Middlewares/      # Middlewares personnalisés
│   └── vues/             # Fichiers de vues PHP
├── vendor/               # Dépendances Composer
├── .env                  # Variables d'environnement
└── composer.json
```

---

## En savoir plus

| Page | Description |
|---|---|
| [Routeur](routeur.md) | Définir des routes GET, POST, PUT, PATCH, DELETE |
| [Contrôleurs](controleurs.md) | Organiser la logique dans des classes |
| [Vues](vues.md) | Afficher du HTML avec des templates PHP |
| [Réponse](reponse.md) | Retourner JSON, HTML, texte ou rediriger |
| [Base de données](base-de-donnees.md) | Lire, insérer, modifier, supprimer |
| [Validation](validation.md) | Valider les données utilisateur |
| [Upload de fichiers](fichiers.md) | Gérer les fichiers envoyés par formulaire |
| [Middlewares](middlewares.md) | Exécuter du code avant/après les routes |
| [Sessions](sessions.md) | Persister des données entre les requêtes |
| [Variables d'environnement](env.md) | Configurer l'application via `.env` |
