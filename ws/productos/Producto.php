<?php
// session_start();

if ($_POST || $_SERVER['REQUEST_METHOD'] === 'POST') {
    // $empresaId = 1;
    $json = file_get_contents('php://input');
    $data = json_decode($json);
    require_once('../bd/bd.php');


    $action = $data->action;
    
    // Realiza la acción correspondiente según el valor de 'action'
    switch ($action) {
        case 'sortProducts':
            // Recibe el parámetro requestJson
            $requestJson = $data->requestJson;

            // Llama a la función sortProducts y devuelve el resultado
            $sortedProducts = sortProducts($requestJson);
            echo json_encode($sortedProducts);
            break;

        case 'getProductos':
            // Recibe el parámetro empresaId
            $empresaId = $data->empresaId;

            $productos = getProductos($empresaId);
            echo json_encode($productos);
            break;
        case 'getAllMyProductsToList':
            // Recibe el parámetro empresaId
            $empresaId = $data->empresaId;

            $productos = getAllMyProductsToList($empresaId);
            echo json_encode($productos);
            break;
        case 'customProdSearch':
            // Recibe el parámetro empresaId
            $request = $data->request;
            $empresaId = $data->empresaId;

            $productos = customProdSearch($request, $empresaId);
            echo json_encode($productos);
            break;

        case 'GetProductDataById':
            // Recibe el parámetro empresaId
            $product_id = $data->product_id;

            $productos = GetProductDataById($product_id);
            echo json_encode($productos);
            break;

        case 'addProd':
            // Recibe el parámetro jsonCreateProd
            $jsonCreateProd = $data->request;

            // Llama a la función addProd y devuelve el resultado
            $addProdResponse = addProd($jsonCreateProd);
            echo $addProdResponse;
            break;
        case 'dropAssigmentProduct':
            // Recibe el parámetro jsonCreateProd
            $idProject = $data->idProject;
            // Llama a la función addProd y devuelve el resultado
            $droppedIds = dropAssigmentProduct($idProject);
            echo $droppedIds;
            break;
        case 'GetAvailableProducts':
            $empresaId = $data->empresaId;
            // Llama a la función GetAvailableProducts y devuelve el resultado
            $products = json_encode(GetAvailableProducts($empresaId));
            echo $products;
            break;
        case 'assignProductToProject':
            // Recibe el parámetro jsonCreateProd
            $request = $data->request;

            // Llama a la función addProd y devuelve el resultado
            $assignProductResponse = assignProductToProject($request);
            echo json_encode($assignProductResponse);
            break;
        case 'GetUnavailableProductsByDate':
            // Recibe el parámetro jsonCreateProd
            $request = $data->request;
            $empresa_id = $data->empresa_id;
            // Llama a la función addProd y devuelve el resultado
            $response = GetUnavailableProductsByDate($request, $empresa_id);
            echo json_encode($response);
            break;
        case 'AssignOthersToProject':
            // Recibe el parámetro jsonCreateProd
            $request = $data->request;
            $project_id = $data->project_id;
            // Llama a la función addProd y devuelve el resultado
            $response = AssignOthersToProject($request, $project_id);
            echo json_encode($response);
            break;
        case 'GetAllProductsByBussiness':
            // Recibe el parámetro jsonCreateProd
            $empresa_id = $data->empresa_id;
            // Llama a la función addProd y devuelve el resultado
            $response = GetAllProductsByBussiness($empresa_id);
            echo json_encode($response);
            break;
        case 'assignProductJSONToProject':
            // Recibe el parámetro jsonCreateProd
            $empresa_id = $data->empresa_id;
            $event_id = $data->event_id;
            $json = $data->json;
            // Llama a la función addProd y devuelve el resultado
            $response = assignProductJSONToProject($json, $empresa_id, $event_id);
            echo json_encode($response);
            break;
        case 'assignOtherProdsToEvent':
            // Recibe el parámetro jsonCreateProd
            $request = $data->request;
            // Llama a la función addProd y devuelve el resultado
            $response = assignOtherProdsToEvent($request);
            echo json_encode($response);
            break;
        case 'getCatsAndSubCatsByBussiness':
            // Recibe el parámetro jsonCreateProd
            $empresa_id = $data->empresa_id;
            // Llama a la función addProd y devuelve el resultado
            $response = getCatsAndSubCatsByBussiness($empresa_id);
            echo json_encode($response);
            break;
        case 'insertCatsOnArr':
            $empresa_id = $data->empresa_id;
            $arrCats = $data->arrCats;
            $response = insertCatsOnArr($empresa_id, $arrCats);
            echo json_encode($response);
            break;
        case 'insertSubCatOnArr':
            $empresa_id = $data->empresa_id;
            $arrCats = $data->arrCats;
            $response = insertSubCatOnArr($empresa_id, $arrCats);
            echo json_encode($response);
            break;
        case 'getProductById':
            $empresa_id = $data->empresa_id;
            $product_id = $data->product_id;
            $response = getProductById($empresa_id, $product_id);
            echo json_encode($response);
            break;
        case 'addProdsMasiva':
            $empresa_id = $data->empresa_id;
            $request = $data->request;
            $response = addProdsMasiva($request, $empresa_id);
            echo json_encode($response);
            break;
        case 'updateProductById':
            $request = $data->request;
            $empresa_id = $data->empresa_id;
            $product_id = $data->product_id;
            $response = updateProductById($request, $empresa_id, $product_id);
            echo json_encode($response);
        case 'createNewProduct':
            $request = $data->request;
            $response = insertNewProduct($request);
            echo json_encode($response);
            break;
        case 'getCategorias':
            $empresaId = $data->empresaId;
            $categorias = GetCategorias($empresaId);
            echo json_encode($categorias);
            break;
        case 'test_1':
            $catid = $data->catid;
            $subcatId = $data->subcatId;
            $response = insertOrGetCategorieHasSubCategorie($catid, $subcatId);
            echo json_encode($response);
            break;
        default:
            echo 'Invalid action.';
            break;
    }
} else {
    require_once('./ws/bd/bd.php');
}

