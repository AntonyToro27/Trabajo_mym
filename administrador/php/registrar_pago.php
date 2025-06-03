<!-- Todavia no -->


<?php
session_start(); // ← Esto debe estar antes de usar $_SESSION

include('conexion.php');

$id_usuario = $_SESSION['id_usuario']; // ← Usamos el ID guardado en la sesión

// El resto del código...

$pedido_id = $_POST['pedido_id'];
$metodo = $_POST['metodo'];
$estado = $_POST['estado'];
$referencia = $_POST['referencia'];
$monto = $_POST['monto'];

$insert = "INSERT INTO pagos (pedido_id, metodo, estado, referencia, monto)
           VALUES ('$pedido_id', '$metodo', '$estado', '$referencia', '$monto')";

if (mysqli_query($conexion, $insert)) {
    if ($estado === 'completado') {
        $update = "UPDATE pedidos 
                   SET estado = 'procesando'
                   WHERE id_pedido = $pedido_id 
                     AND estado = 'pendiente'";
        mysqli_query($conexion, $update);
    }

    echo "<h3>✅ Pago registrado correctamente</h3><a href='pedidos.php'>Volver a pedidos</a>";
} else {
    echo "❌ Error al registrar el pago: " . mysqli_error($conexion);
}
?>
