-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Lun 08 Février 2016 à 16:53
-- Version du serveur :  10.1.8-MariaDB
-- Version de PHP :  5.6.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `myyelp`
--

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE `categorie` (
  `id_categorie` int(10) UNSIGNED NOT NULL,
  `nom_categorie` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `codepostale`
--

CREATE TABLE `codepostale` (
  `id_codePostale` int(10) UNSIGNED NOT NULL,
  `cp_codePotale` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `invitation`
--

CREATE TABLE `invitation` (
  `id_invitation` int(10) UNSIGNED NOT NULL,
  `email_invitation` varchar(255) NOT NULL,
  `inviteCode_invitation` varchar(32) NOT NULL,
  `token_invitation` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `invitation`
--

INSERT INTO `invitation` (`id_invitation`, `email_invitation`, `inviteCode_invitation`, `token_invitation`) VALUES
(1, 'ajxa@gm.com', '9o171zv2wm', '0');

-- --------------------------------------------------------

--
-- Structure de la table `lieu`
--

CREATE TABLE `lieu` (
  `id_lieu` int(10) UNSIGNED NOT NULL,
  `nom_lieu` varchar(256) NOT NULL,
  `adresse_lieu` varchar(255) DEFAULT NULL,
  `ville_id_ville` int(10) UNSIGNED NOT NULL,
  `description_lieu` text,
  `codePostale_id_codePostale` int(10) UNSIGNED NOT NULL,
  `categorie_id_categorie` int(10) UNSIGNED NOT NULL,
  `lati_lieu` float NOT NULL,
  `long_lieu` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `lieu`
--

INSERT INTO `lieu` (`id_lieu`, `nom_lieu`, `adresse_lieu`, `ville_id_ville`, `description_lieu`, `codePostale_id_codePostale`, `categorie_id_categorie`, `lati_lieu`, `long_lieu`) VALUES
(1, '0', '105', 1, '0', 1, 1, 0, 0),
(2, '0', '105', 1, '1', 1, 1, 45.9005, 19.8876);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id_user` int(10) UNSIGNED NOT NULL,
  `email_user` varchar(256) DEFAULT NULL,
  `password_user` varchar(256) DEFAULT NULL,
  `role_user` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id_user`, `email_user`, `password_user`, `role_user`) VALUES
(1, 'tot@tet.com', '$2y$10$wyTgpRhHfmbgcd5wbix32uaYXD4JeZYiKz1YdUn7BSQeWMrJDitMS', 'simple'),
(2, 'papy@t.com', '$2y$10$udyEqmSccAdSGgkIlr5T4ux5ZxDHtjeY8PLSzIIFsmy/V5qVLnmTS', 'simple');

-- --------------------------------------------------------

--
-- Structure de la table `ville`
--

CREATE TABLE `ville` (
  `id_ville` int(10) UNSIGNED NOT NULL,
  `nom_ville` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Index pour les tables exportées
--

--
-- Index pour la table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`id_categorie`);

--
-- Index pour la table `codepostale`
--
ALTER TABLE `codepostale`
  ADD PRIMARY KEY (`id_codePostale`);

--
-- Index pour la table `invitation`
--
ALTER TABLE `invitation`
  ADD PRIMARY KEY (`id_invitation`);

--
-- Index pour la table `lieu`
--
ALTER TABLE `lieu`
  ADD PRIMARY KEY (`id_lieu`),
  ADD KEY `lieu_FKIndex1` (`categorie_id_categorie`),
  ADD KEY `lieu_FKIndex2` (`ville_id_ville`),
  ADD KEY `lieu_FKIndex3` (`codePostale_id_codePostale`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- Index pour la table `ville`
--
ALTER TABLE `ville`
  ADD PRIMARY KEY (`id_ville`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `id_categorie` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `codepostale`
--
ALTER TABLE `codepostale`
  MODIFY `id_codePostale` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `invitation`
--
ALTER TABLE `invitation`
  MODIFY `id_invitation` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `lieu`
--
ALTER TABLE `lieu`
  MODIFY `id_lieu` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `ville`
--
ALTER TABLE `ville`
  MODIFY `id_ville` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
