-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 16-10-2025 a las 00:10:52
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bd_patitas`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `crear_usuario` (IN `p_usuario` VARCHAR(12), IN `p_correo` VARCHAR(80), IN `p_contrasena` VARCHAR(255))   BEGIN
    -- Rol = 1 porque es cliente
    INSERT INTO Usuarios (Usuario, Correo, Contrasena, Rol)
    VALUES (p_usuario, p_correo, p_contrasena, 1);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `login_usuario` (IN `p_usuario` VARCHAR(100))   BEGIN
    -- Verificamos si el usuario existe
    IF EXISTS (SELECT 1 FROM Usuarios WHERE Usuario = p_usuario) THEN
        SELECT Id_Usuario, Usuario, Contrasena
        FROM Usuarios
        WHERE Usuario = p_usuario;
    ELSE
        SELECT NULL AS Id_Usuario, NULL AS Usuario, NULL AS Contrasena;
    END IF;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito`
--

CREATE TABLE `carrito` (
  `Id_Carrito` int(11) NOT NULL,
  `Id_Usuario` int(11) NOT NULL,
  `Id_Producto` int(11) NOT NULL,
  `Cantidad` int(11) NOT NULL DEFAULT 1,
  `FechaAgregado` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `carrito`
--

INSERT INTO `carrito` (`Id_Carrito`, `Id_Usuario`, `Id_Producto`, `Cantidad`, `FechaAgregado`) VALUES
(41, 5, 1, 1, '2025-10-10 17:49:49'),
(42, 5, 2, 2, '2025-10-10 17:49:51'),
(43, 5, 3, 3, '2025-10-10 17:49:54');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historialcontrasenas`
--

CREATE TABLE `historialcontrasenas` (
  `Id_Historial` int(11) NOT NULL,
  `Id_Usuario` int(11) NOT NULL,
  `FechaCambio` datetime NOT NULL DEFAULT current_timestamp(),
  `Contrasena` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imagen`
--

CREATE TABLE `imagen` (
  `Id_Imagen` int(11) NOT NULL,
  `Nombre` varchar(50) DEFAULT NULL,
  `URL` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `imagen`
--

INSERT INTO `imagen` (`Id_Imagen`, `Nombre`, `URL`) VALUES
(1, 'suptm es tecnico.jpg', '../uploads/suptm es tecnico.jpg'),
(2, 'Captura de pantalla 2025-08-26 164454.png', '../uploads/Captura de pantalla 2025-08-26 164454.png'),
(3, 'Captura de pantalla 2025-08-29 182940.png', '../uploads/Captura de pantalla 2025-08-29 182940.png'),
(4, 'Captura de pantalla 2025-09-12 190621.png', '../uploads/Captura de pantalla 2025-09-12 190621.png'),
(5, 'Captura de pantalla 2025-08-29 223810.png', '../uploads/Captura de pantalla 2025-08-29 223810.png'),
(6, 'Captura de pantalla 2025-10-08 132015.png', '../uploads/Captura de pantalla 2025-10-08 132015.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permiso`
--

CREATE TABLE `permiso` (
  `idPermiso` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `Id_Producto` int(11) NOT NULL,
  `Nombre` varchar(100) NOT NULL,
  `Cantidad` int(11) DEFAULT 0,
  `Descripcion` varchar(255) DEFAULT NULL,
  `Marca` varchar(50) DEFAULT NULL,
  `Categoria` varchar(50) DEFAULT NULL,
  `Precio` decimal(15,2) NOT NULL,
  `Id_Imagen` int(11) DEFAULT NULL,
  `Fecha_Ven` datetime DEFAULT NULL,
  `Token` varchar(6) DEFAULT NULL,
  `TokenVencimiento` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`Id_Producto`, `Nombre`, `Cantidad`, `Descripcion`, `Marca`, `Categoria`, `Precio`, `Id_Imagen`, `Fecha_Ven`, `Token`, `TokenVencimiento`) VALUES
(1, 'aa', 2, '12', 'Sin marca', 'juguetes', 12.00, 1, '2025-10-06 13:53:46', NULL, NULL),
(2, 'ssss', 11, 'd', 'Sin marca', 'accesorios', 123.00, 2, '2025-10-06 15:05:45', NULL, NULL),
(3, 'zzz', 23, 'g', 'Sin marca', 'comida', 41.00, 3, '2025-10-06 15:06:06', NULL, NULL),
(4, 'rossi', 16, '123123', 'Sin marca', 'comida', 51.00, 4, '2025-10-08 12:26:35', NULL, NULL),
(5, 'asdasdasd', 123, 'asdasd', 'Sin marca', 'juguetes', 235234.00, 5, '2025-10-08 13:20:35', NULL, NULL),
(6, 'suptm', 2323232, '123123', 'Sin marca', 'comida', 12312.00, 6, '2025-10-08 19:27:38', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `idRol` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`idRol`, `nombre`, `descripcion`) VALUES
(1, 'Cliente', 'Rol por defecto para usuarios registrados');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol_permisos`
--

CREATE TABLE `rol_permisos` (
  `idRol` int(11) NOT NULL,
  `idPermiso` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `Id_Usuario` int(11) NOT NULL,
  `Usuario` varchar(12) NOT NULL,
  `Correo` varchar(80) NOT NULL,
  `Contrasena` varchar(255) NOT NULL,
  `Rol` int(11) NOT NULL,
  `CambioContra` tinyint(4) DEFAULT 0,
  `FechaCambioContra` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`Id_Usuario`, `Usuario`, `Correo`, `Contrasena`, `Rol`, `CambioContra`, `FechaCambioContra`) VALUES
(2, 'ema242jaja', '', '$2y$10$6/3TB9N.Yp0voeoX1S6.Z.av.DcTNdjpbaDX5pyZMNYAXbmfSanZy', 1, 0, '2025-10-10 13:53:07'),
(4, 'fludx82', 'fludx82@test.com', '$2y$10$h27lcQBzbkH9JvEa7WDlnuD6OeSw1KqoglhpIXDklBckq75T4sCmu', 1, 0, '2025-10-10 14:14:21'),
(5, 'pelado', 'pelado@test.com', '$2y$10$VIoNUEpQBYxHr6rSORaLeux4Xynvz6uMzYt9WTZ9JElG2Aej4.PCK', 1, 0, '2025-10-10 16:09:05');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD PRIMARY KEY (`Id_Carrito`),
  ADD KEY `Id_Usuario` (`Id_Usuario`),
  ADD KEY `Id_Producto` (`Id_Producto`);

--
-- Indices de la tabla `historialcontrasenas`
--
ALTER TABLE `historialcontrasenas`
  ADD PRIMARY KEY (`Id_Historial`),
  ADD KEY `Id_Usuario` (`Id_Usuario`);

--
-- Indices de la tabla `imagen`
--
ALTER TABLE `imagen`
  ADD PRIMARY KEY (`Id_Imagen`);

--
-- Indices de la tabla `permiso`
--
ALTER TABLE `permiso`
  ADD PRIMARY KEY (`idPermiso`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`Id_Producto`),
  ADD KEY `Id_Imagen` (`Id_Imagen`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`idRol`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `rol_permisos`
--
ALTER TABLE `rol_permisos`
  ADD PRIMARY KEY (`idRol`,`idPermiso`),
  ADD KEY `idPermiso` (`idPermiso`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`Id_Usuario`),
  ADD UNIQUE KEY `Correo` (`Correo`),
  ADD KEY `Rol` (`Rol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `carrito`
--
ALTER TABLE `carrito`
  MODIFY `Id_Carrito` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT de la tabla `historialcontrasenas`
--
ALTER TABLE `historialcontrasenas`
  MODIFY `Id_Historial` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `imagen`
--
ALTER TABLE `imagen`
  MODIFY `Id_Imagen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `permiso`
--
ALTER TABLE `permiso`
  MODIFY `idPermiso` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `Id_Producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `idRol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `Id_Usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD CONSTRAINT `carrito_ibfk_1` FOREIGN KEY (`Id_Usuario`) REFERENCES `usuarios` (`Id_Usuario`),
  ADD CONSTRAINT `carrito_ibfk_2` FOREIGN KEY (`Id_Producto`) REFERENCES `productos` (`Id_Producto`);

--
-- Filtros para la tabla `historialcontrasenas`
--
ALTER TABLE `historialcontrasenas`
  ADD CONSTRAINT `historialcontrasenas_ibfk_1` FOREIGN KEY (`Id_Usuario`) REFERENCES `usuarios` (`Id_Usuario`) ON DELETE CASCADE;

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`Id_Imagen`) REFERENCES `imagen` (`Id_Imagen`) ON DELETE SET NULL;

--
-- Filtros para la tabla `rol_permisos`
--
ALTER TABLE `rol_permisos`
  ADD CONSTRAINT `rol_permisos_ibfk_1` FOREIGN KEY (`idRol`) REFERENCES `rol` (`idRol`) ON DELETE CASCADE,
  ADD CONSTRAINT `rol_permisos_ibfk_2` FOREIGN KEY (`idPermiso`) REFERENCES `permiso` (`idPermiso`) ON DELETE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`Rol`) REFERENCES `rol` (`idRol`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
