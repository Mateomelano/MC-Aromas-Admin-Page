<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $categoria = $_POST['categoria'];
    $marca = $_POST['marca'];
    $precio = $_POST['precio'];
    $habilitado = $_POST['habilitado'];

    // 📂 Manejo de la imagen
    $rutaImagen = null;
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
        $directorio = 'uploads/';
        if (!is_dir($directorio)) {
            mkdir($directorio, 0777, true);
        }
        $rutaImagen = $directorio . basename($_FILES['imagen']['name']);
        move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaImagen);
    }

    $sql = "INSERT INTO productos (nombre, descripcion, categoria, marca, precio, habilitado, imagen) 
            VALUES ('$nombre', '$descripcion', '$categoria', '$marca', '$precio', '$habilitado', '$rutaImagen')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["status" => "success", "message" => "Producto agregado"]);
    } else {
        echo json_encode(["status" => "error", "message" => $conn->error]);
    }
}
?>
