<?php
/**
 * Test simple de conexión
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "=== Test de Conexión ===<br><br>";

echo "1. Intentando conectar a MySQL...<br>";
$conn = @new mysqli('localhost', 'root', '', 'guardarbd');

if ($conn->connect_error) {
    echo "❌ Error de conexión: " . $conn->connect_error . "<br>";
    echo "<br>Esto significa que la base de datos 'guardarbd' no existe o hay un problema de conexión.";
} else {
    echo "✅ Conexión exitosa a 'guardarbd'<br><br>";
    
    echo "2. Verificando tablas...<br>";
    $result = $conn->query("SHOW TABLES");
    
    echo "Tablas encontradas:<br>";
    while ($row = $result->fetch_array()) {
        echo "  - " . $row[0] . "<br>";
    }
    
    echo "<br>3. Verificando si existen las tablas de avance...<br>";
    $tablas = ['rutinas', 'ejercicios', 'progresos_peso', 'medidas_corporales', 'entrenamientos_realizados', 'objetivos'];
    
    foreach ($tablas as $tabla) {
        $result = $conn->query("SHOW TABLES LIKE '$tabla'");
        if ($result->num_rows > 0) {
            echo "  ✅ $tabla existe<br>";
        } else {
            echo "  ❌ $tabla NO existe<br>";
        }
    }
    
    $conn->close();
}

echo "<br>=== Fin del test ===";