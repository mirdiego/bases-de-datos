<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin</title>
  <link rel="stylesheet" href="../css/styles.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
  <?php
  session_start();
  $admin = $_SESSION["user"];
  if (is_null($admin)) {
    header("Location: ../index.php");
    exit();
  }

  require("../config/conexion.php");

  // Obtener las regiones de la tabla "comuna_region"
  $query = "SELECT DISTINCT region FROM comuna_region ORDER BY region ASC";
  $result = $db1->prepare($query);
  $result->execute();
  $regiones = $result->fetchAll(PDO::FETCH_COLUMN);

  include('../templates/header.html');
  ?>

  <h1 class="title">ADMIN</h1>

  <div class="field has-text-centered">
    <label class="label is-size-4" for="region">Región:</label>
    <div class="control">
      <div class="select is-large">
        <select name="region" id="region" class="is-size-5">
          <option value="">Seleccionar región</option>
          <?php foreach ($regiones as $region) { ?>
            <option value="<?php echo $region; ?>"><?php echo $region; ?></option>
          <?php } ?>
        </select>
      </div>
    </div>
  </div>

  <div id="tiendasDropdown" class="field has-text-centered" style="display: none;">
    <label class="label is-size-4" for="tienda">Tienda:</label>
    <div class="control">
      <div class="select is-large">
        <select name="tienda" id="tienda" class="is-size-5">
          <option value="">Seleccionar tienda</option>
        </select>
      </div>
    </div>
  </div>

  <div id="categoriasDropdown" class="field has-text-centered" style="display: none;">
    <label class="label is-size-4" for="categoria">Categoría:</label>
    <div class="control">
      <div class="select is-large">
        <select name="categoria" id="categoria" class="is-size-5">
          <option value="">Seleccionar categoría</option>
        </select>
      </div>
    </div>
  </div>

  <div id="productosTable" style="display: none;">
    <table class="table is-fullwidth">
      <thead>
        <tr>
          <th>Nombre</th>
          <th>Cantidad</th>
          <th>Descuento</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody id="productosTableBody">
        <!-- Aquí se agregarán las filas de la tabla de productos -->
      </tbody>
    </table>
  </div>

  <script>
    $(document).ready(function() {
      // Obtener la referencia al elemento de selección de región
      var regionSelect = $("#region");

      // Agregar un evento de cambio al elemento de selección de región
      regionSelect.on("change", function() {
        // Obtener el valor seleccionado de la región
        var region = $(this).val();

        // Hacer una solicitud AJAX al servidor para obtener los IDs de las tiendas
        $.ajax({
          url: "../funciones/admin_funcion.php",
          data: { region: region },
          dataType: "json",
          success: function(response) {
            // Procesar la respuesta del servidor
            var tiendasDropdown = $("#tiendasDropdown");
            var tiendaSelect = $("#tienda");

            // Limpiar las opciones actuales del dropdown de tiendas
            tiendaSelect.html("<option value=''>Seleccionar tienda</option>");

            // Agregar las nuevas opciones al dropdown de tiendas
            for (var i = 0; i < response.length; i++) {
              var tienda = response[i]["id_tienda"];
              var option = $("<option>").val(tienda).text(tienda);
              tiendaSelect.append(option);
            }

            // Mostrar el dropdown de tiendas si hay tiendas disponibles
            tiendasDropdown.css("display", response.length > 0 ? "block" : "none");

            // Limpiar y ocultar el dropdown de categorías
            var categoriasDropdown = $("#categoriasDropdown");
            var categoriaSelect = $("#categoria");
            categoriaSelect.html("<option value=''>Seleccionar categoría</option>");
            categoriasDropdown.css("display", "none");

            // Ocultar la tabla de productos
            var productosTable = $("#productosTable");
            productosTable.css("display", "none");
          },
          error: function(xhr, status, error) {
            console.error(xhr.responseText);
          }
        });
      });

      // Obtener la referencia al elemento de selección de tienda
      var tiendaSelect = $("#tienda");

      // Agregar un evento de cambio al elemento de selección de tienda
      tiendaSelect.on("change", function() {
        // Obtener el valor seleccionado de la tienda
        var idTienda = $(this).val();

        // Hacer una solicitud AJAX al servidor para obtener las categorías de productos
        $.ajax({
          url: "../funciones/admin_funcion.php",
          data: { id_tienda: idTienda },
          dataType: "json",
          success: function(response) {
            // Procesar la respuesta del servidor
            var categoriasDropdown = $("#categoriasDropdown");
            var categoriaSelect = $("#categoria");

            // Limpiar las opciones actuales del dropdown de categorías
            categoriaSelect.html("<option value=''>Seleccionar categoría</option>");

            // Agregar las nuevas opciones al dropdown de categorías
            for (var i = 0; i < response.length; i++) {
              var categoria = response[i];
              var option = $("<option>").val(categoria).text(categoria);
              categoriaSelect.append(option);
            }

            // Mostrar el dropdown de categorías si hay categorías disponibles
            categoriasDropdown.css("display", response.length > 0 ? "block" : "none");

            // Ocultar la tabla de productos
            var productosTable = $("#productosTable");
            productosTable.css("display", "none");
          },
          error: function(xhr, status, error) {
            console.error(xhr.responseText);
          }
        });
      });

      // Obtener la referencia al elemento de selección de categoría
      var categoriaSelect = $("#categoria");

      // Agregar un evento de cambio al elemento de selección de categoría
      categoriaSelect.on("change", function() {
        // Obtener el valor seleccionado de la categoría
        var categoria = $(this).val();

        // Obtener el valor seleccionado de la tienda
        var idTienda = $("#tienda").val();

        // Hacer una solicitud AJAX al servidor para obtener los productos
        $.ajax({
          url: "../funciones/admin_funcion.php",
          data: { id_tienda: idTienda, categoria: categoria },
          dataType: "json",
          success: function(response) {
            // Procesar la respuesta del servidor
            var productosTable = $("#productosTable");
            var productosTableBody = $("#productosTableBody");

            // Limpiar las filas actuales de la tabla de productos
            productosTableBody.empty();

            // Agregar las nuevas filas a la tabla de productos
            for (var i = 0; i < response.length; i++) {
              var producto = response[i];
              var row = $("<tr>");
              row.append($("<td>").text(producto.nombre));
              row.append($("<td>").text(producto.cantidad));
              row.append($("<td>").text(producto.descuento));

              // Crear el botón de acciones
              var accionesButton = $("<button>").text("Ver detalles");
              accionesButton.attr("data-producto-id", producto.id);
              accionesButton.addClass("acciones-button");

              // Agregar el evento click al botón de acciones
              accionesButton.on("click", function() {
                var productoId = producto.id_producto
                var productoIdTienda = producto.id_tienda
                window.location.href = "productos.php?id_producto=" + productoId +"&id_tienda=" + productoIdTienda ;
              });
              // Agregar el botón de acciones a la fila
              row.append($("<td>").append(accionesButton));
              
              productosTableBody.append(row);
            }

            // Mostrar la tabla de productos
            productosTable.css("display", "block");
          },
          error: function(xhr, status, error) {
            console.error(xhr.responseText);
          }
        });
      });
    });
    // Obtener el ID del producto desde la URL
    // Obtener el ID del producto desde la URL
    function getUrlParameter(name) {
      name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
      var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
      var results = regex.exec(location.search);
      return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
    }

    // Obtener el ID del producto desde la URL
    var productId = getUrlParameter('id');

    // Si hay un ID de producto en la URL, seleccionarlo automáticamente en la lista de productos
    if (productId !== '') {
      $('#producto').val(productId).trigger('change');
    }

    // Modificar la función de redireccionamiento para obtener el ID del producto
    function redirectToProduct() {
      var productoId = $('#producto').val();
      if (productoId !== '') {
        window.location.href = "productos.php?id=" + productoId;
      }
    }
  </script>
</body>
</html>



