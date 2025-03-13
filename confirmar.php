<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Confirmar Tarea</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <form method="POST">
        <textarea name="descripcion" placeholder="Descripción de la tarea"></textarea>
        <input type="hidden" name="tarea_id" value="<?php echo $_GET['tarea_id']; ?>">
        <button type="submit">Confirmar Tarea</button>
    </form>

</body>
</html>
