<?php 
date_default_timezone_set('America/Santiago');
if ($_POST){
    require_once('../bd/bd.php');

    $json = file_get_contents('php://input');
    $data = json_decode($json);
    $action = $data->action;
    // Realiza la acción correspondiente según el valor de 'action'
    switch($action) {
        case 'updateBussLogo':
            $request = $data->request;
            $result = updateBussLogo($request);
            break;
        default:
            $result = false;
            break;
    }
    // Devolver la respuesta como JSON
    header('Content-Type: application/json');
    echo json_encode($result);
}




function updateBussLogo($request){

    return $request->formData->files->tmp_name;
    $conn = new bd();
    $conn->conectar();
    $mysqli = $conn->mysqli;
    $now = date('Y-m-d H:i:s');

    $stmt = $mysqli->prepare("INSERT INTO u136839350_intec.businessLogo (bus_logo_name, last_update_datetime, last_update_user_id) VALUES(?,?,?);");
    $stmt->bind_param("ssi", $request->logoName,$now,$request->user_id);
    
    if(!$stmt->execute()){
        $conn->desconectar();
        return badReqBusLogo();
    }

    $bus_logo_id = $mysqli->insert_id;


    $stmt = $mysqli->prepare("UPDATE empresa SET bus_logo_id = ? WHERE id = ?");
    $stmt->bind_param("ii",$bus_logo_id,$request->empresa_id);

    if(!$stmt->execute()){
        $conn->desconectar();
        return badReqBusLogo();
    }
    $conn->desconectar();

    return successReq('Logo guardado correctamente');

}


function badReqBusLogo(){
    return [
        'error' => true,
        'message' => 'Ha ocurrido un error, por favor intente nuevamente.'
    ];
}
function successReq($message){
    return [
        'success' => true,
        'message' => "$message"
    ];
}