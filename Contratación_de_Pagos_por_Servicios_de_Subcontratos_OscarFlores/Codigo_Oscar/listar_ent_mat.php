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
<title>Buscar entradas Material</title>
<link rel="stylesheet" href="../estilos/style.css" type="text/css" />
<script type="text/javascript" src="Ajax/myAjax.js"></script>
<script language="javascript" src="../scripts/script.js" type="text/javascript"></script>
<script language="javascript" src="../calendar/cal2.js"> </script>
<script language="javascript" src="../calendar/cal_conf2.js"></script>
</head>
<body onload="asignaVariables();">
<div id="maincontent">
  <form method="get"  action="" name="form">
   <input type="hidden" id = "archivo" value="buscar_entradas_material.php?" />
    <div class="normal" align="center">Selecciona Entradas de Material a Editar</div> 

    <table width="690" border="0" cellpadding="1" cellspacing="0" align="center">
  <tr>
    <td width="140" height="10" class="td" ><div align="right">Nombre Material
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
						 <div id="lista" onmouseout="v=1;" onmouseover="v=0;" align="left"></div>
         </div>
	    </div>	    </td>	
    <td width="142" class="td">
     </td></tr>
  <tr>
    <td width="140" height="11" class="td" ><div align="right">Fecha
      <input name="radioboton" type="radio" value="fecha"/>
</div></td>
    <td width="394" class="td">Desde :<span class="td2">
      <input name="desde" type="text" class="cajatexto" id="desde" size=12 readonly="true" autocomplete="off" />
    </span><a href="javascript:showCal('Desde')"><img src="../imagenes/calendar.gif" width="30" height="23" border="0" align="top" /></a>Hasta :<span class="td2">
    <input name="hasta" type="text" class="cajatexto" id="hasta" size="12" readonly="true" autocomplete="off" />
    <a href="javascript:showCal('Hasta')"><img src="../imagenes/calendar.gif" width="30" height="23" border="0" align="top" /></a></span></td>
    <td class="td"><div align="center">
      <input name="Busqueda" type="button" onclick="if (ver_radioBoton()){this.form.submit();}"  class="btn" value="Busqueda" />
    </div></td>
  </tr>
</table>
</form>
<?php
include"../global/global.php";
if($_GET["radioboton"]== "fecha")
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
$cantidad=12; // cantidad de resultados por página
$inicial = $pg * $cantidad;

$sql = "SELECT * FROM entradas WHERE fecha between  DATE '$desde' and  DATE  '$hasta' LIMIT $inicial,$cantidad";
$cad = mysql_query($sql, $conexion) or die(mysql_error());

$contar = "SELECT * FROM entradas  WHERE fecha between  DATE '$desde' and  DATE  '$hasta'"; 
$contarok= mysql_query($contar , $conexion) or die(mysql_error()); 
$total_records = mysql_num_rows($contarok);
$pages = intval($total_records / $cantidad);
$material = $_GET['nombre'];
$desde = $_GET['desde'];
$hasta =  $_GET['hasta'];
$pagina = $_GET['pg'];
if($pagina == "")
{
$pagina= 1;
}
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

