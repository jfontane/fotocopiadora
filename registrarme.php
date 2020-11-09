<?php
include("php/conexion.php");
include 'carrito.php';
$cart = new Cart;
$paginaActivo='registrarme';
?>

<!DOCTYPE html>
<html lang="es">
<head><meta http-equiv="Content-Type" content="text/html; charset=euc-jp">
  <title>El Original Online</title>
  <!-- Bootstrap core CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link href="assets/css/sstyle.css" rel="stylesheet" />
  <link href="assets/css/font-awesome.min.css" rel="stylesheet" />
  <!-- Custom styles for this template -->
  <link href="grid.css" rel="stylesheet"></head>
<body>

  <?php
  include('nav.php');
  ?>

  <div class="container">
    <div class="row justify-content-md-center">
      <div class="col">
        <div class="modal-dialog">
          <div class="modal-content">

            <form name="cliente_agregar" id="cliente_agregar" action="cliente_agregar.php" method="post" enctype="multipart/form-data">
              <div class="modal-header">
                <h4 class="modal-title">Registrarme</h4>
              </div>

              <div class="modal-body" id="idcuerpo">
                <fieldset>
                  <legend>Datos de la Cuenta de Usuario:</legend>
                  <div class="form-group">
                    <label>Email <font color="red"><b>(Obligatorio)</b></font></label>
                    <input type="email" name="email" id="email" class="form-control" maxlength="60" required>
                  </div>
                  <div class="form-group">
                    <label>Contraseña <font color="red"><b>(Obligatorio)</b></font></label>
                    <input type="text" name="password" id="password" class="form-control" maxlength="20" required>
                  </div>
                  <div class="form-group">
                    <label>Repetir Contraseña <font color="red"><b>(Obligatorio)</b></font></label>
                    <input type="text" name="password2" id="password2" class="form-control" maxlength="20" required>
                  </div>
                </fieldset>
                <fieldset>
                  <legend>Datos Personales</legend>
                  <div class="form-group">
                    <label>Apellido <font color="red"><b>(Obligatorio)</b></font></label>
                    <input type="text" name="apellido" id="apellido" class="form-control" maxlength="35" required>
                  </div>
                  <div class="form-group">
                    <label>Nombre <font color="red"><b>(Obligatorio)</b></font></label>
                    <input type="text" name="nombre" id="nombre" class="form-control" maxlength="35" required>
                  </div>
                  <div class="form-group">
                    <label>DNI <font color="red"><b>(Obligatorio)</b></font></label>
                    <input type="text" name="dni" id="dni" maxlength="8" class="form-control">
                  </div>
                </fieldset>
                <fieldset>
                  <legend>Datos Personales:</legend>
                  <div class="form-group">
                    <label>Telefono</label>
                    <input type="text" name="telefono" id="telefono" class="form-control" maxlength="25">
                  </div>
                  <div class="form-group">
                    <label>Direccion</label>
                    <input type="text" name="direccion" id="direccion" class="form-control" maxlength="50">
                  </div>
                </fieldset>
              </div>
              <div class="modal-footer">
                <input type="submit" class="btn btn-success" value="Guardar datos">
              </div>
            </form>

          </div>
        </div>
      </div>
    </div>

    <br>
    <div id="resultado" class="text-center"></div>
    <div class="outer_div"></div><!-- Datos ajax Final -->


  </div><!-- Cierra Container-->



  <?php
  include('footer.php');
  ?>

  <!-- ********************************************************************************* -->
  <!-- ************ JAVASCRIPT ********************************************************* -->
  <!-- ********************************************************************************* -->

  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


  <script>

  $(document).ready(function() {
    $( "#cliente_agregar" ).submit(function( event ) {
      var parametros = $(this).serialize();
      $.ajax({
        type: "POST",
        url: "ajax/cliente_guardar.php",
        data: parametros,
        beforeSend: function(objeto){
          $("#resultados").html("<center><img src='img/ajax-loader.gif'></center>");
        },
        success: function(datos){
          if (datos=="ok") console.log("siiiiiiiiiiii ok")
          $(location).attr("href","index.php");
          //$("#idcuerpo").html(datos);
        }
      });
      event.preventDefault();
    });
  });

  </script>
</body>
</html>