function sortProducts($requestJson)
{
    $conn = new bd();
    $conn->conectar();
    $data = $requestJson;
    $item = $data->item;
    $categoria = $data->categoria;
    $tipo = $data->tipo;
    $queryProd = "";
    $productos = [];

    if ($tipo === "categoria") {
        $queryProd = "SELECT i.item as Item ,c.nombre as categoria, p.nombre as nombre, p.precio_arriendo as arriendo, p.precio_compra as compra ,
                          m.marca as marca, inv.cantidad
                            from producto p 
                            INNER JOIN inventario inv on inv.producto_id  = p.id
                            INNER JOIN categoria_has_item chi on chi.id = p.categoria_has_item_id 
                            INNER JOIN categoria c on c.id = chi.categoria_id 
                            INNER JOIN marca m on m.id = p.marca_id 
                            INNER JOIN item i on i.id  = chi.item_id 
                            WHERE LOWER(c.nombre) = '" . strtolower($categoria) . "' and p.empresa_id = 1
                            GROUP BY p.nombre";
    }

    if ($tipo === "item") {
        $queryProd = "SELECT i.item as Item ,c.nombre as categoria, p.nombre as nombre, p.precio_arriendo as arriendo, p.precio_compra as compra, 
                        m.marca as marca, inv.cantidad
                        from producto p 
                        INNER JOIN inventario inv on inv.producto_id  = p.id
                        INNER JOIN categoria_has_item chi on chi.id =p.categoria_has_item_id 
                        INNER JOIN categoria c on c.id = chi.categoria_id 
                        INNER JOIN marca m on m.id = p.marca_id 
                        INNER JOIN item i on i.id  = chi.item_id 
                        WHERE LOWER(i.item) = '" . strtolower($item) . "' and LOWER(c.nombre)= '" . strtolower($categoria) . "' and p.empresa_id = 1
                        GROUP BY p.nombre";
    }

    $responseBdProd = $conn->mysqli->query($queryProd);
    while ($dataItems = $responseBdProd->fetch_object()) {
        $productos[] = $dataItems;
    }

    $conn->desconectar();
    if (count($productos) === 0) {
        return $productos;
    }
    return $productos;
}


function getProductos($empresaId)
{
    $conn = new bd();
    $conn->conectar();

    $productos = [];
    $queryProductos = "SELECT p.id, p.nombre, c.nombre as categoria, i.item, p.precio_arriendo, inv.cantidad FROM producto p 
        INNER JOIN empresa e on e.id = p.empresa_id 
        INNER JOIN categoria_has_item chi on chi.id = p.categoria_has_item_id 
        INNER JOIN categoria c on c.id = chi.categoria_id 
        LEFT JOIN item i on i.id  = chi.item_id 
        INNER JOIN inventario inv on inv.producto_id  = p.id 
        WHERE e.id = $empresaId";

    if ($responseProductos = $conn->mysqli->query($queryProductos)) {
        while ($dataProductos = $responseProductos->fetch_object()) {
            $productos[] = $dataProductos;
        }
    }
    $conn->desconectar();
    return $productos;
}
function getAllMyProductsToList($empresaId)
{
    $conn = new bd();
    $conn->conectar();

    $productos = [];
    $queryProductos = "SELECT p.id as product_id, p.nombre as nombre_producto, c.nombre as categoria, 
        i.item as subcategoria, inv.cantidad as stock, p.precio_arriendo 
        FROM producto p 
        INNER JOIN empresa e on e.id = p.empresa_id 
        INNER JOIN categoria_has_item chi on chi.id = p.categoria_has_item_id 
        INNER JOIN categoria c on c.id = chi.categoria_id 
        LEFT JOIN item i on i.id  = chi.item_id 
        INNER JOIN inventario inv on inv.producto_id  = p.id 
        WHERE e.id = $empresaId
        and p.isDelete = 0";

    if ($responseProductos = $conn->mysqli->query($queryProductos)) {
        while ($dataProductos = $responseProductos->fetch_object()) {
            $productos[] = $dataProductos;
        }
    }
    $conn->desconectar();
    return $productos;
}
function customProdSearch($request, $empresaId)
{
    $conn = new bd();
    $conn->conectar();

    $categoriaWhere = "";
    $subcategoriaWhere = "";

    if ($request->cat !== "") {
        $categoriaWhere = "AND c.id = $request->cat";
    }
    if ($request->cat === "all") {
        $categoriaWhere = "  ";
    }

    if ($request->subcat !== "") {
        $subcategoriaWhere = "AND i.id = $request->subcat";
    }
    if ($request->subcat === "all") {
        $subcategoriaWhere = "  ";
    }

    if ($request->subcat !== "" || $request->subcat !== null) {
        $request->subcat = "AND i.id = $request->subcat";
    }

    $productos = [];
    $queryProductos = "SELECT p.id as product_id, p.nombre as nombre_producto,c.nombre as categoria,
    i.item as subcategoria,inv.cantidad as stock,
    p.precio_arriendo  
    FROM producto p 
    INNER JOIN empresa e on e.id = p.empresa_id  
    INNER JOIN categoria_has_item chi on chi.id = p.categoria_has_item_id  
    INNER JOIN categoria c on c.id = chi.categoria_id  
    INNER JOIN item i on i.id  = chi.item_id  
    INNER JOIN inventario inv on inv.producto_id  = p.id 
    WHERE e.id = $empresaId and p.isDelete = 0   $categoriaWhere $subcategoriaWhere";

    // return array($queryProductos);

    if ($responseProductos = $conn->mysqli->query($queryProductos)) {
        while ($dataProductos = $responseProductos->fetch_object()) {
            $productos[] = $dataProductos;
        }
        $conn->desconectar();
        return array("success" => true, "data" => $productos);
    } else {
        $conn->desconectar();
        return array("error" => true);
    }
}

