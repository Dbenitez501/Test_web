-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-03-2022 a las 03:59:58
-- Versión del servidor: 10.4.22-MariaDB
-- Versión de PHP: 8.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `conferencias`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `cambiar_estado_presenciales` (IN `idL` INT)  BEGIN
UPDATE presencial SET estado = 0 WHERE presencial.id_lugar = idL;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `conteo_capacidad_presencial` (IN `id_p` INT)  BEGIN
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `conteo_capacidad_virtual` (IN `id_v` INT)  BEGIN
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `desactivar_conferencias_expiradas` (IN `fecha_actual` DATE)  BEGIN

UPDATE presencial SET estado = 0 WHERE fecha_inicio < fecha_actual;

UPDATE virtual SET estado = 0 WHERE fecha_inicio < fecha_actual;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `restar_capacidad_presencial` (IN `id_r` INT, IN `fecha_actual` DATE, IN `hora_actual` VARCHAR(10))  BEGIN
DECLARE cap_act INT;
DECLARE cap_maxima INT;
DECLARE id_p INT;
DECLARE fecha_conferencia DATE;
DECLARE hora_conferencia VARCHAR(10);

SELECT id_presencial FROM registros WHERE id_registro = id_r INTO id_p;

SELECT fecha_inicio FROM presencial WHERE id_presencial = id_p INTO fecha_conferencia;

SELECT hora_inicio FROM presencial WHERE id_presencial = id_p INTO hora_conferencia;

SELECT capacidad_actual FROM presencial WHERE id_presencial = id_p INTO cap_act;

SELECT lugar_expo.capacidad_max FROM lugar_expo JOIN presencial ON presencial.id_lugar = lugar_expo.id_lugar WHERE presencial.id_presencial = id_p INTO cap_maxima;

SET cap_act = cap_act - 1;
UPDATE presencial SET capacidad_actual = cap_act WHERE id_presencial = id_p;

/*Activa la conferencia si aun hay cupos y si aun no pasa la fecha de exposicion*/
IF ((cap_act < cap_maxima) AND (fecha_conferencia >= fecha_actual))
THEN
	UPDATE presencial SET estado = 1 WHERE id_presencial = 		id_p;
    
    IF ((fecha_conferencia = fecha_actual) AND (hora_conferencia  > hora_actual))
    THEN
	UPDATE presencial SET estado = 1 WHERE id_presencial = 		id_p;
	END IF;
END IF;

/*Desactiva la conferencia si ya esta expirada*/
IF (fecha_conferencia <= fecha_actual)
	THEN
    IF (hora_conferencia  <= hora_actual)
    THEN
    UPDATE presencial SET estado = 0 WHERE id_presencial = 		id_p;
    END IF;
END IF;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `restar_capacidad_virtual` (IN `id_r` INT, IN `fecha_actual` DATE, IN `hora_actual` VARCHAR(10))  BEGIN
DECLARE cap_act INT;
DECLARE cap_maxima INT;
DECLARE id_v INT;
DECLARE fecha_conferencia DATE;
DECLARE hora_conferencia VARCHAR(10);

SELECT id_virtual FROM registros WHERE id_registro = id_r INTO id_v;

SELECT fecha_inicio FROM virtual WHERE id_virtual = id_v INTO fecha_conferencia;

SELECT hora_inicio FROM virtual WHERE id_virtual = id_v INTO hora_conferencia;

SELECT cap_actual FROM virtual WHERE id_virtual = id_v INTO cap_act;

SELECT cap_max FROM virtual WHERE id_virtual = id_v INTO cap_maxima;

SET cap_act = cap_act - 1;
UPDATE virtual SET cap_actual = cap_act WHERE id_virtual = id_v;

