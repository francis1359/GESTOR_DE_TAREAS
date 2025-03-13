<?php
$host = "localhost";
$user = "root";  // Usuario de MySQL
$pass = "";      // Contraseña de MySQL
$db = "gestor_tareas";  // Nombre de la base de datos

$conn = new mysqli($host, $user, $pass, $db);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>
