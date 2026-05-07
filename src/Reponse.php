<?php

namespace Fleche;

class Reponse
{
    private string $contenu;
    private int $statut;
    private array $entetes;

    public function __construct(string $contenu = '', int $statut = 200, array $entetes = [])
    {
        $this->contenu = $contenu;
        $this->statut  = $statut;
        $this->entetes = $entetes;
    }

    public static function texte(string $contenu, int $statut = 200): self
    {
        return new self($contenu, $statut, ['Content-Type' => 'text/plain; charset=UTF-8']);
    }

    public static function vue(string $nom, array $donnees = [], int $statut = 200): self
    {
        return new self(
            Vue::rendu($nom, $donnees),
            $statut,
            ['Content-Type' => 'text/html; charset=UTF-8']
        );
    }

    public static function json(mixed $donnees, int $statut = 200): self
    {
        return new self(
            json_encode($donnees, JSON_UNESCAPED_UNICODE),
            $statut,
            ['Content-Type' => 'application/json; charset=UTF-8']
        );
    }

    public static function rediriger(string $url, int $statut = 302): self
    {
        return new self('', $statut, ['Location' => $url]);
    }

    public function envoyer(): void
    {
        http_response_code($this->statut);
        foreach ($this->entetes as $nom => $valeur) {
            header("$nom: $valeur");
        }
        echo $this->contenu;
    }
}
