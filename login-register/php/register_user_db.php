<?php
include 'conexion_db.php';
header('Content-Type: application/json');

$nombre_completo = $_POST['nombre_completo'] ?? '';
$email = $_POST['email'] ?? '';
$password = hash('sha512', $_POST['password'] ?? '');

$verificar_correo = mysqli_query($conexion, "SELECT * FROM usuarios WHERE email='$email'");
if (mysqli_num_rows($verificar_correo) > 0) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Este correo ya está registrado.'
    ]);
    exit();
}

$query = "INSERT INTO usuarios(nombre_completo, email, contrasena) VALUES('$nombre_completo', '$email', '$password')";
$ejecutar = mysqli_query($conexion, $query);

if ($ejecutar) {
    echo json_encode([
        'status' => 'ok',
        'message' => 'Usuario registrado exitosamente.'
    ]);
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'No se pudo registrar el usuario.'
    ]);
}
mysqli_close($conexion);
?>




