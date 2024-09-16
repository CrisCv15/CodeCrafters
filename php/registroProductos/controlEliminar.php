<?php 

if (!empty($_GET["CodigoBarras"])) {
    $CodigoBarras = $_GET   ["CodigoBarras"];

    $eliminar = $conexion ->query("DELETE from producto where CodigoBarras ='$CodigoBarras'");
    if ($eliminar==true) {
        echo"<div class='alert alert-success'>Se elimino de manera correcta</div>";
    } else {
        echo"<div class='alert alert-'>Se elimino de manera correcta</div>";
    }
    
}

?>