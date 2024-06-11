<?php

require_once('../../bd/bd.php');
// $json = file_get_contents('php://input');
// $data = json_decode($json);
// $request = $data->request;


// $conn = new bd();
// $conn->conectar();
// $mysqli = $conn->mysqli;

// $now = date('Y-m-d H:i:s');
// $today = date('Y-m-d');

// $cats_subcats =  [];
// $brands = [];


// // GET ALL BRAND IN DB

// $stmt = $mysqli->prepare("SELECT id as brand_id ,marca as brand from marca 
// where IsDelete = 0;");
// // $stmt->bind_param("ssi", $request->categorie,$today,$data->empresaId);
// $stmt->execute();
// $brandDbResponse = $stmt->get_result();

// while ($brands_data = $brandDbResponse->fetch_object()) {
//     $brands[] = $brands_data;
// }






// foreach ($requestProds as $key => $request) {
//     $brandId = 0;

//     $stmt = $mysqli->prepare("INSERT INTO u136839350_intec.categoria 
//     (nombre,  createAt, empresa_id)
//     VALUES(?, ?, ?);");
//     $stmt->bind_param("ssi", $request->categorie, $today, $data->empresaId);
//     $stmt->execute();

//     $request->categorie_id = $stmt->insert_id;

//     $stmt = $mysqli->prepare("INSERT INTO u136839350_intec.item 
//     (item, createAt,  empresa_id) 
//     VALUES(?, ?, ?);");
//     $stmt->bind_param("ssi", $request->subcategorie, $today, $data->empresaId);
//     $stmt->execute();

//     $request->subCat_id = $stmt->insert_id;


//     $stmt = $mysqli->prepare("INSERT INTO u136839350_intec.categoria_has_item 
//     (categoria_id, item_id) 
//     VALUES(?, ?);");
//     $stmt->bind_param("ii", $request->categorie_id, $request->subCat_id);
//     $stmt->execute();

//     $request->chiId = $stmt->insert_id;


//     if (array_search($request->brand, array_column($brands, 'brand')) !== False) {

//         $brandId = $brands['brand_id'];
//         // echo "FOUND";
//     } else {
//         $stmt = $mysqli->prepare("INSERT INTO u136839350_intec.marca 
//         (marca, createAt) 
//         VALUES(?, ?);");
//         $stmt->bind_param("ii", $request->brand, $today);
//         $stmt->execute();
//         $brandId = $stmt->insert_id;

//         array_push($brands,['id'=>$brandId,'brand'=>$request->brand]);
//     }


    
//     $stmt = $mysqli->prepare("INSERT INTO u136839350_intec.producto
//     (nombre, `desc`, marca_id, categoria_has_item_id, codigo_barra, precio_compra, 
//     precio_arriendo, createAt, modifiedAt, IsDelete, deleteAt, empresa_id, is_demo) 
//     VALUES(?, NULL, ?, ?, '11211', ?, ?, ?, NULL, NULL, NULL, ?, 1);");
//     $stmt->bind_param("siiiisi",$request->productName, $brandId, $request->chiId,
//                     $request->purchPrice, $request->rentPrice, $today,
//                     $data->empresaId );
//     $stmt->execute();


// }

// Obtener el cuerpo del request
$json = file_get_contents('php://input');
$data = json_decode($json);

// echo json_encode($data->request);
// exit();
// Validar que los datos han sido recibidos correctamente
if (!$data || !isset($data->request)) {
    echo json_encode(["status" => "error", "message" => "Invalid request data"]);
    exit();
}

$request = $data->request;

$conn = new bd();
$conn->conectar();
$mysqli = $conn->mysqli;

$now = date('Y-m-d H:i:s');
$today = date('Y-m-d');

// Obtener todas las marcas de la base de datos
$brands = [];
$stmt = $mysqli->prepare("SELECT id as brand_id, marca as brand FROM marca WHERE IsDelete = 0");
$stmt->execute();
$brandDbResponse = $stmt->get_result();
while ($brands_data = $brandDbResponse->fetch_object()) {
    $brands[] = $brands_data;
}

foreach ($request as $requestProd) {
    $brandId = 0;

    // Insertar categoría
    $stmt = $mysqli->prepare("INSERT INTO categoria (nombre, createAt, empresa_id) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $requestProd->categorie, $today, $data->empresaId);
    $stmt->execute();
    $requestProd->categorie_id = $stmt->insert_id;

    // Insertar subcategoría
    $stmt = $mysqli->prepare("INSERT INTO item (item, createAt, empresa_id) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $requestProd->subcategorie, $today, $data->empresaId);
    $stmt->execute();
    $requestProd->subCat_id = $stmt->insert_id;

    // Asociar categoría y subcategoría
    $stmt = $mysqli->prepare("INSERT INTO categoria_has_item (categoria_id, item_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $requestProd->categorie_id, $requestProd->subCat_id);
    $stmt->execute();
    $requestProd->chiId = $stmt->insert_id;

    // Buscar o insertar marca
    $brandFound = false;
    foreach ($brands as $brand) {
        if ($brand->brand == $requestProd->brand) {
            $brandId = $brand->brand_id;
            $brandFound = true;
            break;
        }
    }

    if (!$brandFound) {
        $stmt = $mysqli->prepare("INSERT INTO marca (marca, createAt) VALUES (?, ?)");
        $stmt->bind_param("ss", $requestProd->brand, $today);
        $stmt->execute();
        $brandId = $stmt->insert_id;
        $brands[] = (object) ['brand_id' => $brandId, 'brand' => $requestProd->brand];
    }

    // Insertar producto
    $stmt = $mysqli->prepare("INSERT INTO producto
        (nombre, `desc`, marca_id, categoria_has_item_id, codigo_barra, precio_compra, 
        precio_arriendo, createAt, modifiedAt, IsDelete, deleteAt, empresa_id, is_demo)
        VALUES (?, NULL, ?, ?, '11211', ?, ?, ?, NULL, NULL, NULL, ?, 1)");

    $stmt->bind_param("siiiisi", $requestProd->productName, $brandId, $requestProd->chiId,
                      $requestProd->purchPrice, $requestProd->rentPrice, $today,
                      $data->empresaId);

    $stmt->execute();
}
$conn->desconectar();
echo json_encode(["status" => "success", "message" => "Request processed successfully"]);
?>






