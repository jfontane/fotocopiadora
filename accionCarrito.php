<?php
//session_start();
if (!isset($_SESSION['usuario'])||($_SESSION['usuario']=="")) {
  //header("location: ./login.php");
  //die;
}


//date_default_timezone_set("America/Argentina/Salta");
// Iniciamos la clase de la carta
include 'carrito.php';
$cart = new Cart;
// include database configuration file
include './php/conexion.php';
if(isset($_REQUEST['action']) && !empty($_REQUEST['action'])){ //si viene algo en accion
  if($_REQUEST['action'] == 'addToCart' && !empty($_REQUEST['id'])){ // si en accion viene addToCart y tb viene un id


    $productID = $_REQUEST['id'];
    // get product details
    $query = $con->query("SELECT * FROM articulos WHERE id = ".$productID);
    $row = $query->fetch_assoc();
    $itemData = array(
      'id' => $row['id'],
      'name' => $row['descripcion'],
      'price' => $row['precioConIva']*$row['porcentajeRecargo'],
      'discount' => 0,
      'qty' => 1
    );

    $insertItem = $cart->insert($itemData);
    $redirectLoc = $insertItem?'verCarrito.php':'index.php'; //si es TRUE salio bien y agrego a carrito y redirecciona a verCarrito
    header("Location: ".$redirectLoc);
  }elseif($_REQUEST['action'] == 'updateCartItem' && !empty($_REQUEST['id'])){ //si accion es updateCartItem
    $itemData = array(
      'rowid' => $_REQUEST['id'],
      'qty' => $_REQUEST['qty']
    );
    //die('entroooo');
    $updateItem = $cart->update($itemData);
    echo $updateItem?'ok':'err';
  }elseif($_REQUEST['action'] == 'updateCartItemDisc' && !empty($_REQUEST['id'])){ //si accion es updateCartItem
    $itemData = array(
      'rowid' => $_REQUEST['id'],
      'discount' => $_REQUEST['discount']
    );
    //die('entroooo');
    $updateItem = $cart->update($itemData);
    echo $updateItem?'ok':'err';
  }elseif($_REQUEST['action'] == 'removeCartItem' && !empty($_REQUEST['id'])){ //si accion es updateCartItem
    $deleteItem = $cart->remove($_REQUEST['id']);
    header("Location: verCarrito.php");
  }elseif($_REQUEST['action'] == 'placeOrder' && $cart->total_items() > 0 && !empty($_SESSION['idCliente'])){
    // insert order details into database
    $idCliente=(!isset($_REQUEST['idcliente'])||!($_REQUEST['idcliente']>0))?1:$_REQUEST['idcliente'];
    $insertOrder = $con->query("INSERT INTO orden (cliente_id, precio_total, creado, modificado, origen) VALUES ('".$idCliente."', '".$cart->total().
    "', '".date("Y-m-d H:i:s")."', '".date("Y-m-d H:i:s")."','Internet')");

    if($insertOrder){
      $orderID = $con->insert_id;
      $sql = '';
      // get cart items
      $cartItems = $cart->contents();
      foreach($cartItems as $item){
        $sql_temp="SELECT precioConIva, porcentajeRecargo FROM articulos WHERE id=".$item['id'];
        //die($sql_temp);
        $query_temp=$con->query($sql_temp);
        $row = $query_temp->fetch_assoc();
        $precioConIva=$row['precioConIva'];
        $porcentajeRecargo=$row['porcentajeRecargo'];

        $sql .= "INSERT INTO orden_articulos (orden_id, articulo_id, precioUnitario, porcentajeRecargo, cantidad, descuento) VALUES (".$orderID.", ".$item['id'].",".$precioConIva.",".$porcentajeRecargo.",".$item['qty'].",".$item['discount'].");";
      }
      //die($sql);
      // insert order items into database
      $insertOrderItems = $con->multi_query($sql);

      if($insertOrderItems){
        $cart->destroy();
        header("Location: ordenExito.php?id=$orderID");
      }else{
        header("Location: ordenPagos.php");
      }
    }else{
      header("Location: ordenPagos.php");
    }
  }else{
    header("Location: index.php");
  }
}else{
  header("Location: index.php");
}
