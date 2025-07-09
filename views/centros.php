<?php
require_once '../controllers/CentroLogisticoController.php';
require_once '../controllers/CategoriaController.php';

$centroController = new CentroLogisticoController();
$categoriaController = new CategoriaController();

$centros = $centroController->listAll();
$categorias = $categoriaController->listAll();

// Handle actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'add') {
            $centroController->create($_POST);
        } elseif ($_POST['action'] === 'edit') {
            $centroController->update($_POST);
        } elseif ($_POST['action'] === 'delete') {
            $centroController->delete($_POST['id_centro']);
        }
        header("Location: centros.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Centros Logísticos</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
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

        .modal-header {
            background-color: #28a745;
            color: white;
        }
        .container {
        background: rgba(255, 255, 255, 0.9);
        border-radius: 15px;
        box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.15);
        padding: 20px;
        margin-top: 30px;
        width: fit-content; /* Ajusta el ancho al contenido */
        max-width: 90%; /* Agrega un límite máximo en caso de ser muy ancho */
    }

    table {
        margin: auto; /* Centra la tabla dentro del contenedor */
    }
    </style>
</head>
<body>
    <div class="container">
        <h1><i class="fas fa-warehouse"></i> Gestión de Centros Logísticos</h1>
        <div class="d-flex justify-content-between mb-3">
            <button class="btn btn-primary btn-custom" onclick="goBack()"><i class="fas fa-arrow-left"></i> Volver</button>
            <button class="btn btn-success btn-custom" onclick="openModal('add')"><i class="fas fa-plus-circle"></i> Agregar Centro</button>
        </div>
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Categoría</th>
                    <th>Descripción</th>
                    <th>Tipo de Recurso</th>
                    <th>Longitud</th>
                    <th>Latitud</th>
                    <th>Capacidad</th>
                    <th>Horario</th>
                    <th>Zona de Cobertura</th>
                    <th>Contacto</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($centros as $centro): ?>
                    <tr id="row-<?= $centro['id_centro'] ?>">
                        <td><?= htmlspecialchars($centro['id_centro'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($centro['centro_nombre'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($centro['categoria_nombre'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($centro['descripcion'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($centro['tipos_recursos'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($centro['longitud'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($centro['latitud'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($centro['capacidad'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($centro['horario_operacion'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($centro['zona_cobertura'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($centro['contacto'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td>
                            <button class="btn btn-warning btn-sm" onclick="openEditModal(<?= $centro['id_centro'] ?>)">Editar</button>
                            <form action="centros.php" method="POST" style="display:inline;" onsubmit="return confirmDelete();">
                                <input type="hidden" name="id_centro" value="<?= $centro['id_centro'] ?>">
                                <input type="hidden" name="action" value="delete">
                                <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    <div id="modal" class="modal fade" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Agregar/Editar Centro</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="modalForm" action="centros.php" method="POST">
                        <input type="hidden" name="action" id="formAction">
                        <input type="hidden" name="id_centro" id="formIdCentro">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="formNombre" class="form-label">Nombre</label>
                                    <input type="text" name="nombre" id="formNombre" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label for="formDescripcion" class="form-label">Descripción</label>
                                    <input type="text" name="descripcion" id="formDescripcion" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label for="formTiposRecursos" class="form-label">Tipo de Recurso</label>
                                    <input type="text" name="tipos_recursos" id="formTiposRecursos" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label for="formCategoria" class="form-label">Categoría</label>
                                    <select name="id_categoria" id="formCategoria" class="form-select" required>
                                        <?php foreach ($categorias as $categoria): ?>
                                            <option value="<?= $categoria['id_categoria'] ?>"><?= htmlspecialchars($categoria['nombre'], ENT_QUOTES, 'UTF-8') ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="formLongitud" class="form-label">Longitud</label>
                                    <input type="text" name="longitud" id="formLongitud" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label for="formLatitud" class="form-label">Latitud</label>
                                    <input type="text" name="latitud" id="formLatitud" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label for="formCapacidad" class="form-label">Capacidad</label>
                                    <input type="text" name="capacidad" id="formCapacidad" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label for="formHorario" class="form-label">Horario</label>
                                    <input type="text" name="horario_operacion" id="formHorario" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label for="formZonaCobertura" class="form-label">Zona de Cobertura</label>
                                    <input type="text" name="zona_cobertura" id="formZonaCobertura" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label for="formContacto" class="form-label">Contacto</label>
                                    <input type="text" name="contacto" id="formContacto" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" id="formSubmitButton" class="btn btn-success w-50">Guardar</button>
                            <button type="button" class="btn btn-secondary w-50 mt-2" data-bs-dismiss="modal">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function confirmDelete() {
            return confirm("¿Estás seguro de que deseas eliminar este centro logístico?");
        }

        function openModal(action) {
            const modal = new bootstrap.Modal(document.getElementById('modal'));
            document.getElementById('formAction').value = action;

            if (action === 'add') {
                document.getElementById('modalTitle').textContent = 'Agregar Centro Logístico';
                document.getElementById('modalForm').reset();
            } else if (action === 'edit') {
                document.getElementById('modalTitle').textContent = 'Editar Centro Logístico';
            }

            modal.show();
        }

        function openEditModal(id) {
            const row = document.getElementById(`row-${id}`);
            const nombre = row.cells[1].innerText.trim();
            const categoria = row.cells[2].innerText.trim();
            const descripcion = row.cells[3].innerText.trim();
            const tipos_recursos = row.cells[4].innerText.trim();
            const longitud = row.cells[5].innerText.trim();
            const latitud = row.cells[6].innerText.trim();
            const capacidad = row.cells[7].innerText.trim();
            const horario = row.cells[8].innerText.trim();
            const zona = row.cells[9].innerText.trim();
            const contacto = row.cells[10].innerText.trim();

            openModal('edit');

            document.getElementById('formIdCentro').value = id;
            document.getElementById('formNombre').value = nombre;
            document.getElementById('formDescripcion').value = descripcion;
            document.getElementById('formTiposRecursos').value = tipos_recursos;
            document.getElementById('formLongitud').value = longitud;
            document.getElementById('formLatitud').value = latitud;
            document.getElementById('formCapacidad').value = capacidad;
            document.getElementById('formHorario').value = horario;
            document.getElementById('formZonaCobertura').value = zona;
            document.getElementById('formContacto').value = contacto;

            const selectCategoria = document.getElementById('formCategoria');
            for (const option of selectCategoria.options) {
                if (option.textContent === categoria) {
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
