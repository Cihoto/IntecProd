<?php

require_once('../../bd/bd.php');

// Obtener el cuerpo del request
$json = file_get_contents('php://input');
$data = json_decode($json);

// echo json_encode($data->request);
// exit();
// Validar que los datos han sido recibidos correctamente
if (!$data || !isset($data->request)) {
    echo json_encode(["status" => "error", "message" => "Invalid request data","data"=>$data]);
    exit();
}

$request = $data->request;
$empresaId = $data->empresaId;

$conn = new bd();
$conn->conectar();
$mysqli = $conn->mysqli;

$now = date('Y-m-d H:i:s');
$today = date('Y-m-d');

$specialisms = [];


foreach ($request as $key => $specialism) {
    $success = false;
    $maxAttempts = 5; // Máximo número de intentos
    $attempt = 0;
    # code...
   
    // $stmt->execute();
    // $cargoDbResponse = $stmt->get_result();

    try {
        $stmt = $mysqli->prepare("INSERT INTO u136839350_intec.especialidad 
        (especialidad, createAt, modifiedAt, IsDelete, deleteAt, empresa_id, is_demo) 
        VALUES(?, $today, NULL, NULL, NULL, ?, 1);");
        
        if ($stmt === false) {
            throw new Exception("Error en la preparación de la consulta:");
        }

        $stmt->bind_param("si", $specialism, $empresaId);

        if (!$stmt->execute()) {
            throw new Exception("Error en la ejecución de la consulta:");
        }

        $specialismId = $stmt->insert_id;
        // Si llegamos aquí, significa que la consulta se ejecutó correctamente
        $success = true;
        
        $specialisms[] = (object) ['specialism' => $specialism, 'id' => $specialismId];
    } catch (Exception $e) {
        // Manejar el error y aumentar el contador de intentos
        // echo "Intento " . ($attempt + 1) . " fallido: " . $e->getMessage() . "\n";
        $attempt++;
        // Esperar un poco antes de intentar nuevamente
        sleep(1); // Esperar 1 segundo (puedes ajustar el tiempo según sea necesario)
    }

    
}

$conn->desconectar();

echo json_encode(["success"=>true,"specialisms"=>$specialisms]);

?>






