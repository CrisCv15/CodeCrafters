-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-10-2024 a las 03:25:13
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
  `Apertura` decimal(10,2) NOT NULL,
  `Cierre` decimal(10,2) NOT NULL,
  `Registrototal` decimal(10,2) NOT NULL,
  `ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `caja`
--

INSERT INTO `caja` (`FechayHora`, `Apertura`, `Cierre`, `Registrototal`, `ID`) VALUES
('2024-10-03 02:40:51', 10.00, 10.00, 10.00, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `CodigoBarras` varchar(50) NOT NULL,
  `Precio` decimal(10,2) NOT NULL,
  `Descripcion` varchar(255) NOT NULL,
  `Stock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`CodigoBarras`, `Precio`, `Descripcion`, `Stock`) VALUES
('1111111111111', 200.00, 'Camiseta azul de algodón', 100),
('3333333333333', 200.00, 'prueba', 12),
('88888888888', 200.00, 'prueba ', 12);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `promoción`
--

CREATE TABLE `promoción` (
  `CodigoPromoción` varchar(50) NOT NULL,
  `Precio` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `promociónproductos`
--

CREATE TABLE `promociónproductos` (
  `CodigoBarras` varchar(50) NOT NULL,
  `CodigoPromoción` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `ID` int(11) NOT NULL,
  `Nombre` varchar(50) NOT NULL,
  `Contraseña` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`ID`, `Nombre`, `Contraseña`) VALUES
(1, 'admin', 'admin');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `FechayHora` datetime DEFAULT NULL,
  `NumeroTicket` int(11) NOT NULL,
  `FormaPago` varchar(50) NOT NULL,
  `cantidad` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`FechayHora`, `NumeroTicket`, `FormaPago`, `cantidad`) VALUES
('2024-10-03 02:40:51', 76575776, 'Efectivo', 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventasproductos`
--

CREATE TABLE `ventasproductos` (
  `NumeroTicket` int(11) NOT NULL,
  `CodigoBarras` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ventasproductos`
--

INSERT INTO `ventasproductos` (`NumeroTicket`, `CodigoBarras`) VALUES
(76575776, '88888888888');

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
-- Indices de la tabla `promoción`
--
ALTER TABLE `promoción`
  ADD PRIMARY KEY (`CodigoPromoción`);

--
-- Indices de la tabla `promociónproductos`
--
ALTER TABLE `promociónproductos`
  ADD PRIMARY KEY (`CodigoBarras`,`CodigoPromoción`),
  ADD KEY `CodigoPromoción` (`CodigoPromoción`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`NumeroTicket`),
  ADD KEY `FechayHora` (`FechayHora`);

--
-- Indices de la tabla `ventasproductos`
--
ALTER TABLE `ventasproductos`
  ADD PRIMARY KEY (`NumeroTicket`,`CodigoBarras`),
  ADD KEY `CodigoBarras` (`CodigoBarras`);

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
  MODIFY `NumeroTicket` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76575777;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `caja`
--
ALTER TABLE `caja`
  ADD CONSTRAINT `caja_ibfk_1` FOREIGN KEY (`ID`) REFERENCES `usuario` (`ID`);

--
-- Filtros para la tabla `promociónproductos`
--
ALTER TABLE `promociónproductos`
  ADD CONSTRAINT `promociónproductos_ibfk_1` FOREIGN KEY (`CodigoBarras`) REFERENCES `producto` (`CodigoBarras`),
  ADD CONSTRAINT `promociónproductos_ibfk_2` FOREIGN KEY (`CodigoPromoción`) REFERENCES `promoción` (`CodigoPromoción`);

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `ventas_ibfk_1` FOREIGN KEY (`FechayHora`) REFERENCES `caja` (`FechayHora`);

--
-- Filtros para la tabla `ventasproductos`
--
ALTER TABLE `ventasproductos`
  ADD CONSTRAINT `ventasproductos_ibfk_1` FOREIGN KEY (`NumeroTicket`) REFERENCES `ventas` (`NumeroTicket`),
  ADD CONSTRAINT `ventasproductos_ibfk_2` FOREIGN KEY (`CodigoBarras`) REFERENCES `producto` (`CodigoBarras`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
