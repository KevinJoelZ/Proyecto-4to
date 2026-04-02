<?php
/**
 * Script para verificar la conexión a la base de datos plataforma_fitness
 */

header('Content-Type: text/html; charset=utf-8');

echo "<h1>Verificación de Base de Datos plataforma_fitness</h1>";

try {
    // Conectar a plataforma_fitness
    $host = "localhost";
    $user = "root";
    $password = "";
    $database = "plataforma_fitness";
    
    $conn = new mysqli($host, $user, $password, $database);
    if ($conn->connect_error) {
        throw new Exception("Error de conexión: " . $conn->connect_error);
    }
    
    echo "<p style='color: green;'>✅ Conexión exitosa a plataforma_fitness</p>";
    
    // Listar todas las tablas
    $tables_result = $conn->query("SHOW TABLES");
    echo "<h3>Tablas en plataforma_fitness:</h3><ul>";
    $tablas = [];
    while ($table_row = $tables_result->fetch_array(MYSQLI_NUM)) {
        $tablas[] = $table_row[0];
        echo "<li>" . $table_row[0] . "</li>";
    }
    echo "</ul>";
    
    // Verificar tablas de formularios
    $tablas_formularios = ['contactos', 'solicitudes_entrenadores', 'solicitudes_planes', 'solicitudes_servicios'];
    echo "<h3>Verificación de tablas de formularios:</h3><ul>";
    
    foreach ($tablas_formularios as $tabla) {
        if (in_array($tabla, $tablas)) {
            $count = $conn->query("SELECT COUNT(*) FROM $tabla")->fetch_row()[0];
            echo "<li style='color: green;'>✅ $tabla: $count registros</li>";
        } else {
            echo "<li style='color: red;'>❌ $tabla: NO existe</li>";
        }
    }
    echo "</ul>";
    
    // Verificar tablas de avance
    $tablas_avance = ['rutinas', 'ejercicios', 'progresos_peso', 'medidas_corporales', 'entrenamientos_realizados', 'objetivos'];
    echo "<h3>Verificación de tablas de avance:</h3><ul>";
    
    foreach ($tablas_avance as $tabla) {
        if (in_array($tabla, $tablas)) {
            $count = $conn->query("SELECT COUNT(*) FROM $tabla")->fetch_row()[0];
            echo "<li style='color: green;'>✅ $tabla: $count registros</li>";
        } else {
            echo "<li style='color: red;'>❌ $tabla: NO existe</li>";
        }
    }
    echo "</ul>";
    
    // Probar inserción
    echo "<h3>Probando inserción...</h3>";
    
    $test_insert = "INSERT INTO contactos (nombre, email, telefono, motivo, mensaje, privacidad) VALUES 
    ('Usuario Prueba', 'test@example.com', '0991234567', 'informacion', 'Mensaje de prueba', 1)";
    
    if ($conn->query($test_insert)) {
        echo "<p style='color: green;'>✅ Inserción de prueba exitosa</p>";
        
        // Eliminar el registro de prueba
        $conn->query("DELETE FROM contactos WHERE email = 'test@example.com'");
        echo "<p>🧹 Registro de prueba eliminado</p>";
    } else {
        echo "<p style='color: red;'>❌ Error en inserción de prueba: " . $conn->error . "</p>";
    }
    
    echo "<h2 style='color: green;'>✅ Verificación completada</h2>";
    echo "<p><a href='../index.php'>Ir al inicio</a> | <a href='../contacto.php'>Probar formulario de contacto</a></p>";
    
    $conn->close();
    
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Error: " . $e->getMessage() . "</p>";
    echo "<p>Asegúrate de ejecutar primero <a href='crear_db_guardar.php'>crear_db_guardar.php</a></p>";
}
?>
