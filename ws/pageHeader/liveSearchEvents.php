<?php

require_once('../bd/bd.php');
$json = file_get_contents('php://input');
$data = json_decode($json);

$request = $data->request;

$conn = new bd();
$conn->conectar();
$mysqli = $conn->mysqli;

$events = [];

$stmt = $mysqli->prepare("SELECT 
p.id, 
p.fecha_inicio as s_date,
p.nombre_proyecto as event_name
FROM proyecto p 
WHERE p.empresa_id = ?
AND LOWER(p.nombre_proyecto) LIKE ?");

$preparedName = "%".$request->eventName."%";
$stmt->bind_param("is", $request->empresa_id, $preparedName);
$stmt->execute();

$result = $stmt->get_result();

while ($data = $result->fetch_object()) {
    $events [] = $data;
}

$conn->desconectar();
echo json_encode([
    'success' => true,
    'events' => $events
]); 
 ?>