<?php
declare(strict_types=1);

use Slim\Psr7\Response;
use Slim\Factory\AppFactory;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseInterface ;
use Psr\Http\Message\ServerRequestInterface as RequestInterface;
require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

$beforeMiddleware = function(RequestInterface $request, RequestHandlerInterface $handler){
	$response = $handler->handle($request);
	$existingContent = (string) $response->getBody();

	$response = new Response();
	$response->getBody()->write('Before' . $existingContent);
	return $response;
};



$app->add($beforeMiddleware);
$app->addErrorMiddleware(true, true, false);

// Corrigido a rota e a definição correta dos parâmetros
$app->get('/hello/{name}', function(RequestInterface $request, ResponseInterface $response, array $args) {
    $name = $args['name'];
    $response->getBody()->write("Hello, $name");
    return $response;
});

$app->run();
