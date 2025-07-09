<?php

    session_start();
    include 'conexion.php';

    //Verifica que el rol sea de admin.
    if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
        header("Location: ../../login-register/login-registro.php");
        exit();
    }

    // PROCESAR ENVÍO DEL FORMULARIO
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $producto_id = $_POST['producto_id'];
        $talla_id = $_POST['talla_id'];
        $color_id = $_POST['color_id'];
        $stock = $_POST['stock'];

        // Validar que no exista la misma variante ya
        $consulta = $conexion->prepare("SELECT id FROM variantes_producto WHERE producto_id = ? AND talla_id = ? AND color_id = ?");
        $consulta->bind_param("iii", $producto_id, $talla_id, $color_id);
        $consulta->execute();
        $resultado = $consulta->get_result();

        if ($resultado->num_rows > 0) {
            $mensaje = "Ya existe una variante con esa talla y color para este producto.";
        } else {
            $stmt = $conexion->prepare("INSERT INTO variantes_producto (producto_id, talla_id, color_id, stock) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("iiii", $producto_id, $talla_id, $color_id, $stock);
            if ($stmt->execute()) {
                $mensaje = "Variante agregada correctamente.";
            } else {
                $mensaje = "Error al agregar variante.";
            }
        }
    }

    // OBTENER DATOS PARA LOS SELECTS
    $productos = $conexion->query("SELECT id, nombre FROM productos WHERE estado = 'activo'");
    $tallas = $conexion->query("SELECT id, talla FROM tallas");
    $colores = $conexion->query("SELECT id, color FROM colores");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Variante de Producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-5">
    <h2>Crear variante de producto</h2>

    <?php if (isset($mensaje)): ?>
        <div class="alert alert-info"><?php echo $mensaje; ?></div>
    <?php endif; ?>

    <form method="POST" class="mt-4">
        <div class="mb-3">
            <label for="producto_id" class="form-label">Producto</label>
            <select name="producto_id" id="producto_id" class="form-select" required>
                <option value="">Selecciona un producto</option>
                <?php while ($p = $productos->fetch_assoc()): ?>
                    <option value="<?php echo $p['id']; ?>"><?php echo $p['nombre']; ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="talla_id" class="form-label">Talla</label>
            <select name="talla_id" id="talla_id" class="form-select" required>
                <option value="">Selecciona una talla</option>
                <?php while ($t = $tallas->fetch_assoc()): ?>
                    <option value="<?php echo $t['id']; ?>"><?php echo $t['talla']; ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="color_id" class="form-label">Color</label>
            <select name="color_id" id="color_id" class="form-select" required>
                <option value="">Selecciona un color</option>
                <?php while ($c = $colores->fetch_assoc()): ?>
                    <option value="<?php echo $c['id']; ?>"><?php echo $c['color']; ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="stock" class="form-label">Stock disponible</label>
            <input type="number" class="form-control" name="stock" id="stock" required min="1">
        </div>

        <button type="submit" class="btn btn-primary">Agregar variante</button>
        <a href="listado_variante.php" class="btn btn-secondary">Volver</a>
    </form>
</body>
</html>



