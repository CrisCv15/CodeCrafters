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
    <title>BMos</title>
    <link rel="stylesheet" href="./css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
      // Función para confirmar cierre de sesión
      function confirmarCerrarSesion(event) {
        event.preventDefault();
        const confirmar = confirm("¿Estás seguro de que quieres cerrar sesión?");
        if (confirmar) {
            window.location.href = "./php/CerrarSesion/cerrar_sesion.php";
        }
      }

      // Función para cargar contenido dinámicamente
      function cargarContenido(hash) {
        let url = '';
        switch (hash) {
          case '#inicio':
            url = './php/inicio/inicio.php';
            break; 
          case '#ventas':
            url = './php/ventas/ventas.php';
            break;
          case '#caja':
            url = './php/caja/Html.html';
            break;
          case '#productos':
            url = './php/registroProductos/menu.php';
            break;
          case '#estadisticas':
            url = './php/estadisticas.php';
            break;
          default:
            url = './php/inicio.php';
            break;
        }

        // Cargar contenido en el div 'contenido-principal'
        $('.contenido-principal').load(url);
      }

      $(document).ready(function() {
        $(window).on('hashchange', function() {
          let hash = window.location.hash;
          cargarContenido(hash);
        });

        // Cargar contenido inicial (inicio por defecto)
        let initialHash = window.location.hash || '#inicio';
        cargarContenido(initialHash);
      });
    </script>
  </head>
  <body>

    <!-- Contenedor principal con flexbox -->
    <div class="contenedor-principal">
      
      <!-- Barra lateral -->
      <div class="barra-lateral">
        <div class="nombre-pagina">
          <ion-icon name="home-outline" id="home"></ion-icon>
          <span>BMos</span>
        </div>

        <button class="boton">
          <ion-icon name="add-outline"></ion-icon>
          <span>Create New</span>
        </button>

        <nav class="navegacion">
          <ul>
            <li><a href="#inicio"><ion-icon name="home-outline"></ion-icon>Inicio</a></li>
            <li><a href="#ventas"><ion-icon name="list-outline"></ion-icon>Ventas</a></li>
            <li><a href="#caja"><ion-icon name="cart-outline"></ion-icon>Caja</a></li>
            <li><a href="#productos"><ion-icon name="pricetags-outline"></ion-icon>Productos</a></li>
            <li><a href="#estadisticas"><ion-icon name="stats-chart-outline"></ion-icon>Estadísticas</a></li>
            <li><a href="./php/CerrarSesion/cerrar_sesion.php" onclick="confirmarCerrarSesion(event)">
              <ion-icon name="close-circle-outline"></ion-icon>Cerrar Sesión</a></li>
          </ul>
        </nav>

        <div class="linea"></div>

        
      </div>

      <!-- Contenedor de contenido principal -->
      <div class="contenido-principal">
        <!-- Aquí se cargará el contenido dinámico -->
      </div>

    </div>
      
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>