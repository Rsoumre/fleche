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

## Utiliser un contrôleur

```php
$app->routeur->get('/articles', [ArticleControleur::class, 'liste']);
$app->routeur->get('/articles/{id}', [ArticleControleur::class, 'afficher']);
$app->routeur->post('/articles', [ArticleControleur::class, 'creer']);
```

## Ajouter un middleware

```php
$app->routeur->get('/profil', [ProfilControleur::class, 'index'])
             ->middleware(ConnexionMiddleware::class);

// Plusieurs middlewares
$app->routeur->post('/admin', [AdminControleur::class, 'index'])
             ->middleware(ConnexionMiddleware::class, AdminMiddleware::class);
```
