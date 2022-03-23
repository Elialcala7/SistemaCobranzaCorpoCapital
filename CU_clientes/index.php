<?php 
require('../includes.php');
require ("../head.php");

//session_start();
$fechaRegistro = date('d/m/Y'); //fecha actual


$ObjDbPG = new bd();
define("conect","../../framework/db/CX_SIS.php");
$conector=$ObjDbPG->classdb(conect);
$conector=$ObjDbPG->conectar();

// Combo Servicios/Planes [INICIO] 
$parametros = array();    
$consultartipoC=$ObjDbPG->SELECT("public.consultartipocliente",$parametros);

$consultaCliente=0;
foreach ($consultartipoC as $tipo) 
{
   $consultaCliente.= '<option value="'.$tipo[0].'"> ' .strtoupper($tipo[1]). '</option>';
}

// Combo Servicios/Planes [INICIO] 
$parametros = array();    
$consultaServicios=$ObjDbPG->SELECT("public.consultar_todosservicios",$parametros);
//print_r($consultaServicios);exit();

$consultaServ=0;
foreach ($consultaServicios as $tipo) 
{
   $consultaServ.= '<option value="'.$tipo[0].'"> ' .strtoupper($tipo[1]). '</option>';
}

$mensaje='
<div class="container bootstrap snippet" >
  <div class="row" align="center">
    <div class="col-sm-10" >
    <br><br>
<form class="form-horizontal" id="formcliente" name="formcliente" method="POST" action="procesaResidencial.php">
  <fieldset>
    <table>
      <tr>
        <td>
        <!-- Multiple Checkboxes (inline) -->
          <div class="row">
            <div class="form-group">
              <label class="col-md-6 control-label" for="checkcond" align="center"></label>
              <div class="col-md-8">
                <label class="checkbox-inline" for="checkcond-0">Cliente:
                <input type="radio" name="checkcliente" id="checkcliente" value="Nuevo" checked>Nuevo</label>
                <label class="checkbox-inline" for="checkcond-1">
            <!-- <input type="radio" name="checkcliente" id="checkcliente" value="Existente" >Existente</label>-->
              </div>
            </div>
          </div>
        </td>
        <td>
          <div class="col-sm-12" >
            <label class="control-label col-md-6" for="selectipoCliente">Tipo Cliente:</label>
            <select id="selectcliente" name="selectcliente" class="form-control" required onchange="habilitar(this.value)">
              <option value="" selected disabled >Seleccionar...</option>
              '.$consultaCliente.'
            </select>
            
          </div>
        </td>
      </tr>
    </table>  
  </fieldset>
<legend></legend>
</form>
<div id="contenidoresidencial" style="display: none;" >
<form class="form-horizontal" id="residencialForm" name="residencialForm" method="POST" action="procesaResidencial.php">

      <legend>Datos Personales</legend>
<html>
<body>
<tablet style="width: 100%" border="1">
  <tr>
    <td>
      <div class="input-group col-md-10">
        <span class="input-group-addon">Nombres y Apellidos</span>
        <input id="checkcliente" name="checkcliente" class="form-control" type="hidden" value="1">
        <input id="selectcliente" name="selectcliente" class="form-control" type="hidden" value="1">
        <input id="fechaSistema" name="fechaSistema" class="form-control" type="hidden" value="'.$fechaRegistro .'">
        
        <input id="usuario" name="usuario" class="form-control" type="hidden" value="'.$_SESSION['cedula_ED'].'">
        <input id="txtNombresApellidos" name="txtNombresApellidos" class="form-control" type="text" required>
        <p class="help-block">Debe ingresar Nombre y Apellido del Cliente</p>
      </div> 
    </td>
    <td>
      <div class="row col-md-4">
        <span class="input-group-addon">Numero de Cedula</span>
        <input id="txtCI" name="txtCI" class="form-control" type="text" minlength="6" maxlength="8" required placeholder="Por ejemplo, 12345678" pattern="[0-9]+">
      </div>
    </td> 
  </tr>
  <tr>
    <td>
      <div class="row col-md-4">
        <span class="input-group-addon">Telefono Principal</span>
        <input id="txtlf1" name="txtlf1" class="form-control" type="text" minlength="7" maxlength="11" required placeholder="Por ejemplo, 04141234567" pattern="[0-9]+">
      </div>
    </td>
    <td>
      <div class="row col-md-4">
        <span class="input-group-addon">Otro Numero de Telefono</span>
        <input id="txtlf2" name="txtlf2" class="form-control" type="text" placeholder="Por ejemplo, 04141234567" pattern="[0-9]+" minlength="7" maxlength="11">
      </div>
    </td>
  </tr>
  <tr>
    <td>
      <div class="row col-md-4">
        <span class="input-group-addon">Correo</span>
        <input id="txtcorreo" name="txtcorreo" class="form-control" type="email" required>
      </div>
    </td>
    <td>
      <div class="form-group">
        <label class="col-md-8 control-label" for="txtdireccion" align="center">Dirección</label>
        <div class="col-md-8">                     
          <textarea class="form-control" id="txtdireccion" name="txtdireccion" required></textarea>
          <p class="help-block" minlength="5" maxlength="200">Máximo 200 caracteres (*)</p>
        </div>
      </div>
      
    </td>
  </tr>
   </table>
