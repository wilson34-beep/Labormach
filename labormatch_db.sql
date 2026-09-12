-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 09, 2026 at 11:57 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `labormatch_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `action` varchar(120) NOT NULL,
  `details` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `details`, `created_at`) VALUES
(1, 1, 'login', 'User logged in.', '2026-08-18 21:21:20'),
(2, 1, 'login', 'User logged in.', '2026-08-18 21:22:05'),
(3, NULL, 'login', 'User logged in.', '2026-08-18 21:22:08'),
(4, 3, 'login', 'User logged in.', '2026-08-18 21:22:11'),
(5, NULL, 'login', 'User logged in.', '2026-08-18 21:27:05'),
(6, NULL, 'profile_update', 'Updated job seeker profile.', '2026-08-18 21:27:05'),
(7, 3, 'login', 'User logged in.', '2026-08-18 21:27:05'),
(8, 3, 'company_update', 'Updated employer company profile.', '2026-08-18 21:27:05'),
(9, NULL, 'login', 'User logged in.', '2026-08-18 21:28:33'),
(10, 3, 'login', 'User logged in.', '2026-08-18 21:28:37'),
(11, 1, 'login', 'User logged in.', '2026-08-18 21:28:39'),
(12, NULL, 'login', 'User logged in.', '2026-08-18 21:42:58'),
(13, NULL, 'profile_update', 'Updated job seeker profile.', '2026-08-18 21:43:35'),
(14, NULL, 'logout', 'User logged out.', '2026-08-18 21:45:02'),
(15, 1, 'login', 'User logged in.', '2026-08-18 21:45:40'),
(16, 1, 'logout', 'User logged out.', '2026-08-18 21:47:48'),
(17, 2, 'login', 'User logged in.', '2026-08-18 21:48:18'),
(18, 2, 'logout', 'User logged out.', '2026-08-18 21:48:58'),
(19, 1, 'login', 'User logged in.', '2026-08-18 21:49:19'),
(20, 1, 'logout', 'User logged out.', '2026-08-18 21:50:16'),
(21, 2, 'login', 'User logged in.', '2026-08-18 21:51:18'),
(22, 2, 'logout', 'User logged out.', '2026-08-18 21:52:44'),
(23, NULL, 'login', 'User logged in.', '2026-08-18 21:55:21'),
(24, NULL, 'logout', 'User logged out.', '2026-08-18 21:58:42'),
(25, 1, 'login', 'User logged in.', '2026-08-18 21:58:59'),
(26, 1, 'logout', 'User logged out.', '2026-08-18 22:03:54'),
(27, 1, 'login', 'User logged in.', '2026-08-18 22:08:50'),
(28, 1, 'barangay_admin_create', 'Created barangay admin account for barangay.test.20260818220850@example.com.', '2026-08-18 22:08:51'),
(29, NULL, 'login', 'User logged in.', '2026-08-18 22:08:51'),
(30, NULL, 'settings_profile_update', 'Updated admin account settings.', '2026-08-18 22:08:51'),
(31, 1, 'barangay_admin_delete', 'Deleted barangay admin account #6', '2026-08-18 22:08:51'),
(32, 1, 'login', 'User logged in.', '2026-08-18 22:09:25'),
(33, 1, 'login', 'User logged in.', '2026-08-18 22:09:44'),
(34, 2, 'login', 'User logged in.', '2026-08-18 22:09:44'),
(35, 1, 'login', 'User logged in.', '2026-08-18 22:16:04'),
(36, 1, 'barangay_admin_create', 'Created barangay admin account for dextercardona@gmail.com.', '2026-08-18 22:18:00'),
(37, 1, 'logout', 'User logged out.', '2026-08-18 22:19:21'),
(38, 7, 'login', 'User logged in.', '2026-08-18 22:19:35'),
(39, 7, 'logout', 'User logged out.', '2026-08-18 22:20:24'),
(40, 1, 'login', 'User logged in.', '2026-08-19 13:00:59'),
(41, 1, 'logout', 'User logged out.', '2026-08-19 13:03:01'),
(42, 1, 'login', 'User logged in.', '2026-08-19 13:21:18'),
(43, 1, 'login', 'User logged in.', '2026-08-19 13:23:05'),
(44, 1, 'login', 'User logged in.', '2026-08-19 13:25:50'),
(45, 1, 'logout', 'User logged out.', '2026-08-19 13:41:45'),
(46, 7, 'login', 'User logged in.', '2026-08-19 13:41:58'),
(47, 7, 'logout', 'User logged out.', '2026-08-19 13:52:31'),
(48, 8, 'register', 'New jobseeker account registered.', '2026-08-19 13:55:28'),
(49, 8, 'login', 'User logged in.', '2026-08-19 13:55:36'),
(50, 8, 'logout', 'User logged out.', '2026-08-19 13:58:35'),
(51, 1, 'login', 'User logged in.', '2026-08-19 13:58:44'),
(52, 1, 'jobseeker_active', 'Updated job seeker account #8', '2026-08-19 13:59:43'),
(53, 1, 'jobseeker_verify', 'Updated job seeker account #8', '2026-08-19 13:59:45'),
(54, 1, 'jobseeker_active', 'Updated job seeker account #8', '2026-08-19 13:59:46'),
(55, 1, 'jobseeker_verify', 'Updated job seeker account #8', '2026-08-19 13:59:52'),
(56, 1, 'logout', 'User logged out.', '2026-08-19 14:07:48'),
(57, 2, 'login', 'User logged in.', '2026-08-19 14:13:23'),
(58, 2, 'settings_profile_update', 'Updated admin account settings.', '2026-08-19 14:13:24'),
(59, 1, 'login', 'User logged in.', '2026-08-19 14:14:13'),
(60, 2, 'login', 'User logged in.', '2026-08-19 14:14:16'),
(61, 3, 'login', 'User logged in.', '2026-08-19 14:14:20'),
(62, 1, 'login', 'User logged in.', '2026-08-19 14:32:50'),
(63, 2, 'login', 'User logged in.', '2026-08-19 14:32:51'),
(64, 3, 'login', 'User logged in.', '2026-08-19 14:32:51'),
(65, 5, 'login', 'User logged in.', '2026-08-19 14:33:52'),
(66, NULL, 'register', 'New jobseeker account registered.', '2026-08-19 14:34:26'),
(67, 10, 'register', 'New jobseeker account registered.', '2026-08-19 14:37:06'),
(68, 1, 'login', 'User logged in.', '2026-08-19 14:37:16'),
(69, 1, 'jobseeker_active', 'Updated job seeker account #10', '2026-08-19 14:37:43'),
(70, 1, 'jobseeker_verify', 'Updated job seeker account #10', '2026-08-19 14:37:58'),
(71, 1, 'jobseeker_active', 'Updated job seeker account #10', '2026-08-19 14:38:04'),
(72, 1, 'job_approved', 'Updated job #1', '2026-08-19 14:39:46'),
(73, 1, 'logout', 'User logged out.', '2026-08-19 14:40:17'),
(74, 10, 'login', 'User logged in.', '2026-08-19 14:40:29'),
(75, 10, 'logout', 'User logged out.', '2026-08-19 14:40:43'),
(76, 10, 'login', 'User logged in.', '2026-08-19 14:40:55'),
(77, 10, 'logout', 'User logged out.', '2026-08-19 14:41:48'),
(78, 1, 'login', 'User logged in.', '2026-08-19 14:41:58'),
(79, 1, 'jobseeker_verify', 'Updated job seeker account #10', '2026-08-19 14:42:03'),
(80, 1, 'logout', 'User logged out.', '2026-08-19 14:42:20'),
(81, 10, 'login', 'User logged in.', '2026-08-19 14:42:32'),
(82, 10, 'logout', 'User logged out.', '2026-08-19 14:43:24'),
(83, 11, 'register', 'New employer account registered.', '2026-08-19 14:44:23'),
(84, 11, 'login', 'User logged in.', '2026-08-19 14:44:34'),
(85, 11, 'logout', 'User logged out.', '2026-08-19 14:44:57'),
(86, 7, 'login', 'User logged in.', '2026-08-19 14:45:06'),
(87, 1, 'login', 'User logged in.', '2026-08-19 14:52:18'),
(88, 2, 'login', 'User logged in.', '2026-08-19 14:52:18'),
(89, 3, 'login', 'User logged in.', '2026-08-19 14:52:18'),
(90, 5, 'login', 'User logged in.', '2026-08-19 14:52:19'),
(91, 7, 'logout', 'User logged out.', '2026-08-19 14:52:57'),
(92, 1, 'login', 'User logged in.', '2026-08-19 14:53:07'),
(93, 3, 'login', 'User logged in.', '2026-08-19 14:54:42'),
(94, 5, 'login', 'User logged in.', '2026-08-19 14:54:43'),
(95, 8, 'login', 'User logged in.', '2026-08-19 14:56:11'),
(96, 8, 'logout', 'User logged out.', '2026-08-19 14:56:24'),
(97, 3, 'login', 'User logged in.', '2026-08-19 14:57:46'),
(98, 3, 'logout', 'User logged out.', '2026-08-19 14:58:08'),
(99, 3, 'login', 'User logged in.', '2026-08-19 15:01:07'),
(100, 5, 'login', 'User logged in.', '2026-08-19 15:01:08'),
(101, 1, 'login', 'User logged in.', '2026-08-19 15:01:08'),
(102, 3, 'login', 'User logged in.', '2026-08-19 15:16:23'),
(103, 5, 'login', 'User logged in.', '2026-08-19 15:16:23'),
(104, 1, 'login', 'User logged in.', '2026-08-19 15:16:24'),
(105, 3, 'login', 'User logged in.', '2026-08-19 15:18:06'),
(106, 5, 'login', 'User logged in.', '2026-08-19 15:18:07'),
(107, 1, 'login', 'User logged in.', '2026-08-19 15:18:08'),
(108, 3, 'login', 'User logged in.', '2026-08-19 15:18:49'),
(109, 2, 'login', 'User logged in.', '2026-08-19 15:19:33'),
(110, 3, 'login', 'User logged in.', '2026-08-19 15:20:05'),
(111, 5, 'login', 'User logged in.', '2026-08-19 15:20:06'),
(112, 1, 'login', 'User logged in.', '2026-08-19 15:20:06'),
(113, 2, 'login', 'User logged in.', '2026-08-19 15:20:07'),
(114, 1, 'login', 'User logged in.', '2026-08-19 15:22:33'),
(115, 1, 'employer_active', 'Updated employer #2', '2026-08-19 15:23:51'),
(116, 1, 'employer_active', 'Updated employer #2', '2026-08-19 15:23:53'),
(117, 1, 'employer_verified', 'Updated employer #2', '2026-08-19 15:24:05'),
(118, 1, 'employer_active', 'Updated employer #2', '2026-08-19 15:24:09'),
(119, 1, 'employer_verified', 'Updated employer #2', '2026-08-19 15:24:12'),
(120, 1, 'employer_verified', 'Updated employer #2', '2026-08-19 15:24:14'),
(121, 1, 'employer_verified', 'Updated employer #2', '2026-08-19 15:24:14'),
(122, 1, 'employer_rejected', 'Updated employer #2', '2026-08-19 15:24:24'),
(123, 1, 'employer_suspended', 'Updated employer #2', '2026-08-19 15:24:28'),
(124, 1, 'employer_rejected', 'Updated employer #2', '2026-08-19 15:24:31'),
(125, 1, 'employer_suspended', 'Updated employer #2', '2026-08-19 15:24:34'),
(126, 1, 'employer_verified', 'Updated employer #2', '2026-08-19 15:24:35'),
(127, 1, 'employer_active', 'Updated employer #2', '2026-08-19 15:24:40'),
(128, 1, 'employer_active', 'Updated employer #2', '2026-08-19 15:24:41'),
(129, 1, 'employer_verified', 'Updated employer #2', '2026-08-19 15:24:43'),
(130, 1, 'employer_verified', 'Updated employer #2', '2026-08-19 15:24:45'),
(131, 1, 'employer_active', 'Updated employer #2', '2026-08-19 15:24:46'),
(132, 1, 'employer_active', 'Updated employer #2', '2026-08-19 15:24:54'),
(133, 1, 'employer_active', 'Updated employer #2', '2026-08-19 15:24:57'),
(134, 1, 'employer_verified', 'Updated employer #2', '2026-08-19 15:24:59'),
(135, 1, 'employer_active', 'Updated employer #2', '2026-08-19 15:25:02'),
(136, 1, 'employer_verified', 'Updated employer #2', '2026-08-19 15:25:03'),
(137, 1, 'logout', 'User logged out.', '2026-08-19 15:25:09'),
(138, 8, 'login', 'User logged in.', '2026-08-19 15:25:20'),
(139, 8, 'logout', 'User logged out.', '2026-08-19 15:27:06'),
(140, 7, 'login', 'User logged in.', '2026-08-19 15:27:15'),
(141, 7, 'logout', 'User logged out.', '2026-08-19 15:28:20'),
(142, 5, 'login', 'User logged in.', '2026-08-19 15:41:13'),
(143, 5, 'login', 'User logged in.', '2026-08-19 15:42:23'),
(144, 3, 'login', 'User logged in.', '2026-08-19 15:42:23'),
(145, 1, 'login', 'User logged in.', '2026-08-19 15:42:23'),
(146, 2, 'login', 'User logged in.', '2026-08-19 15:42:24'),
(147, 1, 'login', 'User logged in.', '2026-08-19 15:43:33'),
(148, 3, 'login', 'User logged in.', '2026-08-19 16:12:47'),
(149, 5, 'login', 'User logged in.', '2026-08-19 16:12:48'),
(150, 1, 'login', 'User logged in.', '2026-08-19 16:12:49'),
(151, 2, 'login', 'User logged in.', '2026-08-19 16:12:50'),
(153, 1, 'login', 'User logged in.', '2026-08-19 16:14:01'),
(154, NULL, 'login', 'User logged in.', '2026-08-19 16:14:44'),
(155, 1, 'login', 'User logged in.', '2026-08-19 16:16:08'),
(156, 1, 'logout', 'User logged out.', '2026-08-19 16:16:33'),
(157, 13, 'register', 'New jobseeker account registered.', '2026-08-19 16:17:36'),
(158, 1, 'login', 'User logged in.', '2026-08-19 16:17:48'),
(159, 1, 'login', 'User logged in.', '2026-08-19 18:49:25'),
(160, 1, 'logout', 'User logged out.', '2026-08-19 18:53:34'),
(161, 1, 'login', 'User logged in.', '2026-08-19 18:56:45'),
(162, 1, 'logout', 'User logged out.', '2026-08-19 19:03:06'),
(163, NULL, 'login', 'User logged in.', '2026-08-19 19:20:13'),
(164, 5, 'login', 'User logged in.', '2026-08-19 19:26:11'),
(165, 3, 'login', 'User logged in.', '2026-08-19 19:26:11'),
(166, 1, 'login', 'User logged in.', '2026-08-19 19:26:12'),
(167, 2, 'login', 'User logged in.', '2026-08-19 19:26:13'),
(168, NULL, 'login', 'User logged in.', '2026-08-19 19:26:16'),
(169, 16, 'register', 'New employer account registered.', '2026-08-19 19:28:10'),
(170, 1, 'login', 'User logged in.', '2026-08-19 19:28:24'),
(171, 1, 'logout', 'User logged out.', '2026-08-19 19:29:31'),
(172, 16, 'login', 'User logged in.', '2026-08-19 19:29:46'),
(173, 16, 'company_update', 'Updated employer company profile.', '2026-08-19 19:30:43'),
(174, 16, 'logout', 'User logged out.', '2026-08-19 19:31:37'),
(175, 7, 'login', 'User logged in.', '2026-08-19 19:31:48'),
(176, 7, 'settings_profile_update', 'Updated admin account settings.', '2026-08-19 19:32:44'),
(177, 7, 'logout', 'User logged out.', '2026-08-19 19:32:50'),
(178, 1, 'login', 'User logged in.', '2026-08-19 19:33:11'),
(179, 1, 'logout', 'User logged out.', '2026-08-19 19:35:44'),
(180, 1, 'login', 'User logged in.', '2026-08-20 16:43:07'),
(181, 1, 'barangay_admin_create', 'Created barangay admin account for a@gamil.com.', '2026-08-20 16:44:17'),
(182, 1, 'logout', 'User logged out.', '2026-08-20 16:51:01'),
(183, 8, 'login', 'User logged in.', '2026-08-20 16:51:33'),
(184, 8, 'logout', 'User logged out.', '2026-08-20 16:53:13'),
(185, 7, 'login', 'User logged in.', '2026-08-20 16:53:23'),
(186, 7, 'logout', 'User logged out.', '2026-08-20 16:55:35'),
(187, 8, 'login', 'User logged in.', '2026-08-20 16:55:48'),
(188, 8, 'logout', 'User logged out.', '2026-08-20 16:57:35'),
(189, 1, 'login', 'User logged in.', '2026-08-20 17:00:16'),
(190, 1, 'login', 'User logged in.', '2026-08-20 19:05:15'),
(191, 5, 'login', 'User logged in.', '2026-08-20 19:05:15'),
(192, 2, 'login', 'User logged in.', '2026-08-20 19:05:45'),
(193, 3, 'login', 'User logged in.', '2026-08-20 19:05:46'),
(194, 1, 'login', 'User logged in.', '2026-08-20 19:05:46'),
(195, 5, 'login', 'User logged in.', '2026-08-20 19:06:20'),
(196, 1, 'login', 'User logged in.', '2026-08-20 19:10:16'),
(197, 1, 'login', 'User logged in.', '2026-08-20 19:26:45'),
(198, 1, 'logout', 'User logged out.', '2026-08-20 19:27:47'),
(199, 1, 'login', 'User logged in.', '2026-08-20 19:27:55'),
(200, 1, 'logout', 'User logged out.', '2026-08-20 19:30:16'),
(201, 7, 'login', 'User logged in.', '2026-08-20 19:30:25'),
(202, 7, 'logout', 'User logged out.', '2026-08-20 19:31:14'),
(203, 10, 'login', 'User logged in.', '2026-08-20 19:31:26'),
(204, 10, 'logout', 'User logged out.', '2026-08-20 19:32:15'),
(205, 7, 'login', 'User logged in.', '2026-08-20 19:32:27'),
(206, 7, 'logout', 'User logged out.', '2026-08-20 19:32:39'),
(207, 11, 'login', 'User logged in.', '2026-08-20 19:32:50'),
(208, 11, 'logout', 'User logged out.', '2026-08-20 19:33:38'),
(209, 1, 'login', 'User logged in.', '2026-08-20 19:35:55'),
(210, 1, 'login', 'User logged in.', '2026-08-20 19:48:25'),
(211, 5, 'login', 'User logged in.', '2026-08-20 19:48:25'),
(212, 1, 'login', 'User logged in.', '2026-08-20 19:49:37'),
(213, 1, 'logout', 'User logged out.', '2026-08-20 19:49:39'),
(214, 5, 'login', 'User logged in.', '2026-08-20 19:49:40'),
(215, 5, 'login', 'User logged in.', '2026-08-20 19:50:01'),
(216, 1, 'login', 'User logged in.', '2026-08-20 19:50:37'),
(217, 1, 'logout', 'User logged out.', '2026-08-20 19:51:01'),
(218, 1, 'login', 'User logged in.', '2026-08-20 19:51:31'),
(219, 1, 'logout', 'User logged out.', '2026-08-20 19:52:03'),
(220, 8, 'login', 'User logged in.', '2026-08-20 19:52:17'),
(221, 8, 'profile_update', 'Updated job seeker profile.', '2026-08-20 19:52:35'),
(222, 8, 'logout', 'User logged out.', '2026-08-20 19:52:47'),
(223, 7, 'login', 'User logged in.', '2026-08-20 19:53:03'),
(224, 7, 'logout', 'User logged out.', '2026-08-20 19:53:13'),
(225, 1, 'login', 'User logged in.', '2026-08-20 19:55:52'),
(226, 5, 'login', 'User logged in.', '2026-08-20 20:03:00'),
(227, 1, 'login', 'User logged in.', '2026-08-20 20:03:31'),
(228, 1, 'logout', 'User logged out.', '2026-08-20 20:05:18'),
(229, 1, 'login', 'User logged in.', '2026-08-20 20:06:25'),
(230, 1, 'logout', 'User logged out.', '2026-08-20 20:07:46'),
(231, 7, 'login', 'User logged in.', '2026-08-20 20:07:57'),
(232, 7, 'logout', 'User logged out.', '2026-08-20 20:09:20'),
(233, 8, 'login', 'User logged in.', '2026-08-20 20:55:35'),
(234, 8, 'profile_update', 'Updated job seeker profile.', '2026-08-20 20:56:09'),
(235, 8, 'logout', 'User logged out.', '2026-08-20 20:58:41'),
(236, 1, 'login', 'User logged in.', '2026-08-20 20:58:58'),
(237, 1, 'settings_profile_update', 'Updated admin account settings.', '2026-08-20 21:01:50'),
(238, 1, 'logout', 'User logged out.', '2026-08-20 21:02:32'),
(239, 1, 'login', 'User logged in.', '2026-08-20 21:02:56'),
(240, 1, 'login', 'User logged in.', '2026-08-20 22:03:07'),
(241, 1, 'login', 'User logged in.', '2026-08-25 21:57:48'),
(242, 1, 'logout', 'User logged out.', '2026-08-25 22:12:10'),
(243, 1, 'login', 'User logged in.', '2026-08-25 22:12:24'),
(244, 1, 'login', 'User logged in.', '2026-08-26 15:24:54'),
(245, 1, 'logout', 'User logged out.', '2026-08-26 16:54:24'),
(246, 1, 'login', 'User logged in.', '2026-08-26 18:44:14'),
(247, 1, 'login', 'User logged in.', '2026-08-27 11:18:26'),
(248, 1, 'logout', 'User logged out.', '2026-08-27 11:51:55'),
(249, 8, 'login', 'User logged in.', '2026-08-27 11:52:53'),
(250, 8, 'profile_update', 'Updated job seeker profile.', '2026-08-27 11:53:13'),
(251, 8, 'logout', 'User logged out.', '2026-08-27 11:53:19'),
(252, 1, 'login', 'User logged in.', '2026-08-27 11:53:31'),
(253, 1, 'announcement_create', 'ffefe', '2026-08-27 11:54:13'),
(254, 1, 'logout', 'User logged out.', '2026-08-27 11:54:35'),
(255, 18, 'register', 'New jobseeker account registered.', '2026-08-27 11:55:29'),
(256, 1, 'login', 'User logged in.', '2026-08-27 11:55:45'),
(257, 1, 'settings_profile_update', 'Updated admin account settings.', '2026-08-27 14:26:18'),
(258, 1, 'logout', 'User logged out.', '2026-08-27 14:44:27'),
(259, 1, 'login', 'User logged in.', '2026-08-27 14:46:33'),
(260, 1, 'settings_profile_update', 'Updated admin account settings.', '2026-08-27 14:47:15'),
(261, 1, 'settings_profile_update', 'Updated admin account settings.', '2026-08-27 14:48:35'),
(262, 1, 'logout', 'User logged out.', '2026-08-27 18:27:49'),
(263, 1, 'login', 'User logged in.', '2026-08-27 18:43:22'),
(264, 1, 'login', 'User logged in.', '2026-08-27 20:43:23'),
(265, 1, 'job_closed', 'Updated job #1', '2026-08-27 21:05:56'),
(266, 1, 'job_active', 'Updated job #1', '2026-08-27 21:06:06'),
(267, 1, 'logout', 'User logged out.', '2026-08-27 22:37:32'),
(268, 8, 'login', 'User logged in.', '2026-08-27 22:37:46'),
(269, 1, 'login', 'User logged in.', '2026-08-28 13:03:24'),
(270, 1, 'logout', 'User logged out.', '2026-08-28 13:59:14'),
(271, 7, 'login', 'User logged in.', '2026-08-28 13:59:57'),
(272, 7, 'logout', 'User logged out.', '2026-08-28 14:36:12'),
(273, 1, 'login', 'User logged in.', '2026-08-28 14:36:26'),
(274, 1, 'announcement_create', 'awdawdawda', '2026-08-28 14:48:20'),
(275, 1, 'logout', 'User logged out.', '2026-08-28 15:06:34'),
(276, 7, 'login', 'User logged in.', '2026-08-28 15:06:53'),
(277, 7, 'logout', 'User logged out.', '2026-08-28 15:07:16'),
(278, 16, 'login', 'User logged in.', '2026-08-28 15:08:15'),
(279, 16, 'logout', 'User logged out.', '2026-08-28 18:38:07'),
(280, 1, 'login', 'User logged in.', '2026-08-28 18:38:16'),
(281, 1, 'logout', 'User logged out.', '2026-08-28 18:56:39'),
(282, 16, 'login', 'User logged in.', '2026-08-28 18:56:49'),
(283, 16, 'login', 'User logged in.', '2026-08-30 15:58:38'),
(284, 16, 'job_save', 'Saved job post.', '2026-08-30 16:02:10'),
(285, 16, 'job_save', 'Saved job post.', '2026-08-30 16:02:37'),
(286, 16, 'logout', 'User logged out.', '2026-08-30 16:35:57'),
(287, 8, 'login', 'User logged in.', '2026-08-30 16:36:11'),
(288, 8, 'logout', 'User logged out.', '2026-08-30 16:37:52'),
(289, 3, 'login', 'User logged in.', '2026-08-30 16:38:47'),
(290, 3, 'application_shortlisted', 'Updated application #2', '2026-08-30 16:39:19'),
(291, 3, 'logout', 'User logged out.', '2026-08-30 16:40:32'),
(292, 16, 'login', 'User logged in.', '2026-08-30 16:40:52'),
(293, 16, 'company_update', 'Updated employer company profile.', '2026-08-30 16:50:26'),
(294, 16, 'logout', 'User logged out.', '2026-08-30 16:53:46'),
(295, 3, 'login', 'User logged in.', '2026-08-30 16:54:02'),
(296, 3, 'application_screening', 'Updated application #2', '2026-08-30 17:13:01'),
(297, 3, 'application_screening', 'Updated application #2', '2026-08-30 17:13:04'),
(298, 3, 'application_screening', 'Updated application #2', '2026-08-30 17:13:12'),
(299, 3, 'application_interview', 'Updated application #2', '2026-08-30 17:15:21'),
(300, 3, 'company_update', 'Updated employer company profile.', '2026-08-30 17:35:48'),
(301, 3, 'logout', 'User logged out.', '2026-08-30 17:39:25'),
(302, 8, 'login', 'User logged in.', '2026-08-30 17:39:40'),
(303, 1, 'login', 'User logged in.', '2026-08-30 18:00:34'),
(304, 1, 'logout', 'User logged out.', '2026-08-30 18:07:28'),
(305, 16, 'login', 'User logged in.', '2026-08-30 18:07:39'),
(306, 16, 'logout', 'User logged out.', '2026-08-30 18:07:44'),
(307, 8, 'login', 'User logged in.', '2026-08-30 18:07:57'),
(308, 8, 'logout', 'User logged out.', '2026-08-30 18:23:08'),
(309, 16, 'login', 'User logged in.', '2026-08-30 18:23:21'),
(310, 16, 'logout', 'User logged out.', '2026-08-30 18:23:45'),
(311, 8, 'login', 'User logged in.', '2026-08-30 18:24:05'),
(312, 8, 'login', 'User logged in.', '2026-08-30 20:27:22'),
(313, 8, 'logout', 'User logged out.', '2026-08-30 21:31:38'),
(314, 1, 'login', 'User logged in.', '2026-08-31 14:37:37'),
(315, 1, 'settings_profile_update', 'Updated admin account settings.', '2026-08-31 15:07:12'),
(316, 1, 'settings_password_update', 'Changed admin account password.', '2026-08-31 15:07:55'),
(317, 1, 'settings_profile_update', 'Updated admin account settings.', '2026-08-31 15:10:24'),
(318, 1, 'settings_profile_update', 'Updated admin account settings.', '2026-08-31 15:11:02'),
(319, 1, 'settings_profile_update', 'Updated admin account settings.', '2026-08-31 15:15:21'),
(320, 1, 'settings_password_update', 'Changed admin account password.', '2026-08-31 15:23:07'),
(321, 1, 'barangay_admin_create', 'Created barangay admin account for adawd@gadjaw.', '2026-08-31 16:28:15'),
(322, 1, 'barangay_admin_verified', 'Updated barangay admin account #2', '2026-08-31 16:38:15'),
(323, 1, 'barangay_admin_verified', 'Updated barangay admin account #2', '2026-08-31 16:38:47'),
(324, 1, 'barangay_admin_verified', 'Updated barangay admin account #2', '2026-08-31 16:39:00'),
(325, 1, 'barangay_admin_verified', 'Updated barangay admin account #2', '2026-08-31 16:39:13'),
(326, 1, 'barangay_admin_active', 'Updated barangay admin account #2', '2026-08-31 16:41:01'),
(327, 1, 'barangay_admin_suspended', 'Updated barangay admin account #2', '2026-08-31 16:41:08'),
(328, 1, 'barangay_admin_verified', 'Updated barangay admin account #2', '2026-08-31 16:41:17'),
(329, 1, 'barangay_admin_suspended', 'Updated barangay admin account #2', '2026-08-31 16:41:25'),
(330, 1, 'barangay_admin_verified', 'Updated barangay admin account #2', '2026-08-31 16:41:29'),
(331, 1, 'barangay_admin_delete', 'Deleted barangay admin account #19', '2026-08-31 16:48:01'),
(332, 1, 'logout', 'User logged out.', '2026-08-31 18:11:04'),
(333, 7, 'login', 'User logged in.', '2026-08-31 18:11:24'),
(334, 7, 'login', 'User logged in.', '2026-09-01 07:47:46'),
(335, 7, 'logout', 'User logged out.', '2026-09-01 07:47:52'),
(336, 8, 'login', 'User logged in.', '2026-09-01 07:48:08'),
(337, 8, 'logout', 'User logged out.', '2026-09-01 07:48:14'),
(338, 3, 'login', 'User logged in.', '2026-09-01 07:48:59'),
(339, 3, 'company_update', 'Updated employer company profile.', '2026-09-01 08:02:13'),
(340, 3, 'company_update', 'Updated employer company profile.', '2026-09-01 08:02:31'),
(341, 3, 'logout', 'User logged out.', '2026-09-01 08:38:20'),
(342, 7, 'login', 'User logged in.', '2026-09-01 08:38:30'),
(343, 7, 'logout', 'User logged out.', '2026-09-01 08:38:34'),
(344, 16, 'login', 'User logged in.', '2026-09-01 08:38:41'),
(345, 16, 'logout', 'User logged out.', '2026-09-01 08:38:46'),
(346, 8, 'login', 'User logged in.', '2026-09-01 08:38:56'),
(347, 8, 'logout', 'User logged out.', '2026-09-01 09:12:36'),
(348, 1, 'login', 'User logged in.', '2026-09-01 09:12:46'),
(349, 1, 'login', 'User logged in.', '2026-09-09 17:55:32'),
(350, 1, 'settings_password_update', 'Changed admin account password.', '2026-09-09 17:56:57'),
(351, 1, 'logout', 'User logged out.', '2026-09-09 17:57:02'),
(352, 1, 'login', 'User logged in.', '2026-09-09 17:57:18');

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `id` int(11) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `title` varchar(180) NOT NULL,
  `message` text NOT NULL,
  `audience` enum('public','all','employer','jobseeker','admin') NOT NULL DEFAULT 'public',
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`id`, `created_by`, `title`, `message`, `audience`, `created_at`) VALUES
(1, 1, 'LaborMatch Registration Open', 'Job seekers and employers in General MacArthur may now register in the LaborMatch system.', 'public', '2026-08-18 21:20:59'),
(2, 1, 'Skills Verification Day', 'Bring your resume, certificates, and valid ID to the municipal office for profile verification.', 'jobseeker', '2026-08-18 21:20:59'),
(3, 1, 'ffefe', 'sfsefs', 'public', '2026-08-27 11:54:13'),
(4, 1, 'awdawdawda', 'adawdaw', 'public', '2026-08-28 14:48:20');

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE `applications` (
  `id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `jobseeker_id` int(11) NOT NULL,
  `resume_path` varchar(255) DEFAULT NULL,
  `status` enum('applied','screening','shortlisted','interview','hired','rejected') NOT NULL DEFAULT 'applied',
  `match_score` int(11) NOT NULL DEFAULT 0,
  `interview_date` date DEFAULT NULL,
  `interview_time` time DEFAULT NULL,
  `interview_location` varchar(180) DEFAULT NULL,
  `interview_type` enum('Face-to-face','Online','Phone Interview') DEFAULT NULL,
  `interview_notes` text DEFAULT NULL,
  `hiring_result` varchar(120) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `applications`
