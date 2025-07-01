<?php
session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../../login-register/login-registro.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4 bg-light">

<div class="container">
    <h2 class="mb-4">Agregar Usuario</h2>

    <form method="POST" action="insertar_usuario.php" class="row g-3 needs-validation" novalidate id="formularioUsuario">
        <!-- Cédula -->
        <div class="col-md-6">
            <label class="form-label">Cédula:</label>
            <input type="text" name="cedula" class="form-control" required
                   pattern="^\d{6,12}$" title="Ingrese solo números entre 6 y 12 dígitos">
            <div class="invalid-feedback">Cédula obligatoria (6-12 números).</div>
        </div>

        <!-- Nombre completo -->
        <div class="col-md-6">
            <label class="form-label">Nombre completo:</label>
            <input type="text" name="nombre_completo" class="form-control" required
                   pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ]{2,}(?: [A-Za-zÁÉÍÓÚáéíóúÑñ]{2,})*$"
                   title="Solo letras y espacios entre nombres (mínimo 2 letras por palabra)">
            <div class="invalid-feedback">Nombre obligatorio (solo letras, sin números, mínimo 2 letras por palabra).</div>
        </div>

        <!-- Email -->
        <div class="col-md-6">
            <label class="form-label">Email:</label>
            <input type="email" name="email" class="form-control" required
                   title="Ingrese un correo válido">
            <div class="invalid-feedback">Correo electrónico válido obligatorio.</div>
        </div>

        <!-- Teléfono -->
        <div class="col-md-6">
            <label class="form-label">Teléfono:</label>
            <input type="tel" name="telefono" class="form-control" required
                   pattern="^\d{7,10}$" title="Teléfono de 7 a 10 dígitos">
            <div class="invalid-feedback">Teléfono obligatorio (7 a 10 números).</div>
        </div>

        <!-- Dirección -->
        <div class="col-md-6">
            <label class="form-label">Dirección:</label>
            <input type="text" name="direccion" class="form-control" required maxlength="100"
                   pattern="^(?!\s+$).{5,100}$"
                   title="Dirección válida (mínimo 5 caracteres, no solo espacios)">
            <div class="invalid-feedback">Dirección válida obligatoria (no solo espacios).</div>
        </div>

        <!-- Contraseña -->
        <div class="col-md-6">
            <label class="form-label">Contraseña:</label>
            <input type="password" name="contrasena" class="form-control" required
                   pattern="^(?=.*[a-zA-Z])(?=.*\d).{6,20}$"
                   title="Debe tener letras y números, entre 6 y 20 caracteres">
            <div class="invalid-feedback">Contraseña con letras y números (mínimo 6 caracteres).</div>
        </div>

        <!-- Rol -->
        <div class="col-md-4">
            <label class="form-label">Rol:</label>
            <select name="rol" class="form-select" required>
                <option value="" disabled selected>Selecciona un rol</option>
                <option value="cliente">Cliente</option>
                <option value="admin">Administrador</option>
            </select>
            <div class="invalid-feedback">Selecciona un rol válido.</div>
        </div>

        <!-- Botones -->
        <div class="col-12 d-flex gap-2">
            <button type="submit" class="btn btn-success">Guardar</button>
            <a href="usuarios.php" class="btn btn-secondary">Volver</a>
        </div>
    </form>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Validación JS adicional -->
<script>
    (function () {
        'use strict';
        const form = document.getElementById('formularioUsuario');

        form.addEventListener('submit', function (event) {
            let campos = form.querySelectorAll('input, select');
            let valido = true;

            campos.forEach(campo => {
                if (campo.type !== "submit" && campo.type !== "button") {
                    let valor = campo.value.trim();
                    if (valor === "") {
                        campo.classList.add('is-invalid');
                        valido = false;
                    } else {
                        campo.classList.remove('is-invalid');
                    }
                }
            });

            if (!form.checkValidity() || !valido) {
                event.preventDefault();
                event.stopPropagation();
                alert("Por favor, completa correctamente todos los campos (sin solo espacios).");
            }

            form.classList.add('was-validated');
        }, false);
    })();
</script>

</body>
</html>