/*Activa la conferencia si aun hay cupos y si aun no pasa la fecha de exposicion*/
IF ((cap_act < cap_maxima) AND (fecha_conferencia >= fecha_actual))
THEN
	UPDATE virtual SET estado = 1 WHERE id_virtual = id_v;
    
    IF ((fecha_conferencia = fecha_actual) AND (hora_conferencia  > hora_actual))
    THEN
	UPDATE virtual SET estado = 1 WHERE id_virtual = id_v;
	END IF;
END IF;

/*Desactiva la conferencia si ya esta expirada*/
IF (fecha_conferencia <= fecha_actual)
	THEN
    IF (hora_conferencia  <= hora_actual)
    THEN
    UPDATE virtual SET estado = 0 WHERE id_virtual = id_v;
    END IF;
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
(4, 'Auditorio', 'Edificio 4, 2do piso', 42, 'Esta es una prueba de lugar de exposición', 'Habilitado'),
(6, 'Prueba Lugar', 'Edificio 2, 3er Piso', 30, 'Características del lugar de la conferencia', 'Habilitado');

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
(10, 'Conferencia FASTENAL Prueba', 'Conferencia llevada a cabo por la empresa FASTENAL', 'Expositor 1', '2022-03-31', '20:00', 2, 1, 6, 'fastenal432', 'Presencial', 0x3738323136372e6a7067, '2022-02-28 20:34:02'),
(22, 'Conferencia de Cemex', 'Aquí va la descripción de la conferencia ', 'Ing. Cemex', '2022-03-30', '10:30', 1, 1, 6, '822189', 'Presencial', 0x3834323432362e6a7067, '2022-02-28 20:34:15');

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
(72, NULL, 4, 47, 0, NULL),
(73, NULL, 4, 58, 0, NULL),
(74, NULL, 4, 59, 0, NULL),
(76, 22, NULL, 59, 0, NULL),
(77, NULL, 4, 44, 0, NULL),
(79, 10, NULL, 58, 0, NULL),
(140, NULL, 9, 29, 0, NULL),
(148, 22, NULL, 29, 0, NULL),
(164, 10, NULL, 64, 0, NULL);

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
(1, 'Dbenitez', 'L3Rrd1pGdTV2R2p6U21tU3NGdkM1QT09', 'Abiam Alberto Escobedo Ruiz', NULL, NULL, 'diego@gmail.com', 8127592648, 'Masculino', '', 1),
(29, 'Abiam19', 'L3Rrd1pGdTV2R2p6U21tU3NGdkM1QT09', 'Abiam Alberto Escobedo Ruiz', 'IAS', '1804387', 'diegobenitez@live.com.mx', 8121137873, 'Masculino', '', 3),
(34, 'Prueba1', 'L3Rrd1pGdTV2R2p6U21tU3NGdkM1QT09', 'Prueba 1', NULL, NULL, 'prueba1@gmail.com', 8127689609, 'Masculino', '', 5),
(35, 'Prueba2', 'L3Rrd1pGdTV2R2p6U21tU3NGdkM1QT09', 'Prueba 2', NULL, NULL, 'prueba2@gmail.com', 0, 'Femenino', '', 5),
(36, 'PruebaA1', 'L3Rrd1pGdTV2R2p6U21tU3NGdkM1QT09', 'Prueba Alumno', 'IAS', '8512364', 'pruebaalumno@gmail.com', 0, 'Femenino', '', 4),
(37, 'PruebaA2', 'L3Rrd1pGdTV2R2p6U21tU3NGdkM1QT09', 'Prueba A2', 'IAS', '1456436', 'pruebaa2@gmail.com', 0, 'Masculino', '', 3),
(43, '1', 'b0V6a0JPUnNCK1lIRmgvNkQwL1NtZz09', '11|', '1', '222222222222222222222', 'jahir.a.gzz@gmail.com', 1, 'Masculino', '', 3),
(44, '12', 'L3Rrd1pGdTV2R2p6U21tU3NGdkM1QT09', '12', NULL, '1', 'abaim19halo4@hotmail.com', 8121127873, 'Masculino', '', 2),
(45, '233', 'L3Rrd1pGdTV2R2p6U21tU3NGdkM1QT09', 'Alberto', NULL, '81928', 'jahi22r.a.gzz@gmail.com', 0, 'Masculino', '', 2),
(46, 'abiam1999', 'L3Rrd1pGdTV2R2p6U21tU3NGdkM1QT09', 'Abiam Alberto ', 'IAS', '1804388', 'abaim19halo4@gmail.com', 8121137873, 'Masculino', '', 3),
(47, 'Alberto19', 'L3Rrd1pGdTV2R2p6U21tU3NGdkM1QT09', 'Alberto', NULL, '1219012', 'azabiaam19@gmail.com', 8121137873, 'Otro', '', 2),
(48, 'Dbenitez2121', 'MGw1TTdxUG5CR09SaVhPaHFhRzM4QT09', 'Alberto99', NULL, 'abiam', 'jahir.a2.gzz@gmail.com', 11212121, 'M', '', 2),
(49, '212121', 'b0V6a0JPUnNCK1lIRmgvNkQwL1NtZz09', 'akla,11', NULL, 'naoiska', 'ali2ber.14.a@gmail.com', 21213112, 'M', '', 2),
(50, '2121211', 'b0V6a0JPUnNCK1lIRmgvNkQwL1NtZz09', 'akla,11', NULL, 'naoiska1', 'ali2ber.14.ag@mail.com', 21213100, 'M', '', 2),
(51, 'Abiam192', 'dCt4d0FMYkE0THczeGg1eXE5Rk9DUT09', 'Alberto', NULL, '1802911', 'abaim19hal2o4@hotmail.com', 8121137873, 'Otro', '', 2),
(52, 'PruebaPaisMX', 'SE1NbTYyTnBtTkFaeUlhOWFUa2twQT09', 'Abiam Alberto', NULL, '1219022', 'abaim2219halo4@gmail.com', 8121137873, 'Masculino', '', 2),
(53, 'Dbenitez2', 'NUdVc3pvYUtYNzF5TU5IMmdtR2FJQT09', 'Abiam Alberto ', NULL, '1802933', 'btabia1m19@gmail.com', 8121137873, 'Otro', '', 2),
(54, 'Dbenitez32', 'K2F6ekdWaFhtUTFIamlsWVBnU2FCdz09', 'Abiam Alberto ', NULL, '1619012', 'jahir.a.gz33z@gmail.com', 8121137873, 'Femenino', '', 2),
(55, 'Dbenitez42', 'K2F6ekdWaFhtUTFIamlsWVBnU2FCdz09', 'Abiam Alberto ', NULL, '1619019', 'jahir.a.g33z@gmail.com', 8121137873, 'Femenino', 'México', 2),
(56, 'Abiam22', 'WGxEbGhiNENkMUF2NlNMOVUyeVpZQT09', 'Abiamxñ Alberto ', 'IB', '1804342', 'abaim19hhalo4@hotmail.com', 8121137871, 'Otro', '', 3),
(57, 'Dbenitez2z', 'WGxEbGhiNENkMUF2NlNMOVUyeVpZQT09', 'Abiamxñ Alberto ', 'IB', '1844342', 'abaim19ha2lo4@hotmail.com', 8121137871, 'Otro', '', 3),
(58, 'Aliber21', 'SE1NbTYyTnBtTkFaeUlhOWFUa2twQT09', 'Aliber Abiel Escobedo Ruiz', 'IMA', '9904387', 'aliber@hotmail.com', 8121137873, 'Masculino', 'Estados Unidos', 3),
(59, 'PruebaA9', 'SE1NbTYyTnBtTkFaeUlhOWFUa2twQT09', 'Abiam Alberto ', NULL, NULL, 'abaim19halo7774@hotmail.com', 8121137873, 'Femenino', 'Australia', 4),
(60, 'PruebaA122', 'SE1NbTYyTnBtTkFaeUlhOWFUa2twQT09', 'Abiam Alberto ', NULL, '1219010', 'abaim19ha24lo4@hotmail.com', 8121137873, 'Masculino', 'Bangladesh', 2),
(61, 'auxiliar1', 'SE1NbTYyTnBtTkFaeUlhOWFUa2twQT09', 'Auxiliar Abiam', NULL, NULL, 'abaim19dddddddhalo4@hotmail.com', 8121137873, 'Masculino', '', 5),
(62, 'auxiliar9', 'SE1NbTYyTnBtTkFaeUlhOWFUa2twQT09', 'Auxiliar Abiam', NULL, NULL, 'abaim19ddddhalo4@hotmail.com', 8121137873, 'Masculino', '', 5),
(63, 'ojsmlkaokl', 'V3F6WWN6dXk4SGRuT0VINDRhUnh0QT09', 'ank', NULL, NULL, 'jahir.1a.gzz@gmail.com', 8121137873, 'Femenino', '', 1),
(64, 'Ejemplo_1', 'RmpIcFNLTUErbGtJQVN0bUJQYkRJUT09', 'Nombres Apellidop Apellidom', NULL, '1234567', 'ejemplo_1@hotmail.com', 8121534873, 'Masculino', 'México', 2);

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
(4, 'Programas Formativos', 'Sesión informativa de los programas formativos en Ternium', 'Expositor 2', '2022-04-14', '14:00', 'MsTeams', 'j6fn564', 1, 4, 32, 'ternium123', 'Virtual', 0x39363736372e6a7067, '2022-02-14 19:47:14'),
(9, 'Impacto de empresas de consumo masivo', 'Impacto de empresas de consumo masivo en generación de riqueza, empleo y nuevas tecnologías en países emergentes', 'ING. JOSE LUIS PEREZ RENTERIA', '2022-03-26', '20:00', 'MsTeams', 'a8gf345', 0, 1, 50, 'arca345', 'Virtual', 0x3839323839342e706e67, '2021-07-02 21:04:45'),
(15, 'Prueba Activación 1', 'Prueba de activacion de la conferencia en tiempo aun disponible', 'Abiam', '2022-10-01', '20:00', 'Teams', 'x2901ao', 1, 0, 1, '123', 'Virtual', 0x3838313135332e706e67, '2022-02-28 19:48:54');

