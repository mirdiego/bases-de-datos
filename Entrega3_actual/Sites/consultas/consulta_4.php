<?php
  # Incluir el archivo de encabezado
  include('../templates/header.html');

  # Incluir el archivo de conexión a la base de datos
  require("../config/conexion.php");

  # Obtener los valores de los inputs del usuario
  $fecha_entrega = $_POST["input_fecha"];
  $patente = $_POST["input_patente"];

  # Construir la consulta como un string
  if (empty($fecha_entrega) || empty($patente)) {
    echo "La fecha de entrega o la patente están vacías. Por favor, ingrese valores válidos.";
  } else {
    $query = "SELECT SUM(c.peso) AS peso_total
              FROM despachos d
              JOIN compras co ON d.id_compra = co.id_compra
              JOIN cajas c ON co.id = c.id_producto
              JOIN vehiculos v ON d.id_vehiculo = v.id
              WHERE d.fecha_entrega = :fecha_entrega
              AND v.patente = :patente";

    # Preparar y ejecutar la consulta
    $result = $db->prepare($query);
    $result->bindParam(':fecha_entrega', $fecha_entrega);
    $result->bindParam(':patente', $patente);
    $result->execute();
    $dataCollected = $result->fetchAll();

    # Verificar si la consulta no devuelve resultados
    if ($result->rowCount() === 0) {
      echo "No se encontraron resultados.";
    } else {
      ?>

      <table>
        <tr>
          <th>Peso Total</th>
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

  # Incluir el archivo de pie de página
  include('../templates/footer.html');
?>
