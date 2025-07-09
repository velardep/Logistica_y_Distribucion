<?php
class CentroLogistico {
    private $conn;
    private $table_name = "Centros_Logisticos";

    public $id_centro;
    public $nombre;
    public $id_categoria;
    public $descripcion; // Nuevo campo
    public $longitud;
    public $latitud;
    public $horario_operacion;
    public $capacidad;
    public $tipos_recursos;
    public $zona_cobertura;
    public $contacto;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAllWithCategory() {
        $query = "
            SELECT cl.id_centro, cl.nombre AS centro_nombre, c.nombre AS categoria_nombre, 
                   cl.descripcion, cl.longitud, cl.latitud, cl.horario_operacion, 
                   cl.capacidad, cl.tipos_recursos, cl.zona_cobertura, cl.contacto
            FROM " . $this->table_name . " cl
            JOIN Categorias c ON cl.id_categoria = c.id_categoria
            ORDER BY cl.id_centro DESC
        ";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . "  
          (nombre, id_categoria, descripcion, longitud, latitud, horario_operacion, capacidad, tipos_recursos, zona_cobertura, contacto) 
          VALUES (:nombre, :id_categoria, :descripcion, :longitud, :latitud, :horario_operacion, :capacidad, :tipos_recursos, :zona_cobertura, :contacto)";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":id_categoria", $this->id_categoria);
        $stmt->bindParam(":descripcion", $this->descripcion); // Nuevo campo
        $stmt->bindParam(":longitud", $this->longitud);
        $stmt->bindParam(":latitud", $this->latitud);
        $stmt->bindParam(":horario_operacion", $this->horario_operacion);
        $stmt->bindParam(":capacidad", $this->capacidad);
        $stmt->bindParam(":tipos_recursos", $this->tipos_recursos);
        $stmt->bindParam(":zona_cobertura", $this->zona_cobertura);
        $stmt->bindParam(":contacto", $this->contacto);

        return $stmt->execute();
    }

    public function update() {
        $query = "
            UPDATE " . $this->table_name . " 
            SET nombre=:nombre, id_categoria=:id_categoria, descripcion=:descripcion, 
                longitud=:longitud, latitud=:latitud, horario_operacion=:horario_operacion, 
                capacidad=:capacidad, tipos_recursos=:tipos_recursos, 
                zona_cobertura=:zona_cobertura, contacto=:contacto
            WHERE id_centro=:id_centro
        ";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":id_categoria", $this->id_categoria);
        $stmt->bindParam(":descripcion", $this->descripcion); // Nuevo campo
        $stmt->bindParam(":longitud", $this->longitud);
        $stmt->bindParam(":latitud", $this->latitud);
        $stmt->bindParam(":horario_operacion", $this->horario_operacion);
        $stmt->bindParam(":capacidad", $this->capacidad);
        $stmt->bindParam(":tipos_recursos", $this->tipos_recursos);
        $stmt->bindParam(":zona_cobertura", $this->zona_cobertura);
        $stmt->bindParam(":contacto", $this->contacto);
        $stmt->bindParam(":id_centro", $this->id_centro);

        return $stmt->execute();
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id_centro=:id_centro";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id_centro", $this->id_centro);
        return $stmt->execute();
    }
}
?>
