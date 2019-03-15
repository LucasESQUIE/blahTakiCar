-- phpMyAdmin SQL Dump
-- version 4.5.4.1
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Ven 15 Mars 2019 à 10:09
-- Version du serveur :  5.7.11
-- Version de PHP :  5.6.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `blahtakicarv2`
--

-- --------------------------------------------------------

--
-- Structure de la table `trajet`
--

CREATE TABLE `trajet` (
  `idTrajet` int(5) NOT NULL,
  `villeDep` varchar(25) NOT NULL,
  `villeEtape` text,
  `villeArr` varchar(25) NOT NULL,
  `heureDep` varchar(5) NOT NULL,
  `dateDep` date NOT NULL,
  `nbPassagers` int(2) NOT NULL,
  `prix` int(2) DEFAULT '0',
  `immaVoiture` char(9) DEFAULT NULL,
  `idConducteur` varchar(70) NOT NULL,
  `idPassagers` text,
  `plein` tinyint(1) NOT NULL,
  `commentaires` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `trajet`
--

INSERT INTO `trajet` (`idTrajet`, `villeDep`, `villeEtape`, `villeArr`, `heureDep`, `dateDep`, `nbPassagers`, `prix`, `immaVoiture`, `idConducteur`, `idPassagers`, `plein`, `commentaires`) VALUES
(1, 'Rodez', NULL, 'Toulouse', '17h05', '2019-03-02', 9, 5, 'EL251WE', 'laura.duphil@iut-rodez.fr', 'clement.maurin@iut-rodez.fr;', 0, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec ut dui eu eros gravida tincidunt quis sed ante. Curabitur sem libero, eleifend sit amet feugiat mattis, elementum at lacus. '),
(2, 'Toulouse', NULL, 'Rodez', '10h00', '2019-03-01', 8, 5, 'EL251WE', 'laura.duphil@iut-rodez.fr', 'clement.maurin@iut-rodez.fr;test@iut-rodez.fr;', 0, NULL),
(3, 'Mazamet', ';', 'Castres', '15h15', '2019-03-15', 3, 0, NULL, 'theo.gutierrez@iut-rodez.fr', NULL, 0, ''),
(4, 'Castres', ';', 'Mazamet', '15h15', '2019-03-16', 3, 0, NULL, 'theo.gutierrez@iut-rodez.fr', NULL, 0, '');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `mailUtilisateur` varchar(70) NOT NULL,
  `role` tinyint(4) NOT NULL DEFAULT '0',
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `numTel` char(10) DEFAULT NULL,
  `filiere` varchar(20) NOT NULL,
  `photoUtilisateur` varchar(60) DEFAULT NULL,
  `mdp` varchar(255) NOT NULL,
  `cleconfirm` varchar(255) NOT NULL,
  `confirme` tinyint(1) NOT NULL DEFAULT '0',
  `immaVoiture` char(9) DEFAULT NULL,
  `marqueVoiture` varchar(25) DEFAULT NULL,
  `modeleVoiture` varchar(25) DEFAULT NULL,
  `couleurVoiture` varchar(25) DEFAULT NULL,
  `photoVoiture` varchar(80) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `utilisateur`
--

INSERT INTO `utilisateur` (`mailUtilisateur`, `role`, `nom`, `prenom`, `numTel`, `filiere`, `photoUtilisateur`, `mdp`, `cleconfirm`, `confirme`, `immaVoiture`, `marqueVoiture`, `modeleVoiture`, `couleurVoiture`, `photoVoiture`) VALUES
('clement.maurin@iut-rodez.fr', 0, 'maurin', 'clement', '0647206097', 'informatique', NULL, 'Mdp12345', '', 1, NULL, '', '', '', ''),
('laura.duphil@iut-rodez.fr', 0, 'Duphil', 'Laura', '0686065454', 'informatique', NULL, 'Mdp12345', '', 1, 'EL251WE', '', '', '', ''),
('lucas.esquie-fayolle@iut-rodez.fr', 1, 'Esquié-Fayolle', 'Lucas', '0635284660', 'Informatique', NULL, '$2y$12$7ZMwDO5eOA2XgRfX7GNe7.UdlD7FK6/oRGrgV8v3uIjrHrg/a84ni', '28348779465775', 1, NULL, NULL, NULL, NULL, NULL),
('test@iut-rodez.fr', 0, 'Test', 'Test', '0635284660', 'Informatique', NULL, '$2y$12$yINwArNDmv.jgkhQnlUX5OarKfKZH/pKnX8nN4oNHNeGZrFqCobJW', '12393551342332', 0, NULL, NULL, NULL, NULL, NULL),
('theo.gutierrez@iut-rodez.fr', 0, 'Gutierrez', 'Théo', '0612543212', 'Informatique', NULL, '$2y$12$UvEmw0ecXIIC57K3jU5AFucIAV94cpYXi3gnW.KOnodzeEQMldYVO', '23737110110707', 1, NULL, NULL, NULL, NULL, NULL);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `trajet`
--
ALTER TABLE `trajet`
  ADD PRIMARY KEY (`idTrajet`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`mailUtilisateur`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `trajet`
--
ALTER TABLE `trajet`
  MODIFY `idTrajet` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
