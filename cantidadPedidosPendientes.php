<?php
include_once 'php/conexion.php';
function calcularPedidosPendientes($db) {
  $sql="SELECT * FROM orden WHERE estado='No Preparado' and cliente_id=".$_SESSION['idCliente'];
  //echo $sql;
  $result=$db->query($sql);
  $row_cnt = $result->num_rows;
  return $row_cnt;
};
?>
