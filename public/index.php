<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Fleche\Application;
use Fleche\Reponse;
use Fleche\Controleurs\UtilisateurControleur;

$app = new Application();

$app->routeur->get('/', function () {
    return Reponse::texte('Bonjour depuis Flèche !');
});

$app->routeur->get('/utilisateurs', [UtilisateurControleur::class, 'liste']);
$app->routeur->get('/utilisateurs/{id}', [UtilisateurControleur::class, 'afficher']);

$app->demarrer();
