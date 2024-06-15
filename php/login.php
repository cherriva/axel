<?php
session_start();

// Conexión a la base de datos
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
$username = $_POST['username'];
$password = $_POST['password'];

// Buscar el usuario en la base de datos
$sql = "SELECT id, nombre_completo, correo, contraseña, ultima_conexion, es_admin FROM Usuarios WHERE nombre_completo='$username' OR correo='$username'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Usuario encontrado
    $row = $result->fetch_assoc();
    $hashed_password = $row['contraseña'];

    // Verificar la contraseña
    if (password_verify($password, $hashed_password)) {
        // Actualizar la hora de última conexión en la base de datos
        $update_sql = "UPDATE Usuarios SET ultima_conexion=CURRENT_TIMESTAMP WHERE id=" . $row['id'];
        $conn->query($update_sql);

        // Contraseña correcta, iniciar sesión
        $_SESSION['id'] = $row['id'];
        $_SESSION['nombre_completo'] = $row['nombre_completo'];
        $_SESSION['correo'] = $row['correo'];
        $_SESSION['loggedin'] = true;
        $_SESSION['ultima_conexion'] = $row['ultima_conexion']; // Guardar la última conexión en la sesión
        $_SESSION['es_admin'] = $row['es_admin'];

        // Verificar si el usuario es administrador
        if ($row['es_admin']) {
            // Redirigir al backoffice para los administradores
            header("Location: ../backoffice/index.php");
            exit;
        } else {
            // Redireccionar al usuario a la página de inicio
            header("Location: ../index.html");
            exit;
        }
    } else {
        // Contraseña incorrecta
        $_SESSION['error'] = 'incorrect_password';
        header("Location: inicioSesion.php");
        exit;
    }
} else {
    // Usuario no encontrado
    $_SESSION['error'] = 'user_not_found';
    header("Location: inicioSesion.php");
    exit;
}

$conn->close();
?>
