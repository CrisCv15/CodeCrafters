<?php
include "../conexion_be.php";

// Verificamos si se recibió el parámetro CodigoBarras
if (isset($_GET["CodigoBarras"])) {
    $CodigoBarras = $_GET["CodigoBarras"];

    // Usamos una sentencia preparada para prevenir inyecciones SQL
    $stmt = $conexion->prepare("SELECT * FROM producto WHERE CodigoBarras = ?");
    $stmt->bind_param("s", $CodigoBarras);  // 's' para tipo string
    $stmt->execute();
    $result = $stmt->get_result();

    // Verificamos si el producto existe
    if ($result->num_rows === 0) {
        echo "<script>alert('Producto no encontrado.'); window.location.href='menu.php';</script>";
        exit;
    }
} else {
    echo "<script>alert('Código de barras no especificado.'); window.location.href='menu.php';</script>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <form class="col-4 p-3 m-auto" method="POST">
        <h3 class="text-center alert alert-secondary">Editar Producto</h3>
        <input type="hidden" name="CodigoBarras" value="<?= htmlspecialchars($CodigoBarras) ?>">
        <?php 
        while ($datos = $result->fetch_object()) { ?>
            <div class="mb-3">
                <label for="exampleInputCodigo" class="form-label">Código de Barras</label>
                <input type="text" class="form-control" name="CodigoB" value="<?= htmlspecialchars($datos->CodigoBarras) ?>">
            </div>
            <div class="mb-3">
                <label for="exampleInputPrecio" class="form-label">Precio</label>
                <input type="text" class="form-control" name="Precio" value="<?= htmlspecialchars($datos->Precio) ?>">
            </div>
            <div class="mb-3">
                <label for="exampleInputDescripcion" class="form-label">Descripción</label>
                <input type="text" class="form-control" name="Descripcion" value="<?= htmlspecialchars($datos->Descripcion) ?>">
            </div>
            <div class="mb-3">
                <label for="exampleInputOferta" class="form-label">Ofertas</label>
                <input type="text" class="form-control" name="Oferta" value="<?= htmlspecialchars($datos->Ofertas) ?>">
            </div>
            <div class="mb-3">
                <label for="exampleInputStock" class="form-label">Stock</label>
                <input type="text" class="form-control" name="Stock" value="<?= htmlspecialchars($datos->Stock) ?>">
            </div>  
        <?php } ?>
    
        <button type="submit" class="btn btn-primary" name="actualizar" value="ok">Editar Producto</button>
    </form>
</body>
</html>
