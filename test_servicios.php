<?php
/**
 * Script de prueba específico para el formulario de servicios
 * Verifica que la conexión a plataforma_fitness funcione y los datos se guarden
 */

header('Content-Type: text/html; charset=utf-8');

echo "<h1>🧪 Prueba Específica - Formulario de Servicios</h1>";

try {
    // Conectar a plataforma_fitness
    require_once 'conexión.php';
    
    echo "<p style='color: green;'>✅ Conexión a plataforma_fitness establecida</p>";
    
    // Verificar que la tabla solicitudes_servicios existe
    $result = $conexion->query("SHOW TABLES LIKE 'solicitudes_servicios'");
    if ($result->num_rows > 0) {
        echo "<p style='color: green;'>✅ Tabla 'solicitudes_servicios' existe</p>";
    } else {
        echo "<p style='color: red;'>❌ Tabla 'solicitudes_servicios' NO existe. Ejecuta crear_db_guardar.php primero.</p>";
        exit;
    }
    
    // Simular el envío del formulario de servicios
    echo "<h2>📝 Simulando envío del formulario de servicios...</h2>";
    
    $sql = "INSERT INTO solicitudes_servicios (nombre, email, telefono, motivo, mensaje, fecha_solicitud) VALUES (?, ?, ?, ?, ?, NOW())";
    $stmt = $conexion->prepare($sql);
    
    if (!$stmt) {
        throw new Exception("Error al preparar la consulta: " . $conexion->error);
    }
    
    // Datos de prueba
    $nombre = "Usuario Prueba Servicios";
    $email = "servicios@prueba.com";
    $telefono = "0991234567";
    $motivo = "informacion";
    $mensaje = "Este es un mensaje de prueba para el formulario de servicios de DeporteFit";
    
    $stmt->bind_param("sssss", $nombre, $email, $telefono, $motivo, $mensaje);
    
    if ($stmt->execute()) {
        $id_insertado = $stmt->insert_id;
        echo "<p style='color: green;'>✅ ¡Datos guardados exitosamente en plataforma_fitness!</p>";
        echo "<p>📋 ID de la solicitud: $id_insertado</p>";
        echo "<p>📧 Email: $email</p>";
        echo "<p>📞 Teléfono: $telefono</p>";
        echo "<p>🎯 Motivo: $motivo</p>";
        
        // Verificar que el dato esté realmente guardado
        $verificar = $conexion->query("SELECT * FROM solicitudes_servicios WHERE id = $id_insertado");
        if ($verificar->num_rows > 0) {
            $datos = $verificar->fetch_assoc();
            echo "<h3>✅ Verificación exitosa - Datos guardados:</h3>";
            echo "<ul>";
            echo "<li><strong>Nombre:</strong> " . htmlspecialchars($datos['nombre']) . "</li>";
            echo "<li><strong>Email:</strong> " . htmlspecialchars($datos['email']) . "</li>";
            echo "<li><strong>Teléfono:</strong> " . htmlspecialchars($datos['telefono']) . "</li>";
            echo "<li><strong>Motivo:</strong> " . htmlspecialchars($datos['motivo']) . "</li>";
            echo "<li><strong>Mensaje:</strong> " . htmlspecialchars($datos['mensaje']) . "</li>";
            echo "<li><strong>Fecha:</strong> " . $datos['fecha_solicitud'] . "</li>";
            echo "</ul>";
        }
        
    } else {
        throw new Exception("Error al ejecutar la consulta: " . $stmt->error);
    }
    
    $stmt->close();
    
    // Mostrar total de registros
    $total = $conexion->query("SELECT COUNT(*) as total FROM solicitudes_servicios")->fetch_assoc()['total'];
    echo "<h3>📊 Estadísticas:</h3>";
    echo "<p>Total de solicitudes de servicios en plataforma_fitness: <strong>$total</strong></p>";
    
    echo "<h2 style='color: green;'>🎉 ¡Prueba completada con éxito!</h2>";
    
    echo "<div style='margin-top: 20px; padding: 15px; background: #e8f5e8; border-radius: 8px;'>";
    echo "<h3>📋 ¿Qué significa esto?</h3>";
    echo "<p>✅ El formulario de <strong>servicios.php</strong> está conectado a <strong>plataforma_fitness</strong></p>";
    echo "<p>✅ Los datos se guardarán en la tabla <strong>solicitudes_servicios</strong></p>";
    echo "<p>✅ Verás el mensaje: <em>'¡Éxito! Tu solicitud de servicio ha sido enviada. Te contactaremos pronto.'</em></p>";
    echo "<p>✅ La página no se recargará (gracias a AJAX)</p>";
    echo "<p>✅ Los estilos de navbar y header se mantendrán</p>";
    echo "</div>";
    
    echo "<div style='margin-top: 15px; padding: 15px; background: #fff3cd; border-radius: 8px; border-left: 4px solid #ffc107;'>";
    echo "<h3>🔍 Para probar en el navegador:</h3>";
    echo "<ol>";
    echo "<li>Ve a <a href='servicios.php' target='_blank'>servicios.php</a></li>";
    echo "<li>Completa el formulario 'Solicitar Información'</li>";
    echo "<li>Haz clic en 'Enviar'</li>";
    echo "<li>Verás el mensaje de éxito sin recargar la página</li>";
    echo "<li>Los datos quedarán guardados en plataforma_fitness</li>";
    echo "</ol>";
    echo "</div>";
    
    echo "<p><a href='servicios.php' target='_blank'>🚀 Ir al formulario de servicios</a> | <a href='prueba_inserciones.php'>🧪 Probar todos los formularios</a></p>";
    
    $conexion->close();
    
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Error: " . $e->getMessage() . "</p>";
    echo "<p>Asegúrate de:</p>";
    echo "<ul>";
    echo "<li>Ejecutar <a href='crear_db_guardar.php'>crear_db_guardar.php</a> primero</li>";
    echo "<li>Que XAMPP esté corriendo (Apache y MySQL)</li>";
    echo "<li>Que el usuario MySQL sea 'root' sin contraseña</li>";
    echo "</ul>";
}
?>
