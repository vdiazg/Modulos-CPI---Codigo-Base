<?php
session_start();
header ("Expires: Thu, 27 Mar 1980 23:59:00 GMT"); //la pagina expira en una fecha pasada
header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); //ultima actualizacion ahora cuando la cargamos
header ("Cache-Control: no-cache, must-revalidate"); //no guardar en CACHE
header ("Pragma: no-cache");
?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Buscar Solicitante</title>
<link rel="stylesheet" href="../estilos/style.css" type="text/css" />
<script type="text/javascript" src="Ajax/myAjax.js"></script>
<script language="javascript" src="../scripts/script.js" type="text/javascript"></script>

</head>

<body onload="asignaVariables();">

<div id="maincontent">

<form method="get"  action="" name="buscar_material">
   <input type="hidden" id = "archivo" value="buscar_material.php?" />

<table width="614" border="0" align="center">
<div align="center" class="normal"><h3>Seleccione Solicitante a Eliminar</h3></div>




</form>

<?php
include"../global/global.php";
 ?>
<?php

$pg = $_GET['pg'];
if($pg > 0)
{
$pg = $pg -1 ;
}else{
$pg = 0;}
$cantidad=15; // cantidad de resultados por página
$inicial = $pg * $cantidad;

$sql = "SELECT * FROM solicitantes WHERE existe='SI' ORDER BY id_solicitante LIMIT $inicial,$cantidad";
$cad = mysql_query($sql , $conexion) or die(mysql_error()); 

$contar = "SELECT * FROM solicitantes WHERE existe='SI' ORDER BY id_solicitante"; 
$contarok= mysql_query($contar , $conexion) or die(mysql_error()); 
$total_records = mysql_num_rows($contarok);
$pages = intval($total_records / $cantidad);
$pagina = $_GET['pg'];
$pages = $pages + 1;
if($pagina == "")
{
$pagina= 1;
}
echo "<center><form METHOD='GET'><font class='normal'>".$pages." Paginas</font> <input align='center' type='textbox' size='1' value='".$pagina."' name='pg' class='cajatexto'>";
echo "<input type='submit' onclick='this.form.submit()' value='IR' class='btn'></form></center>"; 

?>

<center>

<form action="eliminar_solic.php" method="post" name="form">
<table width="873">
<tr align=center class="td">
	   <td width="60">Código</td>
	    <td width="60">Nombre Solicitante</td>
		<td width="30">ELIM</td>
</tr>

<?php
$contador = 0;
$color=array("#ffffff","#D5EAEA");

 while($array = mysql_fetch_array($cad))
 {
 $contador++; 

//onclick="form.submit('editar_mat.php?id_material= php echo $array['id_material'];')"
 ?>
 
<tr bgcolor="<?php echo $color[$contador%2]; ?>"> 
<td class="td3"><div align="center"><?php echo $array['id_solicitante'];?></div></td>
<td class="td3"><div align="left"><?php echo $array['nombre'];?></div></td>
<td class="td3"><div align="center"><a href="eliminar_solic.php?id_sol=<?php echo $array['id_solicitante'];?>"><img src="../imagenes/borrar.png"></a></div></td>

</tr>
<?php } 

 
?>
</table>
</form>

<?php
mysql_close($conexion);

?>
</div>
</body>
</html>