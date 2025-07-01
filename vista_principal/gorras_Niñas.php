<?php
    session_start();
    // if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'cliente') {
    //     header("Location: ../login-register/login-registro.php");
    //     exit();
    // }

?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>MyM</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap y Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">MyM</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <!-- Menú izquierdo -->
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

                <!-- Menú derecho (botones dinámicos) -->
                <ul class="navbar-nav mb-2 mb-lg-0">
                    <?php if (isset($_SESSION['usuario'])): ?>
                    <li class="nav-item me-2">
                        <a class="btn btn-outline-primary" href="php/carrito.php">
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




    <!-- img/Hombres/Camiseta_Monastery_Negra.jpg -->


    <!-- Carrusel de imágenes con altura fija -->
    


    <!-- TARJETAS DE PRODUCTOS -->
    

    <div class="container">
        <div class="row g-4">
        
            <!-- Tarjeta 1 -->
            <div class="col-12 col-sm-6 col-md-4">
                <div class="card h-100 shadow-sm d-flex flex-column">
                        <img src="https://assets.adidas.com/images/h_2000,f_auto,q_auto,fl_lossy,c_fill,g_auto/8e8eddc934104b3d85baa1d456c44748_9366/Gorra_adidas_X_Disney_Lilo_and_Stitch_Kids_Azul_JD4240_01_00_standard.jpg" class="card-img-top img-fluid" alt="Producto B" style="height: 400px;">
                    <div class="card-body flex-grow-1">
                        <h5 class="card-title">Gorra adidas X Disney Lilo & Stitch</h5>
                        <h6 class="card-subtitle text-muted mb-2">$75.000</h6>
                        <p class="card-text">Gorra adidas X Disney Lilo & Stitch.</p>
                    </div>
                    <div class="card-footer bg-white border-0 d-flex justify-content-between">
                        <a href="#" class="btn btn-outline-primary btn-sm">Ver más</a>
                        <?php if (isset($_SESSION['usuario'])): ?>
                            <button class="btn btn-success btn-sm agregar-carrito">Agregar al carrito</button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Tarjeta 2 -->
            <div class="col-12 col-sm-6 col-md-4">
                <div class="card h-100 shadow-sm d-flex flex-column">
                        <img src="https://assets.adidas.com/images/h_2000,f_auto,q_auto,fl_lossy,c_fill,g_auto/9f82c6e800ce4287ae451c482af13248_9366/Gorra_adidas_x_Disney_Minnie_Mouse_Ninos_Rosa_JH3418_01_00_standard.jpg" class="card-img-top img-fluid" alt="Producto B" style="height: 400px;">
                    <div class="card-body flex-grow-1">
                        <h5 class="card-title">Gorra adidas x Disney Minnie Mouse</h5>
                        <h6 class="card-subtitle text-muted mb-2">$75.000</h6>
                        <p class="card-text">Gorra adidas x Disney Minnie Mouse.</p>
                    </div>
                    <div class="card-footer bg-white border-0 d-flex justify-content-between">
                        <a href="#" class="btn btn-outline-primary btn-sm">Ver más</a>
                        <?php if (isset($_SESSION['usuario'])): ?>
                            <button class="btn btn-success btn-sm agregar-carrito">Agregar al carrito</button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

                <!-- Tarjeta 3 -->
                <div class="col-12 col-sm-6 col-md-4">
                <div class="card h-100 shadow-sm d-flex flex-column">
                        <img src="https://assets.adidas.com/images/h_840,f_auto,q_auto,fl_lossy,c_fill,g_auto/2e2535b251104232bc09fb67776ed492_9366/Gorra_Beisbol_Ninos_Rosa_IY6694_01_00_standard.jpg" class="card-img-top img-fluid" alt="Producto B" style="height: 400px;">
                    <div class="card-body flex-grow-1">
                        <h5 class="card-title">Gorra Béisbolera</h5>
                        <h6 class="card-subtitle text-muted mb-2">$75.000</h6>
                        <p class="card-text">Gorra Béisbolera.</p>
                    </div>
                    <div class="card-footer bg-white border-0 d-flex justify-content-between">
                        <a href="#" class="btn btn-outline-primary btn-sm">Ver más</a>
                        <?php if (isset($_SESSION['usuario'])): ?>
                            <button class="btn btn-success btn-sm agregar-carrito">Agregar al carrito</button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>


                <!-- Tarjeta 4 -->
                <div class="col-12 col-sm-6 col-md-4">
                <div class="card h-100 shadow-sm d-flex flex-column">
                        <img src="https://assets.adidas.com/images/h_2000,f_auto,q_auto,fl_lossy,c_fill,g_auto/c7922915924849e7a891e5c01795f57b_9366/Gorra_Trucker_Youth_Negro_IT7344_01_standard.jpg" class="card-img-top img-fluid" alt="Producto B" style="height: 400px;">
                    <div class="card-body flex-grow-1">
                        <h5 class="card-title">Gorra Trucker Youth</h5>
                        <h6 class="card-subtitle text-muted mb-2">$75.000</h6>
                        <p class="card-text">Gorra Trucker Youth.</p>
                    </div>
                    <div class="card-footer bg-white border-0 d-flex justify-content-between">
                        <a href="#" class="btn btn-outline-primary btn-sm">Ver más</a>
                        <?php if (isset($_SESSION['usuario'])): ?>
                            <button class="btn btn-success btn-sm agregar-carrito">Agregar al carrito</button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

                <!-- Tarjeta 5 -->
                <div class="col-12 col-sm-6 col-md-4">
                <div class="card h-100 shadow-sm d-flex flex-column">
                        <img src="https://assets.adidas.com/images/h_2000,f_auto,q_auto,fl_lossy,c_fill,g_auto/d0cc376d9565417d88809e3c0d503da9_9366/Gorro_adidas_Originals_x_Liberty_London_Bucket_Ninos_Multicolor_JC8518_01_00_standard.jpg" class="card-img-top img-fluid" alt="Producto B" style="height: 400px;">
                    <div class="card-body flex-grow-1">
                        <h5 class="card-title">Gorro adidas Originals x Liberty London Bucket</h5>
                        <h6 class="card-subtitle text-muted mb-2">$85.000</h6>
                        <p class="card-text">Gorro adidas Originals x Liberty London Bucket.</p>
                    </div>
                    <div class="card-footer bg-white border-0 d-flex justify-content-between">
                        <a href="#" class="btn btn-outline-primary btn-sm">Ver más</a>
                        <?php if (isset($_SESSION['usuario'])): ?>
                            <button class="btn btn-success btn-sm agregar-carrito">Agregar al carrito</button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>



                
                        

        </div>
    </div>

  <script>
    // Si usas SweetAlert para confirmar la acción
    document.querySelectorAll('.agregar-carrito').forEach(btn => {
      btn.addEventListener('click', () => {
        Swal.fire({
          icon: 'success',
          title: 'Agregado al carrito',
          text: 'El producto ha sido agregado exitosamente.',
          timer: 1500,
          showConfirmButton: false
        });
      });
    });
  </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>