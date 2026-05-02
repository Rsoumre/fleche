<?php

namespace Fleche;

class Session
{
    public static function demarrer(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function definir(string $cle, mixed $valeur): void
    {
        $_SESSION[$cle] = $valeur;
    }

    public static function obtenir(string $cle, mixed $defaut = null): mixed
    {
        return $_SESSION[$cle] ?? $defaut;
    }

    public static function a(string $cle): bool
    {
        return isset($_SESSION[$cle]);
    }

    public static function supprimer(string $cle): void
    {
        unset($_SESSION[$cle]);
    }

    public static function vider(): void
    {
        session_destroy();
        $_SESSION = [];
    }

    // Message flash : lu une seule fois puis supprimé
    public static function flash(string $cle, string $message): void
    {
        $_SESSION['_flash'][$cle] = $message;
    }

    public static function obtenirFlash(string $cle): ?string
    {
        $message = $_SESSION['_flash'][$cle] ?? null;
        unset($_SESSION['_flash'][$cle]);
        return $message;
    }
}
