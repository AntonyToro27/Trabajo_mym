// alert("estoy conectado")

// Variables

let container_forms = document.querySelector(".container_forms");
let form_login = document.querySelector(".form_login");
let form_register = document.querySelector(".form_register");
let caja_trasera_login = document.querySelector(".caja_trasera-login");
let caja_trasera_register = document.querySelector(".caja_trasera-register");

//Botones
let botonInicioSesion = document.getElementById("btn-iniciarSesion");
let botonRegistro = document.getElementById("btn-registro");


//Eventos

window.addEventListener("resize", anchoPagina);
botonInicioSesion.addEventListener("click", iniciarSesion);
botonRegistro.addEventListener("click", register);


//Funciones

function anchoPagina() {
    if (window.innerWidth > 850) {
        caja_trasera_login.style.display = "block";
        caja_trasera_register.style.display = "block";
    } else {
        caja_trasera_register.style.display = "block";
        caja_trasera_register.style.opacity = "1";
        caja_trasera_login.style.display = "none";
        form_login.style.display = "block";
        form_register.style.display = "none";
        container_forms.style.left = "0px";
    }
}

anchoPagina();

function iniciarSesion() {

    if (window.innerWidth > 850) {
        form_register.style.display = "none";
        container_forms.style.left = "10px";
        form_login.style.display = "block";
        caja_trasera_register.style.opacity = "1";
        caja_trasera_login.style.opacity = "0";
    } else {
        form_register.style.display = "none";
        container_forms.style.left = "0px";
        form_login.style.display = "block";
        caja_trasera_register.style.display = "block";
        caja_trasera_login.style.display = "none";
    }
}


function register() {

    if (window.innerWidth > 850) {
        form_register.style.display = "block";
        container_forms.style.left = "410px";
        form_login.style.display = "none";
        caja_trasera_register.style.opacity = "0";
        caja_trasera_login.style.opacity = "1";
    } else {
        form_register.style.display = "block";
        container_forms.style.left = "0px";
        form_login.style.display = "none";
        caja_trasera_register.style.display = "none";
        caja_trasera_login.style.display = "block";
        caja_trasera_login.style.opacity = "1";
    }
}