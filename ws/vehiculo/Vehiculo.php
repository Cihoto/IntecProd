<?php
date_default_timezone_set('America/Santiago');

if ($_POST) {
    require_once('../bd/bd.php');

    $json = file_get_contents('php://input');
    $data = json_decode($json);
    $action = $data->action;
    
    if(isset($data->vehicleData)){
        $datav = $data->vehicleData;
    }



    // Realiza la acción correspondiente según el valor de 'action'
    switch ($action) {
        case 'getVehiclesByBussiness':
            // Recibe el parámetro empresaId
            $empresa_id = $data->empresa_id;
            // Llama a la función getVehiculos y devuelve el resultado
            $vehiculos = json_encode(getVehiclesByBussiness($empresa_id));
            echo $vehiculos;
            break;
        case 'deleteVehicleDash':
            $vehicle_id = $data->vehicle_id;
            $empresa_id = $data->empresa_id;
            $result = deleteVehicleDash($vehicle_id ,$empresa_id );
            echo json_encode($result);
            break;
        case 'getVehiculos':
            // Recibe el parámetro empresaId
            $empresaId = $data->empresaId;
            // Llama a la función getVehiculos y devuelve el resultado
            $vehiculos = getVehiculos($empresaId);
            echo json_encode($vehiculos);
            break;
        case 'getVehiculosForEvents':
            // Recibe el parámetro empresaId
            $empresaId = $data->empresaId;
            // Llama a la función getVehiculos y devuelve el resultado
            $vehiculos = getVehiculosForEvents($empresaId);
            echo json_encode($vehiculos);
            break;
        case 'getAvailableVehiculos':
            // Recibe el parámetro empresaId
            $request = $data->request->arrayRequest;
            // Llama a la función getAvailableVehiculos y devuelve el resultado
            $vehiculos = getAvailableVehiculos($request);
            echo json_encode($vehiculos);
            break;
        
        case 'addVehicleToProject':
            // Recibe el parámetro request
            $request = $data->request;
            
            // Llama a la función addtoProject y devuelve el resultado
            $response = addVehicleToProject($request);
            echo json_encode($response);
            break;
        
        case 'dropAssigmentVehicles':
            // Recibe el parámetro request
            $idProject = $data->idProject;
            // Llama a la función addtoProject y devuelve el resultado
            $deleteIds = dropAssigmentVehicles($idProject);
            echo json_encode($deleteIds);
            break;
        
        case 'getAssigned':
            // Recibe el parámetro empresaId
            $empresaId = $_POST['empresaId'];
            
            // Llama a la función getAssigned y devuelve el resultado
            $assigned = getAssigned($empresaId);
            echo json_encode($assigned);
            break;
        
        case 'deleteVehicle':
            // Recibe el parámetro arrayIdVehicles
            $arrayIdVehicles = $data->arrayIdVehicles;
            
            // Llama a la función deleteVehicle y devuelve el resultado
            $response = deleteVehicle($arrayIdVehicles);
            echo $response;
            break;
        
        case 'addVehicle':
            // Recibe el parámetro vehicleData
            $vehicleData = $data->vehicleData;
            $empresaId = $data->empresaId;
            
            // Llama a la función addVehicle y devuelve el resultado
            $response = addVehicle($vehicleData,$empresaId);
            echo $response;
            break;
        case 'getVehicleBrandsAndModels':
            
            // Llama a la función addVehicle y devuelve el resultado
            $response = getVehicleBrandsAndModels();
            echo $response;
            break;
        case 'insertVehicle':
            $request = $data->request;
            $empresa_id = $data->empresa_id;
            // Llama a la función addVehicle y devuelve el resultado
            $response = insertVehicle($request, $empresa_id);
            echo $response;
            break;
        case 'getVehicleInfoById':
            $vehicle_id = $data->vehicle_id;
            $empresa_id = $data->empresa_id;
            // Llama a la función addVehicle y devuelve el resultado
            $response = getVehicleInfoById($vehicle_id, $empresa_id);
            echo $response;
            break;
        
        default:
            echo 'Invalid action.';
            break;
    }
}else{
    require_once('./ws/bd/bd.php');
}

