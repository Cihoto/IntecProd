<?php
if ($_POST){
    require_once(__DIR__ . '/../bd/ConnectionManager.php');

    $json = file_get_contents('php://input');
    $data = json_decode($json);
    $action = $data->action;
    // Realiza la acción correspondiente según el valor de 'action'
    switch($action) {
        case 'addLugar':
            $request = $data->request;
            $result = addLugar($request);
            break;
        default:
            $result = false;
            break;
    }

    // Devolver la respuesta como JSON
    header('Content-Type: application/json');
    echo $result;
} else {
    require_once(__DIR__ . '/ws/bd/ConnectionManager.php');
}


    function addLugar($request){
        $conn = getDBConnection(); // Auto-managed connection
        $conn ->conectar();

        $today = date('Y-m-d');
        $lugar="";
        $direccion_id="";

        foreach($request as $req){
            $lugar= $req->lugar;
            $direccion_id = $req->direccion_id;
        }
        $query = "INSERT INTO lugar
                (lugar, createAt, direccion_id)
                VALUES('".$lugar."', '".$today."', $direccion_id )";
        if($conn->mysqli->query($query)){
            $insert_id = $conn->mysqli->insert_id;
            // $conn->desconectar(); // Auto-closed by ConnectionManager
            return json_encode(array("id_lugar"=> $insert_id)) ;
        }else{
            // $conn->desconectar(); // Auto-closed by ConnectionManager
            return false;
        }
    } 


?>