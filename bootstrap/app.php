<?php

session_start();

require_once __DIR__ . '/../vendor/autoload.php';

try {
    $dotenv = \Dotenv\Dotenv::create(__DIR__ . '/..//')->load();
} catch (\Dotenv\Exception\InvalidPathException $exception) {
    //
}


var_dump(getenv("APP_NAME"));

