<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../../login-register/login-registro.php");
    exit();
}

include('conexion.php');

// Verificamos que se recibió el ID del pedido
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_pedido'])) {
    $id = $_POST['id_pedido'];

    // Obtenemos los datos del pedido
    $query = "SELECT * FROM pedidos WHERE id = $id";
    $resultado = mysqli_query($conexion, $query);
    $pedido = mysqli_fetch_assoc($resultado);

    if (!$pedido) {
        echo "<div class='alert alert-danger'>❌ Pedido no encontrado.</div>";
        exit();
    }
} else {
    header("Location: pedidos.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Actualizar Estado</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
<div class="container">
    <h2>Actualizar Estado del Pedido #<?= $pedido['id'] ?></h2>

    <form action="actualizar_pedido.php" method="POST">
        <input type="hidden" name="id" value="<?= $pedido['id'] ?>">

        <div class="mb-3">
            <label class="form-label">Estado:</label>
            <select name="estado" class="form-select" required>
                <option value="pendiente" <?= $pedido['estado'] === 'pendiente' ? 'selected' : '' ?>>Pendiente</option>
                <option value="procesando" <?= $pedido['estado'] === 'procesando' ? 'selected' : '' ?>>Procesando</option>
                <option value="enviado" <?= $pedido['estado'] === 'enviado' ? 'selected' : '' ?>>Enviado</option>
                <option value="entregado" <?= $pedido['estado'] === 'entregado' ? 'selected' : '' ?>>Entregado</option>
                <option value="cancelado" <?= $pedido['estado'] === 'cancelado' ? 'selected' : '' ?>>Cancelado</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Guardar cambios</button>
        <a href="pedidos.php" class="btn btn-secondary">Volver</a>
    </form>
</div>
</body>
</html>
