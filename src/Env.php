<?php

namespace Fleche;

class Env
{
    private static array $variables = [];

    public static function charger(string $fichier): void
    {
        if (!file_exists($fichier)) {
            return;
        }

        foreach (file($fichier, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $ligne) {
            if (str_starts_with(trim($ligne), '#')) {
                continue;
            }

            [$cle, $valeur] = explode('=', $ligne, 2) + [null, null];

            if ($cle === null) {
                continue;
            }

            $cle    = trim($cle);
            $valeur = trim($valeur ?? '');
            $valeur = trim($valeur, '"\'');

            self::$variables[$cle] = $valeur;
            $_ENV[$cle]            = $valeur;
        }
    }

    public static function obtenir(string $cle, mixed $defaut = null): mixed
    {
        return self::$variables[$cle] ?? $_ENV[$cle] ?? $defaut;
    }
}
