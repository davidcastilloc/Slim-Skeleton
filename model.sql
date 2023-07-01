-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 01-07-2023 a las 18:51:14
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `db_asonap`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `certificacion`
--

CREATE TABLE `certificacion` (
  `id` varchar(36) NOT NULL DEFAULT uuid(),
  `documento_identidad` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `cod_asistente` varchar(12) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `nombre_completo` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `tipo_participacion` varchar(15) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `evento_id` int(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `certificacion`
--

INSERT INTO `certificacion` (`id`, `documento_identidad`, `cod_asistente`, `nombre_completo`, `tipo_participacion`, `timestamp`, `evento_id`) VALUES
('c6c2db5f-177a-11ee-b7ac-902e1caec5c1', '24980047', '2123123', 'David Jose Castillo Cirilo', 'Asistente', '2023-06-30 19:17:27', 1),
('fd6628ff-177a-11ee-b7ac-902e1caec5c1', '123456', 'gg1235', 'Jose Salomon Castillo Mata', 'Asistente', '2023-06-30 19:18:59', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evento`
--

CREATE TABLE `evento` (
  `id` int(12) NOT NULL,
  `nombre` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `fecha` date NOT NULL,
  `lugar` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `asistencia_requerida` tinyint(1) NOT NULL DEFAULT 0,
  `plantilla_certificado` varchar(36) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `evento`
--

INSERT INTO `evento` (`id`, `nombre`, `fecha`, `lugar`, `asistencia_requerida`, `plantilla_certificado`) VALUES
(1, '5 Convencion de x o y', '2023-06-14', 'Medellin', 1, 'certificado.jpg');

-- --------------------------------------------------------

-- Índices para tablas volcadas
--

--
-- Indices de la tabla `certificacion`
--
ALTER TABLE `certificacion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `evento_id` (`evento_id`);

--
-- Indices de la tabla `evento`
--
ALTER TABLE `evento`
  ADD PRIMARY KEY (`id`) USING BTREE;


--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `evento`
--
ALTER TABLE `evento`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `certificacion`
--
ALTER TABLE `certificacion`
  ADD CONSTRAINT `certificacion_ibfk_1` FOREIGN KEY (`evento_id`) REFERENCES `evento` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
