<?php
header('Content-Type: application/json');
include '../conexion_be.php'; // Archivo de conexión

// Verificar si la conexión es exitosa
if (!$conexion) {
    die(json_encode(['error' => 'Error de conexión a la base de datos']));
}

// Consultar el último registro para determinar si la caja está abierta o cerrada
$resultado = mysqli_query($conexion, "SELECT Cierre FROM caja ORDER BY FechayHora DESC LIMIT 1");
$fila = mysqli_fetch_assoc($resultado);

// La caja está abierta si el campo Cierre es NULL
$abierta = $fila && is_null($fila['Cierre']);

echo json_encode(['abierta' => $abierta]);
mysqli_close($conexion);
?>
