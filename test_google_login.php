<?php
// Script de prueba para verificar la funcionalidad del login con Google
session_start();
include_once 'conexión.php';

echo "<h2>Test de Funcionalidad - Login con Google</h2>";

// Verificar conexión a la base de datos
echo "<h3>1. Conexión a Base de Datos:</h3>";
if ($conexion) {
    echo "✅ Conexión exitosa a la base de datos 'guardarbd'<br>";
    
    // Verificar si existe la tabla usuarios
    $result = $conexion->query("SHOW TABLES LIKE 'usuarios'");
    if ($result->num_rows > 0) {
        echo "✅ Tabla 'usuarios' existe<br>";
        
        // Mostrar estructura de la tabla
        $structure = $conexion->query("DESCRIBE usuarios");
        echo "<h4>Estructura de la tabla usuarios:</h4>";
        echo "<table border='1' style='border-collapse: collapse;'>";
        echo "<tr><th>Campo</th><th>Tipo</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
        while ($row = $structure->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['Field'] . "</td>";
            echo "<td>" . $row['Type'] . "</td>";
            echo "<td>" . $row['Null'] . "</td>";
            echo "<td>" . $row['Key'] . "</td>";
            echo "<td>" . $row['Default'] . "</td>";
            echo "<td>" . $row['Extra'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        
        // Contar usuarios existentes
        $count = $conexion->query("SELECT COUNT(*) as total FROM usuarios");
        $total = $count->fetch_assoc()['total'];
        echo "<p>Total de usuarios registrados: <strong>$total</strong></p>";
        
        // Mostrar algunos usuarios de ejemplo (sin datos sensibles)
        if ($total > 0) {
            $users = $conexion->query("SELECT id, nombre, email, rol, fecha_registro FROM usuarios LIMIT 5");
            echo "<h4>Usuarios registrados (últimos 5):</h4>";
            echo "<table border='1' style='border-collapse: collapse;'>";
            echo "<tr><th>ID</th><th>Nombre</th><th>Email</th><th>Rol</th><th>Fecha Registro</th></tr>";
            while ($user = $users->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $user['id'] . "</td>";
                echo "<td>" . htmlspecialchars($user['nombre']) . "</td>";
                echo "<td>" . htmlspecialchars($user['email']) . "</td>";
                echo "<td>" . htmlspecialchars($user['rol']) . "</td>";
                echo "<td>" . $user['fecha_registro'] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
        
    } else {
        echo "❌ La tabla 'usuarios' no existe. Necesitas crearla.<br>";
        echo "<h4>SQL para crear la tabla:</h4>";
        echo "<pre>
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    uid VARCHAR(255) UNIQUE,
    nombre VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    foto_perfil TEXT,
    email_verificado TINYINT(1) DEFAULT 0,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    ultima_conexion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    estado ENUM('activo', 'inactivo') DEFAULT 'activo',
    rol ENUM('admin', 'cliente') DEFAULT 'cliente'
);
        </pre>";
    }
} else {
    echo "❌ Error de conexión a la base de datos<br>";
}

// Verificar archivos necesarios
echo "<h3>2. Archivos del Sistema:</h3>";
$files = [
    'index.php' => 'Página principal con botón de Google',
    'cliente.php' => 'Panel de cliente',
    'admin.php' => 'Panel de administrador',
    'login/guardar_usuario.php' => 'Script para guardar usuario',
    'login/obtener_rol.php' => 'Script para obtener rol',
    'auth.php' => 'Script de autenticación alternativo'
];

foreach ($files as $file => $description) {
    if (file_exists($file)) {
        echo "✅ $file - $description<br>";
    } else {
        echo "❌ $file - $description (FALTANTE)<br>";
    }
}

// Verificar configuración de Firebase
echo "<h3>3. Configuración de Firebase:</h3>";
$firebase_config = [
    'apiKey' => 'AIzaSyBZoUGrSk3V-yFW6QHxXLeXQfPMgnYUeQo',
    'authDomain' => 'proyectoweb-fc2d2.firebaseapp.com',
    'projectId' => 'proyectoweb-fc2d2'
];

foreach ($firebase_config as $key => $value) {
    echo "✅ $key: $value<br>";
}

// Verificar sesión actual
echo "<h3>4. Estado de Sesión Actual:</h3>";
if (isset($_SESSION['user_id'])) {
    echo "✅ Usuario logueado:<br>";
    echo "- ID: " . $_SESSION['user_id'] . "<br>";
    echo "- Nombre: " . htmlspecialchars($_SESSION['user_nombre'] ?? 'No definido') . "<br>";
    echo "- Email: " . htmlspecialchars($_SESSION['user_email'] ?? 'No definido') . "<br>";
    echo "- Rol: " . htmlspecialchars($_SESSION['user_rol'] ?? 'No definido') . "<br>";
} else {
    echo "ℹ️ No hay usuario logueado actualmente<br>";
}

echo "<h3>5. Instrucciones:</h3>";
echo "<ol>";
echo "<li>Asegúrate de que XAMPP esté ejecutándose (Apache y MySQL)</li>";
echo "<li>Verifica que la base de datos 'guardarbd' exista</li>";
echo "<li>Si la tabla 'usuarios' no existe, créala usando el SQL mostrado arriba</li>";
echo "<li>Ve a <a href='index.php'>index.php</a> para probar el login con Google</li>";
echo "<li>Después del login exitoso, deberías ser redirigido a <a href='cliente.php'>cliente.php</a></li>";
echo "</ol>";

echo "<hr>";
echo "<p><a href='index.php'>← Volver al Login</a> | <a href='cliente.php'>Panel Cliente</a> | <a href='admin.php'>Panel Admin</a></p>";
?>
