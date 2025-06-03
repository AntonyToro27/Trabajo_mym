<?php
    session_start();
    include 'conexion_db.php';

    // Validar que los datos vengan por POST
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $email = $_POST['email'];
        $password = hash('sha512', $_POST['password']);

        // Usamos una consulta preparada para mayor seguridad
        $stmt = $conexion->prepare("SELECT id, email, rol FROM usuarios WHERE email = ? AND contrasena = ?");
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows > 0) {
            $usuario = $resultado->fetch_assoc();

            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario'] = $usuario['email'];
            $_SESSION['rol'] = $usuario['rol'];

            // Redirigir según el rol
            if ($usuario['rol'] === 'admin') {
                header("location: ../../administrador/php/admin.php");
            } else {
                header("location: ../../vista_principal/vistaPrincipal.php");
            }
            exit();
        } else {
            echo '
                <script>
                    alert("El usuario no existe o los datos son incorrectos.");
                    window.location = "../login-registro.php";
                </script>
            ';
            exit();
        }
    } else {
        header("Location: ../login-registro.php");
        exit();
    }
?>
