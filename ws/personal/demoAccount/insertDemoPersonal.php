<?php

require_once('../../bd/bd.php');

// Obtener el cuerpo del request
$json = file_get_contents('php://input');
$data = json_decode($json);

// echo json_encode($data->request);
// exit();
// Validar que los datos han sido recibidos correctamente
if (!$data || !isset($data->empresaId) || !isset($data->personalData) || !isset($data->specialismData) || !isset($data->cargoData)) {
    echo json_encode(["status" => "error", "message" => "Invalid request data"]);
    exit();
}

$empresaId = $data->empresaId;
$personalData = $data->personalData;
$specialismData = $data->specialismData;
$cargoData = $data->cargoData;

$conn = new bd();
$conn->conectar();
$mysqli = $conn->mysqli;

$now = date('Y-m-d H:i:s');
$today = date('Y-m-d');

$cargos = [];




foreach ($personalData as $key => $personal) {


    $personaId = 0;
    $cargo_id = 0;
    $specialism_id = 0;

    $stmt = $mysqli->prepare("INSERT INTO u136839350_intec.persona 
        (nombre, apellido, rut, email, telefono) 
        VALUES(?, NULL, ?, ?, ?);");

    // "name ": "Pedro Soto",
    // "rut": "12345678-8",
    // "mail": "correo2@gmail.com",
    // "number": 9912345679,
    // "persona_id": 124,
    // "salary": 1200000,
    // "cargo": "Jefe Técnico",
    // "specialism": "De todo",
    // "tipo_contrato_id": 4

    $stmt->bind_param("ssss", $personal->name, $personal->rut, $personal->mail, $personal->number);
    $stmt->execute();
    $personaId = $stmt->insert_id;


    foreach ($cargoData as $cargo) {
        if (strtolower($cargo->cargo)  === strtolower($personal->cargo)) {
            $cargo_id = $cargo->id;
            break; // Salir del bucle una vez encontrado
        }
    }

    foreach ($specialismData as $specialism) {
        if (strtolower($specialism->specialism)  === strtolower($personal->specialism)) {
            $specialism_id = $specialism->id;
            break; // Salir del bucle una vez encontrado
        }
    }



    $stmt = $mysqli->prepare("INSERT INTO u136839350_intec.personal 
        (persona_id, usuario_id, neto, cargo_id, especialidad_id, tipo_contrato_id,
        createAt, modifiedAt, IsDelete, deleteAt, empresa_id, is_demo) 
        VALUES(?, NULL, ?, ?, ?, ?, ?, NULL, 0, NULL, ?, 1);");

    $stmt->bind_param(
        "iiiiisi",
        $personaId,
        $personal->salary,
        $cargo_id,
        $specialism_id,
        $personal->tipo_contrato_id,
        $today,
        $empresaId
    );

    $stmt->execute();
}
$conn->desconectar();
echo json_encode(["success" => true]);
