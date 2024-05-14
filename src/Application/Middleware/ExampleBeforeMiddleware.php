<?php
namespace App\Application\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

class ExampleBeforeMiddleware {
    public function __invoke(Request $request, RequestHandler $handler): Response {
        // Handle the request and get the response
        $response = $handler->handle($request);
        $existingContent = (string) $response->getBody();

        // Create a new response
        $response = new Response();
        $response->getBody()->write('Before ' . $existingContent);

        return $response;
    }
}
