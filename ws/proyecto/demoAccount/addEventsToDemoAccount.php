<?php

    require_once('../../bd/bd.php');
    // Obtener el cuerpo del request
    $json = file_get_contents('php://input');
    $data = json_decode($json);

    // echo json_encode($data->request);
    // exit();
    // Validar que los datos han sido recibidos correctamente
    if (!$data || !isset($data->request) || !isset($data->empresaId)) {
        echo json_encode(["status" => "error", "message" => "Invalid request data"]);
        exit();
    }




    $request = $data->request;  
    $empresaId = $data->empresaId;  
    $conn = new bd();   
    $conn->conectar();
    $mysqli = $conn->mysqli;
    $now = date('Y-m-d H:i:s');
    $today = date('Y-m-d');
    $response = [];
    $buss_data = [];



    

    // Create php API to execute the query to insert the events into the demo account
    foreach ($request as $event) {

        
    // insert direccion to get address_id

        $stmt = $mysqli->prepare("INSERT INTO u136839350_intec.direccion 
        (direccion, empresa_id) 
        VALUES(?, 0)");
        
        $stmt->bind_param("s", $event->ADDRESS);
        $stmt->execute();
        $addressId = $stmt->insert_id;

        $fechaInicio = date('Y-m-d', strtotime($event->fecha_inicio . ' ' . $event->fecha_inicio . ' days'));
        $fechaTermino = date('Y-m-d', strtotime($event->fecha_termino . ' ' . $event->fecha_termino . ' days'));

        $stmt = $mysqli->prepare("INSERT INTO u136839350_intec.proyecto 
                (nombre_proyecto,
                fecha_inicio,
                fecha_termino,
                comentarios,
                createAt,
                isDelete,
                cliente_id,
                empresa_id,
                status_id,
                address_id,
                event_type_id,
                isDemo) 
        VALUES(?,?,?,?,?,0,?,?,?,?,?,1);");
        

        $stmt->bind_param("sssssiiiii", 
            $event->nombre_proyecto, 
            $fechaInicio, 
            $fechaTermino, 
            $event->observaciones, 
            $fechaInicio, 
            $event->cliente_id, 
            $empresaId, 
            $event->status_id, 
            $addressId, 
            $event->event_type_id
        );
        $stmt->execute();
        $eventId = $stmt->insert_id;


        // Insertar el personal a asignar
        foreach ($event->personalToAssign as $personal) {
            $stmtPersonal = $mysqli->prepare("INSERT INTO u136839350_intec.personal_has_proyecto 
            (personal_id, proyecto_id, costo, worked_hours) 
            VALUES(?,?,?,?);");
            $stmtPersonal->bind_param("iiii", $personal->personalId,$eventId, $personal->salary,$personal->workedHours);
            $stmtPersonal->execute();
            $stmtPersonal->close();
        }


        // Insertar los productos a asignar
        foreach ($event->productsToAssign as $product) {

            $stmtProducts = $mysqli->prepare("INSERT INTO u136839350_intec.proyecto_has_producto 
            (proyecto_id, producto_id, cantidad, arriendo) 
            VALUES(?,?,?,?);");

            $stmtProducts->bind_param("iiii", $eventId,$product->prodId, $product->quantity, $product->totalProd);
            $stmtProducts->execute();
            $stmtProducts->close();
        }

        // Insertar los vehículos a asignar 
        foreach ($event->vehiclesToAssign as $vehicle) {
            $stmtVehicles = $mysqli->prepare("INSERT INTO u136839350_intec.proyecto_has_vehiculo 
            (proyecto_id, vehiculo_id, price_per_trip, trip_count) 
            VALUES(?,?,?,?);");
            $stmtVehicles->bind_param("iiii", $eventId,$vehicle->vehicleId, $vehicle->tripPrice, $vehicle->tripCount);
            $stmtVehicles->execute();
            $stmtVehicles->close();
        }

        // Insertar los otros productos a asignar
        foreach ($event->othersSellToAssign as $otherSell) {
            $stmtOtherSell = $mysqli->prepare("INSERT INTO u136839350_intec.proyecto_has_otros_productos 
            (detalle, cantidad, valor, project_id) 
            VALUES(?,?,?,?);");
            $stmtOtherSell->bind_param("siii", $otherSell->sellName, $otherSell->quantity, $otherSell->totalPrice, $eventId);
            $stmtOtherSell->execute();
            $stmtOtherSell->close();
        }

        // Insertar los otros costos a asignar
        foreach ($event->otherCostsToAssign as $otherCost) {
            $stmtOtherCost = $mysqli->prepare("INSERT INTO u136839350_intec.proyecto_has_other_costs 
            (name, quantity, total, event_id) 
            VALUES(?,?,?,?);");
            $stmtOtherCost->bind_param("siii", $otherCost->costName, $otherCost->quantity, $otherCost->totalPrice, $eventId);
            $stmtOtherCost->execute();
            $stmtOtherCost->close();
        }



    }


    // update demo_active to 1
    $stmt = $mysqli->prepare("UPDATE empresa SET demo_active = 1, demo_activation_date = ? WHERE id = ?;");
    $stmt->bind_param("si",$now, $empresaId);
    $stmt->execute();

    // Get the business data

    $stmt = $mysqli->prepare("SELECT datediff(CURDATE(),e.createdAt) AS diff ,e.demo_active, bl.bus_logo_name as bl
    FROM empresa e 
    LEFT JOIN businessLogo bl on bl.bus_logo_id  = e.bus_logo_id 
    WHERE e.id =?;");
    $stmt->bind_param("i", $empresaId);
    $stmt->execute();
    $responseBussData = $stmt->get_result();

    while ($data = $responseBussData->fetch_object()) {
        $buss_data = $data;
    }

    if(session_id() == '') {
        session_start();
    }
    $_SESSION['buss_data'] = $buss_data;

    $conn->desconectar();

    $response = ["status" => "success", "message" => "Events added successfully"];
    echo json_encode($response);

?>