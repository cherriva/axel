<?php include 'header.php'; 

ob_start(); 
include '../php/tokenUpdater.php';
ob_end_clean();
?>
<div class="index-container">
    <h2>Bienvenido al Back Office</h2>
</div>
<?php include 'footer.php'; ?>
