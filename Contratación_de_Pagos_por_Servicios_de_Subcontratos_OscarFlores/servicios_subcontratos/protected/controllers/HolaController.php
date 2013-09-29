<?php
#http://localhost/Modulos_CPI/Contrataci%C3%B3n_de_Pagos_por_Servicios_de_Subcontratos_OscarFlores/servicios_subcontratos/hola/index.php
class HolaController extends Controller 
{
	 public function actionIndex()
	{
		$itecsys="@iTecSys";
		$this->render("index",array("itecsys"=>$itecsys));
	}
}