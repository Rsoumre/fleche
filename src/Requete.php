<?php

namespace Fleche;

class Requete
{
    public string $methode;
    public string $uri;
    public array $corps;
    public array $entetes;
    public array $parametres = [];

    public function __construct()
    {
        $this->methode  = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $this->uri      = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
        $this->corps    = $_POST + (array) json_decode(file_get_contents('php://input'), true);
        $this->entetes  = getallheaders() ?: [];
    }

    public function obtenir(string $cle, mixed $defaut = null): mixed
    {
        return $_GET[$cle] ?? $defaut;
    }

    public function entree(string $cle, mixed $defaut = null): mixed
    {
        return $this->corps[$cle] ?? $defaut;
    }
}
