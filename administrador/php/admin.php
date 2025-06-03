<?php
    session_start();
    if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
        header("Location: ../../login-register/login-registro.php");
        exit();
    }
?>  

<!-- esta conexion me suelta error, cuando llegue del sena la organizo y organizo lo del oso y estamos melos. -->

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administración - mym</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/estilosAdmin.css">
</head>
<body>
<p class="text-dark">👋 Bienvenido <?= $_SESSION['usuario'] ?> </p>


    <div class="d-flex" id="wrapper">

        <!-- Sidebar -->
        <div class="bg-dark text-white sidebar p-3" id="sidebar">
            <h4 class="text-danger mb-4">mym</h4>
            <ul class="nav flex-column">
                <li class="nav-item mb-2">
                <a href="productos.php" class="nav-link text-white">📦 Productos</a>
                </li>
                <li class="nav-item mb-2">
                <a href="pedidos.php" class="nav-link text-white">🧾 Pedidos</a>

                </li>
                <li class="nav-item mb-2">
                <a href="usuarios.php" class="nav-link text-white">👥 Usuarios</a>
                </li>
                <li class="nav-item mb-2">
                <a href="categorias.php" class="nav-link text-white">📂 Categorías</a>
                </li>
                <li class="nav-item mb-2">
                <a href="configuracion.php" class="nav-link text-white">⚙️ Configuración</a>
                </li>
                <li class="nav-item mt-4">
                    <a href="cerrarSesion.php" class="btn btn-danger w-100">Cerrar sesión</a>
                </li>
            </ul>
        </div>

        <!-- Page Content -->
        <div class="flex-grow-1 p-4" id="content">
            <h2 class="text-dark">Bienvenido, Administrador</h2>
            <p class="text-secondary">Desde aquí puedes gestionar los productos, pedidos y usuarios de tu tienda online.</p>

            <!-- Ejemplo de tarjetas -->
            <div class="row row-cols-1 row-cols-md-4 g-4 mt-4">
    <!-- Categorías -->
    <div class="col">
        <div class="card h-100 text-white bg-primary">
            <div class="card-body">
                <h5 class="card-title">Categorías</h5>
                <p class="card-text">Organiza y administra las categorías de productos.</p>
            </div>
        </div>
    </div>

    <!-- Productos -->
    <div class="col">
        <div class="card h-100 text-white bg-danger">
            <div class="card-body">
                <h5 class="card-title">Productos</h5>
                <p class="card-text">Gestiona el inventario y publica nuevos productos.</p>
            </div>
        </div>
    </div>

    <!-- Pedidos -->
    <div class="col">
        <div class="card h-100 text-white bg-dark">
            <div class="card-body">
                <h5 class="card-title">Pedidos</h5>
                <p class="card-text">Consulta y procesa los pedidos de los clientes.</p>
            </div>
        </div>
    </div>

    <!-- Usuarios -->
    <div class="col">
        <div class="card h-100 text-white bg-secondary">
            <div class="card-body">
                <h5 class="card-title">Usuarios</h5>
                <p class="card-text">Administra los usuarios registrados en la tienda.</p>
            </div>
        </div>
    </div>
</div>

</body>
</html>

