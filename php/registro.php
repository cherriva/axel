<?php
$servidor = "localhost";
$bd = "SIW";
$user = "root";
$password = "";

// Crear conexión
$conn = new mysqli($servidor, $user, $password, $bd);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error en la conexión a la base de datos: " . $conn->connect_error);
}

// Recibir datos del formulario
$nombre = $_POST['nombre'];
$email = $_POST['email'];
$password = $_POST['password'];
$password2 = $_POST['password2'];

// Verificar que las contraseñas coincidan
if ($password != $password2) {
    header("Location: ../error.html");
    exit();
}

// Encriptar la contraseña (puedes usar un método de encriptación más seguro)
$password_hash = password_hash($password, PASSWORD_DEFAULT);

// Verificar si el nombre de usuario ya existe
$check_sql = "SELECT nombre_completo FROM Usuarios WHERE nombre_completo = '$nombre'";
$check_result = $conn->query($check_sql);

if ($check_result->num_rows > 0) {
    header("Location: ../error.html");
    exit();
}

// Insertar datos en la base de datos
$sql = "INSERT INTO Usuarios (nombre_completo, correo, contraseña, fecha_creacion, ultima_conexion) 
        VALUES ('$nombre', '$email', '$password_hash', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)";

if ($conn->query($sql) === TRUE) {
    header("Location: ../RegistroCorrecto.html");
    exit();
} else {
    header("Location: ../error.html");
    exit();
}

$conn->close();
?>
