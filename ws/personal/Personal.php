<?php
if ($_POST) {
    require_once('../bd/bd.php');

    $json = file_get_contents('php://input');
    $data = json_decode($json);
    $action = $data->action;

    // Realiza la acción correspondiente según el valor de 'action'
    switch ($action) {
        case 'getPersonal':
            // Recibe el parámetro empresaId
            $empresaId = $data->empresaId;

            // Llama a la función getPersonal y devuelve el resultado
            $personal = getPersonal($empresaId);
            echo json_encode($personal);
            break;

        case 'deletePersonalDash':
            // Recibe el parámetro request
            $personal_id = $data->personal_id;
            $empresa_id = $data->empresa_id;

            // Llama a la función addtoProject y devuelve el resultado
            $response = deletePersonalDash($personal_id,$empresa_id);
            echo json_encode($response);
            break;
        case 'addPersonalToProject':
            // Recibe el parámetro request
            $request = $data->request;

            // Llama a la función addtoProject y devuelve el resultado
            $response = addPersonalToProject($request);
            echo json_encode($response);
            break;
        case 'setviatico':
            // Recibe el parámetro request
            $request = $data->request;
            // Llama a la función addtoProject y devuelve el resultado
            $response = setviatico($request);
            echo json_encode($response);
            break;
        case 'setArriendos':
            // Recibe el parámetro request
            $request = $data->request;
            // Llama a la función addtoProject y devuelve el resultado
            $response = setArriendos($request);
            echo json_encode($response);
            break;
        case 'SetTotalProject':
            // Recibe el parámetro request
            $request = $data->request;
            // Llama a la función SetTotalProject y devuelve el resultado
            $response = SetTotalProject($request);
            echo json_encode(["success"=>true]);
            break;
        case 'AddPersonal':
            // Recibe el parámetro request
            $request = $data->request;
            $empresaId = $data->empresaId;
            // Llama a la función SetTotalProject y devuelve el resultado
            $response = AddPersonal($request, $empresaId);
            echo json_encode($response);
            break;
        case 'getAvailablePersonal':
            // Recibe el parámetro request
            $request = $data->request;
            // Llama a la función getAvailablePersonal y devuelve el resultado
            $response = getAvailablePersonal($request);
            echo json_encode($response);
            break;
        case 'GetPersonalByEmpresa':
            // Recibe el parámetro request
            $empresa_id = $data->empresa_id;
            // Llama a la función getAvailablePersonal y devuelve el resultado
            $response = GetPersonalByEmpresa($empresa_id);
            echo json_encode($response);
            break;
        case 'AddEspecialidad':
            // Recibe el parámetro request
            $request = $data->request;
            $empresaId = $data->empresaId;
            // Llama a la función AddEspecialidad y devuelve el resultado
            $response = AddEspecialidad($request, $empresaId);
            echo json_encode($response);
            break;
        case 'AddCargo':
            // Recibe el parámetro request
            $request = $data->request;
            $empresaId = $data->empresaId;
            // Llama a la función AddCargo y devuelve el resultado
            $response = AddCargo($request, $empresaId);
            echo json_encode($response);
            break;
        case 'getEspecialidad':
            // Recibe el parámetro request
            $empresaId = $data->empresaId;
            // Llama a la función getEspecialidad y devuelve el resultado
            $response = getEspecialidad($empresaId);
            echo json_encode($response);
            break;
        case 'getCargo':
            // Recibe el parámetro request
            $empresaId = $data->empresaId;
            // Llama a la función getCargo y devuelve el resultado
            $response = getCargo($empresaId);
            echo json_encode($response);
            break;
        case 'getAllPersonalData':
            // Recibe el parámetro request
            $empresaId = $data->empresaId;
            // Llama a la función getAllPersonalData y devuelve el resultado
            $response = getAllPersonalData($empresaId);
            echo json_encode($response);
            break;
        case 'getAllContratos':
            // Llama a la función getAllContratos y devuelve el resultado
            $response = getAllContratos();
            // $response = "123123123123123123";

            echo json_encode($response);
            break;
        case 'dropAssigmentPersonal':
            // Recibe el parámetro request
            $idProject = $data->idProject;
            // Llama a la función dropAssigmentPersonal =>
            // devuelve los ids eliminados de las asignaciones
            $response = dropAssigmentPersonal($idProject);
            echo json_encode($response);
            break;
        case 'addPersonalMasiva':
            // Recibe el parámetro request
            $request = $data->request;
            $empresaId = $data->empresaId;
            // Llama a la función dropAssigmentPersonal =>
            // devuelve los ids eliminados de las asignaciones
            $response = addPersonalMasiva($request, $empresaId);
            echo json_encode($response);
            break;
        case 'getTakenPersonalByDateRange':
            // Recibe el parámetro jsonCreateProd
            $request = $data->request;
            $empresa_id = $data->empresa_id;
            // Llama a la función addProd y devuelve el resultado
            $response = getTakenPersonalByDateRange($request, $empresa_id);
            echo json_encode($response);
            break;
        case 'insertPersonal':
            // Recibe el parámetro jsonCreateProd
            $personalData = $data->personalData;
            $empresa_id = $data->empresa_id;
            // Llama a la función addProd y devuelve el resultado
            $response = insertPersonal($personalData, $empresa_id);
            echo json_encode($response);
            break;
        case 'getPersonalByBussiness':
            // Recibe el parámetro jsonCreateProd
            $empresa_id = $data->empresa_id;
            // Llama a la función addProd y devuelve el resultado
            $response = getPersonalByBussiness($empresa_id);
            echo json_encode($response);
            break;
        case 'insertPersonalForm':
            $request = $data->request;
            $empresa_id = $data->empresa_id;
            $response = insertPersonalForm($request, $empresa_id);
            echo json_encode($response);
            break;
        case 'getPersonalById':
            $personal_id = $data->personal_id;
            $empresa_id = $data->empresa_id;
            $response = getPersonalById($personal_id, $empresa_id);
            echo json_encode($response);
            break;
        case 'getPersonalById_quotes':
            $personal_id = $data->personal_id;
            $empresa_id = $data->empresa_id;
            $response = getPersonalById_quotes($personal_id, $empresa_id);
            echo json_encode($response);
            break;
        case 'updatePersonal':
            $request = $data->request;
            $empresa_id = $data->empresa_id;
            $response = updatePersonal($request, $empresa_id);
            echo json_encode($response);
            break;
        case 'deleteEspecialidad':
            $especialidad_id = $data->especialidad_id;
            $empresa_id = $data->empresa_id;
            $response =  deleteEspecialidad($especialidad_id, $empresa_id);
            echo json_encode($response);
            break;
        case 'deleteCargo':
            $cargo_id = $data->cargo_id;
            $empresa_id = $data->empresa_id;
            $response = deleteCargo($cargo_id, $empresa_id);
            echo json_encode($response);
            break;
        default:
            echo 'Invalid action.';
            break;
    }
} else {
    require_once('./ws/bd/bd.php');
}

