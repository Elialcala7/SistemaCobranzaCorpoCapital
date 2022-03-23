<?php 
require("../includes.php");
extract($_POST);

if($_GET["accion"]=="consultarContenidoS")
{
    $conten=$_POST['idseleccion'];


	$ObjDbPG=new bd();
	$conexion="../../framework/db/CX_SIS.php";  
	$conector=$ObjDbPG->classdb($conexion);
	$conector=$ObjDbPG->conectar();

	$parametros = array();
	$parametros[0]= $conten;
    $consultaContenidoServicios=$ObjDbPG->SELECT("public.consultar_servicio",$parametros);

    //resultado de busqueda//
    $nombreServicio = $consultaContenidoServicios[0][1];
    $contenido_servicio = $consultaContenidoServicios[0][2];
    $montoServicio = $consultaContenidoServicios[0][3];

	header('Content-Type: application/json;charset=utf-8');
          $datos = array(
          'estado' => 'ok',
          'nombreServicio'=> $nombreServicio,
          'contenido_servicio'=> $contenido_servicio,
          'montoServicio'=> $montoServicio);
          echo json_encode($datos);

}


if($_GET["accion"]=="consultarContenidoC")
{
  $contenC=$_POST['idseleccionC'];

  $ObjDbPG=new bd();
  $conexion="../../framework/db/CX_SIS.php";  
  $conector=$ObjDbPG->classdb($conexion);
  $conector=$ObjDbPG->conectar();

  $parametros = array();
  $parametros[0]= $contenC;
  $consultaContenidoServicios=$ObjDbPG->SELECT("public.consultar_servicio",$parametros);

    //resultado de busqueda//
    $nombreServicioC = $consultaContenidoServicios[0][1];
    $contenido_servicioC = $consultaContenidoServicios[0][2];
    $montoServicioC = $consultaContenidoServicios[0][3];

  header('Content-Type: application/json;charset=utf-8');
          $datos = array(
          'estado' => 'ok',
          'nombreServicioC'=> $nombreServicioC,
          'contenido_servicioC'=> $contenido_servicioC,
          'montoServicioC'=> $montoServicioC);
          echo json_encode($datos);

}

if($_GET["accion"]=="consultarContenidoE")
{
  $contenC=$_POST['idseleccionE'];

  $ObjDbPG=new bd();
  $conexion="../../framework/db/CX_SIS.php";  
  $conector=$ObjDbPG->classdb($conexion);
  $conector=$ObjDbPG->conectar();

  $parametros = array();
  $parametros[0]= $contenC;
  $consultaContenidoServicios=$ObjDbPG->SELECT("public.consultar_servicio",$parametros);

    //resultado de busqueda//
    $nombreServicioE = $consultaContenidoServicios[0][1];
    $contenido_servicioE = $consultaContenidoServicios[0][2];
    $montoServicioE = $consultaContenidoServicios[0][3];

  header('Content-Type: application/json;charset=utf-8');
          $datos = array(
          'estado' => 'ok',
          'nombreServicioE'=> $nombreServicioE,
          'contenido_servicioE'=> $contenido_servicioE,
          'montoServicioE'=> $montoServicioE);
          echo json_encode($datos);

}



?>