<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/inicioSesion.css">
  <title>Iniciar sesión en Spotify</title>
</head>
<body>
  <div class="container">
    <div class="login-form">
      <img src="../images/logo.png" alt="Logo de Spotify">
      <h1>Bienvenido de nuevo</h1>
      <?php
      if (isset($_SESSION['error'])) {
        if ($_SESSION['error'] == 'incorrect_password') {
          echo '<p style="color:red;">Contraseña incorrecta. Por favor, inténtalo de nuevo.</p>';
        } elseif ($_SESSION['error'] == 'user_not_found') {
          echo '<p style="color:red;">Usuario no encontrado. Por favor, regístrate primero.</p>';
        }
        unset($_SESSION['error']); // Clear error after displaying
      }
      ?>
      <form action="login.php" method="post">
        <input type="text" name="username" placeholder="Nombre de usuario o email" required>
        <input type="password" name="password" placeholder="Contraseña" required>
        <button type="submit">Iniciar sesión</button>
      </form>
      <p class="message">¿No tienes cuenta? <a href="../registrar.html">Regístrate gratis</a></p>
    </div>
  </div>
</body>
</html>
