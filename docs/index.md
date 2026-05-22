# Flèche

**Flèche** est un framework PHP moderne avec une API entièrement en français. Conçu pour être élégant, rapide et accessible aux développeurs francophones.

---

## Pourquoi Flèche ?

- **API 100% en français** — méthodes, classes et fonctions nommées en français
- **Léger** — zéro dépendance inutile
- **Complet** — routeur, ORM, validation, sessions, middlewares, CSRF, hachage, journalisation
- **Expressif** — syntaxe fluide et lisible
- **PHP 8+** — promotions de propriétés, types d'union, match expression

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
    return Reponse::json(['id' => $req->parametre('id')]);
});

$app->routeur->groupe([
    'prefixe'     => '/admin',
    'middlewares' => [AuthMiddleware::class],
], function ($r) {
    $r->get('/tableau', [AdminControleur::class, 'tableau']);
});

$app->demarrer();
```

---

## Structure du projet

```
mon-projet/
├── public/
│   └── index.php              # Point d'entrée
├── src/
│   ├── Controleurs/           # Contrôleurs de l'application
│   ├── Middlewares/           # Middlewares personnalisés
│   └── vues/
│       ├── layouts/           # Gabarits de page
│       ├── partials/          # Morceaux réutilisables
│       └── accueil.php
├── stockage/
│   └── logs/                  # Fichiers de logs
├── vendor/                    # Dépendances Composer
├── .env
└── composer.json
```

---

## Vue d'ensemble des classes

| Classe | Rôle |
|---|---|
| `Application` | Point d'entrée — initialise le framework |
| `Routeur` | Gestion des routes HTTP |
| `Requete` | Données de la requête entrante |
| `Reponse` | Construction de la réponse HTTP |
| `Vue` | Rendu de templates PHP avec héritage |
| `DB` | Connexion et requêtes base de données |
| `Requeteur` | Constructeur de requêtes SQL fluide |
| `Modele` | Classe de base ORM |
| `Validateur` | Validation des données |
| `Session` | Gestion des sessions et messages flash |
| `Hachage` | Hachage bcrypt des mots de passe |
| `Jeton` | Protection CSRF |
| `Paginateur` | Pagination des résultats |
| `Journalisation` | Écriture de logs dans des fichiers |

---

## Pages de la documentation

| Page | Description |
|---|---|
| [Routeur](routeur.md) | Routes GET, POST, PUT, PATCH, DELETE, groupes, middlewares |
| [Contrôleurs](controleurs.md) | Organiser la logique dans des classes |
| [Vues](vues.md) | Templates PHP avec héritage de layouts |
| [Réponse](reponse.md) | JSON, HTML, redirections, téléchargements, cookies |
| [Base de données](base-de-donnees.md) | Requêteur fluide, jointures, transactions |
| [Modèle ORM](modele.md) | Classe de base Active Record |
| [Validation](validation.md) | Règles de validation des données |
| [Sessions](sessions.md) | Sessions, flash, régénération |
| [Sécurité](securite.md) | CSRF, hachage, protection XSS |
| [Pagination](pagination.md) | Paginer les résultats facilement |
| [Middlewares](middlewares.md) | Pipeline avant/après les routes |
| [Journalisation](journalisation.md) | Logs fichiers par niveaux |
| [Upload de fichiers](fichiers.md) | Gérer les fichiers de formulaires |
| [Variables d'environnement](env.md) | Configuration via `.env` |
