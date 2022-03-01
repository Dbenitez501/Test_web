-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 01-03-2022 a las 01:41:19
-- Versión del servidor: 10.5.12-MariaDB
-- Versión de PHP: 7.3.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `id18312954_conferencias`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`id18312954_root`@`%` PROCEDURE `cambiar_estado_presenciales` (IN `idL` INT)  BEGIN
UPDATE presencial SET estado = 0 WHERE presencial.id_lugar = idL;
END$$

CREATE DEFINER=`id18312954_root`@`%` PROCEDURE `conteo_capacidad_presencial` (IN `id_p` INT)  BEGIN
DECLARE cap_act INT;
DECLARE cap_maxima INT;

SELECT capacidad_actual FROM presencial WHERE id_presencial = id_p INTO cap_act;
SELECT lugar_expo.capacidad_max FROM lugar_expo JOIN presencial ON presencial.id_lugar = lugar_expo.id_lugar WHERE presencial.id_presencial = id_p INTO cap_maxima;

SET cap_act = cap_act + 1;
UPDATE presencial SET capacidad_actual = cap_act WHERE id_presencial = id_p;

IF cap_act = cap_maxima THEN
UPDATE presencial SET estado = 0 WHERE id_presencial = id_p;
END IF;
END$$

CREATE DEFINER=`id18312954_root`@`%` PROCEDURE `conteo_capacidad_virtual` (IN `id_v` INT)  BEGIN
DECLARE cap_act INT;
DECLARE cap_maxima INT;

SELECT cap_actual FROM virtual WHERE id_virtual = id_v INTO cap_act;
SELECT cap_max FROM virtual WHERE id_virtual = id_v INTO cap_maxima;

SET cap_act = cap_act + 1;
UPDATE virtual SET cap_actual = cap_act WHERE id_virtual = id_v;

IF cap_act = cap_maxima THEN
UPDATE virtual SET estado = 0 WHERE id_virtual = id_v;
END IF;
END$$

CREATE DEFINER=`id18312954_root`@`%` PROCEDURE `restar_capacidad_presencial` (IN `id_r` INT)  BEGIN
DECLARE cap_act INT;
DECLARE cap_maxima INT;
DECLARE id_p INT;

SELECT id_presencial FROM registros WHERE id_registro = id_r INTO id_p;

SELECT capacidad_actual FROM presencial WHERE id_presencial = id_p INTO cap_act;

SELECT lugar_expo.capacidad_max FROM lugar_expo JOIN presencial ON presencial.id_lugar = lugar_expo.id_lugar WHERE presencial.id_presencial = id_p INTO cap_maxima;

SET cap_act = cap_act - 1;
UPDATE presencial SET capacidad_actual = cap_act WHERE id_presencial = id_p;

IF cap_act < cap_maxima THEN
UPDATE presencial SET estado = 1 WHERE id_presencial = id_p;
END IF;
END$$

CREATE DEFINER=`id18312954_root`@`%` PROCEDURE `restar_capacidad_virtual` (IN `id_r` INT)  BEGIN
DECLARE cap_act INT;
DECLARE cap_maxima INT;
DECLARE id_v INT;

SELECT id_virtual FROM registros WHERE id_registro = id_r INTO id_v;

SELECT cap_actual FROM virtual WHERE id_virtual = id_v INTO cap_act;

SELECT cap_max FROM virtual WHERE id_virtual = id_v INTO cap_maxima;

SET cap_act = cap_act - 1;
UPDATE virtual SET cap_actual = cap_act WHERE id_virtual = id_v;

