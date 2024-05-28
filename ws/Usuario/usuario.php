<?php
if ($_POST) {
    date_default_timezone_set('America/Santiago');
    require_once('../bd/bd.php');

    $json = file_get_contents('php://input');
    $data = json_decode($json);
    $action = $data->action;

    // Realiza la acción correspondiente según el valor de 'action'
    switch ($action) {
        case 'GetUsuario':
            $email = $data->email;
            $result = GetUsuario($email);
            break;
        case 'GetAllUsuariosByEmpresa':
            $empresa_id = $data->empresa_id;
            $result = GetAllUsuariosByEmpresa($empresa_id);
            break;
        case 'GetUserByUserId':
            $user_id = $data->user_id;
            $result = GetUserByUserId($user_id);
            break;
        case 'GetUserRol':
            $user_id = $data->user_id;
            $result = GetUserRol($user_id);
            break;
        case 'AssignRoles':
            $user_id = $data->user_id;
            $arrayRoles = $data->arrayRoles;

            $result = AssignRoles($user_id, $arrayRoles);
            break;
        case 'LogUser':
            $request = $data->request;
            $result = LogUser($request);
            break;
        case 'CreateUser':
            $request = $data->request;
            $result = CreateUser($request);
            break;
        case 'DeleteUser':
            $user_id = $data->user_id;
            $result = DeleteUser($user_id);
            break;
        case 'DeleteUser':
            $user_id = $data->user_id;
            $result = DeleteUser($user_id);
            break;
        case 'createNewAccount':
            $request = $data->request;
            $result = createNewAccount($request);
            break;
        default:
            $result = false;
            break;
    }
    // Devolver la respuesta como JSON
    header('Content-Type: application/json');
    echo json_encode($result);
} else {
    require_once('./ws/bd/bd.php');
}

function GetUsuario($email)
{
    $conn =  new bd();
    $conn->conectar();
    // $query="SELECT per.email from persona per 
    // INNER JOIN personal p on p.persona_id = per.id 
    // INNER JOIN usuario u on u.id = p.usuario_id
    // where LOWER(per.email) = LOWER('$email')";
    $query = "SELECT * FROM usuario u WHERE LOWER(u.user) = LOWER('$email')";
    // return $query;

    if ($conn->mysqli->query($query)->num_rows > 0) {
        $conn->desconectar();
        return true;
    } else {
        $conn->desconectar();
        return false;
    }
}

function GetAllUsuariosByEmpresa($empresa_id)
{
    $conn =  new bd();
    $conn->conectar();
    $usuarios = [];

    $queryGetAlUsers = "SELECT u.is_deleted , u.empresa_id,u.id as user_id, per.nombre , per.apellido,per.email,u.user as user_email FROM usuario u 
    INNER JOIN personal p on p.usuario_id = u.id 
    INNER JOIN persona per on per.id = p.persona_id
    WHERE u.empresa_id = $empresa_id
    AND p.empresa_id = $empresa_id
    AND  u.is_deleted = 0";

    if ($responseDb = $conn->mysqli->query($queryGetAlUsers)) {
        if ($responseDb->num_rows > 0) {
            while ($dataReponse = $responseDb->fetch_object()) {
                $usuarios[] = $dataReponse;
            }
            return array("success" => true, "data" => $usuarios, "message" => "Se han encontrado " . count($usuarios) . " usuarios");
        } else {
            return array("success" => true, "data" => $usuarios, "message" => "No se han encontrado usuarios");
        }
    } else {
        return array("error", "message" => "Ha ocurrido un error, intente nuevamente");
    }
}

function GetUserByUserId($user_id)
{
    $conn =  new bd();
    $conn->conectar();
}


function GetUserRol($user_id)
{


    $conn =  new bd();
    $conn->conectar();

    $roles = [];
    $userData = [];

    $query = "SELECT * FROM rol_has_usuario rhu 
        inner join rol r on r.id  = rhu.rol_id 
        where rhu.usuario_id  = $user_id";

    $querydatauser = "SELECT u.`user` , LENGTH(u.password) AS pass_length  FROM usuario u WHERE u.id =  $user_id";

    if ($responseDbRoles = $conn->mysqli->query($query)) {
        while ($dataRoles = $responseDbRoles->fetch_object()) {
            $roles[] = $dataRoles;
        }
        $responseDbData = $conn->mysqli->query($querydatauser);
        while ($dataInfoUser = $responseDbData->fetch_object()) {
            $userData[] = $dataInfoUser;
        }
        $conn->desconectar();
        return array("success" => true, "data" => $roles, "user_data" => $userData);
    } else {
        $conn->desconectar();
        return array("error" => true, "message" => "No se ha podido completar la solicitud, por favor intente nuevamente");
    }
}


