<?php
  include('../templates/header.html');

  # Incluir el archivo de conexión a la base de datos
  require("../config/conexion.php");

$id = $_POST['id'];

if (empty($id)) {
  echo "El ID ingresado es vacío. Por favor, ingrese un ID válido.";
} else {

  $query = "SELECT co.id_compra, COUNT(co.id_producto) AS numero_productos, SUM(p.num_cajas) AS numero_cajas
	FROM compras co
	JOIN productos p ON co.id_producto = p.id
	WHERE co.id_cliente = :id
	GROUP BY co.id_compra";

  $result = $db->prepare($query);
  $result->bindParam(':id', $id);
  $result->execute();
  $dataCollected = $result->fetchAll();

  if ($result->rowCount() === 0) {
    echo "No se encontraron resultados.";
  } else {
?>
	<table>
	  <tr>
	    <th>ID Compra</th>
	    <th>Número de Productos</th>
	    <th>Número de Cajas</th>
	  </tr>
	  
	  <?php
	  foreach ($dataCollected as $row) {
	    echo "<tr><td>{$row['id_compra']}</td><td>{$row['numero_productos']}</td><td>{$row['numero_cajas']}</td></tr>";
	  }
	  ?>
	</table>
<?php
  }
}

include('templates/footer.html');
?>

