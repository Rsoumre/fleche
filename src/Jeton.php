<?php

namespace Fleche;

class Jeton
{
    private const CLE_SESSION = '_jeton_csrf';

    public static function generer(): string
    {
        Session::demarrer();

        if (!Session::a(self::CLE_SESSION)) {
            Session::definir(self::CLE_SESSION, bin2hex(random_bytes(32)));
        }

        return Session::obtenir(self::CLE_SESSION);
    }

    public static function valider(string $jeton): bool
    {
        Session::demarrer();
        $attendu = Session::obtenir(self::CLE_SESSION, '');
        return hash_equals($attendu, $jeton);
    }

    public static function champ(): string
    {
        $jeton = self::generer();
        return "<input type=\"hidden\" name=\"_jeton\" value=\"{$jeton}\">";
    }

    public static function verifierRequete(Requete $requete): void
    {
        if (!in_array($requete->methode, ['GET', 'HEAD', 'OPTIONS'])) {
            $jeton = $requete->entree('_jeton', '');

            if (!self::valider($jeton)) {
                throw new \RuntimeException('Jeton CSRF invalide.', 419);
            }

            Session::supprimer(self::CLE_SESSION);
        }
    }
}
