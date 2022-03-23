<?php 
require('../includes.php');
require ("../head.php");

extract($_POST);


$condicionCliente=$_POST['checkcliente']; //condicionando si es nuevo el cliente o existente//
$id_tipocliente=$_POST['selectcliente'];  //cliente Residencial= 1; Comercial= 2; 
$fechaRegistro = $_POST['fechaSistema']; //fecha actual
$usuario=$_POST['usuario']; // cedula del usuario que manipula el sistema
$nombresRepresentante=$_POST['txtnombreLegal']; //nombres y apellidos ==> igual para cliente se guarda//
$RIFcomercio=$_POST['txtrif']; //cedula de cliente o representante ==> rif del comercio
$telefono1=$_POST['txtlfLocal']; //telefono1 ==> igual va en telefono 1
$telefono2=$_POST['txtlfMovil']; //otro numero puede estar en blanco ==> igual guarda telefono 2
$correo=$_POST['txtcorreoComercio']; //correo ==>correo principal del comercio
$direccion=$_POST['txtdireComercio']; //direccion de habitacion ==> direccion del comercio
$id_servicio=$_POST['selectbasic1']; // id del servicio (luego hacer consulta con el id)
$costoInstalacion=$_POST['costoInstalacionC']; //costo por instalacion
$notaObservacion=$_POST['txtnotaC']; //nota sobre la instalacion
$statuscontrato=$_POST['radioContratoC']; //confirmacion de contrato SI / NO / PENDIENTE
$nombreComercio=$_POST['txtnombreComercio']; //nombre del comercio
$OtroCorreo=$_POST['txtcorreoRepres'];

$ObjDbPG = new bd();
define("conect","../../framework/db/CX_SIS.php");
$conector=$ObjDbPG->classdb(conect);
$conector=$ObjDbPG->conectar();

//guardar calculos//
$parametros=array();
$parametros[0]=$id_servicio;  
$consultaServicio=$ObjDbPG->SELECT("public.consultar_servicio",$parametros);

$costoServicio= $consultaServicio[0][3];
$totalSercicio = $costoServicio + $costoInstalacion;
//

//AGREGAR TABLA CLIENTE//
$parametros=array();
$parametros[0]=$condicionCliente; //integer 
$parametros[1]=$nombresRepresentante; //cv
$parametros[2]=$RIFcomercio;       //text
$parametros[3]=$telefono1;      //text
$parametros[4]=$telefono2;      //text
$parametros[5]=$correo;          //cv
$parametros[6]=$direccion;       //cv
$parametros[7]=$id_servicio;     //integer
$parametros[8]=$costoInstalacion;//integer
$parametros[9]=$notaObservacion;//cv
$parametros[10]=$statuscontrato; //cv
$parametros[11]=$fechaRegistro;  //date
$parametros[12]=$usuario;        //integer
$parametros[13]=$id_tipocliente; //integer
$parametros[14]=$nombreComercio;
$parametros[15]=$OtroCorreo;
$parametros[16]=$costoServicio;

$IncluirRegistro=$ObjDbPG->SELECT("public.insertar_cliente",$parametros);


//IP SEGURIDAD //
$ip=get_ip_address();

  function get_ip_address()
  {

      if (!empty($_SERVER['HTTP_CLIENT_IP']))  
        {  
            $ip=$_SERVER['HTTP_CLIENT_IP'];  
        }  
      elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))  
      
        {  
            $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];  
        }  
        else  
        {  
            $ip=$_SERVER['REMOTE_ADDR'];  
        }  
      return $ip;  //ip del equipo

  }

$movimiento='AGREGAR CLIENTE COMERCIAL'; //informacion de gestion dentro del modulo

$control='COM#';
if($IncluirRegistro[0][0]!='')
{
  //AGREGAR HISTORICO TABLA SEGURIDAD//

  $parametros=array();
  $parametros[0]=$fechaRegistro; //integer 
  $parametros[1]=$usuario;
  $parametros[2]=$ip;
  $parametros[3]=$movimiento;
  $parametros[4]=$IncluirRegistro[0][0];
  $IncluirHistorico=$ObjDbPG->SELECT("public.insertar_seguridad",$parametros);
  
  if($statuscontrato=='SI')
  {
        //AGREGAR FACTURAS PENDIENTE DE COBRO//
    $fechahoy=date('Y-m-d');
    $fechaInicio = $fechahoy;
    $fechaFin = "2021-12-31"; //valor que se puede cambiar por ahora manual//
    //conversion de fechas//
    $tiempoInicio = strtotime($fechaInicio);
    $tiempoFin = strtotime($fechaFin);
    // 1dia= 24 horas * 60 minutos por hora * 60 segundos por minuto
    $dia = 2592000; //30 dias
    $i = 1;
    while ($tiempoInicio <= $tiempoFin):
    
        $fechacorte= date("Y-m-d", $tiempoInicio);
     
        $parametros=array();
        $parametros[0]=$IncluirRegistro[0][0]; //integer 
        $parametros[1]=$id_servicio;
        $parametros[2]=$costoServicio;
        $parametros[3]=$fechacorte;
        $IncluirHistorico=$ObjDbPG->SELECT("public.insertar_pfcobro",$parametros);

       // Sumar el incremento para que en algún momento termine el ciclo
       $tiempoInicio += $dia;
    endwhile;

    $mensaje = '
    <form id="formMensaje" name="formMensaje" method="post" action="../CU_pagos/formPagos.php">
    <input type="hidden" id="idCliente" name="idCliente" class="form-control" value="'.$IncluirRegistro[0][0].'">
    <input id="fechaSistema" name="fechaSistema" class="form-control" type="hidden" value="'.$fechaRegistro .'">
    <input id="costoServicio" name="costoServicio" class="form-control" type="hidden" value="'.$costoServicio.'">
    <input id="costoInstalacion" name="costoInstalacion" class="form-control" type="hidden" value="'.$costoInstalacion.'">
    <input id="totalSercicio" name="totalSercicio" class="form-control" type="hidden" value="'.$totalSercicio.'">
    
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <div class="alert alert-success col-md-4 col-md-offset-4" align="center">      
              <strong>CLIENTE Agregado Exitosamente!!!</strong>
              <br>
              <strong>No. Control: </strong>'.$control.''.$IncluirRegistro[0][0].'
              <strong><br>Total Bs. Contrato: '.$totalSercicio.'</strong>
              <button>Procesar Pago</button>
            </div>
    </form>';
    
  }
else
{
  $mensaje='<br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <div class="alert alert-success col-md-4 col-md-offset-4" align="center">      
              <strong>CLIENTE con estatus PENDIENTE Agregado Exitosamente!!!</strong>
              <br>
              <strong>No. Control: </strong>'.$control.''.$IncluirRegistro[0][0].'
              <strong><br>Total Bs. Contrato: '.$totalSercicio.'</strong>
              <a href="index.php"><br>Retorno</a>
            </div>';
}
}
$html->salidaFinal($tituloPagina="Página Principal",$menu="menu2",$mensaje);
?> 