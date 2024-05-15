<?php

namespace App\Controllers;
use App\Models\user;

class HomeController extends Controller{

    public function index($request, $response){

        return $this->container->view->render($response, 'index.html');
    }
}