<?php
if ($_POST) {
    require_once('../bd/bd.php');

    $json = file_get_contents('php://input');
    $data = json_decode($json);

    $action = $data->tipo;

    // Realiza la acción correspondiente según el valor de 'action'
    switch ($action) {
        case 'insertNewClient':
            $request = $data->request;
            $result = insertNewClient($request);
            break;
        case 'deleteClient':
            $client_id = $data->client_id;
            $empresa_id = $data->empresa_id;
            $result = deleteClient($client_id,$empresa_id);
            break;
        case 'addCliente':
            $request = $data->request;
            $result = addCliente($request);
            break;
        case 'AddClientForm':
            $request = $data->request;
            $empresa_id = $data->empresa_id;
            $result = AddClientForm($request, $empresa_id);
            break;
        case 'getCliente':
            $request = $data->request;
            $result = getClienteById($request);
            break;
        case 'getClientesByEmpresa':
            $request = $data->request;
            $result = json_encode(getClientesByEmpresa($request));
            break;
        case 'getClienteById':
            $request = $data->request;
            $result = getClienteById($request);
            break;
        case 'UpdateCliente':
            $request = $data->request;
            $result = UpdateCliente($request);
            break;
        case 'getClientData':
            $empresa_id = $data->empresa_id;
            $result = getClientData($empresa_id);
            break;
        case 'AddClientMasiva':
            $request = $data->request;
            $empresa_id = $data->empresa_id;
            $result = AddClientMasiva($request, $empresa_id);
            break;
        case 'getClientInformation':
            $cliente_id = $data->cliente_id;
            $result = getClientInformation($cliente_id, $empresa_id);
            break;
        case 'getClienteById_dataAndEvents':
            $cliente_id = $data->cliente_id;
            $empresa_id = $data->empresa_id;
            $result = getClienteById_dataAndEvents($cliente_id, $empresa_id);
            break;
        default:
            $result = false;
            break;
    }

    // Devolver la respuesta como JSON
    header('Content-Type: application/json');
    echo $result;
} else {
    require_once('./ws/bd/bd.php');
}



function insertNewClient($request){
    

    $conn = new bd();
    $conn->conectar();

    try{
        $empresaId = $request->empresaId;
        $clientNameorDesc = $request->clientNameorDesc;
        $clientRazonSocial = $request->clientRazonSocial;
        $clientRut = $request->clientRut;
        $clientContacto = $request->clientContacto;
        $clientCorreo = $request->clientCorreo;
        $clientTelefono = $request->clientTelefono;
    
    
        $queryInsertPersona = "INSERT INTO u136839350_intec.persona 
            (nombre,apellido, rut, email, telefono) 
            VALUES( '$clientContacto','','$clientRut','$clientCorreo','$clientTelefono');";
    
        $conn->mysqli->query($queryInsertPersona);
        $persona_id = $conn->mysqli->insert_id;
        $queryInsertDF = "INSERT INTO u136839350_intec.datos_facturacion 
            (razon_social,nombre_fantasia ,persona_contacto,rut) 
            VALUES('$clientRazonSocial','$clientNameorDesc','$clientContacto','$clientRut');";
    
        $conn->mysqli->query($queryInsertDF);
        $df_id = $conn->mysqli->insert_id;
    
        $queryCliente = "INSERT INTO cliente
            (datos_facturacion_id, persona_id_contacto, empresa_id)
            VALUES($df_id, $persona_id, $empresaId);";
    
        if ($conn->mysqli->query($queryCliente)) {
            $conn->desconectar();
            return json_encode(array("success" => true, "created" => true, "message" => "Cliente creado exitosamente"));
        } else {
            $conn->desconectar();
            return false;
        }
    }catch(Exception $err){
        $conn->desconectar();
        return array('error'=>true);
    }

   
}



function deleteClient($client_id,$empresa_id){
    try  {

        if(!viewIfClienteIsOnBussieness($client_id,$empresa_id)){
            return ['error', 'message'=>'client has not been found'];
        }   

        $conn = new bd();
        $conn->conectar();
        $mysqli = $conn->mysqli;
        $stmt = $mysqli->prepare("UPDATE cliente set isDelete = 1 where id = ?");
        $stmt->bind_param("i", $client_id);
        $stmt->execute();

        $results = $stmt->get_result();
        $conn->desconectar();


        if($stmt->affected_rows > 0){
            return true;
        }

        return false;

    } catch (Exception $e) {
        $conn->desconectar();
        return 'error while deleting client';
    }
}

