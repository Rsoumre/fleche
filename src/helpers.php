<?php

use Fleche\Env;
use Fleche\Reponse;
use Fleche\Session;
use Fleche\Journalisation;

if (!function_exists('env')) {
    function env(string $cle, mixed $defaut = null): mixed
    {
        return Env::obtenir($cle, $defaut);
    }
}

if (!function_exists('rediriger')) {
    function rediriger(string $url, int $statut = 302): Reponse
    {
        return Reponse::rediriger($url, $statut);
    }
}

if (!function_exists('retour')) {
    function retour(): Reponse
    {
        $url = $_SERVER['HTTP_REFERER'] ?? '/';
        return Reponse::rediriger($url);
    }
}

if (!function_exists('abort')) {
    function abort(int $code, string $message = ''): never
    {
        http_response_code($code);

        if ($message !== '') {
            echo $message;
        }

        exit;
    }
}

if (!function_exists('url')) {
    function url(string $chemin = ''): string
    {
        $base = rtrim(env('APP_URL', ''), '/');
        return $base . '/' . ltrim($chemin, '/');
    }
}

if (!function_exists('asset')) {
    function asset(string $chemin): string
    {
        return url('public/' . ltrim($chemin, '/'));
    }
}

if (!function_exists('flash')) {
    function flash(string $cle, ?string $message = null): ?string
    {
        if ($message !== null) {
            Session::flash($cle, $message);
            return null;
        }

        return Session::obtenirFlash($cle);
    }
}

if (!function_exists('ancien')) {
    function ancien(string $cle, mixed $defaut = ''): mixed
    {
        Session::demarrer();
        $valeurs = $_SESSION['_ancien'] ?? [];
        return $valeurs[$cle] ?? $defaut;
    }
}

if (!function_exists('sauvegarderAncien')) {
    function sauvegarderAncien(array $donnees): void
    {
        Session::demarrer();
        $_SESSION['_ancien'] = $donnees;
    }
}

if (!function_exists('jeton')) {
    function jeton(): string
    {
        return \Fleche\Jeton::generer();
    }
}

if (!function_exists('champJeton')) {
    function champJeton(): string
    {
        return \Fleche\Jeton::champ();
    }
}

if (!function_exists('e')) {
    function e(string $valeur): string
    {
        return htmlspecialchars($valeur, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }
}

if (!function_exists('journal')) {
    function journal(string $message, string $niveau = 'info', array $contexte = []): void
    {
        match ($niveau) {
            'erreur'        => Journalisation::erreur($message, $contexte),
            'avertissement' => Journalisation::avertissement($message, $contexte),
            'debug'         => Journalisation::debug($message, $contexte),
            default         => Journalisation::info($message, $contexte),
        };
    }
}
