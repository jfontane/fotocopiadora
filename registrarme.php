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
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<body>

  <?php
  include('nav.php');
  ?>

  <span class="material-icons">
games
</span>

  <div class="container">

    <div class="row">
            <div class="col-lg-12">
                                    <div class="card bg-light mb-12">
                        <div class="card-header">Registro</div>


                        <div class="card-body">

                            <form>


                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="inputEmail4">Email</label>
                                        <input type="email" class="form-control" id="inputEmail4" placeholder="Email">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputPassword4">Password</label>
                                        <input type="password" class="form-control" id="inputPassword4"
                                               placeholder="Password">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputAddress">Address</label>
                                    <input type="text" class="form-control" id="inputAddress"
                                           placeholder="1234 Main St">
                                </div>
                                <div class="form-group">
                                    <label for="inputAddress2">Address 2</label>
                                    <input type="text" class="form-control" id="inputAddress2"
                                           placeholder="Apartment, studio, or floor">
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="inputCity">City</label>
                                        <input type="text" class="form-control" id="inputCity">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="inputState">State</label>
                                        <select id="inputState" class="form-control">
                                            <option selected>Choose...</option>
                                            <option>...</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="inputZip">Zip</label>
                                        <input type="text" class="form-control" id="inputZip">
                                    </div>
                                </div>


                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="checkbox"> Check me out
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <button type="submit" class="btn btn-primary">Aceptar</button>
                                </div>

                            </form>
                        </div>

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
