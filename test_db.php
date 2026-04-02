<?php
// Script simple para verificar conexión y base de datos
$host = "localhost";
$user = "root";
$password = "";
$database = "plataforma_fitness";

echo "<h2>Verificación de Base de Datos</h2>";

// Primero, conectar sin especificar DB para listar bases
$conn = new mysqli($host, $user, $password);
if ($conn->connect_error) {
    die("<p style='color: red;'>❌ Error de conexión al servidor MySQL: " . $conn->connect_error . "</p>");
}
echo "<p style='color: green;'>✅ Conexión al servidor MySQL exitosa</p>";

// Listar bases de datos
$databases = [];
$result = $conn->query("SHOW DATABASES");
echo "<h3>Bases de datos disponibles:</h3><ul>";
while ($row = $result->fetch_array(MYSQLI_NUM)) {
    $databases[] = $row[0];
    echo "<li>" . $row[0] . "</li>";
}
echo "</ul>";

// Verificar si 'plataforma_fitness' existe
if (in_array("plataforma_fitness", $databases)) {
    echo "<p style='color: green;'>✅ Base de datos 'plataforma_fitness' existe</p>";
    
    // Conectar a 'plataforma_fitness'
    $conexion = new mysqli($host, $user, $password, $database);
    if ($conexion->connect_error) {
        echo "<p style='color: red;'>❌ Error conectando a 'plataforma_fitness': " . $conexion->connect_error . "</p>";
    } else {
        echo "<p style='color: green;'>✅ Conexión a 'plataforma_fitness' exitosa</p>";
        
        // Listar todas las tablas en la BD
        $tables_result = $conexion->query("SHOW TABLES");
        echo "<h3>Tablas en 'plataforma_fitness':</h3><ul>";
        while ($table_row = $tables_result->fetch_array(MYSQLI_NUM)) {
            echo "<li>" . $table_row[0] . "</li>";
        }
        echo "</ul>";

        // Verificar específicamente 'solicitudes_planes'
        $tabla_result = $conexion->query("SHOW TABLES LIKE 'solicitudes_planes'");
        if ($tabla_result->num_rows > 0) {
            echo "<p style='color: green;'>✅ Tabla 'solicitudes_planes' existe</p>";
            
            // Contar registros
            $count = $conexion->query("SELECT COUNT(*) FROM solicitudes_planes")->fetch_row()[0];
            echo "<p>📊 Registros en 'solicitudes_planes': $count</p>";
        } else {
            echo "<p style='color: red;'>❌ Tabla 'solicitudes_planes' NO existe. El formulario de planes fallará al insertar.</p>";
        }
    }
    $conexion->close();
} else {
    echo "<p style='color: red;'>❌ Base de datos 'plataforma_fitness' NO existe. Ejecuta crear_db_guardar.php primero.</p>";
}

$conn->close();
?>