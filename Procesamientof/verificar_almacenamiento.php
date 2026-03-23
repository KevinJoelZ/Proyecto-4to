<?php
// Archivo para verificar que los datos se estén guardando en la base de datos
include '../PHP/conexión.php';

echo "<!DOCTYPE html>
<html lang='es'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Verificación de Almacenamiento - DeporteFit</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }
        .container { max-width: 1200px; margin: 0 auto; background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .success { color: green; background: #e8f5e8; padding: 10px; border-radius: 5px; margin: 10px 0; }
        .error { color: red; background: #ffe8e8; padding: 10px; border-radius: 5px; margin: 10px 0; }
        .info { color: blue; background: #e8f0ff; padding: 10px; border-radius: 5px; margin: 10px 0; }
        .table-container { margin: 20px 0; overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; margin: 10px 0; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; }
        .btn { background: #007bff; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; margin: 5px; }
        .btn:hover { background: #0056b3; }
        .form-test { background: #f9f9f9; padding: 20px; border-radius: 10px; margin: 20px 0; }
        .form-test input, .form-test textarea, .form-test select { width: 100%; padding: 8px; margin: 5px 0; border: 1px solid #ddd; border-radius: 4px; }
        .form-test button { background: #28a745; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; }
        .form-test button:hover { background: #218838; }
    </style>
</head>
<body>
    <div class='container'>
        <h1>🔍 Verificación de Almacenamiento en Base de Datos</h1>
        <p>Este archivo verifica que los datos se estén guardando correctamente en tu base de datos de InfinityFree.</p>";

// Verificar conexión
if (!$conexion) {
    echo "<div class='error'>❌ Error de conexión: " . mysqli_connect_error() . "</div>";
    exit;
}

echo "<div class='success'>✅ Conexión exitosa a la base de datos de InfinityFree</div>";

// Verificar tablas existentes
$tablas_esperadas = [
    'contactos',
    'solicitudes_entrenadores', 
    'solicitudes_planes',
    'solicitudes_servicios',
    'solicitudes_info'
];

echo "<h2>📊 Verificación de Tablas</h2>";

foreach ($tablas_esperadas as $tabla) {
    $sql = "SHOW TABLES LIKE '$tabla'";
    $resultado = mysqli_query($conexion, $sql);
    
    if (mysqli_num_rows($resultado) > 0) {
        echo "<div class='success'>✅ Tabla '$tabla' existe</div>";
        
        // Contar registros
        $count_sql = "SELECT COUNT(*) as total FROM $tabla";
        $count_result = mysqli_query($conexion, $count_sql);
        if ($count_result) {
            $row = mysqli_fetch_assoc($count_result);
            echo "<div class='info'>📈 Registros en '$tabla': " . $row['total'] . "</div>";
        }
    } else {
        echo "<div class='error'>❌ Tabla '$tabla' NO existe</div>";
    }
}

// Mostrar datos de cada tabla
echo "<h2>📋 Datos Almacenados en las Tablas</h2>";

foreach ($tablas_esperadas as $tabla) {
    $sql = "SHOW TABLES LIKE '$tabla'";
    $resultado = mysqli_query($conexion, $sql);
    
    if (mysqli_num_rows($resultado) > 0) {
        echo "<h3>📊 Tabla: $tabla</h3>";
        
        $data_sql = "SELECT * FROM $tabla ORDER BY id DESC LIMIT 10";
        $data_result = mysqli_query($conexion, $data_sql);
        
        if ($data_result && mysqli_num_rows($data_result) > 0) {
            echo "<div class='table-container'>";
            echo "<table>";
            
            // Obtener nombres de columnas
            $columnas = [];
            while ($field = mysqli_fetch_field($data_result)) {
                $columnas[] = $field->name;
            }
            
            // Imprimir encabezados
            echo "<tr>";
            foreach ($columnas as $columna) {
                echo "<th>$columna</th>";
            }
            echo "</tr>";
            
            // Imprimir datos
            mysqli_data_seek($data_result, 0);
            while ($row = mysqli_fetch_assoc($data_result)) {
                echo "<tr>";
                foreach ($columnas as $columna) {
                    $valor = $row[$columna];
                    if ($columna == 'fecha_creacion' || $columna == 'fecha_solicitud') {
                        $valor = date('d/m/Y H:i', strtotime($valor));
                    }
                    echo "<td>" . htmlspecialchars($valor) . "</td>";
                }
                echo "</tr>";
            }
            
            echo "</table>";
            echo "</div>";
        } else {
            echo "<div class='info'>ℹ️ No hay datos en la tabla '$tabla'</div>";
        }
    }
}

// Formulario de prueba para insertar datos
echo "<h2>🧪 Insertar Datos de Prueba</h2>";
echo "<div class='form-test'>";
echo "<form method='POST' action=''>";
echo "<h3>Formulario de Prueba - Contacto</h3>";
echo "<input type='text' name='nombre_prueba' placeholder='Nombre' required><br>";
echo "<input type='email' name='email_prueba' placeholder='Email' required><br>";
echo "<input type='tel' name='telefono_prueba' placeholder='Teléfono'><br>";
echo "<select name='motivo_prueba' required>";
echo "<option value=''>Selecciona motivo</option>";
echo "<option value='informacion'>Información</option>";
echo "<option value='soporte'>Soporte</option>";
echo "<option value='entrenadores'>Entrenadores</option>";
echo "<option value='otros'>Otros</option>";
echo "</select><br>";
echo "<textarea name='mensaje_prueba' placeholder='Mensaje' required></textarea><br>";
echo "<button type='submit' name='insertar_prueba'>Insertar Datos de Prueba</button>";
echo "</form>";
echo "</div>";

// Procesar inserción de prueba
if (isset($_POST['insertar_prueba'])) {
    $nombre = $_POST['nombre_prueba'];
    $email = $_POST['email_prueba'];
    $telefono = $_POST['telefono_prueba'];
    $motivo = $_POST['motivo_prueba'];
    $mensaje = $_POST['mensaje_prueba'];
    
    $sql = "INSERT INTO contactos (nombre, email, telefono, motivo, mensaje, fecha_creacion) VALUES (?, ?, ?, ?, ?, NOW())";
    $stmt = mysqli_prepare($conexion, $sql);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "sssss", $nombre, $email, $telefono, $motivo, $mensaje);
        
        if (mysqli_stmt_execute($stmt)) {
            $id_insertado = mysqli_insert_id($conexion);
            echo "<div class='success'>✅ Datos de prueba insertados correctamente en la tabla 'contactos' con ID: $id_insertado</div>";
            echo "<script>location.reload();</script>";
        } else {
            echo "<div class='error'>❌ Error al insertar datos: " . mysqli_stmt_error($stmt) . "</div>";
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "<div class='error'>❌ Error preparando consulta: " . mysqli_error($conexion) . "</div>";
    }
}

// Botones de acción
echo "<h2>🔧 Acciones Disponibles</h2>";
echo "<a href='test_conexion.php' class='btn'>🧪 Probar Conexión</a>";
echo "<a href='probar_formularios.php' class='btn'>📝 Probar Formularios</a>";
echo "<a href='probar_tablas_formularios.php' class='btn'>📊 Probar Tablas</a>";
echo "<a href='index.html' class='btn'>🏠 Ir a Página Principal</a>";

echo "<h2>📝 Instrucciones para Verificar</h2>";
echo "<div class='info'>";
echo "<ol>";
echo "<li><strong>Verifica que las tablas existan</strong> - Deben aparecer todas con ✅</li>";
echo "<li><strong>Revisa los datos existentes</strong> - Las tablas deben mostrar registros</li>";
echo "<li><strong>Inserta datos de prueba</strong> - Usa el formulario de arriba</li>";
echo "<li><strong>Verifica que se guarden</strong> - Los datos deben aparecer en la tabla</li>";
echo "<li><strong>Prueba los formularios reales</strong> - Ve a las páginas HTML</li>";
echo "</ol>";
echo "</div>";

echo "<h2>⚠️ Si Algo No Funciona</h2>";
echo "<div class='error'>";
echo "<ul>";
echo "<li>Verifica que hayas ejecutado el script SQL en tu base de datos de InfinityFree</li>";
echo "<li>Confirma que las credenciales en 'conexión.php' sean correctas</li>";
echo "<li>Asegúrate de que tu hosting tenga PHP habilitado</li>";
echo "<li>Verifica que las tablas tengan la estructura correcta</li>";
echo "</ul>";
echo "</div>";

mysqli_close($conexion);

echo "</div></body></html>";
?>
