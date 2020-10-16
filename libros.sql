-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 16-10-2020 a las 04:24:12
-- Versión del servidor: 10.4.8-MariaDB
-- Versión de PHP: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `libros`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `autores`
--

CREATE TABLE `autores` (
  `codigoAutor` varchar(10) COLLATE utf8mb4_spanish_ci NOT NULL,
  `nombreAutor` varchar(150) COLLATE utf8mb4_spanish_ci NOT NULL,
  `nacionalidad` varchar(150) COLLATE utf8mb4_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `autores`
--

INSERT INTO `autores` (`codigoAutor`, `nombreAutor`, `nacionalidad`) VALUES
('001', 'TOMS ELLIS', 'BRITANICA'),
('002', 'BRAND STOCKERS', 'BRITANICA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `editoriales`
--

CREATE TABLE `editoriales` (
  `codigoEditorial` varchar(10) COLLATE utf8mb4_spanish_ci NOT NULL,
  `nombreEditorial` varchar(150) COLLATE utf8mb4_spanish_ci NOT NULL,
  `contacto` varchar(20) COLLATE utf8mb4_spanish_ci NOT NULL,
  `telefono` varchar(10) COLLATE utf8mb4_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `editoriales`
--

INSERT INTO `editoriales` (`codigoEditorial`, `nombreEditorial`, `contacto`, `telefono`) VALUES
('0001', 'MARVEL COMICS 1', 'JOSE EFRAIN DIAZ', '223443555');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `generos`
--

CREATE TABLE `generos` (
  `idGenero` int(11) NOT NULL,
  `nombreGenero` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  `descripcion` varchar(150) COLLATE utf8mb4_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `generos`
--

INSERT INTO `generos` (`idGenero`, `nombreGenero`, `descripcion`) VALUES
(1, 'TERROR ', 'TODO LO RELACIONADO CON EL TERROR Y LA SANGRE'),
(2, 'ROMANCE', 'ROMANCE Y AMOR'),
(4, 'CIENCIA FICCION', 'FANTASIAS');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `libros`
--

CREATE TABLE `libros` (
  `codigoLibro` varchar(10) COLLATE utf8mb4_spanish_ci NOT NULL,
  `nombreLibro` varchar(150) COLLATE utf8mb4_spanish_ci NOT NULL,
  `existencias` int(11) NOT NULL,
  `precio` double(18,2) NOT NULL,
  `codigoAutor` varchar(10) COLLATE utf8mb4_spanish_ci NOT NULL,
  `codigoEditorial` varchar(10) COLLATE utf8mb4_spanish_ci NOT NULL,
  `idGenero` int(11) NOT NULL,
  `descripcion` varchar(300) COLLATE utf8mb4_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `libros`
--

INSERT INTO `libros` (`codigoLibro`, `nombreLibro`, `existencias`, `precio`, `codigoAutor`, `codigoEditorial`, `idGenero`, `descripcion`) VALUES
('0001', 'EL ZORRO2', 250, 45.00, '002', '0001', 4, 'sdsdsd'),
('0002', 'erase una vez', 1, 23.00, '001', '0001', 1, 'hola mundo hermoso 1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movimientos`
--

CREATE TABLE `movimientos` (
  `id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `codigoLibro` varchar(11) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `entrada` int(11) NOT NULL,
  `salida` int(11) NOT NULL,
  `saldo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `movimientos`
--

INSERT INTO `movimientos` (`id`, `fecha`, `codigoLibro`, `entrada`, `salida`, `saldo`) VALUES
(2, '2020-09-13', '0001', 12, 0, 12),
(3, '2020-09-13', '0001', 2, 0, 14),
(4, '2020-09-13', '0001', 0, 6, 8),
(5, '2020-10-16', '0002', 12, 0, 12),
(6, '2020-10-16', '0001', 0, 0, 16),
(9, '2020-10-16', '0001', 234, 0, 250),
(14, '2020-10-16', '0002', 50, 0, 62),
(15, '2020-10-16', '0002', 0, 0, 1),
(16, '2020-10-16', '0002', 0, 0, 1),
(17, '2020-10-16', '0002', 0, 0, 1),
(18, '2020-10-16', '0002', 0, 0, 1),
(19, '2020-10-16', '0002', 0, 0, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `autores`
--
ALTER TABLE `autores`
  ADD PRIMARY KEY (`codigoAutor`);

--
-- Indices de la tabla `editoriales`
--
ALTER TABLE `editoriales`
  ADD PRIMARY KEY (`codigoEditorial`);

--
-- Indices de la tabla `generos`
--
ALTER TABLE `generos`
  ADD PRIMARY KEY (`idGenero`);

--
-- Indices de la tabla `libros`
--
ALTER TABLE `libros`
  ADD PRIMARY KEY (`codigoLibro`),
  ADD KEY `fk_codigo` (`codigoAutor`),
  ADD KEY `fk_editorial` (`codigoEditorial`),
  ADD KEY `fk_genero` (`idGenero`);

--
-- Indices de la tabla `movimientos`
--
ALTER TABLE `movimientos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `codigoLibro` (`codigoLibro`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `generos`
--
ALTER TABLE `generos`
  MODIFY `idGenero` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `movimientos`
--
ALTER TABLE `movimientos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `libros`
--
ALTER TABLE `libros`
  ADD CONSTRAINT `fk_codigo` FOREIGN KEY (`codigoAutor`) REFERENCES `autores` (`codigoAutor`),
  ADD CONSTRAINT `fk_editorial` FOREIGN KEY (`codigoEditorial`) REFERENCES `editoriales` (`codigoEditorial`),
  ADD CONSTRAINT `fk_genero` FOREIGN KEY (`idGenero`) REFERENCES `generos` (`idGenero`);

--
-- Filtros para la tabla `movimientos`
--
ALTER TABLE `movimientos`
  ADD CONSTRAINT `movimientos_ibfk_1` FOREIGN KEY (`codigoLibro`) REFERENCES `libros` (`codigoLibro`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
