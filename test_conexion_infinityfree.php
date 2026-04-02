<?php
// ============================================
// TEST DE CONEXIÓN PARA INFINITYFREE
// ============================================
// Sube este archivo a InfinityFree y accede a:
// https://tudominio.rf.gd/test_conexion_infinityfree.php

echo "<h1>🔍 Test de Conexión - InfinityFree</h1>";
echo "<style>
    body { font-family: Arial, sans-serif; margin: 20px; }
    .success { color: green; font-weight: bold; }
    .error { color: red; font-weight: bold; }
    .warning { color: orange; font-weight: bold; }
    .info { color: blue; }
    table { border-collapse: collapse; width: 100%; margin: 20px 0; }
    th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
    th { background-color: #4CAF50; color: white; }
    tr:nth-child(even) { background-color: #f2f2f2; }
</style>";

// ============================================
// 1. VERIFICAR CONFIGURACIÓN DE PHP
// ============================================
echo "<h2>1. Configuración de PHP</h2>";
echo "<table>";
echo "<tr><th>Parámetro</th><th>Valor</th><th>Estado</th></tr>";

$php_version = phpversion();
echo "<tr><td>Versión de PHP</td><td>$php_version</td>";
echo ($php_version >= '7.4') ? "<td class='success'>✅ OK</td></tr>" : "<td class='warning'>⚠️ Recomendado 7.4+</td></tr>";

$extensions = ['mysqli', 'curl', 'json', 'session'];
foreach ($extensions as $ext) {
    $loaded = extension_loaded($ext);
    echo "<tr><td>Extensión $ext</td><td>" . ($loaded ? 'Cargada' : 'No cargada') . "</td>";
    echo $loaded ? "<td class='success'>✅ OK</td></tr>" : "<td class='error'>❌ Faltante</td></tr>";
}

echo "</table>";

// ============================================
// 2. VERIFICAR CONEXIÓN A BASE DE DATOS
// ============================================
echo "<h2>2. Conexión a Base de Datos MySQL</h2>";

// Intentar incluir el archivo de conexión
if (file_exists('conexión.php')) {
    include 'conexión.php';
    
    if (isset($conexion) && $conexion instanceof mysqli) {
        if ($conexion->connect_error) {
            echo "<p class='error'>❌ Error de conexión: " . $conexion->connect_error . "</p>";
            echo "<p class='info'>💡 Verifica los datos en <code>conexión.php</code>:</p>";
            echo "<ul>";
            echo "<li>MySQL Host (ej: sqlXXX.epizy.com)</li>";
            echo "<li>MySQL Username (ej: epiz_XXXXX)</li>";
            echo "<li>MySQL Password</li>";
            echo "<li>MySQL Database Name (ej: epiz_XXXXX_plataforma_fitness)</li>";
            echo "</ul>";
        } else {
            echo "<p class='success'>✅ Conexión exitosa a MySQL</p>";
            
            // Verificar tablas
            $result = $conexion->query("SHOW TABLES");
            if ($result) {
                $num_tables = $result->num_rows;
                echo "<p class='info'>📊 Tablas encontradas: $num_tables</p>";
                
                if ($num_tables > 0) {
                    echo "<ul>";
                    while ($row = $result->fetch_array()) {
                        echo "<li>" . $row[0] . "</li>";
                    }
                    echo "</ul>";
                } else {
                    echo "<p class='warning'>⚠️ No hay tablas. Importa tu base de datos SQL desde phpMyAdmin</p>";
                }
            }
            
            // Verificar tabla usuarios
            $result = $conexion->query("SELECT COUNT(*) as total FROM usuarios");
            if ($result) {
                $row = $result->fetch_assoc();
                echo "<p class='info'>👥 Usuarios registrados: " . $row['total'] . "</p>";
            }
            
            $conexion->close();
        }
    } else {
        echo "<p class='error'>❌ No se pudo crear la conexión</p>";
    }
} else {
    echo "<p class='error'>❌ Archivo <code>conexión.php</code> no encontrado</p>";
    echo "<p class='info'>💡 Asegúrate de subir el archivo <code>conexión.php</code> con los datos de InfinityFree</p>";
}

// ============================================
// 3. VERIFICAR CONFIGURACIÓN DE FIREBASE
// ============================================
echo "<h2>3. Configuración de Firebase</h2>";

$firebase_config = [
    'apiKey' => 'AIzaSyBZoUGrSk3V-yFW6QHxXLeXQfPMgnYUeQo',
    'authDomain' => 'proyectoweb-fc2d2.firebaseapp.com',
    'projectId' => 'proyectoweb-fc2d2',
    'storageBucket' => 'proyectoweb-fc2d2.firebasestorage.app',
    'messagingSenderId' => '508269230145'
];

echo "<table>";
echo "<tr><th>Parámetro</th><th>Valor</th><th>Estado</th></tr>";

foreach ($firebase_config as $key => $value) {
    echo "<tr><td>$key</td><td>$value</td>";
    echo !empty($value) ? "<td class='success'>✅ OK</td></tr>" : "<td class='error'>❌ Vacío</td></tr>";
}

echo "</table>";

// Verificar project_id en auth.php
if (file_exists('auth.php')) {
    $auth_content = file_get_contents('auth.php');
    if (strpos($auth_content, 'proyectoweb-fc2d2') !== false) {
        echo "<p class='success'>✅ Project ID configurado correctamente en auth.php</p>";
    } else {
        echo "<p class='error'>❌ Project ID no encontrado en auth.php</p>";
    }
}

// ============================================
// 4. VERIFICAR DOMINIO ACTUAL
// ============================================
echo "<h>4. Información del Dominio</h2>";

$current_domain = $_SERVER['HTTP_HOST'] ?? 'localhost';
$current_protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
$current_url = $current_protocol . '://' . $current_domain;

echo "<table>";
echo "<tr><th>Parámetro</th><th>Valor</th></tr>";
echo "<tr><td>Dominio actual</td><td>$current_domain</td></tr>";
echo "<tr><td>Protocolo</td><td>$current_protocol</td></tr>";
echo "<tr><td>URL completa</td><td>$current_url</td></tr>";
echo "</table>";

echo "<p class='info'>💡 Asegúrate de agregar <strong>$current_domain</strong> a los dominios autorizados en Firebase Console:</p>";
echo "<ol>";
echo "<li>Ve a <a href='https://console.firebase.google.com' target='_blank'>Firebase Console</a></li>";
echo "<li>Selecciona tu proyecto: <strong>proyectoweb-fc2d2</strong></li>";
echo "<li>Ve a <strong>Authentication</strong> → <strong>Settings</strong> → <strong>Authorized domains</strong></li>";
echo "<li>Haz clic en <strong>Add domain</strong></li>";
echo "<li>Agrega: <strong>$current_domain</strong></li>";
echo "</ol>";

// ============================================
// 5. VERIFICAR ARCHIVOS NECESARIOS
// ============================================
echo "<h2>5. Archivos Necesarios</h2>";

$required_files = [
    'index.php' => 'Página principal con login Firebase',
    'cliente.php' => 'Panel de cliente con login Firebase',
    'auth.php' => 'Verificación de tokens Firebase',
    'conexión.php' => 'Conexión a base de datos',
    'admin.php' => 'Panel de administración'
];

echo "<table>";
echo "<tr><th>Archivo</th><th>Descripción</th><th>Estado</th></tr>";

foreach ($required_files as $file => $description) {
    $exists = file_exists($file);
    echo "<tr><td><code>$file</code></td><td>$description</td>";
    echo $exists ? "<td class='success'>✅ Existe</td></tr>" : "<td class='error'>❌ No encontrado</td></tr>";
}

echo "</table>";

// ============================================
// 6. RESUMEN Y RECOMENDACIONES
// ============================================
echo "<h2>6. Resumen</h2>";

$checks = [
    'PHP 7.4+' => version_compare(phpversion(), '7.4', '>='),
    'Extensión mysqli' => extension_loaded('mysqli'),
    'Extensión curl' => extension_loaded('curl'),
    'Archivo conexión.php' => file_exists('conexión.php'),
    'Archivo auth.php' => file_exists('auth.php'),
    'Archivo index.php' => file_exists('index.php'),
];

$passed = 0;
$total = count($checks);

foreach ($checks as $check => $result) {
    if ($result) $passed++;
}

echo "<p><strong>Verificaciones pasadas: $passed / $total</strong></p>";

if ($passed === $total) {
    echo "<p class='success'>🎉 ¡Todo está configurado correctamente!</p>";
    echo "<p class='info'>Prueba tu sitio en: <a href='$current_url/index.php'>$current_url/index.php</a></p>";
} else {
    echo "<p class='warning'>⚠️ Algunas verificaciones fallaron. Revisa los errores arriba.</p>";
}

echo "<hr>";
echo "<p class='info'><strong>Próximos pasos:</strong></p>";
echo "<ol>";
echo "<li>Si la conexión a MySQL falla, actualiza <code>conexión.php</code> con los datos de InfinityFree</li>";
echo "<li>Si no hay tablas, importa tu base de datos SQL desde phpMyAdmin</li>";
echo "<li>Agrega tu dominio a Firebase Console → Authentication → Settings → Authorized domains</li>";
echo "<li>Prueba el login con Google en <a href='$current_url/index.php'>$current_url/index.php</a></li>";
echo "</ol>";

echo "<hr>";
echo "<p><small>Test generado automáticamente - " . date('Y-m-d H:i:s') . "</small></p>";
?>
