-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: proxysql-01.dd.scip.local
-- Tiempo de generación: 05-12-2024 a las 21:18:48
-- Versión del servidor: 10.10.2-MariaDB-1:10.10.2+maria~deb11
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `ddb237716`
--
CREATE DATABASE IF NOT EXISTS `ddb237716` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `ddb237716`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personatges`
--

CREATE TABLE IF NOT EXISTS `personatges` (
  `id_personatge` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(30) NOT NULL,
  `cos` varchar(100) NOT NULL,
  `usuari_id` int(11) NOT NULL,
  PRIMARY KEY (`id_personatge`),
  KEY `usuari_id` (`usuari_id`)
) ENGINE=InnoDB AUTO_INCREMENT=148 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `personatges`
--

INSERT INTO `personatges` (`id_personatge`, `nom`, `cos`, `usuari_id`) VALUES
(10, 'Roronoa Zoro', 'Un espadachín musculoso que aspira a ser el mejor del mundo.', 15),
(11, 'Nami', 'La navegante ágil con un talento excepcional para la cartografía y un amor por el tesoro.', 16),
(12, 'Usopp', 'Un francotirador delgado con una imaginación desbordante y un deseo de ser un gran guerrero.', 17),
(14, 'Tony Tony Chopper', 'Un pequeño reno que se convirtió en humano y es un talentoso médico.', 15),
(15, 'Nico Robin', 'La arqueóloga esbelta que busca desentrañar los secretos de la historia antigua.', 16),
(16, 'Franky', 'Un carpintero cyborg excéntrico que quiere construir el mejor barco del mundo.', 17),
(18, 'Trafalgar D. Water Law', 'Un médico pirata delgado con habilidades únicas y ambiciones desafiantes.', 15),
(20, 'Portgas D. Ace', 'El hermano de Luffy, un poderoso usuario del fuego que aspira a ser libre.', 15),
(21, 'Boa Hancock', 'La emperatriz de Amazon Lily, famosa por su belleza y su amor por Luffy.', 16),
(22, 'Kozuki Oden', 'Un antiguo samurái que sueña con un mundo lleno de libertad y aventuras.', 17),
(24, 'Bartholomew Kuma', 'Un antiguo miembro de los Shichibukai con el poder de la Fruta del Diablo que le permite mover objet', 15),
(25, 'Dracule Mihawk', 'El espadachín más fuerte del mundo, conocido por su habilidad y su imponente espada.', 16),
(26, 'Nefertari Vivi', 'La princesa de Arabasta que lucha por su pueblo y la paz en el mundo.', 17),
(27, 'Donquixote Doflamingo', 'Un villano carismático que manipula a otros y busca poder en el mundo subterráneo.', 15),
(28, 'Eustass Kid', 'Un capitán pirata con un carácter feroz y un fuerte deseo de fama y fortuna.', 16),
(29, 'Yamato', 'Hija de Kaido que busca unirse a Luffy y vivir aventuras.', 17),
(31, 'Smoker', 'Un marino que utiliza el poder del humo para capturar piratas.', 15),
(32, 'Toki', 'La mujer que puede enviar a otros a través del tiempo, con un gran deseo de proteger a su familia.', 16),
(33, 'Crocodile', 'Un ex Shichibukai con el poder de manipular la arena y un ambicioso plan para controlar el mundo.', 17),
(94, 'Monkey D. Luffy', 'Un joven pirata con habilidades de goma, determinado a convertirse en el Rey de los Piratas', 14),
(95, 'Sanji', 'Un cocinero elegante y luchador experto en el estilo de piernas negras', 14),
(96, 'Franky', 'Un ciborg con habilidades de ingeniería y un carácter extravagante', 14),
(97, 'Brook', 'Un esqueleto músico con habilidades de combate y un sentido del humor oscuro', 14),
(98, 'Jinbe', 'Un hombre pez fuerte y noble, maestro en artes marciales y con gran sentido de justicia', 15),
(101, 'Kizaru', 'Almirante de la Marina con el poder de la velocidad de la luz, capaz de moverse y atacar a velocidad', 16),
(102, 'Aokiji', 'Ex-Almirante de la Marina con el poder de crear y controlar hielo', 17),
(103, 'Akainu', 'Almirante de la Marina con el poder de magma, implacable y de carácter fuerte', 14),
(104, 'Big Mom', 'Una de los Yonkou, con el poder de manipular almas y una insaciable voracidad', 15),
(105, 'Kaido', 'Un Yonkou y el ser más fuerte del mundo, conocido por su apariencia imponente y fuerza brutal', 16),
(106, 'Enel', 'Dios autoproclamado de Skypiea con la habilidad de manipular la electricidad', 17),
(107, 'Crocodile', 'Un ex-Shichibukai con el poder de la arena y una ambición sin límites', 14),
(108, 'Marco', 'Primer comandante de los Piratas de Barbablanca y usuario de habilidades de regeneración como un ave', 15),
(109, 'Koby', 'Un joven y ambicioso oficial de la Marina, entrenado por Garp', 14),
(110, 'Helmeppo', 'Oficial de la Marina y compañero de Koby, ha crecido mucho desde sus días arrogantes', 15),
(111, 'Caesar Clown', 'Un científico loco y usuario de la fruta del gas, con una personalidad cruel', 16),
(112, 'Vergo', 'Un oficial encubierto del Donquixote Family en la Marina, con habilidades de endurecimiento', 17),
(114, 'Rebecca', 'Una gladiadora del Coliseo de Dressrosa que busca justicia para su familia', 15),
(115, 'Hajrudin', 'Un gigante y guerrero poderoso, líder de la flota de Luffy', 16),
(116, 'Bartolomeo', 'Un pirata excéntrico y fanático de Luffy, con el poder de crear barreras', 17),
(118, 'Diamante', 'Un oficial de la familia Donquixote, con habilidades de flexibilidad extrema', 15),
(119, 'Pica', 'Un oficial de la familia Donquixote con el poder de manipular piedra', 16),
(120, 'Sugar', 'Una niña miembro de la familia Donquixote, capaz de transformar a otros en juguetes', 17),
(121, 'Kin’emon', 'Un samurái del país de Wano con habilidades para disfrazarse y controlar fuego', 14),
(122, 'Kanjuro', 'Un samurái del país de Wano con habilidades para crear dibujos que cobran vida', 15),
(123, 'Raizo', 'Un ninja del país de Wano, aliado de los Sombrero de Paja', 16),
(124, 'Shinobu', 'Una kunoichi del país de Wano, experta en técnicas de infiltración', 17),
(125, 'Killer', 'El segundo al mando de los Piratas Kid, también conocido como “Asesino”', 14),
(126, 'Scratchmen Apoo', 'Un pirata músico con la habilidad de convertir sonidos en ataques', 15),
(127, 'Capone Bege', 'Capitán de los Piratas Fire Tank y estratega con poderes de “castillo humano”', 16),
(128, 'X Drake', 'Ex-contralmirante de la Marina convertido en pirata, usuario de una fruta zoan de dinosaurio', 17);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuaris`
--