function GetProductDataById($product_id)
{
    $conn =  new bd();
    $conn->conectar();

    $queryGetProduct = "SELECT * FROM productos ";
}


function GetAvailableProducts()
{
    $conn = new bd();
    $conn->conectar();
    $products = [];


    $queryGetAvailable = "SELECT  p.id, 
        p.nombre, 
        cat.nombre as categoria,
        it.item,
        p.precio_arriendo,
        i.cantidad as stock,
        php.cantidad as assigned,
        pro.fecha_inicio,
        pro.fecha_termino,
        phe.estado_id  as estado
        FROM proyecto_has_producto php 
        RIGHT JOIN proyecto_has_estado phe on phe.proyecto_id = php.proyecto_id 
        RIGHT JOIN producto p on p.id = php.producto_id
        INNER JOIN inventario i on i.producto_id  = p.id
        INNER JOIN categoria_has_item chi on chi.id = p.categoria_has_item_id 
        INNER JOIN categoria cat on cat.id = chi.categoria_id
        INNER JOIN item it on it.id = chi.item_id 
        LEFT join proyecto pro on pro.id = php.proyecto_id
        WHERE p.empresa_id = 1";

    $responseDB = $conn->mysqli->query($queryGetAvailable);
    while ($dataResponseBd = $responseDB->fetch_object()) {
        $products[] = $dataResponseBd;
    }
    $conn->desconectar();
    return $products;
}

function assignProductToProject($request)
{
    $conn = new bd();
    $conn->conectar();
    $arrayResponse = [];

    foreach (array_slice($request, 0, 1) as $req) {
        if (isset($req->idProject)) {
            $idProject = $req->idProject;
            $queryIfAssigned = "SELECT * FROM proyecto_has_producto php WHERE php.proyecto_id = $idProject";
            if ($conn->mysqli->query($queryIfAssigned)->num_rows > 0) {
                $qdelete = "DELETE FROM proyecto_has_producto WHERE proyecto_id =$idProject";
                $conn->mysqli->query($qdelete);
            }
        }
    }

    foreach ($request as $req) {

        $idProject = $req->idProject;
        $idProduct = $req->idProduct;
        $price = $req->price;
        $quantity = $req->quantity;

        $query = "INSERT INTO proyecto_has_producto
                    (proyecto_id, producto_id, cantidad, arriendo)
                    VALUES($idProject, $idProduct, $quantity, $price);";

        if ($conn->mysqli->query($query)) {
            array_push($arrayResponse, array("Asignado" => array("id" => $idProduct, "descontados" => $quantity)));
        } else {
            array_push($arrayResponse, array("NoAsignado" => array("id" => $idProduct)));
        }
    }

    $conn->desconectar();
    return $arrayResponse;
    // return $query;
}

function dropAssigmentProduct($idProject)
{
    $conn = new bd();
    $conn->conectar();

    $queryIfAssigned = "SELECT * FROM proyecto_has_producto php WHERE php.proyecto_id = $idProject";

    if ($conn->mysqli->query($queryIfAssigned)->num_rows > 0) {

        $qdelete = "DELETE FROM proyecto_has_producto WHERE proyecto_id =$idProject";
        $conn->mysqli->query($qdelete);
    }
    $conn->desconectar();
    return true;
}


