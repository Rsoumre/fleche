# Routeur

Le routeur associe une URL et une méthode HTTP à une action (fonction ou contrôleur).

---

## Méthodes disponibles

| Méthode | Usage |
|---|---|
| `get($uri, $action)` | Lecture de données |
| `post($uri, $action)` | Création |
| `put($uri, $action)` | Remplacement complet |
| `patch($uri, $action)` | Mise à jour partielle |
| `delete($uri, $action)` | Suppression |

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
    return Reponse::json(['supprime' => $req->parametres['id']]);
});
```

---

## Paramètres d'URL

Les paramètres sont définis avec `{nom}` dans l'URI et accessibles via `$req->parametres`.

```php
$app->routeur->get('/articles/{slug}', function ($req) {
    $slug = $req->parametres['slug'];
    return Reponse::texte("Article : {$slug}");
});

// Plusieurs paramètres
$app->routeur->get('/categories/{categorie}/articles/{id}', function ($req) {
    $categorie = $req->parametres['categorie'];
    $id        = $req->parametres['id'];
});
```

---

## Utiliser un contrôleur

Passe un tableau `[Classe::class, 'methode']` comme action :

```php
$app->routeur->get('/articles',         [ArticleControleur::class, 'liste']);
$app->routeur->get('/articles/{id}',    [ArticleControleur::class, 'afficher']);
$app->routeur->post('/articles',        [ArticleControleur::class, 'creer']);
$app->routeur->put('/articles/{id}',    [ArticleControleur::class, 'modifier']);
$app->routeur->delete('/articles/{id}', [ArticleControleur::class, 'supprimer']);
```

---

## Middlewares sur une route

Chaîne un ou plusieurs middlewares avec `->middleware()` :

```php
// Un seul middleware
$app->routeur->get('/profil', [ProfilControleur::class, 'index'])
             ->middleware(ConnexionMiddleware::class);

// Plusieurs middlewares (exécutés dans l'ordre)
$app->routeur->get('/admin', [AdminControleur::class, 'index'])
             ->middleware(ConnexionMiddleware::class, AdminMiddleware::class);
```

---

## Formulaires HTML (PUT / PATCH / DELETE)

Les formulaires HTML ne supportent que `GET` et `POST`. Utilisez le champ caché `_method` :

```html
<form method="POST" action="/articles/42">
    <input type="hidden" name="_method" value="DELETE">
    <button type="submit">Supprimer</button>
</form>
```

Flèche lit automatiquement `_method` et redirige vers la bonne route.
