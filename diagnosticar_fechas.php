<?php
// Script para diagnosticar el problema de fechas en medidas corporales
header('Content-Type: text/html; charset=utf-8');

echo "<h1>🔍 Diagnóstico de Fechas en Medidas Corporales</h1>";

try {
    // Conectar a la base de datos
    $host = "localhost";
    $user = "root";
    $password = "";
    
    $conn = new mysqli($host, $user, $password);
    if ($conn->connect_error) {
        throw new Exception("Error de conexión: " . $conn->connect_error);
    }
    
    // Seleccionar la base de datos
    $conn->select_db("plataforma_fitness");
    echo "<p>✓ Conectado a la base de datos plataforma_fitness</p>";
    
    // Revisar estructura de la tabla medidas_corporales
    echo "<h2>📋 Estructura de la tabla medidas_corporales:</h2>";
    $result = $conn->query("DESCRIBE medidas_corporales");
    echo "<table border='1' style='border-collapse: collapse; margin: 20px 0;'>";
    echo "<tr style='background: #f0f0f0;'><th>Campo</th><th>Tipo</th><th>Nulo</th><th>Key</th></tr>";
    
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td style='padding: 5px; border: 1px solid #ddd;'>" . $row['Field'] . "</td>";
        echo "<td style='padding: 5px; border: 1px solid #ddd;'>" . $row['Type'] . "</td>";
        echo "<td style='padding: 5px; border: 1px solid #ddd;'>" . $row['Null'] . "</td>";
        echo "<td style='padding: 5px; border: 1px solid #ddd;'>" . $row['Key'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    // Revisar datos actuales en la tabla
    echo "<h2>📊 Datos actuales en medidas_corporales:</h2>";
    $result = $conn->query("SELECT id, fecha_medicion, pecho, cintura, cadera, biceps, pierna, notas, fecha_creacion FROM medidas_corporales WHERE usuario_id = 'demo_user' ORDER BY id DESC LIMIT 5");
    
    if ($result->num_rows > 0) {
        echo "<table border='1' style='border-collapse: collapse; margin: 20px 0;'>";
        echo "<tr style='background: #f0f0f0;'><th>ID</th><th>Fecha Medición (BD)</th><th>Tipo Dato</th><th>Fecha Formateada (PHP)</th><th>Notas</th></tr>";
        
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td style='padding: 5px; border: 1px solid #ddd;'>" . $row['id'] . "</td>";
            echo "<td style='padding: 5px; border: 1px solid #ddd;'>" . $row['fecha_medicion'] . "</td>";
            
            // Analizar el tipo de dato
            $tipo_dato = gettype($row['fecha_medicion']);
            echo "<td style='padding: 5px; border: 1px solid #ddd;'>" . $tipo_dato . "</td>";
            
            // Probar el formateo
            try {
                if ($row['fecha_medicion']) {
                    $date_obj = new DateTime($row['fecha_medicion']);
                    $fecha_formateada = $date_obj->format('Y-m-d');
                    echo "<td style='padding: 5px; border: 1px solid #ddd; background: #e8f5e9;'>" . $fecha_formateada . "</td>";
                } else {
                    echo "<td style='padding: 5px; border: 1px solid #ddd; background: #ffebee;'>NULL</td>";
                }
            } catch (Exception $e) {
                echo "<td style='padding: 5px; border: 1px solid #ddd; background: #ffebee;'>Error: " . $e->getMessage() . "</td>";
            }
            
            echo "<td style='padding: 5px; border: 1px solid #ddd;'>" . $row['notas'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p style='color: #666;'>No hay datos de medidas corporales para el usuario demo_user</p>";
    }
    
    // Probar una inserción manual
    echo "<h2>🧪 Prueba de inserción manual:</h2>";
    $test_fecha = '2026-03-27';
    $test_sql = "INSERT INTO medidas_corporales (usuario_id, fecha_medicion, pecho, cintura, cadera, biceps, pierna, notas, fecha_creacion) VALUES ('demo_user', ?, 100, 80, 95, 35, 55, 'Test diagnóstico', NOW())";
    
    $stmt = $conn->prepare($test_sql);
    $stmt->bind_param("s", $test_fecha);
    
    if ($stmt->execute()) {
        echo "<p style='color: #4caf50;'>✅ Inserción de prueba exitosa con fecha: $test_fecha</p>";
        
        // Recuperar el dato insertado
        $insert_id = $stmt->insert_id;
        $result = $conn->query("SELECT fecha_medicion FROM medidas_corporales WHERE id = $insert_id");
        $row = $result->fetch_assoc();
        
        echo "<p style='color: #1976d2;'>📋 Fecha recuperada de BD: " . $row['fecha_medicion'] . "</p>";
        echo "<p style='color: #1976d2;'>🔍 Tipo de dato: " . gettype($row['fecha_medicion']) . "</p>";
        
        // Probar conversión a JSON
        $test_array = ['fecha_medicion' => $row['fecha_medicion']];
        $json_test = json_encode($test_array);
        echo "<p style='color: #1976d2;'>📄 JSON: $json_test</p>";
        
    } else {
        echo "<p style='color: #f44336;'>❌ Error en inserción de prueba: " . $stmt->error . "</p>";
    }
    
    $conn->close();
    
} catch (Exception $e) {
    echo "<p style='color: #f44336;'>❌ Error: " . $e->getMessage() . "</p>";
}

echo "<hr>";
echo "<h3>🔍 Recomendaciones:</h3>";
echo "<ul>";
echo "<li>Si la fecha_medicion es NULL o vacía, JavaScript mostrará 'Invalid Date'</li>";
echo "<li>Verifica que el formulario envíe correctamente la fecha</li>";
echo "<li>Revisa el formato DATE en la base de datos</li>";
echo "</ul>";
?>
