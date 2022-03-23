<?php
/*class inicializar 
{
	function inicializar()
	{*/
		session_start();
		//ini_set("display_errors",'On');
		//error_reporting(1);
		//error_reporting(E_ALL);
		$self = $_SERVER['PHP_SELF'];
		$contarDirectorios=explode("/",$self);	
		$niveles_atras=count($contarDirectorios)-2;
		$base="";
		for($a=1;$a<$niveles_atras;$a++)
		{
			$base.="../";
		}
		require_once($base."framework/librerias/phpmailer_v5.1/class.phpmailer.php");
		require_once($base."framework/marco_html/html.php");
		require_once($base."framework/librerias/herramientas.php");		
		require_once($base."framework/db/classdbPG.php");//funcion para las consultas bd
		$conexion=$base."framework/db/CX_SIS.php";//funcion para las consultas		
		
		$html = new Html();		
		$ObjDbPG = new bd();
		$herramientas=new herramientas();
		$conector=$ObjDbPG->classdb($conexion);
		$conector=$ObjDbPG->conectar();
	/*}
}*/
?>