<?php

namespace App\Controllers\Auth;
use App\Controllers\Controller;

class AuthController extends Controller{

    public function getSignUp($request, $response){

        return $this->container->view->render($response, 'auth/signup.php');

    }

    public function postSignUp(){

    }
}