<?php

require_once(__DIR__ . '/../bd/ConnectionManager.php');
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
        $conn = getDBConnection(); // Auto-managed connection
        $mysqli = $conn->mysqli;

        $absolute_path = getcwd();
        $target_path = $absolute_path."/documents/buss".$empresa_id."/Ev".$event_id."/bsd".$file_name;

        // Intentar eliminar archivo físico (no falla si no existe)
        $fileDeleted = false;
        if (file_exists($target_path)) {
            $fileDeleted = unlink($target_path);
        } else {
            // Archivo no existe físicamente, pero seguimos para eliminarlo de BD
            $fileDeleted = true;
        }
        
        // Siempre intentar marcar como eliminado en BD
        $stmt = $mysqli->prepare("UPDATE proyecto_has_files SET isDelete = 1
        WHERE file_id = ?
        AND event_id = ?");
        $stmt->bind_param("ii", $file_id, $event_id);
        $stmt->execute();
        $dbDeleted = $stmt->affected_rows > 0;
        // $conn->desconectar(); // Auto-closed by ConnectionManager
        
        // Mensaje basado en qué se eliminó
        if ($fileDeleted && $dbDeleted) {
            return array('success'=>true, 'message'=>'Documento eliminado exitosamente');
        } elseif ($dbDeleted) {
            return array('success'=>true, 'message'=>'Documento eliminado de la base de datos (archivo físico no existía)');
        } elseif ($fileDeleted) {
            return array('success'=>true, 'message'=>'Archivo físico eliminado (no estaba registrado en BD)');
        } else {
            return array('error'=>true, 'message'=>'No se encontró el documento en ningún lado');
        }

    }catch(Exception $ex){
        return array('error'=>true, 'message'=>'Error al procesar la solicitud: ' . $ex->getMessage());
    }

}