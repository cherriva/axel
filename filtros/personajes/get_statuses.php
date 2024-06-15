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

$sql = "SELECT idStatus, status FROM FINAL_STATUS";
$result = $con->query($sql);

$options = '<option value="">Selecciona un Status</option>';
while ($row = $result->fetch_assoc()) {

    $options .= '<option value="' . $row['idStatus'] . '">' . $row['status'] . '</option>';
}

$con->close();

echo $options;
?>
