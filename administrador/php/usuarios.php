<?php
    include('conexion.php');
    session_start();

    // Validar que el usuario tenga rol de admin
    if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
        header("Location: ../../login-register/login-registro.php");
        exit();
    }

    // Número de usuarios por página
    $por_pagina = 10;

    // Página actual desde URL, por defecto 1
    $pagina = isset($_GET['pagina']) ? max(1, intval($_GET['pagina'])) : 1;

    // Calcular el offset
    $offset = ($pagina - 1) * $por_pagina;

    // Total de usuarios para saber cuántas páginas hay
    $total_resultado = mysqli_query($conexion, "SELECT COUNT(*) AS total FROM Usuarios");
    $total_filas = mysqli_fetch_assoc($total_resultado)['total'];
    $total_paginas = ceil($total_filas / $por_pagina);

    // Consulta con paginación
    $consulta = "SELECT id, cedula, nombre_completo, email, telefono, direccion, rol 
                FROM Usuarios 
                ORDER BY id DESC 
                LIMIT $por_pagina OFFSET $offset";
    $resultado = mysqli_query($conexion, $consulta);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Usuarios</title>
    <link rel="stylesheet" href="../css/estiloSidebar.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php if (isset($_SESSION['mensaje_exito'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $_SESSION['mensaje_exito']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
        <?php unset($_SESSION['mensaje_exito']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['mensaje_error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= $_SESSION['mensaje_error']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
        <?php unset($_SESSION['mensaje_error']); ?>
    <?php endif; ?>


    <!-- Botón para abrir el sidebar en móviles -->
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
                <li class="nav-item mb-2"><a href="categorias.php" class="nav-link text-white">📂 Categorías</a></li>
                <li class="nav-item mb-2"><a href="configuracion.php" class="nav-link text-white">⚙️ Configuración</a></li>
                <li class="nav-item mt-4"><a href="cerrarSesion.php" class="btn btn-danger w-100">Cerrar sesión</a></li>
            </ul>
        </div>

        <!-- Contenido principal -->
        <div class="p-4 w-100">
            <h2 class="mb-4">Usuarios Registrados</h2>

            <!-- Mensajes de éxito o error -->
            <?php if (isset($_SESSION['mensaje_exito'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= $_SESSION['mensaje_exito']; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                </div>
                <?php unset($_SESSION['mensaje_exito']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['mensaje_error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= $_SESSION['mensaje_error']; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                </div>
                <?php unset($_SESSION['mensaje_error']); ?>
            <?php endif; ?>

            <!-- Botones superiores -->
            <div class="mb-3 d-flex gap-2">
                <a href="admin.php" class="btn btn-secondary">⬅ Volver al Panel</a>
                <a href="agregar_usuario.php" class="btn btn-success">+ Agregar Usuario</a>
            </div>

            <!-- Tabla de usuarios -->
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Cédula</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Teléfono</th>
                        <th>Dirección</th>
                        <th>Rol</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- recorre los usuarios de la consulta y los muestra -->
                    <?php while ($fila = mysqli_fetch_assoc($resultado)) { ?>
                        <tr>
                            <td><?= $fila['id'] ?></td>
                            <td><?= $fila['cedula'] ?></td>
                            <td><?= $fila['nombre_completo'] ?></td>
                            <td><?= $fila['email'] ?></td>
                            <td><?= $fila['telefono'] ?></td>
                            <td><?= $fila['direccion'] ?></td>
                            <td><?= $fila['rol'] ?></td>
                            <td>
                                <form action="editar_usuario.php" method="POST" style="display:inline;">
                                    <input type="hidden" name="id_editar" value="<?= $fila['id'] ?>">
                                    <button type="submit" class="btn btn-sm btn-warning">Editar</button>
                                </form>
                                <form action="eliminar_usuario.php" method="POST" style="display:inline;" onsubmit="return confirm('¿Eliminar este usuario?')">
                                    <input type="hidden" name="id" value="<?= $fila['id'] ?>">
                                    <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                                </form>
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
                    <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
                        <li class="page-item <?= $i == $pagina ? 'active' : '' ?>">
                            <a class="page-link" href="?pagina=<?= $i ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>

                    <!-- Botón Siguiente -->
                    <li class="page-item <?= $pagina >= $total_paginas ? 'disabled' : '' ?>">
                        <a class="page-link" href="?pagina=<?= $pagina + 1 ?>">Siguiente</a>
                    </li>
                </ul>
            </nav>

        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('show');
        }
    </script>
</body>
</html>
