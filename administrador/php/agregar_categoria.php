<?php
session_start();

// 🛡️ Verificamos que el usuario esté autenticado como administrador
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'admin') {
    header("Location: loginA.php");
    exit();
}

include('conexion.php');

$error = "";

// 🧾 Si el formulario se envía por método POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 🔍 Limpiamos los datos del formulario
    $nombre = trim($_POST['nombre']);
    $descripcion = trim($_POST['descripcion']);

    // 🧠 Validamos que el campo nombre no esté vacío
    if ($nombre !== '') {
        // 🔐 Verificamos si ya existe una categoría con ese nombre
        $verificar = "SELECT id FROM categorias WHERE nombre = ?";
        $stmt = mysqli_prepare($conexion, $verificar);
        mysqli_stmt_bind_param($stmt, "s", $nombre);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        // ⚠️ Si ya existe una categoría con ese nombre, mostramos error
        if (mysqli_stmt_num_rows($stmt) > 0) {
            $error = "Ya existe una categoría con ese nombre.";
        } else {
            // ✅ Si todo es válido, insertamos la nueva categoría
            $query = "INSERT INTO categorias (nombre, descripcion) VALUES (?, ?)";
            $stmt = mysqli_prepare($conexion, $query);
            mysqli_stmt_bind_param($stmt, "ss", $nombre, $descripcion);
            mysqli_stmt_execute($stmt);

            // 🟢 Mostramos mensaje de éxito y redirigimos
            $_SESSION['mensaje_exito'] = "Categoría registrada correctamente.";
            header("Location: categorias.php");
            exit();
        }
    } else {
        // ⚠️ El campo nombre está vacío
        $error = "El campo nombre es obligatorio.";
    }
}
?>

<!-- 🌐 HTML con formulario para agregar categoría -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Categoría</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
<div class="container">
    
    <h2>Agregar Categoría</h2>

    <!-- ⚠️ Mostrar errores si existen -->
    <?php if (!empty($error)) : ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <!-- 📝 Formulario de nueva categoría -->
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Nombre:</label>
            <input type="text" name="nombre" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Descripción:</label>
            <textarea name="descripcion" class="form-control"></textarea>
        </div>
        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="categorias.php" class="btn btn-secondary">Volver</a>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
