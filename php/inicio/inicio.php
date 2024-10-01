<?php
session_start();


if (!isset($_SESSION['usr'])) {
    header("Location: ./php/Login/Login.php");
    exit;
}


?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bienvenido a BMos</title>
    <link rel="stylesheet" href="./css/styleInicio.css">
    
</head>
<body>
    <div class="contenedor-bienvenida">
    <h1>Los4Hermanos</h1>
        <h1>¡Bienvenido, Admin!</h1>
        <p>Nos alegra verte de nuevo. Puedes gestionar productos, ventas, caja y estadísticas.</p>

        <div class="acciones">
            <a href="#productos" class="boton">Gestionar Productos</a>
            <a href="#ventas" class="boton">Ver Ventas</a>
            <a href="#caja" class="boton">Ver Caja</a>
            <a href="#estadisticas" class="boton">Ver Estadísticas</a>
        </div>
    </div>
</body>
</html>