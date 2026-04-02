<?php
/**
 * Script para crear la tabla entrenamientos_realizados en la base de datos plataforma_fitness
 * Ejecutar este archivo desde el navegador una sola vez
 */

header('Content-Type: text/html; charset=utf-8');

echo "<h1>Creando tabla entrenamientos_realizados en plataforma_fitness...</h1>";

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
    
    // Crear tabla entrenamientos_realizados
    $sql = "CREATE TABLE IF NOT EXISTS `entrenamientos_realizados` (
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
    
    if ($conn->query($sql) === TRUE) {
        echo "<p>✓ Tabla 'entrenamientos_realizados' creada exitosamente</p>";
    } else {
        throw new Exception("Error al crear la tabla: " . $conn->error);
    }
    
    // Verificar que la tabla existe
    $result = $conn->query("SHOW TABLES LIKE 'entrenamientos_realizados'");
    if ($result->num_rows > 0) {
        echo "<p>✓ Verificación: La tabla 'entrenamientos_realizados' existe en la base de datos</p>";
        
        // Mostrar estructura de la tabla
        echo "<h2>Estructura de la tabla:</h2>";
        $result = $conn->query("DESCRIBE entrenamientos_realizados");
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
    } else {
        echo "<p style='color: red;'>✗ La tabla 'entrenamientos_realizados' no se creó correctamente</p>";
    }
    
    echo "<h2 style='color: green;'>✓ Tabla entrenamientos_realizados configurada exitosamente</h2>";
    echo "<p>La tabla está lista para registrar entrenamientos en la base de datos plataforma_fitness.</p>";
    echo "<p><a href='index.php'>Ir al inicio</a></p>";
    
    $conn->close();
    
} catch (Exception $e) {
    echo "<p style='color: red;'>✗ Error: " . $e->getMessage() . "</p>";
}
?>
