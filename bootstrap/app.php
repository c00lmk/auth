<?php

use League\Route\Router;

session_start();

require_once __DIR__ . '/../vendor/autoload.php';

try {
    $dotenv = \Dotenv\Dotenv::create(__DIR__ . '/..//')->load();
} catch (\Dotenv\Exception\InvalidPathException $exception) {
    //
}

require_once __DIR__ . '/container.php';

$router = $container->get(Router::class);

require_once __DIR__ . '/../routes/web.php';

$response = $router->dispatch($container->get('request'));