<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../../login-register/login-registro.php");
    exit();
}

include('conexion.php');

//procesa eliminacion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];

    //verificamos si hay productos que usan esta categoría
    $verificar = "SELECT COUNT(*) FROM productos WHERE categoria_id = ?";
    $stmt = mysqli_prepare($conexion, $verificar);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $totalProductos);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    if ($totalProductos > 0) {
        //Hay productos relacionados, no se puede eliminar
        $_SESSION['mensaje_error'] = "No puedes eliminar esta categoría porque tiene productos asociados.";
    } else {
        //No hay productos, podemos eliminar la categoría
        $query = "DELETE FROM categorias WHERE id = ?";
        $stmt = mysqli_prepare($conexion, $query);
        mysqli_stmt_bind_param($stmt, "i", $id);

        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['mensaje_exito'] = "Categoría eliminada correctamente.";
        } else {
            $_SESSION['mensaje_error'] = "Error al eliminar la categoría.";
        }
    }
}

header("Location: categorias.php");
exit();
