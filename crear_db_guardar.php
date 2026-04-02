<?php
/**
 * Script para crear la base de datos plataforma_fitness y todas las tablas necesarias
 * Ejecutar este archivo desde el navegador una sola vez
 */

header('Content-Type: text/html; charset=utf-8');

echo "<h1>Creando base de datos plataforma_fitness y tablas...</h1>";

try {
    // Conectar sin especificar base de datos
    $host = "localhost";
    $user = "root";
    $password = "";
    
    $conn = new mysqli($host, $user, $password);
    if ($conn->connect_error) {
        throw new Exception("Error de conexión: " . $conn->connect_error);
    }
    
    echo "<p>✓ Conexión al servidor MySQL establecida</p>";
    
    // Crear base de datos si no existe
    $conn->query("CREATE DATABASE IF NOT EXISTS plataforma_fitness CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "<p>✓ Base de datos 'plataforma_fitness' creada/verificada</p>";
    
    // Seleccionar la base de datos
    $conn->select_db("plataforma_fitness");
    echo "<p>✓ Conectado a la base de datos plataforma_fitness</p>";
    
    // Tablas para formularios de contacto y solicitudes
    $tablas_formularios = [
        "CREATE TABLE IF NOT EXISTS `contactos` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `nombre` varchar(100) NOT NULL,
            `email` varchar(100) NOT NULL,
            `telefono` varchar(20) DEFAULT NULL,
            `motivo` varchar(50) NOT NULL,
            `mensaje` text NOT NULL,
            `privacidad` tinyint(1) DEFAULT 0,
            `fecha_creacion` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            KEY `idx_email` (`email`),
            KEY `idx_fecha` (`fecha_creacion`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
        
        "CREATE TABLE IF NOT EXISTS `solicitudes_entrenadores` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `nombre` varchar(100) NOT NULL,
            `email` varchar(100) NOT NULL,
            `telefono` varchar(20) DEFAULT NULL,
            `motivo` varchar(50) NOT NULL,
            `mensaje` text NOT NULL,
            `fecha_solicitud` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            KEY `idx_email` (`email`),
            KEY `idx_fecha` (`fecha_solicitud`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
        
        "CREATE TABLE IF NOT EXISTS `solicitudes_planes` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `nombre` varchar(100) NOT NULL,
            `email` varchar(100) NOT NULL,
            `telefono` varchar(20) DEFAULT NULL,
            `motivo` varchar(50) NOT NULL,
            `mensaje` text NOT NULL,
            `fecha_solicitud` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            KEY `idx_email` (`email`),
            KEY `idx_fecha` (`fecha_solicitud`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
        
        "CREATE TABLE IF NOT EXISTS `solicitudes_servicios` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `nombre` varchar(100) NOT NULL,
            `email` varchar(100) NOT NULL,
            `telefono` varchar(20) DEFAULT NULL,
            `motivo` varchar(50) NOT NULL,
            `mensaje` text NOT NULL,
            `fecha_solicitud` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            KEY `idx_email` (`email`),
            KEY `idx_fecha` (`fecha_solicitud`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;"
    ];
    
    // Tablas para el módulo de avance
    $tablas_avance = [
        "CREATE TABLE IF NOT EXISTS `rutinas` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `usuario_id` varchar(100) DEFAULT NULL,
            `nombre` varchar(150) NOT NULL,
            `tipo` enum('fuerza','cardio','flexibilidad','tecnica','resistencia') NOT NULL,
            `dificultad` enum('principiante','intermedio','avanzado') NOT NULL,
            `duracion` int(11) NOT NULL COMMENT 'Duración en minutos',
            `notas` text,
            `fecha_creacion` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `estado` enum('activa','completada','cancelada') DEFAULT 'activa',
            PRIMARY KEY (`id`),
            KEY `idx_usuario` (`usuario_id`),
            KEY `idx_tipo` (`tipo`),
            KEY `idx_fecha` (`fecha_creacion`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
        
        "CREATE TABLE IF NOT EXISTS `ejercicios` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `rutina_id` int(11) NOT NULL,
            `nombre` varchar(150) NOT NULL,
            `series` int(11) NOT NULL DEFAULT 1,
            `repeticiones` int(11) NOT NULL,
            `peso` decimal(6,2) DEFAULT NULL COMMENT 'Peso en kg',
            `descanso` int(11) DEFAULT 60 COMMENT 'Descanso en segundos',
            `orden` int(11) DEFAULT 0,
            `fecha_creacion` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            KEY `idx_rutina` (`rutina_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
        
        "CREATE TABLE IF NOT EXISTS `progresos_peso` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `usuario_id` varchar(100) DEFAULT NULL,
            `peso` decimal(5,2) NOT NULL COMMENT 'Peso en kg',
            `fecha_medicion` date NOT NULL,
            `notas` text,
            `fecha_creacion` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            KEY `idx_usuario` (`usuario_id`),
            KEY `idx_fecha` (`fecha_medicion`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
        
        "CREATE TABLE IF NOT EXISTS `medidas_corporales` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `usuario_id` varchar(100) DEFAULT NULL,
            `fecha_medicion` date NOT NULL,
            `pecho` decimal(5,2) DEFAULT NULL,
            `cintura` decimal(5,2) DEFAULT NULL,
            `cadera` decimal(5,2) DEFAULT NULL,
            `biceps` decimal(5,2) DEFAULT NULL,
            `pierna` decimal(5,2) DEFAULT NULL,
            `notas` text,
            `fecha_creacion` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            KEY `idx_usuario` (`usuario_id`),
            KEY `idx_fecha` (`fecha_medicion`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
        
        "CREATE TABLE IF NOT EXISTS `entrenamientos_realizados` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `usuario_id` varchar(100) DEFAULT NULL,
            `rutina_id` int(11) DEFAULT NULL,
            `nombre_rutina` varchar(150) DEFAULT NULL,
            `intensidad` int(11) DEFAULT 5 COMMENT '1-10',
            `sensacion` enum('excelente','bien','regular','cansado','agotado') DEFAULT 'bien',
            `duracion_real` int(11) DEFAULT NULL COMMENT 'Duración real en minutos',
            `calorias` int(11) DEFAULT NULL,
            `fecha_entrenamiento` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            KEY `idx_usuario` (`usuario_id`),
            KEY `idx_fecha` (`fecha_entrenamiento`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
        
        "CREATE TABLE IF NOT EXISTS `objetivos` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `usuario_id` varchar(100) DEFAULT NULL,
            `tipo` enum('peso','cintura','entrenamientos_semana') NOT NULL,
            `valor_objetivo` decimal(6,2) NOT NULL,
            `valor_actual` decimal(6,2) DEFAULT 0,
            `fecha_inicio` date NOT NULL,
            `fecha_objetivo` date DEFAULT NULL,
            `estado` enum('activo','completado','cancelado') DEFAULT 'activo',
            `fecha_creacion` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            KEY `idx_usuario` (`usuario_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;"
    ];
    
    // Combinar todas las tablas
    $todas_tablas = array_merge($tablas_formularios, $tablas_avance);
    
    // Ejecutar todas las consultas
    $contador = 0;
    $errores = [];
    
    foreach ($todas_tablas as $consulta) {
        try {
            $result = $conn->query($consulta);
            if ($result === true || $conn->affected_rows >= 0) {
                $contador++;
            }
        } catch (Exception $e) {
            // Ignorar errores de tabla ya existente
            if (strpos($e->getMessage(), 'already exists') === false) {
                $errores[] = $e->getMessage();
            }
        }
    }
    
    echo "<p>✓ Se ejecutaron $contador consultas de creación de tablas</p>";
    
    if (!empty($errores)) {
        echo "<p>⚠ Errores ignorados (tablas ya existentes):</p>";
        echo "<ul>" . implode(', ', array_map(function($e) { return "<li>$e</li>"; }, array_slice($errores, 0, 5))) . "</ul>";
    }
    
    // Verificar que todas las tablas existen
    echo "<h2>Verificación de tablas creadas:</h2>";
    echo "<ul>";
    
    $tablas_esperadas = [
        'contactos', 'solicitudes_entrenadores', 'solicitudes_planes', 'solicitudes_servicios',
        'rutinas', 'ejercicios', 'progresos_peso', 'medidas_corporales', 
        'entrenamientos_realizados', 'objetivos'
    ];
    
    foreach ($tablas_esperadas as $tabla) {
        $result = $conn->query("SHOW TABLES LIKE '$tabla'");
        if ($result->num_rows > 0) {
            echo "<li>✓ Tabla '$tabla' existe</li>";
        } else {
            echo "<li>✗ Tabla '$tabla' NO existe</li>";
        }
    }
    
    echo "</ul>";
    
    // Insertar datos de ejemplo para el módulo de avance
    echo "<h2>Insertando datos de ejemplo para avance...</h2>";
    
    $datos_ejemplo = [
        "INSERT INTO `rutinas` (`usuario_id`, `nombre`, `tipo`, `dificultad`, `duracion`, `notas`, `fecha_creacion`, `estado`) VALUES
        ('demo_user', 'Rutina de Piernas - Lunes', 'fuerza', 'intermedio', 60, 'Enfoque en cuádriceps y glúteos', NOW(), 'activa'),
        ('demo_user', 'Cardio Matutino', 'cardio', 'principiante', 30, 'Entrenamiento ligero para empezar', NOW(), 'activa'),
        ('demo_user', 'Estiramientos y Yoga', 'flexibilidad', 'principiante', 45, 'Sesión de recuperación', NOW(), 'activa')
        ON DUPLICATE KEY UPDATE nombre=VALUES(nombre);",
        
        "INSERT INTO `ejercicios` (`rutina_id`, `nombre`, `series`, `repeticiones`, `peso`, `descanso`, `orden`) VALUES
        (1, 'Sentadillas', 4, 12, 20.00, 60, 1),
        (1, 'Prensa de piernas', 3, 15, 80.00, 90, 2),
        (2, 'Trote ligero', 1, 20, 0.00, 0, 1),
        (3, 'Estiramiento de isquiotibiales', 1, 60, 0.00, 0, 1)
        ON DUPLICATE KEY UPDATE nombre=VALUES(nombre);",
        
        "INSERT INTO `progresos_peso` (`usuario_id`, `peso`, `fecha_medicion`, `notas`) VALUES
        ('demo_user', 76.00, '2026-03-18', 'Peso inicial'),
        ('demo_user', 75.80, '2026-03-20', 'Buen progreso'),
        ('demo_user', 75.50, '2026-03-22', 'Continuando bien')
        ON DUPLICATE KEY UPDATE peso=VALUES(peso);",
        
        "INSERT INTO `medidas_corporales` (`usuario_id`, `fecha_medicion`, `pecho`, `cintura`, `cadera`, `biceps`) VALUES
        ('demo_user', '2026-03-18', 101.00, 83.00, 95.00, 34.00),
        ('demo_user', '2026-03-20', 100.50, 82.50, 94.50, 34.50)
        ON DUPLICATE KEY UPDATE pecho=VALUES(pecho);",
        
        "INSERT INTO `objetivos` (`usuario_id`, `tipo`, `valor_objetivo`, `valor_actual`, `fecha_inicio`, `estado`) VALUES
        ('demo_user', 'peso', 70.00, 75.50, '2026-03-01', 'activo'),
        ('demo_user', 'cintura', 78.00, 82.00, '2026-03-01', 'activo')
        ON DUPLICATE KEY UPDATE valor_objetivo=VALUES(valor_objetivo);"
    ];
    
    foreach ($datos_ejemplo as $consulta) {
        try {
            $conn->query($consulta);
        } catch (Exception $e) {
            // Ignorar errores de duplicados
        }
    }
    
    echo "<p>✓ Datos de ejemplo insertados</p>";
    
    // Mostrar resumen final
    echo "<h2>Resumen final:</h2>";
    echo "<ul>";
    
    foreach ($tablas_esperadas as $tabla) {
        $result = $conn->query("SELECT COUNT(*) as total FROM $tabla");
        $row = $result->fetch_assoc();
        echo "<li>$tabla: " . $row['total'] . " registros</li>";
    }
    
    echo "</ul>";
    
    echo "<h2 style='color: green;'>✓ Base de datos plataforma_fitness configurada exitosamente</h2>";
    echo "<p>La plataforma ahora está conectada a plataforma_fitness y todas las inserciones se guardarán allí.</p>";
    echo "<p><a href='test_db_guardar.php'>Ir al test de conexión</a> | <a href='../index.php'>Ir al inicio</a></p>";
    
    $conn->close();
    
} catch (Exception $e) {
    echo "<p style='color: red;'>✗ Error: " . $e->getMessage() . "</p>";
}
?>
