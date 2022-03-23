 <?php
require('../includes.php');
require ("../head.php");

//session_start();
extract($_POST);
//print_r($_POST); exit();
//GUARDAR EN BASE DE DATOS//

define("conect","../../framework/db/CX_SIS.php");
$conector=$ObjDbPG->classdb(conect);
$conector=$ObjDbPG->conectar();  

$idservicio=$_POST['idServicio'];
$montoNuevo=$_POST['newCosto'];
$fechasistema=$_POST['fechaSistema'];
$incremento=$_POST['incremento'];

$parametros=array();
$parametros[0]=$idservicio;
$parametros[1]=$montoNuevo;
$actualizarServicio=$ObjDbPG->SELECT("actualizarservicio",$parametros);

$par=array();
$par[0]=$fechasistema;
$par[1]=$montoNuevo;
$par[2]=$idservicio;
$par[3]=$incremento;

$InsertarCostos=$ObjDbPG->SELECT("insertar_costos",$par);

//IP SEGURIDAD //
$ip=get_ip_address();

  function get_ip_address()
  {

      if (!empty($_SERVER['HTTP_CLIENT_IP']))  
        {  
            $ip=$_SERVER['HTTP_CLIENT_IP'];  
        }  
      elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))  
      //to check ip is pass from proxy  
        {  
            $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];  
        }  
        else  
        {  
            $ip=$_SERVER['REMOTE_ADDR'];  
        }  
      return $ip;  //ip del equipo

  }

$movimiento='ACTUALIZAR COSTO PARA SERVICIO'; //informacion de gestion dentro del modulo
$usuario=$_SESSION['cedula_ED'];
  //AGREGAR HISTORICO TABLA SEGURIDAD//

  $parametros=array();
  $parametros[0]=$fechasistema; //integer 
  $parametros[1]=$usuario;
  $parametros[2]=$ip;
  $parametros[3]=$movimiento;
  $parametros[4]=$idservicio;
  $IncluirHistorico=$ObjDbPG->SELECT("public.insertar_seguridad",$parametros);

$mensaje=
' 
  <div class="row contenedor1">
   <div class="alert alert-success col-md-8" align="center"><img src="imagenes/success_icon-icons.com_52365.png"></img>
	   Servicio '.$_POST['nombreServicio'].' del Plan '.$_POST['descripcion'].' 
	   ha Actualizado su Costo!
   </div>
</div>
   <div class="col-md-12" align="center"> 
          <div class="col-md-12 contenedor2" font-size: 100%; position: absolute; top:110px;">
            <a href="../CU_bienvenida/index.php"><button><img src="imagenes/mbrilogout_99583.png" height="30" width="30"></img>Regresar</button></a>
          </div>
    </div> 
<style>
.contenedor1 {
  
  width: 850px;
  height: 200px;
  position: absolute;
  top: 80%;
  left: 50%;
  margin-top: -100px;
  margin-left: -280px;
}

.contenedor2 {
  
  width: 600px;
  height: 200px;
  position: absolute;
  top: 250px;
  left: 70%;
  margin-top: -5px;
  margin-left: -280px;
}
</style>
';

$html->salidaFinal($tituloPagina="Página Principal",$menu="menu2",$mensaje);

?>