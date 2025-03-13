<?php
session_start();
if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit;
}

// Conectar a la base de datos
include "db.php";

// Obtener el ID de la tarea
$tarea_id = $_GET['id'];

// Obtener la tarea desde la base de datos
$sql = "SELECT tarea.id, tarea.titulo, tarea.descripcion, tarea.estado, tarea.fecha_final, usuario.nombre AS usuario_asignado
        FROM tarea 
        INNER JOIN tarea_usuario ON tarea.id = tarea_usuario.tarea_id
        INNER JOIN usuario ON tarea_usuario.usuario_id = usuario.id
        WHERE tarea.id = $tarea_id";
$result = $conn->query($sql);
$tarea = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Tarea</title>
    <link rel="stylesheet" href="style.css"> <!-- Enlace a tu archivo CSS -->
</head>
<body>

    <h2>Información de la Tarea</h2>
    <div class="tarea-container">
        <form>
            <label for="titulo">Título:</label>
            <input type="text" id="titulo" name="titulo" value="<?php echo $tarea['titulo']; ?>" readonly>

            <label for="descripcion">Descripción:</label>
            <textarea id="descripcion" name="descripcion" readonly><?php echo $tarea['descripcion']; ?></textarea>

            <label for="estado">Estado:</label>
            <input type="text" id="estado" name="estado" value="<?php echo $tarea['estado']; ?>" readonly>

            <label for="usuario_asignado">Usuario Asignado:</label>
            <input type="text" id="usuario_asignado" name="usuario_asignado" value="<?php echo $tarea['usuario_asignado']; ?>" readonly>

            <label for="fecha_final">Fecha Final:</label>
            <input type="date" id="fecha_final" name="fecha_final" value="<?php echo $tarea['fecha_final']; ?>" readonly>

            <a href="dashboard.php" class="button-link">Volver al Dashboard</a>
        </form>
    </div>

</body>
</html>
