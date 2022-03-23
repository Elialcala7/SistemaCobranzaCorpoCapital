<?php

require('../includes.php');
require ("../head.php");

extract($_POST);
//print_r($_POST);exit();

/*
--------------------------------------------
[usuario] => 13109607 ==> cedula tipo text del usuario ==> cedula_usuario
[fecha] => 09-05-2020 
[hora] => 03:17:20 
[idcliente] => 12 ==> id del registro de cliente
[montoTotal] => 330000  ==> total_pagar
[idfpagos] => 83 factura a pagar
[fechaCorte] => 04-06-2020
[fpagos] => 4 seleccion forma de pago
[detallepago] => pago completo 
[montoPagar] => 350000  ==> monto_pagado
*/

$fechaPago = $_POST['fecha'];
$fechaCorte = $_POST['fechaCorte'];
$resta= $_POST['montoPagar'] - $_POST['montoTotal']; //monto_pendiente (puede ser saldo positivo/negativo)

//BD//
$ObjDbPG = new bd();
define("conect","../../framework/db/CX_SIS.php");
$conector=$ObjDbPG->classdb(conect);
$conector=$ObjDbPG->conectar();

$parametros = array();    
$parametros[0]=$_POST['idcliente'];
$ConsultarFacturasPendientes=$ObjDbPG->SELECT("public.consultar_fpcobro",$parametros);

$fechaConsultada = date('d-m-Y',strtotime($ConsultarFacturasPendientes[0][3]));

if($fechaCorte==$fechaConsultada)
{
	$status='PAGADO';
    $parametros= array();
    $parametros[0]=$ConsultarFacturasPendientes[0][3];
    $parametros[1]=$status;
    $parametros[2]=$_POST['idcliente'];
    $actualizarFactura=$ObjDbPG->SELECT("public.actualizar_fpcobro", $parametros);
}

$factura ='FACT-00-'.$ConsultarFacturasPendientes[0][5].'I1'.$_POST['idcliente'].'';

$parametros = array();    
$parametros[0]=$_POST['idcliente'];
$parametros[1]=$_POST['fpagos'];
$parametros[2]=$fechaPago;
$parametros[3]=$_POST['hora'];
$parametros[4]=$factura;
$parametros[5]=$_POST['montoTotal'];
$parametros[6]=$_POST['montoPagar'];
$parametros[7]=$resta;
$parametros[8]=$_POST['usuario'];
$parametros[9]=$_POST['detallepago'];

$insetarPago=$ObjDbPG->SELECT("public.insertar_control_pago",$parametros);

//IP SEGURIDAD //
$ip=get_ip_address();

  function get_ip_address()
  {

      if (!empty($_SERVER['HTTP_CLIENT_IP']))  
        {  
            $ip=$_SERVER['HTTP_CLIENT_IP'];  
        }  
      elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))  
      
        {  
            $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];  
        }  
        else  
        {  
            $ip=$_SERVER['REMOTE_ADDR'];  
        }  
      return $ip;  //ip del equipo

  }

$movimiento='AGREGAR PAGO DE FACTURA'; //informacion de gestion dentro del modulo


if($insetarPago[0][0]!='')
{
	  $parametros=array();
  	$parametros[0]=$_POST['fecha']; //integer 
  	$parametros[1]=$_POST['usuario'];
  	$parametros[2]=$ip;
  	$parametros[3]=$movimiento.$factura;
  	$parametros[4]=$insetarPago[0][0];
  	$IncluirHistorico=$ObjDbPG->SELECT("public.insertar_seguridad",$parametros);
    $factura1='FACT-0000-000';
  	$mensaje='
    <style>
    .padre 
    {
       background-color: #fafafa;
       margin: 1rem;
       padding: 1rem;
       text-align: center;
    }
    </style>

  	<form method="post" class="formulario2" name="form_txt2" action="factura1.php" id="form_txt2" target="_blank">
		        <input class="form-control" id="idPago" name="idPago" type="hidden" value="'.$insetarPago[0][0].'"> 
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <div class="alert alert-success padre">
		    	<strong>Exito:</strong> Pago registrado satisfactoriamente!!!.
  			</div>
        <div class="padre">
    			<label>Ver Contro de Pago No.'.$factura.'</label>
  				<button>
  					<img width="45px" height="50px" src="../CU_clientes/imagenes/icons8-imprimir.png">
          </button>
          <a href="../CU_bienvenida/index.php">
            <img src="../CU_servicios/imagenes/arrow_left_15601.png" height="30" width="30"></img>
           VOLVER
          </a>
        </div>
	 </form>';

}
else
{
	$mensaje='no se puede agregar';
}

$html->salidaFinal($tituloPagina="Página Principal",$menu="menu2",$mensaje);
?>