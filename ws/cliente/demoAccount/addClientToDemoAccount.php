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


    foreach ($request as $cliente) {



        $razon_social = $cliente->razon_social;
        $nombre_fantasia = $cliente->nombre_fantasia;
        $rut_df = $cliente->rut_df;
        $direccion_df = $cliente->direccion_df;
        $correo_df = $cliente->mail_df;
        $persona_contacto = $cliente->persona_contacto;
        $nombre = $cliente->nombre;
        $rut = $cliente->rut;
        $email = $cliente->mail;
        $number = $cliente->number;

        // Validate if any value is null and set it to empty string
        if ($razon_social === null) {
            $razon_social = "";
        }
        if ($nombre_fantasia === null) {
            $nombre_fantasia = "";
        }
        if ($rut_df === null) {
            $rut_df = "";
        }
        if ($direccion_df === null) {
            $direccion_df = "";
        }
        if ($correo_df === null) {
            $correo_df = "";
        }
        if ($persona_contacto === null) {
            $persona_contacto = "";
        }
        if ($nombre === null) {
            $nombre = "";
        }
        if ($rut === null) {
            $rut = "";
        }
        if ($email === null) {
            $email = "";
        }
        if ($number === null) {
            $number = "";
        }

        $stmt = $conn->mysqli->prepare("INSERT INTO u136839350_intec.datos_facturacion 
        (razon_social, nombre_fantasia, rut, direccion, correo) 
        VALUES(?, ?, ?, ?, ?);");

        $stmt->bind_param("sssss", $razon_social, $nombre_fantasia, $rut_df, $direccion_df, $correo_df);
        $stmt->execute();
        $datos_facturacion_id = mysqli_insert_id($conn->mysqli);

        $stmt->close();

        $stmt = $conn->mysqli->prepare("INSERT INTO u136839350_intec.persona 
        (nombre, apellido, rut, email, telefono) 
        VALUES(?, NULL, ?, ?, ?);");

        $stmt->bind_param("ssss", $nombre, $rut, $email, $number);
        $stmt->execute();
        $persona_id_contacto = mysqli_insert_id($conn->mysqli);
        

        $stmt = $conn->mysqli->prepare("INSERT INTO u136839350_intec.cliente 
        (datos_facturacion_id, persona_id_contacto, empresa_id, isDelete,isDemo) 
        VALUES(?, ?, ?, ?,1)");

        $stmt->bind_param("iiii", $datos_facturacion_id, $persona_id_contacto, $empresa_id, $isDelete);

        // $datos_facturacion_id = 0;
        // $persona_id_contacto = 0;
        $empresa_id = $empresaId;
        $isDelete = 0;
        $stmt->execute();
        $stmt->close();

        $response [] = [
            "razon_social" => $razon_social,
            "nombre_fantasia" => $nombre_fantasia,
            "rut_df" => $rut_df,
            "direccion_df" => $direccion_df,
            "correo_df" => $correo_df,
            "persona_contacto" => $persona_contacto,
            "nombre" => $nombre,
            "rut" => $rut,
            "email" => $email,
            "number" => $number,
            "clientId" => mysqli_insert_id($conn->mysqli),
            "datos_facturacion_id" => $datos_facturacion_id,
            "persona_id_contacto" => $persona_id_contacto
        ];
    }
    echo json_encode($response);

}else{
    // Error: Faltan campos requeridos
    $response = array(
        "error" => true,
        "message" => "Missing required fields"
    );
}