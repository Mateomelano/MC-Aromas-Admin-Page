<?php

$host = "localhost"; 
$user = "root"; // Usuario de MySQL (por defecto en XAMPP)
$password = "mateo"; // Deja vacío si no configuraste una contraseña
$dbname = "mc_aromas"; 

$conn = new mysqli($host, $user, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>