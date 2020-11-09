<?php
include("php/conexion.php");
include 'carrito.php';
$cart = new Cart;
$paginaActivo='index';
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Grid Template for Bootstrap</title>
    <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/grid/">

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="assets/css/sstyle.css" rel="stylesheet" />
    <link href="assets/css/font-awesome.min.css" rel="stylesheet" />
    <!-- Custom styles for this template -->
    <link href="grid.css" rel="stylesheet">
  </head>

<body>

<?php include_once('nav.php'); ?>

<header>
<div class="container">
  <h1>Header</h1>
</div>
</header>


<div class="container">
  <section class="main row">
    <article class="col-xs-12 col-sm-8 col-md-9">
      <h3>Articulo</h3>
      <p>
        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
      </p>
    </article>
    <aside class="col-xs-12 col-sm-4 col-md-3">
      <h3>Aside</h3>
      <p>
        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
        Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
      </p>
    </aside>
  </section>


  <div class="row">
    <div class="btn-group alg-right-pad">
      <button type="button" class="btn btn-default"><strong>1235  </strong>items</button>
      <div class="btn-group">
        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
          Ordenar Por&nbsp;
          <span class="caret"></span>
        </button>
        <ul class="dropdown-menu">
          <li><a href="#" id="por_menor_precio">Menor Precio</a></li>
          <li class="divider"></li>
          <li><a href="#" id="por_mayor_precio">Mayor Precio</a></li>
        </ul>
      </div>
    </div>
  </div>

<div class="row">
  <div class="col-xs-12">

  </div>
</div>

  <div id="resultado">

  </div>

</div>

</div>

<?php include 'footer.php'; ?>


<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

<script src="assets/js/jquery-3.5.1.min.js"></script>

<script>

$('document').ready(function() {
  load(1);
});


function load(page){
//  var query=$("#q").val();
var ordenar_por="<?php echo (isset($_SESSION['order']))?$_SESSION['order']:'';?>";
$('#por_menor_precio').click(function () {
   ordenar_por='menor_precio';
   var per_page=4;
   var query="";
   var parametros = {"action":"ajax","page":page,'query':ordenar_por,'per_page':per_page};
   $.ajax({
     url:'ajax/promociones_listar.php',
     data: parametros,
     beforeSend: function(objeto){
       //$("#loader").html("Cargando...");
     },
     success:function(data){
       $("#resultado").html(data).fadeIn('slow');

     }
   });
});

$('#por_mayor_precio').click(function () {
  ordenar_por='mayor_precio';
  var per_page=4;
  var query="";
  var parametros = {"action":"ajax","page":page,'query':ordenar_por,'per_page':per_page};
  $.ajax({
    url:'ajax/promociones_listar.php',
    data: parametros,
    beforeSend: function(objeto){
      //$("#loader").html("Cargando...");
    },
    success:function(data){
      $("#resultado").html(data).fadeIn('slow');

    }
  });
});

  var per_page=4;
  var query="";
  var parametros = {"action":"ajax","page":page,'query':ordenar_por,'per_page':per_page};
  $.ajax({
    url:'ajax/promociones_listar.php',
    data: parametros,
    beforeSend: function(objeto){
      //$("#loader").html("Cargando...");
    },
    success:function(data){
      $("#resultado").html(data).fadeIn('slow');
    }
  })
}



/*
$(document).ready(function() {
  var parametros = {"action":"ajax"};
  $.ajax({
    url:'ajax/promociones_listar.php',
    data: parametros,
    beforeSend: function(objeto){
      //$("#loader").html("Cargando...");
    },
    success:function(data){
      $("#resultado").html(data).fadeIn('slow');

    }
  });
});*/




</script>



</body>
</html>
