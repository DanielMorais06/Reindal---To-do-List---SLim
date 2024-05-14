<?php
    declare(strict_types=1);

    use Slim\Factory\AppFactory;
    use Psr\Http\Message\RequestInterface as Request;
    use Slim\Handlers\Strategies\RequestResponse as Response;
    require __DIR__ . '/../vendor/autoload.php';

    $app = AppFactory::create();

    $app->get('/hello/(name)', function(Request $request, Response $response, $args){
        $name = $args['Daniel'];
        $response->getBody()->write("Hello, $name");
        return $response;
    });

    $app->run();