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




    <!-- img/Hombres/Camiseta_Monastery_Negra.jpg -->


    <!-- Carrusel de imágenes con altura fija -->
    


    <!-- TARJETAS DE PRODUCTOS -->
    

    <div class="container">
        <div class="row g-4">
        
            <!-- Tarjeta 1 -->
            <div class="col-12 col-sm-6 col-md-4">
                <div class="card h-100 shadow-sm d-flex flex-column">
                        <img src="img/Hombres/Sudadera_con_Capucha_Gris_Oscuro.jpeg" class="card-img-top img-fluid" alt="Producto B" style="height: 400px;">
                    <div class="card-body flex-grow-1">
                        <h5 class="card-title">Sudadera gris oscuro</h5>
                        <h6 class="card-subtitle text-muted mb-2">$75.000</h6>
                        <p class="card-text">Sudadera gris oscuro con capucha.</p>
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
                        <img src="img/Hombres/Sudadera_Monastery_Blanca.jpg" class="card-img-top img-fluid" alt="Producto B" style="height: 400px;">
                    <div class="card-body flex-grow-1">
                        <h5 class="card-title">Sudadera Monasatery Blanca</h5>
                        <h6 class="card-subtitle text-muted mb-2">$75.000</h6>
                        <p class="card-text">Sudadera Monastery Blanca.</p>
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
                        <img src="img/Hombres/Sudadera_con_Capucha_Verde_Oscuro.jpeg" class="card-img-top img-fluid" alt="Producto B" style="height: 400px;">
                    <div class="card-body flex-grow-1">
                        <h5 class="card-title">Sudadera verde oscura </h5>
                        <h6 class="card-subtitle text-muted mb-2">$75.000</h6>
                        <p class="card-text">Sudadera verde oscura con capucha.</p>
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
                        <img src="img/Hombres/Sudadera_Monastery_Negra.jpg " class="card-img-top img-fluid" alt="Producto B" style="height: 400px;">
                    <div class="card-body flex-grow-1">
                        <h5 class="card-title">Sudadera Monastery Negra</h5>
                        <h6 class="card-subtitle text-muted mb-2">$75.000</h6>
                        <p class="card-text">Sudadera Monastery Negra.</p>
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
                        <img src="https://encrypted-tbn2.gstatic.com/shopping?q=tbn:ANd9GcSqNDMb3KObQMBrpNJ-GM2RwrbABhnHahlFvZu68l_lBbAQUhBMeYPVxgjiKmEtHTb0haVrU6Js2mSMGd5gvXcOsYG6PqLHszKxdmVl_v5rRXfKC-4Qld6EnQ" class="card-img-top img-fluid" alt="Producto B" style="height: 400px;">
                    <div class="card-body flex-grow-1">
                        <h5 class="card-title">Sudadera rosa con capucha</h5>
                        <h6 class="card-subtitle text-muted mb-2">$75.000</h6>
                        <p class="card-text">Sudadera rosada con capucha.</p>
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