function AddPersonal($request, $empresaId)
{
    $conn = new bd();
    $conn->conectar();
    $today = date('Y-m-d');

    foreach ($request as $req) {
        $nombre = $req->nombre;
        $apellido = $req->apellido;
        $rut = $req->rut;
        $correo = $req->correo;
        $telefono = $req->telefono;
        $neto = $req->neto;
        $especialidad = $req->especialidad;
        $idContrato = $req->idContrato;
        $cargo = $req->cargo;
    }

    $queryPersona = "INSERT INTO persona
    (nombre, apellido, rut, telefono, email)
    VALUES('" . $nombre . " ', '" . $apellido . "', '" . $rut . "', '" . $telefono . "', '" . $correo . "')";

    $conn->mysqli->query($queryPersona);
    $idPersona = $conn->mysqli->insert_id;

    $queryInsert = "INSERT INTO personal
    (persona_id, cargo_id, especialidad_id, tipo_contrato_id, createAt, IsDelete, empresa_id,neto)
    VALUES(" . $idPersona . "," . $cargo . "," . $especialidad . "," . $idContrato . ",'" . $today . "', 0, $empresaId, $neto)";

    // return $queryInsert;

    if ($conn->mysqli->query($queryInsert)) {
        $conn->desconectar();
        return array("success" => array("message" => "Se ha ingresado a " . $nombre . " " . $apellido . " al sistema"));
    } else {
        $conn->desconectar();
        return array("error" => array("message" => "No se ha podido ingresar a " . $nombre . " " . $apellido . " al sistema"));
    }
}


function deletePersonalDash($personal_id,$empresa_id){
    try  {

        if(!viewIfPersonalOnBussieness($personal_id,$empresa_id)){
            return ['error', 'message'=>'personal has not been found'];
        }   
        $now = date('Y-m-d H:i:s');
        $conn = new bd();
        $conn->conectar();
        $mysqli = $conn->mysqli;
        $stmt = $mysqli->prepare("UPDATE personal SET IsDelete = 1 , deleteAt = ? WHERE id = ?");
        $stmt->bind_param("si",$now, $personal_id);
        $stmt->execute();
        $conn->desconectar();

        // return $stmt->affected_rows;

        if($stmt->affected_rows > 0){
            return true;
        }

        return false;

    } catch (Exception $e) {
        $conn->desconectar();
        return 'error while deleting personal';
    }
}

function viewIfPersonalOnBussieness($personal_id,$empresa_id){
    try {
        $conn = new bd();
        $conn->conectar();
        $mysqli = $conn->mysqli;
        $stmt = $mysqli->prepare("SELECT * FROM personal p WHERE p.empresa_id  = ? AND  p.id = ?;");
        $stmt->bind_param("ii", $empresa_id,$personal_id);
        $stmt->execute();

        $results = $stmt->get_result();
        
        $conn->desconectar();
        if($results->num_rows > 0){
            return true;
        }
        return false;
    } catch (Exception $e) {
        $conn->desconectar();
        return ['message'=>'error in view PERSONAL On Bussiness petition'];
    }
}

