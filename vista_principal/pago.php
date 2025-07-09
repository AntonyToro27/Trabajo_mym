<?php
    session_start();
    require 'php/conexion_bd.php';

    //Solo usurarios logueados, si no redirecciona a login
    if (!isset($_SESSION['usuario_id'])) {
        header("Location: ../../login-register/login-registro.php");
        exit;
    }

    $usuario_id = $_SESSION['usuario_id'];

    // Obtener productos del carrito
    $sql = "SELECT 
                c.variante_id,
                c.cantidad,
                p.nombre,
                p.precio,
                p.imagen,
                t.talla,
                co.color,
                (p.precio * c.cantidad) AS subtotal
            FROM carrito c
            INNER JOIN variantes_producto v ON c.variante_id = v.id
            INNER JOIN productos p ON v.producto_id = p.id
            INNER JOIN tallas t ON v.talla_id = t.id
            INNER JOIN colores co ON v.color_id = co.id 
            WHERE c.usuario_id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->execute([$usuario_id]);
    $productos = $stmt->get_result()->fetch_all(MYSQLI_ASSOC); //junta los datos como array asociativo

    //si el carrito está vacio muestra mensaje y redirecciona al carrito.
    if (empty($productos)) {
        echo "<script>alert('Tu carrito está vacío.'); window.location.href='carrito.php';</script>";
        exit;
    }

    $total = array_sum(array_column($productos, 'subtotal')); //Suma los valores de todos los productos
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Confirmar Compra</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2 class="text-center">🧾 Confirmar Compra</h2>

    <div class="table-responsive mt-4">
        <table class="table table-bordered text-center align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Producto</th>
                    <th>Imagen</th>
                    <th>Talla</th>
                    <th>Color</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <!-- lista de productos con info -->
            <tbody> 
                <?php foreach ($productos as $item): ?> 
                <tr>
                    <td><?= htmlspecialchars($item['nombre']) ?></td>
                    <td><img src="../img/<?= $item['imagen'] ?>" width="60"></td>
                    <td><?= $item['talla'] ?></td>
                    <td><?= $item['color'] ?></td>
                    <td><?= $item['cantidad'] ?></td>
                    <td>$<?= number_format($item['precio'], 2) ?></td>
                    <td>$<?= number_format($item['subtotal'], 2) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <h4 class="text-end mt-3">Total: <span class="text-success">$<?= number_format($total, 2) ?></span></h4>

    <form action="procesar_pago.php" method="POST" class="mt-4">
        <input type="hidden" name="total" value="<?= $total ?>">

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="direccion" class="form-label">Dirección de entrega:</label>
                <input type="text" name="direccion" id="direccion" class="form-control" required placeholder="Ej. Calle 123 #45-67">
            </div>
            <div class="col-md-6">
                <label for="telefono" class="form-label">Teléfono de contacto:</label>
                <!-- <input type="text" name="telefono" id="telefono" class="form-control" required placeholder="Ej. 3001234567"> -->
                 <input type="text" name="telefono" id="telefono" class="form-control" required 
                    placeholder="Ej. 3001234567" pattern="\d{10}" title="Debe tener exactamente 10 dígitos" maxlength="10">
            </div>
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-success btn-lg">✅ Confirmar y Pagar</button>
            <a href="carrito_compras.php" class="btn btn-secondary btn-lg ms-3">Cancelar</a>
        </div>
    </form>
</div>
</body>
</html>
