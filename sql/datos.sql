-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-10-2022 a las 02:03:23
-- Versión del servidor: 10.4.25-MariaDB
-- Versión de PHP: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `licenciado`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documentos`
--

CREATE TABLE `documentos` (
  `id` int(11) NOT NULL,
  `id_tipo_documento` int(11) NOT NULL,
  `id_persona_vendedor` int(11) DEFAULT NULL,
  `id_persona_comprador` int(11) DEFAULT NULL,
  `id_persona_declarador` int(11) DEFAULT NULL,
  `id_persona_donatario` int(11) DEFAULT NULL,
  `id_persona_donador` int(11) DEFAULT NULL,
  `id_persona_cedente` int(11) DEFAULT NULL,
  `id_persona_cesionario` int(11) DEFAULT NULL,
  `fecha` date NOT NULL,
  `fecha_escaneado` date DEFAULT current_timestamp(),
  `numero_escritura` varchar(20) NOT NULL,
  `url_archivo` varchar(2083) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `documentos`
--

INSERT INTO `documentos` (`id`, `id_tipo_documento`, `id_persona_vendedor`, `id_persona_comprador`, `id_persona_declarador`, `id_persona_donatario`, `id_persona_donador`, `id_persona_cedente`, `id_persona_cesionario`, `fecha`, `fecha_escaneado`, `numero_escritura`, `url_archivo`) VALUES
(1, 1, 1, 2, NULL, NULL, NULL, NULL, NULL, '2022-09-27', '2022-10-09', '111', 'https://firebasestorage.googleapis.com/v0/b/miprimerproyecto-8abf3.appspot.com/o/escaneos%2FcompraVentas%2Fdocumento-1665359746.pdf?alt=media&token=2770b07c-26cd-4d57-a21d-8171109a4044'),
(2, 2, NULL, NULL, 3, NULL, NULL, NULL, NULL, '2022-09-20', '2022-10-09', '222', 'https://firebasestorage.googleapis.com/v0/b/miprimerproyecto-8abf3.appspot.com/o/escaneos%2FdeclaracionesJuradas%2Fdocumento-1665359780.pdf?alt=media&token=77237462-2459-4cd5-946d-6944dfe8d54f'),
(3, 3, NULL, NULL, NULL, NULL, NULL, 4, 5, '2022-09-27', '2022-10-09', '333', 'https://firebasestorage.googleapis.com/v0/b/miprimerproyecto-8abf3.appspot.com/o/escaneos%2Fherencias%2Fdocumento-1665359844.pdf?alt=media&token=694f9ecf-30fd-485d-b358-694c7665805c'),
(4, 3, NULL, NULL, NULL, NULL, NULL, 4, 6, '2022-09-27', '2022-10-09', '333', 'https://firebasestorage.googleapis.com/v0/b/miprimerproyecto-8abf3.appspot.com/o/escaneos%2Fherencias%2Fdocumento-1665359844.pdf?alt=media&token=694f9ecf-30fd-485d-b358-694c7665805c'),
(5, 3, NULL, NULL, NULL, NULL, NULL, 4, 7, '2022-09-27', '2022-10-09', '333', 'https://firebasestorage.googleapis.com/v0/b/miprimerproyecto-8abf3.appspot.com/o/escaneos%2Fherencias%2Fdocumento-1665359844.pdf?alt=media&token=694f9ecf-30fd-485d-b358-694c7665805c'),
(6, 4, NULL, NULL, NULL, 9, 8, NULL, NULL, '2022-09-27', '2022-10-09', '444', 'https://firebasestorage.googleapis.com/v0/b/miprimerproyecto-8abf3.appspot.com/o/escaneos%2Fdonaciones%2Fdocumento-1665359901.pdf?alt=media&token=514789d8-462b-4750-ab6b-671ef6b76a63'),
(7, 1, 10, 11, NULL, NULL, NULL, NULL, NULL, '2022-09-12', '2022-10-09', '555', 'https://firebasestorage.googleapis.com/v0/b/miprimerproyecto-8abf3.appspot.com/o/escaneos%2FcompraVentas%2Fdocumento-1665360102.pdf?alt=media&token=7457d393-9caf-486e-a5e2-435c78dfdfb2'),
(8, 2, NULL, NULL, 12, NULL, NULL, NULL, NULL, '2022-09-14', '2022-10-09', '666', 'https://firebasestorage.googleapis.com/v0/b/miprimerproyecto-8abf3.appspot.com/o/escaneos%2FdeclaracionesJuradas%2Fdocumento-1665360123.pdf?alt=media&token=52ecfc91-646a-4543-816b-df93ca721c93'),
(9, 3, NULL, NULL, NULL, NULL, NULL, 13, 14, '2022-09-18', '2022-10-09', '777', 'https://firebasestorage.googleapis.com/v0/b/miprimerproyecto-8abf3.appspot.com/o/escaneos%2Fherencias%2Fdocumento-1665360162.pdf?alt=media&token=5b833bb3-cff2-456d-b509-950f7225e35a'),
(10, 3, NULL, NULL, NULL, NULL, NULL, 13, 15, '2022-09-18', '2022-10-09', '777', 'https://firebasestorage.googleapis.com/v0/b/miprimerproyecto-8abf3.appspot.com/o/escaneos%2Fherencias%2Fdocumento-1665360162.pdf?alt=media&token=5b833bb3-cff2-456d-b509-950f7225e35a');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personas`
--

