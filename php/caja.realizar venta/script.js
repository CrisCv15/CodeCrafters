document.addEventListener("DOMContentLoaded", function () {
    const productSearch = document.getElementById("productSearch");
    const productTableBody = document.getElementById("productTableBody");
    const totalVenta = document.getElementById("totalVenta");
    const salesForm = document.getElementById("salesForm");
    const vuelto = document.getElementById("vuelto");
    let cart = [];
    let total = 0;

    // Función para buscar productos
    productSearch.addEventListener("input", function () {
        const searchTerm = productSearch.value;
        if (searchTerm.length > 2) {
            fetch(`sales.php?search=${searchTerm}`)
                .then(response => response.json())
                .then(products => {
                    productTableBody.innerHTML = '';
                    products.forEach(product => {
                        const row = document.createElement("tr");
                        row.innerHTML = `
                            <td>${product.code}</td>
                            <td>${product.name}</td>
                            <td><input type="number" value="1" min="1" class="form-control" data-price="${product.price}" data-code="${product.code}" /></td>
                            <td>${product.price}</td>
                            <td>${product.price}</td>
                            <td><button class="btn btn-danger btn-sm">Eliminar</button></td>
                        `;
                        productTableBody.appendChild(row);

                        // Agregar producto al carrito
                        cart.push({
                            codigo: product.code,
                            name: product.name,
                            price: product.price,
                            quantity: 1
                        });

                        // Actualizar total
                        total += product.price;
                        totalVenta.innerText = `$${total}`;

                        // Eliminar producto
                        row.querySelector("button").addEventListener("click", () => {
                            productTableBody.removeChild(row);
                            cart = cart.filter(p => p.codigo !== product.code);
                            total -= product.price;
                            totalVenta.innerText = `$${total}`;
                        });
                    });
                });
        }
    });

    // Calcular vuelto basado en monto efectivo
    const montoEfectivo = document.getElementById("montoEfectivo");
    montoEfectivo.addEventListener("input", function () {
        const efectivo = parseFloat(montoEfectivo.value);
        const change = efectivo - total;
        vuelto.innerText = `$${change >= 0 ? change : 0}`;
    });

    // Enviar venta
    salesForm.addEventListener("submit", function (e) {
        e.preventDefault();
        const paymentMethod = document.getElementById("paymentMethod").value;
        const efectivo = montoEfectivo.value || 0;

        fetch("sales.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
            },
            body: new URLSearchParams({
                productos: JSON.stringify(cart),
                metodoPago: paymentMethod,
                montoEfectivo: efectivo,
                totalVenta: total
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === "success") {
                alert("Venta realizada con éxito");

                // Reiniciar formulario
                cart = [];
                total = 0;
                productTableBody.innerHTML = '';
                totalVenta.innerText = '$0';
                vuelto.innerText = '$0';
                montoEfectivo.value = '';
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error("Error en la venta:", error);
            alert("Error al procesar la venta");
        });
    });
});
