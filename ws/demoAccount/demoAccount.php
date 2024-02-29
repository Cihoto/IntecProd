<?php
header("Content-Type: text/html;charset=utf-8");

if ($_POST) {
    require_once('../bd/bd.php');

    $json = file_get_contents('php://input');
    $data = json_decode($json);

    $action = $data->action;

    // Realiza la acción correspondiente según el valor de 'action'
    switch ($action) {
        case 'createDemoAccount':
            $empresa_id = $data->empresa_id;
            $result = createDemoAccount($empresa_id);
            break;
        case 'AddClientForm':
            $request = $data->request;
            $empresa_id = $data->empresa_id;
            $result = AddClientForm($request, $empresa_id);
            break;
        case 'getDemoProducts':
            $empresa_id = $data->empresa_id;
            $result = getDemoProducts($empresa_id);
            break;
        case 'addStockToProducts':
            $empresa_id = $data->empresa_id;
            $result = addStockToProducts($empresa_id);
            break;
        case 'addCategorieHasItemToDemoAccount':
            $empresa_id = $data->empresa_id;
            $result = addCategorieHasItemToDemoAccount($empresa_id);
            break;
        case 'getCatsHasItem_demoAccount':
            $empresa_id = $data->empresa_id;
            $result = getCatsHasItem_demoAccount($empresa_id);
            break;
        case 'addPersonalToDemoAccount':
            $empresa_id = $data->empresa_id;
            $result = addPersonalToDemoAccount($empresa_id);
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


function returnBadReq()
{
    return array("error" => true, "status" => 400);
}


function createDemoAccount($empresa_id)
{
    $conn = new bd();
    $conn->conectar();
    $mysqli = $conn->mysqli;

    $empresa_id = intval($empresa_id);
    $empresa_id = 6;

    if ($empresa_id === "") {
        return returnBadReq();
    } else {
        $empresa_id = filter_var($empresa_id, FILTER_VALIDATE_INT);
    }

    if (!addProductsToDemoAccount($empresa_id)) {
        return returnBadReq();
    }

    if (!addCategorie($empresa_id)) {
        return returnBadReq();
    }
    if (!addSubcategories($empresa_id)) {
        return returnBadReq();
    }

    if (!addStockToProducts($empresa_id)) {
        return returnBadReq();
    }

    if (!addVehiclesToDemoAccount($empresa_id)) {
        return returnBadReq();
    }

    // if (!addPersonalToDemoAccount($empresa_id)){
    //     return returnBadReq();
    // }
    // return addPersonalToDemoAccount($empresa_id);

    // return array("success"=>true);

}

function addProductsToDemoAccount($empresa_id)
{
    $conn = new bd();
    $conn->conectar();
    $mysqli = $conn->mysqli;
    try {
        $stmt = $mysqli->prepare("SELECT addProductsToDemoAccount(?);");
        $stmt->bind_param("i", $empresa_id);
        $stmt->execute();
        return true;
    } catch (Exception $err) {
        $conn->desconectar();
        return false;
    }
}

function addCategorie($empresa_id)
{
    try {
        $conn = new bd();
        $conn->conectar();
        $mysqli = $conn->mysqli;

        $stmt = $mysqli->prepare("SELECT addCategoriesToDemoAccount(?);");
        $stmt->bind_param("i", $empresa_id);
        $stmt->execute();
        $conn->desconectar();
        return true;
    } catch (Exception $err) {
        $conn->desconectar();
        return false;
    }
}
function addSubcategories($empresa_id)
{
    try {
        $conn = new bd();
        $conn->conectar();
        $mysqli = $conn->mysqli;

        $stmt = $mysqli->prepare("SELECT addSubCategoriesToDemoAccount(?);");
        $stmt->bind_param("i", $empresa_id);
        $stmt->execute();
        $conn->desconectar();
        return true;
    } catch (Exception $err) {
        $conn->desconectar();
        return false;
    }
}

function addStockToProducts($empresa_id)
{
    $conn = new bd();
    $conn->conectar();
    $mysqli = $conn->mysqli;

    try {
        $ALL_PRODS = getDemoProducts($empresa_id);
        // return $ALL_PRODS['demo'];
        $TO_QUERY = [];

        foreach ($ALL_PRODS['demo'] as $prod) {
            $nombre_prod = strtoupper($prod->nombre);
            $PROD_E = null;
            foreach ($ALL_PRODS['prods'] as $inv) {
                // array_push($TO_QUERY_false,[$nombre_prod,strtoupper($inv->nombre)]);             
                // return $ALL_PRODS['prods'];
                if ($nombre_prod === strtoupper($inv->nombre)) {
                    $PROD_E = $inv;
                    break;
                }
            }
            if ($PROD_E) {
                $arrToPush = [
                    'stock' => $prod->stock,
                    'prod_id' => $PROD_E->id
                ];
                array_push($TO_QUERY, $arrToPush);
            }
        }
        // Filtrar elementos nulos
        $TO_QUERY = array_filter($TO_QUERY, function ($p) {
            return $p !== null;
        });
        foreach ($TO_QUERY as $prod) {
            $prod_id = $prod['prod_id'];
            $stock = $prod['stock'];
            $stmt = $mysqli->prepare("INSERT INTO u136839350_intec.inventario 
            (producto_id, cantidad, createAt) 
            VALUES(?, ?, CURDATE());");
            $stmt->bind_param("ii", $prod_id, $stock);
            $stmt->execute();

            $conn->desconectar();

            return true;
        }
        return true;
    } catch (Exception $err) {
        $conn->desconectar();
        return false;
    }
}

function addVehiclesToDemoAccount($empresa_id){

    try {
        $conn = new bd();
        $conn->conectar();
        $mysqli = $conn->mysqli;
        $stmt = $mysqli->prepare("SELECT addVehiclesToDemoAccount(?);");
        $stmt->bind_param("i", $empresa_id);
        $stmt->execute();
        $conn->desconectar();
        return true;
    } catch (Exception $e) {
        $conn->desconectar();
        return false;
    }
}

function getDemoProducts($empresa_id)
{
    $conn = new bd();
    $conn->conectar();
    $mysqli = $conn->mysqli;
    $demo_prods = [];
    $prods = [];

    try {
        $stmt = $mysqli->prepare("SELECT * FROM demo_product");
        $stmt->execute();
        $result = $stmt->get_result();

        while ($data = $result->fetch_object()) {
            $demo_prods[] = $data;
        }

        $stmt = $mysqli->prepare("SELECT * FROM producto where empresa_id = ?;");

        $stmt->bind_param("i", $empresa_id);

        $stmt->execute();
        $result = $stmt->get_result();

        while ($data = $result->fetch_object()) {
            $prods[] = $data;
        }
        $conn->desconectar();
        return array("demo" => $demo_prods, "prods" => $prods);
    } catch (Exception $err) {
        $conn->desconectar();
        return false;
    }
}

function addCategorieHasItemToDemoAccount($request)
{

    $conn = new bd();
    $conn->conectar();
    $mysqli = $conn->mysqli;
}

function addPersonalToDemoAccount($empresa_id)
{
    $cargos = [];
    $especialidades = [];
    $personas = [
        [
            "nombre" => "Carlos Urrutia",
            "apellido" => "",
            "rut" => "18.905.324-2",
            "email" => "carlos@example.com",
            "telefono" => "+56923416523"
        ],
        [
            "nombre" => "Juan Cáceres",
            "apellido" => "",
            "rut" => "15.223.698-5",
            "email" => "juan@example.com",
            "telefono" => "+56953918356"
        ],
        [
            "nombre" => "Romina Galleguillos",
            "apellido" => "",
            "rut" => "19.418.426-4",
            "email" => "romina@example.com",
            "telefono" => "+56988327310"
        ]
    ];

    $personal = [
        [
            "usuario_id" => NULL,
            "neto" => 90000,
            "cargo_id" => 1,
            "especialidad_id" => 0,
            "tipo_contrato_id" => 4,
            "createAt" => date("Y-m-d"),
            "modifiedAt" => NULL,
            "IsDelete" => NULL,
            "deleteAt" => NULL,
            "empresa_id" => 0
        ],
        [
            "persona_id" => 2,
            "usuario_id" => NULL,
            "neto" => 0,
            "cargo_id" => 0,
            "especialidad_id" => 0,
            "tipo_contrato_id" => 5,
            "createAt" => date("Y-m-d"),
            "modifiedAt" => NULL,
            "IsDelete" => NULL,
            "deleteAt" => NULL,
            "empresa_id" => 0
        ],
        [
            "persona_id" => 3,
            "usuario_id" => NULL,
            "neto" => 0,
            "cargo_id" => 0,
            "especialidad_id" => 0,
            "tipo_contrato_id" => 6,
            "createAt" => date("Y-m-d"),
            "modifiedAt" => NULL,
            "IsDelete" => NULL,
            "deleteAt" => NULL,
            "empresa_id" => 0
        ]
    ];
    return addCargosAndEspecialidades($empresa_id);
    try{

        if(!addCargosAndEspecialidades($empresa_id)){ 
            return false;
        }
        $conn = new bd();
        $conn->conectar();
        $mysqli = $conn->mysqli;

        $stmt = $mysqli->prepare("SELECT * FROM cargo WHERE empresa_id = ?;");
        $stmt->bind_param("i", $empresa_id);
        $stmt->execute();
        $result = $stmt->get_result();
        while($data = $result->fetch_object()){
            $cargos [] = $data;
        }

        $stmt = $mysqli->prepare("SELECT * FROM especialidad WHERE empresa_id = ?;");
        $stmt->bind_param("i", $empresa_id);
        $stmt->execute();
        $result = $stmt->get_result();

        while($data = $result->fetch_object()){
            $especialidades [] = $data;
        }

        $stmt = $mysqli->prepare("INSERT INTO u136839350_intec.persona (nombre, apellido, rut, email, telefono) 
        VALUES (?, '', ?, ?,?)");

        $stmt_personal = $mysqli->prepare("INSERT INTO u136839350_intec.personal 
        (persona_id, usuario_id, neto, cargo_id, especialidad_id, tipo_contrato_id, createAt, IsDelete, empresa_id,is_demo) 
        VALUES (?, NULL, ?, ?, ?, ?, CURDATE(), 0, ?,1)");

        $counter = 0;
        foreach ($personas as $key => $persona) {
            $stmt->bind_param("ssss", $persona['nombre'], $persona['rut'],$persona['email'], $persona['telefono']);
            $stmt->execute();

            $persona_id = $stmt->insert_id;

            $stmt_personal->bind_param("iiiiii", $persona_id,$personal[$key]['neto'],$cargos[$counter]->id,
            $especialidades[$counter]->id,$personal[$counter]['tipo_contrato_id'],$empresa_id);

            $stmt_personal->execute();

            $counter ++;
        }   
        $conn->desconectar();
        return array("success");
    } catch (Exception $e) {
        $conn->desconectar();
        return false;
    }
}

function addCargosAndEspecialidades($empresa_id){
    // try{

        $conn = new bd();
        $conn->conectar();
        $mysqli = $conn->mysqli;

        $stmt_cargos = $mysqli->prepare("SELECT addCargoToDemoAccount(?)");
        $stmt_cargos->bind_param("i", $empresa_id);

        $result = $stmt_cargos->execute();

        // return $result;
        if(!$result){
            return false;
        }
        
        $stmt_especialidades = $mysqli->prepare("SELECT addEspecialidadToDemoAccount(?)");
        $stmt_especialidades->bind_param("i", $empresa_id);
        $result_esp = $stmt_especialidades->execute();
        // return $result_esp;
        if(!$result_esp){        
            $stmt_delete_especialidades = $mysqli->prepare("DELETE FROM especialidad where empresa_id = ?");
            $stmt_delete_especialidades->bind_param("i", $empresa_id);
            $result = $stmt_delete_especialidades->execute();
            return false;
        }
        $conn->desconectar();
        return true;

    // }
    // catch(Exception $e){
    //     $conn->desconectar();
    //     return false;
    // }
}

function getCatsHasItem_demoAccount($empresa_id)
{
    $conn = new bd();
    $conn->conectar();
    $mysqli = $conn->mysqli;

    $demo_prods = [];
    $categories = [];
    $subCategories = [];
    $chi_Ids = [];
    try {

        $stmt = $mysqli->prepare("SELECT * FROM demo_product");
        $stmt->execute();
        $result = $stmt->get_result();
        while ($data = $result->fetch_object()) {
            $demo_prods[] = $data;
        }


        $stmt = $mysqli->prepare("SELECT c.nombre ,c.id as cat_id FROM categoria c 
        WHERE c.empresa_id = ?;");

        $stmt->bind_param("i", $empresa_id);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($data = $result->fetch_object()) {
            $categories[] = $data;
        }


        $stmt = $mysqli->prepare("select i.item , i.id as subCat_id from item i
        where i.empresa_id = ?;");
        $stmt->bind_param("i", $empresa_id);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($data = $result->fetch_object()) {
            $subCategories[] = $data;
        }

        // return $categories;
        // return $subCategories;
        // return $demo_prods;

        return array('subcats' => $subCategories, 'categories' => $categories, 'demo_prods' => $demo_prods);

        $cats_name = [];

        // $demo_prods = json_decode($demo_prods,true);
        // $test_Arr = [];
        // foreach($demo_prods as $demo_prod){
        //     // return $demo_prod->categorie;
        //     array_push($cats_name,[$demo_prod->categorie, $demo_prod->subCategorie]);
        //     $demo_categorie = strtoupper($demo_prod->categorie);
        //     $demo_subcategorie = strtoupper($demo_prod->subCategorie);
        //     $cat_id = null;
        //     $subcat_id = null;
        //     foreach ($categories as $key => $cat) {
        //         if(strtoupper($cat->nombre) === $demo_categorie){
        //             $cat_id = $cat->cat_id;
        //             break;
        //         }
        //     }
        //     foreach ($subCategories as $key => $subCat) {
        //         if(strtoupper($subCat->item) === $demo_subcategorie){
        //             $subcat_id = $subCat->subCat_id;
        //             break;
        //         }
        //     }
        //     $test_Arr [] = $cat_id && $subcat_id;
        //     if($cat_id && $subcat_id){
        //         // return $cat_id;
        //         // return $subcat_id;
        //         $arrToPush = [
        //             'cat_id' => $cat_id,
        //             'subCat_id' => $subcat_id
        //         ];
        //         if(count($chi_Ids) === 0){
        //             $chi_Ids[] = $arrToPush;
        //         }else{
        //             $exists = false;
        //             foreach ($chi_Ids as $key => $chi_id) {
        //                 // return $chi_id['cat_id'];
        //                 // return array('1'=>$chi_id[0] ,'1'=>$cat_id,'2'=>$chi_id[1] ,'2'=>$subcat_id);
        //                 if($chi_id['cat_id'] === $cat_id && $chi_id['subCat_id'] === $subcat_id){
        //                    $exists = true;
        //                    break; 
        //                 }
        //             }
        //             if($exists){
        //                 $chi_Ids[] = $arrToPush;
        //             }
        //         }
        //         // return $chi_Ids;
        //     }
        // }

    } catch (Exception $err) {
        return false;
    }
}


