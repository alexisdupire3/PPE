-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 29 avr. 2021 à 20:08
-- Version du serveur :  5.7.31
-- Version de PHP : 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `hopital`
--

-- --------------------------------------------------------

--
-- Structure de la table `chambre`
--

DROP TABLE IF EXISTS `chambre`;
CREATE TABLE IF NOT EXISTS `chambre` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `num_chambre` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `chambre`
--

INSERT INTO `chambre` (`id`, `num_chambre`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20201119093021', '2020-11-19 09:30:38', 57),
('DoctrineMigrations\\Version20201214165849', '2020-12-15 10:55:06', 262),
('DoctrineMigrations\\Version20201214170243', '2020-12-15 10:55:07', 136),
('DoctrineMigrations\\Version20201214170628', '2020-12-15 10:55:07', 51),
('DoctrineMigrations\\Version20201214171550', '2020-12-15 10:55:07', 6),
('DoctrineMigrations\\Version20201214173354', '2020-12-15 10:55:07', 563),
('DoctrineMigrations\\Version20201214174311', '2020-12-15 10:55:07', 95),
('DoctrineMigrations\\Version20201215174141', '2020-12-15 17:41:58', 100),
('DoctrineMigrations\\Version20210307185816', '2021-03-07 18:58:32', 124);

-- --------------------------------------------------------

--
-- Structure de la table `lit`
--

DROP TABLE IF EXISTS `lit`;
CREATE TABLE IF NOT EXISTS `lit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `num_chambre_id` int(11) NOT NULL,
  `num_lit` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_5DDB8E9D14003FDF` (`num_chambre_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `patient`
--

DROP TABLE IF EXISTS `patient`;
CREATE TABLE IF NOT EXISTS `patient` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `patient`
--

INSERT INTO `patient` (`id`, `nom`, `prenom`, `telephone`) VALUES
(1, 'collot', 'yoann', '0000000000');

-- --------------------------------------------------------

--
-- Structure de la table `rdv`
--

DROP TABLE IF EXISTS `rdv`;
CREATE TABLE IF NOT EXISTS `rdv` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_patient_id` int(11) NOT NULL,
  `id_medecin_id` int(11) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_10C31F86CE0312AE` (`id_patient_id`),
  KEY `IDX_10C31F86A1799A53` (`id_medecin_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `sejour`
--

DROP TABLE IF EXISTS `sejour`;
CREATE TABLE IF NOT EXISTS `sejour` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_patient_id` int(11) NOT NULL,
  `numero_lit_id` int(11) DEFAULT NULL,
  `date_arrive` datetime NOT NULL,
  `date_sortie` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_96F52028CE0312AE` (`id_patient_id`),
  KEY `IDX_96F520287F4C436D` (`numero_lit_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json)',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D64924A232CF` (`user_name`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `user_name`, `roles`, `password`, `nom`, `prenom`) VALUES
(8, 'admin', '[\"ROLE_ADMIN\"]', '$argon2id$v=19$m=65536,t=4,p=1$QVdkWW9xd2Q5dkhEMkFqQQ$1dLiWI8Ityt0JofuE8fmo7BjjzEBNJfQEtuJq4devv0', 'admin', 'admin'),
(9, 'infirmier', '[\"ROLE_INFIRMIER\"]', '$argon2id$v=19$m=65536,t=4,p=1$RGJqeEE1bFBaQUp1aTBJMQ$CPvV3NhNUrwTI/VOuMFQSWfpyiHh3FDzD66qUrTHUoo', 'infirmier', 'infirmier'),
(10, 'administratif', '[\"ROLE_ADMINISTRATIF\"]', '$argon2id$v=19$m=65536,t=4,p=1$ZUNFb1duY2VZejZSblUzMA$urnkq5060JSVrjtttCRhx/QmAp/iikyCZj2p8Og3fSo', 'administratif', 'administratif');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `lit`
--
ALTER TABLE `lit`
  ADD CONSTRAINT `FK_5DDB8E9D14003FDF` FOREIGN KEY (`num_chambre_id`) REFERENCES `chambre` (`id`);

--
-- Contraintes pour la table `rdv`
--
ALTER TABLE `rdv`
  ADD CONSTRAINT `FK_10C31F86A1799A53` FOREIGN KEY (`id_medecin_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_10C31F86CE0312AE` FOREIGN KEY (`id_patient_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `sejour`
--
ALTER TABLE `sejour`
  ADD CONSTRAINT `FK_96F520287F4C436D` FOREIGN KEY (`numero_lit_id`) REFERENCES `lit` (`id`),
  ADD CONSTRAINT `FK_96F52028CE0312AE` FOREIGN KEY (`id_patient_id`) REFERENCES `patient` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
