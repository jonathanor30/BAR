-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 12-09-2020 a las 00:02:34
-- Versión del servidor: 5.7.31-0ubuntu0.18.04.1
-- Versión de PHP: 7.2.33-1+ubuntu18.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bar70`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id_cliente` int(12) NOT NULL,
  `capitalimpagado` double DEFAULT NULL,
  `cifnif` varchar(30) COLLATE utf8_bin NOT NULL,
  `cifnif_dv` int(1) DEFAULT NULL,
  `codagente` varchar(10) COLLATE utf8_bin DEFAULT NULL,
  `codcliente` varchar(6) COLLATE utf8_bin DEFAULT NULL,
  `codcontacto` varchar(6) COLLATE utf8_bin DEFAULT NULL,
  `codcuentadom` varchar(6) COLLATE utf8_bin DEFAULT NULL,
  `codcuentarem` varchar(6) COLLATE utf8_bin DEFAULT NULL,
  `coddivisa` varchar(3) COLLATE utf8_bin DEFAULT NULL,
  `codedi` varchar(17) COLLATE utf8_bin DEFAULT NULL,
  `codgrupo` varchar(6) COLLATE utf8_bin DEFAULT NULL,
  `codpago` varchar(10) COLLATE utf8_bin DEFAULT NULL,
  `medio_pago` int(25) DEFAULT NULL,
  `codserie` varchar(2) COLLATE utf8_bin DEFAULT NULL,
  `codsubcuenta` varchar(15) COLLATE utf8_bin DEFAULT NULL,
  `codtiporappel` varchar(10) COLLATE utf8_bin DEFAULT NULL,
  `contacto` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `copiasfactura` int(11) DEFAULT NULL,
  `estado` tinyint(1) DEFAULT '0',
  `bancname` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `banctype` int(11) DEFAULT NULL,
  `bancnumber` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `pais` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `departamento` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `ciudad` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `codpostal` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `codigo_departamento` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `codigo_municipio` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `direccion` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `email` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `fax` varchar(30) COLLATE utf8_bin DEFAULT NULL,
  `fechabaja` date DEFAULT NULL,
  `fechaalta` date DEFAULT NULL,
  `idsubcuenta` int(11) DEFAULT NULL,
  `ivaincluido` tinyint(1) DEFAULT NULL,
  `nombre` varchar(100) COLLATE utf8_bin NOT NULL,
  `razonsocial` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `observaciones` text COLLATE utf8_bin,
  `recargo` tinyint(1) DEFAULT NULL,
  `regimeniva` tinyint(2) DEFAULT NULL,
  `tipo_organizacion` tinyint(2) DEFAULT NULL,
  `riesgoalcanzado` double DEFAULT NULL,
  `riesgomax` double DEFAULT NULL,
  `telefono1` varchar(30) COLLATE utf8_bin DEFAULT NULL,
  `telefono2` varchar(30) COLLATE utf8_bin DEFAULT NULL,
  `tipoidfiscal` varchar(25) COLLATE utf8_bin NOT NULL DEFAULT 'NIT',
  `personafisica` tinyint(1) DEFAULT '1',
  `web` varchar(250) COLLATE utf8_bin DEFAULT NULL,
  `diaspago` varchar(10) COLLATE utf8_bin DEFAULT NULL,
  `codproveedor` varchar(6) COLLATE utf8_bin DEFAULT NULL,
  `codtarifa` varchar(6) COLLATE utf8_bin DEFAULT NULL,
  `responsabilidades` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `mercant_register` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id_cliente`, `capitalimpagado`, `cifnif`, `cifnif_dv`, `codagente`, `codcliente`, `codcontacto`, `codcuentadom`, `codcuentarem`, `coddivisa`, `codedi`, `codgrupo`, `codpago`, `medio_pago`, `codserie`, `codsubcuenta`, `codtiporappel`, `contacto`, `copiasfactura`, `estado`, `bancname`, `banctype`, `bancnumber`, `pais`, `departamento`, `ciudad`, `codpostal`, `codigo_departamento`, `codigo_municipio`, `direccion`, `email`, `fax`, `fechabaja`, `fechaalta`, `idsubcuenta`, `ivaincluido`, `nombre`, `razonsocial`, `observaciones`, `recargo`, `regimeniva`, `tipo_organizacion`, `riesgoalcanzado`, `riesgomax`, `telefono1`, `telefono2`, `tipoidfiscal`, `personafisica`, `web`, `diaspago`, `codproveedor`, `codtarifa`, `responsabilidades`, `mercant_register`, `created_at`, `updated_at`) VALUES
(30, NULL, '1054561218', NULL, NULL, '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, 'CO', 'ANTIOQUIA', 'MEDELLIN', '', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, 'JUAN BAUTISTA', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '326466288', NULL, 'CC', 1, NULL, NULL, NULL, NULL, NULL, NULL, '2020-09-11 22:23:21', '2020-09-11 22:23:21');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `divisas`
--

CREATE TABLE `divisas` (
  `coddivisa` varchar(3) COLLATE utf8_bin NOT NULL,
  `codiso` varchar(5) COLLATE utf8_bin DEFAULT NULL,
  `descripcion` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `simbolo` varchar(10) COLLATE utf8_bin DEFAULT NULL,
  `tasaconv` double NOT NULL,
  `tasaconvcompra` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `divisas`
--

INSERT INTO `divisas` (`coddivisa`, `codiso`, `descripcion`, `simbolo`, `tasaconv`, `tasaconvcompra`) VALUES
('ARS', '32', 'PESO ARGENTINO', 'AR$', 16.684, 16.684),
('BOB', '068', 'BOLIVIANO', 'Bs', 8.0465, 8.0465),
('BRL', '986', 'REAL BRASILEÑO', 'R$', 4.50553, 4.50553),
('CAD', '124', 'DÓLAR CANADIENSE', 'C$', 1.5385, 1.5385),
('CLP', '152', 'PESO CHILENO', 'CLP$', 704.0227, 704.0227),
('COP', '170', 'PESO COLOMBIANO', 'CO$', 3140.6803, 3140.6803),
('CRC', '188', 'COLÓN COSTARRICENSE', '₡', 659.39, 659.39),
('CUP', '192', 'PESO CUBANO', 'CU$', 1.16, 1.16),
('DOP', '214', 'PESO DOMINICANO', 'RD$', 49.7618, 49.7618),
('EUR', '978', 'EURO', '€', 1, 1),
('FKP', '238', 'LIBRA MALVINENSE', 'FK£', 1.13304, 1.13304),
('GBP', '826', 'LIBRA ESTERLINA', '£', 0.865, 0.865),
('GTQ', '320', 'QUETZAL GUATEMALTECO', 'Q', 8.774, 8.774),
('HNL', '340', 'LEMPIRA HONDUREÑO', 'L', 27.909, 27.909),
('HTG', '332', 'GOURDE HAITIANO', 'G', 72.0869, 72.0869),
('MXN', '484', 'PESO MEXICANO', 'MX$', 23.3678, 23.3678),
('PAB', '590', 'BALBOA PANAMEÑO', 'B', 1.128, 1.128),
('PEN', '604', 'SOL PERUANO', 'S/', 3.736, 3.736),
('PYG', '600', 'GUARANÍ PARAGUAYO', '₲', 6647.44318, 6647.44318),
('SVC', '222', 'COLON SALVADOREÑO', '₡', 10.17, 10.17),
('USD', '840', 'DÓLAR AMERICANO', '$', 1.129, 1.129),
('UYU', '858', 'PESO URUGUAYO', '$U', 30.7, 30.7),
('VEF', '937', 'BOLIVAR VENEZOLANO', 'Bs', 10.6492, 10.6492);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturacion_electronica`
--

