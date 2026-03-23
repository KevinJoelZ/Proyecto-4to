-- Script para crear las tablas EXACTAMENTE según los formularios existentes
-- Ejecutar este script en tu base de datos de InfinityFree
-- IMPORTANTE: Ejecuta esto en el panel de control de InfinityFree en la sección de MySQL

-- Tabla para contactos generales (usada por procesar_formularios.php)
-- Campos: nombre, email, telefono, motivo, mensaje, privacidad
CREATE TABLE IF NOT EXISTS `contactos` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla para solicitudes de información general (usada por solicitar-info.php)
-- Campos: nombre, email, telefono, servicio, plan, mensaje
CREATE TABLE IF NOT EXISTS `solicitudes_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `servicio` varchar(100) NOT NULL,
  `plan` varchar(50) DEFAULT NULL,
  `mensaje` text DEFAULT NULL,
  `fecha_solicitud` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `estado` enum('pendiente','respondido','archivado') DEFAULT 'pendiente',
  PRIMARY KEY (`id`),
  KEY `idx_email` (`email`),
  KEY `idx_servicio` (`servicio`),
  KEY `idx_fecha` (`fecha_solicitud`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla para solicitudes de entrenadores específicos
-- Campos: nombre, email, telefono, motivo, mensaje
CREATE TABLE IF NOT EXISTS `solicitudes_entrenadores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `motivo` enum('informacion','soporte','entrenadores','otros') NOT NULL,
  `mensaje` text NOT NULL,
  `fecha_solicitud` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `estado` enum('pendiente','respondido','archivado') DEFAULT 'pendiente',
  PRIMARY KEY (`id`),
  KEY `idx_email` (`email`),
  KEY `idx_motivo` (`motivo`),
  KEY `idx_fecha` (`fecha_solicitud`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla para solicitudes de planes específicos
-- Campos: nombre, email, telefono, motivo, mensaje
CREATE TABLE IF NOT EXISTS `solicitudes_planes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `motivo` enum('informacion','soporte','entrenadores','otros') NOT NULL,
  `mensaje` text NOT NULL,
  `fecha_solicitud` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `estado` enum('pendiente','respondido','archivado') DEFAULT 'pendiente',
  PRIMARY KEY (`id`),
  KEY `idx_email` (`email`),
  KEY `idx_motivo` (`motivo`),
  KEY `idx_fecha` (`fecha_solicitud`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla para solicitudes de servicios específicos
-- Campos: nombre, email, telefono, motivo, mensaje
CREATE TABLE IF NOT EXISTS `solicitudes_servicios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `motivo` enum('informacion','soporte','entrenadores','otros') NOT NULL,
  `mensaje` text NOT NULL,
  `fecha_solicitud` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `estado` enum('pendiente','respondido','archivado') DEFAULT 'pendiente',
  PRIMARY KEY (`id`),
  KEY `idx_email` (`email`),
  KEY `idx_motivo` (`motivo`),
  KEY `idx_fecha` (`fecha_solicitud`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insertar datos de ejemplo para probar la funcionalidad
INSERT INTO `contactos` (`nombre`, `email`, `telefono`, `motivo`, `mensaje`, `privacidad`, `fecha_creacion`, `estado`) VALUES
('Usuario Ejemplo', 'ejemplo@email.com', '0991234567', 'informacion', 'Me gustaría obtener más información sobre los servicios de entrenamiento.', 1, NOW(), 'pendiente');

INSERT INTO `solicitudes_info` (`nombre`, `email`, `telefono`, `servicio`, `plan`, `mensaje`, `fecha_solicitud`, `estado`) VALUES
('Cliente Ejemplo', 'cliente@email.com', '0987654321', 'Entrenamiento Personal', 'Plan Estándar', 'Interesado en el plan estándar de entrenamiento personal', NOW(), 'pendiente');

INSERT INTO `solicitudes_entrenadores` (`nombre`, `email`, `telefono`, `motivo`, `mensaje`, `fecha_solicitud`, `estado`) VALUES
('Deportista Ejemplo', 'deportista@email.com', '0976543210', 'entrenadores', 'Quisiera contactar a un entrenador de fitness para comenzar mi entrenamiento', NOW(), 'pendiente');

INSERT INTO `solicitudes_planes` (`nombre`, `email`, `telefono`, `motivo`, `mensaje`, `fecha_solicitud`, `estado`) VALUES
('Interesado Plan', 'plan@email.com', '0965432109', 'informacion', 'Necesito información detallada sobre los planes de entrenamiento disponibles', NOW(), 'pendiente');

INSERT INTO `solicitudes_servicios` (`nombre`, `email`, `telefono`, `motivo`, `mensaje`, `fecha_solicitud`, `estado`) VALUES
('Cliente Servicio', 'servicio@email.com', '0954321098', 'informacion', 'Me interesa conocer más sobre los servicios de entrenamiento deportivo', NOW(), 'pendiente');

-- Verificar que las tablas se crearon correctamente
SHOW TABLES;

-- Mostrar estructura de cada tabla
DESCRIBE contactos;
DESCRIBE solicitudes_info;
DESCRIBE solicitudes_entrenadores;
DESCRIBE solicitudes_planes;
DESCRIBE solicitudes_servicios;
