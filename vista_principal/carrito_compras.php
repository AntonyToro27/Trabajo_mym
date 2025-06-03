<?php

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['agregar_producto'])) {
    $producto_id = $_POST['producto_id'];
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $cantidad = intval($_POST['cantidad']);

    $nuevo_item = [
        'id' => $producto_id,
        'nombre' => $nombre,
        'precio' => $precio,
        'cantidad' => $cantidad
    ];

    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = [];
    }

    $existe = false;
    foreach ($_SESSION['carrito'] as $key => $item) {
        if ($item['id'] == $producto_id) {
            $_SESSION['carrito'][$key]['cantidad'] += $cantidad;
            $existe = true;
            break;
        }
    }

    if (!$existe) {
        $_SESSION['carrito'][] = $nuevo_item;
    }


    header('Location: carrito_compras.php');
    exit();
}


if (isset($_GET['eliminar']) && is_numeric($_GET['eliminar'])) {
    $id_eliminar = $_GET['eliminar'];
    if (isset($_SESSION['carrito'])) {
        foreach ($_SESSION['carrito'] as $key => $item) {
            if ($item['id'] == $id_eliminar) {
                unset($_SESSION['carrito'][$key]);
                // Reindexar el array para evitar problemas con las claves
                $_SESSION['carrito'] = array_values($_SESSION['carrito']);
                break;
            }
        }
        header('Location: carrito_compras.php');
        exit();
    }
}


$carrito = $_SESSION['carrito'] ?? [];
$subtotal = 0;
$cantidad_productos = 0;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/carrito.css">
    <title>Carrito</title>
</head>
<body class="cur">
    <div class="carrito-container">
        <div class="carrito-izquierda">
            <h2 class="carrito-titulo">Carrito</h2>
            <?php if (empty($carrito)): ?>
                <p>Tu carrito está vacío.</p>
            <?php else: ?>
                <?php foreach ($carrito as $index => $item): ?>
                    <div class="elemento-seleccionado">
                        <div class="checkbox-container">
                            <input type="checkbox" checked>
                        </div>
                        <div class="info-producto">
                            <span><?php echo $item['nombre']; ?></span>
                            <span>Cantidad: <?php echo $item['cantidad']; ?></span>
                            <span>Precio: COP$<?php echo number_format($item['precio'], 0, ',', '.'); ?></span>
                            <span>Subtotal Item: COP$<?php echo number_format($item['precio'] * $item['cantidad'], 0, ',', '.'); ?></span>
                            <a href="?eliminar=<?php echo $item['id']; ?>">Eliminar</a>
                        </div>
                    </div>
                    <?php
                        $subtotal += $item['precio'] * $item['cantidad'];
                        $cantidad_productos += $item['cantidad'];
                    ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <div class="carrito-derecha">
            <div class="resumen-compra">
                <h2 class="resumen-titulo">Resumen del pedido</h2>
                <div class="subtotal">
                    <span>Subtotal (<?php echo $cantidad_productos; ?> producto<?php echo ($cantidad_productos > 1) ? 's' : ''; ?>):</span>
                    <span class="subtotal-valor">COP$<?php echo number_format($subtotal, 0, ',', '.'); ?></span>
                </div>
                <button class="proceder-pago-boton">Proceder al pago</button>
            </div>
        </div>
    </div>

    
    <script src="/js/carrito.js"></script>
</body>
</html>