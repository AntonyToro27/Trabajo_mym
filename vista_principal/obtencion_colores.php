<?php
session_start(); 
include 'php/conexion_bd.php';

header('Content-Type: application/json');

$response = ['success' => false, 'colores' => [], 'message' => ''];

if (!isset($_POST['producto_id']) || !isset($_POST['talla_id'])) {
    $response['message'] = 'Faltan parámetros: producto_id o talla_id.';
    echo json_encode($response);
    exit;
}

$producto_id = intval($_POST['producto_id']);
$talla_id = intval($_POST['talla_id']);

if (!$conexion) {
    $response['message'] = 'Error de conexión a la base de datos.';
    echo json_encode($response);
    exit;
}

$sql = "
    SELECT c.id, c.color
    FROM variantes_producto vp
    JOIN colores c ON vp.color_id = c.id
    WHERE vp.producto_id = ? AND vp.talla_id = ?
";

if ($stmt = $conexion->prepare($sql)) {
    $stmt->bind_param('ii', $producto_id, $talla_id);

    if ($stmt->execute()) {
        $resultado = $stmt->get_result();
        $colores = [];
        while ($row = $resultado->fetch_assoc()) {
            $colores[] = [
                'id' => $row['id'],
                'color' => $row['color']
            ];
        }
        $response['success'] = true;
        $response['colores'] = $colores;
    } else {
        $response['message'] = 'Error al ejecutar la consulta: ' . $stmt->error;
    }
    $stmt->close();
} else {
    $response['message'] = 'Error al preparar la consulta: ' . $conexion->error;
}

$conexion->close();
echo json_encode($response);
?>




