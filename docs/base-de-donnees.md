# Base de données

Flèche utilise PDO pour communiquer avec MySQL/MariaDB via une interface fluide en français.

---

## Configuration

Dans le fichier `.env` :

```env
DB_HOTE=localhost
DB_PORT=3306
DB_NOM=ma_base
DB_UTILISATEUR=root
DB_MOT_DE_PASSE=secret
```

---

## Lire des données

```php
use Fleche\DB;

// Tous les enregistrements
$articles = DB::table('articles')->tout();

// Avec un filtre
$article = DB::table('articles')
    ->filtrer('id', 1)
    ->premier();

// Plusieurs filtres (AND)
$resultats = DB::table('articles')
    ->filtrer('categorie', 'tech')
    ->filtrer('publie', 1)
    ->tout();

// Limiter
$recents = DB::table('articles')->limiter(5)->tout();

// Ordonner
$articles = DB::table('articles')
    ->ordonner('created_at', 'DESC')
    ->tout();

// Pagination
$page = 2;
$parPage = 10;
$articles = DB::table('articles')
    ->ordonner('created_at', 'DESC')
    ->limiter($parPage)
    ->decaler(($page - 1) * $parPage)
    ->tout();

// Compter
$total = DB::table('articles')->compter();
```

---

## Insérer

```php
$id = DB::table('articles')->inserer([
    'titre'      => 'Mon article',
    'contenu'    => 'Le contenu...',
    'created_at' => date('Y-m-d H:i:s'),
]);

// $id contient l'identifiant du nouvel enregistrement
```

---

## Modifier

```php
DB::table('articles')
    ->filtrer('id', 1)
    ->modifier([
        'titre'      => 'Nouveau titre',
        'updated_at' => date('Y-m-d H:i:s'),
    ]);
```

---

## Supprimer

```php
DB::table('articles')
    ->filtrer('id', 1)
    ->supprimer();
```

---

## Référence

| Méthode | Description |
|---|---|
| `DB::table($table)` | Cible une table |
| `->filtrer($col, $val)` | Ajoute un filtre WHERE |
| `->ordonner($col, $dir)` | ORDER BY (ASC ou DESC) |
| `->limiter($n)` | LIMIT |
| `->decaler($n)` | OFFSET |
| `->tout()` | Retourne tous les résultats |
| `->premier()` | Retourne le premier résultat |
| `->compter()` | Retourne le nombre de résultats |
| `->inserer($donnees)` | INSERT — retourne l'ID inséré |
| `->modifier($donnees)` | UPDATE |
| `->supprimer()` | DELETE |
