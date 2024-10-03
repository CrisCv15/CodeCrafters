<?php
include "../conexion_be.php";  


$sql = $conexion->query("
    SELECT 
        producto.Descripcion, 
        producto.Precio, 
        ventas.NumeroTicket, 
        ventas.FormaPago, 
        ventas.FechayHora, 
        ventas.cantidad
    FROM ventas
    JOIN ventasproductos ON ventasproductos.NumeroTicket = ventas.NumeroTicket
    JOIN producto ON ventasproductos.CodigoBarras = producto.CodigoBarras
");

if (!$sql) {
    echo "Error en la consulta: " . $conexion->error;
    exit();
}

$output = '';
$hayVentas = false;  


while ($datos = $sql->fetch_object()) {
    $hayVentas = true;  
    $output .= "
    <tr>
        <td>{$datos->Descripcion}</td>
        <td>{$datos->Precio}</td>
        <td>{$datos->NumeroTicket}</td>
        <td>{$datos->FormaPago}</td>
        <td>{$datos->FechayHora}</td>
        <td>{$datos->cantidad}</td>
    </tr>";
}


if (!$hayVentas) {
    $output = "<tr><td colspan='6'>No se encontraron ventas</td></tr>";
}

echo $output;

$conexion->close();
?>
