<?php
    require("../config/conexion.php");

    // Query usuarios totales en db
    $query_usuarios = "SELECT *
                       FROM usuarios;";
    $result_usuarios = $db1 -> prepare($query_usuarios);
    $result_usuarios -> execute();
    $usuarios = $result_usuarios -> fetchAll();

    $n_usuarios = sizeof($usuarios);

    // Query para el usuario ADMIN
    $query_admin = "SELECT id, username, contraseña, tipo
                    FROM usuarios
                    WHERE username like '%ADMIN%';";
    $result_admin = $db1 -> prepare($query_admin);
    $result_admin -> execute();
    $admin = $result_admin -> fetchAll();

    // Añadir ADMIN a la base de datos si es que no se encuentra
    if (count($admin) == 0) {
        $id = $n_usuarios+1;
        $n_usuarios = $n_usuarios+1;
        $admin_q = "INSERT INTO usuarios (id, username, contraseña, tipo)
                    VALUES ('$id', 'ADMIN', 'admin', 'Admin');";
        try {
            $db1 ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $db1 -> exec($admin_q);
            echo "New record created successfully";
        } catch(PDOException $e) {
            echo "<br>";
        }
    }

    // Query usuarios tipo clientes en db
    $query_usuarios_cl = "SELECT id, username, contraseña, tipo
                          FROM usuarios
                          WHERE tipo like '%Cliente%';";
    $result_usuarios_cl = $db1 -> prepare($query_usuarios_cl);
    $result_usuarios_cl -> execute();
    $usuarios_cl = $result_usuarios_cl -> fetchAll();

    // Array de username de usuarios tipo clientes
    $array_usuarios_cl = array();
    foreach ($usuarios_cl as $cliente) {
        array_push($array_usuarios_cl, $cliente[1]);
    }

    // Query de clientes en db
    $query_cl = "SELECT *
                 FROM clientes;";
    $result_cl = $db1 -> prepare($query_cl);
    $result_cl -> execute();
    $id_cl = $result_cl -> fetchAll();

    // array de clientes
    $array_cl = array();
    foreach ($id_cl as $cliente) {
        array_push($array_cl, array($cliente[0], $cliente[1]));
    }

    // ingresar usuarios tipo cliente a db con password al azar
    foreach ($array_cl as $cliente) {
        if (!(in_array($cliente[0], $array_usuarios_cl))) {
            $id = $n_usuarios+1;
            $n_usuarios = $n_usuarios+1;
            $pwd = bin2hex(openssl_random_pseudo_bytes(4));
            // echo $id;
            // echo $cliente[0];
            // echo " ";
            // echo $cliente[1];
            // echo "<br>";
            $user_ca = "INSERT INTO usuarios (id, username, contraseña, tipo)
                        VALUES ('$cliente[0]', '$cliente[1]', '$pwd', 'Cliente');";
            try {
                $db1 ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $db1 -> exec($user_ca);
            } catch(PDOException $e) {
                echo "<br>";
            }
        }
    }
?>