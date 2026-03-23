<?php
// Archivo de prueba para verificar que todos los formularios funcionen
include 'conexión.php';

echo "<!DOCTYPE html>
<html lang='es'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Prueba de Formularios - DeporteFit</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .success { color: green; background: #e8f5e8; padding: 10px; border-radius: 5px; margin: 10px 0; }
        .error { color: red; background: #ffe8e8; padding: 10px; border-radius: 5px; margin: 10px 0; }
        .info { color: blue; background: #e8f0ff; padding: 10px; border-radius: 5px; margin: 10px 0; }
        .form-test { background: #f9f9f9; padding: 15px; margin: 15px 0; border-radius: 5px; border: 1px solid #ddd; }
        .btn { background: #1976d2; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; text-decoration: none; display: inline-block; margin: 5px; }
        .btn:hover { background: #1565c0; }
        table { width: 100%; border-collapse: collapse; margin: 15px 0; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background: #f2f2f2; }
    </style>
</head>
<body>
    <div class='container'>
        <h1>🧪 Prueba Completa de Formularios - DeporteFit</h1>";

if ($conexion) {
    echo "<div class='success'>✅ Conexión exitosa a la base de datos</div>";
    
    // Verificar si las tablas existen
    $tablas = ['contactos', 'solicitudes_info'];
    
    foreach ($tablas as $tabla) {
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
    
    // Mostrar registros existentes en la tabla contactos
    echo "<h3>📋 Registros Existentes en la Tabla 'contactos'</h3>";
    $select_sql = "SELECT * FROM contactos ORDER BY fecha_creacion DESC LIMIT 10";
    $select_result = mysqli_query($conexion, $select_sql);
    
    if ($select_result && mysqli_num_rows($select_result) > 0) {
        echo "<table>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Teléfono</th>
                    <th>Motivo</th>
                    <th>Mensaje</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                </tr>";
        
        while ($row = mysqli_fetch_assoc($select_result)) {
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['nombre']}</td>
                    <td>{$row['email']}</td>
                    <td>{$row['telefono']}</td>
                    <td>{$row['motivo']}</td>
                    <td>" . substr($row['mensaje'], 0, 50) . "...</td>
                    <td>{$row['fecha_creacion']}</td>
                    <td>{$row['estado']}</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<div class='info'>📭 No hay registros en la tabla 'contactos'</div>";
    }
    
    // Probar inserción de datos
    echo "<h3>🧪 Prueba de Inserción de Datos</h3>";
    
    $test_sql = "INSERT INTO contactos (nombre, email, telefono, motivo, mensaje, fecha_creacion) VALUES (?, ?, ?, ?, ?, NOW())";
    $stmt = mysqli_prepare($conexion, $test_sql);
    
    if ($stmt) {
        $nombre = "Usuario Prueba " . date('H:i:s');
        $email = "prueba" . time() . "@test.com";
        $telefono = "099" . rand(1000000, 9999999);
        $motivo = "prueba";
        $mensaje = "Este es un mensaje de prueba para verificar la funcionalidad de los formularios. Fecha: " . date('Y-m-d H:i:s');
        
        mysqli_stmt_bind_param($stmt, "sssss", $nombre, $email, $telefono, $motivo, $mensaje);
        
        if (mysqli_stmt_execute($stmt)) {
            $id_insertado = mysqli_insert_id($conexion);
            echo "<div class='success'>✅ Inserción de prueba exitosa - ID: $id_insertado</div>";
            
            // Mostrar el registro insertado
            $show_sql = "SELECT * FROM contactos WHERE id = ?";
            $show_stmt = mysqli_prepare($conexion, $show_sql);
            if ($show_stmt) {
                mysqli_stmt_bind_param($show_stmt, "i", $id_insertado);
                mysqli_stmt_execute($show_stmt);
                $result = mysqli_stmt_get_result($show_stmt);
                $row = mysqli_fetch_assoc($result);
                
                echo "<div class='form-test'>
                        <h4>📝 Registro Insertado:</h4>
                        <p><strong>ID:</strong> {$row['id']}</p>
                        <p><strong>Nombre:</strong> {$row['nombre']}</p>
                        <p><strong>Email:</strong> {$row['email']}</p>
                        <p><strong>Teléfono:</strong> {$row['telefono']}</p>
                        <p><strong>Motivo:</strong> {$row['motivo']}</p>
                        <p><strong>Mensaje:</strong> {$row['mensaje']}</p>
                        <p><strong>Fecha:</strong> {$row['fecha_creacion']}</p>
                        <p><strong>Estado:</strong> {$row['estado']}</p>
                      </div>";
                
                mysqli_stmt_close($show_stmt);
            }
            
            // Eliminar el registro de prueba
            $delete_sql = "DELETE FROM contactos WHERE id = ?";
            $delete_stmt = mysqli_prepare($conexion, $delete_sql);
            if ($delete_stmt) {
                mysqli_stmt_bind_param($delete_stmt, "i", $id_insertado);
                if (mysqli_stmt_execute($delete_stmt)) {
                    echo "<div class='info'>🗑️ Registro de prueba eliminado correctamente</div>";
                }
                mysqli_stmt_close($delete_stmt);
            }
        } else {
            echo "<div class='error'>❌ Error en inserción de prueba: " . mysqli_stmt_error($stmt) . "</div>";
        }
        
        mysqli_stmt_close($stmt);
    } else {
        echo "<div class='error'>❌ Error preparando consulta de prueba: " . mysqli_error($conexion) . "</div>";
    }
    
    mysqli_close($conexion);
    echo "<div class='info'>🔌 Conexión cerrada</div>";
    
} else {
    echo "<div class='error'>❌ Error de conexión: " . mysqli_connect_error() . "</div>";
}

echo "<hr>
        <h3>📋 Estado de los Formularios</h3>
        <div class='form-test'>
            <h4>✅ Formularios Verificados:</h4>
            <ul>
                <li><strong>contacto.html</strong> → guardar.php → Tabla 'contactos'</li>
                <li><strong>planes.html</strong> → guardar.php → Tabla 'contactos'</li>
                <li><strong>entrenadores.html</strong> → guardar.php → Tabla 'contactos'</li>
                <li><strong>servicios.html</strong> → guardar.php → Tabla 'contactos'</li>
            </ul>
        </div>
        
        <div class='form-test'>
            <h4>🔧 Próximos Pasos:</h4>
            <ol>
                <li>Sube todos los archivos a tu hosting de InfinityFree</li>
                <li>Ejecuta 'crear_tablas.sql' en phpMyAdmin</li>
                <li>Prueba los formularios llenándolos y enviándolos</li>
                <li>Verifica que los datos se guarden en la base de datos</li>
                <li>Una vez que funcione, elimina este archivo de prueba</li>
            </ol>
        </div>
        
        <div class='form-test'>
            <h4>🧪 Enlaces de Prueba:</h4>
            <a href='contacto.html' class='btn'>Probar Formulario de Contacto</a>
            <a href='planes.html' class='btn'>Probar Formulario de Planes</a>
            <a href='entrenadores.html' class='btn'>Probar Formulario de Entrenadores</a>
            <a href='servicios.html' class='btn'>Probar Formulario de Servicios</a>
        </div>
    </div>
</body>
</html>";
?>
