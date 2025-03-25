<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = isset($_POST['id']) ? $conn->real_escape_string($_POST['id']) : null;

    if (!$id) {
        echo json_encode(["success" => false, "error" => "ID no válido"]);
        exit;
    }

    // Si solo se está actualizando el estado "habilitado"
    if (isset($_POST['habilitado']) && !isset($_POST['nombre'])) {
        $habilitado = isset($_POST['habilitado']) ? $conn->real_escape_string($_POST['habilitado']) : '0';
        $sql = "UPDATE productos SET habilitado='$habilitado' WHERE id='$id'";
    } 
    // Si se están editando todos los campos
    else if (isset($_POST['nombre'], $_POST['categoria'], $_POST['marca'], $_POST['precio'], $_POST['habilitado'])) {
        $nombre = $conn->real_escape_string($_POST['nombre']);
        $categoria = $conn->real_escape_string($_POST['categoria']);
        $marca = $conn->real_escape_string($_POST['marca']);
        $precio = $conn->real_escape_string($_POST['precio']);
        $habilitado = isset($_POST['habilitado']) ? $conn->real_escape_string($_POST['habilitado']) : '0';

        $sql = "UPDATE productos 
                SET nombre='$nombre', categoria='$categoria', marca='$marca', precio='$precio', habilitado='$habilitado' 
                WHERE id='$id'";
    } else {
        echo json_encode(["success" => false, "error" => "Datos insuficientes"]);
        exit;
    }

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["success" => true, "message" => "Producto actualizado"]);
    } else {
        echo json_encode(["success" => false, "error" => $conn->error]);
    }
}

$conn->close();
?>
