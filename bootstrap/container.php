<?php

use App\Providers\AppServiceProvider;
use App\Providers\ViewServiceProvider;
use League\Container\Container;
use League\Container\ReflectionContainer;

$container = new Container();

// This turns auto-wiring ON
$container->delegate(
    new ReflectionContainer
);

$container->addServiceProvider(new AppServiceProvider());
$container->addServiceProvider(new ViewServiceProvider());