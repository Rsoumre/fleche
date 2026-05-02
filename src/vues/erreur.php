<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Erreur serveur</title>
    <style>
        body  { font-family: sans-serif; background: #1e1e2e; color: #cdd6f4; margin: 0; padding: 40px; }
        .boite { background: #313244; border-left: 4px solid #f38ba8; padding: 24px; border-radius: 8px; max-width: 900px; margin: 0 auto; }
        h1    { color: #f38ba8; margin: 0 0 8px; }
        .meta { color: #a6adc8; font-size: 14px; margin-bottom: 20px; }
        pre   { background: #1e1e2e; padding: 16px; border-radius: 6px; overflow-x: auto; font-size: 13px; line-height: 1.6; }
    </style>
</head>
<body>
    <div class="boite">
        <h1>500 — Erreur serveur</h1>
        <p class="meta"><?= htmlspecialchars($fichier) ?><?= $ligne ? " (ligne {$ligne})" : '' ?></p>
        <p><?= htmlspecialchars($message) ?></p>
        <?php if ($trace): ?>
            <pre><?= htmlspecialchars($trace) ?></pre>
        <?php endif; ?>
    </div>
</body>
</html>
