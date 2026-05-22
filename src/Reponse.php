<?php

namespace Fleche;

class Reponse
{
    private string $contenu;
    private int $statut;
    private array $entetes;
    private array $cookies = [];

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
            json_encode($donnees, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
            $statut,
            ['Content-Type' => 'application/json; charset=UTF-8']
        );
    }

    public static function rediriger(string $url, int $statut = 302): self
    {
        return new self('', $statut, ['Location' => $url]);
    }

    public static function telecharger(string $cheminFichier, ?string $nomFichier = null): self
    {
        if (!file_exists($cheminFichier)) {
            throw new \RuntimeException("Fichier introuvable : {$cheminFichier}");
        }

        $nomFichier ??= basename($cheminFichier);
        $taille       = filesize($cheminFichier);
        $contenu      = file_get_contents($cheminFichier);

        return new self($contenu, 200, [
            'Content-Type'              => 'application/octet-stream',
            'Content-Disposition'       => "attachment; filename=\"{$nomFichier}\"",
            'Content-Length'            => (string) $taille,
            'Cache-Control'             => 'no-cache, no-store, must-revalidate',
        ]);
    }

    public function avecEntete(string $nom, string $valeur): static
    {
        $clone = clone $this;
        $clone->entetes[$nom] = $valeur;
        return $clone;
    }

    public function avecCookie(
        string $nom,
        string $valeur,
        int $duree = 0,
        string $chemin = '/',
        string $domaine = '',
        bool $securise = false,
        bool $httpSeulement = true
    ): static {
        $clone = clone $this;
        $clone->cookies[] = compact('nom', 'valeur', 'duree', 'chemin', 'domaine', 'securise', 'httpSeulement');
        return $clone;
    }

    public function sansCookie(string $nom): static
    {
        return $this->avecCookie($nom, '', time() - 3600);
    }

    public function envoyer(): void
    {
        http_response_code($this->statut);

        foreach ($this->entetes as $nom => $valeur) {
            header("{$nom}: {$valeur}");
        }

        foreach ($this->cookies as $cookie) {
            setcookie(
                $cookie['nom'],
                $cookie['valeur'],
                $cookie['duree'],
                $cookie['chemin'],
                $cookie['domaine'],
                $cookie['securise'],
                $cookie['httpSeulement']
            );
        }

        echo $this->contenu;
    }
}
