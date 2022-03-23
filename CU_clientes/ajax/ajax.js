//objeto ajax
function nuevoAjax(){
var xmlhttp=false;
try {
xmlhttp = new ActiveXObject('Msxml2.XMLHTTP');
} catch (e) {
try {
xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
} catch (E) {
xmlhttp = false;
}
}

if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
xmlhttp = new XMLHttpRequest();
}
return xmlhttp;
} 
//////////////////////////////////////////////////////////////////  

function habilitar(selectcliente)
{
   
    var idseleccion=$("#selectcliente").val();
    //alert(idseleccion);
 
     //document.getElementById('contenidoresidencial').innerHTML='';//para limpiar valores del div ante de volver a invocar
    if((idseleccion=="") || (idseleccion==null))
    {
        
       document.getElementById('contenidoresidencial').style.display='none';
       document.getElementById('contenidocomercio').style.display='none'; 
       document.getElementById('contenidoempresa').style.display='none';  
       document.getElementById('contenidoconvenio').style.display='none';  
        
    }
    else
    {
      if(idseleccion==1)
      {
       //document.getElementById('tabletserv').innerHTML='';//para limpiar valores del div ante de volver a invocar
       document.getElementById('contenidoresidencial').style.display='block';
       document.getElementById('contenidocomercio').style.display='none'; 
       document.getElementById('contenidoempresa').style.display='none'; 

       } 
      if(idseleccion==2)
      {
        document.getElementById('contenidoresidencial').style.display='none';
        document.getElementById('contenidocomercio').style.display='block'; 
        document.getElementById('contenidoempresa').style.display='none'; 

      }
      if(idseleccion==3)
      {
        document.getElementById('contenidoresidencial').style.display='none';
        document.getElementById('contenidocomercio').style.display='none'; 
        document.getElementById('contenidoempresa').style.display='block'; 

      }
      if(idseleccion==4)
      {
        document.getElementById('contenidoresidencial').style.display='none';
        document.getElementById('contenidocomercio').style.display='none'; 
        document.getElementById('contenidoempresa').style.display='none'; 

      }
    }
  
}
function contenido(selectbasic)
{
  //alert('entrando al combo servicio');
  var idseleccion=$("#selectbasic").val();
  document.getElementById('contenidoServ').style.display='block';

  $.ajax({
      method:"POST",
      type: "JSON",
      url:"datos.php",
      data:  {idseleccion:idseleccion},
      url:"../CU_clientes/datos.php?accion=consultarContenidoS",
      success:function(mensaje){
        var status=mensaje.estado,
            nombreServicio=mensaje.nombreServicio,
            contenido_servicio=mensaje.contenido_servicio,
            montoServicio=mensaje.montoServicio;
        
        if(status=="ok"){

     //  document.getElementById('contenidoServ').innerHTML='';
       //$("#contenidoServ").empty();
          $("#nombreServicio").append(nombreServicio); 
          $("#contenido_servicio").append(contenido_servicio);
          $("#montoServicio").append(montoServicio);
          $("#contenidoServ").show();
          
                 
        }

        else
        {
            alert("No encontrado");
        }
      }
    });
            
}

function contenidoComercio(selectbasic1)
{
  var idseleccionC=$("#selectbasic1").val();
  document.getElementById('contenidoServC').style.display='block';

  $.ajax({
      method:"POST",
      type: "JSON",
      url:"datos.php",
      data:  {idseleccionC:idseleccionC},
      url:"../CU_clientes/datos.php?accion=consultarContenidoC",
      success:function(mensaje){
        var status=mensaje.estado,
            nombreServicioC=mensaje.nombreServicioC,
            contenido_servicioC=mensaje.contenido_servicioC,
            montoServicioC=mensaje.montoServicioC;
        
        if(status=="ok"){

     //  document.getElementById('contenidoServ').innerHTML='';
       //$("#contenidoServ").empty();
          $("#nombreServicioC").append(nombreServicioC); 
          $("#contenido_servicioC").append(contenido_servicioC);
          $("#montoServicioC").append(montoServicioC);
          $("#contenidoServC").show();
          
                 
        }

        else
        {
            alert("No encontrado");
        }
      }
    });
            
}

function contenidoEmpresas(selectbasic2)
{
  var idseleccionE=$("#selectbasic2").val();
  document.getElementById('contenidoServE').style.display='block';

  $.ajax({
      method:"POST",
      type: "JSON",
      url:"datos.php",
      data:  {idseleccionE:idseleccionE},
      url:"../CU_clientes/datos.php?accion=consultarContenidoE",
      success:function(mensaje){
        var status=mensaje.estado,
            nombreServicioE=mensaje.nombreServicioE,
            contenido_servicioE=mensaje.contenido_servicioE,
            montoServicioE=mensaje.montoServicioE;
        
        if(status=="ok"){

     //  document.getElementById('contenidoServ').innerHTML='';
       //$("#contenidoServ").empty();
          $("#nombreServicioE").append(nombreServicioE); 
          $("#contenido_servicioE").append(contenido_servicioE);
          $("#montoServicioE").append(montoServicioE);
          $("#contenidoServE").show();
          
                 
        }

        else
        {
            alert("No encontrado");
        }
      }
    });
            
}