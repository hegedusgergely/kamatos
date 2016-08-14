<?php

use Kamatos\Http\Application;
use Kamatos\Http\Provider;

$app = new Application([
    'settings' => [
        'displayErrorDetails' => true,
        'logger' => [
            'name' => 'app_logger',
            'handler' => '../var/logs/app.log'
        ],
        'view' => [
            'cache_enabled' => false,
            'cache_path' => '',
            'path' => '../templates'
        ]
    ]
]);
$app->registerService('logger', new Provider\LoggerProvider);
$app->registerService('view', new Provider\ViewProvider);

return $app;
