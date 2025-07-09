<?php
include 'conexion.php';

//verifica si recibe id por post 
if (isset($_POST['id'])) {
    $id = intval($_POST['id']);
    //consulta preparada
    $stmt = $conexion->prepare("DELETE FROM variantes_producto WHERE id = ?");
    $stmt->bind_param("i", $id);
    //se ejecuta la sentencia
    if ($stmt->execute()) {
        echo "Eliminado con éxito";
    } else {
        echo "Error al eliminar";
    }
}
