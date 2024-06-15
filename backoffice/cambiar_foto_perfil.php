<?php
// Iniciar la sesión
session_start();

// Verificar si el usuario ha iniciado sesión
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    // Verificar si se ha enviado un archivo
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["profile_picture"])) {
        // Conexión a la base de datos
        $servername = 'dbserver';
        $username = 'grupo37';
        $password = "ieK3air8Ho"; 
        $database = "db_grupo37";

        $conn = new mysqli($servername, $username, $password, $database);

        // Verificar la conexión
        if ($conn->connect_error) {
            die("Error en la conexión a la base de datos: " . $conn->connect_error);
        }

        // Directorio donde se guardarán las imágenes de perfil
        $target_dir = "../fotosDePerfil/";
        // Crear el directorio si no existe
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        // Nombre de archivo único basado en el ID de usuario
        $usuario_id = $_SESSION['id'];
        $target_file = $target_dir . basename($_FILES["profile_picture"]["name"]);
        $profile_picture = $target_file;

        // Mover el archivo cargado al directorio de imágenes de perfil
        if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file)) {
            // Actualizar la ruta de la foto de perfil en la base de datos
            $sql = $conn->prepare("UPDATE Usuarios SET foto_perfil=? WHERE id=?");
            $sql->bind_param("si", $profile_picture, $usuario_id);

            if ($sql->execute()) {
                echo "Foto de perfil actualizada exitosamente.";
                echo '<br><a href="perfil.php">Volver al perfil</a>';
            } else {
                echo "Error al actualizar la foto de perfil: " . $conn->error;
                echo '<br><a href="perfil.php">Volver al perfil</a>';
            }
        } else {
            echo "Error al subir la foto de perfil.";
            echo '<br><a href="perfil.php">Volver al perfil</a>';
        }

        $conn->close();
    } else {
        echo "No se recibió ninguna imagen.";
        echo '<br><a href="perfil.php">Volver al perfil</a>';
    }
} else {
    // El usuario no ha iniciado sesión, redirigirlo a la página de inicio de sesión
    header("Location: login.php");
    exit;
}
?>
