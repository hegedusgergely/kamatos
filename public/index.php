<?php
require '../vendor/autoload.php';

$app = require '../src/app.php';
require '../src/routes.php';
// It's time to run the application.
$app->run();
