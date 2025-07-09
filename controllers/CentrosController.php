<?php
require_once '../config/db.php';

class CentrosController {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getPoints() {
        try {
            $query = "SELECT cl.*, c.nombre as categoria_nombre 
                      FROM centros_logisticos cl
                      INNER JOIN categorias c ON cl.id_categoria = c.id_categoria";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $points = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($points);
        } catch (PDOException $e) {
            echo json_encode(["error" => $e->getMessage()]);
        }
    }
}

if (isset($_GET['action']) && $_GET['action'] === 'getPoints') {
    $controller = new CentrosController();
    $controller->getPoints();
}
?>
