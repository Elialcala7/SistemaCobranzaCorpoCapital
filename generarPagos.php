<?php 
require('../includes.php');
require ("../head.php");

extract($_POST);
//print_r($_POST);exit();
$idfactpPagar=$_POST['idfactpagar'];


date_default_timezone_set("America/Caracas");
$hora= date('h:i:s A');

$ObjDbPG = new bd();
define("conect","../../framework/db/CX_SIS.php");
$conector=$ObjDbPG->classdb(conect);
$conector=$ObjDbPG->conectar();

// Factura a pagar//
$parametros = array();  
$parametros[0]=$idfactpPagar; 
$consFactPendienteCobro=$ObjDbPG->SELECT("public.consultar_pfpago",$parametros);

/*
 [0] => 58 
 [1] => 2020-08-03 
 [2] => PENDIENTE 
 [3] => 9 
 [4] => 1 
 [5] => Jonathan Smegner 
 [6] => j-9632541-7 
 [7] => 02124587412 
 [8] => 02125478965 
 [9] => egoSeguridad@gmail.com 
 [10] => noruega 
 [11] => BASICO III 
 [12] => OTRA PRUEBA 
 [13] => 62500 
 [14] => Seguridad Ego, C.A. 
 [15] => jjsmith@gmail.com 
 [16] => 62500
 */
$idcliente=$consFactPendienteCobro[0][3];
$nombreServicio=$consFactPendienteCobro[0][11];
$contServicio=$consFactPendienteCobro[0][12];
$costoServicio=$consFactPendienteCobro[0][13];
$fechaCorte=date('d-m-Y',strtotime($consFactPendienteCobro[0][1]));
$fechaHoy = date('d-m-Y');

 if($consFactPendienteCobro[0][14])
 {
 	$nombrCliente=$consFactPendienteCobro[0][14];
 }
 else
 {
 	$nombrCliente=$consFactPendienteCobro[0][5];
 }

// Combo Forma de Pago[INICIO] 
$parametros = array();    
$consultarPago=$ObjDbPG->SELECT("public.consultar_formapagos",$parametros);

$consultaFormaPago=0;
foreach ($consultarPago as $tipo) 
{
   $consultaFormaPago.= '<option value="'.$tipo[0].'"> ' .strtoupper($tipo[1]). '</option>';
}

$mensaje ="
		<br><br>
		<br><br>
		<div>
      		<div class='panel-title' style=' margin-top:35px; margin-left:300px;'>
      		GENERAR PAGO CLIENTE: <strong>".$nombrCliente."</strong></div>
    	</div>
		'<div id='frameText' style=' margin-top:50px; margin-left:50px;' class='mainbox col-md-4'>
 	 <div class='panel panel-info'>
   	 <div class='panel-heading'>
      <div class='panel-title' style=' margin-top:15px; margin-left:30px;'>DATOS DE LA OPERACIÓN</div>
   	 </div>
   	 <div class='row' style='margin-left:20px;'>  
    	<div id='nombreServicio' name='nombreServicio' class='row'>
	     <label for='nombreServicio' class='control-label col-md-6'> Nombre del Servicio: </label>
	     <div class='controls col-md-4'>".$nombreServicio."</div>
	    </div>
	    <div id='contServicio' name='contServicio' class='row'>
	     <label for='contServicio' class='control-label col-md-6'> Contenido del Servicio: </label>
	     <div class='controls col-md-4'>".$contServicio."</div>
	    </div>
	    <div id='costoServicio' name='costoServicio' class='row'>
	     <label for='costoServicio' class='control-label col-md-6'> Costo del Servicio: </label>
	     <div class='controls col-md-4'>Bs. ".$costoServicio."</div>
	    </div>
	    <hr width='90%'></hr>
	    <div id='fechaCorte' name='fechaCorte' class='row'>
	     <label for='fechaCorte' class='control-label col-md-6'> Fecha Corte: </label>
	     <div class='controls col-md-4'>".$fechaCorte."</div>
	    </div>
	    <hr width='90%'></hr><hr width='90%'></hr>
	    <div id='fecha' name='fecha' class='row'>
	     <label for='fecha' class='control-label col-md-6'> Fecha: </label>
	     <div class='controls col-md-4'>".$fechaHoy." ".$hora."</div>
	    </div>
	</div>
  </div>
</div>

<div id='frameText' style=' margin-top:50px; margin-left:50px;' class='mainbox col-md-6'>
  <div class='panel panel-info'>
     <div class='panel-heading'>
      <div class='panel-title' style=' margin-top:15px; margin-left:190px;'>PAGAR</div>
     </div>
    <div class='panel-body' >
      <form  class='form-horizontal' id='formPagos' name='formPagos' method='POST' action='procesarDatosPagos.php' >
        <div id='pagos' name='pagos' class='row' style=' margin-top:10px; margin-left:50px;' >
        <input id='usuario' name='usuario' class='form-control' type='hidden' value=".$_SESSION['cedula_ED'].">
        <input id='fecha' name='fecha' class='form-control' type='hidden' value=".$fechaHoy.">
        <input id='hora' name='hora' class='form-control' type='hidden' value=".$hora.">
        <input id='idcliente' name='idcliente' class='form-control' type='hidden' value=".$idcliente.">
        <input id='montoTotal' name='montoTotal' class='form-control' type='hidden' value= ".$costoServicio.">
        <input id='idfpagos' name='idfpagos' class='form-control' type='hidden' value=".$idfactpPagar.">
        <input id='fechaCorte' name='fechaCorte' class='form-control' type='hidden' value=".$fechaCorte.">
          <div class='row'>
            <label for='formaPagos' class='justify-content-start col-md-6'> Forma de Pago:</label>
			  <div class='col-sm-6'>
			    <select id='fpagos' name='fpagos' class='form-control' required>
				   	 <option value='' selected disabled > </option>
				    '.$consultaFormaPago.'
			   	</select>
			  </div>
		  </div>
		  <div class='row'>
            <label for='detallePagos' class='justify-content-start col-md-5'> Detalle del Pago:</label>
			  <div class='col-sm-5'>
			    <input id='detallepago' name='detallepago' class='form-control' type='text' required>
			  </div>
		  </div>
		  <div class='row'>
            <label for='montoPagos' class='justify-content-start col-md-5'> Monto a Pagar:</label>
			  <div class='col-sm-5'>
			    <input id='montoPagar' name='montoPagar' class='form-control' placeholder='números' type='text' minlength='5' maxlength='12' required placeholder='Por ejemplo, 120345678901' pattern='[0-9]+'>
			     <p class='help-block'>Sin coma (,) ni puntos(.)</p>
			  </div>
		  </div>
		  <hr width='100%'></hr>
		  <div>
		  	   <button>
                <img src='../CU_servicios/imagenes/icons8-pago-online-50.png' height='20' width='20'></img>
                Generar Pago
              </button>
              <button id='limpiarcampos' name='limpiarcampos'>
                <img src='../CU_servicios/imagenes/icons8-escoba-64.png' height='20' width='20'></img>
                Limpiar
              </button>
          </div> 
        </div> 
      </form>
    </div>
</div>

<script language='JavaScript'>

$('#limpiarcampos').click(function(event) {
    $('#formPagos')[0].reset();
    
});

</script>


	</form>";


$html->salidaFinal($tituloPagina="Página Principal",$menu="menu2",$mensaje);

?>