<?php
// 🚪 Cerramos la sesión
session_start();
session_unset(); // Limpia todas las variables de sesión
session_destroy(); // Destruye la sesión actual

// 🔁 Redirige al login
header("Location: ../../login-register/login-registro.php");
exit();