function setviatico($request)
{
    $conn = new bd();
    $conn->conectar();
    $arrayResponse = [];

    foreach ($request as $req) {
        $idProject = $req->idProject;
    }
    
    $queryIfAssigned = "SELECT * from personal_has_proyecto php where php.proyecto_id = $idProject";

    if ($conn->mysqli->query($queryIfAssigned)->num_rows > 0) {
        $qdelete = "DELETE FROM proyecto_has_viatico WHERE proyecto_id =$idProject";
        $conn->mysqli->query($qdelete);
    }
    foreach ($request as $req) {
        $idProject = $req->idProject;
        $valor = $req->valor;
        $detalle = $req->detalle;

        $queryInsertViatico = "INSERT INTO viatico (detalle,valor) VALUES ('$detalle','$valor')";

        $conn->mysqli->query($queryInsertViatico);

        $viaticoId = $conn->mysqli->insert_id;

        $query = "INSERT INTO proyecto_has_viatico
                    (proyecto_id, viatico_id)
                    VALUES($idProject, $viaticoId)";

        if ($conn->mysqli->query($query)) {

            array_push($arrayResponse, array("Asignado" => array("id" => $valor)));
        } else {

            array_push($arrayResponse, array("NoAsignado" => array("id" => $valor)));
        }
    }
    $conn->desconectar();
    return $arrayResponse;
}
function setArriendos($request)
{
    $conn = new bd();
    $conn->conectar();
    $arrayResponse = [];

    foreach ($request as $req) {
        $idProject = $req->idProject;
    }

    $queryIfAssigned = "SELECT * from arriendos_proyectos php where php.proyecto_id = $idProject";

    if ($conn->mysqli->query($queryIfAssigned)->num_rows > 0) {
        $qdelete = "DELETE FROM arriendos_proyectos WHERE proyecto_id =$idProject";
        $conn->mysqli->query($qdelete);
    }

    foreach ($request as $req) {
        $idProject = $req->idProject;
        $valor = $req->valor;
        $detalle = $req->detalle;

        $query = "INSERT INTO arriendos_proyectos
                (proyecto_id, detalle_arriendo, valor)
                VALUES($idProject, '" . $detalle . "', " . intval($valor) . ")";

        if ($conn->mysqli->query($query)) {

            array_push($arrayResponse, array("Asignado" => array("id" => $valor)));
        } else {

            array_push($arrayResponse, array("NoAsignado" => array("id" => $valor)));
        }
    }
    $conn->desconectar();
    return $arrayResponse;
}

function SetTotalProject($request)
{
    $conn = new bd();
    $conn->conectar();
    $today = date('Y-m-d');

    // return json_encode($request);

    foreach ($request as $req) {
        $idProject = $req->idProject;
    }

    $queryIfTotal = "SELECT * FROM ingresos_has_proyecto WHERE proyecto_id =  $idProject";

    if ($conn->mysqli->query($queryIfTotal)->num_rows > 0) {
        $qdelete = "DELETE FROM ingresos_has_proyecto WHERE proyecto_id = $idProject";
        $conn->mysqli->query($qdelete);
    }

    foreach ($request as $req) {

        $queryInsertIngreso = "INSERT INTO ingresos (ingreso, monto)
        VALUES('Ingreso Cobro Evento', " . intval($req->valor) . ")";

        $conn->mysqli->query($queryInsertIngreso);
        $idIngreso = $conn->mysqli->insert_id;

        $queryInsertTotal = "INSERT INTO u136839350_intec.ingresos_has_proyecto
        (ingresos_id, proyecto_id, fecha)
        VALUES($idIngreso, $req->idProject, '$today')";

        $conn->mysqli->query($queryInsertTotal);

        
    }
}

function getAvailablePersonal($request)
{
    $conn = new bd();
    $conn->conectar();
    $personal = [];

    $empresaId = $request->empresaId;
    $fechaInicio = $request->fechaInicio;
    $fechaTermino = $request->fechaTermino;

    $queryPersonal = "SELECT  p.id, p.cargo_id, CONCAT(per.nombre ,' ',per.apellido) as nombre,
                            c.cargo, e.especialidad, p.neto, tc.contrato
                            FROM personal p
                        INNER JOIN persona per on per.id = p.persona_id 
                        INNER JOIN cargo c on c.id  = p.cargo_id 
                        INNER JOIN especialidad e on e.id  = p.especialidad_id 
                        INNER JOIN empresa emp on emp.id = p.empresa_id 
                        INNER JOIN tipo_contrato tc on tc.id = p.tipo_contrato_id 
                        LEFT JOIN  personal_has_proyecto php  on php.personal_id  = per.id
                        LEFT JOIN proyecto pro on p.id = php.proyecto_id
                        LEFT JOIN proyecto_has_estado phe on phe.proyecto_id = pro.id
                        where pro.id IS NULL or phe.estado_id != 2
                        or '" . $fechaInicio . "' < pro.fecha_inicio and '" . $fechaTermino . "' < pro.fecha_inicio 
                        or '" . $fechaInicio . "' > pro.fecha_termino and '" . $fechaTermino . "' > pro.fecha_termino
                        and p.empresa_id = $empresaId";



    if ($responseBdVehiculos = $conn->mysqli->query($queryPersonal)) {
        while ($dataVehiculos = $responseBdVehiculos->fetch_object()) {
            $personal[] = $dataVehiculos;
        }
    }
    $conn->desconectar();
    return $personal;
}


