# Base de données

Flèche utilise PDO pour communiquer avec MySQL/MariaDB.

## Configuration

Dans le fichier `.env` :

```env
DB_HOTE=localhost
DB_PORT=3306
DB_NOM=ma_base
DB_UTILISATEUR=root
DB_MOT_DE_PASSE=secret
```

## Lire des données

```php
use Fleche\DB;

// Tous les enregistrements
$articles = DB::table('articles')->tout();

// Avec un filtre
$article = DB::table('articles')
    ->filtrer('id', 1)
    ->premier();

// Plusieurs filtres
$resultat = DB::table('articles')
    ->filtrer('categorie', 'tech')
    ->filtrer('publie', 1)
    ->tout();

// Limiter le nombre de résultats
$recents = DB::table('articles')->limiter(5)->tout();

// Compter
$nombre = DB::table('articles')->compter();
```

## Insérer

```php
$id = DB::table('articles')->inserer([
    'titre'   => 'Mon article',
    'contenu' => 'Le contenu...',
]);
```

## Modifier

```php
DB::table('articles')
    ->filtrer('id', 1)
    ->modifier(['titre' => 'Nouveau titre']);
```

## Supprimer

```php
DB::table('articles')
    ->filtrer('id', 1)
    ->supprimer();
```
