<?php

session_start();

require __DIR__ . '/../vendor/autoload.php';

$user = new \App\Models\User;
var_dump($user);
die();

$app = new Slim\App([
    'settings' => [
        'displayErrorDetails' => true,

    ]
]);


require __DIR__ . '/../app/routes.php';