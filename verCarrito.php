<?php
// initializ shopping cart class
include 'carrito.php';
$cart = new Cart;
$paginaActivo='verCarrito';

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>El Original</title>
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

  <?php include_once('nav.php'); ?>

  <header>
  <div class="container">
    <h1>Header</h1>
  </div>
  </header>



<div class="container">
  <h2><i class="fa fa-shopping-cart fa-lg">&nbsp;</i>&nbsp;&nbsp;Carrito de Compras </h2>
  <br>
  <div class="row">
      <div class="col-xs-12">
        <table class="table" width="100%">
          <thead>
            <tr>
              <th width='45%' class="text-center">ITEM</th>
              <th width='5%' class="text-center">P.UNIT.</th>
              <th width='20%' class="text-center">CANT.</th>
              <th width='10%' class="text-center">PRECIO</th>
            </tr>
          </thead>
          <tbody>
            <?php
            //echo $cart->total_items();
            if($cart->total_items() > 0){
              //get cart items from session
              $cartItems = $cart->contents();
              //var_dump($cartItems);
              foreach($cartItems as $item){
                ?>
                <tr>
                  <td  style="font-size: 12px;"><?php echo $item["name"]; ?></td>
                  <td class="text-right"  style="font-size: 12px;"><?php echo '$'.number_format($item["price"],2,'.',',').' '; ?></td>
                  <td style="padding-top: 0px;">
  <input type="number" class="form-control text-center"  style="font-size: 12px;" value="<?php echo $item["qty"]; ?>" min="1" step="1"
  onchange="updateCartItem(this, '<?php echo $item["rowid"]; ?>')" style="float: right;width : 55px;padding-top: 1px;padding-bottom: 1px;padding-left: 5px;padding-right: 5px;height: 22px;">
                  </td>
                    <td class="text-right"><?php echo '$'.number_format($item["subtotal"],2,'.',',').' '; ?>&nbsp;
                      <a href="accionCarrito.php?action=removeCartItem&id=<?php echo $item["rowid"]; ?>" onclick="return confirm('Confirma eliminar?')" >
                        <i class="fa fa-trash-alt">del</i>
                      </a>
                    </td>
                  </tr>
                <?php } }else{ ?>
                  <tr><td colspan="4"><p>Tu carrito esta vacio.....</p></td>
                  <?php } ?>
                </tbody>

                <tfoot>
                  <tr>
                    <td align='left'><b>Subtotal:</b></td>
                    <td align='left'><b>3 Items</b></td>
                    <td align='left'><b><?php echo '$'.number_format($cart->total(),2,'.',',').' '; ?></b></td>
                    <td></td>
                  </tr>
                  <tr>
                    <td align='left'><b>Cupon:</b></td>
                    <td align='left'><b>10% off</b></td>
                    <td align='left'><b>$ 761,50</b></td>
                    <td></td>
                  </tr>
                  <tr>
                    <td colspan="2" align='left'><b>Total:</b></td>
                    <td align='left'><b><?php echo '$'.number_format($cart->total(),2,'.',',').' '; ?></td>
                    <td></td>
                  </tr>
                  <tr>
                    <?php if($cart->total_items() > 0){ ?>
                      <td class="text-right" colspan="4"><strong>Total <?php echo '$'.number_format($cart->total(),2,'.',',').' '; ?></strong></td>
                    <?php } ?>
                  </tr>
                  <tr>
                    <td colspan="4">
                      <a href="<?php echo ($usuario=="")?"login.php?target=ordenPagos":"ordenPagos.php"; ?>" id="btnConfirmarPedido" class="btn btn-primary orderBtn" >
                        Aceptar<i class="glyphicon glyphicon-menu-right"></i>
                      </a>
                      &nbsp;&nbsp;
                      <a href="index.php">Volver</a>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="4">
                      <b>Nota:</b> El Boton 'Aceptar' del Pedido aun no realiza el pago. Solo acepta para pasar a otra instancia de verificacion.
                    </td>
                  </tr>
                </tfoot>
              </table>
            </div>

          </div>
        </div>

      <?php include 'footer.php'; ?>
      <!--Footer end -->
      <!--Core JavaScript file  -->
      <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

      <script>

      function updateCartItem(obj,id){
        console.log('qty: '+obj.value+' id: '+id);
        $.get("accionCarrito.php", {action:"updateCartItem", id:id, qty:obj.value}, function(data){
          //alert(data)
          if(data == 'ok'){
            location.reload();
          }else{
            alert('Cart update failed, please try again.');
          }
        });
      }

    </script>

  </body>
  </html>
