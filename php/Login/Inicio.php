<?php
session_start();

// Si la sesión no está activa, redirige al login
if (!isset($_SESSION['usr'])) {
    header("Location: ./php/Login/Login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BMos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script>
        function inicio() {
            window.location = "../../index.php"; // Redirige al index
        }
    </script>
</head>
<body class="bg-info d-flex flex-column p-5 align-items-center vh-100 text">
    <div class="bg-white p-5 rounded-5 text-secondary" style="width: 25rem;">
        <div class="d-flex justify-content-center">
            <h3 style="color: #00b2d0ff;">INGRESO CON EXITO</h3>
        </div>
        <div class="d-flex justify-content-center">
            <img src="../../img/bitmap.png" alt="" style="width: 15rem;">
        </div>
        <div class="d-flex justify-content-center">
            <input onclick="inicio()" class="btn text-white w-100 mt-4" type="submit" value="Ir al Inicio" name="btn-ingresar" style="background-color: #00b2d0ff;">
        </div>
    </div>
</body>
</html>
