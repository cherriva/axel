<?php
session_start(); // Iniciar la sesión

require 'db.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_SESSION['id'])) {
        $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
        
        $stmt = $pdo->prepare('UPDATE Usuarios SET contraseña = ? WHERE id = ?');
        
        if ($stmt->execute([$new_password, $_SESSION['id']])) {
            $message = 'La contraseña ha sido modificada exitosamente.';
        } else {
            $message = 'Error al modificar la contraseña. Por favor, inténtelo de nuevo.';
        }
    } else {
        $message = 'No hay usuario autenticado.';
    }
}
?>

<?php include 'header.php'; ?>
<div class="change-password-container">
    <h2>Modificar contraseña administrador</h2>
    <form method="post">
        <div class="input-group">
            <input type="password" name="new_password" placeholder="Nueva contraseña" required>
            <button type="submit">Cambiar contraseña</button>
        </div>
    </form>
    <?php if ($message): ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>
</div>
<?php include 'footer.php'; ?>
