<?php

namespace App\Controllers;

class HomeController extends Controller{

    public function index($request, $response){

        return $this->container->view->render($response, '/sneat-1.0.0/html/index.html');
    }
   
}