function AddEspecialidad($request, $empresaId)
{

    $conn =  new bd();
    $conn->conectar();
    $arrayIdsInserted = [];
    $today = date('Y-m-d');

    // return count($request->arrayCategorias);
    for ($i = 0; $i < count($request->arrayCargos); $i++) {

        $queryInsertCargo = "INSERT INTO especialidad
        (especialidad, createAt, IsDelete, empresa_id)
        VALUES('" . trim($request->arrayCargos[$i]) . "', '" . $today . "', 0, $empresaId);";

        if ($conn->mysqli->query($queryInsertCargo)) {
            array_push($arrayIdsInserted, $conn->mysqli->insert_id);
        }
    }

    // return $queryInsertCargo;
    return $arrayIdsInserted;
}
function AddCargo($request, $empresaId)
{

    $conn =  new bd();
    $conn->conectar();
    $arrayIdsInserted = [];
    $today = date('Y-m-d');

    // return count($request->arrayCategorias);
    for ($i = 0; $i < count($request->arrayCargos); $i++) {

        $queryInsertCargo = "INSERT INTO cargo (cargo,empresa_id)
        VALUES('" . trim($request->arrayCargos[$i]) . "', $empresaId)";

        if ($conn->mysqli->query($queryInsertCargo)) {
            array_push($arrayIdsInserted, $conn->mysqli->insert_id);
        }
    }

    // return $queryInsertCargo;
    return $arrayIdsInserted;
}

function getEspecialidad($empresaId)
{

    $conn = new bd();
    $conn->conectar();
    $especialidades = [];
    $queryGetEspecialidad = "SELECT id, especialidad FROM especialidad e WHERE empresa_id = $empresaId and IsDelete = 0 OR IsDelete IS NULL";
    $responseBd = $conn->mysqli->query($queryGetEspecialidad);

    while ($dataEspecialidad = $responseBd->fetch_object()) {
        $especialidades[] = $dataEspecialidad;
    }
    $conn->desconectar();
    return array("especialidades" => $especialidades);
}
function getCargo($empresaId)
{

    $conn = new bd();
    $conn->conectar();
    $cargos = [];
    $queryGetCargo = "SELECT id, cargo FROM cargo  WHERE empresa_id = $empresaId and IsDelete = 0;";
    $responseBd = $conn->mysqli->query($queryGetCargo);

    while ($datosCargo = $responseBd->fetch_object()) {
        $cargos[] = $datosCargo;
    }
    $conn->desconectar();
    return array("cargos" => $cargos);
}

function getPersonal($empresaId){
    try{
        $conn = new bd();
        $conn->conectar();
        $personal =  [];
        $queryPersonal = "SELECT  p.id, p.cargo_id, CONCAT(per.nombre ,' ',per.apellido) as nombre,per.nombre as personalName,
                                c.cargo,per.rut, e.especialidad, p.neto, tc.contrato, p.IsDelete
                            FROM personal p
                            INNER JOIN persona per on per.id = p.persona_id 
                            LEFT JOIN cargo c on c.id  = p.cargo_id 
                            LEFT JOIN especialidad e on e.id  = p.especialidad_id 
                            INNER JOIN empresa emp on emp.id = p.empresa_id 
                            INNER JOIN tipo_contrato tc on tc.id = p.tipo_contrato_id 
                            WHERE emp.id = $empresaId ;";
                            // AND p.IsDelete = 0";
    
        if ($responseBd = $conn->mysqli->query($queryPersonal)) {
            while ($dataPersonal = $responseBd->fetch_object()) {
                $personal[] = $dataPersonal;
            }
        }
        $conn->desconectar();
        return $personal;
    }catch(Exception $e){
        return array("fatalError"=>true,"code"=>404);
    }

}

function getAllPersonalData($empresaId)
{
    $conn = new bd();
    $conn->conectar();
    $personal =  [];
    $queryPersonal = "SELECT  p.id, p.cargo_id, per.nombre, per.apellido, per.rut,per.email,c.cargo ,e.especialidad,
                        c.cargo, e.especialidad, p.neto, tc.contrato, per.telefono
                    FROM personal p
                    INNER JOIN persona per on per.id = p.persona_id 
                    INNER JOIN cargo c on c.id  = p.cargo_id 
                    INNER JOIN especialidad e on e.id  = p.especialidad_id 
                    INNER JOIN empresa emp on emp.id = p.empresa_id 
                    INNER JOIN tipo_contrato tc on tc.id = p.tipo_contrato_id 
                    where emp.id = $empresaId";

    if ($responseBd = $conn->mysqli->query($queryPersonal)) {
        while ($dataPersonal = $responseBd->fetch_object()) {

            $personal[] = $dataPersonal;
        }
    }

    $conn->desconectar();
    return $personal;
}

