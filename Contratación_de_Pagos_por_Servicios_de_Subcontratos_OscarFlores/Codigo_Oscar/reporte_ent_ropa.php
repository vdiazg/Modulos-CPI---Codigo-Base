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
<title>Reporte de Entrada de Ropa</title>
<link rel="stylesheet" href="../estilos/style.css" type="text/css" />
<script type="text/javascript" src="Ajax/myAjax.js"></script>
<script language="javascript" src="../scripts/script.js" type="text/javascript"></script>


</head>

<body onload="asignaVariables();">


<?php
include"../global/global.php";
$ent_rop=$_REQUEST['id_ropa'];
$consulta = "SELECT * FROM ropa WHERE id_ropa='".$ent_rop."'";
$cadena = mysql_query($consulta , $conexion) or die(mysql_error()); 
$array_rop = mysql_fetch_array($cadena);
?>
<div class="normal" align="center">Reporte de Entrada de <?php echo " "; echo $array_rop['nombre']; echo " / Talla: "; echo $array_rop['talla'];?></div> 
<div id="maincontent">

<?php



$pg = $_REQUEST['pg'];

if($pg > 0)
{
$pg = $pg -1 ;
}else{
$pg = 0;}
$cantidad=20; // cantidad de resultados por página
$inicial = $pg * $cantidad;

$sql = "SELECT * FROM entrada_ropa WHERE id_ropa='".$ent_rop."' ORDER BY id_entrada_ropa DESC LIMIT $inicial,$cantidad";
$cad = mysql_query($sql , $conexion) or die(mysql_error()); 

$contar = "SELECT * FROM entrada_ropa WHERE id_ropa='".$ent_rop."' ORDER BY id_entrada_ropa DESC"; 
$contarok= mysql_query($contar , $conexion) or die(mysql_error()); 
$total_records = mysql_num_rows($contarok);
$pages = intval($total_records / $cantidad);
$pagina = $_REQUEST['pg'];
$pages = $pages + 1;
if($pagina == "")
{
$pagina= 1;
}
?>
<center><form method='post' action='reporte_ent_ropa.php?id_ropa=<?php echo $ent_rop;?>'><font class='normal'><?php echo $pages;?> Paginas</font> <input align='center' type='textbox' size='1' value='<?php echo $pagina;?>' name='pg' class='cajatexto'>
<input type='submit'  value='IR' class='btn'></form></center> 



<center>



<table width="873">
<tr align="center" class="td">
	  	<td width="40">N°</td>
		<td width="180">Fecha</td>
        	<td width="50">Cantidad</td>
		<td width="150">Precio(unidad)</td>
		<td width="150">Solicitante</td>
		<td width="150">Terminal</td>
		<td width="180">Proveedor</td>
		<td width="80">Factura</td>
		<td width="80">Guia</td>
		<td width="400">Observacion</td>

</tr>

<?php
$contador = 0;
$color=array("#ffffff","#D5EAEA");

 while($array = mysql_fetch_array($cad))
 {
 $contador++;
 
 $consulta_terminal = "SELECT terminal FROM terminal WHERE cod_terminal='".$array['cod_terminal']."'";
 $cadena_term = mysql_query($consulta_terminal , $conexion) or die(mysql_error()); 
 $array_term = mysql_fetch_array($cadena_term);
 
 $consulta_solic = "SELECT * FROM solicitantes WHERE id_solicitante='".$array['solicitante']."'";
 $cadena_solic = mysql_query($consulta_solic , $conexion) or die(mysql_error()); 
 $array_sol = mysql_fetch_array($cadena_solic);
 
 ?>
 
<tr bgcolor="<?php echo $color[$contador%2]; ?>"> 
<td class="td3"><div align="center"><?php echo $array['id_entrada_ropa'];?></div></td>
<td class="td3"><div align="center"><?php echo $array['fecha'];?></div></td>
<td class="td3"><div align="center"><?php echo $array['cantidad'];?></div></td>
<td class="td3"><div align="center"><?php echo $array['precio_unitario'];?></div></td>
<td class="td3"><div align="center"><?php echo $array_sol['nombre'];?></div></td>
<td class="td3"><div align="center"><?php echo $array_term['terminal'];?></div></td>
<td class="td3"><div align="center"><?php echo $array['proveedor'];?></div></td>
<td class="td3"><div align="center"><?php echo $array['factura'];?></div></td>
<td class="td3"><div align="center"><?php echo $array['guia'];?></div></td>
<td class="td3"><div align="center"><?php echo $array['observacion'];?></div></td>
</tr>
<?php } 

?>
</div>
</table>
</body>
</html>
