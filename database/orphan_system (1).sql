-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 26, 2025 at 06:20 PM
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
(17, 'Grade 1', 'all subjcts', 10, '[\"Monday\",\"Tuesday\",\"Wednesday\",\"Saturday\",\"Sunday\"]', 'ongoing', '2025-07-25 17:51:07', 1);

-- --------------------------------------------------------

--
-- Table structure for table `parents`
--

CREATE TABLE `parents` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `relationship_to_student` varchar(50) DEFAULT NULL,
  `children` varchar(250) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `academic_year_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `parents`
--

INSERT INTO `parents` (`id`, `name`, `phone`, `relationship_to_student`, `children`, `created_at`, `academic_year_id`) VALUES
(4, 'fartuun mohamed muuse', '61559945', 'Mother', '', '2025-07-25 20:07:55', 1),
(5, 'Cabdulaahi Aadan ', '6187838993', 'Father', '', '2025-07-25 20:08:06', 1),
(6, 'Abdinaasir mohamed', '61559945', 'Father', '', '2025-07-26 05:56:14', 1);

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
(18, 'QBS-001', 'cabdinaasir mohamed', 'Male', '2025-07-26', 'qoryooley', 'dhakr', 17, 1, 5, '../upload/students/6884ae2c5799d_HU23104613Abdinasir Mohamed yusuf ID 4613  619951562.jpg', 'Active', 'yes', '2025-07-26 10:30:04'),
(19, 'QBS-019', 'Ali ibraahim cabdi', 'Male', '2025-07-26', 'qoryooley', 'hodon', 17, 1, 4, '../upload/students/6884fcbc95cd8_cali.png.jpg', 'Active', 'nothing', '2025-07-26 16:05:16');

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
(17, 'xisaab', 'SUB4022', 17, 'all subjects', 'active', '2025-07-25 17:52:19', 1),
(18, 'English', 'SUB1554', 17, 'all subjects', 'active', '2025-07-25 17:53:16', 1),
(19, 'cilmiga bulshada', 'SUB6097', 17, '0', 'active', '2025-07-25 17:53:40', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(250) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(20) NOT NULL,
  `status` enum('active','inactive') DEFAULT 'inactive',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `profile_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `status`, `created_at`, `profile_image`) VALUES
(24, 'Abdinaasir', 'qoryooley839@gmail.com', '$2y$10$Cuhu1KN2nu2GpOC9IEZZM.WDqVE1cokdjWUO7naqucQxVvfCPwNly', 'Admin', 'active', '2025-07-25 13:29:23', '1753450272_HU23104613Abdinasir Mohamed yusuf ID 4613  619951562.jpg'),
(25, 'cali', 'qoryooley840@gmail.com', '$2y$10$JGu0NX462Tua.dy/WsfJDeqEm5Bkv1sfv7HZCfdo.ZwKjVa9g5n3K', 'Admin', 'active', '2025-07-26 16:11:29', '1753546725_cali.png.jpg');

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
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_academic_year` (`academic_year_id`);

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
  ADD UNIQUE KEY `student_id` (`student_id`),
  ADD KEY `class_id` (`class_id`),
  ADD KEY `academic_year_id` (`academic_year_id`),
  ADD KEY `fk_students_parent` (`parent_id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `subject_code` (`subject_code`),
  ADD KEY `fk_subjects_class_id` (`class_id`),
  ADD KEY `fk_subjects_academic_year_id` (`academic_year_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4881;

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `parents`
--
ALTER TABLE `parents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `schedules`
--
ALTER TABLE `schedules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Constraints for dumped tables
--

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
  ADD CONSTRAINT `fk_students_parent` FOREIGN KEY (`parent_id`) REFERENCES `parents` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `students_ibfk_2` FOREIGN KEY (`academic_year_id`) REFERENCES `academic_years` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `students_ibfk_3` FOREIGN KEY (`parent_id`) REFERENCES `parents` (`id`) ON DELETE SET NULL;

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
