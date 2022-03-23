<?php 
require('../includes.php');
define("conect","../../framework/db/CX_SIS.php");
$conector=$ObjDbPG->classdb(conect);
$conector=$ObjDbPG->conectar();

$parametros=array();
$consulta=$ObjDbPG->SELECT("cond_cilente",$parametros);
$cond_clienteCombo='{';
foreach ($consulta as $rol){
    $cond_clienteCombo.= "'" . $rol[0] ."'". ':' . "'" . $rol[1] . "'" . ',';
}
$cond_clienteCombo=substr($cond_clienteCombo,0,-1);
$cond_clienteCombo.='}';

//print_r($cond_clienteCombo);exit();

//opciones que puede realizar el usuario
$mensaje = 
"

  <br><br><br>
    <script type='text/javascript'> 
    $(document).ready(function () {
        var spanishMessages = {
                    serverCommunicationError: 'Ocurri&oacute; un error en la comunicaci&oacute;n con el servidor.',
                    loadingMessage: 'Cargando registros...',
                    noDataAvailable: 'No hay datos disponibles!',
                    addNewRecord: 'Crear nuevo cliente',
                    editRecord: 'Editar cliente',
                    areYouSure: '¿Está seguro?',
                    deleteConfirmation: 'El cliente ser&aacute; eliminado. ¿Est&aacute; seguro?',
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
        $('#TablaCliente').jtable({
            messages: spanishMessages,
            title: 'LISTADO DE CLIENTES ACTIVOS',
            paging: true, 
            pageSize: 15, 
            sorting: true, 
            defaultSorting: 'nombres_cliente ASC',
            actions: {
                listAction:   'usuarios.php?accion=lista',
                deleteAction: 'usuarios.php?accion=eliminar'
            },            
            fields: {
                id_cliente: {  key: true,type: 'hidden' },
                nombres_cliente: {title: 'Nombre y Apellido',width: '12%',inputClass: 'validate[required]'},
                nombre_comercio: {title: 'Comercio/Empresa',width: '12%',inputClass: 'validate[required]'},
                ci_cliente: {title: 'Cédula/RIF',width: '8%',inputClass: 'validate[required]',edit:false},
                telefono_principal: {title: 'No.Telefono',width: '8%',inputClass: 'validate[required]',edit:false},
        
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
        $('#TablaCliente').jtable('load');
    });    
    </script> 
    
<div class='row col-md-12'>
  <div class='col-md-8'></div>
  <div class='col-md-12' id='TablaCliente'></div>
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

  <br><br><br>
  <br><br><br>
<div top='350px'  height='30' width='30'>
<a href='javascript:history.back()' class='centrado'>
  <img src='imagenes/arrow_left_15601.png' height='30' width='30'></img>Regresar
</a>
</div>";
$html->salidaFinal($tituloPagina='Registro de Estatus',$Nmenu='menu2',$mensaje);
?>