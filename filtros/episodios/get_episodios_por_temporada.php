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
$con = conexion();

// Asegurar que el parámetro temporada está definido y no está vacío
if (isset($_GET['temporada']) && !empty($_GET['temporada'])) {
    $temporada = $_GET['temporada'];

    // Consulta preparada para evitar SQL injection
    $sql = "SELECT * FROM FINAL_EPISODES WHERE episode LIKE ?";
    
    // El patrón para buscar episodios de la temporada seleccionada (S01, S02, etc.)
    $pattern = $temporada . "%";

    // Preparar y ejecutar la consulta
    $stmt = $con->prepare($sql);
    $stmt->bind_param("s", $pattern); // "s" indica que esperamos un string
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="card">';
            echo '<h3>' . $row['name'] . '</h3>';
            echo '<p><strong>Fecha de Emisión:</strong> ' . $row['air_date'] . '</p>';
            echo '<p><strong>Episodio:</strong> ' . $row['episode'] . '</p>';
            echo '</div>';
        }
    } else {
        echo '<p>No se encontraron episodios para esta temporada.</p>';
    }

    $stmt->close();
} else {
    echo '<p>Temporada no válida.</p>';
}

$con->close();
?>
