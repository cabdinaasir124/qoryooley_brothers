-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 02, 2025 at 01:09 PM
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
(38, 'imtixaanka bilaha', 'New exam titled \'imtixaanka bilaha\' has been scheduled for term \'Term 1\' on 2025-08-02.', 'student', 'school', 24, '2025-08-02 13:05:19', NULL);

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
(105, 20, 25, '2025-07-30 16:52:31');

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
(15, 'Grade 2', 'All subjcts', 3, '[\"Monday\",\"Saturday\",\"Sunday\"]', 'ongoing', '2025-07-25 12:32:40', 1),
(17, 'Grade 1', 'all subjcts', 10, '[\"Monday\",\"Tuesday\",\"Wednesday\",\"Saturday\",\"Sunday\"]', 'ongoing', '2025-07-25 17:51:07', 1),
(18, 'Grade 3', 'primary', 30, '[\"Monday\",\"Tuesday\",\"Saturday\",\"Sunday\"]', 'ongoing', '2025-07-30 13:43:18', 1);

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
(39, 'imtixaan bileedka', 15, 'Term 1', '2025-08-02', 1, 'draft'),
(40, 'imtixaan bileedka', 17, 'Term 1', '2025-08-02', 1, 'draft'),
(41, 'imtixaan bileedka', 18, 'Term 1', '2025-08-02', 1, 'draft');

-- --------------------------------------------------------

--
-- Table structure for table `exam_results`
--

CREATE TABLE `exam_results` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `exam_subject_id` int(11) DEFAULT NULL,
  `marks_obtained` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `exam_subjects`
--

CREATE TABLE `exam_subjects` (
  `id` int(11) NOT NULL,
  `exam_id` int(11) DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `max_marks` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` int(11) NOT NULL,
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

INSERT INTO `expenses` (`id`, `title`, `description`, `amount`, `date`, `category`, `created_at`) VALUES
(3, 'waa lacagta deeq bixiyeyaasha', 'waa lacagta deeq bixiyeyaasha', 250.00, '2025-08-01', 'Income', '2025-08-01 19:49:35'),
(4, 'waa mushaarka macalimiinta', 'waa mushaarka', 100.00, '2025-08-01', 'Other', '2025-08-01 19:50:18'),
(6, 'lacagta kirada ', 'waa lacagta ', 121.00, '2025-08-02', 'Other', '2025-08-02 10:46:09');

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
(12, 'Ahmed aadan', '61559935', 'Father', 'hodon', 'yuusuf dheere', '2025-08-01 19:10:18', 1);

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
(8, 1, 15, 16, 'Saturday', '08:49:00', '09:50:00', 'nuur cabdulaahi', '4', 'active', '2025-07-25 17:49:37'),
(9, 1, 17, 17, 'Saturday', '08:00:00', '08:40:00', 'mohamed ibraahim', '5', 'active', '2025-07-25 17:54:51');

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
  `address` text DEFAULT NULL,
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

INSERT INTO `students` (`id`, `student_id`, `full_name`, `gender`, `date_of_birth`, `place_of_birth`, `address`, `class_id`, `academic_year_id`, `parent_id`, `student_image`, `status`, `notes`, `created_at`) VALUES
(2, 'QBS-2526-001', 'cabdinaasir mohamed', 'Male', '2025-08-02', 'qoryooley', ' hodon', 17, 1, 12, '', 'Active', 'hhh', '2025-08-02 08:28:07');

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` int(11) NOT NULL,
  `subject_name` varchar(100) NOT NULL,
  `subject_code` varchar(50) NOT NULL,
  `class_id` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `academic_year_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `subject_name`, `subject_code`, `class_id`, `description`, `status`, `created_at`, `academic_year_id`) VALUES
(16, 'somali', 'SUB4041', 15, 'all subjects', 'active', '2025-07-25 17:48:53', 1),
(17, 'xisaab', 'SUB4022', 17, '0', 'active', '2025-07-25 17:52:19', 1),
(18, 'English', 'SUB1554', 17, 'all subjects', 'active', '2025-07-25 17:53:16', 1),
(19, 'cilmiga bulshada', 'SUB6097', 17, '0', 'active', '2025-07-25 17:53:40', 1),
(22, 'english', 'SUB2063', 17, 'primary', 'active', '2025-07-30 13:42:07', 1);

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
(5, 'T-9748', 'Abdulaahi mohamed', 'cabdalacadde222@gmail.com', '617618145', 'BSC', 120.00, 17, '2025-08-02 07:42:52'),
(6, 'T-4795', 'Abdinaasir mohamed', 'qoryooley839@gmail.com', '619951562', 'BSC', 250.00, 17, '2025-08-02 07:43:35'),
(7, 'T-2979', 'fartuun nuur', 'nuurfartuun756@gmail.com', '614891818', 'BSC', 150.00, 18, '2025-08-02 07:59:54');

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
(25, 'cali', 'qoryooley840@gmail.com', '$2y$10$JGu0NX462Tua.dy/WsfJDeqEm5Bkv1sfv7HZCfdo.ZwKjVa9g5n3K', 'active', '2025-07-26 16:11:29', '1753546725_cali.png.jpg', 'teacher');

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
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exam_subjects`
--
ALTER TABLE `exam_subjects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12856;

--
-- AUTO_INCREMENT for table `activities`
--
ALTER TABLE `activities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `announcement_reads`
--
ALTER TABLE `announcement_reads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `exams`
--
ALTER TABLE `exams`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `exam_results`
--
ALTER TABLE `exam_results`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `exam_subjects`
--
ALTER TABLE `exam_subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `parents`
--
ALTER TABLE `parents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `schedules`
--
ALTER TABLE `schedules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
