<?php
// Verificar si se recibió el ID del usuario
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    // Redirigir si no se proporcionó un ID válido
    header("Location: index.php");
    exit();
}

require 'db.php';

// Obtener el ID del usuario de la URL
$user_id = $_GET['id'];

// Obtener la información del usuario de la base de datos
$stmt = $pdo->prepare("SELECT * FROM Usuarios WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Verificar si el usuario existe
if (!$user) {
    // Redirigir si el usuario no existe
    header("Location: index.php");
    exit();
}

// Procesar la modificación de la contraseña
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['new_password'])) {
    $new_password = $_POST['new_password'];

    // Cifrar la nueva contraseña
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    // Actualizar la contraseña cifrada en la base de datos
    $stmt = $pdo->prepare("UPDATE Usuarios SET contraseña = ? WHERE id = ?");
    $stmt->execute([$hashed_password, $user_id]);

    // Redirigir a la página principal después de actualizar la contraseña
    header("Location: index.php");
    exit();
}

// Procesar la eliminación del usuario
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_user'])) {
    // Eliminar el usuario de la base de datos
    $stmt = $pdo->prepare("DELETE FROM Usuarios WHERE id = ?");
    $stmt->execute([$user_id]);

    // Redirigir a la página principal después de eliminar el usuario
    header("Location: index.php");
    exit();
}
?>

<?php include 'header.php'; ?>

<div class="modify-user-container">
    <h2>Modificar Usuario</h2>
    <p><strong>Usuario</strong>: <?php echo htmlspecialchars($user['nombre_completo']); ?> - <?php echo htmlspecialchars($user['correo']); ?></p>
    
    <!-- Formulario para modificar la contraseña -->
    <form class="modify-form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . '?id=' . $user_id); ?>">
        <label for="new_password"><strong>Modificar Contraseña:</strong></label>
        <input type="password" name="new_password" id="new_password" required>
        <button type="submit">Cambiar Contraseña Usuario</button>
    </form>

    <!-- Formulario para eliminar el usuario -->
    <form class="modify-form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . '?id=' . $user_id); ?>">
        <input type="hidden" name="delete_user" value="true">
        <button type="submit" onclick="return confirm('¿Estás seguro de que quieres eliminar este usuario?')">Eliminar Usuario</button>
    </form>
</div>

<?php include 'footer.php'; ?>
