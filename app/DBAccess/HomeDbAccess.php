<?php
namespace App\DBAccess;

class HomeDbAccess
{
    protected $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function getAltaUrgenza($iduser, $dateLimit1)
    {
        $query1 = "SELECT * FROM tasks WHERE final_date <= :dateLimit1 AND id_user = :iduser AND Completed='0' AND final_date >= CURDATE() LIMIT 4";
        $stmt1 = $this->container->db->prepare($query1);
        $stmt1->execute(['dateLimit1' => $dateLimit1, 'iduser' => $iduser]);
        $tasks1 = $stmt1->fetchAll(\PDO::FETCH_ASSOC);
        return $tasks1;
    }

    public function getNormale($iduser, $dateLimit1, $dateLimit2)
    {
        $query2 = "SELECT * FROM tasks WHERE final_date > :dateLimit1 AND final_date <= :dateLimit2 AND id_user = :iduser AND Completed='0' AND final_date >= CURDATE() LIMIT 4";
        $stmt2 = $this->container->db->prepare($query2);
        $stmt2->execute(['dateLimit1' => $dateLimit1, 'dateLimit2' => $dateLimit2, 'iduser' => $iduser]);
        $tasks2 = $stmt2->fetchAll(\PDO::FETCH_ASSOC);
        return $tasks2;
    }

    public function getHoTempo($iduser, $dateLimit2, $dateLimit3)
    {
        $query3 = "SELECT * FROM tasks WHERE final_date > :dateLimit2 AND final_date > :dateLimit3 AND id_user = :iduser AND Completed='0' AND final_date >= CURDATE() LIMIT 4";
        $stmt3 = $this->container->db->prepare($query3);
        $stmt3->execute(['dateLimit2' => $dateLimit2, 'dateLimit3' => $dateLimit3, 'iduser' => $iduser]);
        $tasks3 = $stmt3->fetchAll(\PDO::FETCH_ASSOC);
        return $tasks3;

    }

    public function getTasks($iduser)
    {
        $query4 = "SELECT * FROM tasks WHERE id_user = '$iduser' AND Completed='0' AND final_date >= CURDATE()";
        $stmt4 = $this->container->db->query($query4);
        $tasks4 = $stmt4->fetchAll(\PDO::FETCH_ASSOC);
        return $tasks4;
    }
    public function getCategorys($iduser)
    {
        $query5 = "SELECT * FROM categorys WHERE id_user = :iduser";
        $stmt5 = $this->container->db->prepare($query5);
        $stmt5->execute(['iduser' => $iduser]);
        $tasks5 = $stmt5->fetchAll(\PDO::FETCH_ASSOC);
        return $tasks5;
    }

    public function getTasksCompleted($iduser)
    {
        $query6 = "SELECT * FROM tasks WHERE id_user = '$iduser' AND Completed='1'";
        $stmt6 = $this->container->db->query($query6);
        $tasks6 = $stmt6->fetchAll(\PDO::FETCH_ASSOC);
        return $tasks6;
    }

    public function getTasksIncompleted($iduser)
    {
        $query7 = "SELECT * FROM tasks WHERE id_user = '$iduser' AND Completed='0' AND final_date < CURDATE()";
        $stmt7 = $this->container->db->query($query7);
        $tasks7 = $stmt7->fetchAll(\PDO::FETCH_ASSOC);
        return $tasks7;
    }

    public function getProfilo($iduser)
    {
        $query5 = "SELECT * FROM users WHERE id_user = :iduser";
        $stmt5 = $this->container->db->prepare($query5);
        $stmt5->execute(['iduser' => $iduser]);
        $userData = $stmt5->fetch(\PDO::FETCH_ASSOC);
        return $userData;
    }

    public function getTaskDetails($iduser, $idtask)
    {
        $query5 = "SELECT t.*, c.name AS category_name 
           FROM tasks t 
           JOIN categorys c ON t.category = c.id_category 
           WHERE t.id_task = :idtask AND t.id_user = :iduser";
        $stmt5 = $this->container->db->prepare($query5);
        $stmt5->execute(['idtask' => $idtask, 'iduser' => $iduser]);
        $task5 = $stmt5->fetch(\PDO::FETCH_ASSOC);
        return $task5;
    }

    public function getCheckCompleted($iduser, $idtask)
    {
        $queryCheckComplete = "SELECT Completed FROM tasks WHERE id_task = :idtask AND id_user = :iduser";
        $stmtCheckComplete = $this->container->db->prepare($queryCheckComplete);
        $stmtCheckComplete->execute(['idtask' => $idtask, 'iduser' => $iduser]);
        return $stmtCheckComplete;

    }

