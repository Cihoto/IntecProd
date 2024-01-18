<?php
    require_once('../bd/bd.php');
    
    $conn = new bd();

    $conn ->conectar();

    $json = file_get_contents('php://input');
    $data = json_decode($json);

    $vehicleArray = $data;
    $returnErrArray = [];
    $countTotal = 0;
    $counter = 0;


    foreach ($vehicleArray as $key => $request){

        if($request->type === "" || $request->type === null ){ $request->type = "NULL";}
        if($request->brand === "" || $request->brand === null ){ $request->brand = "NULL";}
        if($request->model === "" || $request->model === null ){ $request->model = "NULL";}
        if($request->patente === "" || $request->patente === null ){ $request->patente = "";}
        if($request->owner === "" || $request->owner === null ){ $request->owner = 0;}
        if($request->costPerTrip === "" || $request->costPerTrip === null ){ $request->costPerTrip = "NULL";}

        $queryInsert = "INSERT INTO vehiculo 
        (patente, IsDelete, empresa_id, ownCar, tripValue, tipoVehiculo_id, marca, modelo)
        VALUES('$request->patente',
         0,
         $request->empresa_id,
         $request->owner,
         $request->costPerTrip,
         $request->type,
         $request->brand,
         $request->model);";

        if($conn->mysqli->query($queryInsert)){
            // return json_encode(array("success"=>true,"message"=>"Vehículo ingresado exitosamente"));
            $counter++;
        }else{
            
            $countTotal ++;
            // return json_encode(array("error"=>true,"message"=>"Intente nuevamente"));
        }
    };

    echo json_encode(array("data"=>'Se han ingresado '.$counter.' de '.$countTotal,"query"=>$queryInsert));                                             
?>