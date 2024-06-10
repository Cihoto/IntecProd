<?php

require_once('../bd/bd.php');
header('Content-Type: application/json');

$json = file_get_contents('php://input');
$data = json_decode($json);


if (isset($data->empresaId)) {
    echo json_encode(GetMarcas($data->empresaId));
} else {
    echo json_encode(['error' => 'Invalid input']);
}

// return json_encode(GetCategorias($data->empresaId));


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

    return $response;

}