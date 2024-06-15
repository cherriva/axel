<?php
require 'db.php';

$usuarios = $pdo->query('SELECT * FROM Usuarios')->fetchAll();
?>

<?php include 'header.php'; ?>
<div class="users-container">
    <h2>Usuarios</h2>
    <input type="text" id="search" placeholder="Buscar usuarios...">
    <ul id="user_list">
        <?php foreach ($usuarios as $usuario): ?>
            <li>
                <?php echo htmlspecialchars($usuario['nombre_completo']); ?> - <?php echo htmlspecialchars($usuario['correo']); ?>
                <button class="modify-user-btn" data-id="<?php echo $usuario['id']; ?>">Modificar</button>
            </li>
        <?php endforeach; ?>
    </ul>
</div>

<div id="modify-user-modal" style="display: none;">
    <!-- Contenido del modal para modificar usuario -->
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
    // Función para adjuntar el evento click al botón de modificar usuario
    function attachModifyUserEvent() {
        $('.modify-user-btn').click(function(){
            var userId = $(this).data('id');
            // Redirigir a la página de modificación de usuario con el ID del usuario
            window.location.href = 'modify_user.php?id=' + userId;
        });
    }

    // Adjuntar el evento click al cargar la página
    attachModifyUserEvent();

    $('#search').keyup(function(){
        var query = $(this).val();
        $.ajax({
            url:'search.php',
            method: 'POST',
            data:{query:query},
            success:function(response){
                $('#user_list').html(response);
                // Volver a adjuntar el evento click después de la búsqueda
                attachModifyUserEvent();
            }
        });
    });
});
</script>

<?php include 'footer.php'; ?>
