<?php
  require_once(__DIR__ . '/ws/bd/ConnectionManager.php');

    function getVehiculos($empresaId){
        $conn = getDBConnection(); // Auto-managed connection
        $vehiculos= [];
        $queryVehiculos = "SELECT v.id ,v.patente ,v.personal_id  FROM vehiculo v
                            INNER JOIN personal p on p.id = v.personal_id 
                            INNER JOIN empresa e on e.id = p.empresa_id 
                            WHERE e.id = $empresaId";

        if($responseBdVehiculos = $conn->mysqli->query($queryVehiculos)){
            while($dataVehiculos = $responseBdVehiculos->fetch_object()){
                $vehiculos [] = $dataVehiculos;
            }
        }
        // $conn->desconectar(); // Auto-closed by ConnectionManager
        return $vehiculos;
    }

    function getAssigned($empresaId){
        $conn = getDBConnection(); // Auto-managed connection
        $vehiculos= [];
        $queryVehiculos = "SELECT v.id ,v.patente ,v.personal_id  FROM vehiculo v
                            INNER JOIN personal p on p.id = v.personal_id 
                            INNER JOIN empresa e on e.id = p.empresa_id 
                            WHERE e.id = $empresaId";

        if($responseBdVehiculos = $conn->mysqli->query($queryVehiculos)){
            while($dataVehiculos = $responseBdVehiculos->fetch_object()){
                $vehiculos [] = $dataVehiculos;
            }
        }
        // $conn->desconectar(); // Auto-closed by ConnectionManager
        return $vehiculos;
    }

?>