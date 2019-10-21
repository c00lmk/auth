<?php

use App\Providers\AppServiceProvider;
use League\Container\Container;

$container = new Container();

$container->addServiceProvider(new AppServiceProvider());

// var_dump($container->get('test'));