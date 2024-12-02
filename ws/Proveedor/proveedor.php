<?php
    if ($_POST) {
        require_once('../bd/bd.php');

        $json = file_get_contents('php://input');
        $data = json_decode($json);
        $action = $data->action;
        
        if(isset($data->vehicleData)){
            $datav = $data->vehicleData;
        }

        switch ($action) {
            case 'addNewProvider':
                $empresa_id = $data->empresa_id;
                $request = $data->request;
                $providerResponse = addNewProvider($request,$empresa_id);
                echo json_encode($providerResponse);
                break;
            case 'getAllProviderByBussiessId':
                $empresa_id = $data->empresa_id;
                $providerResponse = getAllProviderByBussiessId($empresa_id);
                echo json_encode($providerResponse);
                break;
            default:
                echo 'Invalid action.';
                break;
        }

    }else{
        require_once('./ws/bd/bd.php');
    }


    function addNewProvider($request,$empresa_id){
    
        $conn = new bd();
        $conn->conectar();



        $persona_id = 0;
        $datosFacturacion_id = 0; 
        $proveedor_id = 0;

        $nombre_fantasia = $request->nombre_fantasia;
        $razon_social = $request->razon_social;
        $rut = $request->rut;
        $nombre = $request->nombre;
        $correo = $request->correo;
        $telefono = $request->telefono;


        $queryInsertPersona = "INSERT INTO u136839350_intec.persona
        (nombre, apellido, rut, email, telefono)
        VALUES('$nombre', '', '', '$correo', '$telefono');";

        if($conn->mysqli->query($queryInsertPersona)){
            $persona_id = $conn->mysqli->insert_id;
        }else{
            $conn->desconectar();
            return array("success"=>false);
        }

        $queryInsertDatosFacturacion = "INSERT INTO u136839350_intec.datos_facturacion
        (razon_social, nombre_fantasia, rut, direccion, correo)
        VALUES('$razon_social', '$nombre_fantasia', '$rut', '', '');";

        if($conn->mysqli->query($queryInsertDatosFacturacion)){
            $datosFacturacion_id = $conn->mysqli->insert_id;
        }else{
            $querydelete = "DELETE FROM u136839350_intec.persona WHERE id = $persona_id;";
            $conn->mysqli->query($querydelete);
            $conn->desconectar();
            return array("success"=>false);
        }


        $queryInsertProvider = "INSERT INTO u136839350_intec.proveedor
        (persona_id_contacto, empresa_id, datos_facturacion_id) VALUES
        ($persona_id, $empresa_id, $datosFacturacion_id);";

        if($conn->mysqli->query($queryInsertProvider)){
            $proveedor_id = $conn->mysqli->insert_id;
            $conn->desconectar();
            return array("success"=>true, "message"=>"Proveedor agregado exitosamente");
        }else{
            $querydelete = "DELETE FROM u136839350_intec.persona WHERE id = $persona_id;";
            $conn->mysqli->query($querydelete);
            $querydelete = "DELETE FROM u136839350_intec.datos_facturacion WHERE id = $datosFacturacion_id;";
            $conn->mysqli->query($querydelete);
            $conn->desconectar();
            return array("success"=>false);
        }
    }


    function getAllProviderByBussiessId($empresa_id){
        $conn = new bd();
        $conn->conectar();
        $providers = [];
    
        $query = "SELECT pro.id, df.nombre_fantasia, per.nombre FROM proveedor pro 
        INNER JOIN persona per ON per.id = pro.persona_id_contacto 
        inner join datos_facturacion df on df.id = pro.datos_facturacion_id 
        WHERE pro.empresa_id = '$empresa_id'; ";
    
        if($bdResponse =  $conn->mysqli->query($query)){
            while($dataProviders = $bdResponse->fetch_object()){
                $providers[] = $dataProviders;
            }
            $conn->desconectar();
            return array("success"=>true,"providers"=>$providers);
        }else{
            $conn->desconectar();
            return array("false"=>true);
        }
    }
?>