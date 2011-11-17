-- phpMyAdmin SQL Dump
-- version 3.4.7
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le : Jeu 17 Novembre 2011 à 01:48
-- Version du serveur: 5.5.16
-- Version de PHP: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `fiches_eval`
--

-- --------------------------------------------------------

--
-- Structure de la table `commentaire`
--

CREATE TABLE IF NOT EXISTS `commentaire` (
  `idEtudiant` int(11) NOT NULL,
  `codeApogee` varchar(16) NOT NULL,
  `idSection` int(11) NOT NULL,
  `date` varchar(9) NOT NULL,
  `commentaire` text,
  PRIMARY KEY (`idEtudiant`,`codeApogee`,`idSection`,`date`),
  KEY `codeApogee` (`codeApogee`),
  KEY `idSection` (`idSection`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `enseignant`
--

CREATE TABLE IF NOT EXISTS `enseignant` (
  `idEnseignant` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  PRIMARY KEY (`idEnseignant`),
  UNIQUE KEY `idEnseignant` (`idEnseignant`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `etudiant`
--

CREATE TABLE IF NOT EXISTS `etudiant` (
  `idEtudiant` int(11) NOT NULL,
  `idPassword` int(11) NOT NULL,
  `groupeCM` int(11) NOT NULL,
  `groupeTD` int(11) NOT NULL,
  `groupeTP` int(11) NOT NULL,
  `delegue` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idEtudiant`),
  KEY `idPassword` (`idPassword`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `matiere`
--

CREATE TABLE IF NOT EXISTS `matiere` (
  `codeApogee` varchar(16) NOT NULL,
  `intitule` varchar(255) NOT NULL,
  `nbGroupeCM` int(11) NOT NULL,
  `nbGroupeTD` int(11) NOT NULL,
  `nbGroupeTP` int(11) NOT NULL,
  PRIMARY KEY (`codeApogee`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `matiere`
--

INSERT INTO `matiere` (`codeApogee`, `intitule`, `nbGroupeCM`, `nbGroupeTD`, `nbGroupeTP`) VALUES
('HR20AAD', 'AD', 1, 1, 1),
('HR20AAS', 'AS', 1, 1, 1),
('HR20AEP', 'EP', 1, 1, 1),
('HR20AIPP', 'IP', 1, 1, 1),
('HR20AIR', 'IR', 1, 1, 1),
('HR20GEG', 'Gestion', 1, 0, 0),
('HR20GLV', 'Langue vivante', 0, 3, 0),
('HR20GMOP', 'MO', 3, 0, 3),
('HR20MCL', 'CL', 1, 1, 1),
('HR20MIM', 'Mim', 1, 1, 1),
('HR20MSI', 'SI', 1, 1, 1),
('HR20MTS', 'TS', 1, 1, 1),
('HR20PGL', 'GL', 1, 2, 0),
('HR20SBD', 'BD', 1, 2, 2),
('HR20SSR', 'AR', 1, 2, 2),
('HR20TROP', 'RIM', 1, 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `option`
--

CREATE TABLE IF NOT EXISTS `option` (
  `codeApogee` varchar(16) NOT NULL,
  `intitule` varchar(16) NOT NULL,
  PRIMARY KEY (`codeApogee`,`intitule`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `password`
--

CREATE TABLE IF NOT EXISTS `password` (
  `idPassword` int(11) NOT NULL,
  `pwd` varchar(128) CHARACTER SET utf8 NOT NULL,
  `type` int(3) NOT NULL,
  PRIMARY KEY (`idPassword`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `question`
--

CREATE TABLE IF NOT EXISTS `question` (
  `idQuestion` int(11) NOT NULL,
  `section` int(11) NOT NULL,
  `texteQuestion` text NOT NULL,
  `resume` varchar(255) NOT NULL,
  PRIMARY KEY (`idQuestion`),
  KEY `section` (`section`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `question`
--

INSERT INTO `question` (`idQuestion`, `section`, `texteQuestion`, `resume`) VALUES
(1, 1, 'Estimez votre présence aux séances d''enseignement', 'Présence'),
(2, 1, 'Estimez votre participation active à l''enseignement', 'Participation'),
(3, 1, 'Estimez votre travail personnel permettant l''assimilation du cours', 'Travail personnel'),
(4, 1, 'Estimez votre réalisation du travail demandé', 'Travail demandé'),
(5, 2, 'Quel est votre avis sur la qualité des documents écrits (polycopiés, bibliographie...)', 'Qualité documents'),
(6, 2, 'Quel est votre avis sur la qualité et la gestion des supports (tableau, transparents, vidéos...)', 'Qualité supports'),
(7, 2, 'Les conditions matérielles (salles, équipements,...) vous paraissent-elles suffisantes ?', 'Conditions matérielles'),
(8, 3, 'Les objectifs et le programme ont-ils été clairement définis et expliqués ?', 'Objectifs?'),
(9, 3, 'Présence et respect d''un plan', 'Plan'),
(10, 3, 'Cohérence CM/TD/TP', 'Cohérence CM/TD/TP'),
(11, 3, 'Complémentarité par rapport aux autres disciplines', 'Complémentarité'),
(12, 3, 'Apport de connaissances nouvelles', 'Connaissances nouvelles'),
(13, 3, 'Votre niveau vous semble-t-il adapté pour suivre le cours ?', 'Niveau élève suffisant'),
(14, 3, 'Etes-vous globalement satisfait du cours ?', 'Satisfaction'),
(15, 4, 'Structuration des exposés oraux', 'Structuration exposés'),
(16, 4, 'Clarté du propos', 'Clarté'),
(17, 4, 'Rythme de progression du cours', 'Rythme de progression'),
(18, 4, 'Réponse aux questions des étudiants', 'Réponses aus questions'),
(19, 4, 'L''enseignant vous paraît-il suffisamment disponible : rencontres, réponses à vos questions ?', 'Disponibilité');

-- --------------------------------------------------------

--
-- Structure de la table `reponse`
--

CREATE TABLE IF NOT EXISTS `reponse` (
  `idEtudiant` int(11) NOT NULL,
  `codeApogee` varchar(16) NOT NULL,
  `idQuestion` int(11) NOT NULL,
  `reponse` int(11) DEFAULT NULL,
  `date` varchar(9) NOT NULL,
  PRIMARY KEY (`idEtudiant`,`codeApogee`,`idQuestion`,`date`),
  KEY `codeApogee` (`codeApogee`),
  KEY `idQuestion` (`idQuestion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

CREATE TABLE IF NOT EXISTS `role` (
  `codeApogee` varchar(16) NOT NULL,
  `idEnseignant` int(11) NOT NULL,
  `date` varchar(9) NOT NULL DEFAULT '',
  `CM` tinyint(1) NOT NULL,
  `TD` tinyint(1) NOT NULL,
  `TP` tinyint(1) NOT NULL,
  PRIMARY KEY (`codeApogee`,`idEnseignant`,`date`),
  KEY `idEnseignant` (`idEnseignant`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `section`
--

CREATE TABLE IF NOT EXISTS `section` (
  `idSection` int(11) NOT NULL,
  `nomSection` varchar(255) NOT NULL,
  PRIMARY KEY (`idSection`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `section`
--

INSERT INTO `section` (`idSection`, `nomSection`) VALUES
(1, 'Implication de l''élève'),
(2, 'Organisation et Documentation'),
(3, 'Contenu'),
(4, 'Pédagogie');

-- --------------------------------------------------------

--
-- Structure de la table `synthese`
--

CREATE TABLE IF NOT EXISTS `synthese` (
  `idSection` int(11) NOT NULL,
  `codeApogee` varchar(16) NOT NULL,
  `date` varchar(9) NOT NULL,
  `commentaire` text,
  PRIMARY KEY (`idSection`,`codeApogee`,`date`),
  KEY `codeApogee` (`codeApogee`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `commentaire`
--
ALTER TABLE `commentaire`
  ADD CONSTRAINT `commentaire_ibfk_1` FOREIGN KEY (`idEtudiant`) REFERENCES `etudiant` (`idEtudiant`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `commentaire_ibfk_2` FOREIGN KEY (`codeApogee`) REFERENCES `matiere` (`codeApogee`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `commentaire_ibfk_3` FOREIGN KEY (`idSection`) REFERENCES `section` (`idSection`);

--
-- Contraintes pour la table `option`
--
ALTER TABLE `option`
  ADD CONSTRAINT `option_ibfk_1` FOREIGN KEY (`codeApogee`) REFERENCES `matiere` (`codeApogee`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `question`
--
ALTER TABLE `question`
  ADD CONSTRAINT `question_ibfk_1` FOREIGN KEY (`section`) REFERENCES `section` (`idSection`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Contraintes pour la table `reponse`
--
ALTER TABLE `reponse`
  ADD CONSTRAINT `reponse_ibfk_1` FOREIGN KEY (`idEtudiant`) REFERENCES `etudiant` (`idEtudiant`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `reponse_ibfk_2` FOREIGN KEY (`codeApogee`) REFERENCES `matiere` (`codeApogee`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `reponse_ibfk_3` FOREIGN KEY (`idQuestion`) REFERENCES `question` (`idQuestion`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `role`
--
ALTER TABLE `role`
  ADD CONSTRAINT `role_ibfk_3` FOREIGN KEY (`codeApogee`) REFERENCES `matiere` (`codeApogee`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `role_ibfk_4` FOREIGN KEY (`idEnseignant`) REFERENCES `enseignant` (`idEnseignant`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `synthese`
--
ALTER TABLE `synthese`
  ADD CONSTRAINT `synthese_ibfk_1` FOREIGN KEY (`idSection`) REFERENCES `section` (`idSection`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `synthese_ibfk_2` FOREIGN KEY (`codeApogee`) REFERENCES `matiere` (`codeApogee`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
