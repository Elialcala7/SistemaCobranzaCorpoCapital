<?php 
require('../includes.php');
require ("../head.php");

//session_start();
$fechaRegistro = date('d-m-Y'); //fecha actual


$mensaje='
<div class="container bootstrap snippet" >
  <div class="row" align="center">
    <div class="col-sm-10" >
    <br><br>
 <form  class="form-horizontal" id="formcliente" name="formcliente" method="POST" action="datos.php">
  <fieldset>
   <input id="fechaSistema" name="fechaSistema" class="form-control" type="hidden" value="'.$fechaRegistro .'">
   <input id="usuario" name="usuario" class="form-control" type="hidden" value="'.$_SESSION['cedula_ED'].'">
    <table>
      <tr>
        <td>
       	<label>Introduzca No. de Contrato:</label>
        </td>
        <td>
          <div class="col-sm-12">
            <input type="text" id="idConsultar" name="idConsultar" value="" minlength="1" maxlength="8" required placeholder="Por ejemplo, 12345678" pattern="[0-9]+">
          </div>
        </td>
        <td>
          <div class="col-sm-12">
           <button>Consultar</button>
          </div>
        </td>
      </tr>
    </table>  
  </fieldset>
 </form>
<legend></legend>

	<hr>

';


$html->salidaFinal($tituloPagina="Página Principal",$menu="menu2",$mensaje);
?> 

