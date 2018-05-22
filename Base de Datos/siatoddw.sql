-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 02-04-2017 a las 01:53:08
-- Versión del servidor: 5.7.9
-- Versión de PHP: 5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `siatoddw`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dimclientes`
--

DROP TABLE IF EXISTS `dimclientes`;
CREATE TABLE IF NOT EXISTS `dimclientes` (
  `id_cliente` varchar(20) NOT NULL,
  `cliente_genero_id` int(10) NOT NULL,
  `cliente_ciudad_id` varchar(10) NOT NULL,
  `cliente_fecha_nacimiento` date DEFAULT NULL,
  `cliente_frecuencia` int(10) NOT NULL,
  `cliente_costacum_ventas` int(10) NOT NULL,
  PRIMARY KEY (`id_cliente`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `dimclientes`
--

INSERT INTO `dimclientes` (`id_cliente`, `cliente_genero_id`, `cliente_ciudad_id`, `cliente_fecha_nacimiento`, `cliente_frecuencia`, `cliente_costacum_ventas`) VALUES
('1113219112', 2, '76001', '1991-11-05', 1, 3500),
('1116222290', 1, '76834', '1991-04-26', 3, 9000),
('1116247618', 1, '76834', '2017-02-01', 0, 0),
('1116252828', 2, '76834', '1991-09-20', 3, 24000),
('1116323448', 2, '05001', '1995-11-25', 1, 6000),
('1117665123', 1, '76834', '1988-12-06', 2, 120000);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dimingredientes`
--

