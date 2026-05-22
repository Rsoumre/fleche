<?php

namespace Fleche;

class Requeteur
{
    private array $filtres       = [];
    private array $valeurs       = [];
    private array $colonnesSelect = ['*'];
    private array $tris          = [];
    private array $jointures     = [];
    private array $filtresOu     = [];
    private ?int  $limite        = null;
    private ?int  $decalage      = null;

    public function __construct(
        private \PDO $pdo,
        private string $table
    ) {}

    public function select(string ...$colonnes): static
    {
        $this->colonnesSelect = $colonnes;
        return $this;
    }

    public function filtrer(string $colonne, mixed $valeur, string $operateur = '='): static
    {
        $this->filtres[] = "{$colonne} {$operateur} ?";
        $this->valeurs[] = $valeur;
        return $this;
    }

    public function ouFiltrer(string $colonne, mixed $valeur, string $operateur = '='): static
    {
        $this->filtresOu[] = "{$colonne} {$operateur} ?";
        $this->valeurs[]   = $valeur;
        return $this;
    }

    public function jointure(string $table, string $condition, string $type = 'INNER'): static
    {
        $this->jointures[] = "{$type} JOIN {$table} ON {$condition}";
        return $this;
    }

    public function joinGauche(string $table, string $condition): static
    {
        return $this->jointure($table, $condition, 'LEFT');
    }

    public function trier(string $colonne, string $direction = 'ASC'): static
    {
        $direction = strtoupper($direction) === 'DESC' ? 'DESC' : 'ASC';
        $this->tris[] = "{$colonne} {$direction}";
        return $this;
    }

    public function limiter(int $nombre): static
    {
        $this->limite = $nombre;
        return $this;
    }

    public function decaler(int $nombre): static
    {
        $this->decalage = $nombre;
        return $this;
    }

    public function paginer(int $page, int $parPage = 15): Paginateur
    {
        $total   = $this->compter();
        $decalage = ($page - 1) * $parPage;

        $this->limiter($parPage)->decaler($decalage);
        $items = $this->tout();

        return new Paginateur($items, $total, $page, $parPage);
    }

    public function tout(): array
    {
        $stmt = $this->pdo->prepare($this->construireSelect());
        $stmt->execute($this->valeurs);
        return $stmt->fetchAll();
    }

    public function premier(): ?array
    {
        $clone = clone $this;
        $clone->limite = 1;
        $stmt = $this->pdo->prepare($clone->construireSelect());
        $stmt->execute($clone->valeurs);
        $resultat = $stmt->fetch();
        return $resultat ?: null;
    }

    public function trouver(int|string $id, string $cle = 'id'): ?array
    {
        return $this->filtrer($cle, $id)->premier();
    }

    public function compter(): int
    {
        $clone = clone $this;
        $clone->colonnesSelect = ['COUNT(*) as total'];
        $clone->limite   = null;
        $clone->decalage = null;
        $clone->tris     = [];

        $stmt = $this->pdo->prepare($clone->construireSelect());
        $stmt->execute($clone->valeurs);
        return (int) $stmt->fetchColumn();
    }

    public function existe(): bool
    {
        return $this->compter() > 0;
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

    public function insererOuIgnorer(array $donnees): string
    {
        $colonnes     = implode(', ', array_keys($donnees));
        $placeholders = implode(', ', array_fill(0, count($donnees), '?'));

        $sql  = "INSERT IGNORE INTO {$this->table} ({$colonnes}) VALUES ({$placeholders})";
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

    public function valeur(string $colonne): mixed
    {
        $clone = clone $this;
        $clone->colonnesSelect = [$colonne];
        $clone->limite = 1;

        $stmt = $this->pdo->prepare($clone->construireSelect());
        $stmt->execute($clone->valeurs);
        return $stmt->fetchColumn();
    }

    private function construireSelect(): string
    {
        $colonnes = implode(', ', $this->colonnesSelect);
        $sql      = "SELECT {$colonnes} FROM {$this->table}";

        foreach ($this->jointures as $jointure) {
            $sql .= " {$jointure}";
        }

        $sql .= $this->construireConditions();

        if (!empty($this->tris)) {
            $sql .= ' ORDER BY ' . implode(', ', $this->tris);
        }

        if ($this->limite !== null) {
            $sql .= " LIMIT {$this->limite}";
        }

        if ($this->decalage !== null) {
            $sql .= " OFFSET {$this->decalage}";
        }

        return $sql;
    }

    private function construireConditions(): string
    {
        $parties = [];

        if (!empty($this->filtres)) {
            $parties[] = implode(' AND ', $this->filtres);
        }

        if (!empty($this->filtresOu)) {
            $parties[] = implode(' OR ', $this->filtresOu);
        }

        if (empty($parties)) {
            return '';
        }

        return ' WHERE ' . implode(' OR ', $parties);
    }
}
