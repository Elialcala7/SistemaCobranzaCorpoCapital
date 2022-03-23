<?php 
require('../includes.php');

define("conect","../../framework/db/CX_SIS.php");
$conector=$ObjDbPG->classdb(conect);
$conector=$ObjDbPG->conectar(); 
 

 $bvalor1=40;

//Combo de Clientes 
 
$parametros = array();     
$consultarTipoCliente=$ObjDbPG->SELECT("public.consultartipocliente",$parametros); 
 
 $comboTipo=''; 
foreach ($consultarTipoCliente as $tipo) 
{
  
  $comboTipo.= '<option value="'.$tipo[0].'"> ' .strtoupper($tipo[1]). '</option>';
}

$mensaje=' 
<form action="generarCorte.php" method="post" id="corteFechas" name="corteFechas" 
target="_blank">
<table class="table table-bordered">
  <tr>
  	<td >
  	INFORMACIÒN GENERAL DE REPORTES
  		<br><br><br>
  		1.- Pendiente de Cobro. Corte de Fechas <br><br>
  		2.- Generar Reporte Clientes por tipo: Residencial, Comercial, Empresarial <br><br>
  		3.- Interesados en Servicio - Clientes Pendientes <br><br>
  	</td>
  	<td>
  		SELECCIONE SEGÙN TIPO DE REPORTES <br>
  		<br><br>

	  	<div class="col-md-8">
	      <label class="form-text-label" for="etiqueta">Fecha Inicio<span style="color:red">(*)</span></label>
	      <input class="form-control" "type="text"  id="fechaemision" value="" name="fechaemision" placeholder="Fecha Inicio" required>
	    </div>  

	     <div class="col-md-8">
    		<label class="form-text-label" for="etiqueta">Fecha Fin<span style="color:red">(*)</span></label>
    		<input class="form-control" "type="text"  id="fecharecibe" value="" name="fecharecibe" placeholder="Fecha Fin" required>
  		</div>
	<br><br>
		<div class="col-md-12">
            <label class="form-text-label" for="etiqueta">Tipo de Clientes:</label>
            <select class="form-control" id="tipoC" name="tipoC"><option value="">Seleccione</option>
                    '.$comboTipo.'
            </select>
        </div>  
	<br><br>
		<div class="col-md-12">
            <label class="form-text-label" for="etiqueta">Listar Pendientes:</label>
            <input type="checkbox" name="clientesPend" id="clientesPend" value="PENDIENTE"> Interesados
        </div>  
	
  	</td>
  </tr>
  <tr> 
  	
  </tr> 
</table>  
<div class="row"  align="center">
          <div class="col-md-8">
            <a href="#top-agre"><button type="submit" class="btn btn-primary">Generar 
            Reporte</button></a>
            <button class="btn btn-primary" type="button" id="btnLimpiar">Limpiar</button>
          </div>
        </div> 
</form> 
 <br><br>
 
<script>
  $("#fechaemision").datepicker({
      dateFormat: "dd-mm-yy"
  }); 
    $("#fecharecibe").datepicker({
      dateFormat: "dd-mm-yy"
  });

$("#btnLimpiar").click(function(event) {
     $("#corteFechas")[0].reset();
   });

  </script>

 ';


$html->salidaFinal($tituloPagina='Registro de Estatus',$Nmenu='menu2',$mensaje);
?>
