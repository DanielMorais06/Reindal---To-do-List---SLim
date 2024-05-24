<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\DBAccess\HomeDbAccess;

class TaskController extends Controller
{

    public function getNewTask($request, $response)
    {
        try {
            if (empty($_SESSION['Id_User'])) {
                $this->container->logger->info('Failed! Riendirected /sneat-1.0.0/html/Login.phtml');
                return $this->container->view->render($response, 'sneat-1.0.0/html/Login.phtml');
            } else {
                $iduser = $_SESSION['Id_User'];


                $dbAccess = new HomeDbAccess($this->container);
                $dateLimit1 = date('Y-m-d', strtotime('+3 days'));
                $tasksJson1 = $dbAccess->getAltaUrgenza($iduser, $dateLimit1);

                $dateLimit2 = date('Y-m-d', strtotime('+1 week'));
                $tasksJson2 = $dbAccess->getNormale($iduser, $dateLimit1, $dateLimit2);

                $dateLimit3 = date('Y-m-d');
                $tasksJson3 = $dbAccess->getHoTempo($iduser, $dateLimit2, $dateLimit3);
                $tasksJson4 = $dbAccess->getCategorys($iduser);

                return $this->container->view->render($response, '/sneat-1.0.0/html/NewTask.phtml', [
                    'tasksJson1' => json_encode($tasksJson1),
                    'tasksJson2' => json_encode($tasksJson2),
                    'tasksJson3' => json_encode($tasksJson3),
                    'tasksJson4' => json_encode($tasksJson4)
                ]);


            }
        } catch (\Exception $e) {
            $this->container->logger->error($e->getMessage(), ['exception' => $e]);
        }
    }

    public function postNewTask($request, $response)
    {
        try {
            $dbAccess = new HomeDbAccess($this->container);
            $titolo = $request->getParam('titolo');
            $avidita = $request->getParam('avidita');
            $data = $request->getParam('data');
            $categoria = $request->getParam('categoria');
            $iduser = $_SESSION['Id_User'];
            $errodata = 0;
            $errovazio = 0;

            $uploadedFiles = $_FILES['files'];



            $filesArray = [];
            $uploadDir = 'uploads'.$iduser.'/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            // Process uploaded files
            foreach ($uploadedFiles['error'] as $key => $error) {
                if ($error == UPLOAD_ERR_OK) {
                    $tmp_name = $uploadedFiles['tmp_name'][$key];
                    $name = basename($uploadedFiles['name'][$key]);
                    $destination = $uploadDir . $name;

                    if (move_uploaded_file($tmp_name, $destination)) {
                        $filesArray[] = $destination;
                    } else {
                        $filesArray = '';
                    }
                } else {
                    $filesArray = '';
                }
            }

            if (empty($filesArray)) {
                $filesArray = '';
            }

            if ($filesArray == '') {

            } else {
                $filesArray = implode($filesArray);
                $filesArray = preg_replace('/uploads'.$iduser.'\//', 'ººuploads'.$iduser.'/', $filesArray);


                $filesArray = preg_replace('/^ºº/', '', $filesArray);

                $filesArray = str_replace("'", "**", $filesArray);
            }

            $titolo = str_replace("'", "**", $titolo);
            $avidita = str_replace("'", "**", $avidita);

            $dataAtual = date('Y-m-d');

            if ($data < $dataAtual) {

                $errodata = 1;
            
            }

            if (empty($titolo) || empty($avidita) || empty($data) || empty($categoria)) {

                $errovazio = 1;
                $errodata = 1;
            
            }

            if ($errodata == 0 && $errovazio == 0) {

                $stmt = $dbAccess->getInsertTask($iduser, $categoria, $avidita, $data, $titolo, $filesArray);
                $dateLimit1 = date('Y-m-d', strtotime('+3 days'));
                $tasksJson1 = $dbAccess->getAltaUrgenza($iduser, $dateLimit1);

                $dateLimit2 = date('Y-m-d', strtotime('+1 week'));
                $tasksJson2 = $dbAccess->getNormale($iduser, $dateLimit1, $dateLimit2);

                $dateLimit3 = date('Y-m-d');
                $tasksJson3 = $dbAccess->getHoTempo($iduser, $dateLimit2, $dateLimit3);
                $tasksJson4 = $dbAccess->getCategorys($iduser);
                if ($stmt->rowCount() > 0) {
                    return $this->container->view->render($response, '/sneat-1.0.0/html/NewTask.phtml', [
                        'tasksJson1' => json_encode($tasksJson1),
                        'tasksJson2' => json_encode($tasksJson2),
                        'tasksJson3' => json_encode($tasksJson3),
                        'tasksJson4' => json_encode($tasksJson4)
                    ]);
                }
            
            } else {
                $this->container->logger->info('Failed! Riendirected /sneat-1.0.0/html/NewTask.phtml');
                $dateLimit1 = date('Y-m-d', strtotime('+3 days'));
                $tasksJson1 = $dbAccess->getAltaUrgenza($iduser, $dateLimit1);

                $dateLimit2 = date('Y-m-d', strtotime('+1 week'));
                $tasksJson2 = $dbAccess->getNormale($iduser, $dateLimit1, $dateLimit2);

                $dateLimit3 = date('Y-m-d');
                $tasksJson3 = $dbAccess->getHoTempo($iduser, $dateLimit2, $dateLimit3);
                $tasksJson4 = $dbAccess->getCategorys($iduser);
                return $this->container->view->render($response, '/sneat-1.0.0/html/NewTask.phtml', [
                    'tasksJson1' => json_encode($tasksJson1),
                    'tasksJson2' => json_encode($tasksJson2),
                    'tasksJson3' => json_encode($tasksJson3),
                    'tasksJson4' => json_encode($tasksJson4),
                    'erroData' => $errodata,
                    'erroVazio' => $errovazio
                ]);

            }
        
        } catch (\Exception $e) {
            $this->container->logger->error($e->getMessage(), ['exception' => $e]);
        }

    }

