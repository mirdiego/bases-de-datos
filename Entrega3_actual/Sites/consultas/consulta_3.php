<?php include('../templates/header.html'); ?>

<body>
  <?php
  require("../config/conexion.php");

  $id = $_POST["id"];
  if (empty($id)) {
    echo "El ID ingresado es vacío. Por favor, ingrese un ID válido.";
  } else {
    $query = "SELECT SUM(p.num_cajas * co.cantidad) AS total_cajas
              FROM compras co
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
          <th>Total cajas</th>
        </tr>

        <?php
        foreach ($dataCollected as $p) {
          echo "<tr><td>$p[0]</td></tr>";
        }
        ?>

      </table>

    <?php
    }
  }

  include('../templates/footer.html');
  ?>
