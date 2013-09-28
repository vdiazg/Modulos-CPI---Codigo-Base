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
<title>Buscar Salidas Material</title>
<link rel="stylesheet" href="../estilos/style.css" type="text/css" />
<script type="text/javascript" src="Ajax/myAjax.js"></script>
<script language="javascript" src="../scripts/script.js" type="text/javascript"></script>
<script language="javascript" src="../calendar/cal2.js"> </script>
<script language="javascript" src="../calendar/cal_conf2.js"></script>

<script>
function valida_busca()
{ 
   	if (document.buscar_salida_material.nombre.value.length==0){ 
      	 alert("Ingrese nombre de Material") 
      	 document.buscar_salida_material.nombre.focus(); 
      	 return false; 
}else{
	return true;
	}
}
</script>

</head>

<body onload="asignaVariables();">

<div id="maincontent">
  <form method="get"  action="" name="buscar_salida_material">
   <input type="hidden" id = "archivo" value="buscar_salidas_material.php?" />
   
	<div class="normal" align="center">Consultar Salidas de Material </div> 

<table width="690" border="0" cellpadding="1" cellspacing="0">
  <tr>
    <td width="121" height="10" class="td" ><div align="right">Nombre Material 
      <input name="radioboton" type="radio" value="nombre" checked="checked"/>
    </div></td>
    <td width="394" class="td">
	
	  <div id="demo" style="width:300px;">
	  				<div class="td2" id="demoDer">
					          <div align="left">
		  <?php
//funciones para mostrar datos con ajax
function validaBusqueda($parametro)
{
	// Funcion para validar la cadena de busqueda de la lista desplegable
	if(eregi("^[a-zA-Z0-9.@ ]{2,40}$", $parametro)) return TRUE;
	else return FALSE;
}


if(isset($_POST["busqueda"]))
{
	$valor=$_POST["busqueda"];
	if(validaBusqueda($valor))
	{
	include "../global/global.php";
		
		$consulta=mysql_query("SELECT nombre FROM materiales WHERE nombre LIKE '".$valor."%' ORDER BY nombre LIMIT 0, 22");
		
		mysql_close($conexion);
		
		$cantidad=mysql_num_rows($consulta);
		if($cantidad==0)
		{
			/* 0: no se vuelve por mas resultados
			vacio: cadena a mostrar, en este caso no se muestra nada */
			echo "0&No hay resultados";
		}
		else
		{
			if($cantidad>20) echo "1&"; 
			else echo "0&";
	
			$cantidad=1;
			while(($registro=mysql_fetch_row($consulta)) && $cantidad<=20)
			{
				echo "<div onClick=\"clickLista(this);\" onMouseOver=\"mouseDentro(this);\">".$registro[0]."</div>";
				
				
				// Muestro solo 20 resultados de los 22 obtenidos
				$cantidad++;
			}
		}
	}
}


?>		  
		  <input name="nombre" type="text" class="cajatexto" id="valor"
					onfocus="if(document.getElementById('lista').childNodes[0]!=null && this.value!='') { filtraLista(this.value); formateaLista(this.value); 
						reiniciaSeleccion(); document.getElementById('lista').style.display='block'; }" 					onblur="if(v==1) document.getElementById('lista').style.display='none';" onkeypress="return validar_texto_espacio(event)" 
					onkeyup="if(navegaTeclado(event)==1) {
						clearTimeout(ultimoIdentificador); 
						ultimoIdentificador=setTimeout('rellenaLista()', 1000); }" size="51" autocomplete="off">
				  </div>
						 <div id="lista" onmouseout="v=1;" onmouseover="v=0;"align="left"></div>
         </div>
	    </div>	    </td>	
    <td width="161" class="td">&nbsp;</td>
  </tr>
  <tr>
    <td height="11" class="td" ><div align="right">Fecha 
      <input name="radioboton" type="radio" value="fecha"/>
</div></td>
    <td width="394" class="td">Desde :<span class="td2">
    <input name="desde" type="text" class="cajatexto" id="desde" size="12" readonly="true" autocomplete="off" />
    </span><a href="javascript:showCal('Desde_Mat')"><img src="../imagenes/calendar.gif" width="30" height="23" border="0" align="top" /></a>Hasta :<span class="td2">
    <input name="hasta" type="text" class="cajatexto" id="hasta" size="12" readonly="true" autocomplete="off" />
    <a href="javascript:showCal('Hasta_Mat')"><img src="../imagenes/calendar.gif" width="30" height="23" border="0" align="top" /></a></span></td>
    <td width="161" class="td"><div align="center">
      <input name="Busqueda" type="button" onclick="if (ver_radioBoton_mat()){this.form.submit();}"  class="btn" value="Busqueda" />
    </div></td>
  </tr>
