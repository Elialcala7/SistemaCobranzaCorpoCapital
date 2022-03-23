<?php
require('../includes.php');
require ("../head.php");

extract($_POST);
//print_r($_POST);exit();
date_default_timezone_set("America/Caracas");
$hora= date('h:i:s A');

/*
 [idCliente] => 36 
 [fechaSistema] => 30/03/2020 
 [costoServicio] => 90922 
 [costoInstalacion] => 25000 
 [totalSercicio] => 115922
*/


//print_r($hora);exit();
$fechaHoy = $_POST['fechaSistema'];
$pedido = '2020-00I'.$_POST['idCliente'];
$costoServicio=$_POST['costoServicio'];
$costoInstalacion=$_POST['costoInstalacion'];
$totalSercicio=$_POST['totalSercicio'];


$ObjDbPG = new bd();
define("conect","../../framework/db/CX_SIS.php");
$conector=$ObjDbPG->classdb(conect);
$conector=$ObjDbPG->conectar();

// Combo Forma de Pago[INICIO] 
$parametros = array();    
$consultarPago=$ObjDbPG->SELECT("public.consultar_formapagos",$parametros);

$consultaFormaPago=0;
foreach ($consultarPago as $tipo) 
{
   $consultaFormaPago.= '<option value="'.$tipo[0].'"> ' .strtoupper($tipo[1]). '</option>';
}



$mensaje=
'<div id="frameText" style=" margin-top:50px; margin-left:50px;" class="mainbox col-md-4">
  <div class="panel panel-info">
    <div class="panel-heading">
      <div class="panel-title" style=" margin-top:15px; margin-left:30px;">DATOS DE LA OPERACIÓN</div>
    </div>
    <div class="row" style="margin-left:20px;">  
	    <div id="costoServicio" name="costoServicio" class="row">
	     <label for="costoServicio" class="control-label col-md-6"> Costo del Servicio: </label>
	     <div class="controls col-md-4">Bs. '.$costoServicio.'</div>
	    </div>
	    <div id="costoInstalacion" name="costoInstalacion" class="row">
	     <label for="costoInstalacion" class="control-label col-md-6"> Costo de Instalación: </label>
	     <div class="controls col-md-4">Bs. '.$costoInstalacion.'</div>
	    </div>
	    <hr width="90%"></hr>
	    <div id="totalSercicio" name="totalSercicio" class="row">
	     <label for="totalSercicio" class="control-label col-md-6"> Monto Total: </label>
	     <div class="controls col-md-4">Bs. '.$totalSercicio.'</div>
	    </div>
	    <hr width="90%"></hr><hr width="90%"></hr>
	    <div id="ordenpedido" name="ordenpedido" class="row">
	     <label for="ordenpedido" class="control-label col-md-6"> No. Pedido: </label>
	     <div class="controls col-md-4">'.$pedido.'</div>
	    </div>
	    <div id="fecha" name="fecha" class="row">
	     <label for="fecha" class="control-label col-md-6"> Fecha: </label>
	     <div class="controls col-md-4">'.$fechaHoy.' '.$hora.'</div>
	    </div>
	</div>
  </div>
</div>

<div id="frameText" style=" margin-top:50px; margin-left:50px;" class="mainbox col-md-6">
  <div class="panel panel-info">
     <div class="panel-heading">
      <div class="panel-title" style=" margin-top:15px; margin-left:190px;">PAGAR</div>
     </div>
    <div class="panel-body" >
      <form  class="form-horizontal" id="formPagos" name="formPagos" method="POST" action="procesar.php" >
        <div id="pagos" name="pagos" class="row" style=" margin-top:10px; margin-left:50px;" >
        <input id="usuario" name="usuario" class="form-control" type="hidden" value="'.$_SESSION['cedula_ED'].'">
        <input id="fecha" name="fecha" class="form-control" type="hidden" value="'.$fechaHoy.'">
        <input id="hora" name="hora" class="form-control" type="hidden" value="'.$hora.'">
        <input id="idcliente" name="idcliente" class="form-control" type="hidden" value="'.$_POST['idCliente'].'">
        <input id="montoTotal" name="montoTotal" class="form-control" type="hidden" value="'.$totalSercicio.'"
          <div class="row">
            <label for="formaPagos" class="justify-content-start col-md-6"> Forma de Pago:</label>
			  <div class="col-sm-6">
			    <select id="fpagos" name="fpagos" class="form-control" required>
				   	 <option value="" selected disabled >Seleccionar...</option>
				    '.$consultaFormaPago.'
			   	</select>
			  </div>
		  </div>
		  <div class="row">
            <label for="formaPagos" class="justify-content-start col-md-5"> Detalle del Pago:</label>
			  <div class="col-sm-5">
			    <input id="detallepago" name="detallepago" class="form-control" type="text" required>
			  </div>
		  </div>
		  <div class="row">
            <label for="formaPagos" class="justify-content-start col-md-5"> Monto a Pagar:</label>
			  <div class="col-sm-5">
			    <input id="montoPagar" name="montoPagar" class="form-control" placeholder="números" type="text" minlength="5" maxlength="12" required placeholder="Por ejemplo, 120345678901" pattern="[0-9]+">
			     <p class="help-block">Sin coma (,) ni puntos(.)</p>
			  </div>
		  </div>
		  <hr width="100%"></hr>
		  <div>
		  	   <button>
                <img src="../CU_servicios/imagenes/icons8-pago-online-50.png" height="20" width="20"></img>
                Generar Pago
              </button>
              <button id="limpiarcampos" name="limpiarcampos">
                <img src="../CU_servicios/imagenes/icons8-escoba-64.png" height="20" width="20"></img>
                Limpiar
              </button>
          </div> 
        </div> 
      </form>
    </div>
</div>

<script language="JavaScript">

$("#limpiarcampos").click(function(event) {
    $("#formPagos")[0].reset();
    
});

</script>';


$html->salidaFinal($tituloPagina="Página Principal",$menu="menu2",$mensaje);
?>