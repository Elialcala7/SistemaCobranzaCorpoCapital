<?php

require("../includes.php");
extract($_POST);

//CONSULTA DE PAGO//

$idControlPago = $_POST['idPago']; //id de control en tabla
//print_r($idControlPago);exit();
$ObjDbPG = new bd();
define("conect","../../framework/db/CX_SIS.php");
$conector=$ObjDbPG->classdb(conect);
$conector=$ObjDbPG->conectar();

$parametros = array();
$parametros[0]=$idControlPago;    
$consultarPago=$ObjDbPG->SELECT("public.consultar_pago",$parametros);

//print_r($consultarPago);exit();
$idCliente = $consultarPago[0][0];
$nombreCliente = $consultarPago[0][2];
$ci= $consultarPago[0][3];
$telefono =$consultarPago[0][4];
$correoP=$consultarPago[0][6];
$direccionCliente=$consultarPago[0][7];
$fechaRegistroPago=$consultarPago[0][8];
$horaRegistroPago=$consultarPago[0][9];
$factNo=$consultarPago[0][10];
$montoPagado=$consultarPago[0][11];
$detallePago=$consultarPago[0][13];
$servicioNombre=$consultarPago[0][14];
$contenidoServicio=$consultarPago[0][15];
$costoServicio=$consultarPago[0][22];
$costoInstalacion=$consultarPago[0][16];
$usuario=$consultarPago[0][17].' '.$consultarPago[0][18];
$formaPago =$consultarPago[0][19];
$comercioNombre =$consultarPago[0][20];
$otroCorreo=$consultarPago[0][21];
$otroTelefono=$consultarPago[0][5];
$totalPagar=$costoServicio;
$restanMonto=($montoPagado - $totalPagar);
$detalleInstalacion='INSTALACIÓN';
$empresa ='CORPOCAPITAL, C.A.';
$rif =' RIF: G-20010665-4';
$direccionEmpresa ='Av.Lecuna entre Av. Sur 17 y Av. Bolívar, Edificio Torre Oeste, Piso 32, Complejo Urbanístico Parque Central.
Municipio Libertador, Distrito Capital – Código Postal 1010.';
$telefonos ='Teléfonos: 0212-508.58.13/508.58.12 Telefax: 0212-508.58.14';
$correo='Correo: cobranzas.internet@corpocapital.gob.ve';



$mensaje = '

<style>
.linea_seniat
{
	font-family: Arial, Helvetica, sans-serif;
	font-size: 18px;
	line-height: 1%   /*esta es la propiedad para el interlineado*/
	text-align:center;
	text-align:center;
	border:1px dotted #000; 
	padding:8px;
}
.linea
{
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
	border:1px solid;
	text-align:center;
	text-align:center;
	border:1px dotted #000; 
	margin:1px;
}
.linea-1
{
	font-family: Arial, Helvetica, sans-serif;
	font-size: 8px;
	border:1px solid;
	text-align:center;
	text-align:center;
	border:1px dotted #000; 
	margin:1px;
}
.linea-2
{
	font-family: Arial, Helvetica, sans-serif;
	font-size: 7px;
	margin:1px;
	text-align:center;

}
.detalle
{
	font-family: Arial, Helvetica, sans-serif;
	font-size: 8px;
	margin:1px;
	text-align:center;
	align:center;
}

</style>
 <h3 class="linea_seniat"> SENIAT </h3>
 <h5 class="linea">'.$empresa.'</h5>

 <h6 class="linea-1">'.$direccionEmpresa.'</h6>
 <h6 class="linea-1">'.$telefonos.'</h6>
 <h6 class="linea-1">'.$correo.'</h6>
';
$datosClientes='
 <h5 class="linea-2">'.$rif.'   </h5>
<table class="table table-sm">
	<tr>
   		<td colspan="2" style="border-bottom-color:#000000;" class="linea-1">'.$fechaRegistroPago.'   '.$horaRegistroPago.' </td>
 	</tr>
	<tr>
   		<td colspan="2" style="border-bottom-color:#000000;">Datos del consumidor</td>
 	</tr>
