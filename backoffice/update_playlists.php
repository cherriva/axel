<?php
$dbHost     = 'dbserver';
$dbUsername = 'grupo37';
$dbPassword = "ieK3air8Ho"; 
$dbName     = "db_grupo37";

$mysqli = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

if ($mysqli->connect_error) {
    die("Conexión fallida: " . $mysqli->connect_error);
}

$tokenResult = $mysqli->query("SELECT Token FROM Token");
if ($tokenResult->num_rows === 0) {
    die("Error: Token no encontrado.");
}
$tokenRow = $tokenResult->fetch_assoc();
$access_token = $tokenRow['Token'];

if (isset($_GET['playlist_id'])) {
    $playlist_id = $mysqli->real_escape_string($_GET['playlist_id']);

    // Limpieza de datos existentes
    $mysqli->query("DELETE FROM PlaylistTracks WHERE PlaylistID = '$playlist_id'");
    $mysqli->query("DELETE FROM Playlists WHERE PlaylistID = '$playlist_id'");

    // Configuración de cURL para recuperar detalles de la playlist
    $url = "https://api.spotify.com/v1/playlists/{$playlist_id}?fields=name,description,tracks.items(track(id,name,artists(name,id),album(images),preview_url)),owner(display_name),external_urls(spotify),images";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HTTPHEADER, ["Authorization: Bearer {$access_token}"]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_URL, $url);
    $response = curl_exec($ch);

    if (!$response) {
        echo "Error al realizar solicitud a Spotify: " . curl_error($ch);
        curl_close($ch);
        exit;
    }

    $playlist = json_decode($response, true);

    if (isset($playlist['error'])) {
        echo "Error al obtener datos de la playlist: " . $playlist['error']['message'];
        curl_close($ch);
        exit;
    }

    if ($playlist) {
        $playlistName = $mysqli->real_escape_string($playlist['name']);
        $numberOfTracks = count($playlist['tracks']['items']);
        $ownerName = $mysqli->real_escape_string($playlist['owner']['display_name']);
        $playlistDescription = $mysqli->real_escape_string($playlist['description']);
        $playlistURL = $mysqli->real_escape_string($playlist['external_urls']['spotify']);
        $imageURL = isset($playlist['images'][0]['url']) ? $mysqli->real_escape_string($playlist['images'][0]['url']) : NULL;

        $sql = "INSERT INTO Playlists (PlaylistID, PlaylistName, NumberOfTracks, OwnerName, PlaylistDescription, PlaylistURL, ImageURL)
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("ssissss", $playlist_id, $playlistName, $numberOfTracks, $ownerName, $playlistDescription, $playlistURL, $imageURL);
        $stmt->execute();

        foreach ($playlist['tracks']['items'] as $item) {
            $track = $item['track'];
            $trackId = $mysqli->real_escape_string($track['id']);
            $trackName = $mysqli->real_escape_string($track['name']);
            $artistId = $mysqli->real_escape_string($track['artists'][0]['id']);
            $artistName = $mysqli->real_escape_string($track['artists'][0]['name']);
            $trackImageURL = $mysqli->real_escape_string($track['album']['images'][0]['url']);
            $previewUrl = isset($track['preview_url']) ? $mysqli->real_escape_string($track['preview_url']) : NULL;
            $markets = isset($track['available_markets']) ? implode(", ", $track['available_markets']) : NULL;

            $sql_tracks = "INSERT INTO PlaylistTracks (TrackID, PlaylistID, TrackName, ArtistName, ImageURL, PlaylistName, PreviewURL, Market) 
                           VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            if ($stmt_tracks = $mysqli->prepare($sql_tracks)) {
                $stmt_tracks->bind_param("ssssssss", $trackId, $playlist_id, $trackName, $artistName, $trackImageURL, $playlistName, $previewUrl, $markets);
                $stmt_tracks->execute();
            } else {
                echo "Error preparando la consulta: " . $mysqli->error;
            }
        }

        echo "Playlist y pistas actualizadas con éxito.";
    }
    curl_close($ch);
} else {
    echo "ID de la playlist no proporcionado.";
}

$mysqli->close();
?>
