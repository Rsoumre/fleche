# Variables d'environnement

Les variables d'environnement configurent l'application sans modifier le code source.

---

## Fichier .env

```bash
cp .env.exemple .env
```

```env
APP_NOM=MonApp
APP_ENV=developpement
APP_URL=http://localhost:8080
APP_DEBUG=true

DB_HOTE=localhost
DB_PORT=3306
DB_NOM=ma_base
DB_UTILISATEUR=root
DB_MOT_DE_PASSE=secret
```

!!! warning "Sécurité"
    Ne commitez jamais le fichier `.env`. Ajoutez-le dans `.gitignore`.
    Utilisez `.env.exemple` pour partager la structure sans les vraies valeurs.

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
| `APP_ENV` | Environnement | `developpement` / `production` |
| `APP_URL` | URL de base | `http://localhost:8080` |
| `APP_DEBUG` | Activer les logs debug | `true` / `false` |
| `DB_HOTE` | Hôte MySQL | `localhost` |
| `DB_PORT` | Port MySQL | `3306` |
| `DB_NOM` | Nom de la base | `ma_base` |
| `DB_UTILISATEUR` | Utilisateur MySQL | `root` |
| `DB_MOT_DE_PASSE` | Mot de passe MySQL | `secret` |

---

## Développement vs Production

```env
# Développement
APP_ENV=developpement
APP_DEBUG=true

# Production
APP_ENV=production
APP_DEBUG=false
```

```php
// Adapter le comportement selon l'environnement
if (env('APP_ENV') === 'developpement') {
    // Afficher les détails de l'erreur
}

if (env('APP_DEBUG')) {
    Journalisation::debug('Détail interne', $data);
}
```
