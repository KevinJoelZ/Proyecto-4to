-- =====================================================
-- BASE DE DATOS COMPLETA - DEPORTEFIT
-- =====================================================
-- Nombre de la base de datos: guardarbd
-- Ejecutar en phpMyAdmin o cualquier cliente MySQL
-- =====================================================

-- Crear base de datos (si no existe)
CREATE DATABASE IF NOT EXISTS guardarbd;
USE guardarbd;

-- =====================================================
-- TABLA: USUARIOS (Base de usuarios Firebase)
-- =====================================================
CREATE TABLE IF NOT EXISTS `usuarios` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `uid` VARCHAR(255) UNIQUE NOT NULL COMMENT 'UID de Firebase',
    `nombre` VARCHAR(255) NOT NULL COMMENT 'Nombre completo',
    `email` VARCHAR(255) UNIQUE NOT NULL COMMENT 'Email del usuario',
    `foto_perfil` TEXT DEFAULT NULL COMMENT 'URL de foto de perfil',
    `email_verificado` TINYINT(1) DEFAULT 0 COMMENT '1 si el email está verificado',
    `telefono` VARCHAR(20) DEFAULT NULL,
    `fecha_registro` TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha de registro',
    `ultima_conexion` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `estado` ENUM('activo', 'inactivo', 'suspendido') DEFAULT 'activo',
    `rol` ENUM('admin', 'cliente', 'entrenador') DEFAULT 'cliente',
    INDEX `idx_uid` (`uid`),
    INDEX `idx_email` (`email`),
    INDEX `idx_estado` (`estado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- TABLA: CONTACTOS (Formulario de contacto)
-- =====================================================
CREATE TABLE IF NOT EXISTS `contactos` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `nombre` VARCHAR(100) NOT NULL,
    `email` VARCHAR(100) NOT NULL,
    `telefono` VARCHAR(20) DEFAULT NULL,
    `motivo` ENUM('informacion', 'soporte', 'entrenadores', 'otros') NOT NULL,
    `mensaje` TEXT NOT NULL,
    `privacidad` TINYINT(1) DEFAULT 0,
    `fecha_creacion` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `estado` ENUM('pendiente', 'respondido', 'archivado') DEFAULT 'pendiente',
    INDEX `idx_email` (`email`),
    INDEX `idx_motivo` (`motivo`),
    INDEX `idx_fecha` (`fecha_creacion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- TABLA: SOLICITUDES DE INFORMACIÓN
-- =====================================================
CREATE TABLE IF NOT EXISTS `solicitudes_info` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `nombre` VARCHAR(100) NOT NULL,
    `email` VARCHAR(100) NOT NULL,
    `telefono` VARCHAR(20) DEFAULT NULL,
    `servicio` VARCHAR(100) NOT NULL,
    `plan` VARCHAR(50) DEFAULT NULL,
    `mensaje` TEXT DEFAULT NULL,
    `fecha_solicitud` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `estado` ENUM('pendiente', 'respondido', 'archivado') DEFAULT 'pendiente',
    INDEX `idx_email` (`email`),
    INDEX `idx_servicio` (`servicio`),
    INDEX `idx_fecha` (`fecha_solicitud`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- TABLA: SOLICITUDES DE ENTRENADORES
-- =====================================================
CREATE TABLE IF NOT EXISTS `solicitudes_entrenadores` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `nombre` VARCHAR(100) NOT NULL,
    `email` VARCHAR(100) NOT NULL,
    `telefono` VARCHAR(20) DEFAULT NULL,
    `motivo` ENUM('informacion', 'soporte', 'entrenadores', 'otros') NOT NULL,
    `mensaje` TEXT NOT NULL,
    `fecha_solicitud` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `estado` ENUM('pendiente', 'respondido', 'archivado') DEFAULT 'pendiente',
    INDEX `idx_email` (`email`),
    INDEX `idx_motivo` (`motivo`),
    INDEX `idx_fecha` (`fecha_solicitud`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- TABLA: SOLICITUDES DE PLANES
-- =====================================================
CREATE TABLE IF NOT EXISTS `solicitudes_planes` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `nombre` VARCHAR(100) NOT NULL,
    `email` VARCHAR(100) NOT NULL,
    `telefono` VARCHAR(20) DEFAULT NULL,
    `motivo` ENUM('informacion', 'soporte', 'entrenadores', 'otros') NOT NULL,
    `mensaje` TEXT NOT NULL,
    `fecha_solicitud` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `estado` ENUM('pendiente', 'respondido', 'archivado') DEFAULT 'pendiente',
    INDEX `idx_email` (`email`),
    INDEX `idx_motivo` (`motivo`),
    INDEX `idx_fecha` (`fecha_solicitud`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- TABLA: SOLICITUDES DE SERVICIOS
-- =====================================================
CREATE TABLE IF NOT EXISTS `solicitudes_servicios` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `nombre` VARCHAR(100) NOT NULL,
    `email` VARCHAR(100) NOT NULL,
    `telefono` VARCHAR(20) DEFAULT NULL,
    `motivo` ENUM('informacion', 'soporte', 'entrenadores', 'otros') NOT NULL,
    `mensaje` TEXT NOT NULL,
    `fecha_solicitud` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `estado` ENUM('pendiente', 'respondido', 'archivado') DEFAULT 'pendiente',
    INDEX `idx_email` (`email`),
    INDEX `idx_motivo` (`motivo`),
    INDEX `idx_fecha` (`fecha_solicitud`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- TABLA: RUTINAS (Módulo de Avance)
-- =====================================================
CREATE TABLE IF NOT EXISTS `rutinas` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `usuario_id` VARCHAR(100) DEFAULT NULL,
    `nombre` VARCHAR(150) NOT NULL,
    `tipo` ENUM('fuerza', 'cardio', 'flexibilidad', 'tecnica', 'resistencia') NOT NULL,
    `dificultad` ENUM('principiante', 'intermedio', 'avanzado') NOT NULL,
    `duracion` INT NOT NULL COMMENT 'Duración en minutos',
    `notas` TEXT,
    `fecha_creacion` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `estado` ENUM('activa', 'completada', 'cancelada') DEFAULT 'activa',
    INDEX `idx_usuario` (`usuario_id`),
    INDEX `idx_tipo` (`tipo`),
    INDEX `idx_fecha` (`fecha_creacion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- TABLA: EJERCICIOS (Ejercicios por rutina)
-- =====================================================
CREATE TABLE IF NOT EXISTS `ejercicios` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `rutina_id` INT NOT NULL,
    `nombre` VARCHAR(150) NOT NULL,
    `series` INT NOT NULL DEFAULT 1,
    `repeticiones` INT NOT NULL,
    `peso` DECIMAL(6,2) DEFAULT NULL COMMENT 'Peso en kg',
    `descanso` INT DEFAULT 60 COMMENT 'Descanso en segundos',
    `orden` INT DEFAULT 0,
    `fecha_creacion` DATETIME DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_rutina` (`rutina_id`),
    FOREIGN KEY (`rutina_id`) REFERENCES `rutinas`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- TABLA: PROGRESOS PESO (Registro de peso corporal)
-- =====================================================
CREATE TABLE IF NOT EXISTS `progresos_peso` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `usuario_id` VARCHAR(100) DEFAULT NULL,
    `peso` DECIMAL(5,2) NOT NULL COMMENT 'Peso en kg',
    `fecha_medicion` DATE NOT NULL,
    `notas` TEXT,
    `fecha_creacion` DATETIME DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_usuario` (`usuario_id`),
    INDEX `idx_fecha` (`fecha_medicion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- TABLA: MEDIDAS CORPORALES
-- =====================================================
CREATE TABLE IF NOT EXISTS `medidas_corporales` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `usuario_id` VARCHAR(100) DEFAULT NULL,
    `fecha_medicion` DATE NOT NULL,
    `pecho` DECIMAL(5,2) DEFAULT NULL,
    `cintura` DECIMAL(5,2) DEFAULT NULL,
    `cadera` DECIMAL(5,2) DEFAULT NULL,
    `biceps` DECIMAL(5,2) DEFAULT NULL,
    `pierna` DECIMAL(5,2) DEFAULT NULL,
    `notas` TEXT,
    `fecha_creacion` DATETIME DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_usuario` (`usuario_id`),
    INDEX `idx_fecha` (`fecha_medicion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- TABLA: ENTRENAMIENTOS REALIZADOS
-- =====================================================
CREATE TABLE IF NOT EXISTS `entrenamientos_realizados` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `usuario_id` VARCHAR(100) DEFAULT NULL,
    `rutina_id` INT DEFAULT NULL,
    `nombre_rutina` VARCHAR(150) DEFAULT NULL,
    `intensidad` INT DEFAULT 5 COMMENT '1-10',
    `sensacion` ENUM('excelente', 'bien', 'regular', 'cansado', 'agotado') DEFAULT 'bien',
    `duracion_real` INT DEFAULT NULL COMMENT 'Duración real en minutos',
    `calorias` INT DEFAULT NULL,
    `fecha_entrenamiento` DATETIME DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_usuario` (`usuario_id`),
    INDEX `idx_fecha` (`fecha_entrenamiento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- TABLA: OBJETIVOS
-- =====================================================
CREATE TABLE IF NOT EXISTS `objetivos` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `usuario_id` VARCHAR(100) DEFAULT NULL,
    `tipo` ENUM('peso', 'cintura', 'entrenamientos_semana') NOT NULL,
    `valor_objetivo` DECIMAL(6,2) NOT NULL,
    `valor_actual` DECIMAL(6,2) DEFAULT 0,
    `fecha_inicio` DATE NOT NULL,
    `fecha_objetivo` DATE DEFAULT NULL,
    `estado` ENUM('activo', 'completado', 'cancelado') DEFAULT 'activo',
    `fecha_creacion` DATETIME DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_usuario` (`usuario_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- DATOS DE EJEMPLO (INSERTOS)
-- =====================================================

-- Usuario de ejemplo
INSERT INTO `usuarios` (`uid`, `nombre`, `email`, `foto_perfil`, `email_verificado`, `rol`) VALUES
('demo_user', 'Usuario Demo', 'demo@deportefit.com', '', 1, 'cliente'),
('admin_user', 'Administrador', 'admin@deportefit.com', '', 1, 'admin');

-- Contactos de ejemplo
INSERT INTO `contactos` (`nombre`, `email`, `telefono`, `motivo`, `mensaje`, `privacidad`, `estado`) VALUES
('Usuario Ejemplo', 'ejemplo@email.com', '0991234567', 'informacion', 'Me gustaría obtener más información sobre los servicios de entrenamiento.', 1, 'pendiente');

-- Solicitudes de ejemplo
INSERT INTO `solicitudes_info` (`nombre`, `email`, `telefono`, `servicio`, `plan`, `mensaje`, `estado`) VALUES
('Cliente Ejemplo', 'cliente@email.com', '0987654321', 'Entrenamiento Personal', 'Plan Estándar', 'Interesado en el plan estándar', 'pendiente');

-- Rutinas de ejemplo
INSERT INTO `rutinas` (`usuario_id`, `nombre`, `tipo`, `dificultad`, `duracion`, `notas`, `estado`) VALUES
('demo_user', 'Rutina de Piernas - Lunes', 'fuerza', 'intermedio', 60, 'Enfoque en cuádriceps y glúteos', 'activa'),
('demo_user', 'Cardio Matutino', 'cardio', 'principiante', 30, 'Entrenamiento ligero para empezar', 'activa'),
('demo_user', 'Estiramientos y Yoga', 'flexibilidad', 'principiante', 45, 'Sesión de recuperación', 'activa');

-- Ejercicios de ejemplo
INSERT INTO `ejercicios` (`rutina_id`, `nombre`, `series`, `repeticiones`, `peso`, `descanso`, `orden`) VALUES
(1, 'Sentadillas', 4, 12, 20.00, 60, 1),
(1, 'Prensa de piernas', 3, 15, 80.00, 90, 2),
(1, 'Elevación de talones', 3, 20, 0.00, 45, 3),
(2, 'Trote ligero', 1, 20, 0.00, 0, 1),
(2, 'Saltos de comba', 3, 30, 0.00, 30, 2),
(3, 'Estiramiento de isquiotibiales', 1, 60, 0.00, 0, 1),
(3, 'Yoga: postura del guerrero', 1, 45, 0.00, 0, 2);

-- Progresos de peso
INSERT INTO `progresos_peso` (`usuario_id`, `peso`, `fecha_medicion`, `notas`) VALUES
('demo_user', 76.00, '2026-03-18', 'Peso inicial'),
('demo_user', 75.80, '2026-03-20', 'Buen progreso'),
('demo_user', 75.50, '2026-03-22', 'Continuando bien');

-- Medidas corporales
INSERT INTO `medidas_corporales` (`usuario_id`, `fecha_medicion`, `pecho`, `cintura`, `cadera`, `biceps`) VALUES
('demo_user', '2026-03-18', 101.00, 83.00, 95.00, 34.00),
('demo_user', '2026-03-20', 100.50, 82.50, 94.50, 34.50),
('demo_user', '2026-03-22', 100.00, 82.00, 94.00, 35.00);

-- Entrenamientos realizados
INSERT INTO `entrenamientos_realizados` (`usuario_id`, `rutina_id`, `nombre_rutina`, `intensidad`, `sensacion`, `duracion_real`, `calorias`) VALUES
('demo_user', 1, 'Rutina de Piernas - Lunes', 7, 'bien', 55, 280),
('demo_user', 2, 'Cardio Matutino', 5, 'excelente', 28, 150),
('demo_user', 3, 'Estiramientos y Yoga', 4, 'bien', 45, 100),
('demo_user', 1, 'Rutina de Piernas - Lunes', 8, 'excelente', 58, 320);

-- Objetivos
INSERT INTO `objetivos` (`usuario_id`, `tipo`, `valor_objetivo`, `valor_actual`, `fecha_inicio`, `estado`) VALUES
('demo_user', 'peso', 70.00, 75.50, '2026-03-01', 'activo'),
('demo_user', 'cintura', 78.00, 82.00, '2026-03-01', 'activo'),
('demo_user', 'entrenamientos_semana', 4.00, 3.00, '2026-03-01', 'activo');

-- =====================================================
-- FIN DEL SCRIPT
-- =====================================================
-- La base de datos está lista para usar
-- Accede a: http://localhost/phpmyadmin
-- Selecciona la base de datos "guardarbd"
-- Importa este archivo SQL
-- =====================================================
