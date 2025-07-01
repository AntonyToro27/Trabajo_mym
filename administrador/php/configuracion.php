<?php
// 🛡️ 1. Iniciamos la sesión para verificar si el usuario está autenticado
session_start();

// 🛡️ 2. Validamos que el usuario tenga el rol 'admin'
// Si no lo es, lo redirigimos al login por seguridad
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin' || !isset($_SESSION['usuario_id'])) {
    header("Location: ../../login-register/login-registro.php");
    exit();
}

// 🔌 3. Incluimos el archivo de conexión a la base de datos
include('conexion.php');

// 🧠 4. Obtenemos el ID del administrador desde la sesión
// IMPORTANTE: Este ID debe guardarse en $_SESSION['id'] al momento del login
$id_admin = $_SESSION['usuario_id'];


// 🔍 5. Consultamos los datos actuales del administrador
$consulta = "SELECT * FROM Usuarios WHERE id = $id_admin";
$resultado = mysqli_query($conexion, $consulta);
$admin = mysqli_fetch_assoc($resultado); // Obtenemos los datos como array asociativo

// 📝 6. Si el formulario fue enviado por POST, actualizamos los datos
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // 🔢 6.1 Capturamos los datos del formulario
    $nombre = $_POST['nombre_completo'];
    $email = $_POST['email'];
    $contrasena_nueva = $_POST['contrasena']; // Este campo puede estar vacío

    // 🧪 6.2 Validamos que el nuevo correo no lo tenga otro usuario
    $verifica = "SELECT * FROM Usuarios WHERE email = '$email' AND id != $id_admin";
    $verif = mysqli_query($conexion, $verifica);

    // ⚠️ Si ya existe otro usuario con ese email, mostramos un error
    if (mysqli_num_rows($verif) > 0) {
        echo "<script>alert('Este correo ya está en uso.'); window.location.href='configuracion.php';</script>";
        exit();
    }

    // 🧠 6.3 Si el campo contraseña está vacío, no se actualiza
    if (!empty($contrasena_nueva)) {
        // Encriptamos la nueva contraseña antes de guardarla
        $hash = password_hash($contrasena_nueva, PASSWORD_DEFAULT);

        // Actualizamos todos los datos incluyendo la contraseña
        $update = "UPDATE Usuarios SET nombre_completo='$nombre', email='$email', contrasena='$hash' WHERE id = $id_admin";
    } else {
        // Actualizamos solo nombre y email
        $update = "UPDATE Usuarios SET nombre_completo='$nombre', email='$email' WHERE id = $id_admin";
    }

    // Ejecutamos la consulta de actualización
    mysqli_query($conexion, $update);

    // 🟢 Mostramos mensaje de éxito y recargamos la página
    $_SESSION['mensaje_exito'] = 'Datos actualizados correctamente.';
    header("Location: configuracion.php");
    exit();
    }
?>

<!-- 🌐 HTML con formulario para editar los datos del administrador -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Configuración</title>
    <link rel="stylesheet" href="../css/estiloSidebar.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    
    <?php if (isset($_SESSION['mensaje_exito'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $_SESSION['mensaje_exito']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['mensaje_exito']); ?>
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
                <li class="nav-item mb-2"><a href="listado_variante.php" class="nav-link text-white">🎯Editar Variantes</a></li>
                <li class="nav-item mb-2"><a href="pedidos.php" class="nav-link text-white">🧾 Pedidos</a></li>
                <li class="nav-item mb-2"><a href="usuarios.php" class="nav-link text-white">👥 Usuarios</a></li>
                <li class="nav-item mb-2"><a href="categorias.php" class="nav-link text-white">📂 Categorías</a></li>
                <li class="nav-item mt-4"><a href="cerrarSesion.php" class="btn btn-danger w-100">Cerrar sesión</a></li>
            </ul>
        </div>

        <!-- Contenido principal -->
        <div class="p-4 w-100">
            <h2>Configuración del Administrador</h2>

            <!-- Alerta de éxito -->
            <?php if (isset($_SESSION['mensaje_exito'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= $_SESSION['mensaje_exito']; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php unset($_SESSION['mensaje_exito']); ?>
            <?php endif; ?>

            <!-- Botón de volver -->
            <a href="admin.php" class="btn btn-secondary mb-3">⬅ Volver</a>

            <!-- Formulario de configuración -->
            <form method="POST" class="row g-3">
                <div class="col-md-6">
                    <label>Nombre completo</label>
                    <input type="text" name="nombre_completo" value="<?= $admin['nombre_completo'] ?>" class="form-control" required>
                </div>

                <div class="col-md-6">
                    <label>Email</label>
                    <input type="email" name="email" value="<?= $admin['email'] ?>" class="form-control" required>
                </div>

                <div class="col-md-6">
                    <label>Contraseña nueva (opcional)</label>
                    <input type="password" name="contrasena" class="form-control" placeholder="Deja vacío para no cambiarla">
                </div>

                <div class="col-md-2">
                    <button type="submit" class="btn btn-success w-100 mt-4">Actualizar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('show');
        }
    </script>
</body>
</html>
