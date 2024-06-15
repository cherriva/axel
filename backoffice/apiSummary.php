<!DOCTYPE html>
<html lang="es">
<?php include 'header.php'; ?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resumen de la Base de Datos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        h2 {
            color: #555;
            margin-top: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
            color: #333;
            text-transform: uppercase;
        }

        tr:hover {
            background-color: #f9f9f9;
        }

        .empty-message {
            text-align: center;
            color: #999;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Resumen de la Base de Datos</h1>

        <h2>Resumen de Playlists</h2>
        <table>
            <thead>
                <tr>
                    <th>Nombre de la Playlist</th>
                    <th>Número de Canciones</th>
                    <th>Nombre del Propietario</th>
                </tr>
            </thead>
            <tbody>
                <?php
               
                $dbHost     = 'dbserver';
                $dbUsername = 'grupo37';
                $dbPassword = "ieK3air8Ho"; 
                $dbName     = "db_grupo37";

                $mysqli = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

                if ($mysqli->connect_error) {
                    die("Conexión fallida: " . $mysqli->connect_error);
                }

                $result = $mysqli->query("SELECT PlaylistName, NumberOfTracks, OwnerName FROM Playlists");
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['PlaylistName']}</td>
                                <td>{$row['NumberOfTracks']}</td>
                                <td>{$row['OwnerName']}</td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='3' class='empty-message'>No hay playlists disponibles</td></tr>";
                }
                $mysqli->close();
                ?>
            </tbody>
        </table>

        <h2>Resumen de Canciones</h2>
        <table>
            <thead>
                <tr>
                    <th>Nombre de la Canción</th>
                    <th>Artista</th>
                    <th>Playlist</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $mysqli = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

                if ($mysqli->connect_error) {
                    die("Conexión fallida: " . $mysqli->connect_error);
                }

                $result = $mysqli->query("SELECT TrackName, ArtistName, PlaylistName FROM PlaylistTracks");
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['TrackName']}</td>
                                <td>{$row['ArtistName']}</td>
                                <td>{$row['PlaylistName']}</td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='3' class='empty-message'>No hay canciones disponibles</td></tr>";
                }
                $mysqli->close();
                ?>
            </tbody>
        </table>
    </div>
</body>
<?php include 'footer.php'; ?>
</html>
