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
        // Cargar ventas al iniciar la página
        cargarVentas();

        // Función para cargar ventas con filtros
        function cargarVentas() {
            var ventasDesde = $('#ventasDesde').val();
            var ventasHasta = $('#ventasHasta').val();
            var metodoPago = $('input[name="formaPago"]:checked').val();  

            $.ajax({
                url: './php/Ventas/obtenerVentas.php',
                method: 'GET',
                data: {
                    ventasDesde: ventasDesde,
                    ventasHasta: ventasHasta,
                    metodoPago: metodoPago
                },
                success: function (data) {
                    $('#tablaVentas tbody').html(data);  
                },
                error: function () {
                    $('#mensaje').html('<div class="alert alert-danger">Error al cargar las ventas.</div>');
                }
            });
        }

        
        $('#btnBuscar').on('click', function () {
            cargarVentas();
        });
    });
    </script>
</head>
<body>
    <div id="ventas">
    <div class="container">
        <h2 class="text-center my-4" style="background-color: #00a3e0; color: white;">Ventas Registradas</h2>

       
        <div class="card">
            <div class="card-body">
                <h4>Criterios de Búsqueda</h4>
                <div class="row">
                    <div class="col-md-4">
                        <label for="ventasDesde">Ventas Desde:</label>
                        <input type="date" id="ventasDesde" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label for="ventasHasta">Ventas Hasta:</label>
                        <input type="date" id="ventasHasta" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label>Forma de Pago:</label><br>
                        <input type="checkbox" id="débito" name="formaPago" value="Débito"> Debito
                        <input type="checkbox" id="efectivo" name="formaPago" value="Efectivo"> Efectivo
                    </div>
                </div>
                <div class="mt-3 text-right">
                    <button id="btnBuscar" class="btn btn-primary">Buscar</button>
                </div>
            </div>
        </div>

        
        <div class="table-responsive mt-4">
            <table class="table table-bordered" id="tablaVentas">
                <thead style="background-color: #00a3e0; color: white;">
                    <tr>
                        <th scope="col">Nro. Ticket</th>
                        <th scope="col">Fecha</th>
                        <th scope="col">Hora</th>
                        <th scope="col">Método Pago</th>
                        <th scope="col">Total</th>
                        <th scope="col">Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
            </table>
        </div>

        <div id="mensaje"></div> <!-- Mensaje de error si ocurre -->

        
    </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
