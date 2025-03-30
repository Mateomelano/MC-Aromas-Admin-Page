include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = isset($_POST['id']) ? $conn->real_escape_string($_POST['id']) : null;

    if (!$id) {
        echo json_encode(["success" => false, "error" => "ID no válido"]);
        exit;
    }

    $habilitado = isset($_POST['habilitado']) ? $conn->real_escape_string($_POST['habilitado']) : null;

    // Si solo se envía 'habilitado', actualizamos solo ese campo
    if ($habilitado !== null && empty($_POST['nombre']) && empty($_POST['descripcion']) && empty($_POST['categoria']) && empty($_POST['marca']) && empty($_POST['precio']) && empty($_POST['imagenUrlActual'])) {
        $sql = "UPDATE productos SET habilitado='$habilitado' WHERE id='$id'";
    } else {
        $nombre = $conn->real_escape_string($_POST['nombre']);
        $descripcion = $conn->real_escape_string($_POST['descripcion']);
        $categoria = $conn->real_escape_string($_POST['categoria']);
        $marca = $conn->real_escape_string($_POST['marca']);
        $precio = $conn->real_escape_string($_POST['precio']);
        $imagenUrl = isset($_POST['imagenUrlActual']) ? $conn->real_escape_string($_POST['imagenUrlActual']) : null;

        if (isset($_POST['imagenUrl'])) {
            $imagenUrl = $_POST['imagenUrl'];
        } elseif (isset($_POST['imagenUrlActual'])) {
            $imagenUrl = $_POST['imagenUrlActual'];
        }

        $sql = "UPDATE productos 
                SET nombre='$nombre', descripcion='$descripcion', categoria='$categoria', 
                    marca='$marca', precio='$precio', habilitado='$habilitado', imagen='$imagenUrl'
                WHERE id='$id'";
    }

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["success" => true, "message" => "Producto actualizado"]);
    } else {
        echo json_encode(["success" => false, "error" => $conn->error]);
    }
}

$conn->close();
