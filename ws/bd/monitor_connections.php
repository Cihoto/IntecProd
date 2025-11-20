<?php
/**
 * ============================================================================
 * MONITOR DE CONEXIONES A BASE DE DATOS
 * ============================================================================
 * 
 * Este script te permite monitorear en tiempo real:
 * - Número de conexiones activas
 * - Estado de la conexión Singleton
 * - Información del servidor MySQL
 * - Procesos activos en la BD
 * 
 * USO:
 * 1. Abrir en navegador: http://tu-dominio.com/ws/bd/monitor_connections.php
 * 2. O ejecutar desde terminal: php monitor_connections.php
 * 
 * SEGURIDAD: 
 * ⚠️ IMPORTANTE: Este archivo debe ser protegido o eliminado en producción
 * ⚠️ Comentar la línea de exit() para habilitar
 */

// SEGURIDAD: Descomentar para proteger en producción
// exit("Monitor deshabilitado por seguridad");

// SEGURIDAD: Descomentar para requerir autenticación básica
// if (!isset($_SERVER['PHP_AUTH_USER']) || $_SERVER['PHP_AUTH_USER'] !== 'admin' || $_SERVER['PHP_AUTH_PW'] !== 'tu_password_aqui') {
//     header('WWW-Authenticate: Basic realm="Monitor BD"');
//     header('HTTP/1.0 401 Unauthorized');
//     exit('Acceso denegado');
// }

require_once('./bd.php');

