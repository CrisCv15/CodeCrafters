<?php
header('Content-Type: application/json');
include '../conexion_be.php'; 


if (!$conexion) {
    die(json_encode(['error' => 'Error de conexión a la base de datos']));
}


$resultado = mysqli_query($conexion, "SELECT Cierre FROM caja ORDER BY FechayHora DESC LIMIT 1");
$fila = mysqli_fetch_assoc($resultado);


$abierta = $fila && is_null($fila['Cierre']);

echo json_encode(['abierta' => $abierta]);
mysqli_close($conexion);
?>
