-- Script SQL para crear la tabla de usuarios para el sistema de login con Google
-- Ejecutar este script en phpMyAdmin o MySQL Workbench

-- Crear la base de datos si no existe
CREATE DATABASE IF NOT EXISTS guardarbd;
USE guardarbd;

-- Crear la tabla usuarios
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    uid VARCHAR(255) UNIQUE NOT NULL COMMENT 'UID de Firebase',
    nombre VARCHAR(255) NOT NULL COMMENT 'Nombre completo del usuario',
    email VARCHAR(255) UNIQUE NOT NULL COMMENT 'Email del usuario',
    foto_perfil TEXT COMMENT 'URL de la foto de perfil',
    email_verificado TINYINT(1) DEFAULT 0 COMMENT '1 si el email está verificado, 0 si no',
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha de registro',
    ultima_conexion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Última vez que se conectó',
    estado ENUM('activo', 'inactivo') DEFAULT 'activo' COMMENT 'Estado del usuario',
    rol ENUM('admin', 'cliente') DEFAULT 'cliente' COMMENT 'Rol del usuario'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Crear índices para mejorar el rendimiento
CREATE INDEX idx_email ON usuarios(email);
CREATE INDEX idx_uid ON usuarios(uid);
CREATE INDEX idx_rol ON usuarios(rol);

-- Insertar un usuario administrador de ejemplo (opcional)
-- Cambiar el email por el tuyo para tener acceso de administrador
INSERT IGNORE INTO usuarios (uid, nombre, email, foto_perfil, email_verificado, rol) 
VALUES ('admin-uid-example', 'Administrador', 'admin@deportefit.com', '', 1, 'admin');

-- Mostrar la estructura de la tabla creada
DESCRIBE usuarios;

-- Mostrar los usuarios existentes
SELECT id, nombre, email, rol, fecha_registro FROM usuarios;
