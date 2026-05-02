<?php

namespace Fleche;

abstract class Controleur
{
    protected function vue(string $nom, array $donnees = [], int $statut = 200): Reponse
    {
        return Reponse::vue($nom, $donnees, $statut);
    }
}
