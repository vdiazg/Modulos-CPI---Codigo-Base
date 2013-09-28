
<link rel="stylesheet" href="css/table.css" type="text/css"/>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" href="css/table.css" type="text/css"/>

<style type="text/css">
 img.pequeña{width: 50px; height: 20px;}
 img.mediana{width: 100px; height: 100px;}
 img.grande{width: 200px; height: 200px;}
</style>
</head>
<center><img src="listarCamion.png"> 
<div align="center">
<table width="150" align="center" id='itsthetable'>
     <tr> 
      <td width="50" height="80"><font face="verdana"><b>codigo patente</b></font></td> 
     <td width="64"><div align="left"><font face="verdana"><b>peso verificador</b></font></div></td> 
     <td width="50"><font face="verdana"><b>peso documental</b></font></td>  
    <td width="87"><font face="verdana"><b>peso nietobl</b></font></td>    
	<td width="41"><font face="verdana"><b>diferencia automatica</b></font></td> 
	 <td width="64"><font face="verdana"><b>rut chofer</b></font></td> 
     <td width="50"><font face="verdana"><b>nombre</b></font></td>  
    <td width="87"><font face="verdana"><b>fono</b></font></td>    
<?php
include"global.php";
?>
<?php
 $query = "SELECT camion.cod_patente, camion.peso_verificador,camion.peso_documental,camion.peso_nietobl,camion.diferencia_automatica,chofer.rut_chofer,chofer.nombre,chofer.fono FROM camion,chofer
WHERE camion.cod_patente
AND chofer.cod_patente = camion.cod_patente";   	
$result = mysql_query($query);     while($row = mysql_fetch_array($result))    {   
echo "<tr><td width=\"25%\"><font face=\"verdana\">" .   	$row["cod_patente"] . "</font></td>";      
echo "<td width=\"25%\"><font face=\"verdana\">" .   	    $row["peso_verificador"] . "</font></td>";      
echo "<td width=\"25%\"><font face=\"verdana\">" .   	    $row["peso_documental"] . "</font></td>";    
echo "<td width=\"25%\"><font face=\"verdana\">" .   	    $row["peso_nietobl"] . "</font></td>";    
echo "<td width=\"25%\"><font face=\"verdana\">" .   	    $row["diferencia_automatica"]. "</font></td>"; 
echo "<td width=\"25%\"><font face=\"verdana\">" .   	    $row["rut_chofer"] . "</font></td>";    
echo "<td width=\"25%\"><font face=\"verdana\">" .   	    $row["nombre"] . "</font></td>";    
echo "<td width=\"25%\"><font face=\"verdana\">" .   	    $row["fono"]. "</font></td></tr>";        
}

mysql_free_result($result);    
?>
</table>
<p>&nbsp;</p>
<p><img src="simbolo.png" width="65" height="49" /></p>
