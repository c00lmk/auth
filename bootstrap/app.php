<?php

use App\Exceptions\Handler;
use App\Models\User;
use App\Session\Session;
use App\Views\View;
use Dotenv\Dotenv;
use Dotenv\Exception\InvalidPathException;
use League\Route\Router;
use Whoops\Run;

session_start();

require_once __DIR__ . '/../vendor/autoload.php';

try {
    // Create new Dotenv object so that we can load configuration parameters from .env file
    $dotenv = Dotenv::create(base_path())->load();
} catch (InvalidPathException $exception) {
    //
}

require_once base_path('/bootstrap/container.php');

$router = $container->get(Router::class);

require_once base_path('/bootstrap/middleware.php');


require_once base_path('/routes/web.php');

try {
    $response = $router->dispatch($container->get('request'));
} catch (Exception $e) {
    $handler = new Handler(
        $e,
        $container->get(Session::class),
        $container->get(View::class)
    );

    $response = $handler->respond();
}