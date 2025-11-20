<?php
    // $conn = getDBConnection(); // Auto-managed connection


$json = file_get_contents('php://input');
$data = json_decode($json);

$request = $data->request;
$tipo = $data->tipo;

if($tipo === "addtoProject"){
    echo addtoProject($request);
}
?>