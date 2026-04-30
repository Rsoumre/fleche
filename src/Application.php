<?php

namespace Fleche;

class Application
{
    public Routeur $routeur;
    public Requete $requete;

    public function __construct()
    {
        $this->requete = new Requete();
        $this->routeur = new Routeur($this->requete);
    }

    public function demarrer(): void
    {
        $reponse = $this->routeur->resoudre();
        $reponse->envoyer();
    }
}
