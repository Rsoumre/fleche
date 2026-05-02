<?php

namespace Fleche;

class Vue
{
    private static string $dossier = __DIR__ . '/vues';

    public static function rendu(string $nom, array $donnees = []): string
    {
        $fichier = self::$dossier . '/' . $nom . '.php';

        if (!file_exists($fichier)) {
            throw new \RuntimeException("Vue introuvable : {$nom}");
        }

        extract($donnees);

        ob_start();
        require $fichier;
        return ob_get_clean();
    }
}
