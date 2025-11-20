<?php

if ($_POST) {
    require_once(__DIR__ . '/../bd/ConnectionManager.php');
    $json = file_get_contents('php://input');
    $data = json_decode($json);
    $action = $data->action;

    // Realiza la acción correspondiente según el valor de 'action'
    switch ($action) {
        case 'getComunasByRegion':
            // Recibe el parámetro jsonRequest
            $idregion = $data->idRegion;
            // Llama a la función getComunasByRegion y devuelve el resultado
            $comunas = getComunasByRegion($idregion);
            echo json_encode($comunas);
            break;
        
        default:
            echo 'Invalid action.';
            break;
    }
}else{
    require_once(__DIR__ . '/ws/bd/ConnectionManager.php');

}

    function getComunasByRegion($idRegion){

        $conn = getDBConnection(); // Auto-managed connection
        // $idRegion = $jsonRequest->idRegion;
        $comunas = [];
    
        $query = 'SELECT c.id, c.comuna from comuna c
                    INNER JOIN region r on r.id = c.region_id
                    WHERE r.id ='.$idRegion;
                    
        if($responseBd = $conn->mysqli->query($query)){
            while($dataComunas = $responseBd->fetch_object()){
                $comunas [] = $dataComunas;
            }
        }
        // $conn->desconectar(); // Auto-closed by ConnectionManager
        return $comunas;
    }
?>