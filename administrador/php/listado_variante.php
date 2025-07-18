<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../../login-register/login-registro.php");
    exit();
}
include 'conexion.php';

$productos = $conexion->query("SELECT id, nombre FROM productos");
$tallas = $conexion->query("SELECT id, talla FROM tallas");
$colores = $conexion->query("SELECT id, color FROM colores");

// Número de registros por página
$por_pagina = 10;

// Página actual desde URL, por defecto 1
$pagina = isset($_GET['pagina']) ? max(1, intval($_GET['pagina'])) : 1;

// Calcular desde qué registro iniciar
$offset = ($pagina - 1) * $por_pagina;

// Obtener total de variantes
$total_resultado = $conexion->query("SELECT COUNT(*) as total FROM variantes_producto");
$total_filas = $total_resultado->fetch_assoc()['total'];
$total_paginas = ceil($total_filas / $por_pagina);



//trae info de la variante
$lista = $conexion->query("
    SELECT vp.id, vp.producto_id, vp.talla_id, vp.color_id, vp.stock,
           p.nombre AS producto, t.talla, c.color
    FROM variantes_producto vp
    JOIN productos p ON vp.producto_id = p.id
    JOIN tallas t ON vp.talla_id = t.id
    JOIN colores c ON vp.color_id = c.id
    ORDER BY p.nombre, t.talla, c.color
    LIMIT $por_pagina OFFSET $offset
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
                <a href="variante_prod.php" class="btn btn-success">
                    ➕ Nueva Variante
                </a>

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
                                <td class="d-flex justify-content-center align-items-center gap-1">
                                    <button type="button" class="btn btn-sm btn-outline-secondary btn-restar-stock" data-id="<?= $v['id'] ?>">−</button>
                                    <input type="number" name="stock" class="form-control form-control-sm text-center" style="width: 70px;" value="<?= $v['stock'] ?>" min="0" readonly>
                                    <button type="button" class="btn btn-sm btn-outline-secondary btn-sumar-stock" data-id="<?= $v['id'] ?>">+</button>
                                
                                    <button type="button" class="btn btn-sm btn-success btn-stock" 
                                        data-id="<?= $v['id'] ?>" 
                                        data-stock="<?= $v['stock'] ?>"
                                        data-producto="<?= htmlspecialchars($v['producto']) ?>"
                                        data-talla="<?= htmlspecialchars($v['talla']) ?>"
                                        data-color="<?= htmlspecialchars($v['color']) ?>">
                                        ➕
                                    </button>

                                </td>
                                <td class="text-center">
                                    <button type="submit" class="btn btn-sm btn-primary mb-1">💾</button>
                                    <button type="button" class="btn btn-sm btn-danger btn-eliminar" data-id="<?php echo $v['id']; ?>">🗑️</button>
                                </td>
                            </form>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <nav>
                <ul class="pagination justify-content-center">
                    <!-- Anterior -->
                    <li class="page-item <?= $pagina <= 1 ? 'disabled' : '' ?>">
                        <a class="page-link" href="?pagina=<?= $pagina - 1 ?>">Anterior</a>
                    </li>

                    <!-- Páginas numeradas -->
                    <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
                        <li class="page-item <?= $i == $pagina ? 'active' : '' ?>">
                            <a class="page-link" href="?pagina=<?= $i ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>

                    <!-- Siguiente -->
                    <li class="page-item <?= $pagina >= $total_paginas ? 'disabled' : '' ?>">
                        <a class="page-link" href="?pagina=<?= $pagina + 1 ?>">Siguiente</a>
                    </li>
                </ul>
            </nav>

        </div>
    </div>
</div>

    <!-- Modal Agregar Stock -->
    <div class="modal fade" id="modalStock" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form id="formStock" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Agregar Stock</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id" id="modal-id">
                <div class="mb-3">
                    <label><strong>Producto</strong></label>
                    <input type="text" id="modal-info-producto" class="form-control" readonly>
                </div>
                <div class="mb-3">
                    <label>Stock actual</label>
                    <input type="number" id="modal-stock-actual" class="form-control" readonly>
                </div>
                <div class="mb-3">
                    <label>Cantidad a agregar</label>
                    <input type="number" name="cantidad" id="modal-cantidad" class="form-control" min="1" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Guardar cambios</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            </div>
            </form>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    const modal = new bootstrap.Modal(document.getElementById('modalStock'));

    // Abrir modal
    document.querySelectorAll('.btn-stock').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.dataset.id;
            const stock = btn.dataset.stock;
            const producto = btn.dataset.producto;
            const talla = btn.dataset.talla;
            const color = btn.dataset.color;

            document.getElementById('modal-id').value = id;
            document.getElementById('modal-stock-actual').value = stock;
            document.getElementById('modal-cantidad').value = "";
            document.getElementById('modal-info-producto').value = `${producto} - Talla ${talla} - Color ${color}`;

            modal.show();
        });
    });


    // Enviar cambios
    document.getElementById('formStock').addEventListener('submit', e => {
        e.preventDefault();
        const formData = new FormData(e.target);

        fetch('agregar_stock.php', {
            method: 'POST',
            body: formData
        }).then(res => res.json())
        .then(data => {
            if (data.success) {
                // Actualizar visualmente la celda del stock
                const fila = document.getElementById('fila-' + data.id);
                const inputStock = fila.querySelector('input[name="stock"]');
                inputStock.value = data.nuevo_stock;
                // Actualizar dataset del botón
                fila.querySelector('.btn-stock').dataset.stock = data.nuevo_stock;
                modal.hide();
                Swal.fire({
                    icon: 'success',
                    title: 'Stock actualizado',
                    text: `Nuevo stock: ${data.nuevo_stock}`,
                    timer: 1500,
                    showConfirmButton: false
                });
            } else {
                Swal.fire('Error', data.mensaje, 'error');
            }
        });
    });
</script>


<script>
    // Botón +
    document.querySelectorAll('.btn-sumar-stock').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.dataset.id;
            const fila = document.getElementById('fila-' + id);
            const input = fila.querySelector('input[name="stock"]');
            let stock = parseInt(input.value);
            stock++;
            actualizarStock(id, stock, input);
        });
    });

    // Botón −
    document.querySelectorAll('.btn-restar-stock').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.dataset.id;
            const fila = document.getElementById('fila-' + id);
            const input = fila.querySelector('input[name="stock"]');
            let stock = parseInt(input.value);
            if (stock > 0) {
                stock--;
                actualizarStock(id, stock, input);
            }
        });
    });

    // Función AJAX para guardar
    function actualizarStock(id, nuevoStock, input) {
        const data = new FormData();
        data.append('id', id);
        data.append('stock', nuevoStock);

        fetch('editar_variante.php', {
            method: 'POST',
            body: data
        })
        .then(res => res.text())
        .then(msg => {
            input.value = nuevoStock;
            Swal.fire({
                icon: 'success',
                title: 'Stock actualizado',
                text: msg,
                timer: 1200,
                showConfirmButton: false
            });
        });
    }
</script>

</body>
</html>
