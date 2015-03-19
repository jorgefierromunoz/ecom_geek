-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 14-11-2014 a las 01:08:15
-- Versión del servidor: 5.5.24-log
-- Versión de PHP: 5.4.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `geek4y`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bancos`
--

CREATE TABLE IF NOT EXISTS `bancos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `banco` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `bancos`
--

INSERT INTO `bancos` (`id`, `banco`) VALUES
(1, 'Banco de Chile'),
(2, 'Banco Estado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE IF NOT EXISTS `categorias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categoria` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `categoria`) VALUES
(1, 'CAT1'),
(2, 'CAT2'),
(3, 'CAT3');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria_vendedores`
--

CREATE TABLE IF NOT EXISTS `categoria_vendedores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categoriaVendedor` varchar(45) DEFAULT NULL,
  `porcentaje` decimal(6,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `categoria_vendedores`
--

INSERT INTO `categoria_vendedores` (`id`, `categoriaVendedor`, `porcentaje`) VALUES
(1, 'Elite', '0.10'),
(2, 'nuevas', '0.23'),
(3, 'asdf', '0.03');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comunas`
--

CREATE TABLE IF NOT EXISTS `comunas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `comuna` varchar(45) DEFAULT NULL,
  `regione_id` int(11) NOT NULL,
  `zona_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_comunas_regiones1_idx` (`regione_id`),
  KEY `fk_comunas_zonas1_idx` (`zona_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `comunas`
--

INSERT INTO `comunas` (`id`, `comuna`, `regione_id`, `zona_id`) VALUES
(1, 'Recoleta', 1, 1),
(2, 'Quilicuraa', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_compras`
--

CREATE TABLE IF NOT EXISTS `detalle_compras` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ordenes_compra_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `precio` int(11) DEFAULT NULL,
  `subtotal` int(11) DEFAULT NULL,
  `subtotalpunto` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_detalle_compras_ordenes_compras1_idx` (`ordenes_compra_id`),
  KEY `fk_detalle_compras_productos1_idx` (`producto_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `direcciones`
--

CREATE TABLE IF NOT EXISTS `direcciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `calle` varchar(200) DEFAULT NULL,
  `numero` int(11) DEFAULT NULL,
  `dpto` varchar(10) DEFAULT NULL,
  `restoDireccion` text,
  `codigoPostal` varchar(7) DEFAULT NULL,
  `georeferencia` varchar(45) DEFAULT NULL,
  `estado` tinyint(1) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `comuna_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_direcciones_users1_idx` (`user_id`),
  KEY `fk_direcciones_comunas1_idx` (`comuna_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `direcciones`
--

INSERT INTO `direcciones` (`id`, `calle`, `numero`, `dpto`, `restoDireccion`, `codigoPostal`, `georeferencia`, `estado`, `user_id`, `comuna_id`) VALUES
(1, 'antonia prado ', 432, 'dpto', 'restodir', 'cpostal', 'georef', 1, 1, 1),
(4, 'ola', 998, 'p', '', '', '', 1, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fotos`
--

CREATE TABLE IF NOT EXISTS `fotos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(250) DEFAULT NULL,
  `mime` varchar(12) DEFAULT NULL,
  `descripcion` varchar(200) DEFAULT NULL,
  `producto_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_fotos_productos1_idx` (`producto_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=47 ;

--
-- Volcado de datos para la tabla `fotos`
--

INSERT INTO `fotos` (`id`, `url`, `mime`, `descripcion`, `producto_id`) VALUES
(23, '23_NOTE1.jpg', 'image/jpeg', 'Peso: 790009/kB', 13),
(24, '24_IMAGENES DE PRUEBA.png', 'image/png', 'Peso: 11959/kB', 16),
(29, '29_font.jpg', 'image/jpeg', 'Peso: 418226/kB', 15),
(43, '43_9_NOTE.jpg', 'image/jpeg', 'Peso: 402240/kB', 14),
(44, '44_fig2_full.jpg', 'image/jpeg', 'Peso: 1571446/kB', 11),
(45, '45_back.jpg', 'image/jpeg', 'Peso: 354741/kB', 17),
(46, '46_BD1231.png', 'image/png', 'Peso: 181363/kB', 15);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modelos`
--

CREATE TABLE IF NOT EXISTS `modelos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `modelo` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `modelos`
--

INSERT INTO `modelos` (`id`, `modelo`) VALUES
(1, 'modelo'),
(3, 'asdf');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ordenes_compras`
--

CREATE TABLE IF NOT EXISTS `ordenes_compras` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL,
  `user_id` int(11) NOT NULL,
  `total` int(11) DEFAULT NULL,
  `totalPunto` int(11) DEFAULT NULL,
  `totalFlete` int(11) DEFAULT NULL,
  `tipoPunto` tinyint(1) DEFAULT NULL,
  `estadoPago` enum('C','P') DEFAULT NULL,
  `estado` enum('B','D','E','V') DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_ordenes_compras_users1_idx` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paises`
--

CREATE TABLE IF NOT EXISTS `paises` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `abreviatura` varchar(2) CHARACTER SET latin1 DEFAULT NULL,
  `pais` varchar(250) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=241 ;

--
-- Volcado de datos para la tabla `paises`
--

INSERT INTO `paises` (`id`, `abreviatura`, `pais`) VALUES
(2, 'AX', 'Islas Gland'),
(3, 'AL', 'Albania'),
(4, 'DE', 'Alemania'),
(5, 'AD', 'Andorra'),
(6, 'AO', 'Angola'),
(7, 'AI', 'Anguilla'),
(8, 'AQ', 'Antártida'),
(9, 'AG', 'Antigua y Barbuda'),
(10, 'AN', 'Antillas Holandesas'),
(11, 'SA', 'Arabia Saudí'),
(12, 'DZ', 'Argelia'),
(13, 'AR', 'Argentina'),
(14, 'AM', 'Armenia'),
(15, 'AW', 'Aruba'),
(16, 'AU', 'Australia'),
(17, 'AT', 'Austria'),
(18, 'AZ', 'Azerbaiyán'),
(19, 'BS', 'Bahamas'),
(20, 'BH', 'Bahréin'),
(21, 'BD', 'Bangladesh'),
(22, 'BB', 'Barbados'),
(23, 'BY', 'Bielorrusia'),
(24, 'BE', 'Bélgica'),
(25, 'BZ', 'Belice'),
(26, 'BJ', 'Benin'),
(27, 'BM', 'Bermudas'),
(28, 'BT', 'Bhután'),
(29, 'BO', 'Bolivia'),
(30, 'BA', 'Bosnia y Herzegovina'),
(31, 'BW', 'Botsuana'),
(32, 'BV', 'Isla Bouvet'),
(33, 'BR', 'Brasil'),
(34, 'BN', 'Brunéi'),
(35, 'BG', 'Bulgaria'),
(36, 'BF', 'Burkina Faso'),
(37, 'BI', 'Burundi'),
(38, 'CV', 'Cabo Verde'),
(39, 'KY', 'Islas Caimán'),
(40, 'KH', 'Camboya'),
(41, 'CM', 'Camerún'),
(42, 'CA', 'Canadá'),
(43, 'CF', 'República Centroafricana'),
(44, 'TD', 'Chad'),
(45, 'CZ', 'República Checa'),
(46, 'CL', 'Chile'),
(47, 'CN', 'China'),
(48, 'CY', 'Chipre'),
(49, 'CX', 'Isla de Navidad'),
(50, 'VA', 'Ciudad del Vaticano'),
(51, 'CC', 'Islas Cocos'),
(52, 'CO', 'Colombia'),
(53, 'KM', 'Comoras'),
(54, 'CD', 'República Democrática del Congo'),
(55, 'CG', 'Congo'),
(56, 'CK', 'Islas Cook'),
(57, 'KP', 'Corea del Norte'),
(58, 'KR', 'Corea del Sur'),
(59, 'CI', 'Costa de Marfil'),
(60, 'CR', 'Costa Rica'),
(61, 'HR', 'Croacia'),
(62, 'CU', 'Cuba'),
(63, 'DK', 'Dinamarca'),
(64, 'DM', 'Dominica'),
(65, 'DO', 'República Dominicana'),
(66, 'EC', 'Ecuador'),
(67, 'EG', 'Egipto'),
(68, 'SV', 'El Salvador'),
(69, 'AE', 'Emiratos Árabes Unidos'),
(70, 'ER', 'Eritrea'),
(71, 'SK', 'Eslovaquia'),
(72, 'SI', 'Eslovenia'),
(73, 'ES', 'España'),
(74, 'UM', 'Islas ultramarinas de Estados Unidos'),
(75, 'US', 'Estados Unidos'),
(76, 'EE', 'Estonia'),
(77, 'ET', 'Etiopía'),
(78, 'FO', 'Islas Feroe'),
(79, 'PH', 'Filipinas'),
(80, 'FI', 'Finlandia'),
(81, 'FJ', 'Fiyi'),
(82, 'FR', 'Francia'),
(83, 'GA', 'Gabón'),
(84, 'GM', 'Gambia'),
(85, 'GE', 'Georgia'),
(86, 'GS', 'Islas Georgias del Sur y Sandwich del Sur'),
(87, 'GH', 'Ghana'),
(88, 'GI', 'Gibraltar'),
(89, 'GD', 'Granada'),
(90, 'GR', 'Grecia'),
(91, 'GL', 'Groenlandia'),
(92, 'GP', 'Guadalupe'),
(93, 'GU', 'Guam'),
(94, 'GT', 'Guatemala'),
(95, 'GF', 'Guayana Francesa'),
(96, 'GN', 'Guinea'),
(97, 'GQ', 'Guinea Ecuatorial'),
(98, 'GW', 'Guinea-Bissau'),
(99, 'GY', 'Guyana'),
(100, 'HT', 'Haití'),
(101, 'HM', 'Islas Heard y McDonald'),
(102, 'HN', 'Honduras'),
(103, 'HK', 'Hong Kong'),
(104, 'HU', 'Hungría'),
(105, 'IN', 'India'),
(106, 'ID', 'Indonesia'),
(107, 'IR', 'Irán'),
(108, 'IQ', 'Iraq'),
(109, 'IE', 'Irlanda'),
(110, 'IS', 'Islandia'),
(111, 'IL', 'Israel'),
(112, 'IT', 'Italia'),
(113, 'JM', 'Jamaica'),
(114, 'JP', 'Japón'),
(115, 'JO', 'Jordania'),
(116, 'KZ', 'Kazajstán'),
(117, 'KE', 'Kenia'),
(118, 'KG', 'Kirguistán'),
(119, 'KI', 'Kiribati'),
(120, 'KW', 'Kuwait'),
(121, 'LA', 'Laos'),
(122, 'LS', 'Lesotho'),
(123, 'LV', 'Letonia'),
(124, 'LB', 'Líbano'),
(125, 'LR', 'Liberia'),
(126, 'LY', 'Libia'),
(127, 'LI', 'Liechtenstein'),
(128, 'LT', 'Lituania'),
(129, 'LU', 'Luxemburgo'),
(130, 'MO', 'Macao'),
(131, 'MK', 'ARY Macedonia'),
(132, 'MG', 'Madagascar'),
(133, 'MY', 'Malasia'),
(134, 'MW', 'Malawi'),
(135, 'MV', 'Maldivas'),
(136, 'ML', 'Malí'),
(137, 'MT', 'Malta'),
(138, 'FK', 'Islas Malvinas'),
(139, 'MP', 'Islas Marianas del Norte'),
(140, 'MA', 'Marruecos'),
(141, 'MH', 'Islas Marshall'),
(142, 'MQ', 'Martinica'),
(143, 'MU', 'Mauricio'),
(144, 'MR', 'Mauritania'),
(145, 'YT', 'Mayotte'),
(146, 'MX', 'México'),
(147, 'FM', 'Micronesia'),
(148, 'MD', 'Moldavia'),
(149, 'MC', 'Mónaco'),
(150, 'MN', 'Mongolia'),
(151, 'MS', 'Montserrat'),
(152, 'MZ', 'Mozambique'),
(153, 'MM', 'Myanmar'),
(154, 'NA', 'Namibia'),
(155, 'NR', 'Nauru'),
(156, 'NP', 'Nepal'),
(157, 'NI', 'Nicaragua'),
(158, 'NE', 'Níger'),
(159, 'NG', 'Nigeria'),
(160, 'NU', 'Niue'),
(161, 'NF', 'Isla Norfolk'),
(162, 'NO', 'Noruega'),
(163, 'NC', 'Nueva Caledonia'),
(164, 'NZ', 'Nueva Zelanda'),
(165, 'OM', 'Omán'),
(166, 'NL', 'Países Bajos'),
(167, 'PK', 'Pakistán'),
(168, 'PW', 'Palau'),
(169, 'PS', 'Palestina'),
(170, 'PA', 'Panamá'),
(171, 'PG', 'Papúa Nueva Guinea'),
(172, 'PY', 'Paraguay'),
(173, 'PE', 'Perú'),
(174, 'PN', 'Islas Pitcairn'),
(175, 'PF', 'Polinesia Francesa'),
(176, 'PL', 'Polonia'),
(177, 'PT', 'Portugal'),
(178, 'PR', 'Puerto Rico'),
(179, 'QA', 'Qatar'),
(180, 'GB', 'Reino Unido'),
(181, 'RE', 'Reunión'),
(182, 'RW', 'Ruanda'),
(183, 'RO', 'Rumania'),
(184, 'RU', 'Rusia'),
(185, 'EH', 'Sahara Occidental'),
(186, 'SB', 'Islas Salomón'),
(187, 'WS', 'Samoa'),
(188, 'AS', 'Samoa Americana'),
(189, 'KN', 'San Cristóbal y Nevis'),
(190, 'SM', 'San Marino'),
(191, 'PM', 'San Pedro y Miquelón'),
(192, 'VC', 'San Vicente y las Granadinas'),
(193, 'SH', 'Santa Helena'),
(194, 'LC', 'Santa Lucía'),
(195, 'ST', 'Santo Tomé y Príncipe'),
(196, 'SN', 'Senegal'),
(197, 'CS', 'Serbia y Montenegro'),
(198, 'SC', 'Seychelles'),
(199, 'SL', 'Sierra Leona'),
(200, 'SG', 'Singapur'),
(201, 'SY', 'Siria'),
(202, 'SO', 'Somalia'),
(203, 'LK', 'Sri Lanka'),
(204, 'SZ', 'Suazilandia'),
(205, 'ZA', 'Sudáfrica'),
(206, 'SD', 'Sudán'),
(207, 'SE', 'Suecia'),
(208, 'CH', 'Suiza'),
(209, 'SR', 'Surinam'),
(210, 'SJ', 'Svalbard y Jan Mayen'),
(211, 'TH', 'Tailandia'),
(212, 'TW', 'Taiwán'),
(213, 'TZ', 'Tanzania'),
(214, 'TJ', 'Tayikistán'),
(215, 'IO', 'Territorio Británico del Océano Índico'),
(216, 'TF', 'Territorios Australes Franceses'),
(217, 'TL', 'Timor Oriental'),
(218, 'TG', 'Togo'),
(219, 'TK', 'Tokelau'),
(220, 'TO', 'Tonga'),
(221, 'TT', 'Trinidad y Tobago'),
(222, 'TN', 'Túnez'),
(223, 'TC', 'Islas Turcas y Caicos'),
(224, 'TM', 'Turkmenistán'),
(225, 'TR', 'Turquía'),
(226, 'TV', 'Tuvalu'),
(227, 'UA', 'Ucrania'),
(228, 'UG', 'Uganda'),
(229, 'UY', 'Uruguay'),
(230, 'UZ', 'Uzbekistán'),
(231, 'VU', 'Vanuatu'),
(232, 'VE', 'Venezuela'),
(233, 'VN', 'Vietnam'),
(234, 'VG', 'Islas Vírgenes Británicas'),
(235, 'VI', 'Islas Vírgenes de los Estados Unidos'),
(236, 'WF', 'Wallis y Futuna'),
(237, 'YE', 'Yemen'),
(238, 'DJ', 'Yibuti'),
(239, 'ZM', 'Zambia'),
(240, 'ZW', 'Zimbabue');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE IF NOT EXISTS `productos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `producto` varchar(200) DEFAULT NULL,
  `descripcion` text,
  `stock` int(11) DEFAULT NULL,
  `precio` int(11) DEFAULT NULL,
  `precioPunto` int(11) DEFAULT NULL,
  `prioridadPunto` tinyint(1) DEFAULT NULL,
  `prioridadPrecio` tinyint(1) DEFAULT NULL,
  `sub_categoria_id` int(11) NOT NULL,
  `modelo_id` int(11) NOT NULL,
  `tamano_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_productos_sub_categorias1_idx` (`sub_categoria_id`),
  KEY `fk_productos_modelos1_idx` (`modelo_id`),
  KEY `fk_productos_tamanos1_idx` (`tamano_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `producto`, `descripcion`, `stock`, `precio`, `precioPunto`, `prioridadPunto`, `prioridadPrecio`, `sub_categoria_id`, `modelo_id`, `tamano_id`) VALUES
(11, 'Control para Pc Marca Geek4Y', 'gg', 3, 3, 3, 1, 0, 10, 1, 1),
(13, 'pppppp', 'p', 2, 111111, 2, 0, 1, 11, 1, 1),
(14, 'uno', 'inoasdo', 12, 12, 223, 0, 0, 10, 1, 1),
(15, 'asdf', 'asdf', 23, 23, 23, 0, 0, 8, 1, 1),
(16, 'tres', 'ters', 23, 32, 32, 0, 0, 11, 1, 1),
(17, 'diesisie teaasd adsaasddas', 'asdasdsfsdkasl', 242, 242, 2424, 0, 0, 10, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `regiones`
--

CREATE TABLE IF NOT EXISTS `regiones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `region` varchar(45) DEFAULT NULL,
  `paise_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_regiones_paises1_idx` (`paise_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `regiones`
--

INSERT INTO `regiones` (`id`, `region`, `paise_id`) VALUES
(1, 'Metropolitana', 46);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sub_categorias`
--

CREATE TABLE IF NOT EXISTS `sub_categorias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subCategoria` varchar(45) DEFAULT NULL,
  `categoria_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_sub_categorias_categorias1_idx` (`categoria_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Volcado de datos para la tabla `sub_categorias`
--

INSERT INTO `sub_categorias` (`id`, `subCategoria`, `categoria_id`) VALUES
(7, 'SUB2-2', 2),
(8, 'SUB1-1', 1),
(9, 'SUB1-2', 1),
(10, 'SUB2-1', 2),
(11, 'SubCategoriap', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tamanos`
--

CREATE TABLE IF NOT EXISTS `tamanos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tamano` varchar(45) DEFAULT NULL,
  `factor` decimal(6,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `tamanos`
--

INSERT INTO `tamanos` (`id`, `tamano`, `factor`) VALUES
(1, 'tam', '0.10'),
(2, 'tam2', '0.20'),
(3, 'tam5', '0.10');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_cuentas_bancarias`
--

CREATE TABLE IF NOT EXISTS `tipo_cuentas_bancarias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipoCuentaBancaria` varchar(45) DEFAULT NULL,
  `banco_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_tipo_cuentas_bancos1_idx` (`banco_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Volcado de datos para la tabla `tipo_cuentas_bancarias`
--

INSERT INTO `tipo_cuentas_bancarias` (`id`, `tipoCuentaBancaria`, `banco_id`) VALUES
(1, 'Rut', 2),
(2, 'Rut2', 2),
(3, 'chile1', 1),
(4, 'chile2', 1),
(5, 'Rut3', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rut` varchar(9) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `username` varchar(45) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL,
  `tipo` varchar(45) DEFAULT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `apellidoPaterno` varchar(45) DEFAULT NULL,
  `apellidoMaterno` varchar(45) DEFAULT NULL,
  `numeroCuenta` varchar(45) DEFAULT NULL,
  `sexo` enum('M','F') DEFAULT NULL,
  `puntoAcumulado` int(11) DEFAULT NULL,
  `referido` tinyint(1) DEFAULT NULL,
  `estado` varchar(45) NOT NULL,
  `codigo` varchar(500) DEFAULT NULL,
  `codigo2` varchar(500) DEFAULT NULL,
  `tipo_cuentas_bancaria_id` int(11) DEFAULT NULL,
  `categoria_vendedore_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_users_tipo_cuentas1_idx` (`tipo_cuentas_bancaria_id`),
  KEY `fk_users_categoria_vendedores1_idx` (`categoria_vendedore_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=46 ;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `rut`, `email`, `username`, `password`, `tipo`, `nombre`, `apellidoPaterno`, `apellidoMaterno`, `numeroCuenta`, `sexo`, `puntoAcumulado`, `referido`, `estado`, `codigo`, `codigo2`, `tipo_cuentas_bancaria_id`, `categoria_vendedore_id`) VALUES
(1, '179414074', 'falso@gmail.com', 'jorges', 'master', 'admin', 'jorge', 'fierro', 'muñoz', '88888', 'M', 100, 1, 'deshabilitado', 'dedea0f19f05659f939fc3e38a1b778907ea32f2', 'dedea0f19f05659f939fc3e38a1b778907ea32f2', 1, 1),
(40, 'Sin Rut', 'jorgefierromunomz@gmail.com', 'master', '20f70df628eee00ddd8ca9bcb23f6222b7e7f04c', 'admin', 'jorge', 'fierro', 'muñoz', '179414074', 'M', 0, 0, 'habilitado', 'c594afa8a6d3379808a81aaed2e0c63b651a04c0', 'c594afa8a6d3379808a81aaed2e0c63b651a04c0', 1, 3),
(44, 'Sin Rut', 'master_x01@hotmail.com', 'new', 'a4149375ef88af9de97ef00566e0630834459c48', 'cliente', 'new', 'new', 'new', '', 'M', 0, 0, 'habilitado', '6869c6cf51488e4020ad5c87b3f0f6def11ea955', '6869c6cf51488e4020ad5c87b3f0f6def11ea955', 3, 3),
(45, 'Sin Rut', 'jorgefierromunoz@gmail.com', NULL, '20f70df628eee00ddd8ca9bcb23f6222b7e7f04c', 'admin', 'master', 'master', 'master', NULL, 'M', 0, 0, 'habilitado', 'codhabxmailgeek4y', 'aab69143a2eda7b04665fec8df1be4610d27cd71', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `zonas`
--

CREATE TABLE IF NOT EXISTS `zonas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `zona` varchar(45) DEFAULT NULL,
  `precio` int(11) DEFAULT NULL,
  `precioPunto` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `zonas`
--

INSERT INTO `zonas` (`id`, `zona`, `precio`, `precioPunto`) VALUES
(1, 'norte', 100, 10);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `comunas`
--
ALTER TABLE `comunas`
  ADD CONSTRAINT `fk_comunas_regiones1` FOREIGN KEY (`regione_id`) REFERENCES `regiones` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_comunas_zonas1` FOREIGN KEY (`zona_id`) REFERENCES `zonas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `detalle_compras`
--
ALTER TABLE `detalle_compras`
  ADD CONSTRAINT `fk_detalle_compras_ordenes_compras1` FOREIGN KEY (`ordenes_compra_id`) REFERENCES `ordenes_compras` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_detalle_compras_productos1` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `direcciones`
--
ALTER TABLE `direcciones`
  ADD CONSTRAINT `fk_direcciones_comunas1` FOREIGN KEY (`comuna_id`) REFERENCES `comunas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_direcciones_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `fotos`
--
ALTER TABLE `fotos`
  ADD CONSTRAINT `fk_fotos_productos1` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `ordenes_compras`
--
ALTER TABLE `ordenes_compras`
  ADD CONSTRAINT `fk_ordenes_compras_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `fk_productos_modelos1` FOREIGN KEY (`modelo_id`) REFERENCES `modelos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_productos_sub_categorias1` FOREIGN KEY (`sub_categoria_id`) REFERENCES `sub_categorias` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_productos_tamanos1` FOREIGN KEY (`tamano_id`) REFERENCES `tamanos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `regiones`
--
ALTER TABLE `regiones`
  ADD CONSTRAINT `fk_regiones_paises1` FOREIGN KEY (`paise_id`) REFERENCES `paises` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `sub_categorias`
--
ALTER TABLE `sub_categorias`
  ADD CONSTRAINT `fk_sub_categorias_categorias1` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `tipo_cuentas_bancarias`
--
ALTER TABLE `tipo_cuentas_bancarias`
  ADD CONSTRAINT `fk_tipo_cuentas_bancos1` FOREIGN KEY (`banco_id`) REFERENCES `bancos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_categoria_vendedores1` FOREIGN KEY (`categoria_vendedore_id`) REFERENCES `categoria_vendedores` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_users_tipo_cuentas1` FOREIGN KEY (`tipo_cuentas_bancaria_id`) REFERENCES `tipo_cuentas_bancarias` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
