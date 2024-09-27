<?php
$host = "localhost"; 
$user = "root"; 
$password = "admin";
$dbname = "los4HermanosBD";

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Procesar el formulario de ventas
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $productos = $_POST['productos'];
    $formaPago = $_POST['formaPago']; 
    $totalVenta = $_POST['totalVenta'];
    
   
    $fechaHora = date('Y-m-d H:i:s');

    // Insertar la nueva venta en la tabla Ventas
    $queryVenta = "INSERT INTO Ventas (FechayHora, formaPago) VALUES ('$fechaHora', '$formaPago')";
    
    if ($conn->query($queryVenta) === TRUE) {
        $numTicket = $conn->insert_id; //número de ticket de la venta recién creada
        
        // Insertar los productos en la tabla ventasProductos
        foreach ($productos as $producto) {
            $codBarras = $producto['codBarras'];
            $cantidad = $producto['cantidad'];
            $precio = $producto['precio'];
            $total = $cantidad * $precio;
            
            $queryProducto = "INSERT INTO ventasProductos (numTicket, codBarras) 
                              VALUES ('$numTicket', '$codBarras')";
            $conn->query($queryProducto);
            
            // Actualizar el stock del producto en la tabla Producto
            $queryStock = "UPDATE Producto SET stock = stock - '$cantidad' WHERE codBarras = '$codBarras'";
            $conn->query($queryStock);
        }
        
        echo "Venta realizada con éxito.";
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>

