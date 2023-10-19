<?php include('../templates/header.html');   ?>

<body>
<?php
  #Llama a conexión, crea el objeto PDO y obtiene la variable $db
  require("../config/conexion.php");

  #Se obtiene el valor del input del usuario
  $fecha = $_POST["fecha"];
  $fecha = intval($fecha);
  #Se construye la consulta como un string
 	$query = "SELECT c.nombre, c.calle, c.numero_domicilio, c.comuna, c.region FROM despachos d JOIN compras co ON d.id_compra = co.id_compra JOIN clientes c ON co.id_cliente = c.id WHERE fecha = '$fecha';";
echo $query;

  #Se prepara y ejecuta la consulta. Se obtienen TODOS los resultados
	$result = $db -> prepare($query);
	$result -> execute();
	$cliente_direccion = $result -> fetchAll();
  ?>

  <table>
    <tr>
      <th>nombre</th>
      <th>direccion</th>
    </tr>
  
      <?php
        // echo $pokemones;
        foreach ($cliente_direccion as $p) {
          echo "<tr><td>$p[0]</td><td>$p[1]</td><td>";
      }
      ?>
      
  </table>

<?php include('../templates/footer.html'); ?>
