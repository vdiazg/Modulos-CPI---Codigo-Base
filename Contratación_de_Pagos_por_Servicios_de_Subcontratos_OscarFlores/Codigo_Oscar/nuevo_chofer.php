<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" href="css/table.css" type="text/css"/>

<!--validacion para letras, numeros, rut-->
<script>
    function LetrasNumeros(e){
       key = e.keyCode || e.which;
       tecla = String.fromCharCode(key).toLowerCase();
       letras = " abcdefghijklmnopqrstuvwxyz0123456789";
       especiales = [8,37,39,46];

       tecla_especial = false
       for(var i in especiales){
            if(key == especiales[i]){
                tecla_especial = true;
                break;
            }
        }

        if(letras.indexOf(tecla)==-1 && !tecla_especial){
            return false;
        }
    }

    function SoloLetras(e){
       key = e.keyCode || e.which;
       tecla = String.fromCharCode(key).toLowerCase();
       letras = " abcdefghijklmnopqrstuvwxyz";
       especiales = [8,37,39,46];

       tecla_especial = false
       for(var i in especiales){
            if(key == especiales[i]){
                tecla_especial = true;
                break;
            }
        }

        if(letras.indexOf(tecla)==-1 && !tecla_especial){
            return false;
        }
    }

     function SoloRut(e){
       key = e.keyCode || e.which;
       tecla = String.fromCharCode(key).toLowerCase();
       letras = "0123456789kK";
       especiales = [8,37,39,46];

       tecla_especial = false
       for(var i in especiales){
            if(key == especiales[i]){
                tecla_especial = true;
                break;
            }
        }

        if(letras.indexOf(tecla)==-1 && !tecla_especial){
            return false;
        }
    }
	function SoloNumeros(e){
       key = e.keyCode || e.which;
       tecla = String.fromCharCode(key).toLowerCase();
       letras = "0123456789";
       especiales = [8,37,39,46];

       tecla_especial = false
       for(var i in especiales){
            if(key == especiales[i]){
                tecla_especial = true;
                break;
            }
        }

        if(letras.indexOf(tecla)==-1 && !tecla_especial){
            return false;
        }
    }
</script>

<script type="text/javascript">
    function valida(){
        var cod_patente=document.getElementById('cod_patente').valueOf();
        if(cod_patente==''){
            alert('campo obligatorio');
            return;
        }        
    }
</script>
</head>


<center><img src="nuevoss.png"> 
<form name="form">
  <div align="center">
    <table width="322" height="200" id='itsthetable'>
      <input type="hidden" name="cod_hbl" value="<?php echo $array_hbl['cod_hbl']?>">
      <tr>
        <th colspan="2">Ingresar  Datos  
      <tr>
        <th>N&deg; Patente 
        <td><label>
          		  <input name="cod_patente" type="text" id="cod_patente" onkeypress="return LetrasNumeros(event)"  maxlength="6" />
          </label>
      <tr>
	   <th>Peso Verificado 
	   <td><input name="peso_verificador" type="text" id="peso_verificador" onkeypress="return SoloNumeros(event)"  maxlength="12" />
      <tr>
	    <th>Peso Documental 
        
	    <td><input name="peso_documental" type="text" id="peso_documental" maxlength="12" onkeypress="return SoloNumeros(event)">
      <tr>
	    <th>Peso Nieto Bl 
        
	    <td><input name="peso_nietobl" type="text" id="peso_nietobl" maxlength="12" onkeypress="return SoloNumeros(event)">
      <tr>
	    <th>Diferencia Automat&iacute;ca 
        
	    <td><input name="diferencia_automatica" type="text" id="diferencia_automatica" maxlength="12" onkeypress="return SoloNumeros(event)">
    <tr>
	    <th>Rut
	    <td><input name="rut_chofer" type="text" id="rut_chofer" maxlength="9" onkeypress="return SoloRut(event)">
    <tr>
	    <th>Nombre
	    <td><input name="nombre" type="text" id="nombre" maxlength="30" onkeypress="return SoloLetras(event)">
    <tr>
	    <th>Fono
	    <td><input name="fono" type="text" id="fono" maxlength="10" onkeypress="return SoloNumeros(event)">
  
      <tr>
    </table>
    <center>
  </div>
  <div align="center">
  <table width="201" id='itsthetable'>
    <tr><td><input type="submit" onclick="valida()" value="Ingresar" name="ingresar"><td><input type="reset" value="Limpiar Campos">
    </table>
</div>
</form>

<?php
error_reporting(E_ALL ^ E_NOTICE);
            
include"global.php";

$cod_patente =$_REQUEST['cod_patente'];
$peso_verificador =$_REQUEST['peso_verificador'];
$peso_documental =$_REQUEST['peso_documental'];
$peso_nietobl =$_REQUEST['peso_nietobl'];
$diferencia_automatica =$_REQUEST['diferencia_automatica'];
$rut_chofer=$_REQUEST['rut_chofer'];
$nombre=$_REQUEST['nombre'];
$fono=$_REQUEST['fono'];



if(isset($_REQUEST["ingresar"])==" ") {

$sql_in= "insert into camion(cod_patente,peso_verificador,peso_documental,peso_nietobl,diferencia_automatica)
values ('$cod_patente','$peso_verificador','$peso_documental', '$peso_nietobl','$diferencia_automatica')";

$sql_ini= "insert into chofer(cod_patente,rut_chofer,nombre,fono)
values ('$cod_patente','$rut_chofer','$nombre', '$fono')";

$ingresando=mysql_query ($sql_in, $conexion) or die (mysql_error());
				
$ingresando=mysql_query ($sql_ini, $conexion) or die (mysql_error());


echo "<script language='javascript'>alert('Datos Ingresados Correctamente');window.close();</script>";
}
?>
</html>