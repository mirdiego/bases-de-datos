<?php
session_start();
$admin = $_SESSION["user"];
if (is_null($admin)) {
    header("Location: ../index.php");
    exit();
}

require("../config/conexion.php");

if (isset($_GET['region'])) {
    // Obtener la región seleccionada
    $region = $_GET['region'];

    // Buscar los IDs de las tiendas
    $query = "SELECT id_tienda FROM direcciones WHERE region = :region";
    $result = $db2->prepare($query);
    $result->bindParam(':region', $region);
    $result->execute();
    $tiendas = $result->fetchAll(PDO::FETCH_ASSOC);

    // Devolver los IDs de las tiendas como respuesta en formato JSON
    echo json_encode($tiendas);
} elseif (isset($_GET['id_tienda']) && isset($_GET['categoria'])) {
    // Obtener los productos por tienda y categoría
    $idTienda = $_GET['id_tienda'];
    $categoria = $_GET['categoria'];

    $query = "SELECT p.nombre, s.cantidad, s.descuento, p.id_producto, s.id_tienda FROM productos p JOIN stock s ON p.id_producto = s.id_producto WHERE s.id_tienda = :id_tienda AND p.categoria = :categoria";
    $statement = $db2->prepare($query);
    $statement->bindParam(':id_tienda', $idTienda);
    $statement->bindParam(':categoria', $categoria);
    $statement->execute();
    $productos = $statement->fetchAll(PDO::FETCH_ASSOC);

    // Devolver la respuesta como JSON con los productos
    echo json_encode($productos);
} elseif (isset($_GET['id_tienda'])) {
    $id_tienda = $_GET['id_tienda'];

    // Obtener los ID de los productos en la tienda seleccionada
    $query = "SELECT id_producto FROM stock WHERE id_tienda = :id_tienda";
    $statement = $db2->prepare($query);
    $statement->bindParam(':id_tienda', $id_tienda, PDO::PARAM_INT);
    $statement->execute();
    $productos = $statement->fetchAll(PDO::FETCH_COLUMN);

    // Obtener las categorías de los productos
    $query = "SELECT DISTINCT categoria FROM productos WHERE id_producto IN (" . implode(",", $productos) . ") ORDER BY categoria ASC";
    $statement = $db2->prepare($query);
    $statement->execute();
    $categorias = $statement->fetchAll(PDO::FETCH_COLUMN);

    // Devolver la respuesta como JSON con las categorías de los productos
    echo json_encode($categorias);
}
?>