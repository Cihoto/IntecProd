<?php
if ($_POST) {
    require_once(__DIR__ . '/../bd/ConnectionManager.php');

    $json = file_get_contents('php://input');
    $data = json_decode($json);

    $action = $data->action;

    // Realiza la acción correspondiente según el valor de 'action'
    switch ($action) {
        case 'getRegiones':
            $regiones = getRegiones();
            echo json_encode($regiones);
            break;

        default:
            echo 'Invalid action.';
            break;
    }
} else {
    require_once(__DIR__ . '/ws/bd/ConnectionManager.php');
}

    function getRegiones(){
        $conn = getDBConnection(); // Auto-managed connection
        $regiones = [];
        $queryRegiones = 'SELECT id, region FROM region';
        if($responseRegion = $conn->mysqli->query($queryRegiones)){
            while($dataRegiones = $responseRegion->fetch_object()){
                $regiones[] = $dataRegiones;
            }
        }
        // $conn->desconectar(); // Auto-closed by ConnectionManager
        return $regiones;
    }

//   require_once(__DIR__ . '/ws/bd/ConnectionManager.php');

//     function getRegiones(){
//         $conn = getDBConnection(); // Auto-managed connection
//         $conn->conectar();

//         $regiones = [];
//         $queryRegiones = 'Select id, region from region';
//         if($responseRegion = $conn->mysqli->query($queryRegiones)){
//             while($dataRegiones = $responseRegion->fetch_object()){
//                 $regiones[] = $dataRegiones;
//             }
//         }
//         return $regiones;
//     }
?>