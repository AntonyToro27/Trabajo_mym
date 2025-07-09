<?php
session_start(); 
include 'php/conexion_bd.php';

//la respuesta es en json
header('Content-Type: application/json');

//arreglo para la respuesta
$response = ['success' => false, 'colores' => [], 'message' => ''];

//Verifica que todo llegue si no muestra error
if (!isset($_POST['producto_id']) || !isset($_POST['talla_id'])) {
    $response['message'] = 'Faltan parámetros: producto_id o talla_id.';
    echo json_encode($response);
    exit;
}

//pasa los valores a enteros
$producto_id = intval($_POST['producto_id']);
$talla_id = intval($_POST['talla_id']);

if (!$conexion) {
    $response['message'] = 'Error de conexión a la base de datos.';
    echo json_encode($response);
    exit;
}

//consulta para buscar los colores
$sql = "
    SELECT c.id, c.color
    FROM variantes_producto vp
    JOIN colores c ON vp.color_id = c.id
    WHERE vp.producto_id = ? AND vp.talla_id = ?
";

//se ejecuta la consulta 
if ($stmt = $conexion->prepare($sql)) {
    $stmt->bind_param('ii', $producto_id, $talla_id);

    if ($stmt->execute()) {
        $resultado = $stmt->get_result();
        $colores = [];
        //se guardan los resultados en el array
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




