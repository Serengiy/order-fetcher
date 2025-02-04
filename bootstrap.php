<?php
use Illuminate\Database\Capsule\Manager as Capsule;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Dotenv\Dotenv;

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/app/helpers.php';

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();


$capsule = new Capsule;
$capsule->addConnection([
    'driver'    => env('DB_DRIVER', 'mysql'),
    'host'      => env('DB_HOST', '127.0.0.1'),
    'database'  => env('DB_DATABASE', 'database'),
    'username'  => env('DB_USERNAME', 'root'),
    'password'  => env('DB_PASSWORD', ''),
]);

$capsule->setAsGlobal();
$capsule->bootEloquent();

$logger = new Logger('logger');
$logger->pushHandler(new StreamHandler(__DIR__ . '/logs/app.log', Level::Debug));