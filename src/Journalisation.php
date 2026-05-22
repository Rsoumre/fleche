<?php

namespace Fleche;

class Journalisation
{
    private static string $dossier = __DIR__ . '/../stockage/logs';
    private static string $fichier = 'app.log';

    public static function definirDossier(string $dossier): void
    {
        self::$dossier = rtrim($dossier, '/');
    }

    public static function info(string $message, array $contexte = []): void
    {
        self::ecrire('INFO', $message, $contexte);
    }

    public static function avertissement(string $message, array $contexte = []): void
    {
        self::ecrire('AVERTISSEMENT', $message, $contexte);
    }

    public static function erreur(string $message, array $contexte = []): void
    {
        self::ecrire('ERREUR', $message, $contexte);
    }

    public static function debug(string $message, array $contexte = []): void
    {
        if (env('APP_DEBUG', false)) {
            self::ecrire('DEBUG', $message, $contexte);
        }
    }

    public static function exception(\Throwable $e): void
    {
        self::erreur($e->getMessage(), [
            'fichier' => $e->getFile(),
            'ligne'   => $e->getLine(),
            'trace'   => $e->getTraceAsString(),
        ]);
    }

    private static function ecrire(string $niveau, string $message, array $contexte): void
    {
        if (!is_dir(self::$dossier)) {
            mkdir(self::$dossier, 0755, true);
        }

        $date    = date('Y-m-d H:i:s');
        $extra   = empty($contexte) ? '' : ' ' . json_encode($contexte, JSON_UNESCAPED_UNICODE);
        $ligne   = "[{$date}] [{$niveau}] {$message}{$extra}" . PHP_EOL;
        $chemin  = self::$dossier . '/' . self::$fichier;

        file_put_contents($chemin, $ligne, FILE_APPEND | LOCK_EX);
    }
}
