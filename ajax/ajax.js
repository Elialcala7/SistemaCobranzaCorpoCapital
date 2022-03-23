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
function consultaCliente(id)
{
  alert('entrando a la consulta' + id);
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

/*function fn_enviarPago(id)
{   
    var idfpcobro =id;
       
    $.ajax({
      method: "POST",
      url: "generarPagos.php",
      data: {idfpcobro:idfpcobro}
         }).done(function(respuesta) {
     
         if (respuesta.estado == "ok") {

            var idfpcobro=respuesta.idfpcobro;
               
          $('#idfpcobro').val(idfpcobro);

           $('#generaPagos').show(); //form//

          $('#generaPagos').form({
                     backdrop: 'static',
                     keyboard: false
                  });
        }
      });


}*/
