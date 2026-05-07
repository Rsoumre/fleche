<?php

namespace Fleche;

class Requete
{
    public string $methode;
    public string $uri;
    public array $corps;
    public array $entetes;
    public array $parametres = [];
    public array $fichiers   = [];

    public function __construct()
    {
        $methode = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        if ($methode === 'POST' && isset($_POST['_method'])) {
            $methode = strtoupper($_POST['_method']);
        }
        $this->methode  = $methode;
        $this->uri      = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
        $this->corps    = $_POST + (array) json_decode(file_get_contents('php://input'), true);
        $this->entetes  = getallheaders() ?: [];
        $this->fichiers = $_FILES;
    }

    public function fichier(string $cle): ?array
    {
        $f = $this->fichiers[$cle] ?? null;
        if ($f === null || $f['error'] !== UPLOAD_ERR_OK) {
            return null;
        }
        return $f;
    }

    public function aFichier(string $cle): bool
    {
        return isset($this->fichiers[$cle]) && $this->fichiers[$cle]['error'] === UPLOAD_ERR_OK;
    }

    public function deplacer(string $cle, string $destination): bool
    {
        $f = $this->fichier($cle);
        if ($f === null) {
            return false;
        }

        $dossier = dirname($destination);
        if (!is_dir($dossier)) {
            mkdir($dossier, 0755, true);
        }

        return move_uploaded_file($f['tmp_name'], $destination);
    }

    public function obtenir(string $cle, mixed $defaut = null): mixed
    {
        return $_GET[$cle] ?? $defaut;
    }

    public function entree(string $cle, mixed $defaut = null): mixed
    {
        return $this->corps[$cle] ?? $defaut;
    }

    public function valider(array $regles): array
    {
        return (new Validateur($this->corps, $regles))->valider();
    }
}
