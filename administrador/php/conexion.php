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


            //  $host = 'localhost';
            //  $user = 'root';
            //  $password = '';
            //  $nombreDB = 'mym';


            //  $conexion = mysqli_connect($host, $user, $password, $nombreDB);

            //   if ($conexion) {
            //      echo "Conexion exitosa";
            //   }
            //   else{
            //      echo "Error en la conexion";
            //   }
?>