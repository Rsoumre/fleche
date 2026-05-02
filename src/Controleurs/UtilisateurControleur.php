<?php

namespace Fleche\Controleurs;

use Fleche\Controleur;
use Fleche\Requete;
use Fleche\Reponse;

class UtilisateurControleur extends Controleur
{
    public function liste(Requete $req): Reponse
    {
        $utilisateurs = [
            ['id' => 1, 'nom' => 'Harouna'],
            ['id' => 2, 'nom' => 'Fatou'],
        ];

        return $this->vue('utilisateurs', ['utilisateurs' => $utilisateurs]);
    }

    public function afficher(Requete $req): Reponse
    {
        $id = $req->parametres['id'];

        return Reponse::json(['id' => $id, 'nom' => 'Utilisateur ' . $id]);
    }
}
