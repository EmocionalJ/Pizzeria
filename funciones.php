<?php
function Conectar(){
    $host = "localhost";
    $user = "root";
    $pass = "";
    $bd = "pizzeria";
    $cnn = mysqli_connect($host, $user, $pass, $bd); // Incluye el nombre de la base de datos en la conexión
    if (!$cnn) {
        die("Error de conexión: " . mysqli_connect_error());
    }
    return $cnn;
}

?>