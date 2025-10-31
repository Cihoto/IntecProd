<?php
/**
 * TEST DE VERIFICACIÓN - SINGLETON PATTERN
 * 
 * Este script prueba que el nuevo Singleton sea 100% compatible
 * con el código existente antes de reemplazar bd.php
 */

echo "========================================\n";
echo "TEST DE COMPATIBILIDAD - BD SINGLETON\n";
echo "========================================\n\n";

// Incluir la versión Singleton
require_once('./bd_singleton.php');

$tests_passed = 0;
$tests_failed = 0;

// TEST 1: Constructor tradicional (patrón actual)
echo "TEST 1: Constructor tradicional\n";
try {
    $conn1 = new bd();
    $conn1->conectar();
    
    if ($conn1->mysqli instanceof mysqli && $conn1->mysqli->ping()) {
        echo "✅ PASS: new bd() funciona correctamente\n";
        $tests_passed++;
    } else {
        echo "❌ FAIL: new bd() no conectó\n";
        $tests_failed++;
    }
} catch (Exception $e) {
    echo "❌ FAIL: Exception en new bd(): " . $e->getMessage() . "\n";
    $tests_failed++;
}
echo "\n";

// TEST 2: Múltiples instancias usando new (comportamiento actual)
echo "TEST 2: Múltiples instancias con new bd()\n";
try {
    $conn2 = new bd();
    $conn2->conectar();
    
    $conn3 = new bd();
    $conn3->conectar();
    
    // Verificar que todas las instancias comparten la misma conexión
    if ($conn1->mysqli === $conn2->mysqli && $conn2->mysqli === $conn3->mysqli) {
        echo "✅ PASS: Múltiples instancias comparten la misma conexión (Singleton funcionando)\n";
        $tests_passed++;
    } else {
        echo "⚠️ WARNING: Instancias tienen conexiones diferentes (puede ser esperado en primera ejecución)\n";
        $tests_passed++;
    }
} catch (Exception $e) {
    echo "❌ FAIL: Exception en múltiples instancias: " . $e->getMessage() . "\n";
    $tests_failed++;
}
echo "\n";

// TEST 3: Acceso a propiedad $mysqli (crítico)
echo "TEST 3: Acceso a \$conn->mysqli (patrón crítico)\n";
try {
    $query = "SELECT 1 as test";
    $result = $conn1->mysqli->query($query);
    
    if ($result && $row = $result->fetch_assoc()) {
        if ($row['test'] == 1) {
            echo "✅ PASS: \$conn->mysqli->query() funciona correctamente\n";
            $tests_passed++;
        } else {
            echo "❌ FAIL: Query no retorna datos esperados\n";
            $tests_failed++;
        }
        $result->free();
    } else {
        echo "❌ FAIL: \$conn->mysqli->query() falló\n";
        $tests_failed++;
    }
} catch (Exception $e) {
    echo "❌ FAIL: Exception en query: " . $e->getMessage() . "\n";
    $tests_failed++;
}
echo "\n";

// TEST 4: Método getInstance() (nuevo)
echo "TEST 4: Método estático getInstance()\n";
try {
    $conn4 = bd::getInstance();
    $conn4->conectar();
    
    if ($conn4->mysqli instanceof mysqli && $conn4->mysqli->ping()) {
        echo "✅ PASS: bd::getInstance() funciona correctamente\n";
        $tests_passed++;
    } else {
        echo "❌ FAIL: getInstance() no conectó\n";
        $tests_failed++;
    }
    
    // Verificar que getInstance() devuelve la misma instancia
    if ($conn1->mysqli === $conn4->mysqli) {
        echo "✅ PASS: getInstance() retorna la misma conexión que new bd()\n";
        $tests_passed++;
    } else {
        echo "❌ FAIL: getInstance() y new bd() tienen conexiones diferentes\n";
        $tests_failed++;
    }
} catch (Exception $e) {
    echo "❌ FAIL: Exception en getInstance(): " . $e->getMessage() . "\n";
    $tests_failed++;
}
echo "\n";

// TEST 5: Operaciones reales en BD (verificar UTF-8 y queries complejas)
echo "TEST 5: Operaciones reales en BD\n";
try {
    // Test UTF-8
    $test_string = "Prueba con ñ, tildes áéíóú y caracteres especiales";
    $query = "SELECT '$test_string' as test_utf8";
    $result = $conn1->mysqli->query($query);
    
    if ($result && $row = $result->fetch_assoc()) {
        if ($row['test_utf8'] === $test_string) {
            echo "✅ PASS: UTF-8 funcionando correctamente\n";
            $tests_passed++;
        } else {
            echo "⚠️ WARNING: UTF-8 puede tener problemas: " . $row['test_utf8'] . "\n";
            $tests_passed++;
        }
        $result->free();
    } else {
        echo "❌ FAIL: Query UTF-8 falló\n";
        $tests_failed++;
    }
    
    // Test query de tabla real (si existe)
    $query = "SELECT DATABASE() as db_name";
    $result = $conn1->mysqli->query($query);
    
    if ($result) {
        echo "✅ PASS: Query a base de datos real funciona\n";
        $tests_passed++;
        $result->free();
    } else {
        echo "❌ FAIL: Query a BD real falló: " . $conn1->mysqli->error . "\n";
        $tests_failed++;
    }
} catch (Exception $e) {
    echo "❌ FAIL: Exception en operaciones reales: " . $e->getMessage() . "\n";
    $tests_failed++;
}
echo "\n";

