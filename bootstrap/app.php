<?php

session_start();

require __DIR__ . '/../vendor/autoload.php';

$app = new \Slim\App([
    'settings' => [
        'displayErrorDetails' => true,
    ]
]);

$container = $app->getContainer();

$container['view'] = function($container){
    $view=new \Slim\Views\PhpRenderer(__DIR__.'/../resources/views');
    return $view;
};


$container['HomeController'] = function($container){
    return new App\Controllers\HomeController($container);
};

require __DIR__ . '/../app/routes.php';

