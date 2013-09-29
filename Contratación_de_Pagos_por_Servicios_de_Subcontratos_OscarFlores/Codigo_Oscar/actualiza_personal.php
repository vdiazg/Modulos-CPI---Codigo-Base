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

	
	$consulta= "update empleado set fecha='".$fecha."', nombre='".$nombre."', cargo='".$cargo."', cod_terminal='".$terminal."', id_celular='".$celular."', id_nextel='".$nextel."', id_fija='".$anexo."', id_area='".$area."' where rut='".$rut."'";
	$consulta = mysql_query($consulta ) or die(mysql_error());
	mysql_close($conexion);
	echo "<center class='exito'> Se ha Actualizo Existosamente la informacion del Personal! </center>";

?>