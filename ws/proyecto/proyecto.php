<?php

if ($_POST) {

    require_once('../bd/bd.php');

    $json = file_get_contents('php://input');
    $data = json_decode($json);
    $action = $data->action;

    // Realiza la acción correspondiente según el valor de 'action'
    switch ($action) {
        case 'addProject':
            $request = $data->request;
            $result = addProject($request);
            break;
        case 'insertOrUpdateEventData_json':
            $event_id = $data->event_id;
            $totalPerItem = $data->totalPerItem;
            $selectedProducts = $data->selectedProducts;
            $allSelectedPersonal = $data->allSelectedPersonal;
            $selectedVehicles = $data->selectedVehicles;
            $creditedBalance = $data->creditedBalance;
            $_subRentsToAssign = $data->_subRentsToAssign;
            $_allMyOtherCosts = $data->_allMyOtherCosts;
            $result = json_encode(insertOrUpdateEventData_json($event_id, $totalPerItem, $selectedProducts, $allSelectedPersonal, $selectedVehicles, $creditedBalance,$_subRentsToAssign,$_allMyOtherCosts));
            break;
        case 'getProjectResume':
            $request = $data->request;
            $result = getProjectResume($request);
            break;
        case 'getMyProjects':
            $request = $data->request;
            $result = json_encode(getMyProjects($request));
            break;
        case 'UpdateProjectData':
            $request = $data->request;
            $result = json_encode(UpdateProjectData($request));
            break;
        case 'UpdateProjectDataStatus':
            $idProject = $data->idProject;
            $result = UpdateProjectDataStatus($idProject);
            break;
        case 'GetAllMyProjects':
            $empresa_id = $data->empresaId;
            $result = json_encode(GetAllMyProjects($empresa_id));
            break;
        case 'getAllMyEvents_notDeleted':
            $empresa_id = $data->empresa_id;
            $result = json_encode(getAllMyEvents_notDeleted($empresa_id));
            break;
        case 'getAllCalendarEvents':
            $empresa_id = $data->empresa_id;
            $status_id = $data->status_id;
            $result = json_encode(getAllCalendarEvents($empresa_id, $status_id));
            break;
        case 'GetAllProjects':
            $empresa_id = $data->empresaId;
            $result = json_encode(GetAllProjects($empresa_id));
            break;
        case 'GetCalendarProjects':
            $empresa_id = $data->empresaId;
            $status = $data->status;
            $result = json_encode(GetCalendarProjects($empresa_id, $status));
            break;
        case 'GetEventsByClient':
            $cliente_id = $data->cliente_id;
            $result = json_encode(GetEventsByClient($cliente_id));
            break;
        case 'getAllMyProjects_list_toExecute':
            $empresa_id = $data->empresa_id;
            $result = json_encode(getAllMyProjects_list_toExecute($empresa_id));
            break;
        case 'updateProject':
            $empresa_id = $data->empresa_id;
            $request = $data->request;
            $event_id = $data->event_id;
            $result = json_encode(updateProject($empresa_id, $request, $event_id));
            break;
        case 'removeAddressFromEvent':
            $event_id = $data->event_id;
            $empresa_id = $data->empresa_id;
            $result = json_encode(removeAddressFromEvent($empresa_id, $event_id));
            break;
        case 'getAllMyEvents':
            $empresa_id = $data->empresa_id;
            $result = json_encode(getAllMyEvents($empresa_id));
            break;
        case 'getEventByStatus_id':
            $empresa_id = $data->empresa_id;
            $status_id = $data->status_id;
            $result = json_encode(getEventByStatus_id($empresa_id, $status_id));
            break;
        case 'getOperEvents':
            $empresa_id = $data->empresa_id;
            $result = json_encode(getOperEvents($empresa_id));
            break;
        case 'getSellsEvents':
            $empresa_id = $data->empresa_id;
            $result = json_encode(getSellsEvents($empresa_id));
            break;
        case 'getAdmEvents':
            $empresa_id = $data->empresa_id;
            $result = json_encode(getAdmEvents($empresa_id));
            break;
        case 'getDashResume':
            $empresa_id = $data->empresa_id;
            $result = json_encode(getDashResume($empresa_id));
            break;
        case 'insertOrUpdateIncomeAndCosts':
            $request = $data->request;
            $result = json_encode(insertOrUpdateIncomeAndCosts($request));
            break;
        case 'getEventsForDashboard':
            $request = $data->request;
            $empresa_id = $data->empresa_id;
            $result = json_encode(getEventsForDashboard($request, $empresa_id));
            break;
        case 'getTodayEvent':
            $result = json_encode(getTodayEvent());
            break;
        case 'getEventDay':
            $date = $data->date;
            $empresa_id = $data->empresa_id;
            $result = json_encode(getEventDay($empresa_id, $date));
            break;
        case 'getDeletedEvents':
            $empresa_id = $data->empresa_id;
            $result = json_encode(getDeletedEvents($empresa_id));
            break;
        case 'deleteEvent':
            $event_id = $data->event_id;
            $empresa_id = $data->empresa_id;
            $result = json_encode(deleteEvent($empresa_id, $event_id));
            break;
        case 'returnEventToList':
            $event_id = $data->event_id;
            $empresa_id = $data->empresa_id;
            $result = json_encode(returnEventToList($empresa_id, $event_id));
            break;
        case 'updateEventStatusFromEventList':
            $status_id = $data->status_id;
            $empresa_id = $data->empresa_id;
            $event_id = $data->event_id;
            $result = json_encode(updateEventStatusFromEventList($status_id,$empresa_id,$event_id));
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

function addProject($request)
{
    $conn = new bd();
    $conn->conectar();
    $today = date('Y-m-d');

    foreach ($request as $req) {

        $nombre_proyecto = $req->nombre_proyecto;
        $lugar_id = $req->lugar_id;
        $fecha_inicio = $req->fecha_inicio;
        $fecha_termino = $req->fecha_termino;
        $cliente_id = $req->cliente_id;
        $comentarios = $req->comentarios;
        $empresa_id = $req->empresa_id;
        $owner = $req->owner;
        $status_id = $req->status_id;
        $event_type_id = $req->event_type_id;
    }
    if ($lugar_id === "") {
        $lugar_id = "null";
    } else {
        $lugar_id = "'" . $lugar_id . "'";
    }
    if ($cliente_id === "") {
        $cliente_id = "null";
    } else {
        $cliente_id = "'" . $cliente_id . "'";
    }
    if ($fecha_inicio === "") {
        $fecha_inicio = "null";
    } else {
        $fecha_inicio = "'" . $fecha_inicio . "'";
    }
    if ($fecha_termino === "") {
        $fecha_termino = "null";
    } else {
        $fecha_termino = "'" . $fecha_termino . "'";
    }

    if ($event_type_id === "") {
        $event_type_id = "NULL";
    }
    if ($owner === "" || $owner === null) {
        $owner = "NULL";
    }

    $query = "INSERT INTO proyecto
            (nombre_proyecto, lugar_id, fecha_inicio, fecha_termino, createAt, IsDelete , cliente_id, empresa_id,comentarios,`owner`,status_id,event_type_id)
            VALUES('$nombre_proyecto',
            $lugar_id,
            $fecha_inicio,
            $fecha_termino,
            '$today',
            0,
            $cliente_id,
            $empresa_id,
            '$comentarios',
            $owner,
            $status_id,
            $event_type_id)";
    // return $query;
    if ($conn->mysqli->query($query)) {
        $id_project = $conn->mysqli->insert_id;

        $queryInsertEstado = "INSERT INTO u136839350_intec.proyecto_has_estado
        (proyecto_id, estado_id, fecha)
        VALUES($id_project, $status_id, '$today');";
        $conn->mysqli->query($queryInsertEstado);

        $conn->desconectar();
        return json_encode(array("id_project" => $id_project));
    } else {
        $conn->desconectar();
        return false;
    }
}


function insertOrUpdateEventData_json($event_id, $totalPerItem, $selectedProducts, $allSelectedPersonal, $selectedVehicles, $creditedBalance,$_subRentsToAssign,$_allMyOtherCosts)
{
    try {
        $conn = new bd();
        $conn->conectar();
        $mysqli = $conn->mysqli;

        $stmt = $mysqli->prepare("SELECT id FROM event_data ed where ed.event_id = ?");
        $stmt->bind_param("i", $event_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            return insertEventData_json($event_id, $totalPerItem, $selectedProducts, $allSelectedPersonal, $selectedVehicles, $creditedBalance,$_subRentsToAssign,$_allMyOtherCosts);
        }

        $conn->desconectar();
        return updateEvent_json($event_id, $totalPerItem, $selectedProducts, $allSelectedPersonal, $selectedVehicles,$creditedBalance,$_subRentsToAssign,$_allMyOtherCosts);
    } catch (Exception $e) {
        $conn->desconectar();
        return false;
    }
}


function insertEventData_json($event_id, $totalPerItem, $selectedProducts, $selectedPersonal, $selectedVehicles,$creditedBalance,$_subRentsToAssign,$_allMyOtherCosts)
{
    try {
        $conn = new bd();
        $conn->conectar();
        $mysqli = $conn->mysqli;
        $stmt = $mysqli->prepare("INSERT INTO u136839350_intec.event_data 
        (event_id, selected_prods_json, totalPerItem_json,selectedPersonal_json,selectedVehicles_json,creditedBalance,subRent_json,otherCost_json) VALUES
        (?, ?, ?,?,?,?,?,?);");

        $totalPerItem = json_encode($totalPerItem);


        if(count($selectedProducts) === 0){
            $selectedProducts = json_encode([]);
        }else{
            $selectedProducts = json_encode($selectedProducts);
        }
        if(count($selectedPersonal) === 0){
            $selectedPersonal = json_encode([]);
        }else{
            $selectedPersonal = json_encode($selectedPersonal);
        }
        if(count($selectedVehicles) === 0){
            $selectedVehicles = json_encode([]);
        }else{
            $selectedVehicles = json_encode($selectedVehicles);
        }

        $creditedBalance = json_encode($creditedBalance);


        $selectedProducts = json_encode($selectedProducts);
        $selectedPersonal = json_encode($selectedPersonal);
        $selectedVehicles = json_encode($selectedVehicles);
        $_subRentsToAssign = json_encode($_subRentsToAssign);
        $_allMyOtherCosts = json_encode($_allMyOtherCosts);


        $stmt->bind_param("isssssss",  $event_id, $selectedProducts, $totalPerItem, $selectedPersonal, $selectedVehicles,$creditedBalance,$_subRentsToAssign,$_allMyOtherCosts);
        $stmt->execute();
        $conn->desconectar();
        return true;
    } catch (Exception $e) {
        $conn->desconectar();
        return false;
    }
}

function updateEvent_json($event_id, $totalPerItem, $selectedProducts, $allSelectedPersonal, $selectedVehicles,$creditedBalance,$_subRentsToAssign,$_allMyOtherCosts)
{
    try {
        $conn = new bd();
        $conn->conectar();
        $mysqli = $conn->mysqli;
        $stmt = $mysqli->prepare("UPDATE u136839350_intec.event_data 
        SET selected_prods_json= ? , 
        totalPerItem_json= ?,
        selectedPersonal_json = ?,
        selectedVehicles_json = ?,
        creditedBalance = ?,
        subRent_json = ?,
        otherCost_json = ?
        WHERE event_id= ?;");

        $totalPerItem = json_encode($totalPerItem);
        $selectedProducts = json_encode($selectedProducts);

        $allSelectedPersonal = json_encode($allSelectedPersonal);
        $selectedVehicles = json_encode($selectedVehicles);
        $creditedBalance = json_encode($creditedBalance);
        $_subRentsToAssign = json_encode($_subRentsToAssign);
        $_allMyOtherCosts = json_encode($_allMyOtherCosts);

        $stmt->bind_param("sssssssi", $selectedProducts, $totalPerItem, $allSelectedPersonal, $selectedVehicles,$creditedBalance,$_subRentsToAssign,$_allMyOtherCosts,$event_id);
        $stmt->execute();
        $conn->desconectar();
        return true;
    } catch (Exception $e) {
        $conn->desconectar();
        return false;
    }
}

function getProjectResume($request)
{


    try {

        $conn = new bd();
        $conn->conectar();

        $empresa_id = $request->projectRequest->empresa_id;
        $event_id = $request->projectRequest->idProject;

        // return json_encode();// ->empresa_id; 

        // $queryGetEvent = "SELECT * FROM proyecto p WHERE p.id = $event_id AND p.empresa_id = $empresa_id;";
        $queryGetEvent = "SELECT p.empresa_id FROM proyecto p WHERE p.id = $event_id";
        // AND p.empresa_id = 2;
        if ($result = $conn->mysqli->query($queryGetEvent)) {
            while ($dataEvent = $result->fetch_object()) {
                $empresa_id_get[] = $dataEvent;
            }
            if (intval($empresa_id_get[0]->empresa_id) !== $empresa_id) {
                return json_encode(array("error" => true, "fatalError" => true));
            }
        } else {
            return json_encode(array("error" => true, "CannotAccessData" => true));
        }

        $asignadosV = [];
        $clienteAsignado = [];
        $schedules = [];
        $asignadosPer = [];
        $asignadosPro = [];
        $asignadosOtherProds = [];
        $assignedPackages = [];
        $projects = [];
        $viaticoAsignado = [];
        $arriendosasignados = [];
        $totalIngresos = [];
        $files = [];
        $comments = [];
        $comment_replies = [];
        $eventData_json = [];
        $event_quote = [];;
        $accountables = [];
        $otherCosts = [];
        $viewasignados = false;


        foreach ($request as $key => $value) {
            $idProject = $value->idProject;

            if (isset($value->asignados)) {
                $viewasignados = true;
            }
        }

        if ($viewasignados) {
            $queryVehiclesAsignados = "SELECT v.*, phv.*
        from vehiculo v 
        INNER JOIN proyecto_has_vehiculo phv ON phv.vehiculo_id = v.id 
        INNER JOIN proyecto p on p.id = phv.proyecto_id 
        WHERE p.id = $idProject";

            $queryPersonalAsignados = "SELECT p.id ,CONCAT(per.nombre,' ',per.apellido) as nombre,per.nombre as personalName,
        c.cargo , e.especialidad, php.costo, tc.contrato 
        from personal p 
        INNER JOIN persona per on per.id = p.persona_id 
        INNER JOIN personal_has_proyecto php on php.personal_id = p.id 
        INNER JOIN proyecto pro on pro.id  = php.proyecto_id 
        INNER JOIN cargo c on c.id = p.cargo_id 
        INNER JOIN especialidad e on e.id = p.especialidad_id 
        INNER JOIN tipo_contrato tc on tc.id = p.tipo_contrato_id 
        where pro.id = $idProject";

            // $queryClienteAssigned = "SELECT c.id ,per.nombre, per.apellido, per.rut, per.telefono,per.email,
            // df.razon_social, df.nombre_fantasia,df.rut as rut_df, df.direccion, df.correo
            // FROM proyecto p
            // INNER JOIN cliente c on c.id = p.cliente_id 
            // INNER JOIN persona per on per.id = c.persona_id_contacto 
            // INNER JOIN datos_facturacion df on df.id = c.datos_facturacion_id 
            // INNER JOIN empresa e on e.id = p.empresa_id 
            // WHERE p.id = $idProject";

            // $queryClienteAssigned = "SELECT c.id ,per.nombre, per.apellido, per.rut, per.telefono,per.email,
            // df.razon_social, df.nombre_fantasia,df.rut as rut_df, df.direccion, df.correo
            // FROM proyecto p
            // INNER JOIN cliente c on c.id = p.cliente_id 
            // INNER JOIN persona per on per.id = c.persona_id_contacto 
            // INNER JOIN datos_facturacion df on df.id = c.datos_facturacion_id 
            // INNER JOIN empresa e on e.id = p.empresa_id 
            // WHERE p.id = $idProject";

            $queryClienteAssigned = "SELECT 
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
            and p.cliente_id  = c.id) as event_quantity
            FROM cliente c
            INNER JOIN datos_facturacion df on df.id = c.datos_facturacion_id 
            INNER JOIN persona p on p.id = c.persona_id_contacto 
            INNER JOIN proyecto pro on pro.cliente_id = c.id
            where pro.id = $idProject";

            $queryGetEventSchedules = "SELECT * FROM event_has_schedules ehs WHERE ehs.event_id = $idProject;";

            $queryProductsAssigned = "SELECT p.nombre , p.precio_arriendo, p.id,php.cantidad  FROM proyecto_has_producto php 
            INNER JOIN producto p on p.id  = php.producto_id 
            WHERE php.proyecto_id = $idProject";

            $queryOtherProductsAssigned = "SELECT * FROM proyecto_has_otros_productos phop
            WHERE phop.project_id = $idProject;";

            $queryAssignedPackages = "SELECT * FROM proyecto_has_paquete php where php.proyecto_id = $idProject";

            $queryViaticosAssigned = "SELECT * from proyecto_has_viatico phv WHERE phv.proyecto_id = $idProject";

            $querySubarriendos = "SELECT proyecto_id, detalle, proveedor_id, valor
            FROM u136839350_intec.proyecto_has_sub_arriendos WHERE proyecto_id = $idProject;";

            $queryTotalIngresos = "SELECT * FROM ingresos_has_proyecto ihp 
            INNER JOIN ingresos i on i.id = ihp.ingresos_id 
            WHERE ihp.proyecto_id = $idProject";

            $queryAccountables = "SELECT * FROM u136839350_intec.proyecto_has_rendicion phr WHERE phr.event_id =  $idProject";
            $queryOtherCosts = "SELECT * FROM u136839350_intec.proyecto_has_other_costs phoc WHERE phoc.event_id =  $idProject";

            $queryFiles = "SELECT  * FROM proyecto_has_files phf 
            INNER JOIN file f on f.id = phf.file_id 
            WHERE phf.event_id = $idProject
            AND phf.isDelete = 0;";

            $queryComments = "SELECT ehc.*, c.*, c.id as comment_id,pers.nombre as user_name 
            FROM event_has_comment ehc 
            INNER JOIN comment c on c.id = ehc.comment_id  
            INNER JOIN proyecto p on p.id = ehc.event_id 
            INNER JOIN usuario u on u.id = c.post_user_id 
            INNER JOIN personal per on per.usuario_id = u.id
            INNER JOIN persona pers on pers.id = per.persona_id 
            WHERE p.id =  $event_id
            AND c.isDelete = 0
            ORDER BY c.post_date desc;";

            $queryComments_has_replies = "SELECT chr.*,c.*,pers.nombre as user_name  FROM comment_has_reply chr 
            INNER JOIN comment c on c.id = chr.reply_id
            INNER JOIN event_has_comment ehc on ehc.comment_id = chr.comment_id  
            INNER JOIN usuario u on u.id = c.post_user_id 
            INNER JOIN personal per on per.usuario_id = u.id
            INNER JOIN persona pers on pers.id = per.persona_id 
            WHERE ehc.event_id = $event_id
            AND c.isDelete = 0
            ORDER BY chr.comment_id , c.post_date ASC ";


            $queryEventData_json = "SELECT * FROM event_data ed where ed.event_id = $event_id ";
            // $queryEventData_json = "SELECT * FROM event_data ed where ed.event_id = $event_id ";
        }

        $queryProject = "   SELECT  p.nombre_proyecto, p.fecha_inicio, p.fecha_termino,p.comentarios,
        d.id as dirId, d.direccion, d.numero,
        d.dpto, d.postal_code,c.comuna,r.region, p.id, e.id as estado,
        p.event_type_id,p.owner
        FROM proyecto p 
        INNER JOIN estado e on e.id = p.status_id  
        LEFT JOIN direccion d on d.id = p.address_id
        LEFT JOIN comuna c ON c.id = d.comuna_id
        LEFT JOIN region r ON r.id = c.region_id
        WHERE p.id = $idProject";

        if ($responseBd = $conn->mysqli->query($queryProject)) {
            while ($dataProject = $responseBd->fetch_object()) {
                $projects[] = $dataProject;
            }
        }
        if ($viewasignados) {
            if ($responseBd = $conn->mysqli->query($queryVehiclesAsignados)) {
                while ($dataAsignadosV = $responseBd->fetch_object()) {
                    $asignadosV[] = $dataAsignadosV;
                }
            }
            if ($responseBd = $conn->mysqli->query($queryPersonalAsignados)) {
                while ($dataAsignadosPer = $responseBd->fetch_object()) {
                    $asignadosPer[] = $dataAsignadosPer;
                }
            }
            if ($responseBd = $conn->mysqli->query($queryProductsAssigned)) {
                while ($dataAsignadosPro = $responseBd->fetch_object()) {
                    $asignadosPro[] = $dataAsignadosPro;
                }
            }
            if ($responseBd = $conn->mysqli->query($queryOtherProductsAssigned)) {
                while ($dataAsignadosOthersProds = $responseBd->fetch_object()) {
                    $asignadosOtherProds[] = $dataAsignadosOthersProds;
                }
            }
            if ($responseBd = $conn->mysqli->query($queryAssignedPackages)) {
                while ($dataAssignedPackages = $responseBd->fetch_object()) {
                    $assignedPackages[] = $dataAssignedPackages;
                }
            }
            if ($responseBd = $conn->mysqli->query($queryClienteAssigned)) {
                while ($dataClienteAss = $responseBd->fetch_object()) {
                    $clienteAsignado[] = $dataClienteAss;
                }
            }
            if ($responseBd = $conn->mysqli->query($queryGetEventSchedules)) {
                while ($dataEventSchedules = $responseBd->fetch_object()) {
                    $schedules[] = $dataEventSchedules;
                }
            }
            if ($responseBd = $conn->mysqli->query($queryViaticosAssigned)) {
                while ($dataClienteAss = $responseBd->fetch_object()) {
                    $viaticoAsignado[] = $dataClienteAss;
                }
            }
            if ($responseBd = $conn->mysqli->query($querySubarriendos)) {
                while ($dataArriendos  = $responseBd->fetch_object()) {
                    $arriendosasignados[] = $dataArriendos;
                }
            }
            if ($responseBd = $conn->mysqli->query($queryTotalIngresos)) {
                while ($dataIngresos  = $responseBd->fetch_object()) {
                    $totalIngresos[] = $dataIngresos;
                }
            }
            if ($responseBd = $conn->mysqli->query($queryAccountables)) {
                while ($dataAccountables  = $responseBd->fetch_object()) {
                    $accountables[] = $dataAccountables;
                }
            }
            if ($responseBd = $conn->mysqli->query($queryOtherCosts)) {
                while ($dataOtherCosts  = $responseBd->fetch_object()) {
                    $otherCosts[] = $dataOtherCosts;
                }
            }
            if ($responseBd = $conn->mysqli->query($queryFiles)) {
                while ($dataFiles  = $responseBd->fetch_object()) {
                    $files[] = $dataFiles;
                }
            }
            if ($responseBd = $conn->mysqli->query($queryComments)) {
                while ($dataComments  = $responseBd->fetch_object()) {
                    $comments[] = $dataComments;
                }
            }
            if ($responseBd = $conn->mysqli->query($queryComments_has_replies)) {
                while ($dataComment_replies  = $responseBd->fetch_object()) {
                    $comment_replies[] = $dataComment_replies;
                }
            }
            if ($responseBd = $conn->mysqli->query($queryEventData_json)) {
                while ($dataEvent_json  = $responseBd->fetch_object()) {
                    $eventData_json[] = $dataEvent_json;
                }
            }
        }
        $conn->desconectar();
        return json_encode(array(
            "dataProject" => $projects,
            "asignados" => array(
                "vehiculos" => $asignadosV,
                "personal" => $asignadosPer,
                "cliente" => $clienteAsignado,
                "schedules" => $schedules,
                "productos" => $asignadosPro,
                "otherProds" => $asignadosOtherProds,
                "assignedPackages" => $assignedPackages,
                "viaticos" => $viaticoAsignado,
                "arriendos" => $arriendosasignados,
                "totalIngresos" => $totalIngresos,
                "accountables" => $accountables,
                "otherCosts" => $otherCosts,
                "files" => $files,
                "comments" => $comments,
                "comment_replies" => $comment_replies,
                "eventData_json" => $eventData_json,
                "event_quote" => $event_quote
            )
        ));
    } catch (Exception $e) {
        $conn->desconectar();
        return array('fatalError' => true, 'code' => 400);
    }
}

function getMyProjects($request)
{
    $conn = new bd();
    $conn->conectar();
    $empresaId = $request->empresaId;
    $status = $request->status;

    $projects = [];
    $queryProyectos = "SELECT p.id, p.nombre_proyecto, 
    CONCAT(per.nombre,' ', per.apellido) as nombreCliente, 
    CONCAT(d.direccion, ' ',d.numero,', ',co.comuna,', ',re.region) as direccion,
    p.fecha_inicio ,p.fecha_termino
            FROM proyecto p
    INNER JOIN proyecto_has_estado phe ON  phe.proyecto_id  = p.id 
    LEFT  JOIN lugar l on l.id = p.lugar_id 
    LEFT JOIN direccion d on d.id = l.direccion_id 
    LEFT JOIN cliente c on c.id  = p.cliente_id         
    LEFT JOIN persona per on per.id = c.persona_id_contacto
    LEFT JOIN comuna co on co.id = d.comuna_id 
    LEFT JOIN region re on re.id = co.region_id 
    where phe.estado_id = $status and p.empresa_id = $empresaId";
    if ($responseBd = $conn->mysqli->query($queryProyectos)) {
        while ($dataProject = $responseBd->fetch_object()) {
            $projects[] = $dataProject;
        }
    }
    return $projects;
}

function GetAllProjects($empresa_id)
{
    $conn = new bd();
    $conn->conectar();
    $allProjects = [];

    $queryGetAll = "SELECT p.id, p.nombre_proyecto, 
    CONCAT(per.nombre,' ', per.apellido) as nombreCliente, 
    CONCAT(d.direccion, ' ',d.numero,', ',co.comuna,', ',re.region) as direccion,
    p.fecha_inicio ,p.fecha_termino
    FROM proyecto p
    LEFT  JOIN lugar l on l.id = p.lugar_id 
    LEFT JOIN direccion d on d.id = l.direccion_id 
    LEFT JOIN cliente c on c.id  = p.cliente_id         
    LEFT JOIN persona per on per.id = c.persona_id_contacto
    LEFT JOIN comuna co on co.id = d.comuna_id 
    LEFT JOIN region re on re.id = co.region_id 
    where  p.empresa_id = $empresa_id";

    if ($responseBd = $conn->mysqli->query($queryGetAll)) {

        if ($responseBd->num_rows > 0) {
            while ($dataAllProjects = $responseBd->fetch_object()) {
                $allProjects[] = $dataAllProjects;
            }
            return array("status" => "success", "data" => $allProjects, "message" => "Se han encontrado" . $responseBd->num_rows . " eventos");
        } else {
            return array("status" => "success", "data" => $allProjects, "message" => "No se han encontrado eventos");
        }
    } else {
        return array("status" => "error", "data" => $allProjects, "message" => "No se ha podido completar el requerimiento, por favor intente nuevamente");
    }
}

function GetAllMyProjects($empresa_id)
{

    $conn =  new bd();
    $conn->conectar();
    $projects = [];

    $queryGetAllMyProjects = "SELECT p.id, 
                                p.nombre_proyecto, 
                                p.fecha_inicio, 
                                p.fecha_termino,
                                e.estado 
                            FROM proyecto p 
                            INNER JOIN proyecto_has_estado phe on phe.proyecto_id = p.id 
                            INNER JOIN estado e on e.id = phe.estado_id 
                            where p.empresa_id = $empresa_id";

    if ($responseBd = $conn->mysqli->query($queryGetAllMyProjects)) {
        while ($dataProjects = $responseBd->fetch_object()) {
            $projects[] = $dataProjects;
        }
        $conn->desconectar();
        return $projects;
    } else {
        $conn->desconectar();
        return array("error" => true, "message" => "NO DATA RECOVERED");
    }
}



function GetCalendarProjects($empresaId, $status)
{

    $conn =  new bd();
    $conn->conectar();
    $projects = [];
    $queryQuoteStatus = "";

    if ($status !== 0) {
        $queryQuoteStatus = "and phe.estado_id  = $status";
    }

    $queryGetAllMyProjects = "SELECT p.id, 
    p.nombre_proyecto, 
    p.fecha_inicio, 
    p.fecha_termino,
    e.estado 
    FROM proyecto p 
    INNER JOIN proyecto_has_estado phe on phe.proyecto_id = p.id 
    INNER JOIN estado e on e.id = phe.estado_id 
    where p.empresa_id = $empresaId $queryQuoteStatus";
    // return $queryGetAllMyProjects;

    if ($responseBd = $conn->mysqli->query($queryGetAllMyProjects)) {
        while ($dataProjects = $responseBd->fetch_object()) {
            $projects[] = $dataProjects;
        }
        return $projects;
    } else {
        return array("error" => true, "message" => "NO DATA RECOVERED");
    }
}

function UpdateProjectData($request)
{

    $conn =  new bd();
    $conn->conectar();

    // return $request;


    $idProject = $request->idProject;

    if (!isset($idProject)) {
        return array("error" => array("message" => "No has seleccionado eventos, elige uno antes de actualizarlo"));
    }

    $projectName = $request->txtProjectName;
    $fechaInicio = $request->fecha_inicio;
    $fechaTermino = $request->fecha_termino;
    $comentarios = $request->txtAreaComments;
    $today = date("Y-m-d");

    if ($idProject === "") {
        $idProject = "null";
    } else {
        $idProject = $idProject;
    }
    if ($projectName === "") {
        $projectName = "null";
    } else {
        $projectName = "'" . $projectName . "'";
    }
    if ($fechaInicio === '') {
        $fechaInicio = "null";
    } else {
        $fechaInicio = "'" . $fechaInicio . "'";
    }
    if ($fechaTermino === "") {
        $fechaTermino = "null";
    } else {
        $fechaTermino = "'" . $fechaTermino . "'";
    }
    if ($comentarios === "") {
        $comentarios = "null";
    } else {
        $comentarios = "'" . $comentarios . "'";
    }


    $queryUpdateProject = "UPDATE proyecto
                SET nombre_proyecto = $projectName, fecha_inicio = '$fechaInicio', 
                fecha_termino = '$fechaTermino', comentarios = $comentarios,
                modifiedAt = '" . $today . "'
                WHERE id= $idProject";

    // return $queryUpdateProject;

    if ($conn->mysqli->query($queryUpdateProject)) {
        $conn->desconectar();
        return array("success" => array("message" => "Evento modificado exitosamente"));
    } else {
        $conn->desconectar();
        return array("error" => array("message" => "No se ha podido actualizar el proyecto, por favor intente nuevamente"));
    }

    // $resultDatabase =  $conn->mysqli->query($queryUpdateProject);

    // while ($dataProject = $resultDatabase->fetch_object()) {
    //     $response[] = $dataProject;
    //     // $nombreProyecto = $dataProject["nombre_proyecto"];
    //     // $lugarId = $dataProject["lugar_id"];
    //     // $fecha_inicio = $dataProject["fecha_inicio"];
    //     // $fecha_termino = $dataProject["fecha_termino"];
    //     // $comentarios = $dataProject["comentarios"];
    //     // $clienteId = $dataProject["cliente_id"];
    // }

    // return json_encode($response);
    // return json_encode($dataProject);



}

function UpdateProjectDataStatus($idProject)
{
    $conn =  new bd();
    $conn->conectar();
    $queryUpdate = "UPDATE proyecto_has_estado set estado_id = estado_id + 1 where proyecto_id = $idProject";

    if ($conn->mysqli->query($queryUpdate)) {
        $conn->desconectar();
        return true;
    } else {
        $conn->desconectar();
        return false;
    }
}

function GetEventsByClient($cliente_id)
{
    $conn =  new bd();
    $conn->conectar();

    $record = [];

    $queryGetRecord = "SELECT  p.*, d.*, c.comuna ,r.region  
    FROM proyecto p 
    LEFT JOIN lugar l on l.id = p.lugar_id 
    LEFT JOIN direccion d on d.id = l.direccion_id
    LEFT JOIN comuna c on c.id = d.comuna_id 
    LEFT JOIN region r on r.id = c.region_id  
    WHERE p.cliente_id = $cliente_id";

    if ($resposneDbRecord = $conn->mysqli->query($queryGetRecord)) {
        while ($dataRecord = $resposneDbRecord->fetch_object()) {
            $record[] = $dataRecord;
        }
        $conn->desconectar();
        return array("success" => true, "data" => $record);
    } else {
        $conn->desconectar();
        return array("error" => true, "message" => "Ha ocurrido un error, por favor intente nuevamente");
    }
}





function getAllMyProjects_list_toExecute($empresa_id)
{
    $conn = new bd();
    $conn->conectar();
    $empresa_id = $empresa_id;

    $today = date('Y-m-d');

    $projects = [];
    $queryProyectos = "SELECT p.id, p.nombre_proyecto,e.estado , p.status_id as 'estado_id',pfr.income,
    CONCAT(per.nombre,' ', per.apellido) as nombreCliente, 
    df.nombre_fantasia as nombre_fantasia ,
    CONCAT(d.direccion, ' ',d.numero,', ',co.comuna,', ',re.region) as direccion,
    p.fecha_inicio ,p.fecha_termino,phv.proyecto_id as 'phv', php.proyecto_id as 'php',  phf.event_id as 'phf',
    et.nombre as event_type, pfr.income as income, pfr.cost as cost,
    (SELECT persona.nombre 
    FROM personal pers
    INNER JOIN persona on persona.id = pers.persona_id 
    INNER JOIN proyecto proye on proye.owner = pers.id
    WHERE proye.id = p.id AND p.empresa_id = $empresa_id) as owner,
    (SELECT ehc.id FROM event_has_comment ehc where ehc.event_id = p.id LIMIT 1) as event_has_comment,
    (SELECT prohp.proyecto_id FROM proyecto_has_producto prohp WHERE prohp.proyecto_id = p.id LIMIT 1) as event_has_inventory
        FROM proyecto p
    LEFT JOIN proyecto_has_vehiculo phv on phv.proyecto_id  = p.id
    LEFT JOIN personal_has_proyecto php ON php.proyecto_id = p.id
    LEFT JOIN proyecto_has_files phf on phf.event_id = p.id
    LEFT JOIN estado e on e.id = p.status_id
    LEFT JOIN event_type et on et.id = p.event_type_id
    LEFT JOIN lugar l on l.id = p.lugar_id 
    LEFT JOIN project_finance_resume pfr on pfr.event_id  = p.id
    LEFT JOIN direccion d on d.id = l.direccion_id 
    LEFT JOIN cliente c on c.id  = p.cliente_id
    LEFT JOIN datos_facturacion df on df.id = c.datos_facturacion_id          
    LEFT JOIN persona per on per.id = c.persona_id_contacto
    LEFT JOIN comuna co on co.id = d.comuna_id 
    LEFT JOIN region re on re.id = co.region_id  
    WHERE p.empresa_id = $empresa_id 
    AND p.status_id IN (2,4)
    AND p.fecha_inicio >= '$today'
    AND p.isDelete = 0
    group by p.id
	ORDER BY p.fecha_inicio asc;";
    // -- where p.empresa_id = 1 and p.fecha_inicio >= '2023-11-23'

    if ($responseBd = $conn->mysqli->query($queryProyectos)) {
        while ($dataProject = $responseBd->fetch_object()) {
            $projects[] = $dataProject;
        }
    }

    // return $queryProyectos;
    $conn->desconectar();
    return $projects;
}







function getAllMyEvents_notDeleted($empresa_id)
{

    try {
        $conn = new bd();
        $conn->conectar();
        $mysqli = $conn->mysqli;
        $projects_with_Date = [];

        $stmt = $mysqli->prepare("SELECT p.id, p.nombre_proyecto, estado , p.status_id as 'estado_id',
        CONCAT(per.nombre,' ', per.apellido) as nombreCliente, 
        df.nombre_fantasia as nombre_fantasia ,
        CONCAT(d.direccion, ' ',d.numero,', ',co.comuna,', ',re.region) as direccion,
        p.fecha_inicio ,p.fecha_termino,phv.proyecto_id as 'phv', php.proyecto_id as 'php',  phf.event_id as 'phf',
        et.nombre as event_type, pfr.income as income, pfr.cost as cost,(SELECT persona.nombre 
        FROM personal pers
        INNER JOIN persona on persona.id = pers.persona_id 
        INNER JOIN proyecto proye on proye.owner = pers.id
        WHERE proye.id = p.id AND p.empresa_id = ?) as owner,
        (SELECT ehc.id FROM event_has_comment ehc where ehc.event_id = p.id LIMIT 1) as event_has_comment,
        (SELECT prohp.proyecto_id FROM proyecto_has_producto prohp WHERE prohp.proyecto_id = p.id LIMIT 1) as event_has_inventory
         FROM proyecto p
        LEFT JOIN proyecto_has_vehiculo phv on phv.proyecto_id  = p.id
        LEFT JOIN personal_has_proyecto php ON php.proyecto_id = p.id
        LEFT JOIN proyecto_has_files phf on phf.event_id = p.id
        LEFT JOIN estado e on e.id = p.status_id
        LEFT JOIN event_type et on et.id = p.event_type_id
        LEFT JOIN lugar l on l.id = p.lugar_id 
        LEFT JOIN project_finance_resume pfr on pfr.event_id  = p.id
        LEFT JOIN direccion d on d.id = l.direccion_id 
        LEFT JOIN cliente c on c.id  = p.cliente_id 
        LEFT JOIN datos_facturacion df on df.id = c.datos_facturacion_id        
        LEFT JOIN persona per on per.id = c.persona_id_contacto
        LEFT JOIN comuna co on co.id = d.comuna_id 
        LEFT JOIN region re on re.id = co.region_id 
        WHERE p.empresa_id = ?
        AND p.isDelete = 0
        AND p.fecha_inicio IS NOT NULL
        group by p.id
        ORDER BY p.fecha_inicio desc;");

        $stmt->bind_param("ii", $empresa_id, $empresa_id);
        $stmt->execute();

        $result = $stmt->get_result();
        while ($dataProject = $result->fetch_object()) {
            $projects_with_Date[] = $dataProject;
        }
        $conn->desconectar();
        return array("events" => $projects_with_Date);
    } catch (Exception $e) {
        $conn->desconectar();
        return array("error" => true);
    }
}
function getAllCalendarEvents($empresa_id, $status_id)
{

    try {
        $conn = new bd();
        $conn->conectar();
        $mysqli = $conn->mysqli;
        $projects_with_Date = [];

        $stmt = $mysqli->prepare("SELECT p.id, p.nombre_proyecto, estado , p.status_id as 'estado_id',
        CONCAT(per.nombre,' ', per.apellido) as nombreCliente, 
        df.nombre_fantasia as nombre_fantasia ,
        CONCAT(d.direccion, ' ',d.numero,', ',co.comuna,', ',re.region) as direccion,
        p.fecha_inicio ,p.fecha_termino,phv.proyecto_id as 'phv', php.proyecto_id as 'php',  phf.event_id as 'phf',
        et.nombre as event_type, pfr.income as income, pfr.cost as cost,(SELECT persona.nombre 
        FROM personal pers
        INNER JOIN persona on persona.id = pers.persona_id 
        INNER JOIN proyecto proye on proye.owner = pers.id
        WHERE proye.id = p.id AND p.empresa_id = ?) as owner,
        (SELECT ehc.id FROM event_has_comment ehc where ehc.event_id = p.id LIMIT 1) as event_has_comment,
        (SELECT prohp.proyecto_id FROM proyecto_has_producto prohp WHERE prohp.proyecto_id = p.id LIMIT 1) as event_has_inventory
         FROM proyecto p
        LEFT JOIN proyecto_has_vehiculo phv on phv.proyecto_id  = p.id
        LEFT JOIN personal_has_proyecto php ON php.proyecto_id = p.id
        LEFT JOIN proyecto_has_files phf on phf.event_id = p.id
        LEFT JOIN estado e on e.id = p.status_id
        LEFT JOIN event_type et on et.id = p.event_type_id
        LEFT JOIN lugar l on l.id = p.lugar_id 
        LEFT JOIN project_finance_resume pfr on pfr.event_id  = p.id
        LEFT JOIN direccion d on d.id = l.direccion_id 
        LEFT JOIN cliente c on c.id  = p.cliente_id 
        LEFT JOIN datos_facturacion df on df.id = c.datos_facturacion_id        
        LEFT JOIN persona per on per.id = c.persona_id_contacto
        LEFT JOIN comuna co on co.id = d.comuna_id 
        LEFT JOIN region re on re.id = co.region_id 
        WHERE p.empresa_id = ?
        AND p.isDelete = 0
        AND p.status_id = ?
        AND p.fecha_inicio IS NOT NULL
        group by p.id
        ORDER BY p.fecha_inicio desc;");
        $stmt->bind_param("iii", $empresa_id, $empresa_id, $status_id);
        $stmt->execute();

        $result = $stmt->get_result();
        while ($dataProject = $result->fetch_object()) {
            $projects_with_Date[] = $dataProject;
        }
        $conn->desconectar();
        return array("events" => $projects_with_Date);
    } catch (Exception $e) {
        $conn->desconectar();
        return array("error" => true);
    }
}


function getAllMyEvents($empresa_id)
{
    $conn = new bd();
    $conn->conectar();
    $empresa_id = $empresa_id;
    $today = date('Y-m-d');
    $projects_with_Date = [];
    $projects_without_Date = [];
    $queryProyectos_with_date = "SELECT p.id, p.nombre_proyecto, estado , p.status_id as 'estado_id',
    CONCAT(per.nombre,' ', per.apellido) as nombreCliente, 
    df.nombre_fantasia as nombre_fantasia ,
    CONCAT(d.direccion, ' ',d.numero,', ',co.comuna,', ',re.region) as direccion,
    p.fecha_inicio ,p.fecha_termino,phv.proyecto_id as 'phv', php.proyecto_id as 'php',  phf.event_id as 'phf',
    et.nombre as event_type, pfr.income as income, pfr.cost as cost,(SELECT persona.nombre 
    FROM personal pers
    INNER JOIN persona on persona.id = pers.persona_id 
    INNER JOIN proyecto proye on proye.owner = pers.id
    WHERE proye.id = p.id AND p.empresa_id = $empresa_id) as owner,
    (SELECT ehc.id FROM event_has_comment ehc where ehc.event_id = p.id LIMIT 1) as event_has_comment,
    (SELECT prohp.proyecto_id FROM proyecto_has_producto prohp WHERE prohp.proyecto_id = p.id LIMIT 1) as event_has_inventory
            FROM proyecto p
    LEFT JOIN proyecto_has_vehiculo phv on phv.proyecto_id  = p.id
    LEFT JOIN personal_has_proyecto php ON php.proyecto_id = p.id
    LEFT JOIN proyecto_has_files phf on phf.event_id = p.id
    LEFT JOIN estado e on e.id = p.status_id
    LEFT JOIN event_type et on et.id = p.event_type_id
    LEFT JOIN lugar l on l.id = p.lugar_id 
    LEFT JOIN project_finance_resume pfr on pfr.event_id  = p.id
    LEFT JOIN direccion d on d.id = l.direccion_id 
    LEFT JOIN cliente c on c.id  = p.cliente_id 
    LEFT JOIN datos_facturacion df on df.id = c.datos_facturacion_id        
    LEFT JOIN persona per on per.id = c.persona_id_contacto
    LEFT JOIN comuna co on co.id = d.comuna_id 
    LEFT JOIN region re on re.id = co.region_id 
    WHERE p.empresa_id = $empresa_id
    AND p.fecha_inicio IS NOT NULL
    AND p.isDelete = 0
    group by p.id
	ORDER BY p.fecha_inicio desc;";


    $queryProyectos_without_date = "SELECT p.id, p.nombre_proyecto,e.estado , p.status_id as 'estado_id',
    CONCAT(per.nombre,' ', per.apellido) as nombreCliente, 
    df.nombre_fantasia as nombre_fantasia ,
    CONCAT(d.direccion, ' ',d.numero,', ',co.comuna,', ',re.region) as direccion,
    p.fecha_inicio ,p.fecha_termino,phv.proyecto_id as 'phv', php.proyecto_id as 'php',  phf.event_id as 'phf',
    et.nombre as event_type, pfr.income as income, pfr.cost as cost,(SELECT persona.nombre 
    FROM personal pers
    INNER JOIN persona on persona.id = pers.persona_id 
    INNER JOIN proyecto proye on proye.owner = pers.id
    WHERE proye.id = p.id AND p.empresa_id = $empresa_id) as owner,
    (SELECT ehc.id FROM event_has_comment ehc where ehc.event_id = p.id LIMIT 1) as event_has_comment,
    (SELECT prohp.proyecto_id FROM proyecto_has_producto prohp WHERE prohp.proyecto_id = p.id LIMIT 1) as event_has_inventory
            FROM proyecto p
    LEFT JOIN proyecto_has_vehiculo phv on phv.proyecto_id  = p.id
    LEFT JOIN personal_has_proyecto php ON php.proyecto_id = p.id
    LEFT JOIN proyecto_has_files phf on phf.event_id = p.id
    LEFT JOIN estado e on e.id = p.status_id
    LEFT JOIN event_type et on et.id = p.event_type_id
    LEFT JOIN lugar l on l.id = p.lugar_id 
    LEFT JOIN project_finance_resume pfr on pfr.event_id  = p.id
    LEFT JOIN direccion d on d.id = l.direccion_id 
    LEFT JOIN cliente c on c.id  = p.cliente_id
    LEFT JOIN datos_facturacion df on df.id = c.datos_facturacion_id         
    LEFT JOIN persona per on per.id = c.persona_id_contacto
    LEFT JOIN comuna co on co.id = d.comuna_id 
    LEFT JOIN region re on re.id = co.region_id 
    WHERE p.empresa_id = $empresa_id
    AND p.fecha_inicio IS NULL
    AND p.isDelete = 0
    group by p.id
	ORDER BY p.createAt desc;";

    // return $queryProyectos_with_date;
    if ($responseBd = $conn->mysqli->query($queryProyectos_with_date)) {
        while ($dataProject = $responseBd->fetch_object()) {
            $projects_with_Date[] = $dataProject;
        }
    }
    if ($responseBd = $conn->mysqli->query($queryProyectos_without_date)) {
        while ($dataProject = $responseBd->fetch_object()) {
            $projects_without_Date[] = $dataProject;
        }
    }

    $conn->desconectar();
    return array("wd" => $projects_with_Date, "woutd" => $projects_without_Date);
}


function  getEventByStatus_id($empresa_id, $status_id)
{
    $conn = new bd();
    $conn->conectar();
    $empresa_id = $empresa_id;
    $today = date('Y-m-d');
    $projects_with_Date = [];
    $projects_without_Date = [];
    $queryProyectos_with_date = "SELECT p.id, p.nombre_proyecto,e.estado , p.status_id as 'estado_id',
    CONCAT(per.nombre,' ', per.apellido) as nombreCliente, 
    df.nombre_fantasia as nombre_fantasia ,
    CONCAT(d.direccion, ' ',d.numero,', ',co.comuna,', ',re.region) as direccion,
    p.fecha_inicio ,p.fecha_termino,phv.proyecto_id as 'phv', php.proyecto_id as 'php',  phf.event_id as 'phf',
    et.nombre as event_type, pfr.income as income, pfr.cost as cost,(SELECT persona.nombre 
    FROM personal pers
    INNER JOIN persona on persona.id = pers.persona_id 
    INNER JOIN proyecto proye on proye.owner = pers.id
    WHERE proye.id = p.id AND p.empresa_id = $empresa_id) as owner,
    (SELECT ehc.id FROM event_has_comment ehc where ehc.event_id = p.id LIMIT 1) as event_has_comment,
    (SELECT prohp.proyecto_id FROM proyecto_has_producto prohp WHERE prohp.proyecto_id = p.id LIMIT 1) as event_has_inventory
            FROM proyecto p
    LEFT JOIN proyecto_has_vehiculo phv on phv.proyecto_id  = p.id
    LEFT JOIN personal_has_proyecto php ON php.proyecto_id = p.id
    LEFT JOIN proyecto_has_files phf on phf.event_id = p.id
    LEFT JOIN estado e on e.id = p.status_id
    LEFT JOIN event_type et on et.id = p.event_type_id
    LEFT JOIN lugar l on l.id = p.lugar_id 
    LEFT JOIN project_finance_resume pfr on pfr.event_id  = p.id
    LEFT JOIN direccion d on d.id = l.direccion_id 
    LEFT JOIN cliente c on c.id  = p.cliente_id       
    LEFT JOIN datos_facturacion df on df.id = c.datos_facturacion_id  
    LEFT JOIN persona per on per.id = c.persona_id_contacto
    LEFT JOIN comuna co on co.id = d.comuna_id 
    LEFT JOIN region re on re.id = co.region_id 
    WHERE p.empresa_id = $empresa_id
    AND p.fecha_inicio IS NOT NULL
    AND p.status_id = $status_id
    AND p.isDelete = 0
    group by p.id
	ORDER BY p.fecha_inicio desc;";

    $queryProyectos_without_date = "SELECT p.id, p.nombre_proyecto,e.estado , p.status_id as 'estado_id',
    CONCAT(per.nombre,' ', per.apellido) as nombreCliente, 
    df.nombre_fantasia as nombre_fantasia ,
    CONCAT(d.direccion, ' ',d.numero,', ',co.comuna,', ',re.region) as direccion,
    p.fecha_inicio ,p.fecha_termino,phv.proyecto_id as 'phv', php.proyecto_id as 'php',  phf.event_id as 'phf',
    et.nombre as event_type, pfr.income as income, pfr.cost as cost,(SELECT persona.nombre 
    FROM personal pers
    INNER JOIN persona on persona.id = pers.persona_id 
    INNER JOIN proyecto proye on proye.owner = pers.id
    WHERE proye.id = p.id AND p.empresa_id = $empresa_id) as owner,
    (SELECT ehc.id FROM event_has_comment ehc where ehc.event_id = p.id LIMIT 1) as event_has_comment,
    (SELECT prohp.proyecto_id FROM proyecto_has_producto prohp WHERE prohp.proyecto_id = p.id LIMIT 1) as event_has_inventory
            FROM proyecto p
    LEFT JOIN proyecto_has_vehiculo phv on phv.proyecto_id  = p.id
    LEFT JOIN personal_has_proyecto php ON php.proyecto_id = p.id
    LEFT JOIN proyecto_has_files phf on phf.event_id = p.id
    LEFT JOIN estado e on e.id = p.status_id
    LEFT JOIN event_type et on et.id = p.event_type_id
    LEFT JOIN lugar l on l.id = p.lugar_id 
    LEFT JOIN project_finance_resume pfr on pfr.event_id  = p.id
    LEFT JOIN direccion d on d.id = l.direccion_id 
    LEFT JOIN cliente c on c.id  = p.cliente_id   
    LEFT JOIN datos_facturacion df on df.id = c.datos_facturacion_id      
    LEFT JOIN persona per on per.id = c.persona_id_contacto
    LEFT JOIN comuna co on co.id = d.comuna_id 
    LEFT JOIN region re on re.id = co.region_id 
    WHERE p.empresa_id = $empresa_id
    AND p.fecha_inicio IS NULL
    AND p.status_id = $status_id
    AND p.isDelete = 0
    group by p.id
	ORDER BY p.createAt desc;";

    // return $queryProyectos_with_date;
    if ($responseBd = $conn->mysqli->query($queryProyectos_with_date)) {
        while ($dataProject = $responseBd->fetch_object()) {
            $projects_with_Date[] = $dataProject;
        }
    }
    if ($responseBd = $conn->mysqli->query($queryProyectos_without_date)) {
        while ($dataProject = $responseBd->fetch_object()) {
            $projects_without_Date[] = $dataProject;
        }
    }

    $conn->desconectar();
    return array("wd" => $projects_with_Date, "woutd" => $projects_without_Date);
}

function getOperEvents($empresa_id)
{
    $conn = new bd();
    $conn->conectar();
    $empresa_id = $empresa_id;
    $today = date('Y-m-d');
    $projects_with_Date = [];
    $projects_without_Date = [];

    $queryProyectos_with_date = "SELECT   p.id, p.nombre_proyecto, estado , p.status_id as 'estado_id',
    CONCAT(per.nombre,' ', per.apellido) as nombreCliente, 
    df.nombre_fantasia as nombre_fantasia ,
    CONCAT(d.direccion, ' ',d.numero,', ',co.comuna,', ',re.region) as direccion,
    p.fecha_inicio ,p.fecha_termino,phv.proyecto_id as 'phv', php.proyecto_id as 'php',  phf.event_id as 'phf',
    et.nombre as event_type, pfr.income as income, pfr.cost as cost,(SELECT persona.nombre 
    FROM personal pers
    INNER JOIN persona on persona.id = pers.persona_id 
    INNER JOIN proyecto proye on proye.owner = pers.id
    WHERE proye.id = p.id AND p.empresa_id = $empresa_id) as owner,
    (SELECT ehc.id FROM event_has_comment ehc where ehc.event_id = p.id LIMIT 1) as event_has_comment,
    (SELECT prohp.proyecto_id FROM proyecto_has_producto prohp WHERE prohp.proyecto_id = p.id LIMIT 1) as event_has_inventory
            FROM proyecto p
    LEFT JOIN proyecto_has_vehiculo phv on phv.proyecto_id  = p.id
    LEFT JOIN personal_has_proyecto php ON php.proyecto_id = p.id
    LEFT JOIN proyecto_has_files phf on phf.event_id = p.id
    LEFT JOIN estado e on e.id = p.status_id
    LEFT JOIN event_type et on et.id = p.event_type_id
    LEFT JOIN lugar l on l.id = p.lugar_id 
    LEFT JOIN project_finance_resume pfr on pfr.event_id  = p.id
    LEFT JOIN direccion d on d.id = l.direccion_id 
    LEFT JOIN cliente c on c.id  = p.cliente_id 
    LEFT JOIN datos_facturacion df on df.id = c.datos_facturacion_id        
    LEFT JOIN persona per on per.id = c.persona_id_contacto
    LEFT JOIN comuna co on co.id = d.comuna_id 
    LEFT JOIN region re on re.id = co.region_id  
    WHERE p.empresa_id = $empresa_id
    AND p.status_id in(2)
    AND p.fecha_inicio IS NOT NULL
    AND p.fecha_inicio >= '$today' 
    AND p.isDelete = 0
    GROUP BY p.id
	ORDER BY p.fecha_inicio desc;";


    $queryProyectos_without_date = "SELECT   p.id, p.nombre_proyecto, estado , p.status_id as 'estado_id',
    CONCAT(per.nombre,' ', per.apellido) as nombreCliente, 
    df.nombre_fantasia as nombre_fantasia ,
    CONCAT(d.direccion, ' ',d.numero,', ',co.comuna,', ',re.region) as direccion,
    p.fecha_inicio ,p.fecha_termino,phv.proyecto_id as 'phv', php.proyecto_id as 'php',  phf.event_id as 'phf',
    et.nombre as event_type, pfr.income as income, pfr.cost as cost,(SELECT persona.nombre 
    FROM personal pers
    INNER JOIN persona on persona.id = pers.persona_id 
    INNER JOIN proyecto proye on proye.owner = pers.id
    WHERE proye.id = p.id AND p.empresa_id = $empresa_id) as owner,
    (SELECT ehc.id FROM event_has_comment ehc where ehc.event_id = p.id LIMIT 1) as event_has_comment,
    (SELECT prohp.proyecto_id FROM proyecto_has_producto prohp WHERE prohp.proyecto_id = p.id LIMIT 1) as event_has_inventory
            FROM proyecto p
    LEFT JOIN proyecto_has_vehiculo phv on phv.proyecto_id  = p.id
    LEFT JOIN personal_has_proyecto php ON php.proyecto_id = p.id
    LEFT JOIN proyecto_has_files phf on phf.event_id = p.id
    LEFT JOIN estado e on e.id = p.status_id
    LEFT JOIN event_type et on et.id = p.event_type_id
    LEFT JOIN lugar l on l.id = p.lugar_id 
    LEFT JOIN project_finance_resume pfr on pfr.event_id  = p.id
    LEFT JOIN direccion d on d.id = l.direccion_id 
    LEFT JOIN cliente c on c.id  = p.cliente_id         
    LEFT JOIN datos_facturacion df on df.id = c.datos_facturacion_id
    LEFT JOIN persona per on per.id = c.persona_id_contacto
    LEFT JOIN comuna co on co.id = d.comuna_id 
    LEFT JOIN region re on re.id = co.region_id  
    WHERE p.empresa_id = $empresa_id
    AND p.status_id in(1,2)
    AND p.isDelete = 0
    AND p.fecha_inicio IS NULL 
    GROUP BY p.id
	ORDER BY p.createAt desc;";

    // return $queryProyectos_with_date;
    if ($responseBd = $conn->mysqli->query($queryProyectos_with_date)) {
        while ($dataProject = $responseBd->fetch_object()) {
            $projects_with_Date[] = $dataProject;
        }
    }
    if ($responseBd = $conn->mysqli->query($queryProyectos_without_date)) {
        while ($dataProject = $responseBd->fetch_object()) {
            $projects_without_Date[] = $dataProject;
        }
    }

    // return $queryProyectos_with_date;
    $conn->desconectar();
    return array("wd" => $projects_with_Date, "woutd" => $projects_without_Date);
}
function getSellsEvents($empresa_id)
{
    $conn = new bd();
    $conn->conectar();
    $empresa_id = $empresa_id;
    $today = date('Y-m-d');
    $projects_with_Date = [];
    $projects_without_Date = [];

    $queryProyectos_with_date = "SELECT   p.id, p.nombre_proyecto, estado , p.status_id as 'estado_id',
    CONCAT(per.nombre,' ', per.apellido) as nombreCliente, 
    df.nombre_fantasia as nombre_fantasia ,
    CONCAT(d.direccion, ' ',d.numero,', ',co.comuna,', ',re.region) as direccion,
    p.fecha_inicio ,p.fecha_termino,phv.proyecto_id as 'phv', php.proyecto_id as 'php',  phf.event_id as 'phf',
    et.nombre as event_type, pfr.income as income, pfr.cost as cost,(SELECT persona.nombre 
    FROM personal pers
    INNER JOIN persona on persona.id = pers.persona_id 
    INNER JOIN proyecto proye on proye.owner = pers.id
    WHERE proye.id = p.id AND p.empresa_id = $empresa_id) as owner,
    (SELECT ehc.id FROM event_has_comment ehc where ehc.event_id = p.id LIMIT 1) as event_has_comment,
    (SELECT prohp.proyecto_id FROM proyecto_has_producto prohp WHERE prohp.proyecto_id = p.id LIMIT 1) as event_has_inventory
            FROM proyecto p
    LEFT JOIN proyecto_has_vehiculo phv on phv.proyecto_id  = p.id
    LEFT JOIN personal_has_proyecto php ON php.proyecto_id = p.id
    LEFT JOIN proyecto_has_files phf on phf.event_id = p.id
    LEFT JOIN estado e on e.id = p.status_id
    LEFT JOIN event_type et on et.id = p.event_type_id
    LEFT JOIN lugar l on l.id = p.lugar_id 
    LEFT JOIN project_finance_resume pfr on pfr.event_id  = p.id
    LEFT JOIN direccion d on d.id = l.direccion_id 
    LEFT JOIN cliente c on c.id  = p.cliente_id         
    LEFT JOIN datos_facturacion df on df.id = c.datos_facturacion_id
    LEFT JOIN persona per on per.id = c.persona_id_contacto
    LEFT JOIN comuna co on co.id = d.comuna_id 
    LEFT JOIN region re on re.id = co.region_id 
    WHERE p.empresa_id = $empresa_id
    AND p.status_id  in (2,4)
    AND p.fecha_inicio IS NOT NULL
    AND p.fecha_inicio >= '$today'
    AND p.isDelete = 0
    GROUP BY p.id
	ORDER BY p.fecha_inicio desc;";

    if ($responseBd = $conn->mysqli->query($queryProyectos_with_date)) {
        while ($dataProject = $responseBd->fetch_object()) {
            $projects_with_Date[] = $dataProject;
        }
    }

    $conn->desconectar();
    return array("wd" => $projects_with_Date, "woutd" => $projects_without_Date);

    // $queryProyectos_without_date = "SELECT   p.id, p.nombre_proyecto, estado , p.status_id as 'estado_id',
    // CONCAT(per.nombre,' ', per.apellido) as nombreCliente, 
    // CONCAT(d.direccion, ' ',d.numero,', ',co.comuna,', ',re.region) as direccion,
    // p.fecha_inicio ,p.fecha_termino,phv.proyecto_id as 'phv', php.proyecto_id as 'php',  phf.event_id as 'phf'
    //         FROM proyecto p
    // INNER JOIN proyecto_has_estado phe ON  phe.proyecto_id  = p.id 
    // LEFT JOIN proyecto_has_vehiculo phv on phv.proyecto_id  = p.id
    // LEFT JOIN personal_has_proyecto php ON php.proyecto_id = p.id
    // LEFT JOIN proyecto_has_files phf on phf.event_id = p.id
    // LEFT JOIN estado e on e.id = p.status_id 
    // LEFT JOIN lugar l on l.id = p.lugar_id 
    // LEFT JOIN direccion d on d.id = l.direccion_id 
    // LEFT JOIN cliente c on c.id  = p.cliente_id         
    // LEFT JOIN persona per on per.id = c.persona_id_contacto
    // LEFT JOIN comuna co on co.id = d.comuna_id 
    // LEFT JOIN region re on re.id = co.region_id 
    // WHERE p.empresa_id = 1
    // AND p.status_id in(1,2)
    // AND p.fecha_inicio IS NULL 
    // GROUP BY p.id
    // ORDER BY p.createAt desc;";

    // return $queryProyectos_with_date;

    // if ($responseBd = $conn->mysqli->query($queryProyectos_without_date)) {
    //     while ($dataProject = $responseBd->fetch_object()) {
    //         $projects_without_Date[] = $dataProject;
    //     }
    // }

    // return $queryProyectos_with_date;

}
function getAdmEvents($empresa_id)
{
    $conn = new bd();
    $conn->conectar();
    $empresa_id = $empresa_id;
    $today = date('Y-m-d');
    $projects_with_Date = [];
    $projects_without_Date = [];

    $queryProyectos_with_date = "SELECT   p.id, p.nombre_proyecto, estado , p.status_id as 'estado_id',
    CONCAT(per.nombre,' ', per.apellido) as nombreCliente, 
    df.nombre_fantasia as nombre_fantasia ,
    CONCAT(d.direccion, ' ',d.numero,', ',co.comuna,', ',re.region) as direccion,
    p.fecha_inicio ,p.fecha_termino,phv.proyecto_id as 'phv', php.proyecto_id as 'php',  phf.event_id as 'phf',
    et.nombre as event_type, pfr.income as income, pfr.cost as cost,(SELECT persona.nombre 
    FROM personal pers
    INNER JOIN persona on persona.id = pers.persona_id 
    INNER JOIN proyecto proye on proye.owner = pers.id
    WHERE proye.id = p.id AND p.empresa_id = $empresa_id) as owner,
    (SELECT ehc.id FROM event_has_comment ehc where ehc.event_id = p.id LIMIT 1) as event_has_comment,
    (SELECT prohp.proyecto_id FROM proyecto_has_producto prohp WHERE prohp.proyecto_id = p.id LIMIT 1) as event_has_inventory
        FROM proyecto p
    LEFT JOIN proyecto_has_vehiculo phv on phv.proyecto_id  = p.id
    LEFT JOIN personal_has_proyecto php ON php.proyecto_id = p.id
    LEFT JOIN proyecto_has_files phf on phf.event_id = p.id
    LEFT JOIN estado e on e.id = p.status_id
    LEFT JOIN event_type et on et.id = p.event_type_id
    LEFT JOIN lugar l on l.id = p.lugar_id 
    LEFT JOIN project_finance_resume pfr on pfr.event_id  = p.id
    LEFT JOIN direccion d on d.id = l.direccion_id 
    LEFT JOIN cliente c on c.id  = p.cliente_id  
    LEFT JOIN datos_facturacion df on df.id = c.datos_facturacion_id       
    LEFT JOIN persona per on per.id = c.persona_id_contacto
    LEFT JOIN comuna co on co.id = d.comuna_id 
    LEFT JOIN region re on re.id = co.region_id 
    WHERE p.empresa_id = $empresa_id
    AND p.status_id in(3,5)
    AND p.fecha_termino <= '$today' 
    AND p.isDelete = 0
    GROUP BY p.id
	ORDER BY p.fecha_termino desc;";

    if ($responseBd = $conn->mysqli->query($queryProyectos_with_date)) {
        while ($dataProject = $responseBd->fetch_object()) {
            $projects_with_Date[] = $dataProject;
        }
    }
    $conn->desconectar();
    return array("wd" => $projects_with_Date, "woutd" => $projects_without_Date);
}


function updateProject($empresa_id, $request, $event_id)
{
    $conn = new bd();
    $conn->conectar();

    // let requestProject = {
    //   'nombre_proyecto': projectName,
    //   'lugar_id': id_lugar,
    //   'fecha_inicio': fechaInicio,
    //   'fecha_termino': fechaTermino,
    //   'cliente_id': idCliente,
    //   'comentarios': comentarios,
    //   'empresa_id': EMPRESA_ID,
    //   'owner' : OWNER,
    //   'status_id' : STATUS_ID
    //}

    if ($request->lugar_id === "") {
        $request->lugar_id = "NULL";
    }
    if ($request->fecha_inicio === "") {
        $request->fecha_inicio = "NULL";
    }
    if ($request->fecha_termino === "") {
        $request->fecha_termino = "NULL";
    }
    if ($request->cliente_id === "") {
        $request->cliente_id = "NULL";
    }
    if ($request->comentarios === "") {
        $request->comentarios = "NULL";
    }
    if ($request->empresa_id === "") {
        $request->empresa_id = "NULL";
    }
    if ($request->owner === "" || $request->owner === null) {
        $request->owner = "NULL";
    }

    if ($request->status_id === "") {
        $request->status_id = "NULL";
    }
    if ($request->event_type_id === "") {
        $request->event_type_id = "NULL";
    }

    if ($request->nombre_proyecto === null || $request->nombre_proyecto === "") {
        return array("error" => true, "message" => "Debes ingresar un nombre para tu evento");
    }

    $queryUpdate = "UPDATE proyecto SET 
    nombre_proyecto='$request->nombre_proyecto',  
    fecha_inicio='$request->fecha_inicio',  
    fecha_termino='$request->fecha_termino',  
    comentarios='$request->comentarios',  
    IsDelete=0, cliente_id=$request->cliente_id, 
    owner=$request->owner,  
    status_id=$request->status_id, 
    event_type_id=$request->event_type_id
    WHERE id=$event_id AND empresa_id = $empresa_id;";

    if ($conn->mysqli->query($queryUpdate)) {
        return array("success" => true, "message" => "Detalles del evento actualizados con exito");
    } else {
        return array("error" => "error", "message" => "No se han podido realizar los detalles del evento");
    }
    $conn->desconectar();
    return $queryUpdate;
}

function removeAddressFromEvent($empresa_id, $event_id)
{
    $conn = new bd();
    $conn->conectar();

    $query = "UPDATE proyecto
    SET address_id=NULL
    WHERE id=$event_id AND empresa_id = $empresa_id;";

    if ($conn->mysqli->query($query)) {
        $conn->desconectar();
        return array("success" => true, "message" => "Address has been removed successfully from event");
    } else {
        $conn->desconectar();
        return array("error" => true, "message" => "Address has not been removed form event");
    }
}


function getDashResume($empresa_id)
{
    $conn = new bd();
    $conn->conectar();


    $incomeResume = [];

    // DECLARE ALL ARRAY RESPONSE 

    $currentAndLastMonthEventQuantity = [];
    $currentMonthIncome = [];
    // QUERY SECTION

    $queryGetCurAndLastMonthEventQuantity = "SELECT COUNT(p.id) AS total_current_month,
	(SELECT COUNT(p.id)  FROM proyecto p 
        WHERE p.fecha_inicio >=  DATE_SUB(DATE(CONCAT_WS('-', YEAR(CURRENT_DATE()), MONTH(CURRENT_DATE()) , '01')),INTERVAL 1 MONTH) 
        AND  p.fecha_inicio <= LAST_DAY(DATE_SUB(DATE(CONCAT_WS('-', YEAR(CURRENT_DATE()), MONTH(CURRENT_DATE())  , '01')),INTERVAL 1 MONTH))
        AND p.empresa_id = $empresa_id) AS total_last_month,
    (SELECT COUNT(p.id)  
        from proyecto p
    WHERE p.fecha_inicio >= CURDATE()
    AND p.fecha_inicio <= LAST_DAY(CURDATE())
    AND p.empresa_id = $empresa_id
    AND p.status_id = 2) AS currentLeftEvents
        FROM proyecto p 
    WHERE p.fecha_inicio >=    DATE(CONCAT_WS('-', YEAR(CURRENT_DATE()), MONTH(CURRENT_DATE()) , '01'))
    AND  p.fecha_inicio <=  LAST_DAY(CURDATE())
    AND p.empresa_id = $empresa_id
    AND p.IsDelete  = 0
    and p.status_id in (2,3,5); ";

    $queryIncomeComparisonCurrentAndLast = "SELECT 
    CASE 
     WHEN SUM(pfr.income) is null
     THEN 0
     ELSE pfr.income
    END as actual_income_month,
    (SELECT SUM(pfr.income) as actual_income_month
    FROM project_finance_resume pfr
    INNER JOIN proyecto p on p.id = pfr.event_id
    where p.fecha_inicio >=  DATE_SUB(DATE(CONCAT_WS('-', YEAR(CURRENT_DATE()), MONTH(CURRENT_DATE())  , '01')),INTERVAL 1 MONTH) 
    AND p.fecha_inicio <=LAST_DAY(DATE_SUB(DATE(CONCAT_WS('-', YEAR(CURRENT_DATE()), MONTH(CURRENT_DATE())  , '01')),INTERVAL 1 MONTH))
    AND p.empresa_id = $empresa_id) AS last_month_income
    FROM project_finance_resume pfr 
    INNER JOIN proyecto p on p.id = pfr.event_id
    where p.fecha_inicio >=    DATE(CONCAT_WS('-', YEAR(CURRENT_DATE()), MONTH(CURRENT_DATE()) , '01'))
    AND  p.fecha_inicio >=  LAST_DAY(CURDATE())
    AND p.empresa_id = $empresa_id
    AND p.isDelete = 0";

    $queryActualMonthIncome = "SELECT  SUM(pfr.income)as currentMonthIncome from project_finance_resume pfr 
    INNER JOIN proyecto p on p.id = pfr.event_id
    where p.fecha_inicio >=    DATE(CONCAT_WS('-', YEAR(CURRENT_DATE()), MONTH(CURRENT_DATE()) , '01'))
    and  p.fecha_inicio <=  LAST_DAY(CURDATE())
    AND p.empresa_id = $empresa_id
    and p.IsDelete = 0
    and p.status_id in(2,3,5);  ";



    // EXECUTE QUERY SECTION

    if ($responseBd = $conn->mysqli->query($queryGetCurAndLastMonthEventQuantity)) {
        while ($dataResponse = $responseBd->fetch_object()) {
            $currentAndLastMonthEventQuantity  = $dataResponse;
        }
    }
    if ($responseBd = $conn->mysqli->query($queryIncomeComparisonCurrentAndLast)) {
        while ($dataResponse = $responseBd->fetch_object()) {
            $incomeResume  = $dataResponse;
        }
    }
    if ($responseBd = $conn->mysqli->query($queryActualMonthIncome)) {
        while ($dataResponse = $responseBd->fetch_object()) {
            $currentMonthIncome  = $dataResponse;
        }
    }
    
    $conn->desconectar();
    return array(
        "success" => true,
        "event_quanity_cur_last_month" => $currentAndLastMonthEventQuantity,
        "incomeResume" => $incomeResume,
        "currentMonthIncome" => $currentMonthIncome
    );
}

function insertOrUpdateIncomeAndCosts($request)
{
    $conn = new bd();
    $conn->conectar();
    $udpate = false;

    $query = "SELECT id FROM project_finance_resume pfr where pfr.event_id = $request->event_id ;";

    $result = $conn->mysqli->query($query);
    if ($result->num_rows > 0) {
        $queryUpdate = "UPDATE project_finance_resume 
        set income = $request->ingreso , cost = $request->costo
        WHERE event_id = $request->event_id";

        if ($conn->mysqli->query($queryUpdate)) {
            $conn->desconectar();
            return array("success" => true, "message" => "Event finance updated");
        } else {
            $conn->desconectar();
            return array("success" => true, "message" => "Event finance couldn't be updated");
        }
    } else {


        $query = "INSERT INTO project_finance_resume (event_id, income, cost) 
        VALUES($request->event_id, $request->ingreso, $request->costo);";


        if ($conn->mysqli->query($query)) {
            $conn->desconectar();
            return array("success" => true, "message" => "Event finance created");
        } else {
            $conn->desconectar();
            return array("success" => true, "message" => "Event finance couldn't be created");
        }
    }
}


function getEventsForDashboard($request, $empresa_id)
{
    $conn = new bd();
    $conn->conectar();

    $eventos = [];

    $today = date("Y-m-d");


    $status = $request->status;
    $date =   $request->date;
    $type =   $request->type;

    // return $request ;
    if ($request->status !== "all") {
        $status = "and p.status_id = $request->status";
    } else {
        $status = "";
    }

    if ($request->date === "") {
        $date = "and p.fecha_inicio >= '$today'";
    } else {
        $date = "and p.fecha_inicio >= '$request->date'";
    }

    if ($request->type !== "") {
        $type = "and p.event_type_id = $request->type";
    } else {
        $type = "";
    }

    $query = "SELECT p.id, p.nombre_proyecto, d.direccion as 'address' ,
    p.fecha_inicio ,
    e.estado as estado,
    e.id as estado_id,
    (SELECT ehc.id FROM event_has_comment ehc where ehc.event_id = p.id LIMIT 1) as event_has_comment,
    phf.event_id as 'phf',
    pfr.income 
    FROM proyecto p  
    LEFT join event_type et on et.id = p.event_type_id  
    LEFT join direccion d on d.id = p.address_id  
    LEFT JOIN project_finance_resume pfr ON pfr.event_id = p.id
    LEFT JOIN proyecto_has_files phf on phf.event_id = p.id
    LEFT JOIN estado e on e.id = p.status_id  where p.empresa_id = $empresa_id 
    $status $date $type 
    AND p.isDelete = 0;";

    if ($response = $conn->mysqli->query($query)) {
        while ($data = $response->fetch_object()) {
            $eventos[] = $data;
        }
        $conn->desconectar();
        return array("success" => true, "events" => $eventos);
    } else {
        $conn->desconectar();
        return array("error" => true);
    }
}


function getTodayEvent()
{

    try {
        $conn = new bd();
        $conn->conectar();
        $today = date('Y-m-d');
        $events = [];
        $query = "SELECT * FROM proyecto p WHERE p.fecha_inicio = '$today'";

        if ($response = $conn->mysqli->query($query)) {
            while ($data = $response->fetch_object()) {
                $events[] = $data;
            }
            $conn->desconectar();
            return array("success" => true, "data" => $events);
        } else {
            $conn->desconectar();
            return array("error" => true);
        }
    } catch (Exception $e) {
        return array("error" => $e);
    }
}

function getEventDay($empresa_id, $date){

    try {
        $conn = new bd();
        $conn->conectar();
        $events = [];
        $query = "SELECT p.*, pers.nombre as owner FROM proyecto p 
        LEFT JOIN personal per on per.id = p.owner 
        LEFT JOIN persona pers on pers.id = per.persona_id 
        WHERE p.fecha_inicio = '$date' 
        AND p.empresa_id = $empresa_id
        AND p.isDelete =  0 ";


        if ($response = $conn->mysqli->query($query)) {
            while ($data = $response->fetch_object()) {
                $events[] = $data;
            }
            $conn->desconectar();
            return array("success" => true, "data" => $events);
        } else {
            $conn->desconectar();
            return array("error" => true);
        }
    } catch (Exception $e) {
        return array("error" => "Intente Nuevamente");
    }
}

function getDeletedEvents($empresa_id)
{
    $deleteEvents = [];
    try {
        $conn = new bd();
        $conn->conectar();
        $mysqli = $conn->mysqli;
        try {
            $stmt = $mysqli->prepare("SELECT   p.id, p.nombre_proyecto, estado , p.status_id as 'estado_id',
            CONCAT(per.nombre,' ', per.apellido) as nombreCliente, 
            df.nombre_fantasia as nombre_fantasia ,
            CONCAT(d.direccion, ' ',d.numero,', ',co.comuna,', ',re.region) as direccion,
            p.fecha_inicio ,p.fecha_termino,phv.proyecto_id as 'phv', php.proyecto_id as 'php',  phf.event_id as 'phf',
            et.nombre as event_type, pfr.income as income, pfr.cost as cost,(SELECT persona.nombre 
            FROM personal pers
            INNER JOIN persona on persona.id = pers.persona_id 
            INNER JOIN proyecto proye on proye.owner = pers.id
            WHERE proye.id = p.id AND p.empresa_id = ?) as owner,
            (SELECT ehc.id FROM event_has_comment ehc where ehc.event_id = p.id LIMIT 1) as event_has_comment,
            (SELECT prohp.proyecto_id FROM proyecto_has_producto prohp WHERE prohp.proyecto_id = p.id LIMIT 1) as event_has_inventory
                FROM proyecto p
            LEFT JOIN proyecto_has_vehiculo phv on phv.proyecto_id  = p.id
            LEFT JOIN personal_has_proyecto php ON php.proyecto_id = p.id
            LEFT JOIN proyecto_has_files phf on phf.event_id = p.id
            LEFT JOIN estado e on e.id = p.status_id
            LEFT JOIN event_type et on et.id = p.event_type_id
            LEFT JOIN lugar l on l.id = p.lugar_id 
            LEFT JOIN project_finance_resume pfr on pfr.event_id  = p.id
            LEFT JOIN direccion d on d.id = l.direccion_id 
            LEFT JOIN cliente c on c.id  = p.cliente_id  
            LEFT JOIN datos_facturacion df on df.id = c.datos_facturacion_id       
            LEFT JOIN persona per on per.id = c.persona_id_contacto
            LEFT JOIN comuna co on co.id = d.comuna_id 
            LEFT JOIN region re on re.id = co.region_id 
            WHERE p.empresa_id = ? 
            AND DATEDIFF(CURDATE() , p.deleteAt) < 30
            AND p.IsDelete = 1
            group by p.id
            ORDER BY p.deleteAt asc;");

            $stmt->bind_param("ii", $empresa_id, $empresa_id);
            $stmt->execute();

            $result = $stmt->get_result();

            while ($data = $result->fetch_object()) {
                $deleteEvents[] = $data;
            }
            return $deleteEvents;
        } catch (Exception $err) {
            $conn->desconectar();
            return false;
        }
    } catch (Exception $e) {
        $conn->desconectar();
        return array("error" => true);
    }
}


function deleteEvent($empresa_id, $event_id)
{

    try {
        $conn = new bd();
        $conn->conectar();
        $mysqli = $conn->mysqli;

        $stmt = $mysqli->prepare("UPDATE proyecto set IsDelete = 1, deleteAt = CURDATE() WHERE empresa_id = ? and id = ? ;");

        $stmt->bind_param("ii", $empresa_id, $event_id);
        $stmt->execute();

        $conn->desconectar();
        return true;
    } catch (Exception $err) {
        $conn->desconectar();
        return false;
    }
}

function returnEventToList($empresa_id, $event_id)
{

    try {
        $conn = new bd();
        $conn->conectar();
        $mysqli = $conn->mysqli;

        $stmt = $mysqli->prepare("UPDATE proyecto set IsDelete = 0, deleteAt = NULL  WHERE empresa_id = ? and id = ? ;");

        $stmt->bind_param("ii", $empresa_id, $event_id);
        $stmt->execute();

        $conn->desconectar();
        return true;
    } catch (Exception $err) {
        $conn->desconectar();
        return false;
    }
}

function updateEventStatusFromEventList($status_id,$empresa_id,$event_id){
    try {
        $conn = new bd();
        $conn->conectar();
        $mysqli = $conn->mysqli;

        $stmt = $mysqli->prepare("UPDATE proyecto set status_id = ?  WHERE empresa_id = ? and id = ? ;");

        $stmt->bind_param("sii", $status_id,$empresa_id, $event_id);
        $stmt->execute();

        $conn->desconectar();
        return true;
    } catch (Exception $err) {
        $conn->desconectar();
        return false;
    }
}