    public function getNewCategory($request, $response)
    {
        try {
        if (empty($_SESSION['Id_User'])) {
            $this->container->logger->info('Failed! Riendirected /sneat-1.0.0/html/Login.phtml');
            return $this->container->view->render($response, 'sneat-1.0.0/html/Login.phtml');
        } else {
            $iduser = $_SESSION['Id_User'];

            
                $dbAccess = new HomeDbAccess($this->container);
                $dateLimit1 = date('Y-m-d', strtotime('+3 days'));
                $tasksJson1 = $dbAccess->getAltaUrgenza($iduser, $dateLimit1);

                $dateLimit2 = date('Y-m-d', strtotime('+1 week'));
                $tasksJson2 = $dbAccess->getNormale($iduser, $dateLimit1, $dateLimit2);

                $dateLimit3 = date('Y-m-d');
                $tasksJson3 = $dbAccess->getHoTempo($iduser, $dateLimit2, $dateLimit3);
                $tasksJson4 = $dbAccess->getCategorys($iduser);

                return $this->container->view->render($response, '/sneat-1.0.0/html/NewCategory.phtml', [
                    'tasksJson1' => json_encode($tasksJson1),
                    'tasksJson2' => json_encode($tasksJson2),
                    'tasksJson3' => json_encode($tasksJson3),
                    'tasksJson4' => json_encode($tasksJson4)
                ]);
            
        }} catch (\Exception $e) {
            $this->container->logger->error($e->getMessage(), ['exception' => $e]);
        }

    }
    public function postNewCategory($request, $response)
    {        try {
        $categoria = $request->getParam('categoria');
        $iduser = $_SESSION['Id_User'];
        $dbAccess = new HomeDbAccess($this->container);
        if (empty($categoria)) {

    
                $dateLimit1 = date('Y-m-d', strtotime('+3 days'));
                $tasksJson1 = $dbAccess->getAltaUrgenza($iduser, $dateLimit1);

                $dateLimit2 = date('Y-m-d', strtotime('+1 week'));
                $tasksJson2 = $dbAccess->getNormale($iduser, $dateLimit1, $dateLimit2);

                $dateLimit3 = date('Y-m-d');
                $tasksJson3 = $dbAccess->getHoTempo($iduser, $dateLimit2, $dateLimit3);
                $tasksJson4 = $dbAccess->getCategorys($iduser);

                $this->container->logger->info('Failed! Riendirected /sneat-1.0.0/html/NewCategory.phtml');
                return $this->container->view->render($response, '/sneat-1.0.0/html/NewCategory.phtml', [
                    'tasksJson1' => json_encode($tasksJson1),
                    'tasksJson2' => json_encode($tasksJson2),
                    'tasksJson3' => json_encode($tasksJson3),
                    'tasksJson4' => json_encode($tasksJson4)
                ]);
            
        } else {
                
                $categoria = str_replace("'", "**", $categoria);
                $stmt = $dbAccess->getInsertCategory($iduser, $categoria);
                if ($stmt->rowCount() > 0) {
                    return $response->withRedirect('/public/');
                } 
        }
    } catch (\Exception $e) {
        $this->container->logger->error($e->getMessage(), ['exception' => $e]);
    }
    }