<table width="873" align="center">
<tr align=center class="td">
<td width="44">Nº</td>
<td width="77">Fecha</td>
<td width="158">Nombre Mat</td>
<td width="55">Cantidad</td>
<td width="58">Valor</td>
<td width="97">Nº Factura</td>
<td width="139">Proveedor</td>
<td width="173">Solicitante</td>
<td width="32">OBS</td>
<td width="32">EDIT</td>
<td width="32">DEL</td>
</tr>
<?php  
$contador = 0;
$color=array("#ffffff","#D5EAEA");

 while($arreglo_fecha = mysql_fetch_array($cad))
		{
		$contador ++;
?>
<tr bgcolor="<?php echo $color[$contador%2]; ?>"> 
<td class="td3"><div align="center"><?php echo $arreglo_fecha['id_entrada'];?></div></td>
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
 ?>
</a></div></td>
<td class="td3"><div align="center"><?php echo $arreglo_fecha['cantidad']; ?></a></div></td>
<td class="td3"><div align="center"><?php echo $arreglo_fecha['precio_unitario'];?></div></td>
<td class="td3"><div align="center"><?php echo $arreglo_fecha['factura'];?></div></td>
<td class="td3"><div align="center"><?php echo $arreglo_fecha['proveedor'];?></div></td>
<td class="td3"><div align="center">
<?php 
$cod=$arreglo_fecha['solicitante'];
$cons_solic = "SELECT nombre FROM solicitantes WHERE id_solicitante='$cod'";
$cad_sol = mysql_query($cons_solic , $conexion) or die(mysql_error()); 
$array_sol = mysql_fetch_array($cad_sol);
echo $array_sol['nombre'];
?></div></td>
<td class="td3"><div align="center"><a href="javascript:Abrir_Ventana('popup/observacion_entrada_material.php?id=<?php echo $arreglo_fecha['material_id']; ?>','ventana')"><img src="../imagenes/ver.gif" border="0" /></a></td>
<td class="td3"><div align="center"><a href="editar_ent_mat.php?id_ent_mat=<?php echo $array_entradas['id_entrada'];?>" ><img src="../imagenes/b_edit.png"></div></td>
<td class="td3"><div align="center"><a href="eliminar_ent_mat.php?id_ent_mat=<?php echo $array_entradas['id_entrada'];?>" ><img src="../imagenes/borrar.png"></div></td>
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
		//echo $consulta;
?>
<center>
<?php if($arreglo = mysql_fetch_array($cadena))
 	{
$id_material = $arreglo['id_material'];

$pg = $_GET['pg'];
if($pg > 0)
{
$pg = $pg -1 ;
}else{
$pg = 0;}
$cantidad=12; // cantidad de resultados por página
$inicial = $pg * $cantidad;

$consulta_salidas = "SELECT * FROM entradas WHERE material_id='$id_material' LIMIT $inicial,$cantidad";
$cadena_salidas = mysql_query($consulta_salidas , $conexion) or die(mysql_error()); 

  
$contar = "SELECT * FROM entradas WHERE material_id='$id_material'"; 
$contarok= mysql_query($contar , $conexion) or die(mysql_error()); 
$total_records = mysql_num_rows($contarok);
$pages = intval($total_records / $cantidad);
$pagina = $_GET['pg'];
$material = $_GET['nombre'];
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

<table width="873"  align="center">
<tr align=center class="td">
<td width="44">Nº</td>
<td width="77">Fecha</td>
<td width="158">Nombre Mat</td>
<td width="55">Cantidad</td>
<td width="58">Valor</td>
<td width="97">Nº Factura</td>
<td width="139">Proveedor</td>
<td width="173">Solicitante</td>
<td width="32">OBS</td>
<td width="32">EDIT</td>
<td width="32">DEL</td>
</tr>

<?php  
$contador = 0;
$color=array("#ffffff","#D5EAEA");

 while($arreglo_entradas = mysql_fetch_array($cadena_salidas))
		{
		$contador ++;
?>
<tr bgcolor="<?php echo $color[$contador%2]; ?>"> 
<td class="td3"><div align="center"><?php echo $arreglo_entradas['id_entrada'];?></div></td>
<td class="td3"><div align="center"><?php echo $arreglo_entradas['fecha'];?></div></td>
<td class="td3"><div align="center"><a href="javascript:Abrir_Ventana('popup/datos_material.php?id=<?php echo $arreglo_entradas['material_id']; ?>','ventana')">
<?php
$id_material = $arreglo_entradas['material_id'];
$consulta = "SELECT nombre FROM materiales WHERE id_material='$id_material'";
$cadena = mysql_query($consulta , $conexion) or die(mysql_error()); 
if($arreglo = mysql_fetch_array($cadena))
{
echo $arreglo['nombre'];
}
 ?>
</a></div></td>
<td class="td3"><div align="center"><?php echo $arreglo_entradas['cantidad']; ?></a></div></td>
<td class="td3"><div align="center"><?php echo $arreglo_entradas['precio_unitario'];?></div></td>
<td class="td3"><div align="center"><?php echo $arreglo_entradas['factura'];?></div></td>
<td class="td3"><div align="center"><?php echo $arreglo_entradas['proveedor'];?></div></td>
<td class="td3"><div align="center"><?php 
	$cod=$arreglo_entradas['solicitante'];
	$cons_solic = "SELECT nombre FROM solicitantes WHERE id_solicitante='$cod'";
	$cad_sol = mysql_query($cons_solic , $conexion) or die(mysql_error()); 
	$array_sol = mysql_fetch_array($cad_sol);
	echo $array_sol['nombre'];
?></div></td>
<td class="td3"><div align="center"><a href="javascript:Abrir_Ventana('popup/observacion_entrada_material.php?id=<?php echo $arreglo_entradas['id_entrada']; ?>','ventana')"><img src="../imagenes/ver.gif" /></a></td>
<td class="td3"><div align="center"><a href="editar_ent_mat.php?id_ent_mat=<?php echo $array_entradas['id_entrada'];?>" ><img src="../imagenes/b_edit.png"></div></td>
<td class="td3"><div align="center"><a href="eliminar_ent_mat.php?id_ent_mat=<?php echo $array_entradas['id_entrada'];?>" ><img src="../imagenes/borrar.png"></div></td>
</tr>

<?php } //CIERRE DEL WHILE 
}else {echo "<div class='error'>EL MATERIAL NO REGISTRA ENTRADAS</div>";}
?>
</table>
	<?php 
		
	}else{echo "<div class='error'>NO SE ENCONTRO REGISTROS CON ESE NOMBRE DE MATERIAL</div>";}	
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

