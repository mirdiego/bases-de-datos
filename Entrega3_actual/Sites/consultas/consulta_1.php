<?php include('../templates/header.html'); ?>

<body>
<?php
  require("../config/conexion.php"); # Llama a conexión, crea el objeto PDO y obtiene la variable $db

  $fecha = $_POST["fecha"];

  if (empty($fecha)) {
    echo "La fecha ingresada es vacía. Por favor, ingrese una fecha válida.";
  } else {
    $query = "SELECT c.nombre, c.calle, c.numero_domicilio, c.comuna, c.region
              FROM despachos d
              JOIN compras co ON d.id_compra = co.id_compra
              JOIN clientes c ON co.id_cliente = c.id
              WHERE d.fecha_entrega = :fecha";

    $result = $db->prepare($query);
    $result->bindParam(':fecha', $fecha);
    $result->execute();
    $cliente_direccion = $result->fetchAll();

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
        </tr>

        <?php
        foreach ($cliente_direccion as $p) {
          echo "<tr><td>$p[0]</td><td>$p[1]</td><td>$p[2]</td><td>$p[3]</td><td>$p[4]</td></tr>";
        }
        ?>
      </table>
      <?php
    }
  }

  include('../templates/footer.html');
?>
