<?php
    session_start();
    require("../config/conexion.php");

    $username = $_POST["user"];
    $password = $_POST["pass"];

    $query = "SELECT tipo
                FROM usuarios
                WHERE username = '$username' AND contraseña = '$password';";
    $result = $db1 -> prepare($query);
    $result -> execute();
    $data = $result -> fetch();
    $_SESSION["user"] = $username;
    $_SESSION["password"] = $password;

    if ($data[0] == 'Admin') {
        echo 'menu/admin.php';
    } elseif ($data[0] == 'Cliente') {
        echo 'menu/cliente.php';
    }

?>