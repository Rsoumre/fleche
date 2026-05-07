<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($titre) ?></title>

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="/images/logo.svg">
    <link rel="icon" type="image/png" href="/images/logo.png">
    <link rel="shortcut icon" href="/images/logo.png">
    <link rel="apple-touch-icon" href="/images/logo.png">

    <!-- SEO -->
    <meta name="description" content="<?= htmlspecialchars($description) ?>">
    <meta name="keywords" content="framework PHP, PHP français, framework français, Flèche">
    <meta name="author" content="Rsoumre">

    <!-- Open Graph (réseaux sociaux + aperçu navigateur) -->
    <meta property="og:title" content="Flèche — Framework PHP en français">
    <meta property="og:description" content="<?= htmlspecialchars($description) ?>">
    <meta property="og:image" content="https://rsoumre.github.io/fleche/images/logo.png">
    <meta property="og:image:width" content="512">
    <meta property="og:image:height" content="512">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://rsoumre.github.io/fleche/">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="Flèche — Framework PHP en français">
    <meta name="twitter:description" content="<?= htmlspecialchars($description) ?>">
    <meta name="twitter:image" content="https://rsoumre.github.io/fleche/images/logo.png">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: system-ui, sans-serif;
            background: #0a0a0a;
            color: #f0f0f0;
            overflow-x: hidden;
        }

        /* HERO */
        .hero {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 60px 20px;
            position: relative;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: radial-gradient(ellipse at 50% 0%, #e74c3c18 0%, transparent 70%);
            pointer-events: none;
        }

        .logo {
            width: 90px;
            height: 90px;
            margin-bottom: 28px;
            animation: apparaitre 0.6s ease;
        }

        .badge {
            display: inline-block;
            background: #e74c3c18;
            color: #e74c3c;
            border: 1px solid #e74c3c44;
            padding: 6px 18px;
            border-radius: 999px;
            font-size: 13px;
            margin-bottom: 24px;
            letter-spacing: 1px;
            animation: apparaitre 0.7s ease;
        }

        h1 {
            font-size: 72px;
            font-weight: 900;
            color: #fff;
            letter-spacing: -3px;
            margin-bottom: 6px;
            animation: glisser-bas 0.6s ease;
        }

        h1 span { color: #e74c3c; }

        .sous-titre {
            font-size: 19px;
            color: #666;
            max-width: 500px;
            line-height: 1.7;
            margin-bottom: 44px;
            animation: glisser-bas 0.7s ease;
        }

        .boutons {
            display: flex;
            gap: 14px;
            flex-wrap: wrap;
            justify-content: center;
            margin-bottom: 60px;
            animation: glisser-bas 0.8s ease;
        }

        .btn-principal {
            background: #e74c3c;
            color: #fff;
            padding: 14px 28px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 700;
            font-size: 15px;
            transition: background 0.2s, transform 0.2s;
        }

        .btn-principal:hover { background: #c0392b; transform: translateY(-2px); }

        .btn-secondaire {
            background: #1a1a1a;
            color: #aaa;
            padding: 14px 28px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            font-size: 15px;
            border: 1px solid #2a2a2a;
            transition: border-color 0.2s, transform 0.2s;
        }

        .btn-secondaire:hover { border-color: #e74c3c; color: #fff; transform: translateY(-2px); }

        .code-install {
            background: #111;
            border: 1px solid #222;
            border-radius: 12px;
            padding: 16px 28px;
            font-family: monospace;
            font-size: 15px;
            color: #e74c3c;
            animation: glisser-bas 0.9s ease;
        }

        .code-install span { color: #555; margin-right: 8px; }

        /* FONCTIONNALITÉS */
        .section {
            padding: 80px 20px;
            max-width: 1000px;
            margin: 0 auto;
        }

        .section-titre {
            text-align: center;
            font-size: 36px;
            font-weight: 800;
            margin-bottom: 12px;
            letter-spacing: -1px;
        }

        .section-sous-titre {
            text-align: center;
            color: #555;
            font-size: 16px;
            margin-bottom: 52px;
        }

        .grille {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
        }

        .carte {
            background: #111;
            border: 1px solid #1e1e1e;
            border-radius: 16px;
            padding: 28px;
            transition: border-color 0.2s, transform 0.2s;
        }

        .carte:hover { border-color: #e74c3c44; transform: translateY(-4px); }

        .carte-icone {
            font-size: 28px;
            margin-bottom: 14px;
        }

        .carte h3 {
            font-size: 17px;
            font-weight: 700;
            margin-bottom: 8px;
            color: #fff;
        }

        .carte p {
            font-size: 14px;
            color: #555;
            line-height: 1.6;
        }

        /* CODE EXEMPLE */
        .section-code {
            padding: 80px 20px;
            background: #080808;
        }

        .code-bloc {
            max-width: 760px;
            margin: 0 auto;
            background: #111;
            border: 1px solid #1e1e1e;
            border-radius: 16px;
            overflow: hidden;
        }

        .code-entete {
            background: #161616;
            padding: 14px 20px;
            display: flex;
            align-items: center;
            gap: 8px;
            border-bottom: 1px solid #1e1e1e;
        }

        .point { width: 12px; height: 12px; border-radius: 50%; }
        .rouge { background: #e74c3c; }
        .jaune { background: #f39c12; }
        .vert  { background: #2ecc71; }

        .code-entete span {
            margin-left: 8px;
            font-size: 13px;
            color: #444;
            font-family: monospace;
        }

        pre {
            padding: 28px;
            font-family: monospace;
            font-size: 14px;
            line-height: 1.8;
            color: #ccc;
            overflow-x: auto;
        }

        .kw  { color: #e74c3c; }
        .fn  { color: #3498db; }
        .str { color: #2ecc71; }
        .cm  { color: #444; }

        /* STATS */
        .stats {
            display: flex;
            justify-content: center;
            gap: 0;
            flex-wrap: wrap;
            border-top: 1px solid #111;
            border-bottom: 1px solid #111;
            background: #080808;
        }

        .stat {
            flex: 1;
            min-width: 160px;
            padding: 40px 20px;
            text-align: center;
            border-right: 1px solid #111;
        }

        .stat:last-child { border-right: none; }

        .stat-nombre {
            font-size: 42px;
            font-weight: 900;
            color: #e74c3c;
            letter-spacing: -2px;
            margin-bottom: 6px;
        }

        .stat-label {
            font-size: 13px;
            color: #444;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* POURQUOI */
        .section-pourquoi {
            padding: 80px 20px;
            max-width: 900px;
            margin: 0 auto;
        }

        .comparaison {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-top: 48px;
        }

        @media (max-width: 600px) {
            .comparaison { grid-template-columns: 1fr; }
            h1 { font-size: 48px; }
        }

        .colonne h3 {
            font-size: 15px;
            font-weight: 700;
            margin-bottom: 20px;
            padding-bottom: 12px;
            border-bottom: 1px solid #1e1e1e;
            color: #666;
        }

        .colonne.fleche h3 { color: #e74c3c; border-color: #e74c3c33; }

        .item-liste {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 16px;
            font-size: 14px;
            color: #888;
            line-height: 1.5;
        }

        .item-liste .icone { font-size: 16px; flex-shrink: 0; margin-top: 1px; }
        .colonne.fleche .item-liste { color: #ccc; }

        /* FOOTER */
        footer {
            text-align: center;
            padding: 40px 20px;
            color: #333;
            font-size: 13px;
            border-top: 1px solid #111;
        }

        footer a { color: #e74c3c; text-decoration: none; }

        /* ANIMATIONS */
        @keyframes apparaitre {
            from { opacity: 0; transform: scale(0.95); }
            to   { opacity: 1; transform: scale(1); }
        }

        @keyframes glisser-bas {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

    <!-- HERO -->
    <section class="hero">
        <img src="/images/logo.svg" alt="Logo Flèche" class="logo">
        <div class="badge">Framework PHP · Open Source</div>
        <h1><span><?= htmlspecialchars($titre) ?></span></h1>
        <p class="sous-titre"><?= htmlspecialchars($description) ?></p>
        <div class="boutons">
            <a href="https://rsoumre.github.io/fleche/" class="btn-principal" target="_blank">Documentation</a>
            <a href="https://github.com/Rsoumre/fleche" class="btn-secondaire" target="_blank">GitHub</a>
        </div>
        <div class="code-install">
            <span>$</span>composer require rsoumre/fleche
        </div>
    </section>

    <!-- FONCTIONNALITÉS -->
    <section class="section">
        <h2 class="section-titre">Tout ce qu'il te faut</h2>
        <p class="section-sous-titre">Un framework complet sans la complexité</p>
        <div class="grille">
            <div class="carte">
                <div class="carte-icone">🛣️</div>
                <h3>Routeur</h3>
                <p>Routes GET et POST avec paramètres dynamiques et support des middlewares.</p>
            </div>
            <div class="carte">
                <div class="carte-icone">🏗️</div>
                <h3>Contrôleurs</h3>
                <p>Organise ta logique dans des classes propres et séparées.</p>
            </div>
            <div class="carte">
                <div class="carte-icone">🎨</div>
                <h3>Vues</h3>
                <p>Templates PHP simples avec passage de variables.</p>
            </div>
            <div class="carte">
                <div class="carte-icone">🗄️</div>
                <h3>Base de données</h3>
                <p>Query builder en français pour MySQL et MariaDB via PDO.</p>
            </div>
            <div class="carte">
                <div class="carte-icone">✅</div>
                <h3>Validation</h3>
                <p>Valide les données avec des règles simples en français.</p>
            </div>
            <div class="carte">
                <div class="carte-icone">🔒</div>
                <h3>Sessions & Middlewares</h3>
                <p>Gestion des sessions et pipeline de middlewares pour protéger tes routes.</p>
            </div>
        </div>
    </section>

    <!-- STATS -->
    <div class="stats">
        <div class="stat">
            <div class="stat-nombre">9</div>
            <div class="stat-label">Fonctionnalités</div>
        </div>
        <div class="stat">
            <div class="stat-nombre">0</div>
            <div class="stat-label">Dépendance externe</div>
        </div>
        <div class="stat">
            <div class="stat-nombre">8.0</div>
            <div class="stat-label">PHP minimum</div>
        </div>
        <div class="stat">
            <div class="stat-nombre">100%</div>
            <div class="stat-label">En français</div>
        </div>
    </div>

    <!-- POURQUOI FLÈCHE -->
    <section class="section-pourquoi">
        <h2 class="section-titre" style="text-align:center">Pourquoi Flèche ?</h2>
        <p class="section-sous-titre" style="text-align:center;color:#555;margin-top:12px">Simple à apprendre, rapide à utiliser</p>

        <div class="comparaison">
            <div class="colonne">
                <h3>Laravel / Symfony</h3>
                <div class="item-liste"><span class="icone">❌</span>Des centaines de fichiers de configuration</div>
                <div class="item-liste"><span class="icone">❌</span>API entièrement en anglais</div>
                <div class="item-liste"><span class="icone">❌</span>Courbe d'apprentissage très longue</div>
                <div class="item-liste"><span class="icone">❌</span>Des dizaines de dépendances</div>
            </div>
            <div class="colonne fleche">
                <h3>Flèche ⚡</h3>
                <div class="item-liste"><span class="icone">✅</span>Un seul fichier pour démarrer</div>
                <div class="item-liste"><span class="icone">✅</span>API 100% en français</div>
                <div class="item-liste"><span class="icone">✅</span>Opérationnel en 5 minutes</div>
                <div class="item-liste"><span class="icone">✅</span>Aucune dépendance externe</div>
            </div>
        </div>
    </section>

    <!-- CODE EXEMPLE -->
    <section class="section-code">
        <div class="code-bloc">
            <div class="code-entete">
                <div class="point rouge"></div>
                <div class="point jaune"></div>
                <div class="point vert"></div>
                <span>index.php</span>
            </div>
            <pre><span class="kw">use</span> Fleche\Application;
<span class="kw">use</span> Fleche\Reponse;

<span class="cm">// Démarrer l'application</span>
<span class="kw">$app</span> = <span class="kw">new</span> <span class="fn">Application</span>();

<span class="cm">// Définir une route</span>
<span class="kw">$app</span>->routeur-><span class="fn">get</span>(<span class="str">'/utilisateurs/{id}'</span>, [UtilisateurControleur::<span class="kw">class</span>, <span class="str">'afficher'</span>])
             -><span class="fn">middleware</span>(ConnexionMiddleware::<span class="kw">class</span>);

<span class="cm">// Lancer</span>
<span class="kw">$app</span>-><span class="fn">demarrer</span>();</pre>
        </div>
    </section>

    <!-- FOOTER -->
    <footer>
        Fait avec ❤️ par <a href="https://github.com/Rsoumre" target="_blank">Rsoumre</a> ·
        <a href="https://github.com/Rsoumre/fleche" target="_blank">GitHub</a> ·
        <a href="https://rsoumre.github.io/fleche/" target="_blank">Documentation</a>
    </footer>

</body>
</html>
