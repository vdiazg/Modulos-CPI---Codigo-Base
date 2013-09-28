<link rel="stylesheet" href="css/table.css" type="text/css"/>

<script language="JavaScript" type="text/javascript">

function EditarNbl(NBL)
{
ruta='editar_nbl.php?cod_nbl='+NBL;

window.open(ruta,'Ingreso datos al NBL','width=500,height=650,menubar=no,scrollbars=no,toolbar=no,location=no,directories=no,resizable=no,top=10%,left=20%');
}


function abreIframe (URL){ 
	window.open(URL, target="NBL") ;
}
  
function menus_in(){
	document.body.style.cursor ='pointer';
}

function menus_out(){
	document.body.style.cursor ='default';
}

function busca_nbl(HBL){
  abreIframe("listar_nbl.php?hbl=" + HBL);  
}

function abreHBL (URL){ 
	window.open(URL, target="HBL") ;
}

</script>

<style type="text/css">

 img.pequeña{width: 20px; height: 20px;}
 img.mediana{width: 100px; height: 100px;}
 img.grande{width: 200px; height: 200px;}

</style>



<?php
$hbl =$_REQUEST['hbl'];
$peso_documental =$_REQUEST['peso_documental'];
$peso_verificado=$_REQUEST['peso_verificado'];
$diferencia=$_REQUEST['diferencia'];


?>
<?php

error_reporting(E_ALL ^ E_NOTICE);

include"global.php";
$hbl=$_REQUEST['hbl'];

$sql="select *  from nbl where cod_hbl = '".$hbl."'";
$cadena=mysql_query($sql, $conexion) or die (mysql_error());




?>
<center>
<table id='itsthetable' align="center">
<center>
<tr>
<th>N°NBL
<th>Retiro de Carga
<th>Encargado
<th>Fecha Ingreso AEP
<th>N° Tarja
<th>Status Desconsolidacion
<th>Fecha Reporte Fotografico
<th>Fecha Reporte VideoTarja
<th>Fecha Retiro AEP
<th>Dias Almacenaje
<th>Tipo Camion
<th>Fecha Recepcion Cliente
<th>Hora Inicio Faena
<th>Hora Termino
<th>Peso Verificado 
<th>Diferencia 
<th>N° Patente
<th>Nombre Chofer
<th>EDIT

<?php
function n_dias($fecha_desde,$fecha_hasta)
{
$dias= (strtotime($fecha_desde)-strtotime($fecha_hasta))/86400;
$dias = abs($dias); $dias = floor($dias);
return  $dias;
}



$diferencia=$dif;
$total_dias=15;
	while ($array = mysql_fetch_array($cadena)){
		
		echo "<tr><td>";
		echo $array['NBL'];

// *******************************************		
		echo "<td>";
		if ($array['tipo_retiro']=='1'){
			echo "Directo";
			}else echo "Indirecto";

// *******************************************
		echo "<td>";
		$sql_enc="select * from encargado where encargado='".$array['encargado']."'";
		$cad_enc=mysql_query($sql_enc, $conexion) or die (mysql_error());
		$array_enc=mysql_fetch_array($cad_enc);
		echo $array_enc['nombre'];		

// *******************************************
		echo "<td>";
		echo $array['fecha_in_jaula'];		
		echo "<td>";
		echo $array['num_tarja_desp'];			

// *******************************************
		echo "<td>";
		if ($array['status_desc']=='1'){
			echo "Normal";
			}else echo "Reparos";	

// *******************************************

		echo "<td>";
		echo $array['fecha_rep_foto'];		
		echo "<td>";
		echo $array['fecha_rep_video'];		
		echo "<td>";
		echo $array['fecha_out_jaula'];				

//********************************************
		echo "<td>";
	    $total_dias=n_dias($array['fecha_in_jaula'],$array['fecha_out_jaula']);    
		echo $total_dias;

// *******************************************
		echo "<td>";
		if ($array['tipo_camion']=='1'){
			echo "Abierto";
			}else echo "Cerrado";	

 // *******************************************
        echo "<td>";
		echo $array['fecha_recep_cliente'];
		
		echo "<td>";
		echo $array['hora_inicio'];
		
		echo "<td>";
		echo $array['hora_fin'];
		
		echo "<td>";
		echo $array['peso_verificado'];	
   //********************************************* lo que podria ser
        echo "<td>";
	    $diferencia=diferencias($array['peso_documental'],$array['peso_verificado']); 
		echo $diferencia;
  // ******************************************* lo que tenia  
		echo $array['$diferencia'];
   // *******************************************	
		echo "<td>";
		echo $array['patente_camion'];
		
		echo "<td>";
		echo $array['nombre_chofer'];
		
		echo "<td>";
		echo "<img class='pequeña' src='archivador2.png' onmouseout='menus_out()' onmouseover='menus_in()' onclick='EditarNbl(".$array['cod_nbl'].")'>";

	// *******************************************
	
		
	};

?>
</table>
