<?php
  session_start();
  require 'php/conexion_bd.php';

  if (!isset($_SESSION['usuario_id'])) {
      header('Location: login.php');
      exit;
  }

  $usuario_id = $_SESSION['usuario_id'];
  //Obtiene toda la info de los productos del carrito
  $sql = "SELECT 
              c.id AS carrito_id,
              p.nombre AS producto,
              p.imagen,
              v.id AS variante_id,
              t.talla,
              co.color,
              p.precio,
              c.cantidad,
              (p.precio * c.cantidad) AS subtotal
          FROM carrito c
          INNER JOIN variantes_producto v ON c.variante_id = v.id
          INNER JOIN productos p ON v.producto_id = p.id
          INNER JOIN tallas t ON v.talla_id = t.id
          INNER JOIN colores co ON v.color_id = co.id
          WHERE c.usuario_id = ?";
  $stmt = $conexion->prepare($sql);
  $stmt->execute([$usuario_id]);
  $resultado = $stmt->get_result();
  $items = $resultado->fetch_all(MYSQLI_ASSOC);
  $total = array_sum(array_column($items, 'subtotal'));
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Carrito de Compras</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="container mt-5">
    <h2 class="text-center mb-4">🛒 Carrito de Compras</h2>
    <!-- si hay un producto o mas pinta la tabla -->
    <?php if (count($items) > 0): ?>
    <div class="table-responsive">
      <table class="table table-bordered align-middle text-center">
        <thead class="table-dark">
          <tr>
            <th>Producto</th>
            <th>Imagen</th>
            <th>Talla</th>
            <th>Color</th>
            <th>Precio</th>
            <th>Cantidad</th>
            <th>Subtotal</th>
            <th>Eliminar</th>
          </tr>
        </thead>

        <tbody>
          <?php foreach ($items as $item): ?>
            <tr>
              <td><?= htmlspecialchars($item['producto']) ?></td>
              <td><img src="../img/<?= $item['imagen'] ?>" alt="" width="80"></td>
              <td><?= $item['talla'] ?></td>
              <td><?= $item['color'] ?></td>
              <td>$<?= number_format($item['precio'], 2) ?></td>
              <td>
                <form action="actualizar_cantidad.php" method="POST" class="d-flex justify-content-center align-items-center">
                  <input type="hidden" name="carrito_id" value="<?= $item['carrito_id'] ?>">
                  <input type="number" name="cantidad" value="<?= $item['cantidad'] ?>" min="1" class="form-control me-2" style="width: 80px;">
                  <button type="submit" class="btn btn-sm btn-primary">Actualizar</button>
                </form>
              </td>
              <td>$<?= number_format($item['subtotal'], 2) ?></td>
              <td>
                <form action="eliminar_del_carrito.php" method="POST">
                  <input type="hidden" name="carrito_id" value="<?= $item['carrito_id'] ?>">
                  <button type="submit" class="btn btn-sm btn-danger">❌</button>
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <button id="vaciar-carrito" class="btn btn-outline-danger ms-2">Vaciar Carrito</button>

    <div class="text-end mt-4">
      <h4>Total: <span class="text-success">$<?= number_format($total, 2) ?></span></h4>
      <a href="pago.php" class="btn btn-success">Finalizar Compra</a>
    </div>
    <?php else: ?>
      <div class="alert alert-info text-center">
        No hay productos en el carrito.
      </div>
    <?php endif; ?>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script>
    // Actualizar cantidad
    document.querySelectorAll('form[action="actualizar_cantidad.php"]').forEach(form => {
      form.addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        //usa fetch para actualizar la cantidad
        fetch('actualizar_cantidad.php', {
          method: 'POST',
          body: formData
        })
        .then(res => res.text())
        .then(data => {
          if (data.trim() === 'ok') {
            Swal.fire({
              icon: 'success',
              title: 'Cantidad actualizada',
              timer: 1500,
              showConfirmButton: false
            }).then(() => {
              actualizarContadorCarrito();
              location.reload()
            });
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: data
            });
          }
        });
      });
    });

    // Eliminar del carrito
    document.querySelectorAll('form[action="eliminar_del_carrito.php"]').forEach(form => {
      form.addEventListener('submit', function(e) {
        e.preventDefault();
        Swal.fire({
          title: '¿Eliminar este producto?',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Sí, eliminar',
          cancelButtonText: 'Cancelar'
        }).then(result => {
          if (result.isConfirmed) {
            const formData = new FormData(this);
            fetch('eliminar_del_carrito.php', {
              method: 'POST',
              body: formData
            })
            .then(res => res.text())
            .then(data => {
              if (data.trim() === 'ok') {
                Swal.fire({
                  icon: 'success',
                  title: 'Eliminado',
                  timer: 1500,
                  showConfirmButton: false
                }).then(() => {
                  actualizarContadorCarrito();
                  location.reload()
                });
              } else {
                Swal.fire({
                  icon: 'error',
                  title: 'Error',
                  text: data
                });
              }
            });
          }
        });
      });
    });
  </script>


  <script>
    document.getElementById('vaciar-carrito').addEventListener('click', function () {
      Swal.fire({
        title: '¿Vaciar el carrito?',
        text: "Se eliminarán todos los productos.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, vaciar',
        cancelButtonText: 'Cancelar'
      }).then((result) => {
        if (result.isConfirmed) {
          fetch('vaciar_carrito.php', {
            method: 'POST'
          })
          .then(res => res.text())
          .then(data => {
            if (data.trim() === 'ok') {
              Swal.fire({
                icon: 'success',
                title: 'Carrito vaciado',
                timer: 1500,
                showConfirmButton: false
              }).then(() => {
                actualizarContadorCarrito();
                location.reload()
              });
            } else {
              Swal.fire({
                icon: 'error',
                title: 'Error',
                text: data
              });
            }
          });
        }
      });
    });
  </script>

  <script>
    function actualizarContadorCarrito() {
      fetch('carrito_contador.php')
        .then(res => res.text())
        .then(total => {
          document.getElementById('contador-carrito').textContent = total;
        });
    }

    actualizarContadorCarrito();
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>