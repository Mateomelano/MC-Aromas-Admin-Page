<?php
include 'db.php'; // Conexión a la base de datos

$q = isset($_GET['q']) ? $conn->real_escape_string($_GET['q']) : '';

$sql = "SELECT id, nombre, categoria, marca, precio, habilitado FROM productos";
if (!empty($q)) {
    $sql .= " WHERE 
        id LIKE '%$q%' OR 
        nombre LIKE '%$q%' OR 
        categoria LIKE '%$q%' OR 
        marca LIKE '%$q%' OR 
        precio LIKE '%$q%'";
}

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
