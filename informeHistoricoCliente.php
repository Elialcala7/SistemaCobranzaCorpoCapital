<?php

require("../includes.php");
extract($_POST);

//CONSULTA DE PAGO//

$idControlPago = $_POST['idPagoCliente']; //id de control en tabla

$ObjDbPG = new bd();
define("conect","../../framework/db/CX_SIS.php");
$conector=$ObjDbPG->classdb(conect);
$conector=$ObjDbPG->conectar();

/*
[0] => 14 == id_cliente
[1] => Agustin Prieto == nombres_cliente
[2] => J-14852365-9 == ci_cliente
[3] => 02126547855 == telefono_principal
[4] => tocucitosrl@gmail.com == correo
[5] => 51-A,Torre Este, Nivel 2, Parque Central == direccion
[6] => 2020-05-12 == fecha_pago
[7] => 05:07:59 == hora_pago
[8] => FACT-00-101I114 == factura_no
[9] => 330000 == monto_total
[10] => 350000 == monto_pagado
[11] => 20000 == diferencia_monto
[12] => completo == detalle_pago
[13] => 1 == idservicio
[14] => 330000 == costoservicio
[15] => 150000 == costos_instalacion
[16] => cables y extension == observacion_instalacion
[17] => Los Tocucitos, srl == nombre_comercio
[18] => agustinPP@gmail.com == otro_correo
[19] => 2020-05-11 == fecha_registr
[20] => 13109607 == usuario == cedula
[21] => Ely  == nombre usuario 
[22] => Alcala == apellido usuario
[23] => 1 == id_forma_pago


*/

$parametros = array();
$parametros[0]=$idControlPago;    
$consultarPagoInforme=$ObjDbPG->SELECT("public.consultar_pago_cliente_informe",$parametros);

$idCliente = $consultarPagoInforme[0][0];
$nombreCliente = $consultarPagoInforme[0][1];
$ci= $consultarPagoInforme[0][2];
$telefono =$consultarPagoInforme[0][3];
$correoP=$consultarPagoInforme[0][4];
$direccionCliente=$consultarPagoInforme[0][5];
$monto_total=$consultarPagoInforme[0][9];
$detallePago=$consultarPagoInforme[0][12];
$idservicio=$consultarPagoInforme[0][13];
$costoServicio=$consultarPagoInforme[0][14];
$costoInstalacion=$consultarPagoInforme[0][15];
$observacion_instalacion=$consultarPagoInforme[0][16];
$comercioNombre =$consultarPagoInforme[0][17];
$otroCorreo=$consultarPagoInforme[0][18];
$fechaRegistroCliente=$consultarPagoInforme[0][19];
$usuarioCedula=$consultarPagoInforme[0][20];
$usuariodatos=$consultarPagoInforme[0][21].' '.$consultarPagoInforme[0][22];

$detalleInstalacion='INSTALACIÓN';
$empresa ='CORPOCAPITAL, C.A.';
$rif =' RIF: G-20010665-4';
$direccionEmpresa ='Av.Lecuna entre Av. Sur 17 y Av. Bolívar, Edificio Torre Oeste, Piso 32, Complejo Urbanístico Parque Central.
Municipio Libertador, Distrito Capital – Código Postal 1010.';
$telefonos ='Teléfonos: 0212-508.58.13/508.58.12 Telefax: 0212-508.58.14';
$correo='Correo: cobranzas.internet@corpocapital.gob.ve';

$contenido='';
$i=1;
foreach ($consultarPagoInforme as $valor) 
{
   
    $factNo=$valor[8];
    $fechaPago=date("d-m-Y", strtotime($valor[6]));
    $horaPago=$valor[7];
    
    $formaPago=$valor[23];
   
    $montoPagado=$valor[10];

     $contenido.="<tr>
            <td class='linea-2' width='15px'>$i</td>
            <td class='linea-2' width='35px'>$factNo</td>
            <td class='linea-2' width='35px'>$fechaPago</td>
            <td class='linea-2' width='35px'>$horaPago</td>
            <td class='linea-2' width='35px'>$formaPago</td>
            <td class='linea-2' width='35px'>$montoPagado</td>
            </tr>";
    $i=$i+1; 
}
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
	font-size: 20px;
	border:1px solid;
	text-align:center;
	text-align:center;
	border:1px dotted #000; 
	margin:1px;
}
.linea-1
{
	font-family: Arial, Helvetica, sans-serif;
	font-size: 18px;
	border:1px solid;
	border:1px dotted #000; 
	margin:1px;
  align:center;
}
.linea-2
{
	font-family: Arial, Helvetica, sans-serif;
	font-size: 18px;
	margin:1px;
	text-align:center;

}
.detalle
{
	font-family: Arial, Helvetica, sans-serif;
	font-size: 18px;
	margin:1px;
	text-align:center;
	align:center;
}
</style>

<table>
  <tr class="fila">
    <td id="col_3">
      <img  src="../../framework/marco_html/plantillas/sistema/imagenes/encabezadoInforme.png">
    </td>
  </tr>
</table>';
$fechaHoy=date('d-m-Y');
$datosClientes='
<br><br>
<table class="table">
	<tr>
		<td class="linea-2" text-align="justyfi">
		  Cliente/Comercio: '.$nombreCliente.' / '.$comercioNombre.'
		</td>
		<td class="linea-2">
		  R.I.F./C.I: '.$ci.' - '.$idCliente.'
		</td>
	</tr>
	<tr>
		<td class="linea-2">
		  Telefono Principal: '.$telefono .'
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
<br><br>
<label><strong align="center"><h3>INFORME DE PAGOS</h3></strong></label>
<br>
<label><strong align="right"><h4>A la Fecha de Hoy: '.$fechaHoy.'</h4></strong></label>
<br><br>
';

$resultado="
<div align='center'>
  <table style='width:100%; font-family: arial, sans-serif; align: center;' border='1' CELLPADDING=3 CELLSPACING=0>
      <tr>
          <th class='linea-2' width='15px'> Registro No. </th>
          <th class='linea-2' width='35px'> Factura No. </th>
          <th class='linea-2' width='35px'> Fecha de Pago </th>
          <th class='linea-2' width='35px'> Hora de Pago </th>
          <th class='linea-2' width='35px'> Forma de Pago </th>
          <th class='linea-2' width='35px'> Monto Bs. </th>

      </tr>
      <tbody>
         ".$contenido."      
      </tbody>
  </table> 
</div>
";


require_once dirname(__FILE__).'/HTML2pdf/vendor/autoload.php';

use Spipu\Html2Pdf\Html2Pdf;

try
{
  $fe='fech';
   $html2pdf=new HTML2PDF('L','A4','es','true','UTF-8',array(35, 5, 20, 10)); //definimos: horientacion de hoja, tamaño de hoja, idioma, utilizacion de caracteres especiales, margenes//
    $html2pdf->setDefaultFont('Arial'); // tipo de letra
    $html2pdf->writeHTML($mensaje); //contenido del pdf
    $html2pdf->writeHTML($datosClientes); //contenido del pdf
    $html2pdf->writeHTML($resultado); //contenido del pdf
    $html2pdf->output('InformeCliente.pdf'); //nombre de archivo para descargar
    $html2pdf->setFooter('Fecha de Impresión '.$fe.''); 
}
  catch(HTML2PDF_exception $e) 
  {
        echo $e;
        exit;
  }


?>
