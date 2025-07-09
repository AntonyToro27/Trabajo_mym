<?php
session_start();
session_destroy(); // borra todo lo de la sesión
header("Location: ../../login-register/login-registro.php"); // vuelve al login
?>
