<?php
require_once '../config/db.php';
require_once '../models/Ruta.php';

class RutaController {
    private $db;
    private $model;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->model = new Ruta($this->db);
    }

    public function listAll() {
        return $this->model->getAllWithCenters();
    }

    public function create($data) {
        $this->model->id_centro_origen = $data['id_centro_origen'];
        $this->model->id_centro_destino = $data['id_centro_destino'];
        $this->model->distancia = $data['distancia'];
        $this->model->tiempo_estimado = $data['tiempo_estimado'];

        return $this->model->create();
    }

    public function update($data) {
        $this->model->id_ruta = $data['id_ruta'];
        $this->model->id_centro_origen = $data['id_centro_origen'];
        $this->model->id_centro_destino = $data['id_centro_destino'];
        $this->model->distancia = $data['distancia'];
        $this->model->tiempo_estimado = $data['tiempo_estimado'];

        return $this->model->update();
    }

    public function delete($id) {
        return $this->model->delete($id);
    }
}
?>