--

INSERT INTO `applications` (`id`, `job_id`, `jobseeker_id`, `resume_path`, `status`, `match_score`, `interview_date`, `interview_time`, `interview_location`, `interview_type`, `interview_notes`, `hiring_result`, `created_at`, `updated_at`) VALUES
(2, 2, 2, NULL, 'interview', 78, '2026-09-22', '08:00:00', 'rsfsfsfs', 'Face-to-face', 'fsfsefse', NULL, '2026-08-18 21:20:59', '2026-08-30 17:25:01'),
(3, 1, 3, NULL, 'applied', 10, NULL, NULL, NULL, NULL, NULL, NULL, '2026-08-19 13:57:14', NULL),
(5, 2, 3, NULL, 'applied', 10, NULL, NULL, NULL, NULL, NULL, NULL, '2026-08-30 16:37:37', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `badge_views`
--

CREATE TABLE `badge_views` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `badge_key` varchar(160) NOT NULL,
  `viewed_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `badge_views`
--

INSERT INTO `badge_views` (`id`, `user_id`, `badge_key`, `viewed_at`) VALUES
(1, 3, 'employer/jobs.php', '2026-09-01 08:15:52'),
(2, 3, 'employer/applicants.php', '2026-09-01 08:22:13'),
(3, 3, 'employer/interviews.php', '2026-09-01 08:30:14'),
(4, 5, 'jobseeker/applications.php', '2026-08-19 16:12:48'),
(5, 5, 'jobseeker/saved_jobs.php', '2026-08-19 16:12:48'),
(6, 5, 'jobseeker/training.php', '2026-08-20 19:06:20'),
(7, 1, 'admin/users.php', '2026-08-30 18:00:37'),
(8, 1, 'admin/barangay_admins.php', '2026-08-31 16:48:01'),
(9, 1, 'admin/employers.php', '2026-08-31 17:38:01'),
(10, 1, 'admin/jobs.php', '2026-09-01 09:16:47'),
(11, 1, 'admin/applications.php', '2026-09-01 09:16:50'),
(12, 1, 'admin/announcements.php', '2026-08-31 17:50:02'),
(13, 1, 'admin/audit_logs.php', '2026-08-28 13:03:31'),
(14, 2, 'admin/users.php', '2026-08-20 19:05:46'),
(15, 2, 'admin/applications.php', '2026-08-19 16:12:51'),
(16, 2, 'admin/announcements.php', '2026-08-19 16:12:51'),
(40, 16, 'employer/applicants.php', '2026-08-30 16:53:32'),
(41, 16, 'employer/interviews.php', '2026-08-28 15:10:01'),
(42, 7, 'admin/applications.php', '2026-08-20 16:54:53'),
(43, 7, 'admin/announcements.php', '2026-08-28 14:32:51'),
(52, 8, 'jobseeker/applications.php', '2026-08-30 21:28:10'),
(53, 8, 'jobseeker/training.php', '2026-08-30 20:44:45'),
(56, 8, 'jobseeker/saved_jobs.php', '2026-08-30 20:43:32'),
(61, 7, 'admin/users.php', '2026-08-28 15:07:07'),
(88, 10, 'jobseeker/training.php', '2026-08-20 19:31:37'),
(89, 10, 'jobseeker/saved_jobs.php', '2026-08-20 19:31:39'),
(92, 10, 'jobseeker/applications.php', '2026-08-20 19:31:40'),
(145, 16, 'employer/jobs.php', '2026-08-30 16:41:29');

-- --------------------------------------------------------

--
-- Table structure for table `barangays`
--

CREATE TABLE `barangays` (
  `id` int(11) NOT NULL,
  `name` varchar(120) NOT NULL,
  `municipality` varchar(120) NOT NULL DEFAULT 'General MacArthur',
  `province` varchar(120) NOT NULL DEFAULT 'Eastern Samar',
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `barangays`
--

INSERT INTO `barangays` (`id`, `name`, `municipality`, `province`, `created_at`) VALUES
(1, 'Aguinaldo', 'General MacArthur', 'Eastern Samar', '2026-08-18 21:20:59'),
(2, 'Alang-alang', 'General MacArthur', 'Eastern Samar', '2026-08-18 21:20:59'),
(3, 'Binalay', 'General MacArthur', 'Eastern Samar', '2026-08-18 21:20:59'),
(4, 'Calutan', 'General MacArthur', 'Eastern Samar', '2026-08-18 21:20:59'),
(5, 'Camcuevas', 'General MacArthur', 'Eastern Samar', '2026-08-18 21:20:59'),
(6, 'Domrog', 'General MacArthur', 'Eastern Samar', '2026-08-18 21:20:59'),
(7, 'Limbujan', 'General MacArthur', 'Eastern Samar', '2026-08-18 21:20:59'),
(8, 'Macapagal', 'General MacArthur', 'Eastern Samar', '2026-08-18 21:20:59'),
(9, 'Magsaysay', 'General MacArthur', 'Eastern Samar', '2026-08-18 21:20:59'),
(10, 'Osmeña', 'General MacArthur', 'Eastern Samar', '2026-08-18 21:20:59'),
(11, 'Pingan', 'General MacArthur', 'Eastern Samar', '2026-08-18 21:20:59'),
(12, 'Laurel', 'General MacArthur', 'Eastern Samar', '2026-08-18 21:20:59'),
(13, 'Roxas', 'General MacArthur', 'Eastern Samar', '2026-08-18 21:20:59'),
(14, 'Quezon', 'General MacArthur', 'Eastern Samar', '2026-08-18 21:20:59'),
(15, 'Quirino', 'General MacArthur', 'Eastern Samar', '2026-08-18 21:20:59'),
(16, 'San Isidro', 'General MacArthur', 'Eastern Samar', '2026-08-18 21:20:59'),
(17, 'San Roque', 'General MacArthur', 'Eastern Samar', '2026-08-18 21:20:59'),
(18, 'Santa Cruz (Opong)', 'General MacArthur', 'Eastern Samar', '2026-08-18 21:20:59'),
(19, 'Santa Fe', 'General MacArthur', 'Eastern Samar', '2026-08-18 21:20:59'),
(20, 'Tandang Sora', 'General MacArthur', 'Eastern Samar', '2026-08-18 21:20:59'),
(21, 'Tugop', 'General MacArthur', 'Eastern Samar', '2026-08-18 21:20:59'),
(22, 'Vigan', 'General MacArthur', 'Eastern Samar', '2026-08-18 21:20:59'),
(23, 'Barangay 1 (Poblacion)', 'General MacArthur', 'Eastern Samar', '2026-08-18 21:20:59'),
(24, 'Barangay 2 (Poblacion)', 'General MacArthur', 'Eastern Samar', '2026-08-18 21:20:59'),
(25, 'Barangay 3 (Poblacion)', 'General MacArthur', 'Eastern Samar', '2026-08-18 21:20:59'),
(26, 'Barangay 4 (Poblacion)', 'General MacArthur', 'Eastern Samar', '2026-08-18 21:20:59'),
(27, 'Barangay 5 (Poblacion)', 'General MacArthur', 'Eastern Samar', '2026-08-18 21:20:59'),
(28, 'Barangay 6 (Poblacion)', 'General MacArthur', 'Eastern Samar', '2026-08-18 21:20:59'),
(29, 'Barangay 7 (Poblacion)', 'General MacArthur', 'Eastern Samar', '2026-08-18 21:20:59'),
(30, 'Barangay 8 (Poblacion)', 'General MacArthur', 'Eastern Samar', '2026-08-18 21:20:59');

-- --------------------------------------------------------

--
-- Table structure for table `employers`
--

CREATE TABLE `employers` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `business_name` varchar(180) NOT NULL,
  `business_address` varchar(255) DEFAULT NULL,
  `business_type` varchar(120) DEFAULT NULL,
  `industry` varchar(120) DEFAULT NULL,
  `contact_person` varchar(140) DEFAULT NULL,
  `company_description` text DEFAULT NULL,
  `logo_path` varchar(255) DEFAULT NULL,
  `business_permit_path` varchar(255) DEFAULT NULL,
  `supporting_document_path` varchar(255) DEFAULT NULL,
  `verification_status` enum('pending','verified','rejected') NOT NULL DEFAULT 'pending',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employers`
--

INSERT INTO `employers` (`id`, `user_id`, `business_name`, `business_address`, `business_type`, `industry`, `contact_person`, `company_description`, `logo_path`, `business_permit_path`, `supporting_document_path`, `verification_status`, `created_at`, `updated_at`) VALUES
(1, 3, 'ABC Construction', 'Aguinaldo, General MacArthur, Eastern Samar', 'Contractor', 'Construction', 'Ramon Abella', 'Local construction and maintenance services.', 'uploads/logos/20260830113548-5b45eb3a2e.jpg', NULL, NULL, 'pending', '2026-08-18 21:20:59', '2026-09-01 08:02:31'),
(2, 11, 'sfsefsefse', 'sefsefsefs', 'sfsefe', 'fsefsefe', 'dexter', NULL, NULL, NULL, NULL, 'verified', '2026-08-19 14:44:23', '2026-08-19 15:25:03'),
(3, 16, 'sfseffsrserer', 'sefsefsefsedfe', 'zsefefsse', 'sefseseseresrvs', 'Dexter Cardona', '', 'uploads/logos/20260819133043-a871e5ac79.jpg', NULL, NULL, 'pending', '2026-08-19 19:28:10', '2026-08-30 16:50:26');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` int(11) NOT NULL,
  `employer_id` int(11) NOT NULL,
  `barangay_id` int(11) DEFAULT NULL,
  `title` varchar(180) NOT NULL,
  `description` text NOT NULL,
  `category` varchar(120) NOT NULL,
  `required_skills` text DEFAULT NULL,
  `education_requirement` varchar(140) DEFAULT NULL,
  `experience_years` int(11) NOT NULL DEFAULT 0,
  `salary_min` decimal(10,2) DEFAULT NULL,
  `salary_max` decimal(10,2) DEFAULT NULL,
  `employment_type` enum('Full-Time','Part-Time','Contractual','Temporary','Internship','Work From Home') NOT NULL,
  `vacancies` int(11) NOT NULL DEFAULT 1,
  `location` varchar(180) DEFAULT NULL,
  `contact_info` varchar(180) DEFAULT NULL,
  `deadline` date DEFAULT NULL,
  `status` enum('draft','pending','approved','active','rejected','closed','archived','expired') NOT NULL DEFAULT 'draft',
  `rejection_reason` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `employer_id`, `barangay_id`, `title`, `description`, `category`, `required_skills`, `education_requirement`, `experience_years`, `salary_min`, `salary_max`, `employment_type`, `vacancies`, `location`, `contact_info`, `deadline`, `status`, `rejection_reason`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Masonry Worker', 'Assist in hollow block laying and wall repair.', 'Construction', 'Masonry, Carpentry', 'High School', 1, 700.00, 900.00, 'Contractual', 3, 'Aguinaldo, General MacArthur', '0917-111-2222', '2026-09-17', 'active', '', '2026-08-18 21:20:59', '2026-08-27 21:06:06'),
(2, 1, 2, 'Maintenance Helper', 'Support repair, painting, and general maintenance tasks.', 'Construction', 'Plumbing, Carpentry, Electrical Installation', 'High School', 1, 650.00, 850.00, 'Part-Time', 2, 'Alang-alang, General MacArthur', '0917-111-2222', '2026-09-07', 'approved', NULL, '2026-08-18 21:20:59', NULL),
(3, 3, 23, 'adwa', 'adwadasdr', 'adawwa', 'adawd', 'awda', 0, 1222.00, 1999.00, 'Part-Time', 1, 'General MacArthur', '0917-555-0182', '2026-08-31', 'pending', NULL, '2026-08-30 16:02:10', NULL),
(4, 3, 1, 'adwad', 'addaw', 'adaw', 'awda', 'ada', 0, 12.00, 111.00, 'Contractual', 2, 'General MacArthur', '0917-555-0182', '2026-09-14', 'closed', NULL, '2026-08-30 16:02:37', '2026-08-30 16:23:00');

-- --------------------------------------------------------

--
-- Table structure for table `job_seekers`
--

CREATE TABLE `job_seekers` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `birthdate` date DEFAULT NULL,
  `gender` varchar(30) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `education` varchar(120) DEFAULT NULL,
  `employment_status` enum('unemployed','employed','underemployed','student','fresh_graduate') DEFAULT 'unemployed',
  `previous_employer` varchar(160) DEFAULT NULL,
  `position` varchar(120) DEFAULT NULL,
  `years_experience` int(11) NOT NULL DEFAULT 0,
  `previous_salary` decimal(10,2) DEFAULT NULL,
  `expected_salary` decimal(10,2) DEFAULT NULL,
  `skills` text DEFAULT NULL,
  `soft_skills` text DEFAULT NULL,
  `certifications` text DEFAULT NULL,
  `licenses` text DEFAULT NULL,
  `profile_photo` varchar(255) DEFAULT NULL,
  `resume_path` varchar(255) DEFAULT NULL,
  `certificate_path` varchar(255) DEFAULT NULL,
  `looking_for_work` tinyint(1) NOT NULL DEFAULT 1,
  `verification_status` enum('pending','verified','rejected') NOT NULL DEFAULT 'pending',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `job_seekers`
--

INSERT INTO `job_seekers` (`id`, `user_id`, `birthdate`, `gender`, `address`, `education`, `employment_status`, `previous_employer`, `position`, `years_experience`, `previous_salary`, `expected_salary`, `skills`, `soft_skills`, `certifications`, `licenses`, `profile_photo`, `resume_path`, `certificate_path`, `looking_for_work`, `verification_status`, `created_at`, `updated_at`) VALUES
(2, 5, '1997-09-02', 'Female', 'Alang-alang, General MacArthur, Eastern Samar', 'Vocational', 'underemployed', NULL, 'Caregiver', 2, NULL, 700.00, 'Caregiving, Housekeeping, Customer Service', 'Patience, Communication', 'Caregiving NC II', NULL, NULL, NULL, NULL, 1, 'verified', '2026-08-18 21:20:59', NULL),
(3, 8, NULL, '', 'Barangay 1, General MacArthur, Eastern Samar', 'College', 'unemployed', '', '', 0, NULL, NULL, 'masonary', '', '', '', 'uploads/profiles/20260820145609-1149419ec8.jpg', NULL, NULL, 1, 'pending', '2026-08-19 13:55:28', '2026-08-27 11:53:13'),
(5, 10, NULL, NULL, 'Tugop', 'College', 'unemployed', NULL, NULL, 0, NULL, NULL, 'Masonary', NULL, NULL, NULL, NULL, NULL, NULL, 1, 'verified', '2026-08-19 14:37:06', NULL),
(6, 13, NULL, NULL, 'Tugop', 'College', 'unemployed', NULL, NULL, 0, NULL, NULL, 'Carpentry', NULL, NULL, NULL, NULL, NULL, NULL, 1, 'pending', '2026-08-19 16:17:36', NULL),
(7, 18, NULL, NULL, 'National Road', '', 'unemployed', NULL, NULL, 0, NULL, NULL, 'sefsefsef', NULL, NULL, NULL, NULL, NULL, NULL, 1, 'pending', '2026-08-27 11:55:29', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(180) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `is_seen` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `title`, `message`, `is_read`, `is_seen`, `created_at`) VALUES
(1, 8, 'Profile verified', 'Your LaborMatch job seeker profile has been verified.', 0, 1, '2026-08-19 13:59:45'),
(2, 8, 'Profile verified', 'Your LaborMatch job seeker profile has been verified.', 0, 1, '2026-08-19 13:59:52'),
(7, 2, 'New job seeker account', 'Mariel Aliporo registered and is waiting for profile verification.', 1, 1, '2026-08-19 14:37:06'),
(8, 10, 'Registration received', 'Your job seeker account was created. Please complete your profile for verification.', 1, 1, '2026-08-19 14:37:06'),
(9, 10, 'Profile verified', 'Your LaborMatch job seeker profile has been verified.', 1, 1, '2026-08-19 14:37:58'),
(10, 3, 'Job post updated', 'Your job post \"Masonry Worker\" is now Approved.', 1, 1, '2026-08-19 14:39:46'),
(11, 10, 'Profile verified', 'Your LaborMatch job seeker profile has been verified.', 1, 1, '2026-08-19 14:42:03'),
(13, 11, 'Registration received', 'Your employer account was created. Please complete your company profile for verification.', 1, 1, '2026-08-19 14:44:23'),
(14, 11, 'Employer verification updated', 'Your employer verification status is now verified.', 1, 1, '2026-08-19 15:24:05'),
(15, 11, 'Employer verification updated', 'Your employer verification status is now verified.', 1, 1, '2026-08-19 15:24:12'),
(16, 11, 'Employer verification updated', 'Your employer verification status is now verified.', 1, 1, '2026-08-19 15:24:14'),
(17, 11, 'Employer verification updated', 'Your employer verification status is now verified.', 1, 1, '2026-08-19 15:24:14'),
(18, 11, 'Employer verification updated', 'Your employer verification status is now rejected.', 1, 1, '2026-08-19 15:24:24'),
(19, 11, 'Employer verification updated', 'Your employer verification status is now rejected.', 1, 1, '2026-08-19 15:24:31'),
(20, 11, 'Employer verification updated', 'Your employer verification status is now verified.', 1, 1, '2026-08-19 15:24:35'),
(21, 11, 'Employer verification updated', 'Your employer verification status is now verified.', 1, 1, '2026-08-19 15:24:43'),
(22, 11, 'Employer verification updated', 'Your employer verification status is now verified.', 1, 1, '2026-08-19 15:24:45'),
(23, 11, 'Employer verification updated', 'Your employer verification status is now verified.', 1, 1, '2026-08-19 15:24:59'),
(24, 11, 'Employer verification updated', 'Your employer verification status is now verified.', 1, 1, '2026-08-19 15:25:03'),
(30, 2, 'New job seeker account', 'sghjbn registered and is waiting for profile verification.', 0, 1, '2026-08-19 16:17:36'),
(31, 13, 'Registration received', 'Your job seeker account was created. Please complete your profile for verification.', 0, 0, '2026-08-19 16:17:36'),
(35, 16, 'Registration received', 'Your employer account was created. Please complete your company profile for verification.', 1, 1, '2026-08-19 19:28:10'),
(36, 17, 'Barangay admin account created', 'Your barangay admin account is ready. You can now monitor your assigned barangay.', 0, 0, '2026-08-20 16:44:17'),
(37, 1, 'New job seeker account', 'sqSsq registered and is waiting for profile verification.', 0, 1, '2026-08-27 11:55:29'),
(38, 2, 'New job seeker account', 'sqSsq registered and is waiting for profile verification.', 0, 0, '2026-08-27 11:55:29'),
(39, 18, 'Registration received', 'Your job seeker account was created. Please complete your profile for verification.', 0, 0, '2026-08-27 11:55:29'),
(40, 3, 'Job post updated', 'Your job post \"Masonry Worker\" is now Closed.', 0, 1, '2026-08-27 21:05:56'),
(41, 3, 'Job post updated', 'Your job post \"Masonry Worker\" is now Active.', 0, 1, '2026-08-27 21:06:06'),
(42, 1, 'New job post for approval', 'sfseffsrserer submitted \"adwa\" for review.', 0, 1, '2026-08-30 16:02:10'),
(43, 3, 'New job application', 'Dexter Cardona applied for \"Maintenance Helper\".', 0, 1, '2026-08-30 16:37:37'),
(44, 1, 'New job application', 'Dexter Cardona applied for \"Maintenance Helper\" at ABC Construction.', 0, 1, '2026-08-30 16:37:37'),
(45, 7, 'New job application', 'Dexter Cardona applied for \"Maintenance Helper\" at ABC Construction.', 0, 0, '2026-08-30 16:37:37'),
(46, 17, 'New job application', 'Dexter Cardona applied for \"Maintenance Helper\" at ABC Construction.', 0, 0, '2026-08-30 16:37:37'),
(47, 5, 'Application updated', 'Your application status is now shortlisted.', 0, 0, '2026-08-30 16:39:19'),
(48, 5, 'Application updated', 'Your application status is now screening.', 0, 0, '2026-08-30 17:13:01'),
(49, 5, 'Application updated', 'Your application status is now screening.', 0, 0, '2026-08-30 17:13:04'),
(50, 5, 'Application updated', 'Your application status is now screening.', 0, 0, '2026-08-30 17:13:12'),
(51, 5, 'Application updated', 'Your application status is now interview.', 0, 0, '2026-08-30 17:15:21'),
(52, 5, 'Interview scheduled', 'An interview has been scheduled for your application.', 0, 0, '2026-08-30 17:25:01');

-- --------------------------------------------------------

--
-- Table structure for table `saved_jobs`
--

CREATE TABLE `saved_jobs` (
  `id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `jobseeker_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `skills`
--

CREATE TABLE `skills` (
  `id` int(11) NOT NULL,
  `category` varchar(120) NOT NULL,
  `name` varchar(120) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `skills`
--

INSERT INTO `skills` (`id`, `category`, `name`, `created_at`) VALUES
(4, 'Construction', 'Masonry', '2026-08-18 21:20:59'),
(5, 'Construction', 'Carpentry', '2026-08-18 21:20:59'),
(6, 'Construction', 'Welding', '2026-08-18 21:20:59'),
(7, 'Construction', 'Electrical Installation', '2026-08-18 21:20:59'),
(8, 'Construction', 'Plumbing', '2026-08-18 21:20:59'),
(9, 'Hospitality', 'Cooking', '2026-08-18 21:20:59'),
(10, 'Hospitality', 'Housekeeping', '2026-08-18 21:20:59'),
(11, 'Hospitality', 'Customer Service', '2026-08-18 21:20:59'),
(12, 'Agriculture', 'Farming', '2026-08-18 21:20:59'),
(13, 'Agriculture', 'Livestock Management', '2026-08-18 21:20:59'),
(14, 'Agriculture', 'Fishing', '2026-08-18 21:20:59');

-- --------------------------------------------------------

--
-- Table structure for table `trainings`
--

CREATE TABLE `trainings` (
  `id` int(11) NOT NULL,
  `title` varchar(180) NOT NULL,
  `provider` varchar(160) NOT NULL,
  `category` varchar(120) NOT NULL,
  `description` text DEFAULT NULL,
  `slots` int(11) NOT NULL DEFAULT 0,
  `location` varchar(180) DEFAULT NULL,
  `status` enum('open','closed','completed','cancelled') NOT NULL DEFAULT 'open',
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `trainings`
--

INSERT INTO `trainings` (`id`, `title`, `provider`, `category`, `description`, `slots`, `location`, `status`, `start_date`, `end_date`, `created_at`) VALUES
(1, 'Welding NC II Training', 'TESDA', 'Construction', 'Skills training for local welding certification.', 25, 'General MacArthur Training Center', 'open', '2026-08-28', '2026-09-27', '2026-08-18 21:20:59'),
(2, 'Job Readiness Seminar', 'Municipal Employment Office', 'Employment', 'Resume writing, interview preparation, and workplace orientation.', 60, 'Municipal Hall', 'open', '2026-08-23', '2026-08-23', '2026-08-18 21:20:59');

-- --------------------------------------------------------

--
-- Table structure for table `training_registrations`
--

CREATE TABLE `training_registrations` (
  `id` int(11) NOT NULL,
  `training_id` int(11) NOT NULL,
  `jobseeker_id` int(11) NOT NULL,
  `status` enum('registered','attended','completed','cancelled') NOT NULL DEFAULT 'registered',
  `certificate_path` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `training_registrations`
--

INSERT INTO `training_registrations` (`id`, `training_id`, `jobseeker_id`, `status`, `certificate_path`, `created_at`) VALUES
(1, 2, 3, 'registered', NULL, '2026-08-19 13:57:30'),
(2, 1, 3, 'cancelled', NULL, '2026-08-20 16:53:07');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `barangay_id` int(11) DEFAULT NULL,
  `name` varchar(140) NOT NULL,
  `email` varchar(140) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('municipal_admin','barangay_admin','employer','jobseeker') NOT NULL,
  `contact_number` varchar(40) DEFAULT NULL,
  `profile_photo` varchar(255) DEFAULT NULL,
  `status` enum('pending','active','verified','suspended','rejected') NOT NULL DEFAULT 'pending',
  `email_verified_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `barangay_id`, `name`, `email`, `password_hash`, `role`, `contact_number`, `profile_photo`, `status`, `email_verified_at`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Administrator', 'genmac@gmail.com', '$2y$10$VmqIunlDNyxiDDmVzc6l5upEV8pFr3nJKFSbx9HxoTHfY6YJrPrAm', 'municipal_admin', '09554555657', NULL, 'verified', '2026-08-18 21:20:59', '2026-08-18 21:20:59', '2026-09-09 17:56:57'),
(2, 1, 'Barangay Employment Admin', 'barangay@generalmacarthur.gov.ph', '$2y$10$8RxvJKI4CEsr2KeKGKaILuQ2xj2/Np3Q5YpnHIFYjp9BJXZQ/3jCe', 'barangay_admin', '055-000-0002', 'uploads/profiles/20260819081324-c46f3f41f0.png', 'verified', '2026-08-18 21:20:59', '2026-08-18 21:20:59', '2026-08-31 16:41:29'),
(3, 1, 'ABC Construction', 'employer@example.com', '$2y$10$ewYQYTAxKFy0EdI8SH5QheXrMa.AzcIIRUbVcymHdvuLqL6y6w4ja', 'employer', '0917-111-2222', NULL, 'verified', '2026-08-18 21:20:59', '2026-08-18 21:20:59', '2026-09-01 08:02:31'),
(5, 2, 'Maria Santos', 'maria@example.com', '$2y$10$S3Vwdf7ia7vcmRPNs1xmR.qas3PTNxj2HLPLbcwI2z2.qHiA5vqCu', 'jobseeker', '0917-555-0183', NULL, 'verified', '2026-08-18 21:20:59', '2026-08-18 21:20:59', NULL),
(7, 2, 'Dexter Cardona', 'dextercardona@gmail.com', '$2y$10$aWyKpcm269FRUTruP/yy.uCXe0p4wbIqug.qGPTuF01R07XzduPMa', 'barangay_admin', '0917-555-0182', 'uploads/profiles/20260819133244-40d74f2f45.jpg', 'verified', '2026-08-18 22:18:00', '2026-08-18 22:18:00', '2026-08-19 19:32:44'),
(8, 29, 'Dexter Cardona', 'dexter@gmail.com', '$2y$10$5bTG.LrOhAmQC30wJZUdVOXQvd/CwdEWJFnKEAv3as9PlJD75ScbG', 'jobseeker', '0917-555-0182', NULL, 'verified', NULL, '2026-08-19 13:55:28', '2026-08-27 11:53:13'),
(10, 1, 'Mariel Aliporo', 'mariel@gmail.com', '$2y$10$OMpViMISPR9w7fdePV12Q.xzFKbfGY20/eDKoOq.f3Dgk3u/7CXvC', 'jobseeker', '0917-555-0182', NULL, 'verified', NULL, '2026-08-19 14:37:06', NULL),
(11, 1, 'dexter', 'dc@gmail.com', '$2y$10$1zQn3TmK/IrI4MGJRKDL.eQVrvrI6Hav2otx1sv338Ohfslm12Dmq', 'employer', '0917-555-0182', NULL, 'verified', NULL, '2026-08-19 14:44:23', NULL),
(13, 1, 'sghjbn', 'qwerty@gmail.com', '$2y$10$7UHvd6Af4MtKqPuvkWmghOk5VR8lgn2TcjVl4YgDUJ.W0Baddlrli', 'jobseeker', '0917-555-0182', NULL, 'active', NULL, '2026-08-19 16:17:36', NULL),
(16, 19, 'Dexter Cardona', 'dx@gmail.com', '$2y$10$Sje2P0KuHrbvEU7imMCKhOFaoBsGVb64YH84LyETlyx5vZvIXgtT.', 'employer', '0917-555-0182', NULL, 'pending', NULL, '2026-08-19 19:28:10', '2026-08-30 16:50:26'),
(17, 2, 'esfsefe', 'a@gamil.com', '$2y$10$JezbX20xXGOKNXnN0NtC6OLiPPZz9NAa0TNfnUKI.VgprZP/XyFLG', 'barangay_admin', '0917-555-0182', NULL, 'verified', '2026-08-20 16:44:17', '2026-08-20 16:44:17', NULL),
(18, 1, 'sqSsq', '123@gmail.com', '$2y$10$tZxvKpI7z35WXytec/Qglu65riafPAeTpv5KvEAH4MR7msT3iN2zS', 'jobseeker', '09070737740', NULL, 'active', NULL, '2026-08-27 11:55:29', NULL);

--
-- Triggers `users`
--
DELIMITER $$
CREATE TRIGGER `trg_users_one_barangay_admin_insert` BEFORE INSERT ON `users` FOR EACH ROW BEGIN
  IF NEW.role = 'municipal_admin' AND EXISTS (
    SELECT 1 FROM users WHERE role = 'municipal_admin' LIMIT 1
  ) THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'General MacArthur already has a municipal admin.';
  END IF;

  IF NEW.role = 'barangay_admin' AND NEW.barangay_id IS NOT NULL AND EXISTS (
    SELECT 1 FROM users WHERE role = 'barangay_admin' AND barangay_id = NEW.barangay_id LIMIT 1
  ) THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'This barangay already has a barangay admin.';
  END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_users_one_barangay_admin_update` BEFORE UPDATE ON `users` FOR EACH ROW BEGIN
  IF NEW.role = 'municipal_admin'
    AND OLD.role <> NEW.role
    AND EXISTS (
      SELECT 1 FROM users WHERE role = 'municipal_admin' AND id <> NEW.id LIMIT 1
    ) THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'General MacArthur already has a municipal admin.';
  END IF;

  IF NEW.role = 'barangay_admin'
    AND NEW.barangay_id IS NOT NULL
    AND (OLD.role <> NEW.role OR COALESCE(OLD.barangay_id, 0) <> COALESCE(NEW.barangay_id, 0))
    AND EXISTS (
      SELECT 1 FROM users WHERE role = 'barangay_admin' AND barangay_id = NEW.barangay_id AND id <> NEW.id LIMIT 1
    ) THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'This barangay already has a barangay admin.';
  END IF;
END
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_log_user` (`user_id`);

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_ann_user` (`created_by`);

--
-- Indexes for table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_application` (`job_id`,`jobseeker_id`),
  ADD KEY `fk_app_seeker` (`jobseeker_id`);

--
-- Indexes for table `badge_views`
--
ALTER TABLE `badge_views`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_user_badge` (`user_id`,`badge_key`);

--
-- Indexes for table `barangays`
--
ALTER TABLE `barangays`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employers`
--
ALTER TABLE `employers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_jobs_employer` (`employer_id`),
  ADD KEY `fk_jobs_barangay` (`barangay_id`);

--
-- Indexes for table `job_seekers`
--
ALTER TABLE `job_seekers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_notif_user` (`user_id`);

--
-- Indexes for table `saved_jobs`
--
ALTER TABLE `saved_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_saved_job` (`job_id`,`jobseeker_id`),
  ADD KEY `fk_saved_seeker` (`jobseeker_id`);

--
-- Indexes for table `skills`
--
ALTER TABLE `skills`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_skill` (`category`,`name`);

--
-- Indexes for table `trainings`
--
ALTER TABLE `trainings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `training_registrations`
--
ALTER TABLE `training_registrations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_training_registration` (`training_id`,`jobseeker_id`),
  ADD KEY `fk_tr_seeker` (`jobseeker_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_users_barangay` (`barangay_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=353;

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `badge_views`
--
ALTER TABLE `badge_views`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=267;

--
-- AUTO_INCREMENT for table `barangays`
--
ALTER TABLE `barangays`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `employers`
--
ALTER TABLE `employers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `job_seekers`
--
ALTER TABLE `job_seekers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `saved_jobs`
--
ALTER TABLE `saved_jobs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `skills`
--
ALTER TABLE `skills`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `trainings`
--
ALTER TABLE `trainings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `training_registrations`
--
ALTER TABLE `training_registrations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `fk_log_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `announcements`
--
ALTER TABLE `announcements`
  ADD CONSTRAINT `fk_ann_user` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `applications`
--
ALTER TABLE `applications`
  ADD CONSTRAINT `fk_app_job` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_app_seeker` FOREIGN KEY (`jobseeker_id`) REFERENCES `job_seekers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `badge_views`
--
ALTER TABLE `badge_views`
  ADD CONSTRAINT `fk_badge_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `employers`
--
ALTER TABLE `employers`
  ADD CONSTRAINT `fk_employers_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `jobs`
--
ALTER TABLE `jobs`
  ADD CONSTRAINT `fk_jobs_barangay` FOREIGN KEY (`barangay_id`) REFERENCES `barangays` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_jobs_employer` FOREIGN KEY (`employer_id`) REFERENCES `employers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `job_seekers`
--
ALTER TABLE `job_seekers`
  ADD CONSTRAINT `fk_seekers_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `fk_notif_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `saved_jobs`
--
ALTER TABLE `saved_jobs`
  ADD CONSTRAINT `fk_saved_job` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_saved_seeker` FOREIGN KEY (`jobseeker_id`) REFERENCES `job_seekers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `training_registrations`
--
ALTER TABLE `training_registrations`
  ADD CONSTRAINT `fk_tr_seeker` FOREIGN KEY (`jobseeker_id`) REFERENCES `job_seekers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_tr_training` FOREIGN KEY (`training_id`) REFERENCES `trainings` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_barangay` FOREIGN KEY (`barangay_id`) REFERENCES `barangays` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