// Determinar si es CLI o web
$is_cli = php_sapi_name() === 'cli';
$is_ajax = isset($_GET['ajax']) || (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest');

// Si es AJAX, solo devolver JSON
if ($is_ajax) {
    header('Content-Type: application/json');
    echo json_encode(getMonitorData());
    exit;
}

// Si es CLI, mostrar en texto plano
if ($is_cli) {
    echo str_repeat("=", 80) . "\n";
    echo "MONITOR DE CONEXIONES BD - " . date('Y-m-d H:i:s') . "\n";
    echo str_repeat("=", 80) . "\n\n";
    
    $data = getMonitorData();
    
    foreach ($data as $section => $values) {
        echo strtoupper($section) . ":\n";
        echo str_repeat("-", 40) . "\n";
        
        if (is_array($values)) {
            foreach ($values as $key => $value) {
                printf("  %-25s: %s\n", $key, is_array($value) ? json_encode($value) : $value);
            }
        } else {
            echo "  " . $values . "\n";
        }
        echo "\n";
    }
    
    exit;
}

// Si es web, mostrar HTML
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitor de Conexiones BD - IntecProd</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f5f5;
            padding: 20px;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        .header h1 {
            margin-bottom: 10px;
        }
        .header .subtitle {
            opacity: 0.9;
            font-size: 14px;
        }
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }
        .card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .card h2 {
            color: #333;
            margin-bottom: 15px;
            font-size: 18px;
            border-bottom: 2px solid #667eea;
            padding-bottom: 10px;
        }
        .stat {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }
        .stat:last-child {
            border-bottom: none;
        }
        .stat-label {
            color: #666;
            font-weight: 500;
        }
        .stat-value {
            color: #333;
            font-weight: 600;
        }
        .status {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        .status.ok {
            background: #d4edda;
            color: #155724;
        }
        .status.error {
            background: #f8d7da;
            color: #721c24;
        }
        .status.warning {
            background: #fff3cd;
            color: #856404;
        }
        .refresh-bar {
            background: white;
            border-radius: 10px;
            padding: 15px 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .refresh-bar button {
            background: #667eea;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 600;
        }
        .refresh-bar button:hover {
            background: #5568d3;
        }
        .auto-refresh {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .processes-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .processes-table th,
        .processes-table td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #eee;
            font-size: 13px;
        }
        .processes-table th {
            background: #f8f9fa;
            font-weight: 600;
            color: #666;
        }
        .alert {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        .alert.success {
            background: #d4edda;
            border-color: #28a745;
        }
        .alert.danger {
            background: #f8d7da;
            border-color: #dc3545;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🔍 Monitor de Conexiones BD</h1>
            <div class="subtitle">IntecProd - Monitoreo en tiempo real</div>
            <div class="subtitle" id="last-update">Última actualización: <?= date('Y-m-d H:i:s') ?></div>
        </div>

        <div class="refresh-bar">
            <div class="auto-refresh">
                <label>
                    <input type="checkbox" id="auto-refresh" checked>
                    Auto-actualizar cada
                </label>
                <select id="refresh-interval">
                    <option value="5">5 seg</option>
                    <option value="10" selected>10 seg</option>
                    <option value="30">30 seg</option>
                    <option value="60">1 min</option>
                </select>
            </div>
            <button onclick="refreshData()">🔄 Actualizar ahora</button>
        </div>

        <div id="monitor-content">
            <?php renderMonitorContent(); ?>
        </div>
    </div>

    <script>
        let refreshTimer = null;

        function refreshData() {
            fetch('?ajax=1&_=' + Date.now())
                .then(response => response.json())
                .then(data => {
                    document.getElementById('monitor-content').innerHTML = renderMonitorHTML(data);
                    document.getElementById('last-update').textContent = 'Última actualización: ' + new Date().toLocaleString('es-CL');
                })
                .catch(error => {
                    console.error('Error al actualizar:', error);
                });
        }

        function renderMonitorHTML(data) {
            // Aquí iría la lógica de renderizado... Por simplicidad, recargamos la página
            location.reload();
        }

        function setupAutoRefresh() {
            if (refreshTimer) {
                clearInterval(refreshTimer);
            }

            const autoRefresh = document.getElementById('auto-refresh');
            const interval = document.getElementById('refresh-interval');

            if (autoRefresh.checked) {
                const seconds = parseInt(interval.value) * 1000;
                refreshTimer = setInterval(refreshData, seconds);
            }
        }

        document.getElementById('auto-refresh').addEventListener('change', setupAutoRefresh);
        document.getElementById('refresh-interval').addEventListener('change', setupAutoRefresh);

        // Iniciar auto-refresh
        setupAutoRefresh();
    </script>
</body>
</html>

<?php

function renderMonitorContent() {
    $data = getMonitorData();
    
    // Alertas
    if ($data['singleton']['connection_alive'] === false) {
        echo '<div class="alert danger">⚠️ <strong>CRÍTICO:</strong> La conexión a la base de datos no está activa</div>';
    } elseif ($data['singleton']['connection_count'] > 5) {
        echo '<div class="alert">⚠️ <strong>ADVERTENCIA:</strong> Se han creado múltiples conexiones (' . $data['singleton']['connection_count'] . '). Esto puede indicar un problema.</div>';
    } else {
        echo '<div class="alert success">✅ <strong>ESTADO OK:</strong> El sistema Singleton está funcionando correctamente</div>';
    }
    
    // Grid de estadísticas
    echo '<div class="grid">';
    
    // Singleton Stats
    echo '<div class="card">';
    echo '<h2>📊 Estado Singleton</h2>';
    echo '<div class="stat">';
    echo '<span class="stat-label">Estado</span>';
    echo '<span class="stat-value">' . ($data['singleton']['singleton_active'] ? '<span class="status ok">ACTIVO</span>' : '<span class="status error">INACTIVO</span>') . '</span>';
    echo '</div>';
    echo '<div class="stat">';
    echo '<span class="stat-label">Conexión viva</span>';
    echo '<span class="stat-value">' . ($data['singleton']['connection_alive'] ? '<span class="status ok">SÍ</span>' : '<span class="status error">NO</span>') . '</span>';
    echo '</div>';
    echo '<div class="stat">';
    echo '<span class="stat-label">Conexiones creadas</span>';
    echo '<span class="stat-value">' . $data['singleton']['connection_count'] . '</span>';
    echo '</div>';
    echo '<div class="stat">';
    echo '<span class="stat-label">Duración request</span>';
    echo '<span class="stat-value">' . number_format($data['singleton']['request_duration'], 3) . 's</span>';
    echo '</div>';
    echo '<div class="stat">';
    echo '<span class="stat-label">Memoria usada</span>';
    echo '<span class="stat-value">' . $data['singleton']['memory_usage'] . '</span>';
    echo '</div>';
    echo '</div>';
    
    // Connection Info
    if ($data['connection_info']) {
        echo '<div class="card">';
        echo '<h2>🔌 Información de Conexión</h2>';
        foreach ($data['connection_info'] as $key => $value) {
            if ($key === 'stats') continue;
            echo '<div class="stat">';
            echo '<span class="stat-label">' . ucfirst(str_replace('_', ' ', $key)) . '</span>';
            echo '<span class="stat-value">' . (is_bool($value) ? ($value ? 'Sí' : 'No') : $value) . '</span>';
            echo '</div>';
        }
        echo '</div>';
    }
    
    // MySQL Status
    echo '<div class="card">';
    echo '<h2>🗄️ Estado MySQL</h2>';
    foreach ($data['mysql_status'] as $key => $value) {
        echo '<div class="stat">';
        echo '<span class="stat-label">' . $key . '</span>';
        echo '<span class="stat-value">' . $value . '</span>';
        echo '</div>';
    }
    echo '</div>';
    
    echo '</div>'; // end grid
    
    // Procesos activos
    if (!empty($data['active_processes'])) {
        echo '<div class="card" style="margin-top: 20px;">';
        echo '<h2>⚙️ Procesos Activos en MySQL (' . count($data['active_processes']) . ')</h2>';
        echo '<table class="processes-table">';
        echo '<thead><tr><th>ID</th><th>Usuario</th><th>Host</th><th>DB</th><th>Comando</th><th>Tiempo</th><th>Estado</th></tr></thead>';
        echo '<tbody>';
        foreach ($data['active_processes'] as $process) {
            echo '<tr>';
            echo '<td>' . $process['Id'] . '</td>';
            echo '<td>' . $process['User'] . '</td>';
            echo '<td>' . $process['Host'] . '</td>';
            echo '<td>' . ($process['db'] ?: '-') . '</td>';
            echo '<td>' . $process['Command'] . '</td>';
            echo '<td>' . $process['Time'] . 's</td>';
            echo '<td>' . ($process['State'] ?: '-') . '</td>';
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
        echo '</div>';
    }
}

function getMonitorData() {
    $data = [
        'timestamp' => date('Y-m-d H:i:s'),
        'singleton' => [],
        'connection_info' => false,
        'mysql_status' => [],
        'active_processes' => []
    ];
    
    try {
        // Forzar inicialización de la conexión
        $conn = bd::getInstance();
        
        // Verificar y conectar si es necesario
        if (!$conn->mysqli || !$conn->mysqli->ping()) {
            $conn->conectar();
        }
        
        // Obtener stats del Singleton DESPUÉS de asegurar conexión
        $data['singleton'] = bd::getStats();
        
        // Obtener info de conexión
        $data['connection_info'] = bd::getConnectionInfo();
        
        if ($conn->mysqli && $conn->mysqli->ping()) {
            // Obtener variables de estado de MySQL
            $result = $conn->mysqli->query("SHOW STATUS WHERE Variable_name IN ('Threads_connected', 'Max_used_connections', 'Connections', 'Aborted_connects')");
            
            if ($result) {
                while ($row = $result->fetch_assoc()) {
                    $data['mysql_status'][$row['Variable_name']] = $row['Value'];
                }
                $result->free();
            }
            
            // Obtener lista de procesos activos
            $result = $conn->mysqli->query("SHOW PROCESSLIST");
            
            if ($result) {
                while ($row = $result->fetch_assoc()) {
                    $data['active_processes'][] = $row;
                }
                $result->free();
            }
        }
    } catch (Exception $e) {
        $data['error'] = $e->getMessage();
    }
    
    return $data;
}
?>
