<?php
include 'db.php';

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = isset($_POST['id']) ? intval($_POST['id']) : null;

    if (!$id) {
        echo json_encode(["success" => false, "error" => "ID no válido"]);
        exit;
    }

    $habilitado = isset($_POST['habilitado']) ? intval($_POST['habilitado']) : null;

    // 🔒 Preparar consulta según los datos enviados
    if ($habilitado !== null && empty($_POST['nombre']) && empty($_POST['descripcion']) && empty($_POST['categoria']) && empty($_POST['marca']) && empty($_POST['precio']) && empty($_POST['imagenUrlActual'])) {
        
        // ✅ Solo actualizar el campo 'habilitado'
        $stmt = $conn->prepare("UPDATE productos SET habilitado = ? WHERE id = ?");
        $stmt->bind_param("ii", $habilitado, $id);
        
    } else {
        
        // 📦 Actualizar todos los campos si se envían
        $nombre = isset($_POST['nombre']) ? $conn->real_escape_string($_POST['nombre']) : null;
        $descripcion = isset($_POST['descripcion']) ? $conn->real_escape_string($_POST['descripcion']) : null;
        $categoria = isset($_POST['categoria']) ? $conn->real_escape_string($_POST['categoria']) : null;
        $marca = isset($_POST['marca']) ? $conn->real_escape_string($_POST['marca']) : null;
        $precio = isset($_POST['precio']) ? floatval($_POST['precio']) : null;
        $imagenUrl = isset($_POST['imagenUrl']) ? $conn->real_escape_string($_POST['imagenUrl']) : null;

        // Si se proporciona la imagen actual pero no una nueva, mantener la actual
        if (!$imagenUrl && isset($_POST['imagenUrlActual'])) {
            $imagenUrl = $conn->real_escape_string($_POST['imagenUrlActual']);
        }

        // Consulta para actualizar todos los campos
        $stmt = $conn->prepare("UPDATE productos 
            SET nombre = ?, descripcion = ?, categoria = ?, marca = ?, precio = ?, habilitado = ?, imagen = ?
            WHERE id = ?");

        $stmt->bind_param("ssssdisi", $nombre, $descripcion, $categoria, $marca, $precio, $habilitado, $imagenUrl, $id);
    }

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Producto actualizado correctamente."]);
    } else {
        echo json_encode(["success" => false, "error" => $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(["success" => false, "error" => "Método no permitido"]);
}

$conn->close();
