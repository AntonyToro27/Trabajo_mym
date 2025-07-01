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

    <script>
            
    const form = document.getElementById("form_register");
    const nombre = document.getElementById("name");
    const email = document.getElementById("email");
    const password = document.getElementById("password");
    const passwordConfirmation = document.getElementById("password_confirmation");

    form.addEventListener("submit", async (event) => {
        event.preventDefault();

        const { validated: validFields, message: fieldMessage } = validarCampos();
        if (!validFields) return showAlert(fieldMessage);

        const { validated, message } = validatePassword();
        if (!validated) return showAlert(message);

        const { validated: validatedSecurity, message: messageError } = validatePasswordSecurity();
        if (!validatedSecurity) return showAlert(messageError);

        const formData = new FormData(form);

        try {
            const response = await fetch("php/register_user_db.php", {
                method: "POST",
                body: formData
            });

            const result = await response.json();

            Swal.fire({
                icon: result.status === "ok" ? "success" : "error",
                title: result.status === "ok" ? "¡Registro exitoso!" : "Error",
                text: result.message,
                confirmButtonColor: "#3085d6"
            }).then(() => {
                if (result.status === "ok") {
                    form.reset();
                }
            });

        } catch (error) {
            Swal.fire("Error", "No se pudo conectar al servidor.", "error");
        }
    });

    function validatePassword() {
        if (password.value !== passwordConfirmation.value) {
            return { validated: false, message: "Las contraseñas no coinciden" };
        }
        return { validated: true };
    }

    function validatePasswordSecurity() {
        const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])[A-Za-z\d$@$!%*?&]{8,15}$/;
        if (regex.test(password.value)) {
            return { validated: true };
        }
        return {
            validated: false,
            message: "La contraseña debe tener mayúsculas, minúsculas, un número, un carácter especial y de 8 a 15 caracteres."
        };
    }

    function validarCampos() {
        const nombreValue = nombre.value.trim();
        const emailValue = email.value.trim();
        const passwordValue = password.value;

        if (nombreValue === "") {
            return { validated: false, message: "El nombre no puede estar vacío." };
        }

        if (/^\s/.test(nombre.value)) {
            return { validated: false, message: "El nombre no puede comenzar con espacios." };
        }

        if (/\s/.test(emailValue)) {
            return { validated: false, message: "El correo no puede contener espacios." };
        }

        if (/\s/.test(passwordValue)) {
            return { validated: false, message: "La contraseña no puede contener espacios." };
        }

        return { validated: true };
    }

    function showAlert(message) {
        Swal.fire({
            title: 'Error!',
            text: message,
            icon: 'error',
            toast: true,
            timer: 5000,
            showConfirmButton: false,
            position: "bottom-right"
        });
    }


    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- <script src="js/validacionRegistro.js" type="module"></script> -->
    <script src="js/login.js"></script>
    <script src="js/forms.js"></script>
</body>
</html>