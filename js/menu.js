$(document).ready(function () {
    cargarProductos();
    $('#mostrarFormulario').click(function() {
        $('#RegistModal').modal('show'); // Cambiado para abrir el modal directamente
        $('#mensaje').empty();
    });
    function cargarProductos() {
        $.ajax({
            url: './php/registroProductos/obtenerProductos.php',
            method: 'GET',
            success: function (data) {
                $('#tablaProductos tbody').html(data);
            },
            error: function () {
                $('#mensaje').html('<div class="alert alert-danger">Error al cargar los productos.</div>');
            }
        });
    }
    $('#formRegistroProducto').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            url: './php/registroProductos/RegistroP.php',
            method: 'POST',
            data: $(this).serialize(),
            success: function (response) {
                $('#mensaje').html(response);
                $('#formRegistroProducto')[0].reset();
                cargarProductos();
            },
            error: function () {
                $('#mensaje').html('<div class="alert alert-danger">Error al registrar el producto.</div>');
            }
        });
    });
    window.confirmarEliminar = function(codigoB) {
        if (confirm('¿Estás seguro de que deseas eliminar este producto?')) {
            $.ajax({
                url: './php/registroProductos/controlEliminar.php',
                method: 'POST',
                data: { CodigoB: codigoB },
                success: function(response) {
                    $('#mensaje').html(response);
                    cargarProductos();
                },
                error: function() {
                    $('#mensaje').html('<div class="alert alert-danger">Error al eliminar el producto.</div>');
                }
            });
        }
    };
    window.cargarDatosProducto = function(codigoB, precio, descripcion, stock) {
        $('#codigoB').val(codigoB);
        $('#precio').val(precio);
        $('#descripcion').val(descripcion);
        $('#stock').val(stock);
    };
    $('#editForm').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            url: './php/registroProductos/controlEditar.php', 
            method: 'POST',
            data: $(this).serialize(),  
            success: function (response) {
                $('#mensaje').html(response);
                $('#editModal').modal('hide'); 
                cargarProductos();  
            },
            error: function () {
                $('#mensaje').html('<div class="alert alert-danger">Error al editar el producto.</div>');
            }
        });
    });
    $(document).on('click', '#editBtn', function () {
        const row = $(this).closest('tr');
        const codigoB = row.find('td:eq(0)').text();
        const precio = row.find('td:eq(1)').text();
        const descripcion = row.find('td:eq(2)').text();
        const stock = row.find('td:eq(3)').text();
        cargarDatosProducto(codigoB, precio, descripcion, stock);
    });
});