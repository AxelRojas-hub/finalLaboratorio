SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE DATABASE IF NOT EXISTS `memoria` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `memoria`;

DROP TABLE IF EXISTS `estadisticas_partida`;
CREATE TABLE IF NOT EXISTS `estadisticas_partida` (
  `partida_id` int NOT NULL,
  `usuario_id` int NOT NULL,
  `aciertos` int DEFAULT '0',
  `intentos` int DEFAULT '0',
  `puntos_obtenidos` int DEFAULT '0',
  PRIMARY KEY (`partida_id`,`usuario_id`),
  KEY `usuario_id` (`usuario_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS `partidas`;
CREATE TABLE IF NOT EXISTS `partidas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `jugador1_id` int NOT NULL,
  `jugador2_id` int NOT NULL,
  `ganador_id` int DEFAULT NULL,
  `fecha` datetime DEFAULT CURRENT_TIMESTAMP,
  `dificultad` enum('facil','intermedio','dificil') NOT NULL,
  `tipo_cartas` enum('futbol','basquet','juegos') NOT NULL,
  `tiempo_maximo` int DEFAULT '0',
  `estado` enum('finished','forfeited','draw','time_expired') NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jugador1_id` (`jugador1_id`),
  KEY `jugador2_id` (`jugador2_id`),
  KEY `ganador_id` (`ganador_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre_usuario` varchar(50) NOT NULL,
  `hash_contraseña` varchar(255) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `pais` varchar(50) DEFAULT NULL,
  `puntaje` int DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `nombre_usuario` (`nombre_usuario`),
  UNIQUE KEY `correo` (`correo`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `usuarios` (`id`, `nombre_usuario`, `hash_contraseña`, `correo`, `pais`, `puntaje`) VALUES
(13, 'Kevin', '$2y$10$.3Ph3YSV4jvM5fSLmfMmHOolfzCYFsuqtZ75xYo/jWsLH0jyVpmpC', 'kevin@gmail.com', 'Argentina', 0),
(12, 'Axel', '$2y$10$l8WvwUfD0rKev8ul7KYoDuBN/KFpLIKhW.nF7gx67ZpmPtD4Omugm', 'axel@gmail.com', 'Argentina', 0),
(21, 'nicolas', '$2y$10$IhWnOciaoKXM6b1mJ91gw.l3XfIzM0dbKbLgScvmO98C0rV2mKomu', 'pene@gmail.com', 'argentina', 0),
(22, 'ana10', '$2y$10$zBA4tJNNIFHv.TdPy2rVFe/n/WxRAcCZdZcLI.UpzSB/GAmQxlUKu', 'ana@mail.com', 'argentina', 0);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
