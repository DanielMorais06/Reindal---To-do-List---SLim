<?php

namespace App\Controllers;

class HomeController extends Controller{

    public function index($request, $response) {
        if(empty($_SESSION['Id_User'])){
            return $this->container->view->render($response, '/sneat-1.0.0/html/index.html');
        }else{
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
            

        $query4 = "SELECT * FROM tasks WHERE id_user = '$iduser'"; 
        $stmt4 = $this->container->db->query($query4);
        $tasks4 = $stmt4->fetchAll(\PDO::FETCH_ASSOC);
        $tasksJson4 = json_encode($tasks4);
        $query5 = "SELECT * FROM categorys WHERE id_user = '$iduser'"; 
        $stmt5 = $this->container->db->query($query5);
        $tasks5 = $stmt5->fetchAll(\PDO::FETCH_ASSOC);
        $tasksJson5 = json_encode($tasks5);
    
        return $this->container->view->render($response, '/sneat-1.0.0/html/index.html', [
            'tasksJson1' => $tasksJson1,
            'tasksJson2' => $tasksJson2,
            'tasksJson3' => $tasksJson3,
            'tasksJson4' => $tasksJson4,
            'tasksJson5' => $tasksJson5  
        ]);
        } 
        
    }
    
    
    
}