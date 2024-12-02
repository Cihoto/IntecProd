<?php
// get post data and get the file name on folder commonMovementsFiles
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $businessName = $data['businessName'];
    $businessId = $data['businessId'];
    $businessAccount = $data['businessAccount'];
    $directory = __DIR__ . '/commonMovementsFiles';
    $filePath = $directory . "/$businessId$businessAccount"."_"."$businessName.json";
    // echo $filePath;
    if (file_exists($filePath)) {
        $commonMovements = json_decode(file_get_contents($filePath), true);
        // check if data is null
        if (empty($commonMovements)) {
            echo json_encode(['status' => 'success', 'message' => 'Data fetched successfully', "data" => []]);
            exit;
        }
        $conn->desconectar();
        echo json_encode(['status' => 'success', 'message' => 'Data fetched successfully', "data" => $commonMovements]);
    } else {
        $conn->desconectar();
        echo json_encode(['status' => 'error', 'message' => 'No data found',"data"=>[]]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>