</table>
<table class="table table-sm">
	<tr>
		<td class="linea-2" text-align="justyfi">
		 Cliente: '.$nombreCliente.' / '.$comercioNombre.'
		</td>
		<td class="linea-2">
		 R.I.F./C.I: '.$ci.' - '.$idCliente.'
		</td>
	</tr>
	<tr>
		<td class="linea-2">
		telefono: '.$telefono .' - '.$otroTelefono.'
		</td>
		<td class="linea-2">
		Dirección: '.$direccionCliente.'
		</td>
	</tr>
	<tr>
		<td class="linea-2" colspan="2">
		Correo: '.$correoP.'  '.$otroCorreo.'
		</td>
	</tr>
</table>
';
$resultado='
<table align="center" cellspacing="3" cellpadding="1" style="border-bottom-color:#000000;">
  <tr>
   <td class="linea-2" colspan="3" align="center">
     FACTURA DETALLE
   </td>
   <td class="linea-2" colspan="2" align="right">
     <strong>'.$factNo.'</strong>
   </td>
  </tr>
</table>
<table  align="center" cellspacing="3" cellpadding="1" style="border-top: 1px dotted black; border-bottom: 1px dotted black;" WIDTH=400 HEIGHT=10>
  <tr>
    <th class="linea-2" width="10px">Cant.</th>
    <th class="linea-2" width="10px">Descripción</th>
    <th class="linea-2" width="10px">Costo Unit.</th>
    <th class="linea-2" width="10px">Tasa %</th>
    <th class="linea-2" width="10px">Total</th>
  </tr>
   <tr>
      <td scope="row" align="center" class="linea-2" width="10px">1</td>
      <td class="linea-2" align="center" width="10px>'.$servicioNombre.'</td>
      <td class="linea-2" align="center" width="10px>'.$costoServicio.'</td>
      <td class="linea-2" align="center" width="10px>0</td>
      <td class="linea-2" align="center" width="10px>'.$costoServicio.'</td>
    </tr>
    <tr>
      <th scope="row" class="detalle"></th>
      <td class="detalle"></td>
      <td class="detalle"></td>
      <td class="detalle"></td>
    </tr>
     <tr>
      <th scope="row" class="detalle"></th>
      <td class="detalle"></td>
      <td class="detalle"></td>
      <td class="detalle"></td>
    </tr>
     <tr>
      <td class="linea-2" colspan="2" align="center"> TOTAL A PAGAR:</td>
      <td class="linea-2" colspan="2" align="center">Bs. '.$totalPagar.'</td>

    </tr>
    <tr>
      <td class="linea-2" colspan="5" align="center" style="border-top: 1px dotted black; border-bottom: 1px dotted black;"> FACTURA DETALLE
      </td>
    </tr>
    <tr>
      <td class="detalle">Forma de Pago: '.$formaPago.'</td>
      <td class="detalle">Monto Bs.: '.$montoPagado.'</td>
    </tr>
    <tr>
      <td class="detalle">Total Diferencia Bs.: '.$restanMonto.'</td>
    </tr>
</table>

';

require_once dirname(__FILE__).'/HTML2pdf/vendor/autoload.php';

use Spipu\Html2Pdf\Html2Pdf;


    $html2pdf = new Html2Pdf('P',array(80,100),'es','true','UTF-8');
    //$html2pdf->setDefaultFont('Arial','10');
    $html2pdf->setDefaultFont('Arial','B',8);
    $html2pdf->writeHTML($mensaje);
    $html2pdf->writeHTML($datosClientes);
    $html2pdf->writeHTML($resultado);
    $html2pdf->output('ComprobPago.pdf');

/*

$mensaje = '
 <h3> SENIAT </h3>
 <h5>'.$empresa.'</h5>
 <h5>'.$rif.'</h5>
 <h6>'.$direccionEmpresa.'</h6>
 <h6>'.$telefonos.'</h6>
 <h6>'.$correo.'</h6>
';
*/
?>