<?php

require("../includes.php");

extract($_POST);

$fdesde=date('Y-m-d', strtotime($_POST['fechaemision']));
$fhasta=date('Y-m-d', strtotime($_POST['fecharecibe']));

/*
 [fechaemision] => 04-02-2020 
 [fecharecibe] => 31-03-2020 
 [tipoC] => 2 
 [clientesPend] => PENDIENTE
*/
if($_POST['tipoC']!="")
{
	 $parametros = array();
	 $parametros[0]=$_POST['tipoC']; 
	 $parametros[1]=$fdesde; 
	 $parametros[2]=$fhasta; 
	 $resultClientes=$ObjDbPG->SELECT("public.consultar_clientestipos_fechas",$parametros);

	 //print_r($resultClientes);exit();
	 /*
		[0] => 18 
		[1] => 
		[2] => Mariano Alvarez 
		[3] => 02125478936 
		[4] => 15420320 
		[5] => BASICO III 
		[6] => 62500 
		[7] => 2020-05-12 
		[8] => 1
	 */
	if($resultClientes[0][0]!="")
	{
		//CONTENIDO DEL REPORTE//

		$i=1;
		$contRegistro = count($resultClientes);

		foreach ($resultClientes as $valor) 
		{
			$nombreCliente=$valor[2].' '.$valor[1];
			$noTelefono=$valor[3];
			$ci_rif=$valor[4];
			$nombreServicio=$valor[5];
			$costoServicio=$valor[6];
			$RegistroFecha=date('d-m-Y', strtotime($valor[7]));

			$mensaje='
				<table style="margin-top:50px" >
					<tr>
						<td align="center">
							<img style="vertical-align: top" src="imagenes/corpocapital.png" width="870" height="100">
							</td>
					</tr>
				<tr><br>
					<td align="center">										
						<h3>REPORTE ESPECIFICO POR FECHAS</h3>
					</td>
				</tr>
				<tr>
					<td align="center">
						<h3>REGISTRO DE CLIENTES '.$valor[8].'</h3>
						<h3>DESDE  '.$fdesde.' - HASTA  '.$fhasta.'</h3>
					</td>
				</tr>	
				</table>';	

			$contenido.="
						<tr>
							<td align='center'>$i</td>
							<td align='center'>$nombreCliente</td>
							<td align='center'>$ci_rif</td>
			                <td align='center'>$noTelefono</td>
			                <td align='center'>$nombreServicio</td>
			                <td align='center'>$costoServicio</td>
			                <td align='center'>$RegistroFecha</td>
						</tr>";
			$i=$i+1;
		}

		$total=($i-1);

			$resultado='
			<br><br><br><br>
			<table style="width:100%; font-family: arial, sans-serif;" border="1" CELLPADDING=3 CELLSPACING=0>
			<br><br>
			  <tr>
			    <th>#</th>
			    <th>Cliente</th>
			    <th>C.I./R.I.F.</th>
			    <th>No. Telefonico</th>
			    <th>Servicio</th>
			    <th>Costo del Servicio</th>
			    <th>Fecha de Registro</th>			 
			  </tr>

			 <tbody class="columnas">
			'.$contenido.'
			</tbody>
			</table>

				<h6>Total Registros: '.$total.'</h6>

			';

			require_once('../../framework/librerias/mpdf-5.7/mpdf.php');
			$mpdf=new mPDF('c','Legal-L','','',8,5,35,5,5,5,'L');
			$stylesheet = file_get_contents('mpdfstyletables.css');
			
			$fe=date("d-m-Y");
			$mpdf->SetHTMLHeader($mensaje);	
			$mpdf->WriteHTML($resultado);
			$mpdf->SetFont('Arial', 'B', '10');
			
			$mpdf->setFooter('Fecha de Impresión '.$fe.''); 
			$mpdf->WriteHTML($stylesheet,1);
			ob_end_clean();
			ob_clean();
			$mpdf->Output('ReporteClientes'.$fe.'.pdf','I');	
	}
	else
	{
	//ENCABEZADO//
		$mensaje='
			<table style="margin-top:50px" >
				<tr>
					<td align="center">
						<img style="vertical-align: top" src="imagenes/corpocapital.png" width="870" height="100">
						</td>
				</tr>
			<tr>
				<td align="center">										
					<h5>REPORTE ESPECIFICO POR FECHAS</h5>
					<h5>REGISTRO DE CLIENTES '.$valor[8].'</h5>
					<h5>DESDE  '.$fdesde.' - HASTA  '.$fhasta.'</h5>
				</td>
			</tr>
			<br><br><br>
			<tr>
				<td align="center">										
					 <h3 align="center" top="100">SIN REGISTROS PARA LA FECHA</h3>
				</td>
			</tr>		
		</table>';	

		require_once('../../framework/librerias/mpdf-5.7/mpdf.php');
		$mpdf=new mPDF();
		$stylesheet = file_get_contents('mpdfstyletables.css');
		$fe=date("d-m-Y");
		$mpdf->SetHTMLHeader($mensaje);			
		$mpdf->setFooter('Fecha de Impresión '.$fe.''); 
		$mpdf->WriteHTML($stylesheet,1);
		ob_end_clean();
		ob_clean();
		$mpdf->Output('ReporteClientes'.$fe.'.pdf','I');
	}
}

