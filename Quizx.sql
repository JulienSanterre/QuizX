-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2.1
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Lun 18 Novembre 2019 à 19:54
-- Version du serveur :  5.7.24-0ubuntu0.16.04.1
-- Version de PHP :  7.2.11-4+ubuntu16.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `Quizx`
--

-- --------------------------------------------------------

--
-- Structure de la table `migration_versions`
--

CREATE TABLE `migration_versions` (
  `version` varchar(14) COLLATE utf8mb4_unicode_ci NOT NULL,
  `executed_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table `migration_versions`
--

INSERT INTO `migration_versions` (`version`, `executed_at`) VALUES
('20191113160043', '2019-11-13 16:00:51'),
('20191113171702', '2019-11-13 17:17:09'),
('20191114165631', '2019-11-14 16:56:35'),
('20191116105509', '2019-11-16 10:55:16'),
('20191116135526', '2019-11-16 13:55:35'),
('20191116164628', '2019-11-16 16:46:37');

-- --------------------------------------------------------

--
-- Structure de la table `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `restricted` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table `questions`
--

INSERT INTO `questions` (`id`, `status`, `title`, `content`, `created_at`, `updated_at`, `user_id`, `restricted`) VALUES
(1, 0, 'The question', 'Pourquoi les nuages sont blanc ? !', '2019-11-15 16:47:55', '2019-11-17 20:32:40', 2, 0),
(5, 1, 'Encore une question pour les tests', 'De quel couleur était le cheval blanc d\'henry 8', '2019-11-16 00:30:12', '2019-11-16 15:09:32', 3, 0),
(7, 0, 'User id !', 'Un user id doit être généré', '2019-11-16 00:46:58', '2019-11-16 15:09:42', 2, 1),
(8, 0, 'Un autre question dont admin est l auteur', 'C est moi qui l ai dit', '2019-11-16 13:44:29', '2019-11-16 14:58:01', 5, 1),
(9, 1, 'La question 36', 'Une super question, non ?', '2019-11-16 14:15:49', '2019-11-16 15:09:57', 5, 0),
(11, 0, 'Ma question a 100 euros partie 2', 'Un test de tag', '2019-11-16 14:40:05', '2019-11-16 14:55:44', 5, 0),
(12, 1, 'La question pour Best', 'pour tester if is best', '2019-11-17 19:52:08', '2019-11-17 23:16:40', 2, 0),
(13, 0, 'user question', 'Pq les vaches sont herbivores', '2019-11-18 19:37:46', NULL, 6, 0),
(14, 0, 'user question blocked', 'combien de points on les cocinelles', '2019-11-18 19:38:14', NULL, 6, 1);

-- --------------------------------------------------------

--
-- Structure de la table `questions_tags`
--

CREATE TABLE `questions_tags` (
  `questions_id` int(11) NOT NULL,
  `tags_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table `questions_tags`
--

INSERT INTO `questions_tags` (`questions_id`, `tags_id`) VALUES
(1, 3),
(1, 4),
(5, 1),
(5, 3),
(7, 1),
(7, 3),
(7, 4),
(8, 3),
(9, 1),
(9, 3),
(11, 3),
(11, 4),
(12, 1),
(13, 3);

-- --------------------------------------------------------

--
-- Structure de la table `responses`
--

CREATE TABLE `responses` (
  `id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `question_id` int(11) DEFAULT NULL,
  `is_best` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table `responses`
--

INSERT INTO `responses` (`id`, `status`, `created_at`, `updated_at`, `content`, `user_id`, `question_id`, `is_best`) VALUES
(2, 1, '2019-11-15 16:48:50', NULL, 'Parcequ il ne sont pas jaune', 3, 1, 0),
(5, 0, '2019-11-16 15:51:32', NULL, 'Moi je sais pas et je m en fiche', 5, 1, 0),
(6, 0, '2019-11-17 18:54:19', NULL, 'La réponse a 10 euros', 6, 1, 0),
(8, 0, '2019-11-17 19:26:38', NULL, 'je ne sais pas', 2, 9, 1),
(13, 1, '2019-11-17 19:52:30', NULL, 'je m auto best :p', 2, 12, 1),
(14, 0, '2019-11-17 21:38:12', '2019-11-17 21:38:22', 'vert bleu', 6, 5, 1),
(15, 1, '2019-11-17 21:38:35', NULL, 'ou peut etre blanc', 6, 5, 0),
(16, 0, '2019-11-18 18:45:46', NULL, 'la reponse de l admin', 2, 8, 0);

-- --------------------------------------------------------

--
-- Structure de la table `tags`
--

CREATE TABLE `tags` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table `tags`
--

INSERT INTO `tags` (`id`, `name`) VALUES
(1, 'Vol haut'),
(3, 'Religion'),
(4, 'Autre');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `mail` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table `user`
--

INSERT INTO `user` (`id`, `mail`, `username`, `password`, `roles`) VALUES
(2, 'julien@ks.ft', 'jupiter', '$argon2id$v=19$m=65536,t=4,p=1$qL0h+901l3jCfBlBi6liTg$tWd53/jrYLPl3xIcesH3PSk5d7E+VKz+HNPNv+FY8WE', '{"0": "ROLE_ADMIN", "1": "ROLE_USER"}'),
(3, 'toto@toto.com', 'toto', '$argon2id$v=19$m=65536,t=4,p=1$Ho7Z+JluPPgBO5Vs6idXow$pZ1DsWNou4YBULm1dGZMEGcyhpPWHDK6DlIi7kGnnbI', '{"1": "ROLE_USER"}'),
(4, 'julien@ks', 'moderator', '$argon2id$v=19$m=65536,t=4,p=1$fvcwmt2+xg4Q2r9k0LCsxA$ynm8rkWFrJe/buHi8+yN26q8sPRddF5qPBZvDpPag+I', '["ROLE_USER", "ROLE_MODERATOR"]'),
(5, '', 'admin', '$argon2id$v=19$m=65536,t=4,p=1$zGLM0i7A4CaPhjICfvFCsQ$Q7Dn+hVlj6nNEoSlJOcpQu3wawbB2DtgHxFgV6O0YQg', '["ROLE_ADMIN"]'),
(6, '', 'user', '$argon2id$v=19$m=65536,t=4,p=1$oWLm2TfuHq/W9BcAnJXdEA$lhso31O+QAiwNAyymXXeXL920exNcYfbNUdE9pCYva0', '[]');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `migration_versions`
--
ALTER TABLE `migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_8ADC54D5A76ED395` (`user_id`);

--
-- Index pour la table `questions_tags`
--
ALTER TABLE `questions_tags`
  ADD PRIMARY KEY (`questions_id`,`tags_id`),
  ADD KEY `IDX_721C3074BCB134CE` (`questions_id`),
  ADD KEY `IDX_721C30748D7B4FB4` (`tags_id`);

--
-- Index pour la table `responses`
--
ALTER TABLE `responses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_315F9F94A76ED395` (`user_id`),
  ADD KEY `IDX_315F9F941E27F6BF` (`question_id`);

--
-- Index pour la table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT pour la table `responses`
--
ALTER TABLE `responses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT pour la table `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `FK_8ADC54D5A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `questions_tags`
--
ALTER TABLE `questions_tags`
  ADD CONSTRAINT `FK_721C30748D7B4FB4` FOREIGN KEY (`tags_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_721C3074BCB134CE` FOREIGN KEY (`questions_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `responses`
--
ALTER TABLE `responses`
  ADD CONSTRAINT `FK_315F9F941E27F6BF` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`),
  ADD CONSTRAINT `FK_315F9F94A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
