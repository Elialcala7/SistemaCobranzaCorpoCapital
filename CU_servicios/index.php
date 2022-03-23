<?php require('../includes.php');

define("conect","../../framework/db/CX_SIS.php");
$conector=$ObjDbPG->classdb(conect);
$conector=$ObjDbPG->conectar();

$parametros=array();
$consulta=$ObjDbPG->SELECT("consultar_planes",$parametros);
$comboPlanes='{';
foreach ($consulta as $rol){
    $comboPlanes.= "'" . $rol[0] ."'". ':' . "'" . $rol[1] . "'" . ',';
}
$comboPlanes=substr($comboPlanes,0,-1);
$comboPlanes.='}';
//opciones que puede realizar el usuario
$mensaje = 
"  </br></br>
    <script type='text/javascript'> 
     
    $(document).ready(function () {
        var spanishMessages = {
        serverCommunicationError: 'Ocurri&oacute; un error en la comunicaci&oacute;n con el servidor.',
        loadingMessage: 'Cargando registros...',
        noDataAvailable: 'No hay datos disponibles!',
        addNewRecord: 'Crear nuevo Servicio',
        editRecord: 'Editar Servicio',
        areYouSure: '¿Está seguro?',
        deleteConfirmation: 'El Servicio se eliminara. ¿Est&aacute; seguro?',
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
        $('#TablaServicio').jtable({
            messages: spanishMessages,
            title: 'SERVICIOS',
            paging: true, 
            pageSize: 15, 
            sorting: true, 
            defaultSorting: 'nombre_servicio ASC',
            actions: {
                listAction:   'registroServicio.php?accion=lista',
                createAction: 'registroServicio.php?accion=crear',
                deleteAction: 'registroServicio.php?accion=eliminar',
               
            },            
            fields: {
             id_servicio: {  key: true,type: 'hidden' },
             nombre_servicio: {title: 'Nombre del Servicio',width: '15%',inputClass: 'validate[required]'},  
             contenido_servicio: {title: 'Detalle del Servicio',width: '15%',inputClass: 'validate[required]'},
             id_plan: {title: 'Tipo de Plan',options:".$comboPlanes.",width: '15%',inputClass: 'validate[required]'},
             monto_servicio: {title: 'Costo del Servicio',edit:false,width: '15%',inputClass: 'validate[required]'},
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
        $('#TablaServicio').jtable('load');
    });    
    </script> 
    
<div class='row col-md-12'>
  <div class='col-md-8'></div>
  <div class='col-md-12' id='TablaServicio'></div>
  <div class='col-md-2'></div>
</div> 

<div class='justificarCaja'>
  <form method='post' id='actualizarForm' name='actualizarForm' action='actualizar.php'>
    <div class='form-group col-md-12'>
      <button type='submit' class='btn btn-primary'><img src='imagenes/refresh_arrow_1546.png' height='20' width='20'></img>Actualizar Costos</button>
    </div>
  </form>
</div>
    <link rel='stylesheet' href='estilos.css'>

<a href='javascript:history.back()' class='centrado'>
  <img src='imagenes/arrow_left_15601.png' height='30' width='30'></img>Regresar
</a>

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
";
$html->salidaFinal($tituloPagina='Registro de Estatus',$Nmenu='menu2',$mensaje);
?>