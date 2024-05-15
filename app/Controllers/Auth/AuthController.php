<?php

namespace App\Controllers\Auth;
use App\Controllers\Controller;

class AuthController extends Controller{

    public function getSignUp($request, $response){

        return $this->container->view->render($response, 'auth/signup.html');

    }

    public function postSignUp($request, $response){
        $nome = $request->getParam('accountName');
        $email = $request->getParam('email');
        $palavrapasse = $request->getParam('password');

        if (preg_match('/[0-9]/', $nome)) {
            echo "O nome não pode conter números.";
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "O email não está em um formato válido.";
        }

        // Verificar se a senha atende aos critérios (letras maiúsculas, minúsculas e números)
        if (!preg_match('/[A-Z]/', $palavrapasse) || !preg_match('/[a-z]/', $palavrapasse) || !preg_match('/[0-9]/', $palavrapasse)) {
            echo "A senha deve conter pelo menos uma letra maiúscula, uma letra minúscula e um número.";
        }

        // Consulta SQL para verificar se o email já está presente na tabela
        $sql = "SELECT COUNT(*) FROM utilizadores WHERE email = :email";
        $stmt = $this->container->db->prepare($sql);
        $stmt->execute(['email' => $email]);
        $count = $stmt->fetchColumn();

        // Verificar se o email já está registrado
        if ($count > 0) {
            echo "O email já está registrado.";
        }

        echo "Nome: $nome<br>";
        echo "Email: $email<br>";
        echo "Senha: $palavrapasse<br>";

    }
}