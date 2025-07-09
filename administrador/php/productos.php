<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../../login-register/login-registro.php");
    exit();
}
include('conexion.php');


// Paginación simple
$limite = 10; // Productos por página
$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$inicio = ($pagina > 1) ? ($pagina * $limite - $limite) : 0;

// Total de productos
$totalProductosQuery = mysqli_query($conexion, "SELECT COUNT(*) AS total FROM productos");
$totalProductos = mysqli_fetch_assoc($totalProductosQuery)['total'];
$totalPaginas = ceil($totalProductos / $limite);

// Consulta paginada
$query = "SELECT * FROM productos LIMIT $inicio, $limite";
$resultado = mysqli_query($conexion, $query);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Productos - Admin</title>
    <link rel="stylesheet" href="../css/estiloSidebar.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <!-- Botón para abrir sidebar en móviles -->
    <button class="btn btn-dark m-2 d-md-none" onclick="toggleSidebar()">☰ Menú</button>

    <div class="d-flex">
        <!-- Sidebar -->
        <div class="bg-dark text-white sidebar p-3" id="sidebar">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="text-danger mb-0">MyM</h4>
                <button class="btn btn-outline-light d-md-none" onclick="toggleSidebar()">✖</button>
            </div>
            <ul class="nav flex-column">
                <li class="nav-item mb-2"><a href="listado_variante.php" class="nav-link text-white">🎯Variantes</a></li>
                <li class="nav-item mb-2"><a href="pedidos.php" class="nav-link text-white">🧾 Pedidos</a></li>
                <li class="nav-item mb-2"><a href="usuarios.php" class="nav-link text-white">👥 Usuarios</a></li>
                <li class="nav-item mb-2"><a href="categorias.php" class="nav-link text-white">📂 Categorías</a></li>
                <li class="nav-item mb-2"><a href="configuracion.php" class="nav-link text-white">⚙️ Configuración</a></li>
                <li class="nav-item mt-4"><a href="cerrarSesion.php" class="btn btn-danger w-100">Cerrar sesión</a></li>
            </ul>
        </div>

        <!-- Contenido principal -->
        <div class="p-4 w-100">
            <h2 class="mb-4">Lista de Productos</h2>

            <!-- Alerta de éxito -->
            <?php if (isset($_SESSION['mensaje_exito'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= $_SESSION['mensaje_exito']; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                </div>
                <?php unset($_SESSION['mensaje_exito']); ?>
            <?php endif; ?>

            <!-- Botones -->
            <div class="d-flex justify-content-between mb-3">
                <a href="agregar_producto.php" class="btn btn-success">+ Agregar Producto</a>
                <a href="admin.php" class="btn btn-secondary">⬅ Volver al Panel</a>
            </div>

            <!-- Tabla -->
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Precio</th>
                        <th>Imagen</th>
                        <th>Categoría</th>
                        <th>Género</th>
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
                            <td>
                                <?php if ($row['imagen']) { ?>
                                    <img src="imagenes/<?= $row['imagen'] ?>" width="50" height="50">
                                <?php } else { echo '—'; } ?>
                            </td>
                            <td><?= $row['categoria_id'] ?></td>
                            <td><?= ucfirst($row['genero']) ?></td>
                            <td><?= ucfirst($row['estado']) ?></td>
                            <td>
                                <a href="editar_producto.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                                <a href="eliminar_producto.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este producto?');">Eliminar</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            
            <!-- Paginación -->
                <nav>
                    <ul class="pagination justify-content-center">
                        <!-- Botón Anterior -->
                        <li class="page-item <?= $pagina <= 1 ? 'disabled' : '' ?>">
                            <a class="page-link" href="?pagina=<?= $pagina - 1 ?>">Anterior</a>
                        </li>

                        <!-- Números de página -->
                        <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                            <li class="page-item <?= $i == $pagina ? 'active' : '' ?>">
                                <a class="page-link" href="?pagina=<?= $i ?>"><?= $i ?></a>
                            </li>
                        <?php endfor; ?>

                        <!-- Botón Siguiente -->
                        <li class="page-item <?= $pagina >= $totalPaginas ? 'disabled' : '' ?>">
                            <a class="page-link" href="?pagina=<?= $pagina + 1 ?>">Siguiente</a>
                        </li>
                    </ul>
                </nav>


        </div>
    </div>

    <!-- Bootstrap + Script sidebar -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('show');
        }
    </script>
</body>
</html>
