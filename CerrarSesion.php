<?php
// Inicia la sesión
session_start();

// Destruye todas las variables de sesión
session_unset();

// Destruye la sesión
session_destroy();

// Redirecciona al usuario a la página de inicio
header("Location: index.php");
?>