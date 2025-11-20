<?php
/**
 * ============================================================================
 * SCRIPT DE VERIFICACIÓN RÁPIDA - Estado de Conexiones BD
 * ============================================================================
 * 
 * Este script hace un check rápido del estado de las conexiones.
 * Útil para:
 * - Verificación rápida desde terminal
 * - Configurar como health check
 * - Monitoreo automatizado con cron
 * 
 * USO:
 * - Terminal: php check_connections.php
 * - Navegador: http://tu-dominio.com/ws/bd/check_connections.php
 * - Cron: cada 5 minutos ejecutar: php /path/to/check_connections.php >> /var/log/bd_check.log
 */

require_once('./bd.php');

// Determinar si es CLI
$is_cli = php_sapi_name() === 'cli';

// Si es web, mostrar como texto plano
if (!$is_cli) {
    header('Content-Type: text/plain; charset=utf-8');
}

echo "==========================================\n";
echo "CHECK DE CONEXIONES BD - " . date('Y-m-d H:i:s') . "\n";
echo "==========================================\n\n";

$all_ok = true;
$warnings = [];
$errors = [];

try {
    // TEST 1: Verificar Singleton
    echo "[1/5] Verificando Singleton... ";
    $conn = bd::getInstance();
    $stats = bd::getStats();
    
    if ($stats['singleton_active'] && $stats['connection_alive']) {
        echo "✅ OK\n";
    } else {
        echo "❌ FALLO\n";
        $errors[] = "Singleton no está activo o conexión caída";
        $all_ok = false;
    }
    
    // TEST 2: Verificar conexiones creadas
    echo "[2/5] Verificando número de conexiones... ";
    if ($stats['connection_count'] <= 3) {
        echo "✅ OK (" . $stats['connection_count'] . " conexión/es)\n";
    } elseif ($stats['connection_count'] <= 5) {
        echo "⚠️  ADVERTENCIA (" . $stats['connection_count'] . " conexiones)\n";
        $warnings[] = "Más conexiones de las esperadas: " . $stats['connection_count'];
    } else {
        echo "❌ CRÍTICO (" . $stats['connection_count'] . " conexiones)\n";
        $errors[] = "Demasiadas conexiones creadas: " . $stats['connection_count'];
        $all_ok = false;
    }
    
    // TEST 3: Verificar query simple
    echo "[3/5] Verificando query a BD... ";
    $result = $conn->mysqli->query("SELECT 1 as test");
    
    if ($result && $row = $result->fetch_assoc()) {
        echo "✅ OK\n";
        $result->free();
    } else {
        echo "❌ FALLO\n";
        $errors[] = "No se pudo ejecutar query: " . $conn->mysqli->error;
        $all_ok = false;
    }
    
    // TEST 4: Verificar threads MySQL
    echo "[4/5] Verificando threads MySQL... ";
    $result = $conn->mysqli->query("SHOW STATUS WHERE Variable_name = 'Threads_connected'");
    
    if ($result && $row = $result->fetch_assoc()) {
        $threads = (int)$row['Value'];
        
        if ($threads < 15) {
            echo "✅ OK ($threads threads)\n";
        } elseif ($threads < 25) {
            echo "⚠️  ADVERTENCIA ($threads threads)\n";
            $warnings[] = "Threads conectados alto: $threads";
        } else {
            echo "❌ CRÍTICO ($threads threads)\n";
            $errors[] = "Demasiados threads: $threads (límite típico: 30)";
            $all_ok = false;
        }
        $result->free();
    } else {
        echo "⚠️  No se pudo verificar\n";
    }
    
    // TEST 5: Verificar conexión persistente
    echo "[5/5] Verificando conexión persistente... ";
    $info = bd::getConnectionInfo();
    
    if ($info && $info['is_persistent']) {
        echo "✅ OK (persistente habilitada)\n";
    } elseif ($info) {
        echo "⚠️  ADVERTENCIA (persistente deshabilitada)\n";
        $warnings[] = "Conexión persistente no habilitada (rendimiento subóptimo)";
    } else {
        echo "❌ No se pudo verificar\n";
    }
    
} catch (Exception $e) {
    echo "❌ ERROR CRÍTICO\n";
    $errors[] = "Exception: " . $e->getMessage();
    $all_ok = false;
}

echo "\n==========================================\n";
echo "RESULTADO FINAL\n";
echo "==========================================\n\n";

if ($all_ok && empty($warnings)) {
    echo "✅ TODO OK - Sistema funcionando correctamente\n";
    echo "   - Singleton activo\n";
    echo "   - Conexión estable\n";
    echo "   - Bajo uso de recursos\n";
    exit(0);
} elseif ($all_ok && !empty($warnings)) {
    echo "⚠️  OK CON ADVERTENCIAS\n\n";
    echo "Advertencias:\n";
    foreach ($warnings as $i => $warning) {
        echo "  " . ($i + 1) . ". $warning\n";
    }
    echo "\nEl sistema funciona pero puede optimizarse.\n";
    exit(1);
} else {
    echo "❌ ERROR CRÍTICO\n\n";
    echo "Errores:\n";
    foreach ($errors as $i => $error) {
        echo "  " . ($i + 1) . ". $error\n";
    }
    if (!empty($warnings)) {
        echo "\nAdvertencias:\n";
        foreach ($warnings as $i => $warning) {
            echo "  " . ($i + 1) . ". $warning\n";
        }
    }
    echo "\n¡ACCIÓN REQUERIDA!\n";
    echo "Revisar logs y considerar reiniciar Apache/MySQL.\n";
    exit(2);
}
?>
