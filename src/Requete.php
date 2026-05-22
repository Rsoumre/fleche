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
        $this->methode = strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');
        $this->uri     = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
        $this->entetes = getallheaders() ?: [];
        $this->fichiers = $_FILES ?? [];

        $methodeSimulee = $_POST['_methode'] ?? null;
        if ($this->methode === 'POST' && in_array($methodeSimulee, ['PUT', 'PATCH', 'DELETE'])) {
            $this->methode = $methodeSimulee;
        }

        $json = null;
        if (str_contains($this->entetes['Content-Type'] ?? '', 'application/json')) {
            $json = (array) json_decode(file_get_contents('php://input'), true);
        }

        $this->corps = array_merge($_POST, $json ?? []);
    }

    public function obtenir(string $cle, mixed $defaut = null): mixed
    {
        return $_GET[$cle] ?? $defaut;
    }

    public function entree(string $cle, mixed $defaut = null): mixed
    {
        return $this->corps[$cle] ?? $this->parametres[$cle] ?? $defaut;
    }

    public function parametre(string $cle, mixed $defaut = null): mixed
    {
        return $this->parametres[$cle] ?? $defaut;
    }

    public function tous(): array
    {
        return array_merge($_GET, $this->corps, $this->parametres);
    }

    public function a(string $cle): bool
    {
        return isset($this->corps[$cle]) || isset($this->parametres[$cle]);
    }

    public function estJson(): bool
    {
        return str_contains($this->entetes['Content-Type'] ?? '', 'application/json');
    }

    public function estAjax(): bool
    {
        return ($this->entetes['X-Requested-With'] ?? '') === 'XMLHttpRequest';
    }

    public function ip(): string
    {
        return $_SERVER['HTTP_X_FORWARDED_FOR']
            ?? $_SERVER['REMOTE_ADDR']
            ?? '';
    }

    public function entete(string $nom, mixed $defaut = null): mixed
    {
        return $this->entetes[$nom] ?? $defaut;
    }

    public function fichier(string $cle): ?array
    {
        return $this->fichiers[$cle] ?? null;
    }

    public function valider(array $regles, ?\PDO $pdo = null): Validateur
    {
        $validateur = Validateur::verifier($this->corps, $regles, $pdo);

        if ($validateur->echoue()) {
            throw new \InvalidArgumentException(
                json_encode($validateur->erreurs(), JSON_UNESCAPED_UNICODE)
            );
        }

        return $validateur;
    }

    public function validerSans(array $regles, ?\PDO $pdo = null): Validateur
    {
        return Validateur::verifier($this->corps, $regles, $pdo);
    }
}
