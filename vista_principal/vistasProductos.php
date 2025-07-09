<?php
    session_start();
    include 'php/conexion_bd.php';

    // Recoger filtros desde la URL
    $categoria_id = isset($_GET['categoria']) ? intval($_GET['categoria']) : null;
    $genero = isset($_GET['genero']) ? $conexion->real_escape_string($_GET['genero']) : null;

    //consulta SQL
    $sql = "SELECT id, nombre, descripcion, precio, imagen FROM productos WHERE estado = 'activo'";

    if ($categoria_id) {
        $sql .= " AND categoria_id = $categoria_id";
    }
    if ($genero) {
        $sql .= " AND genero = '$genero'";
    }

    $resultado = $conexion->query($sql);

    $productos = [];
    if ($resultado->num_rows > 0) {
        while ($row = $resultado->fetch_assoc()) {
            $productos[$row['id']] = $row;
        }
    }

    $variantes = [];
    //Consulta de variantes, talla,color
    $sql = "
        SELECT vp.producto_id, t.id AS talla_id, t.talla, c.id AS color_id, c.color
        FROM variantes_producto vp
        JOIN tallas t ON vp.talla_id = t.id
        JOIN colores c ON vp.color_id = c.id
    ";
    $res = $conexion->query($sql);

    //Agrupa los productos por talla y color
    while ($row = $res->fetch_assoc()) {
        $pid = $row['producto_id'];
        $variantes[$pid]['tallas'][$row['talla_id']] = $row['talla'];
        $variantes[$pid]['colores_por_talla'][$row['talla_id']][] = [
            'id' => $row['color_id'],
            'color' => $row['color']
        ];
    }
    $conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Productos Filtrados</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <nav nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm fixed-top">
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
                            <li><a class="dropdown-item" href="vistasProductos.php?categoria=7&genero=hombre">Camisetas</a></li>
                            <li><a class="dropdown-item" href="vistasProductos.php?categoria=6&genero=hombre">Buzos</a></li>
                            <li><a class="dropdown-item" href="vistasProductos.php?categoria=10&genero=hombre">Jeans</a></li>
                            <li><a class="dropdown-item" href="vistasProductos.php?categoria=11&genero=hombre">Deportiva</a></li>
                            <li><a class="dropdown-item" href="vistasProductos.php?categoria=12&genero=hombre">Pantalonetas</a></li>
                            <li><a class="dropdown-item" href="vistasProductos.php?categoria=9&genero=hombre">Gorras</a></li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Mujeres
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="vistasProductos.php?categoria=13&genero=mujer">Blusas</a></li>
                            <li><a class="dropdown-item" href="vistasProductos.php?categoria=7&genero=mujer">Camisetas</a></li>
                            <li><a class="dropdown-item" href="vistasProductos.php?categoria=6&genero=mujer">Buzos</a></li>
                            <li><a class="dropdown-item" href="vistasProductos.php?categoria=10&genero=mujer">Jeans</a></li>
                            <li><a class="dropdown-item" href="vistasProductos.php?categoria=11&genero=mujer">Deportiva</a></li>
                            <li><a class="dropdown-item" href="vistasProductos.php?categoria=14&genero=mujer">Vestidos</a></li>
                            <li><a class="dropdown-item" href="vistasProductos.php?categoria=9&genero=mujer">Gorras</a></li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Niños
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="vistasProductos.php?categoria=7&genero=niño">Camisetas</a></li>
                            <li><a class="dropdown-item" href="vistasProductos.php?categoria=6&genero=niño">Buzos</a></li>
                            <li><a class="dropdown-item" href="vistasProductos.php?categoria=10&genero=niño">Jeans</a></li>
                            <li><a class="dropdown-item" href="vistasProductos.php?categoria=11&genero=niño">Deportiva</a></li>
                            <li><a class="dropdown-item" href="vistasProductos.php?categoria=12&genero=niño">Pantalonetas</a></li>
                            <li><a class="dropdown-item" href="vistasProductos.php?categoria=9&genero=niño">Gorras</a></li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Niñas
                        </a>
                          <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="vistasProductos.php?categoria=13&genero=niña">Blusas</a></li>
                            <li><a class="dropdown-item" href="vistasProductos.php?categoria=7&genero=niña">Camisetas</a></li>
                            <li><a class="dropdown-item" href="vistasProductos.php?categoria=6&genero=niña">Buzos</a></li>
                            <li><a class="dropdown-item" href="vistasProductos.php?categoria=10&genero=niña">Jeans</a></li>
                            <li><a class="dropdown-item" href="vistasProductos.php?categoria=11&genero=niña">Deportiva</a></li>
                            <li><a class="dropdown-item" href="vistasProductos.php?categoria=14&genero=niña">Vestidos</a></li>
                            <li><a class="dropdown-item" href="vistasProductos.php?categoria=9&genero=niña">Gorras</a></li>
                        </ul>
                    </li>
                </ul>

                <ul class="navbar-nav mb-2 mb-lg-0">
                    <?php if (isset($_SESSION['usuario'])): ?>
                    <li class="nav-item me-2">
                        <a class="btn btn-outline-primary position-relative" href="carrito_compras.php">
                        <i class="bi bi-cart"></i> Carrito
                        </a> 


                    </li>
                    <li class="nav-item me-2">
                        <a class="btn btn-outline-secondary" href="pedidosUser.php">
                        <i class="bi bi-box-seam"></i> Mis pedidos
                        </a>
                    </li>
                    <!-- <li class="nav-item me-2">
                        <a class="btn btn-outline-dark" href="cuenta.php">
                        <i class="bi bi-person-circle"></i> Mi cuenta
                        </a>
                    </li> -->
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


    <div class="container mt-5 pt-4">
        <div class="row g-4">
            <!-- Verifica si la variable está vacía o hay algo en ella -->
            <?php if (empty($productos)): ?>
                <div class="col-12">
                    <div class="alert alert-warning text-center">No hay productos que coincidan con los filtros.</div>
                </div>
            <?php endif; ?>

            <!-- tarjeta para cada producto -->
            <?php foreach ($productos as $id => $producto): ?>
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="card h-100 shadow-sm d-flex flex-column">
                        <img src="../img/<?= $producto['imagen']; ?>" class="card-img-top img-fluid" alt="<?= $producto['nombre']; ?>" style="height: 400px; object-fit: cover;">
                        <div class="card-body flex-grow-1">
                            <h5 class="card-title"><?= $producto['nombre']; ?></h5>
                            <h6 class="card-subtitle text-muted mb-2">COP$<?= number_format($producto['precio'], 0, ',', '.'); ?></h6>
                            <p class="card-text"><?= $producto['descripcion']; ?></p>
                        </div>
                        <div class="card-footer bg-white border-0 d-flex justify-content-between">
                            <?php if (isset($_SESSION['usuario'])): ?>
                                <form method="post" class="form-agregar-carrito">
                                    <input type="hidden" name="producto_id" value="<?= $id; ?>">

                                    <!-- Select de Talla -->
                                    <select class="form-select form-select-sm mb-1 select-talla" name="talla_id" data-producto="<?= $id ?>" required>
                                        <option value="">Seleccione talla</option>
                                        <?php if (isset($variantes[$id]['tallas'])): ?>
                                            <?php foreach ($variantes[$id]['tallas'] as $talla_id => $talla): ?>
                                                <option value="<?= $talla_id ?>"><?= $talla ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>

                                    <!-- Select de Color -->
                                    <select class="form-select form-select-sm mb-1 select-color" name="color_id" required disabled>
                                        <option value="">Seleccione color</option>
                                    </select>

                                    <!-- Botón -->
                                    <button type="button" class="btn btn-primary btn-agregar" data-producto="<?= $id ?>">Agregar al carrito</button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>


    <footer class="bg-dark text-white mt-5 pt-4 pb-3">
        <div class="container">
            <div class="row">

            <div class="col-md-4 mb-3">
                <h5 class="fw-bold">MyM</h5>
                <p class="text-white">Tu estilo, tu elección. Ropa para todos los géneros y edades.</p>
            </div>

            <div class="col-md-4 mb-3">
                <h6 class="text-uppercase">Enlaces</h6>
                <ul class="list-unstyled">
                <li><a href="index.php" class="text-white text-decoration-none">Inicio</a></li>
                <li><a href="vistasProductos.php" class="text-white text-decoration-none">Productos</a></li>
                <li><a href="cuenta.php" class="text-white text-decoration-none">Mi cuenta</a></li>
                <li><a href="contacto.php" class="text-white text-decoration-none">Contacto</a></li>
                </ul>
            </div>

            <div class="col-md-4 mb-3">
                <h6 class="text-uppercase">Síguenos</h6>
                <a href="#" class="text-white d-block mb-1">
                <i class="bi bi-facebook me-1"></i> Facebook
                </a>
                <a href="#" class="text-white d-block mb-1">
                <i class="bi bi-instagram me-1"></i> Instagram
                </a>
                <a href="#" class="text-white d-block">
                <i class="bi bi-tiktok me-1"></i> TikTok
                </a>
            </div>

            </div>

            <hr class="border-light">

            <div class="text-center text-muted small">
            &copy; <?= date("Y") ?> MyM. Todos los derechos reservados.
            </div>
        </div>
    </footer>

    <!-- JS para selects -->
    <script>
        //Select de talla y según la talla el color
        document.querySelectorAll('.select-talla').forEach(selectTalla => {
            selectTalla.addEventListener('change', function () {
                const card = this.closest('.card');
                const producto_id = this.dataset.producto;
                const talla_id = this.value;
                const colorSelect = card.querySelector('.select-color');


                //si no se selecciona una talla valida el selector de colores se desactiva
                if (!talla_id) {
                    colorSelect.innerHTML = '<option value="">Seleccione color</option>';
                    colorSelect.disabled = true;
                    return;
                }

                //Peticion de color segun producto y talla
                fetch('obtencion_colores.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `producto_id=${producto_id}&talla_id=${talla_id}`
                })
                .then(res => res.json())
                .then(data => {
                    colorSelect.innerHTML = '<option value="">Seleccione color</option>';

                    if (data.success) { 
                        data.colores.forEach(color => {
                            const option = document.createElement('option');
                            option.value = color.id;
                            option.textContent = color.color;
                            colorSelect.appendChild(option);
                        });
                        colorSelect.disabled = false;
                    } else { //Error con sweetalert
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'No se pudieron cargar los colores: ' + data.message
                        });
                        colorSelect.disabled = true;
                    }
                })
                .catch(error => { //Error en la conexion
                    colorSelect.innerHTML = '<option value="">Error de conexión</option>';
                    colorSelect.disabled = true;
                    Swal.fire({
                        icon: 'error',
                        title: 'Error de red',
                        text: 'Hubo un problema al conectar con el servidor.'
                    });
                });
            });
        });
    </script>

    <!-- JS para agregar al carrito -->
    <script>
        document.querySelectorAll('.btn-agregar').forEach(btn => {
            btn.addEventListener('click', function () {
                //Cuando se hace click en agregar al carrito se obtiene la info de la tarjeta
                const card = this.closest('.card'); 
                const producto_id = this.getAttribute('data-producto');
                const tallaSelect = card.querySelector('.select-talla');
                const colorSelect = card.querySelector('.select-color');

                const talla_id = tallaSelect.value;
                const color_id = colorSelect.value;

                if (!talla_id || !color_id) {
                    Swal.fire({ //Aviso de que no se ha seleccionado talla o color
                        icon: 'warning',
                        title: '¡Ups!',
                        text: 'Por favor selecciona una talla y un color.',
                        confirmButtonColor: '#3085d6'
                    });
                    return;
                }
                //Peticion para agregar al carrito
                fetch('add_carrito.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `producto_id=${producto_id}&talla_id=${talla_id}&color_id=${color_id}`
                })
                .then(res => res.text())
                .then(data => {
                    if (data === 'ok') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Agregado al carrito',
                            text: 'El producto ha sido añadido correctamente.',
                            timer: 2000,
                            showConfirmButton: false
                        });

                        //reinicia los selectores
                        tallaSelect.selectedIndex = 0; 
                        colorSelect.innerHTML = '<option value="">Seleccione color</option>';
                        colorSelect.disabled = true;
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data
                        });
                    }
                    actualizarContadorCarrito();
                });
            });
        });

        function actualizarContadorCarrito() {
            fetch('carrito_contador.php')
                .then(res => res.text())
                .then(total => {
                    const badge = document.getElementById('contador-carrito');
                    if (badge) {
                        badge.textContent = total;
                    }
                });
        }

        actualizarContadorCarrito();
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>