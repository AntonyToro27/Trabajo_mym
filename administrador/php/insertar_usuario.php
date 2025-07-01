<?php
include('conexion.php');

// Sanitización de entradas
$cedula = trim($_POST['cedula']);
$nombre_completo = trim($_POST['nombre_completo']);
$email = trim($_POST['email']);
$telefono = trim($_POST['telefono']);
$direccion = trim($_POST['direccion']);
$contrasena = trim($_POST['contrasena']);
$rol = $_POST['rol'];

// Validar que el rol sea válido (evita que llegue vacío o malicioso)
$roles_validos = ['admin', 'cliente'];
if (!in_array($rol, $roles_validos)) {
    echo "<script>alert('Rol inválido.'); window.location.href='usuarios.php';</script>";
    exit();
}

// Encriptar contraseña
$hash_contrasena = password_hash($contrasena, PASSWORD_DEFAULT);

// Validar si ya existe el usuario por correo o cédula
$verifica = "SELECT * FROM Usuarios WHERE email = ? OR cedula = ?";
$stmt_verifica = mysqli_prepare($conexion, $verifica);
mysqli_stmt_bind_param($stmt_verifica, 'ss', $email, $cedula);
mysqli_stmt_execute($stmt_verifica);
mysqli_stmt_store_result($stmt_verifica);

if (mysqli_stmt_num_rows($stmt_verifica) > 0) {
    echo "<script>alert('Error: El correo o la cédula ya están registrados.'); window.location.href='usuarios.php';</script>";
    exit();
}
mysqli_stmt_close($stmt_verifica);

// Insertar usuario usando consulta preparada (más seguro)
$insertar = "INSERT INTO Usuarios (cedula, nombre_completo, email, telefono, direccion, contrasena, rol)
             VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt_insertar = mysqli_prepare($conexion, $insertar);
mysqli_stmt_bind_param($stmt_insertar, 'sssssss', $cedula, $nombre_completo, $email, $telefono, $direccion, $hash_contrasena, $rol);

if (mysqli_stmt_execute($stmt_insertar)) {
    header("Location: usuarios.php?mensaje=usuario_agregado");
    exit();
} else {
    echo "<script>alert('Error al insertar el usuario.'); window.location.href='usuarios.php';</script>";
}
?>
