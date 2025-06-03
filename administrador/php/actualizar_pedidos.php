<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'admin') {
    header("Location: loginA.php");
    exit();
}

include('conexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id']) && isset($_POST['estado'])) {
    $id = $_POST['id'];
    $estado = $_POST['estado'];

    $query = "UPDATE pedidos SET estado = '$estado' WHERE id = $id";
    $resultado = mysqli_query($conexion, $query);

    if ($resultado) {
        $_SESSION['mensaje_exito'] = "Estado del pedido actualizado correctamente.";
    } else {
        $_SESSION['mensaje_error'] = "Error al actualizar el estado del pedido.";
    }

    header("Location: pedidos.php");
    exit();
} else {
    header("Location: pedidos.php");
    exit();
}
