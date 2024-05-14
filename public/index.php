<?php
declare(strict_types=1);

use Slim\Psr7\Response;
use Slim\Factory\AppFactory;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseInterface ;
use App\Application\Middleware\ExampleBeforeMiddleware;
use Psr\Http\Message\ServerRequestInterface as RequestInterface;
require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();




$app->addErrorMiddleware(true, true, false);

// Corrigido a rota e a definição correta dos parâmetros
$app->get('/hello/{name}', function(RequestInterface $request, ResponseInterface $response, array $args) {
    $name = $args['name'];
    $response->getBody()->write("Hello, $name");
    return $response;
})->add(new ExampleBeforeMiddleware());

$app->get('/user/{name}', function(RequestInterface $request, ResponseInterface $response, array $args) {
    $name = $args['name'];
    $response->getBody()->write("Hello, $name");
    return $response;
});

$app->run();
