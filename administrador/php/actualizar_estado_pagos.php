<?php
include('conexion.php');

$query = "UPDATE pedidos p
          JOIN pagos pa ON p.id_pedido = pa.pedido_id
          SET p.estado = 'procesando'
          WHERE pa.estado = 'completado'
          AND p.estado = 'pendiente'";

$resultado = mysqli_query($conexion, $query);

if ($resultado) {
    echo "Pedidos actualizados automáticamente a 'procesando'.";
} else {
    echo "Error al actualizar pedidos: " . mysqli_error($conexion);
}
?>
