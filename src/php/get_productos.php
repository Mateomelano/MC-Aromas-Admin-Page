<?php
include 'db.php'; // Conexión a la base de datos


$q = isset($_GET['q']) ? $conn->real_escape_string($_GET['q']) : '';
$habilitadoFiltro = isset($_GET['habilitado']) && $_GET['habilitado'] !== '' ? (int) $_GET['habilitado'] : null;
$orden = isset($_GET['orden']) ? $_GET['orden'] : null;

$sql = "SELECT id, nombre, categoria, marca, precio, habilitado, descripcion, imagen FROM productos";
$filtros = [];

// 🟢 Aplicar filtro de búsqueda
if (!empty($q)) {
    $filtros[] = "(id LIKE '%$q%' OR 
                   nombre LIKE '%$q%' OR
                   descripcion LIKE '%$q%' OR 
                   categoria LIKE '%$q%' OR 
                   marca LIKE '%$q%' OR 
                   imagen LIKE '%$q%' OR 
                   precio LIKE '%$q%')";
}

// 🟢 Aplicar filtro de habilitado si es 1 o 0
if ($habilitadoFiltro === 1) {
    $filtros[] = "habilitado = 1";
} elseif ($habilitadoFiltro === 0) {
    $filtros[] = "habilitado = 0";
}

// Si hay filtros, agregarlos a la consulta
if (!empty($filtros)) {
    $sql .= " WHERE " . implode(" AND ", $filtros);
}

// 🟢 Aplicar ordenación de precio si se envió el parámetro correcto
if ($orden === "asc") {
    $sql .= " ORDER BY precio ASC";
} elseif ($orden === "desc") {
    $sql .= " ORDER BY precio DESC";
} elseif ($orden === "random") {
    $sql .= " ORDER BY RAND()";
}

$result = $conn->query($sql);
$productos = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $productos[] = $row;
    }
}

echo json_encode($productos);
?>
