<?php
// Verificar si se recibió el ID de la canción a eliminar
if(isset($_POST['track_id'])) {
    // Obtener el ID de la canción desde la solicitud POST
    $trackId = $_POST['track_id'];

    // Realizar cualquier validación adicional si es necesario

    // Realizar la conexión a la base de datos
    require 'db.php';

    // Consulta SQL para eliminar la canción de la base de datos
    $sql = "DELETE FROM PlaylistTracks WHERE TrackID = ?";
    $stmt = $pdo->prepare($sql);
    if ($stmt->execute([$trackId])) {
        // La canción se eliminó correctamente
        $response = array(
            'success' => true,
            'message' => 'Canción eliminada exitosamente.',
            'deletedTrackId' => $trackId
        );
    } else {
        // Error al eliminar la canción
        $response = array(
            'success' => false,
            'message' => 'Error al eliminar la canción.'
        );
    }
} else {
    // No se recibió el ID de la canción
    $response = array(
        'success' => false,
        'message' => 'ID de la canción no proporcionado.'
    );
}

// Devolver la respuesta en formato JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
