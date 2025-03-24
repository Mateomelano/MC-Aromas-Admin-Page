<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $categoria = $_POST['categoria'];
    $marca = $_POST['marca'];
    $precio = $_POST['precio'];
    $habilitado = $_POST['habilitado'];

    $sql = "UPDATE productos 
            SET nombre='$nombre', categoria='$categoria', marca='$marca', precio='$precio', habilitado='$habilitado' 
            WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        echo "Producto actualizado";
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>
