-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 12, 2019 at 06:44 PM
-- Server version: 10.3.16-MariaDB
-- PHP Version: 7.3.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `church`
--

-- --------------------------------------------------------

--
-- Table structure for table `church_databases`
--

CREATE TABLE `church_databases` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `church_name` varchar(191) NOT NULL,
  `database_name` varchar(191) NOT NULL,
  `database_url` varchar(191) NOT NULL,
  `database_password` varchar(191) NOT NULL,
  `attached_logo` varchar(191) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `church_databases`
--

INSERT INTO `church_databases` (`id`, `church_name`, `database_name`, `database_url`, `database_password`, `attached_logo`, `created_at`, `updated_at`) VALUES
(1, 'Pahappa', 'Main DB', 'user@pahappa.com', '123Jane14.', 'loho', '2019-09-05 07:53:04', '2019-09-04 22:36:48'),
(2, 'Watoto Church Of Uganda', 'watsDB', 'admin@pahappa.com', '123Jane14.', 'doctore.jpg', '2019-09-05 12:00:07', '2019-09-05 12:00:07'),
(3, 'kasenge miracle Center', 'kasengeDB', 'kasengechuch.com', '123Jane14.', 'ic_launcher.png', '2019-09-05 12:04:22', '2019-09-05 12:04:22'),
(4, 'Hour Of Power Church', 'ChurchDB', 'churchsa@cs', 'ben104767', 'ic_launcher.png', '2019-09-05 12:05:50', '2019-09-05 12:05:50'),
(5, 'Rubaga Cathedral', 'db_rubaga', 'jdbc://mysql:83/db_church', 'db_rubaga', 'doctore.jpg', '2019-09-07 11:53:35', '2019-09-07 11:53:35'),
(9, 'UCC', 'UCCDB', 'http://localhost:8000/createchurches', '123Jane14.', 'doctore.jpg', '2019-09-08 09:38:54', '2019-09-08 09:38:54'),
(10, 'kldsa kgd ld', 'dksa', 'http://localhost:8000/createchurches/6', '123Jane14.', 'doctore.jpg', '2019-09-08 09:44:33', '2019-09-08 09:44:33'),
(11, 'kasa', 'lsakdsa', 'http://localhost:8000/createchurches', 'sakllkashd', 'ic_launcher.png', '2019-09-09 16:15:29', '2019-09-09 16:15:29'),
(12, 'st. reeash', 'dsasa', 'http://localhost:8000/createchurches', '123Jane14', 'ic_launcher.png', '2019-09-09 16:18:13', '2019-09-09 16:18:13'),
(13, 'ETM Church international', 'etmchurch', 'http://localhost:8000/createchurches', '123Jane14.', 'ic_launcher.png', '2019-09-16 13:18:47', '2019-09-16 13:18:47'),
(14, 'Watoto Church Of Ugand', 'kasengeD', 'http://localhost:8000/createchurches', '123Jane14', 'doctore.jpg', '2019-09-17 15:50:09', '2019-09-17 15:50:09'),
(15, 'Watoto Church Uganda', 'kasengeDB', 'http://localhost:8000/createchurches', '123Jane14.', 'doctore.jpg', '2019-09-17 15:52:09', '2019-09-17 15:52:09'),
(16, 'Watoto Church', 'kasengeD', 'http://localhost:8000/createchurches', '123Jane14.', 'ic_launcher.png', '2019-09-17 15:56:17', '2019-09-17 15:56:17'),
(17, 'kasenge miracle Cen', 'kasengeD', 'http://localhost:8000/createchurc', '123Jane14', 'ic_launcher.png', '2019-09-18 10:45:11', '2019-09-18 10:45:11'),
(18, 'Watoto Chuh', 'kaseng', 'http://localhost:8000/createchurc', '123Jane14', NULL, '2019-09-18 15:04:36', '2019-09-18 15:04:36'),
(19, 'em', 'em', 'http://localhost:8000/createchurches', '123Jane14.', NULL, '2019-09-18 15:15:17', '2019-09-18 15:15:17'),
(20, 's', 'kasengeDB', 'http://localhost:8000/createchurches', '123Jane14.', NULL, '2019-09-28 11:38:04', '2019-09-28 11:38:04'),
(21, 'Watoto Church Of Ug', 'kasengeDB', 'http://localhost:8000/createchurches', '123Jane14.', NULL, '2019-10-03 10:34:56', '2019-10-03 10:34:56'),
(22, 'Watoto Church Ofnda', 'kasengeDB', 'http://localhost:8000/createchurches', '123Jane14.', NULL, '2019-10-03 10:36:22', '2019-10-03 10:36:22'),
(23, 's-', 'kasengeDB', 'http://localhost:8000/createchurches', '123Jane14.', NULL, '2019-10-09 16:59:49', '2019-10-09 16:59:49'),
(24, 'Watoto Church Of Ugandp', 'kasengeDB', 'http://localhost:8000/createchurches', '123Jane14.', NULL, '2019-10-09 17:15:21', '2019-10-09 17:15:21');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `church_id` bigint(20) UNSIGNED NOT NULL,
  `group_id` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `update_by` bigint(20) UNSIGNED NOT NULL,
  `contact_number` longtext NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `church_id`, `group_id`, `created_by`, `update_by`, `contact_number`, `created_at`, `updated_at`) VALUES
