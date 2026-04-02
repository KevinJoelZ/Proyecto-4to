<?php
// Archivo para crear la tabla contactos si no existe
include 'conexion.php';

echo "<h1>Creación de Tabla Contactos</h1>";

// Verificar conexión
if ($conexion->connect_error) {
    echo "<p style='color: red;'>Error de conexión: " . $conexion->connect_error . "</p>";
    exit;
}
echo "<p style='color: green;'>✓ Conexión exitosa a la base de datos</p>";

// Verificar si la tabla contactos existe
$result = $conexion->query("SHOW TABLES LIKE 'contactos'");
if ($result->num_rows > 0) {
    echo "<p style='color: green;'>✓ La tabla 'contactos' ya existe</p>";
    
    // Mostrar estructura de la tabla
    echo "<h2>Estructura de la tabla contactos:</h2>";
    $result = $conexion->query("DESCRIBE contactos");
    echo "<table border='1' cellpadding='5'>";
    echo "<tr><th>Campo</th><th>Tipo</th><th>Nulo</th><th>Clave</th><th>Default</th></tr>";
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
    
    // Contar registros existentes
    $result = $conexion->query("SELECT COUNT(*) as total FROM contactos");
    $row = $result->fetch_assoc();
    echo "<p>Total de registros en la tabla: <strong>" . $row['total'] . "</strong></p>";
    
} else {
    echo "<p style='color: orange;'>La tabla 'contactos' NO existe. Creándola...</p>";
    
    $sql = "CREATE TABLE IF NOT EXISTS `contactos` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `nombre` varchar(100) NOT NULL,
        `email` varchar(100) NOT NULL,
        `telefono` varchar(20) DEFAULT NULL,
        `motivo` enum('informacion','soporte','entrenadores','otros') NOT NULL,
        `mensaje` text NOT NULL,
        `privacidad` tinyint(1) DEFAULT 0,
        `fecha_creacion` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `estado` enum('pendiente','respondido','archivado') DEFAULT 'pendiente',
        PRIMARY KEY (`id`),
        KEY `idx_email` (`email`),
        KEY `idx_motivo` (`motivo`),
        KEY `idx_fecha` (`fecha_creacion`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    if ($conexion->query($sql)) {
        echo "<p style='color: green;'>✓ Tabla 'contactos' creada exitosamente</p>";
        
        // Mostrar estructura de la tabla
        echo "<h2>Estructura de la tabla contactos:</h2>";
        $result = $conexion->query("DESCRIBE contactos");
        echo "<table border='1' cellpadding='5'>";
        echo "<tr><th>Campo</th><th>Tipo</th><th>Nulo</th><th>Clave</th><th>Default</th></tr>";
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
        echo "<p style='color: red;'>✗ Error al crear la tabla: " . $conexion->error . "</p>";
    }
}

// Probar inserción de datos
echo "<h2>Prueba de inserción de datos:</h2>";

$nombre = "Usuario de Prueba";
$email = "prueba@test.com";
$telefono = "0991234567";
$motivo = "informacion";
$mensaje = "Este es un mensaje de prueba para verificar el funcionamiento del formulario.";
$privacidad = 1;

$sql = "INSERT INTO contactos (nombre, email, telefono, motivo, mensaje, privacidad, fecha_creacion) VALUES (?, ?, ?, ?, ?, ?, NOW())";
$stmt = mysqli_prepare($conexion, $sql);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "sssssi", $nombre, $email, $telefono, $motivo, $mensaje, $privacidad);
    
    if (mysqli_stmt_execute($stmt)) {
        if (mysqli_stmt_affected_rows($stmt) > 0) {
            $id = mysqli_insert_id($conexion);
            echo "<p style='color: green;'>✓ Inserción exitosa. ID del registro: <strong>$id</strong></p>";
            
            // Verificar que se guardó correctamente
            $result = $conexion->query("SELECT * FROM contactos WHERE id = $id");
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                echo "<h3>Datos guardados:</h3>";
                echo "<ul>";
                echo "<li><strong>ID:</strong> " . $row['id'] . "</li>";
                echo "<li><strong>Nombre:</strong> " . $row['nombre'] . "</li>";
                echo "<li><strong>Email:</strong> " . $row['email'] . "</li>";
                echo "<li><strong>Teléfono:</strong> " . $row['telefono'] . "</li>";
                echo "<li><strong>Motivo:</strong> " . $row['motivo'] . "</li>";
                echo "<li><strong>Mensaje:</strong> " . $row['mensaje'] . "</li>";
                echo "<li><strong>Privacidad:</strong> " . $row['privacidad'] . "</li>";
                echo "<li><strong>Fecha:</strong> " . $row['fecha_creacion'] . "</li>";
                echo "<li><strong>Estado:</strong> " . $row['estado'] . "</li>";
                echo "</ul>";
            }
        } else {
            echo "<p style='color: red;'>✗ No se insertó ningún registro</p>";
        }
    } else {
        echo "<p style='color: red;'>✗ Error al ejecutar la consulta: " . mysqli_stmt_error($stmt) . "</p>";
    }
    
    mysqli_stmt_close($stmt);
} else {
    echo "<p style='color: red;'>✗ Error al preparar la consulta: " . $conexion->error . "</p>";
}

// Mostrar todos los registros
echo "<h2>Todos los registros en la tabla contactos:</h2>";
$result = $conexion->query("SELECT * FROM contactos ORDER BY fecha_creacion DESC LIMIT 10");
if ($result->num_rows > 0) {
    echo "<table border='1' cellpadding='5'>";
    echo "<tr><th>ID</th><th>Nombre</th><th>Email</th><th>Teléfono</th><th>Motivo</th><th>Mensaje</th><th>Fecha</th><th>Estado</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['nombre'] . "</td>";
        echo "<td>" . $row['email'] . "</td>";
        echo "<td>" . $row['telefono'] . "</td>";
        echo "<td>" . $row['motivo'] . "</td>";
        echo "<td>" . substr($row['mensaje'], 0, 50) . "...</td>";
        echo "<td>" . $row['fecha_creacion'] . "</td>";
        echo "<td>" . $row['estado'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p>No hay registros en la tabla.</p>";
}

echo "<h2>Resumen:</h2>";
echo "<p>✓ La tabla 'contactos' está lista para recibir datos del formulario de contacto.</p>";
echo "<p>✓ El formulario en <a href='contacto.php'>contacto.php</a> debería funcionar correctamente.</p>";
echo "<p>✓ Los datos se guardarán en la tabla 'contactos' de la base de datos 'plataforma_fitness'.</p>";

mysqli_close($conexion);
?>
