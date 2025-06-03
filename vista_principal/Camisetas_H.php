<?php
session_start();
// if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'cliente') {
//     header("Location: ../login-register/login-registro.php");
//     exit();
// }

// Simulación de algunos productos (puedes obtenerlos de una base de datos)
$productos = [
    [
        'nombre' => 'Camiseta blanca tipo Polo',
        'precio' => 75000,
        'imagen' => 'img/Hombres/Camiseta_Blanca_tipo_Polo.jpg' ,
        'descripcion' => 'Camiseta Tipo Polo.',
        'id' => 1 // Añade un ID único para cada producto
    ],
    [
        'nombre' => 'Camiseta Beige',
        'precio' => 75000,
        'imagen' => 'img/Hombres/Camiseta_Monastery_Beige.jpg',
        'descripcion' => 'Camiseta Monastery.',
        'id' => 2
    ],
    [
        'nombre' => 'Camiseta Gris',
        'precio' => 75000,
        'imagen' => 'img/Hombres/Camiseta_Monastery_Gris.jpg',
        'descripcion' => 'Camiseta Monastery.',
        'id' => 3
    ],
    [
        'nombre' => 'Camiseta Negra',
        'precio' => 75000,
        'imagen' => 'img/Hombres/Camiseta_Monastery_Negra.jpg',
        'descripcion' => 'Camiseta Monastery.',
        'id' => 4
    ],
    [
        'nombre' => 'Camiseta Roja',
        'precio' => 75000,
        'imagen' => 'img/Hombres/Camiseta_Monastery_Roja.jpg',
        'descripcion' => 'Camiseta Monastery.',
        'id' => 5
    ],
    // ... más productos ...
];

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>MyM</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">MyM</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Hombres
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="./Camisetas_H.php">Camisetas</a></li>
                            <li><a class="dropdown-item" href="./buzos_H.php">Buzos</a></li>
                            <li><a class="dropdown-item" href="./jeans_H.php">Jeans</a></li>
                            <li><a class="dropdown-item" href="./Deportiva_H.php">Deportiva</a></li>
                            <li><a class="dropdown-item" href="./pantalonetas_H.php">Pantalonetas</a></li>
                            <li><a class="dropdown-item" href="./gorras_H.php">Gorras</a></li>
                            <li><a class="dropdown-item" href="./zapatos_H.php">Zapatos</a></li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Mujeres
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="./Blusas_M.php">Blusas</a></li>
                            <li><a class="dropdown-item" href="./Buzos_M.php">Buzos</a></li>
                            <li><a class="dropdown-item" href="./jeans_M.php">Jeans</a></li>
                            <li><a class="dropdown-item" href="./Deportiva_M.php">Deportiva</a></li>
                            <li><a class="dropdown-item" href="./vestidos_M.php">Vestidos</a></li>
                            <li><a class="dropdown-item" href="./gorras_M.php">Gorras</a></li>
                            <li><a class="dropdown-item" href="./zapatos_M.php">Zapatos</a></li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Niños
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="./Camisas_Niño.php">Camisetas</a></li>
                            <li><a class="dropdown-item" href="./Buzos_Niños.php">Buzos</a></li>
                            <li><a class="dropdown-item" href="./Jeans_Niños.php">Jeans</a></li>
                            <li><a class="dropdown-item" href="./Deportiva_Niños.php">Deportiva</a></li>
                            <li><a class="dropdown-item" href="./pantalonetas_niños.php">Pantalonetas</a></li>
                            <li><a class="dropdown-item" href="./gorras_niños.php">Gorras</a></li>
                            <li><a class="dropdown-item" href="./zapatos_Niños.php">Zapatos</a></li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Niñas
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="./camisetas_Niña.php">Camisetas</a></li>
                            <li><a class="dropdown-item" href="./buzos_Niña.php">Buzos</a></li>
                            <li><a class="dropdown-item" href="./jean_Niña.php">Jeans</a></li>
                            <li><a class="dropdown-item" href="./deportiva_Niña.php">Deportiva</a></li>
                            <li><a class="dropdown-item" href="./vestidos_Niña.php">Vestidos</a></li>
                            <li><a class="dropdown-item" href="./gorras_Niñas.php">Gorras</a></li>
                            <li><a class="dropdown-item" href="./zapatos_Niñas.php">Zapatos</a></li>
                        </ul>
                    </li>
                </ul>

                <ul class="navbar-nav mb-2 mb-lg-0">
                    <?php if (isset($_SESSION['usuario'])): ?>
                    <li class="nav-item me-2">
                        <a class="btn btn-outline-primary" href="carrito_compras.php">
                        <i class="bi bi-cart"></i> Carrito
                        </a>
                    </li>
                    <li class="nav-item me-2">
                        <a class="btn btn-outline-secondary" href="pedidos.php">
                        <i class="bi bi-box-seam"></i> Mis pedidos
                        </a>
                    </li>
                    <li class="nav-item me-2">
                        <a class="btn btn-outline-dark" href="cuenta.php">
                        <i class="bi bi-person-circle"></i> Mi cuenta
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-danger text-white" href="php/logout.php">
                        <i class="bi bi-box-arrow-right"></i> Cerrar sesión
                        </a>
                    </li>
                    <?php else: ?>
                    <li class="nav-item">
                        <a class="btn btn-success text-white" href="../login-register/login-registro.php">
                        <i class="bi bi-person"></i> Iniciar sesión
                        </a>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>


    <div class="container">
        <div class="row g-4">
            <?php foreach ($productos as $producto): ?>
            <div class="col-12 col-sm-6 col-md-4">
                <div class="card h-100 shadow-sm d-flex flex-column">
                    <img src="<?php echo $producto['imagen']; ?>" class="card-img-top img-fluid" alt="<?php echo $producto['nombre']; ?>" style="height: 400px; object-fit: cover;">
                    <div class="card-body flex-grow-1">
                        <h5 class="card-title"><?php echo $producto['nombre']; ?></h5>
                        <h6 class="card-subtitle text-muted mb-2">$<?php echo number_format($producto['precio'], 0, ',', '.'); ?></h6>
                        <p class="card-text"><?php echo $producto['descripcion']; ?></p>
                    </div>
                    <div class="card-footer bg-white border-0 d-flex justify-content-between">
                        <a href="producto_detalle.php?id=<?php echo $producto['id']; ?>" class="btn btn-outline-primary btn-sm">Ver más</a>
                        <?php if (isset($_SESSION['usuario'])): ?>
                        <form action="carrito_compras.php" method="post">
                            <input type="hidden" name="producto_id" value="<?php echo $producto['id']; ?>">
                            <input type="hidden" name="nombre" value="<?php echo $producto['nombre']; ?>">
                            <input type="hidden" name="precio" value="<?php echo $producto['precio']; ?>">
                            <button type="submit" class="btn btn-success btn-sm agregar-carrito">Agregar al carrito</button>
                        </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script>
        // Si usas SweetAlert para confirmar la acción
        document.querySelectorAll('.agregar-carrito').forEach(btn => {
            btn.addEventListener('click', (event) => {
                event.preventDefault(); // Evitar la recarga de la página
                Swal.fire({
                    icon: 'success',
                    title: 'Agregado al carrito',
                    text: 'El producto ha sido agregado exitosamente.',
                    timer: 1500,
                    showConfirmButton: false
                });
                // Aquí podrías agregar la lógica para enviar los datos del producto al carrito (AJAX o submit del formulario)
                // Por ejemplo, si tienes el formulario dentro de la tarjeta:
                btn.closest('form').submit();
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>