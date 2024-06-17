<?php
session_start(); // Inicia sesión o reanuda la existente

// Verificar si el usuario está logueado
if (!isset($_SESSION['nombre_completo'])) {
    // Redirigir al usuario si no está logueado
    header('Location: login.php');
    exit();
}

// Conexión a la base de datos
$mysqli = new mysqli("localhost", "root", "", "siw"); // Ajusta estos parámetros según tu configuración

// Verificar conexión
if ($mysqli->connect_error) {
    die("Error de conexión: " . $mysqli->connect_error);
}

// Procesar el cambio de contraseña
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['new_password'])) {
    $newPassword = password_hash($_POST['new_password'], PASSWORD_DEFAULT); // Hash de la nueva contraseña
    $query = "UPDATE Usuarios SET contraseña = ? WHERE nombre_completo = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("ss", $newPassword, $_SESSION['nombre_completo']);

    if ($stmt->execute()) {
        echo "<p>Contraseña actualizada correctamente.</p>";
    } else {
        echo "<p>Error al actualizar la contraseña.</p>";
    }
    $stmt->close();
}

$mysqli->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambiar Contraseña</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        form {
            background: white;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            border-radius: 8px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        label, input {
            display: block;
            width: 100%;
            margin-bottom: 10px;
        }
        input[type="password"] {
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        input[type="submit"] {
            background-color: #5c67f2;
            color: white;
            border: none;
            padding: 10px 15px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 4px;
        }
        input[type="submit"]:hover {
            background-color: #4a54e1;
        }
        p {
            text-align: center;
            color: green;
        }
    </style>
</head>
<body>
    <form action="" method="post">
        <h1>Cambiar Contraseña</h1>
        <label for="new_password">Nueva Contraseña:</label>
        <input type="password" id="new_password" name="new_password" required>
        <input type="submit" value="Cambiar Contraseña">
    </form>
</body>
</html>