function addProdsMasiva($requestProds, $empresa_id)
{

    try {

        $conn = new bd();
        $conn->conectar();

        $today = date('Y-m-d');
        $inserted_counter = 0;

        $notInsertedData = [];

        // "categoria"
        // "item"
        // "categoria_id"
        // "subCat_id"
        // "nombre"
        // "marca"
        // "modelo"
        // "stock"
        // "precioCompra"
        // "precioArriendo"
        // 'sku'    

        foreach ($requestProds as $key => $request) {
            $catHasSub_id = '';
            $marca_id = "NULL";

            $queryGetCatHasSub = "SELECT * FROM categoria_has_item chi 
            WHERE chi.categoria_id = $request->categoria_id 
            AND chi.item_id = $request->subCat_id;";

            if ($response = $conn->mysqli->query($queryGetCatHasSub)) {
                $request->categoria_id = intval($request->categoria_id);
                $request->subCat_id = intval($request->subCat_id);
                if ($response->num_rows > 0) {
                    while ($data = $response->fetch_object()) {
                        $catHasSub_id = $data->id;
                    }
                } else {
                    if (is_numeric($request->categoria_id) && is_numeric($request->subCat_id)) {
                        $queryInsertChi = "INSERT INTO u136839350_intec.categoria_has_item (categoria_id, item_id) 
                        VALUES($request->categoria_id, $request->subCat_id);";

                        // return $queryInsertChi;

                        if ($conn->mysqli->query($queryInsertChi)) {
                            $catHasSub_id = $conn->mysqli->insert_id;
                        } else {
                            continue;
                        }
                    } else {
                        return array("$request->categoria_id" => $request->categoria_id, "$request->subCat_id" => $request->subCat_id);
                        continue;
                    }
                }
            } else {
                return array("error" => true, "message" => "no se a podido asociar su categoria y subcategoria, intente nuevamente");
            }

            if ($request->marca !== "") {

                $queryGetMarcaId = "SELECT * from marca m where UPPER(m.marca) = UPPER('$request->marca')";

                if ($response = $conn->mysqli->query($queryGetMarcaId)) {


                    if ($response->num_rows > 0) {
                        $marca_id = $response->fetch_object()->id;
                    } else {
                        $queryInsertBrand = "INSERT INTO u136839350_intec.marca (marca, createAt,isDelete) 
                        VALUES('$request->marca', '$today',0);";

                        $conn->mysqli->query($queryInsertBrand);
                        $marca_id = $conn->mysqli->insert_id;
                    }
                } else {
                    continue;
                }
            } else {
                $marca_id = "NULL";
            }

            if (!is_numeric($request->precioCompra)) {
                $request->precioCompra = 0;
            }
            if (!is_numeric($request->precioArriendo)) {
                $request->precioArriendo = 0;
            }

            $queryInsertProduct = "INSERT INTO u136839350_intec.producto 
            (nombre, `desc`, marca_id, categoria_has_item_id,precio_compra, precio_arriendo, createAt, IsDelete,  empresa_id)
            VALUES( '$request->nombre', NULL, $marca_id, $catHasSub_id, $request->precioCompra, $request->precioArriendo, '$today',0, $empresa_id);";
            // return $queryInsertProduct;
            if ($response = $conn->mysqli->query($queryInsertProduct)) {
                $inserted_counter++;
                $prod_id = $conn->mysqli->insert_id;
                $queryInsertStock = "INSERT INTO inventario (producto_id, cantidad, createAt) 
                VALUES($prod_id," . intval($request->stock) . ", '$today');";

                if ($conn->mysqli->query($queryInsertStock)) {
                } else {
                    continue;
                }
            } else {
                array_push($notInsertedData, $request);
                continue;
            }
        }

        return array("success" => true, "insert_count" => $inserted_counter, "total" => count($requestProds));
    } catch (Exception $e) {
        return array("fatalError" => true, "message" => "No hemos podido completar su solicitud, intente nuevamente");
    };
}



