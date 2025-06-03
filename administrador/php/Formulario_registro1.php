
<!-- Esto se va -->

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Registro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #111111;
            color: #ffffff;
        }
        .form-container {
            background-color: #ffffff;
            color: #000000;
            max-width: 500px;
            margin: auto;
            margin-top: 5%;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(255, 0, 0, 0.3);
        }
        .form-container h2 {
            text-align: center;
            margin-bottom: 1.5rem;
        }
        .form-label {
            font-weight: 600;
        }
        .form-control {
            border-radius: 8px;
        }
        button[type="submit"] {
            background-color: #d50000;
            color: #ffffff;
            border: none;
            font-weight: bold;
            width: 100%;
        }
        button[type="submit"]:hover {
            background-color: #b71c1c;
        }
        .form-container p {
            text-align: center;
            margin-top: 1rem;
        }
        .form-container a {
            color: #d50000;
            text-decoration: none;
        }
        .form-container a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="form-container">
        <h2>Registrarse</h2>
        <form action="recibir1.php" method="POST">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" id="nombre" name="nombre" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="correo" class="form-label">Correo Electrónico:</label>
                <input type="email" id="correo" name="correo" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="contrasena" class="form-label">Contraseña:</label>
                <input type="password" id="contrasena" name="contrasena" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="direccion" class="form-label">Dirección:</label>
                <input type="text" id="direccion" name="direccion" class="form-control" required>
            </div>

            <div class="mb-4">
                <label for="telefono" class="form-label">Teléfono:</label>
                <input type="text" id="telefono" name="telefono" class="form-control" required>
            </div>

            <button type="submit">Registrar</button>
        </form>

        <p>¿Ya tienes cuenta? <a href="Formulario_login.php">Iniciar sesión</a></p>

        <?php if (isset($_GET['var'])) { ?>
            <div class="alert alert-warning alert-dismissible fade show mt-3" role="alert">
                <?= $_GET['var']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php } ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