    public function getSignIn($request, $response)
    {
        return $this->container->view->render($response, 'sneat-1.0.0/html/Login.phtml');
    }

    public function postSignIn($request, $response)
    {
        try {
            $email = $request->getParam('email');
            $palavrapasse = $request->getParam('password');
            $dbAccess = new HomeDbAccess($this->container);

            $erroPasse = 0;
            $erroEmail = 0;

            if (empty($email)) {
                $erroEmail = 1;
            }

            if (empty($palavrapasse)) {
                $erroPasse = 1;
            }

            if (strpos($palavrapasse, "'") !== false) {
                $erroPasse = 1;
            }

            if (strpos($email, "'") !== false) {
                $erroEmail = 1;
            }

            if ($erroPasse == 0 && $erroEmail == 0) {
                
                $stmt = $dbAccess->getLogin($email);
                $user = $stmt->fetch();

                if ($user && $user['password'] === $palavrapasse) {
                    $_SESSION['Id_User'] = $user['id_user'];
                    return $response->withRedirect('/public/');
                } else {
                    $erroPasse = 1;
                    $erroEmail = 1;
                    $this->container->logger->info('Failed! Riendirected /sneat-1.0.0/html/Login.phtml');
                    return $this->container->view->render($response, 'sneat-1.0.0/html/Login.phtml', [
                        'erroSenha' => $erroPasse,
                        'erroEmail' => $erroEmail
                    ]);
                }

            } else {
                $this->container->logger->info('Failed! Riendirected /sneat-1.0.0/html/Login.phtml');
                return $this->container->view->render($response, 'sneat-1.0.0/html/Login.phtml', [
                    'erroSenha' => $erroPasse,
                    'erroEmail' => $erroEmail
                ]);
            }
        } catch (\Exception $e) {
            $this->container->logger->error($e->getMessage(), ['exception' => $e]);
        }
    }

    public function getSignUp($request, $response)
    {
        return $this->container->view->render($response, 'sneat-1.0.0/html/Register.phtml');
    }

    public function postSignUp($request, $response)
    {
        try {
            $nome = $request->getParam('nomeutente');
            $email = $request->getParam('e-mail');
            $palavrapasse = $request->getParam('password');
            $nome = str_replace("'", "**", $nome);

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

            if (!preg_match('/[A-Z]/', $palavrapasse) || !preg_match('/[a-z]/', $palavrapasse) || !preg_match('/[0-9]/', $palavrapasse)) {
                $erroSenha = 1;
            }
            $dbAccess = new HomeDbAccess($this->container);

            $stmt = $dbAccess->getEmailValidation($email);
            $count = $stmt->fetchColumn();

            if ($count > 0) {
                $erroEmail = 1;
            }


            if (
                $erroNome == 0 &&
                $erroEmail == 0 &&
                $erroSenha == 0
            ) {

                $stmt = $dbAccess->getRegister($email, $nome, $palavrapasse);

                if ($stmt->rowCount() > 0) {
                    $idUsuario = $this->container->db->lastInsertId();

                    $_SESSION['Id_User'] = $idUsuario;

                    return $response->withRedirect('/public/');
                } else {
                    echo "Erro ao inserir registro.";
                }
            } else {
                $this->container->logger->info('Failed! Riendirected /sneat-1.0.0/html/Register.phtml');
                return $this->container->view->render($response, 'sneat-1.0.0/html/Register.phtml', [
                    'erroNome' => $erroNome,
                    'erroEmail' => $erroEmail,
                    'erroSenha' => $erroSenha
                ]);
            }
        } catch (\Exception $e) {
            $this->container->logger->error($e->getMessage(), ['exception' => $e]);
        }

    }

