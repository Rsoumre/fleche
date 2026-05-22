# Base de données

Flèche utilise PDO pour communiquer avec MySQL/MariaDB via une interface fluide en français.

---

## Configuration

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

// Filtrer (AND)
$articles = DB::table('articles')
    ->filtrer('categorie', 'tech')
    ->filtrer('publie', 1)
    ->tout();

// Filtre avec opérateur
$recents = DB::table('articles')
    ->filtrer('vues', 100, '>')
    ->tout();

// Filtre OR
$resultats = DB::table('articles')
    ->filtrer('titre', 'PHP')
    ->ouFiltrer('titre', 'Symfony')
    ->tout();

// Premier résultat
$article = DB::table('articles')->filtrer('id', 1)->premier();

// Trouver par ID
$article = DB::table('articles')->trouver(42);

// Compter
$total = DB::table('articles')->compter();

// Vérifier l'existence
$existe = DB::table('articles')->filtrer('slug', 'mon-article')->existe();
```

---

## Sélectionner des colonnes

```php
$articles = DB::table('articles')
    ->select('id', 'titre', 'created_at')
    ->tout();

// Une seule valeur
$nom = DB::table('utilisateurs')
    ->filtrer('id', 1)
    ->valeur('nom');
```

---

## Trier et limiter

```php
$recents = DB::table('articles')
    ->trier('created_at', 'DESC')
    ->trier('titre', 'ASC')
    ->limiter(10)
    ->decaler(20)
    ->tout();
```

---

## Jointures

```php
// INNER JOIN
$articles = DB::table('articles')
    ->jointure('utilisateurs', 'articles.auteur_id = utilisateurs.id')
    ->select('articles.titre', 'utilisateurs.nom')
    ->tout();

// LEFT JOIN
$articles = DB::table('articles')
    ->joinGauche('commentaires', 'articles.id = commentaires.article_id')
    ->select('articles.titre', 'commentaires.contenu')
    ->tout();
```

---

## Pagination

```php
$page      = (int) ($req->obtenir('page', 1));
$paginator = DB::table('articles')
    ->trier('created_at', 'DESC')
    ->paginer($page, 15); // 15 résultats par page

$articles    = $paginator->items;
$total       = $paginator->total;
$totalPages  = $paginator->totalPages;
$aPrecedent  = $paginator->aPrecedent;
$aSuivant    = $paginator->aSuivant;

// Générer les liens HTML
echo $paginator->liens('/articles');
```

---

## Insérer

```php
$id = DB::table('articles')->inserer([
    'titre'      => 'Mon article',
    'contenu'    => 'Le contenu...',
    'created_at' => date('Y-m-d H:i:s'),
]);
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
DB::table('articles')->filtrer('id', 1)->supprimer();
```

---

## Transactions

Toute exception à l'intérieur du callback déclenche un rollback automatique.

```php
DB::transaction(function () {
    DB::table('commandes')->inserer([
        'utilisateur_id' => 1,
        'total'          => 99.90,
    ]);

    DB::table('stocks')
        ->filtrer('produit_id', 5)
        ->modifier(['quantite' => 10]);
});
```

---

## Requêtes SQL brutes

```php
// SELECT brut — retourne un tableau
$resultats = DB::brut(
    'SELECT * FROM articles WHERE vues > ? AND publie = ?',
    [100, 1]
);

// INSERT / UPDATE / DELETE brut — retourne le nombre de lignes affectées
$lignes = DB::executer(
    'UPDATE articles SET vues = vues + 1 WHERE id = ?',
    [$id]
);
```

---

## Référence — Requeteur

| Méthode | Description |
|---|---|
| `select(string ...$cols)` | Choisir les colonnes |
| `filtrer($col, $val, $op)` | Condition WHERE (AND) |
| `ouFiltrer($col, $val, $op)` | Condition WHERE (OR) |
| `jointure($table, $condition)` | INNER JOIN |
| `joinGauche($table, $condition)` | LEFT JOIN |
| `trier($col, $dir)` | ORDER BY |
| `limiter($n)` | LIMIT |
| `decaler($n)` | OFFSET |
| `tout()` | Retourner tous les résultats |
| `premier()` | Retourner le premier résultat |
| `trouver($id, $cle)` | Trouver par clé primaire |
| `compter()` | COUNT(*) |
| `existe()` | Vrai si au moins un résultat |
| `valeur($colonne)` | Lire une seule valeur |
| `paginer($page, $parPage)` | Retourner un `Paginateur` |
| `inserer($donnees)` | INSERT — retourne l'ID |
| `modifier($donnees)` | UPDATE |
| `supprimer()` | DELETE |

---

## Référence — DB

| Méthode | Description |
|---|---|
| `DB::table($table)` | Créer un Requeteur pour une table |
| `DB::brut($sql, $valeurs)` | Requête SELECT brute |
| `DB::executer($sql, $valeurs)` | Requête INSERT/UPDATE/DELETE brute |
| `DB::transaction($callback)` | Exécuter dans une transaction |
| `DB::connecter()` | Obtenir la connexion PDO |
