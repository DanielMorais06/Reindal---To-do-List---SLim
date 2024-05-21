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
        $this->logger->info('Action: ' . $request->getMethod() . ' ' . $request->getUri());
        return $response;
    }
}
