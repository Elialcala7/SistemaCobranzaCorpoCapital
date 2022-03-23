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
		$result = pg_query("SELECT COUNT(*) AS recordcount FROM servicios where status_servicio=1;");
		$row = pg_fetch_array($result);
		$recordCount = $row['recordcount'];
		//Lista
		$result = pg_query("SELECT * FROM servicios where status_servicio=1 ORDER BY " . $_GET["jtSorting"] . " LIMIT " . $_GET["jtPageSize"] . " OFFSET " . $_GET["jtStartIndex"] . ";");
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

		$monto=trim($_POST["monto_servicio"]);
		$tipoplan=(trim($_POST["id_plan"]));

		//**********validar si campo cédula es numerico******
		if(!is_numeric($monto))
		{
			throw new Exception('El Monto debe expresarse en números sin comas(,) ni puntos(.)');
			return;
		}
		//****************************************************
		$fecha = date("d/m/Y");
		$nombre=strtoupper(trim($_POST["nombre_servicio"]));
		$contenido=strtoupper(trim($_POST["contenido_servicio"]));

		//***************insert en la BD**********************	
		$parametros=array();
		$parametros[0]=$nombre;
		$parametros[1]=$contenido;
		$parametros[2]=$monto;
		$parametros[3]=$tipoplan;
		
				
		$Insertar=$ObjDbPG->SELECT("insertar_servicio",$parametros);
	

		$IdServicio = $Insertar[0][0];	
	
	   //Hicostorico de Costos//

		$param=array();
		$param[0]=$fecha;
		$param[1]=$monto;
		$param[2]=$IdServicio;
		$param[3]=0;

		$InsertarMontos=$ObjDbPG->SELECT("insertar_costos",$param);

		//Hicostorico de Seguridad//
		$usuario=$_SESSION['cedula_ED'];
		$ip='SIN DESCRIPCION DEL EQUIPO';
		$movimiento ='NUEVO  SERVICIO';

		$valores=array();
		$valores[0]=$fecha;
		$valores[1]=$usuario;
		$valores[2]=$ip;
		$valores[3]=$movimiento;
		$valores[4]=$IdServicio;
		$InsertarSeguridad=$ObjDbPG->SELECT("insertar_seguridad",$valores);

		//**********mensaje de error no insertó registro******
		if($IdServicio==0)
		{
			throw new Exception('No se pudo realizar el Registro, verificar información');
			return;
		}
		//****************************************************

		$result = pg_query("SELECT * FROM servicios");		
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
		//Hicostorico de Seguridad//
		$fecha = date("d/m/Y");
		$usuario=$_SESSION['cedula_ED'];
		$ip='SIN DESCRIPCION DEL EQUIPO';
		$movimiento ='ELIMINACIÒN DEL SERVICIO';

		$valor=array();
		$valor[0]=$fecha;
		$valor[1]=$usuario;
		$valor[2]=$ip;
		$valor[3]=$movimiento;
		$valor[4]=$_POST["id_servicio"];
		$InsertarSeguridad=$ObjDbPG->SELECT("insertar_seguridad",$valor);


		$parametros=array();
		$parametros[0]=$_POST["id_servicio"];
		$row=$ObjDbPG->SELECT("eliminar_servicio",$parametros);

			
	
		//Exportamos los datos json
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		$jTableResult['Record'] = $row;
		print json_encode($jTableResult);
	}

	//Actualizar registro
	else if($_GET["accion"] == "editar")
	{ 
		//Datos a actualizar		
		$parametros=array();
		$parametros[0]=$_POST["id_servicio"];
		$parametros[1]=trim($_POST["nombre_servicio"]);
		$parametros[2]=strtoupper(trim($_POST["contenido_servicio"]));
		$parametros[3]=strtoupper(trim($_POST["id_plan"]));	

		$row=$ObjDbPG->SELECT("editar_servicio",$parametros);

		//Hicostorico de Seguridad//
		$fecha = date("d/m/Y");
		$usuario=$_SESSION['cedula_ED'];
		$ip='SIN DESCRIPCION DEL EQUIPO';
		$movimiento ='ACTUALIZACIÓN DEL SERVICIO';

		$valor=array();
		$valor[0]=$fecha;
		$valor[1]=$usuario;
		$valor[2]=$ip;
		$valor[3]=$movimiento;
		$valor[4]=$_POST["id_servicio"];
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
