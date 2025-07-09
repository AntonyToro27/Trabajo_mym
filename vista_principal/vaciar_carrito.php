<?php
    require 'php/conexion_bd.php';
    session_start();

    //Verifica el id del usuario
    if (!isset($_SESSION['usuario_id'])) {
        echo "No autorizado";
        exit;
    }

    $usuario_id = $_SESSION['usuario_id'];

    //Elimina los productos q esten asociados al id
    $stmt = $conexion->prepare("DELETE FROM carrito WHERE usuario_id = ?");
    //Se ejecuta la setencia anterior
    if ($stmt->execute([$usuario_id])) {
        echo "ok";
    } else {
        echo "Error al vaciar el carrito";
    }
?>
