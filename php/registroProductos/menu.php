<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RegistroProductos</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/e3fc2f4517.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./css/styleRP.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
  <div class="table-wrapper">
    <div class="col-smg-6" id="AD">
      <h1 class="text-center p-3">Administrador de Productos</h1>
    </div>
  </div>

  <!-- Botón para mostrar/ocultar formulario -->
  <div class="text-center">
    <button class="btn btn-primary" id="mostrarFormulario">Registrar Producto</button>
  </div>

  <div class="container-fluid row r" id="formularioRegistro" style="display: none;">
    <form class="col-12 p-3 s" id="formRegistroProducto" method="POST">
      <h3 class="text-center text-secundary">Registro de productos</h3>
      <div class="mb-3">
          <label for="exampleInputCodigo" class="form-label i">Código de Barras</label>
          <input type="text" class="form-control" name="CodigoB">
      </div>
      <div class="mb-3">
          <label for="exampleInputCodigo" class="form-label i">Precio</label>
          <input type="text" class="form-control" name="Precio">
      </div>
      <div class="mb-3">
          <label for="exampleInputCodigo" class="form-label i">Descripción</label>
          <input type="text" class="form-control" name="Descripcion">
      </div>
      <div class="mb-3">
          <label for="exampleInputCodigo" class="form-label i">Stock</label>
          <input type="text" class="form-control" name="Stock">
      </div>
      <button type="submit" class="btn btn-primary" name="btnregistrar" value="ok">Registrar</button>
      
    </form>
  </div>

  <div id="mensaje"></div>

  <div class="col-12 d-flex justify-content-center">
    <table class="table" id="tablaProductos">
      <thead class="containerth">
        <tr>
          <th scope="col">CodigoDeBarras</th>
          <th scope="col">Precio</th>
          <th scope="col">Descripcion</th>
          <th scope="col">Stock</th>
        </tr>
      </thead>
      <tbody>
        <!-- Los productos se cargarán aquí dinámicamente -->
      </tbody>
    </table>
  </div>

  <script>
    $(document).ready(function () {
        // Cargar productos al iniciar la página
        cargarProductos();

        // Mostrar/Ocultar el formulario
        $('#mostrarFormulario').click(function() {
            $('#formularioRegistro').toggle();
            $('#mensaje').empty();
        });

        // Función para cargar productos en la tabla
        function cargarProductos() {
            $.ajax({
                url: './php/registroProductos/obtenerProductos.php',  // Ruta al archivo que devuelve los productos
                method: 'GET',
                success: function (data) {
                    $('#tablaProductos tbody').html(data);  // Inyectar el HTML recibido en la tabla
                },
                error: function () {
                    $('#mensaje').html('<div class="alert alert-danger">Error al cargar los productos.</div>');
                }
            });
        }

        // Evento para manejar el envío del formulario con AJAX
        $('#formRegistroProducto').on('submit', function (e) {
            e.preventDefault();  // Evitar que el formulario se envíe de manera tradicional
            $.ajax({
                url: './php/registroProductos/RegistroP.php',
                method: 'POST',
                data: $(this).serialize(),  // Enviar todos los campos del formulario
                success: function (response) {
                    $('#mensaje').html(response);  // Mostrar mensaje de éxito o error
                    $('#formRegistroProducto')[0].reset();  // Limpiar el formulario
                    cargarProductos();  // Volver a cargar la tabla de productos
                },
                error: function () {
                    $('#mensaje').html('<div class="alert alert-danger">Error al registrar el producto.</div>');
                }
            });
        });

        // Función de confirmación para la eliminación de productos
        window.confirmarEliminar = function(codigoB) {
            if (confirm('¿Estás seguro de que deseas eliminar este producto?')) {
                $.ajax({
                    url: './php/registroProductos/controlEliminar.php',  // Asegúrate de que la ruta es correcta
                    method: 'POST',
                    data: { CodigoB: codigoB },
                    success: function(response) {
                        $('#mensaje').html(response);
                        cargarProductos();  // Recargar la tabla de productos
                    },
                    error: function() {
                        $('#mensaje').html('<div class="alert alert-danger">Error al eliminar el producto.</div>');
                    }
                });
            }
        };

        
    });
</script>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
