<?php
function conexion() {
    $servidor = "localhost";
    $bd = "SIW";
    $user = "root";
    $password = "";

    // Crear conexión
    $con = new mysqli($servidor, $user, $password, $bd);

    // Verificar conexión
    if ($con->connect_error) {
        echo "Error de conexión de base de datos <br>";
        echo "Error número: " . $con->connect_errno . "<br>";
        echo "Texto error: " . $con->connect_error;
        exit;
    }

    return $con;
}

function borrarTablas() {
    $con = conexion();

    // SQL para borrar tablas
    $sqlDropPersonajes = "DROP TABLE IF EXISTS FINAL_PERSONAJES";
    $sqlDropStatus = "DROP TABLE IF EXISTS FINAL_STATUS";
    $sqlDropLocation = "DROP TABLE IF EXISTS FINAL_LOCATION";
    $sqlDropTipo = "DROP TABLE IF EXISTS FINAL_TIPO";
    $sqlDropEpisodes = "DROP TABLE IF EXISTS FINAL_EPISODES";

    // Ejecutar consultas
    if ($con->query($sqlDropPersonajes) === TRUE) {
        echo "Tabla FINAL_PERSONAJES borrada exitosamente.<br>";
    } else {
        echo "Error borrando la tabla FINAL_PERSONAJES: " . $con->error . "<br>";
    }

    if ($con->query($sqlDropStatus) === TRUE) {
        echo "Tabla FINAL_STATUS borrada exitosamente.<br>";
    } else {
        echo "Error borrando la tabla FINAL_STATUS: " . $con->error . "<br>";
    }

    if ($con->query($sqlDropLocation) === TRUE) {
        echo "Tabla FINAL_LOCATION borrada exitosamente.<br>";
    } else {
        echo "Error borrando la tabla FINAL_LOCATION: " . $con->error . "<br>";
    }

    if ($con->query($sqlDropTipo) === TRUE) {
        echo "Tabla FINAL_TIPO borrada exitosamente.<br>";
    } else {
        echo "Error borrando la tabla FINAL_TIPO: " . $con->error . "<br>";
    }

    if ($con->query($sqlDropEpisodes) === TRUE) {
        echo "Tabla FINAL_EPISODES borrada exitosamente.<br>";
    } else {
        echo "Error borrando la tabla FINAL_EPISODES: " . $con->error . "<br>";
    }

    $con->close();
}

borrarTablas();
?>
