<?php
use App\Controllers\HomeController;

session_start();

require __DIR__ . '/../vendor/autoload.php';

$app = new \Slim\App([
    'settings' => [
        'displayErrorDetails' => true,
    ]
]);

$container = $app->getContainer();

$container['HomeController'] = function(){
    return new App\Controllers\HomeController;
};

require __DIR__ . '/../app/routes.php';

