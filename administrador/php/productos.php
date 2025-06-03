<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../../login-register/login-registro.php");
    exit();
}
include('conexion.php');

// Consulta productos
$query = "SELECT * FROM productos";
$resultado = mysqli_query($conexion, $query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Productos - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">

<div class="container">
    <h2 class="mb-4">Lista de Productos</h2>

    <!-- ✅ Alerta de éxito al agregar un producto -->
    <?php if (isset($_SESSION['mensaje_exito'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $_SESSION['mensaje_exito']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
        <?php unset($_SESSION['mensaje_exito']); ?>
    <?php endif; ?>

    <!-- ✅ Botones superiores -->
    <div class="d-flex justify-content-between mb-3">
        <a href="agregar_producto.php" class="btn btn-success">+ Agregar Producto</a>
        <a href="admin.php" class="btn btn-secondary">⬅ Volver al Panel</a>
    </div>

    <!-- Tabla de productos -->
    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Imagen</th>
                <th>Categoría</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($resultado)) { ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['nombre'] ?></td>
                    <td><?= $row['descripcion'] ?></td>
                    <td>$<?= number_format($row['precio'], 2) ?></td>
                    <td><?= $row['stock'] ?></td>
                    <td>
                        <?php if ($row['imagen']) { ?>
                            <img src="imagenes/<?= $row['imagen'] ?>" width="50" height="50">
                        <?php } else { echo '—'; } ?>
                    </td>
                    <td><?= $row['categoria_id'] ?></td>
                    <td><?= ucfirst($row['estado']) ?></td>
                    <td>
                        <a href="editar_producto.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                        <a href="eliminar_producto.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este producto?');">Eliminar</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<!-- Script de Bootstrap para alertas y componentes -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
