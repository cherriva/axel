<!DOCTYPE html>
<html lang="es">
<?php include 'header.php'; 
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resumen de la Base de Datos de Rick and Morty</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Resumen de la Base de Datos de Rick and Morty</h1>

        <h2>Episodios</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Fecha de Emisión</th>
                    <th>Episodio</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $mysqli = new mysqli("localhost", "root", "", "siw"); // Conexión a la base de datos

                if ($mysqli->connect_error) {
                    die("Conexión fallida: " . $mysqli->connect_error);
                }

                $query = "SELECT id, name, air_date, episode FROM FINAL_EPISODES";
                $result = $mysqli->query($query);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['id']}</td>
                                <td>{$row['name']}</td>
                                <td>{$row['air_date']}</td>
                                <td>{$row['episode']}</td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No hay episodios disponibles</td></tr>";
                }
                $mysqli->close();
                ?>
            </tbody>
        </table>

        <h2>Personajes</h2>
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Género</th>
                    <th>Estado</th>
                    <th>Ubicación</th>
                    <th>Especie</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $mysqli = new mysqli("localhost", "root", "", "siw"); // Reutilización de la conexión a la base de datos

                if ($mysqli->connect_error) {
                    die("Conexión fallida: " . $mysqli->connect_error);
                }

                $query = "SELECT p.nombre, p.genero, s.status, p.location_name, p.species FROM FINAL_PERSONAJES p JOIN FINAL_STATUS s ON p.idStatus = s.idStatus";
                $result = $mysqli->query($query);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['nombre']}</td>
                                <td>{$row['genero']}</td>
                                <td>{$row['status']}</td>
                                <td>{$row['location_name']}</td>
                                <td>{$row['species']}</td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No hay personajes disponibles</td></tr>";
                }
                $mysqli->close();
                ?>
            </tbody>
        </table>
    </div>
</body>
<?php include 'footer.php'; ?>
</html>
