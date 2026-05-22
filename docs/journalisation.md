# Journalisation

La classe `Journalisation` écrit des logs dans des fichiers pour suivre l'activité de votre application.

---

## Niveaux de logs

| Niveau | Méthode | Usage |
|---|---|---|
| INFO | `Journalisation::info()` | Événements normaux (connexion, création…) |
| AVERTISSEMENT | `Journalisation::avertissement()` | Situations anormales non bloquantes |
| ERREUR | `Journalisation::erreur()` | Erreurs à corriger |
| DEBUG | `Journalisation::debug()` | Informations de débogage (désactivé en production) |

---

## Utilisation

```php
use Fleche\Journalisation;

// Informations
Journalisation::info('Utilisateur connecté', ['id' => 42, 'email' => 'user@example.com']);

// Avertissement
Journalisation::avertissement('Tentative de connexion échouée', ['email' => 'user@example.com']);

// Erreur
Journalisation::erreur('Impossible de se connecter à la base de données', ['hote' => 'localhost']);

// Debug (uniquement si APP_DEBUG=true dans .env)
Journalisation::debug('Requête SQL', ['sql' => 'SELECT * FROM articles WHERE id = 1']);

// Logger une exception directement
try {
    // ...
} catch (\Throwable $e) {
    Journalisation::exception($e);
}
```

---

## Helpers globaux

```php
journal('Utilisateur connecté', 'info', ['id' => 42]);
journal('Erreur critique', 'erreur', ['message' => $e->getMessage()]);
```

---

## Format des logs

Chaque ligne suit ce format :

```
[2025-06-01 14:32:00] [INFO] Utilisateur connecté {"id":42,"email":"user@example.com"}
[2025-06-01 14:33:01] [ERREUR] Connexion BDD échouée {"hote":"localhost"}
```

---

## Emplacement des fichiers

Par défaut, les logs sont écrits dans `stockage/logs/app.log`. Le dossier est créé automatiquement.

```
stockage/
└── logs/
    └── app.log
```

Pour changer le dossier :

```php
use Fleche\Journalisation;

Journalisation::definirDossier('/var/log/mon-app');
```

---

## Activer les logs de débogage

Dans `.env` :

```env
APP_DEBUG=true
```

En production, laissez `APP_DEBUG=false` pour ne pas exposer d'informations sensibles dans les logs.

---

## Référence

| Méthode | Description |
|---|---|
| `Journalisation::info($msg, $ctx)` | Log niveau INFO |
| `Journalisation::avertissement($msg, $ctx)` | Log niveau AVERTISSEMENT |
| `Journalisation::erreur($msg, $ctx)` | Log niveau ERREUR |
| `Journalisation::debug($msg, $ctx)` | Log niveau DEBUG (si APP_DEBUG=true) |
| `Journalisation::exception($e)` | Logger une exception avec sa trace |
| `Journalisation::definirDossier($path)` | Changer le dossier des logs |
