<?php
/**
 * Script de diagnóstico para capturar errores de PHP
 */

header('Content-Type: application/json');

// Configurar manejo de errores
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "=== Diagnóstico de errores ===\n\n";

try {
    echo "1. Verificando inclusión de Database.php...\n";
    require_once __DIR__ . '/Database.php';
    echo "   ✓ Database.php incluido\n";
    
    echo "\n2. Intentando obtener instancia de Database...\n";
    $db = Database::getInstance();
    echo "   ✓ Instancia de Database obtenida\n";
    
    echo "\n3. Verificando conexión...\n";
    $conn = $db->getConnection();
    echo "   ✓ Conexión obtained\n";
    
    echo "\n4. Verificando tablas...\n";
    $tablas = ['rutinas', 'ejercicios', 'progresos_peso', 'medidas_corporales', 'entrenamientos_realizados', 'objetivos'];
    
    foreach ($tablas as $tabla) {
        $result = $conn->query("SHOW TABLES LIKE '$tabla'");
        if ($result->num_rows > 0) {
            echo "   ✓ Tabla '$tabla' existe\n";
        } else {
            echo "   ✗ Tabla '$tabla' NO existe\n";
        }
    }
    
    echo "\n=== Diagnóstico completado exitosamente ===";
    
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString();
} catch (Error $e) {
    echo "FATAL ERROR: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString();
}