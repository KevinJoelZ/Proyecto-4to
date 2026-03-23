<?php
// Archivo de prueba para verificar la conexión a la base de datos
include '../PHP/conexión.php';

echo "<h2>Prueba de Conexión a Base de Datos</h2>";

if ($conexion) {
    echo "<p style='color: green;'>✅ Conexión exitosa a la base de datos</p>";
    
    // Verificar si las tablas existen
    $tablas = ['contactos', 'solicitudes_info'];
    
    foreach ($tablas as $tabla) {
        $sql = "SHOW TABLES LIKE '$tabla'";
        $resultado = mysqli_query($conexion, $sql);
        
        if (mysqli_num_rows($resultado) > 0) {
            echo "<p style='color: green;'>✅ Tabla '$tabla' existe</p>";
            
            // Contar registros en la tabla
            $count_sql = "SELECT COUNT(*) as total FROM $tabla";
            $count_result = mysqli_query($conexion, $count_sql);
            if ($count_result) {
                $row = mysqli_fetch_assoc($count_result);
                echo "<p>📊 Registros en '$tabla': " . $row['total'] . "</p>";
            }
        } else {
            echo "<p style='color: red;'>❌ Tabla '$tabla' NO existe</p>";
        }
    }
    
    // Probar inserción de datos de prueba
    echo "<h3>Insertando datos de prueba...</h3>";
    
    $test_sql = "INSERT INTO contactos (nombre, email, telefono, motivo, mensaje, fecha_creacion) VALUES (?, ?, ?, ?, ?, NOW())";
    $stmt = mysqli_prepare($conexion, $test_sql);
    
    if ($stmt) {
        $nombre = "Usuario Prueba";
        $email = "prueba@test.com";
        $telefono = "0999999999";
        $motivo = "prueba";
        $mensaje = "Este es un mensaje de prueba para verificar la funcionalidad.";
        
        mysqli_stmt_bind_param($stmt, "sssss", $nombre, $email, $telefono, $motivo, $mensaje);
        
        if (mysqli_stmt_execute($stmt)) {
            echo "<p style='color: green;'>✅ Inserción de prueba exitosa</p>";
            
            // Obtener el ID insertado
            $id_insertado = mysqli_insert_id($conexion);
            echo "<p>🆔 ID del registro insertado: $id_insertado</p>";
            
            // Eliminar el registro de prueba
            $delete_sql = "DELETE FROM contactos WHERE id = ?";
            $delete_stmt = mysqli_prepare($conexion, $delete_sql);
            if ($delete_stmt) {
                mysqli_stmt_bind_param($delete_stmt, "i", $id_insertado);
                if (mysqli_stmt_execute($delete_stmt)) {
                    echo "<p style='color: blue;'>🗑️ Registro de prueba eliminado</p>";
                }
                mysqli_stmt_close($delete_stmt);
            }
        } else {
            echo "<p style='color: red;'>❌ Error en inserción de prueba: " . mysqli_stmt_error($stmt) . "</p>";
        }
        
        mysqli_stmt_close($stmt);
    } else {
        echo "<p style='color: red;'>❌ Error preparando consulta de prueba: " . mysqli_error($conexion) . "</p>";
    }
    
    mysqli_close($conexion);
    echo "<p style='color: blue;'>🔌 Conexión cerrada</p>";
    
} else {
    echo "<p style='color: red;'>❌ Error de conexión: " . mysqli_connect_error() . "</p>";
}

echo "<hr>";
echo "<p><strong>Instrucciones:</strong></p>";
echo "<ul>";
echo "<li>Si ves errores de tablas, ejecuta el archivo 'crear_tablas.sql' en tu base de datos</li>";
echo "<li>Si ves errores de conexión, verifica los datos en 'conexión.php'</li>";
echo "<li>Si todo funciona, puedes eliminar este archivo de prueba</li>";
echo "</ul>";
?>
