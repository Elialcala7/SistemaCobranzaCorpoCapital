<?php
require('../includes.php');
require ("../head.php");

extract($_POST);
//print_r($_POST);exit();

$ObjDbPG = new bd();
define("conect","../../framework/db/CX_SIS.php");
$conector=$ObjDbPG->classdb(conect);
$conector=$ObjDbPG->conectar();


$parametros = array();  
$parametros[0]=$_POST['idClienteConsultar'];
$consultarPagosCliente=$ObjDbPG->SELECT("consultar_pago_cliente",$parametros);

$idPagoCliente=count($consultarPagosCliente[0][8]);

$datosHistoricos='';
$botoninforme='<form id="historicoI" name="historicoI" action="../CU_reportes/informeHistoricoCliente.php" method="POST" target="_blank">
       <input id="idClienteConsultar" name="idClienteConsultar" type="hidden" value="'.$_POST['idClienteConsultar'].'">
       <input id="idPagoCliente" name="idPagoCliente" type="hidden" value="'.$idPagoCliente.'">
     <input class="padre2" type="submit" value="Informe de Pagos"/>     
      </form>';

 foreach($consultarPagosCliente as $tipo) 
  {

    $idCliente=$tipo[0];
    $noFactura=$tipo[3];
    $fechaPago=date('d-m-Y',strtotime($tipo[1]));
    $horaPago=$tipo[2];
    $MontoPagado=number_format($tipo[4]);
    

    $parametros = array();  
    $parametros[0]=$tipo[7];
    $consultarPagosCliente=$ObjDbPG->SELECT("consultar_todasformapagos",$parametros);

    $formaPago=$consultarPagosCliente[0][1];

    $datosHistoricos.="<tr>";
    $datosHistoricos.="<td>$noFactura</td>";
    $datosHistoricos.="<td>$fechaPago</td>";
    $datosHistoricos.="<td>$horaPago</td>";
    $datosHistoricos.="<td>$formaPago</td>";
    $datosHistoricos.="<td>$MontoPagado</td>";
    $datosHistoricos.="</tr>";    
  }  

  $mensaje=
"
  <table class='table' border='1' align='center' id='tblDatos'>
  <br><br><br>
  <label class='padre1'><strong><h2>HISTORICO DE PAGOS</h2></strong></label>

  </div>

<br><br>
     <thead class='tableHeader'>
      <tr>
          <th>Factura No.</th>
          <th>Fecha de Pago</th>
          <th>Hora de Pago</th>
          <th>Forma de Pago</th>
          <th>Monto Bs.</th>

      </tr>
     </thead>
      <tr>
        <tbody>
             ".$datosHistoricos."            
         </tbody>
      </tr>
  </table> 
 <style>
    .padre 
    {
       background-color: #fafafa;
       margin: 10rem;
       padding: 1rem;
       text-align: center;
    }
   .padre1 
      {
         background-color: #fafafa;
         margin: 3rem;
         padding: 3rem;
         text-align: center;
         height: 35px;
         width: 890px;
      }
  .padre2 
  {
      padding: 10px;
      font-size: 18px;
      color: #ffffff;
      background-color: #1883ba;
      border-radius: 6px;
      border: 2px solid #0016b0;
      margin: -20px -50px; 
      position:relative;
      top:50%; 
      left:80%;
    }
</style>
   <br><br>
   ".$botoninforme."
  <div class='padre'>
    <a href='../CU_bienvenida/index.php'>
            <img src='../CU_servicios/imagenes/arrow_left_15601.png' height='30' width='30'></img>
           VOLVER
    </a>
  </div>


  ";

$html->salidaFinal($tituloPagina="Página Principal",$menu="menu2",$mensaje);
?>