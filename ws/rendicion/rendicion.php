<?php
if ($_POST){
    require_once('../bd/bd.php');

    $json = file_get_contents('php://input');
    $data = json_decode($json);
    $action = $data->action;
    // Realiza la acción correspondiente según el valor de 'action'
    switch($action) {
        case 'assignRendicionToEvent':
            $event_id = $data->event_id;
            $empresa_id = $data->empresa_id;
            $request = $data->request;
            $result = assignRendicionToEvent($event_id,$empresa_id,$request);
            break;
        case 'removeAllSchedulesFromEvent':
            $event_id=$data->event_id;
            $empresa_id=$data->empresa_id;
            $result = removeAllSchedulesFromEvent($event_id,$empresa_id);
            break;
        default:
            $result = false;
            break;
    }

    // Devolver la respuesta como JSON
    header('Content-Type: application/json');
    echo json_encode($result);
} else {
    require_once('./ws/bd/bd.php');
}

function assignRendicionToEvent($event_id,$empresa_id,$request){


    $conn = new bd();
    $conn->conectar();

    $arrayLength = count($request);
    $insertvalues = "";

    $deleteAllAccountablesFromEvent= removeAllAccountablesFromEvent($event_id,$empresa_id);
    
    if(!isset($deleteAllAccountablesFromEvent['success'])){
        return $deleteAllAccountablesFromEvent;
    }

    if($arrayLength > 0){
        foreach($request as $key=>$rendicion_data){
            if($key < $arrayLength){
                if($key === $arrayLength -1){
                    $insertvalues .= "('$rendicion_data->detalle', $rendicion_data->personal_id, $rendicion_data->monto, '$rendicion_data->fecha', '$rendicion_data->comercio',$event_id)";
                }else{
                    $insertvalues .= "('$rendicion_data->detalle', $rendicion_data->personal_id, $rendicion_data->monto, '$rendicion_data->fecha', '$rendicion_data->comercio',$event_id),";
                }
            }
        }
        $queryInsertAccountablesToProject = "INSERT INTO u136839350_intec.proyecto_has_rendicion
        (detalle, personal_id, monto, fecha, comercio,event_id)
        VALUES $insertvalues";
    
        if($conn->mysqli->query($queryInsertAccountablesToProject)){
            return array("success"=>true,"message"=>"Accountables has been assgined to event successfully");
        }else{
            return array("error"=>true,"message"=>"Something happend, Accountables hasn't been assigned to event, please try again");
        }
    }else{
        return array("success"=>true, "message"=>"No data to insert");
    }
}   


function removeAllAccountablesFromEvent($event_id,$empresa_id){
    $conn = new bd();
    $conn->conectar();

    $queryGetMyEvent = "SELECT p.id FROM proyecto p 
    where p.id = $event_id and p.empresa_id = $empresa_id";

    // return $queryGetMyEvent;

    if(!$conn->mysqli->query($queryGetMyEvent)){
        return array("error"=>true,"message"=>"Access Denied, event not found");
    }

    $queryDeleteSchedules = "DELETE FROM u136839350_intec.proyecto_has_rendicion
    WHERE event_id = $event_id; ";

    if($conn->mysqli->query($queryDeleteSchedules)){
        return array("success"=>true,"message"=>"Accountables has been removed from event successfully");
    }else{
        return array("error"=>true,"message"=>"Accountables hasn't been removed from event, try again");
    }
}
?>