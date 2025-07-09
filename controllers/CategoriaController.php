<?php
require_once '../config/db.php';
require_once '../models/Categoria.php';

class CategoriaController {
    private $db;
    private $model;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->model = new Categoria($this->db);
    }

    public function listAll() {
        return $this->model->getAll();
    }

    public function add($nombre, $descripcion) {
        $this->model->nombre = $nombre;
        $this->model->descripcion = $descripcion;
        return $this->model->create();
    }

    public function update($id_categoria, $nombre, $descripcion) {
        $this->model->id_categoria = $id_categoria;
        $this->model->nombre = $nombre;
        $this->model->descripcion = $descripcion;
        return $this->model->update();
    }

    public function delete($id_categoria) {
        $this->model->id_categoria = $id_categoria;
        return $this->model->delete();
    }
}
?>
