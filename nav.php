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

<nav class="navbar navbar-expand-lg navbar-light bg-warning">
  <div class="navbar-header">
    <a class="navbar-brand" href="index.php"><img src="assets/img/fotocopia.png" width="130"></a>
  </div>
  <button class="navbar-toggler" type="button" data-toggle="collapse"
          data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
          aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="index.php"><i class="fa fa-home fa-lg">&nbsp;</i>Home <span class="sr-only">(current)</span></a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="listado.php"  title="Catalogo de Articulos">
          <i class="fa fa-clipboard fa-lg">&nbsp;<br></i>Listado
        </a>
      </li>

      <li class="nav-item" style="padding-top: 6px;display:none">
        <a href="misCompras.php" class="nav-link" title="Pedidos Pendientes">
          <i class="fa fa-truck fa-lg">&nbsp;
        </i>Mis Compras&nbsp;<?php //if ($cantidad_pedidos>0) echo "<span id='pedidos_pendientes'><span class='badge badge-light'>".$cantidad_pedidos."</span></span>";?>
        </a>
      </li>

      <li class="nav-item">
        <a href="login.php" class="nav-link">
            <i class="fa fa-sign-in fa-lg" aria-hidden="true">&nbsp;</i>Ingresar
            </a>
      </li>

      <li class="nav-item">
        <a href="verCarrito.php" class="nav-link"  title="Carrito de Compras">
          <i class="fa fa-shopping-cart fa-lg">&nbsp;</i>Carrito
          <?php if ($cart->total_items()) echo "<span class='badge badge-light'>".$cart->total_items()."</span>";?>
        </a>
      </li>

      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fa fa-user fa-lg"></i>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="#">Mis datos</a>
          <a class="dropdown-item" href="#">Seguridad</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="logout.php"><i class="fa fa-sign-out fa-lg"></i>&nbsp;Salir</a>
        </div>
      </li>


    </ul>
    <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
  </div>
</nav>
