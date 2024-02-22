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
            $request = $data->request;
            $result = addCliente($request);
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


function createDemoAccount($request)
{
    $conn = new bd();
    $conn->conectar();
    $mysqli = $conn->mysqli;

    $empresa_id = 0;

    if ($request->empresa_id === "") {
        return returnBadReq();
    } else {
        $empresa_id = filter_var($request->empresa_id, FILTER_VALIDATE_EMAIL);
    }

    if (!addProductsToDemoAccount($request->empresa_id)) {
        return returnBadReq();
    }
}

// function createNewDemoAccount($empresa_id){
//     $conn = new bd();
//     $conn->conectar();
//     $mysqli = $conn->mysqli;

//     if(!addProductsToDemoAccount($empresa_id)){
//         return array("error"=>true);
//     }
// }

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
        $TO_QUERY_false = [];


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

            // return $PROD_E;
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
        }

        return $TO_QUERY;
        // return count($TO_QUERY); 



    } catch (Exception $err) {
        return false;
    }
}


function addCategorieHasItemToDemoAccount($empresa_id)
{
    $conn = new bd();
    $conn->conectar();
    $mysqli = $conn->mysqli;

    $demo_prods = [];
    $categories = [];
    $subCategories = [];
    $chi_Ids = [];
    $empresa_id = 6;
    try {

        $stmt = $mysqli->prepare("SELECT * FROM demo_product");
        $stmt->execute();
        $result = $stmt->get_result();
        while ($data = $result->fetch_object()) {
            $demo_prods [] = $data;
        }


        $stmt = $mysqli->prepare("SELECT c.nombre ,c.id as cat_id FROM categoria c 
        WHERE c.empresa_id = ?;");
       
        $stmt->bind_param("i", $empresa_id);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($data = $result->fetch_object()) {
            $categories [] = $data;
        }


        $stmt = $mysqli->prepare("select i.item , i.id as subCat_id from item i
        where i.empresa_id = ?;");
        $stmt->bind_param("i", $empresa_id);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($data = $result->fetch_object()) {
            $subCategories [] = $data;
        }

        // return $categories;
        // return $subCategories;
        // return $demo_prods;

        $cats_name = [];

        // $demo_prods = json_decode($demo_prods,true);
        $test_Arr = [];
        foreach($demo_prods as $demo_prod){

            // return $demo_prod->categorie;
            
            array_push($cats_name,[$demo_prod->categorie, $demo_prod->subCategorie]);
            $demo_categorie = strtoupper($demo_prod->categorie);
            $demo_subcategorie = strtoupper($demo_prod->subCategorie);

            $cat_id = null;
            $subcat_id = null;

            foreach ($categories as $key => $cat) {
                if(strtoupper($cat->nombre) === $demo_categorie){
                    $cat_id = $cat->cat_id;
                    break;
                }
            }

            foreach ($subCategories as $key => $subCat) {
                if(strtoupper($subCat->item) === $demo_subcategorie){
                    $subcat_id = $subCat->subCat_id;
                    break;
                }
            }

            $test_Arr [] = $cat_id && $subcat_id;
            if($cat_id && $subcat_id){
                // return $cat_id;
                // return $subcat_id;
                $arrToPush = [
                    'cat_id' => $cat_id,
                    'subCat_id' => $subcat_id
                ];

                if(count($chi_Ids) === 0){
                    $chi_Ids[] = $arrToPush;
                }else{
                    $exists = false;
                    foreach ($chi_Ids as $key => $chi_id) {
                        
                        // return $chi_id['cat_id'];
                        // return array('1'=>$chi_id[0] ,'1'=>$cat_id,'2'=>$chi_id[1] ,'2'=>$subcat_id);
                        if($chi_id['cat_id'] === $cat_id && $chi_id['subCat_id'] === $subcat_id){
                           $exists = true;
                           break; 
                        }
                    }

                    if($exists){
                        $chi_Ids[] = $arrToPush;
                    }
                }
                // return $chi_Ids;

                
                
            }
            // $stmt = $mysqli->prepare("INSERT INTO u136839350_intec.inventario 
            // (producto_id, cantidad, createAt) 
            // VALUES(?, ?, CURDATE());");

        }



        return array("length"=>count($chi_Ids),"data"=> $test_Arr);

       

        // $stmt = $mysqli->prepare("INSERT INTO u136839350_intec.inventario 
        // (producto_id, cantidad, createAt) 
        // VALUES(?, ?, CURDATE());");

        // $stmt->bind_param("ii", $prod_id, $stock);
        // $stmt->execute();


    } catch (Exception $err) {
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
        // CAMBIAR
        // CAMBIAR
        // CAMBIAR
        // CAMBIAR
        // CAMBIAR
        // CAMBIAR
        // CAMBIAR
        // CAMBIAR
        // CAMBIAR
        // CAMBIAR
        // CAMBIAR
        // CAMBIAR
        // CAMBIAR
        // CAMBIAR
        // CAMBIAR
        // CAMBIAR
        $asd = 6;
        // CAMBIAR
        // CAMBIAR
        // CAMBIAR
        // CAMBIAR
        // CAMBIAR
        // CAMBIAR
        // CAMBIAR
        // CAMBIAR
        // CAMBIAR
        // CAMBIAR
        // CAMBIAR
        // CAMBIAR
        // CAMBIAR
        // CAMBIAR
        // CAMBIAR
        // CAMBIAR
        $stmt->bind_param("i", $asd);

        $stmt->execute();
        $result = $stmt->get_result();

        while ($data = $result->fetch_object()) {
            $prods[] = $data;
        }
        return array("demo" => $demo_prods, "prods" => $prods);
    } catch (Exception $err) {
        return false;
    }
}

function getProductsByBussiness()
{
}
