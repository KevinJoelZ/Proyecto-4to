<?php
/**
 * Script de prueba para verificar el funcionamiento de las APIs
 * Ejecutar desde el navegador para probar la creación de rutinas y progresos
 */

header('Content-Type: text/html; charset=utf-8');

echo "<h1>🧪 Prueba de APIs - DeporteFit</h1>";

$test_results = [];

// Función para hacer prueba
function testAPI($name, $url, $method, $data = null) {
    global $test_results;
    
    echo "<h3>Probando: $name</h3>";
    echo "<p>URL: $url</p>";
    
    $context = stream_context_create([
        'http' => [
            'method' => $method,
            'header' => "Content-Type: application/json\r\n",
            'content' => $data ? json_encode($data) : null,
            'ignore_errors' => true
        ]
    ]);
    
    $response = @file_get_contents($url, false, $context);
    
    if ($response === false) {
        echo "<p style='color: red;'>✗ Error de conexión</p>";
        $test_results[$name] = ['success' => false, 'message' => 'Error de conexión'];
        return;
    }
    
    $result = json_decode($response, true);
    
    if ($result) {
        if (isset($result['success']) && $result['success']) {
            echo "<p style='color: green;'>✓ Éxito: " . ($result['message'] ?? 'Operación exitosa') . "</p>";
            if (isset($result['id'])) {
                echo "<p>ID creado: " . $result['id'] . "</p>";
            }
            $test_results[$name] = ['success' => true, 'data' => $result];
        } else {
            echo "<p style='color: orange;'>⚠ Advertencia: " . ($result['message'] ?? 'Sin mensaje') . "</p>";
            $test_results[$name] = ['success' => false, 'message' => $result['message'] ?? 'Error desconocido'];
        }
    } else {
        echo "<p style='color: red;'>✗ Error: Respuesta no válida</p>";
        echo "<pre>" . htmlspecialchars($response) . "</pre>";
        $test_results[$name] = ['success' => false, 'message' => 'Respuesta no válida'];
    }
    
    echo "<hr>";
}

try {
    // 1. Probar GET de rutinas
    testAPI(
        'Obtener Rutinas',
        'http://localhost/Pagina_deportiva1/admin_api/rutinas.php?usuario_id=demo_user',
        'GET'
    );

    // 2. Probar POST para crear rutina
    testAPI(
        'Crear Rutina',
        'http://localhost/Pagina_deportiva1/admin_api/rutinas.php?usuario_id=demo_user',
        'POST',
        [
            'nombre' => 'Rutina de Prueba ' . date('H:i:s'),
            'tipo' => 'fuerza',
            'dificultad' => 'principiante',
            'duracion' => 45,
            'notas' => 'Esta es una rutina de prueba',
            'ejercicios' => [
                ['nombre' => 'Flexiones', 'series' => 3, 'repeticiones' => 10, 'peso' => null, 'descanso' => 60],
                ['nombre' => 'Sentadillas', 'series' => 3, 'repeticiones' => 15, 'peso' => 0, 'descanso' => 90]
            ]
        ]
    );

    // 3. Probar GET de progresos peso
    testAPI(
        'Obtener Progresos Peso',
        'http://localhost/Pagina_deportiva1/admin_api/progresos.php?usuario_id=demo_user&tipo=peso',
        'GET'
    );

    // 4. Probar POST para registrar peso
    testAPI(
        'Registrar Peso',
        'http://localhost/Pagina_deportiva1/admin_api/progresos.php?usuario_id=demo_user&tipo=peso',
        'POST',
        [
            'peso' => 75.5,
            'fecha' => date('Y-m-d'),
            'notas' => 'Peso de prueba'
        ]
    );

    // 5. Probar POST para registrar medidas
    testAPI(
        'Registrar Medidas',
        'http://localhost/Pagina_deportiva1/admin_api/progresos.php?usuario_id=demo_user&tipo=medidas',
        'POST',
        [
            'fecha' => date('Y-m-d'),
            'pecho' => 100.5,
            'cintura' => 82.0,
            'cadera' => 94.5,
            'biceps' => 35.0,
            'pierna' => 55.0,
            'notas' => 'Medidas de prueba'
        ]
    );

    // 6. Probar POST para registrar entrenamiento
    testAPI(
        'Registrar Entrenamiento',
        'http://localhost/Pagina_deportiva1/admin_api/progresos.php?usuario_id=demo_user&tipo=entrenamientos',
        'POST',
        [
            'rutina_id' => 1,
            'nombre_rutina' => 'Rutina de Prueba',
            'intensidad' => 7,
            'sensacion' => 'bien',
            'duracion' => 45,
            'calorias' => 250
        ]
    );

    // Resumen
    echo "<h2>📊 Resumen de Pruebas</h2>";
    echo "<table border='1' cellpadding='10'>";
    echo "<tr><th>Prueba</th><th>Resultado</th></tr>";
    
    foreach ($test_results as $name => $result) {
        $status = $result['success'] ? '✓ Éxito' : '✗ Fallo';
        $color = $result['success'] ? 'green' : 'red';
        echo "<tr><td>$name</td><td style='color: $color;'>$status</td></tr>";
    }
    
    echo "</table>";
    
    $success_count = count(array_filter($test_results, fn($r) => $r['success']));
    $total = count($test_results);
    
    echo "<h3 style='color: " . ($success_count == $total ? 'green' : 'orange') . ";'>";
    echo "Resultado: $success_count de $total pruebas exitosas";
    echo "</h3>";
    
    echo "<p><a href='crear_tablas.php'>Crear tablas</a> | <a href='test_connection.php'>Verificar conexión</a></p>";
    
} catch (Exception $e) {
    echo "<p style='color: red;'>✗ Error: " . $e->getMessage() . "</p>";
}