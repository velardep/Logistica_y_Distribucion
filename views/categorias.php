<?php
require_once '../controllers/CategoriaController.php';

$controller = new CategoriaController();
$categorias = $controller->listAll();

// Manejo de acciones
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'add') {
            $controller->add($_POST['nombre'], $_POST['descripcion']);
        } elseif ($_POST['action'] === 'edit') {
            $controller->update($_POST['id_categoria'], $_POST['nombre'], $_POST['descripcion']);
        } elseif ($_POST['action'] === 'delete') {
            $controller->delete($_POST['id_categoria']);
        }
        header("Location: categorias.php"); // Redirigir para evitar reenvío de formulario
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Categorías</title>
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
        <h1><i class="fas fa-tags"></i> Gestión de Categorías</h1>
        <div class="d-flex justify-content-between mb-3">
            <button class="btn btn-primary btn-custom" onclick="goBack()"><i class="fas fa-arrow-left"></i> Volver</button>
            <button class="btn btn-success btn-custom" data-bs-toggle="modal" data-bs-target="#modal" onclick="openModal('add')"><i class="fas fa-plus-circle"></i> Agregar Categoría</button>
        </div>
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categorias as $categoria): ?>
                    <tr>
                        <td><?= $categoria['id_categoria'] ?></td>
                        <td><?= htmlspecialchars($categoria['nombre'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($categoria['descripcion'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td>
                            <button 
                                class="btn btn-warning btn-sm" 
                                data-bs-toggle="modal" 
                                data-bs-target="#modal" 
                                onclick="openEditModal(<?= $categoria['id_categoria'] ?>, '<?= htmlspecialchars($categoria['nombre'], ENT_QUOTES, 'UTF-8') ?>', '<?= htmlspecialchars($categoria['descripcion'], ENT_QUOTES, 'UTF-8') ?>')">
                                <i class="fas fa-edit"></i> Editar
                            </button>
                           <!-- <form action="categorias.php" method="POST" style="display:inline;" onsubmit="return confirmDelete(this);">
                                <input type="hidden" name="id_categoria" value="<?= $categoria['id_categoria'] ?>">
                                <input type="hidden" name="action" value="delete">
                                <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Eliminar</button>
                            </form>-->
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
                    <h5 class="modal-title" id="modalTitle">Agregar/Editar Categoría</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="modalForm" action="categorias.php" method="POST">
                        <input type="hidden" name="action" id="formAction">
                        <input type="hidden" name="id_categoria" id="formIdCategoria">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" name="nombre" id="formNombre" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea name="descripcion" id="formDescripcion" class="form-control" rows="3" required></textarea>
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
        function confirmDelete(form) {
            return confirm("¿Estás seguro de que deseas eliminar esta categoría?");
        }

        function openModal(action) {
            document.getElementById('formAction').value = action;
            if (action === 'add') {
                document.getElementById('formIdCategoria').value = '';
                document.getElementById('formNombre').value = '';
                document.getElementById('formDescripcion').value = '';
            }
        }

        function openEditModal(id, nombre, descripcion) {
            openModal('edit');
            document.getElementById('formIdCategoria').value = id;
            document.getElementById('formNombre').value = nombre;
            document.getElementById('formDescripcion').value = descripcion;
        }

        function goBack() {
            window.history.back();
        }
    </script>
</body>
</html>
