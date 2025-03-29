<?php
include 'db.php'; // Ajusta la ruta si es necesario

// 🔑 Claves de Cloudinary (Reemplaza con las tuyas)
$cloud_name = "dzfzqzdcu";
$api_key = "449917526627355";
$api_secret = "gCcKASs-9OD-9MpZX5ZwE885W_Q";

if (isset($_POST['id'])) {
    $id = intval($_POST['id']); // Asegurar que sea un número entero

    // 1. Obtener la URL de la imagen del producto desde la base de datos
    $sql = "SELECT imagen FROM productos WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($imagenUrl);
    $stmt->fetch();
    $stmt->close();

    if ($imagenUrl) {
        // 2. Extraer el ID público de la imagen de Cloudinary
        // Ejemplo: "https://res.cloudinary.com/dzfzqzdcu/image/upload/v1743257645/uha9czmmyuttilgeafbh.jpg"
        preg_match("/\/([^\/]+)\.(jpg|png|jpeg|gif)$/", $imagenUrl, $matches);
        $public_id = $matches[1] ?? null;

        if ($public_id) {
            // 3. Eliminar la imagen de Cloudinary usando cURL
            $timestamp = time();
            $signature = sha1("public_id={$public_id}&timestamp={$timestamp}{$api_secret}");

            $data = [
                "public_id" => $public_id,
                "api_key" => $api_key,
                "timestamp" => $timestamp,
                "signature" => $signature
            ];

            $ch = curl_init("https://api.cloudinary.com/v1_1/{$cloud_name}/image/destroy");
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);

            $result = json_decode($response, true);
            
            if (isset($result["result"]) && $result["result"] === "ok") {
                // Imagen eliminada correctamente de Cloudinary
            } else {
                echo "Error al eliminar la imagen de Cloudinary.";
                exit;
            }
        }
    }

    // 4. Eliminar el producto de la base de datos
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
