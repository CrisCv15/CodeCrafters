<?php
include "../conexion_be.php"; 

// Procesar la venta
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productos = $_POST['productos']; // Lista de productos comprados
    $metodoPago = $conn->real_escape_string($_POST['metodoPago']);
    $montoEfectivo = $conn->real_escape_string($_POST['montoEfectivo']);
    $totalVenta = $conn->real_escape_string($_POST['totalVenta']);

    // Obtener la fecha y hora actual para la transacción
    $fechaHoraActual = date('Y-m-d H:i:s');

    try {
        // Iniciar la transacción
        $conexion->begin_transaction();

        // Verificar si hay una caja abierta (supongo que la caja se debe abrir antes de realizar la venta)
        $sqlCaja = "SELECT FechayHora FROM Caja WHERE FechayHora = ?";
        $stmtCaja = $conexion->prepare($sqlCaja);
        $stmtCaja->bind_param("s", $fechaHoraActual);
        $stmtCaja->execute();
        $resultCaja = $stmtCaja->get_result();

        if ($resultCaja->num_rows == 0) {
            throw new Exception("No hay una caja abierta para registrar la venta.");
        }

        // Insertar la venta en la tabla Ventas
        $sqlVenta = "INSERT INTO Ventas (FechayHora, formaPago) VALUES (?, ?)";
        $stmtVenta = $conexion->prepare($sqlVenta);
        $stmtVenta->bind_param("ss", $fechaHoraActual, $metodoPago);
        $stmtVenta->execute();

        // Obtener el número de ticket de la venta recién creada
        $numTicket = $stmtVenta->insert_id;

        // Insertar cada producto en la tabla ventasProductos y actualizar el inventario en Producto
        foreach ($productos as $producto) {
            $codigoBarras = $conexion->real_escape_string($producto['codigo']);
            $cantidad = $conexion->real_escape_string($producto['cantidad']);

            // Insertar en ventasProductos
            $sqlVentasProductos = "INSERT INTO ventasproductos (NumeroTicket, CodigoBarras) VALUES (?, ?)";
            $stmtVentasProductos = $conexion->prepare($sqlVentasProductos);
            $stmtVentasProductos->bind_param("is", $numTicket, $codigoBarras);
            $stmtVentasProductos->execute();

            // Actualizar stock del producto en la tabla Producto
            $sqlUpdateStock = "UPDATE Producto SET stock = stock - ? WHERE codBarras = ?";
            $stmtUpdateStock = $conexion->prepare($sqlUpdateStock);
            $stmtUpdateStock->bind_param("is", $cantidad, $codigoBarras);
            $stmtUpdateStock->execute();
        }

        // Confirmar la transacción
        $conexion->commit();
        echo json_encode(['status' => 'success', 'message' => 'Venta realizada con éxito']);

    } catch (Exception $e) {
        // Revertir la transacción en caso de error
        $conexion->rollback();
        echo json_encode(['status' => 'error', 'message' => 'Error al procesar la venta: ' . $e->getMessage()]);
    }
}

// Cerrar la conexión
$conexion->close();
?>

