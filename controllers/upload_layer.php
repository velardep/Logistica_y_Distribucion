<?php
// Configuración del directorio donde se guardarán los archivos
$targetDir = '../capas/'; // Asegúrate de que esta ruta sea la correcta
$response = ['success' => false, 'message' => '', 'geoJson' => null];

// Verificar si hay un archivo cargado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['layerFile'])) {
    $targetFile = $targetDir . basename($_FILES['layerFile']['name']);  // Ruta completa del archivo

    // Validar el tipo de archivo (GeoJSON o JSON)
    $fileType = pathinfo($targetFile, PATHINFO_EXTENSION);
    if ($fileType !== 'geojson' && $fileType !== 'json') {
        $response['message'] = "Solo se permiten archivos GeoJSON (.geojson o .json).";
        echo json_encode($response);
        exit;
    }

    // Mover el archivo desde la ubicación temporal al directorio de destino
    if (move_uploaded_file($_FILES['layerFile']['tmp_name'], $targetFile)) {
        // Cargar el archivo GeoJSON para asegurar que es válido
        $geoJson = file_get_contents($targetFile);
        $decodedGeoJson = json_decode($geoJson, true);

        // Verificar que el archivo sea un GeoJSON válido
        if (json_last_error() === JSON_ERROR_NONE && isset($decodedGeoJson['type']) && $decodedGeoJson['type'] === 'FeatureCollection') {
            $response['success'] = true;
            $response['geoJson'] = $decodedGeoJson; // Enviar el GeoJSON como respuesta
            $response['message'] = "Capa cargada correctamente.";
        } else {
            // Si el archivo no es un GeoJSON válido
            unlink($targetFile); // Borrar el archivo corrupto
            $response['message'] = "El archivo no es un GeoJSON válido.";
        }
    } else {
        $response['message'] = "Hubo un error al mover el archivo.";
    }
} else {
    $response['message'] = "No se ha cargado ningún archivo.";
}

// Responder en formato JSON
echo json_encode($response);
?>
