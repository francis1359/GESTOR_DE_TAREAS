<?php
session_start();
if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css"> <!-- Agrega el link a tu archivo CSS -->
    <!-- Font Awesome (para los iconos de editar y visualizar) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>

    <div class="dashboard-container">
        <h2>Bienvenido, <?php echo $_SESSION["cargo"]; ?></h2>

        <!-- Mostrar los botones de acuerdo al cargo -->
        <?php
        if ($_SESSION["cargo"] == "Encargado") {
            echo "<a class='button-link' href='asignar_tarea.php'>Asignar Tareas</a>";
        }
        ?>

        <a class='button-link' href='index.php'>Ver Tareas</a>
        <a class='button-link' href='logout.php'>Cerrar Sesión</a>

        <!-- Mostrar las tareas asignadas por el encargado -->
        <?php
        if ($_SESSION["cargo"] == "Encargado") {
            include "db.php";  // Conectar a la base de datos

            // Obtener las tareas asignadas por el encargado
            $encargado_id = $_SESSION["usuario_id"];
            $sql = "SELECT tarea.id, tarea.titulo, tarea.descripcion, tarea.estado, tarea.fecha_final, usuario.nombre AS usuario_asignado
                    FROM tarea 
                    INNER JOIN tarea_usuario ON tarea.id = tarea_usuario.tarea_id
                    INNER JOIN usuario ON tarea_usuario.usuario_id = usuario.id
                    WHERE tarea_usuario.usuario_id = $encargado_id";
            $result = $conn->query($sql);

            // Mostrar la tabla si hay tareas asignadas
            if ($result->num_rows > 0) {
                echo "<h3>Tareas Asignadas</h3>";
                echo "<table>";
                echo "<tr><th>Título</th><th>Descripción</th><th>Estado</th><th>Usuario Asignado</th><th>Fecha Final</th><th>Acciones</th></tr>";

                while ($row = $result->fetch_assoc()) {
                    $tarea_id = $row["id"];
                    echo "<tr>";
                    echo "<td>" . $row["titulo"] . "</td>";
                    echo "<td>" . $row["descripcion"] . "</td>";
                    echo "<td>" . $row["estado"] . "</td>";
                    echo "<td>" . $row["usuario_asignado"] . "</td>";
                    echo "<td>" . $row["fecha_final"] . "</td>";
                    echo "<td>
                            <a href='ver_tarea.php?id=$tarea_id' title='Ver Tarea'><i class='fas fa-eye'></i></a>
                            <a href='editar_tarea.php?id=$tarea_id' title='Editar Tarea'><i class='fas fa-edit'></i></a>
                          </td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "<p>No hay tareas asignadas.</p>";
            }
        }
        ?>

    </div>

</body>
</html>
