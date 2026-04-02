<?php
/**
 * Script para crear la tabla medidas_corporales en la base de datos plataforma_fitness
 * Ejecutar este archivo desde el navegador una sola vez
 */

header('Content-Type: text/html; charset=utf-8');

echo "<h1>Creando tabla medidas_corporales en plataforma_fitness...</h1>";

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
    
    // Crear tabla medidas_corporales
    $sql = "CREATE TABLE IF NOT EXISTS `medidas_corporales` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `usuario_id` varchar(100) DEFAULT NULL,
        `fecha_medicion` date NOT NULL,
        `pecho` decimal(5,2) DEFAULT NULL,
        `cintura` decimal(5,2) DEFAULT NULL,
        `cadera` decimal(5,2) DEFAULT NULL,
        `biceps` decimal(5,2) DEFAULT NULL,
        `pierna` decimal(5,2) DEFAULT NULL,
        `notas` text,
        `fecha_creacion` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        KEY `idx_usuario` (`usuario_id`),
        KEY `idx_fecha` (`fecha_medicion`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
    
    if ($conn->query($sql) === TRUE) {
        echo "<p>✓ Tabla 'medidas_corporales' creada exitosamente</p>";
    } else {
        throw new Exception("Error al crear la tabla: " . $conn->error);
    }
    
    // Verificar que la tabla existe
    $result = $conn->query("SHOW TABLES LIKE 'medidas_corporales'");
    if ($result->num_rows > 0) {
        echo "<p>✓ Verificación: La tabla 'medidas_corporales' existe en la base de datos</p>";
        
        // Mostrar estructura de la tabla
        echo "<h2>Estructura de la tabla:</h2>";
        $result = $conn->query("DESCRIBE medidas_corporales");
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
        echo "<p style='color: red;'>✗ La tabla 'medidas_corporales' no se creó correctamente</p>";
    }
    
    echo "<h2 style='color: green;'>✓ Tabla medidas_corporales configurada exitosamente</h2>";
    echo "<p>La tabla está lista para almacenar medidas corporales en la base de datos plataforma_fitness.</p>";
    echo "<p><a href='index.php'>Ir al inicio</a></p>";
    
    $conn->close();
    
} catch (Exception $e) {
    echo "<p style='color: red;'>✗ Error: " . $e->getMessage() . "</p>";
}
?>
