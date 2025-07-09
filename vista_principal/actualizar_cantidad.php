<?php
    require 'php/conexion_bd.php';
    session_start();

    //Verifica q esre logueado, se este enviando el id y la nueva cantidad
    if (!isset($_SESSION['usuario_id']) || !isset($_POST['carrito_id']) || !isset($_POST['cantidad'])) {
        echo "Datos incompletos";
        exit;
    }

    $carrito_id = $_POST['carrito_id'];
    //convierte cantidad a numero entero, no permite valores negativos 
    $cantidad = max(1, (int)$_POST['cantidad']);

    //Obtener la variante-id del ítem en el carrito
    $stmt = $conexion->prepare("SELECT variante_id FROM carrito WHERE id = ? AND usuario_id = ?");
    $stmt->execute([$carrito_id, $_SESSION['usuario_id']]);
    $result = $stmt->get_result();
    if ($result->num_rows === 0) {
        echo "Carrito no encontrado";
        exit;
    }
    $variante_id = $result->fetch_assoc()['variante_id'];

    //Obtener el stock disponible de esa variante
    $stmt = $conexion->prepare("SELECT stock FROM variantes_producto WHERE id = ?");
    $stmt->execute([$variante_id]);
    $result = $stmt->get_result();
    if ($result->num_rows === 0) {
        echo "Variante no encontrada";
        exit;
    }
    $stock_disponible = (int)$result->fetch_assoc()['stock'];

    //Validar si la cantidad solicitada supera el stock
    if ($cantidad > $stock_disponible) {
        echo "Solo hay $stock_disponible unidades disponibles";
        exit;
    }

    //Actualizar cantidad en el carrito
    $stmt = $conexion->prepare("UPDATE carrito SET cantidad = ? WHERE id = ?");
    if ($stmt->execute([$cantidad, $carrito_id])) {
        echo "ok";
    } else {
        echo "Error al actualizar";
    }
?>