DROP TABLE IF EXISTS `dimingredientes`;
CREATE TABLE IF NOT EXISTS `dimingredientes` (
  `id_ingrediente` int(10) NOT NULL,
  `ingrediente_cantidad_minima` int(10) NOT NULL,
  `ingrediente_cantidad_maxima` int(10) NOT NULL,
  `ingrediente_cantidad_actual` int(10) NOT NULL,
  PRIMARY KEY (`id_ingrediente`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `dimingredientes`
--

INSERT INTO `dimingredientes` (`id_ingrediente`, `ingrediente_cantidad_minima`, `ingrediente_cantidad_maxima`, `ingrediente_cantidad_actual`) VALUES
(2, 10, 100, 500),
(3, 10, 100, 104),
(4, 10, 100, 2),
(5, 1, 2, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dimingreprodu`
--

DROP TABLE IF EXISTS `dimingreprodu`;
CREATE TABLE IF NOT EXISTS `dimingreprodu` (
  `ingreprodu_producto_id` int(10) NOT NULL,
  `ingreprodu_ingrediente_id` int(10) NOT NULL,
  `ingreprodu_cantidad` int(10) NOT NULL,
  PRIMARY KEY (`ingreprodu_producto_id`,`ingreprodu_ingrediente_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `dimingreprodu`
--

INSERT INTO `dimingreprodu` (`ingreprodu_producto_id`, `ingreprodu_ingrediente_id`, `ingreprodu_cantidad`) VALUES
(1, 2, 10),
(1, 3, 12),
(9, 2, 10),
(15, 4, 50),
(16, 4, 15),
(17, 5, 1),
(18, 2, 50),
(18, 3, 45);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dimmovicomp`
--

DROP TABLE IF EXISTS `dimmovicomp`;
CREATE TABLE IF NOT EXISTS `dimmovicomp` (
  `id_movicomp_compra` varchar(9) NOT NULL,
  `id_movicomp_secuencia` varchar(9) NOT NULL,
  `movicomp_ingrediente_id` int(10) NOT NULL,
  `movicomp_cantidad` int(10) NOT NULL,
  `movicomp_costo_unit` int(10) NOT NULL,
  `movicomp_costo_total` int(10) NOT NULL,
  `movicomp_bodega_id` varchar(5) NOT NULL,
  PRIMARY KEY (`id_movicomp_compra`,`id_movicomp_secuencia`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `dimmovicomp`
--

INSERT INTO `dimmovicomp` (`id_movicomp_compra`, `id_movicomp_secuencia`, `movicomp_ingrediente_id`, `movicomp_cantidad`, `movicomp_costo_unit`, `movicomp_costo_total`, `movicomp_bodega_id`) VALUES
('20160001', '2', 3, 4, 4000, 16000, 'BOD1'),
('20160002', '1', 4, 2, 50000, 100000, 'BOD1'),
('20160003', '1', 2, 500, 5000, 2500000, 'BOD1'),
('20160004', '1', 3, 100, 9000, 900000, 'BOD1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dimmovivent`
--

DROP TABLE IF EXISTS `dimmovivent`;
CREATE TABLE IF NOT EXISTS `dimmovivent` (
  `id_movivent_venta` varchar(9) NOT NULL,
  `id_movivent_secuencia` varchar(9) NOT NULL,
  `movivent_producto_id` int(10) NOT NULL,
  `movivent_cantidad` int(10) NOT NULL,
  `movivent_costo_unit` int(10) NOT NULL,
  `movivent_costo_total` int(10) NOT NULL,
  `movivent_bodega_id` varchar(5) NOT NULL,
  PRIMARY KEY (`id_movivent_venta`,`id_movivent_secuencia`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `dimmovivent`
--

INSERT INTO `dimmovivent` (`id_movivent_venta`, `id_movivent_secuencia`, `movivent_producto_id`, `movivent_cantidad`, `movivent_costo_unit`, `movivent_costo_total`, `movivent_bodega_id`) VALUES
('20170001', '2', 1, 1, 3000, 3000, 'BOD1'),
('20170001', '3', 1, 1, 3000, 3000, 'BOD1'),
('20170002', '1', 1, 1, 3000, 3000, 'BOD1'),
('20170003', '1', 16, 5, 12000, 60000, 'BOD1'),
('20170004', '1', 16, 5, 12000, 60000, 'BOD1'),
('20170005', '1', 17, 1, 3500, 3500, 'BOD1'),
('20170006', '1', 17, 1, 3000, 3000, 'BOD1'),
('20170007', '1', 17, 1, 3000, 3000, 'BOD1'),
('20170008', '1', 17, 1, 3000, 3000, 'BOD1'),
('20170009', '1', 1, 2, 4000, 8000, 'BOD1'),
('20170009', '2', 17, 1, 3000, 3000, 'BOD1'),
('20170010', '1', 1, 1, 3000, 3000, 'BOD1'),
('20170010', '2', 17, 1, 3000, 3000, 'BOD1'),
('20170010', '3', 18, 1, 4000, 4000, 'BOD1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dimproductos`
--

DROP TABLE IF EXISTS `dimproductos`;
CREATE TABLE IF NOT EXISTS `dimproductos` (
  `id_producto` int(10) NOT NULL,
  `producto_categoria_id` int(10) NOT NULL,
  PRIMARY KEY (`id_producto`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `dimproductos`
--

INSERT INTO `dimproductos` (`id_producto`, `producto_categoria_id`) VALUES
(1, 1),
(9, 1),
(13, 1),
(15, 4),
(16, 4),
(17, 20),
(18, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dimproveedores`
--

DROP TABLE IF EXISTS `dimproveedores`;
CREATE TABLE IF NOT EXISTS `dimproveedores` (
  `id_proveedor` varchar(20) NOT NULL,
  `proveedor_frecuencia` int(10) NOT NULL,
  `proveedor_costacum_compras` int(10) NOT NULL,
  PRIMARY KEY (`id_proveedor`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `dimproveedores`
--

INSERT INTO `dimproveedores` (`id_proveedor`, `proveedor_frecuencia`, `proveedor_costacum_compras`) VALUES
('0987-34', 2, 3400000),
('1234567', 2, 116000),
('5202521116-7', 0, 0),
('93451747-10', 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factcompras`
--

DROP TABLE IF EXISTS `factcompras`;
CREATE TABLE IF NOT EXISTS `factcompras` (
  `id_compra` varchar(9) NOT NULL,
  `compra_proveedor_id` varchar(20) NOT NULL,
  `compra_fecha` datetime NOT NULL,
  `compra_costo` int(10) NOT NULL,
  PRIMARY KEY (`id_compra`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `factcompras`
--

INSERT INTO `factcompras` (`id_compra`, `compra_proveedor_id`, `compra_fecha`, `compra_costo`) VALUES
('20160001', '1234567', '2017-01-05 00:00:00', 16000),
('20160002', '1234567', '2017-01-07 00:00:00', 100000),
('20160003', '0987-34', '2017-02-23 00:00:00', 2500000),
('20160004', '0987-34', '2017-02-23 00:00:00', 900000);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factventas`
--

DROP TABLE IF EXISTS `factventas`;
CREATE TABLE IF NOT EXISTS `factventas` (
  `id_venta` varchar(9) NOT NULL,
  `venta_cliente_id` varchar(20) NOT NULL,
  `venta_fecha` date NOT NULL,
  `venta_costo` int(10) NOT NULL,
  PRIMARY KEY (`id_venta`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `factventas`
--

INSERT INTO `factventas` (`id_venta`, `venta_cliente_id`, `venta_fecha`, `venta_costo`) VALUES
('20170001', '1116323448', '2017-01-05', 6000),
('20170002', '1116252828', '2017-01-07', 3000),
('20170003', '1117665123', '2017-01-29', 60000),
('20170004', '1117665123', '2017-01-29', 60000),
('20170005', '1113219112', '2017-02-11', 3500),
('20170006', '1116222290', '2017-02-23', 3000),
('20170007', '1116222290', '2017-02-22', 3000),
('20170008', '1116222290', '2017-02-18', 3000),
('20170009', '1116252828', '2017-02-23', 11000),
('20170010', '1116252828', '2017-03-09', 10000);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