function addPersonalToProject($request)
{
    $conn = new bd();
    $conn->conectar();
    $arrayResponse = [];


    foreach (array_slice($request, 0, 1) as $req) {
        if (isset($req->idProject)) {

            $idProject = $req->idProject;
            $queryIfAssigned = "SELECT * from personal_has_proyecto php where php.proyecto_id = $idProject";

            if ($conn->mysqli->query($queryIfAssigned)->num_rows > 0) {

                $qdelete = "DELETE FROM personal_has_proyecto WHERE proyecto_id =$idProject";
                $conn->mysqli->query($qdelete);
            }
        }
    }
    foreach ($request as $req) {
        $idProject = $req->idProject;
        $idPersonal = $req->idPersonal;
        $costo = $req->cost;
        $worked_hours = $req->worked_hours;

        $query = "INSERT INTO personal_has_proyecto
                            (personal_id, proyecto_id,costo,worked_hours)
                            VALUES($idPersonal, $idProject,$costo,$worked_hours)";

        if ($conn->mysqli->query($query)) {

            array_push($arrayResponse, array("Asignado" => array("id" => $idPersonal)));
        } else {

            array_push($arrayResponse, array("NoAsignado" => array("id" => $idPersonal)));
        }
    }

    $conn->desconectar();
    return $arrayResponse;
}

function dropAssigmentPersonal($idProject)
{
    $conn = new bd();
    $conn->conectar();

    $queryIfAssigned = "SELECT * from personal_has_proyecto php where php.proyecto_id = $idProject";

    if ($conn->mysqli->query($queryIfAssigned)->num_rows > 0) {
        $qdelete = "DELETE FROM personal_has_proyecto WHERE proyecto_id =$idProject";
        $conn->mysqli->query($qdelete);
    }
    $deleted = $conn->mysqli->affected_rows;
    $conn->desconectar();
    return $deleted;
}

function getAllContratos()
{

    try{

        $conn = new bd();
        $conn->conectar();
        $contratos = [];
        $queryAllContratos = "SELECT * FROM tipo_contrato tc";
    
        if ($responseBd = $conn->mysqli->query($queryAllContratos)) {
            while ($dataContratos = $responseBd->fetch_object()) {
                $contratos[] = $dataContratos;
            }
        }
        $conn->desconectar();
        return $contratos;

    }catch(Exception $e){
        return array("fatalError"=>true,"code"=>400);
    }
}

function addPersonalMasiva($request, $empresaId)
{
    $conn =  new bd();
    $conn->conectar();
    $today = date('Y-m-d');

    $arrayNoCompleteData = [];
    $counterInserted = 0;


    foreach ($request as $key => $value) {
        $excelRow = $key + 1;
        $nombre = $value->nombre;
        $apellido = $value->apellido;
        $rut = $value->rut;
        $telefono = $value->telefono;
        $correo = $value->correo;
        $cargo = $value->cargo;
        $especialidad = $value->especialidad;
        $contrato = $value->contrato;
        $neto = $value->neto;
        $idEspecialidad = 0;
        $idCargo = 0;

        $queryPersona = "INSERT INTO persona
                        (nombre, apellido, rut, email, telefono)
                        VALUES('$nombre','', '$rut', '$correo', '$telefono')";

        $resposenBdPersona = $conn->mysqli->query($queryPersona);
        $idPersona = $conn->mysqli->insert_id;

        if($cargo !== "" ){

            $queryCargo = $conn->mysqli->query("SELECT id from cargo where LOWER(cargo)= LOWER('$cargo')");
            if ($queryCargo->num_rows > 0) {
    
                $idCargo = $queryCargo->fetch_object()->id;
            } else {
                array_push($arrayNoCompleteData, array('row' => $excelRow, 'problem' => "Cargo", "data" => array(
                    "nombre" => $nombre,
                    "apellido" => $apellido,
                    "rut" => $rut,
                    "telefono" => $telefono,
                    "correo" => $correo,
                    "cargo" => $cargo,
                    "especialidad" => $especialidad,
                    "contrato" => $contrato
                )));
            }
        }

        $especialidadq = $conn->mysqli->query('SELECT id from especialidad where LOWER(especialidad) ="' . strtolower($especialidad) . '"');

        if ($especialidadq->num_rows > 0) {
            $idEspecialidad = $especialidadq->fetch_object()->id;
        } else {
            array_push($arrayNoCompleteData, array('row' => $excelRow, 'problem' => "Especialidad", "data" => array(
                "nombre" => $nombre,
                "apellido" => $apellido,
                "rut" => $rut,
                "telefono" => $telefono,
                "correo" => $correo,
                "cargo" => $cargo,
                "especialidad" => $especialidad,
                "contrato" => $contrato
            )));
        }
        // return $arrayNoCompleteData;

        $contratoq = $conn->mysqli->query('SELECT id from tipo_contrato where LOWER(contrato) = "' . strtolower($contrato) . '"');

        if ($contratoq->num_rows > 0) {
            $value = $contratoq->fetch_object()->id;
            $idContrato = $value;
        } else {
            array_push($arrayNoCompleteData, array('row' => $excelRow, 'problem' => "Contrato", "data" => array(
                "nombre" => $nombre,
                "apellido" => $apellido,
                "rut" => $rut,
                "telefono" => $telefono,
                "correo" => $correo,
                "cargo" => $cargo,
                "especialidad" => $especialidad,
                "contrato" => $contrato
            )));
        }

        if ($idEspecialidad === 0){
            $conn->mysqli->query("DELETE FROM persona where id = $idPersona");
        } else {
            $query = "INSERT INTO personal
                (persona_id, cargo_id, especialidad_id, tipo_contrato_id, createAt, IsDelete, empresa_id,neto)
                VALUES($idPersona , $idCargo , $idEspecialidad , $idContrato ,'$today', 0, $empresaId, $neto)";

            if ($conn->mysqli->query($query)) {
                $counterInserted++;
            }
        }
    }

    if ($counterInserted === count($request)) {
        $conn->desconectar();
        return array("success" => array("inserted" => $counterInserted, "total" => count($request)));
    } else {
        $conn->desconectar();
        return array('error' => array("inserted" => $counterInserted, 'total' => count($request), 'arrErr' => $arrayNoCompleteData));
    }
}


