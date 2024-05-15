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

$container['view'] = function(){
    $view=new \Slim\Views\PhpRender('/../resources/views');
    return $view;
};


$container['HomeController'] = function($container){
    return new App\Controllers\HomeController($container->view);
};

require __DIR__ . '/../app/routes.php';

