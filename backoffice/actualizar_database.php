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
        <h1>Borrar Datos API</h1>
        <form action="../php/poblarBBDD/reiniciarTablas.php" method="GET">
            <input type="submit" value="Borrar las tablas">
        </form>
        <h1>Cargar datos de API</h1>
        <form action="../php/poblarBBDD/poblarBBDD.php" method="GET">
            <input type="submit" value="Cargar datos en las tablas">
        </form>
    </div>
</body>
<?php include 'footer.php'; ?>
</html>
