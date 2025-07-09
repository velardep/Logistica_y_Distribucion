<?php
class Ruta {
    private $conn;
    private $table_name = "Rutas";

    public $id_ruta;
    public $id_centro_origen;
    public $id_centro_destino;
    public $distancia;
    public $tiempo_estimado;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAllWithCenters() {
        $query = "
            SELECT 
            r.id_ruta, 
            r.id_centro_origen, 
            r.id_centro_destino, 
            r.distancia, 
            r.tiempo_estimado, 
            c1.nombre AS origen_nombre, 
            c2.nombre AS destino_nombre
        FROM " . $this->table_name . " r
        JOIN Centros_Logisticos c1 ON r.id_centro_origen = c1.id_centro
        JOIN Centros_Logisticos c2 ON r.id_centro_destino = c2.id_centro
        ORDER BY r.id_ruta ASC

        ";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create() {
        $query = "
            INSERT INTO rutas 
            (id_centro_origen, id_centro_destino, distancia, tiempo_estimado) 
            VALUES (:id_centro_origen, :id_centro_destino, :distancia, :tiempo_estimado)
        ";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id_centro_origen', $this->id_centro_origen, PDO::PARAM_INT);
        $stmt->bindParam(':id_centro_destino', $this->id_centro_destino, PDO::PARAM_INT);
        $stmt->bindParam(':distancia', $this->distancia, PDO::PARAM_STR);
        $stmt->bindParam(':tiempo_estimado', $this->tiempo_estimado, PDO::PARAM_STR);

        return $stmt->execute();
    }

    public function update() {
        $query = "
            UPDATE " . $this->table_name . " 
            SET id_centro_origen = :id_centro_origen, 
                id_centro_destino = :id_centro_destino, 
                distancia = :distancia, 
                tiempo_estimado = :tiempo_estimado
            WHERE id_ruta = :id_ruta
        ";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":id_ruta", $this->id_ruta);
        $stmt->bindParam(":id_centro_origen", $this->id_centro_origen);
        $stmt->bindParam(":id_centro_destino", $this->id_centro_destino);
        $stmt->bindParam(":distancia", $this->distancia);
        $stmt->bindParam(":tiempo_estimado", $this->tiempo_estimado);

        return $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id_ruta = :id_ruta";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id_ruta", $id);

        return $stmt->execute();
    }
}
?>
