<?php
include "../conexion_be.php";  


$sql = $conexion->query("SELECT * FROM producto");

if (!$sql) {
    
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
                <i class='fa-regular fa-pen-to-square'></i> Editar
            </a>
            <a href='javascript:void(0);' class='btn btn-danger btn-small' onclick='confirmarEliminar(\"{$datos->CodigoBarras}\")'>
                <i class='fa-solid fa-trash-can'></i> Eliminar
            </a>
        </td>
    </tr>";
}

// Si no hay productos, devuelve un mensaje
if (empty($output)) {
    $output = "<tr><td colspan='5'>No se encontraron productos</td></tr>";
}

echo $output;


$conexion->close();
?>