(37, 1, 38, 1, 1, '[{\"Contact\":\"\",\"name\":\"\"},{\"Contact\":\"256757963454\",\"name\":\"James Ociba\"},{\"Contact\":\"256757913454\",\"name\":\"julius\"},{\"Contact\":\"256777700147\",\"name\":\"James Ociba\"}]', '2019-10-02 08:56:49', '2019-10-02 12:56:49'),
(38, 1, 39, 1, 1, '[{\"Contact\":\"\",\"name\":\"\"},{\"Contact\":\"256777700147\",\"name\":\"Norah Wanyenya\"},{\"Contact\":\"256757913454\",\"name\":\"julius\"}]', '2019-10-02 08:58:49', '2019-10-02 12:58:49'),
(39, 1, 40, 1, 1, '[{\"Contact\":\"\",\"name\":\"\"},{\"Contact\":\"256777700144\",\"name\":\"James Ociba\"},{\"Contact\":\"256702913454\",\"name\":\"Norah Wanyenya\"}]', '2019-10-02 09:18:09', '2019-10-02 13:18:09'),
(43, 1, 38, 1, 1, '[{\"Contact\":\"\",\"name\":\"\"}]', '2019-10-03 10:34:55', '2019-10-03 10:34:55'),
(44, 1, 41, 1, 1, '[{\"Contact\":\"\",\"name\":\"\"}]', '2019-10-09 17:29:09', '2019-10-09 17:29:09'),
(45, 1, 42, 1, 1, '[{\"Contact\":\"\",\"name\":\"\"}]', '2019-10-09 17:33:24', '2019-10-09 17:33:24'),
(46, 1, 43, 1, 1, '[{\"Contact\":\"\",\"name\":\"\"}]', '2019-10-09 17:33:30', '2019-10-09 17:33:30'),
(47, 1, 44, 1, 1, '[{\"Contact\":\"\",\"name\":\"\"}]', '2019-10-09 17:33:40', '2019-10-09 17:33:40'),
(48, 1, 45, 1, 1, '[{\"Contact\":\"\",\"name\":\"\"}]', '2019-10-09 17:33:46', '2019-10-09 17:33:46'),
(49, 1, 46, 1, 1, '[{\"Contact\":\"\",\"name\":\"\"}]', '2019-10-09 17:33:52', '2019-10-09 17:33:52'),
(50, 1, 47, 1, 1, '[{\"Contact\":\"\",\"name\":\"\"}]', '2019-10-09 17:33:57', '2019-10-09 17:33:57'),
(51, 1, 48, 1, 1, '[{\"Contact\":\"\",\"name\":\"\"}]', '2019-10-09 17:34:04', '2019-10-09 17:34:04');

-- --------------------------------------------------------

--
-- Table structure for table `Groups`
--

CREATE TABLE `Groups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `church_id` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `group_name` varchar(191) NOT NULL,
  `number_of_contacts` int(15) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Groups`
--