function getUserRoles($user_id)
{


    try {
    } catch (Exception $e) {
        return array("fatalError" => true, "code" => 400);
    }

    $conn =  new bd();
    $conn->conectar();

    $roles = [];
    $userData = [];

    $query = "SELECT * FROM rol_has_usuario rhu 
        inner join rol r on r.id  = rhu.rol_id 
        where rhu.usuario_id  = $user_id";

    $querydatauser = "SELECT u.`user` , LENGTH(u.password) AS pass_length  FROM usuario u WHERE u.id =  $user_id";

    if ($responseDbRoles = $conn->mysqli->query($query)) {
        while ($dataRoles = $responseDbRoles->fetch_object()) {
            $roles[] = $dataRoles;
        }
        $responseDbData = $conn->mysqli->query($querydatauser);
        while ($dataInfoUser = $responseDbData->fetch_object()) {
            $userData[] = $dataInfoUser;
        }
        $conn->desconectar();
        return array("success" => true, "data" => $roles, "user_data" => $userData);
    } else {
        $conn->desconectar();
        return array("error" => true, "message" => "No se ha podido completar la solicitud, por favor intente nuevamente");
    }
}




function AssignRoles($user_id, $arrayRoles)
{


    try {
        $conn =  new bd();
        $conn->conectar();
        $arrayLength = count($arrayRoles);
        $insertvalues = "";

        $conn->mysqli->query("DELETE FROM rol_has_usuario WHERE usuario_id = $user_id");

        if ($arrayLength === 0) {
            $conn->desconectar();
            return array("success" => true, "message" => "Roles asignados correctamente");
        } else {

            if ($arrayLength > 1) {
                foreach ($arrayRoles as $key => $rol_id) {
                    if ($key < $arrayLength) {
                        if ($key === $arrayLength - 1) {
                            $insertvalues .= "($rol_id->rol_id,$user_id)";
                        } else {

                            $insertvalues .= "($rol_id->rol_id,$user_id),";
                        }
                    }
                }
                $query = "INSERT INTO u136839350_intec.rol_has_usuario (rol_id, usuario_id) VALUES" . $insertvalues;

            } else {
                $query = "INSERT INTO u136839350_intec.rol_has_usuario (rol_id, usuario_id) VALUES(" . $arrayRoles[0]->rol_id . "," . $user_id . ")";
            }

            // return $query;

            if ($conn->mysqli->query($query)) {
                $conn->desconectar();
                return array("success" => true, "message" => "Roles asignados correctamente");
            } else {
                $conn->desconectar();
                return array("error" => true, "message" => "No se ha podido completar el requerimiento, por favor intente nuevamente");
            }
        }
    } catch (Exception $e) {
        return array("fatalError" => true, "code" => 400);
    }
}