function GetPersonalByEmpresa($empresa_id){


    try{

        $conn =  new bd();
        $conn->conectar();
        $personal = [];
    
        $queryGetPersonal = "SELECT CONCAT(per.nombre,' ',per.apellido) as nombre, p.id as personal_id,per.email FROM personal p
        INNER JOIN persona per ON per.id = p.persona_id 
        LEFT JOIN usuario u ON u.id = p.usuario_id 
        WHERE u.id is NULL AND p.empresa_id  = $empresa_id";
    
        if ($responseDb = $conn->mysqli->query($queryGetPersonal)) {
            while ($dataPersonal = $responseDb->fetch_object()) {
                $personal[] = $dataPersonal;
            }
            $conn->desconectar();
            return array("success" => true, "data" => $personal);
        } else {
            $conn->desconectar();
            return array('error' => true, "message" => "No se ha podido completar la solicitud, por favor intente nuevamente");
        }
    }catch(Exception $e){
        return array('datalError' => true, "code" => 400);
        
    }
}




function getTakenPersonalByDateRange($request, $empresa_id)
{
    $conn = new bd();
    $conn->conectar();

    $fecha_inicio = $request->data->fecha_inicio;
    $fecha_termino = $request->data->fecha_termino;

    $unavailablePersonal = [];


    $queryGetUnavailables = "SELECT php.personal_id , php.proyecto_id , php.costo , phe.*
    from personal_has_proyecto php 
    INNER JOIN proyecto p ON p.id = php.proyecto_id
    INNER JOIN proyecto_has_estado phe on phe.proyecto_id = p.id
    WHERE phe.estado_id = 2
    AND p.fecha_inicio >= '$fecha_inicio' AND p.fecha_inicio <= '$fecha_termino'
    OR p.fecha_termino >= '$fecha_inicio' AND p.fecha_termino <= '$fecha_termino'
    AND p.empresa_id = $empresa_id";

    // return $queryGetUnavailables;

    if ($responseDb = $conn->mysqli->query($queryGetUnavailables)) {

        while ($dataDb = $responseDb->fetch_object()) {
            $unavailablePersonal[] = $dataDb;
        }
        $conn->desconectar();
        return array("success" => true, "data" => $unavailablePersonal);
    } else {

        $conn->desconectar();
        return array("error" => true, "data" => $unavailablePersonal);
    }
}


function insertPersonal($request, $empresa_id)
{
    $conn = new bd();
    $conn->conectar();
    $today = date('Y-m-d');

    // return json_encode($request);

    foreach ($request as $req) {
        $nombre = $req->nombre;
        $rut = $req->rut;
        $correo = $req->correo;
        $telefono = $req->telefono;
        $especialidad = $req->especialidad;
    }
    $queryPersona = "INSERT INTO persona
    (nombre, apellido, rut, telefono, email)
    VALUES('" . $nombre . " ', '', '" . $rut . "', '" . $telefono . "', '" . $correo . "')";

    $conn->mysqli->query($queryPersona);
    $idPersona = $conn->mysqli->insert_id;

    $queryInsert = "INSERT INTO personal
    (persona_id, especialidad_id, tipo_contrato_id, createAt, IsDelete, empresa_id,neto)
    VALUES(" . $idPersona . ",'" . $especialidad . "', 5 ,'" . $today . "', 0, $empresa_id, 0)";

    // return $queryInsert;
    if ($conn->mysqli->query($queryInsert)) {
        $idPersonal = $conn->mysqli->insert_id;
        $personal =  [];
        $queryPersonal = "SELECT  p.id, p.cargo_id, CONCAT(per.nombre ,' ',per.apellido) as nombre,
                                c.cargo,per.rut, e.especialidad, p.neto, tc.contrato
                            FROM personal p
                            INNER JOIN persona per on per.id = p.persona_id 
                            LEFT JOIN cargo c on c.id  = p.cargo_id 
                            INNER JOIN especialidad e on e.id  = p.especialidad_id 
                            INNER JOIN empresa emp on emp.id = p.empresa_id 
                            INNER JOIN tipo_contrato tc on tc.id = p.tipo_contrato_id 
                            where p.id = $idPersonal";

        if ($responseBd = $conn->mysqli->query($queryPersonal)) {
            while ($dataPersonal = $responseBd->fetch_object()) {
                $personal = $dataPersonal;
            }
        }

        $conn->desconectar();
        return array("success" => array("message" => "Se ha ingresado a " . $nombre . " al sistema"), "personalInserted" => $personal);
    } else {
        $conn->desconectar();
        return array("error" => array("message" => "No se ha podido ingresar a " . $nombre . " al sistema"));
    }
}


