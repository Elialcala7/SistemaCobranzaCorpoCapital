<?php 
require('../includes.php');
require ("../head.php");

//Clase de base de DatosObjDbPG = new bd();
define("conect","../../framework/db/CX_SIS.php");
$conector=$ObjDbPG->classdb(conect);
$conector=$ObjDbPG->conectar();    

extract($_POST);
$newValor=($_POST['increnuevo']);
$idservicio=($_POST['idServicio']);
$fechaSistema=($_POST['fechaSistem']);

$parametros=array();
$parametros[0]=$idservicio;
$consultarServicio=$ObjDbPG->SELECT("consultar_servicio",$parametros);

$idServicio = $consultarServicio[0][0];
$nombreServicio = $consultarServicio[0][1];
$contenidoServicio = $consultarServicio[0][2];
$costoServicio = $consultarServicio[0][3];
$fechaCreacion = $consultarServicio[0][4];
$newFecha = date("d/m/Y", strtotime($fechaCreacion));
$incrementoServicio = $consultarServicio[0][5];
$tipoPlan = $consultarServicio[0][6];

//CALCULAR INCREMENTO//
if(is_numeric($newValor)) 
{
  $newCosto1 = $costoServicio + ($costoServicio*$newValor/100);
  $newCosto = round($costoServicio + ($costoServicio*$newValor/100),0,PHP_ROUND_HALF_EVEN);
  //$newCosto =ceiling($costoServicio + ($costoServicio*$newValor/100),1000);
 // echo round(9.5, 0, PHP_ROUND_HALF_EVEN); // 10
  //$newCosto=ceil($newCosto1,1000);
  $mensaje='
<link rel="stylesheet" href="estilos.css"> 

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
      <form  class="form-horizontal" method="POST" action="registroServicio.php" >
        <div id="increnuevo" name="increnuevo" class="row ">
          <div class="col">
            <label for="increnuevo" class="justify-content-start col-md-6"> Incremento : </label>'.$newValor.'%
          </div>
        </div> 
        <div id="newCosto" name="newCosto" class="row">
          <div class="col">
            <label for="newCosto1" class="justify-content-start col-md-6"> Nuevo Costo: </label>'.$newCosto1.'
          </div>
        </div> 
        <div id="newCosto" name="newCosto" class="row">
          <div class="col">
            <label for="newCosto" class="justify-content-start col-md-6"> Aplicando Criterio: </label>
              '.$newCosto.' 
            </div>
        </div>  
      </form>
    </div>
</div>
<div id="frameText" style=" margin-top:-20px" class="mainbox col-md-12">
    <div class="panel-body" >
      <form  class="form-horizontal" method="post" action="generar.php" >
        <div class="row col col-md-12"> 
          <div class="col col-md-12" style="float:right; font-size: 100%; position: relative; top:-10px">
            <a href="index.php">
              <button>
                <img src="imagenes/arrow_left_15601.png" height="30" width="30"></img>
                VOLVER
              </button>
            </a>
          </div>
       
           <input type="hidden" id="idServicio" name="idServicio" value="'.$_POST['idServicio'].'">
           <input type="hidden" id="fechaSistema" name="fechaSistema" value="'.$fechaSistema.'">
           <input type="hidden" id="incremento" name="incremento" value="'.$newValor.'">
           <input type="hidden" id="newCosto" name="newCosto" value="'.$newCosto.'">
           <input type="hidden" id="descripcion" name="descripcion" value="'.$tipoPlan.'">
           <input type="hidden" id="nombreServicio" name="nombreServicio" value="'.$nombreServicio.'">
       
          <div class="col col-md-12" style="float:right; font-size: 100%; position: relative; top:-10px">
            <button class="btn btn btn-primary"><img src="imagenes/blue_upgrade_recyclearrows_arrow_azul_12426.png" height="30" width="30"></img>Actualizar</button>
          </div>
        </div> 
      </form>
    </div>
</div>';
}
else
{
  $mensaje='
<div class="contenedor1">
  <div class="alert alert-danger" role="alert">
    Error! Datos Incorrectos!!!
</div>    
    <form  class="form-horizontal" method="post" >
        <div class="row" > 
          <div class="col col-md-4" font-size: 100%; position: relative; top:-10px;">
            <a href="index.php"><button type="button"><img src="imagenes/arrow_left_15601.png" height="30" width="30"></img>VOLVER</button></a>
          </div>
        </div> 
      </form>
  </div>
<style>
.contenedor1 {
  
  width: 850px;
  height: 200px;
  position: absolute;
  top: 55%;
  left: 50%;
  margin-top: -100px;
  margin-left: -280px;
}

.contenedor2 {
  
  width: 600px;
  height: 200px;
  position: absolute;
  top: 75%;
  left: 50%;
  margin-top: -5px;
  margin-left: -280px;
}
</style>  ';
}


$html->salidaFinal($tituloPagina="Página Principal",$menu="menu2",$mensaje);

?> 