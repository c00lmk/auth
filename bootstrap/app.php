<?php

use App\Config\Config;
use App\Config\Loaders\ArrayLoader;
use League\Route\Router;

session_start();

require_once __DIR__ . '/../vendor/autoload.php';

try {
    $dotenv = \Dotenv\Dotenv::create(base_path())->load();
} catch (\Dotenv\Exception\InvalidPathException $exception) {
    //
}

require_once base_path('/bootstrap/container.php');

$router = $container->get(Router::class);

require_once base_path('/routes/web.php');

$response = $router->dispatch($container->get('request'));