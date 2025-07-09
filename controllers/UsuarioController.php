<?php
require_once '../config/db.php';
require_once '../models/Usuario.php';

class UsuarioController {
    private $db;
    private $model;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->model = new Usuario($this->db);
    }

    public function listAll() {
        return $this->model->getAll();
    }

    public function getRoles() {
        return $this->model->getRoles();
    }

    public function add($nombre, $correo, $contrasena, $rol) {
        $this->model->nombre = $nombre;
        $this->model->correo = $correo;
        $this->model->contrasena = $contrasena;
        $this->model->rol = $rol;

        return $this->model->create();
    }

    public function update($id_usuario, $nombre, $correo, $contrasena, $rol) {
        $this->model->id_usuario = $id_usuario;
        $this->model->nombre = $nombre;
        $this->model->correo = $correo;
        $this->model->contrasena = $contrasena;
        $this->model->rol = $rol;

        return $this->model->update();
    }
    public function delete($id) {
        return $this->model->delete($id);
    }
    
}
?>
