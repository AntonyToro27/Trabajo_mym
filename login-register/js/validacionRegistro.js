
// const form = document.getElementById("form_register");
// const nombre = document.getElementById("name");
// const email = document.getElementById("email");
// const password = document.getElementById("password");
// const passwordConfirmation = document.getElementById("password_confirmation");

// form.addEventListener("submit", async (event) => {
//     event.preventDefault();

//     const { validated: validFields, message: fieldMessage } = validarCampos();
//     if (!validFields) return showAlert(fieldMessage);

//     const { validated, message } = validatePassword();
//     if (!validated) return showAlert(message);

//     const { validated: validatedSecurity, message: messageError } = validatePasswordSecurity();
//     if (!validatedSecurity) return showAlert(messageError);

//     const formData = new FormData(form);

//     try {
//         const response = await fetch("php/register_user_db.php", {
//             method: "POST",
//             body: formData
//         });

//         const result = await response.json();

//         Swal.fire({
//             icon: result.status === "ok" ? "success" : "error",
//             title: result.status === "ok" ? "¡Registro exitoso!" : "Error",
//             text: result.message,
//             confirmButtonColor: "#3085d6"
//         }).then(() => {
//             if (result.status === "ok") {
//                 // Puedes redirigir a login si lo prefieres:
//                 // window.location.href = "login.php";
//                 form.reset(); // Limpia el formulario
//             }
//         });

//     } catch (error) {
//         Swal.fire("Error", "No se pudo conectar al servidor.", "error");
//     }
// });

// function validatePassword() {
//     if (password.value !== passwordConfirmation.value) {
//         return { validated: false, message: "Las contraseñas no coinciden" };
//     }
//     return { validated: true };
// }

// function validatePasswordSecurity() {
//     const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])[A-Za-z\d$@$!%*?&]{8,15}$/;
//     if (regex.test(password.value)) {
//         return { validated: true };
//     }
//     return {
//         validated: false,
//         message: "La contraseña debe tener mayúsculas, minúsculas, un número, un carácter especial y de 8 a 15 caracteres."
//     };
// }

// function validarCampos() {
//     const nombreValue = nombre.value.trim();
//     const emailValue = email.value.trim();
//     const passwordValue = password.value;

//     if (nombreValue === "") {
//         return { validated: false, message: "El nombre no puede estar vacío." };
//     }

//     if (/^\s/.test(nombre.value)) {
//         return { validated: false, message: "El nombre no puede comenzar con espacios." };
//     }

//     if (/\s/.test(emailValue)) {
//         return { validated: false, message: "El correo no puede contener espacios." };
//     }

//     if (/\s/.test(passwordValue)) {
//         return { validated: false, message: "La contraseña no puede contener espacios." };
//     }

//     return { validated: true };
// }

// function showAlert(message) {
//     Swal.fire({
//         title: 'Error!',
//         text: message,
//         icon: 'error',
//         toast: true,
//         timer: 5000,
//         showConfirmButton: false,
//         position: "bottom-right"
//     });
// }

