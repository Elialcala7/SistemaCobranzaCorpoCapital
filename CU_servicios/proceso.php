<?php 
require('../includes.php');
require ("../head.php");

//Clase de base de DatosObjDbPG = new bd();
define("conect","../../framework/db/CX_SIS.php");
$conector=$ObjDbPG->classdb(conect);
$conector=$ObjDbPG->conectar();    

extract($_POST);
//print_r($_POST);exit();
$idServicio = $_POST['servSelec'];
$parametros=array();
$parametros[0]=$idServicio;
$consultarServicio=$ObjDbPG->SELECT("consultar_servicio",$parametros);

//print_r($consultarServicio); exit();

$idServicio = $consultarServicio[0][0];
$nombreServicio = $consultarServicio[0][1];
$contenidoServicio = $consultarServicio[0][2];
$costoServicio = $consultarServicio[0][3];
$fechaCreacion = $consultarServicio[0][4];
$newFecha = date("d/m/Y", strtotime($fechaCreacion));
$incrementoServicio = $consultarServicio[0][5];
$tipoPlan = $consultarServicio[0][6];
$fechaSistem = date("d/m/Y");

$mensaje='<link rel="stylesheet" href="estilos.css"> 

<div id="frameText" style=" margin-top:20px" class="mainbox col-md-6">
  <div class="panel panel-info">
    <div class="panel-heading">
      <div class="panel-title">SERVICIO ACTIVO: '.$nombreServicio.'</div><br>
      <div style="float:right; font-size: 85%; position: relative; top:-10px">Fecha de Creación: '.$newFecha.'</div>
    </div>  
    <div class="panel-body" >
      <form  class="form-horizontal" method="post" >
        <div id="contenidoServicio" name="contenidoServicio" class="form-group ">
          <label for="contenidoServicio" class="control-label col-md-4"> Contenido: </label>
          <div class="controls col-md-6">'.$contenidoServicio.'</div>
        </div>
        <div id="tipoPlan" name="tipoPlan" class="form-group ">
          <label for="tipoPlan" class="control-label col-md-4"> Plan: </label>
          <div class="controls col-md-6">'.$tipoPlan.'</div>
        </div>
        <div id="costoServicio" name="costoServicio" class="form-group ">
          <label for="costoServicio" class="control-label col-md-4"> Costo del Servicio: </label><br>
          <div class="controls col-md-6">'.$costoServicio.'</div>
        </div>
        <div id="incrementoServicio" name="incrementoServicio" class="form-group ">
          <label for="incrementoServicio" class="control-label col-md-4"> Último Incremento del Servicio: </label><br>
          <div class="controls col-md-6">'.$incrementoServicio.'%</div>
        </div>
      </form>
    </div>
  </div> 
</div>

<div id="frameText" style=" margin-top:20px" class="mainbox col-md-4">
  <div class="panel panel-info">
    <div class="panel-heading">
      <div class="panel-title">ACTUALIZACION DEL COSTO</div><br>
      <div style="float:right; font-size: 85%; position: relative; top:-10px">Fecha de Actualización: '.$fechaSistem.'</div>
    </div>  
    <div class="panel-body" >
      <form  class="form-horizontal" method="POST" action="procesar.php" >
        <div id="increnuevo" name="increnuevo" class="row ">
          <div class="col">
            <label for="increnuevo" class="justify-content-start col-md-4"> Incremento%: </label>
            <input type="text" class="justify-content-start col-md-4" id="increnuevo" name="increnuevo" require="require" size="2" onChange="validarSiNumero(this.value);">
            <input type="hidden" name="idServicio" id="idServicio" value="'.$_POST['servSelec'].'"/>
            <input type="hidden" name="fechaSistem" id="fechaSistem" value="'.$fechaSistem.'"/>
            <br><button>
              <img src="imagenes/percentage_77945.png" height="20" width="20"></img>
              Calcular
            </button>

          </div> 
        </div> 
      </form>
    </div>
</div>

<div id="frameText" style=" margin-top:20px" class="mainbox col-md-12">
    <div class="panel-body" >
      <form  class="form-horizontal" method="post" >
        <div class="row" > 
          <div class="col col-md-12" font-size: 100%; position: relative; top:-10px;">
            <a href="index.php">
              <img src="imagenes/arrow_left_15601.png" height="30" width="30"></img> VOLVER</a>
          </div>
        </div> 
      </form>
    </div>
</div>

<script>
  function validarSiNumero(numero){
    if (!/^([0-9])*$/.test(numero))
      alert("El valor " + numero + " no es un número");
  }
</script>  
    ';
$html->salidaFinal($tituloPagina="Página Principal",$menu="menu2",$mensaje);
?> 

