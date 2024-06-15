<?php
require 'auth.php';
require_login();
require 'db.php';

function get_data_from_api() {
    // Implementa la lógica para obtener los datos desde la API
    return [
        'playlists' => [
            // Ejemplo de datos de la API
            [
                'id' => '1',
                'name' => 'Playlist 1',
                'tracks' => 10,
                'owner' => 'Owner 1',
                'description' => 'Description 1',
                'url' => 'http://example.com/1',
                'image' => 'http://example.com/image1.jpg'
            ],
            // Más datos...
        ]
    ];
}

$data = get_data_from_api();

foreach ($data['playlists'] as $playlist) {
    $stmt = $pdo->prepare('INSERT INTO Playlists (PlaylistID, PlaylistName, NumberOfTracks, OwnerName, PlaylistDescription, PlaylistURL, ImageURL) VALUES (?, ?, ?, ?, ?, ?, ?)');
    $stmt->execute([
        $playlist['id'],
        $playlist['name'],
        $playlist['tracks'],
        $playlist['owner'],
        $playlist['description'],
        $playlist['url'],
        $playlist['image']
    ]);
}

header('Location: dashboard.php');
exit();
?>
