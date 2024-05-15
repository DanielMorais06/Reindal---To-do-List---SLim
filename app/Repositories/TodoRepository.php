<?php

namespace App\Repositories;

class TodoRepository {
    private $todos = [];

    public function getAll() {
        return $this->todos;
    }

    public function create($title) {
        $todo = [
            'id' => count($this->todos) + 1,
            'title' => $title,
            'completed' => false
        ];
        $this->todos[] = $todo;
        return $todo;
    }
}
