<?php

namespace App\Controllers;
use App\Controllers\Controller;

class TaskController extends Controller{

    public function getNewTask($request, $response){
        if(empty($_SESSION['Id_User'])){
            return $this->container->view->render($response, 'sneat-1.0.0/html/Login.html');
        } else {
            $iduser = $_SESSION['Id_User'];
            // Define a data limite para 3 dias no futuro
            $dateLimit1 = date('Y-m-d', strtotime('+3 days'));
            $query1 = "SELECT * FROM tasks WHERE final_date <= :dateLimit1 AND id_user = :iduser LIMIT 4";
            $stmt1 = $this->container->db->prepare($query1);
            $stmt1->execute(['dateLimit1' => $dateLimit1, 'iduser' => $iduser]);
            $tasks1 = $stmt1->fetchAll(\PDO::FETCH_ASSOC);
            $tasksJson1 = json_encode($tasks1);

            // Define a data limite para uma semana no futuro
            $dateLimit2 = date('Y-m-d', strtotime('+1 week'));
            $query2 = "SELECT * FROM tasks WHERE final_date > :dateLimit1 AND final_date <= :dateLimit2 AND id_user = :iduser LIMIT 4";
            $stmt2 = $this->container->db->prepare($query2);
            $stmt2->execute(['dateLimit1' => $dateLimit1, 'dateLimit2' => $dateLimit2, 'iduser' => $iduser]);
            $tasks2 = $stmt2->fetchAll(\PDO::FETCH_ASSOC);
            $tasksJson2 = json_encode($tasks2);

            // Define a data limite para a data atual
            $dateLimit3 = date('Y-m-d');
            $query3 = "SELECT * FROM tasks WHERE final_date > :dateLimit2 AND final_date > :dateLimit3 AND id_user = :iduser LIMIT 4";
            $stmt3 = $this->container->db->prepare($query3);
            $stmt3->execute(['dateLimit2' => $dateLimit2, 'dateLimit3' => $dateLimit3, 'iduser' => $iduser]);
            $tasks3 = $stmt3->fetchAll(\PDO::FETCH_ASSOC);
            $tasksJson3 = json_encode($tasks3);
    
            $query4 = "SELECT * FROM categorys WHERE id_user = :iduser"; 
            $stmt4 = $this->container->db->prepare($query4);
            $stmt4->execute(['iduser' => $iduser]);
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
        $titolo = $request->getParam('titolo');
        $avidita = $request->getParam('avidita');
        $data = $request->getParam('data');
        $categoria = $request->getParam('categoria');

        $errodata = 0;

        $dataAtual = date('Y-m-d');

        if ($data <= $dataAtual) {
            $errodata = 1;
        } 

        if($errodata==0){
            $sql = "INSERT INTO tasks (category, description, final_date, title, id_user) VALUES (:category, :description, :data, :title, :id_user)";
            $stmt = $this->container->db->prepare($sql);
            
            // Execute a consulta com os valores fornecidos
            $stmt->execute(['category' => $categoria, 'description' => $avidita, 'data' => $data, 'title'=>$titolo, 'id_user'=>$_SESSION['Id_User']]);
            
            // Verifica se a inserção foi bem-sucedida
            if ($stmt->rowCount() > 0) {
                
                // Redireciona para a página inicial ou renderiza o template, conforme necessário
                return $response->withRedirect('/public/');
            } else {
                echo "Erro ao inserir registro.";
            }
        }
    }

    public function getNewCategory($request, $response){
        return $this->container->view->render($response, 'sneat-1.0.0/html/NewCategory.html');
    
    }
    public function postNewCategory($request, $response){
        $categoria = $request->getParam('categoria');
    
        $sql = "INSERT INTO categorys (id_user, name) VALUES (:id, :category)";
        $stmt = $this->container->db->prepare($sql);
        
        // Execute a consulta com os valores fornecidos
        $stmt->execute(['category' => $categoria, 'id' => $_SESSION['Id_User']]);
        
        // Verifica se a inserção foi bem-sucedida
        if ($stmt->rowCount() > 0) {
            return $response->withRedirect('/public/');
        } else {
            echo "Erro ao inserir registro.";
        }
    }

    public function getSignIn($request, $response){
            return $this->container->view->render($response, 'sneat-1.0.0/html/Login.html');
        
    }

    public function postSignIn($request, $response){
        $email = $request->getParam('email');
        $palavrapasse = $request->getParam('password');
        
        $sql = "SELECT id_user FROM users WHERE email=:email AND password=:palavrapasse";
        $stmt = $this->container->db->prepare($sql);
        $stmt->execute(['email' => $email, 'palavrapasse' => $palavrapasse]);
        $user = $stmt->fetch(); // Obter a primeira linha de resultado
        
        if ($user) {
            // Se o usuário existe, armazena o ID do usuário na sessão e redireciona
            $_SESSION['Id_User'] = $user['id_user'];
            return $response->withRedirect('/public/');
        } else {
            // Se o usuário não existe, renderiza a página de login novamente
            return $this->container->view->render($response, 'sneat-1.0.0/html/Login.html');
        }
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