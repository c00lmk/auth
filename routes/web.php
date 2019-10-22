<?php

use App\Controllers\HomeController;
/*
 * TODO How to name the route
 *
 */
$router->map('GET', '/', HomeController::class)->setName('home');