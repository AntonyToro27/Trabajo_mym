<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login y Registro</title>
    <link rel="stylesheet" href="CSS/style.css">
</head>
<body>

    <main>
        <div class="container_principal">
            <div class="caja_trasera">
                <div class="caja_trasera-login">
                    <h3>¿Ya tienes una cuenta?</h3>
                    <p>Inicia sesión</p>
                    <button id="btn-iniciarSesion">Iniciar sesión</button>
                </div>

                <div class="caja_trasera-register">
                    <h3>¿Aún no tienes una cuenta?</h3>
                    <p>Regístrate</p>
                    <button id="btn-registro">Registrarme</button>
                </div>
            </div>

            <div class="container_forms">
                <form action="php/login_db.php" method="POST" class="form_login" id="form_login">
                    <h2>Iniciar sesión.</h2>
                    <input type="email" placeholder="Correo Electronico" name="email" id="emailLogin" required>
                    <input type="password" placeholder="Contraseña" name="password" id="passwordLogin" required>
                    <button type="submit" >Entrar</button>
                </form>

                <form action="php/register_user_db.php" method="POST" class="form_register" id="form_register">
                    <h2>Regístrarse.</h2>
                    <input type="text" placeholder="Nombre y apellido" name="nombre_completo" id="name" required>
                    <input type="email" placeholder="Correo electronico" name="email" id="email" required>
                    <input type="password" placeholder="Contraseña" name="password" id="password" required>
                    <input type="password" placeholder="Confirmar contraseña" name="password_confirmation" id="password_confirmation" required>
                    <button type="submit">Regístrarse.</button>
                </form>
            </div>

        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="js/login_register.js"></script>
    <script src="js/validacionRegistro.js" type="module"></script>

</body>
</html>