<?php

require('../bd/bd.php');
session_start();
$empresa_id = $_SESSION["empresa_id"];

$json = file_get_contents('php://input');
$data = json_decode($json);

$file_name = $data->file_name;
$empresa_id = $data->empresa_id;
$event_id = $data->event_id;


echo json_encode(replaceUploadedFile($file_name,$empresa_id,$event_id));


function replaceUploadedFile($file_name,$empresa_id,$event_id){

    try{

        $absolute_path = getcwd();

        $assignedFilePath = $absolute_path."\documents\buss$empresa_id\Ev$event_id\bsd$file_name";
         
        if (!file_exists($absolute_path."\documents\buss$empresa_id\Ev$event_id\bsd$file_name")) {
            return array('error'=>true,'message'=>'El documento no existe');
        }
        if (!unlink($assignedFilePath)) { 
            return array('error'=>true,'message'=>'El documento no se ha podido eliminar');
        } 

        $target_path = $absolute_path."\documents\buss$empresa_id\Ev$event_id\bsd$file_name";

        
        $temporaryFilePath = $absolute_path."/documents/buss$empresa_id/documents/bsd$file_name";

        if(rename($temporaryFilePath, $target_path)){
            return true;
        }
        return false;
        

    }catch(Exception $ex){
        return array('error'=>true, 'message'=>'No se puede procesar la solicitud');
    }
    // rename(C:\xampp\htdocs\IntecProd\ws\BussinessDocuments/documents/buss2/documents/bsdcarFront.jpg/bsdcarFront.jpg,C:\xampp\htdocs\IntecProd\ws\BussinessDocuments\documents\buss2\Ev115\bsdcarFront.jpg)
}