<legend></legend>
<legend>Contrato del Servicio</legend>
<br>
<div class="form-group" name="selector" id="selector">
  <label class="col-sm-4 control-label" for="selectbasic">Seleccione el Servicio</label>
  <div class="col-sm-4">
    <select id="selectbasic" name="selectbasic" class="form-control" required onchange="contenido(this.value)">
    <option value="" selected disabled >Seleccionar...</option>
    '.$consultaServ.'
   </select>
  </div>
</div>
     
    <div id="contenidoServ" name="contenidoServ" style="display:none">
      <table class="table table-striped"  id="tabletserv" name="tabletserv">
        <tr>
          <td align="center" width="30px"><strong>Nombre</strong></th>
          <td align="center" width="30px"><strong>Contenido del Servicio</strong></th>
          <td align="center" width="30px"><strong>Costo</strong></th>
        </tr>
        <tr>
          <td align="center" id="nombreServicio"></td>
          <td align="center" id="contenido_servicio"></td>
          <td align="center" id="montoServicio"></td>
        </tr>
      </table>
      <br>
      <div class="form-group">
        <div class="col-md-4">
          <div class="input-group">
            <span class="input-group-addon">Costo de Instalación</span>
            <input id="costoInstalacion" name="costoInstalacion" class="form-control" placeholder="números" type="text" minlength="5" maxlength="12" required placeholder="Por ejemplo, 120345678901" pattern="[0-9]+">
          </div>
        <p class="help-block">Sin coma (,) ni puntos(.)</p>
        </div>
        <div class="input-group">
          <span class="input-group-addon">Nota</span>
          <textarea id="txtnota" name="txtnota" class="form-control" placeholder="Observaciones para la Instalación" type="text" minlength="5" maxlength="100"></textarea><p class="help-block">Máximo 100 caracteres (*)</p>
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-4 control-label" for="radioContrato">¿Desea formalizar la contratación?</label>
        <div class="col-md-4"> 
          <label class="radio-inline" for="radioContrato-0">
          <input type="radio" name="radioContrato" id="radioContrato-0" value="SI" checked="checked">
              SI
          </label> 
          <label class="radio-inline" for="radioContrato-1">
          <input type="radio" name="radioContrato" id="radioContrato-2" value="PENDIENTE">
              PENDIENTE
          </label>
        </div>
      </div>
    </div>
   <legend></legend>
  <!-- Button (Triple) -->
   <div class="row"  align="center">
    <button type="submit" class="btn btn-primary" >Generar Contrato</button>
    <button class="btn btn-primary" type="button" id="buttonLimpiar"  name="buttonLimpiar">Limpiar formulario</button>
    <a href="index.php">
     <img src="../CU_servicios/imagenes/arrow_left_15601.png" height="30" width="30"></img>
     VOLVER
    </a>
    
   </div> 
  <br><br>
      </fieldset>
    </body>
  </html>
      </div>
<br>
</form>
</div>

<div id="contenidocomercio" style="display: none;">
  <form class="form-horizontal" id="comercialForm" name="comercialForm" method="POST" action="procesaComercial.php">
    <input id="checkcliente" name="checkcliente" type="hidden" value="1">
    <input id="selectcliente" name="selectcliente" type="hidden" value="2">
    <input id="fechaSistema" name="fechaSistema" type="hidden" value="'.$fechaRegistro .'">
    <input id="usuario" name="usuario" type="hidden" value="'.$_SESSION['cedula_ED'].'">

