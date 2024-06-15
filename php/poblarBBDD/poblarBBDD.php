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

function poblarPersonajes($con) {
    $apiUrl = "https://rickandmortyapi.com/api/character";
    do {
        $jsonData = file_get_contents($apiUrl);
        $data = json_decode($jsonData, true);

        foreach ($data['results'] as $character) {
            $nombre = $character['name'];
            $genero = $character['gender'];
            $status = $character['status'];
            $location_name = $character['location']['name'];
            $species = $character['species'];

            // Check if status exists
            $statusQuery = $con->prepare("SELECT idStatus FROM FINAL_STATUS WHERE status = ?");
            $statusQuery->bind_param("s", $status);
            $statusQuery->execute();
            $result = $statusQuery->get_result();

            if ($result->num_rows > 0) {
                $statusRow = $result->fetch_assoc();
                $idStatus = $statusRow['idStatus'];
            } else {
                // Insert new status
                $insertStatusQuery = $con->prepare("INSERT INTO FINAL_STATUS (status) VALUES (?)");
                $insertStatusQuery->bind_param("s", $status);
                $insertStatusQuery->execute();
                $idStatus = $con->insert_id;
            }

            // Insert character data
            $insertCharacterQuery = $con->prepare("INSERT INTO FINAL_PERSONAJES (nombre, genero, idStatus, location_name, species) VALUES (?, ?, ?, ?, ?)");
            $insertCharacterQuery->bind_param("ssiss", $nombre, $genero, $idStatus, $location_name, $species);
            if ($insertCharacterQuery->execute()) {
                echo "Personaje $nombre insertado exitosamente.<br>";
            } else {
                echo "Error insertando el personaje $nombre: " . $con->error . "<br>";
            }
        }

        $apiUrl = $data['info']['next'];
    } while ($apiUrl != null);
}

function poblarLocation($con) {
    $apiUrl = "https://rickandmortyapi.com/api/location";
    do {
        $jsonData = file_get_contents($apiUrl);
        $data = json_decode($jsonData, true);

        foreach ($data['results'] as $location) {
            $idLocation = $location['id'];
            $name = $location['name'];
            $type = $location['type'];
            $dimension = $location['dimension'];

            // Check if type exists
            $typeQuery = $con->prepare("SELECT idTipo FROM FINAL_TIPO WHERE tipo = ?");
            $typeQuery->bind_param("s", $type);
            $typeQuery->execute();
            $result = $typeQuery->get_result();

            if ($result->num_rows > 0) {
                $typeRow = $result->fetch_assoc();
                $idTipo = $typeRow['idTipo'];
            } else {
                // Insert new type
                $insertTypeQuery = $con->prepare("INSERT INTO FINAL_TIPO (tipo) VALUES (?)");
                $insertTypeQuery->bind_param("s", $type);
                $insertTypeQuery->execute();
                $idTipo = $con->insert_id;
            }

            // Insert location data
            $insertLocationQuery = $con->prepare("INSERT INTO FINAL_LOCATION (idLocation, name, idTipo, dimension) VALUES (?, ?, ?, ?)");
            $insertLocationQuery->bind_param("isis", $idLocation, $name, $idTipo, $dimension);
            if ($insertLocationQuery->execute()) {
                echo "Location $name insertado exitosamente.<br>";
            } else {
                echo "Error insertando la location $name: " . $con->error . "<br>";
            }
        }

        $apiUrl = $data['info']['next'];
    } while ($apiUrl != null);
}

function poblarEpisodios($con) {
    $apiUrl = "https://rickandmortyapi.com/api/episode";
    do {
        $jsonData = file_get_contents($apiUrl);
        $data = json_decode($jsonData, true);

        foreach ($data['results'] as $episode) {
            $id = $episode['id'];
            $name = $episode['name'];
            $air_date = date('Y-m-d', strtotime($episode['air_date']));
            $episodeCode = $episode['episode'];

            // Insert episode data
            $insertEpisodeQuery = $con->prepare("INSERT INTO FINAL_EPISODES (id, name, air_date, episode) VALUES (?, ?, ?, ?)");
            $insertEpisodeQuery->bind_param("isss", $id, $name, $air_date, $episodeCode);
            if ($insertEpisodeQuery->execute()) {
                echo "Episodio $name insertado exitosamente.<br>";
            } else {
                echo "Error insertando el episodio $name: " . $con->error . "<br>";
            }
        }

        $apiUrl = $data['info']['next'];
    } while ($apiUrl != null);
}

$con = conexion();

echo "Poblando personajes...<br>";
poblarPersonajes($con);

echo "Poblando locations...<br>";
poblarLocation($con);

echo "Poblando episodios...<br>";
poblarEpisodios($con);

$con->close();
?>
