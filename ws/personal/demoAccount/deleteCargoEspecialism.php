<?php

require_once('../../bd/bd.php');

// Obtener el cuerpo del request
$json = file_get_contents('php://input');
$data = json_decode($json);

// echo json_encode($data->request);
// exit();
// Validar que los datos han sido recibidos correctamente
if (!$data || !isset($data->empresaId)) {
    echo json_encode(["status" => "error", "message" => "Invalid request data","data"=>$data]);
    exit();
}

$empresaId = $data->empresaId;

$conn = new bd();
$conn->conectar();
$mysqli = $conn->mysqli;
// 
$stmt = $mysqli->prepare("DELETE FROM especialidad WHERE empresa_id = ? AND is_demo = 1;");
$stmt->bind_param("i", $empresaId);
$stmt->execute();


$stmt = $mysqli->prepare("DELETE FROM cargo WHERE empresa_id = ? AND is_demo = 1");
$stmt->bind_param("i", $empresaId);
$stmt->execute();


$conn->desconectar();

echo json_encode(["success"=>true]);



?>






