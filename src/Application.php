<?php

namespace Fleche;

class Application
{
    public Routeur $routeur;
    public Requete $requete;

    public function __construct()
    {
        Env::charger(dirname(__DIR__) . '/.env');
        GestionnaireErreurs::enregistrer();
        Session::demarrer();
        $this->requete = new Requete();
        $this->routeur = new Routeur($this->requete);
    }

    public function demarrer(): void
    {
        $reponse = $this->routeur->resoudre();
        $reponse->envoyer();
    }
}
