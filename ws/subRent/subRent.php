<?php
if ($_POST){
    require_once('../bd/bd.php');

    $json = file_get_contents('php://input');
    $data = json_decode($json);
    $action = $data->action;
    // Realiza la acción correspondiente según el valor de 'action'
    switch($action) {
        case 'assignSubRentToEvent':
            $event_id = $data->event_id;
            $empresa_id = $data->empresa_id;
            $request = $data->request;
            $result = assignSubRentToEvent($event_id,$empresa_id,$request);
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

function assignSubRentToEvent($event_id,$empresa_id,$request){


    $conn = new bd();
    $conn->conectar();

    $arrayLength = count($request);
    $insertvalues = "";

    $deleteAllOtherCostsFromEvent= removeAllRentsFromEvent($event_id,$empresa_id);

    // return $deleteAllOtherCostsFromEvent;
    
    if(!isset($deleteAllOtherCostsFromEvent['success'])){
        return $deleteAllOtherCostsFromEvent;
    }

    
    if($arrayLength > 0){
        foreach($request as $key=>$sub_rent_data){
            if($key < $arrayLength){
                if($key === $arrayLength -1){
                    $insertvalues .= "($event_id, '$sub_rent_data->detalle', $sub_rent_data->proveedor_id, $sub_rent_data->valor)";
                }else{
                    $insertvalues .= "($event_id, '$sub_rent_data->detalle', $sub_rent_data->proveedor_id, $sub_rent_data->valor),";
                }
            }
        }
        $queryInsertAccountablesToProject = "INSERT INTO u136839350_intec.proyecto_has_sub_arriendos
        (proyecto_id, detalle, proveedor_id, valor)
        VALUES $insertvalues";
    
        if($conn->mysqli->query($queryInsertAccountablesToProject)){
            return array("success"=>true,"message"=>"Sub Rents has been assgined to event successfully");
        }else{
            return array("error"=>true,"message"=>"Something happend, Sub Rents hasn't been assigned to event, please try again");
        }
    }else{
        return array("success"=>true, "message"=>"No data to insert");
    }
}   


function removeAllRentsFromEvent($event_id,$empresa_id){
    $conn = new bd();
    $conn->conectar();

    $queryGetMyEvent = "SELECT p.id FROM proyecto p 
    where p.id = $event_id and p.empresa_id = $empresa_id";

    if(!$conn->mysqli->query($queryGetMyEvent)){
        return array("error"=>true,"message"=>"Access Denied, event not found");
    }

    $queryDeleteSchedules = "DELETE FROM u136839350_intec.proyecto_has_sub_arriendos
    WHERE proyecto_id = $event_id ";
    // return $queryDeleteSchedules;

    if($conn->mysqli->query($queryDeleteSchedules)){
        return array("success"=>true,"message"=>"Sub Rents has been removed from event successfully");
    }else{
        return array("error"=>true,"message"=>"Sub Rents hasn't been removed from event, try again");
    }
}
?>