    public function getProfilo($request, $response)
    {

        $iduser = $_SESSION['Id_User'];
        $dbAccess = new HomeDbAccess($this->container);

        try {
            
            $dateLimit1 = date('Y-m-d', strtotime('+3 days'));
            $tasksJson1 = $dbAccess->getAltaUrgenza($iduser, $dateLimit1);

            $dateLimit2 = date('Y-m-d', strtotime('+1 week'));
            $tasksJson2 = $dbAccess->getNormale($iduser, $dateLimit1, $dateLimit2);

            $dateLimit3 = date('Y-m-d');
            $tasksJson3 = $dbAccess->getHoTempo($iduser, $dateLimit2, $dateLimit3);
            $tasksJson4 = $dbAccess->getCategorys($iduser);

            $userData = $dbAccess->getProfilo($iduser);

            $this->container->logger->info('Failed! Riendirected /sneat-1.0.0/html/Profilo.phtml');

            return $this->container->view->render($response, '/sneat-1.0.0/html/Profilo.phtml', [
                'tasksJson1' => json_encode($tasksJson1),
                'tasksJson2' => json_encode($tasksJson2),
                'tasksJson3' => json_encode($tasksJson3),
                'tasksJson4' => json_encode($tasksJson4),
                'userData' => $userData
            ]);
        } catch (\Exception $e) {
            $this->container->logger->error($e->getMessage(), ['exception' => $e]);
        }

    }
    public function postProfilo($request, $response)
    {
        try {
            $iduser = $_SESSION['Id_User'];
            $nome = $request->getParam('nome');
            $dbAccess = new HomeDbAccess($this->container);
            if (empty($nome)) {


                $dateLimit1 = date('Y-m-d', strtotime('+3 days'));
                $tasksJson1 = $dbAccess->getAltaUrgenza($iduser, $dateLimit1);

                $dateLimit2 = date('Y-m-d', strtotime('+1 week'));
                $tasksJson2 = $dbAccess->getNormale($iduser, $dateLimit1, $dateLimit2);

                $dateLimit3 = date('Y-m-d');
                $tasksJson3 = $dbAccess->getHoTempo($iduser, $dateLimit2, $dateLimit3);
                $tasksJson4 = $dbAccess->getCategorys($iduser);

                $userData = $dbAccess->getProfilo($iduser);
                

                return $this->container->view->render($response, '/sneat-1.0.0/html/Profilo.phtml', [
                    'tasksJson1' => json_encode($tasksJson1),
                    'tasksJson2' => json_encode($tasksJson2),
                    'tasksJson3' => json_encode($tasksJson3),
                    'tasksJson4' => json_encode($tasksJson4),
                    'userData' => $userData
                ]);

            } else {
                $nome = str_replace("'", "**", $nome);
                $stmt5 = $dbAccess->getAlterName($iduser);
                $stmt5->execute(['nome' => $nome, 'iduser' => $iduser]);

                $dateLimit1 = date('Y-m-d', strtotime('+3 days'));
                $tasksJson1 = $dbAccess->getAltaUrgenza($iduser, $dateLimit1);

                $dateLimit2 = date('Y-m-d', strtotime('+1 week'));
                $tasksJson2 = $dbAccess->getNormale($iduser, $dateLimit1, $dateLimit2);

                $dateLimit3 = date('Y-m-d');
                $tasksJson3 = $dbAccess->getHoTempo($iduser, $dateLimit2, $dateLimit3);
                $tasksJson4 = $dbAccess->getCategorys($iduser);

                $userData = $dbAccess->getProfilo($iduser);

                return $this->container->view->render($response, '/sneat-1.0.0/html/Profilo.phtml', [
                    'tasksJson1' => json_encode($tasksJson1),
                    'tasksJson2' => json_encode($tasksJson2),
                    'tasksJson3' => json_encode($tasksJson3),
                    'tasksJson4' => json_encode($tasksJson4),
                    'userData' => $userData
                ]);
            }
        } catch (\Exception $e) {
            $this->container->logger->error($e->getMessage(), ['exception' => $e]);
        }

    }

