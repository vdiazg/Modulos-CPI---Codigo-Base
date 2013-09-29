<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
	
	<link rel="stylesheet" type="text/css" href="../estilos/style.css" media="screen,projection" />
	<title>Control de Stock</title>
  
</head>

<body>
<div id="maincontent">
  
<?php
include "../global/global.php";

$pg = $_GET['pg'];

if (!isset($pg))
$pg = 0; // $pg es la pagina actual
$cantidad=23; // cantidad de resultados por página
$inicial = $pg * $cantidad;


$consulta = "SELECT * FROM entradas WHERE factura=' ' OR guia=' ' LIMIT $inicial, $cantidad";
$cadena = mysql_query($consulta , $conexion) or die(mysql_error()); 

$contar = "SELECT * FROM entradas  WHERE factura=' ' OR guia=' ' "; 
$contarok= mysql_query($contar , $conexion) or die(mysql_error()); 
$total_records = mysql_num_rows($contarok);
$pages = intval($total_records / $cantidad);

if($total_records > 0)
	{ 
?>
<div align="center" class="normal">Agregar Guia o Factura Entrada Material</div>

<form >

<table>
  <tr>
  <td class ="td"><div align="center">Agregar Nº</div></td>
   <td class="td"><div align="center">Nombre</div></td>
   <td class="td"><div align="center">Fecha</div></td>
   </tr>
<?php


	while($arreglo = mysql_fetch_array($cadena))
 		{
		?>
   <tr>
   <td class="td3" align="center"><a href="modificar_fg_mat.php?id=<?php echo $arreglo['id_entrada'];?>"><img src="../imagenes/b_edit.png"></img></a></td>
    <td  class="td3">
	<?php 
	$id_material = $arreglo['material_id'];
$sql = "SELECT * FROM materiales WHERE id_material='$id_material'";
$cad = mysql_query($sql , $conexion) or die(mysql_error()); 
	if ($nombre_material = mysql_fetch_array($cad))
	{
	echo $nombre_material['nombre'];
	}
	?>
	</a></td>
    <td class="td3"><?php echo $arreglo['fecha']; ?></td>
  </tr>
  
	 <?php

}
?>	

</table>

<?php }
echo "<div class='footer'><center><p>"; 
if ($pg > 0) { 
$url = $pg - 1; 
echo "<a href='$PHP_SELF?pg=".$url."'>&laquo; Anterior </a>"; 
} else { 
echo " "; 
} 
for ($i = 0; $i <= $pages; $i++) { 
if ($i == $pg) { 
if ($i == 0) { 
echo "<b> 1 </b>"; 
} else { 
$i = $i+1; 
echo "<b> ".$i." </b>"; 
} 
} else { 
if ($i == 0) { 
echo "<a href='$PHP_SELF?pg=".$i."'>1</a> "; 
} else { 
echo "<a href='$PHP_SELF?pg=".$i."'>"; 
$i = $i+1; 
echo $i."</a>&nbsp;"; 
} 
} 
} 
if ($pg < $pages) { 
$url = $pg + 1; 
echo "<a href='$PHP_SELF?pg=".$url."'>Siguiente &raquo;</a>"; 
} else { 
echo " "; 
} 
echo "</p></div>"; 

?></form>

	
  <?php 
   
    ?>


</div>
</body>
</html>
