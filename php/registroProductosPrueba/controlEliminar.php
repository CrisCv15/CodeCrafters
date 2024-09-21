<?php 
// Verificamos si se recibió el parámetro CodigoBarras
if (!empty($_GET["CodigoBarras"])) {
    // Capturamos el valor del Código de Barras
    $CodigoBarras = $_GET["CodigoBarras"];

    // Incluimos la conexión a la base de datos
    include "../conexion_be.php";

    // Usamos sentencias preparadas para eliminar el producto
    $stmt = $conexion->prepare("DELETE FROM producto WHERE CodigoBarras = ?");
    $stmt->bind_param("s", $CodigoBarras);  // 's' para tipo string

    // Ejecutamos la consulta y verificamos si se eliminó correctamente
    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>Producto eliminado correctamente</div>";
    } else {
        echo "<div class='alert alert-danger'>Error al eliminar el producto</div>";
    }

    // Cerramos la sentencia
    $stmt->close();
}
?>
