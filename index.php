<?php
session_start();
if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit;
}

// Conexión a la base de datos
include "db.php";

// Aquí puedes mostrar las tareas del usuario, dependiendo del rol.
$sql = "SELECT * FROM tarea";
$result = $conn->query($sql);

echo "<h2>Listado de Tareas</h2>";
echo "<table>";
echo "<tr><th>Título</th><th>Descripción</th><th>Estado</th></tr>";

while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $row["titulo"] . "</td>";
    echo "<td>" . $row["descripcion"] . "</td>";
    echo "<td>" . $row["estado"] . "</td>";
    echo "</tr>";
}
echo "</table>";
?>
