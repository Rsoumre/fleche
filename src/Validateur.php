<?php

namespace Fleche;

class Validateur
{
    private array $erreurs = [];
    private \PDO $pdo;

    public function __construct(
        private array $donnees,
        private array $regles,
        ?\PDO $pdo = null
    ) {
        if ($pdo !== null) {
            $this->pdo = $pdo;
        }
    }

    public static function verifier(array $donnees, array $regles, ?\PDO $pdo = null): self
    {
        $instance = new self($donnees, $regles, $pdo);
        $instance->valider();
        return $instance;
    }

    public function valider(): array
    {
        foreach ($this->regles as $champ => $reglesBrutes) {
            $valeur = $this->donnees[$champ] ?? null;
            $regles = explode('|', $reglesBrutes);

            $estNullable = in_array('nullable', $regles);

            if ($estNullable && ($valeur === null || $valeur === '')) {
                continue;
            }

            foreach ($regles as $regle) {
                if ($regle === 'nullable') {
                    continue;
                }
                [$nom, $parametre] = explode(':', $regle, 2) + [null, null];
                $this->appliquer($champ, $valeur, $nom, $parametre);
            }
        }

        return $this->erreurs;
    }

    public function echoue(): bool
    {
        return !empty($this->erreurs);
    }

    public function reussi(): bool
    {
        return empty($this->erreurs);
    }

    public function erreurs(): array
    {
        return $this->erreurs;
    }

    public function premiere(string $champ): ?string
    {
        return $this->erreurs[$champ][0] ?? null;
    }

    private function appliquer(string $champ, mixed $valeur, string $regle, ?string $param): void
    {
        match ($regle) {
            'requis' => $this->verifier2(
                $valeur !== null && $valeur !== '',
                $champ, "Le champ {$champ} est obligatoire."
            ),
            'chaine' => $this->verifier2(
                $valeur === null || is_string($valeur),
                $champ, "Le champ {$champ} doit être une chaîne de caractères."
            ),
            'entier' => $this->verifier2(
                $valeur === null || filter_var($valeur, FILTER_VALIDATE_INT) !== false,
                $champ, "Le champ {$champ} doit être un entier."
            ),
            'numerique' => $this->verifier2(
                $valeur === null || is_numeric($valeur),
                $champ, "Le champ {$champ} doit être un nombre."
            ),
            'email' => $this->verifier2(
                $valeur === null || filter_var($valeur, FILTER_VALIDATE_EMAIL) !== false,
                $champ, "Le champ {$champ} doit être une adresse email valide."
            ),
            'url' => $this->verifier2(
                $valeur === null || filter_var($valeur, FILTER_VALIDATE_URL) !== false,
                $champ, "Le champ {$champ} doit être une URL valide."
            ),
            'booleen' => $this->verifier2(
                $valeur === null || in_array($valeur, [true, false, 0, 1, '0', '1'], true),
                $champ, "Le champ {$champ} doit être un booléen."
            ),
            'min' => $this->verifier2(
                $valeur === null || mb_strlen((string) $valeur) >= (int) $param,
                $champ, "Le champ {$champ} doit contenir au minimum {$param} caractères."
            ),
            'max' => $this->verifier2(
                $valeur === null || mb_strlen((string) $valeur) <= (int) $param,
                $champ, "Le champ {$champ} ne doit pas dépasser {$param} caractères."
            ),
            'min_val' => $this->verifier2(
                $valeur === null || (is_numeric($valeur) && $valeur >= (float) $param),
                $champ, "Le champ {$champ} doit être supérieur ou égal à {$param}."
            ),
            'max_val' => $this->verifier2(
                $valeur === null || (is_numeric($valeur) && $valeur <= (float) $param),
                $champ, "Le champ {$champ} doit être inférieur ou égal à {$param}."
            ),
            'regex' => $this->verifier2(
                $valeur === null || preg_match($param, (string) $valeur),
                $champ, "Le champ {$champ} a un format invalide."
            ),
            'confirme' => $this->verifier2(
                $valeur === ($this->donnees[$champ . '_confirmation'] ?? null),
                $champ, "Le champ {$champ} ne correspond pas à la confirmation."
            ),
            'dans' => $this->verifier2(
                $valeur === null || in_array($valeur, explode(',', $param)),
                $champ, "La valeur du champ {$champ} n'est pas autorisée."
            ),
            'unique' => $this->verifierUnique($champ, $valeur, $param),
            default   => null,
        };
    }

    private function verifier2(bool $condition, string $champ, string $message): void
    {
        if (!$condition) {
            $this->erreurs[$champ][] = $message;
        }
    }

    private function verifierUnique(string $champ, mixed $valeur, ?string $param): void
    {
        if ($valeur === null || !isset($this->pdo)) {
            return;
        }

        [$table, $colonne] = explode(',', $param ?? '') + [null, $champ];
        $sql  = "SELECT COUNT(*) FROM {$table} WHERE {$colonne} = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$valeur]);

        $this->verifier2(
            (int) $stmt->fetchColumn() === 0,
            $champ,
            "La valeur du champ {$champ} est déjà utilisée."
        );
    }
}
