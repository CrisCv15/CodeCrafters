

// Función global para alternar el estado de la caja
function toggleCaja() {
    console.log("Función toggleCaja llamada"); // Verificación de llamada
    const statusLabel = document.getElementById("cajaStatus");
    const toggleButton = document.getElementById("toggleCaja");
    const abrir = statusLabel.textContent.includes("CERRADA");
    const confirmacion = confirm(`¿Estás seguro de que quieres ${abrir ? "abrir" : "cerrar"} la caja?`);

    if (confirmacion) {
        fetch('./php/caja/actualizar_estado.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ abierta: abrir }),
        })
        .then(response => response.json())
        .then(data => {
            console.log("Respuesta de actualizar_estado.php:", data); // Verificación de respuesta
            if (data.success) {
                cargarEstadoCaja(); // Actualizar el estado visual después de cambiarlo
            } else {
                alert('Error al actualizar el estado de la caja');
            }
        })
        .catch(error => {
            console.error('Error al actualizar el estado:', error);
            alert('Hubo un problema al comunicarse con el servidor.');
        });
    }
}

// Función para cargar el estado de la caja desde el backend al cargar la página
function cargarEstadoCaja() {
    console.log("Cargando estado de la caja"); // Verificación de llamada
    fetch('./php/caja/estado_caja.php')
        .then(response => {
            if (!response.ok) {
                throw new Error('Error en la respuesta del servidor');
            }
            return response.json();
        })
        .then(data => {
            console.log("Datos recibidos de estado_caja.php:", data); // Verificación de datos
            const statusLabel = document.getElementById("cajaStatus");
            const toggleButton = document.getElementById("toggleCaja");

            if (data.abierta) {
                console.log("Actualizando estado: CAJA ABIERTA");
                statusLabel.textContent = "CAJA: ABIERTA";
                toggleButton.classList.remove("btn-danger");
                toggleButton.classList.add("btn-success");
            } else {
                console.log("Actualizando estado: CAJA CERRADA");
                statusLabel.textContent = "CAJA: CERRADA";
                toggleButton.classList.remove("btn-success");
                toggleButton.classList.add("btn-danger");
            }
        })
        .catch(error => {
            console.error('Error al cargar el estado:', error);
            alert('Hubo un problema al cargar el estado de la caja.');
        });
}

// Ejecutar la función de carga de estado al cargar la página
window.onload = () => {
    console.log("window.onload ejecutado");
    cargarEstadoCaja();
};
        
        $(window).on('hashchange', function() {
            let hash = window.location.hash;
         
        if(hash == "#caja"){
            cargarEstadoCaja();
        }
          });
    



function agregarProducto(codigoBarras, descripcion, precio, stock) {
    // Crear una nueva fila en la tabla
    const productTableBody = document.getElementById("productTableBody");
    let existingRow = productTableBody.querySelector(`tr[data-codigo-barras="${codigoBarras}"]`);
    const caja = document.getElementById("cajaStatus");

    if(caja.textContent == "CAJA: ABIERTA"){
        if (existingRow) {
            // Si el producto ya existe, incrementar la cantidad
            const quantityCell = existingRow.querySelector('.cantidad');
            let currentQuantity = parseInt(quantityCell.textContent);
            currentQuantity += 1; // Incrementar la cantidad
    
            // Actualizar la celda de cantidad
            quantityCell.textContent = currentQuantity;
    
            // Actualizar el total del producto
            const precio = parseFloat(existingRow.cells[3].textContent);
            existingRow.cells[4].textContent = (currentQuantity * precio).toFixed(2);
    
        } else {
            // Si el producto no existe, crear una nueva fila
            const newRow = document.createElement("tr");
    
            // Establecer un atributo data-codigo-barras para identificar la fila
            newRow.setAttribute('data-codigo-barras', codigoBarras);
    
            // Inicializar cantidad en 1
            let cantidad = 1;
    
            newRow.innerHTML = `
            <td class="codigoProducto">${codigoBarras}</td>
            <td>${descripcion}</td>
            <td class="cantidad">${cantidad}</td>
            <td>${precio}</td>
            <td>${(cantidad * precio).toFixed(2)}</td>
            <td>
                <button type="button" class="btn btn-success btn-sm" onclick="cambiarCantidad('${codigoBarras}', 1, event)">+</button>
                <button type="button" class="btn btn-warning btn-sm" onclick="cambiarCantidad('${codigoBarras}', -1, event)">-</button>
                <button type="button" class="btn btn-danger btn-sm" onclick="eliminarProducto(this)">Eliminar</button>
            </td>
        `;
    
            // Agregar la nueva fila al cuerpo de la tabla
            productTableBody.appendChild(newRow);
        }
    
        // Actualizar el total de la venta
        actualizarTotalVenta();
        actualizarProductosInput();

    }else{
        alert("Antes debe abrir la caja");
    }

    
}

