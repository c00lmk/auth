<?php

return [
    'name' => getenv('APP_NAME'),
    'debug' =>getenv('APP_DEBUG', false),
    'providers' => [
        'App\Providers\AppServiceProvider',
        'App\Providers\ViewServiceProvider',
        'App\Providers\DatabaseServiceProvider',
        'App\Providers\SessionServiceProvider',
    ]
];