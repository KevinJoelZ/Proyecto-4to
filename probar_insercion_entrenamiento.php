<?php
/**
 * Script para probar la inserción de datos en la tabla entrenamientos_realizados
 * Este script inserta datos de prueba y verifica si se guardaron correctamente
 */

header('Content-Type: text/html; charset=utf-8');

echo "<h1>Probando inserción de datos en entrenamientos_realizados...</h1>";

try {
    // Conectar a la base de datos plataforma_fitness
    $host = "localhost";
    $user = "root";
    $password = "";
    $database = "plataforma_fitness";
    
    $conn = new mysqli($host, $user, $password, $database);
    if ($conn->connect_error) {
        throw new Exception("Error de conexión a plataforma_fitness: " . $conn->connect_error);
    }
    
    echo "<p>✓ Conexión a plataforma_fitness establecida</p>";
    
    // Verificar si la tabla existe
    $result = $conn->query("SHOW TABLES LIKE 'entrenamientos_realizados'");
    if ($result->num_rows == 0) {
        echo "<p style='color: red;'>✗ La tabla 'entrenamientos_realizados' NO existe</p>";
        echo "<p>Creando la tabla ahora...</p>";
        
        // Crear tabla entrenamientos_realizados
        $sql_create = "CREATE TABLE IF NOT EXISTS `entrenamientos_realizados` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `usuario_id` varchar(100) DEFAULT NULL,
            `rutina_id` int(11) DEFAULT NULL,
            `nombre_rutina` varchar(150) DEFAULT NULL,
            `intensidad` int(11) DEFAULT 5 COMMENT '1-10',
            `sensacion` enum('excelente','bien','regular','cansado','agotado') DEFAULT 'bien',
            `duracion_real` int(11) DEFAULT NULL COMMENT 'Duración real en minutos',
            `calorias` int(11) DEFAULT NULL,
            `fecha_entrenamiento` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            KEY `idx_usuario` (`usuario_id`),
            KEY `idx_fecha` (`fecha_entrenamiento`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
        
        if ($conn->query($sql_create) === TRUE) {
            echo "<p>✓ Tabla 'entrenamientos_realizados' creada exitosamente</p>";
        } else {
            throw new Exception("Error al crear la tabla: " . $conn->error);
        }
    } else {
        echo "<p>✓ La tabla 'entrenamientos_realizados' ya existe</p>";
    }
    
    // Contar registros antes de la inserción
    $result = $conn->query("SELECT COUNT(*) as total FROM entrenamientos_realizados");
    $row = $result->fetch_assoc();
    $total_antes = $row['total'];
    echo "<p>Total de registros antes de la inserción: $total_antes</p>";
    
    // Insertar datos de prueba
    echo "<h2>Insertando datos de prueba...</h2>";
    
    $sql_insert = "INSERT INTO entrenamientos_realizados (usuario_id, rutina_id, nombre_rutina, intensidad, sensacion, duracion_real, calorias) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql_insert);
    
    if ($stmt) {
        $usuario_id = 'demo_user';
        $rutina_id = 1;
        $nombre_rutina = 'Rutina de Prueba';
        $intensidad = 8;
        $sensacion = 'bien';
        $duracion_real = 60;
        $calorias = 350;
        
        $stmt->bind_param("sisisii", $usuario_id, $rutina_id, $nombre_rutina, $intensidad, $sensacion, $duracion_real, $calorias);
        
        if ($stmt->execute()) {
            echo "<p>✓ Inserción exitosa</p>";
            
            // Obtener el ID insertado
            $insert_id = $stmt->insert_id;
            echo "<p>ID del registro insertado: $insert_id</p>";
            
            // Verificar que el registro se insertó correctamente
            $result = $conn->query("SELECT * FROM entrenamientos_realizados WHERE id = $insert_id");
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
                echo "<li>Duración Real: " . $row['duracion_real'] . " min</li>";
                echo "<li>Calorías: " . $row['calorias'] . "</li>";
                echo "<li>Fecha Entrenamiento: " . $row['fecha_entrenamiento'] . "</li>";
                echo "</ul>";
            }
        } else {
            echo "<p style='color: red;'>✗ Error al insertar datos: " . $stmt->error . "</p>";
        }
        
        $stmt->close();
    } else {
        echo "<p style='color: red;'>✗ Error al preparar la consulta: " . $conn->error . "</p>";
    }
    
    // Contar registros después de la inserción
    $result = $conn->query("SELECT COUNT(*) as total FROM entrenamientos_realizados");
    $row = $result->fetch_assoc();
    $total_despues = $row['total'];
    echo "<p>Total de registros después de la inserción: $total_despues</p>";
    
    if ($total_despues > $total_antes) {
        echo "<p style='color: green;'>✓ Se insertó correctamente un nuevo registro</p>";
    } else {
        echo "<p style='color: red;'>✗ No se insertó ningún registro</p>";
    }
    
    // Mostrar todos los registros
    echo "<h2>Todos los registros en la tabla:</h2>";
    $result = $conn->query("SELECT * FROM entrenamientos_realizados ORDER BY fecha_entrenamiento DESC LIMIT 10");
    if ($result->num_rows > 0) {
        echo "<table border='1' cellpadding='5'>";
        echo "<tr><th>ID</th><th>Usuario</th><th>Rutina</th><th>Intensidad</th><th>Sensación</th><th>Duración</th><th>Calorías</th><th>Fecha</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['usuario_id'] . "</td>";
            echo "<td>" . $row['nombre_rutina'] . "</td>";
            echo "<td>" . $row['intensidad'] . "</td>";
            echo "<td>" . $row['sensacion'] . "</td>";
            echo "<td>" . $row['duracion_real'] . " min</td>";
            echo "<td>" . $row['calorias'] . "</td>";
            echo "<td>" . $row['fecha_entrenamiento'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No hay registros en la tabla</p>";
    }
    
    echo "<h2 style='color: green;'>✓ Prueba completada</h2>";
    echo "<p>La tabla 'entrenamientos_realizados' está funcionando correctamente.</p>";
    echo "<p>Ahora puedes usar el formulario de entrenamiento en la página de avance.</p>";
    echo "<p><a href='avance.php'>Ir a la página de avance</a> | <a href='index.php'>Ir al inicio</a></p>";
    
    $conn->close();
    
} catch (Exception $e) {
    echo "<p style='color: red;'>✗ Error: " . $e->getMessage() . "</p>";
}
?>