// Función para cambiar la cantidad de un producto
function cambiarCantidad(codigoBarras, cambio, event) {
    event.preventDefault(); // Prevenir el comportamiento por defecto

    const row = document.querySelector(`tr[data-codigo-barras="${codigoBarras}"]`);
    const quantityCell = row.querySelector('.cantidad');
    let currentQuantity = parseInt(quantityCell.textContent);

    // Cambiar la cantidad
    currentQuantity += cambio;

    // No permitir que la cantidad sea menor a 1
    if (currentQuantity < 1) {
        eliminarProducto(row.querySelector('.btn-danger'));
    } else {
        quantityCell.textContent = currentQuantity;
    }

    // Actualizar el total del producto
    const precio = parseFloat(row.cells[3].textContent);
    row.cells[4].textContent = (currentQuantity * precio).toFixed(2);

    // Actualizar el total de la venta
    actualizarTotalVenta();
    actualizarProductosInput();
}

// Función para eliminar un producto
function eliminarProducto(button) {
    const row = button.closest('tr');
    row.parentNode.removeChild(row);

    // Actualizar el total de la venta después de eliminar
    actualizarTotalVenta();
    actualizarProductosInput();
}

// Función para calcular y actualizar el total de la venta
function actualizarTotalVenta() {
    const totalVentaElement = document.getElementById("totalVenta");
    const rows = document.querySelectorAll("#productTableBody tr");
    let total = 0;

    rows.forEach(row => {
        const totalProducto = parseFloat(row.cells[4].textContent);
        total += totalProducto;
    });

    totalVentaElement.textContent = total.toFixed(2); // Actualiza el total en el elemento

    // Actualiza el vuelto en tiempo real
    actualizarVuelto();
}

// Función para actualizar el monto efectivo y el vuelto
function actualizarMontoEfectivo() {
    const montoEfectivoInput = document.getElementById("montoEfectivoInput");
    const montoEfectivo = parseFloat(montoEfectivoInput.value) || 0; // Asegúrate de obtener el valor
    document.getElementById("montoEfectivo").textContent = montoEfectivo.toFixed(2); // Actualiza el monto efectivo

    // Actualiza el vuelto en tiempo real
    actualizarVuelto();
}

// Función para actualizar el vuelto
function actualizarVuelto() {
    const total = parseFloat(document.getElementById("totalVenta").textContent) || 0;
    const montoEfectivo = parseFloat(document.getElementById("montoEfectivo").textContent) || 0; // Asegúrate de usar el texto del monto efectivo
    const vuelto = montoEfectivo - total;

    document.getElementById("vuelto").textContent = vuelto.toFixed(2);
}

$(document).ready(function() {
    $("#formVentas").on("submit", function(event) {
        event.preventDefault();

        
        const formaPago = $("#formaPago").val();
        const totalVenta = document.getElementById("totalVenta").textContent;
        const productos = [];

        // Recopilar productos de la tabla
        $("#productTableBody tr").each(function() {
            const codigo = $(this).find(".codigoProducto").text(); // Corregido para obtener el código
            const cantidad = $(this).find(".cantidad").text(); // Obtener cantidad correctamente
            productos.push({ codigo, cantidad: parseInt(cantidad) }); // Asegúrate de pasar la cantidad como número
        });

        // Enviar la solicitud de venta con AJAX
        $.ajax({
            url: "./php/caja/realizarVenta.php",
            type: "POST",
            contentType: "application/json",
            data: JSON.stringify({
                formaPago: formaPago,
                totalVenta: totalVenta,
                productos: productos
            }),
            dataType: "json",
            success: function(response) {
                if (response.success) {
                    alert(response.message);
                    $("#formVentas")[0].reset();
                    $("#productTableBody").empty(); // Limpiar la tabla después de registrar la venta
                    actualizarTotalVenta(); // Asegúrate de actualizar el total después de limpiar
                } else {
                    alert("Error: " + response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error("Estado:", status);
                console.error("Error:", error);
                console.error("Detalles del error:", xhr.responseText);
                alert("Hubo un error al procesar la venta.");
            }
        });
    });
});

function actualizarProductosInput() {
    const productosInput = document.getElementById('productosInput');
    const productos = []; // Crea un array para almacenar los productos

    // Recorre la tabla para obtener los productos y sus cantidades
    document.querySelectorAll('#productTableBody tr').forEach(row => {
        const codigo = row.querySelector('.codigoProducto').innerText; // Asumiendo que tienes una celda con la clase 'codigoProducto'
        const cantidad = row.querySelector('.cantidad').textContent; // Corregido para obtener la cantidad
        productos.push({ codigo, cantidad });
    });

    // Establece el valor del input oculto como un JSON
    productosInput.value = JSON.stringify(productos);
}
