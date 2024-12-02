<?php 
date_default_timezone_set('America/Santiago');
if ($_POST){
    require_once('../bd/bd.php');

    $json = file_get_contents('php://input');
    $data = json_decode($json);
    $action = $data->action;
    // Realiza la acción correspondiente según el valor de 'action'
    switch($action) {
        case 'addAndAssignCommentsToEvent':
            $event_id = $data->event_id;
            $temp_comments = $data->temp_comments;
            $result = addAndAssignCommentsToEvent($event_id, $temp_comments);
            break;
        case 'replyAssignedComment':
            $assignedReplyData= $data->assignedReplyData;
            $empresa_id= $data->empresa_id;
            $event_id= $data->event_id;
            $commentId= $data->commentId;
            $post_user_id= $data->post_user_id;
            $result = replyAssignedComment($assignedReplyData,$empresa_id,$event_id,$commentId,$post_user_id);
            break;
        case 'updateComment':
            $request= $data->request;
            $result = updateComment($request);
            break;
        case 'deleteComment':
            $request= $data->request;
            $result = deleteComment($request);
            break;
        default:
            $result = false;
            break;
    }
    // Devolver la respuesta como JSON
    header('Content-Type: application/json');
    echo json_encode($result);
}

function addAndAssignCommentsToEvent($event_id,$tempCommentsData,){


    try{
        $conn = new bd();
        $conn->conectar();
        $mysqli = $conn->mysqli;
        $nowDateTime  =date("Y-m-d H:i:s");
    
        foreach($tempCommentsData as $key => $temp_comment){
    
            $stmt = $mysqli->prepare("INSERT INTO u136839350_intec.comment (`text`, post_user_id, isDelete, post_date) VALUES(?, ?, 0, '$nowDateTime');");
            $stmt->bind_param("si", $temp_comment->comment_text, $temp_comment->post_user_id);
            $stmt->execute();
            $comment_id = $stmt->insert_id;
            $stmt = $mysqli->prepare("INSERT INTO u136839350_intec.event_has_comment (comment_id, event_id) VALUES(?, ?);");
            $stmt->bind_param("ii", $comment_id,$event_id);
            $stmt->execute();

            foreach($temp_comment->replies as $key => $reply ){


                $stmt = $mysqli->prepare("INSERT INTO u136839350_intec.comment (`text`, post_user_id, isDelete, post_date) VALUES(?, ?, 0, '$nowDateTime');");
                $stmt->bind_param("si", $reply->replie_text, $reply->post_user_id);
                $stmt->execute();
                $reply_id = $stmt->insert_id;

                $stmt = $mysqli->prepare("INSERT INTO u136839350_intec.comment_has_reply (comment_id, reply_id) VALUES(?, ?);");
                $stmt->bind_param("ii", $comment_id, $reply_id);
                $stmt->execute();
            }

            
        }
        $conn->desconectar();
        return array('success'=>true);  
    }catch(Exception $e){

        return array('error'=>true);

    }
}


function replyAssignedComment($assignedReplyData,$empresa_id,$event_id,$commentId,$post_user_id){

    try{
        $conn = new bd();
        $conn -> conectar();
        $mysqli = $conn->mysqli;
        $nowDateTime = date("Y-m-d H:i:s");

        $stmt = $mysqli->prepare("INSERT INTO u136839350_intec.comment (`text`, post_user_id, isDelete, post_date) VALUES(?, ?, 0, '$nowDateTime');"); 
        $stmt->bind_param("si", $assignedReplyData->reply_text, $assignedReplyData->post_user_id);
        $stmt->execute();
        $reply_id = $stmt->insert_id;

        $stmt = $mysqli->prepare("INSERT INTO u136839350_intec.comment_has_reply (comment_id, reply_id) VALUES(?, ?);");
        $stmt->bind_param("ii", $commentId, $reply_id);
        $stmt->execute();
        $conn->desconectar();
        return array('success'=>true,'reply_id'=>$reply_id);  
    }catch(Exception $e){

        return array('error'=>true);

    }
}


function updateComment($request){

    // try{
        $conn = new bd();
        $conn -> conectar();
        $mysqli = $conn->mysqli;
        $nowDateTime = date("Y-m-d H:i:s");

        $stmt = $mysqli->prepare("SELECT u.empresa_id FROM usuario u WHERE u.id = ?;"); 
        $stmt->bind_param("i",$request->user_id);
        $stmt->execute();
        $response = $stmt->get_result();
        $empresa_id = $response->fetch_object()->empresa_id;
       
        if(!$request->empresa_id === $empresa_id){
            $conn->desconectar();
            return array('error'=>true, 'message'=>'data not available');
        } 
    
        $stmt = $mysqli->prepare("UPDATE comment set `text` = ? WHERE id = ?;");
        $stmt->bind_param("si", $request->updated_comment_text, $request->comment_id);
        $scc = false;
        while (!$scc){
            if($stmt->execute()){
                $scc = true;
            }
        }
    
        $stmt = $mysqli->prepare("INSERT INTO u136839350_intec.comment_logs 
        (update_time, update_user_id, text_update, file_update, request, updated_comment_id) 
        VALUES(?, ?, 1, 0, ?, ?);");
        $parsed_request = json_encode($request);
        $stmt->bind_param("sisi", $nowDateTime,$request->user_id, $parsed_request,$request->comment_id);
        
        $stmt->execute();
        $conn->desconectar();
        return array('success'=>true,'message'=>'comment has been updated successfully');
    // }catch(Exception $e){
    //     return array('error'=>true,'message'=>"couldn't proccess petition");
    // }
}


function deleteComment($request){

    $conn = new bd();
    $conn -> conectar();
    $mysqli = $conn->mysqli;
    $nowDateTime = date("Y-m-d H:i:s");

    $stmt = $mysqli->prepare("SELECT u.empresa_id FROM usuario u WHERE u.id = ? ;"); 
    $stmt->bind_param("i",$request->user_id);
    $stmt->execute();
    $response = $stmt->get_result();
    $empresa_id = $response->fetch_object()->empresa_id;
   
    if(!$request->empresa_id === $empresa_id){
        $conn->desconectar();
        return array('error'=>true, 'message'=>'data not available');
    }

    $stmt = $mysqli->prepare("UPDATE comment set isDelete = 1 WHERE id = ? ;");
    $stmt->bind_param("i", $request->comment_id);
    $scc = false;
    while (!$scc){
        if($stmt->execute()){
            $scc = true;
        }
    }

    $stmt = $mysqli->prepare("INSERT INTO u136839350_intec.comment_logs 
    (updated_comment_id, request, update_user_id, update_time, text_update, file_update, delete_update) 
    VALUES(?, ?, ?, ?, 0, 0, 1);");
    $parsed_request = json_encode($request);
    $stmt->bind_param("isis", $request->comment_id, $parsed_request, $request->user_id, $nowDateTime,);
    $stmt->execute();
    $conn->desconectar();
    return array('success'=>true,'message'=>'comment has been deleted successfully');
  
}

?>