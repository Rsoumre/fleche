# Vues

Les vues sont des fichiers PHP qui affichent le HTML.

## Emplacement

Les vues se trouvent dans `src/vues/`. Chaque fichier porte l'extension `.php`.

```
src/vues/
├── accueil.php
├── articles/
│   ├── liste.php
│   └── detail.php
```

## Retourner une vue

Depuis un contrôleur :

```php
return $this->vue('accueil', ['titre' => 'Bonjour']);

// Sous-dossier
return $this->vue('articles/liste', ['articles' => $articles]);
```

Ou directement :

```php
return Reponse::vue('accueil', ['titre' => 'Bonjour']);
```

## Créer une vue

```php
<!-- src/vues/accueil.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($titre) ?></title>
</head>
<body>
    <h1><?= htmlspecialchars($titre) ?></h1>
</body>
</html>
```

## Bonne pratique

Toujours utiliser `htmlspecialchars()` pour afficher des variables et éviter les failles XSS :

```php
// Bien
<?= htmlspecialchars($nom) ?>

// Dangereux
<?= $nom ?>
```
