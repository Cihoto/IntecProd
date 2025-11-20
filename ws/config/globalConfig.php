<?php
    date_default_timezone_set('America/Santiago');
    require_once(__DIR__ . '/../bd/ConnectionManager.php');
    
    // recieve AJAX Data
    $json = file_get_contents('php://input');
    $data = json_decode($json);
    $request = $data->request;

    // DB connection 
    $conn = getDBConnection(); // Auto-managed connection
    $mysqli = $conn->mysqli;
?>