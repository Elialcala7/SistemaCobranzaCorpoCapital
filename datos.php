<?php

require('../includes.php');
require ("../head.php");

extract($_POST);

//print_r($_POST);exit();
$ObjDbPG = new bd();
define("conect","../../framework/db/CX_SIS.php");
$conector=$ObjDbPG->classdb(conect);
$conector=$ObjDbPG->conectar();


$parametros = array();  
$parametros[0]=$_POST['idConsultar'];  
$consultarDatosCliente=$ObjDbPG->SELECT("public.consultar_cliente",$parametros);

if ($consultarDatosCliente[0][0]!='')
{
  $parametros = array();  
  $parametros[0]=$consultarDatosCliente[0][0]; 
  $consultaGeneralpFactura=$ObjDbPG->SELECT("public.consultar_fpcobro",$parametros);

    if($consultaGeneralpFactura[0][0]== '')
    {
        $mensaje='
    <style>
      .padre 
      {
         background-color: #fafafa;
         margin: 10rem;
         padding: 1rem;
         text-align: center;
      }
      </style>
    <br><br>
    <div class="alert alert-warning padre">
      <strong>INFO:</strong> CLIENTE NO REGISTRADO EN BASE DE DATOS!!!.
      <a href="../CU_bienvenida/index.php">
              <img src="../CU_servicios/imagenes/arrow_left_15601.png" height="30" width="30"></img>
             VOLVER
      </a>
    </div>';

    }
    else
    {
      if($consultarDatosCliente[0][12]=='SI')
      {
        $estatusCliente = 'CLIENTE ACTIVO';

        /*MANIPULACION DE FECHAS*/
        $fechaContrato = date("d-m-Y",strtotime($consultarDatosCliente[0][13]));
        $fecha= explode("-", $fechaContrato);
        $fechaCorteInfo = 'El ' .$fecha[0].' de cada mes';
        $fechaHoy= date("d-m-Y");


        if($consultarDatosCliente[0][1]==1)
        {
          $condicionCliente = 'CLIENTE NUEVO';
        }

        if($consultarDatosCliente[0][16]=='RESIDENCIAL')
        {
          $control='RES#';
        }
        if($consultarDatosCliente[0][16]=='COMERCIAL')
        {
          $control='COM#';
        }
        if($consultarDatosCliente[0][16]=='EMPRESARIAL')
        {
          $control='EMP#';                                                                                 
        }

       $datosValores='';
       $botonModal='<form id="historicoP" name="historicoP" action="modalHistorico.php" method="POST">
           <input id="idClienteConsultar" name="idClienteConsultar" type="hidden" value="'.$_POST['idConsultar'].'">
         <input class="padre2" type="submit" value="Histórico de Pagos"/>     
          </form>';
        foreach($consultaGeneralpFactura as $tipo) 
        {

          $idCliente=$tipo[0];
          $idfpCobro = $tipo[5];
       
          if($tipo[4]=='PENDIENTE')
          {
            
            $noFactura=$tipo[5].$idCliente;
            $fechaCorte=$tipo[3];
            $ordenFechaCorte = date('d-m-Y', strtotime($fechaCorte));

            $parame=array();
            $parame[0]=$consultaGeneralpFactura[0][1];
            $consultaCostoServicio=$ObjDbPG->SELECT("public.consultar_servicio",$parame);

//Cliente suspendido//
            $separar_fechas = explode('-', $fechaCorte);
            $separar_fechaHoy = explode('-', $fechaHoy);
           

            if($separar_fechas[0]!=$separar_fechaHoy[2])
            {
              $mensaje1='
                <style>
                  .padre 
                  {
                     background-color: #fafafa;
                     margin: 10rem;
                     padding: 1rem;
                     text-align: center;
                  }
                  </style>
                <br><br>
                <div class="alert alert-warning padre">
                  <strong>INFO:</strong> IMPORTANTE! CLIENTE SE ENCUENTRA SUSPENDIDO, MORA EN PAGOS DEL AÑO '.$separar_fechas[0].'!!.
                  <a href="../CU_bienvenida/index.php">
                          <img src="../CU_servicios/imagenes/arrow_left_15601.png" height="30" width="30"></img>
                         VOLVER
                  </a>
                </div>';
            }
            else
            {
              $mensaje1='
                <style>
                  .padre 
                  {
                     background-color: #fafafa;
                     margin: 10rem;
                     padding: 1rem;
                     text-align: center;
                  }
                  </style>
                <br><br>
                <div class="alert alert-warning padre">
                  <strong>INFO:</strong> CLIENTE ACTIVO, SE LE RECUERDA REALIZAR SU PAGOS ANTES DE LA FECHA LIMITE '.$separar_fechas[0].'!!.
                  <a href="../CU_bienvenida/index.php">
                          <img src="../CU_servicios/imagenes/arrow_left_15601.png" height="30" width="30"></img>
                         VOLVER
                  </a>
                </div>';
            }
//

            if($consultaCostoServicio[0][0]=='')
            {
              $mensaje='
                <style>
                  .padre 
                  {
                     background-color: #fafafa;
                     margin: 10rem;
                     padding: 1rem;
                     text-align: center;
                  }
                  </style>
                <br><br>
                <div class="alert alert-warning padre">
                  <strong>INFO:</strong> ERROR! NO TIENE COSTO DE SERVICIO ASOCIADO!!.
                  <a href="../CU_bienvenida/index.php">
                          <img src="../CU_servicios/imagenes/arrow_left_15601.png" height="30" width="30"></img>
                         VOLVER
                  </a>
                </div>';
            }
            else
            { 
              $costoServicio=$consultaCostoServicio[0][3];
              $Servicio=$consultaCostoServicio[0][1].':'.$consultaCostoServicio[0][2];

              $pagar='
              <form id="pagarFactura" name="pagarFactura" action="generarPagos.php" method="POST">
                 <input id="idfactpagar" name="idfactpagar" type="hidden" value="'.$idfpCobro.'">
               <input type="submit" value="Pagar"/>     
                </form>';

              $datosValores.="<tr>";
              $datosValores.="<td>$noFactura</td>";
              $datosValores.="<td>$Servicio</td>";
              $datosValores.="<td>$ordenFechaCorte</td>";
              $datosValores.="<td>$costoServicio</td>";
              $datosValores.="<td>$pagar</td>";
              $datosValores.="</tr>";   

               //CONSULTA DEL CLIENTE --- INFO GENERAL -- //
              $mensaje="
              <html>
              <style>

              .register{
                  background: -webkit-linear-gradient(left, #e8e7f8, #00c6ff);
                  margin-top: 10%;
                  padding: -20%;
                  border-radius: 2.5rem;
                  width: 850px;
              }
              </style>
              <body>
              <div class='register' style='width:1000px; align-content:center'>
                <div class='form-group' align='center'>
                   <label align='center'>Nro. de Contrato: <strong> ".$control.$consultarDatosCliente[0][0]."</strong> </label>
                   <label  align='center'>Nombre y Apellido Cliente: <strong> ".$consultarDatosCliente[0][2]."</strong> </label>
                   <label  align='center'>Condición del Cliente: <strong> ".$condicionCliente."</strong> </label>
                </div>
                <div class='form-group' align='center'>
                   <label align='center'>Nro. de Contacto Principal: <strong> ".$consultarDatosCliente[0][4]."</strong> </label>
                   <label  align='center'>Correo: <strong> ".$consultarDatosCliente[0][6]."</strong> </label>
                   <label  align='center'>Dirección: <strong> ".$consultarDatosCliente[0][7]."</strong> </label>
                </div>
                <div class='form-group' align='center'>
                   <label align='center'>Servicio: <strong> ".$consultarDatosCliente[0][8].":".$consultarDatosCliente[0][9]."</strong> </label>
                   <label  align='center'>Costo de Instalaciòn: <strong> ".number_format($consultarDatosCliente[0][10], 2, ",", ".")."</strong> </label>
                   <label  align='center'>Total del Servicio: <strong> Bs. ".number_format($consultarDatosCliente[0][19], 2, ",", ".")."</strong> </label>
                </div>
                <div class='form-group' align='center'>
                   <label align='center'>Fecha de Contratación: <strong> ".$fechaContrato."</strong> </label>
                   <label  align='center'>Fecha de Corte: <strong> ".$fechaCorteInfo."</strong> </label>
                   <label  align='center'>Fecha Actual: <strong> ".$fechaHoy."</strong> </label>
                </div>
              </div>
              </body>
              </html>
               <br>

                <html>
                <head>
                <style type='text/css'>
                .pag_btn {
                    border: solid 1px;
                    border-color: rgb(0, 0, 255);
                    color: rgb(0, 0, 255);
                    background-color: rgb(255, 255, 255);
                }
                 
                .pag_btn_des {
                    border: solid 1px;
                    border-color: rgb(200, 200, 200);
                    color: rgb(200, 200, 200);
                    background-color: rgb(245, 245, 245);
                }
             
                .pag_num {
                    border: solid 1px;
                    border-color: rgb(0, 0, 255);
                    color: rgb(255, 255, 255);
                    background-color: rgb(0, 0, 255);
                }

                .padre 
                    {
                       background-color: #fafafa;
                       margin: 10rem;
                       padding: 1rem;
                       text-align: center;
                    }
                .padre1 
                    {
                       background-color: #fafafa;
                       margin: 3rem;
                       padding: 3rem;
                       text-align: center;
                       height: 35px;
                       width: 890px;
                    }
                .padre2 
                {
                    padding: 10px;
                    font-size: 18px;
                    color: #ffffff;
                    background-color: #1883ba;
                    border-radius: 6px;
                    border: 2px solid #0016b0;
                    margin: -20px -50px; 
                    position:relative;
                    top:50%; 
                    left:80%;
                  }
                </style>
 
              <script type='text/javascript'>
              Paginador = function(divPaginador, tabla, tamPagina)
              {
                  this.miDiv = divPaginador; //un DIV donde irán controles de paginación
                  this.tabla = tabla;           //la tabla a paginar
                  this.tamPagina = tamPagina; //el tamaño de la página (filas por página)
                  this.pagActual = 1;         //asumiendo que se parte en página 1
                  this.paginas = Math.floor((this.tabla.rows.length - 1) / this.tamPagina); //¿?
               
                  this.SetPagina = function(num)
                  {
                      if (num < 0 || num > this.paginas)
                          return;
               
                      this.pagActual = num;
                      var min = 1 + (this.pagActual - 1) * this.tamPagina;
                      var max = min + this.tamPagina - 1;
               
                      for(var i = 1; i < this.tabla.rows.length; i++)
                      {
                          if (i < min || i > max)
                              this.tabla.rows[i].style.display = 'none';
                          else
                              this.tabla.rows[i].style.display = '';
                      }
                      this.miDiv.firstChild.rows[0].cells[1].innerHTML = this.pagActual;
                  }
               
                  this.Mostrar = function()
                  {
                      //Crear la tabla
                      var tblPaginador = document.createElement('table');
               
                      //Agregar una fila a la tabla
                      var fil = tblPaginador.insertRow(tblPaginador.rows.length);
               
                      //Ahora, agregar las celdas que serán los controles
                      var ant = fil.insertCell(fil.cells.length);
                      ant.innerHTML = 'Anterior';
                      ant.className = 'pag_btn'; //con eso le asigno un estilo
                      var self = this;
                      ant.onclick = function()
                      {
                          if (self.pagActual == 1)
                              return;
                          self.SetPagina(self.pagActual - 1);
                      }
               
                      var num = fil.insertCell(fil.cells.length);
                      num.innerHTML = ''; //en rigor aún no se el número de la página
                      num.className = 'pag_num';
               
                      var sig = fil.insertCell(fil.cells.length);
                      sig.innerHTML = 'Siguiente';
                      sig.className = 'pag_btn';
                      sig.onclick = function()
                      {
                          if (self.pagActual == self.paginas)
                              return;
                          self.SetPagina(self.pagActual + 1);
                      }
               
                      //Como ya tengo mi tabla, puedo agregarla al DIV de los controles
                      this.miDiv.appendChild(tblPaginador);
               
                      //¿y esto por qué?
                      if (this.tabla.rows.length - 1 > this.paginas * this.tamPagina)
                          this.paginas = this.paginas + 1;
               
                      this.SetPagina(this.pagActual);
                  }
              }

              </script>
              </head>

              <table class='table' border='1' align='center' id='tblDatos'>
              <label class='padre1'><strong><h2>FACTURAS PENDIENTES</h2></strong></label>

              </div>
                 <thead class='tableHeader'>
                  <tr>
                      <th>Factura No.</th>
                      <th>Servicio</th>
                      <th>Fecha Corte</th>
                      <th>Monto Bs.</th>
                      <th>Acción</th>
                  </tr>
                 </thead>
                  <tr>
                    <tbody>
                         ".$datosValores."            
                     </tbody>
                  </tr>
              </table>
              <div id='paginador'></div>
              <br><br>
              ".$botonModal."
              </html>
              <script type='text/javascript'>
              var p = new Paginador(
                  document.getElementById('paginador'),
                  document.getElementById('tblDatos'),
                  7);
              p.Mostrar();

              </script>
<br>
              ".$mensaje1."
              <div class='padre' >
                  <a href='../CU_bienvenida/index.php'>
                          <img src='../CU_servicios/imagenes/arrow_left_15601.png' height='30' width='30'></img>
                         VOLVER
                  </a>
                </div>
                  "; 
            }
          }
     
        }
    }
}
 
}
$html->salidaFinal($tituloPagina="Página Principal",$menu="menu2",$mensaje);
?> 