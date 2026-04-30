<?php

namespace Fleche\Middlewares;

use Fleche\Middleware;
use Fleche\Requete;
use Fleche\Reponse;

class AuthMiddleware implements Middleware
{
    public function traiter(Requete $requete, callable $suivant): Reponse
    {
        $token = $requete->entetes['Authorization'] ?? null;

        if (!$token) {
            return Reponse::json(['erreur' => 'Non autorisé'], 401);
        }

        return $suivant($requete);
    }
}
