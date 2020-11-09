<?php
include_once '../php/conexion.php';

  $sql="SELECT * FROM orden WHERE estado='No Preparado' and cliente_id=".$_POST['idcliente'];
  //.$_POST['idCliente'];
  //echo $sql;
  $result=$con->query($sql);
  $cant=$result->num_rows;
  echo $cant;


?>