function getPersonalByBussiness($empresa_id)
{
    try{

        $conn  = new bd();
        $conn->conectar();
        $personal = [];
    
        $query = "SELECT *, p.id as personal_id FROM personal p
        left JOIN tipo_contrato tc on tc.id = p.tipo_contrato_id
        left join cargo c on c.id = p.cargo_id 
        left join especialidad e on e.id = p.especialidad_id 
        INNER JOIN persona per on per.id = p.persona_id
        where p.empresa_id = $empresa_id 
        and p.IsDelete = 0";
    
        if ($response = $conn->mysqli->query($query)) {
            while ($data = $response->fetch_object()) {
                $personal[] = $data;
            }
            $conn->desconectar();
            return array("success" => true, "data" => $personal);
        } else {
            $conn->desconectar();
            return array("error" => true);
        }
    }catch(Exception $e){
        return array("fataError"=>true,"code"=>400);
    }

}



function insertPersonalForm($request, $empresa_id)
{
    $conn  = new bd();
    $conn->conectar();
    $personal = [];
    $persona_id = 0;

    $today = date('Y-m-d');


    if ($request->nombrePersonal === "" || $request->nombrePersonal === null) {
        $request->nombrePersonal = "NULL";
    }
    if ($request->rutPersonal === "" || $request->rutPersonal === null) {
        $request->rutPersonal = "NULL";
    }
    if ($request->especialidadPersonal === "" || $request->especialidadPersonal === null) {
        $request->especialidadPersonal = "NULL";
    }
    if ($request->cargoPersonal === "" || $request->cargoPersonal === null) {
        $request->cargoPersonal = "NULL";
    }
    if ($request->tipoContratoPersonal === "" || $request->tipoContratoPersonal === null) {
        $request->tipoContratoPersonal = "NULL";
    }
    if ($request->costoMensualPersonal === "" || $request->costoMensualPersonal === null) {
        $request->costoMensualPersonal = 0;
    }
    if ($request->correoPersonal === "" || $request->correoPersonal === null) {
        $request->correoPersonal = "NULL";
    }
    if ($request->telefonoPersonal === "" || $request->telefonoPersonal === null) {
        $request->telefonoPersonal = "NULL";
    }

    $queryPersona = "INSERT INTO u136839350_intec.persona 
    ( nombre, apellido, rut, email, telefono) 
    VALUES('$request->nombrePersonal', '', '$request->rutPersonal', '$request->correoPersonal', $request->telefonoPersonal);";

    if ($response = $conn->mysqli->query($queryPersona)) {
        $persona_id = $conn->mysqli->insert_id;
    } else {
        $conn->desconectar();
        return array("error" => true, "message" => "Ha ocurrido un error,intente nuevamente");
    }

    $query = "INSERT INTO u136839350_intec.personal 
    ( persona_id, usuario_id, neto, cargo_id, especialidad_id, tipo_contrato_id, createAt, IsDelete, empresa_id) 
    VALUES( $persona_id, NULL, $request->costoMensualPersonal, $request->cargoPersonal, $request->especialidadPersonal,
    $request->tipoContratoPersonal, '$today', 0,  $empresa_id);";

    if ($conn->mysqli->query($query)) {
        $conn->desconectar();
        return array("success" => true, "message" => "Técnico creado exitosamente");
    } else {
        $conn->mysqli->query("DELETE FROM persona where id = $persona_id");
        $conn->desconectar();
        return array("error" => true);
    }
}


