<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Fleche\Application;
use Fleche\Reponse;
use Fleche\Controleurs\UtilisateurControleur;
use Fleche\Middlewares\ConnexionMiddleware;
use Fleche\Session;

$app = new Application();

$app->routeur->get('/', function () {
    return Reponse::vue('accueil', [
        'titre'       => 'Bienvenue sur Flèche !',
        'description' => 'Un framework PHP en français.',
    ]);
});

$app->routeur->get('/utilisateurs',        [UtilisateurControleur::class, 'liste']);
$app->routeur->get('/utilisateurs/{id}',   [UtilisateurControleur::class, 'afficher'])
             ->middleware(ConnexionMiddleware::class);
$app->routeur->post('/utilisateurs',       [UtilisateurControleur::class, 'creer']);
$app->routeur->post('/utilisateurs/{id}/supprimer', [UtilisateurControleur::class, 'supprimer'])
             ->middleware(ConnexionMiddleware::class);

// Exemple de connexion / déconnexion
$app->routeur->post('/connexion', function ($req) {
    Session::definir('utilisateur_id', 1);
    Session::flash('succes', 'Vous êtes connecté !');
    return Reponse::json(['message' => 'Connecté']);
});

$app->routeur->get('/deconnexion', function () {
    Session::vider();
    return Reponse::json(['message' => 'Déconnecté']);
});

$app->demarrer();
