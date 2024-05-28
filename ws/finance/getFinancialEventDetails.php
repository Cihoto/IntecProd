<?php

include_once('../config/globalConfig.php');

$eventDetails = [];

$stmt = $mysqli->prepare("SELECT p.id as event_id,
p.nombre_proyecto as 'event_name',
p.fecha_inicio as 'event_init_date',
pfr.income as 'event_income',
pfr.cost as 'event_cost',
ed.* ,
p.event_type_id as event_type
FROM proyecto p 
LEFT JOIN project_finance_resume pfr on pfr.event_id = p.id 
LEFT JOIN event_data ed on ed.event_id = p.id 
WHERE p.empresa_id = ?
AND p.status_id in (2,3,5)
ORDER BY p.fecha_inicio desc");

// AND p.fecha_inicio <= CURDATE()

$stmt->bind_param("i", $request->empresa_id);
$stmt->execute();
$result = $stmt->get_result();

while($data = $result->fetch_object()){
    $eventDetails [] = $data;
}

echo json_encode([
    "success"=>true,
    "eventDetails" => $eventDetails
]);

?>