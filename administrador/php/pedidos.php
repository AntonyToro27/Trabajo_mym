<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: loginA.php"); //Cambiar locacion
    exit();
}

include('conexion.php');

// Consulta pedidos
$query = "SELECT p.id, p.total, p.estado, u.nombre_completo AS nombre_usuario
          FROM pedidos AS p
          INNER JOIN usuarios AS u ON p.usuario_id = u.id";


          $resultado = mysqli_query($conexion, $query);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pedidos - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
    <div class="container">
        <h2 class="mb-4">Lista de Pedidos</h2>
        <!-- 📦 Botón para actualizar pedidos automáticamente -->
<div class="mb-3">
    <button id="btnActualizarPedidos" class="btn btn-outline-dark">
        🕒 Actualizar pedidos pendientes
    </button>
</div>

<!-- 🧾 Aquí se mostrará el mensaje de resultado -->
<div id="mensajeResultado"></div>

        <a href="admin.php" class="btn btn-secondary mb-3">⬅ Volver al Panel</a>
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Usuario</th>
                    <th>Total</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($resultado)) { ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= $row['nombre_usuario'] ?></td>
                        <td>$<?= number_format($row['total'], 2) ?></td>
                        <td><?= ucfirst($row['estado']) ?></td>
                        <td>
                        <form action="editar_pedido.php" method="POST" style="display:inline;">
    <input type="hidden" name="id_pedido" value="<?= $row['id'] ?>">
    <button type="submit" class="btn btn-warning btn-sm">Actualizar estado</button>
</form>
                            <form action="eliminar_pedido.php" method="POST" style="display:inline;" onsubmit="return confirm('¿Eliminar este pedido?');">
    <input type="hidden" name="id" value="<?= $row['id'] ?>">
    <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
</form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.getElementById("btnActualizarPedidos").addEventListener("click", function() {
    fetch("actualizar_pedidos.php", {
        method: 'GET',
        credentials: 'same-origin' // ✅ Esto es lo que faltaba
    })
    .then(response => response.text())
    .then(data => {
        document.getElementById("mensajeResultado").innerHTML = `
            <div class="alert alert-info alert-dismissible fade show mt-3" role="alert">
                ${data}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </div>`;
    })
    .catch(error => {
        document.getElementById("mensajeResultado").innerHTML = `
            <div class="alert alert-danger mt-3">Error al actualizar los pedidos.</div>`;
        console.error("Error:", error);
    });
});

</script>

</body>
</html>
