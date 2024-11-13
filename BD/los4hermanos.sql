-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-11-2024 a las 20:29:53
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
-- Base de datos: `los4hermanos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `caja`
--

CREATE TABLE `caja` (
  `FechayHora` datetime NOT NULL,
  `Apertura` time NOT NULL,
  `Cierre` time DEFAULT NULL,
  `Registrototal` decimal(10,2) DEFAULT NULL,
  `ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `caja`
--

INSERT INTO `caja` (`FechayHora`, `Apertura`, `Cierre`, `Registrototal`, `ID`) VALUES
('2024-11-08 02:47:44', '02:47:44', '02:48:31', 0.00, 1),
('2024-11-08 02:48:34', '02:48:34', '02:48:36', 0.00, 1),
('2024-11-08 02:49:26', '02:49:26', '02:49:44', 400.00, 1),
('2024-11-08 19:55:24', '19:55:24', '19:57:09', 800.00, 1),
('2024-11-08 19:57:34', '19:57:34', NULL, NULL, 1),
('2024-11-11 20:07:53', '20:07:53', NULL, NULL, 1),
('2024-11-11 20:21:19', '20:21:19', '04:23:59', 0.00, 1),
('2024-11-13 04:25:23', '04:25:23', NULL, NULL, 1),
('2024-11-13 15:23:24', '15:23:24', NULL, NULL, 1),
('2024-11-13 15:47:13', '15:47:13', NULL, NULL, 1),
('2024-11-13 15:55:34', '15:55:34', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `CodigoBarras` decimal(13,0) NOT NULL,
  `Precio` decimal(10,2) NOT NULL,
  `Descripcion` varchar(255) NOT NULL,
  `Stock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`CodigoBarras`, `Precio`, `Descripcion`, `Stock`) VALUES
(1010101010101, 150.00, 'laptop acer', 148),
(1010101010102, 399.00, 'tablet samsung', 58),
(1111111111113, 599.00, 'refrigerador lg', 39),
(1212121212122, 25.00, 'lampara led', 220),
(1313131313132, 130.00, 'auriculares sony', 90),
(1414141414142, 45.99, 'batería externa 10000mAh', 150),
(1515151515152, 75.00, 'almohada ortopédica', 180),
(1616161616162, 12.00, 'pelota de fútbol', 250),
(1717171717172, 20.00, 'bicicleta infantil', 60),
(1818181818182, 100.00, 'camiseta adidas', 300),
(1919191919192, 85.00, 'zapatos deportivos', 220),
(2020202020202, 99.99, 'mouse inalámbrico', 200),
(2020202020203, 50.00, 'mochila escolar', 150),
(3030303030303, 49.99, 'teclado mecánico', 100),
(4040404040404, 199.00, 'monitor samsung 24\"', 80),
(5050505050505, 79.99, 'ratón gamer', 50),
(6060606060606, 12.99, 'cargador usb-c', 300),
(7070707070707, 299.00, 'smartphone xiaomi', 75),
(8080808080808, 199.99, 'audífonos bluetooth', 120),
(9090909090909, 10.50, 'cable hdmi', 500);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `ID` int(11) NOT NULL,
  `Nombre` varchar(50) NOT NULL,
  `Contrasena` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`ID`, `Nombre`, `Contrasena`) VALUES
(1, 'admin', 'admin');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `FechayHora` datetime NOT NULL,
  `NumeroTicket` int(11) NOT NULL,
  `FormaPago` varchar(50) NOT NULL,
  `totalVenta` decimal(11,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`FechayHora`, `NumeroTicket`, `FormaPago`, `totalVenta`) VALUES
('2024-11-13 16:08:20', 100, 'Débito', 549);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventasproductos`
--

CREATE TABLE `ventasproductos` (
  `NumeroTicket` decimal(11,0) NOT NULL,
  `CodigoBarras` varchar(50) NOT NULL,
  `cantidadProducto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ventasproductos`
--

INSERT INTO `ventasproductos` (`NumeroTicket`, `CodigoBarras`, `cantidadProducto`) VALUES
(100, '1010101010101', 1),
(100, '1010101010102', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `caja`
--
ALTER TABLE `caja`
  ADD PRIMARY KEY (`FechayHora`),
  ADD KEY `ID` (`ID`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`CodigoBarras`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`NumeroTicket`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `NumeroTicket` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `caja`
--
ALTER TABLE `caja`
  ADD CONSTRAINT `caja_ibfk_1` FOREIGN KEY (`ID`) REFERENCES `usuario` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
