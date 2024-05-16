<?php

namespace App\Controllers;

class TaskController extends Controller{

    public function getNewTask($request, $response){
        return $this->container->view->render($response, 'sneat-1.0.0/html/NewTask.html');
    }

    public function postNewTask($request, $response){
        
    }

    public function getTasks($request, $response){
        return $this->container->view->render($response, 'sneat-1.0.0/html/NewTask.html');
    }

    public function postTasks($request, $response){
        
    }
}