if (isset($_POST['clientesPend']))
{
	 $parametros = array();
	 $parametros[0]=$fdesde;  
	 $parametros[1]=$fhasta;  
	 $parametros[2]=$_POST['clientesPend'];  
	 $resultInteresados=$ObjDbPG->SELECT("public.consultar_interesados_clientes",$parametros);

	 /*
		[0] => 17 
		[1] => 
		[2] => Carolina Martinez 
		[3] => 04122569845 
		[4] => 12345678 
		[5] => BASICO I 
		[6] => 330000 
		[7] => 2020-05-12 
		[8] => RESIDENCIAL
	 */

	 if($resultInteresados[0][0]=="")
	 {

	 	$mensaje='
			<table style="margin-top:50px" >
				<tr>
					<td align="center">
						<img style="vertical-align: top" src="imagenes/corpocapital.png" width="870" height="100">
						</td>
				</tr>
			<tr>
				<td align="center">										
					<h5>REPORTE PERSONAS INTERESADAS</h5>
					<h5>DESDE  '.$fdesde.' - HASTA  '.$fhasta.'</h5>
				</td>
			</tr>
			<br><br><br>
			<tr>
				<td align="center">										
					 <h3 align="center" top="100">SIN REGISTROS PARA LA FECHA</h3>
				</td>
			</tr>		
		</table>';	

		require_once('../../framework/librerias/mpdf-5.7/mpdf.php');
		$mpdf=new mPDF();
		$stylesheet = file_get_contents('mpdfstyletables.css');
		$fe=date("d-m-Y");
		$mpdf->SetHTMLHeader($mensaje);			
		$mpdf->setFooter('Fecha de Impresión '.$fe.''); 
		$mpdf->WriteHTML($stylesheet,1);
		ob_end_clean();
		ob_clean();
		$mpdf->Output('ReporteInteresados'.$fe.'.pdf','I');

	 }
	 else
	 {
	 	//CONTENIDO DEL REPORTE//

		$i=1;
		$contRegistro = count($resultInteresados);

		foreach ($resultInteresados as $valor) 
		{
			$nombreCliente=$valor[2].' '.$valor[1];
			$noTelefono=$valor[3];
			$ci_rif=$valor[4];
			$nombreServicio=$valor[5];
			$costoServicio=$valor[6];
			$RegistroFecha=date('d-m-Y', strtotime($valor[7]));
			$correo=$valor[8];
			$tipoCliente=$valor[9];

			$mensaje='
				<table style="margin-top:50px" >
					<tr>
						<td align="center">
							<img style="vertical-align: top" src="imagenes/corpocapital.png" width="870" height="100">
							</td>
					</tr>
				<tr>
					<td align="center">
						<h3>REGISTRO DE PERSONAS INTERESADAS</h3>
						<h3>DESDE  '.$fdesde.' - HASTA  '.$fhasta.'</h3>
					</td>
				</tr>	
				</table>';	

			$contenido.="
						<tr>
							<td align='center'>$i</td>
							<td align='center'>$nombreCliente</td>
							<td align='center'>$ci_rif</td>
			                <td align='center'>$noTelefono</td>
			                <td align='center'>$correo</td>
			                <td align='center'>$nombreServicio</td>
			                <td align='center'>$costoServicio</td>
			                <td align='center'>$RegistroFecha</td>
			                <td align='center'>$tipoCliente</td>
						</tr>";
			$i=$i+1;
		}

		$total=($i-1);

			$resultado='
			<br><br><br><br>
			<table style="width:100%; font-family: arial, sans-serif;" border="1" CELLPADDING=3 CELLSPACING=0>
			<br><br>
			  <tr>
			    <th>#</th>
			    <th>Interesado/Cliente</th>
			    <th>C.I./R.I.F.</th>
			    <th>No. Telefonico</th>
			    <th>correo</th>
			    <th>Servicio</th>
			    <th>Costo Servicio</th>
			    <th>Fecha de Registro</th>	
			    <th>Tipo de Cliente</th>		 
			  </tr>

			 <tbody class="columnas">
			'.$contenido.'
			</tbody>
			</table>

				<h6>Total Registros: '.$total.'</h6>

			';

			require_once('../../framework/librerias/mpdf-5.7/mpdf.php');
			$mpdf=new mPDF('c','Legal-L','','',8,5,35,5,5,5,'L');
			$stylesheet = file_get_contents('mpdfstyletables.css');
			
			$fe=date("d-m-Y");
			$mpdf->SetHTMLHeader($mensaje);	
			$mpdf->WriteHTML($resultado);
			$mpdf->SetFont('Arial', 'B', '10');
			
			$mpdf->setFooter('Fecha de Impresión '.$fe.''); 
			$mpdf->WriteHTML($stylesheet,1);
			ob_end_clean();
			ob_clean();
			$mpdf->Output('ReporteInteresados'.$fe.'.pdf','I');	

	 }
}


