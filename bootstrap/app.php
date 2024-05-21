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
$logger->pushHandler(new StreamHandler(__DIR__ . '/../logs/logger.log', Logger::DEBUG, Logger::INFO, Logger::ERROR));

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
$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

$config['db']['host']   = $_ENV['DB_HOST'];
$config['db']['user']   = $_ENV['DB_USERNAME'];
$config['db']['pass']   = $_ENV['DB_PASSWORD'];
$config['db']['dbname'] = $_ENV['DB_DATABASE'];

$app = new \Slim\App([
    'settings' => $config
]);

// Adiciona o serviço de log ao contêiner do Slim
$container = $app->getContainer();
$container['db'] = function ($c) {
    $db = $c['settings']['db'];
    $pdo = new PDO('mysql:host=' . $db['host'] . ';dbname=' . $db['dbname'],
    $db['user'], $db['pass'] ?? '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    return $pdo;
};
$logger = new Logger('logger');

// Adicionar um manipulador (handler) para armazenar mensagens em um arquivo
$logger->pushHandler(new StreamHandler(__DIR__ . '/../logs/logger.log', Logger::DEBUG));

// Adiciona o logger ao container
$container['logger'] = function($container) use ($logger) {
    return $logger;
};

// Adiciona o contêiner e os controladores ao aplicativo


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
