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

// Si el formulario se envía, actualizar la tarea
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $estado = $_POST['estado'];
    $fecha_final = $_POST['fecha_final'];

    // Actualizar tarea en la base de datos
    $update_sql = "UPDATE tarea SET titulo='$titulo', descripcion='$descripcion', estado='$estado', fecha_final='$fecha_final' WHERE id=$tarea_id";
    if ($conn->query($update_sql) === TRUE) {
        echo "Tarea actualizada correctamente.";
    } else {
        echo "Error al actualizar la tarea: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Tarea</title>
    <link rel="stylesheet" href="style.css"> <!-- Enlace a tu archivo CSS -->
</head>
<body>

    <h2>Editar Tarea</h2>
    <div class="tarea-container">
        <form method="POST">
            <label for="titulo">Título:</label>
            <input type="text" id="titulo" name="titulo" value="<?php echo $tarea['titulo']; ?>" required>

            <label for="descripcion">Descripción:</label>
            <textarea id="descripcion" name="descripcion" required><?php echo $tarea['descripcion']; ?></textarea>

            <label for="estado">Estado:</label>
            <select id="estado" name="estado" required>
                <option value="Pendiente" <?php echo ($tarea['estado'] == 'Pendiente') ? 'selected' : ''; ?>>Pendiente</option>
                <option value="En Proceso" <?php echo ($tarea['estado'] == 'En Proceso') ? 'selected' : ''; ?>>En Proceso</option>
                <option value="Completada" <?php echo ($tarea['estado'] == 'Completada') ? 'selected' : ''; ?>>Completada</option>
            </select>

            <label for="fecha_final">Fecha Final:</label>
            <input type="date" id="fecha_final" name="fecha_final" value="<?php echo $tarea['fecha_final']; ?>" required>

            <button type="submit">Actualizar Tarea</button>
        </form>
        <a href="dashboard.php" class="button-link">Volver al Dashboard</a>
    </div>

</body>
</html>
