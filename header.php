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
  $styleMensajesPendientes='';
} else {
  $styleUsuario=' style="display:none" ';
  $styleLogin='';
  $stylePedidosPendientes=' style="display:none" ';
  $styleMensajesPendientes=' style="display:none" ';

}
include 'cantidadPedidosPendientes.php';
$cantidad_pedidos="";
if ($usuario) $cantidad_pedidos=calcularPedidosPendientes($con);
?>


<nav class="navbar  navbar-light " style="background-color: #FEFE66;">  <!--E3E16B  -->
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">
      <img src="assets/img/fotocopia.png" width="170">
    </span> <!-- <strong>Libreria "El Original"</strong> -->
  </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarResponsive">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item " style="padding-top: 6px;">
        <a class="nav-link" href="index.php" title="Home"><i class="fa fa-home fa-lg">&nbsp;</i>Home
        </a>
      </li>

      <li class="nav-item " style="padding-top: 6px;">
        <a class="nav-link" href="catalogo.php"  title="Catalogo de Articulos">
          <i class="fa fa-clipboard fa-lg">&nbsp;<br></i>Catalogo
        </a>
      </li>


      <li class="nav-item" style="padding-top: 6px;">
        <a href="misCompras.php" class="nav-link" title="Pedidos Pendientes">
          <i class="fa fa-truck fa-lg">&nbsp;
        </i>Mis Compras&nbsp;<?php //if ($cantidad_pedidos>0) echo "<span id='pedidos_pendientes'><span class='badge badge-light'>".$cantidad_pedidos."</span></span>";?>

        </a>
      </li>

      <li class="nav-item " style="padding-top: 6px;">
        <a href="login.php" class="nav-link">
            <i class="fa fa-sign-in fa-lg" aria-hidden="true">&nbsp;</i>Ingresar
            </a>
      </li>

      <li class="nav-item " style="padding-top: 6px;">
        <a href="verCarrito.php" class="nav-link"  title="Carrito de Compras">
          <i class="fa fa-shopping-cart fa-lg">&nbsp;</i>Carrito
          <?php if ($cart->total_items()) echo "<span class='badge badge-light'>".$cart->total_items()."</span>";?>

        </a>
      </li>

<li class="nav-item dropdown" style="padding-top: 6px;">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
          <i class="fa fa-user fa-lg"></i>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="#">Mis datos</a>
          <a class="dropdown-item" href="#">Seguridad</a>
          <a class="dropdown-item" href="logout.php"><i class="fa fa-sign-out fa-lg"></i>&nbsp;Salir</a>
        </div>
      </li>

    </ul>
  </div>

</div>
</nav>
