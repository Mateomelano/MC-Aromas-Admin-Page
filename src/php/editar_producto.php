<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = isset($_POST['id']) ? $conn->real_escape_string($_POST['id']) : null;

    if (!$id) {
        echo json_encode(["success" => false, "error" => "ID no válido"]);
        exit;
    }

    $nombre = $conn->real_escape_string($_POST['nombre']);
    $descripcion = $conn->real_escape_string($_POST['descripcion']);
    $categoria = $conn->real_escape_string($_POST['categoria']);
    $marca = $conn->real_escape_string($_POST['marca']);
    $precio = $conn->real_escape_string($_POST['precio']);
    $habilitado = isset($_POST['habilitado']) ? $conn->real_escape_string($_POST['habilitado']) : '0';
    $imagenUrl = isset($_POST['imagenUrlActual']) ? $conn->real_escape_string($_POST['imagenUrlActual']) : null;

    // Si se subió una nueva imagen, se actualiza la URL, sino se mantiene la anterior
    if (isset($_POST['imagenUrl'])) {
        $imagenUrl = $_POST['imagenUrl'];
    } elseif (isset($_POST['imagenUrlActual'])) {
        $imagenUrl = $_POST['imagenUrlActual'];
    } else {
        $imagenUrl = null; // O dejar la URL anterior intacta
    }

    $sql = "UPDATE productos 
            SET nombre='$nombre', descripcion='$descripcion', categoria='$categoria', 
                marca='$marca', precio='$precio', habilitado='$habilitado', imagen='$imagenUrl'
            WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["success" => true, "message" => "Producto actualizado"]);
    } else {
        echo json_encode(["success" => false, "error" => $conn->error]);
    }
}

$conn->close();
