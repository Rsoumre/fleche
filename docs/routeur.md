# Routeur

Le routeur associe une URL à une action.

## Routes de base

```php
$app->routeur->get('/accueil', function () {
    return Reponse::texte('Bienvenue !');
});

$app->routeur->post('/contact', function ($req) {
    return Reponse::json(['recu' => true]);
});
```

## Paramètres d'URL

```php
$app->routeur->get('/articles/{slug}', function ($req) {
    $slug = $req->parametres['slug'];
    return Reponse::texte("Article : {$slug}");
});

// Plusieurs paramètres
$app->routeur->get('/categories/{categorie}/articles/{slug}', function ($req) {
    $categorie = $req->parametres['categorie'];
    $slug      = $req->parametres['slug'];
});
```

## Toutes les méthodes HTTP

```php
$app->routeur->get('/articles',        [ArticleControleur::class, 'liste']);
$app->routeur->post('/articles',       [ArticleControleur::class, 'creer']);
$app->routeur->put('/articles/{id}',   [ArticleControleur::class, 'modifier']);
$app->routeur->patch('/articles/{id}', [ArticleControleur::class, 'mettreAJour']);
$app->routeur->delete('/articles/{id}',[ArticleControleur::class, 'supprimer']);
```

### Formulaires HTML (PUT / PATCH / DELETE)

Les formulaires HTML ne supportent que `GET` et `POST`. Utilisez le champ caché `_method` :

```html
<form method="POST">
    <input type="hidden" name="_method" value="DELETE">
</form>
```

## Ajouter un middleware

```php
$app->routeur->get('/profil', [ProfilControleur::class, 'index'])
             ->middleware(ConnexionMiddleware::class);

// Plusieurs middlewares
$app->routeur->post('/admin', [AdminControleur::class, 'index'])
             ->middleware(ConnexionMiddleware::class, AdminMiddleware::class);
```
