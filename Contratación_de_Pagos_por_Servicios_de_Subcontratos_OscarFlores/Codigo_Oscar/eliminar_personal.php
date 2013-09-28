<script type="text/javascript" src="Ajax/myAjax.js"></script>
<script language="javascript" src="../scripts/script.js" type="text/javascript"></script>



<?
include"../global/global.php";
$rut=$_REQUEST['rut'];
$instruccion= "delete from empleado where rut='".$rut."'";
$consulta=mysql_query($instruccion,$conexion)
	or die ('Error al Eliminar, contactar a Administrador del sistema');

echo '<center><h3>Empleado Eliminado con Exito!</h3></center>';
?>