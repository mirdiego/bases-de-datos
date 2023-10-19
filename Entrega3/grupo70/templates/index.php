<?php include('templates/header.html');   ?>

<body> 
  <h1 align="center">Mercado Libre </h1>
  <p style="text-align:center;">Toda la información de los pedidos!!!.</p>

  <br>

  <h3 align="center"> ¿Quieres saber qué clientes recibirán pedidos en una fecha y dónde viven?</h3>

  <form align="center" action="consultas/consulta_1.php" method="post">
    Fecha:
    <input type="date" name="fecha">
    <br/>
    <br/>
    <input type="submit" value="Buscar">
  </form>
  
  <br>
  <br>
  <br>

  <h3 align="center"> ¿Quieres buscar quién realizó la compra del ID ingresado y dónde vive?</h3>

  <form align="center" action="consultas/consulta_2.php" method="post">
    ID:
    <input type="text" name="id">
    <br>
    <br>
    <input type="submit" value="Buscar">
  </form>
  
  <br>
  <br>
  <br>

  <h3 align="center"> ¿Quieres saber cuántas cajas se utilizarán en una compra?</h3>

  <form align="center" action="consultas/consulta_3.php" method="post">
    Ingresa el ID de compra:
    <input type="text" name="id">
    <br/>
    <br/>
    <input type="submit" value="Buscar">
  </form>
  
  <br>
  <br>
  <br>
  
  <h3 align="center"> ¿Quieres saber cuánto pesará un vehículo en alguna fecha?</h3>

  <form align="center" action="consultas/consulta_4.php" method="post">
    Selecciona la patente del vehículo:
    <input type="text" name="patente">
    <br/>
    Selecciona la fecha:
    <input type="date" name="fecha">
    <br/><br/>
    <input type="submit" value="Buscar">
  </form>
  
  <br>
  <br>
  <br>
  
  <h3 align="center"> ¿Quieres saber qué repartidores trabajan en una región y cuál es su edad promedio?</h3>

  <form align="center" action="consultas/consulta_5.php" method="post">
    Selecciona la región:
    <select name="region">
      <?php
      require("../config/conexion.php");

      $query = "SELECT DISTINCT region FROM comuna_region";
      $result = $db->query($query);

      while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $region = $row['region'];
        echo "<option value='$region'>$region</option>";
      }
      ?>
    </select>
    <br/>
    <br/>
    <input type="submit" value="Buscar">
  </form>
  
  <br>
  <br>
  <br>
  
  <h3 align="center"> ¿Quieres saber qué compra ha hecho un cliente?</h3>

  <form align="center" action="consultas/consulta_6.php" method="post">
    Ingresa el ID del cliente:
    <input type="text" name="id_cliente">
    <br/>
    <br/>
    <input type="submit" value="Buscar">
  </form>
  
  <h3 align="center">¿Quieres saber quiénes gastaron más dinero en una región?</h3>
  
  <form align="center" action="consultas/consulta_7.php" method="post">
    Ingresa la región:
    <input type="text" name="region">
    <br/>
    <br/>
    <input type="submit" value="Buscar">
  </form>

  <?php
  # Primero obtenemos todos los tipos de pokemones
  require("config/conexion.php");
  $result = $db->prepare("SELECT DISTINCT tipo FROM pokemones;");
  $result->execute();
  $dataCollected = $result->fetchAll();
  ?>

  <form align="center" action="consultas/consulta_tipo.php" method="post">
    Selecciona un tipo:
    <select name="tipo">
      <?php
      # Para cada tipo agregamos el tag <option value=value_of_param> visible_value </option>
      foreach ($dataCollected as $d) {
        echo "<option value='{$d['tipo']}'>{$d['tipo']}</option>";
      }
      ?>
    </select>
    <br><br>
    <input type="submit" value="Buscar por tipo">
  </form>

  <br>
  <br>
  <br>
  <br>
</body>
</html>
