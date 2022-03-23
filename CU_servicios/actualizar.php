<?php 
require('../includes.php');
//require('proceso.php');

define("conect","../../framework/db/CX_SIS.php");
$conector=$ObjDbPG->classdb(conect);
$conector=$ObjDbPG->conectar();

//SERVICIOS EN BASE DE DATOS//
			
$parametros=array();
$consultaServicios=$ObjDbPG->SELECT("consultar_todosservicios",$parametros);			
$comboServicios = '<select class="form-control" id="servSelec" name="servSelec" style="width:200px">';
foreach($consultaServicios as $valor)
{
	if($valor[0]==0)
	{
		$comboServicios.='<option value="0">NO SE ENCONTRARON REGISTROS</option>';	
		$mensaje= '<link rel="stylesheet" href="estilos.css"> 
		<br><br><br><br><br><br><br><br>
		<form class="centrarCaja" method="POST" name="form1" action="proceso.php" id="form1">
			<div class="form-group panel panel-default col-md-12" id="cajaServicios" name="cajaServicios" style="center">
			 <label for="servSelec">Servicios Activos</label>
				 '.$comboServicios.'
		';
	}
	else
	{
		$comboServicios.='<option value='. $valor [0] . '>' . $valor[1] .'</option>';	
		
	}
}
$comboServicios.='</select>';
$comboServicios;

$mensaje= '<link rel="stylesheet" href="estilos.css"> 
<br><br><br><br><br><br><br><br>
<form class="centrarCaja" method="POST" name="form1" action="proceso.php" id="form1">
	<div class="form-group panel panel-default col-md-12" id="cajaServicios" name="cajaServicios" style="center">
	 <label for="servSelec">Servicios Activos</label>
		 '.$comboServicios.'
 		<button class="btn btn-primary" role="button" onclick="enviarSeleccion()">
 		  <img src="imagenes/xmag_search_find_export_locate_5984.png" height="20" width="20"></img>Buscar</button>

 	</div>
</form>
<a href="javascript:history.back()" class="centrado">
  <img src="imagenes/arrow_left_15601.png" height="30" width="30"></img>Regresar
</a>

		 	</div>
		</form>

<style>
    .centrado
    {
    margin:150px auto;
    font-size: 16px; /*tamaño de la letra*/
    color: black; /*color de la letra*/
    height: 50px;
    display:block;
    font-weight: normal;
    top: 1000px;
    }  
</style>

';



$html->salidaFinal($tituloPagina='Registro de Estatus',$Nmenu='menu2',$mensaje);
?>

