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
        $erro = 0;

        if (preg_match('/[0-9]/', $nome)) {
            echo "O nome não pode conter números.";
            $erro = 1;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "O email não está em um formato válido.";
            $erro =  1;
        }

        // Verificar se a senha atende aos critérios (letras maiúsculas, minúsculas e números)
        if (!preg_match('/[A-Z]/', $palavrapasse) || !preg_match('/[a-z]/', $palavrapasse) || !preg_match('/[0-9]/', $palavrapasse)) {
            echo "A senha deve conter pelo menos uma letra maiúscula, uma letra minúscula e um número.";
            $erro = 1;
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

        if($erro == 0){
            $sql = "INSERT INTO utilizadores (email, nome, palavrapasse) VALUES (:email, :nome, :palavrapasse)";
            $stmt = $this->container->db->prepare($sql);

            // Execute a consulta com os valores fornecidos
            $stmt->execute(['email' => $email, 'nome' => $nome, 'palavrapasse' => $palavrapasse]);

            // Verifica se a inserção foi bem-sucedida
            if ($stmt->rowCount() > 0) {
                return $this->container->view->render($response, 'index.html');
            } else {
                echo "Erro ao inserir registro.";
            }
        }


        
    }

    public function getSignIn($request, $response){

        return $this->container->view->render($response, 'auth/signin.html');

    }

    public function postSignIn($request, $response){
        $email = $request->getParam('email');
        $palavrapasse = $request->getParam('password');

        $sql = "SELECT id_utilizador FROM utilizadores WHERE email=:email AND palavrapasse:palavrapasse";
        $stmt = $this->container->db->prepare($sql);
        $stmt->execute(['email' => $email, 'palavrapasse' => $palavrapasse]);

        // Verifica se o email existe na base de dados
        if ($stmt->rowCount() > 0) {
            // Se o email existe, armazena o ID do usuário em uma variável
            $id_utilizador = $stmt->fetchColumn();
            $_SESSION['ID'] = $id_utilizador;
            
            return $response->withRedirect('../index.html');
        } else {
            echo "Email não encontrado na base de dados.";
        }

    }
}