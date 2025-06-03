<?php
session_start();

// 🛡️ Validamos que el usuario tenga rol de admin
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../../login-register/login-registro.php");
    exit();
}

// 🔌 Conectamos a la base de datos
include('conexion.php');

// 🔍 Consultamos todos los usuarios registrados
$consulta = "SELECT id, cedula, nombre_completo, email, telefono, direccion, rol FROM Usuarios";
$resultado = mysqli_query($conexion, $consulta);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
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

<body class="p-4">
    <h2 class="mb-4">Usuarios Registrados</h2>

    <a href="admin.php" class="btn btn-secondary mb-3">⬅ Volver al Panel</a>

    <!-- 🧾 Tabla de usuarios existentes -->
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
                        <!-- ✏️ Botón EDITAR (usa POST para enviar el ID al formulario) -->
                        <form action="editar_usuario.php" method="POST" style="display:inline;">
                            <input type="hidden" name="id_editar" value="<?= $fila['id'] ?>">
                            <button type="submit" class="btn btn-sm btn-warning">Editar</button>
                        </form>

                        <!-- 🗑️ Botón ELIMINAR (también lo haremos POST luego si quieres) -->
                        <form action="eliminar_usuario.php" method="POST" style="display:inline;" onsubmit="return confirm('¿Eliminar este usuario?')">
                            <input type="hidden" name="id" value="<?= $fila['id'] ?>">
                            <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <!-- ➕ Formulario para registrar un nuevo usuario -->
    <h3 class="mt-5">Agregar nuevo usuario</h3>
    <form action="insertar_usuario.php" method="POST" class="row g-3">
        <div class="col-md-4">
            <input type="text" name="cedula" class="form-control" placeholder="Cédula" required>
        </div>
        <div class="col-md-4">
            <input type="text" name="nombre_completo" class="form-control" placeholder="Nombre completo" required>
        </div>
        <div class="col-md-4">
            <input type="email" name="email" class="form-control" placeholder="Email" required>
        </div>
        <div class="col-md-4">
            <input type="text" name="telefono" class="form-control" placeholder="Teléfono">
        </div>
        <div class="col-md-4">
            <input type="text" name="direccion" class="form-control" placeholder="Dirección">
        </div>
        <div class="col-md-4">
            <input type="password" name="contrasena" class="form-control" placeholder="Contraseña" required>
        </div>
        <div class="col-md-4">
            <select name="rol" class="form-select">
                <option value="cliente">Cliente</option>
                <option value="admin">Administrador</option>
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-success w-100">Agregar</button>
        </div>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
