<?php
    session_start();
    include 'php/conexion_bd.php';

    //se toman los datos del usuario y el producto selecc
    $usuario_id = $_SESSION['usuario_id']; 
    $producto_id = $_POST['producto_id'];
    $talla_id = $_POST['talla_id'];
    $color_id = $_POST['color_id'];
    $cantidad = 1;

    // Obtien el ID de la variante del producto, talla y color
    $consulta = $conexion->prepare("
        SELECT id FROM variantes_producto 
        WHERE producto_id = ? AND talla_id = ? AND color_id = ?
    ");
    $consulta->bind_param("iii", $producto_id, $talla_id, $color_id);
    $consulta->execute();
    $resultado = $consulta->get_result();

    //verifica q la consulta encontro al menos una coincidencia
    if ($resultado->num_rows > 0) {
        //obtien la info de la variante y se guarda el id para usarlo
        $variante = $resultado->fetch_assoc();
        $variante_id = $variante['id'];

        // Agregar al carrito y si ya está le suma
        $insertar = $conexion->prepare("
            INSERT INTO carrito (usuario_id, variante_id, cantidad) 
            VALUES (?, ?, ?) 
            ON DUPLICATE KEY UPDATE cantidad = cantidad + 1
        ");
        $insertar->bind_param("iii", $usuario_id, $variante_id, $cantidad);
        $insertar->execute();

        echo "ok";
    } else {
        echo "Variante no encontrada";
    }

?>
