<?php include('../templates/header.html'); ?>

<body>

  <?php
  require("../config/conexion.php");

  $id = $_POST["id"];
  $query = "SELECT cl.nombre, cl.calle, cl.numero_domicilio, cl.comuna, cl.region, p.precio * co.cantidad AS valor_compra 
            FROM compras co 
            JOIN clientes cl ON co.id_cliente = cl.id 
            JOIN productos p ON co.id_producto = p.id 
            WHERE co.id_compra = :id";

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
        <th>Nombre</th>
        <th>Calle</th>
        <th>Numero domicilio</th>
        <th>Comuna</th>
        <th>Region</th>
        <th>Valor compra</th>
      </tr>
      
      <?php
      foreach ($dataCollected as $p) {
        echo "<tr><td>$p[0]</td><td>$p[1]</td><td>$p[2]</td><td>$p[3]</td><td>$p[4]</td><td>$p[5]</td></tr>";
      }
      ?>
      
    </table>

  <?php
  }

  include('../templates/footer.html');
  ?>

