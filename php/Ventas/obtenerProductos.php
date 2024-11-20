<?php
include "../conexion_be.php";

if (isset($_GET['numeroTicket'])) {
    $numeroTicket = $_GET['numeroTicket'];

    // Consulta para obtener los productos asociados al número de ticket
    $query = "
        SELECT 
            producto.CodigoBarras, 
            producto.Descripcion, 
            producto.Precio, 
            ventasproductos.cantidadProducto
        FROM ventasproductos
        JOIN producto ON ventasproductos.CodigoBarras = producto.CodigoBarras
        WHERE ventasproductos.NumeroTicket = '$numeroTicket'
    ";

    $result = $conexion->query($query);

    $productos = [];

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $productos[] = $row;
        }
    }

    
    header('Content-Type: application/json');
    echo json_encode($productos);

    $conexion->close();
} else {
    // Respuesta de error si no se pasa el parámetro
    header('HTTP/1.1 400 Bad Request');
    echo json_encode(['error' => 'No se proporcionó el número de ticket']);
}
?>
