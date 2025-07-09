<?php
    session_start();
    require 'conexion.php';

    if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
        header("Location: ../login-register/login-registro.php");
        exit();
    }

    // Filtro por estado
    $estadoFiltro = $_GET['estado'] ?? '';

    // Configuración de paginación
    $por_pagina = 10;
    $pagina = isset($_GET['pagina']) ? max(1, intval($_GET['pagina'])) : 1;
    $offset = ($pagina - 1) * $por_pagina;

    // Obtener total de pedidos para paginación
    $sqlTotal = "SELECT COUNT(*) AS total FROM pedidos p";
    $paramsTotal = [];
    $typesTotal = '';
    if ($estadoFiltro) {
        $sqlTotal .= " WHERE p.estado = ?";
        $paramsTotal[] = $estadoFiltro;
        $typesTotal = 's';
    }
    $stmtTotal = $conexion->prepare($sqlTotal);
    if ($paramsTotal) {
        $stmtTotal->bind_param($typesTotal, ...$paramsTotal);
    }

    $stmtTotal->execute();
    $resTotal = $stmtTotal->get_result()->fetch_assoc();
    $total_pedidos = $resTotal['total'];
    $total_paginas = ceil($total_pedidos / $por_pagina);

    // Consulta de pedidos con paginación
    $sql = "SELECT p.id AS pedido_id, u.nombre_completo AS cliente, p.total, p.estado, p.creado_en
            FROM pedidos p
            INNER JOIN usuarios u ON p.usuario_id = u.id";

    $params = [];
    $types = '';
    if ($estadoFiltro) {
        $sql .= " WHERE p.estado = ?";
        $params[] = $estadoFiltro;
        $types .= 's';
    }

    $sql .= " ORDER BY p.creado_en DESC LIMIT ? OFFSET ?";
    $params[] = $por_pagina;
    $params[] = $offset;
    $types .= 'ii';

    $stmt = $conexion->prepare($sql);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $pedidos = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $estados = ['pendiente', 'procesando', 'enviado', 'entregado', 'cancelado'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historial de Pedidos - Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/estiloSidebar.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-light">
    <button class="btn btn-dark m-3 d-md-none" onclick="toggleSidebar()">☰ Menú</button>

    <div class="d-flex flex-column flex-md-row" id="wrapper">
        <div class="bg-dark text-white sidebar p-3" id="sidebar">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="text-danger mb-0">MyM</h4>
                <button class="btn btn-outline-light d-md-none" onclick="toggleSidebar()">✖</button>
            </div>
            <ul class="nav flex-column">
                <li class="nav-item mb-2"><a href="productos.php" class="nav-link text-white">📦 Productos</a></li>
                <li class="nav-item mb-2"><a href="listado_variante.php" class="nav-link text-white">🎯 Variantes</a></li>
                <li class="nav-item mb-2"><a href="usuarios.php" class="nav-link text-white">👥 Usuarios</a></li>
                <li class="nav-item mb-2"><a href="categorias.php" class="nav-link text-white">📂 Categorías</a></li>
                <li class="nav-item mb-2"><a href="configuracion.php" class="nav-link text-white">⚙️ Configuración</a></li>
                <li class="nav-item mt-4"><a href="cerrarSesion.php" class="btn btn-danger w-100">Cerrar sesión</a></li>
            </ul>
        </div>

        <div class="container-fluid py-4 px-3">
            <h2 class="mb-4 text-center">📋 Historial de Pedidos</h2>

            <form method="GET" class="row g-2 mb-4 justify-content-end align-items-center">
                <div class="col-auto">
                    <label for="estado" class="col-form-label">Filtrar por estado:</label>
                </div>
                <div class="col-auto">
                    <select name="estado" id="estado" class="form-select" onchange="this.form.submit()">
                        <option value="">Todos</option>
                        <?php foreach ($estados as $estado): ?>
                            <option value="<?= $estado ?>" <?= ($estado === $estadoFiltro) ? 'selected' : '' ?>><?= ucfirst($estado) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </form>

            <?php if (count($pedidos) > 0): ?>
                <div class="table-responsive">
                    <table class="table table-bordered align-middle text-center">
                        <thead class="table-dark">
                            <tr>
                                <th>ID Pedido</th>
                                <th>Cliente</th>
                                <th>Total</th>
                                <th>Estado</th>
                                <th>Fecha</th>
                                <th>Factura</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pedidos as $p): ?>
                                <tr>
                                    <td><?= $p['pedido_id'] ?></td>
                                    <td><?= htmlspecialchars($p['cliente']) ?></td>
                                    <td>$<?= number_format($p['total'], 2) ?></td>
                                    <td>
                                        <select class="form-select estado-select" data-id="<?= $p['pedido_id'] ?>">
                                            <?php foreach ($estados as $estado): ?>
                                                <option value="<?= $estado ?>" <?= $p['estado'] === $estado ? 'selected' : '' ?>><?= ucfirst($estado) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </td>
                                    <td><?= date('d/m/Y H:i', strtotime($p['creado_en'])) ?></td>
                                    <td><a href="../../vista_principal/factura.php?pedido_id=<?= $p['pedido_id'] ?>" class="btn btn-sm btn-primary" target="_blank">Ver factura</a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Paginación -->
                <nav>
                    <ul class="pagination justify-content-center">
                        <li class="page-item <?= $pagina <= 1 ? 'disabled' : '' ?>">
                            <a class="page-link" href="?pagina=<?= $pagina - 1 ?>&estado=<?= urlencode($estadoFiltro) ?>">Anterior</a>
                        </li>
                        <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
                            <li class="page-item <?= $i == $pagina ? 'active' : '' ?>">
                                <a class="page-link" href="?pagina=<?= $i ?>&estado=<?= urlencode($estadoFiltro) ?>"><?= $i ?></a>
                            </li>
                        <?php endfor; ?>
                        <li class="page-item <?= $pagina >= $total_paginas ? 'disabled' : '' ?>">
                            <a class="page-link" href="?pagina=<?= $pagina + 1 ?>&estado=<?= urlencode($estadoFiltro) ?>">Siguiente</a>
                        </li>
                    </ul>
                </nav>

            <?php else: ?>
                <div class="alert alert-info text-center">No hay pedidos para mostrar.</div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('show');
        }

        document.querySelectorAll('.estado-select').forEach(select => {
            select.addEventListener('change', function () {
                const pedidoId = this.dataset.id;
                const nuevoEstado = this.value;

                fetch('actualizar_estado_pedidos.php', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    body: `pedido_id=${pedidoId}&estado=${nuevoEstado}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({ icon: 'success', title: 'Estado actualizado', text: `El estado del pedido #${pedidoId} fue actualizado.`, timer: 1500, showConfirmButton: false });
                    } else {
                        Swal.fire({ icon: 'error', title: 'Error', text: data.error || 'No se pudo actualizar el estado.' });
                    }
                })
                .catch(error => {
                    Swal.fire({ icon: 'error', title: 'Error de red', text: 'No se pudo conectar con el servidor.' });
                    console.error(error);
                });
            });
        });
    </script>
</body>
</html>
