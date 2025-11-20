<?php
require_once(__DIR__ . '/../bd/ConnectionManager.php');

$conn = getDBConnection(); // Auto-managed connection

$json = file_get_contents('php://input');
$data = json_decode($json);


// Check if the required parameters are present
if (isset($data->empresaId) && isset($data->productId)) {
    // Retrieve the values from the request body
    $empresaId = $data->empresaId;
    $productId = $data->productId;

    // Your code to delete the product goes here
    // Prepare the SQL statement
    $stmt = $conn->mysqli->prepare("UPDATE producto SET IsDelete = 1, deleteAt = CURDATE() WHERE empresa_id = ? and id = ?");
    // Bind the parameter
    $stmt->bind_param("ii", $empresaId, $productId);
    // Execute the statement
    $stmt->execute();

    // Check if the update was successful
    if ($stmt->affected_rows > 0) {
        // Return a success response
        echo json_encode(array('message' => 'Product deleted successfully'));
        $stmt->close();
        // $conn->desconectar(); // Auto-closed by ConnectionManager
    } else {
        // Return an error response
        // $conn->desconectar(); // Auto-closed by ConnectionManager
        echo json_encode(array('error' => 'Failed to delete product'));
    }

    // Close the statement

    // Return a success response
    // echo json_encode(array('message' => 'Product deleted successfully'));
} else {
    // Return an error response if the required parameters are missing
    // $conn->desconectar(); // Auto-closed by ConnectionManager
    echo json_encode(array('error' => 'Missing parameters'));
}