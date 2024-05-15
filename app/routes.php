<?php

use Slim\App;
use App\Controllers\TodoController;

return function (App $app) {
    $app->get('/todos', [TodoController::class, 'index']);
    $app->post('/todos', [TodoController::class, 'create']);
};
