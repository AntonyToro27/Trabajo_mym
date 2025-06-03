<?php

    include 'conexion_db.php';

    $nombre_completo = $_POST['nombre_completo'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    // Encriptado de contraseña
    $password = hash('sha512', $password);


    $query = "INSERT INTO usuarios(nombre_completo, email, contrasena)
              VALUES('$nombre_completo', '$email', '$password')";
    
        //Verificar correo no se repita en DB
        $verificar_correo = mysqli_query($conexion, "SELECT * FROM usuarios WHERE email='$email'");

    
        if (mysqli_num_rows($verificar_correo) > 0) {
            echo '
                <script>
                    alert("Este correo ya se encuentra registrado, intenta con uno diferente");
                    window.location = "../login-registro.php";
                </script>
            ';
            exit();
            mysqli_close($conexion);
        }
    $ejecutar = mysqli_query($conexion, $query);

    if ($ejecutar) {
        echo '
            <script>
                alert("Usuario registrado exitosamente");
                window.location = "../login-registro.php"
            </script>
        ';
    }else {
        echo '
            <script src=".js/validacionRegistro.js">
                alert("Usuario no registrado, intentelo nuevamente");
                window.location = "../login-registro.php"
            </script>
        ';
    }

    mysqli_close($conexion);

?>


