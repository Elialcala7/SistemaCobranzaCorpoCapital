<?php 
require('../includes.php');
define("conect","../../framework/db/CX_SIS.php");
$conector=$ObjDbPG->classdb(conect);
$conector=$ObjDbPG->conectar();

$parametros=array();
$consulta=$ObjDbPG->SELECT("consultar_nivel_usuario",$parametros);
$combo_r='{';
foreach ($consulta as $rol){
    $combo_r.= "'" . $rol[0] ."'". ':' . "'" . $rol[1] . "'" . ',';
}
$combo_r=substr($combo_r,0,-1);
$combo_r.='}';

//echo $combo_r;

//opciones que puede realizar el usuario
$mensaje = 
"
  </br></br></br>
    <script type='text/javascript'> 
    $(document).ready(function () {
        var spanishMessages = {
                    serverCommunicationError: 'Ocurri&oacute; un error en la comunicaci&oacute;n con el servidor.',
                    loadingMessage: 'Cargando registros...',
                    noDataAvailable: 'No hay datos disponibles!',
                    addNewRecord: 'Crear nuevo usuario',
                    editRecord: 'Editar usuario',
                    areYouSure: '¿Está seguro?',
                    deleteConfirmation: 'El usuario ser&aacute; eliminado. ¿Est&aacute; seguro?',
                    save: 'Guardar',
                    saving: 'Guardando',
                    cancel: 'Cancelar',
                    deleteText: 'Eliminar',
                    deleting: 'Eliminando',
                    error: 'Error',
                    close: 'Cerrar',
                    cannotLoadOptionsFor: 'No se pueden cargar las opciones para el campo {0}',
                    pagingInfo: 'Mostrando registros {0} a {1} de {2}',
                    canNotDeletedRecords: 'No se puede borrar registro(s) {0} de {1}!',
                    deleteProggress: 'Eliminando {0} de {1} registros, procesando...',
                    pageSizeChangeLabel: 'Registros por p&aacute;gina',
                    gotoPageLabel: 'Ir a la p&aacute;gina'
                };    
        $('#TablaUsuario').jtable({
            messages: spanishMessages,
            title: 'USUARIOS',
            paging: true, 
            pageSize: 15, 
            sorting: true, 
            defaultSorting: 'nombre_usuario ASC',
            actions: {
                listAction:   'usuarios.php?accion=lista',
                createAction: 'usuarios.php?accion=crear',
                updateAction: 'usuarios.php?accion=editar',
                deleteAction: 'usuarios.php?accion=eliminar'
            },            
            fields: {
                id_usuario: {  key: true,type: 'hidden' },
                nombre: {title: 'Nombre(s)',width: '12%',inputClass: 'validate[required]'},
                apellido: {title: 'Apellido(s)',width: '12%',inputClass: 'validate[required]'},
                cedula: {title: 'Cédula',width: '8%',inputClass: 'validate[required]',edit:false},
                clave: {title: 'Clave',width: '10%', list:false ,create:true, edit:true, type: 'password',inputClass: 'validate[required]'},
                id_nivel: { title: 'Nivel de Usuario',options:".$combo_r.",width: '10%'},
                correo_usuario: {title: 'Email',width: '9.8%', create:true, inputClass: 'validate[custom[email]]'},
                
            },
            //Inicializar validación lógica cuando el formulario es creado
            formCreated: function (event, data) {               
                data.form.validationEngine();
            },
            //Validación del formulario cuando es enviado
           formSubmitting: function (event, data) {
                return data.form.validationEngine('validate');
            },
            //Disponer lógica de validación cuando se cierra el formulario
            formClosed: function (event, data) {
                data.form.validationEngine('hide');
                data.form.validationEngine('detach');
            }
        });
        $('#TablaUsuario').jtable('load');
    });    
    </script> 
    
<div class='row col-md-12'>
  <div class='col-md-8'></div>
  <div class='col-md-12' id='TablaUsuario'></div>
  <div class='col-md-2'></div>
</div>  

<style>
    .centrado
    {
    margin:250px auto;
    font-size: 16px; /*tamaño de la letra*/
    color: black; /*color de la letra*/
    height: 50px;
    display:block;
    font-weight: normal;
    }  
</style>
<div top='350px'  height='30' width='30'>
<a href='javascript:history.back()' class='centrado'>
  <img src='imagenes/arrow_left_15601.png'</img>Regresar
</a>
</div>";
$html->salidaFinal($tituloPagina='Registro de Estatus',$Nmenu='menu2',$mensaje);
?>