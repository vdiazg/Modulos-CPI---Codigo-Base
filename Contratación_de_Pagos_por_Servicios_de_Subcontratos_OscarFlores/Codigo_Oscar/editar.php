<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<link rel="stylesheet" href="css/table.css" type="text/css"/>
<script language="javascript" src="calendar/cal2.js"> </script>
<script language="javascript" src="calendar/cal_conf2.js"></script>
<meta http-equiv="X-UA-Compatible" content="IE=8" />
<script type="text/javascript" defe="defe"></script>
<?php
error_reporting(E_ALL ^ E_NOTICE);

include"global.php";

$cod_hbl=$_REQUEST['cod_hbl'];
$sql_hbl="select * from hbl where cod_hbl='".$cod_hbl."'";
$cad_hbl=mysql_query($sql_hbl, $conexion);
$array_hbl=mysql_fetch_array($cad_hbl);
$año = date("Y");  
$mes= date("m");  
$dia = date("d");

//RECUPERAR DATOS PARA actualizacion

$hbl_temp = $_REQUEST['hbl'];

$hbl =$_REQUEST['hbl'];
$place =$_REQUEST['place'];
$pol =$_REQUEST['pol'];
$pod =$_REQUEST['pod'];
$nave =$_REQUEST['nave'];
$fecha_salida =$_REQUEST['fecha_salida'];
$fecha_eta =$_REQUEST['fecha_eta'];
$fecha_desc =$_REQUEST['fecha_desc'];
$contenedor =$_REQUEST['contenedor'];
$peso_documental =$_REQUEST['peso_documental'];


if(isset($_REQUEST["actualiza"])){
		$sql_up="update hbl set place='".$place."', POL='".$pol."', POD='".$pod."', nave='".$nave."', fecha_salida='".$fecha_salida."', ETA='".$fecha_eta."', fecha_desc='".$fecha_desc."', contenedor='".$contenedor."', peso_documental='".$peso_documental."' where cod_hbl = '".$cod_hbl."' ";
		$consulta = mysql_query($sql_up, $conexion ) or die(mysql_error());
		echo "<script language='javascript'>alert('HBL se actualizo con exito!');history.go(-2);</script>";
		}


?>
</head>
<body>
<center><img src="editar_hbl.png"> 
<form name="form">
<table id='itsthetable'>
	<input type="hidden" name="cod_hbl" value="<?php echo $array_hbl['cod_hbl'];?>">
	<tr><th>Numero HBL <td><?php echo $array_hbl['HBL'];?>
	<tr><th>Place of Receipt <td><input type="text" name="place"
	value="<?php echo $array_hbl['place'];?>">




	<tr><th>POL	 <td><SELECT NAME="pol">
	<option value="">---SELECCIONE---
<?php
	$sql_pol="select * from pol";
	$cad_pol=mysql_query($sql_pol, $conexion);
	while ($array_pol=mysql_fetch_array($cad_pol)){
		echo "<option value='";	
		echo $array_pol['cod_pol'];	
		echo "' ";
		if ($array_pol['cod_pol']==$array_hbl['POL'])
		    echo "selected";
		echo ">";
		echo $array_pol['pol'];
	};	
?>
				</select>
	<tr><th>POD	 <td><select name="pod">
	<option value="">---SELECCIONE---
<?php
	$sql_pod="select * from pod";
	$cad_pod=mysql_query($sql_pod, $conexion);
	while ($array_pod=mysql_fetch_array($cad_pod)){
		echo "<option value='";	
		echo $array_pod['cod_pod'];	
		echo "' ";
		if ($array_pod['cod_pod']==$array_hbl['POD'])
		    echo "selected";
		echo ">";
		echo $array_pod['pod'];
	};	
?>
				</select>

	<tr><th>Nave	<td><select name="nave">
	<option value="">---SELECCIONE---
<?php
	$sql_nave="select * from nave";
	$cad_nave=mysql_query($sql_nave, $conexion);
	while ($array_nave=mysql_fetch_array($cad_nave)){
		echo "<option value='";	
		echo $array_nave['cod_nave'];	
		echo "' ";
		if ($array_nave['cod_nave']==$array_hbl['nave'])
		    echo "selected";
		echo ">";
		echo $array_nave['nave'];
	};	
?>						</select>



	
	<tr><th>Fecha Salida	 
	<td>
    <input class="input" name="fecha_salida" type="text" size="12" readonly="true" autocomplete="off"
    value="<?php echo $array_hbl['fecha_salida'];?>">
    <a href="javascript:showCal('Calendar6')"><img src="calendar.gif" width="30" height="23" border="0" align="top" /></a>
	
	<tr><th>ETA
	<td>
    <input class="input" name="fecha_eta" type="text" size="12" readonly="true" autocomplete="off"
    value="<?php echo $array_hbl['ETA'];?>">
    <a href="javascript:showCal('Calendar7')"><img src="calendar.gif" width="30" height="23" border="0" align="top" /></a>
	
	<tr><th>Fecha Desconsolidado
	<td>
    <input class="input" name="fecha_desc" type="text" size="12" readonly="true" autocomplete="off"
    value="<?php echo $array_hbl['fecha_desc'];?>">
    <a href="javascript:showCal('Calendar8')"><img src="calendar.gif" width="30" height="23" border="0" align="top" /></a>
	
	
    <tr><th>Contenedor<td><input type="text" name="contenedor"
    value="<?php echo $array_hbl['contenedor'];?>">

	<tr><th>Peso Documental<td><input type="text" name="peso_documental"
    value="<?php echo $array_hbl['peso_documental'];?>">
</table>
<center>
<table id='itsthetable'>
	<tr><td><input type="submit" value="Actualizar" name="actualiza"><td><input type="reset" value="Cancelar">
	<td><input type="button" name="volver"  value="volver" onclick="history.back()">
</table>
</form>
</body>
</html>