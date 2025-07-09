<?php
session_start();
require_once '../config/db.php';

// Mostrar errores de PHP (opcional, para depuración)
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];

    // Conexión a la base de datos
    $database = new Database();
    $db = $database->getConnection();

    // Validar usuario
    $query = "SELECT * FROM Usuarios WHERE correo = :correo";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':correo', $correo);
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verificar contraseña
    if ($usuario && $contrasena === $usuario['contrasena']) {
        // Iniciar sesión
        $_SESSION['id_usuario'] = $usuario['id_usuario'];
        $_SESSION['nombre'] = $usuario['nombre'];
        $_SESSION['rol'] = $usuario['rol'];

        // Redirigir según el rol
        if ($usuario['rol'] === 'admin') {
            header('Location: ../public/index.php');
        } elseif ($usuario['rol'] === 'operador') {
            header('Location: ../public/index_user.php');
        } else {
            $error = "Rol no reconocido.";
        }
        exit();
    } else {
        $error = "Correo o contraseña incorrectos.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistema de Logística y Distribución</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome para Íconos -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
    body {
        background: url('../images/5568850.jpg') no-repeat center center fixed;
        background-size: cover;
        font-family: 'Poppins', sans-serif;
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 0;
    }

    .login-container {
        background: rgba(255, 255, 255, 0.9);
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.15);
        width: 400px;
        text-align: center;
    }

    .login-container h1 {
        font-size: 1.8rem;
        font-weight: bold;
        color: #28a745;
        margin-bottom: 20px;
    }

    .form-control {
        border-radius: 8px;
    }

    .btn-custom {
        background-color: #28a745;
        color: white;
        border: none;
        font-weight: bold;
        width: 100%;
        padding: 10px;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .btn-custom:hover {
        background-color: #218838;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2);
    }

    .error {
        color: #d62828;
        font-size: 0.9rem;
        margin-top: 10px;
    }

    .icon {
        color: #28a745;
        font-size: 3rem;
        margin-bottom: 20px;
    }
    </style>
</head>
<body>
    <div class="login-container">
        <i class="fas fa-user-circle icon"></i>
        <h1>Iniciar Sesión</h1>
        <?php if (isset($error)): ?>
            <div class="error"><?= $error ?></div>
        <?php endif; ?>
        <form action="login.php" method="POST">
            <div class="mb-3">
                <label for="correo" class="form-label">Correo Electrónico</label>
                <input type="email" name="correo" id="correo" class="form-control" placeholder="Ingrese su correo" required>
            </div>
            <div class="mb-3">
                <label for="contrasena" class="form-label">Contraseña</label>
                <input type="password" name="contrasena" id="contrasena" class="form-control" placeholder="Ingrese su contraseña" required>
            </div>
            <button type="submit" class="btn btn-custom">Iniciar Sesión</button>
        </form>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
