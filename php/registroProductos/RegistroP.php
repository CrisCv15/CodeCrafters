<?php
if(!empty($_POST["btnregistrar"])){
    if(!empty($_POST["CodigoB"]) and !empty($_POST["Precio"]) and !empty($_POST["Descripcion"]) and !empty($_POST["Stock"]) ){
        $CodigoB=$_POST["CodigoB"];
        $Precio=$_POST["Precio"];
        $Descripcion=$_POST["Descripcion"];
        $Stock=$_POST["Stock"];
        if(!preg_match("/^[0-9]{1,13}+$/",$CodigoB) || 
           !preg_match("/^[0-9]+$/",$Precio) || 
           !preg_match("/^[0-9]+$/",$Stock)  || 
           !preg_match("/^[a-zA-Z\s]+$/",$Descripcion)){
            header("Location: index.php?warning=1");
            exit();
        }else{
            $sql = $conexion->query("INSERT INTO producto (CodigoBarras, Precio, Descripcion, Stock) VALUES ('$CodigoB', $Precio, '$Descripcion', '$Stock')");
            
            if ($sql) {
                header("Location: index.php?success=1");
                exit();
            } else {
                header("Location: index.php?error=1");
                exit();
            }
            }
        }else {
            header("Location: index.php?warning=1");
            exit();
        }
    }
?>