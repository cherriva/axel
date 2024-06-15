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

// Asegurar que el parámetro status está definido y no está vacío
if (isset($_GET['status']) && !empty($_GET['status'])) {
    $status = $_GET['status'];

    // Consulta preparada para evitar SQL injection
    $sql = "SELECT p.nombre, p.genero, s.status AS nombre_status, p.location_name, p.species 
            FROM FINAL_PERSONAJES p
            INNER JOIN FINAL_STATUS s ON p.idStatus = s.idStatus
            WHERE p.idStatus = ?";
    
    // Preparar y ejecutar la consulta
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $status); // "i" indica que esperamos un entero
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="card">';
            echo '<h3>' . $row['nombre'] . '</h3>';
            echo '<p><strong>Género:</strong> ' . $row['genero'] . '</p>';
            echo '<p><strong>Status:</strong> ' . $row['nombre_status'] . '</p>';
            echo '<p><strong>Locación:</strong> ' . $row['location_name'] . '</p>';
            echo '<p><strong>Especie:</strong> ' . $row['species'] . '</p>';
            echo '</div>';
        }
    } else {
        echo '<p>No se encontraron personajes para este estado.</p>';
    }

    $stmt->close();
} else {
    echo '<p>Estado no válido.</p>';
}

$con->close();
?>