<html>
<body>
  <tablet style="width: 100%" border="1">
    <tr>
      <td> 
        <div style="width:500px" class="row col-md-5">
          <span class="input-group-addon">Representante Legal</span>
          <input id="txtnombreLegal" name="txtnombreLegal" class="form-control" type="text" required placeholder="Nombre y Apellido">
        </div>
      </td>
      <td>
        <div style="width:500px" class="row col-md-5">
          <span class="input-group-addon">Comercio</span>
          <input id="txtnombreComercio" name="txtnombreComercio" class="form-control" type="text" placeholder="Nombre del Comercio" required>
        </div>
      </td>
    </tr>
  </table>
  <tablet style="width: 100%" border="1">
    <tr>
      <td> 
        <div style="width:300px" class="row col-md-5">
          <span class="input-group-addon">R.I.F.</span>
          <input id="txtrif" name="txtrif" class="form-control" type="text" placeholder="Registro información fiscal">
        </div>
      </td>
      <td>
        <div style="width:700px" class="row col-md-5">
          <span class="input-group-addon">Dirección</span>
          <input id="txtdireComercio" name="txtdireComercio" class="form-control" type="text" placeholder="Indique ubicación fisica del comercio" required>
        </div>
      </td>
    </tr>
    <tr>
      <td>
        <div class="row col-md-2" style="width:300px">
          <span class="input-group-addon">Correo del Comercio</span>
          <input id="txtcorreoComercio" name="txtcorreoComercio" class="form-control" type="email">
        </div>
      </td>
      <td>
        <div class="row col-md-2" style="width:300px">
          <span class="input-group-addon">Correo del Representante</span>
          <input id="txtcorreoRepres" name="txtcorreoRepres" class="form-control" type="email">
        </div>
      </td>
      <td>
        <div class="row col-md-2" style="width:250px">
          <span class="input-group-addon">Numero Local</span>
          <input id="txtlfLocal" name="txtlfLocal" class="form-control" type="text" placeholder="Por ejemplo, 02121234567" pattern="[0-9]+" minlength="7" maxlength="11">
        </div>
      </td>
      <td>
        <div class="row col-md-2" style="width:250px">
          <span class="input-group-addon">Numero Movil</span>
          <input id="txtlfMovil" name="txtlfMovil" class="form-control" type="text" placeholder="Por ejemplo, 04141234567" pattern="[0-9]+" minlength="7" maxlength="11">
        </div>
      </td>
    </tr>
  </table>

<table style="width: 30%">
  <tr>
    <th>
     Contrato del Servicio
    </th>
  <br>
  </tr>
</table>
<div class="form-group" name="selector1" id="selector1">
  <label class="col-sm-4 control-label" for="selectbasic1">Seleccione el Servicio</label>
  <div class="col-sm-4">
    <select id="selectbasic1" name="selectbasic1" class="form-control" required onchange="contenidoComercio(this.value)">
    <option value="" selected disabled >Seleccionar...</option>
    '.$consultaServ.'
   </select>
  </div>
</div>
<div id="contenidoServC" name="contenidoServC" style="display:none; width:810px;">
  <table class="table" id="tabletserv" name="tabletserv">
    <tr>
      <td align="center" width="30px"><strong>Nombre</strong></th>
      <td align="center" width="30px"><strong>Contenido del Servicio</strong></th>
      <td align="center" width="30px"><strong>Costo</strong></th>
    </tr>
    <tr>
      <td align="center" id="nombreServicioC"></td>
      <td align="center" id="contenido_servicioC"></td>
      <td align="center" id="montoServicioC"></td>
    </tr>
  </table> 
  <table style="width: 100%" align="justify">
    <tr>
      <td>
        <div class="form-group">
          <div class="col-md-6">
            <div class="input-group">
              <span class="input-group-addon">Costo de Instalación</span>
              <input id="costoInstalacionC" name="costoInstalacionC" class="form-control" placeholder="números" type="text" minlength="5" maxlength="12" required placeholder="Por ejemplo, 120345678901" pattern="[0-9]+">
            </div>
          <p class="help-block">Sin coma (,) ni puntos(.)</p>
          </div>
          <div class="col-md-6">
            <span class="input-group-addon">Nota</span>
            <textarea id="txtnotaC" name="txtnotaC" class="form-control" placeholder="Observaciones para la Instalación" type="text" minlength="5" maxlength="100"></textarea><p class="help-block">Máximo 100 caracteres (*)</p>
          </div>
        </div>
      </td>
    </tr>
    <tr>
      <td>
         <div class="form-group">
        <label class="col-md-8" control-label" for="radioContrato">¿Desea formalizar la contratación?</label>
        <div class="col-md-8"> 
          <label class="radio-inline" for="radioContrato-0">
          <input type="radio" name="radioContratoC" id="radioContrato-0" value="SI" checked="checked">
              SI
          </label> 
          <label class="radio-inline" for="radioContrato-1">
          <input type="radio" name="radioContratoC" id="radioContrato-2" value="PENDIENTE">
              PENDIENTE
          </label>
        </div>
      </div>
      </td>
    </tr>
  </table>  
