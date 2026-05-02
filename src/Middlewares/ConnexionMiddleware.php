<?php

namespace Fleche\Middlewares;

use Fleche\Middleware;
use Fleche\Requete;
use Fleche\Reponse;
use Fleche\Session;

class ConnexionMiddleware implements Middleware
{
    public function traiter(Requete $requete, callable $suivant): Reponse
    {
        if (!Session::a('utilisateur_id')) {
            return Reponse::json(['erreur' => 'Vous devez être connecté.'], 401);
        }

        return $suivant($requete);
    }
}
