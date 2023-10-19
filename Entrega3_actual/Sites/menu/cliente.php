<?php
session_start();
$cliente = $_SESSION['user'];
if (is_null($cliente)) {
    header("Location: ../index.php");
    exit();
}

require("../config/conexion.php");

include('../templates/header.html');
?>

<h1 class="title is-2">¡Bienvenido Cliente!</h1>

<div class="box">
    <h1 class='title is-4'>Informacion</h1>
    <div class="columns">
        <div class="column is-one-quarter"><strong>Nombre Completo:</strong></div>
        <div class="column"><?php echo "$cliente"?></div>
    </div>
</body>
</html>