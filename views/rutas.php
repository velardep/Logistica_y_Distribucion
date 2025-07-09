<?php
require_once '../controllers/RutaController.php';
require_once '../controllers/CentroLogisticoController.php';

$rutaController = new RutaController();
$centroController = new CentroLogisticoController();

$rutas = $rutaController->listAll();
$centros = $centroController->listAll();

// Manejo de acciones
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'add') {
            $rutaController->create($_POST);
        } elseif ($_POST['action'] === 'edit') {
            $rutaController->update($_POST);
        } elseif ($_POST['action'] === 'delete') {
            $rutaController->delete($_POST['id_ruta']);
        }
        header("Location: rutas.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Rutas</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome para Íconos -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: url('../images/5082238.jpg') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Poppins', sans-serif;
            color: #333;
        }

        .container {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.15);
            padding: 20px;
            margin-top: 30px;
        }

        h1 {
            text-align: center;
            font-weight: bold;
            color: #28a745;
            margin-bottom: 20px;
        }

        .table {
            margin-top: 20px;
        }

        .table th {
            background-color: #28a745;
            color: white;
        }

        .btn-custom {
            background-color: #28a745;
            color: white;
            font-weight: bold;
        }

        .btn-custom:hover {
            background-color: #218838;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2);
        }

        .btn-danger:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1><i class="fas fa-road"></i> Gestión de Rutas</h1>
        <div class="d-flex justify-content-between mb-3">
            <button class="btn btn-primary btn-custom" onclick="goBack()"><i class="fas fa-arrow-left"></i> Volver</button>
            <button class="btn btn-success btn-custom" data-bs-toggle="modal" data-bs-target="#modal" onclick="openModal('add')"><i class="fas fa-plus-circle"></i> Agregar Ruta</button>
        </div>
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Centro de Origen</th>
                    <th>Centro de Destino</th>
                    <th>Distancia (km)</th>
                    <th>Tiempo Estimado (hr:min)</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rutas as $ruta): ?>
                    <tr id="row-<?= $ruta['id_ruta'] ?>">
                        <td><?= $ruta['id_ruta'] ?></td>
                        <td><?= htmlspecialchars($ruta['origen_nombre'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($ruta['destino_nombre'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($ruta['distancia'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($ruta['tiempo_estimado'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td>
                            <button 
                                class="btn btn-warning btn-sm" 
                                data-bs-toggle="modal" 
                                data-bs-target="#modal" 
                                onclick="openEditModal(<?= $ruta['id_ruta'] ?>, '<?= htmlspecialchars($ruta['origen_nombre'], ENT_QUOTES, 'UTF-8') ?>', '<?= htmlspecialchars($ruta['destino_nombre'], ENT_QUOTES, 'UTF-8') ?>', '<?= htmlspecialchars($ruta['distancia'], ENT_QUOTES, 'UTF-8') ?>', '<?= htmlspecialchars($ruta['tiempo_estimado'], ENT_QUOTES, 'UTF-8') ?>')">
                                <i class="fas fa-edit"></i> Editar
                            </button>
                            <form action="rutas.php" method="POST" style="display:inline;" onsubmit="return confirmDelete();">
                                <input type="hidden" name="id_ruta" value="<?= $ruta['id_ruta'] ?>">
                                <input type="hidden" name="action" value="delete">
                                <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Eliminar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Modal para agregar/editar -->
    <div id="modal" class="modal fade" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="modalTitle">Agregar/Editar Ruta</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="modalForm" action="rutas.php" method="POST">
                        <input type="hidden" name="action" id="formAction">
                        <input type="hidden" name="id_ruta" id="formIdRuta">
                        <div class="mb-3">
                            <label for="id_centro_origen" class="form-label">Centro de Origen</label>
                            <select name="id_centro_origen" id="formCentroOrigen" class="form-select" required>
                                <?php foreach ($centros as $centro): ?>
                                    <option value="<?= $centro['id_centro'] ?>"><?= htmlspecialchars($centro['centro_nombre'], ENT_QUOTES, 'UTF-8') ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="id_centro_destino" class="form-label">Centro de Destino</label>
                            <select name="id_centro_destino" id="formCentroDestino" class="form-select" required>
                                <?php foreach ($centros as $centro): ?>
                                    <option value="<?= $centro['id_centro'] ?>"><?= htmlspecialchars($centro['centro_nombre'], ENT_QUOTES, 'UTF-8') ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="distancia" class="form-label">Distancia (km)</label>
                            <input type="text" name="distancia" id="formDistancia" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="tiempo_estimado" class="form-label">Tiempo Estimado (hr:min)</label>
                            <input type="text" name="tiempo_estimado" id="formTiempoEstimado" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-success w-100">Guardar</button>
                        <button type="button" class="btn btn-secondary w-100 mt-2" data-bs-dismiss="modal">Cancelar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function confirmDelete() {
            return confirm("¿Estás seguro de que deseas eliminar esta ruta?");
        }

        function openModal(action) {
            document.getElementById('formAction').value = action;
            if (action === 'add') {
                document.getElementById('modalForm').reset();
            }
        }

        function openEditModal(id, origenNombre, destinoNombre, distancia, tiempoEstimado) {
            openModal('edit');
            document.getElementById('formIdRuta').value = id;
            document.getElementById('formDistancia').value = distancia;
            document.getElementById('formTiempoEstimado').value = tiempoEstimado;

            // Selecciona los valores correctos en los <select> de centros
            const origenSelect = document.getElementById('formCentroOrigen');
            const destinoSelect = document.getElementById('formCentroDestino');

            for (const option of origenSelect.options) {
                if (option.textContent.trim() === origenNombre) {
                    option.selected = true;
                    break;
                }
            }

            for (const option of destinoSelect.options) {
                if (option.textContent.trim() === destinoNombre) {
                    option.selected = true;
                    break;
                }
            }
        }

        function goBack() {
            window.history.back();
        }
    </script>
</body>
</html>

