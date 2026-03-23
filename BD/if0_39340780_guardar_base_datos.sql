-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: sql107.infinityfree.com
-- Tiempo de generación: 29-08-2025 a las 19:31:35
-- Versión del servidor: 11.4.7-MariaDB
-- Versión de PHP: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `if0_39340780_guardar_base_datos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contactos`
--

CREATE TABLE `contactos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `motivo` enum('informacion','soporte','entrenadores','otros') NOT NULL,
  `mensaje` text NOT NULL,
  `privacidad` tinyint(1) DEFAULT 0,
  `fecha_creacion` datetime NOT NULL DEFAULT current_timestamp(),
  `estado` enum('pendiente','respondido','archivado') DEFAULT 'pendiente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `contactos`
--

INSERT INTO `contactos` (`id`, `nombre`, `email`, `telefono`, `motivo`, `mensaje`, `privacidad`, `fecha_creacion`, `estado`) VALUES
(1, 'Usuario Ejemplo', 'ejemplo@email.com', '0991234567', 'informacion', 'Me gustaría obtener más información sobre los servicios de entrenamiento.', 1, '2025-08-29 11:57:18', 'pendiente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitudes_entrenadores`
--

CREATE TABLE `solicitudes_entrenadores` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `motivo` enum('informacion','soporte','entrenadores','otros') NOT NULL,
  `mensaje` text NOT NULL,
  `fecha_solicitud` datetime NOT NULL DEFAULT current_timestamp(),
  `estado` enum('pendiente','respondido','archivado') DEFAULT 'pendiente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `solicitudes_entrenadores`
--

INSERT INTO `solicitudes_entrenadores` (`id`, `nombre`, `email`, `telefono`, `motivo`, `mensaje`, `fecha_solicitud`, `estado`) VALUES
(1, 'Deportista Ejemplo', 'deportista@email.com', '0976543210', 'entrenadores', 'Quisiera contactar a un entrenador de fitness para comenzar mi entrenamiento', '2025-08-29 11:57:18', 'pendiente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitudes_info`
--

CREATE TABLE `solicitudes_info` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `servicio` varchar(100) NOT NULL,
  `plan` varchar(50) DEFAULT NULL,
  `mensaje` text DEFAULT NULL,
  `fecha_solicitud` datetime NOT NULL DEFAULT current_timestamp(),
  `estado` enum('pendiente','respondido','archivado') DEFAULT 'pendiente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `solicitudes_info`
--

INSERT INTO `solicitudes_info` (`id`, `nombre`, `email`, `telefono`, `servicio`, `plan`, `mensaje`, `fecha_solicitud`, `estado`) VALUES
(1, 'Cliente Ejemplo', 'cliente@email.com', '0987654321', 'Entrenamiento Personal', 'Plan Estándar', 'Interesado en el plan estándar de entrenamiento personal', '2025-08-29 11:57:18', 'pendiente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitudes_planes`
--

CREATE TABLE `solicitudes_planes` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `motivo` enum('informacion','soporte','entrenadores','otros') NOT NULL,
  `mensaje` text NOT NULL,
  `fecha_solicitud` datetime NOT NULL DEFAULT current_timestamp(),
  `estado` enum('pendiente','respondido','archivado') DEFAULT 'pendiente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `solicitudes_planes`
--

INSERT INTO `solicitudes_planes` (`id`, `nombre`, `email`, `telefono`, `motivo`, `mensaje`, `fecha_solicitud`, `estado`) VALUES
(1, 'Interesado Plan', 'plan@email.com', '0965432109', 'informacion', 'Necesito información detallada sobre los planes de entrenamiento disponibles', '2025-08-29 11:57:18', 'pendiente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitudes_servicios`
--

CREATE TABLE `solicitudes_servicios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `motivo` enum('informacion','soporte','entrenadores','otros') NOT NULL,
  `mensaje` text NOT NULL,
  `fecha_solicitud` datetime NOT NULL DEFAULT current_timestamp(),
  `estado` enum('pendiente','respondido','archivado') DEFAULT 'pendiente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `solicitudes_servicios`
--

INSERT INTO `solicitudes_servicios` (`id`, `nombre`, `email`, `telefono`, `motivo`, `mensaje`, `fecha_solicitud`, `estado`) VALUES
(1, 'Cliente Servicio', 'servicio@email.com', '0954321098', 'informacion', 'Me interesa conocer más sobre los servicios de entrenamiento deportivo', '2025-08-29 11:57:18', 'pendiente');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `contactos`
--
ALTER TABLE `contactos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_email` (`email`),
  ADD KEY `idx_motivo` (`motivo`),
  ADD KEY `idx_fecha` (`fecha_creacion`);

--
-- Indices de la tabla `solicitudes_entrenadores`
--
ALTER TABLE `solicitudes_entrenadores`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_email` (`email`),
  ADD KEY `idx_motivo` (`motivo`),
  ADD KEY `idx_fecha` (`fecha_solicitud`);

--
-- Indices de la tabla `solicitudes_info`
--
ALTER TABLE `solicitudes_info`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_email` (`email`),
  ADD KEY `idx_servicio` (`servicio`),
  ADD KEY `idx_fecha` (`fecha_solicitud`);

--
-- Indices de la tabla `solicitudes_planes`
--
ALTER TABLE `solicitudes_planes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_email` (`email`),
  ADD KEY `idx_motivo` (`motivo`),
  ADD KEY `idx_fecha` (`fecha_solicitud`);

--
-- Indices de la tabla `solicitudes_servicios`
--
ALTER TABLE `solicitudes_servicios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_email` (`email`),
  ADD KEY `idx_motivo` (`motivo`),
  ADD KEY `idx_fecha` (`fecha_solicitud`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `contactos`
--
ALTER TABLE `contactos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `solicitudes_entrenadores`
--
ALTER TABLE `solicitudes_entrenadores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `solicitudes_info`
--
ALTER TABLE `solicitudes_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `solicitudes_planes`
--
ALTER TABLE `solicitudes_planes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `solicitudes_servicios`
--
ALTER TABLE `solicitudes_servicios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
