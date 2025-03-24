<?php
include 'db.php'; // Ajusta la ruta si es necesario

if (isset($_POST['id'])) {
    $id = intval($_POST['id']); // Asegurar que sea un número entero

    $sql = "DELETE FROM productos WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "Producto eliminado correctamente";
    } else {
        echo "Error al eliminar el producto";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "ID no recibido";
}
?>