function LogUser($request)
{
    $conn =  new bd();
    $conn->conectar();

    $correo = $request->email;
    $pass = $request->pass;
    $roles = [];
    $rolesSession = [];

    $cred_pass = 0;


    $queryUserCredentials = "SELECT `password` FROM usuario u WHERE LOWER(user) = LOWER('$correo')";

    try{
        if($responseCredentials = $conn->mysqli->query($queryUserCredentials)){
            while($data = $responseCredentials->fetch_object()){
                $cred_pass = $data;
            }

            // return $cred_pass;
            // return password_verify($pass, $cred_pass->password);

            if(!password_verify($pass, $cred_pass->password)){
                return array("error"=>true);
            }
        }else{
            return array("error"=>true);
        }
    }catch(Exception $e){
        return array("error"=>true);
        
    }

    $queryGetLogin = "SELECT * FROM usuario u 
    WHERE LOWER(user) = LOWER('$correo') 
    AND LOWER(password) = LOWER('$cred_pass->password')";

    if ($responseBd = $conn->mysqli->query($queryGetLogin)) {
        if ($responseBd->num_rows > 0) {

            while ($dataReponseUser = $responseBd->fetch_object()) {
                $usuario_id = $dataReponseUser->id;
                $empresa_id = $dataReponseUser->empresa_id;
            }
            $personalIds = [];
            $user_name = [];
            $buss_data = [];

            $queryGetPersonalId = "SELECT per.id as 'persona_id',
                 u.id as 'usuario_id',
                 p.id as 'personal_id',
                 per.nombre as user_name
                 FROM personal p 
                INNER JOIN usuario u on u.id = p.usuario_id 
                INNER JOIN persona per on per.id = p.persona_id 
                where u.id = $usuario_id;";
            $queryGetUserNname = "SELECT per.nombre as user_name
                 FROM personal p 
                INNER JOIN usuario u on u.id = p.usuario_id 
                INNER JOIN persona per on per.id = p.persona_id 
                where u.id = $usuario_id;";

            $queryGetBussData = "SELECT datediff(CURDATE(),e.createdAt) AS diff ,e.demo_active, bl.bus_logo_name as bl
            FROM empresa e 
            LEFT JOIN businessLogo bl on bl.bus_logo_id  = e.bus_logo_id 
            WHERE e.id = $empresa_id";

            session_start();
            if ($responseBd = $conn->mysqli->query($queryGetPersonalId)) {
                while ($row = $responseBd->fetch_object()) {
                    $personalIds[] = $row;
                }
                $_SESSION['personal_ids'] = $personalIds;
            }
            if ($responseBd = $conn->mysqli->query($queryGetUserNname)) {
                while ($row = $responseBd->fetch_object()) {
                    $user_name = $row->user_name;
                }
                $_SESSION['user_name'] = $user_name;
            }
            if ($responseBd = $conn->mysqli->query($queryGetBussData)) {
                while ($data = $responseBd->fetch_object()) {
                    $buss_data = $data;
                }
                $_SESSION['buss_data'] = $buss_data;
            }

            $queryGetRol = "SELECT r.id as rol_id, r.rol, u.id FROM usuario u  
                INNER JOIN rol_has_usuario rhu on rhu.usuario_id = u.id
                INNER JOIN rol r on r.id = rhu.rol_id 
                where u.id = $usuario_id";
            $queryGetRoles = "SELECT rhu.rol_id  FROM rol_has_usuario rhu where rhu.usuario_id = $usuario_id";

            $responseRol = $conn->mysqli->query($queryGetRoles);


            $_SESSION["empresa_id"] = $empresa_id;
            if ($responseRol->num_rows > 0) {

                while ($dataRoles = $responseRol->fetch_object()) {
                    $roles[] = $dataRoles;
                }

                for ($i = 0; $i < count($roles); $i++) {
                    array_push($rolesSession, $roles[$i]->rol_id);
                }

                $_SESSION["rol_id"] = $rolesSession;
            } else {
                $_SESSION["rol_id"] = [];
            }
            $conn->desconectar();
            return array("success" => true, "message" => "Excelente", "ref" => true);
        } else {
            $conn->desconectar();
            return array("success" => true, "message" => "Credenciales Erroneas", "ref" => false);
        }
    } else {
        $conn->desconectar();
        return array("error" => true, "message" => "Ha ocurrido un error, intente nuevamente");
    }
}

function CreateUser($request)
{
    $conn = new bd();
    $conn->conectar();
    $today = date('Y-m-d');
    $personal_id = $request->personal_id;
    $email = $request->email;
    $pass = $request->pass;
    $empresa_id = $request->empresa_id;

    $queryInsertUser = "INSERT INTO u136839350_intec.usuario
        (`user`, `password`, createAt, empresa_id)
        VALUES('$email', '".createPass($pass)."', '$today', $empresa_id)";

    if ($conn->mysqli->query($queryInsertUser)) {
        $user_id = $conn->mysqli->insert_id;
        $queryAssignUserToPersonal = "UPDATE personal SET usuario_id = $user_id WHERE id = $personal_id";
        $conn->mysqli->query($queryAssignUserToPersonal);
        $conn->desconectar();
        return array("success" => true, "message" => "Usuario Creado Exsitosamente", "user_id" => $user_id);
    } else {
        $conn->desconectar();
        return array("error" => true, "message" => "Ha ocurrido un error, intente nuevamente");
    }
}

function DeleteUser($user_id)
{

    $conn = new bd();
    $conn->conectar();

    $query = "UPDATE usuario SET is_deleted = 1 WHERE id = $user_id";

    if ($conn->mysqli->query($query)) {
        $conn->desconectar();
        return array("success" => true, "message" => "Usuario eliminado exitosamente");
    } else {
        $conn->desconectar();
        return array("error" => true, "message" => "Ha ocurrido un error por favor intente nuevamente");
    }
}


