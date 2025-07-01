<?php
include 'conexion.php';

if (isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $stmt = $conexion->prepare("DELETE FROM variantes_producto WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo "Eliminado con éxito";
    } else {
        echo "Error al eliminar";
    }
}
