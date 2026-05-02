<?php

use Fleche\Env;

if (!function_exists('env')) {
    function env(string $cle, mixed $defaut = null): mixed
    {
        return Env::obtenir($cle, $defaut);
    }
}
