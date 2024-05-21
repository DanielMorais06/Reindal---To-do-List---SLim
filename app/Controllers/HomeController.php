<?php

namespace App\Controllers;

use App\DBAccess\HomeDbAccess;

class HomeController extends Controller{

    public function index($request, $response) {
        if(empty($_SESSION['Id_User'])){
            $this->container->logger->info('SUCESSFULL! Render /sneat-1.0.0/html/index.phtml');
            return $this->container->view->render($response, '/sneat-1.0.0/html/index.phtml');
        }else{
            $iduser = $_SESSION['Id_User'];
        
            try {
                $dbAccess = new HomeDbAccess($this->container);
                $dateLimit1 = date('Y-m-d', strtotime('+3 days'));
                $tasksJson1 = $dbAccess->getAltaUrgenza($iduser,$dateLimit1);

                $dateLimit2 = date('Y-m-d', strtotime('+1 week'));
                $tasksJson2 = $dbAccess->getNormale($iduser,$dateLimit1, $dateLimit2);

                $dateLimit3 = date('Y-m-d');
                $tasksJson3 = $dbAccess->getHoTempo($iduser,$dateLimit2, $dateLimit3);
                $tasksJson4 = $dbAccess->getTasks($iduser);
                $tasksJson5 = $dbAccess->getCategorys($iduser);
                $tasksJson6 = $dbAccess->getTasksCompleted($iduser);
                $tasksJson7 = $dbAccess->getTasksIncompleted($iduser);
    
                return $this->container->view->render($response, '/sneat-1.0.0/html/index.phtml', [
                    'tasksJson1' => json_encode($tasksJson1),
                    'tasksJson2' => json_encode($tasksJson2),
                    'tasksJson3' => json_encode($tasksJson3),
                    'tasksJson4' => json_encode($tasksJson4),
                    'tasksJson5' => json_encode($tasksJson5),
                    'tasksJson6' => json_encode($tasksJson6),
                    'tasksJson7' => json_encode($tasksJson7)
                ]);
            } catch (\Exception $e) {
                $this->container->logger->error($e->getMessage(), ['exception' => $e]);
            }
        } 
        
    }
    
    
    
}