-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-09-2024 a las 03:04:58
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `maked`
--
CREATE DATABASE IF NOT EXISTS `maked` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `maked`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `pago` int(11) NOT NULL,
  `nivel` varchar(50) NOT NULL,
  `horas_dias` varchar(20) NOT NULL,
  `content` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Truncar tablas antes de insertar `posts`
--

TRUNCATE TABLE `posts`;
--
-- Volcado de datos para la tabla `posts`
--

INSERT INTO `posts` (`id`, `id_usuario`, `title`, `pago`, `nivel`, `horas_dias`, `content`, `timestamp`) VALUES
(1, 9, 'Mi primera publicacion', 5000000, 'Junior', '67 horas', 'Hola esta es mi primera publicación', '2024-08-06 23:47:51'),
(2, 10, 'Segunda publicacion', 400000, 'Senior', '78 dias', 'Hola amigos', '2024-08-06 23:48:18'),
(3, 15, 'Empleo programador', 1600000, 'Principiante', '8', 'Importante empresa del sector requiere Programador / Desarrollador que cuente con mínimo 2 Años de experiencia en desarrollo e implementación de .NET y Angular. Requisitos: * Ser PROFESIONAL en Ingeniería de Sistemas o de Software Condiciones Laborales: Horario: Lunes a Viernes de 7:00 a.m. a 5:00 p.m. Salario: $5.383.000 + Prestaciones de Ley Modalidad: Remoto (Puede residir en cualquier parte del país) Contrato: Término Obra o Labor Si cumples con el perfil ¡Postúlate!', '2024-09-13 03:13:07'),
(33, 15, 'qweq', 3, 'semi-Senior', 'qweqwe', 'hhhhhhhhhhhhhhh', '2024-09-13 04:00:33'),
(34, 15, 'Hola maker!', 1200000, 'semi-Senior', '6 dias por semana', 'Esto es una prueba!', '2024-09-13 04:01:51'),
(35, 14, 'holi maked', 100, 'junior', '67 horas ', 'prueba josé ', '2024-09-13 23:10:41');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `rol` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Truncar tablas antes de insertar `roles`
--

TRUNCATE TABLE `roles`;
--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `rol`) VALUES
(1, 'empresa'),
(2, 'programador'),
(3, 'administrador ');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `idrol` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `correo` varchar(120) NOT NULL,
  `clave` varchar(100) NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `foto` varchar(50) DEFAULT 'perfil.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Truncar tablas antes de insertar `usuarios`
--

TRUNCATE TABLE `usuarios`;
--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `idrol`, `nombre`, `apellido`, `correo`, `clave`, `fecha_nacimiento`, `foto`) VALUES
(9, 2, 'Raquel', 'Smith', 'raquel@gmail.com', '2', '2024-08-11', 'chica4.jpg'),
(10, 2, 'Andres', 'Gonzalez', 'andres@gmail.com', '1', '2024-08-11', 'chica3.jpg'),
(14, 1, 'camila', 'Numa', 'camilanuma@gmail.com', 'camilanuma', '2024-08-14', 'chica2.jpg'),
(15, 1, 'Estefany', 'Sequera', 'estefanysequera2510@gmail.com', '2510', '2024-08-09', 'chica1.jpg'),
(17, 2, 'Angel ', 'Velasquez Rangel', 'angel@gmail.com', '123456', '2024-09-12', 'perfil.png'),
(21, 3, 'maked', '', 'makedjobs@outlook.com', 'maked123', '2007-05-20', 'perfil.png'),
(22, 2, 'Katherine ', 'Rodriguez', 'taniakat310112@gmail.com', 'kat123', '1996-05-02', 'perfil.png'),
(23, 2, 'Jeison', 'Castañeda', 'jeisoncoronado2000@gmail.com', 'jeison123', '2000-01-12', 'perfil.png'),
(24, 3, 'Jose', 'Molano', 'josemolanoagudelo2007@hotmail.com', 'Molanojose12345', '2007-05-20', 'perfil.png');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`,`id_usuario`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idrol` (`idrol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`idrol`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
