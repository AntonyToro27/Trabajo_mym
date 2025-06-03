<?php

    session_start();
    if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'cliente') {
        header("Location: ../login-registro.php");
        exit();
    }
?>


<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>bienvenidoooo</h1>

    <a href="cerrarSesion.php">Cerrar sesión</a>
</body>
</html>/ -->