-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 06 août 2025 à 15:06
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

--
-- Déchargement des données de la table `agences`
--

INSERT INTO `agences` (`id`, `nom`) VALUES
(1, 'Paris'),
(2, 'Lyon'),
(3, 'Marseille'),
(4, 'Toulouse'),
(5, 'Nice'),
(6, 'Nantes'),
(7, 'Strasbourg'),
(8, 'Montpellier'),
(9, 'Bordeaux'),
(10, 'Lille'),
(11, 'Rennes'),
(12, 'Reims');

--
-- Déchargement des données de la table `trajets`
--

INSERT INTO `trajets` (`id`, `agence_depart_id`, `agence_arrivee_id`, `date_heure_depart`, `date_heure_arrivee`, `nombres_places_total`, `nombres_places_dispo`, `utilisateur_id`) VALUES
(1, 3, 12, '2025-08-06 08:00:00', '2025-08-06 15:00:00', 5, 2, 1),
(2, 3, 6, '2025-08-11 09:30:00', '2025-08-11 14:00:00', 3, 1, 6),
(3, 2, 11, '2025-08-06 08:00:00', '2025-08-06 15:30:00', 3, 2, 16);

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `prenom`, `nom`, `email`, `mot_de_passe`, `telephone`, `role`) VALUES
(1, 'Alexandre', 'Martin', 'alexandre.martin@email.fr', '$2y$12$lOGbMD0XqTqVnBkX0hFm0eT2FoaDFJZN3y8f5khl5GF/6lyavnmUq', '0612345678', 'utilisateur'),
(2, 'Sophie', 'Dubois', 'sophie.dubois@email.fr', '$2y$12$lOGbMD0XqTqVnBkX0hFm0eT2FoaDFJZN3y8f5khl5GF/6lyavnmUq', '0698765432', 'utilisateur'),
(3, 'Julien', 'Bernard', 'julien.bernard@email.fr', '$2y$12$lOGbMD0XqTqVnBkX0hFm0eT2FoaDFJZN3y8f5khl5GF/6lyavnmUq', '0622446688', 'utilisateur'),
(4, 'Camille', 'Moreau', 'camille.moreau@email.fr', '$2y$12$lOGbMD0XqTqVnBkX0hFm0eT2FoaDFJZN3y8f5khl5GF/6lyavnmUq', '0611223344', 'utilisateur'),
(5, 'lucie', 'lefèvre', 'lucie.lefevre@email.fr', '$2y$12$lOGbMD0XqTqVnBkX0hFm0eT2FoaDFJZN3y8f5khl5GF/6lyavnmUq', '0777889900', 'utilisateur'),
(6, 'Thomas', 'Leroy', 'thomas.leroy@email.fr', '$2y$12$lOGbMD0XqTqVnBkX0hFm0eT2FoaDFJZN3y8f5khl5GF/6lyavnmUq', '0655443322', 'utilisateur'),
(7, 'Chloé', 'Roux', 'clhoe.roux@email.fr', '$2y$12$lOGbMD0XqTqVnBkX0hFm0eT2FoaDFJZN3y8f5khl5GF/6lyavnmUq', '0633221199', 'utilisateur'),
(8, 'Maxime', 'Petit', 'maxime.petit@email.fr', '$2y$12$lOGbMD0XqTqVnBkX0hFm0eT2FoaDFJZN3y8f5khl5GF/6lyavnmUq', '0766778899', 'utilisateur'),
(9, 'Laura', 'Garnier', 'laura.garnier@email.fr', '$2y$12$lOGbMD0XqTqVnBkX0hFm0eT2FoaDFJZN3y8f5khl5GF/6lyavnmUq', '0688776655', 'utilisateur'),
(10, 'Antoine', 'Dupuis', 'antoine.dupuis@email.fr', '$2y$12$lOGbMD0XqTqVnBkX0hFm0eT2FoaDFJZN3y8f5khl5GF/6lyavnmUq', '0744556677', 'utilisateur'),
(11, 'Emma', 'Lefebvre', 'emma.lefebvre@email.fr', '$2y$12$lOGbMD0XqTqVnBkX0hFm0eT2FoaDFJZN3y8f5khl5GF/6lyavnmUq', '0699887766', 'utilisateur'),
(12, 'Louis', 'Fontaine', 'louis.fontaine@email.fr', '$2y$12$lOGbMD0XqTqVnBkX0hFm0eT2FoaDFJZN3y8f5khl5GF/6lyavnmUq', '0655667788', 'utilisateur'),
(13, 'Clara', 'Chevalier', 'clara.chevalier@email.fr', '$2y$12$lOGbMD0XqTqVnBkX0hFm0eT2FoaDFJZN3y8f5khl5GF/6lyavnmUq', '0788990011', 'utilisateur'),
(14, 'Nicolas', 'Robin', 'nicolas.robin@email.fr', '$2y$12$lOGbMD0XqTqVnBkX0hFm0eT2FoaDFJZN3y8f5khl5GF/6lyavnmUq', '0644332211', 'utilisateur'),
(15, 'Marine', 'Gauthier', 'marine.gauthier@email.fr', '$2y$12$lOGbMD0XqTqVnBkX0hFm0eT2FoaDFJZN3y8f5khl5GF/6lyavnmUq', '0677889922', 'utilisateur'),
(16, 'Pierre', 'Fournier', 'pierre.fournier@email.fr', '$2y$12$lOGbMD0XqTqVnBkX0hFm0eT2FoaDFJZN3y8f5khl5GF/6lyavnmUq', '0722334455', 'utilisateur'),
(17, 'Hugo', 'Lambert', 'hugo.lambert@email.fr', '$2y$12$lOGbMD0XqTqVnBkX0hFm0eT2FoaDFJZN3y8f5khl5GF/6lyavnmUq', '0611223366', 'utilisateur'),
(18, 'Julie', 'Masson', 'julie.masson@email.fr', '$2y$12$lOGbMD0XqTqVnBkX0hFm0eT2FoaDFJZN3y8f5khl5GF/6lyavnmUq', '0733445566', 'utilisateur'),
(19, 'Arthur', 'Henri', 'arthur.henri@email.fr', '$2y$12$lOGbMD0XqTqVnBkX0hFm0eT2FoaDFJZN3y8f5khl5GF/6lyavnmUq', '0666554433', 'utilisateur'),
(20, 'Admin', 'Test', 'admin.test@email.fr', '$2y$12$h5XzH1Gyk/1NfH5.H1YxGOmYkRVC4Eyj.Qt5K5HW9qRJVBYfDsgKi', '00000000', 'admin');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
