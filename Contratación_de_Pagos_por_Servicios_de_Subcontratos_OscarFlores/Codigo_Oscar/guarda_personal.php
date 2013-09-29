<?php
	include"../global/global.php";
	$nombre=strtoupper($_REQUEST["personal"]);
	$fecha=$_REQUEST["fecha"];
	$rut=$_REQUEST["rut"];
	$cargo=strtoupper($_REQUEST["cargo"]);
	$terminal=$_REQUEST["terminal"];
	$area=$_REQUEST["area"];
	$anexo=$_REQUEST["anexo"];
	$nextel=$_REQUEST["nextel"];
	$celular=$_REQUEST["celular"];

	
	$consulta_exist = "SELECT * FROM empleado WHERE rut='".$rut."'";
	$cadena=mysql_query($consulta_exist) or die(mysql_error());
	$total_records = mysql_num_rows($cadena);
	if ($total_records==0){	
	 	$consulta = "INSERT INTO empleado VALUES  ('$rut','$fecha','$nombre','$cargo','$terminal','$celular','$nextel','$anexo','$area')";
		$consulta = mysql_query($consulta ) or die(mysql_error());
		mysql_close($conexion);
		echo "<center class='exito'> Se ha Ingresado Existosamente el Personal! </center>";
	}else{
		echo "<center class='exito'> El personal a ingresar ya existe en el sistema! </center>";
		}
?>