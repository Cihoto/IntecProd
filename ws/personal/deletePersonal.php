<?php
require_once(__DIR__ . '/../bd/ConnectionManager.php');
    
$conn = getDBConnection(); // Auto-managed connection

$conn ->conectar();

$json = file_get_contents('php://input');
$data = json_decode($json);

$personalArr = $data;

$today = date('Y-m-d');

foreach($personalArr as $persona){

    $queryDelete = 'update personal set IsDelete = 1 , deleteAt = "'.$today.'" where id = '.$persona->id;

    if($conn->mysqli->query($queryDelete)){
        // $conn->desconectar(); // Auto-closed by ConnectionManager
        echo json_encode(array("status"=> 1,"message"=>"Se ha eliminado exitosamente "));
    }else{
        // $conn->desconectar(); // Auto-closed by ConnectionManager
        echo json_encode(array("status"=> 0,"message"=>"Error al eliminar"));
    }
}

?>