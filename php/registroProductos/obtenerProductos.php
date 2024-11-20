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
        <button id='editBtn' class='btn btn-warning btn-small' data-toggle='modal' data-target='#editModal'> <i class='fa-regular fa-pen-to-square'></i> Editar</button>
            
            <a href='javascript:void(0);' class='btn btn-danger btn-small' onclick='confirmarEliminar(\"{$datos->CodigoBarras}\")'>
                <i class='fa-solid fa-trash-can'></i> Eliminar
            </a>
        </td>
    </tr>";
}


if (empty($output)) {
    $output = "<tr><td colspan='5'>No se encontraron productos</td></tr>";
}

echo $output;


$conexion->close();
?>