CREATE TABLE IF NOT EXISTS `usuaris` (
  `id_usuari` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(30) NOT NULL,
  `cognoms` varchar(100) NOT NULL,
  `correu` varchar(100) DEFAULT NULL,
  `usuari` varchar(30) NOT NULL,
  `contrasenya` varchar(255) NOT NULL,
  `imatge` varchar(200) DEFAULT NULL,
  `administrador` int(11) NOT NULL,
  `token` varchar(200) NOT NULL,
  `token_time` int(11) NOT NULL,
  `autentificacio` varchar(250) NOT NULL,
  PRIMARY KEY (`id_usuari`),
  UNIQUE KEY `usuari` (`usuari`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuaris`
--

INSERT INTO `usuaris` (`id_usuari`, `nom`, `cognoms`, `correu`, `usuari`, `contrasenya`, `imatge`, `administrador`, `token`, `token_time`, `autentificacio`) VALUES
(14, 'Alba', 'Matamoros', 'a.matamoros@sapalomera.cat', 'amatamoros', '$2y$10$wKAh4LyfUgejPvi9f5SaXewdlODqjrkIDBlXKXXUt6HjJU3O6zdNW', '../vista/imatges/imatgesUsers/67520b1d72651_0c954310e36e5130f4446eaf188079de.jpg', 1, '6ffe0ad884bb1e380fe64b8227ae32c7e1b86916e63ccb66881934a50278d9f7355f0a01ffc4403c636e6280f606c53d7be6', 1733270150, ''),
(15, 'Pedro', 'Pica', 'p.pica@sapalomera.cat', 'ppica', '$2y$10$T4wMuW7uKVd2BtQRn2v5w.4eKFr875zm33cVPFrvtXDoRvpqVKj1i', NULL, 0, '', 0, ''),
(16, 'Piter', 'Pan', 'p.pan@sapalomera.cat', 'ppan', '$2y$10$jYKa2jKaqXhAI0spRNp6eOV97H/XH6UfIV4t3UwGiI773kMI7HWAm', NULL, 0, '', 0, ''),
(17, 'mary', 'Jane', 'm.jane@sapalomera.cat', 'mjane', '$2y$10$.7q0zRTlaRctCHAqEgEk1.9kHXXXXZW/QMykfZ5xgHlfL9RBaKzxO', NULL, 1, '', 0, ''),
(19, 'Joselito', 'flores', 'joslinsuria@gmail.com', 'Joselitoflores', '$2y$10$TBGiy2IEABgNPv0UK/AL9eJXixRdnNfqrQZJKsx3ewbef1rYmQ/eG', NULL, 0, '', 0, ''),
(23, 'Àlex', 'González', 'alexpalafolls2002@gmail.com', 'KottaAG', '$2y$10$9ksL2cSbZhQoGE7gYmUqdOr1d9mH69kZbF5OLeUX6ZjpmBbJWU17O', NULL, 0, '57289e2079256f5f91672b8ff05006191669c8ff24918cd1271d15802bad9aaee22319a9df01d1e269cc00097ae4e1799ccd', 1733270201, ''),
(24, 'pere', 'pi', 'perepi@gmail.com', 'perepi', '$2y$10$Chfq2Eff7fDSoWHMnUKALu5ErUiLUMnrS2KNm8quXWBeK4YPA/LTq', NULL, 0, '', 0, ''),
(28, 'Pau', 'Munoz', 'munozserrap@gmail.com', 'XinLu85', '$2y$10$Wy0Hip2o7.IlS2Qon5VD4.8V3Ao3TywnHWM6N2WDHpZoZdCTrIi7O', '../vista/imatges/imatgesUsers/674f2390480e9_background.jpg', 0, '9ad13a1cc5f7c31946805a2cac2081155a775145f030fd68ee0d6b6403a41b8b42cf40389479c01847e7d07883cef8c1d772', 1733253931, ''),
(31, 'Marcos', ' Lopez', 'marrkitus@gmail.com', 'Marrkitus', '$2y$10$f4sXWCWGtUwjusWmnJn9EOJoftFj4G1/SfDHITdYQemUqlbINWGFe', '../vista/imatges/imatgesUsers/674dc469219b9_7b76dba0e362be7f0ccdfdaae65f6a73.jpg', 0, '', 0, ''),
(32, 'Marcos', 'Lopez', 'm.lopez5@sapalomera.cat', 'Marrkitus2', '$2y$10$Y632S7rnfS18Pu4EnJY9rOKwrKAJ/79sBiq4vflTbegz3N9SpH/CC', NULL, 0, 'd09827fcf1bdaa7d7a412c470e61b304670ff81b49d52f16b18bbd8e702b5455f0ddc85c89a6d1ce497f7585ea3472a355b4', 1733153534, ''),
(35, '', '', NULL, 'MATI_712', '', NULL, 0, '', 0, 'Reddit'),
(36, '', '', NULL, 'Aromatic_Ad5332', '', NULL, 0, '', 0, 'Reddit'),
(38, 'Alba', 'Matamoros Morales', 'matamorosmoralesalba@gmail.com', 'matamorosmoralesalba', '', NULL, 0, '', 0, 'Google'),
(41, 'Alba', 'Matamoros Morales', 'albamamo07@gmail.com', 'albamamo07', '', NULL, 0, '', 0, 'Google');

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `personatges`
--
ALTER TABLE `personatges`
  ADD CONSTRAINT `personatges_ibfk_1` FOREIGN KEY (`usuari_id`) REFERENCES `usuaris` (`id_usuari`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
