-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 19-05-2023 a las 16:47:38
-- Versión del servidor: 10.4.21-MariaDB
-- Versión de PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `classcheck`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `apellido` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `admins`
--

INSERT INTO `admins` (`id`, `nombre`, `apellido`, `email`, `password`, `created_at`, `updated_at`) VALUES
(4, 'Administrador', 'Test', 'administrador@gmail.com', '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', '2023-04-20 07:52:03', '2023-04-20 07:52:03');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumnos`
--

CREATE TABLE `alumnos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `apellido` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_padre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1,
  `id_curso` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `alumnos`
--

INSERT INTO `alumnos` (`id`, `nombre`, `apellido`, `email`, `token`, `password`, `email_padre`, `estado`, `id_curso`, `created_at`, `updated_at`) VALUES
(17, 'Dan', 'García', 'contreras.garcia.dani@gmail.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre@gmail.com', 1, 1, '2023-04-20 07:35:32', '2023-05-19 11:57:20'),
(19, 'Andrea', 'Gómez', 'andrea.gomez@daw2.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.andrea@daw2.com', 1, 1, NULL, NULL),
(20, 'Carlos', 'Martínez', 'carlos.martinez@daw2.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.carlos@daw2.com', 1, 1, NULL, NULL),
(21, 'María', 'García', 'maria.garcia@daw2.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.maria@daw2.com', 1, 1, NULL, NULL),
(22, 'Juan', 'Pérez', 'juan.perez@daw2.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.juan@daw2.com', 1, 1, NULL, NULL),
(23, 'Lucía', 'Fernández', 'lucia.fernandez@daw2.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.lucia@daw2.com', 1, 1, NULL, NULL),
(24, 'Hugo', 'Alonso', 'hugo.alonso@daw2.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.hugo@daw2.com', 1, 1, NULL, NULL),
(25, 'Sofía', 'Sánchez', 'sofia.sanchez@daw2.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.sofia@daw2.com', 1, 1, NULL, NULL),
(26, 'Adrián', 'García', 'adrian.garcia@daw2.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.adrian@daw2.com', 1, 1, NULL, NULL),
(27, 'Laura', 'Jiménez', 'laura.jimenez@daw2.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.laura@daw2.com', 1, 1, NULL, NULL),
(28, 'Javier', 'Rodríguez', 'javier.rodriguez@daw2.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.javier@daw2.com', 1, 1, NULL, NULL),
(29, 'Isabel', 'Pardo', 'isabel.pardo@daw2.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.isabel@daw2.com', 1, 1, NULL, NULL),
(30, 'Gonzalo', 'Ortiz', 'gonzalo.ortiz@daw2.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.gonzalo@daw2.com', 1, 1, NULL, NULL),
(31, 'Marina', 'Vega', 'marina.vega@daw2.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.marina@daw2.com', 1, 1, NULL, NULL),
(32, 'Diego', 'Ruiz', 'diego.ruiz@daw2.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.diego@daw2.com', 1, 1, NULL, NULL),
(33, 'Alba', 'García', 'alba.garcia@daw2.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.alba@daw2.com', 1, 1, NULL, NULL),
(34, 'Sergio', 'Santos', 'sergio.santos@asix2.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.sergio@asix2.com', 1, 2, NULL, NULL),
(35, 'Ana', 'López', 'ana.lopez@asix2.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.ana@asix2.com', 1, 2, NULL, NULL),
(36, 'David', 'González', 'david.gonzalez@asix2.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.david@asix2.com', 1, 2, NULL, NULL),
(37, 'Nerea', 'Fernández', 'nerea.fernandez@asix2.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.nerea@asix2.com', 1, 2, NULL, NULL),
(38, 'Lucas', 'García', 'lucas.garcia@asix2.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.lucas@asix2.com', 1, 2, NULL, NULL),
(39, 'Lucía', 'Pérez', 'lucia.perez@asix2.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.lucia@asix2.com', 1, 2, NULL, NULL),
(40, 'Iván', 'Martínez', 'ivan.martinez@asix2.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.ivan@asix2.com', 1, 2, NULL, NULL),
(41, 'Sara', 'Hernández', 'sara.hernandez@asix2.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.sara@asix2.com', 1, 2, NULL, NULL),
(42, 'Hugo', 'García', 'hugo.garcia@asix2.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.hugo@asix2.com', 1, 2, NULL, NULL),
(43, 'Elena', 'Moreno', 'elena.moreno@asix2.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.elena@asix2.com', 1, 2, NULL, NULL),
(44, 'Javier', 'Sánchez', 'javier.sanchez@asix2.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.javier@asix2.com', 1, 2, NULL, NULL),
(45, 'Marta', 'Martínez', 'marta.martinez@asix2.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.marta@asix2.com', 1, 2, NULL, NULL),
(46, 'Carlos', 'Pérez', 'carlos.perez@asix2.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.carlos@asix2.com', 1, 2, NULL, NULL),
(47, 'Laura', 'López', 'laura.lopez@asix2.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.laura@asix2.com', 1, 2, NULL, NULL),
(48, 'Sofía', 'García', 'sofia.garcia@asix2.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.sofia@asix2.com', 1, 2, NULL, NULL),
(49, 'Daniel', 'Martínez', 'daniel.martinez@asix2.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.daniel@asix2.com', 1, 2, NULL, NULL),
(50, 'Adrián', 'García', 'adrian.garcia@smx1.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.adrian@smx1.com', 1, 9, NULL, NULL),
(51, 'María', 'García', 'maria.garcia@smx1.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.maria@smx1.com', 1, 9, NULL, NULL),
(52, 'Lucía', 'González', 'lucia.gonzalez@smx1.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.lucia@smx1.com', 1, 9, NULL, NULL),
(53, 'Sara', 'Hernández', 'sara.hernandez@smx1.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.sara@smx1.com', 1, 9, NULL, NULL),
(54, 'Manuel', 'Martínez', 'manuel.martinez@smx1.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.manuel@smx1.com', 1, 9, NULL, NULL),
(55, 'Isabel', 'García', 'isabel.garcia@smx1.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.isabel@smx1.com', 1, 9, NULL, NULL),
(56, 'Hugo', 'López', 'hugo.lopez@smx1.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.hugo@smx1.com', 1, 9, NULL, NULL),
(57, 'Natalia', 'Fernández', 'natalia.fernandez@smx1.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.natalia@smx1.com', 1, 9, NULL, NULL),
(58, 'Marcos', 'Sánchez', 'marcos.sanchez@smx1.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.marcos@smx1.com', 1, 9, NULL, NULL),
(59, 'Lucas', 'Pérez', 'lucas.perez@smx1.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.lucas@smx1.com', 1, 9, NULL, NULL),
(60, 'Laura', 'González', 'laura.gonzalez@smx1.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.laura@smx1.com', 1, 9, NULL, NULL),
(61, 'Alicia', 'Martínez', 'alicia.martinez@smx1.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.alicia@smx1.com', 1, 9, NULL, NULL),
(62, 'Diego', 'García', 'diego.garcia@smx1.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.diego@smx1.com', 1, 9, NULL, NULL),
(63, 'Carlos', 'Martín', 'carlos.martin@smx2.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.carlos@smx2.com', 1, 10, NULL, NULL),
(64, 'Andrea', 'García', 'andrea.garcia@smx2.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.andrea@smx2.com', 1, 10, NULL, NULL),
(65, 'Sara', 'García', 'sara.garcia@smx2.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.sara@smx2.com', 1, 10, NULL, NULL),
(66, 'Marta', 'Rodríguez', 'marta.rodriguez@smx2.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.marta@smx2.com', 1, 10, NULL, NULL),
(67, 'Lucía', 'López', 'lucia.lopez@smx2.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.lucia@smx2.com', 1, 10, NULL, NULL),
(68, 'Hugo', 'González', 'hugo.gonzalez@smx2.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.hugo@smx2.com', 1, 10, NULL, NULL),
(69, 'Natalia', 'Sánchez', 'natalia.sanchez@smx2.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.natalia@smx2.com', 1, 10, NULL, NULL),
(70, 'Iván', 'Pérez', 'ivan.perez@smx2.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.ivan@smx2.com', 1, 10, NULL, NULL),
(71, 'María', 'González', 'maria.gonzalez@smx2.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.maria@smx2.com', 1, 10, NULL, NULL),
(72, 'David', 'Fernández', 'david.fernandez@smx2.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.david@smx2.com', 1, 10, NULL, NULL),
(73, 'Sofía', 'Hernández', 'sofia.hernandez@smx2.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.sofia@smx2.com', 1, 10, NULL, NULL),
(74, 'Javier', 'Martínez', 'javier.martinez@smx2.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.javier@smx2.com', 1, 10, NULL, NULL),
(75, 'Lucas', 'García', 'lucas.garcia@smx2.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.lucas@smx2.com', 1, 10, NULL, NULL),
(76, 'Elena', 'Moreno', 'elena.moreno@smx2.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.elena@smx2.com', 1, 10, NULL, NULL),
(77, 'Laura', 'García', 'laura.garcia@smx2.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.laura@smx2.com', 1, 10, NULL, NULL),
(78, 'Marc', 'González', 'marc.gonzalez@asix1.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.marc@asix1.com', 1, 11, NULL, NULL),
(79, 'Aitana', 'Hernández', 'aitana.hernandez@asix1.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.aitana@asix1.com', 1, 11, NULL, NULL),
(80, 'Jorge', 'García', 'jorge.garcia@asix1.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.jorge@asix1.com', 1, 11, NULL, NULL),
(81, 'Irene', 'Martínez', 'irene.martinez@asix1.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.irene@asix1.com', 1, 11, NULL, NULL),
(82, 'Pau', 'Sánchez', 'pau.sanchez@asix1.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.pau@asix1.com', 1, 11, NULL, NULL),
(83, 'Laia', 'García', 'laia.garcia@asix1.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.laia@asix1.com', 1, 11, NULL, NULL),
(84, 'Pol', 'Martínez', 'pol.martinez@asix1.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.pol@asix1.com', 1, 11, NULL, NULL),
(85, 'Júlia', 'López', 'julia.lopez@asix1.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.julia@asix1.com', 1, 11, NULL, NULL),
(86, 'Eric', 'Fernández', 'eric.fernandez@asix1.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.eric@asix1.com', 1, 11, NULL, NULL),
(87, 'Emma', 'García', 'emma.garcia@asix1.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.emma@asix1.com', 1, 11, NULL, NULL),
(88, 'Javier', 'García', 'javier.garcia@eso1.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.javier@eso1.com', 1, 12, NULL, NULL),
(89, 'Lucía', 'Fernández', 'lucia.fernandez@eso1.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.lucia@eso1.com', 1, 12, NULL, NULL),
(90, 'Carlos', 'Martínez', 'carlos.martinez@eso1.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.carlos@eso1.com', 1, 12, NULL, NULL),
(91, 'Sofía', 'López', 'sofia.lopez@eso1.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.sofia@eso1.com', 1, 12, NULL, NULL),
(92, 'Eva', 'González', 'eva.gonzalez@eso1.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.eva@eso1.com', 1, 12, NULL, NULL),
(93, 'Hugo', 'Sánchez', 'hugo.sanchez@eso1.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.hugo@eso1.com', 1, 12, NULL, NULL),
(94, 'Marta', 'Hernández', 'marta.hernandez@eso1.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.marta@eso1.com', 1, 12, NULL, NULL),
(95, 'Pablo', 'García', 'pablo.garcia@eso1.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.pablo@eso1.com', 1, 12, NULL, NULL),
(96, 'Marina', 'Fernández', 'marina.fernandez@eso1.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.marina@eso1.com', 1, 12, NULL, NULL),
(97, 'Marcos', 'López', 'marcos.lopez@eso1.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.marcos@eso1.com', 1, 12, NULL, NULL),
(98, 'Ariadna', 'González', 'ariadna.gonzalez@eso1.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.ariadna@eso1.com', 1, 12, NULL, NULL),
(99, 'Jordi', 'Sánchez', 'jordi.sanchez@eso1.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.jordi@eso1.com', 1, 12, NULL, NULL),
(100, 'Mireia', 'Martínez', 'mireia.martinez@eso1.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.mireia@eso1.com', 1, 12, NULL, NULL),
(101, 'Alejandro', 'Hernández', 'alejandro.hernandez@eso1.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.alejandro@eso1.com', 1, 12, NULL, NULL),
(102, 'Mar', 'García', 'mar.garcia@eso1.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.mar@eso1.com', 1, 12, NULL, NULL),
(103, 'Judit', 'Fernández', 'judit.fernandez@eso1.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.judit@eso1.com', 1, 12, NULL, NULL),
(104, 'Juan', 'González', 'juan.gonzalez@eso1.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.juan@eso1.com', 1, 12, NULL, NULL),
(105, 'Laura', 'Sánchez', 'laura.sanchez@eso1.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.laura@eso1.com', 1, 12, NULL, NULL),
(106, 'Iker', 'Martínez', 'iker.martinez@eso2.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.iker@eso2.com', 1, 13, NULL, NULL),
(107, 'Alba', 'López', 'alba.lopez@eso2.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.alba@eso2.com', 1, 13, NULL, NULL),
(108, 'Rubén', 'García', 'ruben.garcia@eso2.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.ruben@eso2.com', 1, 13, NULL, NULL),
(109, 'Nora', 'Martínez', 'nora.martinez@eso2.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.nora@eso2.com', 1, 13, NULL, NULL),
(110, 'Guillem', 'Fernández', 'guillem.fernandez@eso2.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.guillem@eso2.com', 1, 13, NULL, NULL),
(111, 'Biel', 'González', 'biel.gonzalez@eso2.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.biel@eso2.com', 1, 13, NULL, NULL),
(112, 'Aina', 'Sánchez', 'aina.sanchez@eso2.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.aina@eso2.com', 1, 13, NULL, NULL),
(113, 'Joan', 'Hernández', 'joan.hernandez@eso2.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.joan@eso2.com', 1, 13, NULL, NULL),
(114, 'Abril', 'López', 'abril.lopez@eso2.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.abril@eso2.com', 1, 13, NULL, NULL),
(115, 'Oliver', 'García', 'oliver.garcia@eso3.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.oliver@eso3.com', 1, 14, NULL, NULL),
(116, 'Emma', 'Martínez', 'emma.martinez@eso3.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.emma@eso3.com', 1, 14, NULL, NULL),
(117, 'Eric', 'Sánchez', 'eric.sanchez@eso3.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.eric@eso3.com', 1, 14, NULL, NULL),
(118, 'Izan', 'Fernández', 'izan.fernandez@eso3.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.izan@eso3.com', 1, 14, NULL, NULL),
(119, 'Clara', 'López', 'clara.lopez@eso3.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.clara@eso3.com', 1, 14, NULL, NULL),
(120, 'Laia', 'Hernández', 'laia.hernandez@eso3.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.laia@eso3.com', 1, 14, NULL, NULL),
(121, 'Martí', 'González', 'marti.gonzalez@eso3.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.marti@eso3.com', 1, 14, NULL, NULL),
(122, 'Jan', 'Sánchez', 'jan.sanchez@eso3.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.jan@eso3.com', 1, 14, NULL, NULL),
(123, 'Eva', 'Martínez', 'eva.martinez@eso3.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.eva@eso3.com', 1, 14, NULL, NULL),
(124, 'Nil', 'García', 'nil.garcia@eso3.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.nil@eso3.com', 1, 14, NULL, NULL),
(241, 'Marta', 'Martínez', 'marta.martinez@eso4.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.marta@eso4.com', 1, 15, NULL, NULL),
(242, 'Sergio', 'García', 'sergio.garcia@eso4.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.sergio@eso4.com', 1, 15, NULL, NULL),
(243, 'Lucía', 'López', 'lucia.lopez@eso4.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.lucia@eso4.com', 1, 15, NULL, NULL),
(244, 'Hugo', 'Fernández', 'hugo.fernandez@eso4.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.hugo@eso4.com', 1, 15, NULL, NULL),
(245, 'Celia', 'González', 'celia.gonzalez@eso4.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.celia@eso4.com', 1, 15, NULL, NULL),
(246, 'Marc', 'Hernández', 'marc.hernandez@eso4.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.marc@eso4.com', 1, 15, NULL, NULL),
(247, 'Laia', 'Sánchez', 'laia.sanchez@eso4.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.laia@eso4.com', 1, 15, NULL, NULL),
(248, 'Lucas', 'García', 'lucas.garcia@eso4.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.lucas@eso4.com', 1, 15, NULL, NULL),
(249, 'Mireia', 'Martínez', 'mireia.martinez@eso4.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.mireia@eso4.com', 1, 15, NULL, NULL),
(250, 'Bruno', 'Fernández', 'bruno.fernandez@eso4.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 'padre.bruno@eso4.com', 1, 15, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignaturas`
--

CREATE TABLE `asignaturas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_curso` bigint(20) UNSIGNED NOT NULL,
  `id_profesor` bigint(20) UNSIGNED NOT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_fin` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `asignaturas`
--

INSERT INTO `asignaturas` (`id`, `nombre`, `id_curso`, `id_profesor`, `fecha_inicio`, `fecha_fin`) VALUES
(124, 'Lengua y literatura castellana', 12, 23, '2022-09-12', '2023-06-23'),
(125, 'Matemáticas', 12, 24, '2022-09-12', '2023-06-23'),
(126, 'Ciencias naturales', 12, 25, '2022-09-12', '2023-06-23'),
(127, 'Ciencias sociales, geografía e historia', 12, 26, '2022-09-12', '2023-06-23'),
(128, 'Inglés', 12, 27, '2022-09-12', '2023-06-23'),
(129, 'Educación física', 12, 28, '2022-09-12', '2023-06-23'),
(130, 'Lengua y literatura castellana', 13, 23, '2022-09-12', '2023-06-23'),
(131, 'Matemáticas', 13, 24, '2022-09-12', '2023-06-23'),
(132, 'Ciencias naturales', 13, 25, '2022-09-12', '2023-06-23'),
(133, 'Ciencias sociales, geografía e historia', 13, 26, '2022-09-12', '2023-06-23'),
(134, 'Inglés', 13, 27, '2022-09-12', '2023-06-23'),
(135, 'Educación física', 13, 28, '2022-09-12', '2023-06-23'),
(136, 'Lengua y literatura castellana', 14, 23, '2022-09-12', '2023-06-23'),
(137, 'Matemáticas', 14, 24, '2022-09-12', '2023-06-23'),
(138, 'Ciencias naturales', 14, 25, '2022-09-12', '2023-06-23'),
(139, 'Ciencias sociales, geografía e historia', 14, 26, '2022-09-12', '2023-06-23'),
(140, 'Inglés', 14, 27, '2022-09-12', '2023-06-23'),
(141, 'Educación física', 14, 28, '2022-09-12', '2023-06-23'),
(142, 'Lengua y literatura castellana', 15, 23, '2022-09-12', '2023-06-23'),
(143, 'Matemáticas', 15, 24, '2022-09-12', '2023-06-23'),
(144, 'Ciencias naturales', 15, 25, '2022-09-12', '2023-06-23'),
(145, 'Ciencias sociales, geografía e historia', 15, 26, '2022-09-12', '2023-06-23'),
(146, 'Inglés', 15, 27, '2022-09-12', '2023-06-23'),
(147, 'Educación física', 15, 28, '2022-09-12', '2023-06-23'),
(148, 'Programación orientada a objetos UF1', 1, 5, '2022-09-12', '2023-12-20'),
(149, 'Programación orientada a objetos UF2', 1, 5, '2022-12-21', '2023-03-14'),
(150, 'Programación orientada a objetos UF3', 1, 5, '2022-03-15', '2023-06-23'),
(151, 'Bases de datos UF1', 1, 6, '2022-09-12', '2023-02-04'),
(152, 'Bases de datos UF2', 1, 6, '2023-02-05', '2023-06-23'),
(153, 'Bases de datos UF3', 1, 6, '2022-09-12', '2023-06-23'),
(154, 'Programación en entornos web UF1', 1, 7, '2022-09-12', '2023-12-20'),
(155, 'Programación en entornos web UF2', 1, 7, '2022-12-21', '2023-03-14'),
(156, 'Programación en entornos web UF3', 1, 7, '2022-03-15', '2023-06-23'),
(157, 'Sistemas informáticos UF1', 1, 8, '2022-09-12', '2023-12-20'),
(158, 'Sistemas informáticos UF2', 1, 8, '2022-12-21', '2023-03-14'),
(159, 'Sistemas informáticos UF3', 1, 8, '2022-03-15', '2023-06-23'),
(160, 'Programación móvil UF1', 1, 12, '2022-09-12', '2023-12-20'),
(161, 'Programación móvil UF2', 1, 12, '2022-12-21', '2023-03-14'),
(162, 'Programación móvil UF3', 1, 12, '2022-03-15', '2023-06-23'),
(163, 'Programación de videojuegos UF1', 1, 13, '2022-09-12', '2023-02-04'),
(164, 'Programación de videojuegos UF2', 1, 13, '2023-02-04', '2023-06-23'),
(165, 'Programación de videojuegos UF3', 1, 13, '2022-09-12', '2023-06-23'),
(166, 'Proyecto integrado UF1', 1, 14, '2022-09-12', '2022-12-20'),
(167, 'Proyecto integrado UF2', 1, 14, '2022-12-21', '2023-03-14'),
(168, 'Proyecto integrado UF3', 1, 14, '2022-03-15', '2023-06-23'),
(169, 'Empresa e iniciativa emprendedora UF1', 1, 15, '2022-09-12', '2022-12-20'),
(170, 'Empresa e iniciativa emprendedora UF2', 1, 15, '2022-12-21', '2023-03-14'),
(171, 'Empresa e iniciativa emprendedora UF3', 1, 15, '2022-03-15', '2023-06-23'),
(172, 'Administración de sistemas operativos UF1', 2, 9, '2022-09-12', '2023-12-20'),
(173, 'Administración de sistemas operativos UF2', 2, 9, '2022-12-21', '2023-03-14'),
(174, 'Administración de sistemas operativos UF3', 2, 9, '2022-03-15', '2023-06-23'),
(175, 'Gestión de bases de datos UF1', 2, 10, '2022-09-12', '2023-12-20'),
(176, 'Gestión de bases de datos UF2', 2, 10, '2022-12-21', '2023-03-14'),
(177, 'Gestión de bases de datos UF3', 2, 10, '2022-03-15', '2023-06-23'),
(178, 'Programación de scripts UF1', 2, 11, '2022-09-12', '2023-12-20'),
(179, 'Programación de scripts UF2', 2, 11, '2022-12-21', '2023-03-14'),
(180, 'Programación de scripts UF3', 2, 11, '2022-03-15', '2023-06-23'),
(181, 'Servicios de red e Internet UF1', 2, 12, '2022-09-12', '2023-12-20'),
(182, 'Servicios de red e Internet UF2', 2, 12, '2022-12-21', '2023-03-14'),
(183, 'Servicios de red e Internet UF3', 2, 12, '2022-03-15', '2023-06-23'),
(184, 'Implantación de aplicaciones web UF1', 2, 13, '2022-09-12', '2023-06-23'),
(185, 'Implantación de aplicaciones web UF2', 2, 13, '2022-09-12', '2023-02-04'),
(186, 'Implantación de aplicaciones web UF3', 2, 13, '2023-02-05', '2023-06-23'),
(187, 'Administración de sistemas gestores de bases de datos UF1', 2, 14, '2022-09-12', '2023-12-20'),
(188, 'Administración de sistemas gestores de bases de datos UF2', 2, 14, '2022-12-21', '2023-03-14'),
(189, 'Administración de sistemas gestores de bases de datos UF3', 2, 14, '2022-03-15', '2023-06-23'),
(190, 'Seguridad informática UF1', 2, 15, '2022-09-12', '2023-12-20'),
(191, 'Seguridad informática UF2', 2, 15, '2022-12-21', '2023-03-14'),
(192, 'Seguridad informática UF3', 2, 15, '2022-03-15', '2023-06-23'),
(193, 'Sistemas operativos monopuesto UF1', 9, 16, '2022-09-12', '2023-12-20'),
(194, 'Sistemas operativos monopuesto UF2', 9, 16, '2022-12-21', '2023-03-14'),
(195, 'Sistemas operativos monopuesto UF3', 9, 16, '2022-03-15', '2023-06-23'),
(196, 'Redes locales UF1', 9, 17, '2022-09-12', '2023-12-20'),
(197, 'Redes locales UF2', 9, 17, '2022-12-21', '2023-03-14'),
(198, 'Redes locales UF3', 9, 17, '2022-03-15', '2023-06-23'),
(199, 'Aplicaciones ofimáticas UF1', 9, 18, '2022-09-12', '2023-02-04'),
(200, 'Aplicaciones ofimáticas UF2', 9, 18, '2023-02-05', '2023-06-23'),
(201, 'Aplicaciones ofimáticas UF3', 9, 18, '2022-09-12', '2023-06-23'),
(202, 'Montaje y mantenimiento de sistemas microinformáticos UF1', 9, 19, '2022-09-12', '2023-12-20'),
(203, 'Montaje y mantenimiento de sistemas microinformáticos UF2', 9, 19, '2022-12-21', '2023-03-14'),
(204, 'Montaje y mantenimiento de sistemas microinformáticos UF3', 9, 19, '2022-03-15', '2023-06-23'),
(205, 'Sistemas operativos en red UF1', 9, 20, '2022-09-12', '2023-02-04'),
(206, 'Sistemas operativos en red UF2', 9, 20, '2023-02-05', '2023-06-23'),
(207, 'Sistemas operativos en red UF3', 9, 20, '2022-09-12', '2023-06-23'),
(208, 'Implantación de aplicaciones web UF1', 9, 21, '2022-09-12', '2023-12-20'),
(209, 'Implantación de aplicaciones web UF2', 9, 21, '2022-12-21', '2023-03-14'),
(210, 'Implantación de aplicaciones web UF3', 9, 21, '2022-03-15', '2023-06-23'),
(211, 'Sistemas operativos en red UF1', 10, 17, '2022-09-12', '2023-06-23'),
(212, 'Sistemas operativos en red UF2', 10, 17, '2022-09-12', '2023-02-04'),
(213, 'Sistemas operativos en red UF3', 10, 17, '2023-02-05', '2023-06-23'),
(214, 'Seguridad y alta disponibilidad UF1', 10, 18, '2022-09-12', '2023-12-20'),
(215, 'Seguridad y alta disponibilidad UF2', 10, 18, '2022-12-21', '2023-03-14'),
(216, 'Seguridad y alta disponibilidad UF3', 10, 18, '2022-03-15', '2023-06-23'),
(217, 'Servicios de red e Internet UF1', 10, 19, '2022-09-12', '2023-12-20'),
(218, 'Servicios de red e Internet UF2', 10, 19, '2022-12-21', '2023-03-14'),
(219, 'Servicios de red e Internet UF3', 10, 19, '2022-03-15', '2023-06-23'),
(220, 'Administración de sistemas gestores de bases de datos UF1', 10, 20, '2022-09-12', '2023-12-20'),
(221, 'Administración de sistemas gestores de bases de datos UF2', 10, 20, '2022-12-21', '2023-03-14'),
(222, 'Administración de sistemas gestores de bases de datos UF3', 10, 20, '2022-03-15', '2023-06-23'),
(223, 'Administración de sistemas UF1', 10, 21, '2022-09-12', '2023-02-04'),
(224, 'Administración de sistemas UF2', 10, 21, '2023-02-05', '2023-06-23'),
(225, 'Administración de sistemas UF3', 10, 21, '2022-09-12', '2023-06-23'),
(226, 'Implantación de sistemas operativos UF1', 10, 22, '2022-09-12', '2023-12-20'),
(227, 'Implantación de sistemas operativos UF2', 10, 22, '2022-12-21', '2023-03-14'),
(228, 'Implantación de sistemas operativos UF3', 10, 22, '2022-03-15', '2023-06-23'),
(229, 'Administración de sistemas operativos UF1', 11, 9, '2022-09-12', '2023-12-20'),
(230, 'Administración de sistemas operativos UF2', 11, 9, '2022-12-21', '2023-03-14'),
(231, 'Administración de sistemas operativos UF3', 11, 9, '2022-03-15', '2023-06-23'),
(232, 'Gestión de bases de datos UF1', 11, 10, '2022-09-12', '2023-12-20'),
(233, 'Gestión de bases de datos UF2', 11, 10, '2022-12-21', '2023-03-14'),
(234, 'Gestión de bases de datos UF3', 11, 10, '2022-03-15', '2023-06-23'),
(235, 'Programación de scripts UF1', 11, 11, '2022-09-12', '2023-06-23'),
(236, 'Programación de scripts UF2', 11, 11, '2022-09-12', '2023-02-04'),
(237, 'Programación de scripts UF3', 11, 11, '2023-02-05', '2023-06-23'),
(238, 'Servicios de red e Internet UF1', 11, 12, '2022-09-12', '2023-12-20'),
(239, 'Servicios de red e Internet UF2', 11, 12, '2022-12-21', '2023-03-14'),
(240, 'Servicios de red e Internet UF3', 11, 12, '2022-03-15', '2023-06-23'),
(241, 'Implantación de aplicaciones web UF1', 11, 13, '2022-09-12', '2023-12-20'),
(242, 'Implantación de aplicaciones web UF2', 11, 13, '2022-12-21', '2023-03-14'),
(243, 'Implantación de aplicaciones web UF3', 11, 13, '2022-03-15', '2023-06-23'),
(244, 'Administración de sistemas gestores de bases de datos UF1', 11, 14, '2022-09-12', '2022-12-20'),
(245, 'Administración de sistemas gestores de bases de datos UF2', 11, 14, '2022-12-21', '2023-03-14'),
(246, 'Administración de sistemas gestores de bases de datos UF3', 11, 14, '2023-03-15', '2023-06-23'),
(247, 'Seguridad informática UF1', 11, 15, '2022-09-12', '2022-12-20'),
(248, 'Seguridad informática UF2', 11, 15, '2022-12-21', '2023-03-14'),
(249, 'Seguridad informática UF3', 11, 15, '2023-03-15', '2023-06-23');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asistencias`
--

CREATE TABLE `asistencias` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_alumno_asistencia` bigint(20) UNSIGNED NOT NULL,
  `id_profe_asistencia` bigint(20) UNSIGNED NOT NULL,
  `id_horarioasignatura_asistencia` bigint(20) UNSIGNED NOT NULL,
  `id_tipo_asistencia` bigint(20) UNSIGNED NOT NULL,
  `fecha_asistencia` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `asistencias`
--

INSERT INTO `asistencias` (`id`, `id_alumno_asistencia`, `id_profe_asistencia`, `id_horarioasignatura_asistencia`, `id_tipo_asistencia`, `fecha_asistencia`) VALUES
(3, 17, 14, 8194, 2, '2023-05-10'),
(4, 17, 14, 8194, 2, '2023-05-10'),
(5, 19, 14, 8194, 2, '2023-05-15');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cursos`
--

CREATE TABLE `cursos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `promocion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_escuela` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `cursos`
--

INSERT INTO `cursos` (`id`, `nombre`, `promocion`, `id_escuela`) VALUES
(1, 'DAW2', '22-23', 1),
(2, 'ASIX2', '22-23', 1),
(9, 'SMX1', '22-23', 1),
(10, 'SMX2', '22-23', 1),
(11, 'ASIX1', '22-23', 1),
(12, 'ESO1', '22-23', 1),
(13, 'ESO2', '22-23', 1),
(14, 'ESO3', '22-23', 1),
(15, 'ESO4', '22-23', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `escuelas`
--

CREATE TABLE `escuelas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `escuelas`
--

INSERT INTO `escuelas` (`id`, `nombre`) VALUES
(1, 'Joan 23');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horarios`
--

CREATE TABLE `horarios` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `dia` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hora_inicio` time NOT NULL,
  `hora_fin` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `horarios`
--

INSERT INTO `horarios` (`id`, `dia`, `hora_inicio`, `hora_fin`) VALUES
(2, 'Lunes', '08:00:00', '08:55:00'),
(3, 'Lunes', '08:55:00', '09:50:00'),
(4, 'Lunes', '09:50:00', '10:45:00'),
(5, 'Lunes', '11:15:00', '12:10:00'),
(6, 'Lunes', '12:10:00', '13:05:00'),
(7, 'Lunes', '13:05:00', '14:00:00'),
(8, 'Lunes', '15:00:00', '15:55:00'),
(9, 'Lunes', '15:55:00', '16:50:00'),
(10, 'Lunes', '16:50:00', '17:45:00'),
(11, 'Lunes', '17:45:00', '18:40:00'),
(12, 'Lunes', '19:10:00', '20:05:00'),
(13, 'Lunes', '20:05:00', '21:00:00'),
(14, 'Martes', '08:00:00', '08:55:00'),
(15, 'Martes', '08:55:00', '09:50:00'),
(16, 'Martes', '09:50:00', '10:45:00'),
(17, 'Martes', '11:15:00', '12:10:00'),
(18, 'Martes', '12:10:00', '13:05:00'),
(19, 'Martes', '13:05:00', '14:00:00'),
(20, 'Martes', '15:00:00', '15:55:00'),
(21, 'Martes', '15:55:00', '16:50:00'),
(22, 'Martes', '16:50:00', '17:45:00'),
(23, 'Martes', '17:45:00', '18:40:00'),
(24, 'Martes', '19:10:00', '20:05:00'),
(25, 'Martes', '20:05:00', '21:00:00'),
(26, 'Miércoles', '08:00:00', '08:55:00'),
(27, 'Miércoles', '08:55:00', '09:50:00'),
(28, 'Miércoles', '09:50:00', '10:45:00'),
(29, 'Miércoles', '11:15:00', '12:10:00'),
(30, 'Miércoles', '12:10:00', '13:05:00'),
(31, 'Miércoles', '13:05:00', '14:00:00'),
(32, 'Miércoles', '15:00:00', '15:55:00'),
(33, 'Miércoles', '15:55:00', '16:50:00'),
(34, 'Miércoles', '16:50:00', '17:45:00'),
(35, 'Miércoles', '17:45:00', '18:40:00'),
(36, 'Miércoles', '19:10:00', '20:05:00'),
(37, 'Miércoles', '20:05:00', '21:00:00'),
(38, 'Jueves', '08:00:00', '08:55:00'),
(39, 'Jueves', '08:55:00', '09:50:00'),
(40, 'Jueves', '09:50:00', '10:45:00'),
(41, 'Jueves', '11:15:00', '12:10:00'),
(42, 'Jueves', '12:10:00', '13:05:00'),
(43, 'Jueves', '13:05:00', '14:00:00'),
(44, 'Jueves', '15:00:00', '15:55:00'),
(45, 'Jueves', '15:55:00', '16:50:00'),
(46, 'Jueves', '16:50:00', '17:45:00'),
(47, 'Jueves', '17:45:00', '18:40:00'),
(48, 'Jueves', '19:10:00', '20:05:00'),
(49, 'Jueves', '20:05:00', '21:00:00'),
(50, 'Viernes', '08:00:00', '08:55:00'),
(51, 'Viernes', '08:55:00', '09:50:00'),
(52, 'Viernes', '09:50:00', '10:45:00'),
(53, 'Viernes', '11:15:00', '12:10:00'),
(54, 'Viernes', '12:10:00', '13:05:00'),
(55, 'Viernes', '13:05:00', '14:00:00'),
(56, 'Viernes', '15:00:00', '15:55:00'),
(57, 'Viernes', '15:55:00', '16:50:00'),
(58, 'Viernes', '16:50:00', '17:45:00'),
(59, 'Viernes', '17:45:00', '18:40:00'),
(60, 'Viernes', '19:10:00', '20:05:00'),
(61, 'Viernes', '20:05:00', '21:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horario_asignaturas`
--

CREATE TABLE `horario_asignaturas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_asignatura_int` bigint(20) UNSIGNED NOT NULL,
  `id_horario_int` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `horario_asignaturas`
--

INSERT INTO `horario_asignaturas` (`id`, `id_asignatura_int`, `id_horario_int`) VALUES
(8194, 124, 2),
(8195, 124, 3),
(8196, 127, 4),
(8197, 127, 5),
(8198, 127, 6),
(8199, 129, 7),
(8200, 128, 14),
(8201, 128, 15),
(8202, 125, 16),
(8203, 126, 17),
(8204, 126, 18),
(8205, 125, 19),
(8206, 129, 26),
(8207, 124, 27),
(8208, 124, 28),
(8209, 127, 29),
(8210, 129, 30),
(8211, 127, 31),
(8212, 126, 38),
(8213, 126, 39),
(8214, 125, 40),
(8215, 125, 41),
(8216, 129, 42),
(8217, 124, 43),
(8218, 124, 50),
(8219, 127, 51),
(8220, 127, 52),
(8221, 128, 53),
(8222, 124, 54),
(8223, 124, 55),
(8224, 131, 2),
(8225, 131, 3),
(8226, 134, 4),
(8227, 134, 5),
(8228, 130, 6),
(8229, 130, 7),
(8230, 130, 14),
(8231, 130, 15),
(8232, 133, 16),
(8233, 133, 17),
(8234, 131, 18),
(8235, 133, 19),
(8236, 134, 26),
(8237, 132, 27),
(8238, 132, 28),
(8239, 135, 29),
(8240, 134, 30),
(8241, 135, 31),
(8242, 130, 38),
(8243, 130, 39),
(8244, 132, 40),
(8245, 132, 41),
(8246, 133, 42),
(8247, 132, 43),
(8248, 131, 50),
(8249, 131, 51),
(8250, 130, 52),
(8251, 130, 53),
(8252, 133, 54),
(8253, 135, 55),
(8254, 140, 2),
(8255, 140, 3),
(8256, 138, 4),
(8257, 138, 5),
(8258, 141, 6),
(8259, 137, 14),
(8260, 137, 15),
(8261, 136, 16),
(8262, 140, 17),
(8263, 136, 18),
(8264, 138, 26),
(8265, 137, 27),
(8266, 137, 28),
(8267, 140, 29),
(8268, 141, 30),
(8269, 140, 38),
(8270, 140, 39),
(8271, 141, 40),
(8272, 141, 41),
(8273, 138, 42),
(8274, 139, 43),
(8275, 138, 50),
(8276, 138, 51),
(8277, 140, 52),
(8278, 141, 53),
(8279, 141, 54),
(8280, 138, 55),
(8281, 147, 2),
(8282, 147, 3),
(8283, 143, 4),
(8284, 143, 5),
(8285, 144, 6),
(8286, 144, 7),
(8287, 145, 14),
(8288, 145, 15),
(8289, 147, 16),
(8290, 147, 17),
(8291, 146, 18),
(8292, 146, 19),
(8293, 143, 26),
(8294, 146, 27),
(8295, 146, 28),
(8296, 143, 29),
(8297, 143, 30),
(8298, 146, 31),
(8299, 145, 38),
(8300, 145, 39),
(8301, 142, 40),
(8302, 142, 41),
(8303, 142, 42),
(8304, 146, 50),
(8305, 146, 51),
(8306, 144, 52),
(8307, 143, 53),
(8308, 143, 54),
(8309, 211, 8),
(8310, 214, 9),
(8311, 215, 9),
(8312, 216, 9),
(8313, 217, 10),
(8314, 218, 10),
(8315, 219, 10),
(8316, 217, 11),
(8317, 218, 11),
(8318, 219, 11),
(8319, 217, 12),
(8320, 218, 12),
(8321, 219, 12),
(8322, 220, 13),
(8323, 221, 13),
(8324, 222, 13),
(8325, 225, 20),
(8326, 226, 21),
(8327, 227, 21),
(8328, 228, 21),
(8329, 220, 22),
(8330, 221, 22),
(8331, 222, 22),
(8332, 220, 23),
(8333, 221, 23),
(8334, 222, 23),
(8335, 217, 24),
(8336, 218, 24),
(8337, 219, 24),
(8338, 217, 25),
(8339, 218, 25),
(8340, 219, 25),
(8341, 214, 33),
(8342, 215, 33),
(8343, 216, 33),
(8344, 212, 34),
(8345, 213, 34),
(8346, 212, 35),
(8347, 213, 35),
(8348, 212, 36),
(8349, 213, 36),
(8350, 226, 37),
(8351, 227, 37),
(8352, 228, 37),
(8353, 223, 44),
(8354, 224, 44),
(8355, 223, 45),
(8356, 224, 45),
(8357, 217, 46),
(8358, 218, 46),
(8359, 219, 46),
(8360, 220, 47),
(8361, 221, 47),
(8362, 222, 47),
(8363, 211, 48),
(8364, 226, 56),
(8365, 227, 56),
(8366, 228, 56),
(8367, 226, 57),
(8368, 227, 57),
(8369, 228, 57),
(8370, 226, 58),
(8371, 227, 58),
(8372, 228, 58),
(8373, 214, 59),
(8374, 215, 59),
(8375, 216, 59),
(8376, 225, 60),
(8377, 214, 61),
(8378, 215, 61),
(8379, 216, 61),
(8380, 148, 8),
(8381, 149, 8),
(8382, 150, 8),
(8383, 148, 9),
(8384, 149, 9),
(8385, 150, 9),
(8386, 151, 10),
(8387, 152, 10),
(8388, 151, 11),
(8389, 152, 11),
(8390, 165, 12),
(8391, 153, 13),
(8392, 169, 20),
(8393, 170, 20),
(8394, 171, 20),
(8395, 154, 21),
(8396, 155, 21),
(8397, 156, 21),
(8398, 154, 22),
(8399, 155, 22),
(8400, 156, 22),
(8401, 160, 23),
(8402, 161, 23),
(8403, 162, 23),
(8404, 157, 24),
(8405, 158, 24),
(8406, 159, 24),
(8407, 157, 25),
(8408, 158, 25),
(8409, 159, 25),
(8410, 160, 32),
(8411, 161, 32),
(8412, 162, 32),
(8413, 153, 33),
(8414, 157, 34),
(8415, 158, 34),
(8416, 159, 34),
(8417, 157, 35),
(8418, 158, 35),
(8419, 159, 35),
(8420, 154, 36),
(8421, 155, 36),
(8422, 156, 36),
(8423, 154, 37),
(8424, 155, 37),
(8425, 156, 37),
(8426, 166, 44),
(8427, 167, 44),
(8428, 168, 44),
(8429, 160, 45),
(8430, 161, 45),
(8431, 162, 45),
(8432, 160, 46),
(8433, 161, 46),
(8434, 162, 46),
(8435, 148, 47),
(8436, 149, 47),
(8437, 150, 47),
(8438, 166, 48),
(8439, 167, 48),
(8440, 168, 48),
(8441, 148, 49),
(8442, 149, 49),
(8443, 150, 49),
(8444, 157, 56),
(8445, 158, 56),
(8446, 159, 56),
(8447, 163, 57),
(8448, 164, 57),
(8449, 163, 58),
(8450, 164, 58),
(8451, 165, 59),
(8452, 193, 2),
(8453, 194, 2),
(8454, 195, 2),
(8455, 196, 3),
(8456, 197, 3),
(8457, 198, 3),
(8458, 196, 4),
(8459, 197, 4),
(8460, 198, 4),
(8461, 196, 5),
(8462, 197, 5),
(8463, 198, 5),
(8464, 196, 6),
(8465, 197, 6),
(8466, 198, 6),
(8467, 196, 7),
(8468, 197, 7),
(8469, 198, 7),
(8470, 199, 14),
(8471, 200, 14),
(8472, 199, 15),
(8473, 200, 15),
(8474, 202, 16),
(8475, 203, 16),
(8476, 204, 16),
(8477, 202, 17),
(8478, 203, 17),
(8479, 204, 17),
(8480, 205, 18),
(8481, 206, 18),
(8482, 205, 19),
(8483, 206, 19),
(8484, 208, 26),
(8485, 209, 26),
(8486, 210, 26),
(8487, 207, 27),
(8488, 208, 28),
(8489, 209, 28),
(8490, 210, 28),
(8491, 193, 29),
(8492, 194, 29),
(8493, 195, 29),
(8494, 205, 38),
(8495, 206, 38),
(8496, 207, 39),
(8497, 201, 40),
(8498, 201, 41),
(8499, 193, 42),
(8500, 194, 42),
(8501, 195, 42),
(8502, 208, 51),
(8503, 209, 51),
(8504, 210, 51),
(8505, 208, 52),
(8506, 209, 52),
(8507, 210, 52),
(8508, 193, 53),
(8509, 194, 53),
(8510, 195, 53),
(8511, 196, 54),
(8512, 197, 54),
(8513, 198, 54),
(8514, 202, 55),
(8515, 203, 55),
(8516, 204, 55),
(8517, 247, 2),
(8518, 248, 2),
(8519, 249, 2),
(8520, 247, 3),
(8521, 248, 3),
(8522, 249, 3),
(8523, 247, 4),
(8524, 248, 4),
(8525, 249, 4),
(8526, 241, 5),
(8527, 242, 5),
(8528, 243, 5),
(8529, 235, 6),
(8530, 236, 14),
(8531, 237, 14),
(8532, 236, 15),
(8533, 237, 15),
(8534, 229, 16),
(8535, 230, 16),
(8536, 231, 16),
(8537, 232, 17),
(8538, 233, 17),
(8539, 234, 17),
(8540, 244, 26),
(8541, 245, 26),
(8542, 246, 26),
(8543, 238, 27),
(8544, 239, 27),
(8545, 240, 27),
(8546, 238, 28),
(8547, 239, 28),
(8548, 240, 28),
(8549, 238, 29),
(8550, 239, 29),
(8551, 240, 29),
(8552, 244, 30),
(8553, 245, 30),
(8554, 246, 30),
(8555, 244, 31),
(8556, 245, 31),
(8557, 246, 31),
(8558, 235, 38),
(8559, 235, 39),
(8560, 241, 40),
(8561, 242, 40),
(8562, 243, 40),
(8563, 232, 41),
(8564, 233, 41),
(8565, 234, 41),
(8566, 232, 42),
(8567, 233, 42),
(8568, 234, 42),
(8569, 244, 43),
(8570, 245, 43),
(8571, 246, 43),
(8572, 241, 50),
(8573, 242, 50),
(8574, 243, 50),
(8575, 229, 51),
(8576, 230, 51),
(8577, 231, 51),
(8578, 236, 52),
(8579, 237, 52),
(8580, 232, 53),
(8581, 233, 53),
(8582, 234, 53),
(8583, 244, 54),
(8584, 245, 54),
(8585, 246, 54),
(8586, 238, 55),
(8587, 239, 55),
(8588, 240, 55),
(8589, 175, 2),
(8590, 176, 2),
(8591, 177, 2),
(8592, 178, 3),
(8593, 179, 3),
(8594, 180, 3),
(8595, 190, 4),
(8596, 191, 4),
(8597, 192, 4),
(8598, 187, 5),
(8599, 188, 5),
(8600, 189, 5),
(8601, 184, 6),
(8602, 187, 14),
(8603, 188, 14),
(8604, 189, 14),
(8605, 175, 15),
(8606, 176, 15),
(8607, 177, 15),
(8608, 181, 16),
(8609, 182, 16),
(8610, 183, 16),
(8611, 184, 17),
(8612, 190, 18),
(8613, 191, 18),
(8614, 192, 18),
(8615, 181, 19),
(8616, 182, 19),
(8617, 183, 19),
(8618, 172, 26),
(8619, 173, 26),
(8620, 174, 26),
(8621, 178, 27),
(8622, 179, 27),
(8623, 180, 27),
(8624, 178, 28),
(8625, 179, 28),
(8626, 180, 28),
(8627, 178, 29),
(8628, 179, 29),
(8629, 180, 29),
(8630, 178, 30),
(8631, 179, 30),
(8632, 180, 30),
(8633, 190, 38),
(8634, 191, 38),
(8635, 192, 38),
(8636, 187, 39),
(8637, 188, 39),
(8638, 189, 39),
(8639, 175, 40),
(8640, 176, 40),
(8641, 177, 40),
(8642, 185, 41),
(8643, 186, 41),
(8644, 185, 42),
(8645, 186, 42),
(8646, 172, 50),
(8647, 173, 50),
(8648, 174, 50),
(8649, 187, 51),
(8650, 188, 51),
(8651, 189, 51),
(8652, 187, 52),
(8653, 188, 52),
(8654, 189, 52),
(8655, 190, 53),
(8656, 191, 53),
(8657, 192, 53),
(8658, 181, 54),
(8659, 182, 54),
(8660, 183, 54),
(8661, 175, 55),
(8662, 176, 55),
(8663, 177, 55);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(2, '2023_04_13_215117_create_escuelas_table', 1),
(3, '2023_04_13_220913_create_profesores_table', 1),
(4, '2023_04_13_223144_create_cursos_table', 1),
(5, '2023_04_13_224754_create_admins_table', 1),
(6, '2023_04_13_230307_create_horarios_table', 1),
(7, '2023_04_13_231216_create_tipos_table', 1),
(8, '2023_04_13_231706_create_asignaturas_table', 1),
(9, '2023_04_14_101756_create_alumnos_table', 1),
(10, '2023_04_14_103201_create_horario_asignaturas_table', 1),
(11, '2023_04_14_104537_create_asistencias_table', 1),
(12, '2023_05_10_153703_add_email_verification_token_to_profesores_table', 2),
(13, '2023_05_09_140452_add_email_verification_token_to_alumnos_table', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesores`
--

CREATE TABLE `profesores` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `apellido` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `profesores`
--

INSERT INTO `profesores` (`id`, `nombre`, `apellido`, `email`, `token`, `password`, `estado`, `created_at`, `updated_at`) VALUES
(5, 'Álvaro', 'Cantó', 'alvarocanto@gmail.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 1, NULL, NULL),
(6, 'Juan', 'Pérez', 'juanperez@escuela.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 1, NULL, NULL),
(7, 'María', 'González', 'mariagonzalez@escuela.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 1, NULL, NULL),
(8, 'Carlos', 'Ruiz', 'carlosruiz@escuela.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 1, NULL, NULL),
(9, 'Lucía', 'Sánchez', 'luciasanchez@escuela.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 1, NULL, NULL),
(10, 'Pedro', 'García', 'pedrogarcia@escuela.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 1, NULL, NULL),
(11, 'Laura', 'Martínez', 'lauramartinez@escuela.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 1, NULL, NULL),
(12, 'Jorge', 'Hernández', 'jorgehernandez@escuela.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 1, NULL, NULL),
(13, 'Ana', 'López', 'analopez@escuela.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 1, NULL, NULL),
(14, 'Daniel', 'Sanz', 'danielsanz@escuela.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 1, NULL, NULL),
(15, 'Sara', 'González', 'saragonzalez@escuela.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 1, NULL, NULL),
(16, 'Rubén', 'Rodríguez', 'rubenrodriguez@escuela.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 1, NULL, NULL),
(17, 'Cristina', 'García', 'cristinagarcia@escuela.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 1, NULL, NULL),
(18, 'Mario', 'Gómez', 'mariogomez@escuela.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 1, NULL, NULL),
(19, 'Elena', 'Fernández', 'elenafdez@escuela.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 1, NULL, NULL),
(20, 'José', 'Sánchez', 'josesanchez@escuela.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 1, NULL, NULL),
(21, 'María', 'Jiménez', 'mariajimenez@escuela.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 1, NULL, NULL),
(22, 'Pablo', 'Ruiz', 'pabloruiz@escuela.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 1, NULL, NULL),
(23, 'Lucía', 'Torres', 'luciatorres@escuela.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 1, NULL, NULL),
(24, 'Alejandro', 'Ortega', 'alejandroortega@escuela.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 1, NULL, NULL),
(25, 'Patricia', 'Herrera', 'patriciaherrera@escuela.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 1, NULL, NULL),
(26, 'Miguel', 'Gallardo', 'miguelgallardo@escuela.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 1, NULL, NULL),
(27, 'Adriana', 'Ramos', 'adrianaramos@escuela.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 1, NULL, NULL),
(28, 'Javier', 'Santos', 'javiersantos@escuela.com', NULL, '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos`
--

CREATE TABLE `tipos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombretipo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tipos`
--

INSERT INTO `tipos` (`id`, `nombretipo`) VALUES
(1, 'Presente'),
(2, 'Falta'),
(3, 'Retraso\r\n');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_email_unique` (`email`);

--
-- Indices de la tabla `alumnos`
--
ALTER TABLE `alumnos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `alumnos_email_unique` (`email`),
  ADD KEY `alumnos_id_curso_foreign` (`id_curso`);

--
-- Indices de la tabla `asignaturas`
--
ALTER TABLE `asignaturas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `asignaturas_id_profesor_foreign` (`id_profesor`),
  ADD KEY `asignaturas_id_curso_foreign` (`id_curso`);

--
-- Indices de la tabla `asistencias`
--
ALTER TABLE `asistencias`
  ADD PRIMARY KEY (`id`),
  ADD KEY `asistencias_id_alumno_asistencia_foreign` (`id_alumno_asistencia`),
  ADD KEY `asistencias_id_profe_asistencia_foreign` (`id_profe_asistencia`),
  ADD KEY `asistencias_id_horarioasignatura_asistencia_foreign` (`id_horarioasignatura_asistencia`),
  ADD KEY `asistencias_id_tipo_asistencia_foreign` (`id_tipo_asistencia`);

--
-- Indices de la tabla `cursos`
--
ALTER TABLE `cursos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cursos_id_escuela_foreign` (`id_escuela`);

--
-- Indices de la tabla `escuelas`
--
ALTER TABLE `escuelas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `horarios`
--
ALTER TABLE `horarios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `horario_asignaturas`
--
ALTER TABLE `horario_asignaturas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `horario_asignaturas_id_asignatura_int_foreign` (`id_asignatura_int`),
  ADD KEY `horario_asignaturas_id_horario_int_foreign` (`id_horario_int`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indices de la tabla `profesores`
--
ALTER TABLE `profesores`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `profesores_email_unique` (`email`);

--
-- Indices de la tabla `tipos`
--
ALTER TABLE `tipos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `alumnos`
--
ALTER TABLE `alumnos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=255;

--
-- AUTO_INCREMENT de la tabla `asignaturas`
--
ALTER TABLE `asignaturas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=250;

--
-- AUTO_INCREMENT de la tabla `asistencias`
--
ALTER TABLE `asistencias`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `cursos`
--
ALTER TABLE `cursos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `escuelas`
--
ALTER TABLE `escuelas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `horarios`
--
ALTER TABLE `horarios`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT de la tabla `horario_asignaturas`
--
ALTER TABLE `horario_asignaturas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8664;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `profesores`
--
ALTER TABLE `profesores`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT de la tabla `tipos`
--
ALTER TABLE `tipos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `alumnos`
--
ALTER TABLE `alumnos`
  ADD CONSTRAINT `alumnos_id_curso_foreign` FOREIGN KEY (`id_curso`) REFERENCES `cursos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `asignaturas`
--
ALTER TABLE `asignaturas`
  ADD CONSTRAINT `asignaturas_id_curso_foreign` FOREIGN KEY (`id_curso`) REFERENCES `cursos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `asignaturas_id_profesor_foreign` FOREIGN KEY (`id_profesor`) REFERENCES `profesores` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `asistencias`
--
ALTER TABLE `asistencias`
  ADD CONSTRAINT `asistencias_id_alumno_asistencia_foreign` FOREIGN KEY (`id_alumno_asistencia`) REFERENCES `alumnos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `asistencias_id_horarioasignatura_asistencia_foreign` FOREIGN KEY (`id_horarioasignatura_asistencia`) REFERENCES `horario_asignaturas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `asistencias_id_profe_asistencia_foreign` FOREIGN KEY (`id_profe_asistencia`) REFERENCES `profesores` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `asistencias_id_tipo_asistencia_foreign` FOREIGN KEY (`id_tipo_asistencia`) REFERENCES `tipos` (`id`);

--
-- Filtros para la tabla `cursos`
--
ALTER TABLE `cursos`
  ADD CONSTRAINT `cursos_id_escuela_foreign` FOREIGN KEY (`id_escuela`) REFERENCES `escuelas` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `horario_asignaturas`
--
ALTER TABLE `horario_asignaturas`
  ADD CONSTRAINT `horario_asignaturas_id_asignatura_int_foreign` FOREIGN KEY (`id_asignatura_int`) REFERENCES `asignaturas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `horario_asignaturas_id_horario_int_foreign` FOREIGN KEY (`id_horario_int`) REFERENCES `horarios` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
