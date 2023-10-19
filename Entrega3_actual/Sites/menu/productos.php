<?php
// Obtener el ID del producto desde la URL
$idProducto = isset($_GET['id_producto']) ? $_GET['id_producto'] : null;
$idTienda = isset($_GET['id_tienda']) ? $_GET['id_tienda'] : null;
require("../config/conexion.php");
// Verificar si se recibió un ID de producto válido
if (!empty($idProducto)) {
    // Realizar las operaciones que necesites con el ID del producto
    // ...

    // Ejemplo: Obtener los detalles del producto de la base de datos

    $query = "SELECT * FROM productos WHERE id_producto = :id_producto";
    $statement = $db2->prepare($query);
    $statement->bindParam(':id_producto', $idProducto, PDO::PARAM_INT);
    $statement->execute();
    $producto = $statement->fetch(PDO::FETCH_ASSOC);

    // Mostrar los detalles del producto
    if ($producto) {
        // Obtener el nombre del producto
        $nombreProducto = $producto['nombre'];

        // Incluir el archivo de encabezado
        include '../templates/header.html';

        // Mostrar el título con el nombre del producto en el encabezado
        echo "<h1 class='title'>$nombreProducto</h1>";

        // Mostrar formulario para crear oferta
        echo "<h2 class='subtitle'>Crear oferta</h2>";
        echo "<form action='productos.php?id_producto=$idProducto&id_tienda=$idTienda' method='post'>";
        echo "<div class='field'>";
        echo "<label class='label' for='nuevo_precio'>Descuento:</label>";
        echo "<div class='control'>";
        echo "<input class='input' type='number' name='nuevo_precio' id='nuevo_precio' required>";
        echo "</div>";
        echo "</div>";
        echo "<button class='button is-primary' type='submit' name='crear_oferta'>Crear oferta</button>";
        echo "</form>";

        // Mostrar formulario para actualizar stock
        echo "<h2 class='subtitle'>Actualizar stock</h2>";
        echo "<form action='productos.php?id_producto=$idProducto&id_tienda=$idTienda' method='post'>";
        echo "<div class='field'>";
        echo "<label class='label' for='nueva_cantidad'>Nueva cantidad:</label>";
        echo "<div class='control'>";
        echo "<input class='input' type='number' name='nueva_cantidad' id='nueva_cantidad' required>";
        echo "</div>";
        echo "</div>";
        echo "<button class='button is-primary' type='submit' name='actualizar_stock'>Actualizar stock</button>";
        echo "</form>";

        // Resto del contenido de la página
        echo "<p>ID: " . $producto['id_producto'] . "</p>";
        echo "<p>ID Tienda: " . $idTienda . "</p>";

        // ... mostrar más detalles o realizar otras operaciones
    } else {
        echo "No se encontró el producto con el ID especificado.";
    }
} else {
    echo "No se especificó un ID de producto válido.";
}

// Verificar si se envió el formulario para crear oferta
if (isset($_POST['crear_oferta'])) {
    // Obtener los datos del formulario
    $nuevoPrecio = $_POST['nuevo_precio'];

    // Llamar a la función de actualización de oferta
    $query = "CALL actualizar_oferta(:producto_id, :nuevo_precio, :tienda_id, 'mensaje_salida')";
    echo "<script>console.log('aqui');</script>";
    echo "<script>console.log('$idProducto');</script>";
    echo "<script>console.log('$idTienda');</script>";
    echo "<script>console.log('chuplalo');</script>";
    $statement = $db2->prepare($query);
    echo "<script>console.log('aqui1/2');</script>";
    $statement->bindParam(':producto_id', $idProducto, PDO::PARAM_INT);
    $statement->bindParam(':nuevo_precio', $nuevoPrecio, PDO::PARAM_INT);
    $statement->bindParam(':tienda_id', $idTienda, PDO::PARAM_INT);
    $statement->execute();
    echo "<script>console.log('aqui2');</script>";
    $resultado = $statement->fetch(PDO::FETCH_ASSOC);
    echo "<script>console.log('aqui3');</script>";
    // Imprimir el mensaje de resultado
    echo $resultado['mensaje'];
}

// Verificar si se envió el formulario para actualizar stock
if (isset($_POST['actualizar_stock'])) {
    // Obtener los datos del formulario
    $nuevaCantidad = $_POST['nueva_cantidad'];

    // Llamar a la función de actualización de stock
    $query = "CALL actualizar_stock(:producto_id, :nueva_cantidad, :tienda_id, 'mensaje_salida')";
    $statement = $db2->prepare($query);
    $statement->bindParam(':producto_id', $idProducto, PDO::PARAM_INT);
    $statement->bindParam(':nueva_cantidad', $nuevaCantidad, PDO::PARAM_INT);
    $statement->bindParam(':tienda_id', $idTienda, PDO::PARAM_INT);
    $statement->execute();
    $resultado = $statement->fetch(PDO::FETCH_ASSOC);

    // Imprimir el mensaje de resultado
    echo $resultado['mensaje'];
}

// Incluir el archivo de encabezado (en caso de que no se haya incluido anteriormente)
if (empty($producto)) {
    include '../templates/header.html';
}
?>
