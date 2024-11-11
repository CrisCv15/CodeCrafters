<?php
header('Content-Type: application/json');
include '../conexion_be.php'; // Archivo de conexión a la base de datos

// Verificar si la conexión es exitosa
if (!$conexion) {
    die(json_encode(['error' => 'Error de conexión a la base de datos']));
}

// Establecer la zona horaria
date_default_timezone_set('America/Montevideo');

// Leer el JSON enviado
$input = json_decode(file_get_contents('php://input'), true);
$abierta = $input['abierta'];

// Obtener solo la hora actual (sin fecha)
$horaActual = date('H:i:s');

if ($abierta) {
    // Insertar un nuevo registro de apertura con la hora actual en la columna `Apertura`
    $query = "INSERT INTO caja (FechayHora, Apertura, ID) VALUES (NOW(), '$horaActual', 1)";
} else {
    // Obtener la fecha y hora de la última apertura
    $resultadoApertura = mysqli_query($conexion, "SELECT FechayHora FROM caja ORDER BY FechayHora DESC LIMIT 1");
    $filaApertura = mysqli_fetch_assoc($resultadoApertura);
    $fechaHoraApertura = $filaApertura['FechayHora'];

    // Calcular el total de las ventas entre la apertura y el cierre
    $queryVentas = "SELECT SUM(totalVenta) AS totalVentas FROM ventas WHERE FechayHora BETWEEN '$fechaHoraApertura' AND NOW()";
    $resultadoVentas = mysqli_query($conexion, $queryVentas);
    $filaVentas = mysqli_fetch_assoc($resultadoVentas);
    $totalVentas = $filaVentas['totalVentas'] ? $filaVentas['totalVentas'] : 0; // Asegúrate de que no sea NULL

    // Actualizar el último registro para marcar la hora de cierre y el total de ventas
    $query = "UPDATE caja SET Cierre = '$horaActual', Registrototal = '$totalVentas' WHERE FechayHora = (SELECT MAX(FechayHora) FROM caja)";
}

if (mysqli_query($conexion, $query)) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['error' => 'Error al actualizar el estado']);
}

mysqli_close($conexion);
?>