function getVehiclesByBussiness($empresa_id){
    $conn = new bd();
    $conn->conectar();
    $vehiculos = [];

    $query = "SELECT v.*,v.id as vehicle_id, tv.tipo, vb.*, vm.* from vehiculo v 
    left join vehicle_brand vb on vb.id = v.marca
    left join vehicle_model vm on vm.id = v.modelo
    left join tipo_vehiculo tv on tv.id = v.tipoVehiculo_id 
    where v.empresa_id = $empresa_id and IsDelete = 0;";

    if ($response = $conn->mysqli->query($query)) {
        while ($data = $response->fetch_object()) {
            $vehiculos[] = $data;
        }
        $conn->desconectar();

        return array("success"=>true,"data"=>$vehiculos);
    }else{
        return array("error"=>true,"message"=>"Intente nuevamente");
        // return $vehiculos;
    }
}

function deleteVehicleDash($vehicle_id,$empresa_id){
    try  {

        if(!viewIfVehicleIsOnBussieness($vehicle_id,$empresa_id)){
            return ['error', 'message'=>'vehicle has not been found'];
        }   
        $now = date('Y-m-d H:i:s');

        $conn = new bd();
        $conn->conectar();
        $mysqli = $conn->mysqli;
        $stmt = $mysqli->prepare("UPDATE vehiculo set IsDelete = 1 , deleteAt = ? where id = ?");
        $stmt->bind_param("si",$now, $vehicle_id);
        $stmt->execute();
        $conn->desconectar();

        // return $stmt->affected_rows;

        if($stmt->affected_rows > 0){
            return true;
        }

        return false;

    } catch (Exception $e) {
        $conn->desconectar();
        return 'error while deleting vehicle';
    }
}

function viewIfVehicleIsOnBussieness($vehicle_id,$empresa_id){
    try {
        $conn = new bd();
        $conn->conectar();
        $mysqli = $conn->mysqli;
        $stmt = $mysqli->prepare("SELECT * FROM vehiculo v WHERE v.empresa_id  = ? AND v.id = ?");
        $stmt->bind_param("ii", $empresa_id,$vehicle_id);
        $stmt->execute();

        $results = $stmt->get_result();
        
        $conn->desconectar();
        if($results->num_rows > 0){
            return true;
        }
        return false;
    } catch (Exception $e) {
        $conn->desconectar();
        return ['message'=>'error in view VEHICLE On Bussieness petition'];
    }
}

function getVehiculos($empresaId)
{
    $conn = new bd();
    $conn->conectar();
    $vehiculos = [];
    $queryVehiculos = "SELECT v.id,v.patente,v.ownCar,v.tripValue,tv.tipo, v.IsDelete FROM vehiculo v 
    LEFT JOIN persona p ON p.id = v.persona_id
    INNER JOIN tipo_vehiculo tv ON tv.id = v.tipoVehiculo_id
    INNER JOIN empresa e ON e.id = v.empresa_id 
    WHERE e.id = $empresaId AND v.IsDelete = 0";

    if ($responseBdVehiculos = $conn->mysqli->query($queryVehiculos)) {
        while ($dataVehiculos = $responseBdVehiculos->fetch_object()) {
            $vehiculos[] = $dataVehiculos;
        }
    }
    $conn->desconectar();
    return $vehiculos;
}
function getVehiculosForEvents($empresaId)
{
    $conn = new bd();
    $conn->conectar();
    $vehiculos = [];
    $queryVehiculos = "SELECT v.id,v.patente,v.ownCar,v.tripValue,tv.tipo, v.IsDelete FROM vehiculo v 
    LEFT JOIN persona p ON p.id = v.persona_id
    INNER JOIN tipo_vehiculo tv ON tv.id = v.tipoVehiculo_id
    INNER JOIN empresa e ON e.id = v.empresa_id 
    WHERE e.id = $empresaId";

    if ($responseBdVehiculos = $conn->mysqli->query($queryVehiculos)) {
        while ($dataVehiculos = $responseBdVehiculos->fetch_object()) {
            $vehiculos[] = $dataVehiculos;
        }
    }
    $conn->desconectar();
    return $vehiculos;
}

