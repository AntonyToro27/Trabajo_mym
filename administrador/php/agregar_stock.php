<?php
include 'conexion.php';

if (isset($_POST['id'], $_POST['cantidad'])) {
    $id = intval($_POST['id']);
    $cantidad = intval($_POST['cantidad']);

    // Obtener stock actual
    $res = $conexion->query("SELECT stock FROM variantes_producto WHERE id = $id");
    //si no exise id da error
    if ($res->num_rows === 0) {
        echo json_encode(['success' => false, 'mensaje' => 'Variante no encontrada']);
        exit;
    }

    $actual = $res->fetch_assoc()['stock'];
    $nuevo = $actual + $cantidad;

    // Actualizar stock
    $stmt = $conexion->prepare("UPDATE variantes_producto SET stock = ? WHERE id = ?");
    $stmt->bind_param("ii", $nuevo, $id);

    //se ejecuta y responde con yeison
    if ($stmt->execute()) {
        echo json_encode([
            'success' => true,
            'id' => $id,
            'nuevo_stock' => $nuevo
        ]);
    } else {
        echo json_encode(['success' => false, 'mensaje' => 'Error al actualizar stock']);
    }
}