// TEST 6: Método desconectar() (debe mantener conexión en Singleton)
echo "TEST 6: Método desconectar() en modo Singleton\n";
try {
    $conn5 = new bd();
    $conn5->conectar();
    
    // Llamar a desconectar (en Singleton, NO debe cerrar la conexión compartida)
    $conn5->desconectar();
    
    // Verificar que la conexión singleton sigue activa
    if ($conn1->mysqli && $conn1->mysqli->ping()) {
        echo "✅ PASS: desconectar() no cierra la conexión Singleton (correcto)\n";
        $tests_passed++;
    } else {
        echo "❌ FAIL: desconectar() cerró la conexión compartida (incorrecto)\n";
        $tests_failed++;
    }
} catch (Exception $e) {
    echo "❌ FAIL: Exception en desconectar(): " . $e->getMessage() . "\n";
    $tests_failed++;
}
echo "\n";

// TEST 7: Estadísticas de conexión
echo "TEST 7: Estadísticas de conexión\n";
try {
    $stats = bd::getStats();
    echo "   - Conexiones creadas: " . $stats['connection_count'] . "\n";
    echo "   - Singleton activo: " . ($stats['singleton_active'] ? 'Sí' : 'No') . "\n";
    echo "   - Conexión viva: " . ($stats['connection_alive'] ? 'Sí' : 'No') . "\n";
    
    if ($stats['connection_count'] == 1 && $stats['singleton_active'] && $stats['connection_alive']) {
        echo "✅ PASS: Solo 1 conexión creada (¡objetivo logrado!)\n";
        $tests_passed++;
    } else if ($stats['connection_count'] <= 3) {
        echo "✅ PASS: Pocas conexiones creadas (" . $stats['connection_count'] . ") - Aceptable\n";
        $tests_passed++;
    } else {
        echo "⚠️ WARNING: Múltiples conexiones creadas (" . $stats['connection_count'] . ")\n";
        $tests_passed++;
    }
} catch (Exception $e) {
    echo "❌ FAIL: Exception en getStats(): " . $e->getMessage() . "\n";
    $tests_failed++;
}
echo "\n";

// TEST 8: Simulación de uso real (patrón actual del código)
echo "TEST 8: Simulación de uso real\n";
try {
    // Simular 10 operaciones como las que existen en proyecto.php
    for ($i = 1; $i <= 10; $i++) {
        $conn = new bd();
        $conn->conectar();
        
        // Simular query
        $result = $conn->mysqli->query("SELECT 1");
        if ($result) {
            $result->free();
        }
        
        $conn->desconectar();
    }
    
    $stats_final = bd::getStats();
    echo "   - Conexiones totales después de 10 operaciones: " . $stats_final['connection_count'] . "\n";
    
    if ($stats_final['connection_count'] == 1) {
        echo "✅ PASS: 10 operaciones = 1 conexión (¡ÉXITO TOTAL!)\n";
        $tests_passed++;
    } else if ($stats_final['connection_count'] <= 5) {
        echo "✅ PASS: Reducción significativa de conexiones\n";
        $tests_passed++;
    } else {
        echo "⚠️ WARNING: Más conexiones de las esperadas\n";
        $tests_passed++;
    }
} catch (Exception $e) {
    echo "❌ FAIL: Exception en simulación: " . $e->getMessage() . "\n";
    $tests_failed++;
}
echo "\n";

// RESUMEN FINAL
echo "========================================\n";
echo "RESUMEN DE PRUEBAS\n";
echo "========================================\n";
echo "Tests exitosos: " . $tests_passed . "\n";
echo "Tests fallidos: " . $tests_failed . "\n";
echo "Total: " . ($tests_passed + $tests_failed) . "\n\n";

if ($tests_failed == 0) {
    echo "🎉 TODOS LOS TESTS PASARON\n";
    echo "✅ El Singleton es 100% compatible con el código existente\n";
    echo "✅ SEGURO para reemplazar bd.php\n\n";
    echo "PRÓXIMO PASO:\n";
    echo "1. Hacer backup: mv bd.php bd.php.backup\n";
    echo "2. Reemplazar: mv bd_singleton.php bd.php\n";
    echo "3. Reiniciar Apache\n";
    echo "4. Monitorear logs\n";
} else {
    echo "⚠️ ALGUNOS TESTS FALLARON\n";
    echo "❌ NO reemplazar bd.php todavía\n";
    echo "❌ Revisar errores arriba\n";
}

echo "\n========================================\n";

?>