function viewIfClienteIsOnBussieness($client_id,$empresa_id){
    try {
        $conn = new bd();
        $conn->conectar();
        $mysqli = $conn->mysqli;
        $stmt = $mysqli->prepare("SELECT id from cliente c where c.empresa_id = ? and c.id = ?");
        $stmt->bind_param("ii", $empresa_id,$client_id);
        $stmt->execute();

        $results = $stmt->get_result();
        
        $conn->desconectar();
        if($results->num_rows > 0){
            return true;
        }
        return false;
    } catch (Exception $e) {
        $conn->desconectar();
        return ['meesage'=>'error in view Cliente On Bussieness petition'];
    }
}

function addCliente($request)
{

    $conn = new bd();
    $conn->conectar();
    $clienteExist = "";
    // return json_encode($request);

    foreach ($request as $req) {
        if (isset($req->idCliente) && isset($req->idProject)) {
            $idCliente = $req->idCliente;
            $idProject = $req->idProject;
            $responseBdClienteId = $conn->mysqli->query("SELECT id FROM cliente c where c.id = $idCliente");
            $clienteExist = $responseBdClienteId->fetch_object()->id;
            if ($clienteExist !== "") {
                $conn->mysqli->query("UPDATE proyecto
                    SET cliente_id = $clienteExist
                    WHERE id = $idProject");
                return json_encode(array("idCliente" => $clienteExist));
            }
        }
        if (isset($req->idCliente) && !isset($req->idProject)) {
            $idCliente = $req->idCliente;
            $responseBdClienteId = $conn->mysqli->query("SELECT id FROM cliente c where c.id = $idCliente");
            $clienteExist = $responseBdClienteId->fetch_object()->id;
            if ($clienteExist !== "") {
                return json_encode(array("idCliente" => $clienteExist));
            }
        }
    }

    foreach ($request as $req) {

        $empresaId = $req->empresaId;
        $nombreCliente = $req->nombreCliente;
        $apellidos = $req->apellidos;
        $rutCliente = $req->rutCliente;
        $correoCliente = $req->correoCliente;
        $telefono = $req->telefono;
        $rut = $req->rut;
        $razonSocial = $req->razonSocial;
        $nombreFantasia = $req->nombreFantasia;
        $direccionDatosFacturacion = $req->direccionDatosFacturacion;
        $correoDatosFacturacion = $req->correoDatosFacturacion;

        $queryInsertPersona = "INSERT INTO persona
            (nombre, apellido, rut, email, telefono)
            VALUES('" . $nombreCliente . "', '" . $apellidos . "', '" . $rutCliente . "', '" . $correoCliente . "', '" . $telefono . "')";

        $conn->mysqli->query($queryInsertPersona);
        $idPer = $conn->mysqli->insert_id;

        $queryInsertDatosFacturacion = "INSERT INTO datos_facturacion
            (razon_social, nombre_fantasia, rut, direccion, correo)
            VALUES('" . $razonSocial . "', '" . $nombreFantasia . "', '" . $rut . "', '" . $direccionDatosFacturacion . "', '" . $correoDatosFacturacion . "');";
        $conn->mysqli->query($queryInsertDatosFacturacion);
        $idDf = $conn->mysqli->insert_id;

        $queryCliente = "INSERT INTO cliente
            (datos_facturacion_id, persona_id_contacto, empresa_id)
            VALUES($idDf, $idPer, $empresaId);";

        if ($conn->mysqli->query($queryCliente)) {
            $idCliente = $conn->mysqli->insert_id;
            return json_encode(array("idCliente" => $idCliente));
        } else {
            return false;
        }
    }
}




function AddClientForm($request, $empresa_id)
{
    $conn =  new bd();
    $conn->conectar();

    $clientData = [];
    $persona_id = 0;
    $df_id = 0;

    $empresaId = $request->empresaId;
    $clientNameorDesc = $request->clientNameorDesc;
    $clientRazonSocial = $request->clientRazonSocial;
    $clientRut = $request->clientRut;
    $clientContacto = $request->clientContacto;
    $clientCorreo = $request->clientCorreo;
    $clientTelefono = $request->clientTelefono;
    $clienteId = $request->clienteId;
    $updatepersona = $request->updatepersona;

    if ($updatepersona) {

        $querySelect = "SELECT p.id as persona_id, df.id as df_id FROM cliente c
            INNER JOIN persona p on p.id = c.persona_id_contacto 
            INNER JOIN datos_facturacion df on df.id = c.datos_facturacion_id 
            where c.id = $clienteId; ";


        if ($response = $conn->mysqli->query($querySelect)) {
            while ($data = $response->fetch_object()) {
                $clientData = $data;
            }
        }


        if (!isset($clientData->persona_id) || !isset($clientData->df_id)) {
            $queryInsertPersona = "INSERT INTO u136839350_intec.persona 
                (nombre,apellido, rut, email, telefono) 
                VALUES( '$clientContacto','','$clientRut','$clientCorreo','$clientTelefono');";

            $conn->mysqli->query($queryInsertPersona);
            $persona_id = $conn->mysqli->insert_id;
            $queryInsertDF = "INSERT INTO u136839350_intec.datos_facturacion 
                (razon_social,nombre_fantasia ,persona_contacto,rut) 
                VALUES('$clientRazonSocial','$clientNameorDesc','$clientContacto','$clientRut');";

            $conn->mysqli->query($queryInsertDF);
            $df_id = $conn->mysqli->insert_id;

            $queryCliente = "UPDATE cliente 
                SET datos_facturacion_id = $df_id, persona_id_contacto =$persona_id  WHERE id = $clienteId;";

            if ($conn->mysqli->query($queryCliente)) {
                $idCliente = $conn->mysqli->insert_id;
                $conn->desconectar();

                return json_encode(array("success" => true, "created" => false, "message" => "Cliente modificado exitosamente", "client_id" => $clienteId));
            } else {
                $conn->desconectar();
                return false;
            }
        }
        
        $persona_id = $clientData->persona_id;
        $df_id = $clientData->df_id;
        $queryUpdatePersona = "UPDATE persona SET nombre='$clientContacto',
             rut='$clientRut', email='$clientCorreo', telefono='$clientTelefono' WHERE id=$persona_id;";
        $conn->mysqli->query($queryUpdatePersona);
        $queryUpdateDatosFacturacion = "UPDATE datos_facturacion
            set razon_social = '$clientRazonSocial',
             persona_contacto =  '$clientContacto',
             nombre_fantasia = '$clientNameorDesc',
             rut = '$clientRut'
            WHERE id = $df_id;";
        $conn->mysqli->query($queryUpdateDatosFacturacion);
        $conn->desconectar();

        return json_encode(array("success" => true, "created" => false, "message" => "Cliente modificado exitosamente", "client_id" => $clienteId));
    } else {
        $queryInsertPersona = "INSERT INTO u136839350_intec.persona 
            (nombre,apellido, rut, email, telefono) 
            VALUES( '$clientContacto','','$clientRut','$clientCorreo','$clientTelefono');";

        $conn->mysqli->query($queryInsertPersona);
        $persona_id = $conn->mysqli->insert_id;
        $queryInsertDF = "INSERT INTO u136839350_intec.datos_facturacion 
            (razon_social,nombre_fantasia ,persona_contacto,rut) 
            VALUES('$clientRazonSocial','$clientNameorDesc','$clientContacto','$clientRut');";

        $conn->mysqli->query($queryInsertDF);
        $df_id = $conn->mysqli->insert_id;

        $queryCliente = "INSERT INTO cliente
            (datos_facturacion_id, persona_id_contacto, empresa_id)
            VALUES($df_id, $persona_id, $empresaId);";

        if ($conn->mysqli->query($queryCliente)) {
            $idCliente = $conn->mysqli->insert_id;
            $conn->desconectar();

            return json_encode(array("success" => true, "created" => true, "message" => "Cliente creado exitosamente", "client_id" => $idCliente));
        } else {
            $conn->desconectar();
            return false;
        }
    }
}

function AddClientMasiva($request, $empresa_id)
{
    $conn =  new bd();
    $conn->conectar();

    $regex = '/[^a-zA-Z0-9]/';
    foreach ($request as $key => $req) {
        # code...
        $nombre = preg_replace($regex, '', $req->nombre);
        $razonSocial = preg_replace($regex, '', $req->razonSocial);
        $rut = preg_replace($regex, '', $req->rut);
        $contacto = preg_replace($regex, '', $req->contacto);
        $correo = preg_replace($regex, '', $req->correo);
        $telefono = preg_replace($regex, '', $req->telefono);

        $queryInsertPersona = "INSERT INTO u136839350_intec.persona 
            (nombre,apellido, rut, email, telefono) 
            VALUES( '$contacto','','$rut','$correo','$telefono');";
        $conn->mysqli->query($queryInsertPersona);
        $persona_id = $conn->mysqli->insert_id;

        $queryInsertDF = "INSERT INTO u136839350_intec.datos_facturacion 
            (razon_social,nombre_fantasia ,persona_contacto,rut) 
            VALUES('$razonSocial','$nombre','$contacto','$rut');";
        $conn->mysqli->query($queryInsertDF);
        $df_id = $conn->mysqli->insert_id;

        $queryCliente = "INSERT INTO cliente
            (datos_facturacion_id, persona_id_contacto, empresa_id)
            VALUES($df_id, $persona_id, $empresa_id);";
        $conn->mysqli->query($queryCliente);
    }

    return json_encode(array("success" => true, "message" => "clients inserted succesfully"));
}

function getClientData($empresa_id)
{

    try {
        $conn =  new bd();
        $conn->conectar();
        $clientData = [];

        $queryGetClientData = "SELECT 
            c.id AS cliente_id ,
            CONCAT(p.nombre,' ',p.apellido) as nombre_persona,
            p.rut AS rut_persona, 
            p.email as cli_correo,
            p.telefono as cli_telefono,
            df.razon_social,
            df.nombre_fantasia,
            df.rut AS rut_df,
            df.direccion AS df_direccion,
            df.correo AS df_correo,
            df.persona_contacto,
            (SELECT COUNT(p.id) from proyecto p
            inner join cliente cli on cli.id = p.cliente_id 
            and p.cliente_id  = c.id 
            and p.empresa_id = $empresa_id) as event_quantity,
            (SELECT SUM(pfr.income) from project_finance_resume pfr
            inner join proyecto proy on proy.id = pfr.event_id
            and proy.cliente_id = c.id
            and proy.empresa_id = $empresa_id ) as totalPerClient
            FROM cliente c
            INNER JOIN datos_facturacion df on df.id = c.datos_facturacion_id 
            INNER JOIN persona p on p.id = c.persona_id_contacto 
            where c.empresa_id = $empresa_id
            and c.isDelete = 0";

        if ($responseDbClient = $conn->mysqli->query($queryGetClientData)) {
            while ($dataClient = $responseDbClient->fetch_object()) {
                $clientData[] = $dataClient;
            }
            $conn->desconectar();
            return json_encode(array("success" => true, "data" => $clientData));
        } else {
            $conn->desconectar();
            return json_encode(array("error" => true));
        }
    } catch (Exception $e) {
        return array("fatalError" => true, "message" => "No se ha podido completar la solicitud, intente nuevamente");
    }
}
function getClientesByEmpresa($request)
{

    $conn = new bd();
    $conn->conectar();
    $clientes = [];
    $empresaId = $request;


    $query = "SELECT CONCAT(p.nombre ,' ',p.apellido) as nombre_cliente ,c.id as cliente_id ,
        df.*    
        from cliente c 
        INNER JOIN persona p on p.id = c.persona_id_contacto 
        INNER JOIN datos_facturacion df on df.id = c.datos_facturacion_id 
        INNER JOIN empresa e on e.id = c.empresa_id 
        where e.id =  $empresaId
        and c.isDelete = 0";

    // return $query;

    if ($responseBd = $conn->mysqli->query($query)) {
        while ($dataResponse = $responseBd->fetch_object()) {
            $clientes[] = $dataResponse;
        }
    } else {
        return false;
    }
    return $clientes;
}
function getClienteById($request)
{
    $conn = new bd();
    $conn->conectar();
    $clientes = [];
    $clienteId = $request;

    $query = "SELECT c.id, df.nombre_fantasia, df.razon_social, df.rut, p.nombre, df.persona_contacto, p.email, df.correo, p.telefono
        FROM cliente c 
        LEFT JOIN persona p on p.id = c.persona_id_contacto 
        LEFT JOIN datos_facturacion df on df.id = c.datos_facturacion_id 
        WHERE c.id = $clienteId";

    if ($responseBd = $conn->mysqli->query($query)) {
        while ($dataResponse = $responseBd->fetch_object()) {
            $clientes[] = $dataResponse;
        }
    } else {
        return false;
    }
    return json_encode(array("cliente" => $clientes));
}

function UpdateCliente($request)
{
    $conn =  new bd();
    $conn->conectar();

    foreach ($request as $key => $req) {
        $idCliente = $req->idCliente;
        $nombreCliente = $req->nombreCliente;
        $apellidos = $req->apellidos;
        $rutCliente = $req->rutCliente;
        $correo = $req->correo;
        $telefono = $req->telefono;
        $rut = $req->rut;
        $razonSocial = $req->razonSocial;
        $nombreFantasia = $req->nombreFantasia;
        $direccionDatosFacturacion = $req->direccionDatosFacturacion;
        $correoDatosFacturacion = $req->correoDatosFacturacion;
    }

    $queryCliente = "SELECT * FROM cliente c where c.id = $idCliente";

    $responseBd = $conn->mysqli->query($queryCliente);

    while ($dataCliente = $responseBd->fetch_object()) {
        $idDatosFacturacion = $dataCliente->datos_facturacion_id;
        $idPersona = $dataCliente->persona_id_contacto;
    }

    $queryUpdateDatosFacturacion = "UPDATE datos_facturacion
        SET razon_social='" . $razonSocial . "', nombre_fantasia='" . $nombreFantasia . "', rut='" . $rut . "',
        direccion='" . $direccionDatosFacturacion . "', correo='" . $correoDatosFacturacion . "'
        WHERE id= $idDatosFacturacion";

    $queryUpdatePersona = "UPDATE persona
        SET nombre='" . $nombreCliente . "', apellido='" . $apellidos . "', rut='" . $rutCliente . "', email='" . $correo . "', telefono='" . $telefono . "'
        WHERE id= $idPersona";

    $conn->mysqli->query($queryUpdateDatosFacturacion);
    $conn->mysqli->query($queryUpdatePersona);
}

function getClientInformation($cliente_id)
{
    $conn =  new bd();
    $conn->conectar();
    $clientInfo = [];
    $events = [];

    $queryGetClientData = "SELECT  per.nombre, per.apellido, per.rut as rut_persona, per.email  as email_persona , per.telefono,
        df.rut as rut_razon_social, df.razon_social, df.nombre_fantasia, df.direccion,df.correo 
        FROM cliente c
        INNER JOIN datos_facturacion df on df.id = c.datos_facturacion_id 
        INNER JOIN persona per on per.id = c.persona_id_contacto 
        where c.id = $cliente_id";

    if ($responseDbClientInfo = $conn->mysqli->query($queryGetClientData)) {
        while ($dataCliente = $responseDbClientInfo->fetch_object()) {
            $clienteInfo[] = $dataCliente;
        }
        $conn->desconectar();
        return json_encode(array("success" => true, "data" => $clienteInfo));
    } else {
        $conn->desconectar();
        return json_encode(array("error" => true, "message" => "Ha ocurrido un error, por favor intente nuevamente"));
    }
}

function getClienteById_dataAndEvents($cliente_id, $empresa_id)
{
    $conn =  new bd();
    $conn->conectar();
    $clientInfo = [];
    $events = [];

    $queryGetClientData = "SELECT c.id as client_id, per.nombre, per.apellido, per.rut as rut_persona, per.email  as email_persona , per.telefono,
        df.rut as rut_razon_social, df.razon_social, df.nombre_fantasia, df.direccion,df.correo 
        FROM cliente c
        INNER JOIN datos_facturacion df on df.id = c.datos_facturacion_id 
        INNER JOIN persona per on per.id = c.persona_id_contacto 
        where c.id = $cliente_id
        and c.empresa_id = $empresa_id";

    $queryGetEventsByCliente = "SELECT * , p.id as event_id FROM proyecto p
        inner join cliente c on c.id = p.cliente_id
        left join project_finance_resume pfr on pfr.event_id  = p.id
        inner join estado e on e.id = p.status_id  
        where p.cliente_id = $cliente_id
        and p.empresa_id  = $empresa_id
        and c.empresa_id  = $empresa_id";


    if ($responseDbClientInfo = $conn->mysqli->query($queryGetClientData)) {
        while ($dataCliente = $responseDbClientInfo->fetch_object()) {
            $clienteInfo[] = $dataCliente;
        }
        if ($responseEventsClient = $conn->mysqli->query($queryGetEventsByCliente)) {
            while ($dataEventsClient = $responseEventsClient->fetch_object()) {
                $events[] = $dataEventsClient;
            }
        }
        $conn->desconectar();
        return json_encode(array("success" => true, "data" => $clienteInfo, "events" => $events));
    } else {
        $conn->desconectar();
        return json_encode(array("error" => true, "message" => "Ha ocurrido un error, por favor intente nuevamente"));
    }
}
