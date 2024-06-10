    <?php

    // require_once('../bd/bd.php');
    // header('Content-Type: application/json');


    error_log('categoria.php accessed at ' . date('Y-m-d H:i:s'));
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type');

    $json = file_get_contents('php://input');
    $data = json_decode($json);


    // if (isset($data->empresaId)) {
    //     echo json_encode(GetCategorias($data->empresaId));
    // } else {
    //     echo json_encode(['error' => 'Invalid input']);
    // }

    // return json_encode(GetCategorias($data->empresaId));

    function GetCategorias($empresaId){
        
        $conn = new bd();
        $conn->conectar();

        $response = [];

        $querySelectCategorias ="SELECT c.id,c.nombre  from categoria c 
        INNER JOIN categoria_has_item chi on chi.categoria_id = c.id 
        INNER JOIN producto p on p.categoria_has_item_id =chi.id 
        where p.empresa_id = $empresaId
        GROUP BY c.nombre";

        // return $querySelectCategorias; 

        $responseBd = $conn->mysqli->query($querySelectCategorias);

        while($dataResponseBd = $responseBd->fetch_object()){

            $response []= $dataResponseBd;
            
        }

        return $response;

    }