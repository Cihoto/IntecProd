<?php
  require_once(__DIR__ . '/ws/bd/ConnectionManager.php');

    function getProductos($empresaId){
        $conn = getDBConnection(); // Auto-managed connection

        $productos = [];
        $queryRegiones = "SELECT p.id, p.nombre, c.nombre as categoria, i.item, p.precio_arriendo FROM producto p 
        INNER JOIN empresa e on e.id = p.empresa_id 
        INNER JOIN categoria_has_item chi on chi.id = p.categoria_has_item_id 
        INNER JOIN categoria c on c.id = chi.categoria_id 
        INNER JOIN item i on i.id  = chi.item_id 
        WHERE e.id = $empresaId";

        if($responseProductos = $conn->mysqli->query($queryRegiones)){
            while($dataProductos = $responseProductos->fetch_object()){
                $productos[] = $dataProductos;
            }
        }
        // $conn->desconectar(); // Auto-closed by ConnectionManager
        return $productos;
    }
?>