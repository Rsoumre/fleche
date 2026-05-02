<?php

namespace Fleche;

class GestionnaireErreurs
{
    public static function enregistrer(): void
    {
        set_exception_handler([self::class, 'gererException']);
        set_error_handler([self::class, 'gererErreur']);
    }

    public static function gererException(\Throwable $e): void
    {
        $estDev = env('APP_ENV', 'production') === 'developpement';

        http_response_code(500);

        if ($estDev) {
            echo Vue::rendu('erreur', [
                'message' => $e->getMessage(),
                'fichier' => $e->getFile(),
                'ligne'   => $e->getLine(),
                'trace'   => $e->getTraceAsString(),
            ]);
        } else {
            echo Vue::rendu('erreur', [
                'message' => 'Une erreur interne est survenue.',
                'fichier' => '',
                'ligne'   => 0,
                'trace'   => '',
            ]);
        }
    }

    public static function gererErreur(int $niveau, string $message, string $fichier, int $ligne): bool
    {
        throw new \ErrorException($message, 0, $niveau, $fichier, $ligne);
    }
}
