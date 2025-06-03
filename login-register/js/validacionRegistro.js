const form = document.getElementById("form_register");
const nombre = document.getElementById("name");
const email = document.getElementById("email");
const password = document.getElementById("password");
const passwordConfirmation = document.getElementById("password_confirmation");

// Eventos
form.addEventListener("submit", (event) => {
    event.preventDefault();
    validarCampos();
    validaciones();
});

async function validaciones() {
    const { validated: validFields, message: fieldMessage } = validarCampos();
    if (!validFields) {
        showAlert(fieldMessage);
        return;
    }

    const { validated, message } = validatePassword();
    if (!validated) {
        showAlert(message);
        return;
    }

    const { validated: validatedSecurity, message: messageError } = validatePasswordSecurity();
    if (!validatedSecurity) {
        showAlert(messageError);
        return;
    }

    form.submit();
}

// Validar si la contraseña es diferente a la confirmación
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
        message:
            "La contraseña debe tener mayúsculas, minúsculas, un número, un carácter especial y de 8 a 15 caracteres.",
    };
}


function validarCampos(event, input) {
    const nombreValue = nombre.value;
    const emailValue = email.value;
    const passwordValue = password.value;

    // Nombre no puede estar vacío o solo espacios
    if (nombreValue.trim() === "") {
        return { validated: false, message: "El nombre no puede estar vacío o solo contener espacios." };
    }

    // Nombre no puede comenzar con espacios
    if (/^\s/.test(nombreValue)) {
        return { validated: false, message: "El nombre no puede comenzar con espacios en blanco." };
    }

    // Email no puede contener espacios
    if (/\s/.test(emailValue)) {
        return { validated: false, message: "El correo no puede contener espacios." };
    }

    // Contraseña no puede contener espacios
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
        toast: "true",
        timer: 5000,
        showConfirmButton: false,
        position: "bottom-right",
        confirmButtonText: 'Cool'
    });
}