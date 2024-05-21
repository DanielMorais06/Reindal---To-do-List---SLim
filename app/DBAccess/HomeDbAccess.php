<?php
namespace App\DBAccess;

use App\Controllers\Controller;

class HomeDbAccess extends Controller {
    protected $container;

    public function __construct($container) {
        $this->container = $container;
    }

    public function getTasksDueInThreeDays($iduser) {
        $dateLimit1 = date('Y-m-d', strtotime('+3 days'));
        $query1 = "SELECT * FROM tasks WHERE final_date <= :dateLimit1 AND id_user = :iduser AND Completed='0' AND final_date >= CURDATE() LIMIT 4";
        $stmt1 = $this->container->db->prepare($query1); 
        $stmt1->execute(['dateLimit1' => $dateLimit1, 'iduser' => $iduser]);
        $tasks1 = $stmt1->fetchAll(\PDO::FETCH_ASSOC);
        return $tasks1;
    }
}
