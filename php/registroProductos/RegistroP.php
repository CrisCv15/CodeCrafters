<?php
include "../conexion_be.php"; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $codigoB = $_POST['CodigoB'];
    $precio = $_POST['Precio'];
    $descripcion = $_POST['Descripcion'];
    $stock = $_POST['Stock'];

    
    if (empty($codigoB) || empty($precio) || empty($descripcion) || empty($stock)) {
        echo '<div class="alert alert-danger" role="alert">Error: Todos los campos son obligatorios.</div>';
        exit();
    }

    
    $sql = "INSERT INTO producto (CodigoBarras, Precio, Descripcion, Stock) VALUES (?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);

    if ($stmt) {
       
        $stmt->bind_param("sdsi", $codigoB, $precio, $descripcion, $stock);

        
        if ($stmt->execute()) {
            echo '<div class="alert alert-success" role="alert">Producto registrado correctamente.</div>';
        } else {
            echo '<div class="alert alert-danger" role="alert">Error al registrar el producto: ' . $stmt->error . '</div>';
        }
        $stmt->close();
    } else {
        echo '<div class="alert alert-danger" role="alert">Error en la consulta: ' . $conexion->error . '</div>';
    }
} else {
    echo '<div class="alert alert-danger" role="alert">Método no permitido.</div>';
}
?>

