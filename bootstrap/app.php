<?php

session_start();

require __DIR__ . '/../vendo/autoload.php';

$app = new Slim\App([
    'settings' => [
        'displayErrorDetails' => true,

    ]
]);

$app->get('/', function ($request, $response) {

    return 'Home';

});