    public function getCheckCompletedData($iduser, $idtask)
    {
        $queryCheckComplete = "SELECT Completed, final_date FROM tasks WHERE id_task = :idtask AND id_user = :iduser";
        $stmtCheckComplete = $this->container->db->prepare($queryCheckComplete);
        $stmtCheckComplete->execute(['idtask' => $idtask, 'iduser' => $iduser]);
        $taskData = $stmtCheckComplete->fetch(\PDO::FETCH_ASSOC);
        return $taskData;

    }

    public function getCategoryDetails($iduser, $idcategory)
    {
        $query5 = "SELECT t.*, c.name AS category_name, u.*
           FROM tasks t
           JOIN categorys c ON t.category = c.id_category
           JOIN users u ON t.id_user = u.id_user
           WHERE t.category = :idcategory";
        $stmt5 = $this->container->db->prepare($query5);
        $stmt5->execute(['idcategory' => $idcategory]);
        $tasksByCategory = $stmt5->fetchAll(\PDO::FETCH_ASSOC);
        return $tasksByCategory;

    }

    public function getInsertTask($iduser, $categoria, $avidita, $data, $titolo, $filesArray)
    {
        try {

            $sql = "INSERT INTO tasks (category, description, final_date, title, id_user, Completed, File) 
                VALUES (:category, :descrito, :dat, :title, :id_user, 0, :files)";
            $stmt = $this->container->db->prepare($sql);

            $stmt->bindParam(':category', $categoria);
            $stmt->bindParam(':descrito', $avidita);
            $stmt->bindParam(':dat', $data);
            $stmt->bindParam(':title', $titolo);
            $stmt->bindParam(':id_user', $iduser);
            $stmt->bindParam(':files', $filesArray);

            $stmt->execute();

            return $stmt;
        } catch (\Exception $e) {
            $this->container->logger->info($e->getMessage(), ['exception' => $e]);
        }
    }

    public function getInsertCategory($iduser, $categoria)
    {
        $sql = "INSERT INTO categorys (id_user, name) VALUES (:id, :category)";
        $stmt = $this->container->db->prepare($sql);
        $stmt->execute(['category' => $categoria, 'id' => $iduser]);


        return $stmt;

    }

    public function getLogin($email)
    {
        $sql = "SELECT id_user, password FROM users WHERE email=:email";
        $stmt = $this->container->db->prepare($sql);
        $stmt->execute(['email' => $email]);
        return $stmt;

    }

    public function getRegister($email, $nome, $palavrapasse)
    {
        $sql = "INSERT INTO users (email, name, password) VALUES (:email, :nome, :palavrapasse)";
        $stmt = $this->container->db->prepare($sql);

        $stmt->execute(['email' => $email, 'nome' => $nome, 'palavrapasse' => $palavrapasse]);
        return $stmt;

    }

    public function getEmailValidation($email)
    {
        $sql = "SELECT COUNT(*) FROM users WHERE email = :email";
        $stmt = $this->container->db->prepare($sql);
        $stmt->execute(['email' => $email]);
        return $stmt;

    }

    public function getAlterName($iduser)
    {
        $query5 = "Update users SET name=:nome WHERE id_user=:iduser";
        $stmt5 = $this->container->db->prepare($query5);

        return $stmt5;

    }

    public function getCompleteTask($iduser)
    {
        $query5 = "UPDATE tasks SET Completed='1' WHERE id_user = :iduser AND id_task = :idtask";
        $stmt5 = $this->container->db->prepare($query5);

        return $stmt5;

    }

    public function getDeleteCategory($iduser, $idcategory)
    {
        $query4 = "DELETE FROM  tasks WHERE category = :idcategory AND id_user = :iduser";
        $stmt4 = $this->container->db->prepare($query4);
        $stmt4->execute(['idcategory' => $idcategory, 'iduser' => $iduser]);

        $query5 = "DELETE FROM  categorys WHERE id_category = :idcategory AND id_user = :iduser";
        $stmt5 = $this->container->db->prepare($query5);

        return $stmt5;

    }

    public function getDeleteTask()
    {
        $query = "DELETE FROM tasks WHERE id_task = :idtask AND id_user = :iduser";
        $stmt = $this->container->db->prepare($query);
        return $stmt;
    }

    public function getDeleteTaskFiles($iduser, $idtask)
    {
        $query5 = "SELECT File FROM tasks WHERE id_task = :idtask AND id_user = :iduser";
        $stmt5 = $this->container->db->prepare($query5);
        return $stmt5;
    }

}
