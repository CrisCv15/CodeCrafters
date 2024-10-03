<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ventas Registradas</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/e3fc2f4517.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./css/styleListaVentas.css"> 
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
    $(document).ready(function () {
        
        cargarVentas();

        function cargarVentas() {
            $.ajax({
                url: './php/Ventas/obtenerVentas.php',  
                method: 'GET',
                success: function (data) {
                    $('#tablaVentas tbody').html(data);  
                },
                error: function (xhr, status, error) {  
                    console.error("Error en AJAX: ", status, error);
                    $('#mensaje').html('<div class="alert alert-danger">Error al cargar las ventas.</div>');
                }
            });
        }
    });
    </script>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-12 d-flex justify-content-center">
                <table class="table" id="tablaVentas">
                    <thead class="containerth">
                        <tr>
                            <th scope="col">Producto</th>
                            <th scope="col">Precio</th>
                            <th scope="col">Numero de ticket</th>
                            <th scope="col">Forma de Pago</th>
                            <th scope="col">Fecha y Hora</th>
                            <th scope="col">Cantidad</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Las ventas se cargarán aquí dinámicamente -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
