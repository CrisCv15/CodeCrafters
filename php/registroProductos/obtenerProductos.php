<?php
include "../conexion_be.php";  // Asegúrate de que la ruta a la conexión es correcta

// Consulta para obtener todos los productos
$sql = $conexion->query("SELECT * FROM producto");

if (!$sql) {
    // Si hay un error en la consulta, muéstralo para depurar
    echo "Error en la consulta: " . $conexion->error;
    exit();
}

$output = '';

while ($datos = $sql->fetch_object()) {
    $output .= "
    <tr>
        <td>{$datos->CodigoBarras}</td>
        <td>{$datos->Precio}</td>
        <td>{$datos->Descripcion}</td>
        <td>{$datos->Stock}</td>
        <td>
            <a href='editar.php?CodigoBarras={$datos->CodigoBarras}' class='btn btn-warning btn-small'>
                <i class='fa-regular fa-pen-to-square'></i>
            </a>
            <a href='./menu.php?CodigoBarras={$datos->CodigoBarras}' onclick='return confirmar()' class='btn btn-danger btn-small'>
                <i class='fa-solid fa-trash-can'></i>
            </a>
        </td>
    </tr>";
}

// Si no hay productos, devuelve un mensaje
if (empty($output)) {
    $output = "<tr><td colspan='5'>No se encontraron productos</td></tr>";
}

echo $output;

// Cerrar la conexión
$conexion->close();
?>
