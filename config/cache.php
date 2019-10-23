<?php

return [
    'views' => [
        'enableg' => $enabled = env('CACHE_VIEWS'),
        'path' => $enabled ? base_path('cache/views') : false
    ]
];