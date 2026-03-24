<?php
/**
 * Script para crear las tablas de avance en la base de datos
 * Ejecutar este archivo desde el navegador
 */

header('Content-Type: text/html; charset=utf-8');

echo "<h1>Creando tablas en la base de datos...</h1>";

try {
    require_once __DIR__ . '/Database.php';
    $db = Database::getInstance();
    $conn = $db->getConnection();
    
    echo "<p>✓ Conexión a la base de datos establecida</p>";
    
    // Leer el archivo SQL
    $sql = file_get_contents(__DIR__ . '/../BD/tablas_avance.sql');
    
    // Separar las consultas por punto y coma
    $consultas = explode(';', $sql);
    
    $contador = 0;
    $errores = [];
    
    foreach ($consultas as $consulta) {
        $consulta = trim($consulta);
        
        // Saltar comentarios y consultas vacías
        if (empty($consulta) || strpos($consulta, '--') === 0) {
            continue;
        }
        
        try {
            $result = $conn->query($consulta);
            if ($result === true || $conn->affected_rows >= 0) {
                $contador++;
            }
        } catch (Exception $e) {
            // Ignorar errores de tabla ya existente
            if (strpos($e->getMessage(), 'already exists') === false) {
                $errores[] = $e->getMessage();
            }
        }
    }
    
    echo "<p>✓ Se ejecutaron $contador consultas</p>";
    
    if (!empty($errores)) {
        echo "<p>⚠ Errores ignorados (tablas ya existentes):</p>";
        echo "<ul>" . implode(', ', array_map(function($e) { return "<li>$e</li>"; }, array_slice($errores, 0, 5))) . "</ul>";
    }
    
    // Verificar que las tablas existen
    echo "<h2>Verificación de tablas:</h2>";
    echo "<ul>";
    
    $tablas = ['rutinas', 'ejercicios', 'progresos_peso', 'medidas_corporales', 'entrenamientos_realizados', 'objetivos'];
    
    foreach ($tablas as $tabla) {
        $result = $conn->query("SHOW TABLES LIKE '$tabla'");
        if ($result->num_rows > 0) {
            echo "<li>✓ Tabla '$tabla' existe</li>";
        } else {
            echo "<li>✗ Tabla '$tabla' NO existe</li>";
        }
    }
    
    echo "</ul>";
    
    // Mostrar datos de ejemplo
    echo "<h2>Datos de ejemplo:</h2>";
    echo "<ul>";
    
    foreach ($tablas as $tabla) {
        $result = $conn->query("SELECT COUNT(*) as total FROM $tabla");
        $row = $result->fetch_assoc();
        echo "<li>$tabla: " . $row['total'] . " registros</li>";
    }
    
    echo "</ul>";
    
    echo "<h2 style='color: green;'>✓ Proceso completado</h2>";
    echo "<p><a href='test_connection.php'>Ir al test de conexión</a></p>";
    
} catch (Exception $e) {
    echo "<p style='color: red;'>✗ Error: " . $e->getMessage() . "</p>";
}