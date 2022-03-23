<?php
header('Content-Type: application/json');

define("conect","../../framework/db/CX_SIS.php");
$conector=$ObjDbPG->classdb(conect);
$conector=$ObjDbPG->conectar(); 
//tengo que llamar una funcion que me traiga cantidad total de registros
// clientes registrados SI -cantidad cilentes pendientes -

$parametros = array(); 
$result = =$ObjDbPG->SELECT("public.consultar_cliente",$parametros);


$data = array();
foreach ($result as $row) {
        $data[] = $row;
}


echo json_encode($data);
?>