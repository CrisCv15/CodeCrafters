<?php
session_start(); // Inicia la sesión
session_unset(); // Libera todas las variables de sesión
session_destroy(); // Destruye la sesión

// Redirige a la página de inicio de sesión o a la página principal
header("Location: ../Login/Login.php");
exit();
?>
