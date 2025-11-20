<?php
/**
 * ============================================================================
 * SCRIPT DE MIGRACIÓN AUTOMÁTICA
 * ============================================================================
 * 
 * Este script refactoriza automáticamente los archivos PHP para usar
 * ConnectionManager en lugar de crear conexiones individuales.
 * 
 * PRECAUCIÓN:
 * - Hacer BACKUP antes de ejecutar
 * - Ejecutar en entorno de pruebas primero
 * - Revisar cambios con Git diff
 * 
 * USO:
 * php ws/bd/migrate_to_connection_manager.php --dry-run
 * php ws/bd/migrate_to_connection_manager.php --execute
 * 
 * QUÉ HACE:
 * 1. Busca todos los archivos PHP en ws/
 * 2. Reemplaza patrones antiguos:
 *    - require_once('../bd/bd.php') → require_once('../bd/ConnectionManager.php')
 *    - $conn = new bd(); $conn->conectar(); → $conn = getDBConnection();
 *    - $conn->desconectar(); → // Auto-closed
 * 3. Crea backup de cada archivo modificado
 * 
 * @version 1.0
 * @date 2024-11-20
 */

$DRY_RUN = in_array('--dry-run', $argv ?? []);
$EXECUTE = in_array('--execute', $argv ?? []);

if (!$DRY_RUN && !$EXECUTE) {
    echo "ERROR: Debes especificar --dry-run o --execute\n";
    echo "\nUSO:\n";
    echo "  php migrate_to_connection_manager.php --dry-run    (solo mostrar cambios)\n";
    echo "  php migrate_to_connection_manager.php --execute    (ejecutar cambios)\n";
    exit(1);
}

echo "============================================================\n";
echo "MIGRACIÓN A CONNECTION MANAGER\n";
echo "============================================================\n";
echo "Modo: " . ($DRY_RUN ? "DRY-RUN" : "EJECUCIÓN REAL") . "\n";
echo "Fecha: " . date('Y-m-d H:i:s') . "\n";
echo "============================================================\n\n";

$base_dir = __DIR__ . '/../';
$files_to_migrate = [];
$total_files = 0;
$modified_files = 0;
$skipped_files = 0;

// Buscar todos los archivos PHP
$iterator = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($base_dir)
);

foreach ($iterator as $file) {
    if ($file->isFile() && $file->getExtension() === 'php') {
        $filepath = $file->getPathname();
        
        // Ignorar archivos del directorio bd/ (excepto test)
        if (strpos($filepath, DIRECTORY_SEPARATOR . 'bd' . DIRECTORY_SEPARATOR) !== false 
            && basename($filepath) !== 'test_singleton.php') {
            continue;
        }
        
        $files_to_migrate[] = $filepath;
        $total_files++;
    }
}

echo "Archivos encontrados: $total_files\n\n";

// Patrones a reemplazar
$patterns = [
    // Patrón 1: require bd.php
    [
        'pattern' => '/require_once\s*\(\s*[\'"]\.\.\/bd\/bd\.php[\'"]\s*\);?/i',
        'replacement' => "require_once(__DIR__ . '/../bd/ConnectionManager.php');",
        'description' => 'Reemplazar require bd.php'
    ],
    [
        'pattern' => '/require_once\s*\(\s*[\'"]\.\/ws\/bd\/bd\.php[\'"]\s*\);?/i',
        'replacement' => "require_once(__DIR__ . '/ws/bd/ConnectionManager.php');",
        'description' => 'Reemplazar require bd.php (ruta alternativa)'
    ],
    
    // Patrón 2: Crear conexión
    [
        'pattern' => '/\$conn\s*=\s*new\s+bd\s*\(\s*\);\s*\n\s*\$conn->conectar\(\);?/i',
        'replacement' => '$conn = getDBConnection(); // Auto-managed connection',
        'description' => 'Reemplazar new bd() + conectar()'
    ],
    
    // Patrón 3: Solo new bd()
    [
        'pattern' => '/\$conn\s*=\s*new\s+bd\s*\(\s*\);?/i',
        'replacement' => '$conn = getDBConnection(); // Auto-managed connection',
        'description' => 'Reemplazar new bd()'
    ],
    
    // Patrón 4: Comentar desconectar()
    [
        'pattern' => '/\$conn->desconectar\(\);?/i',
        'replacement' => '// $conn->desconectar(); // Auto-closed by ConnectionManager',
        'description' => 'Comentar desconectar()'
    ]
];

// Procesar cada archivo
foreach ($files_to_migrate as $filepath) {
    $content = file_get_contents($filepath);
    $original_content = $content;
    $changes_made = false;
    $file_changes = [];
    
    // Aplicar cada patrón
    foreach ($patterns as $pattern_info) {
        $matches_before = preg_match_all($pattern_info['pattern'], $content);
        
        if ($matches_before > 0) {
            $content = preg_replace(
                $pattern_info['pattern'],
                $pattern_info['replacement'],
                $content
            );
            
            $matches_after = preg_match_all($pattern_info['pattern'], $content);
            $replaced = $matches_before - $matches_after;
            
            if ($replaced > 0) {
                $changes_made = true;
                $file_changes[] = [
                    'description' => $pattern_info['description'],
                    'count' => $replaced
                ];
            }
        }
    }
    
    // Si hubo cambios
    if ($changes_made) {
        $modified_files++;
        $relative_path = str_replace($base_dir, '', $filepath);
        
        echo "📝 $relative_path\n";
        foreach ($file_changes as $change) {
            echo "   ✓ {$change['description']}: {$change['count']} cambio(s)\n";
        }
        echo "\n";
        
        // Si NO es dry-run, guardar cambios
        if (!$DRY_RUN) {
            // Crear backup
            $backup_path = $filepath . '.backup_' . date('Ymd_His');
            copy($filepath, $backup_path);
            
            // Guardar contenido modificado
            file_put_contents($filepath, $content);
            
            echo "   💾 Backup creado: " . basename($backup_path) . "\n";
            echo "   ✅ Archivo actualizado\n\n";
        }
    } else {
        $skipped_files++;
    }
}

// Resumen
echo "\n============================================================\n";
echo "RESUMEN\n";
echo "============================================================\n";
echo "Total de archivos escaneados:  $total_files\n";
echo "Archivos modificados:           $modified_files\n";
echo "Archivos sin cambios:           $skipped_files\n";
echo "\n";

if ($DRY_RUN) {
    echo "⚠️  MODO DRY-RUN: No se modificó ningún archivo\n";
    echo "\nPara ejecutar realmente los cambios:\n";
    echo "  php migrate_to_connection_manager.php --execute\n";
} else {
    echo "✅ MIGRACIÓN COMPLETADA\n";
    echo "\nPRÓXIMOS PASOS:\n";
    echo "1. Verificar que la app funciona correctamente\n";
    echo "2. Revisar cambios con: git diff\n";
    echo "3. Si todo está OK: git add . && git commit -m 'refactor: Migrate to ConnectionManager'\n";
    echo "4. Si algo falla: Restaurar desde los archivos .backup_*\n";
}

echo "\n============================================================\n";

?>