INSERT INTO `Groups` (`id`, `church_id`, `created_by`, `group_name`, `number_of_contacts`, `created_at`, `updated_at`) VALUES
(38, 1, 1, 'new', 4, '2019-10-02 08:56:49', '2019-10-02 12:56:49'),
(39, 1, 1, 'My Group', 3, '2019-10-02 08:58:49', '2019-10-02 12:58:49'),
(40, 1, 1, 'Mine', 3, '2019-10-02 09:18:09', '2019-10-02 13:18:09'),
(41, 1, 1, 'ksd', 0, '2019-10-09 17:29:09', '2019-10-09 17:29:09'),
(42, 1, 1, 'Grace', 0, '2019-10-09 17:33:24', '2019-10-09 17:33:24'),
(43, 1, 1, 'ian', 0, '2019-10-09 17:33:29', '2019-10-09 17:33:29'),
(44, 1, 1, 'kinaana', 0, '2019-10-09 17:33:40', '2019-10-09 17:33:40'),
(45, 1, 1, 'Kintu', 0, '2019-10-09 17:33:46', '2019-10-09 17:33:46'),
(46, 1, 1, 'Carol', 0, '2019-10-09 17:33:52', '2019-10-09 17:33:52'),
(47, 1, 1, 'Bianka', 0, '2019-10-09 17:33:57', '2019-10-09 17:33:57'),
(48, 1, 1, 'Ain', 0, '2019-10-09 17:34:04', '2019-10-09 17:34:04');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `group_id` bigint(20) UNSIGNED NOT NULL,
  `church_id` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `message` longtext NOT NULL,
  `contact_character` int(20) NOT NULL,
  `created_on` varchar(191) NOT NULL,
  `status` enum('Sent','Not Yet Sent','Cancelled') NOT NULL DEFAULT 'Sent',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `group_id`, `church_id`, `created_by`, `message`, `contact_character`, `created_on`, `status`, `created_at`, `updated_at`) VALUES
(35, 38, 1, 1, 'sd', 0, '10/09/2019 10:18', 'Sent', '2019-10-09 18:19:46', '2019-10-09 18:19:46'),
(36, 38, 1, 1, 'sd', 0, '10/09/2019 10:19', 'Sent', '2019-10-09 18:19:58', '2019-10-09 18:19:58'),
(37, 38, 1, 1, 'sd', 0, '10/09/2019 10:20', 'Sent', '2019-10-09 18:20:26', '2019-10-09 18:20:26'),
(38, 38, 1, 1, 'sd', 0, '10/09/2019 10:20', 'Sent', '2019-10-09 18:29:26', '2019-10-09 18:29:26'),
(39, 38, 1, 1, 'asas', 0, '10/09/2019 10:29', 'Sent', '2019-10-09 18:29:43', '2019-10-09 18:29:43'),
(40, 40, 1, 1, 'asas', 0, '10/09/2019 10:29', 'Sent', '2019-10-09 18:29:44', '2019-10-09 18:29:44');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_09_02_060941_create_churches_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `church_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('active','deleted') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `background_color` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `church_name`, `status`, `background_color`, `created_at`, `updated_at`) VALUES
(1, 'Super_admin', 'active', '', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `church_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL DEFAULT 1,
  `background_color` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `church_id`, `name`, `role_id`, `background_color`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 1, 'pahappa ', 1, NULL, 'admin', NULL, '$2y$10$meYu8kr1G9FMrmN53FCCTu0mQtzQfa2qrvXrXpBAZvqLwbe/3mNwC', '0lc2zquftrvOAye9vx41BFF2FWEeSxZ9mc23zeUHGDI3cAhEhMESm4AUSecE', '2019-09-02 10:25:40', '2019-10-02 15:12:24'),
