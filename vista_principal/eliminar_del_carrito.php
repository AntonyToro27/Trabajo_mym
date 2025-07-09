<?php
    require 'php/conexion_bd.php';
    session_start();

    //verifica usuario logueado y el id del producto a eliminar
    if (!isset($_SESSION['usuario_id']) || !isset($_POST['carrito_id'])) {
        echo "Datos incompletos";
        exit;
    }
    //guarda id en variable
    $carrito_id = $_POST['carrito_id'];
    //consulta preparada, elimina la fila que coincida con el id del producto a eliminar 
    $stmt = $conexion->prepare("DELETE FROM carrito WHERE id = ?");
    //Se ejecuta la consulta con el id
    if ($stmt->execute([$carrito_id])) {
        echo "ok";
    } else {
        echo "Error al eliminar";
    }
?>

