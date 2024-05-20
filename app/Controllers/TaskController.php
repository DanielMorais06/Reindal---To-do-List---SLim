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
            $query1 = "SELECT * FROM tasks WHERE final_date <= :dateLimit1 AND id_user = :iduser AND Completed='0' AND final_date >= CURDATE() LIMIT 4";
            $stmt1 = $this->container->db->prepare($query1);
            $stmt1->execute(['dateLimit1' => $dateLimit1, 'iduser' => $iduser]);
            $tasks1 = $stmt1->fetchAll(\PDO::FETCH_ASSOC);
            $tasksJson1 = json_encode($tasks1);

            // Define a data limite para uma semana no futuro
            $dateLimit2 = date('Y-m-d', strtotime('+1 week'));
            $query2 = "SELECT * FROM tasks WHERE final_date > :dateLimit1 AND final_date <= :dateLimit2 AND id_user = :iduser AND Completed='0' AND final_date >= CURDATE() LIMIT 4";
            $stmt2 = $this->container->db->prepare($query2);
            $stmt2->execute(['dateLimit1' => $dateLimit1, 'dateLimit2' => $dateLimit2, 'iduser' => $iduser]);
            $tasks2 = $stmt2->fetchAll(\PDO::FETCH_ASSOC);
            $tasksJson2 = json_encode($tasks2);

            // Define a data limite para a data atual
            $dateLimit3 = date('Y-m-d');
            $query3 = "SELECT * FROM tasks WHERE final_date > :dateLimit2 AND final_date > :dateLimit3 AND id_user = :iduser AND Completed='0' AND final_date >= CURDATE() LIMIT 4";
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

        $titolo = str_replace("'", "**", $titolo);
        $avidita = str_replace("'", "**", $avidita);
    
        $errodata = 0;
        $errovazio = 0;
    
        $dataAtual = date('Y-m-d');
    
        if ($data < $dataAtual) {
            $errodata = 1;
        } 
    
        if(empty($titolo) || empty($avidita) || empty($data) || empty($categoria)){
            $errovazio = 1;
            $errodata = 1;
        }
    
        if($errodata == 0 && $errovazio == 0){
            $sql = "INSERT INTO tasks (category, description, final_date, title, id_user, Completed) VALUES (:category, :descrito, :dat, :title, :id_user, 0)";
            $stmt = $this->container->db->prepare($sql);
    
            // Usar bindParam para garantir a segurança dos dados
            $stmt->bindParam(':category', $categoria);
            $stmt->bindParam(':descrito', $avidita);
            $stmt->bindParam(':dat', $data);
            $stmt->bindParam(':title', $titolo);
            $stmt->bindParam(':id_user', $_SESSION['Id_User']);
    
            // Execute a consulta com os valores fornecidos
            $stmt->execute();
            
            // Verifica se a inserção foi bem-sucedida
            if ($stmt->rowCount() > 0) {
                // Redireciona para a página inicial ou renderiza o template, conforme necessário
                return $response->withRedirect('/public/');
            } else {
                echo "Erro ao inserir registro.";
            }
        } else {
            $iduser = $_SESSION['Id_User'];
    
            // Define a data limite para 3 dias no futuro
            $dateLimit1 = date('Y-m-d', strtotime('+3 days'));
            $query1 = "SELECT * FROM tasks WHERE final_date <= :dateLimit1 AND id_user = :iduser AND Completed='0' AND final_date >= CURDATE() LIMIT 4";
            $stmt1 = $this->container->db->prepare($query1);
            $stmt1->execute(['dateLimit1' => $dateLimit1, 'iduser' => $iduser]);
            $tasks1 = $stmt1->fetchAll(\PDO::FETCH_ASSOC);
            $tasksJson1 = json_encode($tasks1);
    
            // Define a data limite para uma semana no futuro
            $dateLimit2 = date('Y-m-d', strtotime('+1 week'));
            $query2 = "SELECT * FROM tasks WHERE final_date > :dateLimit1 AND final_date <= :dateLimit2 AND id_user = :iduser AND Completed='0' AND final_date >= CURDATE() LIMIT 4";
            $stmt2 = $this->container->db->prepare($query2);
            $stmt2->execute(['dateLimit1' => $dateLimit1, 'dateLimit2' => $dateLimit2, 'iduser' => $iduser]);
            $tasks2 = $stmt2->fetchAll(\PDO::FETCH_ASSOC);
            $tasksJson2 = json_encode($tasks2);
    
            // Define a data limite para a data atual
            $dateLimit3 = date('Y-m-d');
            $query3 = "SELECT * FROM tasks WHERE final_date > :dateLimit2 AND final_date > :dateLimit3 AND id_user = :iduser AND Completed='0' AND final_date >= CURDATE() LIMIT 4";
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
                'tasksJson4' => $tasksJson4,
                'erroData' => $errodata,
                'erroVazio' => $errovazio
            ]);
        }
    }

    public function getNewCategory($request, $response){
        $iduser = $_SESSION['Id_User'];

            // Define a data limite para 3 dias no futuro
            $dateLimit1 = date('Y-m-d', strtotime('+3 days'));
            $query1 = "SELECT * FROM tasks WHERE final_date <= :dateLimit1 AND id_user = :iduser AND Completed='0' AND final_date >= CURDATE() LIMIT 4";
            $stmt1 = $this->container->db->prepare($query1);
            $stmt1->execute(['dateLimit1' => $dateLimit1, 'iduser' => $iduser]);
            $tasks1 = $stmt1->fetchAll(\PDO::FETCH_ASSOC);
            $tasksJson1 = json_encode($tasks1);

            // Define a data limite para uma semana no futuro
            $dateLimit2 = date('Y-m-d', strtotime('+1 week'));
            $query2 = "SELECT * FROM tasks WHERE final_date > :dateLimit1 AND final_date <= :dateLimit2 AND id_user = :iduser AND Completed='0' AND final_date >= CURDATE() LIMIT 4";
            $stmt2 = $this->container->db->prepare($query2);
            $stmt2->execute(['dateLimit1' => $dateLimit1, 'dateLimit2' => $dateLimit2, 'iduser' => $iduser]);
            $tasks2 = $stmt2->fetchAll(\PDO::FETCH_ASSOC);
            $tasksJson2 = json_encode($tasks2);

            // Define a data limite para a data atual
            $dateLimit3 = date('Y-m-d');
            $query3 = "SELECT * FROM tasks WHERE final_date > :dateLimit2 AND final_date > :dateLimit3 AND id_user = :iduser AND Completed='0' AND final_date >= CURDATE() LIMIT 4";
            $stmt3 = $this->container->db->prepare($query3);
            $stmt3->execute(['dateLimit2' => $dateLimit2, 'dateLimit3' => $dateLimit3, 'iduser' => $iduser]);
            $tasks3 = $stmt3->fetchAll(\PDO::FETCH_ASSOC);
            $tasksJson3 = json_encode($tasks3);

            $query4 = "SELECT * FROM categorys WHERE id_user = :iduser";
            $stmt4 = $this->container->db->prepare($query4);
            $stmt4->execute(['iduser' => $iduser]);
            $tasks4 = $stmt4->fetchAll(\PDO::FETCH_ASSOC);
            $tasksJson4 = json_encode($tasks4);

            return $this->container->view->render($response, '/sneat-1.0.0/html/NewCategory.html', [
                'tasksJson1' => $tasksJson1,
                'tasksJson2' => $tasksJson2,
                'tasksJson3' => $tasksJson3,
                'tasksJson4' => $tasksJson4
            ]);
    
    }
    public function postNewCategory($request, $response){
        $categoria = $request->getParam('categoria');
        if(empty($categoria)){
            $iduser = $_SESSION['Id_User'];

            // Define a data limite para 3 dias no futuro
            $dateLimit1 = date('Y-m-d', strtotime('+3 days'));
            $query1 = "SELECT * FROM tasks WHERE final_date <= :dateLimit1 AND id_user = :iduser AND Completed='0' AND final_date >= CURDATE() LIMIT 4";
            $stmt1 = $this->container->db->prepare($query1);
            $stmt1->execute(['dateLimit1' => $dateLimit1, 'iduser' => $iduser]);
            $tasks1 = $stmt1->fetchAll(\PDO::FETCH_ASSOC);
            $tasksJson1 = json_encode($tasks1);

            // Define a data limite para uma semana no futuro
            $dateLimit2 = date('Y-m-d', strtotime('+1 week'));
            $query2 = "SELECT * FROM tasks WHERE final_date > :dateLimit1 AND final_date <= :dateLimit2 AND id_user = :iduser AND Completed='0' AND final_date >= CURDATE() LIMIT 4";
            $stmt2 = $this->container->db->prepare($query2);
            $stmt2->execute(['dateLimit1' => $dateLimit1, 'dateLimit2' => $dateLimit2, 'iduser' => $iduser]);
            $tasks2 = $stmt2->fetchAll(\PDO::FETCH_ASSOC);
            $tasksJson2 = json_encode($tasks2);

            // Define a data limite para a data atual
            $dateLimit3 = date('Y-m-d');
            $query3 = "SELECT * FROM tasks WHERE final_date > :dateLimit2 AND final_date > :dateLimit3 AND id_user = :iduser AND Completed='0' AND final_date >= CURDATE() LIMIT 4";
            $stmt3 = $this->container->db->prepare($query3);
            $stmt3->execute(['dateLimit2' => $dateLimit2, 'dateLimit3' => $dateLimit3, 'iduser' => $iduser]);
            $tasks3 = $stmt3->fetchAll(\PDO::FETCH_ASSOC);
            $tasksJson3 = json_encode($tasks3);

            $query4 = "SELECT * FROM categorys WHERE id_user = :iduser";
            $stmt4 = $this->container->db->prepare($query4);
            $stmt4->execute(['iduser' => $iduser]);
            $tasks4 = $stmt4->fetchAll(\PDO::FETCH_ASSOC);
            $tasksJson4 = json_encode($tasks4);

            return $this->container->view->render($response, '/sneat-1.0.0/html/NewCategory.html', [
                'tasksJson1' => $tasksJson1,
                'tasksJson2' => $tasksJson2,
                'tasksJson3' => $tasksJson3,
                'tasksJson4' => $tasksJson4
            ]);
        }else{
            $categoria = str_replace("'", "**", $categoria);
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
        }
    
        

    public function getSignIn($request, $response){
            return $this->container->view->render($response, 'sneat-1.0.0/html/Login.html');
        
    }

    public function postSignIn($request, $response) {
        $email = $request->getParam('email');
        $palavrapasse = $request->getParam('password');
    
        $erroPasse = 0;
        $erroEmail = 0;
    
        if(empty($email)){
            $erroEmail = 1;
        }
    
        if(empty($palavrapasse)){
            $erroPasse = 1;
        }
    
        if (strpos($palavrapasse, "'") !== false) {
            $erroPasse = 1;
        } 
    
        if (strpos($email, "'") !== false) {
            $erroEmail = 1;
        }
    
        if ($erroPasse == 0 && $erroEmail == 0) {
            $sql = "SELECT id_user, password FROM users WHERE email=:email";
            $stmt = $this->container->db->prepare($sql);
            $stmt->execute(['email' => $email]);
            $user = $stmt->fetch();

            if ($user && $user['password'] === $palavrapasse) {
                $_SESSION['Id_User'] = $user['id_user'];
                return $response->withRedirect('/public/');
            } else {
                $erroPasse = 1;
                $erroEmail = 1;
                // Renderiza o template, independentemente dos erros
                return $this->container->view->render($response, 'sneat-1.0.0/html/Login.html', [
                    'erroSenha' => $erroPasse,
                    'erroEmail' => $erroEmail
                ]);
            }
        }else{
            // Renderiza o template, independentemente dos erros
            return $this->container->view->render($response, 'sneat-1.0.0/html/Login.html', [
                'erroSenha' => $erroPasse,
                'erroEmail' => $erroEmail
            ]);
        }
        
        
    }
    
    

    public function getSignUp($request, $response){
        return $this->container->view->render($response, 'sneat-1.0.0/html/Register.html');
    }
    
    public function postSignUp($request, $response){
        $nome = $request->getParam('nomeutente');
        $email = $request->getParam('e-mail');
        $palavrapasse = $request->getParam('password');
        $nome= str_replace("'", "**", $nome);
        
        $erroNome = 0;
        $erroEmail = 0;
        $erroSenha = 0;
    
        if (preg_match('/[0-9]/', $nome)) {
            $erroNome = 1;
        }
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $erroEmail = 1;
        }

        if (strpos($palavrapasse, "'") !== false) {
            $erroSenha = 1;
        } 

        
        if (strpos($email, "'") !== false) {
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

    public function getProfilo($request, $response){

        $iduser = $_SESSION['Id_User'];

            // Define a data limite para 3 dias no futuro
            $dateLimit1 = date('Y-m-d', strtotime('+3 days'));
            $query1 = "SELECT * FROM tasks WHERE final_date <= :dateLimit1 AND id_user = :iduser AND Completed='0' AND final_date >= CURDATE() LIMIT 4";
            $stmt1 = $this->container->db->prepare($query1);
            $stmt1->execute(['dateLimit1' => $dateLimit1, 'iduser' => $iduser]);
            $tasks1 = $stmt1->fetchAll(\PDO::FETCH_ASSOC);
            $tasksJson1 = json_encode($tasks1);

            // Define a data limite para uma semana no futuro
            $dateLimit2 = date('Y-m-d', strtotime('+1 week'));
            $query2 = "SELECT * FROM tasks WHERE final_date > :dateLimit1 AND final_date <= :dateLimit2 AND id_user = :iduser AND Completed='0' AND final_date >= CURDATE() LIMIT 4";
            $stmt2 = $this->container->db->prepare($query2);
            $stmt2->execute(['dateLimit1' => $dateLimit1, 'dateLimit2' => $dateLimit2, 'iduser' => $iduser]);
            $tasks2 = $stmt2->fetchAll(\PDO::FETCH_ASSOC);
            $tasksJson2 = json_encode($tasks2);

            // Define a data limite para a data atual
            $dateLimit3 = date('Y-m-d');
            $query3 = "SELECT * FROM tasks WHERE final_date > :dateLimit2 AND final_date > :dateLimit3 AND id_user = :iduser AND Completed='0' AND final_date >= CURDATE() LIMIT 4";
            $stmt3 = $this->container->db->prepare($query3);
            $stmt3->execute(['dateLimit2' => $dateLimit2, 'dateLimit3' => $dateLimit3, 'iduser' => $iduser]);
            $tasks3 = $stmt3->fetchAll(\PDO::FETCH_ASSOC);
            $tasksJson3 = json_encode($tasks3);

            $query4 = "SELECT * FROM categorys WHERE id_user = :iduser";
            $stmt4 = $this->container->db->prepare($query4);
            $stmt4->execute(['iduser' => $iduser]);
            $tasks4 = $stmt4->fetchAll(\PDO::FETCH_ASSOC);
            $tasksJson4 = json_encode($tasks4);

            $query5 = "SELECT * FROM users WHERE id_user = :iduser";
            $stmt5 = $this->container->db->prepare($query5);
            $stmt5->execute(['iduser' => $iduser]);
            $userData = $stmt5->fetch(\PDO::FETCH_ASSOC);

            return $this->container->view->render($response, '/sneat-1.0.0/html/Profilo.html', [
                'tasksJson1' => $tasksJson1,
                'tasksJson2' => $tasksJson2,
                'tasksJson3' => $tasksJson3,
                'tasksJson4' => $tasksJson4,
                'userData' => $userData
            ]);
    
    }
    public function postProfilo($request, $response){
        $iduser = $_SESSION['Id_User'];
        $nome = $request->getParam('nome');

        if(empty($nome)){
            $iduser = $_SESSION['Id_User'];

            // Define a data limite para 3 dias no futuro
            $dateLimit1 = date('Y-m-d', strtotime('+3 days'));
            $query1 = "SELECT * FROM tasks WHERE final_date <= :dateLimit1 AND id_user = :iduser AND Completed='0' AND final_date >= CURDATE() LIMIT 4";
            $stmt1 = $this->container->db->prepare($query1);
            $stmt1->execute(['dateLimit1' => $dateLimit1, 'iduser' => $iduser]);
            $tasks1 = $stmt1->fetchAll(\PDO::FETCH_ASSOC);
            $tasksJson1 = json_encode($tasks1);

            // Define a data limite para uma semana no futuro
            $dateLimit2 = date('Y-m-d', strtotime('+1 week'));
            $query2 = "SELECT * FROM tasks WHERE final_date > :dateLimit1 AND final_date <= :dateLimit2 AND id_user = :iduser AND Completed='0' AND final_date >= CURDATE() LIMIT 4";
            $stmt2 = $this->container->db->prepare($query2);
            $stmt2->execute(['dateLimit1' => $dateLimit1, 'dateLimit2' => $dateLimit2, 'iduser' => $iduser]);
            $tasks2 = $stmt2->fetchAll(\PDO::FETCH_ASSOC);
            $tasksJson2 = json_encode($tasks2);

            // Define a data limite para a data atual
            $dateLimit3 = date('Y-m-d');
            $query3 = "SELECT * FROM tasks WHERE final_date > :dateLimit2 AND final_date > :dateLimit3 AND id_user = :iduser AND Completed='0' AND final_date >= CURDATE() LIMIT 4";
            $stmt3 = $this->container->db->prepare($query3);
            $stmt3->execute(['dateLimit2' => $dateLimit2, 'dateLimit3' => $dateLimit3, 'iduser' => $iduser]);
            $tasks3 = $stmt3->fetchAll(\PDO::FETCH_ASSOC);
            $tasksJson3 = json_encode($tasks3);

            $query4 = "SELECT * FROM categorys WHERE id_user = :iduser";
            $stmt4 = $this->container->db->prepare($query4);
            $stmt4->execute(['iduser' => $iduser]);
            $tasks4 = $stmt4->fetchAll(\PDO::FETCH_ASSOC);
            $tasksJson4 = json_encode($tasks4);

            $query5 = "SELECT * FROM users WHERE id_user = :iduser";
            $stmt5 = $this->container->db->prepare($query5);
            $stmt5->execute(['iduser' => $iduser]);
            $userData = $stmt5->fetch(\PDO::FETCH_ASSOC);

            return $this->container->view->render($response, '/sneat-1.0.0/html/Profilo.html', [
                'tasksJson1' => $tasksJson1,
                'tasksJson2' => $tasksJson2,
                'tasksJson3' => $tasksJson3,
                'tasksJson4' => $tasksJson4,
                'userData' => $userData
            ]);
        }else{
            $nome = str_replace("'", "**", $nome);
            $query5 = "Update users SET name=:nome WHERE id_user=:iduser";
            $stmt5 = $this->container->db->prepare($query5);
            $stmt5->execute(['nome' => $nome, 'iduser' => $iduser]);
           
            return $response->withRedirect('/public/');
        }


    }

    public function getTask($request, $response){

       
    
    }
    public function postTask($request, $response) {
        $iduser = $_SESSION['Id_User'];
        $idtask = $request->getParam('id_task');
    
        // Define a data limite para 3 dias no futuro
        $dateLimit1 = date('Y-m-d', strtotime('+3 days'));
        $query1 = "SELECT * FROM tasks WHERE final_date <= :dateLimit1 AND id_user = :iduser AND Completed='0' AND final_date >= CURDATE() LIMIT 4";
        $stmt1 = $this->container->db->prepare($query1);
        $stmt1->execute(['dateLimit1' => $dateLimit1, 'iduser' => $iduser]);
        $tasks1 = $stmt1->fetchAll(\PDO::FETCH_ASSOC);
        $tasksJson1 = json_encode($tasks1);
    
        // Define a data limite para uma semana no futuro
        $dateLimit2 = date('Y-m-d', strtotime('+1 week'));
        $query2 = "SELECT * FROM tasks WHERE final_date > :dateLimit1 AND final_date <= :dateLimit2 AND id_user = :iduser AND Completed='0' AND final_date >= CURDATE() LIMIT 4";
        $stmt2 = $this->container->db->prepare($query2);
        $stmt2->execute(['dateLimit1' => $dateLimit1, 'dateLimit2' => $dateLimit2, 'iduser' => $iduser]);
        $tasks2 = $stmt2->fetchAll(\PDO::FETCH_ASSOC);
        $tasksJson2 = json_encode($tasks2);
    
        // Define a data limite para a data atual
        $dateLimit3 = date('Y-m-d');
        $query3 = "SELECT * FROM tasks WHERE final_date > :dateLimit2 AND final_date > :dateLimit3 AND id_user = :iduser AND Completed='0' AND final_date >= CURDATE() LIMIT 4";
        $stmt3 = $this->container->db->prepare($query3);
        $stmt3->execute(['dateLimit2' => $dateLimit2, 'dateLimit3' => $dateLimit3, 'iduser' => $iduser]);
        $tasks3 = $stmt3->fetchAll(\PDO::FETCH_ASSOC);
        $tasksJson3 = json_encode($tasks3);
    
        $query4 = "SELECT * FROM categorys WHERE id_user = :iduser";
        $stmt4 = $this->container->db->prepare($query4);
        $stmt4->execute(['iduser' => $iduser]);
        $tasks4 = $stmt4->fetchAll(\PDO::FETCH_ASSOC);
        $tasksJson4 = json_encode($tasks4);
    
        // Obtém os detalhes da tarefa específica
        $query5 = "SELECT t.*, c.name AS category_name 
           FROM tasks t 
           JOIN categorys c ON t.category = c.id_category 
           WHERE t.id_task = :idtask AND t.id_user = :iduser";
            $stmt5 = $this->container->db->prepare($query5);
            $stmt5->execute(['idtask' => $idtask, 'iduser' => $iduser]);
            $task5 = $stmt5->fetch(\PDO::FETCH_ASSOC);

        // Verifica se a tarefa está marcada como completa
        $queryCheckComplete = "SELECT Completed FROM tasks WHERE id_task = :idtask AND id_user = :iduser";
        $stmtCheckComplete = $this->container->db->prepare($queryCheckComplete);
        $stmtCheckComplete->execute(['idtask' => $idtask, 'iduser' => $iduser]);
        $isComplete = $stmtCheckComplete->fetchColumn();

        if ($isComplete == 1) {
            return $this->container->view->render($response, '/sneat-1.0.0/html/TaskCompleted.html', [
                'tasksJson1' => $tasksJson1,
                'tasksJson2' => $tasksJson2,
                'tasksJson3' => $tasksJson3,
                'tasksJson4' => $tasksJson4,
                'task5' => json_encode($task5)
            ]);
        }else{
            $queryCheckComplete = "SELECT Completed, final_date FROM tasks WHERE id_task = :idtask AND id_user = :iduser";
            $stmtCheckComplete = $this->container->db->prepare($queryCheckComplete);
            $stmtCheckComplete->execute(['idtask' => $idtask, 'iduser' => $iduser]);
            $taskData = $stmtCheckComplete->fetch(\PDO::FETCH_ASSOC);

            if ($taskData) {
                $completed = $taskData['Completed'];
                $finalDate = $taskData['final_date'];
                
                // Obtém a data atual
                $currentDate = date('Y-m-d');
                
                if ($completed == 0 && $finalDate < $currentDate) {
                    return $this->container->view->render($response, '/sneat-1.0.0/html/TaskCompleted.html', [
                        'tasksJson1' => $tasksJson1,
                        'tasksJson2' => $tasksJson2,
                        'tasksJson3' => $tasksJson3,
                        'tasksJson4' => $tasksJson4,
                        'task5' => json_encode($task5)
                    ]);
                } else {
                    return $this->container->view->render($response, '/sneat-1.0.0/html/Task.html', [
                        'tasksJson1' => $tasksJson1,
                        'tasksJson2' => $tasksJson2,
                        'tasksJson3' => $tasksJson3,
                        'tasksJson4' => $tasksJson4,
                        'task5' => json_encode($task5)
                    ]);
                }
            } 
                    }
    
        
    }

    public function getCompletTask($request, $response){

       
    
    }
    public function postCompletTask($request, $response) {

        $iduser = $_SESSION['Id_User'];
        $idtask = $request->getParam('idtask'); 

        $query5 = "UPDATE tasks SET Completed='1' WHERE id_user = :iduser AND id_task = :idtask";
        $stmt5 = $this->container->db->prepare($query5);
        $stmt5->execute(['iduser' => $iduser, 'idtask' => $idtask]);
       
        return $response->withRedirect('/public/');
    }
    public function getDeletTask($request, $response){

       
    
    }
    public function postDeletTask($request, $response) {

        $iduser = $_SESSION['Id_User'];
        $idtask = $request->getParam('idtask');

        $query5 = "DELETE FROM tasks WHERE id_task = :idtask AND id_user = :iduser";
        $stmt5 = $this->container->db->prepare($query5);
        $stmt5->execute(['idtask' => $idtask, 'iduser' => $iduser]);
       
        return $response->withRedirect('/public/');
    }

    public function getLogout($request, $response){

       session_destroy();
        return $response->withRedirect('/public/');
    }
    public function postLogout($request, $response) {       
        
    }

    public function getDeleteCategory($request, $response){

       
    
    }
    public function postDeleteCategory($request, $response) {

        $iduser = $_SESSION['Id_User'];
        $idcategory = $request->getParam('idcategory');

        $query5 = "DELETE FROM  tasks WHERE category = :idcategory AND id_user = :iduser";
        $stmt5 = $this->container->db->prepare($query5);
        $stmt5->execute(['idcategory' => $idcategory, 'iduser' => $iduser]);

        $query5 = "DELETE FROM  categorys WHERE id_category = :idcategory AND id_user = :iduser";
        $stmt5 = $this->container->db->prepare($query5);
        $stmt5->execute(['idcategory' => $idcategory, 'iduser' => $iduser]);
       
        return $response->withRedirect('/public/');
    }

    public function getCategory($request, $response){

       
    
    }
    public function postCategory($request, $response) {
        $iduser = $_SESSION['Id_User'];
        $idcategory = $request->getParam('category');
    
        // Define a data limite para 3 dias no futuro
        $dateLimit1 = date('Y-m-d', strtotime('+3 days'));
        $query1 = "SELECT * FROM tasks WHERE final_date <= :dateLimit1 AND id_user = :iduser AND Completed='0' AND final_date >= CURDATE() LIMIT 4";
        $stmt1 = $this->container->db->prepare($query1);
        $stmt1->execute(['dateLimit1' => $dateLimit1, 'iduser' => $iduser]);
        $tasks1 = $stmt1->fetchAll(\PDO::FETCH_ASSOC);
        $tasksJson1 = json_encode($tasks1);
    
        // Define a data limite para uma semana no futuro
        $dateLimit2 = date('Y-m-d', strtotime('+1 week'));
        $query2 = "SELECT * FROM tasks WHERE final_date > :dateLimit1 AND final_date <= :dateLimit2 AND id_user = :iduser AND Completed='0' AND final_date >= CURDATE() LIMIT 4";
        $stmt2 = $this->container->db->prepare($query2);
        $stmt2->execute(['dateLimit1' => $dateLimit1, 'dateLimit2' => $dateLimit2, 'iduser' => $iduser]);
        $tasks2 = $stmt2->fetchAll(\PDO::FETCH_ASSOC);
        $tasksJson2 = json_encode($tasks2);
    
        // Define a data limite para a data atual
        $dateLimit3 = date('Y-m-d');
        $query3 = "SELECT * FROM tasks WHERE final_date > :dateLimit2 AND final_date > :dateLimit3 AND id_user = :iduser AND Completed='0' AND final_date >= CURDATE() LIMIT 4";
        $stmt3 = $this->container->db->prepare($query3);
        $stmt3->execute(['dateLimit2' => $dateLimit2, 'dateLimit3' => $dateLimit3, 'iduser' => $iduser]);
        $tasks3 = $stmt3->fetchAll(\PDO::FETCH_ASSOC);
        $tasksJson3 = json_encode($tasks3);
    
        $query4 = "SELECT * FROM categorys WHERE id_user = :iduser";
        $stmt4 = $this->container->db->prepare($query4);
        $stmt4->execute(['iduser' => $iduser]);
        $tasks4 = $stmt4->fetchAll(\PDO::FETCH_ASSOC);
        $tasksJson4 = json_encode($tasks4);
    
        // Fetch all tasks for the specific category
        $query5 = "SELECT t.*, c.name AS category_name, u.*
           FROM tasks t
           JOIN categorys c ON t.category = c.id_category
           JOIN users u ON t.id_user = u.id_user
           WHERE t.category = :idcategory";
$stmt5 = $this->container->db->prepare($query5);
$stmt5->execute(['idcategory' => $idcategory]);
$tasksByCategory = $stmt5->fetchAll(\PDO::FETCH_ASSOC);
$tasksJson5 = json_encode($tasksByCategory);
    
        return $this->container->view->render($response, '/sneat-1.0.0/html/Category.html', [
            'tasksJson1' => $tasksJson1,
            'tasksJson2' => $tasksJson2,
            'tasksJson3' => $tasksJson3,
            'tasksJson4' => $tasksJson4,
            'tasksJson5' => $tasksJson5
        ]);
    }
    




    
}