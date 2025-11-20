<?php
/**
 * ============================================================================
 * SCRIPT DE EMERGENCIA - Liberar Conexiones Colgadas
 * ============================================================================
 * 
 * ⚠️ USAR SOLO EN EMERGENCIAS ⚠️
 * 
 * Este script mata todas las conexiones MySQL que:
 * - Tienen más de X segundos de inactividad
 * - No son del sistema
 * - Están en estado Sleep
 * 
 * USO:
 * 1. Editar configuración abajo
 * 2. Terminal: php emergency_kill_connections.php
 * 3. O navegador: http://tu-dominio.com/ws/bd/emergency_kill_connections.php
 * 
 * PRECAUCIÓN:
 * - Este script puede interrumpir operaciones en curso
 * - Usar solo cuando la BD está bloqueada
 * - Tener backup antes de ejecutar
 */

// ============================================================================
// CONFIGURACIÓN
// ============================================================================

// Tiempo mínimo de inactividad para matar (segundos)
$MIN_IDLE_TIME = 300; // 5 minutos

// Usuarios a ignorar (NO matar sus conexiones)
$PROTECTED_USERS = ['root', 'system_user', 'repl'];

// Comandos a ignorar
$PROTECTED_COMMANDS = ['Binlog Dump', 'Connect'];

// Modo dry-run (solo mostrar, no ejecutar)
$DRY_RUN = true; // ⚠️ Cambiar a false para ejecutar realmente

// ============================================================================
// NO EDITAR ABAJO DE ESTA LÍNEA
// ============================================================================

require_once('./bd.php');

$is_cli = php_sapi_name() === 'cli';

if (!$is_cli) {
    header('Content-Type: text/plain; charset=utf-8');
}

echo "============================================================\n";
echo "SCRIPT DE EMERGENCIA - Liberar Conexiones\n";
echo "============================================================\n";
echo "Fecha: " . date('Y-m-d H:i:s') . "\n";
echo "Modo: " . ($DRY_RUN ? "DRY-RUN (solo simulación)" : "EJECUCIÓN REAL") . "\n";
echo "Tiempo mínimo inactividad: {$MIN_IDLE_TIME}s\n";
echo "============================================================\n\n";

// Confirmación en modo real
if (!$DRY_RUN && $is_cli) {
    echo "⚠️  ADVERTENCIA: Modo EJECUCIÓN REAL activado\n";
    echo "¿Estás seguro? Esto puede interrumpir operaciones en curso.\n";
    echo "Escribe 'SI' para confirmar: ";
    
    $handle = fopen("php://stdin", "r");
    $line = trim(fgets($handle));
    fclose($handle);
    
    if ($line !== 'SI') {
        echo "\nCancelado por el usuario.\n";
        exit(0);
    }
    echo "\n";
}

try {
    $conn = bd::getInstance();
    
    // Obtener lista de procesos
    echo "Obteniendo lista de procesos...\n\n";
    $result = $conn->mysqli->query("SHOW FULL PROCESSLIST");
    
    if (!$result) {
        die("❌ Error al obtener procesos: " . $conn->mysqli->error . "\n");
    }
    
    $total_processes = 0;
    $killable_processes = 0;
    $killed_processes = 0;
    $protected_processes = 0;
    
    echo "ID\tUsuario\t\tHost\t\t\tTiempo\tComando\t\tEstado\n";
    echo str_repeat("-", 100) . "\n";
    
    $processes_to_kill = [];
    
    while ($process = $result->fetch_assoc()) {
        $total_processes++;
        
        $id = $process['Id'];
        $user = $process['User'];
        $host = $process['Host'];
        $db = $process['db'] ?: 'NULL';
        $command = $process['Command'];
        $time = (int)$process['Time'];
        $state = $process['State'] ?: 'NULL';
        
        // Determinar si debe ser matado
        $should_kill = false;
        $reason = '';
        
        // Proteger usuarios especiales
        if (in_array($user, $PROTECTED_USERS)) {
            $protected_processes++;
            $reason = '[PROTEGIDO - Usuario especial]';
        }
        // Proteger comandos especiales
        elseif (in_array($command, $PROTECTED_COMMANDS)) {
            $protected_processes++;
            $reason = '[PROTEGIDO - Comando especial]';
        }
        // Proteger el proceso actual
        elseif ($id == $conn->mysqli->thread_id) {
            $protected_processes++;
            $reason = '[PROTEGIDO - Proceso actual]';
        }
        // Verificar si está inactivo suficiente tiempo
        elseif ($command === 'Sleep' && $time >= $MIN_IDLE_TIME) {
            $should_kill = true;
            $killable_processes++;
            $reason = "⚠️  [KILL - Inactivo {$time}s]";
            $processes_to_kill[] = $id;
        }
        // Otros casos
        else {
            $reason = '[OK]';
        }
        
        // Mostrar proceso
        printf(
            "%d\t%-15s\t%-20s\t%ds\t%-15s\t%s\n",
            $id,
            substr($user, 0, 15),
            substr($host, 0, 20),
            $time,
            substr($command, 0, 15),
            $reason
        );
    }
    
    $result->free();
    
    echo "\n" . str_repeat("=", 100) . "\n";
    echo "RESUMEN:\n";
    echo "  Total de procesos:        $total_processes\n";
    echo "  Procesos protegidos:      $protected_processes\n";
    echo "  Procesos a matar:         $killable_processes\n";
    echo "\n";
    
    if ($killable_processes === 0) {
        echo "✅ No hay conexiones que necesiten ser liberadas.\n";
        exit(0);
    }
    
    // Ejecutar kills
    if (!$DRY_RUN) {
        echo "Matando procesos...\n\n";
        
        foreach ($processes_to_kill as $process_id) {
            $kill_query = "KILL $process_id";
            
            if ($conn->mysqli->query($kill_query)) {
                echo "  ✅ Matado proceso $process_id\n";
                $killed_processes++;
            } else {
                echo "  ❌ Error al matar proceso $process_id: " . $conn->mysqli->error . "\n";
            }
        }
        
        echo "\n";
        echo "============================================================\n";
        echo "RESULTADO:\n";
        echo "  Procesos matados exitosamente: $killed_processes de $killable_processes\n";
        echo "============================================================\n";
        
        if ($killed_processes > 0) {
            echo "\n✅ Conexiones liberadas. Verifica que la aplicación funcione correctamente.\n";
            exit(0);
        } else {
            echo "\n❌ No se pudo matar ninguna conexión. Contacta al administrador del servidor.\n";
            exit(1);
        }
    } else {
        echo "============================================================\n";
        echo "MODO DRY-RUN:\n";
        echo "  Se habrían matado $killable_processes procesos\n";
        echo "  IDs: " . implode(', ', $processes_to_kill) . "\n";
        echo "============================================================\n";
        echo "\n⚠️  Para ejecutar realmente, edita el script y cambia:\n";
        echo "   \$DRY_RUN = true;  →  \$DRY_RUN = false;\n";
        exit(0);
    }
    
} catch (Exception $e) {
    echo "\n❌ ERROR CRÍTICO:\n";
    echo "   " . $e->getMessage() . "\n";
    echo "   Trace: " . $e->getTraceAsString() . "\n";
    exit(2);
}
?>
