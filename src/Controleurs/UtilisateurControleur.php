<?php

namespace Fleche\Controleurs;

use Fleche\Requete;
use Fleche\Reponse;

class UtilisateurControleur
{
    public function liste(Requete $req): Reponse
    {
        $utilisateurs = [
            ['id' => 1, 'nom' => 'Harouna'],
            ['id' => 2, 'nom' => 'Fatou'],
        ];

        return Reponse::json($utilisateurs);
    }

    public function afficher(Requete $req): Reponse
    {
        $id = $req->parametres['id'];

        return Reponse::json(['id' => $id, 'nom' => 'Utilisateur ' . $id]);
    }
}
