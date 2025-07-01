<?php
session_start();
include 'conexion_db.php';

header('Content-Type: application/json');

$email = $_POST['email'] ?? '';
$password = hash('sha512', $_POST['password'] ?? '');

$stmt = $conexion->prepare("SELECT id, email, rol FROM usuarios WHERE email = ? AND contrasena = ?");
$stmt->bind_param("ss", $email, $password);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows > 0) {
    $usuario = $resultado->fetch_assoc();

    $_SESSION['usuario_id'] = $usuario['id'];
    $_SESSION['usuario'] = $usuario['email'];
    $_SESSION['rol'] = $usuario['rol'];

    $redirect = ($usuario['rol'] === 'admin') 
                ? '../administrador/php/admin.php' 
                : '../vista_principal/vistaPrincipal.php';

    echo json_encode([
        'status' => 'ok',
        'message' => 'Inicio de sesión exitoso.',
        'redirect' => $redirect
    ]);
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Usuario o contraseña incorrectos.'
    ]);
}


