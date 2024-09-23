<?php
include "../conexion_be.php";
$CodigoBarras = $_GET["CodigoBarras"];

$sql = $conexion->query("select * from producto where CodigoBarras=$CodigoBarras");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EditarProducto</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/styleRP.css">
</head>
<body>
<form class="col-4 p-3 m-auto" method="POST">
        <h3 class="text-center alert alert-secondary" >Editar Producto</h3>
        <input type="hidden" name="CodigoBarras" value="<?= $_GET["CodigoBarras"]?>" >
        <?php 
        include "./controlEditar.php";
        while($datos=$sql->fetch_object()){?>
          <div class="mb-3">
        <label for="exampleInputCodigo" class="form-label">Codigo de Barras</label>
        <input type="text" class="form-control" name="CodigoB" value="<?= $datos->CodigoBarras ?>">
    </div>
    <div class="mb-3">
        <label for="exampleInputCodigo" class="form-label">Precio</label>
        <input type="text" class="form-control" name="Precio" value="<?= $datos->Precio ?>">
    </div>
    <div class="mb-3">
        <label for="exampleInputCodigo" class="form-label">Descripcion</label>
        <input type="text" class="form-control" name="Descripcion" value="<?= $datos->Descripcion ?>">
    </div>
    <div class="mb-3">
        <label for="exampleInputCodigo" class="form-label">Stock</label>
        <input type="text" class="form-control" name="Stock" value="<?= $datos->Stock ?>">
    </div>  
        <?php }
        ?>
    
    <button type="submit" class="btn btn-primary" name="actualizar" value="ok" >Editar Producto</button>
    <button type="submit" class="btn btn-primary" name="btnvolverE">Volver</button>
    <?php
        include "../conexion_be.php";
        if(isset($_POST['btnvolverE'])){
          header("Location: ./menu.php");
          exit();
        }
       
        ?>
    </form>
</body>
</html>