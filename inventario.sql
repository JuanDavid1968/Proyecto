-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-05-2023 a las 16:54:48
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
-- Base de datos: `inventario`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articulos`
--

CREATE TABLE `articulos` (
  `id_art` int(11) NOT NULL,
  `nombre_art` varchar(20) DEFAULT NULL,
  `tipo` varchar(20) DEFAULT NULL,
  `descripcion_art` text DEFAULT NULL,
  `precio_art` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `articulos`
--

INSERT INTO `articulos` (`id_art`, `nombre_art`, `tipo`, `descripcion_art`, `precio_art`) VALUES
(30001, 'Computador', 'Portatil', NULL, 2500000);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bodega`
--

CREATE TABLE `bodega` (
  `id_bod` int(11) NOT NULL,
  `direccion_bod` varchar(50) DEFAULT NULL,
  `barrio_bod` varchar(20) DEFAULT NULL,
  `ciudad_bod` varchar(20) DEFAULT NULL,
  `pais_bod` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `bodega`
--

INSERT INTO `bodega` (`id_bod`, `direccion_bod`, `barrio_bod`, `ciudad_bod`, `pais_bod`) VALUES
(10001, 'Cra 116 #74a-40', 'Gran Granada', 'Bogota', 'Colombia');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cargo`
--

CREATE TABLE `cargo` (
  `id_car` int(11) NOT NULL,
  `id_emp` int(11) NOT NULL,
  `nombre_car` varchar(50) DEFAULT NULL,
  `funciones_car` text DEFAULT NULL,
  `privilegios_car` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `correos`
--

CREATE TABLE `correos` (
  `id_cor` int(11) NOT NULL,
  `id_emp` int(11) NOT NULL,
  `correo` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `direcciones`
--

CREATE TABLE `direcciones` (
  `id_dir` int(11) NOT NULL,
  `id_emp` int(11) NOT NULL,
  `direccion` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE `empleados` (
  `id_emp` int(11) NOT NULL,
  `nombre1_emp` varchar(50) DEFAULT NULL,
  `nombre2_emp` varchar(50) DEFAULT NULL,
  `apellido1_emp` varchar(50) DEFAULT NULL,
  `apellido2_emp` varchar(50) DEFAULT NULL,
  `sexo_emp` varchar(20) DEFAULT NULL,
  `fechanacim_emp` date DEFAULT NULL,
  `tipo_emp` varchar(20) DEFAULT NULL,
  `cedula_emp` decimal(10,0) DEFAULT NULL,
  `id_bod` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`id_emp`, `nombre1_emp`, `nombre2_emp`, `apellido1_emp`, `apellido2_emp`, `sexo_emp`, `fechanacim_emp`, `tipo_emp`, `cedula_emp`, `id_bod`) VALUES
(20001, 'Jorge', 'Enrique', 'Vargas', 'Abril', 'Masculino', '2000-02-12', 'Administrativo', 0, 10001);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura`
--

CREATE TABLE `factura` (
  `id_fact` int(11) NOT NULL,
  `id_art` int(11) NOT NULL,
  `fecha_fact` date NOT NULL,
  `id_emp` int(11) NOT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `precio_fac` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `factura`
--

INSERT INTO `factura` (`id_fact`, `id_art`, `fecha_fact`, `id_emp`, `cantidad`, `precio_fac`) VALUES
(80001, 30001, '2023-05-16', 20001, 2, 2500000),
(80002, 30001, '2023-03-06', 20001, 2, 5000000);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingreso_inventario`
--

CREATE TABLE `ingreso_inventario` (
  `id_inginv` int(11) NOT NULL,
  `id_art` int(11) NOT NULL,
  `fechaingreso` date DEFAULT NULL,
  `horaingreso` time DEFAULT NULL,
  `cantidad_inginv` decimal(10,0) DEFAULT NULL,
  `id_emp` int(11) NOT NULL,
  `id_bod` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ingreso_inventario`
--

INSERT INTO `ingreso_inventario` (`id_inginv`, `id_art`, `fechaingreso`, `horaingreso`, `cantidad_inginv`, `id_emp`, `id_bod`) VALUES
(60001, 30001, '2023-05-11', '19:49:00', 25, 20001, 10001);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `login`
--

CREATE TABLE `login` (
  `id_log` int(11) NOT NULL,
  `user_log` varchar(50) DEFAULT NULL,
  `password_log` varchar(50) DEFAULT NULL,
  `id_emp` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `salario`
--

CREATE TABLE `salario` (
  `id_sal` int(11) NOT NULL,
  `id_emp` int(11) NOT NULL,
  `numerocuenta` decimal(25,0) DEFAULT NULL,
  `banco` varchar(50) DEFAULT NULL,
  `salariobase` decimal(50,0) DEFAULT NULL,
  `auxiliotransporte` decimal(50,0) DEFAULT NULL,
  `descuentosalud` float DEFAULT NULL,
  `descuentopension` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `salida_inventario`
--

CREATE TABLE `salida_inventario` (
  `id_salinv` int(11) NOT NULL,
  `id_art` int(11) NOT NULL,
  `fechasalida` date DEFAULT NULL,
  `horasalida` time DEFAULT NULL,
  `razonsalida` text DEFAULT NULL,
  `cantidad_salinv` decimal(10,0) DEFAULT NULL,
  `id_emp` int(11) NOT NULL,
  `id_bod` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `salida_inventario`
--

INSERT INTO `salida_inventario` (`id_salinv`, `id_art`, `fechasalida`, `horasalida`, `razonsalida`, `cantidad_salinv`, `id_emp`, `id_bod`) VALUES
(70001, 30001, '2023-05-11', '21:00:00', 'Cambio de Equipo por Garantia', 2, 20001, 10001);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `stock`
--

CREATE TABLE `stock` (
  `id_stk` int(11) NOT NULL,
  `id_art` int(11) NOT NULL,
  `cantidadtotal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `stock`
--

INSERT INTO `stock` (`id_stk`, `id_art`, `cantidadtotal`) VALUES
(40002, 30001, 50);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `telefonos`
--

CREATE TABLE `telefonos` (
  `id_tel` int(11) NOT NULL,
  `id_emp` int(11) NOT NULL,
  `telefono` decimal(25,0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `articulos`
--
ALTER TABLE `articulos`
  ADD PRIMARY KEY (`id_art`);

--
-- Indices de la tabla `bodega`
--
ALTER TABLE `bodega`
  ADD PRIMARY KEY (`id_bod`);

--
-- Indices de la tabla `cargo`
--
ALTER TABLE `cargo`
  ADD PRIMARY KEY (`id_car`),
  ADD KEY `fk_empsix` (`id_emp`);

--
-- Indices de la tabla `correos`
--
ALTER TABLE `correos`
  ADD PRIMARY KEY (`id_cor`),
  ADD KEY `fk_empfive` (`id_emp`);

--
-- Indices de la tabla `direcciones`
--
ALTER TABLE `direcciones`
  ADD PRIMARY KEY (`id_dir`),
  ADD KEY `fk_empfour` (`id_emp`);

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`id_emp`),
  ADD KEY `fk_bod` (`id_bod`);

--
-- Indices de la tabla `factura`
--
ALTER TABLE `factura`
  ADD PRIMARY KEY (`id_fact`),
  ADD KEY `id_emp` (`id_emp`);

--
-- Indices de la tabla `ingreso_inventario`
--
ALTER TABLE `ingreso_inventario`
  ADD PRIMARY KEY (`id_inginv`),
  ADD KEY `fk_art` (`id_art`),
  ADD KEY `fk_emp` (`id_emp`),
  ADD KEY `fk_bodone` (`id_bod`);

--
-- Indices de la tabla `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id_log`),
  ADD KEY `fk_empi` (`id_emp`);

--
-- Indices de la tabla `salario`
--
ALTER TABLE `salario`
  ADD PRIMARY KEY (`id_sal`),
  ADD KEY `fk_empseven` (`id_emp`);

--
-- Indices de la tabla `salida_inventario`
--
ALTER TABLE `salida_inventario`
  ADD PRIMARY KEY (`id_salinv`),
  ADD KEY `fk_artone` (`id_art`),
  ADD KEY `fk_empone` (`id_emp`),
  ADD KEY `fk_bodtwo` (`id_bod`);

--
-- Indices de la tabla `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`id_stk`),
  ADD KEY `id_art` (`id_art`);

--
-- Indices de la tabla `telefonos`
--
ALTER TABLE `telefonos`
  ADD PRIMARY KEY (`id_tel`),
  ADD KEY `fk_emptres` (`id_emp`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `articulos`
--
ALTER TABLE `articulos`
  MODIFY `id_art` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30002;

--
-- AUTO_INCREMENT de la tabla `bodega`
--
ALTER TABLE `bodega`
  MODIFY `id_bod` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10002;

--
-- AUTO_INCREMENT de la tabla `cargo`
--
ALTER TABLE `cargo`
  MODIFY `id_car` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `correos`
--
ALTER TABLE `correos`
  MODIFY `id_cor` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `direcciones`
--
ALTER TABLE `direcciones`
  MODIFY `id_dir` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `id_emp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20003;

--
-- AUTO_INCREMENT de la tabla `factura`
--
ALTER TABLE `factura`
  MODIFY `id_fact` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80003;

--
-- AUTO_INCREMENT de la tabla `ingreso_inventario`
--
ALTER TABLE `ingreso_inventario`
  MODIFY `id_inginv` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60002;

--
-- AUTO_INCREMENT de la tabla `login`
--
ALTER TABLE `login`
  MODIFY `id_log` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `salario`
--
ALTER TABLE `salario`
  MODIFY `id_sal` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `salida_inventario`
--
ALTER TABLE `salida_inventario`
  MODIFY `id_salinv` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70002;

--
-- AUTO_INCREMENT de la tabla `telefonos`
--
ALTER TABLE `telefonos`
  MODIFY `id_tel` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cargo`
--
ALTER TABLE `cargo`
  ADD CONSTRAINT `fk_empsix` FOREIGN KEY (`id_emp`) REFERENCES `empleados` (`id_emp`);

--
-- Filtros para la tabla `correos`
--
ALTER TABLE `correos`
  ADD CONSTRAINT `fk_empfive` FOREIGN KEY (`id_emp`) REFERENCES `empleados` (`id_emp`);

--
-- Filtros para la tabla `direcciones`
--
ALTER TABLE `direcciones`
  ADD CONSTRAINT `fk_empfour` FOREIGN KEY (`id_emp`) REFERENCES `empleados` (`id_emp`);

--
-- Filtros para la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD CONSTRAINT `fk_bod` FOREIGN KEY (`id_bod`) REFERENCES `bodega` (`id_bod`);

--
-- Filtros para la tabla `factura`
--
ALTER TABLE `factura`
  ADD CONSTRAINT `factura_ibfk_1` FOREIGN KEY (`id_emp`) REFERENCES `empleados` (`id_emp`);

--
-- Filtros para la tabla `ingreso_inventario`
--
ALTER TABLE `ingreso_inventario`
  ADD CONSTRAINT `fk_art` FOREIGN KEY (`id_art`) REFERENCES `articulos` (`id_art`),
  ADD CONSTRAINT `fk_bodone` FOREIGN KEY (`id_bod`) REFERENCES `bodega` (`id_bod`),
  ADD CONSTRAINT `fk_emp` FOREIGN KEY (`id_emp`) REFERENCES `empleados` (`id_emp`);

--
-- Filtros para la tabla `login`
--
ALTER TABLE `login`
  ADD CONSTRAINT `fk_empi` FOREIGN KEY (`id_emp`) REFERENCES `empleados` (`id_emp`);

--
-- Filtros para la tabla `salario`
--
ALTER TABLE `salario`
  ADD CONSTRAINT `fk_empseven` FOREIGN KEY (`id_emp`) REFERENCES `empleados` (`id_emp`);

--
-- Filtros para la tabla `salida_inventario`
--
ALTER TABLE `salida_inventario`
  ADD CONSTRAINT `fk_artone` FOREIGN KEY (`id_art`) REFERENCES `articulos` (`id_art`),
  ADD CONSTRAINT `fk_bodtwo` FOREIGN KEY (`id_bod`) REFERENCES `bodega` (`id_bod`),
  ADD CONSTRAINT `fk_empone` FOREIGN KEY (`id_emp`) REFERENCES `empleados` (`id_emp`);

--
-- Filtros para la tabla `stock`
--
ALTER TABLE `stock`
  ADD CONSTRAINT `stock_ibfk_1` FOREIGN KEY (`id_art`) REFERENCES `articulos` (`id_art`);

--
-- Filtros para la tabla `telefonos`
--
ALTER TABLE `telefonos`
  ADD CONSTRAINT `fk_emptres` FOREIGN KEY (`id_emp`) REFERENCES `empleados` (`id_emp`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
