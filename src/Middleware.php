<?php

namespace Fleche;

interface Middleware
{
    public function traiter(Requete $requete, callable $suivant): Reponse;
}
