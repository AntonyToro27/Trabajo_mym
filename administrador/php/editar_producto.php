<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../../login-register/login-registro.php"); //cambiar locacion
    exit();
}
include('conexion.php');

$id = $_GET['id'] ?? null;
$mensaje = '';

if (!$id) {
    header('Location: productos.php');
    exit();
}

// Obtener los datos actuales del producto
$query = "SELECT * FROM productos WHERE id = $id";
$resultado = mysqli_query($conexion, $query);
$producto = mysqli_fetch_assoc($resultado);

// Si se envió el formulario, actualizar producto
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitización básica
    $nombre = trim($_POST['nombre']);
    $descripcion = trim($_POST['descripcion']);
    $precio = floatval($_POST['precio']);
    // $stock = intval($_POST['stock']);
    $estado = $_POST['estado'];
    $categoria_id = intval($_POST['categoria_id']);

    $errores = [];

    // 🔍 Validaciones
    if (strlen($nombre) < 3) $errores[] = "El nombre debe tener al menos 3 caracteres.";
    if (strlen($descripcion) < 5) $errores[] = "La descripción es muy corta.";
    if ($precio < 0) $errores[] = "El precio no puede ser negativo.";
    // if ($stock < 0) $errores[] = "El stock no puede ser negativo.";
    if ($categoria_id <= 0) $errores[] = "La categoría debe ser un número válido.";
    if (!in_array($estado, ['activo', 'inactivo'])) $errores[] = "Estado no válido.";

    // Validar imagen si fue subida
    $imagen = $producto['imagen'];
    if (!empty($_FILES['imagen']['name'])) {
        $permitidos = ['image/jpeg', 'image/png', 'image/webp'];
        if (!in_array($_FILES['imagen']['type'], $permitidos)) {
            $errores[] = "Solo se permiten imágenes JPG, PNG o WEBP.";
        } else {
            $imagen = basename($_FILES['imagen']['name']);
            move_uploaded_file($_FILES['imagen']['tmp_name'], "imagenes/" . $imagen);
        }
    }

    // Si hay errores, los mostramos
    if (!empty($errores)) {
        $mensaje = "<ul class='text-danger'>";
        foreach ($errores as $error) {
            $mensaje .= "<li>$error</li>";
        }
        $mensaje .= "</ul>";
    } else {
        // ✅ Actualizar en la base de datos
        $update = "UPDATE productos 
                   SET nombre='$nombre', descripcion='$descripcion', precio='$precio',
                        imagen='$imagen', categoria_id='$categoria_id', estado='$estado' 
                   WHERE id = $id";

        if (mysqli_query($conexion, $update)) {
            $mensaje = "<div class='text-success'>Producto actualizado correctamente.</div>";
            // refrescar datos
            $resultado = mysqli_query($conexion, "SELECT * FROM productos WHERE id = $id");
            $producto = mysqli_fetch_assoc($resultado);
        } else {
            $mensaje = "<div class='text-danger'>Error al actualizar: " . mysqli_error($conexion) . "</div>";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
    <div class="container">
        <h2>Editar Producto</h2>
        <?php if ($mensaje): ?>
            <div class="alert alert-info"><?= $mensaje ?></div>
        <?php endif; ?>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label>Nombre:</label>
                <input type="text" name="nombre" class="form-control" value="<?= $producto['nombre'] ?>" required>
            </div>
            <div class="mb-3">
                <label>Descripción:</label>
                <textarea name="descripcion" class="form-control"><?= $producto['descripcion'] ?></textarea>
            </div>
            <div class="mb-3">
                <label>Precio:</label>
                <input type="number" step="0.01" name="precio" class="form-control" value="<?= $producto['precio'] ?>" required>
            </div>
            <div class="mb-3">
                <label>Imagen actual:</label><br>
                <?php if ($producto['imagen']) { ?>
                    <img src="imagenes/<?= $producto['imagen'] ?>" width="80" height="80">
                <?php } else { echo '—'; } ?>
            </div>
            <div class="mb-3">
                <label>Cambiar Imagen:</label>
                <input type="file" name="imagen" class="form-control">
            </div>
            <div class="mb-3">
                <label>Categoría (ID):</label>
                <input type="number" name="categoria_id" class="form-control" value="<?= $producto['categoria_id'] ?>">
            </div>
            <div class="mb-3">
                <label>Estado:</label>
                <select name="estado" class="form-select">
                    <option value="activo" <?= $producto['estado'] === 'activo' ? 'selected' : '' ?>>Activo</option>
                    <option value="inactivo" <?= $producto['estado'] === 'inactivo' ? 'selected' : '' ?>>Inactivo</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Guardar cambios</button>
            <a href="productos.php" class="btn btn-secondary">Volver</a>
        </form>
    </div>
</body>
</html>
