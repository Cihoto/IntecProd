<?php

header('Content-Type: application/json');
if ($_POST) {
    require_once('../bd/bd.php');

    $json = file_get_contents('php://input');
    $data = json_decode($json);
    $action = $data->action;
    
    if(isset($data->vehicleData)){
        $datav = $data->vehicleData;
    }

    switch ($action) {
        case 'getMarca':
            $empresaId = $data->empresaId;
            $marcas = GetMarcas($empresaId);
            echo json_encode($marcas);
            break;
        default:
            echo 'Invalid action.';
            break;
    }

}


function GetMarcas($empresaId){
    
    $conn = new bd();
    $conn->conectar();
    $response = [];
    $querySelectMarca ="SELECT m.marca, m.id  from marca m
                            INNER JOIN producto p on p.marca_id = m.id
                            where p.empresa_id = $empresaId
                            GROUP BY m.marca";

    $responseBd = $conn->mysqli->query($querySelectMarca);

    while($dataResponseBd = $responseBd->fetch_object()){
        $response []= $dataResponseBd;
    }
    $conn->desconectar();
    return $response;

}
?>