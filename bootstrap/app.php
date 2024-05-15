<?php

declare(strict_types=1);

use DI\ContainerBuilder;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

// Instantiate PHP-DI ContainerBuilder
$containerBuilder = new ContainerBuilder();

// Set up settings
$settings = require __DIR__ . '/../app/settings.php';
$settings($containerBuilder);

// Set up dependencies
$containerBuilder->addDefinitions([
    'TodoRepository' => function() {
        return new \App\Repositories\TodoRepository();
    },
    \App\Controllers\TodoController::class => function($container) {
        return new \App\Controllers\TodoController($container->get('TodoRepository'));
    }
]);

// Build PHP-DI Container instance
$container = $containerBuilder->build();

// Set the container to create the app
AppFactory::setContainer($container);
$app = AppFactory::create();

// Register routes
(require __DIR__ . '/../app/routes.php')($app);

return $app;
