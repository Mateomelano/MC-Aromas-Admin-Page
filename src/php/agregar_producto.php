<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $categoria = $_POST['categoria'];
    $marca = $_POST['marca'];
    $precio = $_POST['precio'];
    $habilitado = $_POST['habilitado'];

    // URL de la imagen subida a Cloudinary
    $rutaImagen = isset($_POST['imagenUrl']) ? $_POST['imagenUrl'] : null;

    $sql = "INSERT INTO productos (nombre, descripcion, categoria, marca, precio, habilitado, imagen) 
            VALUES ('$nombre', '$descripcion', '$categoria', '$marca', '$precio', '$habilitado', '$rutaImagen')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["status" => "success", "message" => "Producto agregado"]);
    } else {
        echo json_encode(["status" => "error", "message" => $conn->error]);
    }
}
?>