IF cap_act < cap_maxima THEN
UPDATE virtual SET estado = 1 WHERE id_virtual = id_v;
END IF;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `asistencia_registro`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `asistencia_registro` (
`id_usuario` int(11)
,`nombre` varchar(250)
,`tipo` varchar(30)
,`cant_conf` decimal(25,0)
,`correo` varchar(200)
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lugar_expo`
--

CREATE TABLE `lugar_expo` (
  `id_lugar` int(11) NOT NULL COMMENT 'identificador del auditorio',
  `nombre` varchar(200) NOT NULL COMMENT 'nombre del auditorio',
  `ubicacion` varchar(100) NOT NULL COMMENT 'edificio donde se encuentra el auditorio',
  `capacidad_max` int(11) NOT NULL COMMENT 'capacidad máxima de personas que admite el auditorio',
  `descripcion` varchar(700) NOT NULL COMMENT 'descripcion del lugar de exposicion',
  `estado` varchar(20) DEFAULT NULL COMMENT 'Habilitado/Deshabilitado'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Tabla con la información de los auditorios';

--
-- Volcado de datos para la tabla `lugar_expo`
--

INSERT INTO `lugar_expo` (`id_lugar`, `nombre`, `ubicacion`, `capacidad_max`, `descripcion`, `estado`) VALUES
(4, 'Auditorio', 'Edificio 4, 2do piso', 40, 'Esta es una prueba de lugar de exposición', 'Habilitado'),
(6, 'Prueba Lugar', 'Edificio 2, 3er Piso', 2, 'holaaaaaaaaaaaa', 'Habilitado'),
(9, 'Rene Montante', 'Edificio 6, 1er Piso', 100, 'Prueba de características ', 'Habilitado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `presencial`
--

CREATE TABLE `presencial` (
  `id_presencial` int(11) NOT NULL COMMENT 'identificador único de la conferencia presencial',
  `titulo` varchar(255) NOT NULL COMMENT 'tema de la conferencia presencial',
  `descripcion` varchar(500) NOT NULL COMMENT 'descripción del tema a tratar',
  `expositor` varchar(200) NOT NULL COMMENT 'nombre completo del expositor de la conferencia',
  `fecha_inicio` date NOT NULL COMMENT 'fecha de inicio de la conferencia presencial',
  `hora_inicio` varchar(20) NOT NULL COMMENT 'hora de inicio de la conferencia presencial',
  `capacidad_actual` int(11) NOT NULL COMMENT 'numero del cupo ocupado actualmente de la conferencia',
  `estado` tinyint(4) NOT NULL COMMENT 'si la conferencia está habilitada o deshabilitada',
  `id_lugar` int(11) NOT NULL COMMENT 'identificador del auditorio donde se dará la conferencia',
  `codigo_asistencia` varchar(45) NOT NULL,
  `tipo` varchar(30) NOT NULL COMMENT 'tipo de conferencia (presencial)',
  `imagen` longblob DEFAULT NULL,
  `hora_creacion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Tabla con la informacion de las conferencias presenciales';

--
-- Volcado de datos para la tabla `presencial`
--

INSERT INTO `presencial` (`id_presencial`, `titulo`, `descripcion`, `expositor`, `fecha_inicio`, `hora_inicio`, `capacidad_actual`, `estado`, `id_lugar`, `codigo_asistencia`, `tipo`, `imagen`, `hora_creacion`) VALUES
(10, 'Conferencia FASTENAL Prueba', 'Conferencia llevada a cabo por la empresa FASTENAL', 'Expositor 1', '2021-06-30', '11:00', 2, 1, 6, 'fastenal432', 'Presencial', 0x3738323136372e6a7067, '2022-02-05 17:00:06'),
(22, 'Conferencia 1', 'descripción de la conferencia 1..............', 'Expositor 1', '2021-08-19', '17:30', 1, 1, 6, 'efsdfsd', 'Presencial', 0x3136353831342e6a7067, '2022-02-07 23:36:16'),
(23, 'Curso de Inducción', 'Curso de inducción de inicio de servicio social.', 'Servicio Social', '2021-06-25', '14:00', 0, 1, 9, '125463', 'Presencial', 0x3135353637332e6a7067, '2022-02-07 23:36:36');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registros`
--

CREATE TABLE `registros` (
  `id_registro` int(11) NOT NULL COMMENT 'identificador único del registro',
  `id_presencial` int(11) DEFAULT NULL COMMENT 'identificador único de la conferencia presencial',
  `id_virtual` int(11) DEFAULT NULL COMMENT 'identificador único de la conferencia virtual',
  `id_usuario` int(11) NOT NULL,
  `asistencia` tinyint(4) NOT NULL,
  `comentario` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Tabla con todos los registros que se han hecho a las conferencias';

--
-- Volcado de datos para la tabla `registros`
--

INSERT INTO `registros` (`id_registro`, `id_presencial`, `id_virtual`, `id_usuario`, `asistencia`, `comentario`) VALUES
(74, NULL, 14, 29, 1, 'fbgf'),
(75, 22, NULL, 29, 0, NULL),
(83, 10, NULL, 36, 0, NULL),
(85, 10, NULL, 37, 0, NULL),
(88, NULL, 4, 29, 0, NULL),
(89, NULL, 9, 29, 0, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_usuario`
--

CREATE TABLE `tipo_usuario` (
  `id_tipo` int(11) NOT NULL,
  `tipo` varchar(30) NOT NULL COMMENT 'tipo de usuario (Admin, Alumno, Docente, Externo)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Tabla con todos los tipos de usuario del sistema';

--
-- Volcado de datos para la tabla `tipo_usuario`
--

INSERT INTO `tipo_usuario` (`id_tipo`, `tipo`) VALUES
(1, 'Administrador'),
(2, 'Docente'),
(3, 'Estudiante'),
(4, 'Externo'),
(5, 'Auxiliar');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL COMMENT 'identificador único del usuario',
  `username` varchar(100) NOT NULL COMMENT 'Nombre de usuario',
  `contra` varchar(255) NOT NULL COMMENT 'contraseña del usuario',
  `nombre` varchar(250) NOT NULL COMMENT 'Nombre completo del usuario',
  `carrera` varchar(15) DEFAULT NULL COMMENT 'Carrera del usuario(Solo aplica para tipo Alumno)',
  `matricula` varchar(100) DEFAULT NULL COMMENT 'Matricula del usuario (Matricula del alumno o número de empleado del docente, NO APLICA a externo ni admin)',
  `correo` varchar(200) NOT NULL COMMENT 'correo del usuario',
  `telefono` bigint(10) DEFAULT NULL COMMENT 'teléfono OPCIONAL del usuario',
  `sexo` varchar(9) NOT NULL COMMENT 'Genero del usuario (Masculino o Femenino u Otro)',
  `pais` varchar(100) NOT NULL COMMENT 'país de origen',
  `id_tipo` int(11) NOT NULL COMMENT 'identificador único del tipo de usuario'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Tabla con la información de los usuarios';

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `username`, `contra`, `nombre`, `carrera`, `matricula`, `correo`, `telefono`, `sexo`, `pais`, `id_tipo`) VALUES
(1, 'Dbenitez', 'L3Rrd1pGdTV2R2p6U21tU3NGdkM1QT09', 'Diego Benitez Reyna', NULL, NULL, 'diego@gmail.com', 8127592648, 'Masculino', '', 1),
(29, 'Abiam19', 'L3Rrd1pGdTV2R2p6U21tU3NGdkM1QT09', 'Abiam Alberto Escobedo Ruíz', 'IAS', '1804387', 'diegobenitez@live.com.mx', 8136847541, 'H', '', 3),
(34, 'Prueba1', 'L3Rrd1pGdTV2R2p6U21tU3NGdkM1QT09', 'Prueba', NULL, NULL, 'prueba1@gmail.com', 8127689609, 'Femenino', '', 5),
(35, 'Prueba2', 'L3Rrd1pGdTV2R2p6U21tU3NGdkM1QT09', 'Prueba', NULL, NULL, 'prueba2@gmail.com', 8122222222, 'Otro', '', 5),
(36, 'PruebaA1', 'L3Rrd1pGdTV2R2p6U21tU3NGdkM1QT09', 'Prueba Alumno', 'IAS', '8512364', 'pruebaalumno@gmail.com', 0, 'M', '', 3),
(37, 'PruebaA2', 'L3Rrd1pGdTV2R2p6U21tU3NGdkM1QT09', 'Prueba A2', 'IAS', '1456436', 'pruebaa2@gmail.com', 0, 'H', '', 3),
(43, 'Abiam1999', 'SE1NbTYyTnBtTkFaeUlhOWFUa2twQT09', 'Abiam Alberto ', 'IAS', '1814387', 'abaim19halo4@hotmail.com', 8121137873, 'H', '', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `virtual`
--

CREATE TABLE `virtual` (
  `id_virtual` int(11) NOT NULL COMMENT 'identificador único de la conferencia virtual',
  `titulo` varchar(255) NOT NULL COMMENT 'tema a tratar en la conferencia virtual',
  `descripcion` varchar(300) NOT NULL COMMENT 'descripción del tema de la conferencia ',
  `expositor` varchar(200) NOT NULL COMMENT 'nombre completo del expositor de la conferencias',
  `fecha_inicio` date NOT NULL COMMENT 'fecha de inicio de la conferencia virtual',
  `hora_inicio` varchar(20) NOT NULL COMMENT 'hora de inicio de la conferencia virtual',
  `plataforma` varchar(50) NOT NULL COMMENT 'plataforma digital donde se llevará a cabo la conferencia',
  `codigo_plat` varchar(25) NOT NULL COMMENT 'codigo de la sala de la conferencia en la plataforma',
  `estado` tinyint(4) NOT NULL COMMENT 'si la conferencia está habilitada o deshabilitada',
  `cap_actual` int(11) NOT NULL,
  `cap_max` int(11) NOT NULL,
  `codigo_asistencia` varchar(25) NOT NULL,
  `tipo` varchar(30) NOT NULL COMMENT 'tipo de conferencia (virtual)',
  `imagen` longblob DEFAULT NULL,
  `hora_creacion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Tabla con la información general de las conferencias virtuales';

--
-- Volcado de datos para la tabla `virtual`
--

INSERT INTO `virtual` (`id_virtual`, `titulo`, `descripcion`, `expositor`, `fecha_inicio`, `hora_inicio`, `plataforma`, `codigo_plat`, `estado`, `cap_actual`, `cap_max`, `codigo_asistencia`, `tipo`, `imagen`, `hora_creacion`) VALUES
(4, 'Programas Formativos', 'Sesión informativa de los programas formativos en Ternium', 'Expositor 2', '2021-06-25', '14:00', 'MsTeams', 'j6fn564', 1, 1, 35, 'ternium123', 'Virtual', 0x39363736372e6a7067, '2021-07-02 21:04:33'),
(9, 'Impacto de empresas de consumo masivo', 'Impacto de empresas de consumo masivo en generación de riqueza, empleo y nuevas tecnologías en países emergentes', 'ING. JOSE LUIS PEREZ RENTERIA', '2021-06-29', '17:00', 'MsTeams', 'a8gf345', 1, 1, 50, 'arca345', 'Virtual', 0x3839323839342e706e67, '2021-07-02 21:04:45'),
(14, 'Conferencia 2', 'Conferencia virtual en hostapp', 'Abiam Alberto', '2022-01-22', '10:00', 'MsTeams', 'hd2ui198h', 1, 1, 2, '12345', 'Virtual', 0x3832363431302e706e67, '2022-02-07 23:37:26');

-- --------------------------------------------------------

--
-- Estructura para la vista `asistencia_registro`
--
DROP TABLE IF EXISTS `asistencia_registro`;

CREATE ALGORITHM=UNDEFINED DEFINER=`id18312954_root`@`%` SQL SECURITY DEFINER VIEW `asistencia_registro`  AS  select `usuarios`.`id_usuario` AS `id_usuario`,`usuarios`.`nombre` AS `nombre`,`tipo_usuario`.`tipo` AS `tipo`,sum(`registros`.`asistencia`) AS `cant_conf`,`usuarios`.`correo` AS `correo` from ((`registros` join `usuarios` on(`registros`.`id_usuario` = `usuarios`.`id_usuario`)) join `tipo_usuario` on(`usuarios`.`id_tipo` = `tipo_usuario`.`id_tipo`)) group by `usuarios`.`id_usuario` ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `lugar_expo`
--
ALTER TABLE `lugar_expo`
  ADD PRIMARY KEY (`id_lugar`);

--
-- Indices de la tabla `presencial`
--
ALTER TABLE `presencial`
  ADD PRIMARY KEY (`id_presencial`),
  ADD KEY `FK_id_lugar_idx` (`id_lugar`);

--
-- Indices de la tabla `registros`
--
ALTER TABLE `registros`
  ADD PRIMARY KEY (`id_registro`),
  ADD KEY `FK_presencial_idx` (`id_presencial`),
  ADD KEY `FK_virtual_idx` (`id_virtual`),
  ADD KEY `FK_usuario_idx` (`id_usuario`);

--
-- Indices de la tabla `tipo_usuario`
--
ALTER TABLE `tipo_usuario`
  ADD PRIMARY KEY (`id_tipo`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD KEY `FK_id_tipo_idx` (`id_tipo`);

--
-- Indices de la tabla `virtual`
--
ALTER TABLE `virtual`
  ADD PRIMARY KEY (`id_virtual`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `lugar_expo`
--
ALTER TABLE `lugar_expo`
  MODIFY `id_lugar` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identificador del auditorio', AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `presencial`
--
ALTER TABLE `presencial`
  MODIFY `id_presencial` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identificador único de la conferencia presencial', AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `registros`
--
ALTER TABLE `registros`
  MODIFY `id_registro` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identificador único del registro', AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT de la tabla `tipo_usuario`
--
ALTER TABLE `tipo_usuario`
  MODIFY `id_tipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identificador único del usuario', AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT de la tabla `virtual`
--
ALTER TABLE `virtual`
  MODIFY `id_virtual` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identificador único de la conferencia virtual', AUTO_INCREMENT=15;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `presencial`
--
ALTER TABLE `presencial`
  ADD CONSTRAINT `FK_id_lugar` FOREIGN KEY (`id_lugar`) REFERENCES `lugar_expo` (`id_lugar`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `registros`
--
ALTER TABLE `registros`
  ADD CONSTRAINT `FK_presencial` FOREIGN KEY (`id_presencial`) REFERENCES `presencial` (`id_presencial`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_virtual` FOREIGN KEY (`id_virtual`) REFERENCES `virtual` (`id_virtual`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `FK_id_tipo` FOREIGN KEY (`id_tipo`) REFERENCES `tipo_usuario` (`id_tipo`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
