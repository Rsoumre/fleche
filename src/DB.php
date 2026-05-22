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
                \PDO::ATTR_EMULATE_PREPARES   => false,
            ]);
        }

        return self::$connexion;
    }

    public static function table(string $table): Requeteur
    {
        return new Requeteur(self::connecter(), $table);
    }

    public static function brut(string $sql, array $valeurs = []): array
    {
        $stmt = self::connecter()->prepare($sql);
        $stmt->execute($valeurs);
        return $stmt->fetchAll();
    }

    public static function executer(string $sql, array $valeurs = []): int
    {
        $stmt = self::connecter()->prepare($sql);
        $stmt->execute($valeurs);
        return $stmt->rowCount();
    }

    public static function transaction(callable $callback): mixed
    {
        $pdo = self::connecter();
        $pdo->beginTransaction();

        try {
            $resultat = $callback($pdo);
            $pdo->commit();
            return $resultat;
        } catch (\Throwable $e) {
            $pdo->rollBack();
            throw $e;
        }
    }

    public static function deconnecter(): void
    {
        self::$connexion = null;
    }
}
