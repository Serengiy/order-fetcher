<?php

use JetBrains\PhpStorm\NoReturn;
use Symfony\Component\VarDumper\VarDumper;

if (!function_exists('env')) {
    function env($key, $default = null) {
        return $_ENV[$key] ?? getenv($key) ?? $default;
    }
}

if (!function_exists('dd')) {
    #[NoReturn] function dd(...$vars): void
    {
        VarDumper::dump(...$vars);
        die();
    }
}

if (!function_exists('dump')) {
    function dump(...$vars): void
    {
        VarDumper::dump(...$vars);
    }
}