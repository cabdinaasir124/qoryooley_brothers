-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 26, 2025 at 03:09 PM
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
-- Database: `orphan_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `academic_years`
--

CREATE TABLE `academic_years` (
  `id` int(11) NOT NULL,
  `year_name` varchar(9) NOT NULL,
  `is_current` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `academic_years`
--

INSERT INTO `academic_years` (`id`, `year_name`, `is_current`, `created_at`) VALUES
(1, '2025/2026', 1, '2025-07-24 18:28:34'),
(2, '2026/2027', 0, '2025-07-24 18:28:34'),
(3, '2027/2028', 0, '2025-07-24 18:28:34'),
(4, '2028/2029', 0, '2025-07-24 18:28:34'),
(5, '2029/2030', 0, '2025-07-24 18:28:34');

-- --------------------------------------------------------

--
-- Table structure for table `activities`
--

CREATE TABLE `activities` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `activity_date` date NOT NULL,
  `type` enum('academic','sports','social','religious','other') DEFAULT 'other',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activities`
--

INSERT INTO `activities` (`id`, `title`, `description`, `activity_date`, `type`, `created_at`) VALUES
(1, 'Science Fair', 'Annual science exhibition for all classes.', '2025-08-20', 'academic', '2025-07-31 14:35:56');

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `target_audience` enum('student','teachers','parents','admin','all') DEFAULT 'all',
  `type` enum('school','quran','both') DEFAULT 'both',
  `posted_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `read_by` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`read_by`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`id`, `title`, `body`, `target_audience`, `type`, `posted_by`, `created_at`, `read_by`) VALUES
(17, 'Midterm Exams Start Next Week', 'Prepare well! The exam schedule has been published in the exams section.', 'student', 'school', 24, '2025-07-29 19:19:59', NULL),
(18, 'exam around the corner ', 'please make fit shdhiono', '', 'school', 24, '2025-07-30 09:58:36', NULL),
(19, 'Please nothing ', 'nwlfwfjfwjfwffhwnjlnwhwfwhifnfnwiownlwuowhowfqqohwjwqwqfklqwdal', 'student', 'school', 24, '2025-07-30 11:06:12', NULL),
(20, 'exam coming soon', 'dhawaan waxaa fooda inagu soo haawyo imtixaanka bileedka', 'student', 'school', 24, '2025-07-30 16:52:04', NULL),
(21, 'imtixaan bileed', 'New exam titled \'imtixaan bileed\' has been scheduled for term \'Term 1\' on 2025-08-08.', 'student', 'school', 24, '2025-08-02 12:17:24', NULL),
(22, 'imtixaan bileed', 'New exam titled \'imtixaan bileed\' has been scheduled for term \'Term 1\' on 2025-08-08.', 'student', 'school', 24, '2025-08-02 12:17:24', NULL),
(23, 'imtixaan bileed', 'New exam titled \'imtixaan bileed\' has been scheduled for term \'Term 1\' on 2025-08-02.', 'student', 'school', 24, '2025-08-02 12:23:42', NULL),
(24, 'imtixaan bileed', 'New exam titled \'imtixaan bileed\' has been scheduled for term \'Term 1\' on 2025-08-02.', 'student', 'school', 24, '2025-08-02 12:23:42', NULL),
(25, 'imtixaan bilee', 'New exam titled \'imtixaan bilee\' has been scheduled for term \'Term 1\' on 2025-08-01.', 'student', 'school', 24, '2025-08-02 12:26:48', NULL),
(26, 'imtixaan bilee', 'New exam titled \'imtixaan bilee\' has been scheduled for term \'Term 1\' on 2025-08-01.', 'student', 'school', 24, '2025-08-02 12:26:48', NULL),
(27, 'imtixaan bileed', 'New exam titled \'imtixaan bileed\' has been scheduled for term \'Term 1\' on 2025-08-01.', 'student', 'school', 24, '2025-08-02 12:27:52', NULL),
(28, 'imtixaan bileed', 'New exam titled \'imtixaan bileed\' has been scheduled for term \'Term 1\' on 2025-08-01.', 'student', 'school', 24, '2025-08-02 12:27:52', NULL),
(29, 'imtixaanka bileedka', 'New exam titled \'imtixaanka bileedka\' has been scheduled for term \'Term 1\' on 2025-08-09.', 'student', 'school', 24, '2025-08-02 12:35:01', NULL),
(30, 'imtixaanka bileedka', 'New exam titled \'imtixaanka bileedka\' has been scheduled for term \'Term 1\' on 2025-08-09.', 'student', 'school', 24, '2025-08-02 12:35:01', NULL),
(31, 'imtix', 'New exam titled \'imtix\' has been scheduled for term \'Term 1\' on 2025-08-02.', 'student', 'school', 24, '2025-08-02 12:38:24', NULL),
(32, 'imtix', 'New exam titled \'imtix\' has been scheduled for term \'Term 1\' on 2025-08-02.', 'student', 'school', 24, '2025-08-02 12:38:25', NULL),
(33, 'imtixaanka', 'New exam titled \'imtixaanka\' has been scheduled for term \'Term 1\' on 2025-08-01.', 'student', 'school', 24, '2025-08-02 12:56:57', NULL),
(34, 'imtixaanka', 'New exam titled \'imtixaanka\' has been scheduled for term \'Term 1\' on 2025-08-01.', 'student', 'school', 24, '2025-08-02 12:56:57', NULL),
(35, 'imtixaanka', 'New exam titled \'imtixaanka\' has been scheduled for term \'Term 1\' on 2025-08-02.', 'student', 'school', 24, '2025-08-02 13:03:36', NULL),
(36, 'imtixaanka', 'New exam titled \'imtixaanka\' has been scheduled for term \'Term 1\' on 2025-08-02.', 'student', 'school', 24, '2025-08-02 13:03:36', NULL),
(37, 'imtixaanka bilaha', 'New exam titled \'imtixaanka bilaha\' has been scheduled for term \'Term 1\' on 2025-08-02.', 'student', 'school', 24, '2025-08-02 13:05:19', NULL),
(38, 'imtixaanka bilaha', 'New exam titled \'imtixaanka bilaha\' has been scheduled for term \'Term 1\' on 2025-08-02.', 'student', 'school', 24, '2025-08-02 13:05:19', NULL),
(39, 'waxaa nagu soo wajahan imtixaanka', 'all', 'all', 'both', 24, '2025-08-12 16:38:34', NULL),
(40, 'Exam notice!', 'dhawaan waxaa nagu soo aadan imtixaanka', 'all', 'school', 24, '2025-08-23 14:13:30', NULL),
(41, 'ogaysiis', 'waxaa lagu ogaysiinaayaa inaad nagala qeyb qaadataan barnaamijkeena', 'all', 'school', 24, '2025-08-24 22:14:09', NULL),
(42, 'ogaysiis ', 'dhamaan waxaa lagu ogaysiinaayaa inaad nagala qeyb qaadataan barnaamijkeena ', 'teachers', 'both', 24, '2025-08-24 22:15:07', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `announcement_reads`
--

CREATE TABLE `announcement_reads` (
  `id` int(11) NOT NULL,
  `announcement_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `read_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `announcement_reads`
--

INSERT INTO `announcement_reads` (`id`, `announcement_id`, `user_id`, `read_at`) VALUES
(4, 8, 24, '2025-07-29 10:56:55'),
(5, 8, 24, '2025-07-29 11:40:40'),
(6, 8, 24, '2025-07-29 12:04:00'),
(7, 9, 24, '2025-07-29 12:04:00'),
(9, 8, 24, '2025-07-29 12:11:53'),
(10, 9, 24, '2025-07-29 12:11:53'),
(11, 10, 24, '2025-07-29 12:11:53'),
(12, 11, 24, '2025-07-29 12:11:53'),
(16, 8, 24, '2025-07-29 12:13:06'),
(17, 9, 24, '2025-07-29 12:13:06'),
(18, 10, 24, '2025-07-29 12:13:06'),
(19, 11, 24, '2025-07-29 12:13:06'),
(20, 12, 24, '2025-07-29 12:13:06'),
(21, 13, 24, '2025-07-29 12:13:06'),
(23, 8, 24, '2025-07-29 16:43:33'),
(24, 9, 24, '2025-07-29 16:43:33'),
(25, 10, 24, '2025-07-29 16:43:33'),
(26, 11, 24, '2025-07-29 16:43:33'),
(27, 12, 24, '2025-07-29 16:43:33'),
(28, 13, 24, '2025-07-29 16:43:33'),
(29, 14, 24, '2025-07-29 16:43:33'),
(30, 15, 24, '2025-07-29 16:43:33'),
(38, 8, 25, '2025-07-29 16:58:12'),
(39, 9, 25, '2025-07-29 16:58:12'),
(40, 10, 25, '2025-07-29 16:58:12'),
(41, 11, 25, '2025-07-29 16:58:12'),
(42, 12, 25, '2025-07-29 16:58:12'),
(43, 13, 25, '2025-07-29 16:58:12'),
(44, 14, 25, '2025-07-29 16:58:12'),
(45, 15, 25, '2025-07-29 16:58:12'),
(53, 8, 25, '2025-07-29 19:07:30'),
(54, 9, 25, '2025-07-29 19:07:30'),
(55, 10, 25, '2025-07-29 19:07:30'),
(56, 11, 25, '2025-07-29 19:07:30'),
(57, 12, 25, '2025-07-29 19:07:30'),
(58, 13, 25, '2025-07-29 19:07:30'),
(59, 14, 25, '2025-07-29 19:07:30'),
(60, 15, 25, '2025-07-29 19:07:30'),
(61, 16, 25, '2025-07-29 19:07:30'),
(68, 8, 25, '2025-07-29 19:08:04'),
(69, 9, 25, '2025-07-29 19:08:04'),
(70, 10, 25, '2025-07-29 19:08:04'),
(71, 11, 25, '2025-07-29 19:08:04'),
(72, 12, 25, '2025-07-29 19:08:04'),
(73, 13, 25, '2025-07-29 19:08:04'),
(74, 14, 25, '2025-07-29 19:08:04'),
(75, 15, 25, '2025-07-29 19:08:04'),
(76, 16, 25, '2025-07-29 19:08:04'),
(83, 8, 24, '2025-07-29 19:08:51'),
(84, 9, 24, '2025-07-29 19:08:51'),
(85, 10, 24, '2025-07-29 19:08:51'),
(86, 11, 24, '2025-07-29 19:08:51'),
(87, 12, 24, '2025-07-29 19:08:51'),
(88, 13, 24, '2025-07-29 19:08:51'),
(89, 14, 24, '2025-07-29 19:08:51'),
(90, 15, 24, '2025-07-29 19:08:51'),
(91, 16, 24, '2025-07-29 19:08:51'),
(98, 17, 25, '2025-07-29 19:24:22'),
(99, 17, 25, '2025-07-30 16:49:36'),
(100, 18, 25, '2025-07-30 16:49:36'),
(101, 19, 25, '2025-07-30 16:49:36'),
(102, 17, 25, '2025-07-30 16:52:31'),
(103, 18, 25, '2025-07-30 16:52:31'),
(104, 19, 25, '2025-07-30 16:52:31'),
(105, 20, 25, '2025-07-30 16:52:31'),
(106, 17, 24, '2025-08-12 16:39:00'),
(107, 18, 24, '2025-08-12 16:39:00'),
(108, 19, 24, '2025-08-12 16:39:00'),
(109, 20, 24, '2025-08-12 16:39:00'),
(110, 21, 24, '2025-08-12 16:39:00'),
(111, 22, 24, '2025-08-12 16:39:00'),
(112, 23, 24, '2025-08-12 16:39:00'),
(113, 24, 24, '2025-08-12 16:39:00'),
(114, 25, 24, '2025-08-12 16:39:00'),
(115, 26, 24, '2025-08-12 16:39:00'),
(116, 27, 24, '2025-08-12 16:39:00'),
(117, 28, 24, '2025-08-12 16:39:00'),
(118, 29, 24, '2025-08-12 16:39:00'),
(119, 30, 24, '2025-08-12 16:39:00'),
(120, 31, 24, '2025-08-12 16:39:00'),
(121, 32, 24, '2025-08-12 16:39:00'),
(122, 33, 24, '2025-08-12 16:39:00'),
(123, 34, 24, '2025-08-12 16:39:00'),
(124, 35, 24, '2025-08-12 16:39:00'),
(125, 36, 24, '2025-08-12 16:39:00'),
(126, 37, 24, '2025-08-12 16:39:00'),
(127, 38, 24, '2025-08-12 16:39:00'),
(128, 39, 24, '2025-08-12 16:39:00'),
(137, 17, 26, '2025-08-12 16:42:15'),
(138, 18, 26, '2025-08-12 16:42:15'),
(139, 19, 26, '2025-08-12 16:42:15'),
(140, 20, 26, '2025-08-12 16:42:15'),
(141, 21, 26, '2025-08-12 16:42:15'),
(142, 22, 26, '2025-08-12 16:42:15'),
(143, 23, 26, '2025-08-12 16:42:15'),
(144, 24, 26, '2025-08-12 16:42:15'),
(145, 25, 26, '2025-08-12 16:42:15'),
(146, 26, 26, '2025-08-12 16:42:15'),
(147, 27, 26, '2025-08-12 16:42:15'),
(148, 28, 26, '2025-08-12 16:42:15'),
(149, 29, 26, '2025-08-12 16:42:15'),
(150, 30, 26, '2025-08-12 16:42:15'),
(151, 31, 26, '2025-08-12 16:42:15'),
(152, 32, 26, '2025-08-12 16:42:15'),
(153, 33, 26, '2025-08-12 16:42:15'),
(154, 34, 26, '2025-08-12 16:42:15'),
(155, 35, 26, '2025-08-12 16:42:15'),
(156, 36, 26, '2025-08-12 16:42:15'),
(157, 37, 26, '2025-08-12 16:42:15'),
(158, 38, 26, '2025-08-12 16:42:15'),
(159, 39, 26, '2025-08-12 16:42:15'),
(160, 17, 25, '2025-08-22 20:16:21'),
(161, 18, 25, '2025-08-22 20:16:21'),
(162, 19, 25, '2025-08-22 20:16:21'),
(163, 20, 25, '2025-08-22 20:16:21'),
(164, 21, 25, '2025-08-22 20:16:21'),
(165, 22, 25, '2025-08-22 20:16:21'),
(166, 23, 25, '2025-08-22 20:16:21'),
(167, 24, 25, '2025-08-22 20:16:21'),
(168, 25, 25, '2025-08-22 20:16:21'),
(169, 26, 25, '2025-08-22 20:16:21'),
(170, 27, 25, '2025-08-22 20:16:21'),
(171, 28, 25, '2025-08-22 20:16:21'),
(172, 29, 25, '2025-08-22 20:16:21'),
(173, 30, 25, '2025-08-22 20:16:21'),
(174, 31, 25, '2025-08-22 20:16:21'),
(175, 32, 25, '2025-08-22 20:16:21'),
(176, 33, 25, '2025-08-22 20:16:21'),
(177, 34, 25, '2025-08-22 20:16:21'),
(178, 35, 25, '2025-08-22 20:16:21'),
(179, 36, 25, '2025-08-22 20:16:21'),
(180, 37, 25, '2025-08-22 20:16:21'),
(181, 38, 25, '2025-08-22 20:16:21'),
(182, 39, 25, '2025-08-22 20:16:21'),
(191, 17, 32, '2025-08-22 20:32:53'),
(192, 18, 32, '2025-08-22 20:32:53'),
(193, 19, 32, '2025-08-22 20:32:53'),
(194, 20, 32, '2025-08-22 20:32:53'),
(195, 21, 32, '2025-08-22 20:32:53'),
(196, 22, 32, '2025-08-22 20:32:53'),
(197, 23, 32, '2025-08-22 20:32:53'),
(198, 24, 32, '2025-08-22 20:32:53'),
(199, 25, 32, '2025-08-22 20:32:53'),
(200, 26, 32, '2025-08-22 20:32:53'),
(201, 27, 32, '2025-08-22 20:32:53'),
(202, 28, 32, '2025-08-22 20:32:53'),
(203, 29, 32, '2025-08-22 20:32:53'),
(204, 30, 32, '2025-08-22 20:32:53'),
(205, 31, 32, '2025-08-22 20:32:53'),
(206, 32, 32, '2025-08-22 20:32:53'),
(207, 33, 32, '2025-08-22 20:32:53'),
(208, 34, 32, '2025-08-22 20:32:53'),
(209, 35, 32, '2025-08-22 20:32:53'),
(210, 36, 32, '2025-08-22 20:32:53'),
(211, 37, 32, '2025-08-22 20:32:53'),
(212, 38, 32, '2025-08-22 20:32:53'),
(213, 39, 32, '2025-08-22 20:32:53'),
(222, 17, 24, '2025-08-23 14:13:49'),
(223, 18, 24, '2025-08-23 14:13:49'),
(224, 19, 24, '2025-08-23 14:13:49'),
(225, 20, 24, '2025-08-23 14:13:49'),
(226, 21, 24, '2025-08-23 14:13:49'),
(227, 22, 24, '2025-08-23 14:13:49'),
(228, 23, 24, '2025-08-23 14:13:49'),
(229, 24, 24, '2025-08-23 14:13:49'),
(230, 25, 24, '2025-08-23 14:13:49'),
(231, 26, 24, '2025-08-23 14:13:49'),
(232, 27, 24, '2025-08-23 14:13:49'),
(233, 28, 24, '2025-08-23 14:13:49'),
(234, 29, 24, '2025-08-23 14:13:49'),
(235, 30, 24, '2025-08-23 14:13:49'),
(236, 31, 24, '2025-08-23 14:13:49'),
(237, 32, 24, '2025-08-23 14:13:49'),
(238, 33, 24, '2025-08-23 14:13:49'),
(239, 34, 24, '2025-08-23 14:13:49'),
(240, 35, 24, '2025-08-23 14:13:49'),
(241, 36, 24, '2025-08-23 14:13:49'),
(242, 37, 24, '2025-08-23 14:13:49'),
(243, 38, 24, '2025-08-23 14:13:49'),
(244, 39, 24, '2025-08-23 14:13:49'),
(245, 40, 24, '2025-08-23 14:13:49'),
(253, 17, 25, '2025-08-23 14:15:46'),
(254, 18, 25, '2025-08-23 14:15:46'),
(255, 19, 25, '2025-08-23 14:15:46'),
(256, 20, 25, '2025-08-23 14:15:46'),
(257, 21, 25, '2025-08-23 14:15:46'),
(258, 22, 25, '2025-08-23 14:15:46'),
(259, 23, 25, '2025-08-23 14:15:46'),
(260, 24, 25, '2025-08-23 14:15:46'),
(261, 25, 25, '2025-08-23 14:15:46'),
(262, 26, 25, '2025-08-23 14:15:46'),
(263, 27, 25, '2025-08-23 14:15:46'),
(264, 28, 25, '2025-08-23 14:15:46'),
(265, 29, 25, '2025-08-23 14:15:46'),
(266, 30, 25, '2025-08-23 14:15:46'),
(267, 31, 25, '2025-08-23 14:15:46'),
(268, 32, 25, '2025-08-23 14:15:46'),
(269, 33, 25, '2025-08-23 14:15:46'),
(270, 34, 25, '2025-08-23 14:15:46'),
(271, 35, 25, '2025-08-23 14:15:46'),
(272, 36, 25, '2025-08-23 14:15:46'),
(273, 37, 25, '2025-08-23 14:15:46'),
(274, 38, 25, '2025-08-23 14:15:46'),
(275, 39, 25, '2025-08-23 14:15:46'),
(276, 40, 25, '2025-08-23 14:15:46'),
(277, 17, 25, '2025-08-24 22:14:21'),
(278, 18, 25, '2025-08-24 22:14:21'),
(279, 19, 25, '2025-08-24 22:14:21'),
(280, 20, 25, '2025-08-24 22:14:21'),
(281, 21, 25, '2025-08-24 22:14:21'),
(282, 22, 25, '2025-08-24 22:14:21'),
(283, 23, 25, '2025-08-24 22:14:21'),
(284, 24, 25, '2025-08-24 22:14:21'),
(285, 25, 25, '2025-08-24 22:14:21'),
(286, 26, 25, '2025-08-24 22:14:21'),
(287, 27, 25, '2025-08-24 22:14:21'),
(288, 28, 25, '2025-08-24 22:14:21'),
(289, 29, 25, '2025-08-24 22:14:21'),
(290, 30, 25, '2025-08-24 22:14:21'),
(291, 31, 25, '2025-08-24 22:14:21'),
(292, 32, 25, '2025-08-24 22:14:21'),
(293, 33, 25, '2025-08-24 22:14:21'),
(294, 34, 25, '2025-08-24 22:14:21'),
(295, 35, 25, '2025-08-24 22:14:21'),
(296, 36, 25, '2025-08-24 22:14:21'),
(297, 37, 25, '2025-08-24 22:14:21'),
(298, 38, 25, '2025-08-24 22:14:21'),
(299, 39, 25, '2025-08-24 22:14:21'),
(300, 40, 25, '2025-08-24 22:14:21'),
(301, 41, 25, '2025-08-24 22:14:21'),
(308, 17, 24, '2025-08-24 22:14:26'),
(309, 18, 24, '2025-08-24 22:14:26'),
(310, 19, 24, '2025-08-24 22:14:26'),
(311, 20, 24, '2025-08-24 22:14:26'),
(312, 21, 24, '2025-08-24 22:14:26'),
(313, 22, 24, '2025-08-24 22:14:26'),
(314, 23, 24, '2025-08-24 22:14:26'),
(315, 24, 24, '2025-08-24 22:14:26'),
(316, 25, 24, '2025-08-24 22:14:26'),
(317, 26, 24, '2025-08-24 22:14:26'),
(318, 27, 24, '2025-08-24 22:14:26'),
(319, 28, 24, '2025-08-24 22:14:26'),
(320, 29, 24, '2025-08-24 22:14:26'),
(321, 30, 24, '2025-08-24 22:14:26'),
(322, 31, 24, '2025-08-24 22:14:26'),
(323, 32, 24, '2025-08-24 22:14:26'),
(324, 33, 24, '2025-08-24 22:14:26'),
(325, 34, 24, '2025-08-24 22:14:26'),
(326, 35, 24, '2025-08-24 22:14:26'),
(327, 36, 24, '2025-08-24 22:14:26'),
(328, 37, 24, '2025-08-24 22:14:26'),
(329, 38, 24, '2025-08-24 22:14:26'),
(330, 39, 24, '2025-08-24 22:14:26'),
(331, 40, 24, '2025-08-24 22:14:26'),
(332, 41, 24, '2025-08-24 22:14:26'),
(339, 17, 25, '2025-08-24 22:15:37'),
(340, 18, 25, '2025-08-24 22:15:37'),
(341, 19, 25, '2025-08-24 22:15:37'),
(342, 20, 25, '2025-08-24 22:15:37'),
(343, 21, 25, '2025-08-24 22:15:37'),
(344, 22, 25, '2025-08-24 22:15:37'),
(345, 23, 25, '2025-08-24 22:15:37'),
(346, 24, 25, '2025-08-24 22:15:37'),
(347, 25, 25, '2025-08-24 22:15:37'),
(348, 26, 25, '2025-08-24 22:15:37'),
(349, 27, 25, '2025-08-24 22:15:37'),
(350, 28, 25, '2025-08-24 22:15:37'),
(351, 29, 25, '2025-08-24 22:15:37'),
(352, 30, 25, '2025-08-24 22:15:37'),
(353, 31, 25, '2025-08-24 22:15:37'),
(354, 32, 25, '2025-08-24 22:15:37'),
(355, 33, 25, '2025-08-24 22:15:37'),
(356, 34, 25, '2025-08-24 22:15:37'),
(357, 35, 25, '2025-08-24 22:15:37'),
(358, 36, 25, '2025-08-24 22:15:37'),
(359, 37, 25, '2025-08-24 22:15:37'),
(360, 38, 25, '2025-08-24 22:15:37'),
(361, 39, 25, '2025-08-24 22:15:37'),
(362, 40, 25, '2025-08-24 22:15:37'),
(363, 41, 25, '2025-08-24 22:15:37'),
(364, 42, 25, '2025-08-24 22:15:37'),
(365, 17, 33, '2025-08-25 16:53:08'),
(366, 18, 33, '2025-08-25 16:53:08'),
(367, 19, 33, '2025-08-25 16:53:08'),
(368, 20, 33, '2025-08-25 16:53:08'),
(369, 21, 33, '2025-08-25 16:53:08'),
(370, 22, 33, '2025-08-25 16:53:08'),
(371, 23, 33, '2025-08-25 16:53:08'),
(372, 24, 33, '2025-08-25 16:53:08'),
(373, 25, 33, '2025-08-25 16:53:08'),
(374, 26, 33, '2025-08-25 16:53:08'),
(375, 27, 33, '2025-08-25 16:53:08'),
(376, 28, 33, '2025-08-25 16:53:08'),
(377, 29, 33, '2025-08-25 16:53:08'),
(378, 30, 33, '2025-08-25 16:53:08'),
(379, 31, 33, '2025-08-25 16:53:08'),
(380, 32, 33, '2025-08-25 16:53:08'),
(381, 33, 33, '2025-08-25 16:53:08'),
(382, 34, 33, '2025-08-25 16:53:08'),
(383, 35, 33, '2025-08-25 16:53:08'),
(384, 36, 33, '2025-08-25 16:53:08'),
(385, 37, 33, '2025-08-25 16:53:08'),
(386, 38, 33, '2025-08-25 16:53:08'),
(387, 39, 33, '2025-08-25 16:53:08'),
(388, 40, 33, '2025-08-25 16:53:08'),
(389, 41, 33, '2025-08-25 16:53:08'),
(390, 42, 33, '2025-08-25 16:53:08');

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `status` enum('Present','Absent') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `student_id`, `date`, `status`) VALUES
(20, 20, '2025-08-22', 'Present'),
(21, 21, '2025-08-22', 'Present'),
(22, 23, '2025-08-22', 'Present'),
(23, 22, '2025-08-22', 'Present'),
(24, 24, '2025-08-22', 'Absent'),
(25, 20, '2025-08-23', 'Absent'),
(26, 21, '2025-08-23', ''),
(27, 23, '2025-08-23', 'Present'),
(28, 20, '2025-08-25', 'Present'),
(29, 21, '2025-08-25', 'Absent'),
(30, 23, '2025-08-25', 'Absent'),
(31, 25, '2025-08-25', 'Present'),
(32, 26, '2025-08-25', '');

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `id` int(11) NOT NULL,
  `class_name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `max_students` int(11) NOT NULL,
  `days_active` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`days_active`)),
  `status` enum('ongoing','completed') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `academic_year_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`id`, `class_name`, `description`, `max_students`, `days_active`, `status`, `created_at`, `academic_year_id`) VALUES
(19, 'Grade 3', 'primary', 50, '[\"Monday\",\"Tuesday\",\"Wednesday\",\"Saturday\",\"Sunday\"]', 'ongoing', '2025-08-16 19:47:28', 1),
(20, 'Grade 4', 'primary', 50, '[\"Monday\",\"Tuesday\",\"Wednesday\",\"Saturday\",\"Sunday\"]', 'ongoing', '2025-08-16 19:47:56', 1),
(21, 'Grade 5', 'primary', 50, '[\"Monday\",\"Tuesday\",\"Wednesday\",\"Saturday\",\"Sunday\"]', 'ongoing', '2025-08-16 19:48:21', 1),
(22, 'Grade 6', 'primary', 50, '[\"Monday\",\"Tuesday\",\"Wednesday\",\"Saturday\",\"Sunday\"]', 'ongoing', '2025-08-16 19:48:51', 1),
(24, 'Grade 7', 'waa class socdo', 100, '[\"Monday\",\"Saturday\",\"Sunday\"]', 'completed', '2025-08-25 13:45:32', 1);

-- --------------------------------------------------------

--
-- Table structure for table `exams`
--

CREATE TABLE `exams` (
  `id` int(11) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `class_id` int(11) DEFAULT NULL,
  `term` varchar(50) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `academic_year_id` int(11) DEFAULT NULL,
  `status` enum('draft','published') DEFAULT 'draft'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exams`