// NEW BUSSINESS CREATION,
// CREATE A NEW BUSSINESS, THEN HIS FIRST EMPLOYEE
// AFTER THAT WE HAVE 



function createNewAccount($request){
    $conn = new bd();
    $conn->conectar();
    // REQUEST DATA
    $nombre_fanta = $request->nombre_fanta;
    $razon_social = $request->razon_social;
    $rut = $request->rut;
    $address = $request->address;
    $email = $request->email;
    $uName = $request->uName;
    $pass = $request->pass;
    // DATES DATA
    $today = date('Y-m-d');
    $endTrial = date($today, strtotime($today. ' + 7 days'));
    $now = date("Y-m-d H:i:s");  
    // INSERTED IDS FOR POSTERIOR INSERTS
    $datos_facturacion_id = 0;
    $empresa_id = 0;
    $person_id = 0;
    $cargo_id = 0;
    $user_id = 0;
    $especialidad_id = 0;

    $queryInsertDatosFacturacion = "INSERT INTO u136839350_intec.datos_facturacion 
    (razon_social, nombre_fantasia, rut, direccion, correo) 
    VALUES('$razon_social', '$nombre_fanta', '$rut', '$address', '$email');";

    if($response = $conn->mysqli->query($queryInsertDatosFacturacion)){
        $datos_facturacion_id = $conn->mysqli->insert_id;
    }

    if($datos_facturacion_id === 0){
        return array("error"=>true,"message"=>"Intenta nuevamente");
    }

    $queryInsertNewBussiness = "INSERT INTO empresa 
    ( nombre, rut, createdAt, free_trial, start_free, end_free, al_dia, datos_facturacion_id) 
    VALUES('$nombre_fanta', '$rut', '$today', 1, '$today', '$endTrial', 1, $datos_facturacion_id)";


    try{
        if($response = $conn->mysqli->query($queryInsertNewBussiness)){
            $empresa_id =  $conn->mysqli->insert_id;
        }else{
            deleteDatosFacturacion($datos_facturacion_id);
            return array("error"=>true,"message"=>"Intenta nuevamente");
        }
    }catch(Exception $e){
        deleteDatosFacturacion($datos_facturacion_id);
        return array("error"=>true,"message"=>"Intenta nuevamente");
    }


    if($empresa_id === 0){
        deleteDatosFacturacion($datos_facturacion_id);
        return array("error"=>true,"message"=>"No hemos podido crear tu cuenta, intenta nuevamente");
    }

    $queryCreateUser = "INSERT INTO u136839350_intec.usuario 
    (`user`, password, createAt, empresa_id, ultima_conexion, is_deleted) 
    VALUES('$email', '".createPass($pass)."', '$today', $empresa_id, '$now', 0); ";

    try{
        if($conn->mysqli->query($queryCreateUser)){
            $user_id = $conn->mysqli->insert_id;
            // return array("success"=>true,"code"=>200);
        }else{
            deleteDatosFacturacion($datos_facturacion_id);
            deleteEmpresa($empresa_id);
            return array("error"=>true,"code"=>400,"message"=>"Intente nuevamente");
        }
    }catch(Exception $e){
        deleteDatosFacturacion($datos_facturacion_id);
        deleteEmpresa($empresa_id);
        return array("error"=>true,"code"=>400,"message"=>"Intente nuevamente");
    }

    if($user_id === 0){
        deleteDatosFacturacion($datos_facturacion_id);
        deleteEmpresa($empresa_id);
        return array("error"=>true,"code"=>400,"message"=>"Intente nuevamente");
    };


    createPersonalOnNewBussiness($empresa_id,$email,$uName,$user_id);
    createCategorieAndSubcategorieOnNewAccount($empresa_id);


    $tries = 0;
    $queryRol = "INSERT INTO u136839350_intec.rol_has_usuario 
    (rol_id, usuario_id) 
    VALUES (1, $user_id),
    (2, $user_id),
    (3, $user_id),
    (4, $user_id),
    (5, $user_id),
    (6, $user_id),
    (7, $user_id),
    (8, $user_id),
    (9, $user_id),
    (10, $user_id),
    (11, $user_id),
    (12, $user_id),
    (13, $user_id),
    (14, $user_id);";


    while($tries < 9){
        try{
            if($conn->mysqli->query($queryRol)){
                $tries = 123321;
            }else{
                $tries ++;
                deleteDatosFacturacion($datos_facturacion_id);
                deleteEmpresa($empresa_id);
            }
        }catch(Exception $e){
            $tries ++;
        }

    }

    if($tries === 123321){
        return array("success"=>true,"message"=>"su cuenta ha sido registrada exsitosamente junto a su organización");
    }else{
        deleteDatosFacturacion($datos_facturacion_id);
        deleteEmpresa($empresa_id);
        removeuserFromDb($user_id);
        return array("error"=>true,"code"=>400,"message"=>"Intente nuevamente");
    }
}

