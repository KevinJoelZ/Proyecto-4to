<?php
/**
 * Script de diagnóstico para verificar la conexión a la base de datos
 * y el funcionamiento de las APIs de rutinas y progresos
 */

header('Content-Type: application/json');

echo "=== DIAGNÓSTICO DE CONEXIÓN A LA BASE DE DATOS ===\n\n";

// 1. Verificar conexión a la base de datos
try {
    require_once __DIR__ . '/Database.php';
    $db = Database::getInstance();
    $conn = $db->getConnection();
    
    echo "✓ Conexión a la base de datos establecida correctamente\n";
    echo "  Base de datos: guardarbd\n";
    echo "  Servidor: localhost\n\n";
} catch (Exception $e) {
    echo "✗ ERROR DE CONEXIÓN: " . $e->getMessage() . "\n";
    exit;
}

// 2. Verificar que las tablas existan
$tablas = ['rutinas', 'ejercicios', 'progresos_peso', 'medidas_corporales', 'entrenamientos_realizados', 'objetivos'];

echo "=== VERIFICACIÓN DE TABLAS ===\n\n";

foreach ($tablas as $tabla) {
    $result = $conn->query("SHOW TABLES LIKE '$tabla'");
    if ($result->num_rows > 0) {
        echo "✓ Tabla '$tabla' existe\n";
        
        // Contar registros
        $count = $conn->query("SELECT COUNT(*) as total FROM $tabla");
        $row = $count->fetch_assoc();
        echo "  Registros: " . $row['total'] . "\n";
    } else {
        echo "✗ Tabla '$tabla' NO existe\n";
    }
}

echo "\n";

// 3. Verificar estructura de la tabla rutinas
echo "=== ESTRUCTURA DE LA TABLA 'rutinas' ===\n\n";
$result = $conn->query("DESCRIBE rutinas");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        echo $row['Field'] . " - " . $row['Type'] . " - " . ($row['Null'] === 'YES' ? 'NULL' : 'NOT NULL') . "\n";
    }
}

echo "\n";

// 4. Verificar estructura de la tabla progresos_peso
echo "=== ESTRUCTURA DE LA TABLA 'progresos_peso' ===\n\n";
$result = $conn->query("DESCRIBE progresos_peso");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        echo $row['Field'] . " - " . $row['Type'] . " - " . ($row['Null'] === 'YES' ? 'NULL' : 'NOT NULL') . "\n";
    }
}

echo "\n=== FIN DEL DIAGNÓSTICO ===";