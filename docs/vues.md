# Vues

Les vues sont des fichiers PHP qui génèrent le HTML renvoyé au navigateur.

---

## Emplacement

Les vues se trouvent dans `src/vues/`. Vous pouvez les organiser en sous-dossiers.

```
src/vues/
├── accueil.php
├── layout.php
├── articles/
│   ├── liste.php
│   └── detail.php
└── erreurs/
    └── 404.php
```

---

## Retourner une vue

Depuis un contrôleur :

```php
// Vue simple
return $this->vue('accueil');

// Vue avec données
return $this->vue('articles/liste', ['articles' => $articles]);

// Vue avec code HTTP personnalisé
return $this->vue('erreurs/404', [], 404);
```

Directement via `Reponse` :

```php
return Reponse::vue('accueil', ['titre' => 'Bonjour']);
```

---

## Créer une vue

Les variables passées à la vue sont directement accessibles :

```php
<!-- src/vues/articles/liste.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Articles</title>
</head>
<body>
    <h1>Liste des articles</h1>

    <?php foreach ($articles as $article): ?>
        <article>
            <h2><?= htmlspecialchars($article['titre']) ?></h2>
            <p><?= htmlspecialchars($article['contenu']) ?></p>
        </article>
    <?php endforeach; ?>
</body>
</html>
```

---

## Sécurité — Échapper les variables

Utilisez toujours `htmlspecialchars()` pour afficher des variables et éviter les failles XSS :

```php
// Correct — échappe les caractères dangereux
<?= htmlspecialchars($nom) ?>

// Dangereux — ne jamais faire ça avec des données utilisateur
<?= $nom ?>
```

---

## Vue 404 personnalisée

Créez le fichier `src/vues/404.php` pour personnaliser la page d'erreur :

```php
<!-- src/vues/404.php -->
<!DOCTYPE html>
<html lang="fr">
<body>
    <h1>Page introuvable</h1>
    <a href="/">Retour à l'accueil</a>
</body>
</html>
```
