<?php
session_start(); 
session_unset(); // Libera todas las variables de sesión
session_destroy(); 


header("Location: ../Login/Login.php");
exit();
?>
