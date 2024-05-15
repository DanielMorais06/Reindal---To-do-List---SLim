<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Repositories\TodoRepository;

class TodoController {
    private $todoRepository;

    public function __construct(TodoRepository $todoRepository) {
        $this->todoRepository = $todoRepository;
    }

    public function index(Request $request, Response $response, $args): Response {
        $todos = $this->todoRepository->getAll();
        $response->getBody()->write(json_encode($todos));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function create(Request $request, Response $response, $args): Response {
        $data = $request->getParsedBody();
        $todo = $this->todoRepository->create($data['title']);
        $response->getBody()->write(json_encode($todo));
        return $response->withHeader('Content-Type', 'application/json');
    }
}
