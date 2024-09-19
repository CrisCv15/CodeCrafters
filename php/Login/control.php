<?php

    //Inicializar la sesion
    session_start();

    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
        header("location: ../../index.php");
        exit;
    }

    require_once "../conexion_be.php";

    $usr_err = $cont_err ="";

    if($_SERVER["REQUEST_METHOD"] === "POST"){
        $usr = $_POST['usr'];
        $cont = $_POST['cont'];

        //Espacio sin datos        
        if(empty(trim($_POST["usr"]))){
            $usr_err = "Por favor, ingrese el nombre de usuario";
        }else{
            $usr = trim($_POST["usr"]);//almacena datos
        }

        if(empty(trim($_POST["cont"]))){
            $cont_err = "Por favor, ingrese una contraseña";
        }else{
            $cont = trim($_POST["cont"]);//almacena datos
        }
        //Fin espacio sin datos

        //Verificacion de credenciales de usuario
        $query = "SELECT * FROM usuario WHERE Nombre = '$usr' AND Contraseña = '$cont'";
        $result = mysqli_query($conexion, $query);
        
        if(mysqli_num_rows($result) == 1){
            $user = mysqli_fetch_assoc($result);

            // Iniciar la sesion
            
            $_SESSION['usr'] = $user['usr'];

            header("Location: inicio.html");
        }else{
            echo '
        <script>
        alert("El usuario no existe, verifique los datos introducidos");
        window.location = "Login.php";
        </script>
         ';
         exit();
        }


    }

?>