function getAvailableVehiculos($request)
{
    $conn = new bd();
    $conn->conectar();
    $vehiculos = [];

    foreach($request as $req){
        $empresaId = $req->empresaId;
        $fechaInicio = $req->fechaInicio;
        $fechaTermino = $req->fechaTermino;
    }

    $queryVehiculos = "SELECT v.id,v.patente FROM vehiculo v
                        LEFT JOIN proyecto_has_vehiculo phv on phv.vehiculo_id = v.id
                        LEFT  JOIN proyecto p on p.id = phv.proyecto_id
                        where p.id IS NULL 
                        or '".$fechaInicio."' < p.fecha_inicio and '".$fechaTermino."' < p.fecha_inicio 
                        or '".$fechaInicio."' > p.fecha_termino and '".$fechaTermino."' > p.fecha_termino
                        and p.empresa_id = $empresaId";

    if ($responseBdVehiculos = $conn->mysqli->query($queryVehiculos)) {
        while ($dataVehiculos = $responseBdVehiculos->fetch_object()) {
            $vehiculos[] = $dataVehiculos;
        }
    }
    $conn->desconectar();
    return $vehiculos;
}

function addVehicleToProject($request)
{
    $conn = new bd();
    $conn->conectar();
    $arrayResponse = [];
    $idProject = 0;
    
    foreach (array_slice($request, 0, 1) as $req) {
        $idProject = $req->idProject;
    }

    $queryIfAssigned = "SELECT * from proyecto_has_vehiculo phv where phv.proyecto_id =$idProject";

    if($conn->mysqli->query($queryIfAssigned)->num_rows>0){
        $qdelete = "DELETE FROM proyecto_has_vehiculo WHERE proyecto_id =$idProject";
        $conn->mysqli->query($qdelete);
    }

    foreach ($request as $req) {
        $idVehicle = $req->idVehicle;
        $trip_value = $req->trip_value;
        $trip_count = $req->trip_count;
        $query = "INSERT INTO proyecto_has_vehiculo
                (proyecto_id, vehiculo_id,price_per_trip,trip_count)
                VALUES($idProject, $idVehicle, $trip_value,$trip_count)";
        if ($conn->mysqli->query($query)) {
            array_push($arrayResponse, array("Asignado" => array("id" => $idVehicle)));
        } else {
            array_push($arrayResponse, array("NoAsignado" => array("id" => $idVehicle)));
        }
    }
    $conn->desconectar();
    return $arrayResponse;
}

function dropAssigmentVehicles($idProject){
    $conn = new bd();
    $conn->conectar();
    $queryIfAssigned = "SELECT * from proyecto_has_vehiculo phv where phv.proyecto_id =$idProject";

    if($conn->mysqli->query($queryIfAssigned)->num_rows>0){
        $qdelete = "DELETE FROM proyecto_has_vehiculo WHERE proyecto_id =$idProject";
        $conn->mysqli->query($qdelete);
    }

    return $conn->mysqli->affected_rows;
}

function getAssigned($empresaId)
{
    $conn = new bd();
    $conn->conectar();
    $vehiculos = [];
    $queryVehiculos = "SELECT v.id ,v.patente ,v.personal_id  FROM vehiculo v
                                INNER JOIN personal p on p.id = v.personal_id 
                                INNER JOIN empresa e on e.id = p.empresa_id 
                                WHERE e.id = $empresaId";

    if ($responseBdVehiculos = $conn->mysqli->query($queryVehiculos)) {
        while ($dataVehiculos = $responseBdVehiculos->fetch_object()) {
            $vehiculos[] = $dataVehiculos;
        }
    }
    $conn->desconectar();
    return $vehiculos;
}




function deleteVehicle($arrayIdVehicles)
{
    $conn = new bd();
    $conn->conectar();

    $today = date('Y-m-d');
    $arrayResponse = [];

    foreach ($arrayIdVehicles as $persona) {

        $queryDelete = 'update vehiculo set IsDelete = 1, deleteAt = "' . $today . '" where id = ' . $persona->id;

        if ($conn->mysqli->query($queryDelete)) {
            $arrayResponse = json_encode(array("status" => 1, "message" => "Se ha eliminado exitosamente "));
        } else {
            $arrayResponse = json_encode(array("status" => 0, "message" => "Error al eliminar"));
        }
    }

    $conn->desconectar();
    return $arrayResponse;
}

