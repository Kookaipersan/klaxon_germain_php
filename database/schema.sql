-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 06 août 2025 à 15:07
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `touche_pas_au_klaxon`
--

-- --------------------------------------------------------

--
-- Structure de la table `agences`
--

CREATE TABLE `agences` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `trajets`
--

CREATE TABLE `trajets` (
  `id` int(11) NOT NULL,
  `agence_depart_id` int(11) NOT NULL,
  `agence_arrivee_id` int(11) NOT NULL,
  `date_heure_depart` datetime NOT NULL,
  `date_heure_arrivee` datetime NOT NULL,
  `nombres_places_total` int(11) NOT NULL,
  `nombres_places_dispo` int(11) NOT NULL,
  `utilisateur_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id` int(11) NOT NULL,
  `prenom` varchar(100) DEFAULT NULL,
  `nom` varchar(100) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `role` enum('utilisateur','admin') DEFAULT 'utilisateur'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `agences`
--
ALTER TABLE `agences`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `trajets`
--
ALTER TABLE `trajets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `agence_depart_id` (`agence_depart_id`),
  ADD KEY `agence_arrivee_id` (`agence_arrivee_id`),
  ADD KEY `utilisateur_id` (`utilisateur_id`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `agences`
--
ALTER TABLE `agences`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `trajets`
--
ALTER TABLE `trajets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `trajets`
--
ALTER TABLE `trajets`
  ADD CONSTRAINT `trajets_ibfk_1` FOREIGN KEY (`agence_depart_id`) REFERENCES `agences` (`id`),
  ADD CONSTRAINT `trajets_ibfk_2` FOREIGN KEY (`agence_arrivee_id`) REFERENCES `agences` (`id`),
  ADD CONSTRAINT `trajets_ibfk_3` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateurs` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
