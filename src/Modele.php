<?php

namespace Fleche;

abstract class Modele
{
    protected static string $table = '';
    protected static string $cle   = 'id';
    protected array $attributs     = [];
    protected array $original      = [];
    protected bool $existe         = false;

    public function __construct(array $attributs = [])
    {
        $this->remplir($attributs);
    }

    public function __get(string $nom): mixed
    {
        return $this->attributs[$nom] ?? null;
    }

    public function __set(string $nom, mixed $valeur): void
    {
        $this->attributs[$nom] = $valeur;
    }

    public function __isset(string $nom): bool
    {
        return isset($this->attributs[$nom]);
    }

    public function remplir(array $attributs): static
    {
        foreach ($attributs as $cle => $valeur) {
            $this->attributs[$cle] = $valeur;
        }
        return $this;
    }

    public function versTableau(): array
    {
        return $this->attributs;
    }

    public static function requeteur(): Requeteur
    {
        return DB::table(static::$table);
    }

    public static function tout(): array
    {
        return array_map(
            fn($row) => static::depuisTableau($row),
            static::requeteur()->tout()
        );
    }

    public static function trouver(int|string $id): ?static
    {
        $row = static::requeteur()->trouver($id, static::$cle);
        return $row ? static::depuisTableau($row) : null;
    }

    public static function trouverOuEchouer(int|string $id): static
    {
        $instance = static::trouver($id);

        if ($instance === null) {
            throw new \RuntimeException(static::class . " introuvable pour l'identifiant {$id}.", 404);
        }

        return $instance;
    }

    public static function ou(string $colonne, mixed $valeur, string $operateur = '='): array
    {
        return array_map(
            fn($row) => static::depuisTableau($row),
            static::requeteur()->filtrer($colonne, $valeur, $operateur)->tout()
        );
    }

    public static function premier(string $colonne, mixed $valeur): ?static
    {
        $row = static::requeteur()->filtrer($colonne, $valeur)->premier();
        return $row ? static::depuisTableau($row) : null;
    }

    public static function creer(array $donnees): static
    {
        $id       = static::requeteur()->inserer($donnees);
        $instance = new static($donnees);
        $instance->attributs[static::$cle] = $id;
        $instance->original = $instance->attributs;
        $instance->existe   = true;
        return $instance;
    }

    public function sauvegarder(): bool
    {
        if ($this->existe) {
            $id = $this->attributs[static::$cle] ?? null;

            if ($id === null) {
                return false;
            }

            $modifies = array_diff_assoc($this->attributs, $this->original);
            unset($modifies[static::$cle]);

            if (empty($modifies)) {
                return true;
            }

            static::requeteur()
                ->filtrer(static::$cle, $id)
                ->modifier($modifies);
        } else {
            $id = static::requeteur()->inserer($this->attributs);
            $this->attributs[static::$cle] = $id;
            $this->existe = true;
        }

        $this->original = $this->attributs;
        return true;
    }

    public function supprimer(): bool
    {
        $id = $this->attributs[static::$cle] ?? null;

        if ($id === null || !$this->existe) {
            return false;
        }

        static::requeteur()->filtrer(static::$cle, $id)->supprimer();
        $this->existe = false;
        return true;
    }

    public static function compter(): int
    {
        return static::requeteur()->compter();
    }

    public static function paginer(int $page, int $parPage = 15): Paginateur
    {
        $paginateur = static::requeteur()->paginer($page, $parPage);

        $items = array_map(
            fn($row) => static::depuisTableau($row),
            $paginateur->items
        );

        return new Paginateur($items, $paginateur->total, $paginateur->page, $paginateur->parPage);
    }

    protected static function depuisTableau(array $attributs): static
    {
        $instance           = new static($attributs);
        $instance->original = $attributs;
        $instance->existe   = true;
        return $instance;
    }
}