CREATE TABLE `facturacion_electronica` (
  `id_config` int(12) NOT NULL,
  `prefijo` varchar(255) DEFAULT NULL,
  `idioma` varchar(255) DEFAULT NULL,
  `codigo_pais` varchar(255) DEFAULT NULL,
  `codigo_documento` varchar(255) DEFAULT NULL,
  `tipo_empresa` varchar(255) DEFAULT NULL,
  `tipo_regimen` varchar(25) DEFAULT NULL,
  `no_matricula` varchar(255) DEFAULT NULL,
  `codigo_municipio` varchar(255) DEFAULT NULL,
  `id_software` varchar(255) DEFAULT NULL,
  `pin_software` varchar(255) DEFAULT NULL,
  `testsid` varchar(255) DEFAULT NULL,
  `certificado` varchar(255) DEFAULT NULL,
  `clave_certificado` varchar(255) DEFAULT NULL,
  `vigencia_certificado` date DEFAULT NULL,
  `tipo_ambiente` tinyint(4) DEFAULT NULL,
  `enabled` int(1) DEFAULT '2',
  `responsabilidades` varchar(255) DEFAULT NULL,
  `hostEmail` varchar(255) DEFAULT NULL,
  `userEmail` varchar(255) DEFAULT NULL,
  `emailPass` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabla de configuración para la facturación electrónica';

--
-- Volcado de datos para la tabla `facturacion_electronica`
--

INSERT INTO `facturacion_electronica` (`id_config`, `prefijo`, `idioma`, `codigo_pais`, `codigo_documento`, `tipo_empresa`, `tipo_regimen`, `no_matricula`, `codigo_municipio`, `id_software`, `pin_software`, `testsid`, `certificado`, `clave_certificado`, `vigencia_certificado`, `tipo_ambiente`, `enabled`, `responsabilidades`, `hostEmail`, `userEmail`, `emailPass`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturascli`
--

CREATE TABLE `facturascli` (
  `idfactura` int(11) NOT NULL,
  `referencia` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `resolution_id` int(25) DEFAULT NULL,
  `automatica` tinyint(1) DEFAULT NULL,
  `cifnif` varchar(30) COLLATE utf8_bin NOT NULL,
  `ciudad` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `codagente` varchar(10) COLLATE utf8_bin DEFAULT NULL,
  `codalmacen` varchar(4) COLLATE utf8_bin DEFAULT NULL,
  `codcliente` varchar(6) COLLATE utf8_bin DEFAULT NULL,
  `coddir` int(11) DEFAULT NULL,
  `coddivisa` varchar(3) COLLATE utf8_bin DEFAULT NULL,
  `codejercicio` varchar(4) COLLATE utf8_bin NOT NULL,
  `codigo` varchar(20) COLLATE utf8_bin NOT NULL,
  `codigorect` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `codpago` varchar(10) COLLATE utf8_bin DEFAULT NULL,
  `codpais` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `codpostal` varchar(10) COLLATE utf8_bin DEFAULT NULL,
  `codserie` varchar(2) COLLATE utf8_bin NOT NULL,
  `deabono` tinyint(1) DEFAULT '0',
  `direccion` varchar(100) COLLATE utf8_bin NOT NULL,
  `editable` tinyint(1) DEFAULT '0',
  `fecha` date NOT NULL,
  `fp` int(25) NOT NULL,
  `vencimiento` date DEFAULT NULL,
  `femail` date DEFAULT NULL,
  `hora` time DEFAULT '00:00:00',
  `idasiento` int(11) DEFAULT NULL,
  `idasientop` int(11) DEFAULT NULL,
  `idfacturarect` int(11) DEFAULT NULL,
  `idpagodevol` int(11) DEFAULT NULL,
  `idprovincia` int(11) DEFAULT NULL,
  `irpf` double NOT NULL DEFAULT '0',
  `netosindto` double NOT NULL DEFAULT '0',
  `neto` double NOT NULL DEFAULT '0',
  `nogenerarasiento` tinyint(1) DEFAULT NULL,
  `nombrecliente` varchar(100) COLLATE utf8_bin NOT NULL,
  `telefono` varchar(25) COLLATE utf8_bin DEFAULT NULL,
  `numero` varchar(12) COLLATE utf8_bin DEFAULT NULL,
  `numero2` int(25) DEFAULT NULL,
  `observaciones` text COLLATE utf8_bin,
  `pagada` tinyint(1) NOT NULL DEFAULT '0',
  `anulada` tinyint(1) NOT NULL DEFAULT '0',
  `porcomision` double DEFAULT NULL,
  `provincia` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `recfinanciero` double DEFAULT NULL,
  `tasaconv` double NOT NULL DEFAULT '1',
  `total` double NOT NULL DEFAULT '0',
  `totaleuros` double NOT NULL DEFAULT '0',
  `totalirpf` double NOT NULL DEFAULT '0',
  `totaldto` double NOT NULL DEFAULT '0',
  `totaliva` double NOT NULL DEFAULT '0',
  `totalrecargo` double DEFAULT NULL,
  `totalretencion` double DEFAULT NULL,
  `tpv` tinyint(1) DEFAULT NULL,
  `codtrans` varchar(1024) COLLATE utf8_bin DEFAULT NULL,
  `codigoenv` varchar(200) COLLATE utf8_bin DEFAULT NULL,
  `nombreenv` varchar(200) COLLATE utf8_bin DEFAULT NULL,
  `apellidosenv` varchar(200) COLLATE utf8_bin DEFAULT NULL,
  `direccionenv` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `codpostalenv` varchar(10) COLLATE utf8_bin DEFAULT NULL,
  `ciudadenv` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `provinciaenv` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `apartadoenv` varchar(10) COLLATE utf8_bin DEFAULT NULL,
  `codpaisenv` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `idimprenta` int(11) DEFAULT NULL,
  `numdocs` int(11) DEFAULT '0',
  `dtopor1` double DEFAULT '0',
  `dtopor2` double DEFAULT '0',
  `dtopor3` double DEFAULT '0',
  `prefijo` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `qr` varchar(1024) COLLATE utf8_bin DEFAULT NULL,
  `fecha_hora_dian` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `estadodian1` varchar(250) COLLATE utf8_bin DEFAULT '',
  `estadodian2` varchar(1000) COLLATE utf8_bin DEFAULT '',
  `estadodiansimple` varchar(15) COLLATE utf8_bin DEFAULT NULL,
  `estadodiansimple2` varchar(15) COLLATE utf8_bin DEFAULT NULL,
  `estado` int(2) DEFAULT NULL,
  `lineasfactura` int(25) DEFAULT NULL,
  `numero_item` int(12) DEFAULT NULL,
  `nombrexml` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `cufedian` varchar(250) COLLATE utf8_bin DEFAULT NULL,
  `tipo_operacion` varchar(3) COLLATE utf8_bin DEFAULT '10',
  `zipkey` varchar(250) COLLATE utf8_bin DEFAULT NULL,
  `cmetodoenvio` varchar(50) COLLATE utf8_bin DEFAULT 'SendTestSetAsync',
  `medio_pago` int(12) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `facturascli`
--

INSERT INTO `facturascli` (`idfactura`, `referencia`, `resolution_id`, `automatica`, `cifnif`, `ciudad`, `codagente`, `codalmacen`, `codcliente`, `coddir`, `coddivisa`, `codejercicio`, `codigo`, `codigorect`, `codpago`, `codpais`, `codpostal`, `codserie`, `deabono`, `direccion`, `editable`, `fecha`, `fp`, `vencimiento`, `femail`, `hora`, `idasiento`, `idasientop`, `idfacturarect`, `idpagodevol`, `idprovincia`, `irpf`, `netosindto`, `neto`, `nogenerarasiento`, `nombrecliente`, `telefono`, `numero`, `numero2`, `observaciones`, `pagada`, `anulada`, `porcomision`, `provincia`, `recfinanciero`, `tasaconv`, `total`, `totaleuros`, `totalirpf`, `totaldto`, `totaliva`, `totalrecargo`, `totalretencion`, `tpv`, `codtrans`, `codigoenv`, `nombreenv`, `apellidosenv`, `direccionenv`, `codpostalenv`, `ciudadenv`, `provinciaenv`, `apartadoenv`, `codpaisenv`, `idimprenta`, `numdocs`, `dtopor1`, `dtopor2`, `dtopor3`, `prefijo`, `qr`, `fecha_hora_dian`, `estadodian1`, `estadodian2`, `estadodiansimple`, `estadodiansimple2`, `estado`, `lineasfactura`, `numero_item`, `nombrexml`, `cufedian`, `tipo_operacion`, `zipkey`, `cmetodoenvio`, `medio_pago`, `created_at`, `updated_at`) VALUES
(18, 'KJHGHJ', 1, NULL, '1054561218', 'MEDELLIN', '1', NULL, '30', NULL, NULL, '2020', '1', NULL, '1', NULL, NULL, 'A', 0, 'CRA 15#564-587', 0, '2020-09-11', 1, '2020-09-11', NULL, '22:54:41', NULL, NULL, NULL, NULL, NULL, 0, 0, 28000, NULL, 'JUAN BAUTISTA', '326466288', '1', NULL, '', 1, 0, NULL, NULL, NULL, 1, 28000, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, NULL, NULL, NULL, '', '', NULL, NULL, 1, NULL, NULL, NULL, NULL, '10', NULL, 'SendTestSetAsync', 89, '2020-09-11 22:54:41', '2020-09-11 22:54:41');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturasnotes`
--

CREATE TABLE `facturasnotes` (
  `id` int(25) NOT NULL,
  `idfactura` int(11) NOT NULL,
  `resolution_id` int(25) DEFAULT NULL,
  `referencia` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `prefijo` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `numero` varchar(12) COLLATE utf8_bin DEFAULT NULL,
  `numero2` int(25) DEFAULT NULL,
  `zip_number` int(25) DEFAULT NULL,
  `automatica` tinyint(1) DEFAULT NULL,
  `cifnif` varchar(30) COLLATE utf8_bin NOT NULL,
  `ciudad` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `codagente` varchar(10) COLLATE utf8_bin DEFAULT NULL,
  `codalmacen` varchar(4) COLLATE utf8_bin DEFAULT NULL,
  `codcliente` varchar(6) COLLATE utf8_bin DEFAULT NULL,
  `coddir` int(11) DEFAULT NULL,
  `coddivisa` varchar(3) COLLATE utf8_bin NOT NULL,
  `codejercicio` varchar(4) COLLATE utf8_bin NOT NULL,
  `codigo` varchar(20) COLLATE utf8_bin NOT NULL,
  `codigorect` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `codpago` varchar(10) COLLATE utf8_bin NOT NULL,
  `codpais` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `codpostal` varchar(10) COLLATE utf8_bin DEFAULT NULL,
  `codserie` varchar(2) COLLATE utf8_bin NOT NULL,
  `deabono` tinyint(1) DEFAULT '0',
  `direccion` varchar(100) COLLATE utf8_bin NOT NULL,
  `editable` tinyint(1) DEFAULT '0',
  `fecha` date NOT NULL,
  `fp` int(25) NOT NULL,
  `vencimiento` date DEFAULT NULL,
  `femail` date DEFAULT NULL,
  `hora` time DEFAULT '00:00:00',
  `idasiento` int(11) DEFAULT NULL,
  `idasientop` int(11) DEFAULT NULL,
  `idfacturarect` int(11) DEFAULT NULL,
  `idpagodevol` int(11) DEFAULT NULL,
  `idprovincia` int(11) DEFAULT NULL,
  `irpf` double NOT NULL DEFAULT '0',
  `netosindto` double NOT NULL DEFAULT '0',
  `neto` double NOT NULL DEFAULT '0',
  `nogenerarasiento` tinyint(1) DEFAULT NULL,
  `nombrecliente` varchar(100) COLLATE utf8_bin NOT NULL,
  `telefono` varchar(25) COLLATE utf8_bin DEFAULT NULL,
  `observaciones` text COLLATE utf8_bin,
  `pagada` tinyint(1) NOT NULL DEFAULT '0',
  `anulada` tinyint(1) NOT NULL DEFAULT '0',
  `porcomision` double DEFAULT NULL,
  `provincia` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `recfinanciero` double DEFAULT NULL,
  `tasaconv` double NOT NULL DEFAULT '1',
  `total` double NOT NULL DEFAULT '0',
  `totaleuros` double NOT NULL DEFAULT '0',
  `totalirpf` double NOT NULL DEFAULT '0',
  `totaldto` double NOT NULL DEFAULT '0',
  `totaliva` double NOT NULL DEFAULT '0',
  `totalrecargo` double DEFAULT NULL,
  `totalretencion` double DEFAULT NULL,
  `tpv` tinyint(1) DEFAULT NULL,
  `codtrans` varchar(1024) COLLATE utf8_bin DEFAULT NULL,
  `codigoenv` varchar(200) COLLATE utf8_bin DEFAULT NULL,
  `nombreenv` varchar(200) COLLATE utf8_bin DEFAULT NULL,
  `apellidosenv` varchar(200) COLLATE utf8_bin DEFAULT NULL,
  `direccionenv` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `codpostalenv` varchar(10) COLLATE utf8_bin DEFAULT NULL,
  `ciudadenv` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `provinciaenv` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `apartadoenv` varchar(10) COLLATE utf8_bin DEFAULT NULL,
  `codpaisenv` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `idimprenta` int(11) DEFAULT NULL,
  `numdocs` int(11) DEFAULT '0',
  `dtopor1` double DEFAULT '0',
  `dtopor2` double DEFAULT '0',
  `dtopor3` double DEFAULT '0',
  `qr` varchar(1024) COLLATE utf8_bin DEFAULT NULL,
  `fecha_hora_dian` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `estadodian1` varchar(250) COLLATE utf8_bin DEFAULT '',
  `estadodian2` varchar(1000) COLLATE utf8_bin DEFAULT '',
  `estadodiansimple` varchar(15) COLLATE utf8_bin DEFAULT NULL,
  `estadodiansimple2` varchar(15) COLLATE utf8_bin DEFAULT NULL,
  `estado` int(2) DEFAULT NULL,
  `lineasfactura` int(25) DEFAULT NULL,
  `numero_item` int(12) DEFAULT NULL,
  `nombrexml` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `cufedian` varchar(250) COLLATE utf8_bin DEFAULT NULL,
  `tipo_operacion` varchar(3) COLLATE utf8_bin DEFAULT '10',
  `zipkey` varchar(250) COLLATE utf8_bin DEFAULT NULL,
  `cmetodoenvio` varchar(50) COLLATE utf8_bin DEFAULT 'SendTestSetAsync',
  `medio_pago` int(12) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturasprov`
--

CREATE TABLE `facturasprov` (
  `idfactura` int(12) NOT NULL,
  `cifnif` varchar(30) NOT NULL,
  `codproveedor` int(12) NOT NULL,
  `coddivisa` varchar(30) NOT NULL,
  `codpago` varchar(30) DEFAULT NULL,
  `codserie` varchar(30) DEFAULT NULL,
  `nombre` varchar(255) NOT NULL,
  `telefono` varchar(30) NOT NULL,
  `email` varchar(255) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `fecha` date NOT NULL,
  `ejercicio` varchar(50) NOT NULL,
  `hora` time NOT NULL,
  `fp` int(12) NOT NULL,
  `estado` int(12) NOT NULL,
  `lineasfactura` int(200) NOT NULL,
  `deabono` varchar(255) DEFAULT NULL,
  `observaciones` varchar(255) NOT NULL,
  `numero` int(30) NOT NULL,
  `RE` float DEFAULT NULL,
  `totaliva` double DEFAULT NULL,
  `totaldto` double DEFAULT NULL,
  `totalrecargo` double DEFAULT NULL,
  `total` double DEFAULT NULL,
  `referencia` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `facturasprov`
--

INSERT INTO `facturasprov` (`idfactura`, `cifnif`, `codproveedor`, `coddivisa`, `codpago`, `codserie`, `nombre`, `telefono`, `email`, `direccion`, `fecha`, `ejercicio`, `hora`, `fp`, `estado`, `lineasfactura`, `deabono`, `observaciones`, `numero`, `RE`, `totaliva`, `totaldto`, `totalrecargo`, `total`, `referencia`) VALUES
(10, '1054561218', 42, 'COP', NULL, NULL, 'JUAN BAUTISTA', '3206466288', 'JUAN@GMAIL.COM', 'CRA 6565', '2020-09-11', '2020', '22:57:16', 1, 1, 1, NULL, '', 1, 0, 7125, 0, NULL, 149625, 'ASFASFA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingresos_clientes`
--

CREATE TABLE `ingresos_clientes` (
  `id_ingreso` int(12) NOT NULL,
  `idfactura` int(12) DEFAULT NULL,
  `linea` int(30) DEFAULT NULL,
  `numero` int(30) NOT NULL,
  `cliente` varchar(255) NOT NULL,
  `id_cliente` int(12) NOT NULL,
  `importe` double NOT NULL,
  `divisa` varchar(30) NOT NULL DEFAULT 'COP',
  `fp` tinyint(4) NOT NULL,
  `observaciones` varchar(1024) CHARACTER SET utf8 DEFAULT NULL,
  `concepto` varchar(255) NOT NULL,
  `estado_ingreso` int(12) NOT NULL DEFAULT '0',
  `date_added` date NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lineasfacturascli`
--

CREATE TABLE `lineasfacturascli` (
  `idlinea` int(11) NOT NULL,
  `idfactura` int(11) NOT NULL,
  `no_linea` int(4) DEFAULT NULL,
  `cantidad` double NOT NULL DEFAULT '0',
  `codimpuesto` varchar(10) COLLATE utf8_bin DEFAULT NULL,
  `descripcion` varchar(1024) CHARACTER SET utf8 NOT NULL,
  `dtolineal` double NOT NULL DEFAULT '0',
  `dtopor` double NOT NULL DEFAULT '0',
  `dtopor2` double NOT NULL DEFAULT '0',
  `dtopor3` double NOT NULL DEFAULT '0',
  `info_doc` varchar(1024) COLLATE utf8_bin DEFAULT NULL,
  `idalbaran` int(11) DEFAULT NULL,
  `idlineaalbaran` int(11) DEFAULT NULL,
  `irpf` double DEFAULT NULL,
  `iva` double NOT NULL,
  `retencion` double DEFAULT '0',
  `neto` double DEFAULT '0',
  `porcomision` double DEFAULT NULL,
  `pvpsindto` double DEFAULT NULL,
  `pvptotal` double NOT NULL,
  `pvpunitario` double NOT NULL,
  `recargo` double DEFAULT NULL,
  `referencia` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `codigo_estandar` int(25) DEFAULT NULL,
  `codcombinacion` varchar(18) COLLATE utf8_bin DEFAULT NULL,
  `orden` int(11) DEFAULT '0',
  `mostrar_cantidad` tinyint(1) DEFAULT '1',
  `mostrar_precio` tinyint(1) DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `lineasfacturascli`
--

INSERT INTO `lineasfacturascli` (`idlinea`, `idfactura`, `no_linea`, `cantidad`, `codimpuesto`, `descripcion`, `dtolineal`, `dtopor`, `dtopor2`, `dtopor3`, `info_doc`, `idalbaran`, `idlineaalbaran`, `irpf`, `iva`, `retencion`, `neto`, `porcomision`, `pvpsindto`, `pvptotal`, `pvpunitario`, `recargo`, `referencia`, `codigo_estandar`, `codcombinacion`, `orden`, `mostrar_cantidad`, `mostrar_precio`, `created_at`, `updated_at`) VALUES
(19, 18, 1, 10, NULL, 'CERVEZA PILSEN', 0, 0, 0, 0, NULL, NULL, NULL, NULL, 0, 0, 28000, NULL, 28000, 28000, 2800, 0, 'KUGKGF', 2, NULL, 0, 1, 1, '2020-09-11 22:54:41', '2020-09-11 22:54:41');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lineasfacturasnotes`
--

CREATE TABLE `lineasfacturasnotes` (
  `idlinea` int(11) NOT NULL,
  `note_id` int(11) NOT NULL,
  `cantidad` double NOT NULL DEFAULT '0',
  `codimpuesto` varchar(10) COLLATE utf8_bin DEFAULT NULL,
  `descripcion` varchar(1024) CHARACTER SET utf8 NOT NULL,
  `dtolineal` double NOT NULL DEFAULT '0',
  `dtopor` double NOT NULL DEFAULT '0',
  `dtopor2` double NOT NULL DEFAULT '0',
  `dtopor3` double NOT NULL DEFAULT '0',
  `info_doc` varchar(1024) COLLATE utf8_bin DEFAULT NULL,
  `idalbaran` int(11) DEFAULT NULL,
  `no_linea` int(4) DEFAULT NULL,
  `idlineaalbaran` int(11) DEFAULT NULL,
  `irpf` double DEFAULT NULL,
  `iva` double NOT NULL,
  `retencion` double DEFAULT '0',
  `neto` double DEFAULT '0',
  `porcomision` double DEFAULT NULL,
  `pvpsindto` double DEFAULT NULL,
  `pvptotal` double NOT NULL,
  `pvpunitario` double NOT NULL,
  `recargo` double DEFAULT NULL,
  `referencia` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `codigo_estandar` int(25) DEFAULT NULL,
  `codcombinacion` varchar(18) COLLATE utf8_bin DEFAULT NULL,
  `orden` int(11) DEFAULT '0',
  `mostrar_cantidad` tinyint(1) DEFAULT '1',
  `mostrar_precio` tinyint(1) DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lineasfacturasprov`
--

CREATE TABLE `lineasfacturasprov` (
  `idfactura` int(12) NOT NULL,
  `id_linea` int(12) NOT NULL,
  `No_linea` int(12) DEFAULT NULL,
  `articulo` varchar(1024) CHARACTER SET utf8 NOT NULL,
  `cantidad` int(25) NOT NULL,
  `precio` double NOT NULL,
  `dto` double NOT NULL DEFAULT '0',
  `neto` double NOT NULL,
  `retencion` double DEFAULT '0',
  `iva` double NOT NULL DEFAULT '0',
  `total` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `lineasfacturasprov`
--

INSERT INTO `lineasfacturasprov` (`idfactura`, `id_linea`, `No_linea`, `articulo`, `cantidad`, `precio`, `dto`, `neto`, `retencion`, `iva`, `total`) VALUES
(10, 22, 1, 'CERVEZA AGUILA', 50, 2850, 0, 142500, 0, 7125, 149625);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marca`
--

CREATE TABLE `marca` (
  `IdMarca` int(12) NOT NULL,
  `Nombre` varchar(512) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modulos_asignados`
--

CREATE TABLE `modulos_asignados` (
  `id` int(12) NOT NULL,
  `nombre_modulo` varchar(255) NOT NULL,
  `user_id` int(12) NOT NULL,
  `user_id_asignador` int(12) NOT NULL,
  `date_added` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `modulos_asignados`
--

INSERT INTO `modulos_asignados` (`id`, `nombre_modulo`, `user_id`, `user_id_asignador`, `date_added`) VALUES
(2, 'Vehiculos', 6, 4, '2019-11-09'),
(3, 'Gps', 7, 6, '2020-01-24'),
(5, 'Liquidaciones', 7, 8, '2020-06-30'),
(6, 'Servicios', 7, 8, '2020-06-30'),
(8, 'Vehiculos', 7, 8, '2020-06-30'),
(9, 'Vehiculos', 11, 1, '2020-07-09'),
(10, 'Chequeos', 11, 1, '2020-07-09'),
(11, 'Servicios', 11, 1, '2020-07-09'),
(12, 'Contratos', 11, 1, '2020-07-09'),
(13, 'Extractos', 11, 1, '2020-07-09');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paises`
--

CREATE TABLE `paises` (
  `codiso` varchar(2) COLLATE utf8_bin DEFAULT NULL,
  `codpais` varchar(20) COLLATE utf8_bin NOT NULL,
  `nombre` varchar(100) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `paises`
--

INSERT INTO `paises` (`codiso`, `codpais`, `nombre`) VALUES
('AW', 'ABW', 'Aruba'),
('AF', 'AFG', 'Afganistán'),
('AO', 'AGO', 'Angola'),
('AI', 'AIA', 'Anguila'),
('AX', 'ALA', 'Islas Gland'),
('AL', 'ALB', 'Albania'),
('AD', 'AND', 'Andorra'),
('AN', 'ANT', 'Antillas Holandesas'),
('AE', 'ARE', 'Emiratos Árabes Unidos'),
('AR', 'ARG', 'Argentina'),
('AM', 'ARM', 'Armenia'),
('AS', 'ASM', 'Samoa Americana'),
('AQ', 'ATA', 'Antártida'),
('TF', 'ATF', 'Territorios Australes Franceses'),
('AG', 'ATG', 'Antigua y Barbuda'),
('AU', 'AUS', 'Australia'),
('AT', 'AUT', 'Austria'),
('AZ', 'AZE', 'Azerbaiyán'),
('BI', 'BDI', 'Burundi'),
('BE', 'BEL', 'Bélgica'),
('BJ', 'BEN', 'Benín'),
('BF', 'BFA', 'Burkina Faso'),
('BD', 'BGD', 'Bangladesh'),
('BG', 'BGR', 'Bulgaria'),
('BH', 'BHR', 'Bahréin'),
('BS', 'BHS', 'Bahamas'),
('BA', 'BIH', 'Bosnia y Herzegovina'),
('BY', 'BLR', 'Bielorrusia'),
('BZ', 'BLZ', 'Belice'),
('BM', 'BMU', 'Bermudas'),
('BO', 'BOL', 'Bolivia'),
('BR', 'BRA', 'Brasil'),
('BB', 'BRB', 'Barbados'),
('BN', 'BRN', 'Brunéi'),
('BT', 'BTN', 'Bhután'),
('BV', 'BVT', 'Isla Bouvet'),
('BW', 'BWA', 'Botsuana'),
('CF', 'CAF', 'República Centroafricana'),
('CA', 'CAN', 'Canadá'),
('CC', 'CCK', 'Islas Cocos'),
('CH', 'CHE', 'Suiza'),
('CL', 'CHL', 'Chile'),
('CN', 'CHN', 'China'),
('CI', 'CIV', 'Costa de Marfil'),
('CM', 'CMR', 'Camerún'),
('CD', 'COD', 'República Democrática del Congo'),
('CG', 'COG', 'Congo'),
('CK', 'COK', 'Islas Cook'),
('CO', 'COL', 'Colombia'),
('KM', 'COM', 'Comoras'),
('CV', 'CPV', 'Cabo Verde'),
('CR', 'CRI', 'Costa Rica'),
('CU', 'CUB', 'Cuba'),
('CX', 'CXR', 'Isla de Navidad'),
('KY', 'CYM', 'Islas Caimán'),
('CY', 'CYP', 'Chipre'),
('CZ', 'CZE', 'República Checa'),
('DE', 'DEU', 'Alemania'),
('DJ', 'DJI', 'Yibuti'),
('DM', 'DMA', 'Dominica'),
('DK', 'DNK', 'Dinamarca'),
('DO', 'DOM', 'República Dominicana'),
('DZ', 'DZA', 'Argelia'),
('EC', 'ECU', 'Ecuador'),
('EG', 'EGY', 'Egipto'),
('ER', 'ERI', 'Eritrea'),
('EH', 'ESH', 'Sahara Occidental'),
('ES', 'ESP', 'España'),
('EE', 'EST', 'Estonia'),
('ET', 'ETH', 'Etiopía'),
('FI', 'FIN', 'Finlandia'),
('FJ', 'FJI', 'Fiyi'),
('FK', 'FLK', 'Islas Malvinas'),
('FR', 'FRA', 'Francia'),
('FO', 'FRO', 'Islas Feroe'),
('FM', 'FSM', 'Micronesia'),
('GA', 'GAB', 'Gabón'),
('GB', 'GBR', 'Reino Unido'),
('GE', 'GEO', 'Georgia'),
('GH', 'GHA', 'Ghana'),
('GI', 'GIB', 'Gibraltar'),
('GN', 'GIN', 'Guinea'),
('GP', 'GLP', 'Guadalupe'),
('GM', 'GMB', 'Gambia'),
('GW', 'GNB', 'Guinea-Bissau'),
('GQ', 'GNQ', 'Guinea Ecuatorial'),
('GR', 'GRC', 'Grecia'),
('GD', 'GRD', 'Granada'),
('GL', 'GRL', 'Groenlandia'),
('GT', 'GTM', 'Guatemala'),
('GF', 'GUF', 'Guayana Francesa'),
('GU', 'GUM', 'Guam'),
('GY', 'GUY', 'Guyana'),
('HK', 'HKG', 'Hong Kong'),
('HM', 'HMD', 'Islas Heard y McDonald'),
('HN', 'HND', 'Honduras'),
('HR', 'HRV', 'Croacia'),
('HT', 'HTI', 'Haití'),
('HU', 'HUN', 'Hungría'),
('ID', 'IDN', 'Indonesia'),
('IN', 'IND', 'India'),
('IO', 'IOT', 'Territorio Británico del Océano Índico'),
('IE', 'IRL', 'Irlanda'),
('IR', 'IRN', 'Irán'),
('IQ', 'IRQ', 'Iraq'),
('IS', 'ISL', 'Islandia'),
('IL', 'ISR', 'Israel'),
('IT', 'ITA', 'Italia'),
('JM', 'JAM', 'Jamaica'),
('JO', 'JOR', 'Jordania'),
('JP', 'JPN', 'Japón'),
('KZ', 'KAZ', 'Kazajstán'),
('KE', 'KEN', 'Kenia'),
('KG', 'KGZ', 'Kirguistán'),
('KH', 'KHM', 'Camboya'),
('KI', 'KIR', 'Kiribati'),
('KN', 'KNA', 'San Cristóbal y Nieves'),
('KR', 'KOR', 'Corea del Sur'),
('KW', 'KWT', 'Kuwait'),
('LA', 'LAO', 'Laos'),
('LB', 'LBN', 'Líbano'),
('LR', 'LBR', 'Liberia'),
('LY', 'LBY', 'Libia'),
('LC', 'LCA', 'Santa Lucía'),
('LI', 'LIE', 'Liechtenstein'),
('LK', 'LKA', 'Sri Lanka'),
('LS', 'LSO', 'Lesotho'),
('LT', 'LTU', 'Lituania'),
('LU', 'LUX', 'Luxemburgo'),
('LV', 'LVA', 'Letonia'),
('MO', 'MAC', 'Macao'),
('MA', 'MAR', 'Marruecos'),
('MC', 'MCO', 'Mónaco'),
('MD', 'MDA', 'Moldavia'),
('MG', 'MDG', 'Madagascar'),
('MV', 'MDV', 'Maldivas'),
('MX', 'MEX', 'México'),
('MH', 'MHL', 'Islas Marshall'),
('MK', 'MKD', 'Macedonia'),
('ML', 'MLI', 'Malí'),
('MT', 'MLT', 'Malta'),
('MM', 'MMR', 'Myanmar'),
('ME', 'MNE', 'Montenegro'),
('MN', 'MNG', 'Mongolia'),
('MP', 'MNP', 'Islas Marianas del Norte'),
('MZ', 'MOZ', 'Mozambique'),
('MR', 'MRT', 'Mauritania'),
('MS', 'MSR', 'Montserrat'),
('MQ', 'MTQ', 'Martinica'),
('MU', 'MUS', 'Mauricio'),
('MW', 'MWI', 'Malaui'),
('MY', 'MYS', 'Malasia'),
('YT', 'MYT', 'Mayotte'),
('NA', 'NAM', 'Namibia'),
('NC', 'NCL', 'Nueva Caledonia'),
('NE', 'NER', 'Níger'),
('NF', 'NFK', 'Isla Norfolk'),
('NG', 'NGA', 'Nigeria'),
('NI', 'NIC', 'Nicaragua'),
('NU', 'NIU', 'Niue'),
('NL', 'NLD', 'Países Bajos'),
('NO', 'NOR', 'Noruega'),
('NP', 'NPL', 'Nepal'),
('NR', 'NRU', 'Nauru'),
('NZ', 'NZL', 'Nueva Zelanda'),
('OM', 'OMN', 'Omán'),
('PK', 'PAK', 'Pakistán'),
('PA', 'PAN', 'Panamá'),
('PN', 'PCN', 'Islas Pitcairn'),
('PE', 'PER', 'Perú'),
('PH', 'PHL', 'Filipinas'),
('PW', 'PLW', 'Palaos'),
('PG', 'PNG', 'Papúa Nueva Guinea'),
('PL', 'POL', 'Polonia'),
('PR', 'PRI', 'Puerto Rico'),
('KP', 'PRK', 'Corea del Norte'),
('PT', 'PRT', 'Portugal'),
('PY', 'PRY', 'Paraguay'),
('PS', 'PSE', 'Palestina'),
('PF', 'PYF', 'Polinesia Francesa'),
('QA', 'QAT', 'Qatar'),
('RE', 'REU', 'Reunión'),
('RO', 'ROU', 'Rumania'),
('RU', 'RUS', 'Rusia'),
('RW', 'RWA', 'Ruanda'),
('SA', 'SAU', 'Arabia Saudí'),
('SD', 'SDN', 'Sudán'),
('SN', 'SEN', 'Senegal'),
('SG', 'SGP', 'Singapur'),
('GS', 'SGS', 'Islas Georgias del Sur y Sandwich del Sur'),
('SH', 'SHN', 'Santa Helena'),
('SJ', 'SJM', 'Svalbard y Jan Mayen'),
('SB', 'SLB', 'Islas Salomón'),
('SL', 'SLE', 'Sierra Leona'),
('SV', 'SLV', 'El Salvador'),
('SM', 'SMR', 'San Marino'),
('SO', 'SOM', 'Somalia'),
('PM', 'SPM', 'San Pedro y Miquelón'),
('RS', 'SRB', 'Serbia'),
('ST', 'STP', 'Santo Tomé y Príncipe'),
('SR', 'SUR', 'Surinam'),
('SK', 'SVK', 'Eslovaquia'),
('SI', 'SVN', 'Eslovenia'),
('SE', 'SWE', 'Suecia'),
('SZ', 'SWZ', 'Suazilandia'),
('SC', 'SYC', 'Seychelles'),
('SY', 'SYR', 'Siria'),
('TC', 'TCA', 'Islas Turcas y Caicos'),
('TD', 'TCD', 'Chad'),
('TG', 'TGO', 'Togo'),
('TH', 'THA', 'Tailandia'),
('TJ', 'TJK', 'Tayikistán'),
('TK', 'TKL', 'Tokelau'),
('TM', 'TKM', 'Turkmenistán'),
('TL', 'TLS', 'Timor Oriental'),
('TO', 'TON', 'Tonga'),
('TT', 'TTO', 'Trinidad y Tobago'),
('TN', 'TUN', 'Túnez'),
('TR', 'TUR', 'Turquía'),
('TV', 'TUV', 'Tuvalu'),
('TW', 'TWN', 'Taiwán'),
('TZ', 'TZA', 'Tanzania'),
('UG', 'UGA', 'Uganda'),
('UA', 'UKR', 'Ucrania'),
('UM', 'UMI', 'Islas Ultramarinas de Estados Unidos'),
('UY', 'URY', 'Uruguay'),
('US', 'USA', 'Estados Unidos'),
('UZ', 'UZB', 'Uzbekistán'),
('VA', 'VAT', 'Ciudad del Vaticano'),
('VC', 'VCT', 'San Vicente y las Granadinas'),
('VE', 'VEN', 'Venezuela'),
('VG', 'VGB', 'Islas Vírgenes Británicas'),
('VI', 'VIR', 'Islas Vírgenes de los Estados Unidos'),
('VN', 'VNM', 'Vietnam'),
('VU', 'VUT', 'Vanuatu'),
('WF', 'WLF', 'Wallis y Futuna'),
('WS', 'WSM', 'Samoa'),
('YE', 'YEM', 'Yemen'),
('ZA', 'ZAF', 'Sudáfrica'),
('ZM', 'ZMB', 'Zambia'),
('ZW', 'ZWE', 'Zimbabue');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `payment_methods`
--

CREATE TABLE `payment_methods` (
  `id` int(12) NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Facturacion';

--
-- Volcado de datos para la tabla `payment_methods`
--

INSERT INTO `payment_methods` (`id`, `name`, `code`, `created_at`, `updated_at`) VALUES
(80, 'Instrumento no definido', '1', NULL, NULL),
(81, 'Crédito ACH', '2', NULL, NULL),
(82, 'Débito ACH', '3', NULL, NULL),
(83, 'Reversión débito de demanda ACH', '4', NULL, NULL),
(84, 'Reversión crédito de demanda ACH', '5', NULL, NULL),
(85, 'Crédito de demanda ACH', '6', NULL, NULL),
(86, 'Débito de demanda ACH	', '7', NULL, NULL),
(87, 'Mantener', '8', NULL, NULL),
(88, 'Clearing Nacional o Regional', '9', NULL, NULL),
(89, 'Efectivo', '10', NULL, NULL),
(90, 'Reversión Crédito Ahorro', '11', NULL, NULL),
(91, 'Reversión Débito Ahorro', '12', NULL, NULL),
(92, 'Crédito Ahorro', '13', NULL, NULL),
(93, 'Débito Ahorro', '14', NULL, NULL),
(94, 'Bookentry Crédito', '15', NULL, NULL),
(95, 'Bookentry Débito', '16', NULL, NULL),
(96, 'Concentración de la demanda en efectivo /Desembolso Crédito (CCD),', '17', NULL, NULL),
(97, 'Concentración de la demanda en efectivo / Desembolso (CCD), débito	', '18', NULL, NULL),
(98, 'Crédito Pago negocio corporativo (CTP),', '19', NULL, NULL),
(99, 'Cheque', '20', NULL, NULL),
(100, 'Poyecto bancario', '21', NULL, NULL),
(101, 'Proyecto bancario certificado', '22', NULL, NULL),
(102, 'Cheque bancario', '23', NULL, NULL),
(103, 'Nota cambiaria esperando aceptación', '24', NULL, NULL),
(104, 'Cheque certificado', '25', NULL, NULL),
(105, 'Cheque Local', '26', NULL, NULL),
(106, 'Débito Pago Neogcio Corporativo (CTP),', '27', NULL, NULL),
(107, 'Crédito Negocio Intercambio Corporativo (CTX),', '28', NULL, NULL),
(108, 'Débito Negocio Intercambio Corporativo (CTX),', '29', NULL, NULL),
(109, 'Transferecia Crédito', '30', NULL, NULL),
(110, 'Transferencia Débito', '31', NULL, NULL),
(111, 'Concentración Efectivo / Desembolso Crédito plus (CCD+),', '32', NULL, NULL),
(112, 'Concentración Efectivo / Desembolso Débito plus (CCD+),', '33', NULL, NULL),
(113, 'Pago y depósito pre acordado (PPD),', '34', NULL, NULL),
(114, 'Concentración efectivo ahorros / Desembolso Crédito (CCD),', '35', NULL, NULL),
(115, 'Concentración efectivo ahorros / Desembolso Drédito (CCD),', '36', NULL, NULL),
(116, 'Pago Negocio Corporativo Ahorros Crédito (CTP),', '37', NULL, NULL),
(117, 'Pago Neogcio Corporativo Ahorros Débito (CTP),', '38', NULL, NULL),
(118, 'Crédito Negocio Intercambio Corporativo (CTX),', '39', NULL, NULL),
(119, 'Débito Negocio Intercambio Corporativo (CTX),', '40', NULL, NULL),
(120, 'Concentración efectivo/Desembolso Crédito plus (CCD+),', '41', NULL, NULL),
(121, 'Consiganción bancaria', '42', NULL, NULL),
(122, 'Concentración efectivo / Desembolso Débito plus (CCD+),', '43', NULL, NULL),
(123, 'Nota cambiaria', '44', NULL, NULL),
(124, 'Transferencia Crédito Bancario', '45', NULL, NULL),
(125, 'Transferencia Débito Interbancario', '46', NULL, NULL),
(126, 'Transferencia Débito Bancaria', '47', NULL, NULL),
(127, 'Tarjeta Crédito', '48', NULL, NULL),
(128, 'Tarjeta Débito', '49', NULL, NULL),
(129, 'Postgiro', '50', NULL, NULL),
(130, 'Telex estándar bancario francés', '51', NULL, NULL),
(131, 'Pago comercial urgente', '52', NULL, NULL),
(132, 'Pago Tesorería Urgente', '53', NULL, NULL),
(133, 'Nota promisoria', '60', NULL, NULL),
(134, 'Nota promisoria firmada por el acreedor', '61', NULL, NULL),
(135, 'Nota promisoria firmada por el acreedor, avalada por el banco', '62', NULL, NULL),
(136, 'Nota promisoria firmada por el acreedor, avalada por un tercero', '63', NULL, NULL),
(137, 'Nota promisoria firmada pro el banco', '64', NULL, NULL),
(138, 'Nota promisoria firmada por un banco avalada por otro banco', '65', NULL, NULL),
(139, 'Nota promisoria firmada ', '66', NULL, NULL),
(140, 'Nota promisoria firmada por un tercero avalada por un banco', '67', NULL, NULL),
(141, 'Retiro de nota por el por el acreedor', '70', NULL, NULL),
(142, 'Retiro de nota por el por el acreedor sobre un banco', '74', NULL, NULL),
(143, 'Retiro de nota por el acreedor, avalada por otro banco', '75', NULL, NULL),
(144, 'Retiro de nota por el acreedor, sobre un banco avalada por un tercero', '76', NULL, NULL),
(145, 'Retiro de una nota por el acreedor sobre un tercero', '77', NULL, NULL),
(146, 'Retiro de una nota por el acreedor sobre un tercero avalada por un banco', '78', NULL, NULL),
(147, 'Nota bancaria tranferible', '91', NULL, NULL),
(148, 'Cheque local traferible', '92', NULL, NULL),
(149, 'Giro referenciado', '93', NULL, NULL),
(150, 'Giro urgente', '94', NULL, NULL),
(151, 'Giro formato abierto', '95', NULL, NULL),
(152, 'Método de pago solicitado no usuado', '96', NULL, NULL),
(153, 'Clearing entre partners', '97', NULL, NULL),
(154, 'Acuerdo mutuo', 'Z', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfil`
--

CREATE TABLE `perfil` (
  `id_perfil` int(11) NOT NULL,
  `nombre_empresa` varchar(150) NOT NULL,
  `direccion_territorial` varchar(10) NOT NULL,
  `resolucion_empresa` int(10) NOT NULL,
  `numero_habilitacion` int(11) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `ciudad` varchar(100) NOT NULL,
  `nit_empresa` varchar(100) NOT NULL,
  `representante_legal` varchar(55) CHARACTER SET utf8 DEFAULT NULL,
  `estado` varchar(100) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `email` varchar(64) NOT NULL,
  `email_alerta` varchar(64) NOT NULL,
  `id_telegram` varchar(255) DEFAULT NULL,
  `servidor_verificacion` varchar(255) NOT NULL,
  `impuesto` int(2) NOT NULL,
  `moneda` varchar(255) NOT NULL,
  `logo_url` varchar(255) NOT NULL,
  `firma` varchar(255) DEFAULT NULL,
  `hostEmail` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `userEmail` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `passwordEmail` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `logoGTEP` blob,
  `nombre_banco` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `tipo_cuenta` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `numero_cuenta` varchar(255) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `perfil`
--

INSERT INTO `perfil` (`id_perfil`, `nombre_empresa`, `direccion_territorial`, `resolucion_empresa`, `numero_habilitacion`, `direccion`, `ciudad`, `nit_empresa`, `representante_legal`, `estado`, `telefono`, `email`, `email_alerta`, `id_telegram`, `servidor_verificacion`, `impuesto`, `moneda`, `logo_url`, `firma`, `hostEmail`, `userEmail`, `passwordEmail`, `logoGTEP`, `nombre_banco`, `tipo_cuenta`, `numero_cuenta`) VALUES
(1, 'TRANSPORTES ESPECIALES ONIX S.A.S', '305', 49, 19, 'CARRERA 65 8 B 91 OF 305', 'Medellín', '901195461-7', 'PABLO ANDRES LONDOÑO GIRALDO', 'Antioquia', '3107237767', 'asistentegerencia@transportesonix.com', 'asistenteadministrativa@transportesonix.com', '1014696847', 'https://gtep.me', 1, '#1872f2', 'Empresa/img/1599881926_logouser.png', 'Empresa/img/1595107002_firma.png', 'mail.transportesonix.com', 'info@transportesonix.com', '2h$QNfpd565?', 0x646174613a696d6167652f706e673b6261736536342c6956424f5277304b47676f414141414e5355684555674141415751414141424143415941414141745551323041414141426d4a4c523051412f77442f41502b6776616554414141414358424957584d41414173544141414c457745416d707759414141414233524a5455554834774d4f41786753694a2b5a4a7741414555644a52454655654e72746e587555564d5764787a2f5650544d5851524369726b396356496a4d51384672317332794b327149353851594535587061344b4248675a6632665735726d2b6a5a6c654a72787866776177766d415a467544336a4d316e7771496b4c3852586471784a36414a396f68446943434b677764366237317637526a63476870322f31394f326537706e366e444d48546c6664756c5631662f57746478566f4e42714e52715052614451616a55616a30576730476f31476f39466f4e42714e52715052614451616a55616a30576730476b312b69464b38354c523537614f715174356f454873447734467141436e5a4c6753626b484b6433645477515244766973784c6a4344454163432b5349596a4d41514943643149746f675148536b762f483562302f68742b764e724e4a57425956724467616f796a56375364657a50697962496b5668694448416334506b38482f5a6b65466c62302f6833733462546b6a675677666b437867416a676431336950464f62414f32534d6e48435034374871322f7230394350443978724a447941684154674432414555424e44323964774f66414a676e4c525368306b7a3239396d322f73483830643957496d7244335936425449557333566c56565066504947642f734c7361586a3851535038716b7a34387154345266614a7378666b306552693841492f4f74706742484151634251307456656665434233774976416773426261366a75336d576142507a71526e6f46454e334f4d3639726f73416e5978454b717739486a41375430467a6a43746c34462f4c504f3466777738417977436e676536584d644f35684e415653387150516d5970784a416d46517a384a55676e3772676e534656644a306f55743644434559704244455547436f452b774833526d4b4a36794455324a33736575587857524e7956676a57672b3156736c704d78504e69516c4b6e6f426b31774a37416e674c4734586e4e6b5a624558415258784b503147336f747a47467675345362424372706b5a32705a4e6345344b326776375956613638442b56436d59737364433641724c4862505137424f42483442484170386f30774e2f747764686d2b59317576415261356a712b627a4434457a42326744386b6c6758592f66686d652b5a795879594b62687444506446524476665948706d623855384c3568576b7542793133485675715268334c555571714e62472b6e3174766b61733939566e6a7955595159315a635543646866344c31595856553170334842657a57392b5a73364c7a47614b766d516b4e3672516c4458357936436f466e414371746c35597a652f4b51494a77576f7474794853454b52596e787443616570694847475735383634374176465952346f6d46614476412f77442b5573526a334e507754675457476163554d3039705473655531554a47396d6d376c6b6371526e6b6f69444977467a674f2b4e457a7246734f3039757172494f644e593076376d514b65427634356f4c47556334585875545437384d536167304f434e34485441797667517353732b537650792b6259466830766b66497034457531346947764b3036786b35636f2b74774b7a466351347a4f423134456a4b396a775a77416244644d61694d4d526d6f4844706341477737536d46466551686653736c76594c51304c654477774a4d6755436558776b6c6d6a37577265395a64566b495a5076436258686b447a315474776461556c4573376e5a5451307641456f546a304a51626257302f32764177785558434d4649526538767039696a3355654d5a775033447943442f354e685773666f6371387063353431544f76716f676d79684b7351386f356978563741615932783967734270733566335944776e697a697578434365794f78784b52654250752f3871696f4c686e5a2b6c6b674532476e7866356344664a475666386534745a486f7764364f635234436e446c41445030454c444d4d4b30446333786554666b7a474c375444595a704e57647a71416f67393859587636544a36794c7a33336b493654364e32677144516a41455842465a734770716648727431795953346b313169794b78784c306976594c446a2f31502b474c39642b5070576465434342502b4755696c73574d4a37613352756d647a6950452b774c4d46524b636232464c43676d4f67506d344f45434f395171516e4877442f74314f6854374c72574757795237706b6c742b797a5a6f504a7a332b336874647743756b7878574c6b54393957584c566d666d4f35595a48333866374c774e654b494674686b6e50745977446a67612b6c36654e416a786f6d4e61696e704e39356271757279656a684852586b70374d4b51556e43356b6141325262456e634e634a644347454f45344e52704436353462754773492f6f386f57544e587a6c55536e6c47486a586b4c4238667638777a436b7542527a4a69397062723250307932353270534934456d736739642f41647737536d75493739334d342f756f35394933426a6b654c326265436c4846342b6452313763706d567155577559383863594333506c61356a7639685039726b666341787764715a42494255716875654166367045516161455970787047346c7a67502f5964535343707842636a384a7142416b7a4e753431374b4a4d43366c76704d4a314975516472656a37425946776368684e46614261434663414a376d4f2f56453566487a58735473796c634e5377375275412f3658394a4c4a624679624d6661536c63634b37495a58443843686746412f327564664152757744644d364356674d44504e35624b4a685776746b624c766f4364674176435468486f6e344f636a5a55764930734c5a493733735065455a4b3853754a7545724362544b394f4874394838504c75677775565733384266696a346e444f734a47624f383871714634496554657264765538614c466e314f55532f337355777a6f626d46677559707a462b46386a397961504f734f30776d67302f574f6676774f2b71644b4c7073634b70324b316b47394579766c3255384d75692f616e786c6274485a4b654a51532f447151684378736c6e42644350473948367a7036756b666d7459386d7a506e436b3563696c4c6f524f396a37314956766a33707332726a50647636783759797871556a4c7967564369423871526e41324d4b6376615774636b44684b654878484d522b32657147776e614e3158414e4d565168716d7576596a31534130613832544f7465344a77737a6e746c656a41627444786f2b736b2b3178756d6457796d4a35654c48325236666b566f495574494961625930667072736f6b7851467530646b4f387158364f4a30504846767736795770714f4c4131577238346d786744784766572f53552b6f2b34794c7a33386b46665873627137323877615a6c4e44713153645342474d694c516b7076556c66634a54477176657764325054682b2f4e596637587668505044786343574b384533594f74796c61466759645a645572636831374766432b6a376547596f323564434c6b354c5a6f33653956504c63323153365469446b46764d3852493459644766394a76644b5a426d46526379655335586b4a7676414f7a5347586c2b5552314b7854596f6d386a4355535378776c59494a6950646a4a49596465372b4e74444c75653762457a47336f6270696c6a636d3262506b4c723036436a484d66712f6659756a43714b494576454858613049542f4238304b7a36647332795a5355346e7a3774444764716738736a6f354c53734543386c6c534938586f33707738776e4f52637175536c51692b565a302b49304a4e6a4239614c59515150385a2f556d44484736364e487a50454c3133482b62677663523237307259583536714d52327439307051426674765877385551354b31496556752b4437584f484c3965796a374e68692b4a4e39586c76627a46533457583543504951736f44656e4e72697837574a59575970786a554343453552546d6933616e646b504a7352642b66676c797334472b696a2f7569436a54326a5a6c5766386831624e486a62377257416b305a344c646e595550676769776c6a385362366a2f7430384d683855432b6a33536e6a4a2f31355656747a654d2f6b71416354796e45434238506a77486246596356726c477543454c79457451326e794468325869302f6b4d4672324e38334a64586d7157376a693164782b353248567671637138705577373263582b394343336b304a31396239444c50467649387533486d73663266546d5735452f4b7775697a4f2b3756373431614a68575831516e42384d62353763312b2f7162662b32364e5250776e367048386c614c5059543769396f55754f78704e6342696d4e596e305a48724f336e36676769776c62727970646c56666e342f50724e2b59562f4e4768705956474f555636746f746369344c584c7676666c496762316657546b2f2b334d3950353544746c77766c2b4c45385071502b56645771547863526a615a6b596c79462f37454a4c7241793242617977436c387a454e3938345a45766c6c51644550795066576b39626f5437437673614d4d636d663138673279743550306a7363514a76626c6273542b50456f68475254456d4a4d4a42625833316442485361414c6c55667a3159795051456167674338547141455264655677334a4d546177725266624d73725a6d7265626c414d72305a49706b626d4a304c5a34315a314649724c7459526b53586579362f32416a4565336e6763664137455337766535424d4f306167335457674f63724f44396f7034726d366f437949474f414e4b68664f71556c4e34586863565862425542667a6368614546796d554b4e4341494c49663664394632435055545775316d78436b684b354e78486d343849716c416c305177326a6a644d3633484b612b33757036356a4e7866776648566d793377707a37517767447267464b435a394a69787970364456317a4862753335592b48486230725a55554a4236456267467649696d524b62435156636b53624658776e4c353448764b2f67654a5478764776433131535752574f4a597746537342442f70367437394b64316130685441675a6d2f63754c6a41703976726144387a336f715978426a794e7344694a7979494574453256313261446658646e6b7944324f51757834444b615436354343496d3538346134776259424c306b49576d48426773646a6a46646578454e6f6341446863536e5146455544554d535a6c65674468366145334c52397537376845713131674a385865526c76624765464e644b34415653307a4f64487355636b4275696a665633315875466d655931696a677048353676514465647833376a32673035635878726d4d2f3335746a34594a63576e6c4d5561626a6e6264623432516b6c72674a7546347834793445576b2b507251704a7644507750314e3352352f6d38694a45767868352b766641676e37384a4845556a306e56614572416371445a6465783363686476545742304a33653746635878574345347648462b65323079484e34447158796f7a7a7050684a346f5174534c6351797270482f48707275305257723657784b416a7a4a44464a5039784c6859425848513876697351375a5a736351447041393439324f506b47534b544859666846433872567679323962706466714d58303051644143727969784f47776441766e344d2f4a3730424f5072726d4f7637652b57306144474536464649656e4e524f574b48436b76516669654d66453337794a30653547697257396b486e7773475942333676306236643178706537354a34464e726d4e2f566f35643155464e5654637670617234554b676374796b596f37784e57744957623670645536526f312b67764e2b67596948667172584d642b2b314b546f41655177365952624e714f34575538774d4e5645713671304c6e566c6a684c4e5543665833536d3262674e4f683046675250352b375674777a354d766d4c344252484c487a38703758464846384c584468647833596f77564349595670616b445544427431434c674a504e6837574b52463342365876434f6270584e566f744342722b6b6a4b43393857554644766644357335504d6c61476d474b79325044644d616f53314e6f77565a34352b786f5751482f7565684b69426e4c3230384949694e47333572676d73724d4a7633315a616d30594b73386155315775394b654979434e6b664939586130345a47416f72545a782f323443737a6d5137536c616251676139536170436c6a4965726e64475437504f6346474a31336664782f5549465a6647514f7477357467526f74794a7176614773657530585335776d3531524c2b454742302f4737702f6866447443724e486e4c6435503261746b434e466d544e312b67614d76547176717a4c6b7441576a395a74446a4171793869395a6e635963482b6c354b7468576d4f416f334e345761717454364d4657664d316e6a6a39344330434675656e78684c686858346463465136414c2f6256706f4e3035705949566e376341363344634257625830614c6369614c41497237694f66485756433347665072503034794369346a7230566545584236307547616531573571336a5363436b48463557756f3674443933586145485737496f48487743664b476b33454170356c7859704b696f3357673842506a4a4d61304b5a697646782b4a397a664c4f324f6b306c6f72644f6c364c57452f493459422b6c786a486376576a36345558706272754f76635577725475416933793866674e34777a4374753444667549363975722f7a304441744135674a2f4d624836777258735a2f575675664c4b4d4f306a696a54526c6e4364657a75776668526768426b556349775169574f6279426e4d556934526a47674c32575262396c774866746977375361674a454b336938414c6a424d367775676866524557514c594247787a485476516d3059797577567267477258736263617069574142754163306b6372716e51776d7254574b7646393143376c4c545570344342677652626b763745617542502f53776644434c6b7967486738427279462f7a68724a346850436e705469485841484643367666714451684d5761556c454257706e486b764a477765754846654b3556706a5361394c336b50522f2b3741655a6d2f6e5155306c7a4157564d486c434473583137714f2f62725757733241456d5137577639475a4737695970554134733331685a2b326c574b7555694243454a395a5639443732714b3161794e7a452b65584b6f4d463867353148524933336e3562546446504c334d642b3150447450594833737949632f444a4c6a304c5863652b515264707a59416373676845614255703562744b2b6235494c44455455446f4152384b71654650646b6c4c6c6765765932344278686d6e64416c786134585a387465765973335678316c5136657056466b5469394a5446457748546c50426168732f6f6a6e71356a58775a4d4142367177477865445a79677856677a344676496d734c77776f775648736372656e384e7a2b753373552f5873566341307733546d6748384570684765744a7665426c6d37566253457a3558756f3739754c6130584a307574704f2b756157535344474962344852676c77305257614f63734752636d4738715746626630665a6457774a58474759316c576b4a2f7847414e38476a6949393172775836664868634f6266304534396742322f35554d79782f394635743874774672535a314d73427a61376a7232357a4c36325837714e666f685442334277685a616554566c2b55376d5a50567a70737145467551684d62556c4d456a425a73526e5456525757443552542f463348396f44504d6e38666b4f2f5737384748417879546f32585833552f66634f4d4179755076346e2f33593856766c396658767865425345766944304b6f6e69387362374b6a44566671584e4e6f4e4c7146484c5159787849544258784c3058756e534d7072646135704e4272517179794b306558344b656d4e4641714e59323561504f767762703172476f314743334c412f4f54684e634f42437857396230594b5054617230576930494265445a444a354d34724451424a65746d6657726461357074466f6476442f434478784e65526848454941414141415355564f524b35435949493d, '', 'Ahorros', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `presentacion`
--

CREATE TABLE `presentacion` (
  `IdPresentacion` int(12) NOT NULL,
  `Nombre` varchar(512) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `IdProducto` int(12) NOT NULL,
  `IdMarca` int(12) DEFAULT NULL,
  `IdPresentacion` int(12) DEFAULT NULL,
  `IdTipoProducto` int(12) DEFAULT NULL,
  `CodigoProducto` int(12) NOT NULL,
  `IdUnidadMedida` int(12) DEFAULT NULL,
  `NombreProducto` varchar(256) NOT NULL,
  `PrecioVenta` double DEFAULT NULL,
  `PrecioSugerido` double NOT NULL,
  `StockMaximo` int(4) NOT NULL,
  `StockMinimo` int(4) NOT NULL,
  `Existencias` int(4) NOT NULL,
  `Contenido` varchar(512) NOT NULL,
  `Estado_P` tinyint(2) NOT NULL,
  `ImagenProducto` varchar(512) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`IdProducto`, `IdMarca`, `IdPresentacion`, `IdTipoProducto`, `CodigoProducto`, `IdUnidadMedida`, `NombreProducto`, `PrecioVenta`, `PrecioSugerido`, `StockMaximo`, `StockMinimo`, `Existencias`, `Contenido`, `Estado_P`, `ImagenProducto`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, NULL, 1, NULL, 'CERVEZA AGUILA', NULL, 4500, 2000, 5, 1000, '750 ml', 4, NULL, NULL, NULL),
(2, NULL, NULL, NULL, 2, NULL, 'CERVEZA PILSEN', NULL, 4500, 2000, 5, 990, '750 ml', 1, NULL, NULL, '2020-09-11 22:54:41'),
(3, NULL, NULL, 1, 3, NULL, 'CERVEZA CLUB COLOMBIA', 5200, 4500, 2000, 5, 1000, '750 ml', 1, 'Productos/img/1599620545_club_colombia.jpg', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `codproveedor` int(12) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `type_id` int(12) NOT NULL,
  `cifnif` varchar(30) NOT NULL,
  `telefono1` varchar(30) NOT NULL,
  `telefono2` varchar(30) DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `fp` int(12) DEFAULT NULL,
  `divisa` varchar(25) DEFAULT 'COP',
  `riva` int(25) DEFAULT NULL,
  `observaciones` varchar(1024) DEFAULT NULL,
  `personafisica` int(2) NOT NULL,
  `estado` int(25) NOT NULL DEFAULT '1',
  `bancname` varchar(255) DEFAULT NULL,
  `banctype` int(12) DEFAULT NULL,
  `no_cuenta` varchar(255) DEFAULT NULL,
  `country` varchar(255) NOT NULL,
  `deptoprov` varchar(255) NOT NULL,
  `cityprov` varchar(255) NOT NULL,
  `codpprov` varchar(255) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `adjunto_pdf` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`codproveedor`, `nombre`, `type_id`, `cifnif`, `telefono1`, `telefono2`, `email`, `fp`, `divisa`, `riva`, `observaciones`, `personafisica`, `estado`, `bancname`, `banctype`, `no_cuenta`, `country`, `deptoprov`, `cityprov`, `codpprov`, `direccion`, `adjunto_pdf`) VALUES
(42, 'JUAN BAUTISTA', 2, '1054561218', '3206466288', NULL, NULL, NULL, 'COP', NULL, NULL, 1, 1, NULL, NULL, NULL, 'COL', 'ANTIOQUIA', 'MEDELLIN', '4565466', 'CRA 6565', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recibos_proveedor`
--

CREATE TABLE `recibos_proveedor` (
  `id_recibo` int(12) NOT NULL,
  `idfactura` int(12) DEFAULT NULL,
  `linea` int(30) DEFAULT NULL,
  `numero` int(30) NOT NULL,
  `proveedor` varchar(255) NOT NULL,
  `codproveedor` int(12) NOT NULL,
  `importe` double NOT NULL,
  `emitido` date NOT NULL,
  `divisa` varchar(30) NOT NULL DEFAULT 'COP',
  `fp` int(20) DEFAULT NULL,
  `observaciones` varchar(1024) NOT NULL,
  `vencimiento` date DEFAULT NULL,
  `pagado` varchar(30) DEFAULT NULL,
  `notificado` varchar(30) DEFAULT NULL,
  `estado_recibo` int(25) DEFAULT '0',
  `date_added` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `recibos_proveedor`
--

INSERT INTO `recibos_proveedor` (`id_recibo`, `idfactura`, `linea`, `numero`, `proveedor`, `codproveedor`, `importe`, `emitido`, `divisa`, `fp`, `observaciones`, `vencimiento`, `pagado`, `notificado`, `estado_recibo`, `date_added`) VALUES
(5, 10, NULL, 1, 'JUAN BAUTISTA', 42, 149625, '2020-09-11', 'COP', 1, 'Recibo generado para la factura pagada numero 1', '2020-09-11', 'Si', 'Si', 1, '2020-09-11');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resolutions`
--

CREATE TABLE `resolutions` (
  `id` int(24) NOT NULL,
  `number` int(25) DEFAULT NULL,
  `profile_id` int(12) NOT NULL DEFAULT '1',
  `prefix` varchar(256) NOT NULL,
  `resolution` varchar(1024) NOT NULL,
  `resolution_date` date NOT NULL,
  `technical_key` varchar(1024) NOT NULL,
  `from_number` double NOT NULL,
  `to_number` double NOT NULL,
  `date_from` date NOT NULL,
  `date_to` date NOT NULL,
  `type` varchar(50) DEFAULT NULL,
  `status` int(5) NOT NULL DEFAULT '2',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Facturacion';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_producto`
--

CREATE TABLE `tipo_producto` (
  `IdTipoProducto` int(12) NOT NULL,
  `Nombre` varchar(512) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tipo_producto`
--

INSERT INTO `tipo_producto` (`IdTipoProducto`, `Nombre`) VALUES
(1, 'Licor'),
(2, 'Mecato'),
(3, 'Bebidas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `type_liabilities`
--

CREATE TABLE `type_liabilities` (
  `id` int(12) NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(55) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `type_liabilities`
--

INSERT INTO `type_liabilities` (`id`, `name`, `code`, `created_at`, `updated_at`) VALUES
(1, 'Retención en la fuente a título de renta', 'O-07', NULL, NULL),
(2, 'Retención timbre nacional', 'O-08', NULL, NULL),
(3, 'Retención en la fuente en el impuesto sobre las ventas', 'O-09', NULL, NULL),
(4, 'Gran contribuyente', 'O-13', NULL, NULL),
(5, 'Informante de exógena', 'O-14', NULL, NULL),
(6, 'Autorretenedor', 'O-15', NULL, NULL),
(7, 'Obligación de facturar por ingresos de bienes y/o servicios excluidos', 'O-16', NULL, NULL),
(8, 'Profesionales de compra y venta de divisas', 'O-17', NULL, NULL),
(9, 'Productor y/o exportador de bienes exentos', 'O-19', NULL, NULL),
(10, 'Obligado a cumplir deberes formales a nombre de terceros', 'O-22', NULL, NULL),
(11, 'Agente de retención en el impuesto sobre las ventas', 'O-23', NULL, NULL),
(12, 'Impuesto Nacional a la Gasolina y al ACPM', 'O-32', NULL, NULL),
(13, 'Impuesto Nacional al consumo', 'O-33', NULL, NULL),
(14, 'Régimen simplificado impuesto nacional consumo rest y bares', 'O-34', NULL, NULL),
(15, 'Establecimiento Permanente', 'O-36', NULL, NULL),
(16, 'Obligado a Facturar Electrónicamente Modelo 2242', 'O-37', NULL, NULL),
(17, 'Facturación Electrónica Voluntaria Modelo 2242', 'O-38', NULL, NULL),
(18, 'Proveedor de Servicios Tecnológicos PST Modelo 2242', 'O-39', NULL, NULL),
(19, 'Régimen Simple de Tributación – SIMPLE', 'O-47', NULL, NULL),
(20, 'Impuesto sobre las ventas – IVA', 'O-48', NULL, NULL),
(21, 'No responsable de IVA', 'O-49', NULL, NULL),
(22, 'Facturador electrónico', 'O-52', NULL, NULL),
(23, 'Otro tipo de obligado', 'O-99', NULL, NULL),
(24, 'Clientes del Exterior', 'R-00-PN', NULL, NULL),
(25, 'Factor PN', 'R-12-PN', NULL, NULL),
(26, 'Mandatario', 'R-16-PN', NULL, NULL),
(27, 'Agente Interventor', 'R-25-PN', NULL, NULL),
(28, 'No responsable', 'R-99-PN', NULL, NULL),
(29, 'Apoderado especial', 'R-06-PJ', NULL, NULL),
(30, 'Apoderado general', 'R-07-PJ', NULL, NULL),
(31, 'Factor', 'R-12-PJ', NULL, NULL),
(32, 'Mandatario', 'R-16-PJ', NULL, NULL),
(33, 'Otro tipo de responsable', 'R-99-PJ', NULL, NULL),
(34, 'Agente de carga internacional', 'A-01', NULL, NULL),
(35, 'Agente marítimo', 'A-02', NULL, NULL),
(36, 'Almacén general de depósito', 'A-03', NULL, NULL),
(37, 'Comercializadora internacional (C.I.)', 'A-04', NULL, NULL),
(38, 'Comerciante de la zona aduanera especial de Inírida, Puerto Carreño, Cumaribo y Primavera', 'A-05', NULL, NULL),
(39, 'Comerciantes de la zona de régimen aduanero especial de Leticia', 'A-06', NULL, NULL),
(40, 'Comerciantes de la zona de régimen aduanero especial de Maicao, Uribia y Manaure', 'A-07', NULL, NULL),
(41, 'Comerciantes de la zona de régimen aduanero especial de Urabá, Tumaco y Guapí', 'A-08', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `unidad_medida`
--

CREATE TABLE `unidad_medida` (
  `IdUnidadMedida` int(12) NOT NULL,
  `NombreUnidad` varchar(512) NOT NULL,
  `Conversion` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL COMMENT 'auto incrementing user_id of each user, unique index',
  `telegram_id` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `telegram_verification` tinyint(1) DEFAULT '0',
  `user_type` int(11) NOT NULL,
  `firstname` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `user_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT 'user''s name, unique',
  `user_password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'user''s password in salted and hashed format',
  `user_email` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT 'user''s email, unique',
  `email_verification` tinyint(1) DEFAULT '0',
  `vigencia` date DEFAULT NULL,
  `estado_usuario` tinyint(4) NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='user data';

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`user_id`, `telegram_id`, `telegram_verification`, `user_type`, `firstname`, `lastname`, `user_name`, `user_password_hash`, `user_email`, `email_verification`, `vigencia`, `estado_usuario`, `date_added`) VALUES
(1, NULL, NULL, 1, 'Juan David', 'Bautista', 'admin', '$2y$10$eg4yWgPEGWpqecKYUBZnGOvXx.3e6PUtl3SFzLLG/jFm9MvhK.W.W', 'contacto@plenusservices.com', NULL, '9999-12-31', 1, '2016-05-21 15:06:00'),
(5, NULL, 0, 1, 'Sebastian', 'Londoño Giraldo', 'directoroperativo', '$2y$10$k/JdStKPCTd5ZDRbSINsyuo6rrft/5/DMQiqkg.onHcfHZ489tIS.', 'directoroperativo@transportesonix.com', 0, '9999-12-31', 1, '2019-11-09 01:53:51'),
(6, NULL, NULL, 1, 'Yeraldin', 'Guerrero Posada', 'asistentegerencia', '$2y$10$7FReabQF1risOIaWbi61bOydUADyspcGf/Mf3AklhLnBO6.zkN9w.', 'asistentegerencia@transportesonix.com', NULL, '9999-12-31', 1, '2019-11-09 01:54:51'),
(7, NULL, 0, 3, 'TRANSPORTE Y TURISMO', ' 1A ', 'TRANSPORTEYTURISMO', '$2y$10$iiEkEQgAe0zBL89bz98cGujOURtkAwuK7/ms2REKN12mZH1G1xX.O', 'auxiliar2@transporteyturismo1a.com', 0, '9999-12-31', 1, '2020-01-24 18:55:21'),
(8, NULL, NULL, 1, 'leidy', 'posada cañas', 'asistenteadministrativa', '$2y$10$yWQweNzDmSgFhG2sZGG4R.cZpTZo.0oun/tQkCm6dtcbhix2iGWpe', 'asistenteadministrativa@transportesonix.com', NULL, '9999-12-31', 1, '2020-01-31 10:39:53'),
(9, NULL, 0, 1, 'Sebastian', 'Londoño', 'coordinadorlogistico', '$2y$10$a8nQ.UaN2f1he/jWnzi6pOV4ngaAWS4Mv8NT1t1dgvDb9pUxlVKHe', 'coordinadorlogistico@transportesonix.com', 0, '9999-12-31', 1, '2020-05-05 15:29:00'),
(10, NULL, 0, 1, 'Gina', 'Giraldo', 'directoracomercial', '$2y$10$cjjypHOnQfsQnz0op09IQuth39GNRiCmcvw9/rhQfMbM5gu3gViE.', 'directoracomercial@transportesonix.com', 0, '9999-12-31', 1, '2020-05-12 12:14:52'),
(11, NULL, NULL, 2, 'Viviana ', 'Arboleda Lopez', 'directoraoperativa', '$2y$10$IcKzhNIQPYaO8Z6H.peaN.hPfaQ0QdOgd2nOpsaIFHJb8B6RlT1YW', 'directoraperativa@transportesonix.com', NULL, '9999-12-31', 1, '2020-05-13 15:36:57'),
(12, NULL, 0, 1, 'Natalia', 'Gasca Rivera', 'Contabilidad', '$2y$10$TF.zEngILnTzEnu39GbQf.jo6swndqBbhPSyROSJld4xzeG8U5wBG', 'contabilidad@transportesonix.com', 0, '9999-12-31', 1, '2020-05-30 18:31:32'),
(13, NULL, NULL, 1, 'Elizabeth', 'algarin', 'COMERCIAL', '$2y$10$/CJH8M5b37tw59dGsio5EuiCjhcwlJD6X8N2u6hExYfZCCe27ejb.', 'comercial@transportesonix.com', NULL, '9999-12-31', 1, '2020-07-16 10:33:36');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id_cliente`),
  ADD UNIQUE KEY `cifnif` (`cifnif`);

--
-- Indices de la tabla `divisas`
--
ALTER TABLE `divisas`
  ADD PRIMARY KEY (`coddivisa`);

--
-- Indices de la tabla `facturacion_electronica`
--
ALTER TABLE `facturacion_electronica`
  ADD PRIMARY KEY (`id_config`);

--
-- Indices de la tabla `facturascli`
--
ALTER TABLE `facturascli`
  ADD PRIMARY KEY (`idfactura`),
  ADD KEY `resolution` (`resolution_id`);

--
-- Indices de la tabla `facturasnotes`
--
ALTER TABLE `facturasnotes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `factura` (`idfactura`);

--
-- Indices de la tabla `facturasprov`
--
ALTER TABLE `facturasprov`
  ADD PRIMARY KEY (`idfactura`);

--
-- Indices de la tabla `ingresos_clientes`
--
ALTER TABLE `ingresos_clientes`
  ADD PRIMARY KEY (`id_ingreso`),
  ADD KEY `idfactura` (`idfactura`);

--
-- Indices de la tabla `lineasfacturascli`
--
ALTER TABLE `lineasfacturascli`
  ADD PRIMARY KEY (`idlinea`),
  ADD KEY `invoice` (`idfactura`);

--
-- Indices de la tabla `lineasfacturasnotes`
--
ALTER TABLE `lineasfacturasnotes`
  ADD PRIMARY KEY (`idlinea`),
  ADD KEY `notes` (`note_id`);

--
-- Indices de la tabla `lineasfacturasprov`
--
ALTER TABLE `lineasfacturasprov`
  ADD PRIMARY KEY (`id_linea`);

--
-- Indices de la tabla `marca`
--
ALTER TABLE `marca`
  ADD PRIMARY KEY (`IdMarca`);

--
-- Indices de la tabla `modulos_asignados`
--
ALTER TABLE `modulos_asignados`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `paises`
--
ALTER TABLE `paises`
  ADD PRIMARY KEY (`codpais`),
  ADD UNIQUE KEY `uniq_codiso_paises` (`codiso`);

--
-- Indices de la tabla `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `perfil`
--
ALTER TABLE `perfil`
  ADD PRIMARY KEY (`id_perfil`);

--
-- Indices de la tabla `presentacion`
--
ALTER TABLE `presentacion`
  ADD PRIMARY KEY (`IdPresentacion`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`IdProducto`),
  ADD KEY `IdMarca` (`IdMarca`),
  ADD KEY `IdPresentacion` (`IdPresentacion`),
  ADD KEY `IdTipoProducto` (`IdTipoProducto`),
  ADD KEY `IdUnidadMedida` (`IdUnidadMedida`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`codproveedor`),
  ADD UNIQUE KEY `cifnif` (`cifnif`);

--
-- Indices de la tabla `recibos_proveedor`
--
ALTER TABLE `recibos_proveedor`
  ADD PRIMARY KEY (`id_recibo`);

--
-- Indices de la tabla `resolutions`
--
ALTER TABLE `resolutions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `profile` (`profile_id`);

--
-- Indices de la tabla `tipo_producto`
--
ALTER TABLE `tipo_producto`
  ADD PRIMARY KEY (`IdTipoProducto`);

--
-- Indices de la tabla `type_liabilities`
--
ALTER TABLE `type_liabilities`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `unidad_medida`
--
ALTER TABLE `unidad_medida`
  ADD PRIMARY KEY (`IdUnidadMedida`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_name` (`user_name`),
  ADD UNIQUE KEY `user_email` (`user_email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id_cliente` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT de la tabla `facturacion_electronica`
--
ALTER TABLE `facturacion_electronica`
  MODIFY `id_config` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `facturascli`
--
ALTER TABLE `facturascli`
  MODIFY `idfactura` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT de la tabla `facturasnotes`
--
ALTER TABLE `facturasnotes`
  MODIFY `id` int(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `facturasprov`
--
ALTER TABLE `facturasprov`
  MODIFY `idfactura` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT de la tabla `ingresos_clientes`
--
ALTER TABLE `ingresos_clientes`
  MODIFY `id_ingreso` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT de la tabla `lineasfacturascli`
--
ALTER TABLE `lineasfacturascli`
  MODIFY `idlinea` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT de la tabla `lineasfacturasnotes`
--
ALTER TABLE `lineasfacturasnotes`
  MODIFY `idlinea` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `lineasfacturasprov`
--
ALTER TABLE `lineasfacturasprov`
  MODIFY `id_linea` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT de la tabla `marca`
--
ALTER TABLE `marca`
  MODIFY `IdMarca` int(12) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `modulos_asignados`
--
ALTER TABLE `modulos_asignados`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT de la tabla `payment_methods`
--
ALTER TABLE `payment_methods`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=155;
--
-- AUTO_INCREMENT de la tabla `perfil`
--
ALTER TABLE `perfil`
  MODIFY `id_perfil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `presentacion`
--
ALTER TABLE `presentacion`
  MODIFY `IdPresentacion` int(12) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `IdProducto` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `codproveedor` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;
--
-- AUTO_INCREMENT de la tabla `recibos_proveedor`
--
ALTER TABLE `recibos_proveedor`
  MODIFY `id_recibo` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `resolutions`
--
ALTER TABLE `resolutions`
  MODIFY `id` int(24) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `tipo_producto`
--
ALTER TABLE `tipo_producto`
  MODIFY `IdTipoProducto` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `type_liabilities`
--
ALTER TABLE `type_liabilities`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;
--
-- AUTO_INCREMENT de la tabla `unidad_medida`
--
ALTER TABLE `unidad_medida`
  MODIFY `IdUnidadMedida` int(12) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'auto incrementing user_id of each user, unique index', AUTO_INCREMENT=14;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `lineasfacturascli`
--
ALTER TABLE `lineasfacturascli`
  ADD CONSTRAINT `invoice` FOREIGN KEY (`idfactura`) REFERENCES `facturascli` (`idfactura`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `IdMarca` FOREIGN KEY (`IdMarca`) REFERENCES `marca` (`IdMarca`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `IdPresentacion` FOREIGN KEY (`IdPresentacion`) REFERENCES `presentacion` (`IdPresentacion`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `IdTipoProducto` FOREIGN KEY (`IdTipoProducto`) REFERENCES `tipo_producto` (`IdTipoProducto`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `IdUnidadMedida` FOREIGN KEY (`IdUnidadMedida`) REFERENCES `unidad_medida` (`IdUnidadMedida`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
