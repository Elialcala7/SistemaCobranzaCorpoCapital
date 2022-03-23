
<?php 
session_start();
ini_set("display_errors", "off");
//Clase de Heramientas para programación
require_once("../../framework/librerias/herramientas.php");
$heramientas=new herramientas();
//Clase de Intrefáz HTML
require("../../framework/marco_html/html.php");
$html = new Html();
//Clase de base de Datos
require("../../framework/db/classdbPG.php");

$ObjDbPG = new bd();
define("conect","../../framework/db/CX_SIS.php");	
$conector=$ObjDbPG->classdb(conect);
$conector=$ObjDbPG->conectar();
	
if (isset($_POST["cedula"])&&($_POST["clave"]))	
{				
	$cedula=$_POST["cedula"];
	$clave=$_POST["clave"];

	$parametros=array();
	$parametros[0]=$cedula;
	$parametros[1]=$clave;
	$consultaExisteUsuario=$ObjDbPG->SELECT("consultar_usuarios",$parametros);

	//print_r($consultaExisteUsuario);exit();
	/*
		 [0] => 13109607=cedula 
		 [1] => 1=id_nivel  {1=MASTER - 2=DIRECTOR - 3=COORDINADOR - 4=ANALISTA - 5=TECNICO}
		 [2] => 1= id_usuario
		 [3] => 1=eliminar_usuario 
		 [4] => ELY=nombre  
		 [5] => ALCALA=apellido 
		 [6] => ELIALCALA.7@GMAIL.COM=correo_usuario

	*/
	if($consultaExisteUsuario[0][0]=='')
	{			
		$mensaje='
			<br>
			<br>
			<br>
			<br>
			<br>
			<br>
			<br>
			<br>
			<div class="alert alert-danger col-md-4 col-md-offset-4" align="center">			
				<strong>Cédula o clave inválida</strong>
				<a href="../CU_inicio/index.php">Intentar de nuevo</a>
			</div>';
	}
	else
	{
			session_start();
			$_SESSION['cedula_ED']=$cedula;
			$_SESSION['nombre_ED']=$consultaExisteUsuario[0][4];
			$_SESSION['apellido_ED']=$consultaExisteUsuario[0][5];
			$_SESSION['nivel_ED']=$consultaExisteUsuario[0][1];
			$_SESSION['rol_ED']=$consultaExisteUsuario[0][2];
			$_SESSION['id_usuario_ED']=$consultaExisteUsuario[0][3];
//print_r($_SESSION['rol_ED']);exit();
//colocar una opcion para que se vea el menu en forma grafica?//
			
			header("location:../CU_bienvenida/index.php");
	}	
}
	
else
{

$mensaje='
	<h2 align="center"> Bienvenid@s al Sistema de Registro y Control de Informaci&oacute;n</h2>
	<h2 align="center"> para las Cobranzas del Servicio de Internet</h2>
	<h4 align="center"> Por favor ingrese su n&uacute;mero de c&eacute;dula y clave para entrar al sistema</h4>
	<div class="row">
		<div class="col-md-2"></div>
		 <div class="col-md-8"> 
	<br><p>
		<div class="col-md-3"></div>                    
		<div class="col-md-6">                    
			<!-- Div Panel -->
			<form name="form_login" id="form_login" action="index.php" method="post">					
			<div class="panel panel-info" >			
					<!-- Panel Heading -->
					<div class="panel-heading">
						<div class="panel-title">Inicio</div>
					</div><!-- End panel heading -->
					<!-- Panel body -->
					<div class="panel-body" >
							
						<form class="form-horizontal" role="form ">
							<!-- Username -->
							<div class="input-group input-username form-group has-info">
								<span class="input-group-addon"><i class="fa fa-user"></i></span><input type="text" class="form-control" name="cedula" id="cedula" placeholder="Cédula" autofocus>
							</div>
								
							<!-- Password -->
							<p>
							<div class="input-group input-password form-group has-info">
								<span class="input-group-addon"><i class="fa fa-lock"></i></span><input type="password" class="form-control" name="clave" id="clave" placeholder="contraseña">
							</div>
							
							<div class="form-group login-button">
								<div class="col-sm-12 controls">
								<br><p>
								<button type="submit" class="btn btn-info pull-right" ><i class="fa fa-sign-in"></i>&nbsp;Entrar</button>
								</div>
							</div>

						</form><!-- ENd form -->     
					</div><!-- ENd panel body -->
			</div><!-- End panel group -->  
			</form>
		</div><!-- End col div -->
	</div><!-- End container -->
	
	</div>
			<div class="col-md-2"></div>
	</div>	';	
}

$html->salidaFinal($tituloPagina="Inicio de sesión",$Nmenu="menu2",$mensaje);
?>