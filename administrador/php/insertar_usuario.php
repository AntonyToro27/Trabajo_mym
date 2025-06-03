<?php
include('conexion.php');

$cedula = trim($_POST['cedula']);
$nombre_completo = trim($_POST['nombre_completo']);
$email = trim($_POST['email']);
$telefono = trim($_POST['telefono']);
$direccion = trim($_POST['direccion']);
$rol = $_POST['rol'];
$contrasena = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);

// 🧪 Validamos que no exista el mismo email o cédula
$verifica = "SELECT * FROM Usuarios WHERE email = '$email' OR cedula = '$cedula'";
$resultado = mysqli_query($conexion, $verifica);

if (mysqli_num_rows($resultado) > 0) {
    // ⚠️ Ya existe un usuario con ese correo o cédula
    echo "<script>alert('Error: El correo o la cédula ya están registrados.'); window.location.href='usuarios.php';</script>";
    exit();
}

// ✔️ Si pasa la validación, insertamos el usuario
$insertar = "INSERT INTO Usuarios (cedula, nombre_completo, email, telefono, direccion, contrasena, rol) 
VALUES ('$cedula', '$nombre_completo', '$email', '$telefono', '$direccion', '$contrasena', '$rol')";

mysqli_query($conexion, $insertar);

// 🔁 Redireccionamos
header("Location: usuarios.php");
exit();
