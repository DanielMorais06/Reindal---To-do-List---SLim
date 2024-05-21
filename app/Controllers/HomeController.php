<?php

namespace App\Controllers;
use App\DBAccess\HomeDbAccess;

class HomeController extends Controller{

    public function index($request, $response) {
        $_SESSION['Id_User']=18;
        if(empty($_SESSION['Id_User'])){
            $this->container->logger->info('SUCESSFULL! Render /sneat-1.0.0/html/index.phtml');
            return $this->container->view->render($response, '/sneat-1.0.0/html/index.phtml');
        }else{
            $iduser = $_SESSION['Id_User'];

            // Instancie a classe HomeDbAccess e passe o PDO do container
            $dbAccess = new HomeDbAccess($this->container->db);

            // Obtenha as tarefas
            $tasksJson1 = $dbAccess->getTasksDueInThreeDays($iduser);

            /*$dateLimit2 = date('Y-m-d', strtotime('+1 week'));
            $query2 = "SELECT * FROM tasks WHERE final_date > :dateLimit1 AND final_date <= :dateLimit2 AND id_user = :iduser AND Completed='0' AND final_date >= CURDATE() LIMIT 4";
            $stmt2 = $this->container->db->prepare($query2);
            $stmt2->execute(['dateLimit1' => $dateLimit1, 'dateLimit2' => $dateLimit2, 'iduser' => $iduser]);
            $tasks2 = $stmt2->fetchAll(\PDO::FETCH_ASSOC);
            $tasksJson2 = json_encode($tasks2);

            $dateLimit3 = date('Y-m-d');
            $query3 = "SELECT * FROM tasks WHERE final_date > :dateLimit2 AND final_date > :dateLimit3 AND id_user = :iduser AND Completed='0' AND final_date >= CURDATE() LIMIT 4";
            $stmt3 = $this->container->db->prepare($query3);
            $stmt3->execute(['dateLimit2' => $dateLimit2, 'dateLimit3' => $dateLimit3, 'iduser' => $iduser]);
            $tasks3 = $stmt3->fetchAll(\PDO::FETCH_ASSOC);
            $tasksJson3 = json_encode($tasks3);
            

        $query4 = "SELECT * FROM tasks WHERE id_user = '$iduser' AND Completed='0' AND final_date >= CURDATE()"; 
        $stmt4 = $this->container->db->query($query4);
        $tasks4 = $stmt4->fetchAll(\PDO::FETCH_ASSOC);
        $tasksJson4 = json_encode($tasks4);

        $query5 = "SELECT * FROM categorys WHERE id_user = '$iduser'"; 
        $stmt5 = $this->container->db->query($query5);
        $tasks5 = $stmt5->fetchAll(\PDO::FETCH_ASSOC);
        $tasksJson5 = json_encode($tasks5);

        $query6 = "SELECT * FROM tasks WHERE id_user = '$iduser' AND Completed='1'"; 
        $stmt6 = $this->container->db->query($query6);
        $tasks6 = $stmt6->fetchAll(\PDO::FETCH_ASSOC);
        $tasksJson6 = json_encode($tasks6);

        $query7 = "SELECT * FROM tasks WHERE id_user = '$iduser' AND Completed='0' AND final_date < CURDATE()";
        $stmt7 = $this->container->db->query($query7);
        $tasks7 = $stmt7->fetchAll(\PDO::FETCH_ASSOC);
        $tasksJson7 = json_encode($tasks7);*/
    
        return $this->container->view->render($response, '/sneat-1.0.0/html/index.phtml', [
            'tasksJson1' => $tasksJson1
        ]);
        } 
        
    }
    
    
    
}