<?php 
session_start();
require 'php/conexion_bd.php';

//Verifica que los datos estén completos
if (
    !isset($_SESSION['usuario_id']) ||
    !isset($_POST['total']) ||
    !isset($_POST['direccion']) ||
    !isset($_POST['telefono'])
) {
    echo "Acceso no autorizado";
    exit;
}

//Se leen los datos del usuario
$usuario_id = $_SESSION['usuario_id'];
$total = floatval($_POST['total']);
$direccion = trim($_POST['direccion']);
$telefono = trim($_POST['telefono']);

//Actualiza dirección y tel del usuario
$stmt = $conexion->prepare("UPDATE usuarios SET direccion = ?, telefono = ? WHERE id = ?");
$stmt->bind_param("ssi", $direccion, $telefono, $usuario_id);
$stmt->execute();

//Obtiene productos del carrito con stock actual
$sql = "SELECT 
            c.variante_id,
            c.cantidad,
            p.precio,
            vp.stock
        FROM carrito c
        INNER JOIN variantes_producto vp ON c.variante_id = vp.id
        INNER JOIN productos p ON vp.producto_id = p.id
        WHERE c.usuario_id = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();
$carrito = $result->fetch_all(MYSQLI_ASSOC);

if (empty($carrito)) {
    echo "Carrito vacío.";
    exit;
}

//Valida stock antes de procesar
foreach ($carrito as $item) {
    if ($item['cantidad'] > $item['stock']) {
        echo "Stock insuficiente para un producto del carrito.";
        exit;
    }
}

//Se crea el pedido
$stmt = $conexion->prepare("INSERT INTO pedidos (usuario_id, total, estado) VALUES (?, ?, 'procesando')");
$stmt->bind_param("id", $usuario_id, $total);
$stmt->execute();
$pedido_id = $conexion->insert_id;

//Insertar detalle_pedido y descontar stock
$stmt_detalle = $conexion->prepare("INSERT INTO detalle_pedido (pedido_id, variante_id, cantidad, precio_unitario, subtotal) VALUES (?, ?, ?, ?, ?)");
$stmt_stock = $conexion->prepare("UPDATE variantes_producto SET stock = stock - ? WHERE id = ?");

foreach ($carrito as $item) {
    $variante_id = $item['variante_id'];
    $cantidad = $item['cantidad'];
    $precio = $item['precio'];
    $subtotal = $precio * $cantidad;

    // Insertar detalle del pedido
    $stmt_detalle->bind_param("iiidd", $pedido_id, $variante_id, $cantidad, $precio, $subtotal);
    $stmt_detalle->execute();

    // Descontar stock
    $stmt_stock->bind_param("ii", $cantidad, $variante_id);
    $stmt_stock->execute();
}

//Registra pago (simulado)
$metodo = 'tarjeta';
$stmt_pago = $conexion->prepare("INSERT INTO pagos (id_usuario, pedido_id, metodo, estado, monto) VALUES (?, ?, ?, 'completado', ?)");
$stmt_pago->bind_param("iisd", $usuario_id, $pedido_id, $metodo, $total);
$stmt_pago->execute();

//Vaciar carrito al confirmar
$stmt = $conexion->prepare("DELETE FROM carrito WHERE usuario_id = ?");
$stmt->bind_param("i", $usuario_id);
$stmt->execute();

//Redirige a factura
header("Location: factura.php?pedido_id=$pedido_id");
exit;
?>
