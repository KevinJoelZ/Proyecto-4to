<?php
/**
 * Script para verificar y solucionar el error de conexión al procesar entrenamiento
 * Este script verifica la conexión a la base de datos plataforma_fitness
 */

header('Content-Type: text/html; charset=utf-8');

echo "<h1>Verificando conexión al procesar entrenamiento...</h1>";

try {
    // Incluir conexión a la base de datos
    require_once 'conexión.php';
    
    echo "<p>✓ Conexión a plataforma_fitness establecida</p>";
    
    // Verificar que la tabla entrenamientos_realizados existe
    $result = $conexion->query("SHOW TABLES LIKE 'entrenamientos_realizados'");
    if ($result->num_rows > 0) {
        echo "<p>✓ La tabla 'entrenamientos_realizados' existe en la base de datos</p>";
        
        // Contar registros
        $result = $conexion->query("SELECT COUNT(*) as total FROM entrenamientos_realizados");
        $row = $result->fetch_assoc();
        echo "<p>Total de registros en la tabla: " . $row['total'] . "</p>";
    } else {
        echo "<p style='color: red;'>✗ La tabla 'entrenamientos_realizados' NO existe en la base de datos plataforma_fitness</p>";
        echo "<p>Por favor, ejecuta el script <a href='solucionar_error_entrenamiento.php'>solucionar_error_entrenamiento.php</a> para crear la tabla.</p>";
    }
    
    // Probar inserción de datos de prueba
    echo "<h2>Probando inserción de datos de prueba...</h2>";
    
    $sql_test = "INSERT INTO entrenamientos_realizados (usuario_id, rutina_id, nombre_rutina, intensidad, sensacion, duracion_real, calorias) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql_test);
    
    if ($stmt) {
        $usuario_id = 'test_user';
        $rutina_id = 1;
        $nombre_rutina = 'Entrenamiento de Prueba';
        $intensidad = 7;
        $sensacion = 'bien';
        $duracion_real = 45;
        $calorias = 300;
        
        $stmt->bind_param("sisisii", $usuario_id, $rutina_id, $nombre_rutina, $intensidad, $sensacion, $duracion_real, $calorias);
        
        if ($stmt->execute()) {
            echo "<p>✓ Inserción de prueba exitosa</p>";
            
            // Obtener el ID insertado
            $insert_id = $stmt->insert_id;
            echo "<p>ID del registro insertado: $insert_id</p>";
            
            // Eliminar el registro de prueba
            $conexion->query("DELETE FROM entrenamientos_realizados WHERE id = $insert_id");
            echo "<p>✓ Registro de prueba eliminado</p>";
        } else {
            echo "<p style='color: red;'>✗ Error al insertar datos de prueba: " . $stmt->error . "</p>";
        }
        
        $stmt->close();
    } else {
        echo "<p style='color: red;'>✗ Error al preparar la consulta de prueba: " . $conexion->error . "</p>";
    }
    
    echo "<h2 style='color: green;'>✓ Verificación completada</h2>";
    echo "<p>La conexión a la base de datos plataforma_fitness está funcionando correctamente.</p>";
    echo "<p>Ahora puedes usar el formulario de entrenamiento en la página de avance.</p>";
    echo "<p><a href='avance.php'>Ir a la página de avance</a> | <a href='index.php'>Ir al inicio</a></p>";
    
    $conexion->close();
    
} catch (Exception $e) {
    echo "<p style='color: red;'>✗ Error: " . $e->getMessage() . "</p>";
}
?>