function addProd($jsonCreateProd)
{
    $conn = new bd();
    $conn->conectar();

    return $jsonCreateProd;

    $data = json_decode($jsonCreateProd);
    $productoArr = $data;
    $today = date('Y-m-d');
    $jsonErrMarca = [];
    $jsonErrItemHasClass = [];
    $err = false;

    foreach ($jsonCreateProd as $key => $value) {

        $err = false;
        $nombre = $value->nombre;
        $marca = $value->marca;
        $modelo = $value->modelo;
        $categoria = $value->categoria;
        $item = $value->item;
        $stock = $value->stock;
        $precioCompra = $value->precioCompra;
        $precioArriendo = $value->precioArriendo;

        $queryIdMarca = $conn->mysqli->query("Select m.id  from marca m where LOWER(m.marca) ='" . strtolower($marca) . "'");

        if ($queryIdMarca->num_rows === 0) {
            array_push($jsonErrMarca, array(
                "nombre" => $nombre,
                "marca" => $marca,
                "modelo" => $modelo,
                "categoria" => $categoria,
                "item" => $item,
                "stock" => $stock,
                "precioCompra" => $precioCompra,
                "precioArriendo" => $precioArriendo
            ));
            $err = true;
        } else {
            $dataBdResponse = $queryIdMarca->fetch_object();
            $idMarca = $dataBdResponse->id;
        }

        if (!$err) {

            $queryItemHasId = $conn->mysqli->query("SELECT chi.id FROM categoria_has_item chi 
                INNER JOIN categoria c on c.id =chi.categoria_id 
                INNER JOIN item i on i.id = chi.item_id 
                where LOWER(c.nombre)='" . strtolower($categoria) . "' AND LOWER(i.item) ='" . strtolower($item) . "'");

            if ($queryItemHasId->num_rows === 0) {

                $queryCreateItem = "INSERT INTO item(item, createAt, IsDelete)VALUES('" . $item . "','" . $today . "',0)";
                $queryCreateCategoria = "INSERT INTO categoria(nombre, createAt, IsDelete)VALUES('" . $categoria . "','" . $today . "',0)";

                $conn->mysqli->query($queryCreateItem);
                $insertedItem = $conn->mysqli->insert_id;
                $conn->mysqli->query($queryCreateCategoria);
                $insertedCategoria =  $conn->mysqli->insert_id;
                $conn->mysqli->query("INSERT INTO categoria_has_item(categoria_id, item_id)VALUES($insertedCategoria, $insertedItem)");
                array_push($jsonErrItemHasClass, array(
                    "nombre" => $nombre,
                    "marca" => $marca,
                    "modelo" => $modelo,
                    "categoria" => $categoria,
                    "item" => $item,
                    "stock" => $stock,
                    "precioCompra" => $precioCompra,
                    "precioArriendo" => $precioArriendo
                ));
                $err = true;
            } else {
                $dataBdResponse = $queryItemHasId->fetch_object();
                $cathasitemId = $dataBdResponse->id;
            }

            if (!$err) {

                $queryProducto = "INSERT INTO producto
                    (nombre, marca_id, categoria_has_item_id, codigo_barra, precio_compra, precio_arriendo, createAt, IsDelete, empresa_id)
                    VALUES('" . $nombre . "'," . $idMarca . "," . $cathasitemId . ", '11011001'," . $precioCompra . "," . $precioArriendo . ", '" . $today . "', 0,1)";



                if ($conn->mysqli->query($queryProducto)) {

                    $idProducto = $conn->mysqli->insert_id;

                    $queryInventario = "INSERT INTO inventario
                                        (producto_id, cantidad, createAt)
                                        VALUES($idProducto, $stock , $today)";

                    if ($conn->mysqli->query($queryInventario)) {
                    }
                }
            }
        }
    }

    return json_encode(array("total" => count($jsonCreateProd), "errMarca" => $jsonErrMarca, "errHasItem" => $jsonErrItemHasClass));
}

function GetUnavailableProductsByDate($request, $empresa_id)
{
    $conn = new bd();
    $conn->conectar();

    $fecha_inicio = $request->data->fecha_inicio;
    $fecha_termino = $request->data->fecha_termino;

    $unavailableProducts = [];
    // $queryGetUnavailables ="SELECT php.*, phe.estado_id,p.fecha_inicio,p.fecha_termino  FROM proyecto_has_producto php 
    // INNER JOIN proyecto p ON p.id = php.proyecto_id
    // INNER JOIN proyecto_has_estado phe on phe.proyecto_id = p.id 
    // WHERE phe.estado_id = 2
    // AND p.fecha_inicio >= '$fecha_inicio' and p.fecha_termino <= '$fecha_termino'
    // AND p.empresa_id = $empresa_id";
    $queryGetUnavailables = "SELECT php.*, phe.estado_id,p.fecha_inicio,p.fecha_termino  FROM proyecto_has_producto php 
        INNER JOIN proyecto p ON p.id = php.proyecto_id
        INNER JOIN proyecto_has_estado phe on phe.proyecto_id = p.id 
        WHERE phe.estado_id = 2
        AND p.fecha_inicio >= '$fecha_inicio' AND p.fecha_inicio <= '$fecha_termino'
        OR p.fecha_termino >= '$fecha_inicio' AND p.fecha_termino <= '$fecha_termino'
        AND p.empresa_id = 1;";

    // return $queryGetUnavailables;

    if ($responseDb = $conn->mysqli->query($queryGetUnavailables)) {

        while ($dataDb = $responseDb->fetch_object()) {
            $unavailableProducts[] = $dataDb;
        }
        $conn->desconectar();
        return array("success" => true, "data" => $unavailableProducts);
    } else {

        $conn->desconectar();
        return array("error" => true, "data" => $unavailableProducts);
    }
}


function GetAllProductsByBussiness($empresa_id)
{
    $conn = new bd();
    $conn->conectar();
    $products = [];

    $query = "SELECT p.*, inv.cantidad,c.nombre as categoria, i.item  FROM producto p
        INNER JOIN categoria_has_item chi on chi.id = p.categoria_has_item_id 
        INNER JOIN categoria c on c.id = chi.categoria_id 
        LEFT JOIN item i on i.id = chi.item_id
        INNER JOIN inventario inv on inv.producto_id = p.id 
        where p.empresa_id  = $empresa_id";

    if ($responseDb = $conn->mysqli->query($query)) {

        while ($dataDb = $responseDb->fetch_object()) {
            $products[] = $dataDb;
        }
        $conn->desconectar();
        return array("success" => true, "data" => $products);
    } else {
        $conn->desconectar();
        return array("error" => true, "data" => $products);
    }
}


function AssignOthersToProject($request, $project_id)
{
    $conn = new bd();
    $conn->conectar();
    $counter = 0;

    $arrayLength = count($request);
    $insertvalues = "";

    if ($arrayLength > 0) {
        foreach ($request as $key => $other_prod) {
            if ($key < $arrayLength) {
                if ($key === $arrayLength - 1) {
                    $insertvalues .= "('$other_prod->detalle', $other_prod->cantidad, $other_prod->total,$project_id)";
                } else {
                    $insertvalues .= "('$other_prod->detalle', $other_prod->cantidad, $other_prod->total,$project_id),";
                }
            }
        }
        $query = "INSERT INTO u136839350_intec.proyecto_has_otros_productos
            (detalle, cantidad, valor,project_id)
            VALUES" . $insertvalues;
        if ($conn->mysqli->query($query)) {
            $conn->desconectar();
            return array("success" => true, "message" => "Se han agregado otros productos al proyecto");
        } else {
            $conn->desconectar();
            return array("error" => true, "message" => "No se han podido agregar todos los otros productos al proyecto");
        }
    }
}

function assignProductJSONToProject($json, $empresa_id, $event_id)
{
    $conn = new bd();
    $conn->conectar();


    $queryInsert = "";

    if ($conn->mysqli->query($queryInsert)) {
        return array("success" => true, "message" => "JSON Object has been assigned successfuly");
    } else {
        return array("error" => true, "message" => "JSON Object hasn't been assigned");
    }
}

function assignOtherProdsToEvent($request)
{
    $conn = new bd();
    $conn->conectar();
    $counter = 0;
    $totalexec = count($request->request);


    $queryClearOldData = "DELETE FROM proyecto_has_otros_productos
        WHERE project_id = $request->event_id";

    if (!$conn->mysqli->query($queryClearOldData)) {
        return array("error" => true, "message" => "Fatal Error");
    }

    foreach ($request->request as $key => $otherProd) {
        $queryInsert = "INSERT INTO u136839350_intec.proyecto_has_otros_productos
            (detalle, cantidad, valor, project_id)
            VALUES('$otherProd->detalle', $otherProd->cantidad, $otherProd->total, $request->event_id);";
        if ($conn->mysqli->query($queryInsert)) {
            $counter++;
        }
    }
    if ($counter === $totalexec) {
        return array("success" => true, "message" => "Others Prods has been assigned successfuly");
    } else {
        return array("error" => true, "message" => "Others Prods hasn't been assigned");
    }
}


function getCatsAndSubCatsByBussiness($empresa_id)
{
    $conn = new bd();
    $conn->conectar();

    $categorias = [];
    $subCategorias = [];
    $allSubCats = [];


    $queryCategorias = "SELECT * FROM categoria c WHERE c.empresa_id = $empresa_id";

    $querySubcategorias = "SELECT i.item , c.nombre, i.id subcat_id, c.id as cat_id  from item i 
        INNER JOIN categoria_has_item chi on chi.item_id = i.id 
        INNER JOIN categoria c on c.id =chi.categoria_id 
        LEFT JOIN producto p on p.categoria_has_item_id = chi.id
        where c.empresa_id = $empresa_id
        group by i.id;";

    $allSubCatsQuery = "SELECT * from item where empresa_id = $empresa_id";


    if ($result = $conn->mysqli->query($queryCategorias)) {
        while ($data = $result->fetch_object()) {
            $categorias[] = $data;
        }
    }
    if ($result = $conn->mysqli->query($querySubcategorias)) {
        while ($data = $result->fetch_object()) {
            $subCategorias[] = $data;
        }
    }
    if ($result = $conn->mysqli->query($allSubCatsQuery)) {
        while ($data = $result->fetch_object()) {
            $allSubCats[] = $data;
        }
    }

    return array("success" => true, "cats" => $categorias, "subcats" => $subCategorias, "allSubCats" => $allSubCats);
}


function insertCatsOnArr($empresa_id, $arrCats)
{

    try {
        $conn = new bd();
        $conn->conectar();
        $today = date('Y-m-d');
        $arrayLength = count($arrCats);
        $insertvalues = "";
        if ($arrayLength > 0) {
            foreach ($arrCats as $key => $catData) {
                if ($key < $arrayLength) {
                    if ($key === $arrayLength - 1) {
                        $insertvalues .= "('$catData->nombre', '', '$today', 0, $empresa_id)";
                    } else {
                        $insertvalues .= "('$catData->nombre', '', '$today', 0, $empresa_id),";
                    }
                }
            }
        }
        $queryInsertCategorie = "INSERT INTO categoria 
        (nombre, `desc`, createAt,  IsDelete, empresa_id)
        VALUES $insertvalues";

        if ($conn->mysqli->query($queryInsertCategorie)) {
            $message = "Categoría insertada";
            if (count($arrCats) > 1) {
                $message = "Categorías insertadas";
            }
            return array("success" => true, "message" => $message);
        }
    } catch (Exception $error) {
        return array("fatalError" => true, "message" => "Tenemos problemas para procesar tu solicitud, intenta nuevamente", "asd" => $error);
    }
}


function getProductById($empresa_id, $product_id)
{

    try {
        $conn = new bd();
        $conn->conectar();

        $productData = [];

        $queryGetProduct = "SELECT p.*,
        i.id as subcat_id,
        c.id as categorie_id,
        inv.cantidad as stock,
        c.nombre as categorie,
        i.item as subcatgeogie,
        ma.marca as marca FROM producto p 
        LEFT JOIN categoria_has_item chi on chi.id = p.categoria_has_item_id 
        LEFT JOIN categoria c on c.id = chi.categoria_id 
        LEFT JOIN item i on i.id = chi.item_id 
        LEFT JOIN inventario inv on inv.producto_id = p.id 
        LEFT JOIN marca ma on ma.id = p.marca_id 
        WHERE p.id = $product_id 
        and p.empresa_id = $empresa_id;";

        // return $qu   eryGetProduct;

        if ($response = $conn->mysqli->query($queryGetProduct)) {
            while ($data = $response->fetch_object()) {
                $productData = $data;
            }
            return array("success" => true, "data" => $productData, "message" => "success");
        } else {
            return array("error" => true, "message" => "No se ha podido completar la solicitud, intente nuevamente");
        }
    } catch (Exception $error) {
        return array("fatalError" => true, "message" => "Tenemos problemas para procesar tu solicitud, intenta nuevamente", "asd" => $error);
    }
}
function insertSubCatOnArr($empresa_id, $arrCats)
{

    try {
        $conn = new bd();
        $conn->conectar();
        $today = date('Y-m-d');
        $arrayLength = count($arrCats);
        $insertvalues = "";



        if ($arrayLength > 0) {
            foreach ($arrCats as $key => $catData) {
                if ($key < $arrayLength) {
                    if ($key === $arrayLength - 1) {
                        $insertvalues .= "('$catData->nombre', '$today', 0, $empresa_id)";
                    } else {
                        $insertvalues .= "('$catData->nombre', '$today', 0, $empresa_id),";
                    }
                }
            }
        }
        $queryInsertCategorie = "INSERT INTO item 
        (item, createAt,  IsDelete,  empresa_id) 
        VALUES $insertvalues";

        if ($conn->mysqli->query($queryInsertCategorie)) {
            $message = "Subcategoría insertada";
            if (count($arrCats) > 1) {
                $message = "Subcategorías insertadas";
            }
            return array("success" => true, "message" => $message);
        }
    } catch (Exception $error) {
        return array("fatalError" => true, "message" => "Tenemos problemas para procesar tu solicitud, intenta nuevamente", "asd" => $error);
    }
}

function updateProductById($request, $empresa_id, $product_id)
{

    try {
        $conn = new bd();
        $conn->conectar();
        $today = date('Y-m-d');
        $insertvalues = "";

        $nomProd = $request->nomProd;
        $stockProd = $request->stockProd;
        $catProd = $request->catProd;
        $subCatProd = $request->subCatProd;
        $brandProd = $request->brandProd;
        $priceProd = $request->priceProd;
        $rentPriceProd = $request->rentPriceProd;

        $chi = insertOrGetCategorieHasSubCategorie($catProd, $subCatProd);
        $brand_id = 0;
        // return 1;

        // $queryGetChi = "SELECT * FROM categoria_has_item chi 
        // WHERE chi.categoria_id = $catProd
        // AND chi.item_id = $subCatProd
        // limit 1;";

        // if($response = $conn->mysqli->query($queryGetChi)){

        //     // return $queryGetChi;

        //     if ($response->num_rows > 0) {
        //         // Si hay resultados, extraer el ID
        //         $data = $response->fetch_object();
        //         $chi = $data->id;
        //     } else {
        //         // Si no hay resultados, insertar y obtener el nuevo ID
        //         $insertChi = "INSERT INTO u136839350_intec.categoria_has_item (categoria_id, item_id)
        //                       VALUES ($catProd, $subCatProd)";

        //         if ($conn->mysqli->query($insertChi)) {
        //             $chi = $conn->mysqli->insert_id;
        //         } else {
        //             return array("error" => true);
        //         }
        //     }

        // }else{
        //     return array("error"=>true);
        // }

        $queryGetBrand = "SELECT * FROM marca m WHERE LOWER(m.marca) = LOWER('$brandProd')";

        if ($response = $conn->mysqli->query($queryGetBrand)) {
            if ($response->num_rows > 0) {
                $data = $response->fetch_object();
                $response = $data->id;
            } else {
                $insertBrand = "INSERT INTO u136839350_intec.marca (marca, createAt, modifiedAt, IsDelete, deleteAt) 
                VALUES('$brandProd', '$today', NULL, NULL, NULL);";

                if ($response = $conn->mysqli->query($insertBrand)) {
                    $brand_id = $conn->mysqli->insert_id;
                }
            }
        } else {
            return array("error" => true);
        }

        // $queryInsertProd = "INSERT INTO u136839350_intec.producto 
        // (nombre, marca_id, categoria_has_item_id, codigo_barra, precio_compra, precio_arriendo, createAt, modifiedAt, IsDelete, deleteAt, empresa_id) 
        // VALUES('', $brand_id, $chi, '', $priceProd, $rentPriceProd, '', NULL, NULL, NULL, 0);";

        $queryUpdateProd = "UPDATE u136839350_intec.producto SET 
        nombre = '$nomProd',
        marca_id = $brand_id,
        categoria_has_item_id = $chi,
        codigo_barra = '',
        precio_compra = $priceProd,
        precio_arriendo = $rentPriceProd,
        modifiedAt = '$today'
        WHERE id = $product_id
        AND empresa_id=$empresa_id;";



        if ($conn->mysqli->query($queryUpdateProd)) {

            $updateStockQuerry = "UPDATE u136839350_intec.inventario SET 
            cantidad = $stockProd,
            modifiedAt='$today'
            WHERE producto_id = 0;";

            $successStock = false;
            while (!$successStock) {
                if ($conn->mysqli->query($queryUpdateProd)) {
                    $successStock = true;
                } else {
                    return array("error" => true);
                }
            }
            return array("success" => true);
        }
    } catch (Exception $error) {
        return array("fatalError" => true, "message" => "Tenemos problemas para procesar tu solicitud, intenta nuevamente");
    }
}



function insertNewProduct($request){
    $conn = new bd();

    try {
        $conn = new bd();
        $conn->conectar();
        $mysqli = $conn->mysqli;

        $createNomProd = $request->createNomProd;
        $createStockProd = $request->createStockProd;
        $createCatProd = $request->createCatProd;
        $createSubCatProd = $request->createSubCatProd;
        $createBrandProd = $request->createBrandProd;
        $createPriceProd = $request->createPriceProd;
        $createRentPriceProd = $request->createRentPriceProd;
        $empresaId = $request->empresaId;

        $today = date('Y-m-d');

        $brand_id = insertOrGetBrand($createBrandProd);
        $chiId = insertOrGetCategorieHasSubCategorie($createCatProd, $createSubCatProd);

        if ($createPriceProd === "") {
            $createPriceProd = 0;
        } else {
            $createPriceProd = intval($createPriceProd);
        }
        if ($createRentPriceProd === "") {
            $createRentPriceProd = 0;
        } else {
            $createRentPriceProd = intval($createRentPriceProd);
        }

        $stmt = $mysqli->prepare("INSERT INTO 
        producto (nombre, marca_id, categoria_has_item_id, precio_compra, precio_arriendo, createAt, empresa_id) 
        VALUES(?, ? , ?, ? , ?, ? , ? );");
        $stmt->bind_param("siiiisi", $createNomProd, $brand_id, $chiId, $createPriceProd, $createRentPriceProd, $today, $empresaId);
        $stmt->execute();

        $prodId = $stmt->insert_id;

        insertOrUpdateStock($prodId, $createStockProd);
        $conn->desconectar();
        return true;
    } catch (Exception $err) {
        $conn->desconectar();
        return false;
    }
}

function insertOrGetBrand($brand)
{

    // return $brand;
    // return "SELECT m.id FROM marca m where UPPER(m.marca)  = UPPER($brand);";
    try {
        $conn = new bd();
        $conn->conectar();
        $mysqli = $conn->mysqli;

        $today = date('Y-m-d');
        $stmt = $mysqli->prepare("SELECT m.id FROM marca m where UPPER(m.marca) = UPPER(?);");
        $stmt->bind_param("s", $brand);
        $stmt->execute();
        $results = $stmt->get_result()->fetch_object();

        // return $results->fetch_object()->id;

        if (!isset($results->id)) {

            $stmt = $mysqli->prepare("INSERT INTO u136839350_intec.marca (marca, createAt) 
            VALUES(?, ?);");
            $stmt->bind_param("ss", $brand, $today);
            $stmt->execute();
            $results = $stmt->get_result();

            $conn->desconectar();
            return $stmt->insert_id;
        }

        $conn->desconectar();
        return $results->id;
    } catch (Exception $err) {
        $conn->desconectar();
        return false;
    }
}


function insertOrGetCategorieHasSubCategorie($catId, $subcatId)
{

    // return $subcatId;
    try {
        $conn = new bd();
        $conn->conectar();
        $mysqli = $conn->mysqli;

        // if($subcatId == ""){$subcatId = 0;}
        // return "SELECT chi.id FROM categoria_has_item chi where chi.categoria_id = $catId and chi.item_id = $subcatId;";

        $stmt = $mysqli->prepare("SELECT chi.id FROM categoria_has_item chi where chi.categoria_id = ? and chi.item_id = ? ;");
        $stmt->bind_param("ii", $catId, $subcatId);
        $stmt->execute();
        $results = $stmt->get_result()->fetch_object();

        if (!isset($results->id)) {

            $stmt = $mysqli->prepare("INSERT INTO u136839350_intec.categoria_has_item (categoria_id, item_id) VALUES(?,?);");
            $stmt->bind_param("ii", $catId, $subcatId);
            $stmt->execute();
            $conn->desconectar();
            return $stmt->insert_id;
        }

        $conn->desconectar();
        return $results->id;
    } catch (Exception $err) {
        $conn->desconectar();
        return false;
    }
}
function insertOrUpdateStock($prodId, $stock)
{

    try {
        $conn = new bd();
        $conn->conectar();
        $mysqli = $conn->mysqli;
        $today = date('Y-m-d');

        $stmt = $mysqli->prepare("SELECT * FROM inventario i WHERE i.producto_id  = ?;");
        $stmt->bind_param("i", $prodId);
        $stmt->execute();
        $results = $stmt->get_result()->fetch_object();

        if (!isset($results->id)) {

            $stmt = $mysqli->prepare("INSERT INTO u136839350_intec.inventario (producto_id, cantidad, createAt)
            VALUES(?, ?, ?);");
            $stmt->bind_param("iis", $prodId, $stock, $today);
            $stmt->execute();
            $conn->desconectar();
            return $stmt->insert_id;
        } else {
            $stmt = $mysqli->prepare("UPDATE inventario set cantidad = ? WHERE id = ?");
            $stmt->bind_param("ii", $stock, $prodId);
            $stmt->execute();
            $conn->desconectar();
            return $stmt->insert_id;
        }
    } catch (Exception $err) {
        $conn->desconectar();
        return false;
    }
}



