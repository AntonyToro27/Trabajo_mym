<?php
session_start();
session_destroy(); // borra todo lo de la sesión
header("Location: login.php"); // vuelve al login //Tambien cambiar
?>
