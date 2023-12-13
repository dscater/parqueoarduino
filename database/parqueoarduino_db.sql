-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 13-12-2023 a las 13:53:19
-- Versión del servidor: 8.0.30
-- Versión de PHP: 7.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `parqueoarduino_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cobros`
--

CREATE TABLE `cobros` (
  `id` bigint UNSIGNED NOT NULL,
  `ingreso_salida_id` bigint UNSIGNED NOT NULL,
  `tiempo` int NOT NULL,
  `costo` decimal(24,2) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `visto` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `cobros`
--

INSERT INTO `cobros` (`id`, `ingreso_salida_id`, `tiempo`, `costo`, `fecha`, `hora`, `visto`, `created_at`, `updated_at`) VALUES
(1, 1, 66, 100.00, '2023-12-11', '12:19:00', 1, '2023-12-11 16:19:19', '2023-12-11 17:03:03'),
(2, 2, 1, 20.00, '2023-12-11', '13:16:00', 1, '2023-12-11 17:16:58', '2023-12-11 17:19:27'),
(3, 3, 2, 20.00, '2023-12-13', '09:42:00', 1, '2023-12-13 13:42:44', '2023-12-13 13:43:47'),
(4, 4, 11, 50.00, '2023-12-13', '09:51:00', 1, '2023-12-13 13:51:19', '2023-12-13 13:51:21');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `espacios`
--

CREATE TABLE `espacios` (
  `id` bigint UNSIGNED NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nro_espacio` int NOT NULL,
  `estado` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `espacios`
--

INSERT INTO `espacios` (`id`, `nombre`, `nro_espacio`, `estado`, `created_at`, `updated_at`) VALUES
(1, 'ESPACIO 1', 1, 'LIBRE', NULL, '2023-12-13 13:42:44'),
(2, 'ESPACIO 2', 2, 'LIBRE', NULL, '2023-12-11 17:16:58'),
(3, 'ESPACIO 3', 3, 'LIBRE', NULL, '2023-12-13 13:51:19');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingreso_salidas`
--

CREATE TABLE `ingreso_salidas` (
  `id` bigint UNSIGNED NOT NULL,
  `espacio_id` bigint UNSIGNED NOT NULL,
  `fecha_ingreso` date NOT NULL,
  `hora_ingreso` time NOT NULL,
  `fecha_salida` date DEFAULT NULL,
  `hora_salida` time DEFAULT NULL,
  `tiempo` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `ingreso_salidas`
--

INSERT INTO `ingreso_salidas` (`id`, `espacio_id`, `fecha_ingreso`, `hora_ingreso`, `fecha_salida`, `hora_salida`, `tiempo`, `created_at`, `updated_at`) VALUES
(1, 1, '2023-12-11', '11:13:00', '2023-12-11', '12:19:00', 66, '2023-12-11 16:13:58', '2023-12-11 16:13:58'),
(2, 2, '2023-12-11', '13:15:00', '2023-12-11', '13:16:00', 1, '2023-12-11 17:15:48', '2023-12-11 17:16:58'),
(3, 1, '2023-12-13', '09:40:00', '2023-12-13', '09:42:00', 2, '2023-12-13 13:40:12', '2023-12-13 13:42:44'),
(4, 3, '2023-12-13', '09:40:00', '2023-12-13', '09:51:00', 11, '2023-12-13 13:40:54', '2023-12-13 13:51:19');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000002_create_users_table', 1),
(2, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(3, '2023_12_08_161303_create_espacios_table', 2),
(4, '2023_12_08_161304_create_tarifarios_table', 2),
(5, '2023_12_08_161401_create_ingreso_salidas_table', 2),
(6, '2023_12_11_115400_create_cobros_table', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tarifarios`
--

CREATE TABLE `tarifarios` (
  `id` bigint UNSIGNED NOT NULL,
  `tiempo` int NOT NULL,
  `costo` decimal(24,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tarifarios`
--

INSERT INTO `tarifarios` (`id`, `tiempo`, `costo`, `created_at`, `updated_at`) VALUES
(1, 30, 50.00, '2023-12-11 15:20:55', '2023-12-11 15:21:03'),
(2, 10, 20.00, '2023-12-11 15:21:12', '2023-12-11 15:21:12'),
(3, 60, 100.00, '2023-12-11 15:21:25', '2023-12-11 15:21:25');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `usuario` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo` enum('ADMINISTRADOR','OPERADOR') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `usuario`, `tipo`, `password`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'ADMINISTRADOR', '$2y$10$wuTuUildBSgVYfvHomvXWuVLF6T1PWByEZJelnC9LOSQ/Xwcw2N3S', NULL, NULL),
(2, 'JPERES', 'OPERADOR', '$2y$10$1Yekpqr3gwjNmmq0WO7nmeO9Ldzxc.ojRT7J9uQcV9qCl8ctHYcPy', '2023-12-08 20:05:18', '2023-12-08 20:09:39');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cobros`
--
ALTER TABLE `cobros`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `espacios`
--
ALTER TABLE `espacios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ingreso_salidas`
--
ALTER TABLE `ingreso_salidas`
  ADD PRIMARY KEY (`id`);

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
-- Indices de la tabla `tarifarios`
--
ALTER TABLE `tarifarios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_usuario_unique` (`usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cobros`
--
ALTER TABLE `cobros`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `espacios`
--
ALTER TABLE `espacios`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `ingreso_salidas`
--
ALTER TABLE `ingreso_salidas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tarifarios`
--
ALTER TABLE `tarifarios`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
