<?php
function conexion() {
    $servidor = "localhost";
    $bd = "SIW";
    $user = "root";
    $password = "";

    $con = new mysqli($servidor, $user, $password, $bd);

    if ($con->connect_error) {
        echo "Error de conexión de base de datos <br>";
        echo "Error número: " . $con->connect_errno . "<br>";
        echo "Texto error: " . $con->connect_error;
        exit;
    }

    return $con;
}

header('Content-Type: application/json');

$con = conexion();

$queryStatus = "SELECT status, COUNT(*) as count FROM FINAL_PERSONAJES JOIN FINAL_STATUS ON FINAL_PERSONAJES.idStatus = FINAL_STATUS.idStatus GROUP BY status";
$queryGender = "SELECT genero, COUNT(*) as count FROM FINAL_PERSONAJES GROUP BY genero";
$queryEpisodesBySeason = "SELECT 
    CASE
        WHEN episode LIKE 'S01%' THEN 'Season 1'
        WHEN episode LIKE 'S02%' THEN 'Season 2'
        WHEN episode LIKE 'S03%' THEN 'Season 3'
        WHEN episode LIKE 'S04%' THEN 'Season 4'
        WHEN episode LIKE 'S05%' THEN 'Season 5'
        ELSE 'Unknown'
    END as season, COUNT(*) as count
    FROM FINAL_EPISODES
    GROUP BY season
    ORDER BY season";

$resultStatus = $con->query($queryStatus);
$resultGender = $con->query($queryGender);
$resultEpisodesBySeason = $con->query($queryEpisodesBySeason);

$statusData = [];
$genderData = [];
$episodesBySeasonData = [];

while ($row = $resultStatus->fetch_assoc()) {
    $statusData[] = $row;
}

while ($row = $resultGender->fetch_assoc()) {
    $genderData[] = $row;
}

while ($row = $resultEpisodesBySeason->fetch_assoc()) {
    $episodesBySeasonData[] = $row;
}

echo json_encode([
    'status' => $statusData,
    'gender' => $genderData,
    'episodesBySeason' => $episodesBySeasonData
]);

$con->close();
?>
