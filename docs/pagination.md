# Pagination

Le `Paginateur` facilite la pagination des résultats de requêtes.

---

## Utilisation avec le Requeteur

```php
$page      = (int) ($req->obtenir('page', 1));
$paginator = DB::table('articles')
    ->filtrer('publie', 1)
    ->trier('created_at', 'DESC')
    ->paginer($page, 15); // $page, $parPage

// Accéder aux données
$articles   = $paginator->items;      // tableau des résultats
$total      = $paginator->total;      // nombre total
$totalPages = $paginator->totalPages;
$aPrecedent = $paginator->aPrecedent;
$aSuivant   = $paginator->aSuivant;
```

---

## Utilisation avec le Modèle

```php
$paginator = Article::requeteur()
    ->filtrer('publie', 1)
    ->trier('created_at', 'DESC')
    ->paginer($page, 10);

// Les items sont des instances d'Article
foreach ($paginator->items as $article) {
    echo $article->titre;
}
```

---

## Afficher les liens de pagination

```php
// Génère des liens HTML <a> simples
echo $paginator->liens('/articles');

// Avec un paramètre de page personnalisé
echo $paginator->liens('/articles', 'p');
// → /articles?p=2
```

Exemple de sortie :

```html
<nav class="pagination">
    <a href="/articles?page=1">&laquo; Précédent</a>
    <a href="/articles?page=1">1</a>
    <a href="/articles?page=2" class="active">2</a>
    <a href="/articles?page=3">3</a>
    <a href="/articles?page=3">Suivant &raquo;</a>
</nav>
```

---

## Utilisation dans une vue

```php
<!-- src/vues/articles/liste.php -->
<?php foreach ($paginator->items as $article): ?>
    <article>
        <h2><?= e($article['titre']) ?></h2>
    </article>
<?php endforeach; ?>

<p>Page <?= $paginator->page ?> sur <?= $paginator->totalPages ?> (<?= $paginator->total ?> articles)</p>

<?= $paginator->liens('/articles') ?>
```

---

## Convertir en tableau (pour les API)

```php
return Reponse::json($paginator->versTableau());
```

Résultat :

```json
{
    "items":       [...],
    "total":       150,
    "par_page":    15,
    "page":        2,
    "total_pages": 10,
    "a_precedent": true,
    "a_suivant":   true
}
```

---

## Exemple complet — API paginée

```php
$app->routeur->get('/api/articles', function ($req) {
    $page      = (int) $req->obtenir('page', 1);
    $parPage   = (int) $req->obtenir('par_page', 20);
    $parPage   = min($parPage, 100); // limiter à 100 max

    $paginator = DB::table('articles')
        ->filtrer('publie', 1)
        ->trier('created_at', 'DESC')
        ->paginer($page, $parPage);

    return Reponse::json($paginator->versTableau());
});
```

---

## Référence — Paginateur

| Propriété / Méthode | Description |
|---|---|
| `$paginator->items` | Tableau des résultats de la page courante |
| `$paginator->total` | Nombre total d'enregistrements |
| `$paginator->page` | Page courante |
| `$paginator->parPage` | Résultats par page |
| `$paginator->totalPages` | Nombre total de pages |
| `$paginator->aPrecedent` | Vrai s'il existe une page précédente |
| `$paginator->aSuivant` | Vrai s'il existe une page suivante |
| `->pagePrecedente()` | Numéro de la page précédente |
| `->pageSuivante()` | Numéro de la page suivante |
| `->liens($url, $param)` | Générer les liens HTML de navigation |
| `->versTableau()` | Convertir en tableau (pour JSON) |
