-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Temps de generació: 14-11-2022 a les 13:51:02
-- Versió del servidor: 10.4.24-MariaDB
-- Versió de PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de dades: `truiter`
--

-- --------------------------------------------------------

--
-- Estructura de la taula `media`
--

CREATE TABLE `media` (
  `id` int(11) NOT NULL,
  `alt_text` text COLLATE utf8mb4_spanish2_ci NOT NULL,
  `height` int(11) NOT NULL,
  `width` int(11) NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de la taula `tweet`
--

CREATE TABLE `tweet` (
  `id` int(11) NOT NULL,
  `text` text COLLATE utf8mb4_spanish2_ci NOT NULL,
  `created_at` date NOT NULL,
  `like_count` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `media_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Bolcament de dades per a la taula `tweet`
--

INSERT INTO `tweet` (`id`, `text`, `created_at`, `like_count`, `user_id`, `media_id`) VALUES
(6, 'Por la cerveza: causa y solución de todos los problemas', '2022-11-14', 0, 10, NULL),
(7, 'Si algo hemos aprendido de los Picapiedra es que los pelícanos sirven para mezclar cemento', '2022-11-14', 0, 9, NULL),
(8, '¡Ay, caramba!', '2022-11-14', 0, 10, NULL);

-- --------------------------------------------------------

--
-- Estructura de la taula `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `username` varchar(15) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `created_at` date NOT NULL,
  `verified` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Bolcament de dades per a la taula `user`
--

INSERT INTO `user` (`id`, `name`, `username`, `password`, `created_at`, `verified`) VALUES
(9, 'Homer', 'homero', '$2y$10$zI3OS2WFmrSBnGQzMWTfmuDi3Z/HFIe/lRAuWWMYj6aB9EpbDwjEO', '2022-11-14', 0),
(10, 'Bart', 'bartolomeo', '$2y$10$zeQt1VL9WAkMEobfy7P1FeUQ70hR3TjVUFQfUFllL8IYMyanxG8kK', '2022-11-14', 0);

--
-- Índexs per a les taules bolcades
--

--
-- Índexs per a la taula `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`);

--
-- Índexs per a la taula `tweet`
--
ALTER TABLE `tweet`
  ADD PRIMARY KEY (`id`),
  ADD KEY `media_id` (`media_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Índexs per a la taula `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT per les taules bolcades
--

--
-- AUTO_INCREMENT per la taula `media`
--
ALTER TABLE `media`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la taula `tweet`
--
ALTER TABLE `tweet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT per la taula `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Restriccions per a les taules bolcades
--

--
-- Restriccions per a la taula `tweet`
--
ALTER TABLE `tweet`
  ADD CONSTRAINT `media_id` FOREIGN KEY (`media_id`) REFERENCES `media` (`id`),
  ADD CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
