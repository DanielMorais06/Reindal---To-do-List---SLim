<?php

namespace App\Controllers;

class HomeController extends Controller{

    public function index($request, $response){
        $query = "SELECT * FROM tasks";
        $stmt = $this->container->db->query($query);
        $tasks = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    
        // Retorna os dados das tarefas em formato JSON
        $tasksJson = json_encode($tasks);
    
        // Renderiza o HTML com os dados das tarefas
        return $this->container->view->render($response, '/sneat-1.0.0/html/index.html', ['tasksJson' => $tasksJson]);
    }
    
}