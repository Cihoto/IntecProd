<?php

 require_once('../bd/bd.php');
 // header('Content-Type: application/json');


 // error_log('categoria.php accessed at ' . date('Y-m-d H:i:s'));
 header('Content-Type: application/json');
 header('Access-Control-Allow-Origin: *');
 header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
 header('Access-Control-Allow-Headers: Content-Type');

 $json = file_get_contents('php://input');
 $data = json_decode($json);


 if (isset($data->empresaId)) {
     echo json_encode(GetItems($data->empresaId));
 } else {
     echo json_encode(['error' => 'Invalid input']);
 }

 // return json_encode(GetCategorias($data->empresaId));




function GetItems($empresaId){
    
    $conn = new bd();
    $conn->conectar();
    $response = [];
    $querySelectMarca ="SELECT i.item,i.id  from item i 
                        INNER JOIN categoria_has_item chi on chi.item_id = i.id
                        INNER JOIN producto p on p.categoria_has_item_id =chi.id 
                        where p.empresa_id = $empresaId
                        GROUP BY i.item";

    $responseBd = $conn->mysqli->query($querySelectMarca);

    while($dataResponseBd = $responseBd->fetch_object()){
        $response []= $dataResponseBd;
    }
    $conn->desconectar();
    return $response;

}

?>