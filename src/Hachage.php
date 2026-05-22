<?php

namespace Fleche;

class Hachage
{
    public static function creer(string $motDePasse, int $cout = 12): string
    {
        return password_hash($motDePasse, PASSWORD_BCRYPT, ['cost' => $cout]);
    }

    public static function verifier(string $motDePasse, string $hachage): bool
    {
        return password_verify($motDePasse, $hachage);
    }

    public static function doitEtreRecalcule(string $hachage, int $cout = 12): bool
    {
        return password_needs_rehash($hachage, PASSWORD_BCRYPT, ['cost' => $cout]);
    }
}
