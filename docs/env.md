# Variables d'environnement

Les variables d'environnement permettent de configurer l'application sans toucher au code.

## Fichier .env

Crée un fichier `.env` à la racine du projet :

```env
APP_NOM=MonApp
APP_ENV=developpement
APP_URL=http://localhost:8080

DB_HOTE=localhost
DB_PORT=3306
DB_NOM=ma_base
DB_UTILISATEUR=root
DB_MOT_DE_PASSE=secret
```

> Ne commite jamais le fichier `.env` — il contient des informations sensibles.
> Utilise `.env.exemple` pour partager la structure sans les vraies valeurs.

## Lire une variable

```php
// Lire une variable
$nom = env('APP_NOM');

// Avec une valeur par défaut
$port = env('DB_PORT', 3306);
```

## Variables recommandées

| Variable | Description | Exemple |
|---|---|---|
| `APP_NOM` | Nom de l'application | `MonApp` |
| `APP_ENV` | Environnement | `developpement` ou `production` |
| `APP_URL` | URL de base | `http://localhost:8080` |
| `DB_HOTE` | Hôte de la base de données | `localhost` |
| `DB_PORT` | Port de la base de données | `3306` |
| `DB_NOM` | Nom de la base de données | `ma_base` |
| `DB_UTILISATEUR` | Utilisateur MySQL | `root` |
| `DB_MOT_DE_PASSE` | Mot de passe MySQL | `secret` |

## Mode développement vs production

```env
# Affiche les erreurs détaillées
APP_ENV=developpement

# Affiche uniquement un message générique
APP_ENV=production
```
