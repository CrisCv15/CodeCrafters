<?php
if(!empty($_POST["btnregistrar"])){
    if(!empty($_POST["CodigoB"]) and !empty($_POST["Precio"]) and !empty($_POST["Descripcion"]) and !empty($_POST["Ofertas"]) and !empty($_POST["Stock"]) ){
        $CodigoB=$_POST["CodigoB"];
        $Precio=$_POST["Precio"];
        $Descripcion=$_POST["Descripcion"];
        $Ofertas=$_POST["Ofertas"];
        $Stock=$_POST["Stock"];
        if(!preg_match("/^[0-9]{1,13}+$/",$CodigoB) || 
           !preg_match("/^[0-9]+%$/",$Ofertas)||
           !preg_match("/^[0-9]+%$/",$Precio) || 
           !preg_match("/^[0-9]+%$/",$Stock)  || 
           !preg_match("/^[a-zA-Z\s]+$/",$Descripcion)){
            echo'<div class="alert alert-danger">Error: Datos Incorrectos</div>';
        }else{
          $sql=$conexion ->query(" insert into producto(CodigoBarras,Precio,Descripcion,Ofertas,Stock) values ('$CodigoB',$Precio,'$Descripcion','$Ofertas','$Stock')");
        if ($sql==1) {
            echo'<div class="alert alert-success">Producto Registrado Correctamente</div>';
        } else {
            echo'<div class="alert alert-danger">Producto No Registrado Correctamente</div>';
                }
            }
        }else{
        echo'<div class="alert alert-warning">Alguno de los campos esta vacio</div>';
    }
}
?>