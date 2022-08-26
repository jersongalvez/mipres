-- phpMyAdmin SQL Dump
-- version 4.6.6deb5ubuntu0.5
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 01-12-2021 a las 13:42:29
-- Versión del servidor: 5.7.36-0ubuntu0.18.04.1
-- Versión de PHP: 7.2.24-0ubuntu0.18.04.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `gemapres`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `usuario` varchar(150) NOT NULL,
  `codigo` varchar(150) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `password` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`usuario`, `codigo`, `nombre`, `password`) VALUES
('ACASTRO', 'ACASTRO', 'USUARIO SIIMED', '456'),
('HERNANDEZ', 'HERNANDEZ', 'LAURA MELISSA HERNANDEZ HINESTROZA', 'ISABELLA'),
('IDIAZ', 'IDIAZ', 'LIDILIA ISABEL DIAZ CUELLO', 'matisa78'),
('JCRUZ ', 'JCRUZ ', 'JEAN KATHERIN CRUZ RUBIO', '5842'),
('JDUQUE', 'JDUQUE', 'JUAN SEBASTIAN DUQUE MEDINA', '04192001'),
('JSALAZAR', 'JSALAZAR', 'JESSICA ALEJANDRA SALAZAR TRUJILLO', 'LIAM23'),
('LCORTES', '1105', 'LUIS EDILSON CORTES LOZANO', '123'),
('LLGUZMAN', 'LLGUZMAN', 'LIZETH LORENA GUZMAN GARZON', '1318'),
('LOROZCO', '1110495817', 'LEIDY LORENA OROZCO RIVERA', 'LUCIANA'),
('MCAPERA', 'MCAPERA', 'MARINELA CAPERA YATE', '1991'),
('MHERNANDEZ', 'MHERNANDEZ', 'JULIETH MARCELA MEJIA HERNANDEZ', 'MHERNANDEZ'),
('RRAMIREZ', 'RRAMIREZ', 'MARGARITA ROSA RAMIREZ CASTRO', 'MAGUITOR90'),
('YZABALA', 'YZABALA', 'INGRID YIRLEY RODRIGUEZ ZABALA', 'EMILIANO2');
('JGALVEZ', 'JGALVEZ', 'JERSON GALVEZ ENSUNCHO', '2612');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`usuario`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
