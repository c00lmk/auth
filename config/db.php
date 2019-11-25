<?php

return [
    'mysql' => [
        'driver' => 'mysql',
        'host'=> env('DB_HOST', '127.0.0.1'),
        'database'=> env('DB_DATABASE', 'database'),
        'username'=> env('DB_USERNAME', 'root'),
        'password'=> env('DB_PASSWORD', 'root'),
        'port' => env('DB_PORT'),
        'charset' => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix' => ''
    ]
];