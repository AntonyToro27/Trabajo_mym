<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: loginA.php"); //cambiar locacion
    exit();
}

include('conexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']); // Convertimos a entero por seguridad

    $query = "DELETE FROM pedidos WHERE id = $id";

    if (mysqli_query($conexion, $query)) {
        header("Location: pedidos.php");
        exit();
    } else {
        echo "Error al eliminar el pedido: " . mysqli_error($conexion);
    }
} else {
    echo "Acceso no autorizado o ID no proporcionado.";
}
?>
