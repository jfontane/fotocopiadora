<?php
$usuario=(!isset($_SESSION['usuario'])||($_SESSION['usuario']==""))?NULL:$_SESSION['usuario'];
$styleUsuario="";
$foto="";
$styleLogin="";
if ($usuario!="") {
  $foto=$_SESSION['foto'];
  $styleUsuario='';
  $styleLogin=' style="display:none" ';
  $stylePedidosPendientes='';
} else {
  $styleUsuario=' style="display:none" ';
  $styleLogin='';
  $stylePedidosPendientes=' style="display:none" ';

}
include 'cantidadPedidosPendientes.php';
$cantidad_pedidos="";
if ($usuario) $cantidad_pedidos=calcularPedidosPendientes($con);
?>


<nav class="navbar navbar-default" role="navigation">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php"><img src="assets/img/fotocopia.png" width="130"></a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">


      <ul class="nav navbar-nav navbar-right">
        <li class="nav-item " style="padding-top: 6px;">
          <a class="nav-link" href="index.php" title="Home"><i class="fa fa-home fa-lg">&nbsp;</i>Home
          </a>
        </li>
        <li class="nav-item " style="padding-top: 6px;">
          <a class="nav-link" href="listado.php" title="Home">Listado
          </a>
        </li>
        <li class="nav-item " <?php //echo $displayPedidosPendientes; ?> style="padding-top: 6px;" >
          <a class="nav-link" href="misCompras.php" title="Pedidos Pendientes">
            <i class="fa fa-truck fa-lg">&nbsp;
          </i>Pedidos&nbsp;<?php //if ($cantidad_pedidos>0) echo "<span id='pedidos_pendientes'>  <span class='badge badge-light'>7</span></span>";?>
          </a>
        </li>

        <li class="nav-item " <?php //echo $displayLogin;?> style="padding-top: 6px;" >
          <a class="nav-link" href="login.php" title="Home">Ingreso
          </a>
        </li>
        <li class="nav-item " <?php //echo $displayLogin;?> style="padding-top: 6px;" >
          <a class="nav-link" href="registro.php" title="Login">Registro
          </a>
        </li>

        <li class="dropdown" <?php //echo $displayUsuario;?> style="padding-top: 6px;" >
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
         <img width="25" class="img-circle" src="assets/img/usuarios/<?php //echo $foto;?>"/>
             <b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li><a href="#"><strong>Call: </strong>+09-456-567-890</a></li>
            <li><a href="#"><strong>Mail: </strong>info@yourdomain.com</a></li>
            <li class="divider"></li>
            <li><a href="#"><strong>Address: </strong>
              <div>
                234, New york Street,<br />
                Just Location, USA
              </div>
            </a></li>
          </ul>
        </li>

        <li class="nav-item" style="padding-top: 6px;">
          <a href="verCarrito.php" class="nav-link"  title="Carrito de Compras">
            <i class="fa fa-shopping-cart fa-lg">&nbsp;</i>Carrito

          </a>
        </li>

      </ul>
      <form class="navbar-form navbar-right" role="search">
        <div class="form-group">
          <input type="text" placeholder="Ingrese Articulo ..." class="form-control">
        </div>
        &nbsp;
        <button type="submit" class="btn btn-primary">Buscar</button>
      </form>
    </div>
    <!-- /.navbar-collapse -->
  </div>
  <!-- /.container-fluid -->
</nav>
