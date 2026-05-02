<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Fleche\Application;
use Fleche\Reponse;
use Fleche\Controleurs\UtilisateurControleur;
use Fleche\Middlewares\AuthMiddleware;

$app = new Application();

$app->routeur->get('/', function () {
    return Reponse::vue('accueil', [
        'titre'       => 'Bienvenue sur Flèche !',
        'description' => 'Un framework PHP en français.',
    ]);
});

$app->routeur->get('/utilisateurs',        [UtilisateurControleur::class, 'liste']);
$app->routeur->get('/utilisateurs/{id}',   [UtilisateurControleur::class, 'afficher']);
$app->routeur->post('/utilisateurs',       [UtilisateurControleur::class, 'creer']);
$app->routeur->post('/utilisateurs/{id}/supprimer', [UtilisateurControleur::class, 'supprimer']);

$app->demarrer();
