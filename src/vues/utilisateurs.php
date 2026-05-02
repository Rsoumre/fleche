<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Utilisateurs</title>
    <style>
        body { font-family: sans-serif; max-width: 600px; margin: 80px auto; }
        ul   { list-style: none; padding: 0; }
        li   { padding: 10px; border-bottom: 1px solid #eee; }
    </style>
</head>
<body>
    <h1>Liste des utilisateurs</h1>
    <ul>
        <?php foreach ($utilisateurs as $u): ?>
            <li>#<?= $u['id'] ?> — <?= htmlspecialchars($u['nom']) ?></li>
        <?php endforeach; ?>
    </ul>
    <a href="/">Retour à l'accueil</a>
</body>
</html>
