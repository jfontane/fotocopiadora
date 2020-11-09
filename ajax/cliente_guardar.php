<?php
	session_start();
	if (empty($_POST['apellido'])){
		$errors[] = "Ingresa el Apellido del Cliente.";
	} elseif (empty($_POST['nombre'])){
    $errors[] = "Ingresa el Nombre del Cliente.";
	} elseif (!empty($_POST['apellido'] && !empty($_POST['nombre']))) {
	require_once ("../php/conexion.php");//Contiene funcion que conecta a la base de datos
	// escaping, additionally removing everything that could be (html/javascript-) code
  $cliente_apellido = $_POST["apellido"];
	$cliente_nombre = $_POST["nombre"];
	$cliente_dni = $_POST["dni"];
	$cliente_email = $_POST["email"];
	$cliente_telefono = $_POST["telefono"];
	$cliente_direccion = $_POST["direccion"];
  $cliente_password = $_POST["password"];
	$cliente_password2 = $_POST["password2"];
	$cliente_id=0;
  if ($cliente_password!=$cliente_password2) $errors[] = "Las Contraseñas no Coinciden.";

			// REGISTER data into database
			 if (empty($errors)) {
				    $sql = "INSERT INTO clientes(id, apellido, nombre, dni, email, direccion, telefono, password) VALUES
						       (NULL,'$cliente_apellido','$cliente_nombre','$cliente_dni','$cliente_email','$cliente_telefono','$cliente_direccion','$cliente_password')";
				    $resultado=$con->query($sql);
						$cliente_id=$con->insert_id;
				    // if product has been added successfully
				    if ($resultado) {
				        $messages[] = "El Cliente ha sido guardado con éxito.";
				    } else {
								if ($con->errno=="1062") $errors[] = "El mail <b>".$cliente_email."</b> ya se encuentra registrado.";
				        else $errors[] = "Lo sentimos, el registro falló. Por favor, regrese y vuelva a intentarlo.";
				    }

					}
       };

if (isset($errors)){

			?>
			<div class="alert alert-danger" role="alert">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
					<strong>Error!</strong>
					<?php
						foreach ($errors as $error) {
								echo $error;
							}
						?>
			</div>
			<?php
			}
			if (isset($messages)){
						$_SESSION['usuario']=$cliente_email;
						$_SESSION['email']=$cliente_email;
						$_SESSION['username']=$cliente_email;
						$_SESSION['idCliente']=$cliente_id;
						$_SESSION['foto']='foto.jpg';
           echo "ok";
			}
?>