</table>
<input type="hidden" name="busca" value="salidas" />

</form>


<?php
include"../global/global.php";

if($_GET["radioboton"]=="fecha")
{
$desde = $_GET['desde'];
$hasta = $_GET['hasta'];

echo "<span class='normal'>Resultado busqueda entre el </span>";

list($year, $month, $day ) = split( '[/.-]', $desde );
echo "<span class='normal'><b>$day/$month/$year</b>  y </span>";

list($year, $month, $day ) = split( '[/.-]', $hasta );
echo "<span class='normal'><b>$day/$month/$year</b> </span>";

$pg = $_GET['pg'];
if($pg > 0)
{
$pg = $pg -1 ;
}else{
$pg = 0;}
$cantidad=15; // cantidad de resultados por página
$inicial = $pg * $cantidad;

$sql = "SELECT * FROM salidas WHERE fecha between  DATE '$desde' and  DATE  '$hasta' LIMIT $inicial,$cantidad";
$cad = mysql_query($sql, $conexion) or die(mysql_error());

$contar = "SELECT * FROM salidas  WHERE fecha between  DATE '$desde' and  DATE  '$hasta'"; 
$contarok= mysql_query($contar , $conexion) or die(mysql_error()); 
$total_records = mysql_num_rows($contarok);
$pages = intval($total_records / $cantidad);
$material = $_GET['nombre'];
$desde = $_GET['desde'];
$hasta =  $_GET['hasta'];
$pagina = $_GET['pg'];
$total_pages = $pages + 1;
echo "<center><form METHOD='GET'><font class='normal'>".$total_pages." Paginas</font> 
	  <input align='center' type='textbox' size='1' value='".$pagina."' name='pg' class='cajatexto'>";
echo "<input type='submit' onclick='this.form.submit()' value='IR' class='btn'>
<input type='hidden' name='radioboton' value='fecha'>
<input type='hidden' name='desde' value='".$desde."'>
<input type='hidden' name='hasta' value='".$hasta."'>
</form></center>"; 
if($total_records > 0)
	{ 
?>
<div class="normal" align="right"><a href="javascript:Exportar_Excel('excel/excel_salidas_material.php?desde=<?php echo $desde; ?>& hasta=<?php echo $hasta;?>','ventana')"><img src="../imagenes/excel.jpg" /></a></div>
<table width="868">
<tr align=center class="td">
<td width="80">Código Salida</td>
<td width="74">Fecha</td>
<td width="153">Nombre Material </td>
<td width="173">Solicitante</td>
<td width="230">Observacón</td>
<td width="62">Cantidad</td>
<td width="64">Correo</td>
</tr>
<?php  
$contador = 0;
$color=array("#ffffff","#D5EAEA");

 while($arreglo_fecha = mysql_fetch_array($cad))
		{
		$contador ++;
?>
<tr bgcolor="<?php echo $color[$contador%2]; ?>"> 
<td class="td3"><div align="center"><?php echo $arreglo_fecha['id_salida'];?></div></td>
<td class="td3"><div align="center"><?php echo $arreglo_fecha['fecha'];?></div></td>
<td class="td3"><div align="center"><a href="javascript:Abrir_Ventana('popup/datos_material.php?id=<?php echo $arreglo_fecha['material_id']; ?>','ventana')">
<?php
$id_material = $arreglo_fecha['material_id'];
$consulta = "SELECT nombre FROM materiales WHERE id_material='$id_material'";
$cadena = mysql_query($consulta , $conexion) or die(mysql_error()); 
if($arreglo = mysql_fetch_array($cadena))
{
echo $arreglo['nombre'];
}
 ?></div></td>

<td class="td3"><div align="center">
<?php 
$cod=$arreglo_fecha['solicitante'];
$cons_solic = "SELECT nombre FROM solicitantes WHERE id_solicitante='$cod'";
$cad_sol = mysql_query($cons_solic , $conexion) or die(mysql_error()); 
$array_sol = mysql_fetch_array($cad_sol);
echo $array_sol['nombre'];
?>
</div></td>
<td class="td3"><div align="center"><?php echo $arreglo_fecha['observacion'];?></div></td>
<td class="td3"><div align="center"><?php echo $arreglo_fecha['cantidad'];?></div></td>
<td class="td3"><div align="center"><a href="javascript:Abrir_Ventana('popup/correo_material.php?id=<?php echo $arreglo_fecha['id_salida']; ?>','ventana')"><img src="../imagenes/mail.gif" /></a></div></td>


</tr>
<?php } //CIERRE DEL WHILE 
	}else {echo "<p><br><CENTER><div class='error'>NO SE ENCONTRO REGISTROS ENTRE LAS FECHAS INGRESADAS</div></CENTER>";}

		

?>
</table>
<?php

}else if ($_GET["radioboton"]=="nombre") 
{
$nombre = $_GET['nombre'];
$consulta = "SELECT * FROM materiales WHERE nombre='$nombre'";
$cadena = mysql_query($consulta , $conexion) or die(mysql_error()); 

?>
<center>



		<?php if($arreglo = mysql_fetch_array($cadena))
 	{
$id_material = $arreglo['id_material'];
$cod_terminal = $arreglo['cod_terminal'];
$sql = "SELECT * FROM terminal WHERE cod_terminal='$cod_terminal'";
$cad = mysql_query($sql , $conexion) or die(mysql_error()); 
$array = mysql_fetch_array($cad)


	?>
<table width="295" border="0">
  <tr>
    <td colspan="2" class="td">Datos del Material </td>
    </tr>
  <tr>
    <td width="109" class="td"><div align="right">Codigo : </div></td>
    <td width="170" class="td3"><?php echo $arreglo['id_material']; ?></td>
  </tr>
  <tr>
    <td class="td"><div align="right">Nombre : </div></td>
    <td class="td3"><?php echo $arreglo['nombre']; ?></td>
  </tr>
  <tr>
    <td class="td"><div align="right">Unidad Medida : </div></td>
    <td class="td3"><?php echo $arreglo['unidad_medida']; ?></td>
  </tr>
  <tr>
    <td class="td"><div align="right">Stock : </div></td>
    <td class="td3"><?php echo $arreglo['stock']; ?></td>
  </tr>
   <tr>
    <td class="td"><div align="right">Terminal : </div></td>
    <td class="td3"><?php echo $array['terminal']; ?></td>
  </tr>
</table>
<?php
$pg = $_GET['pg'];
if($pg > 0)
{
$pg = $pg -1 ;
}else{
$pg = 0;}
$cantidad=16; // cantidad de resultados por página
$inicial = $pg * $cantidad;

$consulta_salidas = "SELECT * FROM salidas WHERE material_id='$id_material' LIMIT $inicial,$cantidad";
$cadena_salidas = mysql_query($consulta_salidas , $conexion) or die(mysql_error()); 
  
$contar = "SELECT * FROM salidas  WHERE material_id='$id_material'"; 
$contarok= mysql_query($contar , $conexion) or die(mysql_error()); 
$total_records = mysql_num_rows($contarok);
$pages = intval($total_records / $cantidad);
$material = $_GET['nombre'];
$pagina = $_GET['pg'];
if($pagina == "")
{
$pagina= 1;
}
$total_pages = $pages + 1;
echo "<center><form METHOD='GET'><font class='normal'>".$total_pages." Paginas</font> <input align='center' type='textbox' size='1' value='".$pagina."' name='pg' class='cajatexto'>";
echo "<input type='submit' onclick='this.form.submit()' value='IR' class='btn'>
<input type='hidden' name='radioboton' value='nombre'>
<input type='hidden' name='nombre' value='".$material."'>
</form></center>"; 

if($total_records > 0)
{ 
?>

<table width="858">
<tr align=center class="td">
<td width="98">Código Salida</td>
<td width="74">Fecha</td>
<td width="210">Solicitante</td>
<td width="319">Observacón</td>
<td width="60">Cantidad</td>
<td width="69">Correo</td>
</tr>

<?php

$contador = 0;
$color=array("#ffffff","#D5EAEA");


 while($arreglo_salidas = mysql_fetch_array($cadena_salidas))
		{
		$contador ++;
?>
<tr bgcolor="<?php echo $color[$contador%2]; ?>"> 
<td class="td3"><div align="center"><?php echo $arreglo_salidas['id_salida'];?></div></td>
<td class="td3"><div align="center"><?php echo $arreglo_salidas['fecha'];?></div></td>
<td class="td3"><div align="center">
<?php 
$cod=$arreglo_salidas['solicitante'];
$cons_solic = "SELECT nombre FROM solicitantes WHERE id_solicitante='$cod'";
$cad_sol = mysql_query($cons_solic , $conexion) or die(mysql_error()); 
$array_sol = mysql_fetch_array($cad_sol);
echo $array_sol['nombre'];
?>
</div></td>
<td class="td3"><div align="center"><?php echo $arreglo_salidas['observacion'];?></div></td>
<td class="td3"><div align="center"><?php echo $arreglo_salidas['cantidad'];?></div></td>
<td class="td3"><div align="center"><a href="javascript:Abrir_Ventana('popup/correo_material.php?id=<?php echo $arreglo_salidas['id_salida']; ?>','ventana')"><img src="../imagenes/mail.gif" /></a></div></td>


</tr>
<?php } //CIERRE DEL WHILE
}else {echo "<div class='error'>NO HAY SALIDAS REGISTRADAS DE ESTE MATERIAL</div>";}
?>
</table>
	<?php 
		
	}else{echo "<div class='error'>NOMBRE DE MATERIAL NO EXISTE VERIFÍQUELO</div>";}
		?>
 
<?php
  }else{
 
 ?>
<?php

$pg = $_GET['pg'];
if($pg > 0)
{
$pg = $pg -1 ;
}else{
$pg = 0;}
$cantidad=12; // cantidad de resultados por página
$inicial = $pg * $cantidad;

$sql = "SELECT * FROM salidas ORDER BY id_salida LIMIT $inicial,$cantidad";
$cad = mysql_query($sql , $conexion) or die(mysql_error()); 

$contar = "SELECT * FROM salidas ORDER BY id_salida"; 
$contarok= mysql_query($contar , $conexion) or die(mysql_error()); 
$total_records = mysql_num_rows($contarok);
$pages = intval($total_records / $cantidad);
$pagina = $_GET['pg'];
if($pagina == "")
{
$pagina= 1;
}
echo "<center><form METHOD='GET'><font class='normal'>".$pages." Paginas</font> <input align='center' type='textbox' size='1' value='".$pagina."' name='pg' class='cajatexto'>";
echo "<input type='submit' onclick='this.form.submit()' value='IR' class='btn'></form></center>"; 
?>

<center>
<table width="858">
<tr align=center class="td">
<td width="92">Código Salida</td>
<td width="130">Nombre Material </td>
<td width="66">Fecha</td>
<td width="150">Solicitante</td>
<td width="259">Observacón</td>
<td width="60">Cantidad</td>
<td width="69">Correo</td>
</tr>

<?php
$contador = 0;
$color=array("#ffffff","#D5EAEA");

 while($array_salidas = mysql_fetch_array($cad))
 {
 $contador++;
 ?>
 
<tr bgcolor="<?php echo $color[$contador%2]; ?>"> 

<td class="td3"><div align="center"><?php echo $array_salidas['id_salida'];?></div></td>
<td class="td3"><div align="center"><a href="javascript:Abrir_Ventana('popup/datos_material.php?id=<?php echo $array_salidas['material_id']; ?>','ventana')">
<?php
$id_material = $array_salidas['material_id'];
$consulta = "SELECT nombre FROM materiales WHERE id_material='$id_material'";
$cadena = mysql_query($consulta , $conexion) or die(mysql_error()); 
if($arreglo = mysql_fetch_array($cadena))
{
echo $arreglo['nombre'];
}
 ?></a></div></td>
<td class="td3"><div align="center"><?php echo $array_salidas['fecha'];?></div></td>
<td class="td3"><div align="center">
<?php 
$cod=$array_salidas['solicitante'];
$cons_solic = "SELECT nombre FROM solicitantes WHERE id_solicitante='$cod'";
$cad_sol = mysql_query($cons_solic , $conexion) or die(mysql_error()); 
$array_sol = mysql_fetch_array($cad_sol);
echo $array_sol['nombre'];
?>

</div></td>
<td class="td3"><div align="center"><?php echo $array_salidas['observacion'];?></div></td>
<td class="td3"><div align="center"><?php echo $array_salidas['cantidad'];?></div></td>
<td class="td3"><div align="center"><a href="javascript:Abrir_Ventana('popup/correo_material.php?id=<?php echo $array_salidas['id_salida']; ?>','ventana')"><img src="../imagenes/mail.gif" /></a></div></td>
</tr>
<?php }

} ?>
</table>
</div>
</body>
</html>
