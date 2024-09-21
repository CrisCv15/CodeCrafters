<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usr'])) {
    // Si no hay sesión activa, redirige al login
    header("Location: ./php/Login/Login.php");
    exit;
}
?>
<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BMos</title>
    <link rel="stylesheet" href="./css/style.css">
  </head>
  <body>

    <div class="main"></div>

    <div class="barra-lateral">
        <div class="nombre-pagina">
          <ion-icon name="home-outline" id="home"></ion-icon>
          <span>BMos</span>
        </div>
        <button class="boton">
          <ion-icon name="add-outline"></ion-icon>
          <span>Create New</span>
        </button>
        <nav class="navegacion" style="list-style: none;">
          <ul>
            <li>
              <a href="#">
                <ion-icon name="home-outline"></ion-icon>
                <span>Inicio</span>
              </a>
            </li>
            <li>
              <a href="#">
                <ion-icon name="list-outline"></ion-icon>
                <span>Ventas</span>
              </a>
            </li>
            <li>
              <a href="./php/registroProductos/menu.php">
                <ion-icon name="pricetags-outline"></ion-icon>
                <span>Productos</span>
              </a>
            </li>
            <li>
              <a href="#">
                <ion-icon name="stats-chart-outline"></ion-icon>
                <span>Estadísticas</span>
              </a>
            </li>
            <li>
              <a href="./php/CerrarSesion/cerrar_sesion.php">
                <ion-icon name="close-circle-outline"></ion-icon>
                <span>Cerrar Sesión</span>
              </a>
            </li>
          </ul>
        </nav>

        <div class="linea"></div>

        <div class="usuario">
          <img src="./img/login-icon.svg" alt="Ícono de usuario">
          <div class="info-usuario">
            <div class="nombre-email">
              <span class="nombre"><?php echo htmlspecialchars($_SESSION["nombre"]); ?></span>
              <span class="email"><?php echo htmlspecialchars($_SESSION["email"]); ?></span>
            </div>
            <ion-icon name="ellipsis-vertical-outline"></ion-icon>
          </div>
        </div>
    </div>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="./js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>
