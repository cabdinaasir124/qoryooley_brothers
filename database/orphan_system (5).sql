-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 18, 2025 at 07:15 PM
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
(39, 'waxaa nagu soo wajahan imtixaanka', 'all', 'all', 'both', 24, '2025-08-12 16:38:34', NULL);

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
(159, 39, 26, '2025-08-12 16:42:15');

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
(23, 'Grade 7', 'primary', 50, '[\"Monday\",\"Tuesday\",\"Wednesday\",\"Saturday\",\"Sunday\"]', 'ongoing', '2025-08-16 19:49:18', 1);

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
(56, 'imtixaan bileedka 3aad', 19, 'Mid-Term', '2025-08-18', 1, 'published'),
(57, 'imtixaan bileedka 4aad', 20, 'Mid-Term', '2025-08-18', 1, 'published'),
(58, 'imtixaan bileedka 5aad', 21, 'Mid-Term', '2025-08-18', 1, 'published'),
(59, 'imtixaan bileedka 6aad', 22, 'Mid-Term', '2025-08-18', 1, 'published'),
(60, 'imtixaan bileedka 7aad', 23, 'Mid-Term', '2025-08-18', 1, 'published');

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
(25, 20, 44, 20.00, '2025-08-18 11:00:23', '2025-08-18 15:42:25'),
(26, 20, 45, 70.00, '2025-08-18 11:00:35', '2025-08-18 11:00:35'),
(27, 20, 46, 80.00, '2025-08-18 11:00:45', '2025-08-18 11:00:45'),
(28, 20, 47, 77.00, '2025-08-18 11:00:55', '2025-08-18 11:00:55'),
(29, 20, 48, 85.00, '2025-08-18 11:01:04', '2025-08-18 11:01:04'),
(30, 20, 49, 79.00, '2025-08-18 11:01:16', '2025-08-18 11:01:16'),
(31, 20, 50, 60.00, '2025-08-18 11:01:27', '2025-08-18 11:01:27');

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
(25, 19, '2025-08-17', '17:50:00', '18:50:00', 34, 1, 'Term-1'),
(26, 19, '2025-08-17', '17:51:00', '18:51:00', 32, 1, 'Term-1');

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
(44, 56, 29, 6, 19, 1, '2025-08-18', 100),
(45, 56, 30, 6, 19, 1, '2025-08-19', 100),
(46, 56, 31, 6, 19, 1, '2025-08-19', 100),
(47, 56, 32, 6, 19, 1, '2025-08-20', 100),
(48, 56, 33, 6, 19, 1, '2025-08-21', 100),
(49, 56, 34, 6, 19, 1, '2025-08-22', 100),
(50, 56, 35, 6, 19, 1, '2025-08-22', 100);

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
(33, 'take from naasir', 'nohting', 100.00, '2025-08-13', 'Income', '2025-08-13 18:34:57'),
(35, 'yap', 'nothing', 50.00, '2025-08-13', 'Transport', '2025-08-13 18:36:37');

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
(20, 'QBS-2526-001', 'mohamed', 'Male', '2025-08-16', 'mogadishu', 'quranic', 19, 1, 12, '../upload/students/68a0e3b0a57b7_Screenshot 2025-03-18 222443.png', 'Active', 'nothing', '2025-08-16 20:01:52');

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
(8, 'T-3656', 'xafso ibraahim', 'xafsog479@gmail.com', '619951562', 'BSN', 100.00, 15, '2025-08-13 18:05:20');

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
(25, 'cali', 'qoryooley840@gmail.com', '$2y$10$JGu0NX462Tua.dy/WsfJDeqEm5Bkv1sfv7HZCfdo.ZwKjVa9g5n3K', 'active', '2025-07-26 16:11:29', '1753546725_cali.png.jpg', 'teacher'),
(26, 'saalax', 'qoryooley841@gmail.com', '$2y$10$iqxTJ/eImRnNfCJJCcbq4ufGHbeTsOmaT4IOlu3fLQBoq59JZeMNG', 'active', '2025-08-12 13:39:44', NULL, 'admin');

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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `academic_years`
--
ALTER TABLE `academic_years`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20931;

--
-- AUTO_INCREMENT for table `activities`
--
ALTER TABLE `activities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `announcement_reads`
--
ALTER TABLE `announcement_reads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=160;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `exams`
--
ALTER TABLE `exams`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `exam_results`
--
ALTER TABLE `exam_results`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `exam_schedule`
--
ALTER TABLE `exam_schedule`
  MODIFY `exam_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `exam_subjects`
--
ALTER TABLE `exam_subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `expense_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `halaqa_schedule`
--
ALTER TABLE `halaqa_schedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `hifz_progress`
--
ALTER TABLE `hifz_progress`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `parents`
--
ALTER TABLE `parents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `schedules`
--
ALTER TABLE `schedules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `tajweed_records`
--
ALTER TABLE `tajweed_records`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `teacher_attendance`
--
ALTER TABLE `teacher_attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
