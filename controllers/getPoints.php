<?php
require_once '../config/db.php';

header('Content-Type: application/json');

// Conectar a la base de datos
$database = new Database();
$db = $database->getConnection();

// Verificar si se enviaron categorías
$categories = isset($_POST['categories']) ? $_POST['categories'] : [];

// Si no hay categorías seleccionadas, devolver todos los puntos
if (empty($categories)) {
    $query = "SELECT * FROM centros_logisticos";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $points = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($points);
    exit;
}

// Crear la consulta SQL para filtrar por categorías seleccionadas
$placeholders = implode(',', array_fill(0, count($categories), '?'));
$query = "SELECT * FROM centros_logisticos WHERE id_categoria IN ($placeholders)";
$stmt = $db->prepare($query);

// Ejecutar la consulta con las categorías seleccionadas
$stmt->execute($categories);
$points = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Enviar los puntos filtrados como respuesta JSON
echo json_encode($points);
exit;
