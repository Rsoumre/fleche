<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flèche — Framework PHP en français</title>
    <meta name="description" content="<?= htmlspecialchars($description) ?>">
    <link rel="icon" type="image/svg+xml" href="/images/logo.svg">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@700;900&family=Inter:wght@300;400;500;600;700;800;900&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">

    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --deep:    #020010;
            --void:    #08021a;
            --purple:  #a855f7;
            --indigo:  #6366f1;
            --cyan:    #22d3ee;
            --gold:    #f59e0b;
            --rose:    #f43f5e;
            --white:   #ffffff;
            --muted:   rgba(255,255,255,0.45);
            --glass:   rgba(255,255,255,0.04);
            --glass-border: rgba(255,255,255,0.08);
        }

        html { scroll-behavior: smooth; }

        body {
            font-family: 'Inter', system-ui, sans-serif;
            background: var(--deep);
            color: var(--white);
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
            cursor: none;
        }

        /* ─── CURSEUR MAGIQUE ─── */
        .curseur {
            width: 10px; height: 10px;
            background: var(--purple);
            border-radius: 50%;
            position: fixed;
            pointer-events: none;
            z-index: 9999;
            transition: transform 0.1s ease, background 0.3s ease;
            mix-blend-mode: screen;
        }

        .curseur-halo {
            width: 40px; height: 40px;
            border: 1px solid rgba(168,85,247,0.4);
            border-radius: 50%;
            position: fixed;
            pointer-events: none;
            z-index: 9998;
            transition: transform 0.15s ease, width 0.3s ease, height 0.3s ease, border-color 0.3s ease;
        }

        /* ─── CANVAS ÉTOILES ─── */
        #canvas-etoiles {
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            pointer-events: none;
            z-index: 0;
        }

        /* ─── ORBES LUMINEUX ─── */
        .orbe {
            position: fixed;
            border-radius: 50%;
            filter: blur(120px);
            pointer-events: none;
            z-index: 0;
            animation: pulser 8s ease-in-out infinite alternate;
        }

        .orbe-1 {
            width: 600px; height: 600px;
            background: radial-gradient(circle, rgba(99,102,241,0.18) 0%, transparent 70%);
            top: -200px; left: -200px;
        }
        .orbe-2 {
            width: 500px; height: 500px;
            background: radial-gradient(circle, rgba(168,85,247,0.15) 0%, transparent 70%);
            top: 30%; right: -150px;
            animation-delay: -3s;
        }
        .orbe-3 {
            width: 400px; height: 400px;
            background: radial-gradient(circle, rgba(34,211,238,0.1) 0%, transparent 70%);
            bottom: 10%; left: 20%;
            animation-delay: -6s;
        }

        @keyframes pulser {
            from { transform: scale(1) translate(0, 0); opacity: 0.6; }
            to   { transform: scale(1.3) translate(30px, -20px); opacity: 1; }
        }

        /* ─── NAV ─── */
        nav {
            position: fixed;
            top: 0; left: 0; right: 0;
            z-index: 100;
            padding: 20px 48px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            backdrop-filter: blur(20px);
            background: rgba(2,0,16,0.6);
            border-bottom: 1px solid var(--glass-border);
            transition: padding 0.3s ease;
        }

        .nav-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .nav-logo img { width: 32px; height: 32px; }

        .nav-logo-texte {
            font-family: 'Cinzel', serif;
            font-size: 20px;
            font-weight: 700;
            background: linear-gradient(135deg, #fff 0%, var(--purple) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .nav-liens {
            display: flex;
            align-items: center;
            gap: 32px;
            list-style: none;
        }

        .nav-liens a {
            color: var(--muted);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: color 0.2s;
        }

        .nav-liens a:hover { color: var(--white); }

        .nav-cta {
            background: linear-gradient(135deg, var(--purple), var(--indigo));
            color: #fff !important;
            padding: 10px 22px;
            border-radius: 8px;
            font-weight: 600 !important;
            transition: opacity 0.2s, transform 0.2s !important;
            box-shadow: 0 0 20px rgba(168,85,247,0.35);
        }

        .nav-cta:hover { opacity: 0.85; transform: translateY(-1px); }

        /* ─── HERO ─── */
        .hero {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 140px 24px 80px;
            position: relative;
            z-index: 1;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(168,85,247,0.1);
            border: 1px solid rgba(168,85,247,0.3);
            border-radius: 999px;
            padding: 8px 20px;
            font-size: 13px;
            color: var(--purple);
            font-weight: 600;
            letter-spacing: 0.5px;
            margin-bottom: 32px;
            animation: entrer 0.8s cubic-bezier(.16,1,.3,1) both;
        }

        .badge-point {
            width: 7px; height: 7px;
            background: var(--purple);
            border-radius: 50%;
            animation: clignoter 2s ease-in-out infinite;
        }

        @keyframes clignoter {
            0%,100% { opacity: 1; }
            50%      { opacity: 0.3; }
        }

        .hero-logo {
            width: 110px; height: 110px;
            margin-bottom: 32px;
            animation: flotter 4s ease-in-out infinite, entrer 0.6s cubic-bezier(.16,1,.3,1) both;
            filter: drop-shadow(0 0 40px rgba(168,85,247,0.5));
        }

        @keyframes flotter {
            0%,100% { transform: translateY(0px); }
            50%      { transform: translateY(-14px); }
        }

        .hero-titre {
            font-family: 'Cinzel', serif;
            font-size: clamp(64px, 10vw, 120px);
            font-weight: 900;
            line-height: 1;
            letter-spacing: -2px;
            margin-bottom: 8px;
            background: linear-gradient(135deg, #fff 0%, rgba(168,85,247,0.9) 50%, var(--cyan) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            background-size: 200% 200%;
            animation: gradient-anime 6s ease infinite, entrer 0.7s cubic-bezier(.16,1,.3,1) both;
        }

        @keyframes gradient-anime {
            0%   { background-position: 0% 50%; }
            50%  { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .hero-sous-titre {
            font-size: clamp(16px, 2vw, 20px);
            color: var(--muted);
            max-width: 560px;
            line-height: 1.8;
            margin: 20px auto 48px;
            font-weight: 400;
            animation: entrer 0.9s cubic-bezier(.16,1,.3,1) both;
        }

        .hero-boutons {
            display: flex;
            gap: 16px;
            flex-wrap: wrap;
            justify-content: center;
            margin-bottom: 56px;
            animation: entrer 1s cubic-bezier(.16,1,.3,1) both;
        }

        .btn-magie {
            position: relative;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 16px 36px;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 700;
            text-decoration: none;
            overflow: hidden;
            transition: transform 0.25s cubic-bezier(.16,1,.3,1), box-shadow 0.25s;
        }

        .btn-magie::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(255,255,255,0.15), transparent);
            opacity: 0;
            transition: opacity 0.25s;
        }

        .btn-magie:hover::before { opacity: 1; }
        .btn-magie:hover { transform: translateY(-3px) scale(1.02); }

        .btn-primaire {
            background: linear-gradient(135deg, var(--purple) 0%, var(--indigo) 100%);
            color: #fff;
            box-shadow: 0 8px 32px rgba(168,85,247,0.4), 0 0 0 1px rgba(168,85,247,0.2);
        }

        .btn-primaire:hover { box-shadow: 0 16px 48px rgba(168,85,247,0.55), 0 0 0 1px rgba(168,85,247,0.3); }

        .btn-fantome {
            background: var(--glass);
            color: #fff;
            border: 1px solid var(--glass-border);
            backdrop-filter: blur(12px);
        }

        .btn-fantome:hover {
            border-color: rgba(168,85,247,0.4);
            box-shadow: 0 8px 32px rgba(168,85,247,0.15);
        }

        /* Terminal install */
        .terminal {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            background: rgba(0,0,0,0.5);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 14px;
            padding: 16px 28px;
            font-family: 'JetBrains Mono', monospace;
            font-size: 14px;
            backdrop-filter: blur(20px);
            animation: entrer 1.1s cubic-bezier(.16,1,.3,1) both;
            cursor: pointer;
            transition: border-color 0.25s, box-shadow 0.25s;
            user-select: all;
        }

        .terminal:hover {
            border-color: rgba(168,85,247,0.4);
            box-shadow: 0 0 32px rgba(168,85,247,0.15);
        }

        .terminal-prompt { color: rgba(168,85,247,0.7); }
        .terminal-cmd    { color: #e2e8f0; }
        .terminal-pkg    { color: var(--cyan); }
        .terminal-copy   { color: var(--muted); font-size: 12px; margin-left: 8px; transition: color 0.2s; }
        .terminal:hover .terminal-copy { color: var(--purple); }

        @keyframes entrer {
            from { opacity: 0; transform: translateY(24px) scale(0.97); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }

        /* ─── SCROLL INDICATOR ─── */
        .scroll-ind {
            position: absolute;
            bottom: 40px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            color: var(--muted);
            font-size: 11px;
            letter-spacing: 2px;
            text-transform: uppercase;
            animation: rebondir 2s ease-in-out infinite;
        }

        .scroll-ind::before {
            content: '';
            width: 1px;
            height: 40px;
            background: linear-gradient(to bottom, var(--purple), transparent);
        }

        @keyframes rebondir {
            0%,100% { transform: translateX(-50%) translateY(0); }
            50%      { transform: translateX(-50%) translateY(8px); }
        }

        /* ─── SECTION COMMUNE ─── */
        .section {
            position: relative;
            z-index: 1;
            padding: 100px 24px;
        }

        .section-inner {
            max-width: 1100px;
            margin: 0 auto;
        }

        .etiquette {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--purple);
            margin-bottom: 16px;
        }

        .etiquette::before {
            content: '';
            width: 24px; height: 1px;
            background: var(--purple);
        }

        .section-titre {
            font-size: clamp(32px, 4vw, 52px);
            font-weight: 800;
            letter-spacing: -1.5px;
            line-height: 1.1;
            margin-bottom: 16px;
        }

        .gradient-texte {
            background: linear-gradient(135deg, #fff 30%, var(--purple));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .section-desc {
            color: var(--muted);
            font-size: 17px;
            line-height: 1.75;
            max-width: 560px;
            margin-bottom: 64px;
        }

        /* ─── FONCTIONNALITÉS ─── */
        .grille-fonc {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(310px, 1fr));
            gap: 20px;
        }

        .carte-fonc {
            position: relative;
            background: var(--glass);
            border: 1px solid var(--glass-border);
            border-radius: 20px;
            padding: 32px;
            overflow: hidden;
            transition: transform 0.35s cubic-bezier(.16,1,.3,1), border-color 0.35s, box-shadow 0.35s;
            opacity: 0;
            transform: translateY(40px);
            cursor: default;
        }

        .carte-fonc.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .carte-fonc::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(ellipse at var(--mx, 50%) var(--my, 50%), rgba(168,85,247,0.08) 0%, transparent 60%);
            opacity: 0;
            transition: opacity 0.4s;
            pointer-events: none;
        }

        .carte-fonc:hover { transform: translateY(-8px) scale(1.01); border-color: rgba(168,85,247,0.25); box-shadow: 0 32px 64px rgba(0,0,0,0.4), 0 0 0 1px rgba(168,85,247,0.1); }
        .carte-fonc:hover::before { opacity: 1; }

        .carte-fonc-lueur {
            position: absolute;
            top: -1px; left: 0; right: 0; height: 2px;
            background: linear-gradient(90deg, transparent, var(--purple), transparent);
            opacity: 0;
            transition: opacity 0.35s;
        }

        .carte-fonc:hover .carte-fonc-lueur { opacity: 1; }

        .fonc-icone {
            width: 52px; height: 52px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-bottom: 20px;
            background: rgba(168,85,247,0.1);
            border: 1px solid rgba(168,85,247,0.15);
        }

        .carte-fonc h3 {
            font-size: 17px;
            font-weight: 700;
            margin-bottom: 10px;
            color: #fff;
        }

        .carte-fonc p {
            font-size: 14px;
            color: rgba(255,255,255,0.4);
            line-height: 1.75;
        }

        /* ─── SECTION CODE ─── */
        .section-code-bg {
            background: linear-gradient(180deg, transparent, rgba(99,102,241,0.04), transparent);
        }

        .code-layout {
            display: grid;
            grid-template-columns: 1fr 1.3fr;
            gap: 64px;
            align-items: center;
        }

        @media (max-width: 900px) { .code-layout { grid-template-columns: 1fr; } }

        .code-fenetre {
            background: rgba(0,0,0,0.6);
            border: 1px solid rgba(255,255,255,0.07);
            border-radius: 20px;
            overflow: hidden;
            backdrop-filter: blur(20px);
            box-shadow: 0 48px 100px rgba(0,0,0,0.6), 0 0 0 1px rgba(168,85,247,0.06);
            opacity: 0;
            transform: translateX(40px);
            transition: opacity 0.7s cubic-bezier(.16,1,.3,1), transform 0.7s cubic-bezier(.16,1,.3,1);
        }

        .code-fenetre.visible { opacity: 1; transform: translateX(0); }

        .code-barre {
            padding: 14px 18px;
            display: flex;
            align-items: center;
            gap: 8px;
            background: rgba(255,255,255,0.03);
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }

        .dot { width: 12px; height: 12px; border-radius: 50%; }
        .dot-r { background: #ff5f57; }
        .dot-y { background: #febc2e; }
        .dot-g { background: #28c840; }

        .code-barre-nom {
            margin-left: auto;
            font-family: 'JetBrains Mono', monospace;
            font-size: 12px;
            color: rgba(255,255,255,0.2);
        }

        pre {
            padding: 28px 32px;
            font-family: 'JetBrains Mono', monospace;
            font-size: 13px;
            line-height: 1.9;
            overflow-x: auto;
            color: rgba(255,255,255,0.7);
        }

        .t-kw   { color: #c084fc; }
        .t-fn   { color: #67e8f9; }
        .t-str  { color: #86efac; }
        .t-cm   { color: rgba(255,255,255,0.2); font-style: italic; }
        .t-cls  { color: #fde68a; }
        .t-var  { color: #f9a8d4; }
        .t-op   { color: rgba(255,255,255,0.35); }
        .t-num  { color: #fb923c; }

        /* ─── STATS ─── */
        .stats-bande {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            border-top: 1px solid var(--glass-border);
            border-bottom: 1px solid var(--glass-border);
            background: rgba(0,0,0,0.3);
            backdrop-filter: blur(20px);
            position: relative;
            z-index: 1;
        }

        .stat-item {
            flex: 1;
            min-width: 180px;
            padding: 48px 24px;
            text-align: center;
            border-right: 1px solid var(--glass-border);
            position: relative;
            overflow: hidden;
        }

        .stat-item:last-child { border-right: none; }

        .stat-item::after {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(ellipse at 50% 100%, rgba(168,85,247,0.08), transparent 70%);
        }

        .stat-nb {
            font-size: 52px;
            font-weight: 900;
            letter-spacing: -3px;
            background: linear-gradient(135deg, #fff, var(--purple));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 6px;
            line-height: 1;
        }

        .stat-lb {
            font-size: 12px;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 1.5px;
            font-weight: 600;
        }

        /* ─── COMPARAISON ─── */
        .comparaison {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
        }

        @media (max-width: 680px) { .comparaison { grid-template-columns: 1fr; } }

        .cmp-colonne {
            background: var(--glass);
            border: 1px solid var(--glass-border);
            border-radius: 20px;
            padding: 32px;
        }

        .cmp-colonne.fleche {
            border-color: rgba(168,85,247,0.25);
            background: rgba(168,85,247,0.05);
        }

        .cmp-titre {
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: var(--muted);
            margin-bottom: 24px;
            padding-bottom: 16px;
            border-bottom: 1px solid var(--glass-border);
        }

        .cmp-colonne.fleche .cmp-titre { color: var(--purple); border-color: rgba(168,85,247,0.2); }

        .cmp-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 18px;
            font-size: 14px;
            color: rgba(255,255,255,0.35);
            line-height: 1.6;
        }

        .cmp-item .ic { font-size: 15px; flex-shrink: 0; margin-top: 1px; }
        .cmp-colonne.fleche .cmp-item { color: rgba(255,255,255,0.75); }

        /* ─── CTA FINAL ─── */
        .section-cta {
            text-align: center;
            padding: 120px 24px;
            position: relative;
            z-index: 1;
            overflow: hidden;
        }

        .cta-lueur {
            position: absolute;
            width: 800px; height: 800px;
            background: radial-gradient(ellipse, rgba(168,85,247,0.15) 0%, transparent 65%);
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            pointer-events: none;
        }

        .cta-titre {
            font-family: 'Cinzel', serif;
            font-size: clamp(36px, 6vw, 72px);
            font-weight: 900;
            letter-spacing: -2px;
            margin-bottom: 20px;
        }

        .cta-desc {
            color: var(--muted);
            font-size: 18px;
            max-width: 480px;
            margin: 0 auto 48px;
            line-height: 1.75;
        }

        /* ─── FOOTER ─── */
        footer {
            position: relative;
            z-index: 1;
            border-top: 1px solid var(--glass-border);
            padding: 40px 48px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;
        }

        .footer-gauche {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
            color: var(--muted);
        }

        .footer-liens {
            display: flex;
            gap: 24px;
        }

        .footer-liens a {
            font-size: 13px;
            color: var(--muted);
            text-decoration: none;
            transition: color 0.2s;
        }

        .footer-liens a:hover { color: var(--purple); }

        /* ─── PARTICLES MAGIQUES ─── */
        .particle {
            position: fixed;
            width: 4px; height: 4px;
            border-radius: 50%;
            pointer-events: none;
            z-index: 1;
            animation: particle-float linear forwards;
        }

        @keyframes particle-float {
            0%   { opacity: 1; transform: translateY(0) scale(1); }
            100% { opacity: 0; transform: translateY(-120px) scale(0); }
        }

        /* ─── RESPONSIVE ─── */
        @media (max-width: 768px) {
            nav { padding: 16px 24px; }
            .nav-liens { display: none; }
            footer { flex-direction: column; text-align: center; }
        }

        /* ─── LIGNE DE DIVISON MAGIQUE ─── */
        .divider {
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(168,85,247,0.4), transparent);
            margin: 0;
            position: relative;
            z-index: 1;
        }

        /* Transition scroll */
        [data-reveal] {
            opacity: 0;
            transform: translateY(40px);
            transition: opacity 0.8s cubic-bezier(.16,1,.3,1), transform 0.8s cubic-bezier(.16,1,.3,1);
        }

        [data-reveal].visible {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>
<body>

<!-- CURSEUR -->
<div class="curseur" id="cur"></div>
<div class="curseur-halo" id="halo"></div>

<!-- FOND ÉTOILES -->
<canvas id="canvas-etoiles"></canvas>

<!-- ORBES -->
<div class="orbe orbe-1"></div>
<div class="orbe orbe-2"></div>
<div class="orbe orbe-3"></div>

<!-- ─── NAVIGATION ─── -->
<nav>
    <a href="/" class="nav-logo">
        <img src="/images/logo.svg" alt="Logo Flèche">
        <span class="nav-logo-texte">Flèche</span>
    </a>
    <ul class="nav-liens">
        <li><a href="#fonctionnalites">Fonctionnalités</a></li>
        <li><a href="#exemple">Exemple</a></li>
        <li><a href="#pourquoi">Pourquoi Flèche ?</a></li>
        <li><a href="https://github.com/Rsoumre/fleche" target="_blank">GitHub</a></li>
        <li><a href="https://rsoumre.github.io/fleche/" target="_blank" class="nav-cta">Documentation</a></li>
    </ul>
</nav>

<!-- ─── HERO ─── -->
<section class="hero">
    <div class="hero-badge">
        <div class="badge-point"></div>
        Framework PHP Open Source · Entièrement en français
    </div>

    <img src="/images/logo.svg" alt="Logo Flèche" class="hero-logo">

    <h1 class="hero-titre">Flèche</h1>

    <p class="hero-sous-titre">
        Le premier framework PHP conçu entièrement en français.<br>
        Élégant, rapide, et intuitif pour les développeurs francophones.
    </p>

    <div class="hero-boutons">
        <a href="https://rsoumre.github.io/fleche/" target="_blank" class="btn-magie btn-primaire">
            ✦ Documentation
        </a>
        <a href="https://github.com/Rsoumre/fleche" target="_blank" class="btn-magie btn-fantome">
            ◈ GitHub
        </a>
    </div>

    <div class="terminal" id="terminal-install" title="Cliquer pour copier">
        <span class="terminal-prompt">$</span>
        <span class="terminal-cmd">composer require </span>
        <span class="terminal-pkg">rsoumre/fleche</span>
        <span class="terminal-copy" id="copier-texte">copier</span>
    </div>

    <div class="scroll-ind">Défiler</div>
</section>

<div class="divider"></div>

<!-- ─── STATS ─── -->
<div class="stats-bande">
    <div class="stat-item" data-reveal>
        <div class="stat-nb">100%</div>
        <div class="stat-lb">En français</div>
    </div>
    <div class="stat-item" data-reveal>
        <div class="stat-nb">PHP 8+</div>
        <div class="stat-lb">Compatibilité</div>
    </div>
    <div class="stat-item" data-reveal>
        <div class="stat-nb">0</div>
        <div class="stat-lb">Dépendances</div>
    </div>
    <div class="stat-item" data-reveal>
        <div class="stat-nb">∞</div>
        <div class="stat-lb">Possibilités</div>
    </div>
</div>

<div class="divider"></div>

<!-- ─── FONCTIONNALITÉS ─── -->
<section class="section" id="fonctionnalites">
    <div class="section-inner">
        <div data-reveal>
            <div class="etiquette">Fonctionnalités</div>
            <h2 class="section-titre gradient-texte">Tout ce dont vous<br>avez besoin</h2>
            <p class="section-desc">Un framework complet avec routage, ORM, validation, sessions, vues avec héritage, et bien plus — le tout en français.</p>
        </div>

        <div class="grille-fonc">
            <?php $fonctionnalites = [
                ['🗺️', 'Routeur Puissant',       'Routes GET, POST, PUT, PATCH, DELETE. Groupes avec préfixes et middlewares, routes nommées, paramètres dynamiques.'],
                ['🗄️', 'ORM Intuitif',           'Modèle de base avec find, create, save, delete, paginate. Requêteur fluide avec jointures, filtres, tri et pagination.'],
                ['✅', 'Validation Complète',    'Règles : requis, email, min, max, regex, unique, confirmé, dans, nullable... Validateur avec messages clairs en français.'],
                ['🎨', 'Vues avec Héritage',     'Système de templates avec etendre(), section(), ceder() et inclure(). Organisation par layouts et partials.'],
                ['🛡️', 'Middlewares',            'Pipeline de middlewares par route ou par groupe. Créez vos propres middlewares en implémentant une seule interface.'],
                ['🔐', 'Sécurité Intégrée',      'Protection CSRF avec Jeton::champ(), hachage bcrypt avec Hachage::creer(), sessions sécurisées avec régénération d\'ID.'],
                ['📋', 'Sessions & Flash',       'Gestion complète des sessions : définir, obtenir, supprimer, vider. Messages flash lus une seule fois automatiquement.'],
                ['💾', 'Base de Données',        'Connexion PDO centralisée avec DB::table(). Transactions sécurisées, requêtes brutes, et requêteur fluide en chaîne.'],
                ['📝', 'Journalisation',         'Logs niveaux info, avertissement, erreur, debug. Écriture fichier avec contexte JSON. Mode debug configurable via .env.'],
            ];
            foreach ($fonctionnalites as $i => $f): ?>
                <div class="carte-fonc" style="transition-delay: <?= $i * 60 ?>ms">
                    <div class="carte-fonc-lueur"></div>
                    <div class="fonc-icone"><?= $f[0] ?></div>
                    <h3><?= $f[1] ?></h3>
                    <p><?= $f[2] ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<div class="divider"></div>

<!-- ─── EXEMPLE CODE ─── -->
<section class="section section-code-bg" id="exemple">
    <div class="section-inner">
        <div class="code-layout">
            <div data-reveal>
                <div class="etiquette">Exemple</div>
                <h2 class="section-titre gradient-texte">Code élégant<br>et lisible</h2>
                <p class="section-desc">La syntaxe de Flèche est pensée pour être naturelle en français. Plus de barrière de langue dans votre code.</p>
                <div style="display:flex; flex-direction:column; gap:14px; margin-top:32px;">
                    <?php $points = [
                        ['✦', 'API fluide et chaînable'],
                        ['✦', 'Noms de méthodes en français'],
                        ['✦', 'Zéro configuration pour démarrer'],
                        ['✦', 'PSR-4 via Composer'],
                    ];
                    foreach ($points as $p): ?>
                        <div style="display:flex;align-items:center;gap:12px;font-size:14px;color:rgba(255,255,255,0.6);">
                            <span style="color:var(--purple);font-size:16px;"><?= $p[0] ?></span>
                            <?= $p[1] ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="code-fenetre">
                <div class="code-barre">
                    <div class="dot dot-r"></div>
                    <div class="dot dot-y"></div>
                    <div class="dot dot-g"></div>
                    <span class="code-barre-nom">public/index.php</span>
                </div>
                <pre><span class="t-cm">// Démarrer l'application</span>
<span class="t-var">$app</span> <span class="t-op">=</span> <span class="t-kw">new</span> <span class="t-cls">Application</span><span class="t-op">();</span>

<span class="t-cm">// Route simple</span>
<span class="t-var">$app</span><span class="t-op">-></span>routeur<span class="t-op">-></span><span class="t-fn">get</span><span class="t-op">(</span><span class="t-str">'/'</span><span class="t-op">,</span> <span class="t-kw">function</span><span class="t-op">() {</span>
    <span class="t-kw">return</span> <span class="t-cls">Reponse</span><span class="t-op">::</span><span class="t-fn">vue</span><span class="t-op">(</span><span class="t-str">'accueil'</span><span class="t-op">);</span>
<span class="t-op">});</span>

<span class="t-cm">// Groupe avec préfixe et middleware</span>
<span class="t-var">$app</span><span class="t-op">-></span>routeur<span class="t-op">-></span><span class="t-fn">groupe</span><span class="t-op">([</span>
    <span class="t-str">'prefixe'</span>     <span class="t-op">=></span> <span class="t-str">'/admin'</span><span class="t-op">,</span>
    <span class="t-str">'middlewares'</span> <span class="t-op">=></span> <span class="t-op">[</span><span class="t-cls">AuthMiddleware</span><span class="t-op">::</span><span class="t-kw">class</span><span class="t-op">],</span>
<span class="t-op">],</span> <span class="t-kw">function</span><span class="t-op">($r) {</span>
    <span class="t-var">$r</span><span class="t-op">-></span><span class="t-fn">get</span><span class="t-op">(</span><span class="t-str">'/tableau'</span><span class="t-op">,</span>
        <span class="t-op">[</span><span class="t-cls">AdminControleur</span><span class="t-op">::</span><span class="t-kw">class</span><span class="t-op">,</span> <span class="t-str">'tableau'</span><span class="t-op">]);</span>
<span class="t-op">});</span>

<span class="t-cm">// ORM — trouver et paginer</span>
<span class="t-cls">Utilisateur</span><span class="t-op">::</span><span class="t-fn">paginer</span><span class="t-op">(</span><span class="t-var">$page</span><span class="t-op">,</span> <span class="t-num">15</span><span class="t-op">);</span>

<span class="t-cm">// Validation fluide</span>
<span class="t-var">$req</span><span class="t-op">-></span><span class="t-fn">valider</span><span class="t-op">([</span>
    <span class="t-str">'email'</span>    <span class="t-op">=></span> <span class="t-str">'requis|email|unique:utilisateurs'</span><span class="t-op">,</span>
    <span class="t-str">'mot_passe'</span> <span class="t-op">=></span> <span class="t-str">'requis|min:8|confirme'</span><span class="t-op">,</span>
<span class="t-op">]);</span>

<span class="t-var">$app</span><span class="t-op">-></span><span class="t-fn">demarrer</span><span class="t-op">();</span></pre>
            </div>
        </div>
    </div>
</section>

<div class="divider"></div>

<!-- ─── POURQUOI ─── -->
<section class="section" id="pourquoi">
    <div class="section-inner">
        <div data-reveal style="text-align:center;margin-bottom:56px;">
            <div class="etiquette" style="justify-content:center;">Pourquoi Flèche ?</div>
            <h2 class="section-titre gradient-texte">Flèche vs les autres</h2>
            <p class="section-desc" style="margin:16px auto 0;">La différence fondamentale : votre code peut être entièrement en français.</p>
        </div>

        <div class="comparaison" data-reveal>
            <div class="cmp-colonne">
                <div class="cmp-titre">❌ Laravel / Symfony</div>
                <?php $contre = [
                    'API entièrement en anglais',
                    'Courbe d\'apprentissage élevée',
                    'Lourd pour de petits projets',
                    'Barrière linguistique pour débutants',
                    'Configuration complexe',
                ];
                foreach ($contre as $c): ?>
                    <div class="cmp-item"><span class="ic">✗</span><?= $c ?></div>
                <?php endforeach; ?>
            </div>
            <div class="cmp-colonne fleche">
                <div class="cmp-titre">✦ Flèche</div>
                <?php $pour = [
                    'API 100% en français',
                    'Prise en main en quelques minutes',
                    'Léger et ciblé',
                    'Accessible aux développeurs francophones',
                    'Démarrage en 3 lignes de code',
                ];
                foreach ($pour as $p): ?>
                    <div class="cmp-item"><span class="ic">✓</span><?= $p ?></div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<div class="divider"></div>

<!-- ─── CTA FINAL ─── -->
<section class="section-cta">
    <div class="cta-lueur"></div>

    <div data-reveal>
        <h2 class="cta-titre gradient-texte">Prêt à coder<br>en français ?</h2>
        <p class="cta-desc">Installez Flèche en une commande et créez votre première route en moins d'une minute.</p>

        <div style="display:flex;gap:16px;justify-content:center;flex-wrap:wrap;">
            <a href="https://rsoumre.github.io/fleche/" target="_blank" class="btn-magie btn-primaire">
                ✦ Commencer maintenant
            </a>
            <a href="https://github.com/Rsoumre/fleche" target="_blank" class="btn-magie btn-fantome">
                ◈ Voir le code source
            </a>
        </div>
    </div>
</section>

<!-- ─── FOOTER ─── -->
<footer>
    <div class="footer-gauche">
        <img src="/images/logo.svg" alt="" style="width:20px;height:20px;opacity:0.5;">
        <span>© 2025 Flèche — Framework PHP en français</span>
    </div>
    <div class="footer-liens">
        <a href="https://github.com/Rsoumre/fleche" target="_blank">GitHub</a>
        <a href="https://rsoumre.github.io/fleche/" target="_blank">Documentation</a>
        <a href="https://github.com/Rsoumre/fleche/blob/main/LICENSE" target="_blank">Licence MIT</a>
    </div>
</footer>

<script>
// ─── CURSEUR MAGIQUE ───
const cur  = document.getElementById('cur');
const halo = document.getElementById('halo');
let mx = 0, my = 0, hx = 0, hy = 0;

document.addEventListener('mousemove', e => {
    mx = e.clientX; my = e.clientY;
    cur.style.left  = mx - 5  + 'px';
    cur.style.top   = my - 5  + 'px';
});

function animHalo() {
    hx += (mx - hx - 20) * 0.12;
    hy += (my - hy - 20) * 0.12;
    halo.style.left = hx + 'px';
    halo.style.top  = hy + 'px';
    requestAnimationFrame(animHalo);
}
animHalo();

document.querySelectorAll('a, button, .carte-fonc').forEach(el => {
    el.addEventListener('mouseenter', () => {
        cur.style.transform  = 'scale(2.5)';
        halo.style.width     = '70px';
        halo.style.height    = '70px';
        halo.style.borderColor = 'rgba(168,85,247,0.7)';
    });
    el.addEventListener('mouseleave', () => {
        cur.style.transform  = 'scale(1)';
        halo.style.width     = '40px';
        halo.style.height    = '40px';
        halo.style.borderColor = 'rgba(168,85,247,0.4)';
    });
});

// ─── CANVAS ÉTOILES ───
const canvas = document.getElementById('canvas-etoiles');
const ctx    = canvas.getContext('2d');
let etoiles  = [];

function redimensionner() {
    canvas.width  = window.innerWidth;
    canvas.height = window.innerHeight;
}
redimensionner();
window.addEventListener('resize', () => { redimensionner(); creerEtoiles(); });

function creerEtoiles() {
    etoiles = [];
    const nb = Math.floor((canvas.width * canvas.height) / 5000);
    for (let i = 0; i < nb; i++) {
        etoiles.push({
            x:     Math.random() * canvas.width,
            y:     Math.random() * canvas.height,
            r:     Math.random() * 1.2 + 0.2,
            o:     Math.random(),
            speed: Math.random() * 0.4 + 0.1,
            t:     Math.random() * Math.PI * 2,
        });
    }
}
creerEtoiles();

function dessinerEtoiles() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    etoiles.forEach(e => {
        e.t += e.speed * 0.02;
        const opacite = 0.3 + 0.5 * Math.sin(e.t);
        ctx.beginPath();
        ctx.arc(e.x, e.y, e.r, 0, Math.PI * 2);
        ctx.fillStyle = `rgba(200,180,255,${opacite})`;
        ctx.fill();
    });
    requestAnimationFrame(dessinerEtoiles);
}
dessinerEtoiles();

// ─── PARTICLES SUR CLIC ───
document.addEventListener('click', e => {
    const couleurs = ['#a855f7','#6366f1','#22d3ee','#f59e0b','#f43f5e'];
    for (let i = 0; i < 8; i++) {
        const p   = document.createElement('div');
        p.className = 'particle';
        const angle = (Math.PI * 2 / 8) * i;
        const dist  = 30 + Math.random() * 60;
        p.style.cssText = `
            left:${e.clientX}px;
            top:${e.clientY}px;
            background:${couleurs[Math.floor(Math.random()*couleurs.length)]};
            width:${3+Math.random()*4}px;
            height:${3+Math.random()*4}px;
            animation-duration:${0.6+Math.random()*0.6}s;
            transform:translate(${Math.cos(angle)*dist}px, ${Math.sin(angle)*dist}px);
        `;
        document.body.appendChild(p);
        setTimeout(() => p.remove(), 1200);
    }
});

// ─── EFFET MAGNÉTIQUE CARTES ───
document.querySelectorAll('.carte-fonc').forEach(carte => {
    carte.addEventListener('mousemove', e => {
        const r  = carte.getBoundingClientRect();
        const x  = ((e.clientX - r.left) / r.width  * 100).toFixed(1);
        const y  = ((e.clientY - r.top)  / r.height * 100).toFixed(1);
        carte.style.setProperty('--mx', x + '%');
        carte.style.setProperty('--my', y + '%');
    });
});

// ─── COPIER COMMANDE ───
document.getElementById('terminal-install').addEventListener('click', () => {
    navigator.clipboard.writeText('composer require rsoumre/fleche').then(() => {
        const span = document.getElementById('copier-texte');
        span.textContent = '✓ copié !';
        span.style.color = '#86efac';
        setTimeout(() => { span.textContent = 'copier'; span.style.color = ''; }, 2000);
    });
});

// ─── SCROLL REVEAL ───
const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('visible');
        }
    });
}, { threshold: 0.1, rootMargin: '0px 0px -60px 0px' });

document.querySelectorAll('[data-reveal], .carte-fonc, .code-fenetre').forEach(el => {
    observer.observe(el);
});

// ─── NAV COMPACTE AU SCROLL ───
const nav = document.querySelector('nav');
window.addEventListener('scroll', () => {
    nav.style.padding = window.scrollY > 60 ? '12px 48px' : '20px 48px';
}, { passive: true });
</script>
</body>
</html>
