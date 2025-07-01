<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../../login-register/login-registro.php");
    exit();
}

include('conexion.php');

$mensaje = '';
$categorias = mysqli_query($conexion, "SELECT id, nombre FROM categorias");
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $descripcion = trim($_POST['descripcion']);
    $precio = floatval($_POST['precio']);
    $stock = intval($_POST['stock']);
    $estado = $_POST['estado'];
    $categoria_id = intval($_POST['categoria_id']);

    $errores = [];

    // Validaciones
    if (strlen($nombre) < 3 || preg_match('/^\s+$/', $nombre)) {
        $errores[] = "El nombre debe tener al menos 3 caracteres y no estar vacío.";
    }

    if (strlen($descripcion) < 5 || preg_match('/^\s+$/', $descripcion)) {
        $errores[] = "La descripción debe tener al menos 5 caracteres válidos.";
    }

    if ($precio < 0) $errores[] = "El precio no puede ser negativo ni estar vacío.";
    if ($stock < 0) $errores[] = "El stock no puede ser negativo ni estar vacío.";
    if ($categoria_id <= 0) $errores[] = "La categoría debe ser un número válido.";
    if (!in_array($estado, ['activo', 'inactivo'])) $errores[] = "Estado no válido.";

    // Imagen
    $imagen = '';
    if (!empty($_FILES['imagen']['name'])) {
        $permitidos = ['image/jpeg', 'image/png', 'image/webp'];
        if (!in_array($_FILES['imagen']['type'], $permitidos)) {
            $errores[] = "Solo se permiten imágenes JPG, PNG o WEBP.";
        } else {
            $imagen = basename($_FILES['imagen']['name']);
            move_uploaded_file($_FILES['imagen']['tmp_name'], "imagenes/" . $imagen);
        }
    }

    // Verificar que la categoría exista
    $validar_categoria = mysqli_query($conexion, "SELECT id FROM categorias WHERE id = $categoria_id");
    if (mysqli_num_rows($validar_categoria) === 0) {
        $errores[] = "La categoría seleccionada no existe.";
    }

    // Verificar si el nombre ya existe
    $check_nombre = mysqli_query($conexion, "SELECT id FROM productos WHERE nombre = '$nombre'");
    if (mysqli_num_rows($check_nombre) > 0) {
        $errores[] = "Ya existe un producto con ese nombre.";
    }

    // Mostrar errores o insertar
    if (empty($errores)) {
        $query = "INSERT INTO productos (nombre, descripcion, precio, stock, imagen, categoria_id, estado)
                  VALUES ('$nombre', '$descripcion', '$precio', '$stock', '$imagen', '$categoria_id', '$estado')";

        if (mysqli_query($conexion, $query)) {
            $_SESSION['mensaje_exito'] = "Producto agregado exitosamente.";
            header("Location: productos.php");
            exit();
        } else {
            $mensaje = "Error al agregar producto: " . mysqli_error($conexion);
        }
    } else {
        $mensaje = "<ul class='text-danger'>";
        foreach ($errores as $error) {
            $mensaje .= "<li>$error</li>";
        }
        $mensaje .= "</ul>";
    }
}


// Backend como ya lo tienes, mejorado, lo dejamos aparte para no repetir ahora.
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        #preview {
            max-width: 200px;
            margin-top: 10px;
        }
    </style>
</head>
<body class="p-4 bg-light">
<div class="container">
    <h2>Agregar Producto</h2>
    <?php if ($mensaje): ?>
    <div class="alert alert-warning"><?= $mensaje ?></div>
<?php endif; ?>

    <form method="POST" enctype="multipart/form-data" action="" id="formProducto" novalidate>
        <div class="mb-3">
            <label>Nombre:</label>
            <input type="text" name="nombre" id="nombre" class="form-control" required
                   pattern="^\S.{2,49}$" maxlength="50"
                   title="Mínimo 3 caracteres, sin solo espacios">
            <div id="nombre-feedback" class="form-text text-danger d-none">Este nombre ya existe.</div>
        </div>
        <div class="mb-3">
            <label>Descripción:</label>
            <textarea name="descripcion" class="form-control" required minlength="5" maxlength="200"
                      title="Entre 5 y 200 caracteres"></textarea>
        </div>
        <div class="mb-3">
            <label>Precio:</label>
            <input type="number" name="precio" class="form-control" required step="0.01" min="0" max="1000000">
        </div>
        <div class="mb-3">
            <label>Stock:</label>
            <input type="number" name="stock" class="form-control" required min="0" max="10000">
        </div>
        <div class="mb-3">
            <label>Imagen:</label>
            <input type="file" name="imagen" class="form-control" accept="image/jpeg, image/png, image/webp" id="imagen">
            <img id="preview" src="#" alt="Vista previa de imagen" class="d-none"/>
        </div>
        <div class="mb-3">
    <label>Categoría:</label>
    <select name="categoria_id" class="form-select" required>
        <option value="" disabled selected>Selecciona una categoría</option>
        <?php while ($cat = mysqli_fetch_assoc($categorias)) : ?>
            <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['nombre']) ?></option>
        <?php endwhile; ?>
    </select>
</div>
        <div class="mb-3">
            <label>Estado:</label>
            <select name="estado" class="form-select" required>
                <option value="" disabled selected>Seleccione estado</option>
                <option value="activo">Activo</option>
                <option value="inactivo">Inactivo</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="productos.php" class="btn btn-secondary">Volver</a>
    </form>
</div>

<script>
    // Validación sin solo espacios
    document.getElementById("formProducto").addEventListener("submit", function (e) {
        const campos = this.querySelectorAll("input[type=text], textarea");
        let valido = true;

        campos.forEach(campo => {
            if (campo.value.trim() === "") {
                campo.classList.add("is-invalid");
                valido = false;
            } else {
                campo.classList.remove("is-invalid");
            }
        });

        if (!this.checkValidity() || !valido) {
            e.preventDefault();
            e.stopPropagation();
            alert("Completa correctamente todos los campos.");
        }

        this.classList.add('was-validated');
    });

    // Vista previa de imagen
    document.getElementById('imagen').addEventListener('change', function () {
        const archivo = this.files[0];
        if (archivo) {
            const lector = new FileReader();
            lector.onload = function (e) {
                const preview = document.getElementById('preview');
                preview.src = e.target.result;
                preview.classList.remove('d-none');
            };
            lector.readAsDataURL(archivo);
        }
    });

    // Validar nombre con AJAX
    document.getElementById("nombre").addEventListener("blur", function () {
        const nombre = this.value.trim();
        if (nombre.length >= 3) {
            fetch("verificar_nombre.php?nombre=" + encodeURIComponent(nombre))
                .then(res => res.json())
                .then(data => {
                    const feedback = document.getElementById("nombre-feedback");
                    if (data.existe) {
                        feedback.classList.remove("d-none");
                        this.setCustomValidity("El nombre ya existe.");
                    } else {
                        feedback.classList.add("d-none");
                        this.setCustomValidity("");
                    }
                });
        }
    });
</script>
</body>
</html>