(4, 2, 'Norah Wanyenya', 1, NULL, 'juli', NULL, '$2y$10$7B8CWXg0CtPQfiYwPdu2quKTyZPbw2/krb3VoXGjPYyq9Uxz6gDHC', NULL, '2019-09-07 11:25:48', '2019-09-07 11:25:48'),
(5, 5, 'Benedicto Kasolo', 1, NULL, 'bkasolo@gmail.com', NULL, '$2y$10$mD3CGZYPVL.e9iQWcQzKeeWfZ8yt4BrHR2Chn88TwOkaTUYwag.gK', NULL, '2019-09-07 11:54:23', '2019-09-07 11:54:23'),
(8, 9, 'UCC', 1, NULL, 'ucc', NULL, '$2y$10$krRBBiu/P94snk.mrNNJ7ulPpkRA40VCPfNwWJxq4py6.rY//aItK', NULL, '2019-09-08 09:38:54', '2019-09-08 09:38:55'),
(9, 10, 'kldsa kgd ld', 1, NULL, 'kldsakgdld', NULL, '$2y$10$jar.Yr1l87AxxJo1OVuKM.i7z8.DHi/DGUwVMl3aghly0kbdu5uiW', NULL, '2019-09-08 09:44:34', '2019-09-08 09:44:34'),
(10, 11, 'kasa', 1, NULL, 'kasa', NULL, '$2y$10$MU9WER2793LbdG9pJuYAfuET1.mfMJAuTMoO7VHWqbohfqWSDbLom', NULL, '2019-09-09 16:15:29', '2019-09-09 16:15:29'),
(11, 12, 'st. reeash', 1, NULL, 'st.reeash', NULL, '$2y$10$ZtcVJRSe4TlFC39G5r5mju/Xhpv4LwG0AkqW7poCGkLDFJkQnmknC', NULL, '2019-09-09 16:18:13', '2019-09-09 16:18:13'),
(12, 1, 'Joseph Adoch', 1, NULL, 'asda@dsa.comew', NULL, '$2y$10$y8O8aaNmggUfDgd1x4ajlOakl/DOnU9ijV3u74Rhi77q.knBLH0pq', NULL, '2019-09-10 12:10:18', '2019-09-10 12:10:18'),
(13, 1, 'Salim Ssemakula', 1, NULL, 'benjaminnewton7@gmail.com', NULL, '$2y$10$dHSnt0.D16Z1f2dDeePJCeSvjEaWnrhp.EdCNTOMVcknSY4Hd50eK', NULL, '2019-09-10 12:11:44', '2019-09-10 12:11:44'),
(14, 13, 'ETM Church international', 1, NULL, 'etmchurchinternational', NULL, '$2y$10$jMCqhDAutdGxe3kxO3xntOumOq0H92iq5EoijQfZEYjHancm1pAj2', NULL, '2019-09-16 13:18:47', '2019-09-16 13:18:47'),
(16, 1, 'Shyaka Katende', 1, NULL, 'dmin', NULL, '$2y$10$kIAm8icGxm.tGkpEmkSznevM7VIJQCmuhB1LBdxjtqwo3NG.jHHu.', NULL, '2019-09-16 15:16:43', '2019-09-16 15:16:43'),
(17, 14, 'Watoto Church Of Ugand', 1, NULL, 'watotochurchofugand', NULL, '$2y$10$izM6ivKUWaz/zV1CcxwqIeno2ECPAmlIG91uC4nPeV3PlIHE5QXRC', NULL, '2019-09-17 15:50:09', '2019-09-17 15:50:09'),
(18, 15, 'Watoto Church Uganda', 1, NULL, 'watotochurchuganda', NULL, '$2y$10$C1Lt3vwfNibc04JeRX5rQu2t.RkV33e.BernXTcP1N6K8v0Z1Kau2', NULL, '2019-09-17 15:52:09', '2019-09-17 15:52:09'),
(19, 16, 'Watoto Church', 1, NULL, 'watotochurch', NULL, '$2y$10$LAXI3f6wABynGsl10CMBfu3Z7ERq3bO3GYWSnihSqQOICKKAMc0h6', NULL, '2019-09-17 15:56:17', '2019-09-17 15:56:17'),
(20, 1, 'Joseph Adoch', 1, NULL, 'http://localhost:8000/createchurches', NULL, '$2y$10$joVhxPYYfbcPU5QbkODmo.hkW/nU/mrzwElGV7z2jPZWZ/5YGOCRi', NULL, '2019-09-17 19:46:26', '2019-09-17 19:46:26'),
(21, 17, 'kasenge miracle Cen', 1, NULL, 'kasengemiraclecen', NULL, '$2y$10$.63yguSCS5A6oyO2aP4WgeUwmHNtUte8AmaEsodEWHWKSPoVhHc9W', NULL, '2019-09-18 10:45:11', '2019-09-18 10:45:11'),
(22, 18, 'Watoto Chuh', 1, NULL, 'watotochuh', NULL, '$2y$10$kmKNCzem6MJxaaHZu6H1K.dLpNbG/XdNiT5FQZuEGuJPc5ZxA4OuS', NULL, '2019-09-18 15:04:36', '2019-09-18 15:04:37'),
(23, 1, 'Joseph Katende', 1, NULL, 'admin@pahappa.com', NULL, '$2y$10$CRZyKpL0LDSRZmwFu4ugcemohum4pdyKgU4YgP4bOvlpBFEMBGqJ2', NULL, '2019-09-18 15:06:38', '2019-09-18 15:06:38'),
(25, 1, 'Joseph Katende', 1, NULL, 'Paul@gmail.com', NULL, '$2y$10$QGhSq/MRk3DzdjO7pUhPmuYwgIKrs05VRWhK1wYsAHcZF8vHxZvEi', NULL, '2019-09-18 15:13:00', '2019-09-18 15:13:00'),
(26, 19, 'em', 1, NULL, 'em', NULL, '$2y$10$FKxnY7dAOVfOguX4YDEXceKYLGxoQDEweWxcwcTrL0FA/kbn9Uxn2', NULL, '2019-09-18 15:15:17', '2019-09-18 15:15:17'),
(30, 19, 'Joseph Katende', 1, NULL, 's', NULL, '$2y$10$b32dlgiIwHUwBRA6wZyCYuvqSjcQkNFEHn5imVy3z4HoRoADilzyC', NULL, '2019-09-25 12:58:47', '2019-09-25 12:58:47'),
(32, 21, 'Watoto Church Of Ug', 1, NULL, 'watotochurchofug', NULL, '$2y$10$oqAGvCo49syD8qFsJohDYefFduGfeFN87pYRtRtwX7eci7k5rYYmK', NULL, '2019-10-03 10:34:56', '2019-10-03 10:34:56'),
(33, 22, 'Watoto Church Ofnda', 1, NULL, 'watotochurchofnda', NULL, '$2y$10$SkpNAipan7njpoqIp04gquWFvoxOEcQ/Q.oFwe8XI6ZaF9jC.iVqm', NULL, '2019-10-03 10:36:22', '2019-10-03 10:36:22'),
(34, 23, 's-', 1, NULL, 's-', NULL, '$2y$10$34KewugYwz1BEPo/V6Q9/Ogj/shzvR0S6efCMlP/YLHmocxacSun6', NULL, '2019-10-09 16:59:49', '2019-10-09 16:59:50'),
(35, 24, 'Watoto Church Of Ugandp', 1, NULL, 'watotochurchofugandp', NULL, '$2y$10$HmxPI4Mz83dmVtI4cwWhNutdAtGZvU2wQFL8lDE.DU/jjQlsbsDm2', NULL, '2019-10-09 17:15:21', '2019-10-09 17:15:21'),
(36, 1, 'Joseph Katende', 1, NULL, '256702913454', NULL, '$2y$10$Wx4nYD.J39a6hbRKjjsISu6aiBV.pjRw4I7JMim6dhaWQTg8bu7EK', NULL, '2019-10-09 17:26:42', '2019-10-09 17:26:42');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `church_databases`
--
ALTER TABLE `church_databases`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`church_id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `update_by` (`update_by`),
  ADD KEY `group_id` (`group_id`);

--
-- Indexes for table `Groups`
--
ALTER TABLE `Groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `church_id` (`church_id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `number_of_contacts` (`number_of_contacts`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `church_id` (`church_id`),
  ADD KEY `group_id` (`group_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `church_id` (`church_id`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `church_databases`
--
ALTER TABLE `church_databases`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `Groups`
--
ALTER TABLE `Groups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `contacts`
--
ALTER TABLE `contacts`
  ADD CONSTRAINT `contacts_ibfk_1` FOREIGN KEY (`church_id`) REFERENCES `church_databases` (`id`),
  ADD CONSTRAINT `contacts_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `contacts_ibfk_3` FOREIGN KEY (`update_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `contacts_ibfk_4` FOREIGN KEY (`group_id`) REFERENCES `Groups` (`id`);

--
-- Constraints for table `Groups`
--
ALTER TABLE `Groups`
  ADD CONSTRAINT `Groups_ibfk_1` FOREIGN KEY (`church_id`) REFERENCES `church_databases` (`id`),
  ADD CONSTRAINT `Groups_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`church_id`) REFERENCES `church_databases` (`id`),
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `messages_ibfk_3` FOREIGN KEY (`group_id`) REFERENCES `Groups` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`church_id`) REFERENCES `church_databases` (`id`),
  ADD CONSTRAINT `users_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
