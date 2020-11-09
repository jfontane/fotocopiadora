<?php
session_start();
/* Llamar la Cadena de Conexion*/
include ("../php/conexion.php");
$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
if($action == 'ajax'){
	//Elimino producto
	if (isset($_REQUEST['id'])){
		$id_banner=intval($_REQUEST['id']);
		if ($delete=mysqli_query($con,"delete from promociones where id='$id_banner'")){
			$message= "Datos eliminados satisfactoriamente";
		} else {
			$error= "No se pudo eliminar los datos";
		}
	}

	$tables="promociones";
	$sWhere=" ";
	$sWhere.=" ";


	$sWhere.=" order by id";
	include 'pagination.php'; //include pagination file

	//pagination variables
	$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
	$per_page = 8; //how much records you want to show
	$adjacents  = 4; //gap between pages after number of adjacents
	$offset = ($page - 1) * $per_page;

	//Count the total number of row in your table*/
	$count_query   = mysqli_query($con,"SELECT count(*) AS numrows FROM $tables  $sWhere ");
	if ($row= mysqli_fetch_array($count_query))
	{
		$numrows = $row['numrows'];
	}
	else {echo mysqli_error($con);}
	$total_pages = ceil($numrows/$per_page);
	$reload = './banner_ajax.php';
	//main query to fetch the data
	$query = mysqli_query($con,"SELECT * FROM  $tables  $sWhere LIMIT $offset,$per_page");

	if (isset($message)){
		?>
		<div class="alert alert-success alert-dismissible fade in" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
			<strong>Aviso!</strong> <?php echo $message;?>
		</div>

		<?php
	}
	if (isset($error)){
		?>
		<div class="alert alert-danger alert-dismissible fade in" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
			<strong>Error!</strong> <?php echo $error;?>
		</div>

		<?php
	}
	//loop through fetched data
	if ($numrows>0)	{
		?>

		<div class="row">
			<?php
			while($row = mysqli_fetch_array($query)){

				$id=$row['id'];
				if ($row['url_image']=="demo.png") {
					$url_image=$row['url_image'];
				} else {
				$imgUrl=explode(".",$row['url_image']);
				$imagen_nombre=$imgUrl[0];
				$imagen_extension=$imgUrl[1];
				$thumbnail=$imagen_nombre.'_thumb.'.$imagen_extension;
				$url_image=$thumbnail;
			};

				$titulo=$row['titulo'];
				$id_slide=$row['id'];
				$descripcion=$row['descripcion'];
				$articulo_id=$row['articulo_id'];
				?>

				<div class="col-lg-3 col-md-4 col-xs-6 thumb">
					<a class="img-thumbnail" href="#" data-image-id="<?php echo $id;?>" data-toggle="modal" data-title="<?php echo $titulo?>" data-caption="<?php echo $descripcion;	?>" data-image="img/banner/<?php echo $url_image;?>" data-target="#image-gallery">
						<img class="img-thumbnail" src="img/banner/<?php echo $url_image;?>" alt="Another alt text">
					</a>
					<p class='text-center'><a href="accionCarrito.php?action=addToCart&id=<?php echo $articulo_id; ?>" class="btn btn-warning" role="button"><i class="fa fa-shopping-cart fa-lg"></i>&nbsp;</a></p>
					<p class='text-center'> sdfasdf asdf asdf sadf sadfasdf fd sdaf asdfsadf </p>

				</div>

				<?php
			}
			?>
		</div>

		<div class="pagination">
			<?php echo paginate($page, $total_pages, $adjacents);?>
		</div>
		<?php
	}
}
?>
