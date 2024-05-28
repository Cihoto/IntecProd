<?php

include_once('../config/globalConfig.php');

$anualIncome = [];

$stmt = $mysqli->prepare("CALL getAnualIncome_finance(?)");
$stmt->bind_param("i", $request->empresa_id);
$stmt->execute();
$result = $stmt->get_result();


while($data = $result->fetch_object()){

    $anualIncome [] = $data;
}

echo json_encode([
    "success"=>true,
    "anualIncome" => $anualIncome 
]);

?>