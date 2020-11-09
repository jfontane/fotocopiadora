<?php
include 'php/conexion.php';
include 'carrito.php';
$cart = new Cart;
$paginaActivo='catalogo';
?>
<!DOCTYPE html>
<html lang="en">

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

  <!-- Bootstrap core CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <!-- Fontawesome core CSS -->
  <link href="assets/css/font-awesome.min.css" rel="stylesheet" />
  <!--GOOGLE FONT -->
  <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
  <!-- custom CSS here -->
  <link href="assets/css/sstyle.css" rel="stylesheet" />
  <link href="grid.css" rel="stylesheet">

</head>

<body>

  <!-- Navigation -->
  <?php include 'nav.php'; ?>
  <!-- Header -->
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="index.php">Home</a></li>
      <li class="breadcrumb-item active" aria-current="page">Catalogo</li>
    </ol>
  </nav>

  <div class="container">
    <div class="row">
      <div class="col-md-8 mb-5">
        <h2>Catalogo de Articulos</h2>
        <hr>
        <div id="custom-search-input">
          <div class="input-group col-md-12">
            <input type="text" class="form-control" placeholder="Buscar"  id="q" onkeyup="load(1);" />
            <span class="input-group-btn">
              <button class="btn btn-info" type="button" onclick="load(1);">
                <i class="fa fa-search"></i>
              </button>
            </span>
          </div>
        </div>
      </div>
      <div class="col-md-4 mb-5">
      </div>
    </div>
    <!-- /.row -->

    <!-- Page Content -->

    <!-- /.row -->
    <div id="loader"></div><!-- Carga de datos ajax aqui -->
    <div id="resultados"></div><!-- Carga de datos ajax aqui -->
    <div class='outer_div'></div><!-- Carga de datos ajax aqui -->
    <!-- /.row -->
  </div>
  <!-- /.container -->

  <!-- Footer -->
  <?php include 'footer.php'; ?>
  <!--Footer end -->

  <!--Core JavaScript file  -->
  <script src="assets/js/jquery-3.5.1.min.js"></script>
  <!--bootstrap JavaScript file  -->
  <script src="assets/js/bootstrap.js"></script>
  <!--Slider JavaScript file  -->
  <script src="assets/ItemSlider/js/modernizr.custom.63321.js"></script>
  <script src="assets/ItemSlider/js/jquery.catslider.js"></script>

  <!-- ********************************************************************************* -->
  <!-- ************ JAVASCRIPT ********************************************************* -->
  <!-- ********************************************************************************* -->

  <?php include 'scriptJs.php'; ?>

  <script>
  $(function() {
    load(1);
  });

  function load(page){
    var query=$("#q").val();
    var per_page=30;
    var parametros = {"action":"ajax","page":page,'query':query,'per_page':per_page};
    $("#loader").fadeIn('slow');
    $.ajax({
      url:'ajax/productos_listar.php',
      data: parametros,
      beforeSend: function(objeto){
        $("#loader").html("Cargando...");
      },
      success:function(data){
        $(".outer_div").html(data).fadeIn('slow');
        $("#loader").html("");
      }
    })
  }


</script>
</body>

</html>
