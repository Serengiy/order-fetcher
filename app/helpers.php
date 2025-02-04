<?php

use JetBrains\PhpStorm\NoReturn;
use Symfony\Component\VarDumper\VarDumper;

if (!function_exists('env')) {
    function env($key, $default = null) {
        return $_ENV[$key] ?? getenv($key) ?? $default;
    }
}

if (!function_exists('dd')) {
    #[NoReturn] function dd(...$vars) {
        VarDumper::dump(...$vars);
        die();
    }
}

if (!function_exists('dd')) {
    function dump(...$vars) {
        VarDumper::dump(...$vars);
    }
}