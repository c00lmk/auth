<?php

use App\Middleware\Authenticated;
use App\Middleware\Guest;
use League\Route\RouteGroup;
use League\Route\Router;


$router->map('GET', '/', 'App\Controllers\HomeController::index')->setName('home');

$router->group('', function (RouteGroup $router) {
    $router->map('GET', '/dashboard', 'App\Controllers\DashboardController::index')->setName('dashboard');
    $router->map('POST', '/auth/logout', 'App\Controllers\Auth\LogoutController::logout')->setName('auth.logout');
})->middleware($container->get(Authenticated::class));


$router->group('', function (RouteGroup $router) {
    $router->map('GET', '/auth/login', 'App\Controllers\Auth\LoginController::index')->setName('auth.login');
    $router->map('POST', '/auth/login', 'App\Controllers\Auth\LoginController::login');

    $router->map('GET', '/auth/register', 'App\Controllers\Auth\RegisterController::index')->setName('auth.register');
    $router->map('POST', '/auth/register', 'App\Controllers\Auth\RegisterController::register');
})->middleware($container->get(Guest::class));


