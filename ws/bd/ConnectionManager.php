<?php
/**
 * ============================================================================
 * CONNECTION MANAGER - Gestor Global de Conexiones
 * ============================================================================
 * 
 * Este archivo DEBE ser incluido PRIMERO en cada archivo PHP que necesite BD.
 * 
 * PROBLEMA QUE RESUELVE:
 * - Cada función crea su propia conexión
 * - Las subfunciones crean conexiones adicionales
 * - Resultado: 100+ conexiones por request
 * 
 * SOLUCIÓN:
 * - Una conexión global reutilizable por TODO el request
 * - Funciones helper para obtener la conexión sin crearla
 * - Auto-limpieza al final del script
 * 
 * USO:
 * // En lugar de:
 * require_once('../bd/bd.php');
 * $conn = new bd();
 * $conn->conectar();
 * 
 * // Usar:
 * require_once('../bd/ConnectionManager.php');
 * $conn = getDBConnection();
 * $mysqli = $conn->mysqli;
 * 
 * @version 1.0
 * @date 2024-11-20
 */

require_once(__DIR__ . '/bd.php');

// Variable global para la conexión (una sola por request)
$GLOBALS['__DB_CONNECTION__'] = null;
$GLOBALS['__DB_CONNECTION_COUNT__'] = 0;
$GLOBALS['__DB_QUERY_COUNT__'] = 0;

/**
 * Obtener la conexión global (crea solo si no existe)
 * 
 * Esta es la función principal que DEBES usar en lugar de:
 * $conn = new bd(); $conn->conectar();
 * 
 * @return bd Conexión a la base de datos
 */
function getDBConnection() {
    if ($GLOBALS['__DB_CONNECTION__'] === null) {
        $GLOBALS['__DB_CONNECTION__'] = bd::getInstance();
        $GLOBALS['__DB_CONNECTION_COUNT__']++;
    }
    return $GLOBALS['__DB_CONNECTION__'];
}

/**
 * Obtener el objeto mysqli directamente
 * 
 * Uso rápido: $mysqli = getDB();
 * 
 * @return mysqli Objeto mysqli para queries
 */
function getDB() {
    $conn = getDBConnection();
    return $conn->mysqli;
}

/**
 * Ejecutar query con manejo de errores automático
 * 
 * @param string $query Query SQL a ejecutar
 * @param bool $return_insert_id Si true, retorna el insert_id
 * @return mixed Resultado de la query o false en error
 */
function dbQuery($query, $return_insert_id = false) {
    $GLOBALS['__DB_QUERY_COUNT__']++;
    
    $mysqli = getDB();
    $result = $mysqli->query($query);
    
    if (!$result && $mysqli->error) {
        error_log("DB Query Error: " . $mysqli->error . " | Query: " . substr($query, 0, 200));
        return false;
    }
    
    if ($return_insert_id) {
        return $mysqli->insert_id;
    }
    
    return $result;
}

/**
 * Ejecutar query y obtener el primer resultado
 * 
 * @param string $query Query SQL
 * @return object|false Primer resultado o false
 */
function dbQueryOne($query) {
    $result = dbQuery($query);
    
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_object();
        $result->free();
        return $row;
    }
    
    return false;
}

/**
 * Ejecutar query y obtener todos los resultados
 * 
 * @param string $query Query SQL
 * @return array Array de objetos con los resultados
 */
function dbQueryAll($query) {
    $result = dbQuery($query);
    $data = [];
    
    if ($result) {
        while ($row = $result->fetch_object()) {
            $data[] = $row;
        }
        $result->free();
    }
    
    return $data;
}

/**
 * Escapar string para SQL (prevenir SQL injection)
 * 
 * @param string $value Valor a escapar
 * @return string Valor escapado
 */
function dbEscape($value) {
    $mysqli = getDB();
    return $mysqli->real_escape_string($value);
}

/**
 * Obtener estadísticas del request actual
 * 
 * @return array Estadísticas de uso
 */
function getDBStats() {
    return [
        'connections_created' => $GLOBALS['__DB_CONNECTION_COUNT__'],
        'queries_executed' => $GLOBALS['__DB_QUERY_COUNT__'],
        'connection_active' => $GLOBALS['__DB_CONNECTION__'] !== null,
        'singleton_stats' => bd::getStats()
    ];
}

/**
 * Limpiar conexión (NO usar salvo casos especiales)
 * La conexión se cierra automáticamente al final del script
 */
function closeDBConnection() {
    if ($GLOBALS['__DB_CONNECTION__'] !== null) {
        // No cerrar realmente, solo limpiar referencia
        // La conexión persistente se mantendrá
        $GLOBALS['__DB_CONNECTION__'] = null;
    }
}

/**
 * Middleware para loguear queries lentas
 * Solo en desarrollo
 */
function dbQueryWithLog($query, $threshold = 1.0) {
    $start = microtime(true);
    $result = dbQuery($query);
    $duration = microtime(true) - $start;
    
    if ($duration > $threshold) {
        error_log(sprintf(
            "SLOW QUERY (%.3fs): %s",
            $duration,
            substr($query, 0, 200)
        ));
    }
    
    return $result;
}

// Auto-cleanup al final del script
register_shutdown_function(function() {
    $stats = getDBStats();
    
    // Solo loguear si hay actividad inusual
    if ($stats['queries_executed'] > 100) {
        error_log(sprintf(
            "High DB Activity: %d queries in request %s",
            $stats['queries_executed'],
            $_SERVER['REQUEST_URI'] ?? 'CLI'
        ));
    }
});

?>
