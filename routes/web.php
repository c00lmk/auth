<?php

use App\Controllers\HomeController;
use League\Route\RouteGroup;

$router->map('GET', '/', 'App\Controllers\HomeController::index')->setName('home');
$router->group('/auth', function (RouteGroup $router) {
    $router->map('GET', '/login', 'App\Controllers\Auth\LoginController::index')->setName('auth.login');
    $router->map('POST', '/login', 'App\Controllers\Auth\LoginController::login');
});
