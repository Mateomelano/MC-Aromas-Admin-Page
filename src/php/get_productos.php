<?php
include 'db.php'; // Conexión a la base de datos

$sql = "SELECT id, nombre, categoria, marca, precio, habilitado FROM productos";
$result = $conn->query($sql);

$productos = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $productos[] = $row;
    }
}

// Devolver los datos en formato JSON
echo json_encode($productos);
?>
