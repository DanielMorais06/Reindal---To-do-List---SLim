<?php

namespace App\Controllers\Auth;
use App\Controllers\Controller;

class AuthController extends Controller{



    public function getSignIn($request, $response){
        return $this->container->view->render($response, 'auth/signin.html');
    }

    public function postSignIn($request, $response){
        $email = $request->getParam('email');
        $palavrapasse = $request->getParam('password');

        $sql = "SELECT id_utilizador FROM utilizadores WHERE email=:email AND palavrapasse=:palavrapasse";
        $stmt = $this->container->db->prepare($sql);
        $stmt->execute(['email' => $email, 'palavrapasse' => $palavrapasse]);

        if ($stmt->rowCount() > 0) {
            $id_utilizador = $stmt->fetchColumn();
            $_SESSION['ID'] = $id_utilizador;
            
            return $response->withRedirect('/public/');
        } else {
            echo "Email ou Palavra Passe Incorretos";
        }

    }

    
}