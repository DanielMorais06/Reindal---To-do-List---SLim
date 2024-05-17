<?php

namespace App\Controllers;

class HomeController extends Controller{

    public function index($request, $response) {
        if(empty($_SESSION['Id_User'])){
            return $this->container->view->render($response, '/sneat-1.0.0/html/index.html');
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
    
        return $this->container->view->render($response, '/sneat-1.0.0/html/index.html', [
            'tasksJson1' => $tasksJson1,
            'tasksJson2' => $tasksJson2,
            'tasksJson3' => $tasksJson3,
            'tasksJson4' => $tasksJson4 
        ]);
        } 
        
    }
    
    
    
}