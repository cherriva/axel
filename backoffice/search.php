<!DOCTYPE html>
<html lang="es">
<?php include 'header.php'; ?>
<head>
    <meta charset="UTF-8">
    <title>Administrar Usuarios</title>
</head>
<body>
    <h1>Administrar Usuarios</h1>

    <form action="" method="post">
        <label for="user_id">Seleccione el usuario:</label>
        <select name="user_id" id="user_id" required>
            <?php
            $mysqli = new mysqli("localhost", "root", "", "siw");
            if ($mysqli->connect_error) {
                die("Conexión fallida: " . $mysqli->connect_error);
            }
            $result = $mysqli->query("SELECT id, nombre_completo FROM Usuarios");
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<option value='{$row['id']}'>{$row['nombre_completo']}</option>";
                }
            } else {
                echo "<option>No hay usuarios disponibles</option>";
            }
            $mysqli->close();
            ?>
        </select>
        <br><br>

        <label for="new_password">Nueva Contraseña (solo para cambio de contraseña):</label>
        <input type="password" id="new_password" name="new_password">
        <br><br>

        <input type="submit" name="action" value="Eliminar Usuario">
        <input type="submit" name="action" value="Cambiar Contraseña">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $userId = $_POST['user_id'];
        $mysqli = new mysqli("localhost", "root", "", "siw");

        if ($mysqli->connect_error) {
            die("Conexión fallida: " . $mysqli->connect_error);
        }

        if ($_POST['action'] == 'Eliminar Usuario') {
            $query = "DELETE FROM Usuarios WHERE id = ?";
            $stmt = $mysqli->prepare($query);
            $stmt->bind_param("i", $userId);
            $stmt->execute();
            if ($stmt->affected_rows > 0) {
                echo "<p>Usuario eliminado correctamente.</p>";
            } else {
                echo "<p>Error al eliminar el usuario.</p>";
            }
        } elseif ($_POST['action'] == 'Cambiar Contraseña' && !empty($_POST['new_password'])) {
            $newPassword = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
            $query = "UPDATE Usuarios SET contraseña = ? WHERE id = ?";
            $stmt = $mysqli->prepare($query);
            $stmt->bind_param("si", $newPassword, $userId);
            $stmt->execute();
            if ($stmt->affected_rows > 0) {
                echo "<p>Contraseña actualizada correctamente.</p>";
            } else {
                echo "<p>Error al actualizar la contraseña.</p>";
            }
        }

        $mysqli->close();
    }
    ?>
</body>
</html>
<?php include 'footer.php'; ?>
