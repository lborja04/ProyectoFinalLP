-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-01-2025 a las 05:15:35
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `negociosdb`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `categoria` varchar(50) NOT NULL,
  `descripcion` text NOT NULL,
  `precio` decimal(10,0) NOT NULL,
  `imagen` text NOT NULL,
  `estado` enum('activo','inactivo','reservado','') NOT NULL,
  `vendedor_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `categoria`, `descripcion`, `precio`, `imagen`, `estado`, `vendedor_id`) VALUES
(2, 'Camiseta', 'Ropa', 'Camiseta de algodón', 20, '0', 'reservado', 21),
(3, 'Camiseta', 'Ropa', 'Camiseta de algodón', 20, '0', 'activo', 21),
(4, 'Camiseta', 'Ropa', 'Camiseta de algodón', 20, '0', 'activo', 21),
(5, 'Camiseta', 'Ropa', 'Camiseta de algodón', 20, '0', 'activo', 21),
(6, 'Camiseta', 'Ropa', 'Camiseta de algodón', 20, '0', 'activo', 21),
(7, 'Pantalón Moderno', 'Ropa', 'Pantalón moderno de mezclilla', 40, 'imagen_moderno.jpg', 'inactivo', 29),
(8, 'Zapatos', 'Calzado', 'Zapatos deportivos', 50, '0', 'inactivo', 33),
(9, 'Zapatos', 'Calzado', 'Zapatos deportivos', 50, '0', 'inactivo', 46),
(10, 'Zapatos', 'Calzado', 'Zapatos deportivos', 50, '0', 'inactivo', 49),
(11, 'Zapatos', 'Calzado', 'Zapatos deportivos', 50, '0', 'reservado', 50),
(12, 'Mochila', 'Accesorios', 'Mochila de viaje', 80, '0', 'reservado', 51),
(13, 'Mochila', 'Accesorios', 'Mochila de viaje', 80, '0', 'reservado', 54),
(14, 'Laptop Gamer', 'Electrónica', 'Laptop para juegos de última generación', 1300, 'imagen_gamer.jpg', 'inactivo', 63);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `transacciones`
--

CREATE TABLE `transacciones` (
  `id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `comprador_id` int(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `transacciones`
--

INSERT INTO `transacciones` (`id`, `producto_id`, `comprador_id`, `fecha`) VALUES
(2, 2, 21, '2025-01-17 22:48:45'),
(3, 7, 29, '2025-01-17 23:18:09'),
(4, 8, 33, '2025-01-17 23:21:51'),
(5, 9, 46, '2025-01-18 02:48:11'),
(6, 10, 49, '2025-01-18 02:52:11'),
(7, 11, 50, '2025-01-18 03:48:34'),
(8, 12, 51, '2025-01-18 03:51:13'),
(9, 13, 54, '2025-01-18 03:51:30'),
(10, 14, 63, '2025-01-18 04:06:11');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `clave` varchar(100) NOT NULL,
  `rol` enum('vendedor','comprador','','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `email`, `clave`, `rol`) VALUES
(21, 'Juan Pérez', 'juan@example.com', '$2y$10$G9wnH8GNbmxmA1YYGCSq7efx0n92qTW3.ji5idQIUBh8ZhgIVy4/G', 'comprador'),
(29, 'María Actualizada', 'maria@actualizada.com', '$2y$10$L20Lh2Si0GKkCtbRwsCTReaC6jWifDS4ibtI.GaFcjKj/0.LowRgS', 'vendedor'),
(30, 'María López', 'maria@example.com', '$2y$10$gLMizhbYoi19lPJgndS3Xewr/OBIQvEUN2NVuBjbt8NgW.VNnO/wK', 'comprador'),
(33, 'Carlos Actualizado', 'carlos@actualizado.com', '$2y$10$9HmN4Jx5yKjWHTWBIxZpd.f0PjPWg3y8kOWmcDv9z/0mQRACDT5p2', 'vendedor'),
(34, 'Carlos Méndez', 'carlos@example.com', '$2y$10$YBfYXR54EjTYVSH8wGO9R.iAOK95G8pxr0tSY9LdtfkUUsL9BHFpm', 'comprador'),
(42, 'Carlos Méndez', 'carlos@espol.com', '$2y$10$MFnTv/f4f1gcKNdfvnrDvujWLH4Tv8tAG9I4wRL/vSrylr7lBLf7e', 'comprador'),
(46, 'Carlos Méndez', 'carlos@uess.com', '$2y$10$QW/OMGDu.BaYOoaRTlw5G.zI5.lALLy5QDfMIiXE4mC1dhZURlOg2', 'comprador'),
(49, 'Carlos Actualizado', 'carlos@ups.com', '$2y$10$pQiOpow3i1nkuTLLNxgqd.6H3pidnamrbIR7Jxpf9P3dQyvTUKci.', 'vendedor'),
(50, 'Carlos Actualizado', 'carlos@harvard.com', '$2y$10$p6M4vcQNmyKxMvZ1/bEje.5rLDXHDzEcMpcVU5msG76Sw9g7xY2va', 'vendedor'),
(51, 'María Actualizada', 'maria@stanford.edu', '$2y$10$WP1R0TbedLR3SgV/TzfGzuHpRMCGoFLmbN30KFP2lTpe9FdEGoGHm', 'vendedor'),
(54, 'María González', 'maria@harvard.edu', '$2y$10$WBF7rTRl0YYaPs2b24HqwuZVRb6OvMPK7LEsCeVW38l6lGPwUqIFC', 'comprador'),
(63, 'Ana Actualizada', 'ana@example.com', '$2y$10$1X4DgUjRSTlARpA62oR9xOUdkmuWzRocObmO3eguqHDZQI91h6hnq', 'vendedor');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idVendedor` (`vendedor_id`);

--
-- Indices de la tabla `transacciones`
--
ALTER TABLE `transacciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idProducto` (`producto_id`),
  ADD KEY `idComprador` (`comprador_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `correo` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `transacciones`
--
ALTER TABLE `transacciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`vendedor_id`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `transacciones`
--
ALTER TABLE `transacciones`
  ADD CONSTRAINT `transacciones_ibfk_1` FOREIGN KEY (`comprador_id`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `transacciones_ibfk_2` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
