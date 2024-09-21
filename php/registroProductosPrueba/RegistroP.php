<?php
if (!empty($_POST["btnregistrar"])) {
    if (!empty($_POST["CodigoB"]) && !empty($_POST["Precio"]) && !empty($_POST["Descripcion"]) && !empty($_POST["Stock"])) {
        $CodigoB = $_POST["CodigoB"];
        $Precio = $_POST["Precio"];
        $Descripcion = $_POST["Descripcion"];
        $Stock = $_POST["Stock"];
        $Ofertas = !empty($_POST["Ofertas"]) ? $_POST["Ofertas"] : NULL; // Ofertas es opcional, puede ser NULL

        // Validaciones con expresiones regulares
        if (!preg_match("/^[0-9]{13}$/", $CodigoB) ||  // Exactamente 13 caracteres numéricos para el Código de Barras
            !preg_match("/^[0-9]+(\.[0-9]{1,2})?$/", $Precio) ||  // Precio decimal, máximo dos dígitos decimales
            !preg_match("/^[0-9]+$/", $Stock) ||  // Solo números enteros para el Stock
            !preg_match("/^[a-zA-Z\s]+$/", $Descripcion) ||  // Solo letras y espacios para la Descripción
            (!is_null($Ofertas) && !preg_match("/^[0-9]{1,2}%$/", $Ofertas))) {  // Ofertas puede ser NULL o un número seguido de "%"
            echo '<div class="alert alert-danger">Error: Datos Incorrectos</div>';
        } else {
            // Incluimos la conexión a la base de datos
            include "../conexion_be.php";

            // Usamos sentencias preparadas para prevenir inyección SQL
            $stmt = $conexion->prepare("INSERT INTO producto (CodigoBarras, Precio, Descripción, Ofertas, Stock) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sdssi", $CodigoB, $Precio, $Descripcion, $Ofertas, $Stock);  // sdssi: string, decimal, string, string, int

            if ($stmt->execute()) {
                echo '<div class="alert alert-success">Producto Registrado Correctamente</div>';
            } else {
                echo '<div class="alert alert-danger">Producto No Registrado Correctamente</div>';
            }

            // Cerramos la sentencia
            $stmt->close();
        }
    } else {
        echo '<div class="alert alert-warning">Alguno de los campos obligatorios está vacío</div>';
    }
}
?>
