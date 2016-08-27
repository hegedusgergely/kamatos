<?php

return [
    'displayErrorDetails' => true,
    'logger' => [
        'handler' => 'path/to/logger.log',
        'name' => 'logger_name'
    ],
    'twig' => [
        'cache_path' => false, // or 'path/to/cache/directory'
        'path' => 'path/to/templates'
    ]
];
