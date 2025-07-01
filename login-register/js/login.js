const formLogin = document.getElementById("form_login");
const emailLogin = document.getElementById("emailLogin");
const passwordLogin = document.getElementById("passwordLogin");

formLogin.addEventListener("submit", async (e) => {
    e.preventDefault();

    const email = emailLogin.value.trim();
    const password = passwordLogin.value.trim();

    // Validación básica antes de enviar
    if (email === "" || password === "") {
        Swal.fire({
            icon: "warning",
            title: "Campos vacíos",
            text: "Por favor, completa todos los campos.",
            confirmButtonColor: "#3085d6"
        });
        return;
    }

    const formData = new FormData(formLogin);

    try {
        const response = await fetch("php/login_db.php", {
            method: "POST",
            body: formData
        });

        const result = await response.json();

        if (result.status === "ok") {
            Swal.fire({
                icon: "success",
                title: "¡Bienvenido!",
                text: result.message,
                confirmButtonColor: "#3085d6"
            }).then(() => {
                window.location.href = result.redirect;
            });
        } else {
            Swal.fire({
                icon: "error",
                title: "Error",
                text: result.message,
                confirmButtonColor: "#3085d6"
            });
        }
    } catch (error) {
        Swal.fire("Error", "No se pudo conectar al servidor.", "error");
    }
});
