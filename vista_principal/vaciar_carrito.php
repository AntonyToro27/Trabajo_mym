<?php
require 'php/conexion_bd.php';
session_start();

if (!isset($_SESSION['usuario_id'])) {
    echo "No autorizado";
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

$stmt = $conexion->prepare("DELETE FROM carrito WHERE usuario_id = ?");
if ($stmt->execute([$usuario_id])) {
    echo "ok";
} else {
    echo "Error al vaciar el carrito";
}
?>
