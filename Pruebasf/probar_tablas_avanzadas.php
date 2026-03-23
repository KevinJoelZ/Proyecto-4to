<?php
// Archivo de prueba para verificar las tablas avanzadas de entrenadores y planes
include 'conexión.php';

echo "<!DOCTYPE html>
<html lang='es'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Prueba de Tablas Avanzadas - DeporteFit</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }
        .container { max-width: 1000px; margin: 0 auto; background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
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
    </style>
</head>
<body>
    <div class='container'>
        <h1>🧪 Prueba de Tablas Avanzadas - DeporteFit</h1>";

if ($conexion) {
    echo "<div class='success'>✅ Conexión exitosa a la base de datos</div>";
    
    // Verificar si las tablas avanzadas existen
    $tablas_avanzadas = ['entrenadores', 'planes', 'solicitudes_entrenadores', 'solicitudes_planes'];
    
    foreach ($tablas_avanzadas as $tabla) {
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
    
    // Mostrar entrenadores existentes
    echo "<div class='section'>
            <h3>👥 Entrenadores Registrados</h3>";
    
    $entrenadores_sql = "SELECT * FROM entrenadores ORDER BY nombre, apellido";
    $entrenadores_result = mysqli_query($conexion, $entrenadores_sql);
    
    if ($entrenadores_result && mysqli_num_rows($entrenadores_result) > 0) {
        echo "<table>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Especialidad</th>
                    <th>Certificaciones</th>
                    <th>Experiencia</th>
                    <th>Estado</th>
                </tr>";
        
        while ($row = mysqli_fetch_assoc($entrenadores_result)) {
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td><strong>{$row['nombre']} {$row['apellido']}</strong></td>
                    <td>{$row['especialidad']}</td>
                    <td>" . substr($row['certificaciones'], 0, 50) . "...</td>
                    <td>{$row['experiencia_anos']} años</td>
                    <td>{$row['estado']}</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<div class='info'>📭 No hay entrenadores registrados</div>";
    }
    echo "</div>";
    
    // Mostrar planes existentes
    echo "<div class='section'>
            <h3>💎 Planes Disponibles</h3>";
    
    $planes_sql = "SELECT * FROM planes ORDER BY precio_mensual";
    $planes_result = mysqli_query($conexion, $planes_sql);
    
    if ($planes_result && mysqli_num_rows($planes_result) > 0) {
        echo "<table>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Nivel</th>
                    <th>Características</th>
                    <th>Estado</th>
                </tr>";
        
        while ($row = mysqli_fetch_assoc($planes_result)) {
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td><strong>{$row['nombre']}</strong></td>
                    <td>\${$row['precio_mensual']}/mes</td>
                    <td>{$row['nivel']}</td>
                    <td>" . substr($row['caracteristicas'], 0, 60) . "...</td>
                    <td>{$row['estado']}</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<div class='info'>📭 No hay planes registrados</div>";
    }
    echo "</div>";
    
    // Probar inserción de solicitud de entrenador
    echo "<div class='section'>
            <h3>🧪 Prueba de Solicitud de Entrenador</h3>";
    
    $test_entrenador_sql = "INSERT INTO solicitudes_entrenadores (nombre, email, telefono, entrenador_id, entrenador_nombre, especialidad_interes, mensaje, fecha_solicitud) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())";
    $stmt = mysqli_prepare($conexion, $test_entrenador_sql);
    
    if ($stmt) {
        $nombre = "Usuario Prueba Entrenador " . date('H:i:s');
        $email = "prueba.entrenador" . time() . "@test.com";
        $telefono = "099" . rand(1000000, 9999999);
        $entrenador_id = 1;
        $entrenador_nombre = "Carlos Rodríguez";
        $especialidad_interes = "Fitness y Musculación";
        $mensaje = "Me gustaría entrenar con este entrenador. Fecha de prueba: " . date('Y-m-d H:i:s');
        
        mysqli_stmt_bind_param($stmt, "sssisss", $nombre, $email, $telefono, $entrenador_id, $entrenador_nombre, $especialidad_interes, $mensaje);
        
        if (mysqli_stmt_execute($stmt)) {
            $id_insertado = mysqli_insert_id($conexion);
            echo "<div class='success'>✅ Solicitud de entrenador insertada - ID: $id_insertado</div>";
            
            // Eliminar el registro de prueba
            $delete_sql = "DELETE FROM solicitudes_entrenadores WHERE id = ?";
            $delete_stmt = mysqli_prepare($conexion, $delete_sql);
            if ($delete_stmt) {
                mysqli_stmt_bind_param($delete_stmt, "i", $id_insertado);
                if (mysqli_stmt_execute($delete_stmt)) {
                    echo "<div class='info'>🗑️ Solicitud de prueba eliminada</div>";
                }
                mysqli_stmt_close($delete_stmt);
            }
        } else {
            echo "<div class='error'>❌ Error en inserción de solicitud de entrenador: " . mysqli_stmt_error($stmt) . "</div>";
        }
        
        mysqli_stmt_close($stmt);
    }
    echo "</div>";
    
    // Probar inserción de solicitud de plan
    echo "<div class='section'>
            <h3>🧪 Prueba de Solicitud de Plan</h3>";
    
    $test_plan_sql = "INSERT INTO solicitudes_planes (nombre, email, telefono, plan_id, plan_nombre, mensaje, fecha_solicitud) VALUES (?, ?, ?, ?, ?, ?, NOW())";
    $stmt = mysqli_prepare($conexion, $test_plan_sql);
    
    if ($stmt) {
        $nombre = "Usuario Prueba Plan " . date('H:i:s');
        $email = "prueba.plan" . time() . "@test.com";
        $telefono = "098" . rand(1000000, 9999999);
        $plan_id = 1;
        $plan_nombre = "Plan Básico";
        $mensaje = "Me interesa este plan. Fecha de prueba: " . date('Y-m-d H:i:s');
        
        mysqli_stmt_bind_param($stmt, "sssisss", $nombre, $email, $telefono, $plan_id, $plan_nombre, $mensaje);
        
        if (mysqli_stmt_execute($stmt)) {
            $id_insertado = mysqli_insert_id($conexion);
            echo "<div class='success'>✅ Solicitud de plan insertada - ID: $id_insertado</div>";
            
            // Eliminar el registro de prueba
            $delete_sql = "DELETE FROM solicitudes_planes WHERE id = ?";
            $delete_stmt = mysqli_prepare($conexion, $delete_sql);
            if ($delete_stmt) {
                mysqli_stmt_bind_param($delete_stmt, "i", $id_insertado);
                if (mysqli_stmt_execute($delete_stmt)) {
                    echo "<div class='info'>🗑️ Solicitud de prueba eliminada</div>";
                }
                mysqli_stmt_close($delete_stmt);
            }
        } else {
            echo "<div class='error'>❌ Error en inserción de solicitud de plan: " . mysqli_stmt_error($stmt) . "</div>";
        }
        
        mysqli_stmt_close($stmt);
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
                    <li><strong>contactos</strong> - Mensajes generales de contacto</li>
                    <li><strong>solicitudes_info</strong> - Solicitudes de información general</li>
                </ul>
            </div>
            
            <div class='card'>
                <h4>✅ Tablas Avanzadas:</h4>
                <ul>
                    <li><strong>entrenadores</strong> - Información de entrenadores certificados</li>
                    <li><strong>planes</strong> - Planes de entrenamiento disponibles</li>
                    <li><strong>solicitudes_entrenadores</strong> - Solicitudes específicas de entrenadores</li>
                    <li><strong>solicitudes_planes</strong> - Solicitudes específicas de planes</li>
                </ul>
            </div>
        </div>
        
        <div class='section'>
            <h4>🔧 Próximos Pasos:</h4>
            <ol>
                <li>Ejecuta 'crear_tablas.sql' en phpMyAdmin para crear todas las tablas</li>
                <li>Usa 'procesar_solicitudes.php' para manejar solicitudes específicas</li>
                <li>Prueba los formularios con las nuevas funcionalidades</li>
                <li>Una vez que funcione, elimina los archivos de prueba</li>
            </ol>
        </div>
        
        <div class='section'>
            <h4>🧪 Enlaces de Prueba:</h4>
            <a href='probar_formularios.php' class='btn'>Probar Formularios Básicos</a>
            <a href='contacto.html' class='btn'>Formulario de Contacto</a>
            <a href='entrenadores.html' class='btn'>Formulario de Entrenadores</a>
            <a href='planes.html' class='btn'>Formulario de Planes</a>
        </div>
    </div>
</body>
</html>";
?>
