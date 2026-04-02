<?php
/**
 * Script para diagnosticar el error de conexión al procesar entrenamiento
 * Este script verifica la conexión a la base de datos plataforma_fitness
 * y la tabla entrenamientos_realizados
 */

header('Content-Type: text/html; charset=utf-8');

echo "<h1>Diagnosticando error de conexión al procesar entrenamiento...</h1>";

try {
    // Incluir conexión a la base de datos
    require_once 'conexión.php';
    
    echo "<p>✓ Conexión a plataforma_fitness establecida</p>";
    
    // Verificar que la tabla entrenamientos_realizados existe
    $result = $conexion->query("SHOW TABLES LIKE 'entrenamientos_realizados'");
    if ($result->num_rows > 0) {
        echo "<p>✓ La tabla 'entrenamientos_realizados' existe en la base de datos</p>";
        
        // Mostrar estructura de la tabla
        echo "<h2>Estructura de la tabla:</h2>";
        $result = $conexion->query("DESCRIBE entrenamientos_realizados");
        echo "<table border='1' cellpadding='5'>";
        echo "<tr><th>Campo</th><th>Tipo</th><th>Nulo</th><th>Clave</th><th>Por defecto</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['Field'] . "</td>";
            echo "<td>" . $row['Type'] . "</td>";
            echo "<td>" . $row['Null'] . "</td>";
            echo "<td>" . $row['Key'] . "</td>";
            echo "<td>" . $row['Default'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        
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
            
            // Verificar que el registro se insertó correctamente
            $result = $conexion->query("SELECT * FROM entrenamientos_realizados WHERE id = $insert_id");
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                echo "<p>✓ Registro verificado en la base de datos:</p>";
                echo "<ul>";
                echo "<li>ID: " . $row['id'] . "</li>";
                echo "<li>Usuario: " . $row['usuario_id'] . "</li>";
                echo "<li>Rutina ID: " . $row['rutina_id'] . "</li>";
                echo "<li>Nombre Rutina: " . $row['nombre_rutina'] . "</li>";
                echo "<li>Intensidad: " . $row['intensidad'] . "</li>";
                echo "<li>Sensación: " . $row['sensacion'] . "</li>";
                echo "<li>Duración Real: " . $row['duracion_real'] . "</li>";
                echo "<li>Calorías: " . $row['calorias'] . "</li>";
                echo "<li>Fecha Entrenamiento: " . $row['fecha_entrenamiento'] . "</li>";
                echo "</ul>";
            }
            
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
    
    echo "<h2 style='color: green;'>✓ Diagnóstico completado</h2>";
    echo "<p>La conexión a la base de datos plataforma_fitness está funcionando correctamente.</p>";
    echo "<p>Ahora puedes usar el formulario de entrenamiento en la página de avance.</p>";
    echo "<p><a href='avance.php'>Ir a la página de avance</a> | <a href='index.php'>Ir al inicio</a></p>";
    
    $conexion->close();
    
} catch (Exception $e) {
    echo "<p style='color: red;'>✗ Error: " . $e->getMessage() . "</p>";
}
?>
