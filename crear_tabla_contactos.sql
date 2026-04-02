-- Script para crear la tabla contactos si no existe
-- Ejecutar este script en tu base de datos de MySQL

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

-- Verificar que la tabla se creó correctamente
SHOW TABLES LIKE 'contactos';

-- Mostrar estructura de la tabla
DESCRIBE contactos;
