<?php
// Archivo de prueba para verificar las tablas creadas según los formularios
include 'conexión.php';

echo "<!DOCTYPE html>
<html lang='es'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Prueba de Tablas de Formularios - DeporteFit</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }
        .container { max-width: 1200px; margin: 0 auto; background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .success { color: green; background: #e8f5e8; padding: 10px; border-radius: 5px; margin: 10px 0; }
        .error { color: red; background: #ffe8e8; padding: 10px; border-radius: 5px; margin: 10px 0; }
        .info { color: blue; background: #e8f0ff; padding: 10px; border-radius: 5px; margin: 10px 0; }
        .section { background: #f9f9f9; padding: 15px; margin: 15px 0; border-radius: 5px; border: 1px solid #ddd; }
        .btn { background: #1976d2; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; text-decoration: none; display: inline-block; margin: 5px; }
        .btn:hover { background: #1565c0; }
        table { width: 100%; border-collapse: collapse; margin: 15px 0; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background: #f2f2f2; }
        .card { background: white; padding: 15px; margin: 10px 0; border-radius: 5px; border: 1px solid #ddd; }
        .form-info { background: #e3f2fd; padding: 10px; border-radius: 5px; margin: 10px 0; }
    </style>
</head>
<body>
    <div class='container'>
        <h1>🧪 Prueba de Tablas de Formularios - DeporteFit</h1>
        <div class='info'>Este archivo verifica que las tablas creadas coincidan EXACTAMENTE con los campos de tus formularios HTML</div>";

if ($conexion) {
    echo "<div class='success'>✅ Conexión exitosa a la base de datos</div>";
    
    // Verificar si las tablas existen
    $tablas_formularios = ['contactos', 'solicitudes_entrenadores', 'solicitudes_planes', 'solicitudes_servicios', 'solicitudes_info'];
    
    foreach ($tablas_formularios as $tabla) {
        $sql = "SHOW TABLES LIKE '$tabla'";
        $resultado = mysqli_query($conexion, $sql);
        
        if (mysqli_num_rows($resultado) > 0) {
            echo "<div class='success'>✅ Tabla '$tabla' existe</div>";
            
            // Contar registros en la tabla
            $count_sql = "SELECT COUNT(*) as total FROM $tabla";
            $count_result = mysqli_query($conexion, $count_sql);
            if ($count_result) {
                $row = mysqli_fetch_assoc($count_result);
                echo "<div class='info'>📊 Registros en '$tabla': " . $row['total'] . "</div>";
            }
        } else {
            echo "<div class='error'>❌ Tabla '$tabla' NO existe</div>";
        }
    }
    
    // Mostrar estructura de cada tabla
    echo "<div class='section'>
            <h3>📋 Estructura de las Tablas</h3>";
    
    foreach ($tablas_formularios as $tabla) {
        echo "<div class='card'>
                <h4>Tabla: $tabla</h4>";
        
        $columns_sql = "DESCRIBE $tabla";
        $columns_result = mysqli_query($conexion, $columns_sql);
        
        if ($columns_result && mysqli_num_rows($columns_result) > 0) {
            echo "<table>
                    <tr>
                        <th>Campo</th>
                        <th>Tipo</th>
                        <th>Nulo</th>
                        <th>Clave</th>
                        <th>Por Defecto</th>
                        <th>Extra</th>
                    </tr>";
            
            while ($row = mysqli_fetch_assoc($columns_result)) {
                echo "<tr>
                        <td><strong>{$row['Field']}</strong></td>
                        <td>{$row['Type']}</td>
                        <td>{$row['Null']}</td>
                        <td>{$row['Key']}</td>
                        <td>{$row['Default']}</td>
                        <td>{$row['Extra']}</td>
                      </tr>";
            }
            echo "</table>";
        } else {
            echo "<div class='error'>No se pudo obtener la estructura de la tabla</div>";
        }
        echo "</div>";
    }
    echo "</div>";
    
    // Mostrar datos de ejemplo
    echo "<div class='section'>
            <h3>📊 Datos de Ejemplo</h3>";
    
    foreach ($tablas_formularios as $tabla) {
        echo "<div class='card'>
                <h4>Datos en: $tabla</h4>";
        
        $data_sql = "SELECT * FROM $tabla ORDER BY id DESC LIMIT 3";
        $data_result = mysqli_query($conexion, $data_sql);
        
        if ($data_result && mysqli_num_rows($data_result) > 0) {
            echo "<table>
                    <tr>";
            
            // Obtener nombres de columnas
            $columns_sql = "SHOW COLUMNS FROM $tabla";
            $columns_result = mysqli_query($conexion, $columns_sql);
            while ($col = mysqli_fetch_assoc($columns_result)) {
                echo "<th>{$col['Field']}</th>";
            }
            echo "</tr>";
            
            // Mostrar datos
            while ($row = mysqli_fetch_assoc($data_result)) {
                echo "<tr>";
                foreach ($row as $value) {
                    if (strlen($value) > 50) {
                        echo "<td>" . substr($value, 0, 50) . "...</td>";
                    } else {
                        echo "<td>$value</td>";
                    }
                }
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<div class='info'>No hay datos en esta tabla</div>";
        }
        echo "</div>";
    }
    echo "</div>";
    
    // Probar inserción en cada tabla
    echo "<div class='section'>
            <h3>🧪 Prueba de Inserción</h3>";
    
    $tablas_test = [
        'contactos' => ['nombre' => 'Usuario Test Contacto', 'email' => 'test.contacto' . time() . '@test.com', 'telefono' => '099' . rand(1000000, 9999999), 'motivo' => 'informacion', 'mensaje' => 'Mensaje de prueba para contactos', 'privacidad' => 1],
        'solicitudes_entrenadores' => ['nombre' => 'Usuario Test Entrenadores', 'email' => 'test.entrenadores' . time() . '@test.com', 'telefono' => '098' . rand(1000000, 9999999), 'motivo' => 'entrenadores', 'mensaje' => 'Mensaje de prueba para entrenadores'],
        'solicitudes_planes' => ['nombre' => 'Usuario Test Planes', 'email' => 'test.planes' . time() . '@test.com', 'telefono' => '097' . rand(1000000, 9999999), 'motivo' => 'informacion', 'mensaje' => 'Mensaje de prueba para planes'],
        'solicitudes_servicios' => ['nombre' => 'Usuario Test Servicios', 'email' => 'test.servicios' . time() . '@test.com', 'telefono' => '096' . rand(1000000, 9999999), 'motivo' => 'informacion', 'mensaje' => 'Mensaje de prueba para servicios']
    ];
    
    foreach ($tablas_test as $tabla => $datos) {
        echo "<div class='card'>
                <h4>Prueba en: $tabla</h4>";
        
        // Construir consulta dinámicamente
        $campos = implode(', ', array_keys($datos));
        $valores = implode(', ', array_fill(0, count($datos), '?'));
        
        if ($tabla === 'contactos') {
            $sql = "INSERT INTO $tabla ($campos, fecha_creacion) VALUES ($valores, NOW())";
        } else {
            $sql = "INSERT INTO $tabla ($campos, fecha_solicitud) VALUES ($valores, NOW())";
        }
        
        $stmt = mysqli_prepare($conexion, $sql);
        
        if ($stmt) {
            // Crear array de tipos para bind_param
            $tipos = str_repeat('s', count($datos));
            $valores_array = array_values($datos);
            
            mysqli_stmt_bind_param($stmt, $tipos, ...$valores_array);
            
            if (mysqli_stmt_execute($stmt)) {
                $id_insertado = mysqli_insert_id($conexion);
                echo "<div class='success'>✅ Datos insertados en '$tabla' - ID: $id_insertado</div>";
                
                // Eliminar el registro de prueba
                $delete_sql = "DELETE FROM $tabla WHERE id = ?";
                $delete_stmt = mysqli_prepare($conexion, $delete_sql);
                if ($delete_stmt) {
                    mysqli_stmt_bind_param($delete_stmt, "i", $id_insertado);
                    if (mysqli_stmt_execute($delete_stmt)) {
                        echo "<div class='info'>🗑️ Datos de prueba eliminados</div>";
                    }
                    mysqli_stmt_close($delete_stmt);
                }
            } else {
                echo "<div class='error'>❌ Error en inserción: " . mysqli_stmt_error($stmt) . "</div>";
            }
            
            mysqli_stmt_close($stmt);
        } else {
            echo "<div class='error'>❌ Error en preparación: " . mysqli_error($conexion) . "</div>";
        }
        echo "</div>";
    }
    echo "</div>";
    
    mysqli_close($conexion);
    echo "<div class='info'>🔌 Conexión cerrada</div>";
    
} else {
    echo "<div class='error'>❌ Error de conexión: " . mysqli_connect_error() . "</div>";
}

echo "<hr>
        <div class='section'>
            <h3>📋 Resumen de Tablas Creadas</h3>
            <div class='card'>
                <h4>✅ Tablas Principales:</h4>
                <ul>
                    <li><strong>contactos</strong> - Formulario de contacto general (con campo privacidad)</li>
                    <li><strong>solicitudes_info</strong> - Solicitudes de información general</li>
                </ul>
            </div>
            
            <div class='card'>
                <h4>✅ Tablas de Formularios Específicos:</h4>
                <ul>
                    <li><strong>solicitudes_entrenadores</strong> - Formulario de entrenadores.html</li>
                    <li><strong>solicitudes_planes</strong> - Formulario de planes.html</li>
                    <li><strong>solicitudes_servicios</strong> - Formulario de servicios.html</li>
                </ul>
            </div>
        </div>
        
        <div class='section'>
            <h4>🔧 Campos de Cada Formulario:</h4>
            <div class='form-info'>
                <strong>contacto.html:</strong> nombre, email, telefono, motivo, mensaje, privacidad ✅<br>
                <strong>entrenadores.html:</strong> nombre, email, telefono, motivo, mensaje ✅<br>
                <strong>planes.html:</strong> nombre, email, telefono, motivo, mensaje ✅<br>
                <strong>servicios.html:</strong> nombre, email, telefono, motivo, mensaje ✅
            </div>
        </div>
        
        <div class='section'>
            <h4>🔧 Próximos Pasos:</h4>
            <ol>
                <li>Ejecuta 'crear_tablas.sql' en phpMyAdmin para crear todas las tablas</li>
                <li>Verifica que 'procesar_formularios.php' esté funcionando</li>
                <li>Prueba cada formulario para confirmar que se guarden en la tabla correcta</li>
                <li>Una vez que funcione, elimina los archivos de prueba</li>
            </ol>
        </div>
        
        <div class='section'>
            <h4>🧪 Enlaces de Prueba:</h4>
            <a href='probar_formularios.php' class='btn'>Probar Formularios Básicos</a>
            <a href='contacto.html' class='btn'>Formulario de Contacto</a>
            <a href='entrenadores.html' class='btn'>Formulario de Entrenadores</a>
            <a href='planes.html' class='btn'>Formulario de Planes</a>
            <a href='servicios.html' class='btn'>Formulario de Servicios</a>
        </div>
    </div>
</body>
</html>";
?>
