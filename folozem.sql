-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 01 juil. 2022 à 14:00
-- Version du serveur : 8.0.29
-- Version de PHP : 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `folozem`
--

-- --------------------------------------------------------

--
-- Structure de la table `etudiant`
--

CREATE TABLE `etudiant` (
  `noEtudiant` int NOT NULL,
  `nom` varchar(20) NOT NULL,
  `prenom` varchar(20) NOT NULL,
  `premiereAnnee` tinyint(1) NOT NULL,
  `optionSLAM` tinyint(1) DEFAULT NULL,
  `semAbandon` int DEFAULT NULL,
  `anneeArrivee` int NOT NULL,
  `departement` varchar(3) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `alternance` tinyint(1) NOT NULL,
  `reussiteBTS` int DEFAULT NULL,
  `sexe` tinyint(1) NOT NULL DEFAULT '1',
  `redoublantPremAnnee` tinyint(1) DEFAULT NULL,
  `idOption#` int NOT NULL,
  `idSortie#` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `etudiant`
--



-- --------------------------------------------------------

--
-- Structure de la table `motDePasses`
--

CREATE TABLE `motDePasses` (
  `cleacces` varchar(64) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `motDePasses`
--


-- --------------------------------------------------------

--
-- Structure de la table `options`
--

CREATE TABLE `options` (
  `idOption` int NOT NULL,
  `nomOption` varchar(30) NOT NULL,
  `idOrigine#` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `options`
--


-- --------------------------------------------------------

--
-- Structure de la table `origine`
--

CREATE TABLE `origine` (
  `idOrigine` int NOT NULL,
  `nomOrigine` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `origine`
--



-- --------------------------------------------------------

--
-- Structure de la table `Sortie`
--

CREATE TABLE `Sortie` (
  `idSortie` int NOT NULL,
  `labelSortie` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `Sortie`
--

INSERT INTO `Sortie` (`idSortie`, `labelSortie`) VALUES
(6, 'licence ou master'),
(7, 'licence pro ou certification RNCP'),
(8, 'réorientation'),
(9, 'activité professionnelle'),
(10, 'sans activité');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `etudiant`
--
ALTER TABLE `etudiant`
  ADD PRIMARY KEY (`noEtudiant`),
  ADD KEY `options` (`idOption#`),
  ADD KEY `sortie` (`idSortie#`) USING BTREE;

--
-- Index pour la table `motDePasses`
--
ALTER TABLE `motDePasses`
  ADD PRIMARY KEY (`cleacces`);

--
-- Index pour la table `options`
--
ALTER TABLE `options`
  ADD PRIMARY KEY (`idOption`),
  ADD KEY `origine` (`idOrigine#`);

--
-- Index pour la table `origine`
--
ALTER TABLE `origine`
  ADD PRIMARY KEY (`idOrigine`);

--
-- Index pour la table `Sortie`
--
ALTER TABLE `Sortie`
  ADD PRIMARY KEY (`idSortie`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `options`
--
ALTER TABLE `options`
  MODIFY `idOption` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `origine`
--
ALTER TABLE `origine`
  MODIFY `idOrigine` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `Sortie`
--
ALTER TABLE `Sortie`
  MODIFY `idSortie` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `etudiant`
--
ALTER TABLE `etudiant`
  ADD CONSTRAINT `options` FOREIGN KEY (`idOption#`) REFERENCES `options` (`idOption`);

--
-- Contraintes pour la table `options`
--
ALTER TABLE `options`
  ADD CONSTRAINT `origine` FOREIGN KEY (`idOrigine#`) REFERENCES `origine` (`idOrigine`);


  ALTER TABLE `etudiant`
  ADD CONSTRAINT `Sortie` FOREIGN KEY (`idSortie#`) REFERENCES `options` (`idSortie`);

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
