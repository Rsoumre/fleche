<?php

namespace Fleche;

class Vue
{
    private static string $dossier   = __DIR__ . '/vues';
    private static ?string $layout   = null;
    private static array $sections   = [];
    private static ?string $sectionCourante = null;

    public static function rendu(string $nom, array $donnees = []): string
    {
        $fichier = self::$dossier . '/' . str_replace('.', '/', $nom) . '.php';

        if (!file_exists($fichier)) {
            throw new \RuntimeException("Vue introuvable : {$nom}");
        }

        self::$layout          = null;
        self::$sections        = [];
        self::$sectionCourante = null;

        extract($donnees);

        ob_start();
        require $fichier;
        $contenuVue = ob_get_clean();

        if (self::$layout !== null) {
            $fichierLayout = self::$dossier . '/layouts/' . self::$layout . '.php';

            if (!file_exists($fichierLayout)) {
                throw new \RuntimeException("Layout introuvable : " . self::$layout);
            }

            extract($donnees);
            ob_start();
            require $fichierLayout;
            return ob_get_clean();
        }

        return $contenuVue;
    }

    public static function etendre(string $layout): void
    {
        self::$layout = $layout;
    }

    public static function section(string $nom): void
    {
        self::$sectionCourante = $nom;
        ob_start();
    }

    public static function fin(): void
    {
        if (self::$sectionCourante === null) {
            throw new \RuntimeException("Aucune section ouverte. Appelez Vue::section() d'abord.");
        }

        self::$sections[self::$sectionCourante] = ob_get_clean();
        self::$sectionCourante = null;
    }

    public static function ceder(string $nom, string $defaut = ''): string
    {
        return self::$sections[$nom] ?? $defaut;
    }

    public static function inclure(string $nom, array $donnees = []): void
    {
        $fichier = self::$dossier . '/partials/' . $nom . '.php';

        if (!file_exists($fichier)) {
            throw new \RuntimeException("Partial introuvable : {$nom}");
        }

        extract($donnees);
        require $fichier;
    }

    public static function definirDossier(string $dossier): void
    {
        self::$dossier = rtrim($dossier, '/');
    }
}
