<?php include('templates/header.html');   ?>

<body> 
  <h1 align="center">Mercado Libre </h1>
  <p style="text-align:center;">Toda la información de los pedidos!!!.</p>

  <br>

  <h3 align="center"> ¿Quieres seaber que clientes recibiran pedidos en una fecha y donde viven?</h3>

  <form align="center" action="Sites/consultas/nombre_direccion.php" method="post">
    Fecha:
    <input type="text" name="fecha">
    <br/>
    <br/>
    <input type="submit" value="Buscar">
  </form>
  
  <br>
  <br>
  <br>

  <h3 align="center"> ¿Quieres buscar quien realizó la compra del id ingresado y donde vive?</h3>

  <form align="center" action="consultas/consulta_stats.php" method="post">
    Id:
    <input type="text" name="id_elegido">
    <br>
    <br>
    <input type="submit" value="Buscar">
  </form>
  
  <br>
  <br>
  <br>

  <h3 align="center"> ¿Quieres saber cuantas cajas utilizará una compra ?</h3>

  <form align="center" action="consultas/nombre_direccion.php" method="post">
    Ingresa el id de compra:
    <input type="text" name="id">
    <br/>
    <br/>
    <input type="submit" value="Buscar">
  </form>
  <br>
  <br>
  <br>
  <h3 align="center"> ¿Quieres saber cuanto pesará un vehiculo en álguna fecha?</h3>

  <form align="center" action="consultas/consulta_tipo_nombre.php" method="post">
    seleccione la patente del vehículo:
    <input type="text" name="patente">
    <br/>
    seleccione la fecha:
    <input type="text" name="fecha">
    <br/><br/>
    <input type="submit" value="Buscar">
</form>
  <br>
  <br>
  <br>
  <h3 align="center"> ¿Quieres saber que repartidores trabajan en una región y su edad promedio?</h3>

  <form align="center" action="consultas/consulta_tipo_nombre.php" method="post">
    seleccione la región:
    <input type="text" name="región">
    <br/>
    <br/>
    <input type="submit" value="Buscar">
  </form>
  <br>
  <br>
  <br>
  <h3 align="center"> ¿Quieres saber que compra ha hecho un cliente?</h3>

  <form align="center" action="consultas/consulta_tipo_nombre.php" method="post">
    ingrese id de cliente:
    <input type="text" name="id_cliente">
    <br/>
    <br/>
    <input type="submit" value="Buscar">
  </form>
  <h3 align="center">¿Quieres saber quienes gastaron más plata en una región?</h3>
  
  <form align="center" action="consultas/consulta_tipo_nombre.php" method="post">
    ingrese region:
    <input type="text" name="region">
    <br/>
    <br/>
    <input type="submit" value="Buscar">
  </form>
  <?php
  #Primero obtenemos todos los tipos de pokemones
  require("config/conexion.php");
  $result = $db -> prepare("SELECT DISTINCT tipo FROM pokemones;");
  $result -> execute();
  $dataCollected = $result -> fetchAll();
  ?>

  <form align="center" action="consultas/consulta_tipo.php" method="post">
    Seleccinar un tipo:
    <select name="tipo">
      <?php
      #Para cada tipo agregamos el tag <option value=value_of_param> visible_value </option>
      foreach ($dataCollected as $d) {
        echo "<option value=$d[0]>$d[0]</option>";
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