function getPersonalById_quotes($personal_id, $empresa_id){

    $conn = new bd();
    $conn->conectar();
    $mysqli = $conn->mysqli;
    $personalData = [];

    
    try{
        $stmt = $mysqli->prepare("SELECT p.*, per.*,df.direccion 
        FROM personal p
        INNER JOIN persona per ON per.id  = p.persona_id 
        INNER JOIN empresa e on e.id = p.empresa_id 
        INNER JOIN datos_facturacion df on df.id = e.datos_facturacion_id 
        WHERE p.id = ?
        AND p.empresa_id = ?;");    
        $stmt->bind_param("ii",$personal_id,$empresa_id);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($data = $result->fetch_object()) {
            $personalData = $data;
        }
        $conn->desconectar();
        return $personalData;
    }catch(Exception $err ){
        $conn->desconectar();
        return array("error"=>true);
    }
}

function getPersonalById($personal_id, $empresa_id)
{
    $conn  = new bd();
    $conn->conectar();
    $personalData = [];
    $personal_events = [];

    $queryPersonalData = "SELECT *,tc.id as tipo_contrato_id from personal p 
    inner join persona per on per.id = p.persona_id 
    inner join especialidad e on e.id = p.especialidad_id  
    left join tipo_contrato tc on tc.id = p.tipo_contrato_id 
    left join cargo c on c.id = p.cargo_id 
    where p.id = $personal_id
    and p.empresa_id  = $empresa_id";

    $queryEventsPersonal = "SELECT * from proyecto p 
    inner join personal_has_proyecto php on php.proyecto_id  = p.id 
    inner join personal per on per.id = php.personal_id 
    inner join estado e on e.id = p.status_id
    where per.id = $personal_id
    and p.empresa_id = $empresa_id";

    if ($response = $conn->mysqli->query($queryPersonalData)) {
        while ($data = $response->fetch_object()) {
            $personalData = $data;
        }

        if ($response = $conn->mysqli->query($queryEventsPersonal)) {

            while ($data = $response->fetch_object()) {
                $personal_events []= $data;
            }
            $conn->desconectar();
            return array("success" => true, "data" => $personalData, "events" => $personal_events);
        } else {
            $conn->desconectar();
            return array("error" => true, "message" => "No se ha podido completar la solicitud,  intente nuevamente");
        }
    } else {
        $conn->desconectar();
        return array("error" => true, "message" => "No se ha podido completar la solicitud,  intente nuevamente");
    }
}

function updatePersonal($request, $empresa_id)
{
    $conn  = new bd();
    $conn->conectar();

    $today = date("Y-m-d");

    if ($request->update_nombrePersonal === "" || $request->update_nombrePersonal === null) {
        $request->update_nombrePersonal = "";
    }
    if ($request->update_rutPersonal === "" || $request->update_rutPersonal === null) {
        $request->update_rutPersonal = "";
    }
    if ($request->update_especialidadPersonal === "" || $request->update_especialidadPersonal === null) {
        $request->update_especialidadPersonal = "";
    }
    if ($request->update_cargoPersonal === "" || $request->update_cargoPersonal === null) {
        $request->update_cargoPersonal = "";
    }
    if ($request->update_tipoContratoPersonal === "" || $request->update_tipoContratoPersonal === null) {
        $request->update_tipoContratoPersonal = "";
    }
    if ($request->update_costoMensualPersonal === "" || $request->update_costoMensualPersonal === null) {
        $request->update_costoMensualPersonal = "";
    }
    if ($request->update_correoPersonal === "" || $request->update_correoPersonal === null) {
        $request->update_correoPersonal = "";
    }
    if ($request->update_telefonoPersonal === "" || $request->update_telefonoPersonal === null) {
        $request->update_telefonoPersonal = "";
    }

    $queryUpdatePersona = "UPDATE u136839350_intec.persona 
    SET nombre='$request->update_nombrePersonal',
     apellido='',
     rut='$request->update_rutPersonal',
     email='$request->update_correoPersonal', 
     telefono='$request->update_telefonoPersonal' 
     WHERE id = $request->persona_id;";
    if (!$conn->mysqli->query($queryUpdatePersona)) {
        return array("error" => true, "message" => "Intente nuevamente");
    }


    $queryUpdatePersonal = "UPDATE u136839350_intec.personal 
    SET neto=$request->update_costoMensualPersonal,
    modifiedAt='$today',
    tipo_contrato_id = $request->update_tipoContratoPersonal,
    especialidad_id = $request->update_especialidadPersonal,
    cargo_id = $request->update_cargoPersonal
    WHERE id=$request->personal_id 
    AND persona_id=$request->persona_id
    AND empresa_id=$empresa_id;";

    if ($conn->mysqli->query($queryUpdatePersonal)) {
        $conn->desconectar();
        return array("success" => true, "message" => "Técnico modificado exitosamente");
    } else {
        $conn->desconectar();
        return array("error" => true, "message" => "Intente nuevamente");
    }
}

function deleteEspecialidad($especialidad_id, $empresa_id){
    $conn  = new bd();
    $conn->conectar();

    $queryUpdateEspecialidad = "UPDATE especialidad set IsDelete = 1 where id = $especialidad_id and empresa_id = $empresa_id";


    if($conn->mysqli->query($queryUpdateEspecialidad)){
        
        if($conn->mysqli->affected_rows > 0){
            $conn->desconectar();
            return array("success"=>true,"message"=>"Especialidad eliminada exitosamente");
        }else{
            $conn->desconectar();
            return array("error"=>true,"message"=>"Ha ocurrido un error, intente nuevamente");
        }
    }else{
        $conn->desconectar();
        return array("error"=>true,"message"=>"Ha ocurrido un error, intente nuevamente");
    }
}
function deleteCargo($cargo_id, $empresa_id){
    $conn  = new bd();
    $conn->conectar();

    $queryUpdateCargo = "UPDATE cargo set IsDelete = 1 where id = $cargo_id and empresa_id = $empresa_id";
    

    if($conn->mysqli->query($queryUpdateCargo)){
        
        if($conn->mysqli->affected_rows > 0){
            $conn->desconectar();
            return array("success"=>true,"message"=>"Cargo eliminado exitosamente");
        }else{
            $conn->desconectar();
            return array("error"=>true,"message"=>"Ha ocurrido un error, intente nuevamenteee");
        }
    }else{
        $conn->desconectar();
        return array("error"=>true,"message"=>"Ha ocurrido un error, intente nuevamente");
    }
}
