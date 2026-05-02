<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($titre) ?></title>
    <style>
        body { font-family: sans-serif; max-width: 600px; margin: 80px auto; text-align: center; }
        h1   { color: #e74c3c; }
    </style>
</head>
<body>
    <h1><?= htmlspecialchars($titre) ?></h1>
    <p><?= htmlspecialchars($description) ?></p>
    <a href="/utilisateurs">Voir les utilisateurs</a>
</body>
</html>
