<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../../login-register/login-registro.php");
    exit();
}

include('conexion.php');

$mensaje = '';

// 🧲 Cargar las categorías para el <select>
$categorias = mysqli_query($conexion, "SELECT id, nombre FROM categorias");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];
    $estado = $_POST['estado'];
    $categoria_id = $_POST['categoria_id'];

    // 🔍 Validar que la categoría exista
    $validar_categoria = mysqli_query($conexion, "SELECT id FROM categorias WHERE id = $categoria_id");
    if (mysqli_num_rows($validar_categoria) === 0) {
        $mensaje = "La categoría seleccionada no existe. Por favor elige una válida.";
    } else {
        // 🖼️ Subir imagen
        $imagen = '';
        if (!empty($_FILES['imagen']['name'])) {
            $imagen = basename($_FILES['imagen']['name']);
            move_uploaded_file($_FILES['imagen']['tmp_name'], "imagenes/" . $imagen);
        }

        // 💾 Insertar en base de datos
        $query = "INSERT INTO productos (nombre, descripcion, precio, stock, imagen, categoria_id, estado)
                  VALUES ('$nombre', '$descripcion', '$precio', '$stock', '$imagen', '$categoria_id', '$estado')";
        if (mysqli_query($conexion, $query)) {
            $_SESSION['mensaje_exito'] = "Producto agregado exitosamente.";
            header("Location: productos.php");
            exit();
            
        } else {
            $mensaje = "Error al agregar producto: " . mysqli_error($conexion);
        }
    }
}
?>


<!-- Se supone que está bien -->


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
    <div class="container">
        <h2>Agregar Producto</h2>
        <?php if ($mensaje): ?>
            <div class="alert alert-info"><?= $mensaje ?></div>
        <?php endif; ?>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label>Nombre:</label>
                <input type="text" name="nombre" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Descripción:</label>
                <textarea name="descripcion" class="form-control"></textarea>
            </div>
            <div class="mb-3">
                <label>Precio:</label>
                <input type="number" step="0.01" name="precio" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Stock:</label>
                <input type="number" name="stock" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Imagen:</label>
                <input type="file" name="imagen" class="form-control">
            </div>
            <div class="mb-3">
                <label>Categoría (ID):</label>
                <input type="number" name="categoria_id" class="form-control">
            </div>
            <div class="mb-3">
                <label>Estado:</label>
                <select name="estado" class="form-select">
                    <option value="activo">Activo</option>
                    <option value="inactivo">Inactivo</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success">Guardar</button>
            <a href="productos.php" class="btn btn-secondary">Volver</a>
        </form>
    </div>
</body>
</html>
