<?php

define('ROOT', str_replace("public/index.php", "", $_SERVER["SCRIPT_FILENAME"]));

include_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

use Illuminate\Database\Capsule\Manager as Capsule;
$capsule = new Capsule;
$capsule->addConnection(
    [
        "driver"   => env('DB_DRIVER', 'mysql'),
        "host"     => env('DB_HOST', '127.0.0.1'),
        "database" => env('DB_NAME', 'tasks'),
        "username" => env('DB_USERNAME'),
        "password" => env('DB_PASSWORD'),
    ]
);

//Make this Capsule instance available globally.
$capsule->setAsGlobal();

// Setup the Eloquent ORM.
$capsule->bootEloquent();
