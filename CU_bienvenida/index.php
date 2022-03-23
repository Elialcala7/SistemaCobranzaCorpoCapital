<?php 
require("../includes.php");
//require ("../head.php");
//session_start();
//Clase de base de DatosObjDbPG = new bd();
define("conect","../../framework/db/CX_SIS.php");
$conector=$ObjDbPG->classdb(conect);
$conector=$ObjDbPG->conectar();	

$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

//print_r($_SESSION);exit();
$parametros=array();
$parametros[0]=$_SESSION['nivel_ED'];
$consulta_tipoNivel=$ObjDbPG->SELECT("consultar_nivel_especifico",$parametros);
$nivel=$consulta_tipoNivel[0][0];

$mensaje='
	<div>
	 <form name="form_login" id="form_login" method="post">
		<div class="centrado">
			<h5>'.$consulta_tipoNivel[0][0].': '.$_SESSION['nombre_ED'].' '.$_SESSION['apellido_ED'].' </h5>
			<h6> '.$dias[date('w')]."".','." ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y').' </h6>
			<h6> CorpoCapital. </h6>
		</div>
	 </form>
	</div>
		
		
<style>
	.centrado
	{
	margin:500px auto;
	display:block;
	}

	
</style>


    ';
$html->salidaFinal($tituloPagina="Página Principal",$menu="menu2",$mensaje);
?> 