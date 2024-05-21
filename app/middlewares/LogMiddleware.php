<?php

namespace App\Middlewares;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;

class LogMiddleware {
    private $logger;

    public function __construct(LoggerInterface $logger) {
        $this->logger = $logger;
    }

    public function __invoke(Request $request, Response $response, callable $next): Response {
        // Registra uma mensagem de log com o método HTTP e a URL
        $this->logger->info('Action: ' . $request->getMethod() . ' ' . $request->getUri());

        // Retorna a resposta sem chamar o próximo middleware
        return $response;
    }
}
