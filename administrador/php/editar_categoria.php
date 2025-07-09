<?php
session_start();

// Verificamos que el usuario esté autenticado como administrador
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../../login-register/login-registro.php");
    exit();
}

include('conexion.php');

// 🧾 Solo permitimos acceso si se envió un ID por POST
if (!isset($_POST['id'])) {
    header("Location: categorias.php");
    exit();
}

$id = $_POST['id'];

// 🔍 Obtenemos los datos actuales de la categoría para mostrarlos en el formulario
$consulta = "SELECT * FROM categorias WHERE id = ?";
$stmt = mysqli_prepare($conexion, $consulta);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);
$categoria = mysqli_fetch_assoc($resultado);

// 🧠 Procesamos el formulario cuando se envía para actualizar los datos
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nombre'])) {
    $nombre = trim($_POST['nombre']);
    $descripcion = trim($_POST['descripcion']);

    // 🔍 Validación: El campo nombre no debe estar vacío
    if ($nombre !== '') {

        // 🔐 Validación: Revisamos si ya existe otra categoría con ese nombre (excluyendo la actual)
        $verificar = "SELECT id FROM categorias WHERE nombre = ? AND id != ?";
        $stmt = mysqli_prepare($conexion, $verificar);
        mysqli_stmt_bind_param($stmt, "si", $nombre, $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        // ⚠️ Si ya existe una con ese nombre, mostramos un error
        if (mysqli_stmt_num_rows($stmt) > 0) {
            $error = "Otra categoría ya usa ese nombre.";
        } else {
            // ✅ Si todo es válido, actualizamos la categoría
            $update = "UPDATE categorias SET nombre = ?, descripcion = ? WHERE id = ?";
            $stmt = mysqli_prepare($conexion, $update);
            mysqli_stmt_bind_param($stmt, "ssi", $nombre, $descripcion, $id);
            mysqli_stmt_execute($stmt);

            // ✅ Mostramos mensaje de éxito y redirigimos
            $_SESSION['mensaje_exito'] = "Categoría actualizada correctamente.";
            header("Location: categorias.php");
            exit();
        }

    } else {
        // ⚠️ Si el campo nombre está vacío
        $error = "El nombre no puede estar vacío.";
    }
}
?>

<!-- 🌐 Vista HTML con formulario de edición -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Categoría</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
<div class="container">
    <h2>Editar Categoría</h2>

    <!-- ⚠️ Mostrar mensaje de error si existe -->
    <?php if (!empty($error)) : ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <!-- 📝 Formulario de edición -->
    <form method="POST">
        <input type="hidden" name="id" value="<?= $categoria['id'] ?>">

        <div class="mb-3">
            <label class="form-label">Nombre:</label>
            <input type="text" name="nombre" class="form-control" value="<?= htmlspecialchars($categoria['nombre']) ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Descripción:</label>
            <textarea name="descripcion" class="form-control"><?= htmlspecialchars($categoria['descripcion']) ?></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="categorias.php" class="btn btn-secondary">Volver</a>
    </form>
</div>
</body>
</html>