    public function getTask($request, $response)
    {
    }
    public function postTask($request, $response)
    {
        $iduser = $_SESSION['Id_User'];
        $idtask = $request->getParam('id_task');

        try {
            $dbAccess = new HomeDbAccess($this->container);
            $dateLimit1 = date('Y-m-d', strtotime('+3 days'));
            $tasksJson1 = $dbAccess->getAltaUrgenza($iduser, $dateLimit1);

            $dateLimit2 = date('Y-m-d', strtotime('+1 week'));
            $tasksJson2 = $dbAccess->getNormale($iduser, $dateLimit1, $dateLimit2);

            $dateLimit3 = date('Y-m-d');
            $tasksJson3 = $dbAccess->getHoTempo($iduser, $dateLimit2, $dateLimit3);
            $tasksJson4 = $dbAccess->getCategorys($iduser);
            $task5 = $dbAccess->getTaskDetails($iduser, $idtask);

            $queryCheckComplete = $dbAccess->getCheckCompleted($iduser, $idtask);

            $isComplete = $queryCheckComplete->fetchColumn();

            if ($isComplete == 1) {
                return $this->container->view->render($response, '/sneat-1.0.0/html/TaskCompleted.phtml', [
                    'tasksJson1' => json_encode($tasksJson1),
                    'tasksJson2' => json_encode($tasksJson2),
                    'tasksJson3' => json_encode($tasksJson3),
                    'tasksJson4' => json_encode($tasksJson4),
                    'task5' => json_encode($task5)
                ]);
            } else {
                $taskData = $dbAccess->getCheckCompletedData($iduser, $idtask);
                if ($taskData) {
                    $completed = $taskData['Completed'];
                    $finalDate = $taskData['final_date'];

                    // Obtém a data atual
                    $currentDate = date('Y-m-d');

                    if ($completed == 0 && $finalDate < $currentDate) {
                        return $this->container->view->render($response, '/sneat-1.0.0/html/TaskCompleted.phtml', [
                            'tasksJson1' => json_encode($tasksJson1),
                            'tasksJson2' => json_encode($tasksJson2),
                            'tasksJson3' => json_encode($tasksJson3),
                            'tasksJson4' => json_encode($tasksJson4),
                            'task5' => json_encode($task5)
                        ]);
                    } else {
                        return $this->container->view->render($response, '/sneat-1.0.0/html/Task.phtml', [
                            'tasksJson1' => json_encode($tasksJson1),
                            'tasksJson2' => json_encode($tasksJson2),
                            'tasksJson3' => json_encode($tasksJson3),
                            'tasksJson4' => json_encode($tasksJson4),
                            'task5' => json_encode($task5)
                        ]);
                    }
                }
            }

        } catch (\Exception $e) {
            $this->container->logger->error($e->getMessage(), ['exception' => $e]);
        }
    }

    public function getCompletTask($request, $response)
    {
    }
    public function postCompletTask($request, $response)
    {
        try {

            $iduser = $_SESSION['Id_User'];
            $idtask = $request->getParam('idtask');
            $dbAccess = new HomeDbAccess($this->container);
            $stmt5 = $dbAccess->getCompleteTask($iduser);
            $stmt5->execute(['iduser' => $iduser, 'idtask' => $idtask]);
            return $response->withRedirect('/public/');

        } catch (\Exception $e) {
            $this->container->logger->error($e->getMessage(), ['exception' => $e]);
        }
    }