</div>
<table>
  <tr>
    <td>
      <legend></legend>
      <!-- Button (Triple) -->
      <div class="row"  align="center">
        <button type="submit" class="btn btn-primary" >Generar Contrato</button>
        <button class="btn btn-primary" type="button" id="buttonLimpiarC"  name="buttonLimpiarC">Limpiar formulario</button>
        <a href="index.php">
         <img src="../CU_servicios/imagenes/arrow_left_15601.png" height="30" width="30"></img>
         VOLVER
        </a>
      </div> 
    </td>
  </tr>
</table>
<br>
</body>
</html>
  </form>
</div>

<div id="contenidoempresa" style="display: none;">
  <form class="form-horizontal" id="empresaForm" name="empresaForm" method="POST" action="procesaEmpresa.php">
    <input id="checkcliente" name="checkcliente" type="hidden" value="1">
    <input id="selectcliente" name="selectcliente" type="hidden" value="3">
    <input id="fechaSistema" name="fechaSistema" type="hidden" value="'.$fechaRegistro .'">
    <input id="usuario" name="usuario" type="hidden" value="'.$_SESSION['cedula_ED'].'">

    <html>
<body>
  <tablet style="width: 100%" border="1">
    <tr>
      <td> 
        <div style="width:500px" class="row col-md-5">
          <span class="input-group-addon">Representante Legal</span>
          <input id="txtnombreLegal" name="txtnombreLegal" class="form-control" type="text" required placeholder="Nombre y Apellido">
        </div>
      </td>
      <td>
        <div style="width:500px" class="row col-md-5">
          <span class="input-group-addon">Empresa</span>
          <input id="txtnombreEmpresa" name="txtnombreEmpresa" class="form-control" type="text" placeholder="Nombre del Empresa" required>
        </div>
      </td>
    </tr>
  </table>
  <tablet style="width: 100%" border="1">
    <tr>
      <td> 
        <div style="width:300px" class="row col-md-5">
          <span class="input-group-addon">R.I.F.</span>
          <input id="txtrif" name="txtrif" class="form-control" type="text" placeholder="Registro información fiscal">
        </div>
      </td>
      <td>
        <div style="width:700px" class="row col-md-5">
          <span class="input-group-addon">Dirección</span>
          <input id="txtdireEmpresa" name="txtdireEmpresa" class="form-control" type="text" placeholder="Indique ubicación fisica de la Empresa" required>
        </div>
      </td>
    </tr>
    <tr>
      <td>
        <div class="row col-md-2" style="width:300px">
          <span class="input-group-addon">Correo de la Empresa</span>
          <input id="txtcorreoempresa" name="txtcorreoempresa" class="form-control" type="email">
        </div>
      </td>
      <td>
        <div class="row col-md-2" style="width:300px">
          <span class="input-group-addon">Correo del Representante</span>
          <input id="txtcorreoRepres" name="txtcorreoRepres" class="form-control" type="email">
        </div>
      </td>
      <td>
        <div class="row col-md-2" style="width:250px">
          <span class="input-group-addon">Numero Local</span>
          <input id="txtlfLocal" name="txtlfLocal" class="form-control" type="text" placeholder="Por ejemplo, 02121234567" pattern="[0-9]+" minlength="7" maxlength="11">
        </div>
      </td>
      <td>
        <div class="row col-md-2" style="width:250px">
          <span class="input-group-addon">Numero Movil</span>
          <input id="txtlfMovil" name="txtlfMovil" class="form-control" type="text" placeholder="Por ejemplo, 04141234567" pattern="[0-9]+" minlength="7" maxlength="11">
        </div>
      </td>
    </tr>
  </table> 
  <table width="30%">
  <tr>
    <th>
     Contrato del Servicio
    </th>
  <br>
  </tr>
