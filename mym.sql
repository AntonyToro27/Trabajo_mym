-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-07-2025 a las 02:10:02
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
-- Base de datos: `mym`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito`
--

CREATE TABLE `carrito` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `variante_id` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL DEFAULT 1,
  `creado_en` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `carrito`
--

INSERT INTO `carrito` (`id`, `usuario_id`, `variante_id`, `cantidad`, `creado_en`) VALUES
(32, 61, 13, 2, '2025-07-01 14:03:35'),
(76, 62, 13, 1, '2025-07-08 03:59:32');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`, `descripcion`, `created_at`) VALUES
(6, 'Buzos', 'buzos', '2025-07-01 03:36:29'),
(7, 'Camisetas', 'Camisetas', '2025-07-01 13:39:01'),
(9, 'Gorras', 'Gorras', '2025-07-01 14:09:00'),
(10, 'Jeans', '', '2025-07-03 00:10:55'),
(11, 'Deportiva', '', '2025-07-03 00:11:06'),
(12, 'Pantalonetas', '', '2025-07-03 00:11:16'),
(13, 'Blusas', '', '2025-07-03 00:13:40'),
(14, 'Vestidos', '', '2025-07-03 00:13:59');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `colores`
--

CREATE TABLE `colores` (
  `id` int(11) NOT NULL,
  `color` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `colores`
--

INSERT INTO `colores` (`id`, `color`) VALUES
(1, 'Negro'),
(2, 'Blanco'),
(3, 'Blanco'),
(4, 'Azul'),
(5, 'Verde'),
(6, 'Gris');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_pedido`
--

CREATE TABLE `detalle_pedido` (
  `id` int(11) NOT NULL,
  `pedido_id` int(11) NOT NULL,
  `variante_id` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalle_pedido`
--

INSERT INTO `detalle_pedido` (`id`, `pedido_id`, `variante_id`, `cantidad`, `precio_unitario`, `subtotal`) VALUES
(1, 1, 14, 2, 70000.00, 140000.00),
(2, 2, 15, 3, 70000.00, 210000.00),
(3, 2, 13, 1, 80000.00, 80000.00),
(4, 3, 17, 23, 70000.00, 1610000.00),
(5, 4, 15, 1, 70000.00, 70000.00),
(6, 5, 15, 2, 70000.00, 140000.00),
(7, 6, 13, 8, 80000.00, 640000.00),
(8, 7, 13, 1, 80000.00, 80000.00),
(9, 8, 13, 1, 80000.00, 80000.00),
(10, 9, 13, 1, 80000.00, 80000.00),
(11, 10, 13, 6, 80000.00, 480000.00),
(12, 11, 17, 2, 70000.00, 140000.00),
(13, 12, 17, 1, 70000.00, 70000.00),
(14, 13, 13, 2, 80000.00, 160000.00),
(15, 13, 15, 1, 70000.00, 70000.00),
(16, 13, 18, 1, 60000.00, 60000.00),
(17, 14, 14, 1, 70000.00, 70000.00),
(18, 15, 13, 2, 50000.00, 100000.00),
(19, 16, 28, 2, 50000.00, 100000.00),
(20, 17, 28, 2, 50000.00, 100000.00),
(21, 18, 13, 2, 50000.00, 100000.00),
(22, 19, 18, 10, 60000.00, 600000.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos`
--

CREATE TABLE `pagos` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `pedido_id` int(11) NOT NULL,
  `metodo` enum('tarjeta','paypal','transferencia','efectivo') NOT NULL,
  `estado` enum('pendiente','completado','fallido') DEFAULT 'pendiente',
  `referencia` varchar(255) DEFAULT NULL,
  `monto` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pagos`
--

INSERT INTO `pagos` (`id`, `id_usuario`, `pedido_id`, `metodo`, `estado`, `referencia`, `monto`) VALUES
(1, 62, 1, 'tarjeta', 'completado', NULL, 140000.00),
(2, 56, 2, 'tarjeta', 'completado', NULL, 290000.00),
(3, 56, 3, 'tarjeta', 'completado', NULL, 1610000.00),
(4, 56, 4, 'tarjeta', 'completado', NULL, 70000.00),
(5, 56, 5, 'tarjeta', 'completado', NULL, 140000.00),
(6, 56, 6, 'tarjeta', 'completado', NULL, 640000.00),
(7, 62, 7, 'tarjeta', 'completado', NULL, 80000.00),
(8, 62, 8, 'tarjeta', 'completado', NULL, 80000.00),
(9, 56, 9, 'tarjeta', 'completado', NULL, 80000.00),
(10, 56, 10, 'tarjeta', 'completado', NULL, 480000.00),
(11, 62, 11, 'tarjeta', 'completado', NULL, 140000.00),
(12, 62, 12, 'tarjeta', 'completado', NULL, 70000.00),
(13, 62, 13, 'tarjeta', 'completado', NULL, 290000.00),
(14, 56, 14, 'tarjeta', 'completado', NULL, 70000.00),
(15, 62, 15, 'tarjeta', 'completado', NULL, 100000.00),
(16, 62, 16, 'tarjeta', 'completado', NULL, 100000.00),
(17, 62, 17, 'tarjeta', 'completado', NULL, 100000.00),
(18, 62, 18, 'tarjeta', 'completado', NULL, 100000.00),
(19, 56, 19, 'tarjeta', 'completado', NULL, 600000.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `estado` enum('pendiente','procesando','enviado','entregado','cancelado') DEFAULT 'pendiente',
  `creado_en` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id`, `usuario_id`, `total`, `estado`, `creado_en`) VALUES
(1, 62, 140000.00, 'cancelado', '2025-07-02 02:43:22'),
(2, 56, 290000.00, 'cancelado', '2025-07-02 13:12:17'),
(3, 56, 1610000.00, 'cancelado', '2025-07-02 14:24:01'),
(4, 56, 70000.00, 'cancelado', '2025-07-02 14:25:25'),
(5, 56, 140000.00, 'cancelado', '2025-07-02 14:56:56'),
(6, 56, 640000.00, 'cancelado', '2025-07-02 14:58:15'),
(7, 62, 80000.00, 'cancelado', '2025-07-02 14:59:25'),
(8, 62, 80000.00, 'cancelado', '2025-07-02 15:14:23'),
(9, 56, 80000.00, 'cancelado', '2025-07-02 15:23:26'),
(10, 56, 480000.00, 'cancelado', '2025-07-02 22:22:10'),
(11, 62, 140000.00, 'cancelado', '2025-07-02 22:28:32'),
(12, 62, 70000.00, 'cancelado', '2025-07-02 22:33:08'),
(13, 62, 290000.00, 'procesando', '2025-07-03 17:12:10'),
(14, 56, 70000.00, 'cancelado', '2025-07-05 23:00:18'),
(15, 62, 100000.00, 'procesando', '2025-07-07 21:11:05'),
(16, 62, 100000.00, 'procesando', '2025-07-07 21:14:42'),
(17, 62, 100000.00, 'procesando', '2025-07-07 21:21:25'),
(18, 62, 100000.00, 'procesando', '2025-07-08 01:29:44'),
(19, 56, 600000.00, 'procesando', '2025-07-08 14:13:16');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `categoria_id` int(11) DEFAULT NULL,
  `estado` enum('activo','inactivo') DEFAULT 'activo',
  `creado_en` timestamp NOT NULL DEFAULT current_timestamp(),
  `genero` enum('Hombre','Mujer','Niño','Niña','Unisex') DEFAULT 'Hombre'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `descripcion`, `precio`, `imagen`, `categoria_id`, `estado`, `creado_en`, `genero`) VALUES
(14, 'Buzo', 'Buzooo', 50000.00, 'Camiseta_Blanca1.jpg', 6, 'activo', '2025-07-01 12:44:16', 'Hombre'),
(15, 'Camiseta', 'Camiseta Algodon', 90000.00, 'Camiseta_Monastery_Negra.jpg', 7, 'activo', '2025-07-01 13:32:54', 'Hombre'),
(16, 'Camiseta Hombre', 'Camiseta', 50000.00, 'Camiseta_Monastery_Gris1.jpg', 7, 'activo', '2025-07-01 13:41:28', 'Hombre'),
(17, 'Camiseta Oversize', 'Camiseta oversize', 70000.00, 'Camiseta_Monastery_Negra.jpg', 7, 'activo', '2025-07-01 14:05:28', 'Hombre'),
(18, 'BLusa Dama', 'Blusa dama', 60000.00, 'Blusa Saten Beige.jpeg', 7, 'activo', '2025-07-02 23:41:21', 'Mujer'),
(19, 'Camiseta Monastery', 'camiseta algodon', 50000.00, 'Camiseta_Monastery_Gris.jpg', 7, 'activo', '2025-07-07 21:07:22', 'Hombre');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reseñas`
--

CREATE TABLE `reseñas` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `variante_id` int(11) NOT NULL,
  `calificacion` int(11) DEFAULT NULL CHECK (`calificacion` between 1 and 5),
  `comentario` text DEFAULT NULL,
  `creado_en` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tallas`
--

CREATE TABLE `tallas` (
  `id` int(11) NOT NULL,
  `talla` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tallas`
--

INSERT INTO `tallas` (`id`, `talla`) VALUES
(1, 'S'),
(2, 'M'),
(3, 'L'),
(4, 'XL');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `cedula` varchar(20) DEFAULT NULL,
  `nombre_completo` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contrasena` varchar(150) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `rol` enum('cliente','admin') DEFAULT 'cliente',
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `cedula`, `nombre_completo`, `email`, `contrasena`, `telefono`, `direccion`, `rol`, `fecha_registro`) VALUES
(22, NULL, '   ', 'adminmym@gmail.com', '912dae851c3c6ed715aaa7856019fc15d03cf85ecee6a2eb372def515cfe042bc7ba2f18c7b75015c15c5179ac4465dd750611c3fbd2fb4440eaa622a5a742b3', NULL, NULL, 'admin', '2025-04-23 01:33:41'),
(56, 'NA', 'Administrador mym', 'adminmym1@gmail.com', '24d7d1296e90f6d1cd94e18bb8c4fec65d9c7dd022ee3dea625848ad96e85731dfe58b556105302008e09ebc3d8f80928e81a04ee58a7c1024a0c661900f144e', '3122120203', 'Carrera 80 #30-23', 'admin', '2025-06-30 19:47:14'),
(61, NULL, 'hector maya', 'hector@gmail.com', 'd6a1eb33e8cb338a3851112334910572183214286bd9e496edbf8403bfa25f2638974541fc7737a58f4b97cfa3a234ee915ec535e2e1af398a6eed433f7e8f17', NULL, NULL, 'cliente', '2025-07-01 14:02:31'),
(62, NULL, 'Antony Toro', 'antony@gmail.com', 'b5b589bad7c2228b1994f77122735817542f3b6006aa839bf1b617f7afde7ce6eac157a8f655a554843f3a9dfd4a043afa9933c63eff8e122464e8e74ef46c70', '3122120203', 'Carrera 80 #30-23', 'cliente', '2025-07-01 23:32:33');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `variantes_producto`
--

CREATE TABLE `variantes_producto` (
  `id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `talla_id` int(11) NOT NULL,
  `color_id` int(11) NOT NULL,
  `stock` int(10) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `variantes_producto`
--

INSERT INTO `variantes_producto` (`id`, `producto_id`, `talla_id`, `color_id`, `stock`) VALUES
(13, 14, 3, 4, 21),
(14, 17, 3, 1, 2),
(15, 17, 4, 2, 53),
(17, 17, 3, 6, 8),
(18, 18, 2, 1, 24),
(28, 19, 2, 6, 36);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario_variante_unique` (`usuario_id`,`variante_id`),
  ADD KEY `carrito_ibfk_2` (`variante_id`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `colores`
--
ALTER TABLE `colores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pedido_id` (`pedido_id`),
  ADD KEY `variante_id` (`variante_id`);

--
-- Indices de la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `pedido_id` (`pedido_id`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categoria_id` (`categoria_id`);

--
-- Indices de la tabla `reseñas`
--
ALTER TABLE `reseñas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `variante_id` (`variante_id`);

--
-- Indices de la tabla `tallas`
--
ALTER TABLE `tallas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `cedula` (`cedula`);

--
-- Indices de la tabla `variantes_producto`
--
ALTER TABLE `variantes_producto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `talla_id` (`talla_id`),
  ADD KEY `color_id` (`color_id`),
  ADD KEY `variantes_producto_ibfk_1` (`producto_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `carrito`
--
ALTER TABLE `carrito`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `colores`
--
ALTER TABLE `colores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `pagos`
--
ALTER TABLE `pagos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `reseñas`
--
ALTER TABLE `reseñas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tallas`
--
ALTER TABLE `tallas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT de la tabla `variantes_producto`
--
ALTER TABLE `variantes_producto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD CONSTRAINT `carrito_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `carrito_ibfk_2` FOREIGN KEY (`variante_id`) REFERENCES `variantes_producto` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  ADD CONSTRAINT `detalle_pedido_ibfk_1` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`),
  ADD CONSTRAINT `detalle_pedido_ibfk_2` FOREIGN KEY (`variante_id`) REFERENCES `variantes_producto` (`id`);

--
-- Filtros para la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD CONSTRAINT `pagos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `pagos_ibfk_2` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`);

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`);

--
-- Filtros para la tabla `reseñas`
--
ALTER TABLE `reseñas`
  ADD CONSTRAINT `reseñas_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `reseñas_ibfk_2` FOREIGN KEY (`variante_id`) REFERENCES `variantes_producto` (`id`);

--
-- Filtros para la tabla `variantes_producto`
--
ALTER TABLE `variantes_producto`
  ADD CONSTRAINT `variantes_producto_ibfk_1` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `variantes_producto_ibfk_2` FOREIGN KEY (`talla_id`) REFERENCES `tallas` (`id`),
  ADD CONSTRAINT `variantes_producto_ibfk_3` FOREIGN KEY (`color_id`) REFERENCES `colores` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
