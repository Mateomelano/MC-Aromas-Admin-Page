<?php
include 'db.php'; // Conexión a la base de datos

$q = isset($_GET['q']) ? $conn->real_escape_string($_GET['q']) : '';
$habilitadoFiltro = isset($_GET['habilitado']) && $_GET['habilitado'] !== '' ? (int) $_GET['habilitado'] : null;

$sql = "SELECT id, nombre, categoria, marca, precio, habilitado, descripcion, imagen FROM productos";
$filtros = [];

if (!empty($q)) {
    $filtros[] = "(id LIKE '%$q%' OR 
                   nombre LIKE '%$q%' OR
                   descripcion LIKE '%$q%' OR 
                   categoria LIKE '%$q%' OR 
                   marca LIKE '%$q%' OR 
                   imagen LIKE '%$q%' OR 
                   precio LIKE '%$q%')";
}

// 🟢 Si el filtro es 1 o 0, aplicarlo. Si es null, no filtrar.
if ($habilitadoFiltro === 1) {
    $filtros[] = "habilitado = 1";
} elseif ($habilitadoFiltro === 0) {
    $filtros[] = "habilitado = 0";
}

if (!empty($filtros)) {
    $sql .= " WHERE " . implode(" AND ", $filtros);
}

$result = $conn->query($sql);
$productos = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $productos[] = $row;
    }
}

echo json_encode($productos);
?>
