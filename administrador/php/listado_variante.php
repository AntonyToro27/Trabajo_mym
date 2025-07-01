<?php
session_start();
include 'conexion.php';

// Cargar datos
$productos = $conexion->query("SELECT id, nombre FROM productos");
$tallas = $conexion->query("SELECT id, talla FROM tallas");
$colores = $conexion->query("SELECT id, color FROM colores");

$lista = $conexion->query("
    SELECT vp.id, vp.producto_id, vp.talla_id, vp.color_id, vp.stock,
           p.nombre AS producto, t.talla, c.color
    FROM variantes_producto vp
    JOIN productos p ON vp.producto_id = p.id
    JOIN tallas t ON vp.talla_id = t.id
    JOIN colores c ON vp.color_id = c.id
    ORDER BY p.nombre, t.talla, c.color
");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Variantes</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../css/estiloSidebar.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>
<body>

<!-- Botón solo visible en móviles -->
<button class="btn btn-dark m-2 d-md-none" onclick="toggleSidebar()">☰ Menú</button>

<div class="d-flex">
    <!-- Sidebar -->
    <div class="sidebar text-white p-3 bg-dark" id="sidebar">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="text-danger mb-0">MyM</h4>
            <button class="btn btn-outline-light d-md-none" onclick="toggleSidebar()">✖</button>
        </div>
        <ul class="nav flex-column">
            <li class="nav-item mb-2"><a href="productos.php" class="nav-link text-white">📦 Productos</a></li>
            <li class="nav-item mb-2"><a href="pedidos.php" class="nav-link text-white">🧾 Pedidos</a></li>
            <li class="nav-item mb-2"><a href="usuarios.php" class="nav-link text-white">👥 Usuarios</a></li>
            <li class="nav-item mb-2"><a href="categorias.php" class="nav-link text-white">📂 Categorías</a></li>
            <li class="nav-item mb-2"><a href="configuracion.php" class="nav-link text-white">⚙️ Configuración</a></li>
            <li class="nav-item mt-4"><a href="cerrarSesion.php" class="btn btn-danger w-100">Cerrar sesión</a></li>
        </ul>
    </div>

    <!-- Contenido -->
    <div class="flex-grow-1 p-4 content-wrapper">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Editar Variantes de Productos</h2>

            <div class="d-flex gap-2">
                <!-- Botón para crear nueva variante -->
                <a href="variante_prod.php" class="btn btn-success">
                    ➕ Nueva Variante
                </a>

                <!-- Botón para volver al inicio -->
                <a href="admin.php" class="btn btn-secondary">
                    ⬅ Volver al Inicio
                </a>
            </div>
        </div>


        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th>ID</th>
                        <th>Producto</th>
                        <th>Talla</th>
                        <th>Color</th>
                        <th>Stock</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($v = $lista->fetch_assoc()): ?>
                        <tr id="fila-<?php echo $v['id']; ?>">
                            <form class="form-editar" data-id="<?php echo $v['id']; ?>">
                                <td><?php echo $v['id']; ?></td>
                                <td>
                                    <select name="producto_id" class="form-select form-select-sm">
                                        <?php foreach ($productos as $p): ?>
                                            <option value="<?php echo $p['id']; ?>" <?php if ($p['id'] == $v['producto_id']) echo "selected"; ?>>
                                                <?php echo $p['nombre']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                                <td>
                                    <select name="talla_id" class="form-select form-select-sm">
                                        <?php foreach ($tallas as $t): ?>
                                            <option value="<?php echo $t['id']; ?>" <?php if ($t['id'] == $v['talla_id']) echo "selected"; ?>>
                                                <?php echo $t['talla']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                                <td>
                                    <select name="color_id" class="form-select form-select-sm">
                                        <?php foreach ($colores as $c): ?>
                                            <option value="<?php echo $c['id']; ?>" <?php if ($c['id'] == $v['color_id']) echo "selected"; ?>>
                                                <?php echo $c['color']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                                <td><input type="number" name="stock" class="form-control form-control-sm" value="<?php echo $v['stock']; ?>" min="0"></td>
                                <td class="text-center">
                                    <button type="submit" class="btn btn-sm btn-primary mb-1">💾</button>
                                    <button type="button" class="btn btn-sm btn-danger btn-eliminar" data-id="<?php echo $v['id']; ?>">🗑️</button>
                                </td>
                            </form>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        sidebar.classList.toggle('show');
    }

    // Guardar cambios
    document.querySelectorAll('.form-editar').forEach(form => {
        form.addEventListener('submit', e => {
            e.preventDefault();
            const id = form.dataset.id;
            const data = new FormData(form);
            data.append('id', id);

            fetch('editar_variante.php', {
                method: 'POST',
                body: data
            })
            .then(res => res.text())
            .then(msg => {
                Swal.fire({
                    icon: 'success',
                    title: 'Actualizado',
                    text: msg,
                    timer: 1000,
                    showConfirmButton: false
                });
            });
        });
    });

    // Eliminar variante
    document.querySelectorAll('.btn-eliminar').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.dataset.id;
            Swal.fire({
                title: '¿Eliminar variante?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, eliminar'
            }).then(res => {
                if (res.isConfirmed) {
                    fetch('eliminar_variante.php', {
                        method: 'POST',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        body: 'id=' + id
                    }).then(res => res.text())
                    .then(msg => {
                        document.getElementById('fila-' + id).remove();
                        Swal.fire({
                            icon: 'success',
                            title: 'Eliminado',
                            text: msg,
                            timer: 1000,
                            showConfirmButton: false
                        });
                    });
                }
            });
        });
    });
</script>

</body>
</html>
