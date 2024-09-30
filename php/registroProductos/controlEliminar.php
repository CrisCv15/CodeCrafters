<?php
include "../conexion_be.php"; 

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['CodigoB'])) {
    $codigoB = $conexion->real_escape_string($_POST['CodigoB']);

    // Consulta para eliminar el producto
    $sql = "DELETE FROM producto WHERE CodigoBarras='$codigoB'";
    if ($conexion->query($sql) === TRUE) {
        echo '<div class="alert alert-success">Producto eliminado con éxito.</div>';
    } else {
        echo '<div class="alert alert-danger">Error al eliminar el producto: ' . $conexion->error . '</div>';
    }
} else {
    echo '<div class="alert alert-danger">Código de barras no proporcionado.</div>';
}


$conexion->close();
?>
