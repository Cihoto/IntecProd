<?php

require('../bd/bd.php');
session_start();
$empresa_id = $_SESSION["empresa_id"];

$json = file_get_contents('php://input');
$data = json_decode($json);

$file_name = $data->file_name;
$file_id = $data->file_id;
$empresa_id = $data->empresa_id;
$event_id = $data->event_id;


echo json_encode(deleteAssignedFile($file_name,$file_id,$empresa_id,$event_id));


function deleteAssignedFile($file_name,$file_id,$empresa_id,$event_id){

    try{
        $conn = new bd();
        $conn->conectar();
        $mysqli = $conn->mysqli;

        $absolute_path = getcwd();

        $target_path = $absolute_path."/documents/buss".$empresa_id."/Ev".$event_id."/bsd".$file_name;

        if (!file_exists($target_path)){
            return array('error'=>true,'message'=>'El documento no existe');
        }
        
        if (!unlink($target_path)) { 
            return array('error'=>true,'message'=>'El documento no se ha podido eliminar');
        }
         
        else {     
            
     
            $stmt = $mysqli->prepare("UPDATE proyecto_has_files set isDelete = 1
            WHERE file_id  = ?
            AND event_id  = ?");
            $stmt->bind_param("ii", $file_id,$event_id);
            $stmt->execute();
            $result = $stmt->affected_rows;
            $conn->desconectar();   
            return array('success'=>true,'message'=>'Documento Eliminado Exitosamente');
        } 

    }catch(Exception $ex){
        return array('error'=>true, 'message'=>'No se puede procesar la solicitud');
    }

}