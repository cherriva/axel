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

function borrarTablas($con) {
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
}

function crearTablas($con) {
    // SQL para crear tabla FINAL_STATUS
    $sqlStatus = "CREATE TABLE IF NOT EXISTS FINAL_STATUS (
        idStatus INT AUTO_INCREMENT PRIMARY KEY,
        status VARCHAR(50) NOT NULL
    )";

    // SQL para crear tabla FINAL_TIPO
    $sqlTipo = "CREATE TABLE IF NOT EXISTS FINAL_TIPO (
        idTipo INT AUTO_INCREMENT PRIMARY KEY,
        tipo VARCHAR(50) NOT NULL
    )";

    // SQL para crear tabla FINAL_LOCATION
    $sqlLocation = "CREATE TABLE IF NOT EXISTS FINAL_LOCATION (
        idLocation INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        idTipo INT,
        dimension VARCHAR(100),
        FOREIGN KEY (idTipo) REFERENCES FINAL_TIPO(idTipo)
    )";

    // SQL para crear tabla FINAL_PERSONAJES
    $sqlPersonajes = "CREATE TABLE IF NOT EXISTS FINAL_PERSONAJES (
        nombre VARCHAR(100) NOT NULL,
        genero VARCHAR(50) NOT NULL,
        idStatus INT,
        location_name VARCHAR(100),
        species VARCHAR(50),
        FOREIGN KEY (idStatus) REFERENCES FINAL_STATUS(idStatus)
    )";

    // SQL para crear tabla FINAL_EPISODES
    $sqlEpisodes = "CREATE TABLE IF NOT EXISTS FINAL_EPISODES (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        air_date DATE,
        episode VARCHAR(50)
    )";

    // Ejecutar consultas
    if ($con->query($sqlStatus) === TRUE) {
        echo "Tabla FINAL_STATUS creada exitosamente.<br>";
    } else {
        echo "Error creando la tabla FINAL_STATUS: " . $con->error . "<br>";
    }

    if ($con->query($sqlTipo) === TRUE) {
        echo "Tabla FINAL_TIPO creada exitosamente.<br>";
    } else {
        echo "Error creando la tabla FINAL_TIPO: " . $con->error . "<br>";
    }

    if ($con->query($sqlLocation) === TRUE) {
        echo "Tabla FINAL_LOCATION creada exitosamente.<br>";
    } else {
        echo "Error creando la tabla FINAL_LOCATION: " . $con->error . "<br>";
    }

    if ($con->query($sqlPersonajes) === TRUE) {
        echo "Tabla FINAL_PERSONAJES creada exitosamente.<br>";
    } else {
        echo "Error creando la tabla FINAL_PERSONAJES: " . $con->error . "<br>";
    }

    if ($con->query($sqlEpisodes) === TRUE) {
        echo "Tabla FINAL_EPISODES creada exitosamente.<br>";
    } else {
        echo "Error creando la tabla FINAL_EPISODES: " . $con->error . "<br>";
    }
}

$con = conexion();
borrarTablas($con);
crearTablas($con);
$con->close();
?>
