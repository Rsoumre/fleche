# Vues

Les vues sont des fichiers PHP qui génèrent le HTML renvoyé au navigateur.

---

## Emplacement

```
src/vues/
├── layouts/           # Gabarits de page réutilisables
│   └── app.php
├── partials/          # Morceaux réutilisables (nav, footer…)
│   ├── nav.php
│   └── footer.php
├── articles/
│   ├── liste.php
│   └── detail.php
└── accueil.php
```

---

## Retourner une vue

```php
// Depuis un contrôleur
return $this->vue('accueil');
return $this->vue('articles.liste', ['articles' => $articles]);
return $this->vue('erreurs.404', [], 404);

// Directement
return Reponse::vue('accueil', ['titre' => 'Bonjour']);
```

!!! tip "Notation point"
    Utilisez le point pour les sous-dossiers : `articles.liste` → `articles/liste.php`

---

## Vue simple

```php
<!-- src/vues/articles/liste.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Articles</title>
</head>
<body>
    <h1>Articles</h1>
    <?php foreach ($articles as $article): ?>
        <h2><?= e($article['titre']) ?></h2>
        <p><?= e($article['contenu']) ?></p>
    <?php endforeach; ?>
</body>
</html>
```

---

## Héritage de gabarit (Layout)

### 1. Créer le gabarit

```php
<!-- src/vues/layouts/app.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= Vue::ceder('titre', 'Mon App') ?></title>
    <link rel="stylesheet" href="/css/app.css">
</head>
<body>
    <?php Vue::inclure('nav') ?>

    <main>
        <?= Vue::ceder('contenu') ?>
    </main>

    <?php Vue::inclure('footer') ?>
</body>
</html>
```

### 2. Créer une vue qui étend le gabarit

```php
<!-- src/vues/articles/liste.php -->
<?php Vue::etendre('app') ?>

<?php Vue::section('titre') ?>
    Liste des articles
<?php Vue::fin() ?>

<?php Vue::section('contenu') ?>
    <h1>Articles</h1>
    <?php foreach ($articles as $article): ?>
        <article>
            <h2><?= e($article['titre']) ?></h2>
        </article>
    <?php endforeach; ?>
<?php Vue::fin() ?>
```

---

## Inclure un partial

```php
<!-- Inclure sans données -->
<?php Vue::inclure('nav') ?>

<!-- Inclure avec données -->
<?php Vue::inclure('alerte', ['type' => 'succes', 'message' => 'Sauvegardé !']) ?>
```

```php
<!-- src/vues/partials/alerte.php -->
<div class="alerte alerte-<?= e($type) ?>">
    <?= e($message) ?>
</div>
```

---

## Sécurité — Échapper les variables

Utilisez toujours la fonction `e()` (ou `htmlspecialchars()`) pour éviter les failles XSS :

```php
// Correct
<?= e($nom) ?>
<?= htmlspecialchars($nom, ENT_QUOTES, 'UTF-8') ?>

// Dangereux — ne jamais faire ça avec des données utilisateur
<?= $nom ?>
```

---

## Vue 404 personnalisée

```php
<!-- src/vues/404.php -->
<!DOCTYPE html>
<html lang="fr">
<body>
    <h1>404 — Page introuvable</h1>
    <a href="/">Retour à l'accueil</a>
</body>
</html>
```

---

## Référence — Vue

| Méthode | Description |
|---|---|
| `Vue::rendu($nom, $donnees)` | Rendre une vue et retourner le HTML |
| `Vue::etendre($layout)` | Déclarer le gabarit à utiliser |
| `Vue::section($nom)` | Ouvrir une section nommée |
| `Vue::fin()` | Fermer la section courante |
| `Vue::ceder($nom, $defaut)` | Afficher le contenu d'une section |
| `Vue::inclure($nom, $donnees)` | Inclure un partial |
| `Vue::definirDossier($chemin)` | Changer le dossier des vues |
