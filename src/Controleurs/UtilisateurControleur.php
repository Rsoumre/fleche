<?php

namespace Fleche\Controleurs;

use Fleche\Controleur;
use Fleche\Requete;
use Fleche\Reponse;
use Fleche\DB;

class UtilisateurControleur extends Controleur
{
    public function liste(Requete $req): Reponse
    {
        $utilisateurs = DB::table('utilisateurs')->tout();

        return $this->vue('utilisateurs', ['utilisateurs' => $utilisateurs]);
    }

    public function afficher(Requete $req): Reponse
    {
        $utilisateur = DB::table('utilisateurs')
            ->filtrer('id', $req->parametres['id'])
            ->premier();

        if (!$utilisateur) {
            return Reponse::json(['erreur' => 'Utilisateur introuvable'], 404);
        }

        return Reponse::json($utilisateur);
    }

    public function creer(Requete $req): Reponse
    {
        $id = DB::table('utilisateurs')->inserer([
            'nom'   => $req->entree('nom'),
            'email' => $req->entree('email'),
        ]);

        return Reponse::json(['id' => $id, 'message' => 'Utilisateur créé'], 201);
    }

    public function supprimer(Requete $req): Reponse
    {
        DB::table('utilisateurs')
            ->filtrer('id', $req->parametres['id'])
            ->supprimer();

        return Reponse::json(['message' => 'Utilisateur supprimé']);
    }
}
