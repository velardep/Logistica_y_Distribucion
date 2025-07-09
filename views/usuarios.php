<?php
require_once '../controllers/UsuarioController.php';

$usuarioController = new UsuarioController();
$usuarios = $usuarioController->listAll();
$roles = $usuarioController->getRoles(); // Obtener roles dinámicamente

// Manejo de acciones
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'delete') {
            $usuarioController->delete($_POST['id_usuario']);
        } elseif ($_POST['action'] === 'add') {
            $usuarioController->add($_POST['nombre'], $_POST['correo'], $_POST['contrasena'], $_POST['rol']);
        } elseif ($_POST['action'] === 'edit') {
            $usuarioController->update($_POST['id_usuario'], $_POST['nombre'], $_POST['correo'], $_POST['contrasena'], $_POST['rol']);
        }
        header("Location: usuarios.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome para íconos -->
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

        .modal-header {
            background-color: #28a745;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1><i class="fas fa-users"></i> Gestión de Usuarios</h1>
        <div class="d-flex justify-content-between mb-3">
            <button class="btn btn-primary btn-custom" onclick="goBack()"><i class="fas fa-arrow-left"></i> Volver</button>
            <button class="btn btn-success btn-custom" onclick="openModal('add')"><i class="fas fa-plus-circle"></i> Agregar Usuario</button>
        </div>
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Contraseña</th>
                    <th>Rol</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $usuario): ?>
                    <tr>
                        <td><?= htmlspecialchars($usuario['id_usuario'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($usuario['nombre'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($usuario['correo'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($usuario['contrasena'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($usuario['rol'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td>
                            <button class="btn btn-warning btn-sm" onclick="openEditModal(
                                <?= $usuario['id_usuario'] ?>,
                                '<?= htmlspecialchars($usuario['nombre'], ENT_QUOTES, 'UTF-8') ?>',
                                '<?= htmlspecialchars($usuario['correo'], ENT_QUOTES, 'UTF-8') ?>',
                                '<?= htmlspecialchars($usuario['contrasena'], ENT_QUOTES, 'UTF-8') ?>',
                                '<?= htmlspecialchars($usuario['rol'], ENT_QUOTES, 'UTF-8') ?>'
                            )"><i class="fas fa-edit"></i> Editar</button>
                            <form action="usuarios.php" method="POST" style="display:inline;" onsubmit="return confirmDelete();">
                                <input type="hidden" name="id_usuario" value="<?= $usuario['id_usuario'] ?>">
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
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Agregar/Editar Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="modalForm" action="usuarios.php" method="POST">
                        <input type="hidden" name="action" id="formAction">
                        <input type="hidden" name="id_usuario" id="formIdUsuario">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" name="nombre" id="formNombre" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="correo" class="form-label">Correo</label>
                            <input type="email" name="correo" id="formCorreo" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="contrasena" class="form-label">Contraseña</label>
                            <input type="text" name="contrasena" id="formContrasena" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="rol" class="form-label">Rol</label>
                            <select id="formRol" name="rol" class="form-select" required>
                                <?php foreach ($roles as $role): ?>
                                    <option value="<?= htmlspecialchars($role['rol'], ENT_QUOTES, 'UTF-8') ?>">
                                        <?= htmlspecialchars($role['rol'], ENT_QUOTES, 'UTF-8') ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <button type="submit" id="formSubmitButton" class="btn btn-success w-100">Guardar</button>
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
            return confirm("¿Estás seguro de que deseas eliminar este usuario?");
        }

        function openModal(action) {
            document.getElementById('modalForm').reset();
            document.getElementById('formAction').value = action;
            document.getElementById('modalTitle').textContent = action === 'add' ? 'Agregar Usuario' : 'Editar Usuario';
            new bootstrap.Modal(document.getElementById('modal')).show();
        }

        function openEditModal(id, nombre, correo, contrasena, rol) {
            openModal('edit');
            document.getElementById('formIdUsuario').value = id;
            document.getElementById('formNombre').value = nombre;
            document.getElementById('formCorreo').value = correo;
            document.getElementById('formContrasena').value = contrasena;
            document.getElementById('formRol').value = rol;
        }

        function goBack() {
            window.history.back();
        }
    </script>
</body>
</html>
