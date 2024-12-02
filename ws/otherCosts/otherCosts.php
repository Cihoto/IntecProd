<?php
if ($_POST){
    require_once('../bd/bd.php');

    $json = file_get_contents('php://input');
    $data = json_decode($json);
    $action = $data->action;
    // Realiza la acción correspondiente según el valor de 'action'
    switch($action) {
        case 'assignOtherCostsToEvent':
            $event_id = $data->event_id;
            $empresa_id = $data->empresa_id;
            $request = $data->request;
            $result = assignOtherCostsToEvent($event_id,$empresa_id,$request);
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

function assignOtherCostsToEvent($event_id,$empresa_id,$request){


    $conn = new bd();
    $conn->conectar();

    $arrayLength = count($request);
    $insertvalues = "";

    $deleteAllOtherCostsFromEvent= removeAllOtherCostsFromEvent($event_id,$empresa_id);

    // return $deleteAllOtherCostsFromEvent;
    
    if(!isset($deleteAllOtherCostsFromEvent['success'])){
        return $deleteAllOtherCostsFromEvent;
    }

    if($arrayLength > 0){
        foreach($request as $key=>$other_cost_data){
            if($key < $arrayLength){
                if($key === $arrayLength -1){
                    $insertvalues .= "('$other_cost_data->name', $other_cost_data->cantidad, $other_cost_data->monto,$event_id)";
                }else{
                    $insertvalues .= "('$other_cost_data->name', $other_cost_data->cantidad, $other_cost_data->monto,$event_id),";
                }
            }
        }
        $queryInsertAccountablesToProject = "INSERT INTO u136839350_intec.proyecto_has_other_costs
        (name, quantity, total,event_id)
        VALUES $insertvalues";
    
        if($conn->mysqli->query($queryInsertAccountablesToProject)){
            $conn->desconectar();
            return array("success"=>true,"message"=>"Other Costs has been assgined to event successfully");
        }else{
            $conn->desconectar();
            return array("error"=>true,"message"=>"Something happend, Other Costs hasn't been assigned to event, please try again");
        }
    }else{
        $conn->desconectar();
        return array("success"=>true, "message"=>"No data to insert");
    }
}   


function removeAllOtherCostsFromEvent($event_id,$empresa_id){
    $conn = new bd();
    $conn->conectar();

    $queryGetMyEvent = "SELECT p.id FROM proyecto p 
    where p.id = $event_id and p.empresa_id = $empresa_id";

    if(!$conn->mysqli->query($queryGetMyEvent)){
        $conn->desconectar();
        return array("error"=>true,"message"=>"Access Denied, event not found");
    }

    $queryDeleteSchedules = "DELETE FROM u136839350_intec.proyecto_has_other_costs
    WHERE event_id = $event_id ";
    // return $queryDeleteSchedules;

    if($conn->mysqli->query($queryDeleteSchedules)){
        $conn->desconectar();
        return array("success"=>true,"message"=>"Other Costs has been removed from event successfully");
    }else{
        $conn->desconectar();
        return array("error"=>true,"message"=>"Other Costs hasn't been removed from event, try again");
    }
}
?>