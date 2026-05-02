<?php

namespace Fleche;

class Validateur
{
    private array $erreurs = [];

    public function __construct(
        private array $donnees,
        private array $regles
    ) {}

    public function valider(): array
    {
        foreach ($this->regles as $champ => $reglesBrutes) {
            $valeur = $this->donnees[$champ] ?? null;
            $regles = explode('|', $reglesBrutes);

            foreach ($regles as $regle) {
                [$nom, $parametre] = explode(':', $regle, 2) + [null, null];
                $this->appliquer($champ, $valeur, $nom, $parametre);
            }
        }

        return $this->erreurs;
    }

    private function appliquer(string $champ, mixed $valeur, string $regle, ?string $param): void
    {
        match ($regle) {
            'requis'  => $this->verifier(
                $valeur !== null && $valeur !== '',
                $champ, "Le champ {$champ} est obligatoire."
            ),
            'chaine'  => $this->verifier(
                $valeur === null || is_string($valeur),
                $champ, "Le champ {$champ} doit être une chaîne de caractères."
            ),
            'entier'  => $this->verifier(
                $valeur === null || filter_var($valeur, FILTER_VALIDATE_INT) !== false,
                $champ, "Le champ {$champ} doit être un entier."
            ),
            'email'   => $this->verifier(
                $valeur === null || filter_var($valeur, FILTER_VALIDATE_EMAIL) !== false,
                $champ, "Le champ {$champ} doit être une adresse email valide."
            ),
            'min'     => $this->verifier(
                $valeur === null || mb_strlen((string) $valeur) >= (int) $param,
                $champ, "Le champ {$champ} doit contenir au minimum {$param} caractères."
            ),
            'max'     => $this->verifier(
                $valeur === null || mb_strlen((string) $valeur) <= (int) $param,
                $champ, "Le champ {$champ} ne doit pas dépasser {$param} caractères."
            ),
            'numerique' => $this->verifier(
                $valeur === null || is_numeric($valeur),
                $champ, "Le champ {$champ} doit être un nombre."
            ),
            default   => null,
        };
    }

    private function verifier(bool $condition, string $champ, string $message): void
    {
        if (!$condition) {
            $this->erreurs[$champ][] = $message;
        }
    }
}
