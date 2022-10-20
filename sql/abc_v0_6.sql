-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-12-2013 a las 20:12:25
-- Versión del servidor: 5.5.32
-- Versión de PHP: 5.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articulos`
--

CREATE TABLE IF NOT EXISTS `articulos` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(500) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `descripcion` varchar(2000) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `precio_coste` float NOT NULL DEFAULT '0',
  `precio_venta` float NOT NULL DEFAULT '0',
  `observaciones` varchar(2000) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `imagen1` varchar(500) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `imagen2` varchar(500) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `imagen3` varchar(500) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `miniatura` varchar(500) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `id_proveedor` int(11) DEFAULT NULL,
  `id_tipo_iva` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nombre` (`nombre`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE IF NOT EXISTS `clientes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(500) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `apellidos` varchar(500) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `nombre_completo` varchar(200) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `empresa` varchar(500) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `cif` varchar(9) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `direccion` varchar(500) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `poblacion` varchar(500) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `provincia` varchar(500) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `cp` varchar(5) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `pais` varchar(500) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `telefono` varchar(100) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `movil` varchar(100) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `fax` varchar(100) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `email` varchar(500) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `web` varchar(500) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `observaciones` varchar(4000) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `id_usuario` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unico` (`nombre`,`apellidos`),
  KEY `id_usuario` (`id_usuario`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalles_factura`
--

CREATE TABLE IF NOT EXISTS `detalles_factura` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_articulo` int(10) unsigned NOT NULL,
  `nombre_articulo` varchar(1000) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `descripcion` int(11) NOT NULL,
  `precio` int(11) NOT NULL DEFAULT '0',
  `cantidad` int(10) unsigned NOT NULL DEFAULT '0',
  `descuento` int(10) unsigned NOT NULL DEFAULT '0',
  `subtotal` int(11) NOT NULL DEFAULT '0',
  `iva` float NOT NULL DEFAULT '0',
  `observaciones` varchar(500) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `id_factura` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalles_pedido`
--

CREATE TABLE IF NOT EXISTS `detalles_pedido` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_articulo` int(10) unsigned NOT NULL,
  `nombre_articulo` varchar(1000) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `descripcion` varchar(200) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `precio` int(11) NOT NULL,
  `cantidad` int(10) unsigned NOT NULL,
  `descuento` double unsigned NOT NULL,
  `subtotal` int(11) NOT NULL,
  `iva` float NOT NULL,
  `observaciones` varchar(500) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `id_pedido` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dominios`
--

CREATE TABLE IF NOT EXISTS `dominios` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `dominio` varchar(250) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `descripcion` varchar(500) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `dominio_UNIQUE` (`dominio`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Dominios' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa`
--

CREATE TABLE IF NOT EXISTS `empresa` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(500) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `direccion` varchar(500) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `poblacion` varchar(500) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `provincia` varchar(500) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `cp` varchar(5) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `telefono` varchar(500) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `movil` varchar(500) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `fax` varchar(500) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `imagen_logo` varchar(500) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `email` varchar(500) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `web` varchar(500) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturas`
--

CREATE TABLE IF NOT EXISTS `facturas` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `numero_factura` varchar(100) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `fecha` datetime DEFAULT NULL,
  `fecha_vencimiento` datetime DEFAULT NULL,
  `estado` varchar(50) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `comentarios` varchar(2000) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `observaciones` varchar(2000) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `base_imponible` float NOT NULL DEFAULT '0',
  `iva` float NOT NULL DEFAULT '0',
  `importe` float DEFAULT '0',
  `nombre_cliente` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `direccion` varchar(500) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `poblacion` varchar(500) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `provincia` varchar(500) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `cp` varchar(500) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `forma_pago` varchar(500) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `numero_pedido` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `id_cliente` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `numero_pedido` (`numero_factura`),
  KEY `id_cliente` (`nombre_cliente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `formas_envio`
--

CREATE TABLE IF NOT EXISTS `formas_envio` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(500) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `descripcion` varchar(2000) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `coste` float DEFAULT '0',
  `dias` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `nombre` (`nombre`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `formas_pago`
--

CREATE TABLE IF NOT EXISTS `formas_pago` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(500) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `descripcion` varchar(1000) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `coste` float DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `nombre` (`nombre`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE IF NOT EXISTS `pedidos` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `numero_pedido` varchar(20) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `fecha` datetime DEFAULT NULL,
  `fecha_entrega` datetime DEFAULT NULL,
  `estado` varchar(50) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `comentarios` varchar(2000) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `observaciones` varchar(2000) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `base_imponible` float NOT NULL DEFAULT '0',
  `iva` float DEFAULT '0',
  `importe` float DEFAULT '0',
  `id_cliente` int(11) DEFAULT NULL,
  `coste_envio` double DEFAULT '0',
  `coste_forma_pago` double DEFAULT '0',
  `dias_envio` int(11) DEFAULT '0',
  `forma_envio` varchar(500) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `forma_pago` varchar(500) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `terminado` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `numero_pedido` (`numero_pedido`),
  KEY `id_cliente` (`id_cliente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE IF NOT EXISTS `proveedores` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(500) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `contacto` varchar(500) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `cif` varchar(20) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `direccion` varchar(500) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `poblacion` varchar(500) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `provincia` varchar(500) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `cp` varchar(5) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `pais` varchar(500) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `telefono` varchar(100) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `movil` varchar(100) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `fax` varchar(100) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `email` varchar(500) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `web` varchar(500) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `observaciones` varchar(4000) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unico` (`nombre`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tareas`
--

CREATE TABLE IF NOT EXISTS `tareas` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(1000) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `descripcion` varchar(1000) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `fecha_prevista` datetime DEFAULT NULL,
  `fecha_inicio` datetime DEFAULT NULL,
  `fecha_fin` datetime DEFAULT NULL,
  `ubicacion` varchar(1000) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `id_cliente` int(11) DEFAULT NULL,
  `id_proveedor` int(11) DEFAULT NULL,
  `id_pedido` int(11) DEFAULT NULL,
  `estado` varchar(50) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `aviso` tinyint(4) NOT NULL DEFAULT '0',
  `fecha_aviso` datetime DEFAULT NULL,
  `tipo` varchar(50) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL DEFAULT 'tarea',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unico` (`nombre`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_iva`
--

CREATE TABLE IF NOT EXISTS `tipos_iva` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `descripcion` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cantidad` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `usuario` varchar(500) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `contrasena` varchar(500) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `nombre` varchar(500) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `email` varchar(500) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `nivel` varchar(100) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT 'admin',
  PRIMARY KEY (`id`),
  UNIQUE KEY `usuario` (`usuario`,`email`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Tabla de usuarios' AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
