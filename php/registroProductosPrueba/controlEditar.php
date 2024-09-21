<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Capturar los datos enviados por el formulario
    $CodigoBarrasActual = $_POST["CodigoBarras"];  // El código original para la comparación
    $CodigoB = $_POST["CodigoB"];  // El nuevo código de barras a actualizar
    $Precio = $_POST["Precio"];
    $Descripcion = $_POST["Descripcion"];
    $Ofertas = !empty($_POST["Oferta"]) ? $_POST["Oferta"] : NULL;  // Ofertas puede ser NULL
    $Stock = $_POST["Stock"];

    // Validaciones
    if (!preg_match("/^[0-9]{13}$/", $CodigoB) ||  // El Código de Barras debe tener exactamente 13 caracteres numéricos
        !preg_match("/^[0-9]+(\.[0-9]{1,2})?$/", $Precio) ||  // Precio en formato decimal con hasta dos dígitos decimales
        !preg_match("/^[0-9]+$/", $Stock) ||  // Solo números enteros para el Stock
        !preg_match("/^[a-zA-Z\s]+$/", $Descripcion) ||  // Solo letras y espacios para la Descripción
        (!is_null($Ofertas) && !preg_match("/^[0-9]{1,2}%$/", $Ofertas))) {  // Ofertas puede ser NULL o seguir el formato de porcentaje
        echo '<div class="alert alert-danger">Error: Datos Incorrectos</div>';
    } else {
        // Incluimos la conexión a la base de datos
        include "../conexion_be.php";

        // Eliminamos el símbolo de porcentaje para la base de datos
        if (!is_null($Ofertas)) {
            $Ofertas = rtrim($Ofertas, '%');
        }

        // Usamos sentencias preparadas para la actualización
        $stmt = $conexion->prepare("UPDATE producto SET CodigoBarras = ?, Precio = ?, Descripción = ?, Ofertas = ?, Stock = ? WHERE CodigoBarras = ?");
        $stmt->bind_param("sdssis", $CodigoB, $Precio, $Descripcion, $Ofertas, $Stock, $CodigoBarrasActual);  // sdssis: string, decimal, string, string, int, string

        if ($stmt->execute()) {
            header("Location: index.php");
        } else {
            echo "<div class='alert alert-danger'>Error al modificar</div>";
        }

        // Cerramos la sentencia
        $stmt->close();
    }
}
?>
