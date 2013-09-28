<?php
include"../global/global.php";
$nombre=$_REQUEST["nombre"];
$clasificacion=$_REQUEST["clasificacion"];
$unidad=$_REQUEST["unidad"];
$terminal=$_REQUEST["terminal"];
$stock_ini=$_REQUEST["stock_ini"];
$stock_crit=$_REQUEST["stock_crit"];


/* CHEKEO DE TRASPASO DE INFORMACION
print($nombre);
print("  ");
print($clasificacion);
print("  ");
print($unidad);
print("  ");
print($terminal);
print("  ");
print($stock_ini);
print("  ");
print($stock_crit);
print("  ");
*/
$consulta = "INSERT INTO materiales VALUES  ('','$clasificacion','$nombre','$unidad','$stock_ini','$terminal','$stock_crit')";
$consulta = mysql_query($consulta ) or die(mysql_error());
mysql_close($conexion);

echo "<center class='exito'> Se ha Ingresado Existosamente el Nuevo Material! </center>";






?>