<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Fleche\Application;
use Fleche\Reponse;
use Fleche\Controleurs\UtilisateurControleur;
use Fleche\Middlewares\AuthMiddleware;

$app = new Application();

$app->routeur->get('/', function () {
    return Reponse::texte('Bonjour depuis Flèche !');
});

// Route publique
$app->routeur->get('/utilisateurs', [UtilisateurControleur::class, 'liste']);

// Route protégée par le middleware d'authentification
$app->routeur->get('/utilisateurs/{id}', [UtilisateurControleur::class, 'afficher'])
             ->middleware(AuthMiddleware::class);

$app->demarrer();
