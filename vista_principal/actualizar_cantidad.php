<?php
require 'php/conexion_bd.php';
session_start();

if (!isset($_SESSION['usuario_id']) || !isset($_POST['carrito_id']) || !isset($_POST['cantidad'])) {
    echo "Datos incompletos";
    exit;
}

$carrito_id = $_POST['carrito_id'];
$cantidad = max(1, (int)$_POST['cantidad']);

$stmt = $conexion->prepare("UPDATE carrito SET cantidad = ? WHERE id = ?");
if ($stmt->execute([$cantidad, $carrito_id])) {
    echo "ok";
} else {
    echo "Error al actualizar";
}
?>
