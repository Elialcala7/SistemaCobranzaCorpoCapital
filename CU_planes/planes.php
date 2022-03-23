<?php
require("../../framework/db/classdbPG.php");

session_start();

$ObjDbPG = new bd();
define("conect","../../framework/db/CX_SIS.php");
$conector=$ObjDbPG->classdb(conect);
$conector=$ObjDbPG->conectar();
try 
{
	//Listar registros
    if($_GET["accion"] == "lista")
	{			
		$result = pg_query("SELECT COUNT(*) AS recordcount FROM planes where status=1;");
		$row = pg_fetch_array($result);
		$recordCount = $row['recordcount'];
		//Lista
		$result = pg_query("SELECT * FROM planes where status=1 ORDER BY " . $_GET["jtSorting"] . " LIMIT " . $_GET["jtPageSize"] . " OFFSET " . $_GET["jtStartIndex"] . ";");
		//Agrego los registros en un array
		$rows = array();
		while($row = pg_fetch_array($result))
		{
			$rows[] = $row;	
		}		
		//Exportamos los datos json
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		$jTableResult['TotalRecordCount'] = $recordCount;
		$jTableResult['Records'] = $rows;
		print json_encode($jTableResult);
	}


	//Crear nuevo registro
	else if($_GET["accion"] == "crear")
	{	
		$parametros=array();
		$parametros[0]=strtoupper($_POST["descripcion"]);
		
		$Insertar=$ObjDbPG->SELECT("insertar_plan",$parametros);

		$registroPlan = $Insertar[0][0];	

		//**********mensaje de error no insertó registro******
		if($registroPlan==0)
		{
			throw new Exception('No se pudo realizar el Registro, verificar información');
			return;
		}
		//****************************************************

		//Hicostorico de Seguridad//
		$fecha = date("d/m/Y");
		$usuario=$_SESSION['cedula_ED'];
		$ip='SIN DESCRIPCION DEL EQUIPO';
		$movimiento ='PLAN NUEVO';

		$valor=array();
		$valor[0]=$fecha;
		$valor[1]=$usuario;
		$valor[2]=$ip;
		$valor[3]=$movimiento;
		$valor[4]=$registroPlan;
		$InsertarSeguridad=$ObjDbPG->SELECT("insertar_seguridad",$valor);

		$result = pg_query("SELECT * FROM planes ");		
		$row = pg_fetch_array($result);	
		//Exportamos los datos json
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		$jTableResult['Record'] = $row;
		print json_encode($jTableResult);
	}
	
	//Eliminar registro
	else if($_GET["accion"] == "eliminar")
	{		
		$parametros=array();
		$parametros[0]=$_POST["id_plan"];
		$row=$ObjDbPG->SELECT("eliminar_plan",$parametros);

		//Hicostorico de Seguridad//
		$fecha = date("d/m/Y");
		$usuario=$_SESSION['cedula_ED'];
		$ip='SIN DESCRIPCION DEL EQUIPO';
		$movimiento ='ELIMINAR EL PLAN';

		$valor=array();
		$valor[0]=$fecha;
		$valor[1]=$usuario;
		$valor[2]=$ip;
		$valor[3]=$movimiento;
		$valor[4]=$_POST["id_plan"];
		$InsertarSeguridad=$ObjDbPG->SELECT("insertar_seguridad",$valor);
	
		//Exportamos los datos json
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		$jTableResult['Record'] = $row;
		print json_encode($jTableResult);
	}
}
catch(Exception $ex)
{
	//Devuelve mensaje de error
	$jTableResult = array();
	$jTableResult['Result'] = "ERROR";
	$jTableResult['Message'] = $ex->getMessage();
	print json_encode($jTableResult);
}
?>
