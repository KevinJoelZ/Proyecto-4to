-- Tablas para el módulo de Avance (Rutinas y Progresos)
-- DeporteFit - Base de datos: guardarbd

-- Tabla de Rutinas
CREATE TABLE IF NOT EXISTS `rutinas` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de Ejercicios
CREATE TABLE IF NOT EXISTS `ejercicios` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de Progresos (Peso)
CREATE TABLE IF NOT EXISTS `progresos_peso` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` varchar(100) DEFAULT NULL,
  `peso` decimal(5,2) NOT NULL COMMENT 'Peso en kg',
  `fecha_medicion` date NOT NULL,
  `notas` text,
  `fecha_creacion` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_usuario` (`usuario_id`),
  KEY `idx_fecha` (`fecha_medicion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de Medidas Corporales
CREATE TABLE IF NOT EXISTS `medidas_corporales` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de Entrenamientos Realizados
CREATE TABLE IF NOT EXISTS `entrenamientos_realizados` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de Objetivos
CREATE TABLE IF NOT EXISTS `objetivos` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insertar datos de ejemplo
INSERT INTO `rutinas` (`usuario_id`, `nombre`, `tipo`, `dificultad`, `duracion`, `notas`, `fecha_creacion`, `estado`) VALUES
('demo_user', 'Rutina de Piernas - Lunes', 'fuerza', 'intermedio', 60, 'Enfoque en cuádriceps y glúteos', NOW(), 'activa'),
('demo_user', 'Cardio Matutino', 'cardio', 'principiante', 30, 'Entrenamiento ligero para empezar', NOW(), 'activa'),
('demo_user', 'Estiramientos y Yoga', 'flexibilidad', 'principiante', 45, 'Sesión de recuperación', NOW(), 'activa');

INSERT INTO `ejercicios` (`rutina_id`, `nombre`, `series`, `repeticiones`, `peso`, `descanso`, `orden`) VALUES
(1, 'Sentadillas', 4, 12, 20.00, 60, 1),
(1, 'Prensa de piernas', 3, 15, 80.00, 90, 2),
(1, 'Elevación de talones', 3, 20, 0.00, 45, 3),
(2, 'Trote ligero', 1, 20, 0.00, 0, 1),
(2, 'Saltos de comba', 3, 30, 0.00, 30, 2),
(3, 'Estiramiento de isquiotibiales', 1, 60, 0.00, 0, 1),
(3, 'Yoga: postura del guerrero', 1, 45, 0.00, 0, 2);

INSERT INTO `progresos_peso` (`usuario_id`, `peso`, `fecha_medicion`, `notas`) VALUES
('demo_user', 76.00, '2026-03-18', 'Peso inicial'),
('demo_user', 75.80, '2026-03-20', 'Buen progreso'),
('demo_user', 75.50, '2026-03-22', 'Continuando bien');

INSERT INTO `medidas_corporales` (`usuario_id`, `fecha_medicion`, `pecho`, `cintura`, `cadera`, `biceps`) VALUES
('demo_user', '2026-03-18', 101.00, 83.00, 95.00, 34.00),
('demo_user', '2026-03-20', 100.50, 82.50, 94.50, 34.50),
('demo_user', '2026-03-22', 100.00, 82.00, 94.00, 35.00);

INSERT INTO `entrenamientos_realizados` (`usuario_id`, `rutina_id`, `nombre_rutina`, `intensidad`, `sensacion`, `duracion_real`, `calorias`) VALUES
('demo_user', 1, 'Rutina de Piernas - Lunes', 7, 'bien', 55, 280),
('demo_user', 2, 'Cardio Matutino', 5, 'excelente', 28, 150),
('demo_user', 3, 'Estiramientos y Yoga', 4, 'bien', 45, 100),
('demo_user', 1, 'Rutina de Piernas - Lunes', 8, 'excelente', 58, 320);

INSERT INTO `objetivos` (`usuario_id`, `tipo`, `valor_objetivo`, `valor_actual`, `fecha_inicio`, `estado`) VALUES
('demo_user', 'peso', 70.00, 75.50, '2026-03-01', 'activo'),
('demo_user', 'cintura', 78.00, 82.00, '2026-03-01', 'activo'),
('demo_user', 'entrenamientos_semana', 4.00, 3.00, '2026-03-01', 'activo');
