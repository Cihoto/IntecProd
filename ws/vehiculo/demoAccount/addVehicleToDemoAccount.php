<?php

require_once('../../bd/bd.php');

// Obtener el cuerpo del request
$json = file_get_contents('php://input');
$data = json_decode($json);
$request = $data->request;
$empresaId = $data->empresaId;


// Validar que se hayan enviado todos los campos requeridos
if ( $empresaId && count($request) > 0) {  
    $conn = new bd();
    $conn->conectar();  
    $response = [];
    foreach ($request as $vehicle) {
        $patente = $vehicle->patente;
        $ownCar = $vehicle->ownCar;
        $tripValue = $vehicle->tripValue;
        $tipoVehiculo_id = $vehicle->tipoVehiculo_id;
        $brand = $vehicle->brand;
        $model = $vehicle->model;

        $query = "INSERT INTO u136839350_intec.vehiculo 
        (patente, empresa_id, ownCar, tripValue, tipoVehiculo_id, marca, modelo, is_demo)
         VALUES(?, ?, ?, ?, ?, ?, ?, 1)";

        $stmt = mysqli_prepare($conn->mysqli, $query);
        mysqli_stmt_bind_param($stmt, "siiiiii", $patente, $empresaId,$ownCar, $tripValue, $tipoVehiculo_id, $brand, $model);
        $result = mysqli_stmt_execute($stmt);

        if ($result) {
          
            $response[] = array(
                "patente" => $patente,
                "ownCar" => $ownCar,    
                "tripValue" => $tripValue,  
                "tipoVehiculo_id" => $tipoVehiculo_id,  
                "brand" => $brand,
                "model" => $model,  
                "id" => mysqli_insert_id($conn->mysqli)
            );
        } 
    }
} else {
    // Error: Faltan campos requeridos
    $response = array(
        "error" => true,
        "message" => "Missing required fields"
    );
}

// Convertir la respuesta a formato JSON y enviarla
$conn->desconectar();
echo json_encode($response);