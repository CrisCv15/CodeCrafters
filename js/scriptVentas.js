// Definición de la función toggleCaja
function toggleCaja() {
  const cajaEstado = document.getElementById("cajaStatus");
  const btnToggle = document.getElementById("toggleCaja");

  if (cajaEstado.textContent === "CAJA: ABIERTA") {
      cajaEstado.textContent = "CAJA: CERRADA";
      btnToggle.classList.remove("btn-success");
      btnToggle.classList.add("btn-danger");
  } else {
      cajaEstado.textContent = "CAJA: ABIERTA";
      btnToggle.classList.remove("btn-danger");
      btnToggle.classList.add("btn-success");
  }
}

function agregarProducto(codigoBarras, descripcion, precio, stock) {
    // Crear una nueva fila en la tabla
    const productTableBody = document.getElementById("productTableBody");
    let existingRow = productTableBody.querySelector(`tr[data-codigo-barras="${codigoBarras}"]`);

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
            <td>${codigoBarras}</td>
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

        // Actualizar el campo oculto con los IDs de productos
        const productosInput = document.getElementById('productosInput');
        let productos = productosInput.value ? productosInput.value.split(',') : [];

        // Evitar duplicados
        if (!productos.includes(codigoBarras)) {
            productos.push(codigoBarras); // Agregar el nuevo código del producto
            productosInput.value = productos.join(','); // Actualizar el campo oculto
        }
    }

    // Actualizar el total de la venta
    actualizarTotalVenta();
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
}

// Función para eliminar un producto
function eliminarProducto(button) {
    const row = button.closest('tr');
    row.parentNode.removeChild(row);

    // Actualizar el total de la venta después de eliminar
    actualizarTotalVenta();
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




document.getElementById('formVentas').addEventListener('submit', function (event) {
    event.preventDefault(); // Prevenir el envío del formulario por defecto

    let formData = new FormData(this);
    let productosSeleccionados = []; // Suponiendo que los productos se guardan en un array

    // Agregar los IDs de los productos al array
    document.querySelectorAll('#productTableBody .producto').forEach(function (producto) {
        let idProducto = producto.getAttribute('data-id'); // Asegúrate de que cada fila tenga un atributo data-id
        productosSeleccionados.push(idProducto);
    });

    // Agregar los productos seleccionados al FormData
    formData.append('productos', productosSeleccionados);

    fetch('./php/caja/realizarVenta.php', {
        method: 'POST',
        body: formData,
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message); // Alerta de éxito
            // Aquí puedes agregar lógica para actualizar la interfaz de usuario
        } else {
            alert(data.message); // Alerta de error
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Se produjo un error al procesar la venta.'); // Alerta en caso de error en la solicitud
    });
});
