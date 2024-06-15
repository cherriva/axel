<?php
// Incluir el archivo de conexión a la base de datos
require 'basededatos.php';

function registrarUsuario($nombre_usuario, $contrasena, $es_admin) {
    // Obtener el objeto de conexión
    $conexion = conexion();

    // Encriptar la contraseña
    $contrasena_encriptada = password_hash($contrasena, PASSWORD_DEFAULT);

    // Preparar la consulta SQL
    $sql = "INSERT INTO usuarios (nombre_usuario, contrasena, es_admin) 
            VALUES (?, ?, ?)";

    // Preparar la declaración
    $stmt = $conexion->prepare($sql);

    if ($stmt) {
        // Vincular los parámetros
        $stmt->bind_param("ssi", $nombre_usuario, $contrasena_encriptada, $es_admin);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            // Redirigir a la página de inicio
            header('Location: ../index.html');
            exit; // Asegurarse de que el script se detenga después de la redirección
        } else {
            return "Error al registrar el usuario: " . $stmt->error;
        }

        // Cerrar la declaración
        $stmt->close();
    } else {
        return "Error en la preparación de la consulta: " . $conexion->error;
    }

    // Cerrar la conexión
    $conexion->close();
}

// Verificar si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos del formulario
    $nombre_usuario = $_POST['nombre_usuario'];
    $contrasena = $_POST['contrasena'];
    $es_admin = isset($_POST['es_admin']) ? 1 : 0; // Verificar si es admin

    // Registrar el usuario
    $resultado = registrarUsuario($nombre_usuario, $contrasena, $es_admin);
    echo $resultado;
}
?>

<!-- Formulario HTML para registrar un usuario -->
<!DOCTYPE html>
<html>
<head>
    <title>Registro de Usuario</title>
</head>
<body>
    <h2>Registro de Usuario</h2>
    <form method="post" action="loginusuarios.php">
        <label for="nombre_usuario">Nombre de Usuario:</label>
        <input type="text" id="nombre_usuario" name="nombre_usuario" required><br><br>
        <label for="contrasena">Contraseña:</label>
        <input type="password" id="contrasena" name="contrasena" required><br><br>
        <label for="es_admin">¿Es Administrador?</label>
        <input type="checkbox" id="es_admin" name="es_admin"><br><br>
        <input type="submit" value="Registrar">
    </form>
</body>
</html>
