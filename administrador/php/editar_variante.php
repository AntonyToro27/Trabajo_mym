<?php
include 'conexion.php';

if (isset($_POST['id'], $_POST['producto_id'], $_POST['talla_id'], $_POST['color_id'], $_POST['stock'])) {
    $id = intval($_POST['id']);
    $producto_id = intval($_POST['producto_id']);
    $talla_id = intval($_POST['talla_id']);
    $color_id = intval($_POST['color_id']);
    $stock = intval($_POST['stock']);

    // Comprobar que no duplique una variante existente
    $check = $conexion->prepare("SELECT id FROM variantes_producto WHERE producto_id = ? AND talla_id = ? AND color_id = ? AND id != ?");
    $check->bind_param("iiii", $producto_id, $talla_id, $color_id, $id);
    $check->execute();
    $res = $check->get_result();

    if ($res->num_rows > 0) {
        echo "Ya existe una variante con esta combinación.";
    } else {
        $stmt = $conexion->prepare("UPDATE variantes_producto SET producto_id = ?, talla_id = ?, color_id = ?, stock = ? WHERE id = ?");
        $stmt->bind_param("iiiii", $producto_id, $talla_id, $color_id, $stock, $id);
        if ($stmt->execute()) {
            echo "Variante actualizada correctamente.";
        } else {
            echo "Error al actualizar.";
        }
    }
}
