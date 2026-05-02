<?php

namespace Fleche;

class DB
{
    private static ?\PDO $connexion = null;

    public static function connecter(): \PDO
    {
        if (self::$connexion === null) {
            $hote = env('DB_HOTE', 'localhost');
            $port = env('DB_PORT', '3306');
            $nom  = env('DB_NOM');
            $user = env('DB_UTILISATEUR');
            $mdp  = env('DB_MOT_DE_PASSE');

            $dsn = "mysql:host={$hote};port={$port};dbname={$nom};charset=utf8mb4";

            self::$connexion = new \PDO($dsn, $user, $mdp, [
                \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            ]);
        }

        return self::$connexion;
    }

    public static function table(string $table): Requeteur
    {
        return new Requeteur(self::connecter(), $table);
    }
}
