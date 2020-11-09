<?php
$DB_HOST="localhost";
$DB_NAME= "mrlhofsr_eloriginal";
$DB_USER= "mrlhofsr_javier";
$DB_PASS= "JHframbo44";
	# conectare la base de datos
    $con=@mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
    if(!$con){
        die("imposible conectarse: ".mysqli_error($con));
    }
    if (@mysqli_connect_errno()) {
        die("Connect failed: ".mysqli_connect_errno()." : ". mysqli_connect_error());
    }

?>
