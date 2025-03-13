<?php
session_start();
if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit;
}

// Conectar a la base de datos
include "db.php";

// Obtener la lista de usuarios registrados
$sql_usuarios = "SELECT id, nombre FROM usuario";
$result_usuarios = $conn->query($sql_usuarios);

// Comprobar si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $fecha_final = $_POST['fecha_final'];
    $usuarios_asignados = $_POST['usuarios_asignados'];  // Array de usuarios asignados

    // Insertar la tarea en la base de datos
    $insert_sql = "INSERT INTO tarea (titulo, descripcion, fecha_final) VALUES ('$titulo', '$descripcion', '$fecha_final')";
    if ($conn->query($insert_sql) === TRUE) {
        $tarea_id = $conn->insert_id;  // Obtener el ID de la tarea insertada

        // Asignar la tarea a los usuarios seleccionados
        foreach ($usuarios_asignados as $usuario_id) {
            $assign_sql = "INSERT INTO tarea_usuario (tarea_id, usuario_id) VALUES ($tarea_id, $usuario_id)";
            if ($conn->query($assign_sql) !== TRUE) {
                echo "Error al asignar la tarea al usuario con ID $usuario_id: " . $conn->error;
            }
        }
        echo "Tarea asignada correctamente.";
    } else {
        echo "Error al crear la tarea: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asignar Tarea</title>
    <link rel="stylesheet" href="style.css"> <!-- Enlace a tu archivo CSS -->
    
    <!-- Incluye el CSS de Select2 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
</head>
<body>

    <h2>Asignar Tarea</h2>
    <div class="tarea-container">
        <form method="POST">
            <label for="titulo">Título:</label>
            <input type="text" id="titulo" name="titulo" required>

            <label for="descripcion">Descripción:</label>
            <textarea id="descripcion" name="descripcion" required></textarea>

            <label for="usuarios_asignados">Asignar a Usuarios:</label>
            <!-- Usamos un input en lugar de select -->
            <select id="usuarios_asignados" name="usuarios_asignados[]" multiple="multiple" style="width: 100%" required>
                <?php
                // Mostrar los usuarios registrados en el dropdown
                while ($usuario = $result_usuarios->fetch_assoc()) {
                    echo "<option value='" . $usuario['id'] . "'>" . $usuario['nombre'] . "</option>";
                }
                ?>
            </select>

            <label for="fecha_final">Fecha Final:</label>
            <input type="date" id="fecha_final" name="fecha_final" required>

            <button type="submit">Asignar Tarea</button>
        </form>
        <a href="dashboard.php" class="button-link">Volver al Dashboard</a>
    </div>

    <!-- Incluye el JS de Select2 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        // Inicializa Select2 en el select de usuarios
        $(document).ready(function() {
            $('#usuarios_asignados').select2({
                placeholder: "Selecciona uno o más usuarios",
                allowClear: true,
                width: '100%' // Hace que el input ocupe todo el ancho
            });
        });
    </script>

</body>
</html>
