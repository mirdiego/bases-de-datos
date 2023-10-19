<?php
  include('../templates/header.html');

  # Incluir el archivo de conexión a la base de datos
  require("../config/conexion.php");

$region = $_POST['region'];

$query = "SELECT cl.region, r.genero, COUNT(r.id) AS total_repartidores, AVG(r.edad) AS edad_promedio
    FROM repartidores r
    JOIN vehiculos v ON r.id_vehiculo = v.id
    JOIN despachos d ON r.id = d.id_repartidor
    JOIN compras co ON d.id_compra = co.id_compra
    JOIN clientes cl ON co.id_cliente = cl.id
    WHERE cl.region = :region
    GROUP BY r.genero";

$result = $db->prepare($query);
$result->bindParam(':region', $region);
$result->execute();
$dataCollected = $result->fetchAll();

if ($result->rowCount() === 0) {
	echo "No se encontraron resultados.";
} else {
?>
	<table>
	  <tr>
	    <th>Género</th>
	    <th>Total Repartidores</th>
	    <th>Edad Promedio</th>
	  </tr>
	  
	  <?php
	  foreach ($dataCollected as $row) {
	    echo "<tr><td>{$row['genero']}</td><td>{$row['total_repartidores']}</td><td>{$row['edad_promedio']}</td></tr>";
	  }
	  ?>
	</table>
<?php
}

include('templates/footer.html');
?>
