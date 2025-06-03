<?php
session_start();
// Verificamos si el usuario está logueado como admin
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'admin') {
    header("Location: loginA.php");
    exit();
}

include('conexion.php');
// Obtenemos todas las categorías de la base de datos
$resultado = mysqli_query($conexion, "SELECT * FROM categorias");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Categorías</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
<div class="container">
    <h2 class="mb-4">Categorías</h2>

    <!-- Mostramos mensajes de éxito o error -->
    <?php if (isset($_SESSION['mensaje_exito'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $_SESSION['mensaje_exito']; unset($_SESSION['mensaje_exito']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    <?php endif; ?>
    <?php if (isset($_SESSION['mensaje_error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= $_SESSION['mensaje_error']; unset($_SESSION['mensaje_error']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    <?php endif; ?>

    <!-- Botones para volver y agregar -->
    <a href="admin.php" class="btn btn-secondary mb-3">⬅ Volver al Panel</a>
    <a href="agregar_categoria.php" class="btn btn-success mb-3">+ Nueva Categoría</a>

    <!-- Tabla de categorías -->
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr><th>ID</th><th>Nombre</th><th>Descripción</th><th>Acciones</th></tr>
        </thead>
        <tbody>
            <?php while ($cat = mysqli_fetch_assoc($resultado)) { ?>
                <tr>
                    <td><?= $cat['id'] ?></td>
                    <td><?= $cat['nombre'] ?></td>
                    <td><?= $cat['descripcion'] ?></td>
                    <td>
                        <!-- Botón para editar usando POST -->
                        <form action="editar_categoria.php" method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?= $cat['id'] ?>">
                            <button type="submit" class="btn btn-warning btn-sm">Editar</button>
                        </form>

                        <!-- Botón para eliminar usando POST -->
                        <form action="eliminar_categoria.php" method="POST" style="display:inline;" onsubmit="return confirm('¿Eliminar esta categoría?')">
                            <input type="hidden" name="id" value="<?= $cat['id'] ?>">
                            <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
