<?php
include "db.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST["usuario"];
    $contraseña = $_POST["contraseña"];

    // Verificar si el usuario existe en la base de datos
    $sql = "SELECT * FROM usuario WHERE usuario = '$usuario'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        // Comparar la contraseña ingresada con la almacenada en la base de datos
        if ($contraseña == $user["contraseña"]) {
            $_SESSION["usuario_id"] = $user["id"];
            $_SESSION["cargo"] = $user["cargo"];
            header("Location: dashboard.php");
        } else {
            echo "<p class='error'>Contraseña incorrecta</p>";
        }
    } else {
        echo "<p class='error'>Usuario no encontrado</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body id="login">

<div class="login-container">
    <h2>Iniciar sesión</h2>
    <form method="POST">
        <input type="text" name="usuario" placeholder="Usuario" required>
        <input type="password" name="contraseña" placeholder="Contraseña" required>
        <button type="submit">Ingresar</button>
    </form>
</div>

</body>
</html>
