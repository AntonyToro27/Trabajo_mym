<?php
require 'php/conexion_bd.php';
session_start();

if (!isset($_SESSION['usuario_id']) || !isset($_POST['carrito_id'])) {
    echo "Datos incompletos";
    exit;
}

$carrito_id = $_POST['carrito_id'];
$stmt = $conexion->prepare("DELETE FROM carrito WHERE id = ?");
if ($stmt->execute([$carrito_id])) {
    echo "ok";
} else {
    echo "Error al eliminar";
}
?>

