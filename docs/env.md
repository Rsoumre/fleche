# Variables d'environnement

Les variables d'environnement permettent de configurer l'application sans modifier le code source.

---

## Fichier .env

Créez un fichier `.env` à la racine du projet en copiant `.env.exemple` :

```bash
cp .env.exemple .env
```

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

> **Important** — Ne commitez jamais le fichier `.env`. Ajoutez-le dans `.gitignore`. Utilisez `.env.exemple` pour partager la structure sans les vraies valeurs.

---

## Lire une variable

```php
// Lire une variable
$nom = env('APP_NOM');

// Avec une valeur par défaut si absente
$port = env('DB_PORT', 3306);
$env  = env('APP_ENV', 'production');
```

---

## Variables disponibles

| Variable | Description | Exemple |
|---|---|---|
| `APP_NOM` | Nom de l'application | `MonApp` |
| `APP_ENV` | Environnement actuel | `developpement` / `production` |
| `APP_URL` | URL de base | `http://localhost:8080` |
| `DB_HOTE` | Hôte MySQL | `localhost` |
| `DB_PORT` | Port MySQL | `3306` |
| `DB_NOM` | Nom de la base | `ma_base` |
| `DB_UTILISATEUR` | Utilisateur MySQL | `root` |
| `DB_MOT_DE_PASSE` | Mot de passe MySQL | `secret` |

---

## Développement vs Production

```env
# Développement — erreurs détaillées
APP_ENV=developpement

# Production — messages d'erreur génériques
APP_ENV=production
```

Utilisez `env('APP_ENV')` dans votre code pour adapter le comportement :

```php
if (env('APP_ENV') === 'developpement') {
    // Afficher les détails de l'erreur
}
```
