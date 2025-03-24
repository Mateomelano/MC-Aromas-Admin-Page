<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $categoria = $_POST['categoria'];
    $marca = $_POST['marca'];
    $precio = $_POST['precio'];
    $habilitado = $_POST['habilitado'];

    $sql = "INSERT INTO productos (nombre, categoria, marca, precio, habilitado) 
            VALUES ('$nombre', '$categoria', '$marca', '$precio', '$habilitado')";

    if ($conn->query($sql) === TRUE) {
        echo "Producto agregado";
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>
