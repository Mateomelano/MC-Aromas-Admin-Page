include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = isset($_POST['id']) ? $conn->real_escape_string($_POST['id']) : null;
    $habilitado = isset($_POST['habilitado']) ? $conn->real_escape_string($_POST['habilitado']) : null;

    if (!$id || $habilitado === null) {
        echo json_encode(["success" => false, "error" => "ID o estado no válidos"]);
        exit;
    }

    // Actualizar solo el campo 'habilitado' sin modificar otros datos
    $sql = "UPDATE productos SET habilitado='$habilitado' WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["success" => true, "message" => "Estado actualizado correctamente"]);
    } else {
        echo json_encode(["success" => false, "error" => $conn->error]);
    }
}

$conn->close();