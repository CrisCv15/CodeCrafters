<?php
include "../conexion_be.php";

// Variables para los filtros
$ventasDesde = isset($_GET['ventasDesde']) ? $_GET['ventasDesde'] : null;
$ventasHasta = isset($_GET['ventasHasta']) ? $_GET['ventasHasta'] : null;
$metodoPago = isset($_GET['metodoPago']) ? $_GET['metodoPago'] : null;

// Construir la consulta con JOIN y filtros
$query = "
    SELECT 
        ventas.NumeroTicket, 
        ventas.FechayHora, 
        ventas.FormaPago, 
        ventas.totalVenta 
    FROM ventas
    JOIN ventasproductos ON ventas.NumeroTicket = ventasproductos.NumeroTicket
    JOIN producto ON ventasproductos.CodigoBarras = producto.CodigoBarras
    WHERE 1=1
";

// Aplicar filtros si existen
if ($ventasDesde) {
    $query .= " AND ventas.FechayHora >= '$ventasDesde'";
}
if ($ventasHasta) {
    $query .= " AND ventas.FechayHora <= '$ventasHasta'";
}
if ($metodoPago) {
    $query .= " AND ventas.FormaPago = '$metodoPago'";
}

$query .= " GROUP BY ventas.NumeroTicket ORDER BY ventas.FechayHora DESC";

$sql = $conexion->query($query);

if (!$sql) {
    echo "Error en la consulta: " . $conexion->error;
    exit();
}

$output = '';
$hayVentas = false;  

// Procesar los resultados de la consulta
while ($datos = $sql->fetch_object()) {
    $hayVentas = true;  
    $fechaHora = explode(' ', $datos->FechayHora);  // Separar fecha y hora

    $output .= "
    <tr>
        <td>{$datos->NumeroTicket}</td>
        <td>{$fechaHora[0]}</td>
        <td>{$fechaHora[1]}</td>
        <td>{$datos->FormaPago}</td>
        <td>{$datos->totalVenta}</td>
        <td class='text-center'>
         <button class='btn btn-success' data-bs-toggle='modal' data-bs-target='#productosModal' onclick='mostrarProductos({$datos->NumeroTicket})'>
                Ver Productos
            </button>
        
        </td>
        <td class='text-center'>
            <button class='btn btn-info'><i class='fas fa-print'></i></button>
        </td>
    </tr>";
}

if (!$hayVentas) {
    $output = "<tr><td colspan='6'>No se encontraron ventas</td></tr>";
}

echo $output;

$conexion->close();
?>
