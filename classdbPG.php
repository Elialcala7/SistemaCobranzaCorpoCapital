<?php
class bd
{
	var $dbName="", $dbLogin="", $dbPassword="", $dbServidor="", $dbPuerto="";
	var $conElem="";
	/*
	Constructor de la aplicación, se le envia por parametro la ruta del archivo
	que contiene la informacion necesaria para establecer la conexiond de la base
	de datos, Este archivo debe tener:
	$archivoName: Tiene el nombre de la Base de Datos
	$archivoLogin: Tiene el login de la Base de Datos
	$archivoPas: Tiene el password de la Base de Datos
	$archivoServidor: Contiene el Root de la Base de Datos
	$archivoPuerto: Contiene el número del puerto
	*/
	function classdb($archivoInfoDb)
	{
		require($archivoInfoDb);
		$this->dbName=$archivoName;
		$this->dbLogin=$archivoLogin;
		$this->dbPassword=$archivoPas;
		$this->dbServidor=$archivoServidor;
		$this->dbPuerto=$archivoPuerto;
	}
	
	////FUNCIÓN PARA CONECTAR////
	function conectar()
	{
		$conexion = pg_connect("host=".$this->dbServidor." port=".$this->dbPuerto." dbname='".$this->dbName."' user=".$this->dbLogin." password=".$this->dbPassword);
		if($conexion)
		{
			///echo "Conexión Exitosa";
			return $conexion;
		}
		else
		{
			echo pg_errormessage($conexion);
			exit;
		}
	}
	function fdbDesConexion($conexion="")
	{
		pg_close();
	}
	function iniciarTransaccion($conexion="")
	{
		return pg_query ("BEGIN WORK");
	}	
	function aceptarTransacciones($conexion="")
	{
		return pg_query ("COMMIT");
	}	
	function cancelarTransaccion($conexion="")
	{
		return pg_query ("ROLLBACK");
	}	
	function SELECT($funcion, $parametros)
	{
		if(count($parametros)>1)
		{
			$parametrosSeparados="";
			if(count($parametros)==1)
			{
				$parametrosSeparados.="'".$datos."'";
			}
			else
			{
				foreach($parametros as $indice=>$datos)
				{
					if($indice==0)
					{
						$parametrosSeparados.="'".$datos."',";
					}
					elseif($indice==1)
					{
						$parametrosSeparados.="'".$datos."'";
					}
					else
					{
						$parametrosSeparados.=",'".$datos."'";
					}
				}
			}
		}
		elseif(count($parametros)==1)
		{
			$parametrosSeparados="'".$parametros[0]."'";
		}
		else
		{
			$parametrosSeparados="";
		}

		$QUERY="SELECT ".$funcion."(".$parametrosSeparados.");";
		
		//imprime las consultas que se estan realizando para VERIFICAR los ERRORES
	//	echo $QUERY;
   //	echo "</br>";

		$res = pg_query ($QUERY);
		$res2 = pg_fetch_array($res);			
		//hacemos un arreglo bidimencional con el registro que nos devuelve la consulta
		$retornarValores=array();
		$filas = explode('|',$res2[0]);
		//primero las filas
		foreach($filas as $contador => $valores)
		{
			$retornarFilas[$contador]=$valores;
		}
		//luego las columnas de cada fila
		$arreglo = Array ();
		$d = 0;
		foreach ($retornarFilas as $valor)
		{
			$columnas[$d] = explode('~', $valor);
			$d++;
		}			
		return $columnas;
	}

	function sql($funcion)
	{		
		$QUERY=$funcion;
		//echo $QUERY;
		$res = pg_query ($QUERY);
		$res2 = pg_fetch_all($res);
		return $res2;
			
	}
}
?>