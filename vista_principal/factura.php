<?php
    session_start();
    require 'php/conexion_bd.php';

    // Valida que el usuario esté logueado y se reciba un pedido_id
    if (!isset($_SESSION['usuario_id']) || !isset($_GET['pedido_id'])) {
        echo "Acceso no autorizado";
        exit;
    }

    $usuario_id = $_SESSION['usuario_id'];
    $pedido_id = $_GET['pedido_id'];
    $es_admin = (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin'); //verifica el rol

    // Obtener los datos del pedido
    if ($es_admin) { //puede ver todos los peidos si es admin
        $stmt = $conexion->prepare("SELECT * FROM pedidos WHERE id = ?");
        $stmt->execute([$pedido_id]);
    } else { //solo puede ver sus pedidos
        $stmt = $conexion->prepare("SELECT * FROM pedidos WHERE id = ? AND usuario_id = ?");
        $stmt->execute([$pedido_id, $usuario_id]);
    }
    $pedido = $stmt->get_result()->fetch_assoc();

    if (!$pedido) {
        echo "Pedido no encontrado o sin acceso.";
        exit;
    }

    // Obtener método de pago y si fue completado o no
    if ($es_admin) {
        $stmt = $conexion->prepare("SELECT metodo, estado FROM pagos WHERE pedido_id = ?");
        $stmt->execute([$pedido_id]);
    } else {
        $stmt = $conexion->prepare("SELECT metodo, estado FROM pagos WHERE pedido_id = ? AND id_usuario = ?");
        $stmt->execute([$pedido_id, $usuario_id]);
    }
    $pago = $stmt->get_result()->fetch_assoc();

    // Obtiene datos del cliente (base en el pedido)
    $stmt = $conexion->prepare("SELECT nombre_completo, direccion, telefono FROM usuarios WHERE id = ?");
    $stmt->execute([$pedido['usuario_id']]);
    $cliente = $stmt->get_result()->fetch_assoc();

    // Obtiene detalles del pedido y los productos
    $sql = "SELECT 
                p.nombre AS producto,
                t.talla,
                c.color,
                dp.cantidad,
                dp.precio_unitario,
                dp.subtotal
            FROM detalle_pedido dp
            INNER JOIN variantes_producto v ON dp.variante_id = v.id
            INNER JOIN productos p ON v.producto_id = p.id
            INNER JOIN tallas t ON v.talla_id = t.id
            INNER JOIN colores c ON v.color_id = c.id
            WHERE dp.pedido_id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->execute([$pedido_id]);
    $detalles = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Factura #<?= $pedido_id ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body class="bg-white">
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3>🧾 Factura #<?= $pedido_id ?></h3>
            <button class="btn btn-primary no-print" onclick="window.print()">🖨️ Imprimir</button>
        </div>

        <div class="mb-3">
            <p><strong>Cliente:</strong> <?= htmlspecialchars($cliente['nombre_completo']) ?></p>
            <p><strong>Dirección:</strong> <?= htmlspecialchars($cliente['direccion']) ?></p>
            <p><strong>Teléfono:</strong> <?= htmlspecialchars($cliente['telefono']) ?></p>
            <p><strong>Fecha del pedido:</strong> <?= date('d/m/Y H:i', strtotime($pedido['creado_en'])) ?></p>
            <p><strong>Estado del pedido:</strong> <?= ucfirst($pedido['estado']) ?></p>
            <p><strong>Método de pago:</strong> <?= ucfirst($pago['metodo']) ?> (<?= $pago['estado'] ?>)</p>
        </div>

        <h5>📦 Detalle de productos</h5>
        <div class="table-responsive mb-4">
            <table class="table table-bordered text-center align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Producto</th>
                        <th>Talla</th>
                        <th>Color</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($detalles as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['producto']) ?></td>
                        <td><?= $item['talla'] ?></td>
                        <td><?= $item['color'] ?></td>
                        <td><?= $item['cantidad'] ?></td>
                        <td>$<?= number_format($item['precio_unitario'], 2) ?></td>
                        <td>$<?= number_format($item['subtotal'], 2) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <h4 class="text-end">Total pagado: <span class="text-success">$<?= number_format($pedido['total'], 2) ?></span></h4>

        <div class="text-center mt-4">
            <a href="vistaPrincipal.php" class="btn btn-outline-dark no-print">🏠 Volver al inicio</a>
        </div>
    </div>
</body>
</html>
