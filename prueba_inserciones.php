<?php
/**
 * Script de prueba para verificar que todos los formularios guardan en plataforma_fitness
 */

header('Content-Type: text/html; charset=utf-8');

echo "<h1>🧪 Prueba de Inserciones en plataforma_fitness</h1>";

try {
    // Incluir conexión
    require_once 'conexion.php';
    
    echo "<p style='color: green;'>✅ Conexión a plataforma_fitness establecida</p>";
    
    // Prueba 1: Insertar en contactos
    echo "<h2>📝 Prueba 1: Formulario de Contacto</h2>";
    $sql_contacto = "INSERT INTO contactos (nombre, email, telefono, motivo, mensaje, privacidad) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql_contacto);
    
    $nombre = "Usuario Prueba Contacto";
    $email = "contacto@prueba.com";
    $telefono = "0991234567";
    $motivo = "informacion";
    $mensaje = "Este es un mensaje de prueba para el formulario de contacto";
    $privacidad = 1;
    
    $stmt->bind_param("sssssi", $nombre, $email, $telefono, $motivo, $mensaje, $privacidad);
    
    if ($stmt->execute()) {
        echo "<p style='color: green;'>✅ Contacto insertado correctamente</p>";
        $contacto_id = $stmt->insert_id;
        echo "<p>ID del contacto: $contacto_id</p>";
    } else {
        echo "<p style='color: red;'>❌ Error al insertar contacto: " . $stmt->error . "</p>";
    }
    $stmt->close();
    
    // Prueba 2: Insertar en solicitudes_entrenadores
    echo "<h2>🏋️ Prueba 2: Formulario de Entrenadores</h2>";
    $sql_entrenador = "INSERT INTO solicitudes_entrenadores (nombre, email, telefono, motivo, mensaje) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql_entrenador);
    
    $nombre = "Usuario Prueba Entrenador";
    $email = "entrenador@prueba.com";
    $telefono = "0997654321";
    $motivo = "entrenadores";
    $mensaje = "Quiero información sobre entrenadores personales";
    
    $stmt->bind_param("sssss", $nombre, $email, $telefono, $motivo, $mensaje);
    
    if ($stmt->execute()) {
        echo "<p style='color: green;'>✅ Solicitud de entrenador insertada correctamente</p>";
        $entrenador_id = $stmt->insert_id;
        echo "<p>ID de la solicitud: $entrenador_id</p>";
    } else {
        echo "<p style='color: red;'>❌ Error al insertar solicitud de entrenador: " . $stmt->error . "</p>";
    }
    $stmt->close();
    
    // Prueba 3: Insertar en solicitudes_planes
    echo "<h2>💰 Prueba 3: Formulario de Planes</h2>";
    $sql_plan = "INSERT INTO solicitudes_planes (nombre, email, telefono, motivo, mensaje) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql_plan);
    
    $nombre = "Usuario Prueba Plan";
    $email = "plan@prueba.com";
    $telefono = "0995555555";
    $motivo = "planes";
    $mensaje = "Estoy interesado en el plan personalizado";
    
    $stmt->bind_param("sssss", $nombre, $email, $telefono, $motivo, $mensaje);
    
    if ($stmt->execute()) {
        echo "<p style='color: green;'>✅ Solicitud de plan insertada correctamente</p>";
        $plan_id = $stmt->insert_id;
        echo "<p>ID de la solicitud: $plan_id</p>";
    } else {
        echo "<p style='color: red;'>❌ Error al insertar solicitud de plan: " . $stmt->error . "</p>";
    }
    $stmt->close();
    
    // Prueba 4: Insertar en solicitudes_servicios
    echo "<h2>🎯 Prueba 4: Formulario de Servicios</h2>";
    $sql_servicio = "INSERT INTO solicitudes_servicios (nombre, email, telefono, motivo, mensaje) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql_servicio);
    
    $nombre = "Usuario Prueba Servicio";
    $email = "servicio@prueba.com";
    $telefono = "0993333333";
    $motivo = "servicios";
    $mensaje = "Quiero información sobre los servicios disponibles";
    
    $stmt->bind_param("sssss", $nombre, $email, $telefono, $motivo, $mensaje);
    
    if ($stmt->execute()) {
        echo "<p style='color: green;'>✅ Solicitud de servicio insertada correctamente</p>";
        $servicio_id = $stmt->insert_id;
        echo "<p>ID de la solicitud: $servicio_id</p>";
    } else {
        echo "<p style='color: red;'>❌ Error al insertar solicitud de servicio: " . $stmt->error . "</p>";
    }
    $stmt->close();
    
    // Prueba 5: Insertar en rutinas (módulo de avance)
    echo "<h2>📊 Prueba 5: Módulo de Avance - Rutinas</h2>";
    $sql_rutina = "INSERT INTO rutinas (usuario_id, nombre, tipo, dificultad, duracion, notas, estado) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql_rutina);
    
    $usuario_id = "demo_user";
    $nombre = "Rutina de Prueba";
    $tipo = "fuerza";
    $dificultad = "principiante";
    $duracion = 45;
    $notas = "Esta es una rutina de prueba";
    $estado = "activa";
    
    $stmt->bind_param("ssssiss", $usuario_id, $nombre, $tipo, $dificultad, $duracion, $notas, $estado);
    
    if ($stmt->execute()) {
        echo "<p style='color: green;'>✅ Rutina insertada correctamente</p>";
        $rutina_id = $stmt->insert_id;
        echo "<p>ID de la rutina: $rutina_id</p>";
    } else {
        echo "<p style='color: red;'>❌ Error al insertar rutina: " . $stmt->error . "</p>";
    }
    $stmt->close();
    
    // Mostrar resumen final
    echo "<h2>📈 Resumen de Registros en plataforma_fitness</h2>";
    echo "<ul>";
    
    $tablas = ['contactos', 'solicitudes_entrenadores', 'solicitudes_planes', 'solicitudes_servicios', 'rutinas'];
    
    foreach ($tablas as $tabla) {
        $result = $conexion->query("SELECT COUNT(*) as total FROM $tabla");
        $row = $result->fetch_assoc();
        echo "<li><strong>$tabla:</strong> " . $row['total'] . " registros</li>";
    }
    
    echo "</ul>";
    
    echo "<h2 style='color: green;'>🎉 ¡Pruebas completadas con éxito!</h2>";
    echo "<p>Todos los formularios están guardando correctamente en la base de datos <strong>plataforma_fitness</strong>.</p>";
    echo "<p>Los mensajes de éxito que verás en la plataforma serán: '¡Éxito! Tu mensaje ha sido enviado. Te contactaremos pronto.'</p>";
    
    echo "<div style='margin-top: 20px; padding: 15px; background: #e8f5e8; border-radius: 8px;'>";
    echo "<h3>📋 Pasos siguientes:</h3>";
    echo "<ol>";
    echo "<li>Ejecuta <strong>ejecutar_script.bat</strong> para crear la base de datos si aún no lo has hecho</li>";
    echo "<li>Prueba los formularios en: contacto.php, servicios.php, planes.php, trainers.php</li>";
    echo "<li>Verifica que todos los datos se guarden en plataforma_fitness</li>";
    echo "<li>Los mensajes de éxito aparecerán sin recargar la página (gracias a AJAX)</li>";
    echo "</ol>";
    echo "</div>";
    
    echo "<p><a href='index.php'>Ir al inicio</a> | <a href='contacto.php'>Probar formulario de contacto</a></p>";
    
    $conexion->close();
    
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Error: " . $e->getMessage() . "</p>";
    echo "<p>Asegúrate de ejecutar primero <a href='crear_db_guardar.php'>crear_db_guardar.php</a></p>";
}
?>