CREATE TABLE `personas` (
  `id` int(11) NOT NULL,
  `dpi` varchar(13) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `direccion` varchar(255) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `personas`
--

INSERT INTO `personas` (`id`, `dpi`, `nombre`, `direccion`) VALUES
(1, '2343', 'comprador1', ''),
(2, '343453', 'vendedor1', ''),
(3, '345345', 'declarador1', ''),
(4, '584684', 'cedente1', ''),
(5, '2335', 'cesionario1', ''),
(6, '234523', 'cesionario2', ''),
(7, '73764', 'cesionario3', ''),
(8, '34454', 'donante1', ''),
(9, '2344534', 'donatario1', ''),
(10, '324534', 'vendedor2', ''),
(11, '754564', 'comprador2', ''),
(12, '784664', 'declarador2', ''),
(13, '7346764', 'cedente2', ''),
(14, '74674', 'cesinario1', ''),
(15, '84764', 'cesinario2', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `nombre_rol` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_documentos`
--

CREATE TABLE `tipos_documentos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tipos_documentos`
--

INSERT INTO `tipos_documentos` (`id`, `nombre`) VALUES
(1, 'Compraventa'),
(2, 'Declaración jurada'),
(3, 'Cesion de Derechos Hereditarios'),
(4, 'Donacion Entre Vivos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre_usuario` varchar(255) NOT NULL,
  `contrasenia` varchar(255) NOT NULL,
  `estado` varchar(255) DEFAULT 'desconectado',
  `id_persona` int(11) NOT NULL,
  `id_rol` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_cedentes`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vista_cedentes` (
`id_persona` int(11)
,`nombre` varchar(255)
,`dpi` varchar(13)
,`numero_escritura` varchar(20)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_cesionarios`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vista_cesionarios` (
`id_persona` int(11)
,`nombre` varchar(255)
,`dpi` varchar(13)
,`numero_escritura` varchar(20)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_compradores`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vista_compradores` (
`id_persona` int(11)
,`nombre` varchar(255)
,`dpi` varchar(13)
,`numero_escritura` varchar(20)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_documentos`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vista_documentos` (
`rowNumber` bigint(21)
,`id_documento` int(11)
,`numero_escritura` varchar(20)
,`tipo_documento` varchar(255)
,`fecha_documento` date
,`url_archivo` varchar(2083)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_vendedores`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vista_vendedores` (
`id_persona` int(11)
,`nombre` varchar(255)
,`dpi` varchar(13)
,`numero_escritura` varchar(20)
);

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_cedentes`
--
DROP TABLE IF EXISTS `vista_cedentes`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_cedentes`  AS SELECT `personas`.`id` AS `id_persona`, `personas`.`nombre` AS `nombre`, `personas`.`dpi` AS `dpi`, `documentos`.`numero_escritura` AS `numero_escritura` FROM (`personas` join `documentos` on(`personas`.`id` = `documentos`.`id_persona_cedente`))  ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_cesionarios`
--
DROP TABLE IF EXISTS `vista_cesionarios`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_cesionarios`  AS SELECT `personas`.`id` AS `id_persona`, `personas`.`nombre` AS `nombre`, `personas`.`dpi` AS `dpi`, `documentos`.`numero_escritura` AS `numero_escritura` FROM (`personas` join `documentos` on(`personas`.`id` = `documentos`.`id_persona_cesionario`))  ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_compradores`
--
DROP TABLE IF EXISTS `vista_compradores`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_compradores`  AS SELECT `personas`.`id` AS `id_persona`, `personas`.`nombre` AS `nombre`, `personas`.`dpi` AS `dpi`, `documentos`.`numero_escritura` AS `numero_escritura` FROM (`personas` join `documentos` on(`personas`.`id` = `documentos`.`id_persona_comprador`))  ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_documentos`
--
DROP TABLE IF EXISTS `vista_documentos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_documentos`  AS SELECT row_number() over ( order by `documentos`.`id`) AS `rowNumber`, `documentos`.`id` AS `id_documento`, `documentos`.`numero_escritura` AS `numero_escritura`, `tipos_documentos`.`nombre` AS `tipo_documento`, `documentos`.`fecha` AS `fecha_documento`, `documentos`.`url_archivo` AS `url_archivo` FROM (`documentos` join `tipos_documentos` on(`documentos`.`id_tipo_documento` = `tipos_documentos`.`id`)) GROUP BY `documentos`.`numero_escritura``numero_escritura`  ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_vendedores`
--
DROP TABLE IF EXISTS `vista_vendedores`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_vendedores`  AS SELECT `personas`.`id` AS `id_persona`, `personas`.`nombre` AS `nombre`, `personas`.`dpi` AS `dpi`, `documentos`.`numero_escritura` AS `numero_escritura` FROM (`personas` join `documentos` on(`personas`.`id` = `documentos`.`id_persona_vendedor`))  ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `documentos`
--
ALTER TABLE `documentos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_documento_persona_vendedor` (`id_persona_vendedor`),
  ADD KEY `FK_documento_persona_comprador` (`id_persona_comprador`),
  ADD KEY `FK_documento_persona_donatario` (`id_persona_donatario`),
  ADD KEY `FK_documento_persona_donador` (`id_persona_donador`),
  ADD KEY `FK_documento_persona_declarador` (`id_persona_declarador`),
  ADD KEY `FK_documento_persona_difunto` (`id_persona_cedente`),
  ADD KEY `FK_documento_persona_heredera` (`id_persona_cesionario`),
  ADD KEY `FK_documento_tipos_documento` (`id_tipo_documento`);

--
-- Indices de la tabla `personas`
--
ALTER TABLE `personas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipos_documentos`
--
ALTER TABLE `tipos_documentos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_usuario_persona` (`id_persona`),
  ADD KEY `FK_usuario_rol` (`id_rol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `documentos`
--
ALTER TABLE `documentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `personas`
--
ALTER TABLE `personas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tipos_documentos`
--
ALTER TABLE `tipos_documentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `documentos`
--
ALTER TABLE `documentos`
  ADD CONSTRAINT `FK_documento_persona_comprador` FOREIGN KEY (`id_persona_comprador`) REFERENCES `personas` (`id`),
  ADD CONSTRAINT `FK_documento_persona_declarador` FOREIGN KEY (`id_persona_declarador`) REFERENCES `personas` (`id`),
  ADD CONSTRAINT `FK_documento_persona_difunto` FOREIGN KEY (`id_persona_cedente`) REFERENCES `personas` (`id`),
  ADD CONSTRAINT `FK_documento_persona_donador` FOREIGN KEY (`id_persona_donador`) REFERENCES `personas` (`id`),
  ADD CONSTRAINT `FK_documento_persona_donatario` FOREIGN KEY (`id_persona_donatario`) REFERENCES `personas` (`id`),
  ADD CONSTRAINT `FK_documento_persona_heredera` FOREIGN KEY (`id_persona_cesionario`) REFERENCES `personas` (`id`),
  ADD CONSTRAINT `FK_documento_persona_vendedor` FOREIGN KEY (`id_persona_vendedor`) REFERENCES `personas` (`id`),
  ADD CONSTRAINT `FK_documento_tipos_documento` FOREIGN KEY (`id_tipo_documento`) REFERENCES `tipos_documentos` (`id`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `FK_usuario_persona` FOREIGN KEY (`id_persona`) REFERENCES `personas` (`id`),
  ADD CONSTRAINT `FK_usuario_rol` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
