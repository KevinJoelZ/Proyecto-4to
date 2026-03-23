-- Script para crear la tabla de usuarios para autenticación con Google
-- Ejecutar en XAMPP/MySQL: mysql -u root -p"" guardarbd < BD/users_table.sql

USE guardarbd;

CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `uid` VARCHAR(255) NOT NULL UNIQUE,
  `nombre` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL UNIQUE,
  `foto_perfil` TEXT,
  `email_verificado` TINYINT(1) DEFAULT 0,
  `fecha_registro` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ultima_conexion` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `rol` VARCHAR(50) NOT NULL DEFAULT 'cliente',
  PRIMARY KEY (`id`),
  KEY `idx_uid` (`uid`),
  KEY `idx_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insertar un admin de ejemplo (cambiar email por real, y usar uid ficticio)
-- INSERT INTO `usuarios` (`uid`, `nombre`, `email`, `rol`) VALUES ('admin_uid_ficticio', 'Admin Ejemplo', 'admin@deportefit.com', 'admin');