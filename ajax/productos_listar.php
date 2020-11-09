<?php

	/* Connect To Database*/
	//require_once ("../conexion.php");
	require_once ("../php/conexion.php");

$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
if($action == 'ajax'){
	//$query = mysqli_real_escape_string($con,(strip_tags($_REQUEST['query'], ENT_QUOTES)));
  $query=$_REQUEST['query'];
	$tables="articulos";
	$campos="*";
	$sWhere="  articulos.idOnce not like 'c-%' and (articulos.descripcion LIKE '%".$query."%' or articulos.idOnce LIKE '%".$query."%' or articulos.codigoBarra LIKE '%".$query."%') ";
	$sWhere.=" order by articulos.descripcion";


	include 'pagination.php'; //include pagination file
	//pagination variables
	$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
	$per_page = intval($_REQUEST['per_page']); //how much records you want to show
	$adjacents  = 4; //gap between pages after number of adjacents
	$offset = ($page - 1) * $per_page;
	//Count the total number of row in your table*/

	$count_query = $con->query("SELECT * FROM $tables where $sWhere ");
	$numrows = $count_query->num_rows;


	$total_pages = ceil($numrows/$per_page);
	//main query to fetch the data
	//loop through fetched data
  $query = $con->query("SELECT $campos FROM $tables where $sWhere LIMIT $offset,$per_page");


	if ($numrows>0){
	    $cadena=strtoupper($_REQUEST['query']);

	?>
		<div class="table-responsive table-wrapper">
			<table class="table table-striped table-hover table-bordered table-wrapper">
				<thead>
					<tr>
						<th class='text-center' width='5%'>CODIGO</th>
						<th style="color: black !important;" width='5%'>FOTO</th>
						<th style="color: black !important;" width='35%'>PRODUCTO </th>
						<th style="color: black !important;" width='5%'>EMPAQUE </th>
						<th class='text-right' style="color: black !important;" width='35%'>CODIGO DE BARRA</th>
						<th class='text-center' style="color: black !important;" width='15%'>PRECIO</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
						<?php
						$finales=0;
						while($row = $query->fetch_assoc()){
							$product_id=$row['id'];
							$prod_code=$row['idOnce'];
							$prod_name=$row['descripcion'];
							$prod_url_image=$row['url_image'];
							$empaque=$row['empaque'];
							$prod_barCode=$row['codigoBarra'];
							$prod_precio_con_iva=$row['precioConIva'];
							$prod_porcentaje_recargo=$row['porcentajeRecargo'];
							$prod_qty=1;//$row['prod_qty'];
							$price=$row['precioConIva']*$row['porcentajeRecargo'];
							$finales++;
							$prod_name_patron=$prod_name;
						    $prod_barCode_patron=$prod_barCode;
						    $prod_code_patron=$prod_code;
						    if ($cadena!="" && strlen($cadena)>1) {
								$prod_name_patron=str_replace($cadena, "<span title class='highlight'>".$cadena."</span>", strtoupper($prod_name));
								$prod_barCode_patron=str_replace($cadena, "<span title class='highlight'>".$cadena."</span>", strtoupper($prod_barCode));
								$prod_code_patron=str_replace($cadena, "<span title class='highlight'>".$cadena."</span>", strtoupper($prod_code));
						    }

						?>
						<tr style="font-family: "Lato", "Helvetica Neue", Helvetica, Arial, sans-serif;font-size: 13px;">
							<td class="text-left small"><?php echo $prod_code_patron;?></td>
							<td>
								<?php  if ($prod_url_image!='demo.png') { ?>
										<a href="#" data-toggle="modal" data-target="#miModal" data-url='<?php echo $prod_url_image;?>' >
		  									<?php echo "<img src='./img/banner/".$prod_url_image."' width='30'>"; ?>
										</a>
							  <?php } else {echo "<img src='./img/banner/".$prod_url_image."' width='30'>";} ?>
							</td>
							<td class="small" style="color: black;"><?php echo $prod_name_patron;?></td>
							<td class="small" style="color: black;"><?php echo $empaque;?></td>
							<td class="text-right small" style="color: black;"><?php echo $prod_barCode_patron;?></td>
							<td class="text-right font-weight-bold small" style="color: black !important;"><?php echo '<b>$</b>&nbsp;'.number_format($price,2,'.',',');?></td>
							<td>
								<a href="accionCarrito.php?action=addToCart&id=<?php echo $row["id"]; ?>"  >
									<i class="fa fa-shopping-cart" aria-hidden="true"></i>
                </a>
							</td>
						</tr>
						<?php }?>
						<tr>
							<td colspan="7"></td>
						</tr>
						<tr>
							<td colspan='7'>
								<?php
								    echo "<br>";
									$inicios=$offset+1;
									$finales+=$inicios-1;
									echo "Mostrando $inicios al $finales de $numrows registros";
									echo paginate( $page, $total_pages, $adjacents);
								?>
							</td>
						</tr>
						<tr>
							<td colspan="6"></td>
						</tr>
				</tbody>
			</table>
		</div>



	<?php
	}
}
?>

<div class="modal fade" id="miModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="url">

      </div>
    </div>
  </div>
</div>

<script type="text/javascript">

$('#miModal').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget); // Button that triggered the modal
	var url = button.data('url');
	img="<center><img src='./img/banner/"+url+"' width='350'></center>";
	$('#url').html(img);
	console.log(img)
});

</script>
