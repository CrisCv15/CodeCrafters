<?php 
include "../conexion_be.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $CodigoBarras = $_POST["CodigoB"];
    $campos = [];

    // Verificar y validar los campos enviados
    if (!empty($_POST["Precio"]) && preg_match("/^[0-9]+$/", $_POST["Precio"])) {
        $campos[] = "Precio='{$_POST["Precio"]}'";
    }
    if (!empty($_POST["Descripcion"]) && preg_match("/^[a-zA-Z\s]+$/", $_POST["Descripcion"])) {
        $campos[] = "Descripcion='{$_POST["Descripcion"]}'";
    }
    if (!empty($_POST["Stock"]) && preg_match("/^[0-9]+$/", $_POST["Stock"])) {
        $campos[] = "Stock='{$_POST["Stock"]}'";
    }
    // Verificar si hay campos válidos para actualizar
    if (count($campos) > 0) {
        $sql = $conexion->query("UPDATE producto SET " . implode(", ", $campos) . " WHERE CodigoBarras='$CodigoBarras'");

        if ($sql) {
            echo "<div class='alert alert-success'>Producto modificado exitosamente.</div>";
        } else {
            echo "<div class='alert alert-danger'>Error al modificar</div>";
        }
    } else {
        echo '<div class="alert alert-danger">Error: Datos Incorrectos</div>';
    }
}

$conexion->close();
?>
