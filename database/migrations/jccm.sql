-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 18, 2018 at 07:08 PM
-- Server version: 10.1.35-MariaDB
-- PHP Version: 7.2.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jccm`
--

-- --------------------------------------------------------

--
-- Table structure for table `batches`
--

DROP TABLE IF EXISTS `batches`;
CREATE TABLE `batches` (
  `id` int(10) UNSIGNED NOT NULL,
  `no` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `batches`
--

INSERT INTO `batches` (`id`, `no`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 9, 'Be God\'s Voice', 'Mark 1:2-3', '2018-09-15 06:04:05', '2018-09-15 06:18:37'),
(2, 1, 'Batch 1', 'Batch 1', '2018-09-18 04:10:16', '2018-09-18 04:10:16');

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

DROP TABLE IF EXISTS `files`;
CREATE TABLE `files` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `filename` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `files`
--

INSERT INTO `files` (`id`, `name`, `description`, `filename`, `created_at`, `updated_at`) VALUES
(5, 'Sched', 'sched', 'nQfdOnGwJ4IE4uk7cUlDQmKsXOb8vXcEeNDpg9YkFwTtwR9747GxYgIy13n2.pdf', '2018-09-17 04:19:52', '2018-09-17 04:19:52');

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

DROP TABLE IF EXISTS `members`;
CREATE TABLE `members` (
  `id` int(10) UNSIGNED NOT NULL,
  `first_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sex` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `birth_date` date NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `level` int(11) NOT NULL DEFAULT '0',
  `network_id` int(11) NOT NULL DEFAULT '0',
  `leader_id` int(11) NOT NULL DEFAULT '0',
  `dp_filename` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'default.png',
  `isNetwork` int(11) NOT NULL DEFAULT '0',
  `approved` int(11) NOT NULL DEFAULT '0',
  `inactive` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `leader_code` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `first_name`, `last_name`, `sex`, `birth_date`, `address`, `level`, `network_id`, `leader_id`, `dp_filename`, `isNetwork`, `approved`, `inactive`, `created_at`, `updated_at`, `leader_code`) VALUES
(1, 'Anjo Mel', 'Aloyan', 'MALE', '1993-06-12', 'Tondo, Manila', 1, 1, 0, 'EdNUsNeZXc7SXH0vFMOWbuZELhoBBg177wjdVcJhI4b9kqEOuX8sD3uEwD5w.jpg', 0, 0, 0, '2018-09-16 21:46:06', '2018-09-17 22:36:18', '1'),
(2, 'Patrick Dale', 'Rugayan', 'MALE', '1997-12-22', 'Tondo, Manila', 2, 1, 1, '1ZB7C6DbBhgxp0hFrO1ifuT3rYoWPMeIw7iBBGEvqQeBE1iw9DHpTKhmtqn2.jpg', 0, 0, 0, '2018-09-16 22:09:11', '2018-09-18 00:20:06', '1-2'),
(3, 'Rudolf Christian', 'Dacay', 'MALE', '2000-12-20', 'Tondo, Manila', 3, 1, 2, 'meMQ9k1hW7HjEqsgQbQez8NVBGlpSvbEt0vKpWPLdcXMIksRYhZzja4VnwIZ.jpg', 0, 0, 1, '2018-09-16 22:33:59', '2018-09-18 01:59:54', '1-2-3'),
(4, 'Rea Mel', 'Tagubilin', 'FEMALE', '1992-01-12', 'Tondo, Manila', 1, 4, 0, 'dGuiQJC7hFWtcxb4ncZixQvO3PXudwwuJsR6YVJaTTT4w3EI5MeCYJPdhj7s.jpg', 0, 0, 0, '2018-09-16 23:52:32', '2018-09-17 22:37:02', '4'),
(10, 'Kenneth', 'Traquena', 'MALE', '1998-09-28', 'Tondo, Manila', 2, 1, 1, 'default.png', 0, 0, 0, '2018-09-17 07:07:04', '2018-09-17 22:39:15', '1-10'),
(11, 'Kent Russel', 'Cataag', 'MALE', '1998-09-19', 'Tondo, Manila', 3, 1, 10, 'default.png', 0, 0, 0, '2018-09-17 07:07:39', '2018-09-17 22:38:03', '1-10-11'),
(12, 'Patricia', 'De Vera', 'FEMALE', '2000-02-05', 'Tondo, Manila', 2, 4, 4, 'default.png', 0, 0, 0, '2018-09-17 07:19:21', '2018-09-17 22:44:25', '4-12'),
(13, 'Manevie', 'Lemindog', 'FEMALE', '2001-09-27', 'Manila', 3, 4, 12, 'default.png', 0, 0, 0, '2018-09-17 07:23:03', '2018-09-17 07:23:03', '4-12-13'),
(15, 'Nicole', 'Lalog', 'FEMALE', '2018-09-20', 'Manila', 1, 15, 0, 'default.png', 0, 0, 0, '2018-09-17 22:33:44', '2018-09-17 22:33:44', '15'),
(19, 'Edmark', 'De Guzman', 'MALE', '2018-09-27', 'Manila', 1, 19, 0, 'default.png', 0, 0, 0, '2018-09-18 02:55:49', '2018-09-18 02:55:49', '19'),
(20, 'Mark', 'Victoria', 'MALE', '2018-09-21', 'Manila', 1, 20, 0, 'default.png', 0, 0, 0, '2018-09-18 02:56:25', '2018-09-18 02:56:25', '20'),
(21, 'Marinz', 'Acebuche', 'MALE', '2018-09-27', 'Manila', 1, 21, 0, 'default.png', 0, 0, 0, '2018-09-18 02:56:55', '2018-09-18 02:56:55', '21'),
(22, 'Ray Mark', 'Ramos', 'MALE', '2018-09-19', 'Manila', 1, 22, 0, 'default.png', 0, 0, 0, '2018-09-18 02:57:21', '2018-09-18 02:57:21', '22'),
(23, 'Novel', 'Buenaventura', 'MALE', '2018-09-08', 'Manila', 1, 23, 0, 'default.png', 0, 0, 0, '2018-09-18 02:58:14', '2018-09-18 02:58:14', '23'),
(24, 'Briendel', 'Mabini', 'MALE', '2018-09-22', 'Manila', 1, 24, 0, 'default.png', 0, 0, 0, '2018-09-18 02:58:52', '2018-09-18 02:58:52', '24'),
(25, 'Jericho', 'Fuentes', 'MALE', '2018-09-25', 'Manila', 1, 25, 0, 'default.png', 0, 0, 0, '2018-09-18 03:01:19', '2018-09-18 03:01:19', '25'),
(26, 'Jason', 'Sebarre', 'MALE', '2018-09-20', 'Manila', 1, 26, 0, 'default.png', 0, 0, 0, '2018-09-18 03:01:34', '2018-09-18 03:01:34', '26'),
(27, 'Dory', 'Arnigo', 'FEMALE', '2018-09-19', 'Manila', 1, 27, 0, 'default.png', 0, 0, 0, '2018-09-18 03:02:08', '2018-09-18 03:02:08', '27'),
(28, 'Christy Renz', 'Moral', 'FEMALE', '2018-09-22', 'Manila', 1, 28, 0, 'default.png', 0, 0, 0, '2018-09-18 03:02:30', '2018-09-18 03:02:30', '28'),
(29, 'Thine', 'Apostol', 'FEMALE', '2018-09-21', 'Manila', 1, 29, 0, 'default.png', 0, 0, 0, '2018-09-18 03:03:06', '2018-09-18 03:03:06', '29'),
(30, 'Michelle', 'Careon', 'FEMALE', '2018-09-29', 'Manila', 1, 30, 0, 'default.png', 0, 0, 0, '2018-09-18 03:03:26', '2018-09-18 03:03:26', '30'),
(31, 'Nitz', 'Mabini', 'FEMALE', '2018-09-21', 'Manila', 1, 31, 0, 'default.png', 0, 0, 0, '2018-09-18 03:03:47', '2018-09-18 03:03:47', '31'),
(32, 'Evelyn', 'Gonzales', 'FEMALE', '2018-09-18', 'Manila', 1, 32, 0, 'default.png', 0, 0, 0, '2018-09-18 03:04:27', '2018-09-18 03:04:27', '32');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2018_09_15_115339_create_members_table', 1),
(3, '2018_09_15_133828_create_batches_table', 2),
(5, '2018_09_15_144227_create_trainings_table', 3),
(6, '2018_09_17_103346_create_files_table', 4),
(8, '2018_09_18_061649_add_leader_code_column_to_members_table', 5);

-- --------------------------------------------------------

--
-- Table structure for table `trainings`
--

DROP TABLE IF EXISTS `trainings`;
CREATE TABLE `trainings` (
  `id` int(10) UNSIGNED NOT NULL,
  `member` int(11) NOT NULL DEFAULT '0',
  `batch` int(11) NOT NULL DEFAULT '0',
  `pre_encounter` int(11) NOT NULL DEFAULT '0',
  `encounter` int(11) NOT NULL DEFAULT '0',
  `post_encounter` int(11) NOT NULL DEFAULT '0',
  `sol1` int(11) NOT NULL DEFAULT '0',
  `sol2` int(11) NOT NULL DEFAULT '0',
  `re_encounter` int(11) NOT NULL DEFAULT '0',
  `sol3` int(11) NOT NULL DEFAULT '0',
  `baptism` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `trainings`
--

INSERT INTO `trainings` (`id`, `member`, `batch`, `pre_encounter`, `encounter`, `post_encounter`, `sol1`, `sol2`, `re_encounter`, `sol3`, `baptism`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 1, 1, 1, 1, 1, 1, '2010', '2018-09-16 21:46:06', '2018-09-16 23:46:36'),
(2, 2, 1, 1, 1, 1, 1, 1, 1, 0, '2014', '2018-09-16 22:09:11', '2018-09-18 04:01:16'),
(3, 3, 1, 0, 0, 0, 0, 0, 0, 0, '2015', '2018-09-16 22:33:59', '2018-09-16 22:33:59'),
(4, 4, 1, 0, 0, 0, 0, 0, 0, 0, '2005', '2018-09-16 23:52:32', '2018-09-16 23:52:32'),
(10, 10, 1, 0, 0, 0, 0, 0, 0, 0, '', '2018-09-17 07:07:04', '2018-09-18 07:18:24'),
(11, 11, 1, 0, 0, 0, 0, 0, 0, 0, '', '2018-09-17 07:07:39', '2018-09-18 07:18:34'),
(12, 12, 0, 0, 0, 0, 0, 0, 0, 0, '', '2018-09-17 07:19:21', '2018-09-17 07:19:21'),
(13, 13, 0, 0, 0, 0, 0, 0, 0, 0, '', '2018-09-17 07:23:03', '2018-09-17 07:23:03'),
(15, 15, 0, 0, 0, 0, 0, 0, 0, 0, '', '2018-09-17 22:33:44', '2018-09-17 22:33:44'),
(19, 19, 0, 0, 0, 0, 0, 0, 0, 0, '', '2018-09-18 02:55:49', '2018-09-18 02:55:49'),
(20, 20, 0, 0, 0, 0, 0, 0, 0, 0, '', '2018-09-18 02:56:25', '2018-09-18 02:56:25'),
(21, 21, 0, 0, 0, 0, 0, 0, 0, 0, '', '2018-09-18 02:56:55', '2018-09-18 02:56:55'),
(22, 22, 0, 0, 0, 0, 0, 0, 0, 0, '', '2018-09-18 02:57:21', '2018-09-18 02:57:21'),
(23, 23, 0, 0, 0, 0, 0, 0, 0, 0, '', '2018-09-18 02:58:14', '2018-09-18 02:58:14'),
(24, 24, 1, 1, 0, 0, 0, 0, 0, 0, '', '2018-09-18 02:58:52', '2018-09-18 07:02:54'),
(25, 25, 0, 0, 0, 0, 0, 0, 0, 0, '', '2018-09-18 03:01:19', '2018-09-18 03:01:19'),
(26, 26, 0, 0, 0, 0, 0, 0, 0, 0, '', '2018-09-18 03:01:34', '2018-09-18 03:01:34'),
(27, 27, 0, 0, 0, 0, 0, 0, 0, 0, '', '2018-09-18 03:02:08', '2018-09-18 03:02:08'),
(28, 28, 0, 0, 0, 0, 0, 0, 0, 0, '', '2018-09-18 03:02:30', '2018-09-18 03:02:30'),
(29, 29, 0, 0, 0, 0, 0, 0, 0, 0, '', '2018-09-18 03:03:06', '2018-09-18 03:03:06'),
(30, 30, 0, 0, 0, 0, 0, 0, 0, 0, '', '2018-09-18 03:03:26', '2018-09-18 03:03:26'),
(31, 31, 0, 0, 0, 0, 0, 0, 0, 0, '', '2018-09-18 03:03:47', '2018-09-18 03:03:47'),
(32, 32, 0, 0, 0, 0, 0, 0, 0, 0, '', '2018-09-18 03:04:27', '2018-09-18 03:04:27');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `first_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `network` int(11) NOT NULL DEFAULT '0',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `username`, `password`, `type`, `network`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Patrick Dale', 'Rugayan', 'patrick.rugayan', '$2y$10$7QFY5mxUIyr/8wyfGlIwQej978X1Ayv/wBaFaOG6hY8xrYZaX2L8e', 'ADMIN', 0, 'DwMOh5O77gYRBNyyC3l1fH2mQ81CrQrJquMmo0CXCebGwHX3FENIhhfAzR17', NULL, NULL),
(2, 'Anjo Mel', 'Aloyan', 'anjo.aloyan', '$2y$10$fYcFUcl5fKhhig2y7pPruuRbzkEqCiwp1MRkzZiV3taLeRBsVxJNK', 'NET_LEAD', 1, 'LG4zgrpPWnJKh7AoOoyGeMiFAuPGvPWE4l1fGw55RbEaK3555Okyge1VIayN', '2018-09-17 07:53:55', '2018-09-17 07:53:55'),
(3, 'Admin', 'Admin', 'admin.admin', '$2y$10$iCoWAqmXN2X593eUnJPXMOpZYPvqlmK4KsDQa0DYzTwsr9YlnmuvC', 'ADMIN', 0, NULL, '2018-09-17 22:14:11', '2018-09-17 22:14:11');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `batches`
--
ALTER TABLE `batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trainings`
--
ALTER TABLE `trainings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_password_unique` (`password`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `batches`
--
ALTER TABLE `batches`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `trainings`
--
ALTER TABLE `trainings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
