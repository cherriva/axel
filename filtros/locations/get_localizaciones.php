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

// Asegurar que el parámetro tipo está definido y no está vacío
if (isset($_GET['tipo']) && !empty($_GET['tipo'])) {
    $tipo = $_GET['tipo'];

    // Consulta preparada para evitar SQL injection
    $sql = "SELECT l.idLocation, l.name, l.dimension, t.tipo 
            FROM FINAL_LOCATION l
            INNER JOIN FINAL_TIPO t ON l.idTipo = t.idTipo
            WHERE l.idTipo = ?";
    
    // Preparar y ejecutar la consulta
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $tipo); // "i" indica que esperamos un entero
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="card">';
            echo '<h3>' . $row['name'] . '</h3>';
            echo '<p><strong>Dimension:</strong> ' . $row['dimension'] . '</p>';
            echo '<p><strong>Tipo:</strong> ' . $row['tipo'] . '</p>';
            echo '</div>';
        }
    } else {
        echo '<p>No se encontraron localizaciones para este tipo.</p>';
    }

    $stmt->close();
} else {
    echo '<p>Tipo de ubicación no válido.</p>';
}

$con->close();
?>
