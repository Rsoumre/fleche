<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Fleche\Application;
use Fleche\Reponse;

$app = new Application();

$app->routeur->get('/', function () {
    return Reponse::texte('Bonjour depuis Flèche !');
});

$app->routeur->get('/json', function () {
    return Reponse::json(['message' => 'Bonjour le monde !', 'framework' => 'Flèche']);
});

$app->routeur->get('/utilisateurs/{id}', function ($req) {
    return Reponse::json(['id' => $req->parametres['id']]);
});

$app->routeur->get('/articles/{categorie}/{slug}', function ($req) {
    return Reponse::json([
        'categorie' => $req->parametres['categorie'],
        'slug'      => $req->parametres['slug'],
    ]);
});

$app->demarrer();
