<?php

session_start();

require __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use App\Middlewares\LogMiddleware;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Cria o serviço de log
$logger = new Logger('app_logger');
$logger->pushHandler(new StreamHandler(__DIR__ . '/../logs/logger.log', Logger::DEBUG));

// Configurações do aplicativo Slim
$config = [
    'settings' => [
        'displayErrorDetails' => true,
        'db' => [
            'driver' => $_ENV['DB_DRIVER'],
            'host' => $_ENV['DB_HOST'],
            'database' => $_ENV['DB_DATABASE'],
            'username' => $_ENV['DB_USERNAME'],
            'password' => $_ENV['DB_PASSWORD'],
            'charset' => $_ENV['DB_CHARSET'],
            'collation' => $_ENV['DB_COLLATION'],
            'prefix' => $_ENV['DB_PREFIX'],
        ]
    ],
];

$app = new \Slim\App($config);

// Adiciona o serviço de log ao contêiner do Slim
$container = $app->getContainer();
$container['logger'] = function ($c) use ($logger) {
    return $logger;
};

// Cria e adiciona o middleware de log
$logMiddleware = new LogMiddleware($container->get('logger'));
$app->add($logMiddleware);

// Adiciona o contêiner e os controladores ao aplicativo
$container['db'] = function ($c) {
    $db = $c['settings']['db'];
    $pdo = new PDO('mysql:host=' . $db['host'] . ';dbname=' . $db['dbname'],
        $db['user'], $db['pass']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    return $pdo;
};

$container['view'] = function($container){
    $view=new \Slim\Views\PhpRenderer(__DIR__.'/../resources/views');
    return $view;
};

$container['HomeController'] = function($container){
    return new App\Controllers\HomeController($container);
};

$container['TaskController'] = function($container){
    return new App\Controllers\TaskController($container);
};

require __DIR__ . '../../app/routes.php';
