<?php

require_once('../bd/bd.php');
session_start();
$empresa_id = $_SESSION["empresa_id"];
$personal_ids = $_SESSION["personal_ids"][0];
$previusLogo = $_SESSION['buss_data']->bl;

$conn = new bd();
$conn->conectar();
$mysqli = $conn->mysqli;
$now = date('Y-m-d H:i:s');
$absolute_path = getcwd();
$nombreArchivo = $_FILES['files']['name'];
$user_id = $personal_ids->usuario_id;


$stmt = $mysqli->prepare("INSERT INTO u136839350_intec.businessLogo (bus_logo_name, last_update_datetime, last_update_user_id) VALUES(?,?,?);");
$stmt->bind_param("ssi", $nombreArchivo, $now, $user_id);

if (!$stmt->execute()) {
    $conn->desconectar();
    // return badReqBusLogo();
}

$bus_logo_id = $mysqli->insert_id;


$stmt = $mysqli->prepare("UPDATE empresa SET bus_logo_id = ? WHERE id = ?");
$stmt->bind_param("ii", $bus_logo_id, $empresa_id);

if (!$stmt->execute()) {
    $conn->desconectar();
    // return badReqBusLogo();
}
$conn->desconectar();


$target_path = $absolute_path . "/bussLogo";


$targetLogo = $target_path . "/b$empresa_id"."l"."$nombreArchivo";
$previustargetLogo = $target_path . "/b$empresa_id'l'$previusLogo";

if (file_exists($targetLogo)){
    unlink($targetLogo);
}
if (file_exists($previustargetLogo)){
    unlink($previustargetLogo);
}

if (move_uploaded_file($_FILES['files']['tmp_name'], $targetLogo)) {
    echo 'Archivo subido con éxito: ' . $targetLogo;
    $_SESSION['buss_data']->bl = $nombreArchivo;
} else {
    echo 'Error al subir el archivo.';
}