<?php

namespace App\Controllers;
use App\Controllers\Controller;

class TaskController extends Controller{

    public function getNewTask($request, $response){
        if(empty($_SESSION['Id_User'])){
            return $this->container->view->render($response, 'sneat-1.0.0/html/Login.html');
        }else{
            $iduser = $_SESSION['Id_User'];
            $query1 = "SELECT * FROM tasks WHERE category = '1' AND id_user = '$iduser' LIMIT 4";
        $stmt1 = $this->container->db->query($query1);
        $tasks1 = $stmt1->fetchAll(\PDO::FETCH_ASSOC);
        $tasksJson1 = json_encode($tasks1);
    
        $query2 = "SELECT * FROM tasks WHERE category = '2' AND id_user = '$iduser' LIMIT 4";
        $stmt2 = $this->container->db->query($query2);
        $tasks2 = $stmt2->fetchAll(\PDO::FETCH_ASSOC);
        $tasksJson2 = json_encode($tasks2);
    
        $query3 = "SELECT * FROM tasks WHERE category = '3' AND id_user = '$iduser' LIMIT 4"; 
        $stmt3 = $this->container->db->query($query3);
        $tasks3 = $stmt3->fetchAll(\PDO::FETCH_ASSOC);
        $tasksJson3 = json_encode($tasks3);

        $query4 = "SELECT * FROM tasks WHERE id_user = '$iduser'"; 
        $stmt4 = $this->container->db->query($query4);
        $tasks4 = $stmt4->fetchAll(\PDO::FETCH_ASSOC);
        $tasksJson4 = json_encode($tasks4);
    
        return $this->container->view->render($response, '/sneat-1.0.0/html/NewTask.html', [
            'tasksJson1' => $tasksJson1,
            'tasksJson2' => $tasksJson2,
            'tasksJson3' => $tasksJson3,
            'tasksJson4' => $tasksJson4 
        ]);
        } 
    }

    public function postNewTask($request, $response){
        
    }

    public function getSignIn($request, $response){
            return $this->container->view->render($response, 'sneat-1.0.0/html/Login.html');
        
    }

    public function postSignIn($request, $response){
        
    }

    public function getSignUp($request, $response){
        return $this->container->view->render($response, 'sneat-1.0.0/html/Register.html');
    }
    
    public function postSignUp($request, $response){
        $nome = $request->getParam('nomeutente');
        $email = $request->getParam('e-mail');
        $palavrapasse = $request->getParam('password');
        
        $erroNome = 0;
        $erroEmail = 0;
        $erroSenha = 0;
    
        if (preg_match('/[0-9]/', $nome)) {
            $erroNome = 1;
        }
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $erroEmail = 1;
        }
        
    
        // Verificar se a senha atende aos critérios (letras maiúsculas, minúsculas e números)
        if (!preg_match('/[A-Z]/', $palavrapasse) || !preg_match('/[a-z]/', $palavrapasse) || !preg_match('/[0-9]/', $palavrapasse)) {
            $erroSenha = 1;
        }
    
        // Consulta SQL para verificar se o email já está presente na tabela
        $sql = "SELECT COUNT(*) FROM users WHERE email = :email";
        $stmt = $this->container->db->prepare($sql);
        $stmt->execute(['email' => $email]);
        $count = $stmt->fetchColumn();
    
        // Verificar se o email já está registrado
        if ($count > 0) {
            $erroEmail = 1;
        }
        
    
        if($erroNome == 0 &&
        $erroEmail == 0 &&
        $erroSenha == 0){
            $sql = "INSERT INTO users (email, name, password) VALUES (:email, :nome, :palavrapasse)";
            $stmt = $this->container->db->prepare($sql);
            
            // Execute a consulta com os valores fornecidos
            $stmt->execute(['email' => $email, 'nome' => $nome, 'palavrapasse' => $palavrapasse]);
            
            // Verifica se a inserção foi bem-sucedida
            if ($stmt->rowCount() > 0) {
                // Obtém o ID do usuário recém-criado
                $idUsuario = $this->container->db->lastInsertId();
                
                // Armazena o ID do usuário na sessão
                $_SESSION['Id_User'] = $idUsuario;
                
                // Redireciona para a página inicial ou renderiza o template, conforme necessário
                return $response->withRedirect('/public/');
            } else {
                echo "Erro ao inserir registro.";
            }
        }else{
            // Renderiza a página novamente com as informações de erro
            return $this->container->view->render($response, 'sneat-1.0.0/html/Register.html', [
                'erroNome' => $erroNome,
                'erroEmail' => $erroEmail,
                'erroSenha' => $erroSenha
            ]);
        }
    
        
    }

    
}