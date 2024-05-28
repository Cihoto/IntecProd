<?php
    date_default_timezone_set('America/Santiago');
    require_once('../bd/bd.php');
    
    // recieve AJAX Data
    $json = file_get_contents('php://input');
    $data = json_decode($json);
    $request = $data->request;

    // DB connection 
    $conn = new bd();
    $conn->conectar();
    $mysqli = $conn->mysqli;
?>