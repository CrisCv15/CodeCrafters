<?php
include "../conexion_be.php"; 

if (isset($_POST['codigoBarras'])) {
    $codigoBarras = $_POST['codigoBarras'];

    // Preparar la consulta para buscar el producto por código de barras
    $query = "SELECT * FROM producto WHERE CodigoBarras = ?";
    $stmt = mysqli_prepare($conexion, $query);
    mysqli_stmt_bind_param($stmt, "s", $codigoBarras);  // El "s" indica que es una cadena
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Verificar si el producto existe
    if (mysqli_num_rows($result) > 0) {
        $producto = mysqli_fetch_assoc($result);
        $cantidad = 1;
        // Mostrar los datos del producto en una tabla
        echo "
            <tr>
                <td>{$producto['CodigoBarras']}</td>
                <td>{$producto['Descripcion']}</td>
                <td>$cantidad</td>
                <td>{$producto['Precio']}</td>
                <td>$cantidad * {$producto['Stock']}</td>
                <td></td>
            </tr>
        </table>";
    } else {
        echo "No se encontró ningún producto con el código de barras proporcionado.";
    }

    // Cerrar la conexión
    mysqli_stmt_close($stmt);
    mysqli_close($conexion);
} else {
    echo "No se envió ningún código de barras.";
}
?>

