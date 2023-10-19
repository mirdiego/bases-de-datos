<?php
  include('../templates/header.html');

  # Incluir el archivo de conexión a la base de datos
  require("../config/conexion.php");
  
  $region = $_POST['region'];

  
	$query = "SELECT co.id_cliente, cl.nombre, cl.rut, cl.calle, cl.numero_domicilio, cl.comuna, cl.region, SUM(p.precio * co.cantidad) AS total_gastado
	  FROM compras co
	  JOIN productos p ON co.id_producto = p.id
	  JOIN clientes cl ON co.id_cliente = cl.id
	  WHERE cl.region = :region
	  GROUP BY co.id_cliente, cl.nombre, cl.rut, cl.calle, cl.numero_domicilio, cl.comuna, cl.region
	  ORDER BY total_gastado DESC
	  LIMIT 5";
  
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
		  <th>ID Cliente</th>
		  <th>Nombre</th>
		  <th>RUT</th>
		  <th>Calle</th>
		  <th>Número Domicilio</th>
		  <th>Comuna</th>
		  <th>Región</th>
		  <th>Total Gastado</th>
		</tr>
  
		<?php
		foreach ($dataCollected as $row) {
		  echo "<tr><td>{$row['id_cliente']}</td><td>{$row['nombre']}</td><td>{$row['rut']}</td><td>{$row['calle']}</td><td>{$row['numero_domicilio']}</td><td>{$row['comuna']}</td><td>{$row['region']}</td><td>{$row['total_gastado']}</td></tr>";
		}
		?>
	  </table>
  <?php
	}
  
	include('templates/footer.html');
  ?>
  