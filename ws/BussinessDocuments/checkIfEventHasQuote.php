<?php

require('../bd/bd.php');
session_start();
$empresa_id = $_SESSION["empresa_id"];

$json = file_get_contents('php://input');
$data = json_decode($json);

$file_name = $data->file_name;
$empresa_id = $data->empresa_id;


echo json_encode(deleteTempFile($file_name, $empresa_id));


function deleteTempFile($file_name, $empresa_id){

    try{
        $absolute_path = getcwd();
        $target_path = $absolute_path . "\documents\buss$empresa_id\documents\bsd$file_name";
    
        if (!file_exists($absolute_path . "/documents/buss$empresa_id")) {
            return array('error'=>true,'message'=>'El documento no existe');
        }
        
        
        if (!unlink($target_path)) { 
            
            return array('error'=>true,'message'=>'El documento no se ha podido eliminar');
        } 
        else {  
            return array('success'=>true,'message'=>'El documento existe');
        } 

    }catch(Exception $ex){
        return array('error'=>true, 'message'=>'No se puede procesar la solicitud');
    }

}

// $stmt = $mysqli->prepare("DELETE FROM proyecto_has_files WHERE event_id = ? AND file_id = ?;");
// $stmt->bind_param("ii", $event_id, $file_id);
// $stmt->execute();





// if (!file_exists($absolute_path . "/documents/buss$empresa_id/documents")) {
//     mkdir($absolute_path . "/documents/buss$empresa_id/documents");
// }

// // $rutaArchivo = $target_path . "/bsd$nombreArchivo";
// echo $target_path;

// echo file_exists($target_path);


// $delete  = unlink($target_path);
// if ($delete) {
//     echo "delete success";
// } else {
//     echo "delete not success";
// }
