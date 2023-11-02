<?php
include("iniciarSesion.php"); // Incluye el archivo que inicia la sesión

if (!isset($_SESSION['rut'])) {
    // Si el usuario no está autenticado, redirige a la página de inicio de sesión
    header("Location: index.php");
    exit(); // Asegura que el script se detenga después de redirigir
}
?>




























<a href="CerrarSesion.php">Cerrar Sesión</a>