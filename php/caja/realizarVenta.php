<?php
require_once '../conexion_be.php'; // Asegúrate de ajustar la ruta si es necesario

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Leer el contenido JSON de la solicitud
    $input = json_decode(file_get_contents('php://input'), true);

    $formaPago = $input['formaPago'] ?? null;
    $totalVenta = $input['totalVenta'] ?? null;
    $productos = $input['productos'] ?? []; // Decodificar productos en JSON

    // Verificar que se hayan recibido todos los datos necesarios
    if ($formaPago && $totalVenta && !empty($productos)) {
        // Iniciar la transacción
        $conexion->begin_transaction();

        try {
            // Insertar en la tabla de ventas sin el Número de Ticket, ya que es autoincrement
            $stmtVenta = $conexion->prepare("INSERT INTO ventas (FechayHora, FormaPago, totalVenta) VALUES (NOW(), ?, ?)");
            $stmtVenta->bind_param("sd", $formaPago, $totalVenta); // 'sd' para string y decimal

            if (!$stmtVenta->execute()) {
                throw new Exception("Error al registrar la venta: " . $stmtVenta->error);
            }

            // Obtener el número de ticket generado automáticamente
            $nroTicket = $conexion->insert_id;

            // Insertar productos en ventasproductos
            foreach ($productos as $producto) {
                $codigoBarras = $producto['codigo'];
                $cantidad = $producto['cantidad'];

                // Verificar el stock del producto
                $query = "SELECT Stock FROM producto WHERE CodigoBarras = ?";
                $stmtStock = $conexion->prepare($query);
                $stmtStock->bind_param("s", $codigoBarras);
                $stmtStock->execute();
                $resultado = $stmtStock->get_result();

                if ($resultado->num_rows > 0) {
                    $row = $resultado->fetch_assoc();
                    $stockActual = $row['Stock'];

                    if ($stockActual >= $cantidad) {
                        // Insertar en la tabla ventasproductos
                        $stmtProducto = $conexion->prepare("INSERT INTO ventasproductos (NumeroTicket, CodigoBarras, cantidadProducto) VALUES (?, ?, ?)");
                        $stmtProducto->bind_param("isi", $nroTicket, $codigoBarras, $cantidad);
                        if (!$stmtProducto->execute()) {
                            throw new Exception("Error al registrar el producto: " . $stmtProducto->error);
                        }

                        // Actualizar el stock del producto
                        $nuevoStock = $stockActual - $cantidad;
                        $stmtUpdate = $conexion->prepare("UPDATE producto SET Stock = ? WHERE CodigoBarras = ?");
                        $stmtUpdate->bind_param("is", $nuevoStock, $codigoBarras);
                        if (!$stmtUpdate->execute()) {
                            throw new Exception("Error al actualizar el stock: " . $stmtUpdate->error);
                        }
                    } else {
                        throw new Exception("Stock insuficiente para el producto con código: $codigoBarras.");
                    }
                } else {
                    throw new Exception("Producto con código $codigoBarras no encontrado.");
                }
            }

            // Confirmar la transacción
            $conexion->commit();
            echo json_encode(["success" => true, "message" => "Venta registrada con éxito."]);
        } catch (Exception $e) {
            // Revertir la transacción en caso de error
            $conexion->rollback();
            echo json_encode(["success" => false, "message" => $e->getMessage()]);
        } finally {
            // Cerrar sentencias preparadas
            $stmtVenta->close();
            if (isset($stmtProducto)) $stmtProducto->close();
            if (isset($stmtUpdate)) $stmtUpdate->close();
            if (isset($stmtStock)) $stmtStock->close();
        }
    } else {
        echo json_encode(["success" => false, "message" => "Datos incompletos."]);
    }
}

$conexion->close();
?>
