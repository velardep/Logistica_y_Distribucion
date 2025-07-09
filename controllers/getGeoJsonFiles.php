<?php
$folderPath = realpath('../capas'); // Ruta absoluta a la carpeta de capas
$publicPath = '/Sistema_Logistica_Distribucion/capas'; // Prefijo de ruta pública
$geoJsonFiles = [];

if ($folderPath && is_dir($folderPath)) {
    $files = scandir($folderPath);
    foreach ($files as $file) {
        if (pathinfo($file, PATHINFO_EXTENSION) === 'geojson') {
            $geoJsonFiles[] = $publicPath . '/' . $file; // Generar ruta pública relativa
        }
    }
}

header('Content-Type: application/json');
echo json_encode($geoJsonFiles);