function createPersonalOnNewBussiness($empresa_id,$email,$uName,$user_id){

    $conn = new bd();
    $conn->conectar();
    $mysqli = $conn->mysqli;

    $cargo = 'Administrador';
    $especialidad = 'Sistemas';
    $today = Date('Y-m-d');


    $queryCargo = "INSERT INTO u136839350_intec.cargo (cargo, empresa_id) VALUES('$cargo',$empresa_id);";
    $queryEspecialidad = "INSERT INTO u136839350_intec.especialidad (especialidad, createAt, empresa_id) 
    VALUES('$especialidad','$today',$empresa_id);";

    $resultCargo = $mysqli->query($queryCargo);
    $cargoId = $mysqli->insert_id;
    
    $resultEspecialidad = $mysqli->query($queryEspecialidad);
    $especialidadId = $mysqli->insert_id;
    
    
    $queryPersona = "INSERT INTO u136839350_intec.persona (nombre, email) VALUES('$uName','$email' );";
    $resultPersona = $mysqli->query($queryPersona);
    $personaId = $mysqli->insert_id;


    $query_personal = "INSERT INTO u136839350_intec.personal 
    (persona_id, usuario_id, neto, cargo_id, especialidad_id, tipo_contrato_id, createAt,  IsDelete, empresa_id) 
    VALUES($personaId,$user_id , 0, $cargoId, $especialidadId, 4, '$today',0,$empresa_id);";
    $resultPersonal = $mysqli->query($query_personal);
    $personal_id = $mysqli->insert_id;


    return $personal_id;
    
}

function createCategorieAndSubcategorieOnNewAccount($empresa_id){

    $conn = new bd();
    $conn->conectar();
    $mysqli = $conn->mysqli;

    $today= Date('Y-m-d');


    $queryCategoria = "INSERT INTO u136839350_intec.categoria (nombre, `desc`, createAt, empresa_id) 
    VALUES('Sin categoría', '', '$today', $empresa_id);";
    $mysqli->query($queryCategoria);
    
    $querySubcategoria = "INSERT INTO u136839350_intec.item (item, createAt, empresa_id) 
    VALUES('Sin Subcategoría', '$today', $empresa_id);";
    $mysqli->query($querySubcategoria);


}

function createPass($pass){

    $randomLength = rand(20,25);

    $options = $opciones = [
        'cost' => 12
    ];

    return password_hash($pass, PASSWORD_BCRYPT, $options);

}

function deleteDatosFacturacion($df_id){

    try{
        $conn = new bd();
        $conn->conectar();
    
        $queryDeleteDatosFaturacion = "DELETE FROM datos_facturacion WHERE id = $df_id ";
        if($conn->mysqli->query($queryDeleteDatosFaturacion)){
            return true;
        }else{
            return false;
        }
    }catch(Exception $e){
        return false;
    }
   

}
function deleteEmpresa($empresa_id){

    try{
        $conn = new bd();
        $conn->conectar();
        $queryDeleteBussiness = "DELETE FROM empresa WHERE id = $empresa_id ";
        if($conn->mysqli->query($queryDeleteBussiness)){
            return true;
        }else{
            return false;
        }
    }catch(Exception $e){
        return false;
    }
   

}
function deletePersona($persona_id){

    try{
        $conn = new bd();
        $conn->conectar();
        $queryDeletePersona = "DELETE FROM persona WHERE id = $persona_id ";
        if($conn->mysqli->query($queryDeletePersona)){
            return true;
        }else{
            return false;
        }
    }catch(Exception $e){
        return false;
    }
   

}
function removeuserFromDb($usuario_id){

    try{
        $conn = new bd();
        $conn->conectar();
        $queryDeleteUser = "DELETE FROM usuario WHERE id = $usuario_id ";
        if($conn->mysqli->query($queryDeleteUser)){
            return true;
        }else{
            return false;
        }
    }catch(Exception $e){
        return false;
    }
   

}
