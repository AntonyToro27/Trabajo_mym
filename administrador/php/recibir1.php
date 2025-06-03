<!-- //Para recibir info de la db -->

<?php
session_start();
include('conexion.php');

// Recibir datos del formulario
$nombre = $_POST['nombre'];
$correo = $_POST['correo'];
$contrasena = $_POST['contrasena'];
$direccion = $_POST['direccion'];
$telefono = $_POST['telefono'];

// Validación: ¿el correo ya está registrado?
$verificar = "SELECT * FROM usuarios WHERE correo = '$correo'";
$resultado = mysqli_query($conexion, $verificar);

if (mysqli_num_rows($resultado) > 0) {
    $mensaje = "El correo ya está registrado. Intenta con otro.";
    header("Location: formulario_pago.html?var=" . urlencode($mensaje));
    exit();
}

// Insertar en la base de datos
$insertar = "INSERT INTO usuarios (nombre_completo, correo, contrasena, telefono, direccion)
             VALUES ('$nombre', '$correo', '$contrasena', '$telefono', '$direccion')";

if (mysqli_query($conexion, $insertar)) {
    $mensaje = "✅ Registro exitoso. Ahora puedes iniciar sesión.";
    header("Location: loginA.php?var=" . urlencode($mensaje));
    exit();
} else {
    $mensaje = "❌ Error al registrar: " . mysqli_error($conexion);
    header("Location: formulario_pago.html?var=" . urlencode($mensaje));
    exit();
}|
