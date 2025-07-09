<?php
    //Iniciamos la sesión y validamos que el usuario sea administrador
    session_start();
    if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
        header("Location: ../../login-register/login-registro.php");
        exit();
    }

    include('conexion.php');

    //Valida que llegó un ID por POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
        $id = $_POST['id'];

        //verificar si tiene pedidos activos
        $verifica = "SELECT id FROM pedidos 
                    WHERE usuario_id = $id 
                    AND estado IN ('pendiente', 'procesando', 'enviado')";
        $resultado = mysqli_query($conexion, $verifica);

        if (mysqli_num_rows($resultado) > 0) {
            //Tiene pedidos activos, no se elimina
            $_SESSION['mensaje_error'] = 'No se puede eliminar el usuario. Tiene pedidos activos.';
            header("Location: usuarios.php");
            exit();
        }

        //No tiene pedidos activos, se elimina
        $eliminar = "DELETE FROM usuarios WHERE id = $id";
        if (mysqli_query($conexion, $eliminar)) {
            $_SESSION['mensaje_exito'] = 'Usuario eliminado correctamente.';
        } else {
            $_SESSION['mensaje_error'] = 'Error al eliminar el usuario.';
        }

        header("Location: usuarios.php");
        exit();
    } else {
        header("Location: usuarios.php");
        exit();
    }
?>