$sql = "SELECT * FROM entradas ORDER BY id_entrada LIMIT $inicial,$cantidad";
$cad = mysql_query($sql , $conexion) or die(mysql_error()); 

$contar = "SELECT * FROM entradas ORDER BY id_entrada"; 
$contarok= mysql_query($contar , $conexion) or die(mysql_error()); 
$total_records = mysql_num_rows($contarok);
$pages = intval($total_records / $cantidad);
$pagina = $_GET['pg'];
if($pagina == "")
{
$pagina= 1;
}
$total_pages = $pages + 1;
echo "<center><form METHOD='GET'><font class='normal'>".$total_pages." Paginas</font> <input align='center' type='textbox' size='1' value='".$pagina."' name='pg' class='cajatexto'>";
echo "<input type='submit' onclick='this.form.submit()' value='IR' class='btn'></form></center>"; 

?>
<center>
<table width="873" align="center">
<tr align=center class="td">
<td width="44">Nº</td>
<td width="77">Fecha</td>
<td width="158">Nombre Mat</td>
<td width="55">Cantidad</td>
<td width="58">Valor</td>
<td width="97">Nº Factura</td>
<td width="139">Proveedor</td>
<td width="173">Solicitante</td>
<td width="32">OBS</td>
<td width="32">EDIT</td>
<td width="32">DEL</td>
</tr>

<?php
$contador = 0;
$color=array("#ffffff","#D5EAEA");

 while($array_entradas = mysql_fetch_array($cad))
 {
 $contador++;
 ?>
<tr bgcolor="<?php echo $color[$contador%2]; ?>"> 
<td class="td3"><div align="center"><?php echo $array_entradas['id_entrada'];?></div></td>
<td class="td3"><div align="center"><?php echo $array_entradas['fecha'];?></div></td>
<td class="td3"><div align="center"><a href="javascript:Abrir_Ventana('popup/datos_material.php?id=<?php echo $array_entradas['material_id']; ?>','ventana')">
<?php
$id_material = $array_entradas['material_id'];
$consulta = "SELECT nombre FROM materiales WHERE id_material='$id_material'";
$cadena = mysql_query($consulta , $conexion) or die(mysql_error()); 
if($arreglo = mysql_fetch_array($cadena))
{
echo $arreglo['nombre'];
}
 ?>
</a></div></td>
<td class="td3"><div align="center"><?php echo $array_entradas['cantidad']; ?></a></div></td>
<td class="td3"><div align="center"><?php echo $array_entradas['precio_unitario'];?></div></td>
<td class="td3"><div align="center"><?php echo $array_entradas['factura'];?></div></td>
<td class="td3"><div align="center"><?php echo $array_entradas['proveedor'];?></div></td>
<td class="td3"><div align="center">
<?php 
$cod=$array_entradas['solicitante'];
$cons_solic = "SELECT nombre FROM solicitantes WHERE id_solicitante='$cod'";
$cad_sol = mysql_query($cons_solic , $conexion) or die(mysql_error()); 
$array_sol = mysql_fetch_array($cad_sol);
echo $array_sol['nombre'];
?>
</div></td>
<td class="td3"><div align="center"><a href="javascript:Abrir_Ventana('popup/observacion_entrada_material.php?id=<?php echo $array_entradas['material_id']; ?>','ventana')"><img src="../imagenes/ver.gif" /></a></td>
<td class="td3"><div align="center"><a href="editar_ent_mat.php?id_ent_mat=<?php echo $array_entradas['id_entrada'];?>" ><img src="../imagenes/b_edit.png"></div></td>
<td class="td3"><div align="center"><a href="eliminar_ent_mat.php?id_ent_mat=<?php echo $array_entradas['id_entrada'];?>" ><img src="../imagenes/borrar.png"></div></td>
</tr>
<?php } //FIN DEL WHILE
?>
</table>

<?php
// Creando los enlaces de paginación


 }
?>
</div>
</body>
</html>
