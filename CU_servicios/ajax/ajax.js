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
function calculo(increnuevo)
{   

    var inuevo = document.getElementById('increnuevo').value;
alert (inuevo);
    ajax=nuevoAjax();             
    ajax.open("POST", "proceso.php");
    ajax.onreadystatechange=function()
    {
        if (ajax.readyState==4)
        {
            //mostrar resultados en esta capa 
            alert(ajax.responseText);   
          
        }
    }
     ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    //enviando los valores
    ajax.send("&increnuevo=" + increnuevo)

//document.forms['formulario'].reset();
//document.getElementById('actualizarButton').disabled = true;
   
}
