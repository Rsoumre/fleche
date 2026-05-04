<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($titre) ?></title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: system-ui, sans-serif;
            background: #0f0f0f;
            color: #f0f0f0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .hero {
            text-align: center;
            padding: 40px 20px;
        }

        .badge {
            display: inline-block;
            background: #e74c3c22;
            color: #e74c3c;
            border: 1px solid #e74c3c55;
            padding: 6px 16px;
            border-radius: 999px;
            font-size: 13px;
            margin-bottom: 24px;
            letter-spacing: 1px;
        }

        h1 {
            font-size: 64px;
            font-weight: 800;
            color: #e74c3c;
            letter-spacing: -2px;
            margin-bottom: 16px;
        }

        .sous-titre {
            font-size: 20px;
            color: #888;
            max-width: 480px;
            line-height: 1.6;
            margin-bottom: 40px;
        }

        .fonctionnalites {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            justify-content: center;
            margin-bottom: 48px;
        }

        .tag {
            background: #1a1a1a;
            border: 1px solid #2a2a2a;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 14px;
            color: #aaa;
        }

        .code {
            background: #1a1a1a;
            border: 1px solid #2a2a2a;
            border-radius: 12px;
            padding: 20px 32px;
            font-family: monospace;
            font-size: 15px;
            color: #e74c3c;
            margin-bottom: 16px;
        }

        .note {
            font-size: 13px;
            color: #555;
        }
    </style>
</head>
<body>
    <div class="hero">
        <div class="badge">Framework PHP ⚡</div>

        <h1>Flèche</h1>

        <p class="sous-titre"><?= htmlspecialchars($description) ?></p>

        <div class="fonctionnalites">
            <span class="tag">Routeur</span>
            <span class="tag">Contrôleurs</span>
            <span class="tag">Vues</span>
            <span class="tag">Base de données</span>
            <span class="tag">Validation</span>
            <span class="tag">Middlewares</span>
            <span class="tag">Sessions</span>
        </div>

        <div class="code">composer require rsoumre/fleche</div>

        <p class="note">PHP &gt;= 8.0 · MySQL · Open source</p>
    </div>
</body>
</html>
