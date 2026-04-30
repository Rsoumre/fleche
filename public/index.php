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

$app->demarrer();