-- --------------------------------------------------------

--
-- Estructura para la vista `asistencia_registro`
--
DROP TABLE IF EXISTS `asistencia_registro`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `asistencia_registro`  AS SELECT `usuarios`.`id_usuario` AS `id_usuario`, `usuarios`.`nombre` AS `nombre`, `tipo_usuario`.`tipo` AS `tipo`, sum(`registros`.`asistencia`) AS `cant_conf`, `usuarios`.`correo` AS `correo` FROM ((`registros` join `usuarios` on(`registros`.`id_usuario` = `usuarios`.`id_usuario`)) join `tipo_usuario` on(`usuarios`.`id_tipo` = `tipo_usuario`.`id_tipo`)) GROUP BY `usuarios`.`id_usuario` ;

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
  MODIFY `id_lugar` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identificador del auditorio', AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `presencial`
--
ALTER TABLE `presencial`
  MODIFY `id_presencial` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identificador único de la conferencia presencial', AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `registros`
--
ALTER TABLE `registros`
  MODIFY `id_registro` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identificador único del registro', AUTO_INCREMENT=165;

--
-- AUTO_INCREMENT de la tabla `tipo_usuario`
--
ALTER TABLE `tipo_usuario`
  MODIFY `id_tipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identificador único del usuario', AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT de la tabla `virtual`
--
ALTER TABLE `virtual`
  MODIFY `id_virtual` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identificador único de la conferencia virtual', AUTO_INCREMENT=16;

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