function addVehicle($vehicleData, $empresaId)
{
    $conn = new bd();
    $conn->conectar();
    // return json_encode($vehicleData);
    $returnErrArray = [];
    foreach ($vehicleData->arrayRequest as $value) {
        
        $patente = $value->patente;
        $nombre = $value->nombre;

        if($nombre !== ""){  
            
            $query = 'select p.id from personal p 
                    where CONCAT(LOWER(p.nombre)," ",LOWER(p.apellido))="'.trim(strtolower(($nombre))).'" LIMIT 1';

            $responseBd = $conn->mysqli->query($query);
            if ($responseBd->num_rows > 0) {
                $value = $responseBd->fetch_object();
                $idPersonal = $value->id;
                
            } else {
                $idPersonal = "null";
                // array_push($returnErrArray, array("nombre" => $nombre, "patente" => $patente));
            }

        }else{
            $idPersonal = "null";
        }
        $query = "INSERT INTO vehiculo
        (patente, IsDelete, empresa_id, persona_id)
        VALUES('".$patente."', 0, $empresaId, $idPersonal)";

        $conn->mysqli->query($query);
    }

    if (count($returnErrArray) > 0) {
        return json_encode(array("status" => 0, "array" => $returnErrArray));
    } else {
        return json_encode(array("status" => 1, "array" => $returnErrArray));
    }
}

function getVehicleBrandsAndModels(){
    $conn = new bd();
    $conn->conectar();
    $brands = [];
    $models = [];
    $type = [];


    $query_brands = "SELECT * FROM vehicle_brand";
    $query_models = "SELECT * FROM vehicle_model";
    $query_type = "SELECT * FROM tipo_vehiculo tv";

    $result  = $conn->mysqli->query($query_brands);
    while($data = $result->fetch_object()){
        $brands [] = $data;
    }

    $result  = $conn->mysqli->query($query_models);
    while($data = $result->fetch_object()){
        $models [] = $data;
    }
    $result  = $conn->mysqli->query($query_type);
    while($data = $result->fetch_object()){
        $type [] = $data;
    }

    $conn->desconectar();
    return json_encode(array("brands"=>$brands, "models"=>$models,"types"=>$type));
}


function insertVehicle($request, $empresa_id){
    $conn = new bd();
    $conn->conectar();

    if($request->type === "" || $request->type === null ){ $request->type = "NULL";}
    if($request->brand === "" || $request->brand === null ){ $request->brand = "NULL";}
    if($request->model === "" || $request->model === null ){ $request->model = "NULL";}
    if($request->patente === "" || $request->patente === null ){ $request->patente = "NULL";}
    if($request->owner === "" || $request->owner === null ){ $request->owner = 0;}
    if($request->costPerTrip === "" || $request->costPerTrip === null ){ $request->costPerTrip = "NULL";}

    $queryInsert = "INSERT INTO vehiculo 
    (patente, IsDelete, empresa_id, ownCar, tripValue, tipoVehiculo_id, marca, modelo)
    VALUES('$request->patente', 0, $empresa_id, $request->owner, $request->costPerTrip, $request->type, $request->brand, $request->model);";

    if($conn->mysqli->query($queryInsert)){
        return json_encode(array("success"=>true,"message"=>"Vehículo ingresado exitosamente"));
    }else{
        
        return json_encode(array("error"=>true,"message"=>"Intente nuevamente"));
    }
}
function getVehicleInfoById($vehicle_id, $empresa_id){
    $conn = new bd();
    $conn->conectar();
    $vehicle_data = [];
    $vehicle_events = [];

    $queryGetVehicleInformation = "SELECT v.id ,v.patente,v.ownCar , vb.id as brand_id , vm.id as model_id , 
    tv.id as vehicle_type_id
    FROM vehiculo v
    LEFT JOIN vehicle_brand vb on vb.id = v.marca 
    LEFT JOIN vehicle_model vm on vm.id = v.modelo
    LEFT JOIN tipo_vehiculo tv on tv.id  = v.tipoVehiculo_id
    WHERE v.id  = $vehicle_id
    and v.empresa_id = $empresa_id;";

    $queryGetVehicleEvents = "SELECT p.* , phv.* FROM vehiculo v
    INNER JOIN proyecto_has_vehiculo phv on phv.vehiculo_id = v.id
    INNER JOIN proyecto p on p.id = phv.proyecto_id 
    WHERE phv.vehiculo_id  = $vehicle_id
    AND p.empresa_id = $empresa_id
    and v.empresa_id = $empresa_id;";

    if($response = $conn->mysqli->query($queryGetVehicleInformation)){
        while($data = $response->fetch_object()){
            $vehicle_data = $data;
        }
    }
    if($response = $conn->mysqli->query($queryGetVehicleEvents)){
        while($data = $response->fetch_object()){
            $vehicle_events [] = $data;
        }
    }


    return json_encode(array("success"=>true,"data"=>$vehicle_data,"events"=>$vehicle_events));  
}
?>