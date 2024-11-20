<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);

if (session_status() === PHP_SESSION_NONE) {
    session_start(); 
}


if (isset($_SESSION['usr'])) {
    header("Location: inicio.php");
    exit;
}

require "./control.php"; 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BMos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body class="d-flex flex-column p-5 align-items-center vh-100 text" style="background-color: #00b2d0ff;">
    <div class="bg-white p-5 rounded-5 text-secondary" style="width: 25rem;">
        <div class="d-flex justify-content-center">
            <img
            src="../../img/Logo.png"
            alt=""
            style="width: 18rem;">
        </div>
        <div class="text-center fs-4 p-2 fw-bold" style="color: #323232;">BIENVENIDO</div>
        <form class="p-3" action="" method="post">
            <div class="input-group">
                <div class="input-group-text" style="background-color: #00b2d0ff;">
                    <img src="../../img/username-icon.svg" alt="" style="width: 1rem;">
                </div>
                <input class="form-control" type="text" id="usr" name="usr" placeholder="Usuario" required autofocus>
            </div>
            <div class="input-group">
                <div class="input-group-text" style="background-color: #00b2d0ff;">
                    <img src="../../img/password-icon.svg" alt="" style="width: 1rem;">
                </div>
                <input type="password" class="form-control" id="cont" name="cont" placeholder="Contraseña" required>
            </div>
            <div>
                <input class="btn text-white w-100 mt-4" type="submit" value="Ingresar" name="btn-ingresar" style="background-color: #00b2d0ff;">
            </div>
        </form>
    </div>
</body>
<footer class="position-absolute bottom-0 w-100 bg-white text-center text-lg-start">
    <div class="text-center p-2">© 2024 Copyright: <a href="../../AboutUs\AboutUs/aboutUs.html">Los4Hermanos</a> / <a href="../../AboutUs\AboutUs/aboutUs(Empresa).html">CodeCrafters</a>
</footer>
</html>
