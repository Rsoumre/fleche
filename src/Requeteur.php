<?php

namespace Fleche;

class Requeteur
{
    private array $filtres  = [];
    private array $valeurs  = [];
    private ?int  $limite   = null;

    public function __construct(
        private \PDO $pdo,
        private string $table
    ) {}

    public function filtrer(string $colonne, mixed $valeur): static
    {
        $this->filtres[] = "{$colonne} = ?";
        $this->valeurs[] = $valeur;
        return $this;
    }

    public function limiter(int $nombre): static
    {
        $this->limite = $nombre;
        return $this;
    }

    public function tout(): array
    {
        $sql = "SELECT * FROM {$this->table}" . $this->construireConditions();

        if ($this->limite !== null) {
            $sql .= " LIMIT {$this->limite}";
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($this->valeurs);
        return $stmt->fetchAll();
    }

    public function premier(): ?array
    {
        $resultat = $this->limiter(1)->tout();
        return $resultat[0] ?? null;
    }

    public function compter(): int
    {
        $sql  = "SELECT COUNT(*) FROM {$this->table}" . $this->construireConditions();
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($this->valeurs);
        return (int) $stmt->fetchColumn();
    }

    public function inserer(array $donnees): string
    {
        $colonnes     = implode(', ', array_keys($donnees));
        $placeholders = implode(', ', array_fill(0, count($donnees), '?'));

        $sql = "INSERT INTO {$this->table} ({$colonnes}) VALUES ({$placeholders})";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(array_values($donnees));
        return $this->pdo->lastInsertId();
    }

    public function modifier(array $donnees): int
    {
        $set  = implode(', ', array_map(fn($col) => "{$col} = ?", array_keys($donnees)));
        $sql  = "UPDATE {$this->table} SET {$set}" . $this->construireConditions();

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([...array_values($donnees), ...$this->valeurs]);
        return $stmt->rowCount();
    }

    public function supprimer(): int
    {
        $sql  = "DELETE FROM {$this->table}" . $this->construireConditions();
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($this->valeurs);
        return $stmt->rowCount();
    }

    private function construireConditions(): string
    {
        if (empty($this->filtres)) {
            return '';
        }

        return ' WHERE ' . implode(' AND ', $this->filtres);
    }
}
