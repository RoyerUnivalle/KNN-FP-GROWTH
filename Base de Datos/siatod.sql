-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 02-04-2017 a las 01:51:33
-- Versión del servidor: 5.7.9
-- Versión de PHP: 5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `siatod`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bodegas`
--

DROP TABLE IF EXISTS `bodegas`;
CREATE TABLE IF NOT EXISTS `bodegas` (
  `id_bodega` varchar(5) NOT NULL COMMENT 'Identificador de Bodega',
  `bodega_nombre` varchar(50) NOT NULL COMMENT 'Descripción de Bodega',
  `bodega_estado_id` int(11) NOT NULL COMMENT 'Estado de Bodega',
  PRIMARY KEY (`id_bodega`),
  KEY `estados_bodegas_fk` (`bodega_estado_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Bodegas';

--
-- Volcado de datos para la tabla `bodegas`
--

INSERT INTO `bodegas` (`id_bodega`, `bodega_nombre`, `bodega_estado_id`) VALUES
('BOD1', 'BODEGA PRINCIPAL', 1),
('BOD2', 'BODEGA PRÍNCIPE', 1),
('BOD3', 'BODEGA PRUEBA 3', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `campos_dw`
--

DROP TABLE IF EXISTS `campos_dw`;
CREATE TABLE IF NOT EXISTS `campos_dw` (
  `id_campo_dw` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador del Campo',
  `campo_tabla_dw_id` int(11) NOT NULL COMMENT 'Identificador Tabla',
  `campo_dw_nombre` varchar(40) NOT NULL COMMENT 'Nombre del Campo',
  `campo_dw_fecha_registro` datetime NOT NULL COMMENT 'Fecha Registro Campo',
  `campo_dw_fecha_ultimodi` datetime NOT NULL COMMENT 'Fecha Ultima Modificacion',
  PRIMARY KEY (`id_campo_dw`),
  KEY `tablas_dw_campos_dw_fk` (`campo_tabla_dw_id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=latin1 COMMENT='Campos de las Tablas del Data Mart';

--
-- Volcado de datos para la tabla `campos_dw`
--

INSERT INTO `campos_dw` (`id_campo_dw`, `campo_tabla_dw_id`, `campo_dw_nombre`, `campo_dw_fecha_registro`, `campo_dw_fecha_ultimodi`) VALUES
(1, 1, 'id_proveedor', '2016-10-29 11:07:01', '2016-11-16 23:19:12'),
(2, 1, 'proveedor_frecuencia', '2016-10-29 11:07:50', '2016-11-16 23:19:12'),
(3, 1, 'proveedor_costacum_compras', '2016-10-29 11:08:33', '2016-11-16 23:19:12'),
(4, 2, 'id_ingrediente', '2016-10-29 11:10:04', '2016-11-16 23:19:12'),
(5, 2, 'ingrediente_cantidad_minima', '2016-10-29 11:13:08', '2016-11-16 23:19:12'),
(6, 2, 'ingrediente_cantidad_maxima', '2016-10-29 11:13:34', '2016-11-16 23:19:12'),
(7, 2, 'ingrediente_cantidad_actual', '2016-10-29 11:14:02', '2016-11-16 23:19:12'),
(8, 3, 'id_compra', '2016-11-01 21:09:41', '2016-11-16 23:19:12'),
(9, 3, 'compra_proveedor_id', '2016-11-01 21:09:41', '2016-11-16 23:19:12'),
(10, 3, 'compra_fecha', '2016-11-01 21:10:41', '2016-11-16 23:19:12'),
(11, 3, 'compra_costo', '2016-11-01 21:10:41', '2016-11-16 23:19:12'),
(12, 4, 'id_movicomp_compra', '2016-11-01 21:11:50', '2016-11-16 23:19:12'),
(13, 4, 'id_movicomp_secuencia', '2016-11-01 21:11:50', '2016-11-16 23:19:12'),
(14, 4, 'movicomp_ingrediente_id', '2016-11-01 21:12:46', '2016-11-16 23:19:12'),
(15, 4, 'movicomp_cantidad', '2016-11-01 21:12:46', '2016-11-16 23:19:12'),
(16, 4, 'movicomp_costo_unit', '2016-11-01 21:13:40', '2016-11-16 23:19:12'),
(17, 4, 'movicomp_costo_total', '2016-11-01 21:13:40', '2016-11-16 23:19:12'),
(18, 4, 'movicomp_bodega_id', '2016-11-01 21:14:35', '2016-11-16 23:19:12'),
(20, 5, 'id_cliente', '2017-01-13 15:19:27', '2017-01-13 15:19:27'),
(21, 5, 'cliente_genero_id', '2017-01-13 15:19:27', '2017-01-13 15:19:27'),
(22, 5, 'cliente_ciudad_id', '2017-01-13 15:21:15', '2017-01-13 15:21:15'),
(23, 5, 'cliente_fecha_nacimiento', '2017-01-13 15:21:15', '2017-01-13 15:21:15'),
(24, 5, 'cliente_frecuencia', '2017-01-13 15:23:13', '2017-01-13 15:23:13'),
(25, 5, 'cliente_costacum_ventas', '2017-01-13 15:23:13', '2017-01-13 15:23:13'),
(26, 6, 'id_producto', '2017-01-14 17:24:15', '2017-01-14 17:24:15'),
(27, 6, 'producto_categoria_id', '2017-01-14 17:24:15', '2017-01-14 17:24:15'),
(28, 8, 'id_movivent_venta', '2017-01-14 18:09:06', '2017-01-14 18:09:06'),
(29, 8, 'id_movivent_secuencia', '2017-01-14 18:09:06', '2017-01-14 18:09:06'),
(30, 8, 'movivent_producto_id', '2017-01-14 18:11:46', '2017-01-14 18:11:46'),
(31, 8, 'movivent_cantidad', '2017-01-14 18:11:46', '2017-01-14 18:11:46'),
(32, 8, 'movivent_costo_unit', '2017-01-14 18:11:46', '2017-01-14 18:11:46'),
(33, 8, 'movivent_costo_total', '2017-01-14 18:11:46', '2017-01-14 18:22:42'),
(34, 8, 'movivent_bodega_id', '2017-01-14 18:11:46', '2017-01-14 18:11:46'),
(35, 7, 'id_venta', '2017-01-14 18:15:52', '2017-01-14 18:15:52'),
(36, 7, 'venta_cliente_id', '2017-01-14 18:15:52', '2017-01-14 18:15:52'),
(37, 7, 'venta_costo', '2017-01-14 18:15:52', '2017-01-14 18:15:52'),
(38, 7, 'venta_fecha', '2017-01-14 18:15:52', '2017-01-14 18:15:52'),
(39, 9, 'ingreprodu_producto_id', '2017-01-14 19:25:49', '2017-01-14 19:25:49'),
(40, 9, 'ingreprodu_ingrediente_id', '2017-01-14 19:25:49', '2017-01-14 19:25:49'),
(41, 9, 'ingreprodu_cantidad', '2017-01-14 19:25:49', '2017-01-14 19:25:49');

--
-- Disparadores `campos_dw`
--
DROP TRIGGER IF EXISTS `trgbinr_campos_dw`;
DELIMITER $$
CREATE TRIGGER `trgbinr_campos_dw` BEFORE INSERT ON `campos_dw` FOR EACH ROW SET NEW.campo_dw_fecha_registro = now(),
    NEW.campo_dw_fecha_ultimodi = now()
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `trgbupr_campos_dw`;
DELIMITER $$
CREATE TRIGGER `trgbupr_campos_dw` BEFORE UPDATE ON `campos_dw` FOR EACH ROW SET NEW.campo_dw_fecha_ultimodi = now()
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

DROP TABLE IF EXISTS `categorias`;
CREATE TABLE IF NOT EXISTS `categorias` (
  `id_categoria` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador de Categoria',
  `categoria_nombre` varchar(50) NOT NULL COMMENT 'Nombre de la Categoria',
  `categoria_fecha_registro` datetime NOT NULL COMMENT 'Fecha de registro de la Categoria',
  `categoria_persona_id` varchar(15) NOT NULL COMMENT 'Persona que registra la Categoria',
  `categoria_estado_id` int(11) NOT NULL COMMENT 'Identificador de Estado',
  PRIMARY KEY (`id_categoria`),
  KEY `estados_categorias_fk` (`categoria_estado_id`),
  KEY `personas_categorias_fk` (`categoria_persona_id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id_categoria`, `categoria_nombre`, `categoria_fecha_registro`, `categoria_persona_id`, `categoria_estado_id`) VALUES
(1, 'CHUZO', '2016-08-14 15:21:47', '1116250642', 1),
(2, 'PLATO FUERTE', '2016-08-14 15:21:47', '1116250642', 1),
(3, 'PICADA', '2016-08-14 15:21:47', '1116250642', 1),
(4, 'HAMBURGUESA', '2016-08-14 15:21:47', '1116250642', 1),
(5, 'PERRO', '2016-08-14 15:21:47', '1116250642', 1),
(7, 'SANDWICH', '2016-08-14 15:21:47', '1116250642', 1),
(8, 'SALCHIPAPA', '2016-08-14 15:21:47', '1116250642', 1),
(9, 'ADICIONALES', '2016-08-14 15:21:47', '1116250642', 1),
(10, 'COMBO 1', '2016-08-14 15:21:47', '1116250642', 1),
(11, 'COMBO 2', '2016-08-14 15:21:47', '1116250642', 1),
(12, 'COMBO 3', '2016-08-14 15:21:47', '1116250642', 1),
(13, 'COMBO 4', '2016-08-14 15:21:47', '1116250642', 1),
(14, 'COMBO 5', '2016-08-14 15:21:47', '1116250642', 1),
(15, 'FRANCESA', '2016-08-14 15:21:47', '1116250642', 1),
(16, 'HIT', '2016-08-14 15:21:47', '1116250642', 1),
(17, 'DULCES', '2016-08-14 15:21:47', '1116250642', 1),
(18, 'LECHE', '2016-08-14 15:21:47', '1116250642', 1),
(19, 'BEBIDAS', '2016-08-14 15:21:47', '1116250642', 1),
(20, 'VEGETALES', '2016-08-14 15:21:47', '1116250642', 1),
(21, 'TOCINETAS', '2016-08-14 15:21:47', '1116250642', 1),
(22, 'QUESO', '2016-08-14 15:21:47', '1116250642', 2),
(23, 'PAN', '2016-08-14 15:21:47', '1116250642', 1);

--
-- Disparadores `categorias`
--
DROP TRIGGER IF EXISTS `trgbins_categorias`;
DELIMITER $$
CREATE TRIGGER `trgbins_categorias` BEFORE INSERT ON `categorias` FOR EACH ROW SET NEW.categoria_fecha_registro = now()
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ciudades`
--

DROP TABLE IF EXISTS `ciudades`;
CREATE TABLE IF NOT EXISTS `ciudades` (
  `id_ciudad` varchar(10) NOT NULL COMMENT 'Código DANE de la Ciudad',
  `ciudad_nombre` varchar(30) NOT NULL COMMENT 'Nombre de la Ciudad',
  `ciudad_divipais_id` varchar(5) NOT NULL COMMENT 'Diviíson de la Ciudad',
  `ciudad_estado_id` int(11) NOT NULL COMMENT 'Estado de la Ciudad',
  PRIMARY KEY (`id_ciudad`),
  KEY `estados_ciudades_fk` (`ciudad_estado_id`),
  KEY `divipais_ciudades_fk` (`ciudad_divipais_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Ciudades';

--
-- Volcado de datos para la tabla `ciudades`
--

INSERT INTO `ciudades` (`id_ciudad`, `ciudad_nombre`, `ciudad_divipais_id`, `ciudad_estado_id`) VALUES
('05001', 'MEDELLÍN', '05', 1),
('08001', 'BARRANQUILLA', '08', 1),
('11001', 'BOGOTÁ D.C.', '11', 1),
('13001', 'CARTAGENA', '13', 1),
('15001', 'TUNJA', '15', 1),
('17001', 'MANIZALES', '17', 1),
('76001', 'SANTIAGO DE CALI', '76', 1),
('76109', 'BUENAVENTURA', '76', 1),
('76111', 'GUADALAJARA DE BUGA', '76', 1),
('76364', 'JAMUNDÍ', '76', 1),
('76520', 'PALMIRA', '76', 1),
('76834', 'TULUÁ', '76', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clasunid`
--

DROP TABLE IF EXISTS `clasunid`;
CREATE TABLE IF NOT EXISTS `clasunid` (
  `id_clasunid` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador de la Clase de Unidad',
  `clasunid_nombre` varchar(30) NOT NULL COMMENT 'Nombre de la Clase de Unidad',
  PRIMARY KEY (`id_clasunid`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1 COMMENT='Clases de Unidad';

--
-- Volcado de datos para la tabla `clasunid`
--

INSERT INTO `clasunid` (`id_clasunid`, `clasunid_nombre`) VALUES
(1, 'UNIDAD DE PESO'),
(2, 'UNIDAD DE PERIODO'),
(3, 'UNIDAD DE CAPACIDAD'),
(4, 'UNIDAD DE LONGITUD'),
(5, 'UNIDAD DE VOLUMEN'),
(6, 'UNIDAD DE AREA'),
(7, 'UNIDAD DE MEDIDA DE VELOCIDAD'),
(8, 'UNIDAD');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

DROP TABLE IF EXISTS `clientes`;
CREATE TABLE IF NOT EXISTS `clientes` (
  `id_cliente` varchar(20) NOT NULL COMMENT 'Identificador de Cliente',
  `cliente_nombre` varchar(100) NOT NULL COMMENT 'Descripción de Cliente',
  `cliente_genero_id` int(1) NOT NULL COMMENT 'Genero de Cliente (Masculino-M, Femenino-F)',
  `cliente_telefono` varchar(15) DEFAULT NULL COMMENT 'Teléfono de Cliente',
  `cliente_ciudad_id` varchar(10) NOT NULL COMMENT 'Identificador de la Ciudad',
  `cliente_direccion` varchar(100) DEFAULT NULL COMMENT 'Dirección de Cliente',
  `cliente_email` varchar(50) DEFAULT NULL COMMENT 'Correo Electrónico de Cliente',
  `cliente_estado_id` int(11) NOT NULL COMMENT 'Estado de Cliente',
  `cliente_fecha_nacimiento` date DEFAULT NULL COMMENT 'Fecha de Nacimiento de Cliente',
  `cliente_frecuencia` int(11) NOT NULL COMMENT 'Frecuencia acumulada de ventas',
  `cliente_costacum_ventas` int(11) NOT NULL COMMENT 'Costo acumulado de ventas',
  `cliente_fecha_registro` datetime NOT NULL COMMENT 'Fecha de Registro del Cliente',
  `cliente_persona_id` varchar(15) NOT NULL COMMENT 'Identificador de Persona que registra',
  PRIMARY KEY (`id_cliente`),
  KEY `generos_clientes_fk` (`cliente_genero_id`),
  KEY `estados_clientes_fk` (`cliente_estado_id`),
  KEY `ciudades_clientes_fk` (`cliente_ciudad_id`),
  KEY `personas_clientes_fk` (`cliente_persona_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Clientes';

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id_cliente`, `cliente_nombre`, `cliente_genero_id`, `cliente_telefono`, `cliente_ciudad_id`, `cliente_direccion`, `cliente_email`, `cliente_estado_id`, `cliente_fecha_nacimiento`, `cliente_frecuencia`, `cliente_costacum_ventas`, `cliente_fecha_registro`, `cliente_persona_id`) VALUES
('1113219112', 'MAIRA ALEJANDRA VICTORIA GOMEZ', 2, '.3453453443', '76001', '.caleeeeeeeeeeee', 'malejavictoria@gmail.com', 1, '1991-11-05', 1, 3500, '2016-10-08 18:48:53', '1116250642'),
('1116222290', 'CAMILO ANDRES PASMIN VEGA', 1, '2255634', '76834', '.', 'camilopasmin@hotmail.com', 1, '1991-04-26', 3, 9000, '2016-10-08 16:13:46', '1116250642'),
('1116247618', 'ESTRADA ROYER', 1, '343534', '76834', 'sfdsfsdsdf', 'sdfsd@ersd.com', 1, '2017-02-01', 0, 0, '2017-02-11 07:55:49', '1116250642'),
('1116252828', 'VIDALIA ZULUAGA LOZANO', 2, '.', '76834', '.', 'vidalia@gmail.com', 1, '1991-09-20', 3, 24000, '2017-01-07 19:24:20', '1116250642'),
('1116323448', 'PAOLA VELASQUEZ MEJIA', 2, '.', '05001', '.', 'paovela@gmail.com', 1, '1995-11-25', 1, 6000, '2017-01-05 17:57:22', '1116250642'),
('1117665123', 'ALEJANDRO JOSE COSTA BEDOYA', 1, '.', '76834', '.', 'alejo4costa@gmail.com', 1, '1988-12-06', 3, 120000, '2016-10-11 22:49:41', '1116250642');

--
-- Disparadores `clientes`
--
DROP TRIGGER IF EXISTS `trgbins_clientes`;
DELIMITER $$
CREATE TRIGGER `trgbins_clientes` BEFORE INSERT ON `clientes` FOR EACH ROW SET NEW.cliente_fecha_registro = now(),
    NEW.cliente_frecuencia = 0,
    NEW.cliente_costacum_ventas = 0
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compras`
--

DROP TABLE IF EXISTS `compras`;
CREATE TABLE IF NOT EXISTS `compras` (
  `id_compra` varchar(9) NOT NULL COMMENT 'Identificador de Compra',
  `compra_proveedor_id` varchar(20) NOT NULL COMMENT 'Proveedor de la Compra',
  `compra_fecha` date NOT NULL COMMENT 'Fecha de la Compra',
  `compra_costo` int(10) NOT NULL COMMENT 'Costo total de la Compra',
  `compra_descripcion` varchar(4000) NOT NULL COMMENT 'Descripción de la Compra',
  `compra_estado_id` int(11) NOT NULL COMMENT 'Estado de la Compra',
  PRIMARY KEY (`id_compra`),
  KEY `proveedores_compras_fk` (`compra_proveedor_id`),
  KEY `estados_compras_fk` (`compra_estado_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Compras';

--
-- Volcado de datos para la tabla `compras`
--

INSERT INTO `compras` (`id_compra`, `compra_proveedor_id`, `compra_fecha`, `compra_costo`, `compra_descripcion`, `compra_estado_id`) VALUES
('20160001', '1234567', '2017-01-05', 16000, '.', 1),
('20160002', '1234567', '2017-01-07', 100000, '.', 1),
('20160003', '0987-34', '2017-02-23', 2500000, '.', 1),
('20160004', '0987-34', '2017-02-23', 900000, '.', 1);

--
-- Disparadores `compras`
--
DROP TRIGGER IF EXISTS `trgadelr_compras`;
DELIMITER $$
CREATE TRIGGER `trgadelr_compras` AFTER DELETE ON `compras` FOR EACH ROW BEGIN
   
   UPDATE proveedores
      SET proveedor_frecuencia = proveedor_frecuencia - 1,
          proveedor_costacum_compras = proveedor_costacum_compras - OLD.compra_costo
    WHERE id_proveedor = OLD.compra_proveedor_id;
   
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `trgainr_compras`;
DELIMITER $$
CREATE TRIGGER `trgainr_compras` AFTER INSERT ON `compras` FOR EACH ROW BEGIN
   UPDATE proveedores
      SET proveedor_frecuencia = proveedor_frecuencia + 1
    WHERE id_proveedor = NEW.compra_proveedor_id;
   
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `trgaupr_compras`;
DELIMITER $$
CREATE TRIGGER `trgaupr_compras` AFTER UPDATE ON `compras` FOR EACH ROW BEGIN
   
   UPDATE proveedores
      SET proveedor_frecuencia = proveedor_frecuencia - 1,
          proveedor_costacum_compras = proveedor_costacum_compras - OLD.compra_costo
    WHERE id_proveedor = OLD.compra_proveedor_id;
   
   UPDATE proveedores
      SET proveedor_frecuencia = proveedor_frecuencia + 1,
          proveedor_costacum_compras = proveedor_costacum_compras + NEW.compra_costo
    WHERE id_proveedor = NEW.compra_proveedor_id;
    
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `trgbinr_compras`;
DELIMITER $$
CREATE TRIGGER `trgbinr_compras` BEFORE INSERT ON `compras` FOR EACH ROW SET NEW.compra_costo = 0
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `divipais`
--

DROP TABLE IF EXISTS `divipais`;
CREATE TABLE IF NOT EXISTS `divipais` (
  `id_divipais` varchar(5) NOT NULL COMMENT 'Identificador División País',
  `divipais_nombre` varchar(50) NOT NULL COMMENT 'Nombre de la División del País',
  `divipais_pais_id` varchar(5) NOT NULL COMMENT 'País de la División',
  `divipais_estado_id` int(11) NOT NULL COMMENT 'Estado de la División del País',
  PRIMARY KEY (`id_divipais`),
  KEY `estados_divipais_fk` (`divipais_estado_id`),
  KEY `paises_divipais_fk` (`divipais_pais_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Divisiones por Pais';

--
-- Volcado de datos para la tabla `divipais`
--

INSERT INTO `divipais` (`id_divipais`, `divipais_nombre`, `divipais_pais_id`, `divipais_estado_id`) VALUES
('05', 'ANTIOQUIA', '169', 1),
('08', 'ATLÁNTICO', '169', 1),
('11', 'BOGOTÁ D.C.', '169', 1),
('13', 'BOLÍVAR', '169', 1),
('15', 'BOYACÁ', '169', 1),
('17', 'CALDAS', '169', 1),
('18', 'CAQUETÁ', '169', 1),
('19', 'CAUCA', '169', 1),
('20', 'CESAR', '169', 1),
('23', 'CÓRDOBA', '169', 1),
('25', 'CUNDINAMARCA', '169', 1),
('27', 'CHOCÓ', '169', 1),
('41', 'HUILA', '169', 1),
('44', 'LA GUAJIRA', '169', 1),
('47', 'MAGDALENA', '169', 1),
('50', 'META', '169', 1),
('52', 'NARIÑO', '169', 1),
('54', 'NORTE DE SANTANDER', '169', 1),
('63', 'QUINDÍO', '169', 1),
('66', 'RISARALDA', '169', 1),
('68', 'SANTANDER', '169', 1),
('70', 'SUCRE', '169', 1),
('73', 'TOLIMA', '169', 1),
('76', 'VALLE DEL CAUCA', '169', 1),
('81', 'ARAUCA', '169', 1),
('85', 'CASANARE', '169', 1),
('86', 'PUTUMAYO', '169', 1),
('88', 'SAN ANDRÉS', '169', 1),
('91', 'AMAZONAS', '169', 1),
('94', 'GUAINÍA', '169', 1),
('95', 'GUAVIARE', '169', 1),
('97', 'VAUPÉS', '169', 1),
('99', 'VICHADA', '169', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresas`
--

DROP TABLE IF EXISTS `empresas`;
CREATE TABLE IF NOT EXISTS `empresas` (
  `id_empresa` varchar(10) NOT NULL COMMENT 'Identificador de Empresa',
  `empresa_nombre` varchar(100) NOT NULL COMMENT 'Descripción de Empresa',
  `empresa_nit` varchar(20) NOT NULL COMMENT 'NIT de Empresa',
  `empresa_razon_social` varchar(100) NOT NULL COMMENT 'Razón Social de Empresa',
  `empresa_direccion` varchar(100) NOT NULL COMMENT 'Dirección de Empresa',
  `empresa_telefono` varchar(15) NOT NULL COMMENT 'Teléfono de Empresa',
  `empresa_ciudad_id` varchar(5) NOT NULL COMMENT 'Ciudad de Empresa',
  `empresa_estado_id` int(11) NOT NULL COMMENT 'Estado de Empresa',
  PRIMARY KEY (`id_empresa`),
  KEY `estados_empresas_fk` (`empresa_estado_id`),
  KEY `ciudades_empresas_fk` (`empresa_ciudad_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Empresas';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estados`
--

DROP TABLE IF EXISTS `estados`;
CREATE TABLE IF NOT EXISTS `estados` (
  `id_estado` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador de Estado',
  `estado_descripcion` varchar(30) NOT NULL COMMENT 'Descripción de Estado',
  PRIMARY KEY (`id_estado`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `estados`
--

INSERT INTO `estados` (`id_estado`, `estado_descripcion`) VALUES
(1, 'Activo'),
(2, 'Inactivo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `generos`
--

DROP TABLE IF EXISTS `generos`;
CREATE TABLE IF NOT EXISTS `generos` (
  `id_genero` int(1) NOT NULL AUTO_INCREMENT COMMENT 'Identificador de Genero',
  `genero_descripcion` varchar(30) NOT NULL COMMENT 'Descripción de Género',
  `genero_estado_id` int(11) NOT NULL COMMENT 'Identificador de Estado',
  PRIMARY KEY (`id_genero`),
  KEY `estados_generos_fk` (`genero_estado_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `generos`
--

INSERT INTO `generos` (`id_genero`, `genero_descripcion`, `genero_estado_id`) VALUES
(1, 'Masculino', 1),
(2, 'Femenino', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingrebodes`
--

DROP TABLE IF EXISTS `ingrebodes`;
CREATE TABLE IF NOT EXISTS `ingrebodes` (
  `ingrebode_bodega_id` varchar(5) NOT NULL COMMENT 'Identificador de Bodega',
  `ingrebode_ingrediente_id` int(11) NOT NULL COMMENT 'Identificador de Ingrediente',
  `ingrebode_cantidad` int(5) NOT NULL COMMENT 'Cantidad de Ingrediente por Bodega',
  `ingrebode_fecha_registro` datetime NOT NULL COMMENT 'Fecha de registro del Ingrediente por Bodega',
  `ingrebode_persona_id` varchar(15) NOT NULL COMMENT 'Persona que registra el Ingrediente por Bodega',
  PRIMARY KEY (`ingrebode_bodega_id`,`ingrebode_ingrediente_id`),
  KEY `personas_ingrebodes_fk` (`ingrebode_persona_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Ingredientes por Bodega';

--
-- Volcado de datos para la tabla `ingrebodes`
--

INSERT INTO `ingrebodes` (`ingrebode_bodega_id`, `ingrebode_ingrediente_id`, `ingrebode_cantidad`, `ingrebode_fecha_registro`, `ingrebode_persona_id`) VALUES
('BOD1', 2, 2470, '2016-12-29 10:19:53', '1116250642'),
('BOD1', 3, 33, '2016-12-29 10:20:05', '1116250642'),
('BOD1', 4, 852, '2016-12-29 10:20:15', '1116250642'),
('BOD1', 5, 9, '2017-02-11 08:02:04', '1116250642'),
('BOD2', 2, 40, '2017-01-02 15:14:13', '1116250642'),
('BOD3', 2, 0, '2017-01-02 15:14:46', '1116250642'),
('BOD3', 3, 0, '2017-01-02 14:30:16', '1116250642');

--
-- Disparadores `ingrebodes`
--
DROP TRIGGER IF EXISTS `trgbins_ingrebodes`;
DELIMITER $$
CREATE TRIGGER `trgbins_ingrebodes` BEFORE INSERT ON `ingrebodes` FOR EACH ROW SET NEW.ingrebode_fecha_registro = now()
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingredientes`
--

DROP TABLE IF EXISTS `ingredientes`;
CREATE TABLE IF NOT EXISTS `ingredientes` (
  `id_ingrediente` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador de Ingrediente',
  `ingrediente_nombre` varchar(70) NOT NULL COMMENT 'Descripción de Ingrediente',
  `ingrediente_cantidad_minima` int(5) NOT NULL COMMENT 'Cantidad Minima Ingrediente',
  `ingrediente_cantidad_maxima` int(5) NOT NULL COMMENT 'Cantidad Maxima Ingrediente',
  `ingrediente_cantidad_actual` int(5) NOT NULL COMMENT 'Cantidad Actual Ingrediente',
  `ingrediente_unidad_id` varchar(4) NOT NULL COMMENT 'Identificador de la Unidad del Ingrediente',
  `ingrediente_fecha_registro` datetime NOT NULL COMMENT 'Fecha de registro del Ingrediente',
  `ingrediente_persona_id` varchar(15) NOT NULL COMMENT 'Persona que registra el Ingrediente',
  `ingrediente_estado_id` int(11) NOT NULL COMMENT 'Estado del Ingrediente',
  PRIMARY KEY (`id_ingrediente`),
  KEY `estados_ingredientes_fk` (`ingrediente_estado_id`),
  KEY `personas_ingredientes_fk` (`ingrediente_persona_id`),
  KEY `unidades_ingredientes_fk` (`ingrediente_unidad_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1 COMMENT='Ingredientes';

--
-- Volcado de datos para la tabla `ingredientes`
--

INSERT INTO `ingredientes` (`id_ingrediente`, `ingrediente_nombre`, `ingrediente_cantidad_minima`, `ingrediente_cantidad_maxima`, `ingrediente_cantidad_actual`, `ingrediente_unidad_id`, `ingrediente_fecha_registro`, `ingrediente_persona_id`, `ingrediente_estado_id`) VALUES
(2, 'PRUEBA', 10, 100, 500, 'GRS', '2016-08-20 08:22:22', '1116250642', 1),
(3, 'PRUEBA INGR 2', 10, 100, 104, 'GRS', '2016-08-20 08:22:57', '1116250642', 1),
(4, 'PRUEBA INGR 3', 10, 100, 2, 'BLO', '2016-10-30 22:06:12', '1116250642', 1),
(5, 'INGREDIENTE PARA PATATA', 1, 2, 0, 'BUL', '2017-02-11 07:48:51', '1116250642', 1);

--
-- Disparadores `ingredientes`
--
DROP TRIGGER IF EXISTS `trgbins_ingredientes`;
DELIMITER $$
CREATE TRIGGER `trgbins_ingredientes` BEFORE INSERT ON `ingredientes` FOR EACH ROW SET NEW.ingrediente_fecha_registro = now()
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingreprodu`
--

DROP TABLE IF EXISTS `ingreprodu`;
CREATE TABLE IF NOT EXISTS `ingreprodu` (
  `ingreprodu_producto_id` int(11) NOT NULL COMMENT 'Identificador de Producto',
  `ingreprodu_ingrediente_id` int(11) NOT NULL COMMENT 'Identificador de Ingrediente',
  `ingreprodu_unidad_id` varchar(4) NOT NULL COMMENT 'Unidad de Ingrediente',
  `ingreprodu_cantidad` int(10) NOT NULL COMMENT 'Cantidad de Ingrediente',
  `ingreprodu_fecha_registro` datetime NOT NULL COMMENT 'Fecha de registro del Ingrediente por Producto',
  `ingreprodu_persona_id` varchar(15) NOT NULL COMMENT 'Persona que registra el Ingrediente por Producto',
  `ingreprodu_estado_id` int(11) NOT NULL COMMENT 'Estado del Ingrediente por Producto',
  PRIMARY KEY (`ingreprodu_producto_id`,`ingreprodu_ingrediente_id`),
  KEY `estados_ingreprodu_fk` (`ingreprodu_estado_id`),
  KEY `ingredientes_ingreprodu_fk` (`ingreprodu_ingrediente_id`),
  KEY `personas_ingreprodu_fk` (`ingreprodu_persona_id`),
  KEY `unidades_ingreprodu_fk` (`ingreprodu_unidad_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Ingredientes por Producto';

--
-- Volcado de datos para la tabla `ingreprodu`
--

INSERT INTO `ingreprodu` (`ingreprodu_producto_id`, `ingreprodu_ingrediente_id`, `ingreprodu_unidad_id`, `ingreprodu_cantidad`, `ingreprodu_fecha_registro`, `ingreprodu_persona_id`, `ingreprodu_estado_id`) VALUES
(1, 2, 'GRS', 10, '2017-01-11 10:26:53', '1116250642', 1),
(1, 3, 'GRS', 12, '2017-01-11 11:02:59', '1116250642', 1),
(9, 2, 'GRS', 10, '2017-01-11 11:04:55', '1116250642', 1),
(15, 4, 'GRS', 100, '2017-03-09 23:53:47', '1116250642', 1),
(16, 4, 'GRS', 15, '2017-01-29 11:01:48', '1116250642', 1),
(17, 5, 'BUL', 1, '2017-02-11 07:50:12', '1116250642', 1),
(18, 2, 'GRS', 50, '2017-03-08 23:38:30', '1116250642', 1),
(18, 3, 'GRS', 45, '2017-03-08 23:38:56', '1116250642', 1),
(18, 5, 'GRS', 100, '2017-03-25 11:42:51', '1116250642', 1);

--
-- Disparadores `ingreprodu`
--
DROP TRIGGER IF EXISTS `trgbins_ingreprodu`;
DELIMITER $$
CREATE TRIGGER `trgbins_ingreprodu` BEFORE INSERT ON `ingreprodu` FOR EACH ROW SET NEW.ingreprodu_fecha_registro = now()
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modulos`
--

DROP TABLE IF EXISTS `modulos`;
CREATE TABLE IF NOT EXISTS `modulos` (
  `id_modulo` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador de Modulo',
  `modulo_nombre` varchar(70) NOT NULL COMMENT 'Descripción de Modulo',
  `modulo_estado_id` int(11) NOT NULL COMMENT 'Identificador de Estado',
  PRIMARY KEY (`id_modulo`),
  KEY `estados_modulos_fk` (`modulo_estado_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1 COMMENT='Modulos';

--
-- Volcado de datos para la tabla `modulos`
--

INSERT INTO `modulos` (`id_modulo`, `modulo_nombre`, `modulo_estado_id`) VALUES
(1, 'Usuarios', 1),
(2, 'Productos', 1),
(3, 'Terceros', 1),
(5, 'Trámites', 1),
(6, 'Datos Básicos', 1),
(7, 'Inteligencia de Negocio', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movicomp`
--

DROP TABLE IF EXISTS `movicomp`;
CREATE TABLE IF NOT EXISTS `movicomp` (
  `id_movicomp_compra` varchar(9) NOT NULL COMMENT 'Identificador de Compra',
  `id_movicomp_secuencia` varchar(9) NOT NULL COMMENT 'Secuencia del Movimiento de Compra',
  `movicomp_ingrediente_id` int(11) NOT NULL COMMENT 'Ingrediente del Movimiento de Compra',
  `movicomp_cantidad` int(10) NOT NULL COMMENT 'Cantidad del Ingrediente del Movimiento de Compra',
  `movicomp_costo_unit` int(10) NOT NULL COMMENT 'Costo Unitario de Movimiento de Compra',
  `movicomp_costo_total` int(10) NOT NULL COMMENT 'Costo Total de Movimiento de Compra',
  `movicomp_bodega_id` varchar(5) NOT NULL COMMENT 'Bodega de almacenamiento del Ingrediente',
  `movicomp_estado_id` int(11) NOT NULL COMMENT 'Estado del Movimiento de Compra',
  `movicomp_fecha_vencimiento` date DEFAULT NULL COMMENT 'Fecha de Vencimiento del Ingrediente comprado',
  `movicomp_fecha_registro` datetime NOT NULL COMMENT 'Fecha de registro',
  `movicomp_persona_id` varchar(15) NOT NULL COMMENT 'Persona que registra',
  PRIMARY KEY (`id_movicomp_compra`,`id_movicomp_secuencia`),
  KEY `ingredientes_movicomp_fk` (`movicomp_ingrediente_id`),
  KEY `estados_movicomp_fk` (`movicomp_estado_id`),
  KEY `personas_movicomp_fk` (`movicomp_persona_id`),
  KEY `bodegas_movicomp_fk` (`movicomp_bodega_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Movimientos de Compra';

--
-- Volcado de datos para la tabla `movicomp`
--

INSERT INTO `movicomp` (`id_movicomp_compra`, `id_movicomp_secuencia`, `movicomp_ingrediente_id`, `movicomp_cantidad`, `movicomp_costo_unit`, `movicomp_costo_total`, `movicomp_bodega_id`, `movicomp_estado_id`, `movicomp_fecha_vencimiento`, `movicomp_fecha_registro`, `movicomp_persona_id`) VALUES
('20160001', '2', 3, 4, 4000, 16000, 'BOD1', 1, NULL, '2017-01-05 12:32:20', '1116250642'),
('20160002', '1', 4, 2, 50000, 100000, 'BOD1', 1, NULL, '2017-01-07 19:27:34', '1116250642'),
('20160003', '1', 2, 500, 5000, 2500000, 'BOD1', 1, NULL, '2017-02-23 22:23:01', '1116250642'),
('20160004', '1', 3, 100, 9000, 900000, 'BOD1', 1, NULL, '2017-02-23 22:24:27', '1116250642');

--
-- Disparadores `movicomp`
--
DROP TRIGGER IF EXISTS `trgadel_movicomp`;
DELIMITER $$
CREATE TRIGGER `trgadel_movicomp` AFTER DELETE ON `movicomp` FOR EACH ROW BEGIN
UPDATE compras
   SET compra_costo = compra_costo - OLD.movicomp_costo_total
 WHERE id_compra = OLD.id_movicomp_compra;
 
UPDATE ingredientes
    SET ingrediente_cantidad_actual = ingrediente_cantidad_actual - OLD.movicomp_cantidad
  WHERE id_ingrediente = OLD.movicomp_ingrediente_id;

UPDATE ingrebodes
    SET ingrebode_cantidad = ingrebode_cantidad - OLD.movicomp_cantidad
  WHERE ingrebode_bodega_id = OLD.movicomp_bodega_id
    AND ingrebode_ingrediente_id = OLD.movicomp_ingrediente_id;
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `trgains_movicomp`;
DELIMITER $$
CREATE TRIGGER `trgains_movicomp` AFTER INSERT ON `movicomp` FOR EACH ROW BEGIN
UPDATE compras
   SET compras.compra_costo = compras.compra_costo + NEW.movicomp_costo_total
 WHERE compras.id_compra = NEW.id_movicomp_compra;
 
UPDATE ingredientes
    SET ingrediente_cantidad_actual = ingrediente_cantidad_actual + NEW.movicomp_cantidad
  WHERE id_ingrediente = NEW.movicomp_ingrediente_id;
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `trgaupd_movicomp`;
DELIMITER $$
CREATE TRIGGER `trgaupd_movicomp` AFTER UPDATE ON `movicomp` FOR EACH ROW BEGIN
IF(NEW.movicomp_costo_total != OLD.movicomp_costo_total)THEN
UPDATE compras
   SET compra_costo = compra_costo - OLD.movicomp_costo_total + NEW.movicomp_costo_total
 WHERE id_compra = NEW.id_movicomp_compra;
 END IF;
 
 IF(NEW.movicomp_cantidad != OLD.movicomp_cantidad)THEN
UPDATE ingredientes
    SET ingrediente_cantidad_actual = ingrediente_cantidad_actual - OLD.movicomp_cantidad + NEW.movicomp_cantidad
  WHERE id_ingrediente = NEW.movicomp_ingrediente_id;

UPDATE ingrebodes
    SET ingrebode_cantidad = ingrebode_cantidad - OLD.movicomp_cantidad + NEW.movicomp_cantidad
  WHERE ingrebode_bodega_id = NEW.movicomp_bodega_id
    AND ingrebode_ingrediente_id = NEW.movicomp_ingrediente_id;
END IF;
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `trgbins_movicomp`;
DELIMITER $$
CREATE TRIGGER `trgbins_movicomp` BEFORE INSERT ON `movicomp` FOR EACH ROW SET NEW.movicomp_fecha_registro = now(),
    NEW.movicomp_costo_total = NEW.movicomp_costo_unit * NEW.movicomp_cantidad
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movitras`
--

DROP TABLE IF EXISTS `movitras`;
CREATE TABLE IF NOT EXISTS `movitras` (
  `id_movitras` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador de Movimiento de Traslado',
  `movitras_bodefuen_id` varchar(5) NOT NULL COMMENT 'Identificador de la Bodega Fuente',
  `movitras_bodedest_id` varchar(5) NOT NULL COMMENT 'Identificador de la Bodega Destino',
  `movitras_ingrediente_id` int(11) NOT NULL COMMENT 'Identificador de Ingrediente',
  `movitras_cantidad` int(11) NOT NULL COMMENT 'Cantidad del Ingrediente a trasladar',
  `movitras_observacion` varchar(4000) NOT NULL COMMENT 'Observación del Traslado de Bodega',
  `movitras_fecha_registro` datetime NOT NULL COMMENT 'Fecha de registro',
  `movitras_persona_id` varchar(15) NOT NULL COMMENT 'Persona que registra el Movimiento de Traslado',
  PRIMARY KEY (`id_movitras`),
  KEY `bodedest_movitras_fk` (`movitras_bodedest_id`),
  KEY `personas_movitras_fk` (`movitras_persona_id`),
  KEY `bodefuen_movitras_fk` (`movitras_bodefuen_id`),
  KEY `ingredientes_movitras_fk` (`movitras_ingrediente_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1 COMMENT='Movimientos de Traslado de Bodega';

--
-- Volcado de datos para la tabla `movitras`
--

INSERT INTO `movitras` (`id_movitras`, `movitras_bodefuen_id`, `movitras_bodedest_id`, `movitras_ingrediente_id`, `movitras_cantidad`, `movitras_observacion`, `movitras_fecha_registro`, `movitras_persona_id`) VALUES
(3, 'BOD1', 'BOD2', 2, 40, '.', '2016-09-22 22:36:06', '1116250642'),
(4, 'BOD1', 'BOD2', 2, 45, '.', '2016-09-22 22:53:58', '1116250642'),
(14, 'BOD2', 'BOD1', 2, 30, '.', '2016-09-22 23:24:07', '1116250642'),
(15, 'BOD1', 'BOD3', 3, 25, '.', '2016-09-22 23:25:16', '1116250642'),
(16, 'BOD3', 'BOD2', 3, 12, '.', '2016-09-22 23:26:23', '1116250642'),
(17, 'BOD3', 'BOD2', 3, 13, '.', '2016-09-22 23:29:38', '1116250642'),
(18, 'BOD1', 'BOD3', 2, 10, '.', '2016-09-22 23:31:02', '1116250642'),
(19, 'BOD1', 'BOD2', 2, 20, 'ABASTECIMIENTO BODEGA PRÍNCIPE', '2017-03-25 17:54:57', '1116250642'),
(20, 'BOD1', 'BOD2', 2, 20, 'ABASTECIMIENTO BODEGA PRÍNCIPE', '2017-03-25 17:57:23', '1116250642');

--
-- Disparadores `movitras`
--
DROP TRIGGER IF EXISTS `trgbinr_movitras`;
DELIMITER $$
CREATE TRIGGER `trgbinr_movitras` BEFORE INSERT ON `movitras` FOR EACH ROW SET NEW.movitras_fecha_registro = now()
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movivent`
--

DROP TABLE IF EXISTS `movivent`;
CREATE TABLE IF NOT EXISTS `movivent` (
  `id_movivent_venta` varchar(9) NOT NULL COMMENT 'Identificador de la Venta',
  `id_movivent_secuencia` varchar(9) NOT NULL COMMENT 'Secuencia del Movimiento de Venta',
  `movivent_producto_id` int(11) NOT NULL COMMENT 'Identificador del Producto',
  `movivent_cantidad` int(10) NOT NULL COMMENT 'Cantidad del Producto',
  `movivent_costo_unit` int(10) NOT NULL COMMENT 'Costo Unitario del Producto',
  `movivent_costo_total` int(10) NOT NULL COMMENT 'Costo Total del Movimiento de Venta',
  `movivent_bodega_id` varchar(5) NOT NULL COMMENT 'Identificador de Bodega',
  `movivent_estado_id` int(11) NOT NULL COMMENT 'Identificador de Estado',
  `movivent_fecha_registro` datetime NOT NULL COMMENT 'Fecha de Registro del Movimiento de Venta',
  `movivent_persona_id` varchar(15) NOT NULL COMMENT 'Persona que Registra',
  PRIMARY KEY (`id_movivent_venta`,`id_movivent_secuencia`),
  KEY `productos_movivent_fk` (`movivent_producto_id`),
  KEY `bodegas_movivent_fk` (`movivent_bodega_id`),
  KEY `estados_movivent_fk` (`movivent_estado_id`),
  KEY `personas_movivent_fk` (`movivent_persona_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Movimientos de Venta';

--
-- Volcado de datos para la tabla `movivent`
--

INSERT INTO `movivent` (`id_movivent_venta`, `id_movivent_secuencia`, `movivent_producto_id`, `movivent_cantidad`, `movivent_costo_unit`, `movivent_costo_total`, `movivent_bodega_id`, `movivent_estado_id`, `movivent_fecha_registro`, `movivent_persona_id`) VALUES
('20170001', '2', 1, 1, 3000, 3000, 'BOD1', 1, '2017-01-06 11:37:03', '1116250642'),
('20170001', '3', 1, 1, 3000, 3000, 'BOD1', 1, '2017-01-07 07:52:44', '1116250642'),
('20170002', '1', 1, 1, 3000, 3000, 'BOD1', 1, '2017-01-07 19:29:50', '1116250642'),
('20170003', '1', 16, 5, 12000, 60000, 'BOD1', 1, '2017-01-29 11:06:04', '1116250642'),
('20170004', '1', 16, 5, 12000, 60000, 'BOD1', 1, '2017-01-29 11:59:08', '1116250642'),
('20170005', '1', 17, 1, 3500, 3500, 'BOD1', 1, '2017-02-11 08:03:16', '1116250642'),
('20170006', '1', 17, 1, 3000, 3000, 'BOD1', 1, '2017-02-23 21:40:00', '1116250642'),
('20170007', '1', 17, 1, 3000, 3000, 'BOD1', 1, '2017-02-23 21:40:53', '1116250642'),
('20170008', '1', 17, 1, 3000, 3000, 'BOD1', 1, '2017-02-23 21:41:32', '1116250642'),
('20170009', '1', 1, 2, 4000, 8000, 'BOD1', 1, '2017-02-23 22:24:54', '1116250642'),
('20170009', '2', 17, 1, 3000, 3000, 'BOD1', 1, '2017-03-09 18:43:08', '1116250642'),
('20170010', '1', 1, 1, 3000, 3000, 'BOD1', 1, '2017-03-09 18:43:40', '1116250642'),
('20170010', '2', 17, 1, 3000, 3000, 'BOD1', 1, '2017-03-09 18:43:51', '1116250642'),
('20170010', '3', 18, 1, 4000, 4000, 'BOD1', 1, '2017-03-09 18:44:07', '1116250642');

--
-- Disparadores `movivent`
--
DROP TRIGGER IF EXISTS `trgadel_movivent`;
DELIMITER $$
CREATE TRIGGER `trgadel_movivent` AFTER DELETE ON `movivent` FOR EACH ROW BEGIN
UPDATE ventas
   SET venta_costo = venta_costo - OLD.movivent_costo_total
 WHERE id_venta = OLD.id_movivent_venta;
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `trgains_movivent`;
DELIMITER $$
CREATE TRIGGER `trgains_movivent` AFTER INSERT ON `movivent` FOR EACH ROW BEGIN
UPDATE ventas
   SET ventas.venta_costo = ventas.venta_costo + NEW.movivent_costo_total
 WHERE ventas.id_venta = NEW.id_movivent_venta;
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `trgbins_movivent`;
DELIMITER $$
CREATE TRIGGER `trgbins_movivent` BEFORE INSERT ON `movivent` FOR EACH ROW SET NEW.movivent_fecha_registro = now(),
    NEW.movivent_costo_total = NEW.movivent_costo_unit * NEW.movivent_cantidad
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `opciones`
--

DROP TABLE IF EXISTS `opciones`;
CREATE TABLE IF NOT EXISTS `opciones` (
  `id_opcion` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador de Opción',
  `opcion_nombre` varchar(60) NOT NULL COMMENT 'Descripción de Opción',
  `opcion_submodulo_id` int(11) NOT NULL COMMENT 'Identificador de Submódulo',
  `opcion_estado_id` int(11) NOT NULL COMMENT 'Identificador de Estado',
  `opcion_metodo` varchar(400) NOT NULL COMMENT 'URL del método a ejecutar',
  PRIMARY KEY (`id_opcion`),
  KEY `submodulos_opciones_fk` (`opcion_submodulo_id`),
  KEY `estados_opciones_fk` (`opcion_estado_id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=latin1 COMMENT='Opciones';

--
-- Volcado de datos para la tabla `opciones`
--

INSERT INTO `opciones` (`id_opcion`, `opcion_nombre`, `opcion_submodulo_id`, `opcion_estado_id`, `opcion_metodo`) VALUES
(1, 'Crear Usuario', 1, 1, 'usuarios/crearUsuario'),
(2, 'Modificar Usuario', 1, 2, 'usuarios/modificarUsuario'),
(3, 'Consultar Usuario', 1, 1, 'usuarios/consultarUsuario'),
(4, 'Eliminar Usuario', 1, 2, 'usuarios/eliminarUsuario'),
(5, 'Crear Producto', 2, 1, 'productos/crearProducto'),
(6, 'Modificar Producto', 2, 2, 'productos/modificarProducto'),
(7, 'Consultar Producto', 2, 1, 'productos/consultarProducto'),
(8, 'Eliminar Producto', 2, 2, 'productos/eliminarProducto'),
(9, 'Reporte Mensual Usuario', 3, 1, 'usuarios/reporteMensUsua'),
(10, 'Crear Proveedor', 4, 1, 'proveedores/crearProveedor'),
(11, 'Modificar Proveedor', 4, 2, 'proveedores/modificarProveedor'),
(12, 'Consultar Proveedor', 4, 1, 'proveedores/consultarProveedor'),
(13, 'Eliminar Proveedor', 4, 2, 'proveedores/eliminarProveedor'),
(14, 'Crear Cliente', 5, 1, 'clientes/crearCliente'),
(15, 'Modificar Cliente', 5, 2, 'clientes/modificarCliente'),
(16, 'Consultar Cliente', 5, 1, 'clientes/consultarCliente'),
(17, 'Eliminar Cliente', 5, 2, 'clientes/eliminarCliente'),
(18, 'Crear Persona', 6, 1, 'personas/crearPersona'),
(19, 'Modificar Persona', 6, 2, 'personas/modificarPersona'),
(20, 'Consultar Persona', 6, 1, 'personas/consultarPersona'),
(21, 'Eliminar Persona', 6, 2, 'personas/eliminarPersona'),
(22, 'Crear Categoría', 7, 1, 'categorias/crearCategoria'),
(23, 'Modificar Categoría', 7, 2, 'categorias/modificarCategoria'),
(24, 'Consultar Categoría', 7, 1, 'categorias/consultarCategoria'),
(25, 'Eliminar Categorías', 7, 2, 'categorias/eliminarCategoria'),
(26, 'Registrar Compra', 8, 1, 'compras/crearCompra'),
(27, 'Crear Ingrediente', 9, 1, 'ingredientes/crearIngrediente'),
(28, 'Composición de Producto', 2, 1, 'ingreprodus/componerProducto'),
(29, 'Crear Bodega', 10, 1, 'bodegas/crearBodega'),
(30, 'Registrar Traslado de Bodega', 11, 1, 'movitras/crearMovitras'),
(31, 'Sincronizar Datos de Análisis', 12, 1, 'bi/sincronizaDW_vista'),
(32, 'Analizar Compras', 14, 1, 'bi/biCompras'),
(33, 'Consultar Compra', 8, 1, 'compras/consultarCompra'),
(34, 'Registrar Venta', 13, 1, 'ventas/crearVenta'),
(35, 'Consultar Venta', 13, 1, 'ventas/consultarVenta'),
(36, 'Consultar Ingrediente', 9, 1, 'ingredientes/consultarIngrediente'),
(37, 'Consultar Bodega', 10, 1, 'bodegas/consultarBodega'),
(38, 'Consultar Ingredientes por Bodega', 9, 1, 'ingrebodes/consultarIngreBode'),
(39, 'Consultar Traslado de Bodega', 11, 1, 'movitras/consultarMovitras'),
(40, 'Analizar Ventas', 14, 1, 'bi/biVentas'),
(41, 'Analizar Compras', 14, 1, 'bi/biCompras');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `opciperf`
--

DROP TABLE IF EXISTS `opciperf`;
CREATE TABLE IF NOT EXISTS `opciperf` (
  `opciperf_perfil_id` int(11) NOT NULL COMMENT 'Identificador de Perfil',
  `opciperf_opcion_id` int(11) NOT NULL COMMENT 'Identificador de Opción',
  `opciperf_estado_id` int(11) NOT NULL COMMENT 'Identificador de Estado',
  KEY `opciones_opciperf_fk` (`opciperf_opcion_id`),
  KEY `perfiles_opciperf_fk` (`opciperf_perfil_id`),
  KEY `estados_opciperf_fk` (`opciperf_estado_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Modulos por Perfil';

--
-- Volcado de datos para la tabla `opciperf`
--

INSERT INTO `opciperf` (`opciperf_perfil_id`, `opciperf_opcion_id`, `opciperf_estado_id`) VALUES
(1, 1, 1),
(1, 2, 1),
(1, 3, 1),
(1, 4, 1),
(1, 5, 1),
(1, 6, 1),
(1, 7, 1),
(1, 8, 1),
(2, 3, 1),
(2, 7, 1),
(2, 1, 2),
(2, 2, 2),
(2, 4, 2),
(2, 5, 2),
(2, 6, 2),
(2, 8, 2),
(1, 10, 1),
(1, 11, 1),
(1, 12, 1),
(1, 13, 1),
(1, 14, 1),
(1, 15, 1),
(1, 16, 1),
(1, 17, 1),
(1, 18, 1),
(1, 19, 1),
(1, 20, 1),
(1, 21, 1),
(1, 22, 1),
(1, 23, 1),
(1, 24, 1),
(1, 25, 1),
(1, 26, 1),
(1, 27, 1),
(1, 28, 1),
(1, 29, 1),
(1, 30, 1),
(1, 31, 1),
(1, 32, 1),
(1, 33, 1),
(1, 34, 1),
(1, 35, 1),
(1, 36, 1),
(1, 37, 1),
(1, 38, 1),
(1, 39, 1),
(1, 40, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paises`
--

DROP TABLE IF EXISTS `paises`;
CREATE TABLE IF NOT EXISTS `paises` (
  `id_pais` varchar(5) NOT NULL COMMENT 'Identificador de País',
  `pais_nombre` varchar(50) NOT NULL COMMENT 'Nombre del País',
  `pais_estado_id` int(11) NOT NULL COMMENT 'Estado del País',
  PRIMARY KEY (`id_pais`),
  KEY `estados_paises_fk` (`pais_estado_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `paises`
--

INSERT INTO `paises` (`id_pais`, `pais_nombre`, `pais_estado_id`) VALUES
('169', 'COLOMBIA', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfiles`
--

DROP TABLE IF EXISTS `perfiles`;
CREATE TABLE IF NOT EXISTS `perfiles` (
  `id_perfil` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador de Perfil',
  `perfil_nombre` varchar(30) NOT NULL COMMENT 'Descripción de Perfil',
  `perfil_estado_id` int(11) NOT NULL COMMENT 'Identificador de Estado',
  PRIMARY KEY (`id_perfil`),
  KEY `estados_perfiles_fk` (`perfil_estado_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COMMENT='Perfiles';

--
-- Volcado de datos para la tabla `perfiles`
--

INSERT INTO `perfiles` (`id_perfil`, `perfil_nombre`, `perfil_estado_id`) VALUES
(1, 'Administrador', 1),
(2, 'Invitado', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personas`
--

DROP TABLE IF EXISTS `personas`;
CREATE TABLE IF NOT EXISTS `personas` (
  `id_persona` varchar(15) NOT NULL COMMENT 'Identificador de la Persona',
  `persona_nombre` varchar(30) NOT NULL COMMENT 'Nombre(s) de la Persona',
  `persona_apellido` varchar(30) NOT NULL COMMENT 'Apellido(s) de la Persona',
  `persona_email` varchar(50) NOT NULL COMMENT 'Correo electrónico de la Persona',
  `persona_ciudad_id` varchar(10) NOT NULL COMMENT 'Ciudad de residencia la Persona',
  `persona_direccion` varchar(100) NOT NULL COMMENT 'Dirección de la Persona',
  `persona_telefono` varchar(15) NOT NULL COMMENT 'Teléfono de la Persona',
  `persona_usuario_id` int(11) NOT NULL COMMENT 'Usuario de la Persona',
  `persona_estado_id` int(11) NOT NULL COMMENT 'Estado de Persona',
  `persona_persona_registra` varchar(15) NOT NULL COMMENT 'Persona que registra',
  `persona_fecha_registro` datetime NOT NULL COMMENT 'Fecha de registro',
  PRIMARY KEY (`id_persona`),
  KEY `estados_personas_fk` (`persona_estado_id`),
  KEY `usuarios_personas_fk` (`persona_usuario_id`),
  KEY `ciudades_personas_fk` (`persona_ciudad_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Personas';

--
-- Volcado de datos para la tabla `personas`
--

INSERT INTO `personas` (`id_persona`, `persona_nombre`, `persona_apellido`, `persona_email`, `persona_ciudad_id`, `persona_direccion`, `persona_telefono`, `persona_usuario_id`, `persona_estado_id`, `persona_persona_registra`, `persona_fecha_registro`) VALUES
('.', 'PRUEBA', 'PRUEBA', 'prueba@prueba.com', '05001', '.', '.', 5, 1, '1116250642', '2017-02-19 09:58:22'),
('1116250642', 'ANDRES', 'TAMAYO', 'andrest91@hotmail.com', '76834', 'cra 30#14-36', '2246787', 1, 1, '1116250642', '0000-00-00 00:00:00'),
('1116252828', 'VIDALIA', 'ZULUAGA LOZANO', 'yale-daniela16@hotmail.com', '76834', 'Campoalegre', '3176161603', 3, 1, '1116250642', '0000-00-00 00:00:00'),
('1116313285', 'OSCAR ANDRES', 'MARMOLEJO GARCIA', 'oscarego@hotmail.com', '08001', '.', '.', 2, 1, '1116250642', '0000-00-00 00:00:00');

--
-- Disparadores `personas`
--
DROP TRIGGER IF EXISTS `trgbinr_personas`;
DELIMITER $$
CREATE TRIGGER `trgbinr_personas` BEFORE INSERT ON `personas` FOR EACH ROW SET NEW.persona_fecha_registro = now()
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

DROP TABLE IF EXISTS `productos`;
CREATE TABLE IF NOT EXISTS `productos` (
  `id_producto` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador de Producto',
  `producto_nombre` varchar(100) NOT NULL COMMENT 'Descripción de Producto',
  `producto_unidad_id` varchar(4) DEFAULT NULL COMMENT 'Unidad de Medida de Producto',
  `producto_fraccion` int(10) DEFAULT NULL COMMENT 'Fraccion de Producto',
  `producto_costo` int(10) DEFAULT NULL COMMENT 'Costo de Producto',
  `producto_cantidad_minima` int(10) DEFAULT NULL COMMENT 'Cantidad Minima de Producto',
  `producto_cantidad_maxima` int(10) DEFAULT NULL COMMENT 'Cantidad Maxima de Producto',
  `producto_cantidad_actual` int(10) DEFAULT NULL COMMENT 'Cantidad Actual de Producto',
  `producto_costo_total` int(10) DEFAULT NULL COMMENT 'Costo Total de Producto',
  `producto_categoria_id` int(11) NOT NULL COMMENT 'Categoría del Producto',
  `producto_fecha_registro` datetime NOT NULL COMMENT 'Fecha de registro del Producto',
  `producto_persona_id` varchar(15) NOT NULL COMMENT 'Persona que registra el Producto',
  `producto_estado_id` int(11) NOT NULL COMMENT 'Estado de Producto',
  PRIMARY KEY (`id_producto`),
  KEY `estados_productos_fk` (`producto_estado_id`),
  KEY `categorias_productos_fk` (`producto_categoria_id`),
  KEY `unidades_productos_fk` (`producto_unidad_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1 COMMENT='Productos';

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_producto`, `producto_nombre`, `producto_unidad_id`, `producto_fraccion`, `producto_costo`, `producto_cantidad_minima`, `producto_cantidad_maxima`, `producto_cantidad_actual`, `producto_costo_total`, `producto_categoria_id`, `producto_fecha_registro`, `producto_persona_id`, `producto_estado_id`) VALUES
(1, 'COSTILLA AHUMADA', 'LBS', NULL, NULL, 10, 50, NULL, NULL, 1, '2016-08-14 15:06:01', '1116250642', 1),
(9, 'CHUZO DE CERDO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2017-01-07 23:45:32', '1116250642', 1),
(13, 'CHUZO DE POLLO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2017-01-07 23:48:50', '1116250642', 2),
(15, 'HAMBURGUESA TRIPLE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, '2017-01-07 23:49:30', '1116250642', 2),
(16, 'HAMBURGUESA DE RES', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, '2017-01-08 00:00:34', '1116250642', 1),
(17, 'PATATAS', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 20, '2017-02-11 07:46:05', '1116250642', 1),
(18, 'CHUZO MIXTO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2017-03-08 23:35:46', '1116250642', 1);

--
-- Disparadores `productos`
--
DROP TRIGGER IF EXISTS `trgbins_productos`;
DELIMITER $$
CREATE TRIGGER `trgbins_productos` BEFORE INSERT ON `productos` FOR EACH ROW SET NEW.producto_fecha_registro = now()
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

DROP TABLE IF EXISTS `proveedores`;
CREATE TABLE IF NOT EXISTS `proveedores` (
  `id_proveedor` varchar(20) NOT NULL COMMENT 'Identificador de Proveedor',
  `proveedor_nombre` varchar(100) NOT NULL COMMENT 'Descripción de Proveedor',
  `proveedor_telefono` varchar(15) NOT NULL COMMENT 'Teléfono de Proveedor',
  `proveedor_direccion` varchar(100) NOT NULL COMMENT 'Dirección de Proveedor',
  `proveedor_email` varchar(50) NOT NULL COMMENT 'Correo Electrónico de Proveedor',
  `proveedor_frecuencia` int(11) NOT NULL COMMENT 'Frecuencia acumulada de compras',
  `proveedor_costacum_compras` int(11) NOT NULL COMMENT 'Costo acumulado de compras',
  `proveedor_fecha_registro` datetime NOT NULL COMMENT 'Fecha de Registro del Proveedor',
  `proveedor_persona_id` varchar(15) NOT NULL COMMENT 'Persona que registra al Proveedor',
  `proveedor_estado_id` int(11) NOT NULL COMMENT 'Estado de Proveedor',
  PRIMARY KEY (`id_proveedor`),
  KEY `estados_proveedores_fk` (`proveedor_estado_id`),
  KEY `personas_proveedores_fk` (`proveedor_persona_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Proveedores';

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`id_proveedor`, `proveedor_nombre`, `proveedor_telefono`, `proveedor_direccion`, `proveedor_email`, `proveedor_frecuencia`, `proveedor_costacum_compras`, `proveedor_fecha_registro`, `proveedor_persona_id`, `proveedor_estado_id`) VALUES
('0987-34', 'RICA', '.', '.', 'rica@rica.com', 2, 3400000, '2017-02-23 22:04:07', '1116250642', 1),
('1234567', 'postobon', '2312323', 'calle 30 #2434', 'andres@gmail.com', 2, 116000, '2016-07-31 16:20:25', '1116250642', 1),
('5202521116-7', 'ZENU', '6145625', '.', 'zenuatcliente@zenu.com.co', 0, 0, '2016-08-14 13:16:03', '1116313285', 1),
('93451747-10', 'COCA COLA', '5558027', '.', 'atcliente@cocacola.com.co', 0, 0, '2017-01-29 10:47:08', '1116250642', 1);

--
-- Disparadores `proveedores`
--
DROP TRIGGER IF EXISTS `trgbins_proveedores`;
DELIMITER $$
CREATE TRIGGER `trgbins_proveedores` BEFORE INSERT ON `proveedores` FOR EACH ROW SET NEW.proveedor_fecha_registro = now(),
    NEW.proveedor_frecuencia = 0,
    NEW.proveedor_costacum_compras = 0
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `secuencias`
--

DROP TABLE IF EXISTS `secuencias`;
CREATE TABLE IF NOT EXISTS `secuencias` (
  `id_secuencia` varchar(20) NOT NULL COMMENT 'Identificador de la Secuencia',
  `secuencia_numerador` int(15) NOT NULL COMMENT 'Numerador de la Secuencia',
  `secuencia_estado_id` int(11) NOT NULL COMMENT 'Estado de la Secuencia',
  PRIMARY KEY (`id_secuencia`),
  KEY `estados_secuencias_fk` (`secuencia_estado_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `secuencias`
--

INSERT INTO `secuencias` (`id_secuencia`, `secuencia_numerador`, `secuencia_estado_id`) VALUES
('COMPRA', 2016000001, 1),
('VENTA', 2016000001, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sincron_dw`
--

DROP TABLE IF EXISTS `sincron_dw`;
CREATE TABLE IF NOT EXISTS `sincron_dw` (
  `id_sincron_dw` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificación de Sincronización',
  `sincron_dw_usuario_id` int(11) NOT NULL COMMENT 'Identificador de Usuario',
  `sincron_dw_persona_id` varchar(15) NOT NULL COMMENT 'Identificador de Persona',
  `sincron_dw_fecha_registro` datetime NOT NULL COMMENT 'Fecha de Registro de Sincronizacion',
  `sincron_dw_completa` int(1) NOT NULL COMMENT 'Sincronizacion Exitosa',
  PRIMARY KEY (`id_sincron_dw`),
  KEY `usuarios_sincron_dw` (`sincron_dw_usuario_id`),
  KEY `personas_sincron_dw` (`sincron_dw_persona_id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=latin1 COMMENT='Auditoria Sincronizacion Data Mart';

--
-- Volcado de datos para la tabla `sincron_dw`
--

INSERT INTO `sincron_dw` (`id_sincron_dw`, `sincron_dw_usuario_id`, `sincron_dw_persona_id`, `sincron_dw_fecha_registro`, `sincron_dw_completa`) VALUES
(2, 1, '1116250642', '2016-11-27 18:53:25', 1),
(3, 1, '1116250642', '2016-11-27 18:53:51', 1),
(4, 1, '1116250642', '2016-12-10 11:36:02', 1),
(5, 1, '1116250642', '2017-01-13 15:59:59', 1),
(6, 1, '1116250642', '2017-01-14 16:32:45', 1),
(7, 1, '1116250642', '2017-01-14 16:39:33', 1),
(8, 1, '1116250642', '2017-01-14 16:42:53', 1),
(9, 1, '1116250642', '2017-01-14 16:43:03', 1),
(10, 1, '1116250642', '2017-01-14 16:49:13', 1),
(11, 1, '1116250642', '2017-01-14 17:16:12', 1),
(12, 1, '1116250642', '2017-01-14 17:17:21', 1),
(13, 1, '1116250642', '2017-01-14 17:18:02', 1),
(14, 1, '1116250642', '2017-01-14 17:25:04', 1),
(15, 1, '1116250642', '2017-01-14 17:25:16', 1),
(16, 1, '1116250642', '2017-01-14 18:23:28', 1),
(17, 1, '1116250642', '2017-01-14 19:26:30', 1),
(18, 1, '1116250642', '2017-01-21 15:54:09', 1),
(19, 1, '1116250642', '2017-02-11 08:08:27', 1),
(20, 1, '1116250642', '2017-02-23 21:42:09', 1),
(21, 1, '1116250642', '2017-02-23 22:25:09', 1),
(22, 1, '1116250642', '2017-02-28 22:50:27', 1),
(23, 1, '1116250642', '2017-03-09 18:51:00', 1),
(24, 1, '1116250642', '2017-03-14 20:03:54', 1),
(25, 1, '1116250642', '2017-03-15 23:31:20', 1),
(26, 1, '1116250642', '2017-03-15 23:34:06', 1),
(27, 1, '1116250642', '2017-03-15 23:46:39', 1),
(28, 1, '1116250642', '2017-03-15 23:47:17', 1),
(29, 1, '1116250642', '2017-03-15 23:49:24', 1),
(30, 1, '1116250642', '2017-03-15 23:52:21', 1),
(31, 1, '1116250642', '2017-03-15 23:53:15', 1),
(32, 1, '1116250642', '2017-03-15 23:54:16', 1),
(33, 1, '1116250642', '2017-03-16 00:01:55', 1),
(34, 1, '1116250642', '2017-03-16 00:04:05', 1);

--
-- Disparadores `sincron_dw`
--
DROP TRIGGER IF EXISTS `trgins_sincron_dw`;
DELIMITER $$
CREATE TRIGGER `trgins_sincron_dw` BEFORE INSERT ON `sincron_dw` FOR EACH ROW SET NEW.sincron_dw_fecha_registro = now()
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `submodulos`
--

DROP TABLE IF EXISTS `submodulos`;
CREATE TABLE IF NOT EXISTS `submodulos` (
  `id_submodulo` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador de Submódulo',
  `submodulo_nombre` varchar(70) NOT NULL COMMENT 'Nombre Submódulo',
  `submodulo_estado_id` int(11) NOT NULL COMMENT 'Identificador de Estado',
  `submodulo_modulo_id` int(11) NOT NULL COMMENT 'Identificador de Modulo',
  PRIMARY KEY (`id_submodulo`),
  KEY `estados_submodulos_fk` (`submodulo_estado_id`),
  KEY `modulos_submodulos_fk` (`submodulo_modulo_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1 COMMENT='Submódulos';

--
-- Volcado de datos para la tabla `submodulos`
--

INSERT INTO `submodulos` (`id_submodulo`, `submodulo_nombre`, `submodulo_estado_id`, `submodulo_modulo_id`) VALUES
(1, 'Administrar Usuario', 1, 1),
(2, 'Administrar Producto', 1, 2),
(3, 'Reportes Usuario', 1, 1),
(4, 'Administrar Proveedores', 1, 3),
(5, 'Administrar Clientes', 1, 3),
(6, 'Administrar Personas', 1, 3),
(7, 'Administrar Categorías de Productos', 1, 2),
(8, 'Administrar Compras', 1, 5),
(9, 'Administrar Ingredientes', 1, 2),
(10, 'Administrar Bodegas', 1, 6),
(11, 'Administrar Traslados de Bodega', 1, 5),
(12, 'Administrar Datos de Análisis', 1, 7),
(13, 'Administrar Ventas', 1, 5),
(14, 'Análisis de Datos', 1, 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tablas_dw`
--

DROP TABLE IF EXISTS `tablas_dw`;
CREATE TABLE IF NOT EXISTS `tablas_dw` (
  `id_tabla_dw` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador Tabla',
  `tabla_dw_nombre` varchar(20) NOT NULL COMMENT 'Nombre de la Tabla',
  `tabla_dw_fecha_registro` datetime NOT NULL COMMENT 'Fecha de Registro de la Tabla',
  `tabla_dw_fecha_ultimodi` datetime NOT NULL COMMENT 'Fecha Ultima Modificacion',
  PRIMARY KEY (`id_tabla_dw`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1 COMMENT='Tablas del Data Mart';

--
-- Volcado de datos para la tabla `tablas_dw`
--

INSERT INTO `tablas_dw` (`id_tabla_dw`, `tabla_dw_nombre`, `tabla_dw_fecha_registro`, `tabla_dw_fecha_ultimodi`) VALUES
(1, 'proveedores', '2016-10-29 10:36:39', '2016-10-29 10:45:28'),
(2, 'ingredientes', '2016-10-29 10:52:35', '2016-10-29 10:52:35'),
(3, 'compras', '2016-11-01 21:05:24', '2016-11-01 21:05:24'),
(4, 'movicomp', '2016-11-01 21:05:24', '2016-11-01 21:05:24'),
(5, 'clientes', '2017-01-13 15:13:48', '2017-01-13 15:13:48'),
(6, 'productos', '2017-01-14 17:23:00', '2017-01-14 17:23:00'),
(7, 'ventas', '2017-01-14 17:35:31', '2017-01-14 17:35:31'),
(8, 'movivent', '2017-01-14 18:05:47', '2017-01-14 18:05:47'),
(9, 'ingreprodu', '2017-01-14 19:23:26', '2017-01-14 19:23:26');

--
-- Disparadores `tablas_dw`
--
DROP TRIGGER IF EXISTS `trgbinr_tablas_dw`;
DELIMITER $$
CREATE TRIGGER `trgbinr_tablas_dw` BEFORE INSERT ON `tablas_dw` FOR EACH ROW SET NEW.tabla_dw_fecha_registro = now(),
    NEW.tabla_dw_fecha_ultimodi = now()
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `trgbupr_tablas_dw`;
DELIMITER $$
CREATE TRIGGER `trgbupr_tablas_dw` BEFORE UPDATE ON `tablas_dw` FOR EACH ROW SET NEW.tabla_dw_fecha_ultimodi = now()
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `unidades`
--

DROP TABLE IF EXISTS `unidades`;
CREATE TABLE IF NOT EXISTS `unidades` (
  `id_unidad` varchar(4) NOT NULL COMMENT 'Identificador de la Unidad',
  `unidad_nombre` varchar(30) NOT NULL COMMENT 'Nombre de la Unidad',
  `unidad_clasunid_id` int(11) NOT NULL COMMENT 'Identificador de Clase de Unidad de la Unidad',
  PRIMARY KEY (`id_unidad`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Unidades';

--
-- Volcado de datos para la tabla `unidades`
--

INSERT INTO `unidades` (`id_unidad`, `unidad_nombre`, `unidad_clasunid_id`) VALUES
('BLO', 'BLOQUE', 1),
('BOL', 'BOLSA', 5),
('BTL', 'BOTELLA', 5),
('BUL', 'BULTO', 6),
('CAJ', 'CAJA', 3),
('CAN', 'CANECA', 3),
('CM', 'CENTIMETRO', 4),
('CM3', 'CENTIMETROS CUBICOS', 5),
('CTO', 'CUARTO', 5),
('CU', 'CU¿TE', 5),
('CUB', 'CUBETA', 3),
('DC', 'DECIMETRO CUBICO', 5),
('DM', 'DECIMETRO', 4),
('FCO', 'FRASCO', 5),
('GAR', 'GARRAFA', 5),
('GLN', 'GALON', 5),
('GRS', 'GRAMO', 1),
('HJA', 'HOJA', 6),
('JGO', 'JUEGO', 3),
('KGR', 'KILOGRAMO', 1),
('KMS', 'KILOMETRO', 4),
('Lata', 'LATA', 8),
('LBS', 'LIBRA', 1),
('LTR', 'LITRO', 5),
('M/L', 'METROS LINEALES', 4),
('mes', 'Mensual', 2),
('MIL', 'MILLAR', 8),
('MT2', 'METRO CUADRADO', 6),
('MT3', 'METRO CUBICO', 5),
('MTR', 'METRO', 4),
('ONZ', 'ONZA', 5),
('PAQ', 'PAQUETE', 3),
('PAR', 'PAR', 8),
('PGS', 'PLIEGOS', 4),
('PI3', 'Pie Cubico', 5),
('PIE', 'Pie', 4),
('PTE', 'Pote', 5),
('PZA', 'PIEZA', 8),
('RLL', 'ROLLO', 4),
('RMA', 'RESMA', 5),
('SAC', 'SACO', 5),
('SOB', 'SOBRE', 8),
('TAL', 'TALONARIO', 3),
('TAR', 'TARRO', 5),
('TON', 'TONELADA', 1),
('UNI', 'UNIDAD', 8),
('VOL', 'VOLTIO', 3),
('WAT', 'VATIO', 3),
('YDA', 'YARDA', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador de Usuario',
  `usuario_nombre` varchar(15) NOT NULL COMMENT 'Usuario del Sistema',
  `usuario_clave` char(32) NOT NULL COMMENT 'Clave de usuario',
  `usuario_perfil_id` int(11) NOT NULL COMMENT 'Identificador de Perfil',
  `usuario_estado_id` int(11) NOT NULL COMMENT 'Identificador de Estado',
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `UK_USUARIO` (`usuario_nombre`),
  KEY `estados_usuarios_fk` (`usuario_estado_id`),
  KEY `perfiles_usuarios_fk` (`usuario_perfil_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `usuario_nombre`, `usuario_clave`, `usuario_perfil_id`, `usuario_estado_id`) VALUES
(1, 'jmejia710', '4a3c11854a935159baf0c8aafecba2c2', 1, 1),
(2, 'invitado', 'a6ae8a143d440ab8c006d799f682d48d', 2, 1),
(3, 'yvidalia', '233875783fa67d772b19098ad287019b', 2, 1),
(4, 'regor', 'e10adc3949ba59abbe56e057f20f883e', 2, 1),
(5, 'prueba', 'c893bad68927b457dbed39460e6afd62', 1, 1),
(6, 'jsmejia', '00d8dbbd77caff9309635b1099f16849', 1, 1);

--
-- Disparadores `usuarios`
--
DROP TRIGGER IF EXISTS `trgbins_usuarios`;
DELIMITER $$
CREATE TRIGGER `trgbins_usuarios` BEFORE INSERT ON `usuarios` FOR EACH ROW SET NEW.usuario_clave = MD5(NEW.usuario_clave)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

DROP TABLE IF EXISTS `ventas`;
CREATE TABLE IF NOT EXISTS `ventas` (
  `id_venta` varchar(9) NOT NULL COMMENT 'Identificador de la Venta',
  `venta_cliente_id` varchar(20) NOT NULL COMMENT 'Identificador de Cliente',
  `venta_fecha` date NOT NULL COMMENT 'Fecha de la Venta',
  `venta_costo` int(10) NOT NULL COMMENT 'Costo Total de la Venta',
  `venta_descripcion` varchar(4000) NOT NULL COMMENT 'Descripción de la Venta',
  `venta_estado_id` int(11) NOT NULL COMMENT 'Estado de la Venta',
  PRIMARY KEY (`id_venta`),
  KEY `clientes_ventas_fk` (`venta_cliente_id`),
  KEY `estados_ventas_fk` (`venta_estado_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Ventas';

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id_venta`, `venta_cliente_id`, `venta_fecha`, `venta_costo`, `venta_descripcion`, `venta_estado_id`) VALUES
('20170001', '1116323448', '2017-01-05', 6000, '.', 1),
('20170002', '1116252828', '2017-01-07', 3000, '.', 1),
('20170003', '1117665123', '2017-01-29', 60000, 'Venta ordinaria', 1),
('20170004', '1117665123', '2017-01-29', 60000, '.', 1),
('20170005', '1113219112', '2017-02-11', 3500, 'dfgdfgdf', 1),
('20170006', '1116222290', '2017-02-23', 3000, '.', 1),
('20170007', '1116222290', '2017-02-22', 3000, '.', 1),
('20170008', '1116222290', '2017-02-18', 3000, '.', 1),
('20170009', '1116252828', '2017-02-23', 11000, '.', 1),
('20170010', '1116252828', '2017-03-09', 10000, '.', 1),
('20170011', '1117665123', '2017-03-25', 0, 'VENTA ORDINARIA', 1);

--
-- Disparadores `ventas`
--
DROP TRIGGER IF EXISTS `trgadel_ventas`;
DELIMITER $$
CREATE TRIGGER `trgadel_ventas` AFTER DELETE ON `ventas` FOR EACH ROW BEGIN
   
   UPDATE clientes
      SET cliente_frecuencia = cliente_frecuencia - 1,
          cliente_costacum_ventas = cliente_costacum_ventas - OLD.venta_costo
    WHERE id_cliente = OLD.venta_cliente_id;

END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `trgains_ventas`;
DELIMITER $$
CREATE TRIGGER `trgains_ventas` AFTER INSERT ON `ventas` FOR EACH ROW BEGIN
   UPDATE clientes
      SET cliente_frecuencia = cliente_frecuencia + 1
    WHERE id_cliente = NEW.venta_cliente_id;
   
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `trgaupd_ventas`;
DELIMITER $$
CREATE TRIGGER `trgaupd_ventas` AFTER UPDATE ON `ventas` FOR EACH ROW BEGIN
   
   UPDATE clientes
      SET cliente_frecuencia = cliente_frecuencia - 1,
          cliente_costacum_ventas = cliente_costacum_ventas - OLD.venta_costo
    WHERE id_cliente = OLD.venta_cliente_id;
   
   UPDATE clientes
      SET cliente_frecuencia = cliente_frecuencia + 1,
          cliente_costacum_ventas = cliente_costacum_ventas + NEW.venta_costo
    WHERE id_cliente = NEW.venta_cliente_id;
    
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `trgbinr_ventas`;
DELIMITER $$
CREATE TRIGGER `trgbinr_ventas` BEFORE INSERT ON `ventas` FOR EACH ROW SET NEW.venta_costo = 0
$$
DELIMITER ;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `bodegas`
--
ALTER TABLE `bodegas`
  ADD CONSTRAINT `estados_bodegas_fk` FOREIGN KEY (`bodega_estado_id`) REFERENCES `estados` (`id_estado`);

--
-- Filtros para la tabla `campos_dw`
--
ALTER TABLE `campos_dw`
  ADD CONSTRAINT `tablas_dw_campos_dw_fk` FOREIGN KEY (`campo_tabla_dw_id`) REFERENCES `tablas_dw` (`id_tabla_dw`);

--
-- Filtros para la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD CONSTRAINT `estados_categorias_fk` FOREIGN KEY (`categoria_estado_id`) REFERENCES `estados` (`id_estado`),
  ADD CONSTRAINT `personas_categorias_fk` FOREIGN KEY (`categoria_persona_id`) REFERENCES `personas` (`id_persona`);

--
-- Filtros para la tabla `ciudades`
--
ALTER TABLE `ciudades`
  ADD CONSTRAINT `divipais_ciudades_fk` FOREIGN KEY (`ciudad_divipais_id`) REFERENCES `divipais` (`id_divipais`),
  ADD CONSTRAINT `estados_ciudades_fk` FOREIGN KEY (`ciudad_estado_id`) REFERENCES `estados` (`id_estado`);

--
-- Filtros para la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD CONSTRAINT `ciudades_clientes_fk` FOREIGN KEY (`cliente_ciudad_id`) REFERENCES `ciudades` (`id_ciudad`),
  ADD CONSTRAINT `estados_clientes_fk` FOREIGN KEY (`cliente_estado_id`) REFERENCES `estados` (`id_estado`),
  ADD CONSTRAINT `generos_clientes_fk` FOREIGN KEY (`cliente_genero_id`) REFERENCES `generos` (`id_genero`),
  ADD CONSTRAINT `personas_clientes_fk` FOREIGN KEY (`cliente_persona_id`) REFERENCES `personas` (`id_persona`);

--
-- Filtros para la tabla `compras`
--
ALTER TABLE `compras`
  ADD CONSTRAINT `estados_compras_fk` FOREIGN KEY (`compra_estado_id`) REFERENCES `estados` (`id_estado`),
  ADD CONSTRAINT `proveedores_compras_fk` FOREIGN KEY (`compra_proveedor_id`) REFERENCES `proveedores` (`id_proveedor`);

--
-- Filtros para la tabla `divipais`
--
ALTER TABLE `divipais`
  ADD CONSTRAINT `estados_divipais_fk` FOREIGN KEY (`divipais_estado_id`) REFERENCES `estados` (`id_estado`),
  ADD CONSTRAINT `paises_divipais_fk` FOREIGN KEY (`divipais_pais_id`) REFERENCES `paises` (`id_pais`);

--
-- Filtros para la tabla `empresas`
--
ALTER TABLE `empresas`
  ADD CONSTRAINT `ciudades_empresas_fk` FOREIGN KEY (`empresa_ciudad_id`) REFERENCES `ciudades` (`id_ciudad`),
  ADD CONSTRAINT `estados_empresas_fk` FOREIGN KEY (`empresa_estado_id`) REFERENCES `estados` (`id_estado`);

--
-- Filtros para la tabla `generos`
--
ALTER TABLE `generos`
  ADD CONSTRAINT `estados_generos_fk` FOREIGN KEY (`genero_estado_id`) REFERENCES `estados` (`id_estado`);

--
-- Filtros para la tabla `ingrebodes`
--
ALTER TABLE `ingrebodes`
  ADD CONSTRAINT `personas_ingrebodes_fk` FOREIGN KEY (`ingrebode_persona_id`) REFERENCES `personas` (`id_persona`);

--
-- Filtros para la tabla `ingredientes`
--
ALTER TABLE `ingredientes`
  ADD CONSTRAINT `estados_ingredientes_fk` FOREIGN KEY (`ingrediente_estado_id`) REFERENCES `estados` (`id_estado`),
  ADD CONSTRAINT `personas_ingredientes_fk` FOREIGN KEY (`ingrediente_persona_id`) REFERENCES `personas` (`id_persona`),
  ADD CONSTRAINT `unidades_ingredientes_fk` FOREIGN KEY (`ingrediente_unidad_id`) REFERENCES `unidades` (`id_unidad`);

--
-- Filtros para la tabla `ingreprodu`
--
ALTER TABLE `ingreprodu`
  ADD CONSTRAINT `estados_ingreprodu_fk` FOREIGN KEY (`ingreprodu_estado_id`) REFERENCES `estados` (`id_estado`),
  ADD CONSTRAINT `ingredientes_ingreprodu_fk` FOREIGN KEY (`ingreprodu_ingrediente_id`) REFERENCES `ingredientes` (`id_ingrediente`),
  ADD CONSTRAINT `personas_ingreprodu_fk` FOREIGN KEY (`ingreprodu_persona_id`) REFERENCES `personas` (`id_persona`),
  ADD CONSTRAINT `productos_ingreprodu_fk` FOREIGN KEY (`ingreprodu_producto_id`) REFERENCES `productos` (`id_producto`),
  ADD CONSTRAINT `unidades_ingreprodu_fk` FOREIGN KEY (`ingreprodu_unidad_id`) REFERENCES `unidades` (`id_unidad`);

--
-- Filtros para la tabla `modulos`
--
ALTER TABLE `modulos`
  ADD CONSTRAINT `estados_modulos_fk` FOREIGN KEY (`modulo_estado_id`) REFERENCES `estados` (`id_estado`);

--
-- Filtros para la tabla `movicomp`
--
ALTER TABLE `movicomp`
  ADD CONSTRAINT `bodegas_movicomp_fk` FOREIGN KEY (`movicomp_bodega_id`) REFERENCES `bodegas` (`id_bodega`),
  ADD CONSTRAINT `compras_movicomp_fk` FOREIGN KEY (`id_movicomp_compra`) REFERENCES `compras` (`id_compra`),
  ADD CONSTRAINT `estados_movicomp_fk` FOREIGN KEY (`movicomp_estado_id`) REFERENCES `estados` (`id_estado`),
  ADD CONSTRAINT `ingredientes_movicomp_fk` FOREIGN KEY (`movicomp_ingrediente_id`) REFERENCES `ingredientes` (`id_ingrediente`),
  ADD CONSTRAINT `personas_movicomp_fk` FOREIGN KEY (`movicomp_persona_id`) REFERENCES `personas` (`id_persona`);

--
-- Filtros para la tabla `movitras`
--
ALTER TABLE `movitras`
  ADD CONSTRAINT `bodedest_movitras_fk` FOREIGN KEY (`movitras_bodedest_id`) REFERENCES `bodegas` (`id_bodega`),
  ADD CONSTRAINT `bodefuen_movitras_fk` FOREIGN KEY (`movitras_bodefuen_id`) REFERENCES `bodegas` (`id_bodega`),
  ADD CONSTRAINT `ingredientes_movitras_fk` FOREIGN KEY (`movitras_ingrediente_id`) REFERENCES `ingredientes` (`id_ingrediente`),
  ADD CONSTRAINT `personas_movitras_fk` FOREIGN KEY (`movitras_persona_id`) REFERENCES `personas` (`id_persona`);

--
-- Filtros para la tabla `movivent`
--
ALTER TABLE `movivent`
  ADD CONSTRAINT `bodegas_movivent_fk` FOREIGN KEY (`movivent_bodega_id`) REFERENCES `bodegas` (`id_bodega`),
  ADD CONSTRAINT `estados_movivent_fk` FOREIGN KEY (`movivent_estado_id`) REFERENCES `estados` (`id_estado`),
  ADD CONSTRAINT `personas_movivent_fk` FOREIGN KEY (`movivent_persona_id`) REFERENCES `personas` (`id_persona`),
  ADD CONSTRAINT `productos_movivent_fk` FOREIGN KEY (`movivent_producto_id`) REFERENCES `productos` (`id_producto`),
  ADD CONSTRAINT `ventas_movivent_fk` FOREIGN KEY (`id_movivent_venta`) REFERENCES `ventas` (`id_venta`);

--
-- Filtros para la tabla `opciones`
--
ALTER TABLE `opciones`
  ADD CONSTRAINT `estados_opciones_fk` FOREIGN KEY (`opcion_estado_id`) REFERENCES `estados` (`id_estado`),
  ADD CONSTRAINT `submodulos_opciones_fk` FOREIGN KEY (`opcion_submodulo_id`) REFERENCES `submodulos` (`id_submodulo`);

--
-- Filtros para la tabla `opciperf`
--
ALTER TABLE `opciperf`
  ADD CONSTRAINT `estados_opciperf_fk` FOREIGN KEY (`opciperf_estado_id`) REFERENCES `estados` (`id_estado`),
  ADD CONSTRAINT `opciones_opciperf_fk` FOREIGN KEY (`opciperf_opcion_id`) REFERENCES `opciones` (`id_opcion`),
  ADD CONSTRAINT `perfiles_opciperf_fk` FOREIGN KEY (`opciperf_perfil_id`) REFERENCES `perfiles` (`id_perfil`);

--
-- Filtros para la tabla `paises`
--
ALTER TABLE `paises`
  ADD CONSTRAINT `estados_paises_fk` FOREIGN KEY (`pais_estado_id`) REFERENCES `estados` (`id_estado`);

--
-- Filtros para la tabla `perfiles`
--
ALTER TABLE `perfiles`
  ADD CONSTRAINT `estados_perfiles_fk` FOREIGN KEY (`perfil_estado_id`) REFERENCES `estados` (`id_estado`);

--
-- Filtros para la tabla `personas`
--
ALTER TABLE `personas`
  ADD CONSTRAINT `ciudades_personas_fk` FOREIGN KEY (`persona_ciudad_id`) REFERENCES `ciudades` (`id_ciudad`),
  ADD CONSTRAINT `estados_personas_fk` FOREIGN KEY (`persona_estado_id`) REFERENCES `estados` (`id_estado`),
  ADD CONSTRAINT `usuarios_personas_fk` FOREIGN KEY (`persona_usuario_id`) REFERENCES `usuarios` (`id_usuario`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `categorias_productos_fk` FOREIGN KEY (`producto_categoria_id`) REFERENCES `categorias` (`id_categoria`),
  ADD CONSTRAINT `estados_productos_fk` FOREIGN KEY (`producto_estado_id`) REFERENCES `estados` (`id_estado`),
  ADD CONSTRAINT `unidades_productos_fk` FOREIGN KEY (`producto_unidad_id`) REFERENCES `unidades` (`id_unidad`);

--
-- Filtros para la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD CONSTRAINT `estados_proveedores_fk` FOREIGN KEY (`proveedor_estado_id`) REFERENCES `estados` (`id_estado`),
  ADD CONSTRAINT `personas_proveedores_fk` FOREIGN KEY (`proveedor_persona_id`) REFERENCES `personas` (`id_persona`);

--
-- Filtros para la tabla `secuencias`
--
ALTER TABLE `secuencias`
  ADD CONSTRAINT `estados_secuencias_fk` FOREIGN KEY (`secuencia_estado_id`) REFERENCES `estados` (`id_estado`);

--
-- Filtros para la tabla `sincron_dw`
--
ALTER TABLE `sincron_dw`
  ADD CONSTRAINT `personas_sincron_dw` FOREIGN KEY (`sincron_dw_persona_id`) REFERENCES `personas` (`id_persona`),
  ADD CONSTRAINT `usuarios_sincron_dw` FOREIGN KEY (`sincron_dw_usuario_id`) REFERENCES `usuarios` (`id_usuario`);

--
-- Filtros para la tabla `submodulos`
--
ALTER TABLE `submodulos`
  ADD CONSTRAINT `estados_submodulos_fk` FOREIGN KEY (`submodulo_estado_id`) REFERENCES `estados` (`id_estado`),
  ADD CONSTRAINT `modulos_submodulos_fk` FOREIGN KEY (`submodulo_modulo_id`) REFERENCES `modulos` (`id_modulo`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `estados_usuarios_fk` FOREIGN KEY (`usuario_estado_id`) REFERENCES `estados` (`id_estado`),
  ADD CONSTRAINT `perfiles_usuarios_fk` FOREIGN KEY (`usuario_perfil_id`) REFERENCES `perfiles` (`id_perfil`);

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `clientes_ventas_fk` FOREIGN KEY (`venta_cliente_id`) REFERENCES `clientes` (`id_cliente`),
  ADD CONSTRAINT `estados_ventas_fk` FOREIGN KEY (`venta_estado_id`) REFERENCES `estados` (`id_estado`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