--

INSERT INTO `exams` (`id`, `title`, `class_id`, `term`, `date`, `academic_year_id`, `status`) VALUES
(56, 'Mid-Term Exam 3aad', 19, 'Mid-Term', '2025-08-18', 1, 'published'),
(61, 'final exam fasalka 3aad', 19, 'Final', '2025-08-20', 1, 'published');

-- --------------------------------------------------------

--
-- Table structure for table `exam_results`
--

CREATE TABLE `exam_results` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `exam_subject_id` int(11) NOT NULL,
  `marks_obtained` decimal(5,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exam_results`
--

INSERT INTO `exam_results` (`id`, `student_id`, `exam_subject_id`, `marks_obtained`, `created_at`, `updated_at`) VALUES
(29, 20, 48, 85.00, '2025-08-18 11:01:04', '2025-08-18 11:01:04'),
(30, 20, 49, 100.00, '2025-08-18 11:01:16', '2025-08-20 18:56:25'),
(31, 20, 50, 60.00, '2025-08-18 11:01:27', '2025-08-18 11:01:27'),
(32, 20, 55, 100.00, '2025-08-20 19:39:12', '2025-08-20 19:39:12'),
(33, 21, 55, 80.00, '2025-08-20 19:39:12', '2025-08-20 19:39:12'),
(34, 23, 55, 90.00, '2025-08-20 19:39:12', '2025-08-20 19:39:12'),
(35, 20, 56, 90.00, '2025-08-20 20:39:47', '2025-08-20 20:39:47'),
(36, 21, 49, 50.00, '2025-08-25 13:55:19', '2025-08-25 13:55:19'),
(37, 23, 49, 20.00, '2025-08-25 13:55:19', '2025-08-25 13:55:19'),
(38, 25, 49, 60.00, '2025-08-25 13:55:19', '2025-08-25 13:55:19'),
(39, 26, 49, 100.00, '2025-08-25 13:55:19', '2025-08-25 13:55:19');

-- --------------------------------------------------------

--
-- Table structure for table `exam_schedule`
--

CREATE TABLE `exam_schedule` (
  `exam_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `exam_date` date NOT NULL,
  `exam_start_time` time NOT NULL,
  `exam_end_time` time NOT NULL,
  `subject_id` int(11) NOT NULL,
  `academic_year_id` int(11) NOT NULL,
  `exam_type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exam_schedule`
--

INSERT INTO `exam_schedule` (`exam_id`, `class_id`, `exam_date`, `exam_start_time`, `exam_end_time`, `subject_id`, `academic_year_id`, `exam_type`) VALUES
(27, 19, '2025-08-20', '10:23:00', '10:23:00', 34, 0, 'Mid-Term'),
(28, 19, '2025-08-20', '10:24:00', '11:24:00', 32, 0, 'Mid-Term'),
(29, 19, '2025-08-24', '21:23:00', '22:23:00', 33, 0, 'Final'),
(30, 19, '2025-08-23', '09:30:00', '10:30:00', 34, 1, 'Mid-Term');

-- --------------------------------------------------------

--
-- Table structure for table `exam_subjects`
--

CREATE TABLE `exam_subjects` (
  `id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `teacher_id` int(11) DEFAULT NULL,
  `class_id` int(11) NOT NULL,
  `academic_year_id` int(11) NOT NULL,
  `exam_date` date DEFAULT NULL,
  `max_marks` int(11) NOT NULL DEFAULT 100
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exam_subjects`
--

INSERT INTO `exam_subjects` (`id`, `exam_id`, `subject_id`, `teacher_id`, `class_id`, `academic_year_id`, `exam_date`, `max_marks`) VALUES
(48, 56, 33, 6, 19, 1, '2025-08-21', 100),
(49, 56, 34, 6, 19, 1, '2025-08-22', 100),
(50, 56, 35, 6, 19, 1, '2025-08-22', 100),
(55, 61, 35, 8, 19, 1, '2025-08-20', 100),
(56, 61, 34, 7, 19, 1, '2025-08-20', 100);

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `expense_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `date` date NOT NULL,
  `category` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`expense_id`, `title`, `description`, `amount`, `date`, `category`, `created_at`) VALUES
(38, 'deeq bixin', 'djjns', 200.00, '2025-08-25', 'Income', '2025-08-25 13:42:28'),
(39, 'miisas', 'kksoeoe', 20.00, '2025-08-25', 'Other', '2025-08-25 13:43:11');

-- --------------------------------------------------------

--
-- Table structure for table `halaqa_schedule`
--

CREATE TABLE `halaqa_schedule` (
  `id` int(11) NOT NULL,
  `day` varchar(20) NOT NULL,
  `time` varchar(20) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `teacher` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `halaqa_schedule`
--

INSERT INTO `halaqa_schedule` (`id`, `day`, `time`, `subject`, `teacher`) VALUES
(4, 'sabti ', '7:00-12:00pm', 'fiqh', 'mohamuud ali');

-- --------------------------------------------------------

--
-- Table structure for table `hifz_progress`
--

CREATE TABLE `hifz_progress` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `juz_completed` int(11) NOT NULL,
  `last_surah` varchar(100) NOT NULL,
  `revision_notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hifz_progress`
--

INSERT INTO `hifz_progress` (`id`, `student_id`, `juz_completed`, `last_surah`, `revision_notes`, `created_at`) VALUES
(9, 20, 10, 'baqara', 'nothing', '2025-08-18 17:41:29'),
(10, 21, 5, 'baqara', 'notrr', '2025-08-23 12:16:08');

-- --------------------------------------------------------

--
-- Table structure for table `parents`
--

CREATE TABLE `parents` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `relationship_to_student` varchar(50) DEFAULT NULL,
  `Address` varchar(250) NOT NULL,
  `guarantor` varchar(250) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `academic_year_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `parents`
--

INSERT INTO `parents` (`id`, `name`, `phone`, `relationship_to_student`, `Address`, `guarantor`, `created_at`, `academic_year_id`) VALUES
(12, 'Ahmed aadan', '61559935', 'Father', 'hodon', 'yuusuf dheere', '2025-08-01 19:10:18', 1),
(13, 'maxamuud aadan cali', '61772682', 'Father', 'hodon', 'muumin', '2025-08-12 08:34:57', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `expires_at` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`id`, `user_id`, `token`, `expires_at`, `created_at`) VALUES
(5, 24, 'c006f519c94b2db186051535bc1662b49a0434a300941c4d4f857462c58d23831f62ae9a392707cc7eee89ad48ddca99b464', '2025-08-25 11:59:03', '2025-08-25 08:59:03'),
(6, 25, '384b5fae3c04f4e7fafc23dc4e9468410563247b66582d30483882cddc938a635501ce9279cfa79a9c5c0cc42427f3ee5f17', '2025-08-25 12:04:37', '2025-08-25 09:04:37'),
(7, 32, '3cf73d75b539197c82eac7f9b0897c5816e4293504c69d9fb07a880076cfd918490b93d0dc586d01912946c314313d58f2be', '2025-08-25 12:05:14', '2025-08-25 09:05:14'),
(8, 24, '0a6b5e6b63eebd127c7de01dfc41c5f60041086a06f927b903566456735fb3fed9910311674e811d0bfba7a5f447713da839', '2025-08-25 14:58:23', '2025-08-25 11:58:23'),
(9, 24, '84037cd9653a2016d8b92d3594b879552a15e096e6d2f1677fc9b54460d80226a50cf2863e801d23381cbf950a5ba8b0a561', '2025-08-25 17:10:10', '2025-08-25 14:10:10'),
(10, 24, '3bb287d477c89bca5dfa14cb837d1be624ea94b8b121c50b0e6718e8c57f32af803a8ebc6199810efad4760634d0c0c9263c', '2025-08-26 11:44:33', '2025-08-26 08:44:33');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `parent_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `slug`, `parent_id`) VALUES
(1, 'Dashboard', 'dashboard', NULL),
(2, 'Main Dashboard', 'main_dashboard', 1),
(3, 'Statistics', 'statistics', 1),
(4, 'Notifications', 'notifications', 1),
(5, 'Students', 'students', NULL),
(6, 'Student List', 'student_list', 5),
(7, 'Student ID-card', 'student_id', 5),
(8, 'Leave certificate', 'leave_cert', 5),
(9, 'Student Attendance', 'student_attendance', 5),
(10, 'Parents', 'parents', NULL),
(11, 'Parent List', 'parent_list', 10),
(12, 'Teachers', 'teachers', NULL),
(13, 'Teacher List', 'teacher_list', 12),
(14, 'Teacher Profiles', 'teacher_profiles', 12),
(15, 'Teacher Attendance', 'teacher_attendance', 12),
(16, 'Subjects', 'subjects', NULL),
(17, 'Formal Subjects', 'formal_subjects', 16),
(18, 'Finance', 'finance', NULL),
(19, 'Expense List', 'expense_list', 18),
(20, 'Classes', 'classes', NULL),
(21, 'Class List', 'class_list', 20),
(22, 'Class Schedule', 'class_schedule', 20),
(23, 'Exams', 'exams', NULL),
(24, 'All Exams', 'all_exams', 23),
(25, 'Exam Timetable', 'exam_timetable', 23),
(26, 'Exam Subjects', 'exam_subjects', 23),
(27, 'Marks Entry', 'marks_entry', 23),
(28, 'Results Overview', 'results_overview', 23),
(29, 'Quranic School', 'quranic', NULL),
(30, 'Hifz Progress', 'hifz_progress', 29),
(31, 'Halaqa Schedule', 'halaqa_schedule', 29),
(32, 'Tajweed Records', 'tajweed_records', 29),
(33, 'Attendance', 'attendance', NULL),
(34, 'Daily Attendance', 'daily_attendance', 33),
(35, 'Monthly Report', 'monthly_report', 33),
(36, 'Teachers attendance', 'teachers_attendance', 33),
(37, 'Reports', 'reports', NULL),
(38, 'Report List', 'report_list', 37),
(39, 'Student Reports', 'student_reports', 37),
(40, 'Teacher Reports', 'teacher_reports', 37),
(41, 'Announcements', 'announcements', NULL),
(42, 'Announcements list', 'announcements_list', 41),
(43, 'Add Announcement', 'add_announcement', 41),
(44, 'Settings', 'settings', NULL),
(45, 'General Settings', 'general_settings', 44),
(46, 'Profile', 'profile', 44),
(47, 'Assign Permission', 'assign_permission', 44),
(48, 'User Management', 'user_management', 44);

-- --------------------------------------------------------

--
-- Table structure for table `schedules`
--

CREATE TABLE `schedules` (
  `id` int(11) NOT NULL,
  `academic_year_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `day_of_week` varchar(20) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `teacher_name` varchar(100) DEFAULT NULL,
  `room` varchar(50) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `schedules`
--

INSERT INTO `schedules` (`id`, `academic_year_id`, `class_id`, `subject_id`, `day_of_week`, `start_time`, `end_time`, `teacher_name`, `room`, `status`, `created_at`) VALUES
(10, 1, 19, 29, 'Saturday', '22:56:00', '23:56:00', 'mohamed aadan', '5', 'active', '2025-08-16 19:56:45'),
(11, 1, 19, 30, 'Sunday', '22:56:00', '23:56:00', 'mohamed aadan', '5', 'active', '2025-08-16 19:56:45'),
(12, 1, 19, 31, 'Monday', '22:56:00', '23:56:00', 'mohamed aadan', '5', 'active', '2025-08-16 19:56:45'),
(13, 1, 19, 32, 'Tuesday', '22:57:00', '23:57:00', 'mohamed aadan', '5', 'active', '2025-08-16 19:57:43'),
(14, 1, 19, 33, 'Wednesday', '22:57:00', '23:57:00', 'mohamed aadan', '5', 'active', '2025-08-16 19:57:43'),
(15, 1, 19, 34, 'Thursday', '22:57:00', '23:57:00', 'mohamed aadan', '5', 'active', '2025-08-16 19:57:43');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `student_id` varchar(20) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `gender` enum('Male','Female') NOT NULL,
  `date_of_birth` date DEFAULT NULL,
  `place_of_birth` varchar(100) DEFAULT NULL,
  `department_type` varchar(250) NOT NULL,
  `class_id` int(11) NOT NULL,
  `academic_year_id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `student_image` varchar(255) DEFAULT NULL,
  `status` enum('Active','Inactive','Graduated','Left') DEFAULT 'Active',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `student_id`, `full_name`, `gender`, `date_of_birth`, `place_of_birth`, `department_type`, `class_id`, `academic_year_id`, `parent_id`, `student_image`, `status`, `notes`, `created_at`) VALUES
(20, 'QBS-2526-001', 'mohamed', 'Male', '2025-08-16', 'mogadishu', 'quranic', 19, 1, 12, '../upload/students/68a0e3b0a57b7_Screenshot 2025-03-18 222443.png', 'Active', 'nothing', '2025-08-16 20:01:52'),
(21, 'QBS-2526-002', 'xudayfi mohamed', 'Male', '2025-08-19', 'qoryooley', 'quranic', 19, 1, 12, '', 'Active', 'nothing', '2025-08-19 18:48:28'),
(22, 'QBS-2526-003', 'mohamed nuur aadan', 'Male', '2025-08-19', 'qoryooley', '', 20, 1, 13, '', 'Active', 'nothing ', '2025-08-19 18:49:10'),
(23, 'QBS-2526-004', 'muno nuur xuseen', 'Male', '2025-08-19', 'madiino', 'both', 19, 1, 12, '../upload/students/68a87b99c6839_Screenshot 2025-03-18 222443.png', 'Active', 'noting', '2025-08-19 18:50:12'),
(24, 'QBS-2526-005', 'nuurto aadan hassan', 'Male', '2025-08-22', 'qoryooley', 'both', 20, 1, 12, '../upload/students/68a87bb43b40f_Screenshot 2025-06-03 131149.png', 'Active', 'nothing', '2025-08-22 14:07:08'),
(25, 'QBS-2526-006', 'cali xuseen', 'Male', '2025-08-23', 'qoryooley', 'both', 19, 1, 12, '../upload/students/68ab642a6b5a4_Screenshot 2025-05-31 142112.png', 'Active', 'nothing', '2025-08-23 12:22:34'),
(26, 'QBS-2526-007', 'nuur aadan cali', 'Male', '2025-08-25', 'qoryooley', 'both', 19, 1, 12, '../upload/students/68ac6701cde45_Screenshot 2025-06-04 170745.png', 'Active', '', '2025-08-25 13:36:43');

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` int(11) NOT NULL,
  `subject_name` varchar(100) NOT NULL,
  `subject_code` varchar(50) NOT NULL,
  `class_id` int(11) NOT NULL,
  `description` varchar(250) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `academic_year_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `subject_name`, `subject_code`, `class_id`, `description`, `status`, `created_at`, `academic_year_id`) VALUES
(29, 'xisaab', 'SUB4725', 19, 'primary', 'active', '2025-08-16 19:53:54', 1),
(30, 'saynis', 'SUB8728', 19, 'primary', 'active', '2025-08-16 19:54:16', 1),
(31, 'somali', 'SUB8256', 19, 'primary', 'active', '2025-08-16 19:54:32', 1),
(32, 'cilmi bulsho', 'SUB1380', 19, 'primary', 'active', '2025-08-16 19:54:55', 1),
(33, 'English', 'SUB7021', 19, 'primary', 'active', '2025-08-16 19:55:12', 1),
(34, 'carabi', 'SUB3782', 19, 'primary', 'active', '2025-08-16 19:55:26', 1),
(35, 'Tarbiyo', 'SUB8641', 19, 'primary', 'active', '2025-08-16 19:55:39', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tajweed_records`
--

CREATE TABLE `tajweed_records` (
  `id` int(11) NOT NULL,
  `student_name` varchar(255) DEFAULT NULL,
  `lesson` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `remarks` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tajweed_records`
--

INSERT INTO `tajweed_records` (`id`, `student_name`, `lesson`, `date`, `remarks`) VALUES
(6, 'mohamed', '6', '2025-08-18', 'nothing');

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `is_done` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `title`, `due_date`, `is_done`) VALUES
(1, 'Prepare Midterm Exam Papers', '2025-08-15', 1),
(2, 'Prepare Exam Timetable', '2025-08-05', 0),
(3, 'Update Student Attendance', '2025-07-22', 1),
(4, 'Review Hifz Progress Reports', '2025-07-25', 0),
(5, 'Assign Quranic Subjects', '2025-08-01', 0),
(6, 'Upload Exam Results', '2025-07-20', 1);

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `id` int(11) NOT NULL,
  `teacher_code` varchar(20) DEFAULT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `qualification` varchar(20) DEFAULT NULL,
  `salary` decimal(10,2) DEFAULT 0.00,
  `class_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`id`, `teacher_code`, `full_name`, `email`, `phone`, `qualification`, `salary`, `class_id`, `created_at`) VALUES
(6, 'T-4795', 'Abdinaasir mohamed', 'qoryooley839@gmail.com', '619951562', 'BSC', 250.00, 17, '2025-08-02 07:43:35'),
(7, 'T-2979', 'fartuun nuur', 'nuurfartuun756@gmail.com', '614891818', 'BSC', 150.00, 18, '2025-08-02 07:59:54'),
(8, 'T-3656', 'xafso ibraahim', 'xafsog479@gmail.com', '619951562', 'BSN', 100.00, 15, '2025-08-13 18:05:20'),
(10, 'T-4634', 'mohamuud toll', 'mohamudtoll@gmail.com', '6188993', 'BSN', 150.00, 19, '2025-08-23 12:28:50'),
(11, 'T-4040', 'Abdinaasir mohamed', 'qoryooleybns@gmail.com', '619951562', 'BSC', 400.00, 19, '2025-08-25 14:01:47');

-- --------------------------------------------------------

--
-- Table structure for table `teacher_attendance`
--

CREATE TABLE `teacher_attendance` (
  `id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `status` enum('Present','Absent','Late','Leave') NOT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teacher_attendance`
--

INSERT INTO `teacher_attendance` (`id`, `teacher_id`, `date`, `status`, `remarks`, `created_at`) VALUES
(28, 6, '2025-08-21', 'Present', '', '2025-08-21 19:27:12'),
(29, 7, '2025-08-21', 'Absent', '', '2025-08-21 19:27:12'),
(30, 8, '2025-08-21', 'Late', '', '2025-08-21 19:27:12'),
(31, 6, '2025-08-23', 'Present', '', '2025-08-23 12:31:12'),
(32, 7, '2025-08-23', 'Absent', '', '2025-08-23 12:31:12'),
(33, 10, '2025-08-23', 'Leave', 'MEEL', '2025-08-23 12:31:12'),
(34, 8, '2025-08-23', 'Late', '', '2025-08-23 12:31:12');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(250) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` enum('active','inactive') DEFAULT 'inactive',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `profile_image` varchar(255) DEFAULT NULL,
  `role` enum('admin','teacher','student','parent') NOT NULL DEFAULT 'teacher'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `status`, `created_at`, `profile_image`, `role`) VALUES
(24, 'Abdinaasir', 'qoryooley839@gmail.com', '$2y$10$Cuhu1KN2nu2GpOC9IEZZM.WDqVE1cokdjWUO7naqucQxVvfCPwNly', 'active', '2025-07-25 13:29:23', '1753450272_HU23104613Abdinasir Mohamed yusuf ID 4613  619951562.jpg', 'admin'),
(25, 'cali', 'qoryooley840@gmail.com', '$2y$10$PAtw/MAxftL4OCLeXIk/TeCNe3XnlwlKyoc/kGcFCqe9c9e.DkTPi', 'active', '2025-07-26 16:11:29', '1753546725_cali.png.jpg', 'teacher'),
(32, 'Nuur cali', 'qoryooleybns@gmail.com', '$2y$10$RBAfKBkiK4WidlqozQHvzuYdHljVPUQgj4rXYK6nYkdi6K7tRwMte', 'active', '2025-08-22 17:30:25', NULL, 'teacher'),
(33, 'cabdalla', 'qoryooley821@gmail.com', '$2y$10$PzqliCbyz7FX05oauE6y9eyD8GSxgIHY1pjBtKYomKzuoV1H8hUmK', 'active', '2025-08-25 13:52:02', '1756130158_Screenshot 2025-03-18 222443.png', 'teacher');

-- --------------------------------------------------------

--
-- Table structure for table `user_permissions`
--

CREATE TABLE `user_permissions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_permissions`
--

INSERT INTO `user_permissions` (`id`, `user_id`, `permission_id`) VALUES
(235, 25, 5),
(236, 25, 9),
(237, 25, 12),
(238, 25, 15),
(239, 25, 23),
(240, 25, 27),
(241, 25, 29),
(242, 25, 30),
(243, 24, 1),
(244, 24, 2),
(245, 24, 3),
(246, 24, 4),
(247, 24, 5),
(248, 24, 6),
(249, 24, 7),
(250, 24, 8),
(251, 24, 9),
(252, 24, 10),
(253, 24, 11),
(254, 24, 12),
(255, 24, 13),
(256, 24, 14),
(257, 24, 15),
(258, 24, 16),
(259, 24, 17),
(260, 24, 18),
(261, 24, 19),
(262, 24, 20),
(263, 24, 21),
(264, 24, 22),
(265, 24, 23),
(266, 24, 24),
(267, 24, 25),
(268, 24, 26),
(269, 24, 27),
(270, 24, 28),
(271, 24, 29),
(272, 24, 30),
(273, 24, 31),
(274, 24, 32),
(275, 24, 33),
(276, 24, 34),
(277, 24, 35),
(278, 24, 36),
(279, 24, 37),
(280, 24, 38),
(281, 24, 39),
(282, 24, 40),
(283, 24, 41),
(284, 24, 42),
(285, 24, 43),
(286, 24, 44),
(287, 24, 45),
(288, 24, 46),
(289, 24, 47),
(290, 24, 48),
(294, 33, 5),
(295, 33, 9),
(296, 33, 23),
(297, 33, 27);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `academic_years`
--
ALTER TABLE `academic_years`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `year_name` (`year_name`);

--
-- Indexes for table `activities`
--
ALTER TABLE `activities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `announcement_reads`
--
ALTER TABLE `announcement_reads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_academic_year` (`academic_year_id`);

--
-- Indexes for table `exams`
--
ALTER TABLE `exams`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exam_results`
--
ALTER TABLE `exam_results`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `student_exam_subject` (`student_id`,`exam_subject_id`),
  ADD KEY `exam_results_fk_exam_subject` (`exam_subject_id`);

--
-- Indexes for table `exam_schedule`
--
ALTER TABLE `exam_schedule`
  ADD PRIMARY KEY (`exam_id`),
  ADD KEY `class_id` (`class_id`);

--
-- Indexes for table `exam_subjects`
--
ALTER TABLE `exam_subjects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subject_id` (`subject_id`),
  ADD KEY `exam_subjects_ibfk_3` (`class_id`),
  ADD KEY `academic_year_id` (`academic_year_id`),
  ADD KEY `exam_subjects_ibfk_1` (`exam_id`),
  ADD KEY `teacher_id` (`teacher_id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`expense_id`);

--
-- Indexes for table `halaqa_schedule`
--
ALTER TABLE `halaqa_schedule`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hifz_progress`
--
ALTER TABLE `hifz_progress`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `parents`
--
ALTER TABLE `parents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent_id` (`parent_id`);

--
-- Indexes for table `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `academic_year_id` (`academic_year_id`),
  ADD KEY `class_id` (`class_id`),
  ADD KEY `subject_id` (`subject_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_student_id` (`student_id`),
  ADD KEY `class_id` (`class_id`),
  ADD KEY `academic_year_id` (`academic_year_id`),
  ADD KEY `parent_id` (`parent_id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `subject_code` (`subject_code`),
  ADD KEY `fk_subjects_class_id` (`class_id`),
  ADD KEY `fk_subjects_academic_year_id` (`academic_year_id`);

--
-- Indexes for table `tajweed_records`
--
ALTER TABLE `tajweed_records`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `teacher_code` (`teacher_code`);

--
-- Indexes for table `teacher_attendance`
--
ALTER TABLE `teacher_attendance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teacher_id` (`teacher_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `user_permissions`
--
ALTER TABLE `user_permissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `permission_id` (`permission_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `academic_years`
--
ALTER TABLE `academic_years`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26496;

--
-- AUTO_INCREMENT for table `activities`
--
ALTER TABLE `activities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `announcement_reads`
--
ALTER TABLE `announcement_reads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=391;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `exams`
--
ALTER TABLE `exams`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `exam_results`
--
ALTER TABLE `exam_results`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `exam_schedule`
--
ALTER TABLE `exam_schedule`
  MODIFY `exam_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `exam_subjects`
--
ALTER TABLE `exam_subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `expense_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `halaqa_schedule`
--
ALTER TABLE `halaqa_schedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `hifz_progress`
--
ALTER TABLE `hifz_progress`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `parents`
--
ALTER TABLE `parents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `schedules`
--
ALTER TABLE `schedules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `tajweed_records`
--
ALTER TABLE `tajweed_records`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `teacher_attendance`
--
ALTER TABLE `teacher_attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `user_permissions`
--
ALTER TABLE `user_permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=298;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`);

--
-- Constraints for table `classes`
--
ALTER TABLE `classes`
  ADD CONSTRAINT `fk_academic_year` FOREIGN KEY (`academic_year_id`) REFERENCES `academic_years` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `exam_results`
--
ALTER TABLE `exam_results`
  ADD CONSTRAINT `exam_results_fk_exam_subject` FOREIGN KEY (`exam_subject_id`) REFERENCES `exam_subjects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `exam_results_fk_student` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `exam_schedule`
--
ALTER TABLE `exam_schedule`
  ADD CONSTRAINT `exam_schedule_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `exam_subjects`
--
ALTER TABLE `exam_subjects`
  ADD CONSTRAINT `exam_subjects_ibfk_1` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `exam_subjects_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`),
  ADD CONSTRAINT `exam_subjects_ibfk_3` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `exam_subjects_ibfk_4` FOREIGN KEY (`academic_year_id`) REFERENCES `academic_years` (`id`),
  ADD CONSTRAINT `exam_subjects_ibfk_5` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`);

--
-- Constraints for table `hifz_progress`
--
ALTER TABLE `hifz_progress`
  ADD CONSTRAINT `hifz_progress_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD CONSTRAINT `password_resets_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `permissions`
--
ALTER TABLE `permissions`
  ADD CONSTRAINT `permissions_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `schedules`
--
ALTER TABLE `schedules`
  ADD CONSTRAINT `schedules_ibfk_1` FOREIGN KEY (`academic_year_id`) REFERENCES `academic_years` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `schedules_ibfk_2` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `schedules_ibfk_3` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `fk_students_academic_year_id` FOREIGN KEY (`academic_year_id`) REFERENCES `academic_years` (`id`),
  ADD CONSTRAINT `fk_students_class_id` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`),
  ADD CONSTRAINT `fk_students_parent_id` FOREIGN KEY (`parent_id`) REFERENCES `parents` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `subjects`
--
ALTER TABLE `subjects`
  ADD CONSTRAINT `fk_subjects_academic_year_id` FOREIGN KEY (`academic_year_id`) REFERENCES `academic_years` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_subjects_class_id` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `teacher_attendance`
--
ALTER TABLE `teacher_attendance`
  ADD CONSTRAINT `teacher_attendance_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_permissions`
--
ALTER TABLE `user_permissions`
  ADD CONSTRAINT `user_permissions_ibfk_1` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
