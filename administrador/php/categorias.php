<?php
session_start();
// Verificamos si el usuario está logueado como admin
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'admin') {
    header("Location: loginA.php");
    exit();
}

include('conexion.php');


// Número de categorías por página
$por_pagina = 10;

// Página actual desde GET (por defecto página 1)
$pagina = isset($_GET['pagina']) ? max(1, intval($_GET['pagina'])) : 1;

// Calcular desde qué fila empezar
$offset = ($pagina - 1) * $por_pagina;

// Total de registros para calcular cuántas páginas hay
$total_resultado = mysqli_query($conexion, "SELECT COUNT(*) AS total FROM categorias");
$total_filas = mysqli_fetch_assoc($total_resultado)['total'];
$total_paginas = ceil($total_filas / $por_pagina);

// Consulta con paginación
$resultado = mysqli_query($conexion, "SELECT * FROM categorias ORDER BY id DESC LIMIT $por_pagina OFFSET $offset");


// // Obtenemos todas las categorías de la base de datos
// $resultado = mysqli_query($conexion, "SELECT * FROM categorias");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Categorías</title>
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
                <li class="nav-item mb-2"><a href="productos.php" class="nav-link text-white">📦 Productos</a></li>
                <li class="nav-item mb-2"><a href="listado_variante.php" class="nav-link text-white">🎯Variantes</a></li>
                <li class="nav-item mb-2"><a href="pedidos.php" class="nav-link text-white">🧾 Pedidos</a></li>
                <li class="nav-item mb-2"><a href="usuarios.php" class="nav-link text-white">👥 Usuarios</a></li>
                <li class="nav-item mb-2"><a href="configuracion.php" class="nav-link text-white">⚙️ Configuración</a></li>
                <li class="nav-item mt-4"><a href="cerrarSesion.php" class="btn btn-danger w-100">Cerrar sesión</a></li>
            </ul>
        </div>

        <!-- Contenido principal -->
        <div class="p-4 w-100">
            <h2 class="mb-4">Categorías</h2>
            
            <!-- Mensajes -->
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

            <!-- Botones -->
            <a href="admin.php" class="btn btn-secondary mb-3">⬅ Volver al Panel</a>
            <a href="agregar_categoria.php" class="btn btn-success mb-3">+ Nueva Categoría</a>

            <!-- Tabla -->
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
                                <form action="editar_categoria.php" method="POST" style="display:inline;">
                                    <input type="hidden" name="id" value="<?= $cat['id'] ?>">
                                    <button type="submit" class="btn btn-warning btn-sm">Editar</button>
                                </form>

                                <form action="eliminar_categoria.php" method="POST" style="display:inline;" onsubmit="return confirm('¿Eliminar esta categoría?')">
                                    <input type="hidden" name="id" value="<?= $cat['id'] ?>">
                                    <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <!-- Paginación -->
            <nav>
                <ul class="pagination justify-content-center">
                    <!-- Anterior -->
                    <li class="page-item <?= $pagina <= 1 ? 'disabled' : '' ?>">
                        <a class="page-link" href="?pagina=<?= $pagina - 1 ?>">Anterior</a>
                    </li>

                    <!-- Números de página -->
                    <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
                        <li class="page-item <?= $i == $pagina ? 'active' : '' ?>">
                            <a class="page-link" href="?pagina=<?= $i ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>

                    <!-- Siguiente -->
                    <li class="page-item <?= $pagina >= $total_paginas ? 'disabled' : '' ?>">
                        <a class="page-link" href="?pagina=<?= $pagina + 1 ?>">Siguiente</a>
                    </li>
                </ul>
            </nav>

        </div>
    </div>

    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Toggle Sidebar Script -->
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('show');
        }
    </script>
</body>

</html>
