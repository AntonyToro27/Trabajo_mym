<?php

    $host = "localhost"; 
    $user = "root"; 
    $password = ""; 
    $database = "mym"; 

    $conexion = new mysqli($host, $user, $password, $database);

    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }
    return $conexion; 



    // $conexion = mysqli_connect("localhost", "root", "", "mym");

    // if ($conexion) {
    //     echo 'conexión exitosa :)';
    // } else {
    //     echo 'falla en la conexión :(';
    // }
    
?>