    public function getDeletTask($request, $response)
    {
    }
    public function postDeletTask($request, $response)
    {
        try {
            $iduser = $_SESSION['Id_User'];
            $idtask = $request->getParam('idtask');

            $dbAccess = new HomeDbAccess($this->container);
            $stmt5 = $dbAccess->getDeleteTaskFiles($iduser, $idtask);
            $stmt5->execute([':iduser' => $iduser, ':idtask' => $idtask]);
            $filesResult = $stmt5->fetchAll(\PDO::FETCH_ASSOC);

            if ($filesResult) {
                $filesString = $filesResult[0]['File'];
                $filesArray = explode('ºº', $filesString);

                foreach ($filesArray as $file) {
                    $filePath = __DIR__ . '/../../public/' . $file;
                    if (file_exists($filePath)) {
                        if (unlink($filePath)) {
                            $this->container->logger->info("Deleted file: " . $filePath);
                        } else {
                            $this->container->logger->error("Failed to delete file: " . $filePath);
                        }
                    } else {
                        $this->container->logger->warning("File not found: " . $filePath);
                    }
                }
            }

            // Delete the task
            $stmt5 = $dbAccess->getDeleteTask();
            $stmt5->execute([':iduser' => $iduser, ':idtask' => $idtask]);

            return $response->withRedirect('/public/');
        } catch (\Exception $e) {
            $this->container->logger->error($e->getMessage(), ['exception' => $e]);
            return $response->withRedirect('/public/');
        }
    }



    public function getLogout($request, $response)
    {

        session_destroy();
        return $response->withRedirect('/public/');
    }
    public function postLogout($request, $response)
    {
    }

    public function getDeleteCategory($request, $response)
    {
    }
    public function postDeleteCategory($request, $response)
    {

        $iduser = $_SESSION['Id_User'];
        $idcategory = $request->getParam('idcategory');
        try {
            $dbAccess = new HomeDbAccess($this->container);
            $stmt5 = $dbAccess->getDeleteCategory($iduser, $idcategory);
            $stmt5->execute(['idcategory' => $idcategory, 'iduser' => $iduser]);
            return $response->withRedirect('/public/');

        } catch (\Exception $e) {
            $this->container->logger->error($e->getMessage(), ['exception' => $e]);
        }
    }

    public function getCategory($request, $response)
    {
    }
    public function postCategory($request, $response)
    {
        $iduser = $_SESSION['Id_User'];
        $idcategory = $request->getParam('category');

        try {
            $dbAccess = new HomeDbAccess($this->container);
            $dateLimit1 = date('Y-m-d', strtotime('+3 days'));
            $tasksJson1 = $dbAccess->getAltaUrgenza($iduser, $dateLimit1);

            $dateLimit2 = date('Y-m-d', strtotime('+1 week'));
            $tasksJson2 = $dbAccess->getNormale($iduser, $dateLimit1, $dateLimit2);

            $dateLimit3 = date('Y-m-d');
            $tasksJson3 = $dbAccess->getHoTempo($iduser, $dateLimit2, $dateLimit3);
            $tasksJson4 = $dbAccess->getCategorys($iduser);
            $tasksJson5 = $dbAccess->getCategoryDetails($iduser, $idcategory);

            return $this->container->view->render($response, '/sneat-1.0.0/html/Category.phtml', [
                'tasksJson1' => json_encode($tasksJson1),
                'tasksJson2' => json_encode($tasksJson2),
                'tasksJson3' => json_encode($tasksJson3),
                'tasksJson4' => json_encode($tasksJson4),
                'tasksJson5' => json_encode($tasksJson5),
            ]);
        } catch (\Exception $e) {
            $this->container->logger->error($e->getMessage(), ['exception' => $e]);
        }
    }






}