</table>
<br>
<div class="form-group" name="selector2" id="selector2">
  <label class="col-sm-4 control-label" for="selectbasic2">Seleccione el Servicio</label>
  <div class="col-sm-4">
    <select id="selectbasic2" name="selectbasic2" class="form-control" required onchange="contenidoEmpresas(this.value)">
    <option value="" selected disabled >Seleccionar...</option>
    '.$consultaServ.'
   </select>
  </div>
</div>
<br>
<div id="contenidoServE" name="contenidoServE" style="display:none; width:650px;">
  <table class="table" id="tabletservE" name="tabletservE" width="90%">
    <tr>
      <td align="center" width="30px"><strong>Nombre</strong></th>
      <td align="center" width="30px"><strong>Contenido del Servicio</strong></th>
      <td align="center" width="30px"><strong>Costo</strong></th>
    </tr>
    <tr>
      <td align="center" id="nombreServicioE"></td>
      <td align="center" id="contenido_servicioE"></td>
      <td align="center" id="montoServicioE"></td>
    </tr>
  </table> 
  <table style="width: 80%" align="justify">
    <tr>
      <td>
        <div class="form-group">
          <div class="col-md-6">
            <div class="input-group">
              <span class="input-group-addon">Costo de Instalación</span>
              <input id="costoInstalacionE" name="costoInstalacionE" class="form-control" placeholder="números" type="text" minlength="5" maxlength="12" required placeholder="Por ejemplo, 120345678901" pattern="[0-9]+">
            </div>
          <p class="help-block">Sin coma (,) ni puntos(.)</p>
          </div>
          <div class="col-md-6">
            <span class="input-group-addon">Nota</span>
            <textarea id="txtnotaE" name="txtnotaE" class="form-control" placeholder="Observaciones para la Instalación" type="text" minlength="5" maxlength="100"></textarea><p class="help-block">Máximo 100 caracteres (*)</p>
          </div>
        </div>
      </td>
    </tr>
    <tr>
      <td>
         <div class="form-group">
        <label class="col-md-8" control-label" for="radioContrato">¿Desea formalizar la contratación?</label>
        <div class="col-md-8"> 
          <label class="radio-inline" for="radioContrato-0">
          <input type="radio" name="radioContratoE" id="radioContrato-0" value="SI" checked="checked">
              SI
          </label> 
          <label class="radio-inline" for="radioContrato-1">
          <input type="radio" name="radioContratoE" id="radioContrato-2" value="PENDIENTE">
              PENDIENTE
          </label>
        </div>
      </div>
      </td>
    </tr>
  </table>  
</div>
<table>
  <tr>
    <td>
      <legend></legend>
      <!-- Button (Triple) -->
      <div class="row"  align="center">
        <button type="submit" class="btn btn-primary" >Generar Contrato</button>
        <button class="btn btn-primary" type="button" id="buttonLimpiarEE"  name="buttonLimpiarEE">Limpiar formulario</button>
        <a href="index.php">
          <img src="../CU_servicios/imagenes/arrow_left_15601.png" height="30" width="30"></img>
         VOLVER
        </a>
      </div> 

    </td>
  </tr>
</table>
<br>
</body>
</html>
  </form>

</div>
  
      </div>
    </div>
  </div>
</div>

<script language="JavaScript">


$( "#buttonAgregar" ).click(function()
{
  $( "#formcliente" ).submit();
  $( "#residencialForm" ).submit();
});

$("#buttonLimpiar").click(function(event) {
     $("#residencialForm")[0].reset();
    document.getElementById("contenidoServ").style.display="none";
    $("#comercialForm")[0].reset();
    document.getElementById("contenidoServC").style.display="none";
    $("#empresaForm")[0].reset();
    document.getElementById("contenidoServE").style.display="none";
});

$("#buttonLimpiarC").click(function(event) {
    $("#comercialForm")[0].reset();
    document.getElementById("contenidoServC").style.display="none";
});

$("#buttonLimpiarEE").click(function(event) {
    $("#empresaForm")[0].reset();
    document.getElementById("contenidoServE").style.display="none";
});


function valida(f) {
  var ok = true;
  var msg = "Debes llenar los campos a consultar:\n";

  if(f.elements["txtNombresApellidos"].value == "")
  {
    msg += "- Ingresar Nombre y Apellido\n";
    ok = false;
  }


  if(ok == false)
    alert(msg);
  return ok;
}



</script>';



$html->salidaFinal($tituloPagina="Página Principal",$menu="menu2",$mensaje);
?> 