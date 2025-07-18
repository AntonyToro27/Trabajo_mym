<?php
    session_start();

    if (!isset($_SESSION['usuario'])) {
        header("Location: ../../login-register/login-registro.php"); 
        exit();
    }

    include('conexion.php');

    //verifica si hay id 
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        $buscar = mysqli_query($conexion, "SELECT imagen FROM productos WHERE id = $id");
        $producto = mysqli_fetch_assoc($buscar);

        //si tiene imagen y existe elimina por unlink
        if ($producto && $producto['imagen']) {
            $ruta = 'imagenes/' . $producto['imagen'];
            if (file_exists($ruta)) {
                unlink($ruta);
            }
        }

        // Eliminar de la base de datos
        $query = "DELETE FROM productos WHERE id = $id";
        if (mysqli_query($conexion, $query)) {
            header("Location: productos.php");
            exit();
        } else {
            echo "Error al eliminar el producto: " . mysqli_error($conexion);
        }
    } else {
        echo "ID no proporcionado.";
    }
?>
