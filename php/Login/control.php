<?php
// Verificar si ya hay una sesión activa antes de iniciar una nueva
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Solo iniciar la sesión si no está ya iniciada
}

// Conexión a la base de datos
require_once '../conexion_be.php';

// Inicializar variables para los errores
$usr_err = $cont_err = "";

// Verificar si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Validar usuario
    if (empty(trim($_POST["usr"]))) {
        $usr_err = "Por favor, ingrese el nombre de usuario.";
    } else {
        $usr = trim($_POST["usr"]);
    }

    // Validar contraseña
    if (empty(trim($_POST["cont"]))) {
        $cont_err = "Por favor, ingrese una contraseña.";
    } else {
        $cont = trim($_POST["cont"]);
    }

    // Verificar credenciales si no hay errores
    if (empty($usr_err) && empty($cont_err)) {
        // Consulta SQL para verificar las credenciales del usuario
        $query = "SELECT * FROM usuario WHERE Nombre = '$usr' AND Contraseña = '$cont'";
        $result = mysqli_query($conexion, $query);

        if (mysqli_num_rows($result) == 1) {
            $user = mysqli_fetch_assoc($result);
            $_SESSION['usr'] = $user['Nombre']; // Almacenar el nombre de usuario en la sesión
            header("Location: inicio.php");
            exit;
        } else {
            echo '
            <script>
            alert("Usuario o contraseña incorrectos.");
            window.location = "Login.php";
            </script>';
            exit;
        }
    }
}
?>
