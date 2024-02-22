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

            $queryPersonalAsignados = "SELECT p.id ,CONCAT(per.nombre,' ',per.apellido) as nombre,
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

            $queryGetEventSchedules = "SELECT * FROM event_has_schedules ehs WHERE ehs.event_id = 89;";

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
            WHERE phf.event_id = $idProject;";
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
                "files" => $files
            )
        ));
    } catch (Exception $e) {
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
        return $projects;
    } else {
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
        return array("success" => array("message" => "Evento modificado exitosamente"));
    } else {
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
        return true;
    } else {
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
        return array("success" => true, "data" => $record);
    } else {
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
    $queryProyectos = "SELECT p.id, p.nombre_proyecto,e.estado , p.status_id as 'estado_id',
    CONCAT(per.nombre,' ', per.apellido) as nombreCliente, 
    df.nombre_fantasia as nombre_fantasia ,
    CONCAT(d.direccion, ' ',d.numero,', ',co.comuna,', ',re.region) as direccion,
    p.fecha_inicio ,p.fecha_termino,phv.proyecto_id as 'phv', php.proyecto_id as 'php',  phf.event_id as 'phf',
    et.nombre as event_type, pfr.income as income, pfr.cost as cost,(SELECT persona.nombre 
    FROM personal pers
    INNER JOIN persona on persona.id = pers.persona_id 
    INNER JOIN proyecto proye on proye.owner = pers.id
    WHERE proye.id = p.id AND p.empresa_id = $empresa_id) as owner
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
    group by p.id
	ORDER BY p.fecha_inicio asc;";
    // -- where p.empresa_id = 1 and p.fecha_inicio >= '2023-11-23'

    // return $queryProyectos;
    if ($responseBd = $conn->mysqli->query($queryProyectos)) {
        while ($dataProject = $responseBd->fetch_object()) {
            $projects[] = $dataProject;
        }
    }

    // return $queryProyectos;
    return $projects;
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
    WHERE proye.id = p.id AND p.empresa_id = $empresa_id) as owner
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
    WHERE proye.id = p.id AND p.empresa_id = $empresa_id) as owner
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
    WHERE proye.id = p.id AND p.empresa_id = $empresa_id) as owner
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
    WHERE proye.id = p.id AND p.empresa_id = $empresa_id) as owner
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
    WHERE proye.id = p.id AND p.empresa_id = $empresa_id) as owner
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
    WHERE proye.id = p.id AND p.empresa_id = $empresa_id) as owner
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
    WHERE proye.id = p.id AND p.empresa_id = $empresa_id) as owner
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
    GROUP BY p.id
	ORDER BY p.fecha_inicio desc;";

    if ($responseBd = $conn->mysqli->query($queryProyectos_with_date)) {
        while ($dataProject = $responseBd->fetch_object()) {
            $projects_with_Date[] = $dataProject;
        }
    }
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
    WHERE proye.id = p.id AND p.empresa_id = $empresa_id) as owner
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
    GROUP BY p.id
	ORDER BY p.fecha_termino desc;";

    if ($responseBd = $conn->mysqli->query($queryProyectos_with_date)) {
        while ($dataProject = $responseBd->fetch_object()) {
            $projects_with_Date[] = $dataProject;
        }
    }
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
    if ($request->owner === "") {
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

    $queryUpdate = "UPDATE proyecto
    SET nombre_proyecto='$request->nombre_proyecto', fecha_inicio='$request->fecha_inicio', 
    fecha_termino='$request->fecha_termino', comentarios='$request->comentarios', 
    IsDelete=0, cliente_id=$request->cliente_id,owner=$request->owner, status_id=$request->status_id,event_type_id=$request->event_type_id
    WHERE id=$event_id AND empresa_id = $empresa_id;";

    if ($conn->mysqli->query($queryUpdate)) {
        return array("success" => true, "message" => "Detalles del evento actualizados con exito");
    } else {
        return array("error" => "error", "message" => "No se han podido realizar los detalles del evento");
    }
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
        return array("success" => true, "message" => "Address has been removed successfully from event");
    } else {
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
    // QUERY SECTION

    $queryGetCurAndLastMonthEventQuantity = "SELECT COUNT(p.id) AS total_current_month,
	(SELECT COUNT(p.id)  from proyecto p 
        where p.fecha_inicio >=  DATE_SUB(DATE(CONCAT_WS('-', YEAR(CURRENT_DATE()), MONTH(CURRENT_DATE())  , '01')),INTERVAL 1 MONTH) 
        and  p.fecha_inicio <=LAST_DAY(DATE_SUB(DATE(CONCAT_WS('-', YEAR(CURRENT_DATE()), MONTH(CURRENT_DATE())  , '01')),INTERVAL 1 MONTH))
        and p.empresa_id = $empresa_id) AS total_last_month
        from proyecto p 
    where p.fecha_inicio >=    DATE(CONCAT_WS('-', YEAR(CURRENT_DATE()), MONTH(CURRENT_DATE()) , '01'))
    and  p.fecha_inicio >=  LAST_DAY(CURDATE())
    and p.empresa_id = $empresa_id";

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
    and p.fecha_inicio <=LAST_DAY(DATE_SUB(DATE(CONCAT_WS('-', YEAR(CURRENT_DATE()), MONTH(CURRENT_DATE())  , '01')),INTERVAL 1 MONTH))
    and p.empresa_id = $empresa_id) AS last_month_income
    FROM project_finance_resume pfr 
    INNER JOIN proyecto p on p.id = pfr.event_id
    where p.fecha_inicio >=    DATE(CONCAT_WS('-', YEAR(CURRENT_DATE()), MONTH(CURRENT_DATE()) , '01'))
    and  p.fecha_inicio >=  LAST_DAY(CURDATE())
    and p.empresa_id = $empresa_id;";



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

    return array(
        "success" => true,
        "event_quanity_cur_last_month" => $currentAndLastMonthEventQuantity,
        "incomeResume" => $incomeResume
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

            return array("success" => true, "message" => "Event finance updated");
        } else {
            return array("success" => true, "message" => "Event finance couldn't be updated");
        }
    } else {


        $query = "INSERT INTO project_finance_resume (event_id, income, cost) 
        VALUES($request->event_id, $request->ingreso, $request->costo);";


        if ($conn->mysqli->query($query)) {

            return array("success" => true, "message" => "Event finance created");
        } else {
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

    $query = "SELECT p.id, p.nombre_proyecto, d.direccion as 'address' ,p.fecha_inicio ,e.estado as estado, e.id as estado_id FROM proyecto p  
    LEFT join event_type et on et.id = p.event_type_id  
    LEFT join direccion d on d.id = p.address_id  
    LEFT JOIN estado e on e.id = p.status_id  where p.empresa_id = $empresa_id 
    $status $date $type";

    if ($response = $conn->mysqli->query($query)) {
        while ($data = $response->fetch_object()) {
            $eventos[] = $data;
        }
        return array("success" => true, "events" => $eventos);
    } else {
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
            return array("success" => true, "data" => $events);
        } else {
            return array("error" => true);
        }
    } catch (Exception $e) {
        return array("error" => $e);
    }
}
function getEventDay($empresa_id, $date)
{

    try {
        $conn = new bd();
        $conn->conectar();
        $events = [];
        $query = "SELECT * FROM proyecto p WHERE p.fecha_inicio = '$date' and p.empresa_id = $empresa_id";

        if ($response = $conn->mysqli->query($query)) {
            while ($data = $response->fetch_object()) {
                $events[] = $data;
            }
            return array("success" => true, "data" => $events);
        } else {
            return array("error" => true);
        }
    } catch (Exception $e) {
        return array("error" => "Intente Nuevamente");
    }
}