if(isset($fdesde))
{  
	 $parametros = array();
	 $parametros[0]=$fdesde;  
	 $parametros[1]=$fhasta;  
	 $result=$ObjDbPG->SELECT("public.consultar_rangofechas",$parametros);
	 /*
	  [0] => 103 
	  [1] => 14 
	  [2] => Agustin Prieto 
	  [3] => 02126547855 
	  [4] => 1 
	  [5] => BASICO I 
	  [6] => 330000 
	  [7] => 2020-08-09
	 */

	  if($result[0][0]=="")
	  {
		//ENCABEZADO//
		$mensaje='
			<table style="margin-top:50px" >
				<tr>
					<td align="center">
						<img style="vertical-align: top" src="imagenes/corpocapital.png" width="870" height="100">
						</td>
				</tr>
			<tr>
				<td align="center">										
					<h5>REPORTE ESPECIFICO POR FECHAS</h5>
					<h5>CLIENTES PENDIENTES DE COBRO</h5>
					<h5>DESDE  '.$fdesde.' - HASTA  '.$fhasta.'</h5>
				</td>
			</tr>
			<br><br><br>
			<tr>
				<td align="center">										
					 <h3 align="center" top="100">SIN REGISTROS PARA LA FECHA</h3>
				</td>
			</tr>		
		</table>';	

		require_once('../../framework/librerias/mpdf-5.7/mpdf.php');
		$mpdf=new mPDF();
		$stylesheet = file_get_contents('mpdfstyletables.css');
		$fe=date("d-m-Y");
		$mpdf->SetHTMLHeader($mensaje);			
		$mpdf->setFooter('Fecha de Impresión '.$fe.''); 
		$mpdf->WriteHTML($stylesheet,1);
		ob_end_clean();
		ob_clean();
		$mpdf->Output('ReporteCorteFechas'.$fe.'.pdf','I');
	}
	else
	{
		
		//CONTENIDO DEL REPORTE//

		$i=1;
		$contRegistro = count($result);

		foreach ($result as $valor) 
		{
			$nombreCliente=$valor[2];
			$noTelefono=$valor[3];
			$nombreServicio=$valor[5];
			$montoPendiente=$valor[6];
			$fechaCorte=date('d-m-Y', strtotime($valor[7]));

			$mensaje='
				<table style="margin-top:50px" >
					<tr>
						<td align="center">
							<img style="vertical-align: top" src="imagenes/corpocapital.png" width="870" height="100">
							</td>
					</tr>
				<tr>
					<td align="center">
						<h3>CLIENTES PENDIENTES DE COBRO</h3>
						<h3>DESDE  '.$fdesde.' - HASTA  '.$fhasta.'</h3>
					</td>
				</tr>	
				</table><br><br>
				<table><tr><td></td></tr></table>';	

			$contenido.="
						<tr>
							<td align='center'>$i</td>
							<td align='center'>$nombreCliente</td>
			                <td align='center'>$noTelefono</td>
			                <td align='center'>$nombreServicio</td>
			                <td align='center'>$montoPendiente</td>
			                <td align='center'>$fechaCorte</td>
						</tr>";
			$i=$i+1;
		}

		$total=($i-1);

			$resultado='
			<br><br>
			<table><tr><td></td></tr></table><br><br><br><br>
			<table style="width:100%; font-family: arial, sans-serif;" border="1" CELLPADDING=3 CELLSPACING=0>
			  <br><br><tr>
			    <th>#</th>
			    <th>Cliente</th>
			    <th>No. Telefonico</th>
			    <th>Servicio</th>
			    <th>Monto Pendiente</th>
			    <th>Fecha de Corte</th>			 
			  </tr>

			 <tbody class="columnas">
			'.$contenido.'
			</tbody>
			</table>

				<h6>Total Registros: '.$total.'</h6>

			';

			require_once('../../framework/librerias/mpdf-5.7/mpdf.php');
			$mpdf=new mPDF('c','Legal-L','','',8,5,35,5,5,5,'L');
			$stylesheet = file_get_contents('mpdfstyletables.css');
			
			$fe=date("d-m-Y");
			$mpdf->SetHTMLHeader($mensaje);	
			$mpdf->WriteHTML($resultado);
			$mpdf->SetFont('Arial', 'B', '10');
			
			$mpdf->setFooter('Fecha de Impresión '.$fe.''); 
			$mpdf->WriteHTML($stylesheet,1);
			ob_end_clean();
			ob_clean();
			$mpdf->Output('ReporteXFechas'.$fe.'.pdf','I');	
	}
}




?>