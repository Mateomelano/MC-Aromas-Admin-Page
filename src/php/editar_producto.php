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
    else if (isset($_POST['nombre'], $_POST['descripcion'], $_POST['categoria'], $_POST['marca'], $_POST['precio'], $_POST['habilitado'])) {
        $nombre = $conn->real_escape_string($_POST['nombre']);
        $descripcion = $conn->real_escape_string($_POST['descripcion']);
        $categoria = $conn->real_escape_string($_POST['categoria']);
        $marca = $conn->real_escape_string($_POST['marca']);
        $precio = $conn->real_escape_string($_POST['precio']);
        $habilitado = isset($_POST['habilitado']) ? $conn->real_escape_string($_POST['habilitado']) : '0';

        // Manejo de la imagen (solo si se sube una nueva)
        if (!empty($_FILES['imagen']['name'])) {
            $imagen = $_FILES['imagen']['name'];
            $ruta_imagen = "uploads/" . basename($imagen);
            move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta_imagen);
            $sql = "UPDATE productos 
                    SET nombre='$nombre', descripcion='$descripcion', categoria='$categoria', 
                        marca='$marca', precio='$precio', habilitado='$habilitado', imagen='$ruta_imagen'
                    WHERE id='$id'";
        } else {
            // No se subió nueva imagen, mantener la actual
            $sql = "UPDATE productos 
                    SET nombre='$nombre', descripcion='$descripcion', categoria='$categoria', 
                        marca='$marca', precio='$precio', habilitado='$habilitado'
                    WHERE id='$id'";
        }
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
