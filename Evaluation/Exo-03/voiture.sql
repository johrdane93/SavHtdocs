-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Mer 12 Juillet 2017 à 14:42
-- Version du serveur :  10.1.13-MariaDB
-- Version de PHP :  5.6.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `voiture`
--

-- --------------------------------------------------------

--
-- Structure de la table `roulroul`
--

CREATE TABLE `roulroul` (
  `marque` varchar(50) NOT NULL,
  `modele` varchar(50) NOT NULL,
  `years` varchar(4) NOT NULL,
  `couleur` varchar(50) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `roulroul`
--

INSERT INTO `roulroul` (`marque`, `modele`, `years`, `couleur`, `id`) VALUES
('Dacia', 'Vroum', '1991', 'Bleue', 1),
('Dacia', 'Vroum', '1991', 'Bleue', 2),
('Dacia', 'Vroum', '1991', 'Bleue', 3);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `roulroul`
--
ALTER TABLE `roulroul`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `roulroul`
--
ALTER TABLE `roulroul`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
