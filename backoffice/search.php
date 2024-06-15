<?php
require 'db.php';

$output = '';
if(isset($_POST['query'])){
    $search = $_POST['query'];
    $stmt = $pdo->prepare("SELECT * FROM Usuarios WHERE nombre_completo LIKE ? OR correo LIKE ?");
    $stmt->bindValue(1, "%$search%", PDO::PARAM_STR);
    $stmt->bindValue(2, "%$search%", PDO::PARAM_STR);
    $stmt->execute();
    $usuarios = $stmt->fetchAll();

    if($usuarios){
        foreach ($usuarios as $usuario){
            $output .= '<li>' . htmlspecialchars($usuario['nombre_completo']) . ' - ' . htmlspecialchars($usuario['correo']) . '<button class="modify-user-btn" data-id="' . $usuario['id'] . '">Modificar</button></li>';
        }
    } else {
        $output .= '<li>No se han encontrado usuarios</li>';
    }
    echo $output;
}
?>
