<?php

use App\Providers\ConfigServiceProvider;
use League\Container\Container;
use League\Container\ReflectionContainer;

$container = new Container();

// This turns auto-wiring ON
$container->delegate(
    new ReflectionContainer
);


$container->addServiceProvider(new ConfigServiceProvider());

foreach ($container->get('config')->get('app.providers') as $provider) {
    $container->addServiceProvider($provider);
}
