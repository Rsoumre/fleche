# Routeur

Le routeur associe une URL et une méthode HTTP à une action (fonction ou contrôleur).

---

## Méthodes HTTP disponibles

| Méthode | Usage |
|---|---|
| `get($uri, $action)` | Lecture de données |
| `post($uri, $action)` | Création |
| `put($uri, $action)` | Remplacement complet |
| `patch($uri, $action)` | Mise à jour partielle |
| `delete($uri, $action)` | Suppression |
| `any($uri, $action)` | Répond à toutes les méthodes |

---

## Routes simples

```php
$app->routeur->get('/', function () {
    return Reponse::json(['message' => 'Bienvenue']);
});

$app->routeur->post('/contact', function ($req) {
    return Reponse::json(['recu' => true]);
});

$app->routeur->delete('/articles/{id}', function ($req) {
    return Reponse::json(['supprime' => $req->parametre('id')]);
});
```

---

## Paramètres d'URL

Les paramètres sont définis avec `{nom}` et accessibles via `$req->parametre()`.

```php
$app->routeur->get('/articles/{slug}', function ($req) {
    $slug = $req->parametre('slug');
    return Reponse::texte("Article : {$slug}");
});

// Plusieurs paramètres
$app->routeur->get('/categories/{categorie}/articles/{id}', function ($req) {
    $categorie = $req->parametre('categorie');
    $id        = $req->parametre('id');
});
```

---

## Utiliser un contrôleur

```php
$app->routeur->get('/articles',         [ArticleControleur::class, 'liste']);
$app->routeur->get('/articles/{id}',    [ArticleControleur::class, 'afficher']);
$app->routeur->post('/articles',        [ArticleControleur::class, 'creer']);
$app->routeur->put('/articles/{id}',    [ArticleControleur::class, 'modifier']);
$app->routeur->delete('/articles/{id}', [ArticleControleur::class, 'supprimer']);
```

---

## Middlewares sur une route

```php
// Un seul middleware
$app->routeur->get('/profil', [ProfilControleur::class, 'index'])
             ->middleware(ConnexionMiddleware::class);

// Plusieurs middlewares (exécutés dans l'ordre)
$app->routeur->get('/admin', [AdminControleur::class, 'index'])
             ->middleware(ConnexionMiddleware::class, AdminMiddleware::class);
```

---

## Groupes de routes

Un groupe applique un **préfixe** et des **middlewares** à plusieurs routes d'un coup.

```php
$app->routeur->groupe([
    'prefixe'     => '/admin',
    'middlewares' => [ConnexionMiddleware::class],
], function ($r) {
    $r->get('/tableau',          [AdminControleur::class, 'tableau']);
    $r->get('/utilisateurs',     [AdminControleur::class, 'utilisateurs']);
    $r->delete('/articles/{id}', [AdminControleur::class, 'supprimerArticle']);
});
```

Les groupes peuvent être **imbriqués** :

```php
$app->routeur->groupe(['prefixe' => '/api'], function ($r) {
    $r->groupe(['prefixe' => '/v1', 'middlewares' => [AuthMiddleware::class]], function ($r) {
        $r->get('/profil', [ProfilControleur::class, 'index']);
    });
});
// → GET /api/v1/profil (avec AuthMiddleware)
```

---

## Routes nommées

```php
$app->routeur->nommer('article.afficher',
    $app->routeur->get('/articles/{id}', [ArticleControleur::class, 'afficher'])
);

// Générer l'URL depuis n'importe où
$url = $app->routeur->url('article.afficher', ['id' => 42]);
// → /articles/42
```

---

## Formulaires HTML — Simulation de méthode

Les formulaires HTML ne supportent que `GET` et `POST`. Utilisez le champ caché `_method` :

```html
<form method="POST" action="/articles/42">
    <input type="hidden" name="_method" value="DELETE">
    <button type="submit">Supprimer</button>
</form>
```

---

## Référence

| Méthode | Description |
|---|---|
| `get/post/put/patch/delete($uri, $action)` | Enregistrer une route |
| `any($uri, $action)` | Route pour toutes les méthodes HTTP |
| `groupe($options, $callback)` | Grouper des routes |
| `nommer($nom, $route)` | Nommer une route |
| `url($nom, $parametres)` | Générer l'URL d'une route nommée |
| `->middleware(string ...$classes)` | Attacher des middlewares à une route |
