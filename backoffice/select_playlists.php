<!DOCTYPE html>
<html lang="es">
<?php include 'header.php'; 
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Playlists</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 500px;
            margin: 50px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        form {
            text-align: center;
        }

        label {
            font-weight: bold;
            margin-right: 10px;
        }

        select {
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        input[type="submit"] {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #333;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #333;
        }

        .empty-message {
            color: #555;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Selecciona la Playlist a Actualizar</h1>
        <form action="update_playlists.php" method="GET">
            <label for="playlist_id">Playlist:</label>
            <select name="playlist_id" id="playlist_id">
                <?php
                $dbHost     = 'dbserver';
                $dbUsername = 'grupo37';
                $dbPassword = "ieK3air8Ho"; 
                $dbName     = "db_grupo37";

                $mysqli = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

                if ($mysqli->connect_error) {
                    die("Conexión fallida: " . $mysqli->connect_error);
                }

                $result = $mysqli->query("SELECT PlaylistID, PlaylistName FROM Playlists");
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<option value='{$row['PlaylistID']}'>{$row['PlaylistName']}</option>";
                    }
                } else {
                    echo "<option value=''>No hay playlists disponibles</option>";
                }
                $mysqli->close();
                ?>
            </select>
            <br><br>
            <input type="submit" value="Actualizar Playlist">
        </form>
        <?php
        if ($result->num_rows === 0) {
            echo "<p class='empty-message'>No hay playlists disponibles. Por favor, asegúrate de agregar playlists antes de intentar actualizar.</p>";
        }
        ?>
    </div>
</body>
<?php include 'footer.php'; ?>
</html>
