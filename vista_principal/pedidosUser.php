<?php
session_start();
require 'php/conexion_bd.php';

// Verificar sesión
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

//Verifica el rol
$usuario_id = $_SESSION['usuario_id'];
$es_admin = (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin');

// Consulta según el rol
if ($es_admin) { //muestra todos los pedidos
    $sql = "SELECT p.id, p.total, p.estado, p.creado_en, u.nombre_completo 
            FROM pedidos p
            INNER JOIN usuarios u ON p.usuario_id = u.id
            ORDER BY p.creado_en DESC";
    $stmt = $conexion->prepare($sql);
    $stmt->execute();
    $pedidos = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
} else {//muestra solo los pedidos del usuario
    $sql = "SELECT id, total, estado, creado_en FROM pedidos WHERE usuario_id = ? ORDER BY creado_en DESC";
    $stmt = $conexion->prepare($sql);
    $stmt->execute([$usuario_id]);
    $pedidos = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    //Se ejecuta la consulta y se guarda en pedidos
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?php echo $es_admin ? 'Todos los pedidos' : 'Mis Pedidos'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <h2 class="text-center mb-4"><?php echo $es_admin ? '📦 Todos los Pedidos' : '🛍️ Mis Pedidos'; ?></h2>

    <div class="mb-4 text-end">
        <a href="vistaPrincipal.php" class="btn btn-secondary">⬅️ Volver al inicio</a>
    </div>
    <!-- si hay pedidos se muestra la tabla -->
    <?php if (count($pedidos) > 0): ?>
        <div class="table-responsive">
            <table class="table table-bordered text-center align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>ID Pedido</th>
                        <?php if ($es_admin): ?><th>Cliente</th><?php endif; ?>
                        <th>Total</th>
                        <th>Estado</th>
                        <th>Fecha</th>
                        <th>Factura</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pedidos as $pedido): ?>
                    <tr>
                        <td><?= $pedido['id'] ?></td>
                        <?php if ($es_admin): ?><td><?= htmlspecialchars($pedido['nombre_completo']) ?></td><?php endif; ?>
                        <td>$<?= number_format($pedido['total'], 2) ?></td>
                        <td><?= $pedido['estado'] ?></td>
                        <td><?= $pedido['creado_en'] ?></td>
                        <td><a href="factura.php?pedido_id=<?= $pedido['id'] ?>" class="btn btn-sm btn-primary">Ver factura</a></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-info text-center">No se encontraron pedidos.</div>
    <?php endif; ?>
</div>
</body>
</html>
