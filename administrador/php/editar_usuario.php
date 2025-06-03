<?php
// 🛡️ 1. Iniciamos la sesión y validamos que el usuario tenga rol de admin
session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../../login-register/login-registro.php");
    exit();
}

// 🧩 2. Incluimos el archivo de conexión a la base de datos
include('conexion.php');

// 🛠️ 3. Si venimos del botón "Editar", entonces guardamos el ID del usuario (enviado por POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_editar'])) {
    $id = $_POST['id_editar'];

    // 🧲 4. Consultamos los datos actuales del usuario
    $consulta = "SELECT * FROM Usuarios WHERE id = $id";
    $resultado = mysqli_query($conexion, $consulta);
    $usuario = mysqli_fetch_assoc($resultado);
}

// 📝 5. Si venimos del formulario de edición (guardando cambios)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['guardar_cambios'])) {
    $id = $_POST['id'];
    $cedula = $_POST['cedula'];
    $nombre_completo = $_POST['nombre_completo'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];
    $rol = $_POST['rol'];

    // 🧪 Validamos que el nuevo correo o cédula no existan en otro usuario
    $verifica = "SELECT * FROM Usuarios WHERE (email = '$email' OR cedula = '$cedula') AND id != $id";
    $resultado = mysqli_query($conexion, $verifica);

    if (mysqli_num_rows($resultado) > 0) {
        echo "<script>alert('Error: Este correo o cédula ya está registrado en otro usuario.'); window.location.href='usuarios.php';</script>";
        exit();
    }

    // 💾 Si pasa, actualizamos
    $actualizar = "UPDATE Usuarios SET cedula='$cedula', nombre_completo='$nombre_completo', email='$email', telefono='$telefono', direccion='$direccion', rol='$rol' WHERE id = $id";
    mysqli_query($conexion, $actualizar);

    header("Location: usuarios.php");
    exit();
}

?>

<!-- 🌐 8. HTML para mostrar el formulario -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
    <h2>Editar Usuario</h2>
    <a href="usuarios.php" class="btn btn-secondary mb-3">⬅ Volver</a>

    <!-- 📋 9. Formulario para editar usuario -->
    <form method="POST" class="row g-3">
        <!-- Campo oculto con el ID -->
        <input type="hidden" name="id" value="<?= $usuario['id'] ?>">

        <div class="col-md-4">
            <input type="text" name="cedula" value="<?= $usuario['cedula'] ?>" class="form-control" required>
        </div>
        <div class="col-md-4">
            <input type="text" name="nombre_completo" value="<?= $usuario['nombre_completo'] ?>" class="form-control" required>
        </div>
        <div class="col-md-4">
            <input type="email" name="email" value="<?= $usuario['email'] ?>" class="form-control" required>
        </div>
        <div class="col-md-4">
            <input type="text" name="telefono" value="<?= $usuario['telefono'] ?>" class="form-control">
        </div>
        <div class="col-md-4">
            <input type="text" name="direccion" value="<?= $usuario['direccion'] ?>" class="form-control">
        </div>
        <div class="col-md-4">
            <select name="rol" class="form-select">
                <option value="cliente" <?= $usuario['rol'] === 'cliente' ? 'selected' : '' ?>>Cliente</option>
                <option value="admin" <?= $usuario['rol'] === 'admin' ? 'selected' : '' ?>>Administrador</option>
            </select>
        </div>

        <!-- Botón de guardar cambios -->
        <div class="col-md-2">
            <button type="submit" name="guardar_cambios" class="btn btn-warning w-100">Guardar</button>
        </div>
    </form>
</body>
</html>
