<?php
    session_start();
    session_destroy();
    header("Location: ../vistaPrincipal.php");
    exit();
?>
