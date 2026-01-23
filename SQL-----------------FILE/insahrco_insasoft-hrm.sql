-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 08, 2026 at 11:46 AM
-- Server version: 8.0.39-cll-lve
-- PHP Version: 8.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `insahrco_insasoft-hrm`
--

-- --------------------------------------------------------

--
-- Table structure for table `academic_year`
--

CREATE TABLE `academic_year` (
  `id` int NOT NULL,
  `title` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_from` date NOT NULL,
  `start_to` date NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `academic_year`
--

INSERT INTO `academic_year` (`id`, `title`, `start_from`, `start_to`, `active`, `updated_by`, `created_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'AY-2023/2024', '2023-08-15', '2024-06-15', 1, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` int NOT NULL,
  `title` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `taken_by` int NOT NULL,
  `description` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_from` int NOT NULL DEFAULT '0',
  `id_to` int NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` tinyint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `appraisal_applicable`
--

CREATE TABLE `appraisal_applicable` (
  `id` bigint UNSIGNED NOT NULL,
  `applicable` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `appraisal_applicable`
--

INSERT INTO `appraisal_applicable` (`id`, `applicable`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Acadmic', 1, NULL, NULL),
(2, 'Admin', 1, NULL, NULL),
(3, 'SLT', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `appraisal_data`
--

CREATE TABLE `appraisal_data` (
  `id` int NOT NULL,
  `type` int NOT NULL,
  `applicable_to` int NOT NULL DEFAULT '0',
  `details` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `appraisal_data`
--

INSERT INTO `appraisal_data` (`id`, `type`, `applicable_to`, `details`, `description`, `active`, `updated_by`, `created_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 2, 'Demonstrates command of technical/procedural skills of the job', 'Demonstrates command of technical/procedural skills of the job', 1, NULL, NULL, NULL, NULL, NULL),
(2, 1, 2, 'Complies with school policies and procedures', 'Complies with school policies and procedures', 1, NULL, NULL, NULL, NULL, NULL),
(3, 1, 2, 'Demonstrates effective problem solving skills', 'Demonstrates effective problem solving skills', 1, NULL, NULL, NULL, NULL, NULL),
(4, 1, 2, 'Plans and organises tasks effectively to meet deadlines', 'Plans and organises tasks effectively to meet deadlines', 1, NULL, NULL, NULL, NULL, NULL),
(5, 1, 2, 'Set and adhere to priorities', 'Set and adhere to priorities', 1, NULL, NULL, NULL, NULL, NULL),
(6, 1, 2, 'Responds appropriately in emergency situations', 'Responds appropriately in emergency situations', 1, NULL, NULL, NULL, NULL, NULL),
(7, 1, 2, 'Stays updated on new techniques and job related skills', 'Stays updated on new techniques and job related skills', 1, NULL, NULL, NULL, NULL, NULL),
(8, 1, 2, 'Demonstrates willingness to learn new skills', 'Demonstrates willingness to learn new skills', 1, NULL, NULL, NULL, NULL, NULL),
(9, 1, 2, 'Acts promptly on requests and assignments', 'Acts promptly on requests and assignments', 1, NULL, NULL, NULL, NULL, NULL),
(11, 1, 2, 'Accomplishes tasks with minimal assistance and supervision', 'Accomplishes tasks with minimal assistance and supervision', 1, NULL, NULL, NULL, NULL, NULL),
(12, 1, 2, 'Able to lead the team whilst maintaining a postive work ethic', 'Able to lead the team whilst maintaining a postive work ethic', 1, NULL, NULL, NULL, NULL, NULL),
(13, 1, 2, 'Desire of continuous improvement and takes feedback positively', 'Desire of continuous improvement and takes feedback positively', 1, NULL, NULL, NULL, NULL, NULL),
(14, 2, 2, 'Organisational skills', 'Organisational skills', 1, NULL, NULL, NULL, NULL, NULL),
(15, 2, 2, 'Positive attitude', 'Positive attitude', 1, NULL, NULL, NULL, NULL, NULL),
(16, 2, 2, 'Problem solving and critical thinking', 'Problem solving and critical thinking', 1, NULL, NULL, NULL, NULL, NULL),
(17, 2, 2, 'Punctuality', 'Punctuality', 1, NULL, NULL, NULL, NULL, NULL),
(18, 2, 2, 'Dependability', 'Dependability', 1, NULL, NULL, NULL, NULL, NULL),
(19, 2, 2, 'Team player', 'Team player', 1, NULL, NULL, NULL, NULL, NULL),
(20, 2, 2, 'Adaptable', 'Adaptable', 1, NULL, NULL, NULL, NULL, NULL),
(21, 2, 2, 'Pro- activeness', 'Pro- activeness', 1, NULL, NULL, NULL, NULL, NULL),
(22, 1, 1, 'Demonstrates effective classroom teaching', 'Demonstrates effective classroom teaching', 1, NULL, NULL, NULL, NULL, NULL),
(23, 1, 1, 'Complies with school policies and procedures', 'Complies with school policies and procedures', 1, NULL, NULL, NULL, NULL, NULL),
(24, 1, 1, 'Demonstrates effective problem solving skills', 'Demonstrates effective problem solving skills', 1, NULL, NULL, NULL, NULL, NULL),
(25, 1, 1, 'Plans and organises lessons well', 'Plans and organises lessons well', 1, NULL, NULL, NULL, NULL, NULL),
(26, 1, 1, 'Is able to resource lessons according to requirements', 'Is able to resource lessons according to requirements', 1, NULL, NULL, NULL, NULL, NULL),
(27, 1, 1, 'Plans lessons taking students aptitude and learning into account', 'Plans lessons taking students aptitude and learning into account', 1, NULL, NULL, NULL, NULL, NULL),
(28, 1, 1, 'Stays updated on educational matters', 'Stays updated on educational matters', 1, NULL, NULL, NULL, NULL, NULL),
(29, 1, 1, 'Demonstrates willingness to learn new skills', 'Demonstrates willingness to learn new skills', 1, NULL, NULL, NULL, NULL, NULL),
(30, 1, 1, 'Acts promptly on requests and assignments', 'Acts promptly on requests and assignments', 1, NULL, NULL, NULL, NULL, NULL),
(31, 1, 1, 'Accomplishes tasks with minimal assistance and supervision', 'Accomplishes tasks with minimal assistance and supervision', 1, NULL, NULL, NULL, NULL, NULL),
(32, 1, 1, 'Able to lead the team whilst maintaining a postive work ethic', 'Able to lead the team whilst maintaining a postive work ethic', 1, NULL, NULL, NULL, NULL, NULL),
(33, 1, 1, 'Desire of continuous improvement and takes feedback positively', 'Desire of continuous improvement and takes feedback positively', 1, NULL, NULL, NULL, NULL, NULL),
(34, 1, 1, 'Understands and is able to develop assessment methods to gauge learning and progress in class', 'Understands and is able to develop assessment methods to gauge learning and progress in class', 1, NULL, NULL, NULL, NULL, NULL),
(35, 1, 1, 'Attends and shows interest in development/training sessions', 'Attends and shows interest in development/training sessions', 1, NULL, NULL, NULL, NULL, NULL),
(36, 1, 1, 'Deals with classroom disruptions and issues in a timely manner while maintaining the dignity of stud', 'Deals with classroom disruptions and issues in a timely manner while maintaining the dignity of students	', 1, NULL, NULL, NULL, NULL, NULL),
(37, 1, 1, 'Is well aware of the differentiated activities and knows how to apply to different ability levels	', 'Is well aware of the differentiated activities and knows how to apply to different ability levels	', 1, NULL, NULL, NULL, NULL, NULL),
(38, 2, 1, 'Organisational skills', 'Organisational skills', 1, NULL, NULL, NULL, NULL, NULL),
(39, 2, 1, 'Positive attitude', 'Positive attitude', 1, NULL, NULL, NULL, NULL, NULL),
(40, 2, 1, 'Problem solving and critical thinking', 'Problem solving and critical thinking', 1, NULL, NULL, NULL, NULL, NULL),
(41, 2, 1, 'Punctuality', 'Punctuality', 1, NULL, NULL, NULL, NULL, NULL),
(42, 2, 1, 'Dependability', 'Dependability', 1, NULL, NULL, NULL, NULL, NULL),
(43, 2, 1, 'Team player', 'Team player', 1, NULL, NULL, NULL, NULL, NULL),
(44, 2, 1, 'Adaptable', 'Adaptable', 1, NULL, NULL, NULL, NULL, NULL),
(45, 2, 1, 'Pro- activeness', 'Pro- activeness', 1, NULL, NULL, NULL, NULL, NULL),
(46, 1, 3, 'Organises and coordinates the work of the department', 'Organises and coordinates the work of the department', 1, NULL, NULL, NULL, NULL, NULL),
(47, 1, 3, 'Complies with school policies and procedures', 'Complies with school policies and procedures', 1, NULL, NULL, NULL, NULL, NULL),
(48, 1, 3, 'Demonstrates effective problem solving skills', 'Demonstrates effective problem solving skills', 1, NULL, NULL, NULL, NULL, NULL),
(49, 1, 3, 'Provides effective leadership for staff progress and work ethics', 'Provides effective leadership for staff progress and work ethics', 1, NULL, NULL, NULL, NULL, NULL),
(50, 1, 3, 'Leads and coordinates new initiatives and/or improvement programs', 'Leads and coordinates new initiatives and/or improvement programs', 1, NULL, NULL, NULL, NULL, NULL),
(51, 1, 3, 'Provide effective conflict resolution as required', 'Provide effective conflict resolution as required', 1, NULL, NULL, NULL, NULL, NULL),
(52, 1, 3, 'Stays updated on matters connected to the department', 'Stays updated on matters connected to the department', 1, NULL, NULL, NULL, NULL, NULL),
(53, 1, 3, 'Demonstrates willingness to learn new skills', 'Demonstrates willingness to learn new skills', 1, NULL, NULL, NULL, NULL, NULL),
(54, 1, 3, 'Acts promptly on requests and assignments', 'Acts promptly on requests and assignments', 1, NULL, NULL, NULL, NULL, NULL),
(55, 1, 3, 'Accomplishes tasks with minimal assistance and supervision', 'Accomplishes tasks with minimal assistance and supervision', 1, NULL, NULL, NULL, NULL, NULL),
(56, 1, 3, 'Able to lead the team whilst maintaining a postive work ethic', 'Able to lead the team whilst maintaining a postive work ethic', 1, NULL, NULL, NULL, NULL, NULL),
(57, 1, 3, 'Desires continuous improvement and takes feedback positively', 'Desires continuous improvement and takes feedback positively', 1, NULL, NULL, NULL, NULL, NULL),
(58, 1, 3, 'Understands and is able to develop regular feedback to all staff to gauge progress', 'Understands and is able to develop regular feedback to all staff to gauge progress', 1, NULL, NULL, NULL, NULL, NULL),
(59, 1, 3, 'Attends and shows interest in development/training sessions', 'Attends and shows interest in development/training sessions', 1, NULL, NULL, NULL, NULL, NULL),
(60, 1, 3, 'Deals with disruptions and issues in a timely manner while maintaining the dignity of staff', 'Deals with disruptions and issues in a timely manner while maintaining the dignity of staff', 1, NULL, NULL, NULL, NULL, NULL),
(61, 2, 3, 'Organisational skills', 'Organisational skills', 1, NULL, NULL, NULL, NULL, NULL),
(62, 2, 3, 'Positive attitude', 'Positive attitude', 1, NULL, NULL, NULL, NULL, NULL),
(63, 2, 3, 'Problem solving and critical thinking', 'Problem solving and critical thinking', 1, NULL, NULL, NULL, NULL, NULL),
(64, 2, 3, 'Punctuality', 'Punctuality', 1, NULL, NULL, NULL, NULL, NULL),
(65, 2, 3, 'Dependability', 'Dependability', 1, NULL, NULL, NULL, NULL, NULL),
(66, 2, 3, 'Team player', 'Team player', 1, NULL, NULL, NULL, NULL, NULL),
(67, 2, 3, 'Adaptable', 'Adaptable', 1, NULL, NULL, NULL, NULL, NULL),
(68, 2, 3, 'Pro- activeness', 'Pro- activeness', 1, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `appraisal_reports`
--

CREATE TABLE `appraisal_reports` (
  `id` bigint UNSIGNED NOT NULL,
  `employee_id` int NOT NULL,
  `evaluation_date` date NOT NULL,
  `evaluation_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `evaluation_period` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `appraisal_data` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hod_rating` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hod_rating_avg_compt` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hod_rating_avg_chart` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `principal_rating` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `principal_rating_avg_compt` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `principal_rating_avg_chart` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `future_targets_data` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `future_target_review_date` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `future_targets_recommended` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `training_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `training_due_date` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `training_recommended` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `employee_comments` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hod_comments` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `principal_comments` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `employee_status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hr_action` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hr_action_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hr_comments` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `appraisal_reports`
--

INSERT INTO `appraisal_reports` (`id`, `employee_id`, `evaluation_date`, `evaluation_type`, `evaluation_period`, `appraisal_data`, `hod_rating`, `hod_rating_avg_compt`, `hod_rating_avg_chart`, `principal_rating`, `principal_rating_avg_compt`, `principal_rating_avg_chart`, `future_targets_data`, `future_target_review_date`, `future_targets_recommended`, `training_title`, `training_due_date`, `training_recommended`, `employee_comments`, `hod_comments`, `principal_comments`, `employee_status`, `hr_action`, `hr_action_by`, `hr_comments`, `status`, `created_at`, `updated_at`) VALUES
(1, 8, '2024-05-01', 'Annual', '1 Year', '[\"22\",\"23\",\"24\",\"25\",\"26\",\"27\",\"28\",\"29\",\"30\",\"31\",\"32\",\"33\",\"34\",\"35\",\"36\",\"37\",\"38\",\"39\",\"40\",\"41\",\"42\",\"43\",\"44\",\"45\"]', '[\"3\",\"3\",null,null,null,null,null,null,null,null,null,null,null,null,null,null,\"3\",\"3\",\"2\",null,null,null,null,null]', '2.8', NULL, '[\"3\",\"2\",\"3\",\"3\",\"2\",\"3\",\"3\",null,null,null,\"2\",null,null,null,null,null,\"2\",\"3\",\"3\",null,\"3\",null,null,null]', '1.3333333333333', '1.3333333333333', '[\"Improve stuff\",null,null]', '[\"2024-05-03\",null,null]', '[\"HOD\",\"Choose...\",\"Choose...\"]', '[\"Communtication skill\",null,null]', '[\"2024-05-03\",null,null]', '[\"HOD\",\"Choose...\",\"Choose...\"]', NULL, 'Test', NULL, NULL, NULL, NULL, NULL, 1, '2024-05-03 07:44:24', '2024-05-03 07:52:36'),
(2, 8, '2024-05-02', 'Annual', '1 Year', '[\"22\",\"23\",\"24\",\"25\",\"26\",\"27\",\"28\",\"29\",\"30\",\"31\",\"32\",\"33\",\"34\",\"35\",\"36\",\"37\",\"38\",\"39\",\"40\",\"41\",\"42\",\"43\",\"44\",\"45\"]', '[\"3\",\"3\",\"1\",\"1\",null,null,null,null,null,null,null,null,null,null,null,null,\"3\",\"2\",\"3\",null,null,null,null,null]', '2.2857142857143', NULL, '[\"3\",null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,\"3\",null,null,null,null,null,null,null]', '0.25', '0.25', '[\"Improve stuff\",null,null]', '[\"2024-05-03\",null,null]', '[\"HOD\",\"Choose...\",\"Choose...\"]', '[\"Communtication skill\",null,null]', '[\"2024-05-03\",null,null]', '[\"HOD\",\"Choose...\",\"Choose...\"]', NULL, 'test', NULL, NULL, NULL, NULL, NULL, 1, '2024-05-03 07:54:47', '2024-05-03 08:14:19'),
(3, 8, '2024-05-03', 'Annual', '1 Year', '[\"22\",\"23\",\"24\",\"25\",\"26\",\"27\",\"28\",\"29\",\"30\",\"31\",\"32\",\"33\",\"34\",\"35\",\"36\",\"37\",\"38\",\"39\",\"40\",\"41\",\"42\",\"43\",\"44\",\"45\"]', '[\"3\",null,\"2\",null,null,\"1\",null,null,null,null,null,null,null,null,null,null,\"3\",\"4\",\"3\",\"3\",null,null,null,null]', '2.7142857142857', NULL, 'null', '0', '0', '[\"Improve stuff and patientince\",null,null]', '[\"2024-05-03\",null,null]', '[\"HOD\"]', '[\"Communtication skill\",null,null,null]', '[\"2024-05-03\",null,null,null]', '[\"HOD\"]', NULL, 'Test', NULL, NULL, NULL, NULL, NULL, 1, '2024-05-03 08:15:54', '2024-05-03 08:15:54'),
(4, 1, '2024-05-07', 'Annual', '1 Year', '[\"1\",\"2\",\"3\",\"4\",\"5\",\"6\",\"7\",\"8\",\"9\",\"10\",\"11\",\"12\",\"13\",\"14\",\"15\",\"16\",\"17\",\"18\",\"19\",\"20\",\"21\"]', '[\"3\",\"3\",\"4\",\"4\",\"5\",\"5\",\"4\",\"4\",\"5\",\"4\",\"5\",\"5\",\"4\",\"3\",\"5\",\"2\",\"5\",\"4\",\"5\",\"5\"]', '4.2', '4.2', '[\"1\",\"3\",\"5\",\"3\",\"4\",\"5\",\"4\",\"5\",\"4\",\"4\",\"4\",\"2\",\"3\",\"5\",\"4\",\"4\",\"3\",\"5\",\"5\",\"4\"]', '3.85', '3.85', '[\"No future targets\",\"Everything good\",null,null,null,null]', '[\"2024-05-22\",\"2024-05-22\",null,null,null,null]', '[\"Principal\",\"HOD\",\"Choose...\",\"Choose...\",\"Choose...\",\"Choose...\"]', '[\"No training needed\",\"Some training needed to improve\",null,null,null,null]', '[\"2024-05-22\",\"2024-05-22\",null,null,null,null]', '[\"Principal\",\"HOD\",\"Choose...\",\"Choose...\",\"Choose...\",\"Choose...\"]', NULL, 'This is the exec admin comments', 'This is the principal\'s comment', NULL, NULL, NULL, NULL, 1, '2024-05-07 04:54:11', '2024-05-22 14:18:46'),
(5, 2, '2024-05-13', 'Annual', '1 Year', '[\"22\",\"23\",\"24\",\"25\",\"26\",\"27\",\"28\",\"29\",\"30\",\"31\",\"32\",\"33\",\"34\",\"35\",\"36\",\"37\",\"38\",\"39\",\"40\",\"41\",\"42\",\"43\",\"44\",\"45\"]', '[\"2\",\"1\",\"1\",\"3\",\"2\",\"3\",\"4\",\"4\",\"4\",\"2\",\"3\",\"3\",\"3\",\"3\",\"4\",\"3\",\"4\",\"2\",\"1\",\"2\",\"1\",\"2\",\"2\",\"2\"]', '2.5416666666667', '2.5416666666667', '[\"3\",\"3\",\"3\",\"4\",\"2\",\"3\",\"3\",\"3\",\"3\",\"2\",\"2\",\"2\",\"4\",\"2\",\"1\",\"2\",\"4\",\"3\",\"3\",\"1\",\"2\",\"3\",\"2\",\"3\"]', '2.625', '2.625', '[\"test\",\"test\",null,null,null,null]', '[\"2024-05-20\",\"2024-05-16\",null,null,null,null]', '[\"Vice-Principal\",\"Principal\",\"Choose...\",\"Choose...\",\"Choose...\",\"Choose...\"]', '[\"test\",null,null,null,null,null]', '[\"2024-05-20\",null,null,null,null,null]', '[\"HOD\",\"Choose...\",\"Choose...\",\"Choose...\",\"Choose...\",\"Choose...\"]', 'Test Comment', 'test', 'test', 'Accepted', NULL, NULL, NULL, 1, '2024-05-13 05:29:04', '2024-09-09 11:11:30'),
(6, 7, '2024-05-20', 'Annual', '1 Year', '[\"1\",\"2\",\"3\",\"4\",\"5\",\"6\",\"7\",\"8\",\"9\",\"11\",\"12\",\"13\"]', '[\"1\",\"4\",\"5\",\"2\",\"1\",\"2\",\"4\",\"2\",\"3\",\"3\",\"3\",\"3\"]', '2.75', NULL, 'null', '0', '0', '[null,null,null]', '[null,null,null]', '[\"Choose...\",\"Choose...\",\"Choose...\"]', '[null,null,null]', '[null,null,null]', '[\"Choose...\",\"Choose...\",\"Choose...\"]', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-05-19 10:11:48', '2024-05-19 10:12:55'),
(7, 28, '2024-05-21', 'Annual', '1 Year', '[\"1\",\"2\",\"3\",\"4\",\"5\",\"6\",\"7\",\"8\",\"9\",\"11\",\"12\",\"13\",\"14\",\"15\",\"16\",\"17\",\"18\",\"19\",\"20\",\"21\"]', '[\"3\",\"1\",\"1\",\"1\",\"1\",\"1\",\"2\",\"3\",\"2\",\"2\",\"2\",\"4\",null,null,null,null,null,null,null,null]', '1.15', '1.15', 'null', '0', '0', '[null,null,null]', '[null,null,null]', '[\"Choose...\",\"Choose...\",\"Choose...\"]', '[null,null,null]', '[null,null,null]', '[\"Choose...\",\"Choose...\",\"Choose...\"]', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-05-19 10:16:30', '2024-05-19 10:17:07'),
(8, 18, '2024-05-23', 'Annual', '1 Year', '[\"1\",\"2\",\"3\",\"4\",\"5\",\"6\",\"7\",\"8\",\"9\",\"11\",\"12\",\"13\",\"14\",\"15\",\"16\",\"17\",\"18\",\"19\",\"20\",\"21\"]', '[\"4\",\"4\",\"3\",\"5\",\"3\",\"4\",\"1\",\"4\",\"4\",\"4\",\"5\",\"5\",\"5\",\"5\",\"5\",\"5\",\"3\",\"3\",\"4\",\"4\"]', '4', NULL, '[\"2\",\"3\",\"4\",\"4\",\"2\",\"2\",\"3\",\"2\",\"4\",\"3\",\"1\",\"5\",\"3\",\"4\",\"2\",\"4\",\"4\",\"4\",\"3\",\"5\"]', '3.2', '3.2', '[\"ahha\",\"s\",\"sfgsgs\"]', '[\"2024-05-28\",\"2024-05-28\",\"2024-05-23\"]', '[\"HOD\",\"Principal\",\"HOD\"]', '[\"rfgr\",\"dfasf\",\"asfasd\"]', '[\"2024-05-14\",\"2024-06-10\",\"2024-05-23\"]', '[\"HOD\",\"HOD\",\"HOD\"]', NULL, 'done', 'very good', NULL, NULL, NULL, NULL, 1, '2024-05-19 10:19:28', '2024-05-19 10:21:59'),
(9, 6, '2024-05-20', 'Annual', '1 Year', '[\"22\",\"23\",\"24\",\"25\",\"26\",\"27\",\"28\",\"29\",\"30\",\"31\",\"32\",\"33\",\"34\",\"35\",\"36\",\"37\",\"38\",\"39\",\"40\",\"41\",\"42\",\"43\",\"44\",\"45\"]', '[null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null]', '0', '0', '[\"2\",null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,\"1\",null,null,null,null,null,null,null]', '1.5', NULL, '[\"field 1\",\"field 2\",\"field 3\",\"field 4\",\"field 5\",\"field 6\"]', '[\"2024-05-20\",\"2024-05-21\",\"2024-05-22\",\"2024-05-23\",\"2024-05-24\",\"2024-05-25\"]', '[\"Principal\",\"Principal\",\"Principal\",\"Principal\",\"Principal\",\"Principal\"]', '[\"field1\",\"field2\",\"field3\",\"field4\",\"field5\",\"field6\"]', '[\"2024-05-20\",\"2024-05-21\",\"2024-05-22\",\"2024-05-23\",\"2024-05-24\",\"2024-05-25\"]', '[\"Principal\",\"Principal\",\"Principal\",\"Principal\",\"Principal\",\"Principal\"]', NULL, 'Test', 'Test', NULL, NULL, NULL, NULL, 1, '2024-05-20 05:05:20', '2024-05-22 10:52:49');

-- --------------------------------------------------------

--
-- Table structure for table `appraisal_type`
--

CREATE TABLE `appraisal_type` (
  `id` int NOT NULL,
  `type_name` varchar(200) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` int NOT NULL DEFAULT '1',
  `updated_by` int NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `appraisal_type`
--

INSERT INTO `appraisal_type` (`id`, `type_name`, `active`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(1, 'COMPETENCIES (Ratings and weightages entered by appraiser)', 1, '2023-11-06 09:33:36', '2023-11-06 09:40:00', 1, 1),
(2, 'Employee Characteristics', 1, '2023-11-06 09:40:12', '2023-11-06 13:05:34', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `approval_status`
--

CREATE TABLE `approval_status` (
  `id` int NOT NULL,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `attendances`
--

CREATE TABLE `attendances` (
  `id` bigint UNSIGNED NOT NULL,
  `employee_id` int NOT NULL,
  `shift_id` int DEFAULT NULL,
  `status` enum('check-in','check-out') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `check_in` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `check_out` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `academic_year` smallint NOT NULL DEFAULT '1',
  `comment` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attendances`
--

INSERT INTO `attendances` (`id`, `employee_id`, `shift_id`, `status`, `check_in`, `check_out`, `academic_year`, `comment`, `created_at`, `updated_at`, `created_by`) VALUES
(42, 2, 1, 'check-out', NULL, '2024-09-28 23:30:04', 1, NULL, '2024-09-28 21:30:04', '2024-09-28 21:30:04', 0),
(43, 1, 1, 'check-in', '2025-12-18T17:59:46.333233', NULL, 1, NULL, '2025-12-18 14:29:50', '2025-12-18 14:29:50', 0),
(44, 1, 1, 'check-out', NULL, '2025-12-18T18:00:22.519407', 1, NULL, '2025-12-18 14:30:26', '2025-12-18 14:30:26', 0),
(46, 7, 1, 'check-in', '2025-12-18T12:04:18.757735', NULL, 1, NULL, '2025-12-18 08:34:23', '2025-12-18 08:34:23', 0),
(47, 7, 1, 'check-out', NULL, '2025-12-18T13:36:06.442424', 1, NULL, '2025-12-18 10:06:10', '2025-12-18 10:06:10', 0),
(48, 2, 1, 'check-in', '2025-12-18 07:00:00', NULL, 1, 'Manual', '2025-12-19 11:14:01', '2025-12-19 11:14:01', 3),
(49, 2, 1, 'check-out', NULL, '2025-12-18 15:00:00', 1, 'Manual', '2025-12-19 11:14:19', '2025-12-19 11:14:19', 3),
(50, 8, 1, 'check-in', '2025-12-18 07:00:00', NULL, 1, 'Manual', '2025-12-19 11:15:11', '2025-12-19 11:15:11', 3),
(51, 8, 1, 'check-out', NULL, '2025-12-18 15:12:00', 1, 'Manual', '2025-12-19 11:15:27', '2025-12-19 11:15:27', 3),
(52, 2, 1, 'check-in', '2025-12-16 07:00:00', NULL, 1, 'Manual', '2025-12-19 11:16:26', '2025-12-19 11:16:26', 3),
(53, 2, 1, 'check-out', NULL, '2025-12-16 15:04:00', 1, 'Manual', '2025-12-19 11:16:43', '2025-12-19 11:16:43', 3),
(54, 2, 1, 'check-in', '2025-12-17 07:00:00', NULL, 1, 'Manual', '2025-12-19 11:17:05', '2025-12-19 11:17:05', 3),
(55, 2, 1, 'check-out', NULL, '2025-12-17 15:01:00', 1, 'Manual', '2025-12-19 11:17:18', '2025-12-19 11:17:18', 3),
(56, 81, 1, 'check-in', '2025-12-18 07:01:00', NULL, 1, 'Manual', '2025-12-19 11:17:35', '2025-12-19 11:17:35', 3),
(57, 81, 1, 'check-out', NULL, '2025-12-18 12:00:00', 1, 'Manual', '2025-12-19 11:17:49', '2025-12-19 11:17:49', 3),
(58, 81, 1, 'check-in', '2025-12-18 13:00:00', NULL, 1, 'Manual', '2025-12-19 11:22:09', '2025-12-19 11:22:09', 3),
(59, 81, 1, 'check-out', NULL, '2025-12-18 15:05:00', 1, 'Manual', '2025-12-19 11:22:29', '2025-12-19 11:22:29', 3),
(60, 8, 1, 'check-in', '2025-12-14 07:00:00', NULL, 1, 'Manual', '2025-12-19 11:23:00', '2025-12-19 11:23:00', 3),
(61, 8, 1, 'check-out', NULL, '2025-12-14 15:04:00', 1, 'Manual', '2025-12-19 11:23:16', '2025-12-19 11:23:16', 3),
(62, 2, 1, 'check-in', '2025-12-22 07:00:00', NULL, 1, 'Manual', '2025-12-22 09:47:44', '2025-12-22 09:47:44', 3),
(63, 2, 1, 'check-out', NULL, '2025-12-22 12:03:00', 1, 'Manual', '2025-12-22 09:48:04', '2025-12-22 09:48:04', 3),
(64, 2, 1, 'check-in', '2025-12-22 13:12:00', NULL, 1, 'Manual', '2025-12-22 09:48:29', '2025-12-22 09:48:29', 3),
(65, 2, 1, 'check-out', NULL, '2025-12-22 15:30:00', 1, 'Manual', '2025-12-22 09:48:43', '2025-12-22 09:48:43', 3),
(66, 1, 1, 'check-in', '2025-12-22T13:23:09.628173', NULL, 1, NULL, '2025-12-22 09:53:13', '2025-12-22 09:53:13', 0),
(67, 7, 1, 'check-in', '2025-12-22T13:34:22.741974', NULL, 1, NULL, '2025-12-22 10:04:26', '2025-12-22 10:04:26', 0),
(68, 7, 1, 'check-out', NULL, '2025-12-22T14:34:53.742026', 1, NULL, '2025-12-22 10:04:57', '2025-12-22 10:04:57', 0),
(71, 1, 1, 'check-out', NULL, '2025-12-22T14:00:17.069075', 1, NULL, '2025-12-22 10:30:21', '2025-12-22 10:30:21', 0),
(72, 5, 1, 'check-in', '2025-12-23T10:08:33.012446', NULL, 1, NULL, '2025-12-23 06:38:37', '2025-12-23 06:38:37', 0),
(73, 5, 1, 'check-out', NULL, '2025-12-23T11:10:09.276913', 1, NULL, '2025-12-23 06:39:13', '2025-12-23 06:39:13', 0),
(74, 5, 1, 'check-in', '2025-12-23T11:20:29.045315', NULL, 1, NULL, '2025-12-23 06:39:33', '2025-12-23 06:39:33', 0),
(75, 7, 1, 'check-in', '2025-12-23T10:10:33.732419', NULL, 1, NULL, '2025-12-23 06:40:37', '2025-12-23 06:40:37', 0),
(76, 7, 1, 'check-out', NULL, '2025-12-23T10:38:49.711610', 1, NULL, '2025-12-23 07:08:54', '2025-12-23 07:08:54', 0),
(77, 7, 1, 'check-in', '2025-12-23T10:39:19.644776', NULL, 1, NULL, '2025-12-23 07:09:24', '2025-12-23 07:09:24', 0);

-- --------------------------------------------------------

--
-- Table structure for table `audits`
--

CREATE TABLE `audits` (
  `id` bigint UNSIGNED NOT NULL,
  `user_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `event` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `auditable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `auditable_id` bigint UNSIGNED NOT NULL,
  `old_values` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `new_values` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `url` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` varchar(1023) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tags` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `audits`
--

INSERT INTO `audits` (`id`, `user_type`, `user_id`, `event`, `auditable_type`, `auditable_id`, `old_values`, `new_values`, `url`, `ip_address`, `user_agent`, `tags`, `created_at`, `updated_at`) VALUES
(12, 'App\\Models\\User', 64, 'created', 'App\\Models\\Leave\\LeaveApplicationStatus', 118, '[]', '{\"leave_id\":\"113\",\"applier_id\":\"1\",\"approver_id\":64,\"leave_status\":3,\"assigned_to_role\":1,\"assigned_to_id\":1,\"comment\":\"Vrified\",\"id\":118}', 'https://fas.insahr.com/fas-hrm-test/leave-approve?approver_id=64&employee_id=1&id=117&leave_id=113&status=', '49.37.234.78', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', NULL, '2025-12-18 14:31:33', '2025-12-18 14:31:33'),
(13, 'App\\Models\\User', 64, 'updated', 'App\\Models\\Leave\\LeaveApplication', 113, '{\"forward_from\":\"1\",\"forward_to\":\"64\",\"status\":\"1\"}', '{\"forward_from\":64,\"forward_to\":3,\"status\":3}', 'https://fas.insahr.com/fas-hrm-test/leave-approve?approver_id=64&employee_id=1&id=117&leave_id=113&status=', '49.37.234.78', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', NULL, '2025-12-18 14:31:33', '2025-12-18 14:31:33'),
(14, 'App\\Models\\User', 3, 'created', 'App\\Models\\Leave\\LeaveApplicationStatus', 119, '[]', '{\"leave_id\":\"113\",\"applier_id\":\"1\",\"approver_id\":3,\"leave_status\":3,\"assigned_to_role\":1,\"assigned_to_id\":1,\"comment\":\"Verified\",\"id\":119}', 'https://fas.insahr.com/fas-hrm-test/leave-approve?approver_id=3&employee_id=1&id=118&leave_id=113&status=', '49.37.234.78', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', NULL, '2025-12-18 14:32:16', '2025-12-18 14:32:16'),
(15, 'App\\Models\\User', 3, 'updated', 'App\\Models\\Leave\\LeaveApplication', 113, '{\"forward_from\":\"64\",\"forward_to\":\"3\"}', '{\"forward_from\":3,\"forward_to\":19}', 'https://fas.insahr.com/fas-hrm-test/leave-approve?approver_id=3&employee_id=1&id=118&leave_id=113&status=', '49.37.234.78', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', NULL, '2025-12-18 14:32:16', '2025-12-18 14:32:16'),
(16, 'App\\Models\\User', 19, 'created', 'App\\Models\\Leave\\LeaveApplicationStatus', 120, '[]', '{\"leave_id\":\"113\",\"applier_id\":\"1\",\"approver_id\":19,\"leave_status\":6,\"assigned_to_role\":1,\"assigned_to_id\":1,\"comment\":\"Approved\",\"id\":120}', 'https://fas.insahr.com/fas-hrm-test/leave-approve?approver_id=19&employee_id=1&id=119&leave_id=113&status=', '49.37.234.78', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', NULL, '2025-12-18 14:33:01', '2025-12-18 14:33:01'),
(17, 'App\\Models\\User', 19, 'updated', 'App\\Models\\Leave\\LeaveApplication', 113, '{\"forward_from\":\"3\",\"forward_to\":\"19\",\"status\":\"3\"}', '{\"forward_from\":19,\"forward_to\":3,\"status\":6}', 'https://fas.insahr.com/fas-hrm-test/leave-approve?approver_id=19&employee_id=1&id=119&leave_id=113&status=', '49.37.234.78', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', NULL, '2025-12-18 14:33:01', '2025-12-18 14:33:01'),
(18, 'App\\Models\\User', 3, 'updated', 'App\\Models\\User', 3, '{\"name\":\"Mehrin\",\"avatar\":\"avatar.png\"}', '{\"name\":\"Mehrin MH\",\"avatar\":\"1766130746_vXcBrpHf50.jpg\"}', 'https://fas.insahr.com/insasoft-hrm/employees/3', '49.37.234.78', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', NULL, '2025-12-19 09:52:26', '2025-12-19 09:52:26'),
(19, 'App\\Models\\User', 3, 'created', 'App\\Models\\Leave\\LeaveApplication', 114, '[]', '{\"employee_id\":\"7\",\"leave_type\":\"1\",\"date_from\":\"2025-12-21\",\"date_to\":\"2025-12-21\",\"reason\":\"Nil\",\"no_days\":1,\"time_from\":null,\"time_end\":null,\"attachment\":null,\"forward_from\":\"7\",\"forward_to\":64,\"created_by\":3,\"updated_by\":3,\"academic_year\":3,\"paid_status\":\"0\",\"id\":114}', 'https://fas.insahr.com/insasoft-hrm/leaveapproval/add-leave', '49.37.234.78', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', NULL, '2025-12-19 11:25:29', '2025-12-19 11:25:29'),
(20, 'App\\Models\\User', 3, 'created', 'App\\Models\\Leave\\LeaveApplicationStatus', 121, '[]', '{\"leave_id\":114,\"applier_id\":\"7\",\"approver_id\":64,\"leave_status\":1,\"assigned_to_role\":1,\"assigned_to_id\":1,\"comment\":\"Nil\",\"id\":121}', 'https://fas.insahr.com/insasoft-hrm/leaveapproval/add-leave', '49.37.234.78', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', NULL, '2025-12-19 11:25:29', '2025-12-19 11:25:29'),
(21, 'App\\Models\\User', 64, 'created', 'App\\Models\\Leave\\LeaveApplicationStatus', 122, '[]', '{\"leave_id\":\"114\",\"applier_id\":\"7\",\"approver_id\":64,\"leave_status\":3,\"assigned_to_role\":1,\"assigned_to_id\":1,\"comment\":\"Verified\",\"id\":122}', 'https://fas.insahr.com/insasoft-hrm/leave-approve?approver_id=64&employee_id=7&id=121&leave_id=114&status=', '49.37.234.78', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', NULL, '2025-12-19 11:26:13', '2025-12-19 11:26:13'),
(22, 'App\\Models\\User', 64, 'updated', 'App\\Models\\Leave\\LeaveApplication', 114, '{\"forward_from\":\"7\",\"forward_to\":\"64\",\"status\":\"1\"}', '{\"forward_from\":64,\"forward_to\":3,\"status\":3}', 'https://fas.insahr.com/insasoft-hrm/leave-approve?approver_id=64&employee_id=7&id=121&leave_id=114&status=', '49.37.234.78', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', NULL, '2025-12-19 11:26:13', '2025-12-19 11:26:13'),
(23, 'App\\Models\\User', 3, 'created', 'App\\Models\\SchoolEvent', 45, '[]', '{\"academic_year\":3,\"event_title\":\"Xmas Holiday\",\"event_details\":\"Xmas\",\"event_from\":\"2025-12-25\",\"event_to\":\"2025-12-25\",\"event_type\":\"Full Day\",\"event_time_from\":\"2025-12-25 11:18:00\",\"event_time_to\":\"2025-12-25 11:18:00\",\"applicable_to\":\"0\",\"bg_color\":\"#eccf65\",\"created_by\":3,\"updated_by\":3,\"id\":45}', 'https://fas.insahr.com/insasoft-hrm/calendar/addUpdateEvent', '49.37.234.78', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', NULL, '2025-12-22 07:48:26', '2025-12-22 07:48:26'),
(24, 'App\\Models\\User', 3, 'updated', 'App\\Models\\SchoolEvent', 45, '{\"event_title\":\"Xmas Holiday\"}', '{\"event_title\":\"X\'mas Holiday\"}', 'https://fas.insahr.com/insasoft-hrm/calendar/UpdateEvent', '49.37.234.78', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', NULL, '2025-12-22 07:48:43', '2025-12-22 07:48:43'),
(25, 'App\\Models\\User', 9, 'created', 'App\\Models\\Leave\\LeaveApplication', 115, '[]', '{\"employee_id\":\"7\",\"leave_type\":\"1\",\"date_from\":\"2025-12-25\",\"date_to\":\"2025-12-25\",\"time_from\":\"null\",\"time_end\":\"null\",\"no_days\":\"1\",\"reason\":\"casual\",\"attachment\":null,\"forward_from\":\"7\",\"forward_to\":64,\"created_by\":9,\"updated_by\":9,\"academic_year\":3,\"id\":115}', 'https://fas.insahr.com/insasoft-hrm/api/apply-leave', '49.37.234.78', 'Dart/3.10 (dart:io)', NULL, '2025-12-22 10:07:18', '2025-12-22 10:07:18'),
(26, 'App\\Models\\User', 9, 'created', 'App\\Models\\Leave\\LeaveApplicationStatus', 123, '[]', '{\"leave_id\":115,\"applier_id\":\"7\",\"approver_id\":64,\"leave_status\":1,\"assigned_to_role\":1,\"assigned_to_id\":1,\"comment\":\"casual\",\"id\":123}', 'https://fas.insahr.com/insasoft-hrm/api/apply-leave', '49.37.234.78', 'Dart/3.10 (dart:io)', NULL, '2025-12-22 10:07:18', '2025-12-22 10:07:18'),
(27, 'App\\Models\\User', 3, 'created', 'App\\Models\\Leave\\LeaveApplication', 116, '[]', '{\"employee_id\":\"1\",\"leave_type\":\"1\",\"date_from\":\"2025-12-23\",\"date_to\":\"2025-12-24\",\"time_from\":\"null\",\"time_end\":\"null\",\"no_days\":\"2\",\"reason\":\"due to some personal emergency\",\"attachment\":null,\"forward_from\":\"1\",\"forward_to\":64,\"created_by\":3,\"updated_by\":3,\"academic_year\":3,\"id\":116}', 'https://fas.insahr.com/insasoft-hrm/api/apply-leave', '49.37.234.78', 'Dart/3.10 (dart:io)', NULL, '2025-12-22 10:34:19', '2025-12-22 10:34:19'),
(28, 'App\\Models\\User', 3, 'created', 'App\\Models\\Leave\\LeaveApplicationStatus', 124, '[]', '{\"leave_id\":116,\"applier_id\":\"1\",\"approver_id\":64,\"leave_status\":1,\"assigned_to_role\":1,\"assigned_to_id\":1,\"comment\":\"due to some personal emergency\",\"id\":124}', 'https://fas.insahr.com/insasoft-hrm/api/apply-leave', '49.37.234.78', 'Dart/3.10 (dart:io)', NULL, '2025-12-22 10:34:19', '2025-12-22 10:34:19'),
(29, 'App\\Models\\User', 64, 'created', 'App\\Models\\Leave\\LeaveApplicationStatus', 125, '[]', '{\"leave_id\":\"116\",\"applier_id\":\"1\",\"approver_id\":64,\"leave_status\":3,\"assigned_to_role\":1,\"assigned_to_id\":1,\"comment\":\"Verified\",\"id\":125}', 'https://fas.insahr.com/insasoft-hrm/leave-approve?approver_id=64&employee_id=1&id=124&leave_id=116&status=', '49.37.234.78', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', NULL, '2025-12-22 10:36:41', '2025-12-22 10:36:41'),
(30, 'App\\Models\\User', 64, 'updated', 'App\\Models\\Leave\\LeaveApplication', 116, '{\"forward_from\":\"1\",\"forward_to\":\"64\",\"status\":\"1\"}', '{\"forward_from\":64,\"forward_to\":3,\"status\":3}', 'https://fas.insahr.com/insasoft-hrm/leave-approve?approver_id=64&employee_id=1&id=124&leave_id=116&status=', '49.37.234.78', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', NULL, '2025-12-22 10:36:41', '2025-12-22 10:36:41'),
(31, 'App\\Models\\User', 3, 'created', 'App\\Models\\Leave\\LeaveApplicationStatus', 126, '[]', '{\"leave_id\":\"116\",\"applier_id\":\"1\",\"approver_id\":3,\"leave_status\":3,\"assigned_to_role\":1,\"assigned_to_id\":1,\"comment\":\"Verified\",\"id\":126}', 'https://fas.insahr.com/insasoft-hrm/leave-approve?approver_id=3&employee_id=1&id=125&leave_id=116&status=', '49.37.234.78', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', NULL, '2025-12-22 10:37:15', '2025-12-22 10:37:15'),
(32, 'App\\Models\\User', 3, 'updated', 'App\\Models\\Leave\\LeaveApplication', 116, '{\"forward_from\":\"64\",\"forward_to\":\"3\"}', '{\"forward_from\":3,\"forward_to\":19}', 'https://fas.insahr.com/insasoft-hrm/leave-approve?approver_id=3&employee_id=1&id=125&leave_id=116&status=', '49.37.234.78', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', NULL, '2025-12-22 10:37:15', '2025-12-22 10:37:15'),
(33, 'App\\Models\\User', 19, 'created', 'App\\Models\\Leave\\LeaveApplicationStatus', 127, '[]', '{\"leave_id\":\"116\",\"applier_id\":\"1\",\"approver_id\":19,\"leave_status\":6,\"assigned_to_role\":1,\"assigned_to_id\":1,\"comment\":\"Approved\",\"id\":127}', 'https://fas.insahr.com/insasoft-hrm/leave-approve?approver_id=19&employee_id=1&id=126&leave_id=116&status=', '49.37.234.78', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', NULL, '2025-12-22 10:37:55', '2025-12-22 10:37:55'),
(34, 'App\\Models\\User', 19, 'updated', 'App\\Models\\Leave\\LeaveApplication', 116, '{\"forward_from\":\"3\",\"forward_to\":\"19\",\"status\":\"3\"}', '{\"forward_from\":19,\"forward_to\":3,\"status\":6}', 'https://fas.insahr.com/insasoft-hrm/leave-approve?approver_id=19&employee_id=1&id=126&leave_id=116&status=', '49.37.234.78', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', NULL, '2025-12-22 10:37:55', '2025-12-22 10:37:55'),
(35, 'App\\Models\\User', 3, 'created', 'App\\Models\\Leave\\LeaveApplicationStatus', 128, '[]', '{\"leave_id\":\"115\",\"applier_id\":\"7\",\"approver_id\":3,\"leave_status\":3,\"assigned_to_role\":1,\"assigned_to_id\":1,\"comment\":\"Verified\",\"id\":128}', 'https://fas.insahr.com/insasoft-hrm/leave-approve?approver_id=3&employee_id=7&id=123&leave_id=115&status=', '49.37.234.78', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', NULL, '2025-12-22 11:03:47', '2025-12-22 11:03:47'),
(36, 'App\\Models\\User', 3, 'updated', 'App\\Models\\Leave\\LeaveApplication', 115, '{\"forward_from\":\"7\",\"forward_to\":\"3\",\"status\":\"1\"}', '{\"forward_from\":3,\"forward_to\":19,\"status\":3}', 'https://fas.insahr.com/insasoft-hrm/leave-approve?approver_id=3&employee_id=7&id=123&leave_id=115&status=', '49.37.234.78', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', NULL, '2025-12-22 11:03:47', '2025-12-22 11:03:47'),
(37, 'App\\Models\\User', 3, 'created', 'App\\Models\\Leave\\LeaveApplication', 117, '[]', '{\"employee_id\":\"8\",\"leave_type\":\"3\",\"date_from\":\"2025-12-23\",\"date_to\":\"2025-12-23\",\"reason\":\"Sick\",\"no_days\":1,\"time_from\":null,\"time_end\":null,\"attachment\":null,\"forward_from\":\"8\",\"forward_to\":3,\"created_by\":3,\"updated_by\":3,\"academic_year\":3,\"paid_status\":\"0\",\"id\":117}', 'https://fas.insahr.com/insasoft-hrm/leaveapproval/add-leave', '49.37.234.78', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', NULL, '2025-12-22 11:30:26', '2025-12-22 11:30:26'),
(38, 'App\\Models\\User', 3, 'created', 'App\\Models\\Leave\\LeaveApplicationStatus', 129, '[]', '{\"leave_id\":117,\"applier_id\":\"8\",\"approver_id\":3,\"leave_status\":1,\"assigned_to_role\":1,\"assigned_to_id\":1,\"comment\":\"Sick\",\"id\":129}', 'https://fas.insahr.com/insasoft-hrm/leaveapproval/add-leave', '49.37.234.78', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', NULL, '2025-12-22 11:30:26', '2025-12-22 11:30:26'),
(39, 'App\\Models\\User', 3, 'created', 'App\\Models\\Leave\\LeaveApplicationStatus', 130, '[]', '{\"leave_id\":\"111\",\"applier_id\":\"2\",\"approver_id\":3,\"leave_status\":3,\"assigned_to_role\":1,\"assigned_to_id\":1,\"comment\":\"Verified\",\"id\":130}', 'https://fas.insahr.com/insasoft-hrm/leave-approve?approver_id=3&employee_id=2&id=115&leave_id=111&status=', '49.37.234.78', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', NULL, '2025-12-22 11:30:58', '2025-12-22 11:30:58'),
(40, 'App\\Models\\User', 3, 'updated', 'App\\Models\\Leave\\LeaveApplication', 111, '{\"forward_from\":\"2\",\"forward_to\":\"3\",\"status\":\"1\"}', '{\"forward_from\":3,\"forward_to\":19,\"status\":3}', 'https://fas.insahr.com/insasoft-hrm/leave-approve?approver_id=3&employee_id=2&id=115&leave_id=111&status=', '49.37.234.78', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', NULL, '2025-12-22 11:30:58', '2025-12-22 11:30:58'),
(41, 'App\\Models\\User', 7, 'created', 'App\\Models\\Leave\\LeaveApplication', 118, '[]', '{\"employee_id\":\"5\",\"leave_type\":\"3\",\"date_from\":\"2025-12-23\",\"date_to\":\"2025-12-23\",\"time_from\":\"null\",\"time_end\":\"null\",\"no_days\":\"1\",\"reason\":\"sick leave\",\"attachment\":null,\"forward_from\":\"5\",\"forward_to\":3,\"created_by\":7,\"updated_by\":7,\"academic_year\":3,\"id\":118}', 'https://fas.insahr.com/insasoft-hrm/api/apply-leave', '116.68.81.1', 'Dart/3.10 (dart:io)', NULL, '2025-12-22 17:31:11', '2025-12-22 17:31:11'),
(42, 'App\\Models\\User', 7, 'created', 'App\\Models\\Leave\\LeaveApplicationStatus', 131, '[]', '{\"leave_id\":118,\"applier_id\":\"5\",\"approver_id\":3,\"leave_status\":1,\"assigned_to_role\":1,\"assigned_to_id\":1,\"comment\":\"sick leave\",\"id\":131}', 'https://fas.insahr.com/insasoft-hrm/api/apply-leave', '116.68.81.1', 'Dart/3.10 (dart:io)', NULL, '2025-12-22 17:31:12', '2025-12-22 17:31:12'),
(43, 'App\\Models\\User', 3, 'created', 'App\\Models\\Leave\\LeaveApplicationStatus', 132, '[]', '{\"leave_id\":\"118\",\"applier_id\":\"5\",\"approver_id\":3,\"leave_status\":3,\"assigned_to_role\":1,\"assigned_to_id\":1,\"comment\":\"Verified\",\"id\":132}', 'https://fas.insahr.com/insasoft-hrm/leave-approve?approver_id=3&employee_id=5&id=131&leave_id=118&status=', '116.68.81.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', NULL, '2025-12-22 17:38:47', '2025-12-22 17:38:47'),
(44, 'App\\Models\\User', 3, 'updated', 'App\\Models\\Leave\\LeaveApplication', 118, '{\"forward_from\":\"5\",\"forward_to\":\"3\",\"status\":\"1\"}', '{\"forward_from\":3,\"forward_to\":19,\"status\":3}', 'https://fas.insahr.com/insasoft-hrm/leave-approve?approver_id=3&employee_id=5&id=131&leave_id=118&status=', '116.68.81.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', NULL, '2025-12-22 17:38:47', '2025-12-22 17:38:47'),
(45, 'App\\Models\\User', 19, 'created', 'App\\Models\\Leave\\LeaveApplicationStatus', 133, '[]', '{\"leave_id\":\"118\",\"applier_id\":\"5\",\"approver_id\":19,\"leave_status\":6,\"assigned_to_role\":1,\"assigned_to_id\":1,\"comment\":\"Approved\",\"id\":133}', 'https://fas.insahr.com/insasoft-hrm/leave-approve?approver_id=19&employee_id=5&id=132&leave_id=118&status=', '116.68.81.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', NULL, '2025-12-22 17:39:49', '2025-12-22 17:39:49'),
(46, 'App\\Models\\User', 19, 'updated', 'App\\Models\\Leave\\LeaveApplication', 118, '{\"forward_from\":\"3\",\"forward_to\":\"19\",\"status\":\"3\"}', '{\"forward_from\":19,\"forward_to\":3,\"status\":6}', 'https://fas.insahr.com/insasoft-hrm/leave-approve?approver_id=19&employee_id=5&id=132&leave_id=118&status=', '116.68.81.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', NULL, '2025-12-22 17:39:49', '2025-12-22 17:39:49'),
(47, 'App\\Models\\User', 7, 'created', 'App\\Models\\Leave\\LeaveApplication', 119, '[]', '{\"employee_id\":\"5\",\"leave_type\":\"4\",\"date_from\":\"2025-12-24\",\"date_to\":\"2025-12-24\",\"time_from\":\"null\",\"time_end\":\"null\",\"no_days\":\"1\",\"reason\":\"emergency..\",\"attachment\":null,\"forward_from\":\"5\",\"forward_to\":3,\"created_by\":7,\"updated_by\":7,\"academic_year\":3,\"id\":119}', 'https://fas.insahr.com/insasoft-hrm/api/apply-leave', '116.68.81.1', 'Dart/3.10 (dart:io)', NULL, '2025-12-22 18:20:07', '2025-12-22 18:20:07'),
(48, 'App\\Models\\User', 7, 'created', 'App\\Models\\Leave\\LeaveApplicationStatus', 134, '[]', '{\"leave_id\":119,\"applier_id\":\"5\",\"approver_id\":3,\"leave_status\":1,\"assigned_to_role\":1,\"assigned_to_id\":1,\"comment\":\"emergency..\",\"id\":134}', 'https://fas.insahr.com/insasoft-hrm/api/apply-leave', '116.68.81.1', 'Dart/3.10 (dart:io)', NULL, '2025-12-22 18:20:07', '2025-12-22 18:20:07'),
(49, 'App\\Models\\User', 3, 'created', 'App\\Models\\Leave\\LeaveApplicationStatus', 135, '[]', '{\"leave_id\":\"119\",\"applier_id\":\"5\",\"approver_id\":3,\"leave_status\":3,\"assigned_to_role\":1,\"assigned_to_id\":1,\"comment\":\"Verified\",\"id\":135}', 'https://fas.insahr.com/insasoft-hrm/leave-approve?approver_id=3&employee_id=5&id=134&leave_id=119&status=', '49.37.234.78', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', NULL, '2025-12-23 08:46:36', '2025-12-23 08:46:36'),
(50, 'App\\Models\\User', 3, 'updated', 'App\\Models\\Leave\\LeaveApplication', 119, '{\"forward_from\":\"5\",\"forward_to\":\"3\",\"status\":\"1\"}', '{\"forward_from\":3,\"forward_to\":19,\"status\":3}', 'https://fas.insahr.com/insasoft-hrm/leave-approve?approver_id=3&employee_id=5&id=134&leave_id=119&status=', '49.37.234.78', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', NULL, '2025-12-23 08:46:36', '2025-12-23 08:46:36'),
(51, 'App\\Models\\User', 19, 'created', 'App\\Models\\Leave\\LeaveApplicationStatus', 136, '[]', '{\"leave_id\":\"119\",\"applier_id\":\"5\",\"approver_id\":19,\"leave_status\":6,\"assigned_to_role\":1,\"assigned_to_id\":1,\"comment\":\"Approved\",\"id\":136}', 'https://fas.insahr.com/insasoft-hrm/leave-approve?approver_id=19&employee_id=5&id=135&leave_id=119&status=', '49.37.234.78', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', NULL, '2025-12-23 08:47:42', '2025-12-23 08:47:42'),
(52, 'App\\Models\\User', 19, 'updated', 'App\\Models\\Leave\\LeaveApplication', 119, '{\"forward_from\":\"3\",\"forward_to\":\"19\",\"status\":\"3\"}', '{\"forward_from\":19,\"forward_to\":3,\"status\":6}', 'https://fas.insahr.com/insasoft-hrm/leave-approve?approver_id=19&employee_id=5&id=135&leave_id=119&status=', '49.37.234.78', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', NULL, '2025-12-23 08:47:42', '2025-12-23 08:47:42'),
(53, 'App\\Models\\User', 6, 'created', 'App\\Models\\Leave\\LeaveApplication', 120, '[]', '{\"employee_id\":\"4\",\"leave_type\":\"6\",\"date_from\":\"2025-12-24\",\"date_to\":\"2025-12-24\",\"time_from\":\"01:30 PM\",\"time_end\":\"05:30 PM\",\"no_days\":\"1\",\"reason\":\"short leave\",\"attachment\":null,\"forward_from\":\"4\",\"forward_to\":3,\"created_by\":6,\"updated_by\":6,\"academic_year\":3,\"id\":120}', 'https://fas.insahr.com/insasoft-hrm/api/apply-leave', '49.37.234.78', 'Dart/3.10 (dart:io)', NULL, '2025-12-23 08:59:27', '2025-12-23 08:59:27'),
(54, 'App\\Models\\User', 6, 'created', 'App\\Models\\Leave\\LeaveApplicationStatus', 137, '[]', '{\"leave_id\":120,\"applier_id\":\"4\",\"approver_id\":3,\"leave_status\":1,\"assigned_to_role\":1,\"assigned_to_id\":1,\"comment\":\"short leave\",\"id\":137}', 'https://fas.insahr.com/insasoft-hrm/api/apply-leave', '49.37.234.78', 'Dart/3.10 (dart:io)', NULL, '2025-12-23 08:59:27', '2025-12-23 08:59:27'),
(55, 'App\\Models\\User', 3, 'created', 'App\\Models\\Leave\\LeaveApplicationStatus', 138, '[]', '{\"leave_id\":\"120\",\"applier_id\":\"4\",\"approver_id\":3,\"leave_status\":3,\"assigned_to_role\":1,\"assigned_to_id\":1,\"comment\":\"Verified\",\"id\":138}', 'https://fas.insahr.com/insasoft-hrm/leave-approve?approver_id=3&employee_id=4&id=137&leave_id=120&status=', '49.37.234.78', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', NULL, '2025-12-23 09:20:25', '2025-12-23 09:20:25'),
(56, 'App\\Models\\User', 3, 'updated', 'App\\Models\\Leave\\LeaveApplication', 120, '{\"forward_from\":\"4\",\"forward_to\":\"3\",\"status\":\"1\"}', '{\"forward_from\":3,\"forward_to\":19,\"status\":3}', 'https://fas.insahr.com/insasoft-hrm/leave-approve?approver_id=3&employee_id=4&id=137&leave_id=120&status=', '49.37.234.78', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', NULL, '2025-12-23 09:20:25', '2025-12-23 09:20:25'),
(57, 'App\\Models\\User', 19, 'created', 'App\\Models\\Leave\\LeaveApplicationStatus', 139, '[]', '{\"leave_id\":\"120\",\"applier_id\":\"4\",\"approver_id\":19,\"leave_status\":6,\"assigned_to_role\":1,\"assigned_to_id\":1,\"comment\":\"Approved\",\"id\":139}', 'https://fas.insahr.com/insasoft-hrm/leave-approve?approver_id=19&employee_id=4&id=138&leave_id=120&status=', '49.37.234.78', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', NULL, '2025-12-23 09:21:36', '2025-12-23 09:21:36'),
(58, 'App\\Models\\User', 19, 'updated', 'App\\Models\\Leave\\LeaveApplication', 120, '{\"forward_from\":\"3\",\"forward_to\":\"19\",\"status\":\"3\"}', '{\"forward_from\":19,\"forward_to\":3,\"status\":6}', 'https://fas.insahr.com/insasoft-hrm/leave-approve?approver_id=19&employee_id=4&id=138&leave_id=120&status=', '49.37.234.78', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', NULL, '2025-12-23 09:21:36', '2025-12-23 09:21:36'),
(59, 'App\\Models\\User', 6, 'created', 'App\\Models\\Leave\\LeaveApplication', 121, '[]', '{\"employee_id\":\"4\",\"leave_type\":\"1\",\"date_from\":\"2025-12-24\",\"date_to\":\"2025-12-24\",\"time_from\":\"null\",\"time_end\":\"null\",\"no_days\":\"1\",\"reason\":\"due to some personal emergency\",\"attachment\":null,\"forward_from\":\"4\",\"forward_to\":3,\"created_by\":6,\"updated_by\":6,\"academic_year\":3,\"id\":121}', 'https://fas.insahr.com/insasoft-hrm/api/apply-leave', '49.37.234.78', 'Dart/3.10 (dart:io)', NULL, '2025-12-23 12:40:50', '2025-12-23 12:40:50'),
(60, 'App\\Models\\User', 6, 'created', 'App\\Models\\Leave\\LeaveApplicationStatus', 140, '[]', '{\"leave_id\":121,\"applier_id\":\"4\",\"approver_id\":3,\"leave_status\":1,\"assigned_to_role\":1,\"assigned_to_id\":1,\"comment\":\"due to some personal emergency\",\"id\":140}', 'https://fas.insahr.com/insasoft-hrm/api/apply-leave', '49.37.234.78', 'Dart/3.10 (dart:io)', NULL, '2025-12-23 12:40:50', '2025-12-23 12:40:50'),
(62, 'App\\Models\\User', 1, 'created', 'App\\Models\\Leave\\LeaveApprovalFlow', 3, '[]', '{\"name\":\"Administration Flow\",\"description\":null,\"id\":3}', 'https://fas.insahr.com/insasoft-hrm/approval-flows', '49.37.234.78', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', NULL, '2025-12-24 08:15:37', '2025-12-24 08:15:37'),
(63, 'App\\Models\\User', 1, 'created', 'App\\Models\\Leave\\LeaveApprovalFlowStep', 3, '[]', '{\"leave_approval_flow_id\":3,\"role\":\"Executive-Admin\",\"step_order\":1,\"id\":3}', 'https://fas.insahr.com/insasoft-hrm/approval-flows', '49.37.234.78', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', NULL, '2025-12-24 08:15:37', '2025-12-24 08:15:37'),
(64, 'App\\Models\\User', 1, 'created', 'App\\Models\\Leave\\LeaveApprovalFlowStep', 4, '[]', '{\"leave_approval_flow_id\":3,\"role\":\"Hr\",\"step_order\":2,\"id\":4}', 'https://fas.insahr.com/insasoft-hrm/approval-flows', '49.37.234.78', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', NULL, '2025-12-24 08:15:37', '2025-12-24 08:15:37'),
(65, 'App\\Models\\User', 1, 'created', 'App\\Models\\Leave\\LeaveApprovalFlowStep', 5, '[]', '{\"leave_approval_flow_id\":3,\"role\":\"Principal\",\"step_order\":3,\"id\":5}', 'https://fas.insahr.com/insasoft-hrm/approval-flows', '49.37.234.78', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', NULL, '2025-12-24 08:15:37', '2025-12-24 08:15:37'),
(66, 'App\\Models\\User', 1, 'created', 'App\\Models\\Leave\\LeaveApprovalFlowStep', 6, '[]', '{\"leave_approval_flow_id\":1,\"role\":\"Vp\",\"step_order\":1,\"id\":6}', 'https://fas.insahr.com/insasoft-hrm/approval-flows/1', '49.37.234.78', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', NULL, '2025-12-24 08:15:48', '2025-12-24 08:15:48'),
(67, 'App\\Models\\User', 1, 'created', 'App\\Models\\Leave\\LeaveApprovalFlowStep', 7, '[]', '{\"leave_approval_flow_id\":1,\"role\":\"Hr\",\"step_order\":2,\"id\":7}', 'https://fas.insahr.com/insasoft-hrm/approval-flows/1', '49.37.234.78', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', NULL, '2025-12-24 08:15:48', '2025-12-24 08:15:48'),
(68, 'App\\Models\\User', 1, 'created', 'App\\Models\\Leave\\LeaveApprovalFlowStep', 8, '[]', '{\"leave_approval_flow_id\":1,\"role\":\"Principal\",\"step_order\":3,\"id\":8}', 'https://fas.insahr.com/insasoft-hrm/approval-flows/1', '49.37.234.78', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', NULL, '2025-12-24 08:15:48', '2025-12-24 08:15:48'),
(69, 'App\\Models\\User', 1, 'updated', 'App\\Models\\Leave\\LeaveApprovalFlow', 1, '{\"name\":\"Common Flow\"}', '{\"name\":\"Staff Flow\"}', 'https://fas.insahr.com/insasoft-hrm/approval-flows/1', '49.37.234.78', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', NULL, '2025-12-24 08:17:36', '2025-12-24 08:17:36'),
(70, 'App\\Models\\User', 1, 'created', 'App\\Models\\Leave\\LeaveApprovalFlowStep', 9, '[]', '{\"leave_approval_flow_id\":1,\"role\":\"Vp\",\"step_order\":1,\"id\":9}', 'https://fas.insahr.com/insasoft-hrm/approval-flows/1', '49.37.234.78', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', NULL, '2025-12-24 08:17:36', '2025-12-24 08:17:36'),
(71, 'App\\Models\\User', 1, 'created', 'App\\Models\\Leave\\LeaveApprovalFlowStep', 10, '[]', '{\"leave_approval_flow_id\":1,\"role\":\"Hr\",\"step_order\":2,\"id\":10}', 'https://fas.insahr.com/insasoft-hrm/approval-flows/1', '49.37.234.78', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', NULL, '2025-12-24 08:17:36', '2025-12-24 08:17:36'),
(72, 'App\\Models\\User', 1, 'created', 'App\\Models\\Leave\\LeaveApprovalFlowStep', 11, '[]', '{\"leave_approval_flow_id\":1,\"role\":\"Principal\",\"step_order\":3,\"id\":11}', 'https://fas.insahr.com/insasoft-hrm/approval-flows/1', '49.37.234.78', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', NULL, '2025-12-24 08:17:36', '2025-12-24 08:17:36'),
(73, 'App\\Models\\User', 1, 'created', 'App\\Models\\Leave\\LeaveApprovalFlow', 4, '[]', '{\"name\":\"Common Flow\",\"description\":null,\"id\":4}', 'https://fas.insahr.com/insasoft-hrm/approval-flows', '49.37.234.78', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', NULL, '2025-12-24 08:17:46', '2025-12-24 08:17:46'),
(74, 'App\\Models\\User', 1, 'created', 'App\\Models\\Leave\\LeaveApprovalFlowStep', 12, '[]', '{\"leave_approval_flow_id\":4,\"role\":\"Hr\",\"step_order\":1,\"id\":12}', 'https://fas.insahr.com/insasoft-hrm/approval-flows', '49.37.234.78', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', NULL, '2025-12-24 08:17:46', '2025-12-24 08:17:46'),
(75, 'App\\Models\\User', 1, 'created', 'App\\Models\\Leave\\LeaveApprovalFlowStep', 13, '[]', '{\"leave_approval_flow_id\":4,\"role\":\"Principal\",\"step_order\":2,\"id\":13}', 'https://fas.insahr.com/insasoft-hrm/approval-flows', '49.37.234.78', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', NULL, '2025-12-24 08:17:46', '2025-12-24 08:17:46');

-- --------------------------------------------------------

--
-- Table structure for table `budget_type`
--

CREATE TABLE `budget_type` (
  `id` bigint UNSIGNED NOT NULL,
  `budget_type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_from` date NOT NULL,
  `start_to` date NOT NULL,
  `amount` double(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `budget_type`
--

INSERT INTO `budget_type` (`id`, `budget_type`, `start_from`, `start_to`, `amount`, `created_at`, `updated_at`, `updated_by`, `created_by`, `deleted_at`) VALUES
(1, 'year_wise', '2023-03-16', '2023-03-28', 10000.00, NULL, NULL, NULL, NULL, NULL),
(2, 'month_wise', '2023-03-16', '2023-03-28', 10000.00, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `contract_type`
--

CREATE TABLE `contract_type` (
  `id` int NOT NULL,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contract_type`
--

INSERT INTO `contract_type` (`id`, `name`, `description`, `active`, `updated_by`, `created_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Fixed', 'FX', 1, NULL, NULL, NULL, NULL, NULL),
(2, 'Indefinite', 'ID', 1, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` int NOT NULL,
  `phone_code` int NOT NULL,
  `country_code` char(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `country_name` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `ord` smallint NOT NULL DEFAULT '8',
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `phone_code`, `country_code`, `country_name`, `status`, `ord`, `updated_by`, `created_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 93, 'AF', 'Afghanistan', 1, 10, NULL, NULL, NULL, NULL, NULL),
(2, 358, 'AX', 'Aland Islands', 1, 10, NULL, NULL, NULL, NULL, NULL),
(3, 355, 'AL', 'Albania', 1, 10, NULL, NULL, NULL, NULL, NULL),
(4, 213, 'DZ', 'Algeria', 1, 10, NULL, NULL, NULL, NULL, NULL),
(5, 1684, 'AS', 'American Samoa', 1, 10, NULL, NULL, NULL, NULL, NULL),
(6, 376, 'AD', 'Andorra', 1, 10, NULL, NULL, NULL, NULL, NULL),
(7, 244, 'AO', 'Angola', 1, 10, NULL, NULL, NULL, NULL, NULL),
(8, 1264, 'AI', 'Anguilla', 1, 10, NULL, NULL, NULL, NULL, NULL),
(9, 672, 'AQ', 'Antarctica', 1, 10, NULL, NULL, NULL, NULL, NULL),
(10, 1268, 'AG', 'Antigua and Barbuda', 1, 10, NULL, NULL, NULL, NULL, NULL),
(11, 54, 'AR', 'Argentina', 1, 10, NULL, NULL, NULL, NULL, NULL),
(12, 374, 'AM', 'Armenia', 1, 10, NULL, NULL, NULL, NULL, NULL),
(13, 297, 'AW', 'Aruba', 1, 10, NULL, NULL, NULL, NULL, NULL),
(14, 61, 'AU', 'Australia', 1, 10, NULL, NULL, NULL, NULL, NULL),
(15, 43, 'AT', 'Austria', 1, 10, NULL, NULL, NULL, NULL, NULL),
(16, 994, 'AZ', 'Azerbaijan', 1, 10, NULL, NULL, NULL, NULL, NULL),
(17, 1242, 'BS', 'Bahamas', 1, 10, NULL, NULL, NULL, NULL, NULL),
(18, 973, 'BH', 'Bahrain', 1, 6, NULL, NULL, NULL, NULL, NULL),
(19, 880, 'BD', 'Bangladesh', 1, 10, NULL, NULL, NULL, NULL, NULL),
(20, 1246, 'BB', 'Barbados', 1, 10, NULL, NULL, NULL, NULL, NULL),
(21, 375, 'BY', 'Belarus', 1, 10, NULL, NULL, NULL, NULL, NULL),
(22, 32, 'BE', 'Belgium', 1, 10, NULL, NULL, NULL, NULL, NULL),
(23, 501, 'BZ', 'Belize', 1, 10, NULL, NULL, NULL, NULL, NULL),
(24, 229, 'BJ', 'Benin', 1, 10, NULL, NULL, NULL, NULL, NULL),
(25, 1441, 'BM', 'Bermuda', 1, 10, NULL, NULL, NULL, NULL, NULL),
(26, 975, 'BT', 'Bhutan', 1, 10, NULL, NULL, NULL, NULL, NULL),
(27, 591, 'BO', 'Bolivia', 1, 10, NULL, NULL, NULL, NULL, NULL),
(28, 599, 'BQ', 'Bonaire, Sint Eustatius and Saba', 1, 10, NULL, NULL, NULL, NULL, NULL),
(29, 387, 'BA', 'Bosnia and Herzegovina', 1, 10, NULL, NULL, NULL, NULL, NULL),
(30, 267, 'BW', 'Botswana', 1, 10, NULL, NULL, NULL, NULL, NULL),
(31, 55, 'BV', 'Bouvet Island', 1, 10, NULL, NULL, NULL, NULL, NULL),
(32, 55, 'BR', 'Brazil', 1, 10, NULL, NULL, NULL, NULL, NULL),
(33, 246, 'IO', 'British Indian Ocean Territory', 1, 10, NULL, NULL, NULL, NULL, NULL),
(34, 673, 'BN', 'Brunei Darussalam', 1, 10, NULL, NULL, NULL, NULL, NULL),
(35, 359, 'BG', 'Bulgaria', 1, 10, NULL, NULL, NULL, NULL, NULL),
(36, 226, 'BF', 'Burkina Faso', 1, 10, NULL, NULL, NULL, NULL, NULL),
(37, 257, 'BI', 'Burundi', 1, 10, NULL, NULL, NULL, NULL, NULL),
(38, 855, 'KH', 'Cambodia', 1, 10, NULL, NULL, NULL, NULL, NULL),
(39, 237, 'CM', 'Cameroon', 1, 10, NULL, NULL, NULL, NULL, NULL),
(40, 1, 'CA', 'Canada', 1, 10, NULL, NULL, NULL, NULL, NULL),
(41, 238, 'CV', 'Cape Verde', 1, 10, NULL, NULL, NULL, NULL, NULL),
(42, 1345, 'KY', 'Cayman Islands', 1, 10, NULL, NULL, NULL, NULL, NULL),
(43, 236, 'CF', 'Central African Republic', 1, 10, NULL, NULL, NULL, NULL, NULL),
(44, 235, 'TD', 'Chad', 1, 10, NULL, NULL, NULL, NULL, NULL),
(45, 56, 'CL', 'Chile', 1, 10, NULL, NULL, NULL, NULL, NULL),
(46, 86, 'CN', 'China', 1, 10, NULL, NULL, NULL, NULL, NULL),
(47, 61, 'CX', 'Christmas Island', 1, 10, NULL, NULL, NULL, NULL, NULL),
(48, 672, 'CC', 'Cocos (Keeling) Islands', 1, 10, NULL, NULL, NULL, NULL, NULL),
(49, 57, 'CO', 'Colombia', 1, 10, NULL, NULL, NULL, NULL, NULL),
(50, 269, 'KM', 'Comoros', 1, 10, NULL, NULL, NULL, NULL, NULL),
(51, 242, 'CG', 'Congo', 1, 10, NULL, NULL, NULL, NULL, NULL),
(52, 242, 'CD', 'Congo, Democratic Republic of the Congo', 1, 10, NULL, NULL, NULL, NULL, NULL),
(53, 682, 'CK', 'Cook Islands', 1, 10, NULL, NULL, NULL, NULL, NULL),
(54, 506, 'CR', 'Costa Rica', 1, 10, NULL, NULL, NULL, NULL, NULL),
(55, 225, 'CI', 'Cote D\'Ivoire', 1, 10, NULL, NULL, NULL, NULL, NULL),
(56, 385, 'HR', 'Croatia', 1, 10, NULL, NULL, NULL, NULL, NULL),
(57, 53, 'CU', 'Cuba', 1, 10, NULL, NULL, NULL, NULL, NULL),
(58, 599, 'CW', 'Curacao', 1, 10, NULL, NULL, NULL, NULL, NULL),
(59, 357, 'CY', 'Cyprus', 1, 10, NULL, NULL, NULL, NULL, NULL),
(60, 420, 'CZ', 'Czech Republic', 1, 10, NULL, NULL, NULL, NULL, NULL),
(61, 45, 'DK', 'Denmark', 1, 10, NULL, NULL, NULL, NULL, NULL),
(62, 253, 'DJ', 'Djibouti', 1, 10, NULL, NULL, NULL, NULL, NULL),
(63, 1767, 'DM', 'Dominica', 1, 10, NULL, NULL, NULL, NULL, NULL),
(64, 1809, 'DO', 'Dominican Republic', 1, 10, NULL, NULL, NULL, NULL, NULL),
(65, 593, 'EC', 'Ecuador', 1, 10, NULL, NULL, NULL, NULL, NULL),
(66, 20, 'EG', 'Egypt', 1, 10, NULL, NULL, NULL, NULL, NULL),
(67, 503, 'SV', 'El Salvador', 1, 10, NULL, NULL, NULL, NULL, NULL),
(68, 240, 'GQ', 'Equatorial Guinea', 1, 10, NULL, NULL, NULL, NULL, NULL),
(69, 291, 'ER', 'Eritrea', 1, 10, NULL, NULL, NULL, NULL, NULL),
(70, 372, 'EE', 'Estonia', 1, 10, NULL, NULL, NULL, NULL, NULL),
(71, 251, 'ET', 'Ethiopia', 1, 10, NULL, NULL, NULL, NULL, NULL),
(72, 500, 'FK', 'Falkland Islands (Malvinas)', 1, 10, NULL, NULL, NULL, NULL, NULL),
(73, 298, 'FO', 'Faroe Islands', 1, 10, NULL, NULL, NULL, NULL, NULL),
(74, 679, 'FJ', 'Fiji', 1, 10, NULL, NULL, NULL, NULL, NULL),
(75, 358, 'FI', 'Finland', 1, 10, NULL, NULL, NULL, NULL, NULL),
(76, 33, 'FR', 'France', 1, 10, NULL, NULL, NULL, NULL, NULL),
(77, 594, 'GF', 'French Guiana', 1, 10, NULL, NULL, NULL, NULL, NULL),
(78, 689, 'PF', 'French Polynesia', 1, 10, NULL, NULL, NULL, NULL, NULL),
(79, 262, 'TF', 'French Southern Territories', 1, 10, NULL, NULL, NULL, NULL, NULL),
(80, 241, 'GA', 'Gabon', 1, 10, NULL, NULL, NULL, NULL, NULL),
(81, 220, 'GM', 'Gambia', 1, 10, NULL, NULL, NULL, NULL, NULL),
(82, 995, 'GE', 'Georgia', 1, 10, NULL, NULL, NULL, NULL, NULL),
(83, 49, 'DE', 'Germany', 1, 10, NULL, NULL, NULL, NULL, NULL),
(84, 233, 'GH', 'Ghana', 1, 10, NULL, NULL, NULL, NULL, NULL),
(85, 350, 'GI', 'Gibraltar', 1, 10, NULL, NULL, NULL, NULL, NULL),
(86, 30, 'GR', 'Greece', 1, 10, NULL, NULL, NULL, NULL, NULL),
(87, 299, 'GL', 'Greenland', 1, 10, NULL, NULL, NULL, NULL, NULL),
(88, 1473, 'GD', 'Grenada', 1, 10, NULL, NULL, NULL, NULL, NULL),
(89, 590, 'GP', 'Guadeloupe', 1, 10, NULL, NULL, NULL, NULL, NULL),
(90, 1671, 'GU', 'Guam', 1, 10, NULL, NULL, NULL, NULL, NULL),
(91, 502, 'GT', 'Guatemala', 1, 10, NULL, NULL, NULL, NULL, NULL),
(92, 44, 'GG', 'Guernsey', 1, 10, NULL, NULL, NULL, NULL, NULL),
(93, 224, 'GN', 'Guinea', 1, 10, NULL, NULL, NULL, NULL, NULL),
(94, 245, 'GW', 'Guinea-Bissau', 1, 10, NULL, NULL, NULL, NULL, NULL),
(95, 592, 'GY', 'Guyana', 1, 10, NULL, NULL, NULL, NULL, NULL),
(96, 509, 'HT', 'Haiti', 1, 10, NULL, NULL, NULL, NULL, NULL),
(97, 0, 'HM', 'Heard Island and Mcdonald Islands', 1, 10, NULL, NULL, NULL, NULL, NULL),
(98, 39, 'VA', 'Holy See (Vatican City State)', 1, 10, NULL, NULL, NULL, NULL, NULL),
(99, 504, 'HN', 'Honduras', 1, 10, NULL, NULL, NULL, NULL, NULL),
(100, 852, 'HK', 'Hong Kong', 1, 10, NULL, NULL, NULL, NULL, NULL),
(101, 36, 'HU', 'Hungary', 1, 10, NULL, NULL, NULL, NULL, NULL),
(102, 354, 'IS', 'Iceland', 1, 10, NULL, NULL, NULL, NULL, NULL),
(103, 91, 'IN', 'India', 1, 7, NULL, NULL, NULL, NULL, NULL),
(104, 62, 'ID', 'Indonesia', 1, 10, NULL, NULL, NULL, NULL, NULL),
(105, 98, 'IR', 'Iran, Islamic Republic of', 1, 10, NULL, NULL, NULL, NULL, NULL),
(106, 964, 'IQ', 'Iraq', 1, 10, NULL, NULL, NULL, NULL, NULL),
(107, 353, 'IE', 'Ireland', 1, 10, NULL, NULL, NULL, NULL, NULL),
(108, 44, 'IM', 'Isle of Man', 1, 10, NULL, NULL, NULL, NULL, NULL),
(109, 972, 'IL', 'Israel', 1, 10, NULL, NULL, NULL, NULL, NULL),
(110, 39, 'IT', 'Italy', 1, 10, NULL, NULL, NULL, NULL, NULL),
(111, 1876, 'JM', 'Jamaica', 1, 10, NULL, NULL, NULL, NULL, NULL),
(112, 81, 'JP', 'Japan', 1, 10, NULL, NULL, NULL, NULL, NULL),
(113, 44, 'JE', 'Jersey', 1, 10, NULL, NULL, NULL, NULL, NULL),
(114, 962, 'JO', 'Jordan', 1, 10, NULL, NULL, NULL, NULL, NULL),
(115, 7, 'KZ', 'Kazakhstan', 1, 10, NULL, NULL, NULL, NULL, NULL),
(116, 254, 'KE', 'Kenya', 1, 10, NULL, NULL, NULL, NULL, NULL),
(117, 686, 'KI', 'Kiribati', 1, 10, NULL, NULL, NULL, NULL, NULL),
(118, 850, 'KP', 'Korea, Democratic People\'s Republic of', 1, 10, NULL, NULL, NULL, NULL, NULL),
(119, 82, 'KR', 'Korea, Republic of', 1, 10, NULL, NULL, NULL, NULL, NULL),
(120, 381, 'XK', 'Kosovo', 1, 10, NULL, NULL, NULL, NULL, NULL),
(121, 965, 'KW', 'Kuwait', 1, 5, NULL, NULL, NULL, NULL, NULL),
(122, 996, 'KG', 'Kyrgyzstan', 1, 10, NULL, NULL, NULL, NULL, NULL),
(123, 856, 'LA', 'Lao People\'s Democratic Republic', 1, 10, NULL, NULL, NULL, NULL, NULL),
(124, 371, 'LV', 'Latvia', 1, 10, NULL, NULL, NULL, NULL, NULL),
(125, 961, 'LB', 'Lebanon', 1, 10, NULL, NULL, NULL, NULL, NULL),
(126, 266, 'LS', 'Lesotho', 1, 10, NULL, NULL, NULL, NULL, NULL),
(127, 231, 'LR', 'Liberia', 1, 10, NULL, NULL, NULL, NULL, NULL),
(128, 218, 'LY', 'Libyan Arab Jamahiriya', 1, 10, NULL, NULL, NULL, NULL, NULL),
(129, 423, 'LI', 'Liechtenstein', 1, 10, NULL, NULL, NULL, NULL, NULL),
(130, 370, 'LT', 'Lithuania', 1, 10, NULL, NULL, NULL, NULL, NULL),
(131, 352, 'LU', 'Luxembourg', 1, 10, NULL, NULL, NULL, NULL, NULL),
(132, 853, 'MO', 'Macao', 1, 10, NULL, NULL, NULL, NULL, NULL),
(133, 389, 'MK', 'Macedonia, the Former Yugoslav Republic of', 1, 10, NULL, NULL, NULL, NULL, NULL),
(134, 261, 'MG', 'Madagascar', 1, 10, NULL, NULL, NULL, NULL, NULL),
(135, 265, 'MW', 'Malawi', 1, 10, NULL, NULL, NULL, NULL, NULL),
(136, 60, 'MY', 'Malaysia', 1, 10, NULL, NULL, NULL, NULL, NULL),
(137, 960, 'MV', 'Maldives', 1, 10, NULL, NULL, NULL, NULL, NULL),
(138, 223, 'ML', 'Mali', 1, 10, NULL, NULL, NULL, NULL, NULL),
(139, 356, 'MT', 'Malta', 1, 10, NULL, NULL, NULL, NULL, NULL),
(140, 692, 'MH', 'Marshall Islands', 1, 10, NULL, NULL, NULL, NULL, NULL),
(141, 596, 'MQ', 'Martinique', 1, 10, NULL, NULL, NULL, NULL, NULL),
(142, 222, 'MR', 'Mauritania', 1, 10, NULL, NULL, NULL, NULL, NULL),
(143, 230, 'MU', 'Mauritius', 1, 10, NULL, NULL, NULL, NULL, NULL),
(144, 269, 'YT', 'Mayotte', 1, 10, NULL, NULL, NULL, NULL, NULL),
(145, 52, 'MX', 'Mexico', 1, 10, NULL, NULL, NULL, NULL, NULL),
(146, 691, 'FM', 'Micronesia, Federated States of', 1, 10, NULL, NULL, NULL, NULL, NULL),
(147, 373, 'MD', 'Moldova, Republic of', 1, 10, NULL, NULL, NULL, NULL, NULL),
(148, 377, 'MC', 'Monaco', 1, 10, NULL, NULL, NULL, NULL, NULL),
(149, 976, 'MN', 'Mongolia', 1, 10, NULL, NULL, NULL, NULL, NULL),
(150, 382, 'ME', 'Montenegro', 1, 10, NULL, NULL, NULL, NULL, NULL),
(151, 1664, 'MS', 'Montserrat', 1, 10, NULL, NULL, NULL, NULL, NULL),
(152, 212, 'MA', 'Morocco', 1, 10, NULL, NULL, NULL, NULL, NULL),
(153, 258, 'MZ', 'Mozambique', 1, 10, NULL, NULL, NULL, NULL, NULL),
(154, 95, 'MM', 'Myanmar', 1, 10, NULL, NULL, NULL, NULL, NULL),
(155, 264, 'NA', 'Namibia', 1, 10, NULL, NULL, NULL, NULL, NULL),
(156, 674, 'NR', 'Nauru', 1, 10, NULL, NULL, NULL, NULL, NULL),
(157, 977, 'NP', 'Nepal', 1, 10, NULL, NULL, NULL, NULL, NULL),
(158, 31, 'NL', 'Netherlands', 1, 10, NULL, NULL, NULL, NULL, NULL),
(159, 599, 'AN', 'Netherlands Antilles', 1, 10, NULL, NULL, NULL, NULL, NULL),
(160, 687, 'NC', 'New Caledonia', 1, 10, NULL, NULL, NULL, NULL, NULL),
(161, 64, 'NZ', 'New Zealand', 1, 10, NULL, NULL, NULL, NULL, NULL),
(162, 505, 'NI', 'Nicaragua', 1, 10, NULL, NULL, NULL, NULL, NULL),
(163, 227, 'NE', 'Niger', 1, 10, NULL, NULL, NULL, NULL, NULL),
(164, 234, 'NG', 'Nigeria', 1, 10, NULL, NULL, NULL, NULL, NULL),
(165, 683, 'NU', 'Niue', 1, 10, NULL, NULL, NULL, NULL, NULL),
(166, 672, 'NF', 'Norfolk Island', 1, 10, NULL, NULL, NULL, NULL, NULL),
(167, 1670, 'MP', 'Northern Mariana Islands', 1, 10, NULL, NULL, NULL, NULL, NULL),
(168, 47, 'NO', 'Norway', 1, 10, NULL, NULL, NULL, NULL, NULL),
(169, 968, 'OM', 'Oman', 1, 3, NULL, NULL, NULL, NULL, NULL),
(170, 92, 'PK', 'Pakistan', 1, 10, NULL, NULL, NULL, NULL, NULL),
(171, 680, 'PW', 'Palau', 1, 10, NULL, NULL, NULL, NULL, NULL),
(172, 970, 'PS', 'Palestinian Territory, Occupied', 1, 10, NULL, NULL, NULL, NULL, NULL),
(173, 507, 'PA', 'Panama', 1, 10, NULL, NULL, NULL, NULL, NULL),
(174, 675, 'PG', 'Papua New Guinea', 1, 10, NULL, NULL, NULL, NULL, NULL),
(175, 595, 'PY', 'Paraguay', 1, 10, NULL, NULL, NULL, NULL, NULL),
(176, 51, 'PE', 'Peru', 1, 10, NULL, NULL, NULL, NULL, NULL),
(177, 63, 'PH', 'Philippines', 1, 10, NULL, NULL, NULL, NULL, NULL),
(178, 64, 'PN', 'Pitcairn', 1, 10, NULL, NULL, NULL, NULL, NULL),
(179, 48, 'PL', 'Poland', 1, 10, NULL, NULL, NULL, NULL, NULL),
(180, 351, 'PT', 'Portugal', 1, 10, NULL, NULL, NULL, NULL, NULL),
(181, 1787, 'PR', 'Puerto Rico', 1, 10, NULL, NULL, NULL, NULL, NULL),
(182, 974, 'QA', 'Qatar', 1, 1, NULL, NULL, NULL, NULL, NULL),
(183, 262, 'RE', 'Reunion', 1, 10, NULL, NULL, NULL, NULL, NULL),
(184, 40, 'RO', 'Romania', 1, 10, NULL, NULL, NULL, NULL, NULL),
(185, 70, 'RU', 'Russian Federation', 1, 10, NULL, NULL, NULL, NULL, NULL),
(186, 250, 'RW', 'Rwanda', 1, 10, NULL, NULL, NULL, NULL, NULL),
(187, 590, 'BL', 'Saint Barthelemy', 1, 10, NULL, NULL, NULL, NULL, NULL),
(188, 290, 'SH', 'Saint Helena', 1, 10, NULL, NULL, NULL, NULL, NULL),
(189, 1869, 'KN', 'Saint Kitts and Nevis', 1, 10, NULL, NULL, NULL, NULL, NULL),
(190, 1758, 'LC', 'Saint Lucia', 1, 10, NULL, NULL, NULL, NULL, NULL),
(191, 590, 'MF', 'Saint Martin', 1, 10, NULL, NULL, NULL, NULL, NULL),
(192, 508, 'PM', 'Saint Pierre and Miquelon', 1, 10, NULL, NULL, NULL, NULL, NULL),
(193, 1784, 'VC', 'Saint Vincent and the Grenadines', 1, 10, NULL, NULL, NULL, NULL, NULL),
(194, 684, 'WS', 'Samoa', 1, 10, NULL, NULL, NULL, NULL, NULL),
(195, 378, 'SM', 'San Marino', 1, 10, NULL, NULL, NULL, NULL, NULL),
(196, 239, 'ST', 'Sao Tome and Principe', 1, 10, NULL, NULL, NULL, NULL, NULL),
(197, 966, 'SA', 'Saudi Arabia', 1, 4, NULL, NULL, NULL, NULL, NULL),
(198, 221, 'SN', 'Senegal', 1, 10, NULL, NULL, NULL, NULL, NULL),
(199, 381, 'RS', 'Serbia', 1, 10, NULL, NULL, NULL, NULL, NULL),
(200, 381, 'CS', 'Serbia and Montenegro', 1, 10, NULL, NULL, NULL, NULL, NULL),
(201, 248, 'SC', 'Seychelles', 1, 10, NULL, NULL, NULL, NULL, NULL),
(202, 232, 'SL', 'Sierra Leone', 1, 10, NULL, NULL, NULL, NULL, NULL),
(203, 65, 'SG', 'Singapore', 1, 10, NULL, NULL, NULL, NULL, NULL),
(204, 1, 'SX', 'Sint Maarten', 1, 10, NULL, NULL, NULL, NULL, NULL),
(205, 421, 'SK', 'Slovakia', 1, 10, NULL, NULL, NULL, NULL, NULL),
(206, 386, 'SI', 'Slovenia', 1, 10, NULL, NULL, NULL, NULL, NULL),
(207, 677, 'SB', 'Solomon Islands', 1, 10, NULL, NULL, NULL, NULL, NULL),
(208, 252, 'SO', 'Somalia', 1, 10, NULL, NULL, NULL, NULL, NULL),
(209, 27, 'ZA', 'South Africa', 1, 10, NULL, NULL, NULL, NULL, NULL),
(210, 500, 'GS', 'South Georgia and the South Sandwich Islands', 1, 10, NULL, NULL, NULL, NULL, NULL),
(211, 211, 'SS', 'South Sudan', 1, 10, NULL, NULL, NULL, NULL, NULL),
(212, 34, 'ES', 'Spain', 1, 10, NULL, NULL, NULL, NULL, NULL),
(213, 94, 'LK', 'Sri Lanka', 1, 10, NULL, NULL, NULL, NULL, NULL),
(214, 249, 'SD', 'Sudan', 1, 10, NULL, NULL, NULL, NULL, NULL),
(215, 597, 'SR', 'Suriname', 1, 10, NULL, NULL, NULL, NULL, NULL),
(216, 47, 'SJ', 'Svalbard and Jan Mayen', 1, 10, NULL, NULL, NULL, NULL, NULL),
(217, 268, 'SZ', 'Swaziland', 1, 10, NULL, NULL, NULL, NULL, NULL),
(218, 46, 'SE', 'Sweden', 1, 10, NULL, NULL, NULL, NULL, NULL),
(219, 41, 'CH', 'Switzerland', 1, 10, NULL, NULL, NULL, NULL, NULL),
(220, 963, 'SY', 'Syrian Arab Republic', 1, 10, NULL, NULL, NULL, NULL, NULL),
(221, 886, 'TW', 'Taiwan, Province of China', 1, 10, NULL, NULL, NULL, NULL, NULL),
(222, 992, 'TJ', 'Tajikistan', 1, 10, NULL, NULL, NULL, NULL, NULL),
(223, 255, 'TZ', 'Tanzania, United Republic of', 1, 10, NULL, NULL, NULL, NULL, NULL),
(224, 66, 'TH', 'Thailand', 1, 10, NULL, NULL, NULL, NULL, NULL),
(225, 670, 'TL', 'Timor-Leste', 1, 10, NULL, NULL, NULL, NULL, NULL),
(226, 228, 'TG', 'Togo', 1, 10, NULL, NULL, NULL, NULL, NULL),
(227, 690, 'TK', 'Tokelau', 1, 10, NULL, NULL, NULL, NULL, NULL),
(228, 676, 'TO', 'Tonga', 1, 10, NULL, NULL, NULL, NULL, NULL),
(229, 1868, 'TT', 'Trinidad and Tobago', 1, 10, NULL, NULL, NULL, NULL, NULL),
(230, 216, 'TN', 'Tunisia', 1, 10, NULL, NULL, NULL, NULL, NULL),
(231, 90, 'TR', 'Turkey', 1, 10, NULL, NULL, NULL, NULL, NULL),
(232, 7370, 'TM', 'Turkmenistan', 1, 10, NULL, NULL, NULL, NULL, NULL),
(233, 1649, 'TC', 'Turks and Caicos Islands', 1, 10, NULL, NULL, NULL, NULL, NULL),
(234, 688, 'TV', 'Tuvalu', 1, 10, NULL, NULL, NULL, NULL, NULL),
(235, 256, 'UG', 'Uganda', 1, 10, NULL, NULL, NULL, NULL, NULL),
(236, 380, 'UA', 'Ukraine', 1, 10, NULL, NULL, NULL, NULL, NULL),
(237, 971, 'AE', 'United Arab Emirates', 1, 2, NULL, NULL, NULL, NULL, NULL),
(238, 44, 'GB', 'United Kingdom', 1, 9, NULL, NULL, NULL, NULL, NULL),
(239, 1, 'US', 'United States', 1, 8, NULL, NULL, NULL, NULL, NULL),
(240, 1, 'UM', 'United States Minor Outlying Islands', 1, 10, NULL, NULL, NULL, NULL, NULL),
(241, 598, 'UY', 'Uruguay', 1, 10, NULL, NULL, NULL, NULL, NULL),
(242, 998, 'UZ', 'Uzbekistan', 1, 10, NULL, NULL, NULL, NULL, NULL),
(243, 678, 'VU', 'Vanuatu', 1, 10, NULL, NULL, NULL, NULL, NULL),
(244, 58, 'VE', 'Venezuela', 1, 10, NULL, NULL, NULL, NULL, NULL),
(245, 84, 'VN', 'Viet Nam', 1, 10, NULL, NULL, NULL, NULL, NULL),
(246, 1284, 'VG', 'Virgin Islands, British', 1, 10, NULL, NULL, NULL, NULL, NULL),
(247, 1340, 'VI', 'Virgin Islands, U.s.', 1, 10, NULL, NULL, NULL, NULL, NULL),
(248, 681, 'WF', 'Wallis and Futuna', 1, 10, NULL, NULL, NULL, NULL, NULL),
(249, 212, 'EH', 'Western Sahara', 1, 10, NULL, NULL, NULL, NULL, NULL),
(250, 967, 'YE', 'Yemen', 1, 10, NULL, NULL, NULL, NULL, NULL),
(251, 260, 'ZM', 'Zambia', 1, 10, NULL, NULL, NULL, NULL, NULL),
(252, 263, 'ZW', 'Zimbabwe', 1, 10, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `dashboard_settings`
--

CREATE TABLE `dashboard_settings` (
  `id` int NOT NULL,
  `role_id` tinyint NOT NULL,
  `card` longtext NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dashboard_settings`
--

INSERT INTO `dashboard_settings` (`id`, `role_id`, `card`, `created_at`, `updated_at`) VALUES
(1, 1, '[\"AE\",\"IE\",\"LA\",\"AL\"]', '2023-11-07 08:09:40', '2023-11-07 08:09:40'),
(2, 3, '[\"AE\",\"IE\",\"LA\",\"AL\",\"QE\",\"PE\"]', '2023-11-07 08:09:40', '2023-11-07 08:09:40'),
(3, 5, '[\"AE\",\"LA\",\"AL\"]', '2023-11-07 08:09:40', '2023-11-07 08:09:40'),
(4, 6, '[\"AE\",\"IE\",\"LA\",\"AL\"]', '2023-11-07 08:09:40', '2023-11-07 08:09:40'),
(5, 7, '[\"AE\",\"LA\",\"AL\"]', '2023-11-07 08:09:40', '2023-11-07 08:09:40');

-- --------------------------------------------------------

--
-- Table structure for table `deductions`
--

CREATE TABLE `deductions` (
  `id` bigint UNSIGNED NOT NULL,
  `employee_id` int NOT NULL,
  `month_year` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `deduction_amount` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `deduction_reason` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remarks` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_deduction_amount` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `deductions`
--

INSERT INTO `deductions` (`id`, `employee_id`, `month_year`, `deduction_amount`, `deduction_reason`, `remarks`, `total_deduction_amount`, `created_at`, `updated_at`) VALUES
(1, 2, 'May-2024', '[\"10\"]', '[\"Disciplinary\"]', 'Test', 10, '2024-08-30 10:47:10', '2024-08-30 10:47:10');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent` mediumint NOT NULL DEFAULT '0',
  `description` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`, `parent`, `description`, `active`, `updated_by`, `created_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Staff', 0, 'Department for staffs', 1, NULL, NULL, NULL, NULL, NULL),
(2, 'Administration', 0, 'Department for admin staffs', 1, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `designations`
--

CREATE TABLE `designations` (
  `id` int NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `department_id` int NOT NULL DEFAULT '0',
  `description` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `designations`
--

INSERT INTO `designations` (`id`, `name`, `department_id`, `description`, `status`, `updated_by`, `created_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Senior Assistant', 2, 'SAT', 1, NULL, NULL, '2023-03-24 08:59:21', '2023-03-24 11:42:57', NULL),
(2, 'Training Coordinator', 1, 'TRC', 1, NULL, NULL, '2023-05-07 05:31:45', '2023-05-07 05:31:45', NULL),
(3, 'Digital Learning Coordinator', 1, 'DLC', 1, NULL, NULL, '2023-05-07 05:32:58', '2023-05-07 05:32:58', NULL),
(4, 'Assistant', 1, 'AST', 1, NULL, NULL, '2023-05-07 05:33:22', '2023-05-07 05:33:22', NULL),
(5, 'Assistant Teacher', 1, 'AST', 1, NULL, NULL, '2023-05-07 05:34:34', '2023-05-07 05:34:34', NULL),
(6, 'Support Teacher', 1, 'SPT', 1, NULL, NULL, '2023-05-07 05:34:55', '2023-05-07 05:34:55', NULL),
(7, 'Consultant', 1, 'CNS', 1, NULL, NULL, '2023-05-07 05:35:17', '2023-05-07 05:35:17', NULL),
(11, 'Qatar History Coordinator', 1, 'QHC', 1, NULL, NULL, '2023-05-07 05:36:49', '2023-05-07 05:36:49', NULL),
(14, 'Social Worker', 1, 'SOW', 1, NULL, NULL, '2023-05-07 05:37:38', '2023-05-07 05:37:38', NULL),
(16, 'CEO - GM', 2, 'CEO', 1, NULL, NULL, '2023-05-07 05:39:06', '2023-05-07 05:39:06', NULL),
(17, 'Executive CEO', 2, 'EXCO', 1, NULL, NULL, '2023-05-07 05:39:21', '2023-05-07 05:39:21', NULL),
(18, 'Admission Officer', 2, 'AOR', 1, NULL, NULL, '2023-05-07 05:39:38', '2023-05-07 05:39:38', NULL),
(20, 'Accountant', 2, 'ACT', 1, NULL, NULL, '2023-05-07 05:40:11', '2023-05-07 05:40:11', NULL),
(21, 'Secretary', 2, 'SECR', 1, NULL, NULL, '2023-05-07 05:40:30', '2023-05-07 05:40:30', NULL),
(22, 'HR Manager', 2, 'HRM', 1, NULL, NULL, '2023-05-07 05:40:42', '2023-05-07 05:40:42', NULL),
(23, 'Project Manager', 2, 'PRM', 1, NULL, NULL, '2023-05-07 05:40:57', '2023-05-07 05:40:57', NULL),
(24, 'Premises Supervisor', 2, 'PRSU', 1, NULL, NULL, '2023-05-07 05:41:10', '2023-05-07 05:41:10', NULL),
(25, 'IT Administrator', 2, 'ITAR', 1, NULL, NULL, '2023-05-07 05:41:23', '2023-05-07 05:41:23', NULL),
(26, 'Executive Administrator', 2, 'EXAR', 1, NULL, NULL, '2023-05-07 05:41:45', '2023-05-07 05:41:45', NULL),
(27, 'Registrar', 2, 'RGR', 1, NULL, NULL, '2023-05-07 05:42:33', '2023-05-07 05:42:33', NULL),
(28, 'Office Assistant', 2, 'OFAS', 1, NULL, NULL, '2023-05-07 05:42:43', '2023-05-07 05:42:43', NULL),
(29, 'HR Officer/ Secretary', 2, 'HROSCR', 1, NULL, NULL, '2023-09-10 14:58:42', '2023-09-10 14:58:42', NULL),
(30, 'Office Administrator', 2, 'OFADM', 1, NULL, NULL, '2023-09-10 15:01:17', '2023-09-10 15:01:17', NULL),
(31, 'Evening Coordinator', 1, 'EVNCO', 1, NULL, NULL, '2023-09-10 15:06:19', '2023-09-10 15:06:19', NULL),
(32, 'Ministry coordinator', 2, 'MINCO', 1, NULL, NULL, '2023-09-10 15:06:40', '2023-09-10 15:06:40', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `earnings`
--

CREATE TABLE `earnings` (
  `id` bigint UNSIGNED NOT NULL,
  `employee_id` int NOT NULL,
  `month_year` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `additional_amount` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `additional_reason` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remarks` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ticket_accural_amount` int DEFAULT NULL,
  `return_tkt_amount` int DEFAULT NULL,
  `total_addtional_amount` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `earnings`
--

INSERT INTO `earnings` (`id`, `employee_id`, `month_year`, `additional_amount`, `additional_reason`, `remarks`, `ticket_accural_amount`, `return_tkt_amount`, `total_addtional_amount`, `created_at`, `updated_at`) VALUES
(1, 2, 'April-2024', '[\"500\",\"500\"]', '[\"Additional Task\",\"Ticket Accrual\"]', 'test', NULL, NULL, 1000, '2024-04-29 19:09:42', '2024-04-29 19:47:07'),
(2, 2, 'May-2024', '[\"32\"]', '[\"Fuel\"]', NULL, NULL, NULL, 32, '2024-08-29 14:12:26', '2024-08-29 14:15:57');

-- --------------------------------------------------------

--
-- Table structure for table `email_decision`
--

CREATE TABLE `email_decision` (
  `id` int NOT NULL,
  `email` varchar(100) NOT NULL,
  `token` varchar(500) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `email_decision`
--

INSERT INTO `email_decision` (`id`, `email`, `token`, `created_at`) VALUES
(1, 'principal@insasoft.com', 'CpyxStDRs81wy2DtCn5sClxBZgPjSDYdnLwVEy3CFZziS3q8Y1iqcM6SiILhW1ID', '2025-12-18 14:32:16'),
(2, 'principal@insasoft.com', 'NPD32vhsRlTCZAB5Xphykohcwaoh4qMuOVBplhfD4Bw9XgEvvKiQoeqdJ7jFyMNH', '2025-12-22 10:37:15'),
(3, 'principal@insasoft.com', 'DEOiCVTrimsZeUaBE5AqfvvFzCP3Is1pxc1gWObqv8lfvRIMc8QDT4TSkYRyDgM7', '2025-12-22 11:03:47'),
(4, 'principal@insasoft.com', 'angz4SelE0MX34qsM4QxCNoFkWAmDIqmxtdPWwXTZmDrmvYgPLowkKUiwOgv9G9M', '2025-12-22 11:30:58'),
(5, 'ceo@insasoft.com', '0usNEDd562Bb55maU3FX83HImFDICLXCxyhYS0spC2ah77yTzpcmCw7wJTOrlPUd', '2025-12-22 17:38:47'),
(6, 'ceo@insasoft.com', 'Nb4M3aN8PHQcGxpz7bJHAFNglBR2tfjXLRq9Qe2fxD0o8JwJMzLW1ixTBMKUMeXf', '2025-12-23 08:46:36'),
(7, 'ceo@insasoft.com', '0rGpcK1JDoK1yBeiX39BBm0BM9pVSfAeGTXhdI1tyP3R9voZBZN6o9UWrq8wxDXR', '2025-12-23 09:20:25');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `employee_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `employee_no` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `employee_type` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `lname` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `dob` date DEFAULT NULL,
  `age` smallint DEFAULT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nationality` smallint NOT NULL,
  `marital_status` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile1_code` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile1` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile2_code` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile2` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `qidno` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `qidexpiry` date DEFAULT NULL,
  `qid_attaches` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `passportno` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `passportexpiry` date DEFAULT NULL,
  `passport_attaches` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `joiningdate` date DEFAULT NULL,
  `department` int DEFAULT NULL,
  `designation` int DEFAULT NULL,
  `school_shift` smallint DEFAULT NULL,
  `end_probation` date DEFAULT NULL,
  `contract_type` tinyint DEFAULT NULL,
  `contract_length` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `end_contract` date DEFAULT NULL,
  `service_years` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hrcomment` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `sponsorship_status` int NOT NULL DEFAULT '0',
  `fas_sponsor` int DEFAULT NULL,
  `fas_spo_date` date DEFAULT NULL,
  `tkt_allowance_dur` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `relevant_degree` int DEFAULT NULL,
  `degree_details` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `degree_attaches` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `degree_attest_status` int DEFAULT NULL,
  `other_qualifications` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `disclaimer_ltr_moe` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `disclaimer_ltr_moe_atch` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `declaration_ltr_moe` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `declaration_ltr_moe_atch` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `moe_approval_status` smallint DEFAULT NULL,
  `police_clearance_issuance` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `police_clearance_atch` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `noc` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `noc_atch` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `experience_letter` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `experience_letter_atch` int DEFAULT NULL,
  `is_conformed` tinyint NOT NULL DEFAULT '0',
  `status` tinyint NOT NULL DEFAULT '1',
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `user_id`, `employee_id`, `employee_no`, `employee_type`, `name`, `lname`, `gender`, `dob`, `age`, `email`, `nationality`, `marital_status`, `mobile1_code`, `mobile1`, `mobile2_code`, `mobile2`, `qidno`, `qidexpiry`, `qid_attaches`, `passportno`, `passportexpiry`, `passport_attaches`, `joiningdate`, `department`, `designation`, `school_shift`, `end_probation`, `contract_type`, `contract_length`, `end_contract`, `service_years`, `hrcomment`, `sponsorship_status`, `fas_sponsor`, `fas_spo_date`, `tkt_allowance_dur`, `relevant_degree`, `degree_details`, `degree_attaches`, `degree_attest_status`, `other_qualifications`, `disclaimer_ltr_moe`, `disclaimer_ltr_moe_atch`, `declaration_ltr_moe`, `declaration_ltr_moe_atch`, `moe_approval_status`, `police_clearance_issuance`, `police_clearance_atch`, `noc`, `noc_atch`, `experience_letter`, `experience_letter_atch`, `is_conformed`, `status`, `updated_by`, `created_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 3, '1', '82', '', 'Mehrin', 'MH', 'Female', '1997-10-14', 26, 'hr.hrms@gmail.com', 213, 'Married', '974', '30182459', '974', '50271012', '297297297', '2024-03-06', NULL, 'N8240940', '2029-03-22', NULL, '2020-02-05', 2, 22, 1, '2020-08-05', 2, '5', '2026-02-17', '3', NULL, 3, NULL, NULL, NULL, 5, 'Diploma in Human Resource Management- Level 4', NULL, 1, NULL, 'NA', NULL, 'NA', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, NULL, NULL, '2023-08-16 07:48:26', '2023-09-10 17:32:58', NULL),
(2, 4, '2', '3', '', 'Nadima', 'I', 'Female', '1987-11-01', 36, 'aaa@insasoft.com', 170, 'Married', '974', '66728838', '974', NULL, '297297298', '2026-02-27', NULL, 'BP6901603', '2026-09-14', NULL, '2023-01-01', 1, 1, 1, '2019-07-01', 2, '0', '2026-08-17', '1.8', NULL, 5, NULL, NULL, NULL, 2, 'Bachelor of Science', NULL, 1, 'a:1:{i:0;s:10:\"Bsc. Maths\";}', 'NA', NULL, 'NA', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, NULL, NULL, '2023-08-27 15:22:12', '2024-09-09 15:35:27', NULL),
(4, 6, '4', '0128', '', 'Rima', 'Y', 'Female', '1987-04-20', 36, 'rima@insasoft.com', 170, 'Married', '974', '33996007', '974', '0', '297297299', '2025-03-20', NULL, 'R436653', '2029-03-19', NULL, '2022-04-28', 1, 4, 1, '2020-02-23', 2, '5 years', '2026-08-17', '1.3', NULL, 5, NULL, NULL, NULL, 2, 'Bachelor of Arts', NULL, 1, NULL, 'NA', NULL, 'NA', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, NULL, NULL, '2023-09-10 17:31:07', '2023-11-22 15:31:04', NULL),
(5, 7, '5', '125', '', 'Lames', 'H', 'Female', '1988-01-25', 35, 'lames@insasoft.com', 170, 'Married', '974', '55116626', '974', '0', '297297300', '2024-11-29', NULL, 'AY1718772', '2026-03-28', NULL, '2022-08-21', 1, 7, 1, '2020-03-08', 2, '5 years', '2026-08-17', '1.4', NULL, 5, NULL, NULL, NULL, 2, 'Bachelor of Arts', NULL, 1, NULL, 'NA', NULL, 'NA', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, NULL, NULL, '2023-09-10 17:31:07', '2023-12-01 19:31:37', NULL),
(6, 8, '6', '27', NULL, 'Asma ', ' Irfan', 'Female', '1981-10-11', 42, 'ddd@insasoft.com', 170, 'Married', '974', '50583016', '0', '0', '297297301', '2024-04-05', NULL, 'MZ3094742', '2031-02-09', NULL, '2019-03-20', 1, 1, 1, '2020-03-25', 2, '5 years', '2026-08-17', '4.4', NULL, 5, NULL, NULL, NULL, 2, 'Bachelor of Education in English & Mathematics ', NULL, 1, NULL, 'N/A', NULL, 'N/A', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, NULL, NULL, '2023-09-10 17:31:07', '2023-09-10 17:31:07', NULL),
(7, 9, '7', '91', '', 'Cilma', 'M', 'Male', '1965-06-10', 58, 'clima@insasoft.com', 170, 'Married', '974', '55913119', '974', '0', '297297302', '2024-08-11', NULL, 'CB6858183', '2029-11-11', NULL, '2021-01-03', 2, 1, 2, '2020-04-06', 2, '5 years', '2025-06-17', '2.11', 'secondment renewal on 19 Nov 2023', 6, NULL, NULL, NULL, 5, 'Junior Diploma in Physical Education', NULL, 1, NULL, 'NA', NULL, 'NA', NULL, 5, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, NULL, NULL, '2023-09-10 17:31:07', '2023-12-01 19:41:41', NULL),
(8, 10, '8', '38', '', 'Sagun', 'B', 'Female', '1990-11-26', 34, 'prints@insasoft.com', 157, 'Seperated/Divorced', '974', '55321042', '974', '0', '297297303', '2023-09-18', NULL, 'PA1678953', '2033-05-09', NULL, '2019-04-22', 2, 28, 1, '2020-04-27', 2, '5 years', '2025-06-04', '4.4', 'secondment renewed until 27 sept 2022', 6, NULL, NULL, NULL, 2, '3 certificate', NULL, 1, NULL, 'N/A', NULL, 'N/A', NULL, 5, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, NULL, NULL, '2023-09-10 17:31:07', '2025-02-24 11:03:20', NULL),
(17, 19, '17', '63', NULL, 'CEO', 'Ac', 'Male', '1967-06-19', 56, 'ceo@insasoft.com', 238, 'Married', '44', '55207909', '44', '0', '297297304', '2024-10-16', NULL, '553885211', '2028-09-18', NULL, '2019-10-17', 2, 16, 1, '2020-10-22', 2, '5 years', '2025-12-12', '3.9', NULL, 2, NULL, NULL, NULL, 2, 'Bachelor of Arts in Law with Chemistry', NULL, 1, NULL, 'NA', NULL, 'NA', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, NULL, NULL, '2023-09-10 17:31:08', '2023-09-26 05:19:05', NULL),
(18, 20, '18', '64', NULL, 'Executive', 'CEO', 'Female', '1980-08-02', 43, 'execeo@insasoft.com', 170, 'Married', '974', '55987110', '0', '0', '297297305', '2024-02-27', NULL, 'UJ4120372', '2029-02-12', NULL, '2019-11-24', 2, 17, 1, '2020-11-29', 2, '5 years', '2026-08-08', '3.8', NULL, 5, NULL, NULL, NULL, 2, 'Bachelor of Science', NULL, 1, NULL, 'N/A', NULL, 'N/A', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, NULL, NULL, '2023-09-10 17:31:08', '2023-09-10 17:31:08', NULL),
(28, 30, '28', '93', NULL, 'Muhammed ', 'K', 'Male', '1974-05-03', 49, 'accountant@insasoft.com', 103, 'Married', '974', '55385288', '0', '0', '297297306', '2024-01-22', NULL, 'K0286026', '2024-01-19', NULL, '2021-06-20', 2, 20, 1, '2022-06-26', 2, '5 years', '2027-03-03', '2.2', NULL, 2, NULL, NULL, NULL, 2, 'Bachelor of Commerce ', NULL, 1, NULL, 'N/A', NULL, 'Yes', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, NULL, NULL, '2023-09-10 17:31:09', '2023-09-10 17:31:09', NULL),
(62, 64, '62', '136', NULL, 'Executive', 'Admin', 'Female', '1990-09-06', 32, 'executiveadmin@insasoft.com', 170, 'Single', '92', '55298241', '92', '0', '297297307', '2024-03-21', NULL, 'FD5461082', '2033-02-11', NULL, '2023-04-19', 2, 26, 1, '2023-05-19', 2, '5 years', '2028-04-19', '0.4', NULL, 7, NULL, NULL, NULL, 2, 'Bachelors in International Business Management ', NULL, 1, NULL, 'Yes', NULL, 'Yes', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, NULL, NULL, '2023-09-10 17:31:11', '2023-09-18 07:01:34', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `employee_departments`
--

CREATE TABLE `employee_departments` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `department_id` int NOT NULL,
  `department_date_from` date NOT NULL,
  `department_date_to` date NOT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee_designations`
--

CREATE TABLE `employee_designations` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `designation_id` int NOT NULL,
  `deignation_date_from` date NOT NULL,
  `designation_date_to` date NOT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee_emergency_details`
--

CREATE TABLE `employee_emergency_details` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `emergency_primary_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `relationship_primary` smallint NOT NULL,
  `emergency_primary_contact` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `emergency_secondary_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `relationship_secondary` smallint DEFAULT NULL,
  `emergency_secondary_contact` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `comment` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employee_emergency_details`
--

INSERT INTO `employee_emergency_details` (`id`, `user_id`, `emergency_primary_name`, `relationship_primary`, `emergency_primary_contact`, `emergency_secondary_name`, `relationship_secondary`, `emergency_secondary_contact`, `comment`, `status`, `updated_by`, `created_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 3, 'Aishaw', 5, '96339', 'Hello ', 3, '8827', 'Hello World', 1, NULL, NULL, '2023-08-22 08:42:07', '2024-08-26 08:00:44', NULL),
(2, 4, 'MuhammadRe ', 1, '70640', 'Saran', 3, '5090', 'hey', 1, NULL, NULL, '2023-08-28 09:06:46', '2024-09-28 08:50:00', NULL),
(4, 6, 'Ali', 5, '50733', 'Ghaziyarr', 14, '6694', NULL, 1, NULL, NULL, '2023-09-10 17:31:07', '2023-09-10 17:31:07', NULL),
(5, 7, 'Muhammad ty', 5, '7780', 'Shahmeer ', 7, '77617', NULL, 1, NULL, NULL, '2023-09-10 17:31:07', '2023-09-10 17:31:07', NULL),
(6, 8, 'Arfanf', 5, '3348', '-', 7, '-', NULL, 1, NULL, NULL, '2023-09-10 17:31:07', '2023-09-10 17:31:07', NULL),
(7, 9, 'Asmaw', 3, '6665', 'Adulla', 16, '6665', NULL, 1, NULL, NULL, '2023-09-10 17:31:07', '2023-09-10 17:31:07', NULL),
(8, 10, 'Bishapp', 7, '3168', 'Hussai', 11, '7025', NULL, 1, NULL, NULL, '2023-09-10 17:31:07', '2023-09-10 17:31:07', NULL),
(17, 19, 'Dr. SaeedSWE ', 7, '11939', 'Jave', 7, '10827', NULL, 1, NULL, NULL, '2023-09-10 17:31:08', '2023-09-10 17:31:08', NULL),
(18, 20, 'HaseebAx', 4, '5542', 'Muhammad', 7, '33751', NULL, 1, NULL, NULL, '2023-09-10 17:31:08', '2023-09-17 07:07:20', NULL),
(28, 30, 'Shameer K ', 7, '553', '- ', 7, '-', NULL, 1, NULL, NULL, '2023-09-10 17:31:09', '2023-09-17 07:12:17', NULL),
(62, 64, 'Syed er', 7, '6686', 'Aasiaj', 8, '55942', NULL, 1, NULL, NULL, '2023-09-10 17:31:11', '2023-09-10 17:31:11', NULL),
(73, 83, 'Sau ', 1, '8723489', ' ', 2, NULL, NULL, 1, NULL, NULL, '2024-09-09 12:53:23', '2024-09-09 12:53:23', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `employee_files`
--

CREATE TABLE `employee_files` (
  `id` int NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `file_data` text NOT NULL,
  `file_type` varchar(100) NOT NULL,
  `file_path` varchar(150) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int NOT NULL,
  `updated_by` int NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `employee_health_informations`
--

CREATE TABLE `employee_health_informations` (
  `id` int NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `hmc_card_no` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hmc_card_atch` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `health_insurance_status` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `health_insurance_atch` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `health_insurance_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `blood_group` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `medical_ailment_physical` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `physical_details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `medical_ailment_mental` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mental_details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `medication_details` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employee_health_informations`
--

INSERT INTO `employee_health_informations` (`id`, `user_id`, `hmc_card_no`, `hmc_card_atch`, `health_insurance_status`, `health_insurance_atch`, `health_insurance_name`, `blood_group`, `medical_ailment_physical`, `physical_details`, `medical_ailment_mental`, `mental_details`, `medication_details`, `status`, `updated_by`, `created_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 3, 'HMC1', NULL, '1', NULL, 'KFC2', NULL, '1', NULL, '0', NULL, 'Paracetamol', 1, NULL, NULL, '2023-08-22 08:38:46', '2024-08-24 15:21:24', NULL),
(2, 4, 'HC007', NULL, '0', NULL, NULL, NULL, '1', NULL, '0', NULL, 'Thyroxine', 1, NULL, NULL, '2023-08-28 09:05:24', '2024-09-08 14:35:32', NULL),
(4, 6, 'HC05', NULL, NULL, NULL, '-', NULL, 'Allergies', NULL, NULL, NULL, 'Cabergoline, Glucophage', 1, NULL, NULL, '2023-09-10 17:31:07', '2023-09-10 17:31:07', NULL),
(5, 7, 'HC002', NULL, NULL, NULL, '-', NULL, 'Low Blood Pressure, Migraine', NULL, NULL, NULL, 'Diclofemac', 1, NULL, NULL, '2023-09-10 17:31:07', '2023-09-10 17:31:07', NULL),
(6, 8, 'HC048', NULL, NULL, NULL, '-', NULL, '-', NULL, NULL, NULL, '-', 1, NULL, NULL, '2023-09-10 17:31:07', '2023-09-10 17:31:07', NULL),
(7, 9, 'HC004', NULL, NULL, NULL, '-', NULL, '-', NULL, NULL, NULL, '-', 1, NULL, NULL, '2023-09-10 17:31:07', '2023-09-10 17:31:07', NULL),
(8, 10, 'HC062', NULL, NULL, NULL, '-', NULL, 'Allergies', NULL, NULL, NULL, '-', 1, NULL, NULL, '2023-09-10 17:31:07', '2023-09-10 17:31:07', NULL),
(17, 19, 'HC015', NULL, NULL, NULL, 'General Takaful', NULL, '-', NULL, NULL, NULL, '-', 1, NULL, NULL, '2023-09-10 17:31:08', '2023-09-10 17:31:08', NULL),
(18, 20, 'HC0054', NULL, NULL, NULL, '-', NULL, '-', NULL, NULL, NULL, '-', 1, NULL, NULL, '2023-09-10 17:31:08', '2023-09-10 17:31:08', NULL),
(28, 30, 'HC0320', NULL, NULL, NULL, '-', NULL, '-', NULL, NULL, NULL, '-', 1, NULL, NULL, '2023-09-10 17:31:09', '2023-09-10 17:31:09', NULL),
(62, 64, 'HC0021', NULL, NULL, NULL, '-', NULL, '-', NULL, NULL, NULL, '-', 1, NULL, NULL, '2023-09-10 17:31:11', '2023-09-10 17:31:11', NULL),
(72, 83, 'HC0046', NULL, '1', NULL, '-', NULL, '1', NULL, '1', NULL, '-', 1, NULL, NULL, '2023-09-10 17:31:11', '2024-09-09 12:52:13', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `employee_payroll_informations`
--

CREATE TABLE `employee_payroll_informations` (
  `id` int NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `basic_salary` decimal(20,2) NOT NULL,
  `accomodation_allowance` decimal(20,2) NOT NULL,
  `transport_allowance` decimal(20,2) NOT NULL,
  `continuous_allowance` decimal(20,2) NOT NULL,
  `temp_allowance` decimal(20,2) NOT NULL,
  `other_allowance` decimal(20,2) DEFAULT NULL,
  `gross_total` decimal(20,2) DEFAULT NULL,
  `bank_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_no` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `iban_no` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `salary_effective_from` date DEFAULT NULL,
  `bank_docs` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employee_payroll_informations`
--

INSERT INTO `employee_payroll_informations` (`id`, `user_id`, `basic_salary`, `accomodation_allowance`, `transport_allowance`, `continuous_allowance`, `temp_allowance`, `other_allowance`, `gross_total`, `bank_name`, `account_no`, `iban_no`, `salary_effective_from`, `bank_docs`, `status`, `updated_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 3, 5250.00, 1050.00, 700.00, 0.00, 0.00, 0.00, 7000.00, 'Doha Bank', '28746285281', 'QA788327582584', '2023-05-03', NULL, 1, NULL, '2023-08-17 06:12:32', '2024-08-24 11:28:49', NULL),
(3, 4, 4875.00, 1005.00, 670.00, 0.00, 0.00, 0.00, 6500.00, 'Emartes Bank IND', '4700172932021', 'QA16CBQA0000000047001729321', '2019-01-01', NULL, 1, NULL, '2023-08-27 15:27:42', '2024-09-18 16:47:13', NULL),
(5, 6, 5250.00, 700.00, 1050.00, 0.00, 0.00, 0.00, 7000.00, 'Commercial Bank', '1489570177', 'QA55CBQA000000004700183792001', '2022-08-24', NULL, 1, NULL, '2023-09-10 17:31:07', '2023-11-22 15:36:26', NULL),
(6, 7, 3000.00, 700.00, 300.00, 0.00, 0.00, 0.00, 4000.00, 'Commercial Bank', '1480691177', 'QA77CBQA000000004700174913001', '2022-08-21', NULL, 1, NULL, '2023-09-10 17:31:07', '2023-12-01 19:32:10', NULL),
(7, 8, 5025.00, 1005.00, 670.00, 0.00, 0.00, 0.00, 6700.00, 'Commercial Bank', '1484917177', 'QA50CBQA000000004700179139001', '2019-03-20', NULL, 1, NULL, '2023-09-10 17:31:07', '2023-10-16 08:22:39', NULL),
(8, 9, 5250.00, 900.00, 850.00, 0.00, 0.00, 0.00, 7000.00, 'Commercial Bank', '2028313177', 'QA79CBQA000000004700722535001', '2021-01-03', NULL, 1, NULL, '2023-09-10 17:31:07', '2023-12-01 19:42:18', NULL),
(9, 10, 2250.00, 450.00, 300.00, 0.00, 0.00, 0.00, 3000.00, 'Commercial Bank', '1491809277', 'QA90CBQA000000004700186031101', '2019-04-22', NULL, 1, NULL, '2023-09-10 17:31:07', '2023-10-16 08:24:09', NULL),
(18, 19, 5000.00, 1000.00, 1000.00, 0.00, 0.00, 0.00, 700000.00, 'Commercial Bank', '1550015177', 'QA64CBQA000000004700244237001', '2019-10-17', NULL, 1, NULL, '2023-09-10 17:31:08', '2023-10-16 08:37:15', NULL),
(19, 20, 9000.00, 1800.00, 1200.00, 0.00, 0.00, 0.00, 12000.00, 'Commercial Bank', '1735211393', 'QA06CBQA000000004610235120001', '2019-11-24', NULL, 1, NULL, '2023-09-10 17:31:08', '2023-10-16 08:38:17', NULL),
(29, 30, 6000.00, 1200.00, 800.00, 0.00, 0.00, 0.00, 8000.00, 'Commercial Bank', '1982139177', 'QA50CBQA000000004700676361001', '2021-06-20', NULL, 1, NULL, '2023-09-10 17:31:09', '2023-10-16 08:45:36', NULL),
(81, 64, 6000.00, 1200.00, 800.00, 0.00, 0.00, 0.00, 8000.00, 'Commercial Bank', '1982139177', 'QA50CBQA000000004700676361001', '2021-06-20', NULL, 1, NULL, '2023-09-10 17:31:09', '2023-10-16 08:45:36', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `employee_status`
--

CREATE TABLE `employee_status` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `employee_id` int NOT NULL,
  `current_status` smallint NOT NULL,
  `inactive_status` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `inactive_date` date DEFAULT NULL,
  `created_by` int NOT NULL,
  `inactive_reason` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `inactive_attachment` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employee_status`
--

INSERT INTO `employee_status` (`id`, `user_id`, `employee_id`, `current_status`, `inactive_status`, `inactive_date`, `created_by`, `inactive_reason`, `inactive_attachment`, `updated_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 86, 86, 0, '1', '2024-10-09', 3, 'find other job', NULL, NULL, '2024-10-10 11:16:28', '2024-10-10 11:16:28', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(75) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gratuity`
--

CREATE TABLE `gratuity` (
  `id` bigint UNSIGNED NOT NULL,
  `employee_id` int NOT NULL,
  `joining_date` date NOT NULL,
  `last_working_day` date NOT NULL,
  `notice_pay` decimal(8,2) NOT NULL,
  `total_days_employment` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `notice_period` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `notice_period_remarks` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `net_days_worked` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_days_last_month` int NOT NULL DEFAULT '0',
  `current_month_salary` decimal(8,2) NOT NULL,
  `eligible_days` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `gratuity_add` decimal(8,2) NOT NULL DEFAULT '0.00',
  `gratuity_ded` decimal(8,2) NOT NULL DEFAULT '0.00',
  `gratuity_total` decimal(8,2) NOT NULL DEFAULT '0.00',
  `annual_leave_entitled` float NOT NULL DEFAULT '0',
  `accrued_annual_leave` float NOT NULL DEFAULT '0',
  `annual_leave_availed` float NOT NULL DEFAULT '0',
  `annual_leave_balance` float NOT NULL DEFAULT '0',
  `leave_accrual_amount` decimal(8,2) NOT NULL DEFAULT '0.00',
  `ticket_accrual_amount` decimal(8,2) NOT NULL DEFAULT '0.00',
  `return_ticket_amount` decimal(8,2) NOT NULL DEFAULT '0.00',
  `last_payroll_chk` tinyint(1) NOT NULL DEFAULT '0',
  `last_payroll` int NOT NULL DEFAULT '0',
  `net_pay` decimal(8,2) NOT NULL DEFAULT '0.00',
  `net_pay_round_off` decimal(8,2) NOT NULL DEFAULT '0.00',
  `active_decider` int NOT NULL DEFAULT '0',
  `remarks` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `academic_year` smallint NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` enum('Initiated','Assigned To Review','Reviewed & Send To Approve','Approved') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Initiated'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gratuity`
--

INSERT INTO `gratuity` (`id`, `employee_id`, `joining_date`, `last_working_day`, `notice_pay`, `total_days_employment`, `notice_period`, `notice_period_remarks`, `net_days_worked`, `total_days_last_month`, `current_month_salary`, `eligible_days`, `gratuity_add`, `gratuity_ded`, `gratuity_total`, `annual_leave_entitled`, `accrued_annual_leave`, `annual_leave_availed`, `annual_leave_balance`, `leave_accrual_amount`, `ticket_accrual_amount`, `return_ticket_amount`, `last_payroll_chk`, `last_payroll`, `net_pay`, `net_pay_round_off`, `active_decider`, `remarks`, `academic_year`, `created_at`, `updated_at`, `status`) VALUES
(1, 2, '2019-01-01', '2024-02-27', 0.00, '1884', '30', 'Nil', '1884', 2, 433.33, '154.85', 25241.00, 0.00, 25241.00, 30, 30, 29, 1, 163.00, 0.00, 0.00, 0, 0, 25837.00, 25836.38, 30, 'Last payroll not included', 1, '2024-02-27 09:46:23', '2024-04-29 20:34:51', 'Assigned To Review');

-- --------------------------------------------------------

--
-- Table structure for table `gratuity_status`
--

CREATE TABLE `gratuity_status` (
  `id` bigint UNSIGNED NOT NULL,
  `gratuity_id` bigint UNSIGNED NOT NULL,
  `source_id` int NOT NULL DEFAULT '0',
  `dest_id` int NOT NULL DEFAULT '0',
  `comment` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `timing` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `gratuity_status` enum('Initiated','Assigned To Review','Reviewed & Send To Approve','Approved') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Initiated'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gratuity_status`
--

INSERT INTO `gratuity_status` (`id`, `gratuity_id`, `source_id`, `dest_id`, `comment`, `timing`, `created_at`, `updated_at`, `gratuity_status`) VALUES
(1, 1, 3, 3, 'Nil', '2024-02-27 08:46:23', '2024-02-27 09:46:23', '2024-02-27 09:46:23', 'Initiated'),
(2, 1, 3, 30, NULL, '2024-04-29 21:34:51', '2024-04-29 20:34:51', '2024-04-29 20:34:51', 'Assigned To Review');

-- --------------------------------------------------------

--
-- Table structure for table `inactive_reason`
--

CREATE TABLE `inactive_reason` (
  `id` int NOT NULL,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inactive_status`
--

CREATE TABLE `inactive_status` (
  `id` int NOT NULL,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inactive_status`
--

INSERT INTO `inactive_status` (`id`, `name`, `active`, `updated_by`, `created_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Resigned', 1, NULL, NULL, NULL, NULL, NULL),
(2, 'Terminated', 1, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `insahrco_insasoft-hrm`
--

CREATE TABLE `insahrco_insasoft-hrm` (
  `id` int NOT NULL,
  `title` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_from` date NOT NULL,
  `start_to` date NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `insahrco_insasoft-hrm`
--

INSERT INTO `insahrco_insasoft-hrm` (`id`, `title`, `start_from`, `start_to`, `active`, `updated_by`, `created_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'AY-2023/2024', '2023-08-15', '2024-06-15', 1, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `leave_applications`
--

CREATE TABLE `leave_applications` (
  `id` int NOT NULL,
  `leave_type` int NOT NULL,
  `employee_id` int NOT NULL,
  `date_from` date NOT NULL,
  `date_to` date NOT NULL,
  `time_from` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `time_end` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_days` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `reason` varchar(1500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attachment` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `forward_from` int NOT NULL,
  `forward_to` int NOT NULL,
  `paid_status` tinyint NOT NULL DEFAULT '0',
  `academic_year` smallint NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int NOT NULL,
  `updated_by` int NOT NULL,
  `finalised` tinyint(1) NOT NULL DEFAULT '0',
  `amendment` tinyint NOT NULL DEFAULT '0',
  `status` tinyint NOT NULL DEFAULT '1',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `leave_applications`
--

INSERT INTO `leave_applications` (`id`, `leave_type`, `employee_id`, `date_from`, `date_to`, `time_from`, `time_end`, `no_days`, `reason`, `attachment`, `forward_from`, `forward_to`, `paid_status`, `academic_year`, `created_at`, `updated_at`, `created_by`, `updated_by`, `finalised`, `amendment`, `status`, `deleted_at`) VALUES
(111, 8, 2, '2025-01-14', '2025-01-16', 'null', 'null', '3', 'Test Case', NULL, 3, 19, 0, 2, '2024-09-17 20:01:41', '2025-12-22 12:30:58', 4, 4, 0, 0, 3, NULL),
(112, 3, 2, '2024-09-21', '2024-09-21', NULL, NULL, '1', 'Test', '1726906379_rw8DhacBab.pdf', 2, 3, 0, 2, '2024-09-21 11:12:59', '2025-04-22 17:00:51', 4, 4, 0, 0, 1, NULL),
(113, 1, 1, '2025-12-19', '2025-12-19', 'null', 'null', '1', 'ursursu5wu4s74', NULL, 19, 3, 0, 3, '2025-12-18 15:30:48', '2025-12-18 15:33:01', 3, 3, 0, 0, 6, NULL),
(114, 1, 7, '2025-12-21', '2025-12-21', NULL, NULL, '1', 'Nil', NULL, 64, 3, 0, 3, '2025-12-19 12:25:29', '2025-12-19 12:26:13', 3, 3, 0, 0, 3, NULL),
(115, 1, 7, '2025-12-25', '2025-12-25', 'null', 'null', '1', 'casual', NULL, 3, 19, 0, 3, '2025-12-22 11:07:18', '2025-12-22 12:03:47', 9, 9, 0, 0, 3, NULL),
(116, 1, 1, '2025-12-23', '2025-12-24', 'null', 'null', '2', 'due to some personal emergency', NULL, 19, 3, 0, 3, '2025-12-22 11:34:19', '2025-12-22 11:37:55', 3, 3, 0, 0, 6, NULL),
(117, 3, 8, '2025-12-23', '2025-12-23', NULL, NULL, '1', 'Sick', NULL, 8, 3, 0, 3, '2025-12-22 12:30:26', '2025-12-22 12:30:26', 3, 3, 0, 0, 1, NULL),
(118, 3, 5, '2025-12-22', '2025-12-22', 'null', 'null', '1', 'sick leave', NULL, 19, 3, 0, 3, '2025-12-22 18:31:11', '2025-12-22 18:39:49', 7, 7, 0, 0, 6, NULL),
(119, 4, 5, '2025-12-24', '2025-12-24', 'null', 'null', '1', 'emergency..', NULL, 19, 3, 0, 3, '2025-12-22 19:20:07', '2025-12-23 09:47:42', 7, 7, 0, 0, 6, NULL),
(120, 6, 4, '2025-12-24', '2025-12-24', '01:30 PM', '05:30 PM', '1', 'short leave', NULL, 19, 3, 0, 3, '2025-12-23 09:59:27', '2025-12-23 10:21:36', 6, 6, 0, 0, 6, NULL),
(121, 1, 4, '2025-12-24', '2025-12-24', 'null', 'null', '1', 'due to some personal emergency', NULL, 4, 3, 0, 3, '2025-12-23 13:40:50', '2025-12-23 13:40:50', 6, 6, 0, 0, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `leave_application_amendments`
--

CREATE TABLE `leave_application_amendments` (
  `id` int NOT NULL,
  `leave_id` int NOT NULL,
  `employee_id` int NOT NULL,
  `reason` varchar(1500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `leave_date_from` date DEFAULT NULL,
  `leave_date_to` date DEFAULT NULL,
  `request_status` tinyint NOT NULL COMMENT '7:cancelled, 8:partially cancelled',
  `request_from` enum('E','H') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'E' COMMENT 'E: From employee, H: By HR',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` int NOT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '0' COMMENT '0:requested, 1:approved, 2:rejected'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `leave_application_changes`
--

CREATE TABLE `leave_application_changes` (
  `id` bigint UNSIGNED NOT NULL,
  `leave_type` int NOT NULL,
  `employee_id` int NOT NULL,
  `date_from` date NOT NULL,
  `date_to` date NOT NULL,
  `no_days` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `reason` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `changed_by` int NOT NULL,
  `leave_application_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `leave_application_status`
--

CREATE TABLE `leave_application_status` (
  `id` int NOT NULL,
  `leave_id` int NOT NULL,
  `applier_id` int NOT NULL,
  `approver_id` varchar(280) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `action_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `leave_status` int NOT NULL,
  `comment` varchar(1500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `assigned_to_role` int NOT NULL DEFAULT '0',
  `assigned_to_id` int NOT NULL DEFAULT '0',
  `status` tinyint NOT NULL DEFAULT '1',
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `leave_application_status`
--

INSERT INTO `leave_application_status` (`id`, `leave_id`, `applier_id`, `approver_id`, `action_time`, `leave_status`, `comment`, `assigned_to_role`, `assigned_to_id`, `status`, `updated_by`, `created_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(115, 111, 2, '20', '2024-09-17 19:01:41', 1, 'Test Case', 1, 1, 1, NULL, NULL, '2024-09-17 18:01:41', '2024-09-17 18:01:41', NULL),
(116, 112, 2, '20', '2024-09-21 10:12:59', 1, 'Test', 1, 1, 1, NULL, NULL, '2024-09-21 09:12:59', '2024-09-21 09:12:59', NULL),
(117, 113, 1, '64', '2025-12-18 13:30:48', 1, 'ursursu5wu4s74', 1, 1, 1, NULL, NULL, '2025-12-18 14:30:48', '2025-12-18 14:30:48', NULL),
(118, 113, 1, '64', '2025-12-18 13:31:33', 3, 'Vrified', 1, 1, 1, NULL, NULL, '2025-12-18 14:31:33', '2025-12-18 14:31:33', NULL),
(119, 113, 1, '3', '2025-12-18 13:32:16', 3, 'Verified', 1, 1, 1, NULL, NULL, '2025-12-18 14:32:16', '2025-12-18 14:32:16', NULL),
(120, 113, 1, '19', '2025-12-18 13:33:01', 6, 'Approved', 1, 1, 1, NULL, NULL, '2025-12-18 14:33:01', '2025-12-18 14:33:01', NULL),
(121, 114, 7, '64', '2025-12-19 10:25:29', 1, 'Nil', 1, 1, 1, NULL, NULL, '2025-12-19 11:25:29', '2025-12-19 11:25:29', NULL),
(122, 114, 7, '64', '2025-12-19 10:26:13', 3, 'Verified', 1, 1, 1, NULL, NULL, '2025-12-19 11:26:13', '2025-12-19 11:26:13', NULL),
(123, 115, 7, '3', '2025-12-22 09:07:18', 1, 'casual', 1, 1, 1, NULL, NULL, '2025-12-22 10:07:18', '2025-12-22 10:07:18', NULL),
(124, 116, 1, '64', '2025-12-22 09:34:19', 1, 'due to some personal emergency', 1, 1, 1, NULL, NULL, '2025-12-22 10:34:19', '2025-12-22 10:34:19', NULL),
(125, 116, 1, '64', '2025-12-22 09:36:41', 3, 'Verified', 1, 1, 1, NULL, NULL, '2025-12-22 10:36:41', '2025-12-22 10:36:41', NULL),
(126, 116, 1, '3', '2025-12-22 09:37:15', 3, 'Verified', 1, 1, 1, NULL, NULL, '2025-12-22 10:37:15', '2025-12-22 10:37:15', NULL),
(127, 116, 1, '19', '2025-12-22 09:37:55', 6, 'Approved', 1, 1, 1, NULL, NULL, '2025-12-22 10:37:55', '2025-12-22 10:37:55', NULL),
(128, 115, 7, '3', '2025-12-22 10:03:47', 3, 'Verified', 1, 1, 1, NULL, NULL, '2025-12-22 11:03:47', '2025-12-22 11:03:47', NULL),
(129, 117, 8, '3', '2025-12-22 10:30:26', 1, 'Sick', 1, 1, 1, NULL, NULL, '2025-12-22 11:30:26', '2025-12-22 11:30:26', NULL),
(130, 111, 2, '3', '2025-12-22 10:30:58', 3, 'Verified', 1, 1, 1, NULL, NULL, '2025-12-22 11:30:58', '2025-12-22 11:30:58', NULL),
(131, 118, 5, '3', '2025-12-22 16:31:12', 1, 'sick leave', 1, 1, 1, NULL, NULL, '2025-12-22 17:31:12', '2025-12-22 17:31:12', NULL),
(132, 118, 5, '3', '2025-12-22 16:38:47', 3, 'Verified', 1, 1, 1, NULL, NULL, '2025-12-22 17:38:47', '2025-12-22 17:38:47', NULL),
(133, 118, 5, '19', '2025-12-22 16:39:49', 6, 'Approved', 1, 1, 1, NULL, NULL, '2025-12-22 17:39:49', '2025-12-22 17:39:49', NULL),
(134, 119, 5, '3', '2025-12-22 17:20:07', 1, 'emergency..', 1, 1, 1, NULL, NULL, '2025-12-22 18:20:07', '2025-12-22 18:20:07', NULL),
(135, 119, 5, '3', '2025-12-23 07:46:36', 3, 'Verified', 1, 1, 1, NULL, NULL, '2025-12-23 08:46:36', '2025-12-23 08:46:36', NULL),
(136, 119, 5, '19', '2025-12-23 07:47:42', 6, 'Approved', 1, 1, 1, NULL, NULL, '2025-12-23 08:47:42', '2025-12-23 08:47:42', NULL),
(137, 120, 4, '3', '2025-12-23 07:59:27', 1, 'short leave', 1, 1, 1, NULL, NULL, '2025-12-23 08:59:27', '2025-12-23 08:59:27', NULL),
(138, 120, 4, '3', '2025-12-23 08:20:25', 3, 'Verified', 1, 1, 1, NULL, NULL, '2025-12-23 09:20:25', '2025-12-23 09:20:25', NULL),
(139, 120, 4, '19', '2025-12-23 08:21:36', 6, 'Approved', 1, 1, 1, NULL, NULL, '2025-12-23 09:21:36', '2025-12-23 09:21:36', NULL),
(140, 121, 4, '3', '2025-12-23 11:40:50', 1, 'due to some personal emergency', 1, 1, 1, NULL, NULL, '2025-12-23 12:40:50', '2025-12-23 12:40:50', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `leave_approval_flows`
--

CREATE TABLE `leave_approval_flows` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `department_id` int NOT NULL DEFAULT '0',
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `leave_approval_flows`
--

INSERT INTO `leave_approval_flows` (`id`, `name`, `department_id`, `description`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Staff Flow', 1, 'Flow for general staffs', 1, NULL, '2025-12-24 08:17:36'),
(3, 'Administration Flow', 2, 'Flow for Administration staffs', 1, '2025-12-24 08:15:37', '2025-12-24 08:15:37'),
(4, 'Common Flow', 0, 'Basic Flow for all employees', 1, '2025-12-24 08:17:46', '2025-12-24 08:17:46');

-- --------------------------------------------------------

--
-- Table structure for table `leave_approval_flow_steps`
--

CREATE TABLE `leave_approval_flow_steps` (
  `id` bigint UNSIGNED NOT NULL,
  `leave_approval_flow_id` bigint UNSIGNED NOT NULL,
  `role` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `step_order` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `leave_approval_flow_steps`
--

INSERT INTO `leave_approval_flow_steps` (`id`, `leave_approval_flow_id`, `role`, `step_order`, `created_at`, `updated_at`) VALUES
(3, 3, 'Executive-Admin', 1, '2025-12-24 08:15:37', '2025-12-24 08:15:37'),
(4, 3, 'Hr', 2, '2025-12-24 08:15:37', '2025-12-24 08:15:37'),
(5, 3, 'Principal', 3, '2025-12-24 08:15:37', '2025-12-24 08:15:37'),
(9, 1, 'Vp', 1, '2025-12-24 08:17:36', '2025-12-24 08:17:36'),
(10, 1, 'Hr', 2, '2025-12-24 08:17:36', '2025-12-24 08:17:36'),
(11, 1, 'Principal', 3, '2025-12-24 08:17:36', '2025-12-24 08:17:36'),
(12, 4, 'Hr', 1, '2025-12-24 08:17:46', '2025-12-24 08:17:46'),
(13, 4, 'Principal', 2, '2025-12-24 08:17:46', '2025-12-24 08:17:46');

-- --------------------------------------------------------

--
-- Table structure for table `leave_types`
--

CREATE TABLE `leave_types` (
  `id` int NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'L',
  `applicable_to` tinyint NOT NULL DEFAULT '0' COMMENT '0: Others, 1: Academic, 2: Admin',
  `leave_days` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `academic_year` int NOT NULL DEFAULT '0',
  `description` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `bg_color` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `leave_types`
--

INSERT INTO `leave_types` (`id`, `name`, `code`, `applicable_to`, `leave_days`, `academic_year`, `description`, `bg_color`, `created_by`, `created_at`, `active`, `updated_by`, `updated_at`, `deleted_at`) VALUES
(1, 'Casual Leave', 'CL', 1, '3', 1, 'Casual Leave', '#b4b2b2', 1, '2023-03-16 00:23:23', 1, NULL, '2023-03-25 01:37:30', NULL),
(2, 'Annual Leave', 'AL', 1, '30', 1, 'Annual  Leave', '#cfe2ff', 1, '2023-03-16 00:48:14', 1, NULL, '2023-03-25 01:37:30', NULL),
(3, 'Sick Leave', 'SL', 0, '14', 1, 'Sick Leave', '#f8d7da', 1, '2023-05-07 17:08:09', 1, NULL, '2023-05-07 17:08:09', NULL),
(4, 'Emergency leave', 'EL', 0, '4', 1, 'Emergency leave', '#d1e7dd', 1, '2023-05-07 17:08:45', 1, NULL, '2023-05-07 17:08:45', NULL),
(5, 'Maternity Leave', 'ML', 0, '50', 1, 'Maternity Leave', '#cff4fc', 1, '2023-05-07 17:10:00', 1, NULL, '2023-05-07 17:10:00', NULL),
(6, 'Short Leave', 'SL', 0, '6', 1, 'Short Leave', '#e2e3e5', 1, '2023-05-07 17:11:28', 1, NULL, '2023-05-07 17:11:28', NULL),
(7, 'Hajj Leave', 'HL', 0, '10', 1, 'Hajj Leave', '#0dcaf0', 1, '2023-05-07 17:11:59', 1, NULL, '2023-05-07 17:11:59', NULL),
(8, 'Bereavement/Compassionate Leave', 'CO', 0, '7', 1, 'Bereavement/Compassionate Leave', '#fff3cd', 1, '2023-05-07 17:12:28', 1, NULL, '2023-05-07 17:12:28', NULL),
(9, 'Employment Accident Leave', 'EAL', 0, '5', 1, 'Employment Accident Leave', '#f5c2c7', 1, '2023-05-07 17:15:06', 1, NULL, '2023-05-07 17:15:06', NULL),
(10, 'Instructed Leave', 'IL', 0, '3', 1, 'Instructed Leave', '#f7d1af', 1, '2023-05-07 17:15:36', 1, NULL, '2023-05-07 17:15:36', NULL),
(11, 'Leave without Pay', 'LWP', 0, '30', 1, 'Leave without Pay', '#f56371', 1, '2023-05-07 17:16:22', 1, NULL, '2023-05-07 17:16:22', NULL),
(12, 'Half-Sick', 'HSL', 0, '14', 1, 'Half-Sick Leave', '#b4b2b2', 1, '2023-05-15 09:38:50', 1, NULL, '2023-05-15 09:38:50', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `medical_ailment`
--

CREATE TABLE `medical_ailment` (
  `id` int NOT NULL,
  `type` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `menu_links`
--

CREATE TABLE `menu_links` (
  `id` int NOT NULL,
  `position` tinyint NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `path` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `parentid` int NOT NULL DEFAULT '0',
  `menutype` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'SB',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menu_links`
--

INSERT INTO `menu_links` (`id`, `position`, `name`, `path`, `parentid`, `menutype`, `status`, `updated_by`, `created_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'Dashboard', 'dashboard', 0, 'SB', 1, NULL, NULL, NULL, NULL, NULL),
(2, 2, 'Employees', '#', 0, 'SB', 1, NULL, NULL, NULL, NULL, NULL),
(3, 4, 'Leaves', '#', 0, 'SB', 1, NULL, NULL, NULL, NULL, NULL),
(4, 7, 'Leave Retraction', 'leaveretract', 3, 'SB', 1, NULL, NULL, NULL, NULL, NULL),
(5, 6, 'Leave Approval', 'leaveapproval', 3, 'SB', 1, NULL, NULL, NULL, NULL, NULL),
(6, 17, 'Masters', '#', 0, 'SB', 1, NULL, NULL, NULL, NULL, NULL),
(7, 18, 'Academic Year', 'academicyear', 6, 'SB', 0, NULL, NULL, NULL, NULL, NULL),
(8, 19, 'Departments', 'departments', 6, 'SB', 1, NULL, NULL, NULL, NULL, NULL),
(9, 20, 'Designations', 'designations', 6, 'SB', 1, NULL, NULL, NULL, NULL, NULL),
(10, 21, 'Leave Types', 'leavetypes', 6, 'SB', 1, NULL, NULL, NULL, NULL, NULL),
(11, 21, 'Approval Status', 'approvalstatus', 6, 'SB', 0, NULL, NULL, NULL, NULL, NULL),
(12, 23, 'Paid Status', 'paidstatus', 6, 'SB', 0, NULL, NULL, NULL, NULL, NULL),
(13, 24, 'Payment Deduction Type', 'paydeductiontype', 6, 'SB', 0, NULL, NULL, NULL, NULL, NULL),
(14, 25, 'Shifts', 'schoolshift', 6, 'SB', 1, NULL, NULL, NULL, NULL, NULL),
(15, 26, 'Contract Type', 'contracttype', 6, 'SB', 0, NULL, NULL, NULL, NULL, NULL),
(16, 27, 'Sponsorship Status', 'sponsstatus', 6, 'SB', 0, NULL, NULL, NULL, NULL, NULL),
(17, 28, 'Relevant Degree', 'relevantdegree', 6, 'SB', 0, NULL, NULL, NULL, NULL, NULL),
(18, 29, 'MOE approval status', 'moeapprstatus', 6, 'SB', 0, NULL, NULL, NULL, NULL, NULL),
(19, 30, 'Medical Ailment', 'medicalailment', 6, 'SB', 0, NULL, NULL, NULL, NULL, NULL),
(20, 31, 'Appraisal Data', 'appraisaldata', 6, 'SB', 1, NULL, NULL, NULL, NULL, NULL),
(21, 32, 'Inactive Status', 'inactivestatus', 6, 'SB', 1, NULL, NULL, NULL, NULL, NULL),
(22, 33, 'Inactive Reason', 'inactivereason', 6, 'SB', 0, NULL, NULL, NULL, NULL, NULL),
(23, 34, 'Relationship', 'relationship', 6, 'SB', 0, NULL, NULL, NULL, NULL, NULL),
(24, 35, 'Budget Type', 'budgettype', 6, 'SB', 0, NULL, NULL, NULL, NULL, NULL),
(25, 7, 'Payroll', '#', 0, 'SB', 1, NULL, NULL, NULL, NULL, NULL),
(26, 8, 'Earnings', 'earnings', 25, 'SB', 1, NULL, NULL, NULL, NULL, NULL),
(27, 9, 'Deduction', 'deduction', 25, 'SB', 1, NULL, NULL, NULL, NULL, NULL),
(28, 10, 'Payroll List', 'payroll', 25, 'SB', 1, NULL, NULL, NULL, NULL, NULL),
(29, 13, 'Employee Gratuity', 'gratuity', 0, 'SB', 1, NULL, NULL, NULL, NULL, NULL),
(30, 3, 'Attendance Data', 'attendance', 0, 'SB', 1, NULL, NULL, NULL, NULL, NULL),
(31, 12, 'Appraisal', '', 0, 'SB', 1, NULL, NULL, NULL, NULL, NULL),
(32, 11, 'Calendar', 'calendar', 0, 'SB', 1, NULL, NULL, NULL, NULL, NULL),
(33, 36, 'Reports', '#', 0, 'SB', 1, NULL, NULL, NULL, NULL, NULL),
(34, 37, 'Employee Data', 'employee-report', 33, 'SB', 1, NULL, NULL, NULL, NULL, NULL),
(35, 38, 'Monthly Leave Data', 'monthly_leave_report', 33, 'SB', 1, NULL, NULL, NULL, NULL, NULL),
(36, 39, 'Employee Leave Sheet', 'employee_leave_sheet', 33, 'SB', 1, NULL, NULL, NULL, NULL, NULL),
(37, 40, 'Payroll Data', 'payroll-report', 33, 'SB', 1, NULL, NULL, NULL, NULL, NULL),
(38, 41, 'Time Sheet', 'timesheet-report', 33, 'SB', 1, NULL, NULL, NULL, NULL, NULL),
(39, 42, 'Active', 'employees', 2, 'SB', 1, NULL, NULL, NULL, NULL, NULL),
(40, 43, 'Inactive', 'inactive_employees', 2, 'SB', 1, NULL, NULL, NULL, NULL, NULL),
(41, 44, 'Settings', '#', 0, 'SB', 1, NULL, NULL, NULL, NULL, NULL),
(42, 45, 'Dashboard Cards', 'dashboard-settings', 41, 'SB', 1, NULL, NULL, NULL, NULL, NULL),
(43, 46, 'Role Access', 'role-access', 41, 'SB', 1, NULL, NULL, NULL, NULL, NULL),
(44, 31, 'Appraisal Type', 'appraisaltype', 6, 'SB', 1, NULL, NULL, NULL, NULL, NULL),
(45, 42, 'Attendance Report', 'attendance-report', 33, 'SB', 1, NULL, NULL, NULL, NULL, NULL),
(46, 43, 'Employee Presence', 'emp-presence-report', 33, 'SB', 1, NULL, NULL, NULL, NULL, NULL),
(47, 47, 'Shift Assign', 'shift-assign', 41, 'SB', 1, NULL, NULL, NULL, NULL, NULL),
(48, 48, 'Notice Period', 'noticeperiod', 6, 'SB', 1, NULL, NULL, NULL, NULL, NULL),
(49, 47, 'Shift Assigned', 'shift-assigned', 41, 'SB', 1, NULL, NULL, NULL, NULL, NULL),
(50, 13, 'Appraisal Report', 'appraisal', 31, 'SB', 1, NULL, NULL, NULL, NULL, NULL),
(51, 14, 'Probation Period Review', 'probation-period-review', 31, 'SB', 1, NULL, NULL, NULL, NULL, NULL),
(52, 15, 'Staff Concern Form', 'scf', 31, 'SB', 1, NULL, NULL, NULL, NULL, NULL),
(53, 16, 'PIP', 'pip', 31, 'SB', 1, NULL, NULL, NULL, NULL, NULL),
(54, 32, 'Scf Data', 'scf-data', 6, 'SB', 0, NULL, NULL, NULL, NULL, NULL),
(55, 17, 'SCF', 'scf', 31, 'SB', 1, NULL, NULL, NULL, NULL, NULL),
(56, 33, 'Performance Review', 'performance-review', 6, 'SB', 0, NULL, NULL, NULL, NULL, NULL),
(57, 33, 'PIP Apprisal', 'probationary-appraisals', 31, 'SB', 1, NULL, NULL, NULL, NULL, NULL),
(58, 32, 'Appraisal Applicable', 'appraisal_applicable', 6, 'SB', 0, NULL, NULL, NULL, NULL, NULL),
(59, 42, 'Perfomance Related Report', 'perfomance-report', 33, 'SB', 1, NULL, NULL, NULL, NULL, NULL),
(60, 43, 'Gratuity Report', 'gratuity-report', 33, 'SB', 1, NULL, NULL, NULL, NULL, NULL),
(61, 33, 'Leave Approval Flow', 'approval-flows', 6, 'SB', 1, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2016_06_01_000001_create_oauth_auth_codes_table', 1),
(4, '2016_06_01_000002_create_oauth_access_tokens_table', 1),
(5, '2016_06_01_000003_create_oauth_refresh_tokens_table', 1),
(6, '2016_06_01_000004_create_oauth_clients_table', 1),
(7, '2016_06_01_000005_create_oauth_personal_access_clients_table', 1),
(8, '2019_08_19_000000_create_failed_jobs_table', 1),
(9, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(10, '2023_02_14_054302_create_academic_year_table', 1),
(11, '2023_02_14_054302_create_activity_logs_table', 1),
(12, '2023_02_14_054302_create_appraisal_data_table', 1),
(13, '2023_02_14_054302_create_approval_status_table', 1),
(14, '2023_02_14_054302_create_contract_type_table', 1),
(15, '2023_02_14_054302_create_countries_table', 1),
(16, '2023_02_14_054302_create_departments_table', 1),
(17, '2023_02_14_054302_create_designations_table', 1),
(18, '2023_02_14_054302_create_employee_departments_table', 1),
(19, '2023_02_14_054302_create_employee_designations_table', 1),
(20, '2023_02_14_054302_create_employee_emergency_details_table', 1),
(21, '2023_02_14_054302_create_employee_health_informations_table', 1),
(22, '2023_02_14_054302_create_employee_payroll_informations_table', 1),
(23, '2023_02_14_054302_create_employee_status_table', 1),
(24, '2023_02_14_054302_create_employees_table', 1),
(25, '2023_02_14_054302_create_inactive_reason_table', 1),
(26, '2023_02_14_054302_create_inactive_status_table', 1),
(27, '2023_02_14_054302_create_leave_application_amendments_table', 1),
(28, '2023_02_14_054302_create_leave_application_status_table', 1),
(29, '2023_02_14_054302_create_leave_applications_table', 1),
(30, '2023_02_14_054302_create_leave_types_table', 1),
(31, '2023_02_14_054302_create_medical_ailment_table', 1),
(32, '2023_02_14_054302_create_menu_links_table', 1),
(33, '2023_02_14_054302_create_moe_approval_status_table', 1),
(34, '2023_02_14_054302_create_paid_status_table', 1),
(35, '2023_02_14_054302_create_payment_deduction_type_table', 1),
(36, '2023_02_14_054302_create_relationship_table', 1),
(37, '2023_02_14_054302_create_relevant_degree_table', 1),
(38, '2023_02_14_054302_create_school_shift_table', 1),
(39, '2023_02_14_054302_create_semesters_table', 1),
(40, '2023_02_14_054302_create_sponsorship_status_table', 1),
(41, '2023_02_14_054302_create_user_roles_table', 1),
(42, '2023_02_14_054303_add_foreign_keys_to_employees_table', 1),
(43, '2023_02_21_073557_create_permission_tables', 1),
(44, '2023_02_27_190647_create_budget_type_table', 1),
(45, '2023_03_22_055035_update_users_table', 1),
(46, '2023_03_22_060441_update_employees_table', 1),
(47, '2023_03_22_083827_update_academic_year_table', 1),
(48, '2023_03_22_084053_update_appraisal_data_table', 1),
(49, '2023_03_22_084248_update_approval_status_table', 1),
(50, '2023_03_22_084421_update_contract_type_table', 1),
(51, '2023_03_22_084553_update_countries_table', 1),
(52, '2023_03_22_084701_update_departments_table', 1),
(53, '2023_03_22_084951_update_designations_table', 1),
(54, '2023_03_22_085117_update_employee_departments_table', 1),
(55, '2023_03_22_085326_update_employee_designations_table', 1),
(56, '2023_03_22_085527_update_employee_emergency_details_table', 1),
(57, '2023_03_22_085640_update_employee_health_informations_table', 1),
(58, '2023_03_22_085907_update_employee_payroll_informations_table', 1),
(59, '2023_03_22_090010_update_employee_status_table', 1),
(60, '2023_03_22_090326_update_inactive_reason_table', 1),
(61, '2023_03_22_090407_update_inactive_status_table', 1),
(62, '2023_03_22_090509_update_leave_application_amendments_table', 1),
(63, '2023_03_22_090646_update_leave_application_status_table', 1),
(64, '2023_03_22_090910_update_leave_applications_table', 1),
(65, '2023_03_22_091100_update_leave_types_table', 1),
(66, '2023_03_22_091409_update_medical_ailment_table', 1),
(67, '2023_03_22_092127_update_menu_links_table', 1),
(68, '2023_03_22_092155_update_moe_approval_status_table', 1),
(69, '2023_03_22_092220_update_paid_status_table', 1),
(70, '2023_03_22_092241_update_payment_deduction_type_table', 1),
(71, '2023_03_22_092301_update_relationship_table', 1),
(72, '2023_03_22_092319_update_relevant_degree_table', 1),
(73, '2023_03_22_092335_update_school_shift_table', 1),
(74, '2023_03_22_092354_update_semesters_table', 1),
(75, '2023_03_22_092411_update_sponsorship_status_table', 1),
(76, '2023_03_22_092457_update_user_roles_table', 1),
(77, '2023_03_22_092629_update_foreign_keys_to_employees_table', 1),
(78, '2023_03_22_092944_update_budget_type_table', 1),
(79, '2023_03_28_103818_create_audits_table', 1),
(80, '2023_04_20_174000_create_gratuity_table', 2),
(81, '2023_04_11_154315_create_earnings_table', 3),
(82, '2023_04_13_095741_create_deductions_table', 4),
(83, '2023_04_06_111400_create_monthlysalaries_table', 5),
(84, '2023_04_20_180600_create_gratuity_table', 6),
(85, '2023_04_20_183500_create_resign_applications_table', 7),
(86, '2023_04_20_184500_create_resign_applications_table', 8),
(87, '2023_04_15_110920_update_leave_applications_table_2', 9),
(88, '2023_04_20_062527_add_fields_to_monthlysalaries_table', 10),
(89, '2023_04_20_073246_rename_fields_to_monthlysalaries_table', 11),
(90, '2023_04_20_091919_change_fieldstype_to_monthlysalaries_table', 12),
(91, '2023_04_24_153030_create_attendances_table', 13),
(92, '2023_04_27_123000_create_gratuity_table', 14),
(93, '2023_04_27_130500_create_gratuity_table', 15),
(94, '2023_04_27_161000_create_gratuity_table', 16),
(95, '2023_04_25_093534_add_gratuity_field_to_earnings_table', 17),
(96, '2023_04_25_085251_add_gratuity_field_to_monthlysalaries_table', 18),
(97, '2023_04_27_161500_create_gratuity_table', 19),
(98, '2023_04_27_165000_create_gratuity_status_table', 20),
(99, '2023_04_27_161700_create_gratuity_table', 21),
(100, '2024_02_05_084642_add_extra_field_employees_table', 22),
(101, '2024_02_05_090315_add_extra_field_scfs_table', 23),
(102, '2024_02_05_131516_add_extra_field_pips_table', 24);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(75) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(75) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 2),
(3, 'App\\Models\\User', 3),
(4, 'App\\Models\\User', 4),
(4, 'App\\Models\\User', 6),
(4, 'App\\Models\\User', 7),
(4, 'App\\Models\\User', 8),
(4, 'App\\Models\\User', 11),
(4, 'App\\Models\\User', 13),
(4, 'App\\Models\\User', 14),
(4, 'App\\Models\\User', 16),
(4, 'App\\Models\\User', 17),
(4, 'App\\Models\\User', 18),
(6, 'App\\Models\\User', 19),
(5, 'App\\Models\\User', 20),
(4, 'App\\Models\\User', 21),
(4, 'App\\Models\\User', 22),
(4, 'App\\Models\\User', 23),
(4, 'App\\Models\\User', 24),
(4, 'App\\Models\\User', 25),
(4, 'App\\Models\\User', 26),
(4, 'App\\Models\\User', 28),
(7, 'App\\Models\\User', 30),
(4, 'App\\Models\\User', 31),
(4, 'App\\Models\\User', 32),
(4, 'App\\Models\\User', 33),
(4, 'App\\Models\\User', 34),
(4, 'App\\Models\\User', 36),
(4, 'App\\Models\\User', 37),
(4, 'App\\Models\\User', 38),
(4, 'App\\Models\\User', 39),
(4, 'App\\Models\\User', 40),
(4, 'App\\Models\\User', 42),
(4, 'App\\Models\\User', 43),
(4, 'App\\Models\\User', 44),
(4, 'App\\Models\\User', 45),
(4, 'App\\Models\\User', 46),
(4, 'App\\Models\\User', 48),
(4, 'App\\Models\\User', 50),
(4, 'App\\Models\\User', 51),
(4, 'App\\Models\\User', 52),
(4, 'App\\Models\\User', 53),
(4, 'App\\Models\\User', 55),
(4, 'App\\Models\\User', 56),
(4, 'App\\Models\\User', 57),
(4, 'App\\Models\\User', 58),
(4, 'App\\Models\\User', 59),
(4, 'App\\Models\\User', 61),
(4, 'App\\Models\\User', 62),
(4, 'App\\Models\\User', 63),
(8, 'App\\Models\\User', 64),
(4, 'App\\Models\\User', 65),
(4, 'App\\Models\\User', 66),
(4, 'App\\Models\\User', 68),
(4, 'App\\Models\\User', 69),
(4, 'App\\Models\\User', 70),
(4, 'App\\Models\\User', 71),
(4, 'App\\Models\\User', 72),
(4, 'App\\Models\\User', 74),
(4, 'App\\Models\\User', 75),
(4, 'App\\Models\\User', 79),
(4, 'App\\Models\\User', 80),
(4, 'App\\Models\\User', 81),
(4, 'App\\Models\\User', 82),
(4, 'App\\Models\\User', 84),
(4, 'App\\Models\\User', 85);

-- --------------------------------------------------------

--
-- Table structure for table `moe_approval_status`
--

CREATE TABLE `moe_approval_status` (
  `id` int NOT NULL,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `moe_approval_status`
--

INSERT INTO `moe_approval_status` (`id`, `name`, `active`, `updated_by`, `created_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Approved', 1, NULL, NULL, NULL, NULL, NULL),
(2, 'Unapproved', 1, NULL, NULL, NULL, NULL, NULL),
(3, 'Pending', 1, NULL, NULL, '2023-05-07 06:24:48', '2023-05-07 06:24:48', NULL),
(4, 'NA', 1, NULL, NULL, '2023-05-07 06:24:59', '2023-05-07 06:24:59', NULL),
(5, 'Under 6- MOE approval not compulsory', 1, NULL, NULL, '2023-09-10 15:36:57', '2023-09-10 15:36:57', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `monthlysalaries`
--

CREATE TABLE `monthlysalaries` (
  `id` bigint UNSIGNED NOT NULL,
  `employee_id` int NOT NULL,
  `month_year` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `basic_salary` decimal(8,2) NOT NULL DEFAULT '0.00',
  `total_gross_salary` decimal(8,2) NOT NULL DEFAULT '0.00',
  `total_addtional_amount` decimal(8,2) NOT NULL DEFAULT '0.00',
  `total_deduction_amount` decimal(8,2) NOT NULL DEFAULT '0.00',
  `no_of_leave_days` int DEFAULT NULL,
  `total_leave_deduction_amount` decimal(8,2) DEFAULT NULL,
  `paid_reason` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_leave_accural_amount` decimal(8,2) DEFAULT NULL,
  `total_gratuity_amount` decimal(8,2) DEFAULT NULL,
  `is_gratuity` tinyint(1) NOT NULL DEFAULT '0',
  `net_salary` decimal(8,2) NOT NULL DEFAULT '0.00',
  `remarks` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `academic_year` smallint NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `entry_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `monthlysalaries`
--

INSERT INTO `monthlysalaries` (`id`, `employee_id`, `month_year`, `basic_salary`, `total_gross_salary`, `total_addtional_amount`, `total_deduction_amount`, `no_of_leave_days`, `total_leave_deduction_amount`, `paid_reason`, `total_leave_accural_amount`, `total_gratuity_amount`, `is_gratuity`, `net_salary`, `remarks`, `academic_year`, `created_at`, `updated_at`, `entry_date`) VALUES
(1, 2, 'April-2024', 0.00, 6500.00, 500.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 7000.00, NULL, 1, '2024-04-29 19:12:21', '2024-04-29 19:12:21', '2024-04-29 21:12:21'),
(2, 6, 'April-2024', 0.00, 6700.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 6700.00, NULL, 1, '2024-04-29 19:12:21', '2024-04-29 19:12:21', '2024-04-29 21:12:21'),
(3, 8, 'April-2024', 0.00, 3000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 3000.00, NULL, 1, '2024-04-29 19:12:21', '2024-04-29 19:12:21', '2024-04-29 21:12:21'),
(4, 17, 'April-2024', 0.00, 38000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 38000.00, NULL, 1, '2024-04-29 19:12:21', '2024-04-29 19:12:21', '2024-04-29 21:12:21'),
(5, 18, 'April-2024', 0.00, 12000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 12000.00, NULL, 1, '2024-04-29 19:12:21', '2024-04-29 19:12:21', '2024-04-29 21:12:21'),
(6, 1, 'April-2024', 0.00, 7000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 7000.00, NULL, 1, '2024-04-29 19:12:21', '2024-04-29 19:12:21', '2024-04-29 21:12:21'),
(7, 7, 'April-2024', 0.00, 7000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 7000.00, NULL, 1, '2024-04-29 19:12:21', '2024-04-29 19:12:21', '2024-04-29 21:12:21'),
(8, 28, 'April-2024', 0.00, 8000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 8000.00, NULL, 1, '2024-04-29 19:12:21', '2024-04-29 19:12:21', '2024-04-29 21:12:21'),
(9, 5, 'April-2024', 0.00, 4000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 4000.00, NULL, 1, '2024-04-29 19:12:21', '2024-04-29 19:12:21', '2024-04-29 21:12:21'),
(10, 4, 'April-2024', 0.00, 7000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 7000.00, NULL, 1, '2024-04-29 19:12:21', '2024-04-29 19:12:21', '2024-04-29 21:12:21'),
(11, 62, 'April-2024', 0.00, 10000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 10000.00, NULL, 1, '2024-04-29 19:12:21', '2024-04-29 19:12:21', '2024-04-29 21:12:21'),
(243, 2, 'May-2024', 0.00, 6500.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 6500.00, NULL, 1, '2024-05-24 22:00:00', '2024-08-30 11:57:36', '2024-08-30 13:57:36'),
(244, 6, 'May-2024', 0.00, 6700.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 6700.00, NULL, 1, '2024-05-24 22:00:00', '2024-08-30 11:57:36', '2024-08-30 13:57:36'),
(245, 8, 'May-2024', 0.00, 3000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 3000.00, NULL, 1, '2024-05-24 22:00:00', '2024-08-30 11:57:36', '2024-08-30 13:57:36'),
(246, 17, 'May-2024', 0.00, 38000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 38000.00, NULL, 1, '2024-05-24 22:00:00', '2024-08-30 11:57:36', '2024-08-30 13:57:36'),
(247, 18, 'May-2024', 0.00, 12000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 12000.00, NULL, 1, '2024-05-24 22:00:00', '2024-08-30 11:57:36', '2024-08-30 13:57:36'),
(248, 1, 'May-2024', 0.00, 7000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 7000.00, NULL, 1, '2024-05-24 22:00:00', '2024-08-30 11:57:36', '2024-08-30 13:57:36'),
(249, 7, 'May-2024', 0.00, 7000.00, 0.00, 0.00, 1, 83.75, 'monthly salary', NULL, NULL, 0, 6916.25, NULL, 1, '2024-05-24 22:00:00', '2024-08-30 11:57:36', '2024-08-30 13:57:36'),
(250, 28, 'May-2024', 0.00, 8000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 8000.00, NULL, 1, '2024-05-24 22:00:00', '2024-08-30 11:57:36', '2024-08-30 13:57:36'),
(251, 5, 'May-2024', 0.00, 4000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 4000.00, NULL, 1, '2024-05-24 22:00:00', '2024-08-30 11:57:36', '2024-08-30 13:57:36'),
(252, 4, 'May-2024', 0.00, 7000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 7000.00, NULL, 1, '2024-05-24 22:00:00', '2024-08-30 11:57:36', '2024-08-30 13:57:36'),
(253, 62, 'May-2024', 0.00, 10000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 10000.00, NULL, 1, '2024-05-24 22:00:00', '2024-08-30 11:57:36', '2024-08-30 13:57:36'),
(254, 2, 'June-2024', 0.00, 6500.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 6500.00, NULL, 1, '2024-06-24 22:00:00', '2024-08-30 11:57:47', '2024-08-30 13:57:47'),
(255, 6, 'June-2024', 0.00, 6700.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 6700.00, NULL, 1, '2024-06-24 22:00:00', '2024-08-30 11:57:47', '2024-08-30 13:57:47'),
(256, 8, 'June-2024', 0.00, 3000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 3000.00, NULL, 1, '2024-06-24 22:00:00', '2024-08-30 11:57:47', '2024-08-30 13:57:47'),
(257, 17, 'June-2024', 0.00, 38000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 38000.00, NULL, 1, '2024-06-24 22:00:00', '2024-08-30 11:57:47', '2024-08-30 13:57:47'),
(258, 18, 'June-2024', 0.00, 12000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 12000.00, NULL, 1, '2024-06-24 22:00:00', '2024-08-30 11:57:47', '2024-08-30 13:57:47'),
(259, 1, 'June-2024', 0.00, 7000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 7000.00, NULL, 1, '2024-06-24 22:00:00', '2024-08-30 11:57:47', '2024-08-30 13:57:47'),
(260, 7, 'June-2024', 0.00, 7000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 7000.00, NULL, 1, '2024-06-24 22:00:00', '2024-08-30 11:57:47', '2024-08-30 13:57:47'),
(261, 28, 'June-2024', 0.00, 8000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 8000.00, NULL, 1, '2024-06-24 22:00:00', '2024-08-30 11:57:47', '2024-08-30 13:57:47'),
(262, 5, 'June-2024', 0.00, 4000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 4000.00, NULL, 1, '2024-06-24 22:00:00', '2024-08-30 11:57:47', '2024-08-30 13:57:47'),
(263, 4, 'June-2024', 0.00, 7000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 7000.00, NULL, 1, '2024-06-24 22:00:00', '2024-08-30 11:57:47', '2024-08-30 13:57:47'),
(264, 62, 'June-2024', 0.00, 10000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 10000.00, NULL, 1, '2024-06-24 22:00:00', '2024-08-30 11:57:47', '2024-08-30 13:57:47'),
(265, 2, 'July-2024', 0.00, 6500.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 6500.00, NULL, 1, '2024-07-24 22:00:00', '2024-08-30 11:57:52', '2024-08-30 13:57:52'),
(266, 6, 'July-2024', 0.00, 6700.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 6700.00, NULL, 1, '2024-07-24 22:00:00', '2024-08-30 11:57:52', '2024-08-30 13:57:52'),
(267, 8, 'July-2024', 0.00, 3000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 3000.00, NULL, 1, '2024-07-24 22:00:00', '2024-08-30 11:57:52', '2024-08-30 13:57:52'),
(268, 17, 'July-2024', 0.00, 38000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 38000.00, NULL, 1, '2024-07-24 22:00:00', '2024-08-30 11:57:52', '2024-08-30 13:57:52'),
(269, 18, 'July-2024', 0.00, 12000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 12000.00, NULL, 1, '2024-07-24 22:00:00', '2024-08-30 11:57:52', '2024-08-30 13:57:52'),
(270, 1, 'July-2024', 0.00, 7000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 7000.00, NULL, 1, '2024-07-24 22:00:00', '2024-08-30 11:57:52', '2024-08-30 13:57:52'),
(271, 7, 'July-2024', 0.00, 7000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 7000.00, NULL, 1, '2024-07-24 22:00:00', '2024-08-30 11:57:52', '2024-08-30 13:57:52'),
(272, 28, 'July-2024', 0.00, 8000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 8000.00, NULL, 1, '2024-07-24 22:00:00', '2024-08-30 11:57:52', '2024-08-30 13:57:52'),
(273, 5, 'July-2024', 0.00, 4000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 4000.00, NULL, 1, '2024-07-24 22:00:00', '2024-08-30 11:57:52', '2024-08-30 13:57:52'),
(274, 4, 'July-2024', 0.00, 7000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 7000.00, NULL, 1, '2024-07-24 22:00:00', '2024-08-30 11:57:52', '2024-08-30 13:57:52'),
(275, 62, 'July-2024', 0.00, 10000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 10000.00, NULL, 1, '2024-07-24 22:00:00', '2024-08-30 11:57:52', '2024-08-30 13:57:52'),
(276, 2, 'August-2024', 0.00, 6500.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 6500.00, NULL, 1, '2024-08-30 11:57:55', '2024-08-30 11:57:55', '2024-08-30 13:57:55'),
(277, 6, 'August-2024', 0.00, 6700.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 6700.00, NULL, 1, '2024-08-30 11:57:55', '2024-08-30 11:57:55', '2024-08-30 13:57:55'),
(278, 8, 'August-2024', 0.00, 3000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 3000.00, NULL, 1, '2024-08-30 11:57:55', '2024-08-30 11:57:55', '2024-08-30 13:57:55'),
(279, 17, 'August-2024', 0.00, 38000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 38000.00, NULL, 1, '2024-08-30 11:57:55', '2024-08-30 11:57:55', '2024-08-30 13:57:55'),
(280, 18, 'August-2024', 0.00, 12000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 12000.00, NULL, 1, '2024-08-30 11:57:55', '2024-08-30 11:57:55', '2024-08-30 13:57:55'),
(281, 1, 'August-2024', 0.00, 7000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 7000.00, NULL, 1, '2024-08-30 11:57:55', '2024-08-30 11:57:55', '2024-08-30 13:57:55'),
(282, 7, 'August-2024', 0.00, 7000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 7000.00, NULL, 1, '2024-08-30 11:57:55', '2024-08-30 11:57:55', '2024-08-30 13:57:55'),
(283, 28, 'August-2024', 0.00, 8000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 8000.00, NULL, 1, '2024-08-30 11:57:55', '2024-08-30 11:57:55', '2024-08-30 13:57:55'),
(284, 5, 'August-2024', 0.00, 4000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 4000.00, NULL, 1, '2024-08-30 11:57:55', '2024-08-30 11:57:55', '2024-08-30 13:57:55'),
(285, 4, 'August-2024', 0.00, 7000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 7000.00, NULL, 1, '2024-08-30 11:57:55', '2024-08-30 11:57:55', '2024-08-30 13:57:55'),
(286, 62, 'August-2024', 0.00, 10000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 10000.00, NULL, 1, '2024-08-30 11:57:55', '2024-08-30 11:57:55', '2024-08-30 13:57:55'),
(287, 2, 'September-2024', 0.00, 6500.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 6500.00, NULL, 1, '2024-09-24 22:00:00', '2024-08-30 11:57:58', '2024-08-30 13:57:58'),
(288, 6, 'September-2024', 0.00, 6700.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 6700.00, NULL, 1, '2024-09-24 22:00:00', '2024-08-30 11:57:58', '2024-08-30 13:57:58'),
(289, 8, 'September-2024', 0.00, 3000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 3000.00, NULL, 1, '2024-09-24 22:00:00', '2024-08-30 11:57:58', '2024-08-30 13:57:58'),
(290, 17, 'September-2024', 0.00, 38000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 38000.00, NULL, 1, '2024-09-24 22:00:00', '2024-08-30 11:57:58', '2024-08-30 13:57:58'),
(291, 18, 'September-2024', 0.00, 12000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 12000.00, NULL, 1, '2024-09-24 22:00:00', '2024-08-30 11:57:58', '2024-08-30 13:57:58'),
(292, 1, 'September-2024', 0.00, 7000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 7000.00, NULL, 1, '2024-09-24 22:00:00', '2024-08-30 11:57:58', '2024-08-30 13:57:58'),
(293, 7, 'September-2024', 0.00, 7000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 7000.00, NULL, 1, '2024-09-24 22:00:00', '2024-08-30 11:57:58', '2024-08-30 13:57:58'),
(294, 28, 'September-2024', 0.00, 8000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 8000.00, NULL, 1, '2024-09-24 22:00:00', '2024-08-30 11:57:58', '2024-08-30 13:57:58'),
(295, 5, 'September-2024', 0.00, 4000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 4000.00, NULL, 1, '2024-09-24 22:00:00', '2024-08-30 11:57:58', '2024-08-30 13:57:58'),
(296, 4, 'September-2024', 0.00, 7000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 7000.00, NULL, 1, '2024-09-24 22:00:00', '2024-08-30 11:57:58', '2024-08-30 13:57:58'),
(297, 62, 'September-2024', 0.00, 10000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 10000.00, NULL, 1, '2024-09-24 22:00:00', '2024-08-30 11:57:58', '2024-08-30 13:57:58'),
(298, 2, 'October-2024', 0.00, 6500.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 6500.00, NULL, 1, '2024-10-24 22:00:00', '2024-08-30 11:58:02', '2024-08-30 13:58:02'),
(299, 6, 'October-2024', 0.00, 6700.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 6700.00, NULL, 1, '2024-10-24 22:00:00', '2024-08-30 11:58:03', '2024-08-30 13:58:03'),
(300, 8, 'October-2024', 0.00, 3000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 3000.00, NULL, 1, '2024-10-24 22:00:00', '2024-08-30 11:58:03', '2024-08-30 13:58:03'),
(301, 17, 'October-2024', 0.00, 38000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 38000.00, NULL, 1, '2024-10-24 22:00:00', '2024-08-30 11:58:03', '2024-08-30 13:58:03'),
(302, 18, 'October-2024', 0.00, 12000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 12000.00, NULL, 1, '2024-10-24 22:00:00', '2024-08-30 11:58:03', '2024-08-30 13:58:03'),
(303, 1, 'October-2024', 0.00, 7000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 7000.00, NULL, 1, '2024-10-24 22:00:00', '2024-08-30 11:58:03', '2024-08-30 13:58:03'),
(304, 7, 'October-2024', 0.00, 7000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 7000.00, NULL, 1, '2024-10-24 22:00:00', '2024-08-30 11:58:03', '2024-08-30 13:58:03'),
(305, 28, 'October-2024', 0.00, 8000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 8000.00, NULL, 1, '2024-10-24 22:00:00', '2024-08-30 11:58:03', '2024-08-30 13:58:03'),
(306, 5, 'October-2024', 0.00, 4000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 4000.00, NULL, 1, '2024-10-24 22:00:00', '2024-08-30 11:58:03', '2024-08-30 13:58:03'),
(307, 4, 'October-2024', 0.00, 7000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 7000.00, NULL, 1, '2024-10-24 22:00:00', '2024-08-30 11:58:03', '2024-08-30 13:58:03'),
(308, 62, 'October-2024', 0.00, 10000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 10000.00, NULL, 1, '2024-10-24 22:00:00', '2024-08-30 11:58:03', '2024-08-30 13:58:03'),
(309, 2, 'November-2024', 0.00, 6500.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 6500.00, NULL, 1, '2024-11-24 23:00:00', '2025-02-13 16:03:23', '2025-02-13 17:03:23'),
(310, 6, 'November-2024', 0.00, 6700.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 6700.00, NULL, 1, '2024-11-24 23:00:00', '2025-02-13 16:03:23', '2025-02-13 17:03:23'),
(311, 8, 'November-2024', 0.00, 3000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 3000.00, NULL, 1, '2024-11-24 23:00:00', '2025-02-13 16:03:23', '2025-02-13 17:03:23'),
(312, 17, 'November-2024', 0.00, 38000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 38000.00, NULL, 1, '2024-11-24 23:00:00', '2025-02-13 16:03:23', '2025-02-13 17:03:23'),
(313, 18, 'November-2024', 0.00, 12000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 12000.00, NULL, 1, '2024-11-24 23:00:00', '2025-02-13 16:03:23', '2025-02-13 17:03:23'),
(314, 1, 'November-2024', 0.00, 7000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 7000.00, NULL, 1, '2024-11-24 23:00:00', '2025-02-13 16:03:23', '2025-02-13 17:03:23'),
(315, 83, 'November-2024', 0.00, 10000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 10000.00, NULL, 1, '2024-11-24 23:00:00', '2025-02-13 16:03:23', '2025-02-13 17:03:23'),
(316, 85, 'November-2024', 0.00, 3700.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 3700.00, NULL, 1, '2024-11-24 23:00:00', '2025-02-13 16:03:23', '2025-02-13 17:03:23'),
(317, 7, 'November-2024', 0.00, 7000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 7000.00, NULL, 1, '2024-11-24 23:00:00', '2025-02-13 16:03:23', '2025-02-13 17:03:23'),
(318, 28, 'November-2024', 0.00, 8000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 8000.00, NULL, 1, '2024-11-24 23:00:00', '2025-02-13 16:03:23', '2025-02-13 17:03:23'),
(319, 5, 'November-2024', 0.00, 4000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 4000.00, NULL, 1, '2024-11-24 23:00:00', '2025-02-13 16:03:23', '2025-02-13 17:03:23'),
(320, 4, 'November-2024', 0.00, 7000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 7000.00, NULL, 1, '2024-11-24 23:00:00', '2025-02-13 16:03:23', '2025-02-13 17:03:23'),
(321, 62, 'November-2024', 0.00, 10000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 10000.00, NULL, 1, '2024-11-24 23:00:00', '2025-02-13 16:03:23', '2025-02-13 17:03:23'),
(322, 2, 'December-2024', 0.00, 6500.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 6500.00, NULL, 1, '2024-12-24 23:00:00', '2025-02-13 16:03:26', '2025-02-13 17:03:26'),
(323, 6, 'December-2024', 0.00, 6700.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 6700.00, NULL, 1, '2024-12-24 23:00:00', '2025-02-13 16:03:26', '2025-02-13 17:03:26'),
(324, 8, 'December-2024', 0.00, 3000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 3000.00, NULL, 1, '2024-12-24 23:00:00', '2025-02-13 16:03:26', '2025-02-13 17:03:26'),
(325, 17, 'December-2024', 0.00, 38000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 38000.00, NULL, 1, '2024-12-24 23:00:00', '2025-02-13 16:03:26', '2025-02-13 17:03:26'),
(326, 18, 'December-2024', 0.00, 12000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 12000.00, NULL, 1, '2024-12-24 23:00:00', '2025-02-13 16:03:26', '2025-02-13 17:03:26'),
(327, 1, 'December-2024', 0.00, 7000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 7000.00, NULL, 1, '2024-12-24 23:00:00', '2025-02-13 16:03:26', '2025-02-13 17:03:26'),
(328, 83, 'December-2024', 0.00, 10000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 10000.00, NULL, 1, '2024-12-24 23:00:00', '2025-02-13 16:03:26', '2025-02-13 17:03:26'),
(329, 85, 'December-2024', 0.00, 3700.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 3700.00, NULL, 1, '2024-12-24 23:00:00', '2025-02-13 16:03:26', '2025-02-13 17:03:26'),
(330, 7, 'December-2024', 0.00, 7000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 7000.00, NULL, 1, '2024-12-24 23:00:00', '2025-02-13 16:03:26', '2025-02-13 17:03:26'),
(331, 28, 'December-2024', 0.00, 8000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 8000.00, NULL, 1, '2024-12-24 23:00:00', '2025-02-13 16:03:26', '2025-02-13 17:03:26'),
(332, 5, 'December-2024', 0.00, 4000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 4000.00, NULL, 1, '2024-12-24 23:00:00', '2025-02-13 16:03:26', '2025-02-13 17:03:26'),
(333, 4, 'December-2024', 0.00, 7000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 7000.00, NULL, 1, '2024-12-24 23:00:00', '2025-02-13 16:03:26', '2025-02-13 17:03:26'),
(334, 62, 'December-2024', 0.00, 10000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 10000.00, NULL, 1, '2024-12-24 23:00:00', '2025-02-13 16:03:26', '2025-02-13 17:03:26'),
(335, 2, 'January-2025', 0.00, 6500.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 6500.00, NULL, 1, '2025-01-24 23:00:00', '2025-02-13 16:03:29', '2025-02-13 17:03:29'),
(336, 6, 'January-2025', 0.00, 6700.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 6700.00, NULL, 1, '2025-01-24 23:00:00', '2025-02-13 16:03:29', '2025-02-13 17:03:29'),
(337, 8, 'January-2025', 0.00, 3000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 3000.00, NULL, 1, '2025-01-24 23:00:00', '2025-02-13 16:03:29', '2025-02-13 17:03:29'),
(338, 17, 'January-2025', 0.00, 38000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 38000.00, NULL, 1, '2025-01-24 23:00:00', '2025-02-13 16:03:29', '2025-02-13 17:03:29'),
(339, 18, 'January-2025', 0.00, 12000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 12000.00, NULL, 1, '2025-01-24 23:00:00', '2025-02-13 16:03:29', '2025-02-13 17:03:29'),
(340, 1, 'January-2025', 0.00, 7000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 7000.00, NULL, 1, '2025-01-24 23:00:00', '2025-02-13 16:03:29', '2025-02-13 17:03:29'),
(341, 83, 'January-2025', 0.00, 10000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 10000.00, NULL, 1, '2025-01-24 23:00:00', '2025-02-13 16:03:29', '2025-02-13 17:03:29'),
(342, 85, 'January-2025', 0.00, 3700.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 3700.00, NULL, 1, '2025-01-24 23:00:00', '2025-02-13 16:03:29', '2025-02-13 17:03:29'),
(343, 7, 'January-2025', 0.00, 7000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 7000.00, NULL, 1, '2025-01-24 23:00:00', '2025-02-13 16:03:29', '2025-02-13 17:03:29'),
(344, 28, 'January-2025', 0.00, 8000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 8000.00, NULL, 1, '2025-01-24 23:00:00', '2025-02-13 16:03:29', '2025-02-13 17:03:29'),
(345, 5, 'January-2025', 0.00, 4000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 4000.00, NULL, 1, '2025-01-24 23:00:00', '2025-02-13 16:03:29', '2025-02-13 17:03:29'),
(346, 4, 'January-2025', 0.00, 7000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 7000.00, NULL, 1, '2025-01-24 23:00:00', '2025-02-13 16:03:29', '2025-02-13 17:03:29'),
(347, 62, 'January-2025', 0.00, 10000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 10000.00, NULL, 1, '2025-01-24 23:00:00', '2025-02-13 16:03:29', '2025-02-13 17:03:29'),
(348, 2, 'February-2025', 0.00, 6500.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 6500.00, NULL, 1, '2025-02-24 11:11:05', '2025-02-24 11:11:05', '2025-02-24 12:11:05'),
(349, 6, 'February-2025', 0.00, 6700.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 6700.00, NULL, 1, '2025-02-24 11:11:05', '2025-02-24 11:11:05', '2025-02-24 12:11:05'),
(350, 8, 'February-2025', 0.00, 3000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 3000.00, NULL, 1, '2025-02-24 11:11:05', '2025-02-24 11:11:05', '2025-02-24 12:11:05'),
(351, 17, 'February-2025', 0.00, 38000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 38000.00, NULL, 1, '2025-02-24 11:11:05', '2025-02-24 11:11:05', '2025-02-24 12:11:05'),
(352, 18, 'February-2025', 0.00, 12000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 12000.00, NULL, 1, '2025-02-24 11:11:05', '2025-02-24 11:11:05', '2025-02-24 12:11:05'),
(353, 1, 'February-2025', 0.00, 7000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 7000.00, NULL, 1, '2025-02-24 11:11:05', '2025-02-24 11:11:05', '2025-02-24 12:11:05'),
(354, 83, 'February-2025', 0.00, 10000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 10000.00, NULL, 1, '2025-02-24 11:11:05', '2025-02-24 11:11:05', '2025-02-24 12:11:05'),
(355, 85, 'February-2025', 0.00, 3700.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 3700.00, NULL, 1, '2025-02-24 11:11:05', '2025-02-24 11:11:05', '2025-02-24 12:11:05'),
(356, 7, 'February-2025', 0.00, 7000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 7000.00, NULL, 1, '2025-02-24 11:11:05', '2025-02-24 11:11:05', '2025-02-24 12:11:05'),
(357, 28, 'February-2025', 0.00, 8000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 8000.00, NULL, 1, '2025-02-24 11:11:05', '2025-02-24 11:11:05', '2025-02-24 12:11:05'),
(358, 5, 'February-2025', 0.00, 4000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 4000.00, NULL, 1, '2025-02-24 11:11:05', '2025-02-24 11:11:05', '2025-02-24 12:11:05'),
(359, 4, 'February-2025', 0.00, 7000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 7000.00, NULL, 1, '2025-02-24 11:11:05', '2025-02-24 11:11:05', '2025-02-24 12:11:05'),
(360, 62, 'February-2025', 0.00, 10000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 10000.00, NULL, 1, '2025-02-24 11:11:05', '2025-02-24 11:11:05', '2025-02-24 12:11:05'),
(361, 2, 'March-2025', 0.00, 6500.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 6500.00, NULL, 1, '2025-03-24 23:00:00', '2025-04-23 09:06:45', '2025-04-23 11:06:45'),
(362, 6, 'March-2025', 0.00, 6700.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 6700.00, NULL, 1, '2025-03-24 23:00:00', '2025-04-23 09:06:45', '2025-04-23 11:06:45'),
(363, 8, 'March-2025', 0.00, 3000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 3000.00, NULL, 1, '2025-03-24 23:00:00', '2025-04-23 09:06:45', '2025-04-23 11:06:45'),
(364, 17, 'March-2025', 0.00, 700000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 700000.00, NULL, 1, '2025-03-24 23:00:00', '2025-04-23 09:06:45', '2025-04-23 11:06:45'),
(365, 18, 'March-2025', 0.00, 12000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 12000.00, NULL, 1, '2025-03-24 23:00:00', '2025-04-23 09:06:45', '2025-04-23 11:06:45'),
(366, 1, 'March-2025', 0.00, 7000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 7000.00, NULL, 1, '2025-03-24 23:00:00', '2025-04-23 09:06:45', '2025-04-23 11:06:45'),
(367, 83, 'March-2025', 0.00, 10000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 10000.00, NULL, 1, '2025-03-24 23:00:00', '2025-04-23 09:06:45', '2025-04-23 11:06:45'),
(368, 85, 'March-2025', 0.00, 3700.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 3700.00, NULL, 1, '2025-03-24 23:00:00', '2025-04-23 09:06:45', '2025-04-23 11:06:45'),
(369, 7, 'March-2025', 0.00, 7000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 7000.00, NULL, 1, '2025-03-24 23:00:00', '2025-04-23 09:06:45', '2025-04-23 11:06:45'),
(370, 28, 'March-2025', 0.00, 8000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 8000.00, NULL, 1, '2025-03-24 23:00:00', '2025-04-23 09:06:45', '2025-04-23 11:06:45'),
(371, 5, 'March-2025', 0.00, 4000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 4000.00, NULL, 1, '2025-03-24 23:00:00', '2025-04-23 09:06:45', '2025-04-23 11:06:45'),
(372, 4, 'March-2025', 0.00, 7000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 7000.00, NULL, 1, '2025-03-24 23:00:00', '2025-04-23 09:06:45', '2025-04-23 11:06:45'),
(373, 62, 'March-2025', 0.00, 10000.00, 0.00, 0.00, 0, 0.00, 'monthly salary', NULL, NULL, 0, 10000.00, NULL, 1, '2025-03-24 23:00:00', '2025-04-23 09:06:45', '2025-04-23 11:06:45');

-- --------------------------------------------------------

--
-- Table structure for table `notice_period`
--

CREATE TABLE `notice_period` (
  `id` int NOT NULL,
  `employee_id` int NOT NULL,
  `np_days` smallint NOT NULL DEFAULT '30',
  `np_description` varchar(500) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `notice_period`
--

INSERT INTO `notice_period` (`id`, `employee_id`, `np_days`, `np_description`, `created_at`, `updated_at`) VALUES
(1, 7, 15, '15 days NP', '2023-12-01 17:43:34', '2023-12-01 17:43:34');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int NOT NULL,
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint UNSIGNED NOT NULL,
  `notify_to` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT 'group of ids for notify',
  `title` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `data` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_date` date DEFAULT NULL,
  `link` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'dashboard',
  `pushed_at` timestamp NULL DEFAULT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `notify_to`, `title`, `data`, `title_date`, `link`, `pushed_at`, `read_at`, `created_at`, `updated_at`) VALUES
(201, 'Leave Flow', 'App\\Models\\Leave\\LeaveApplication', 3, NULL, 'Leave Request Notification', 'One leave request is waiting for your response', NULL, 'leaveapproval', '2025-12-18 14:45:33', NULL, '2025-12-18 12:31:34', '2025-12-18 14:45:33'),
(202, 'Leave Flow', 'App\\Models\\Leave\\LeaveApplication', 19, NULL, 'Leave Request Notification', 'One leave request is waiting for your response', NULL, 'leaveapproval', '2025-12-18 14:45:33', NULL, '2025-12-18 12:32:17', '2025-12-18 14:45:33'),
(203, 'Leave Approval', 'App\\Models\\Leave\\LeaveApplication', 3, NULL, 'Leave Request Notification', 'Leave Request has been approved successfully', NULL, 'leaveapproval', '2025-12-18 14:45:34', NULL, '2025-12-18 12:33:01', '2025-12-18 14:45:34'),
(204, 'Attendance', 'App\\Models\\Employee\\Attendance', 3, NULL, 'Attendance check in marked successfully', 'Time: 18:14:31 [ 18-12-2025 ] ', NULL, 'attendance', '2025-12-18 14:45:34', NULL, '2025-12-18 12:44:35', '2025-12-18 14:45:34'),
(205, 'Attendance', 'App\\Models\\Employee\\Attendance', 3, NULL, 'Attendance check in marked successfully', 'Time: 12:04:18 [ 19-12-2025 ] ', NULL, 'attendance', '2025-12-22 07:48:26', NULL, '2025-12-19 06:34:23', '2025-12-22 07:48:26'),
(206, 'Attendance', 'App\\Models\\Employee\\Attendance', 3, NULL, 'Attendance check out marked successfully', 'Time: 13:36:06 [ 19-12-2025 ] ', NULL, 'attendance', '2025-12-22 07:48:26', NULL, '2025-12-19 08:06:10', '2025-12-22 07:48:26'),
(207, 'Leave Flow', 'App\\Models\\Leave\\LeaveApplication', 3, NULL, 'Leave Request Notification', 'One leave request is waiting for your response', NULL, 'leaveapproval', '2025-12-22 07:48:26', NULL, '2025-12-19 09:26:14', '2025-12-22 07:48:26'),
(208, 'Event', 'App\\Models\\SchoolEvent', 0, NULL, 'Xmas Holiday', 'An upcoming event/function is added in the calendar', '2025-12-25', 'calendar', '2025-12-22 07:48:27', NULL, '2025-12-22 05:48:26', '2025-12-22 07:48:27'),
(209, 'Event', 'App\\Models\\SchoolEvent', 0, NULL, 'X\'mas Holiday', 'An event/function is updated in the calendar', '2025-12-25', 'calendar', '2025-12-22 07:48:43', NULL, '2025-12-22 05:48:43', '2025-12-22 07:48:43'),
(210, 'Attendance', 'App\\Models\\Employee\\Attendance', 3, NULL, 'Attendance check in marked successfully', 'Time: 13:23:09 [ 22-12-2025 ] ', NULL, 'attendance', NULL, NULL, '2025-12-22 07:53:13', '2025-12-22 07:53:13'),
(211, 'Attendance', 'App\\Models\\Employee\\Attendance', 9, NULL, 'Attendance check in marked successfully', 'Time: 13:34:22 [ 22-12-2025 ] ', NULL, 'attendance', NULL, NULL, '2025-12-22 08:04:26', '2025-12-22 08:04:26'),
(212, 'Attendance', 'App\\Models\\Employee\\Attendance', 9, NULL, 'Attendance check out marked successfully', 'Time: 13:34:53 [ 22-12-2025 ] ', NULL, 'attendance', NULL, NULL, '2025-12-22 08:04:57', '2025-12-22 08:04:57'),
(213, 'Attendance', 'App\\Models\\Employee\\Attendance', 3, NULL, 'Attendance check out marked successfully', 'Time: 13:57:21 [ 22-12-2025 ] ', NULL, 'attendance', NULL, NULL, '2025-12-22 08:27:26', '2025-12-22 08:27:26'),
(214, 'Attendance', 'App\\Models\\Employee\\Attendance', 3, NULL, 'Attendance check in marked successfully', 'Time: 13:58:51 [ 22-12-2025 ] ', NULL, 'attendance', NULL, NULL, '2025-12-22 08:28:56', '2025-12-22 08:28:56'),
(215, 'Attendance', 'App\\Models\\Employee\\Attendance', 3, NULL, 'Attendance check out marked successfully', 'Time: 14:00:17 [ 22-12-2025 ] ', NULL, 'attendance', NULL, NULL, '2025-12-22 08:30:21', '2025-12-22 08:30:21'),
(216, 'Leave Flow', 'App\\Models\\Leave\\LeaveApplication', 3, NULL, 'Leave Request Notification', 'One leave request is waiting for your response', NULL, 'leaveapproval', NULL, NULL, '2025-12-22 08:36:43', '2025-12-22 08:36:43'),
(217, 'Leave Flow', 'App\\Models\\Leave\\LeaveApplication', 19, NULL, 'Leave Request Notification', 'One leave request is waiting for your response', NULL, 'leaveapproval', NULL, NULL, '2025-12-22 08:37:16', '2025-12-22 08:37:16'),
(218, 'Leave Approval', 'App\\Models\\Leave\\LeaveApplication', 3, NULL, 'Leave Request Notification', 'Leave Request has been approved successfully', NULL, 'leaveapproval', NULL, NULL, '2025-12-22 08:37:55', '2025-12-22 08:37:55'),
(219, 'Leave Flow', 'App\\Models\\Leave\\LeaveApplication', 19, NULL, 'Leave Request Notification', 'One leave request is waiting for your response', NULL, 'leaveapproval', NULL, NULL, '2025-12-22 09:03:47', '2025-12-22 09:03:47'),
(220, 'Leave Flow', 'App\\Models\\Leave\\LeaveApplication', 19, NULL, 'Leave Request Notification', 'One leave request is waiting for your response', NULL, 'leaveapproval', NULL, NULL, '2025-12-22 09:31:00', '2025-12-22 09:31:00'),
(221, 'Leave Flow', 'App\\Models\\Leave\\LeaveApplication', 19, NULL, 'Leave Request Notification', 'One leave request is waiting for your response', NULL, 'leaveapproval', NULL, NULL, '2025-12-22 15:38:48', '2025-12-22 15:38:48'),
(222, 'Leave Approval', 'App\\Models\\Leave\\LeaveApplication', 3, NULL, 'Leave Request Notification', 'Leave Request has been approved successfully', NULL, 'leaveapproval', NULL, NULL, '2025-12-22 15:39:50', '2025-12-22 15:39:50'),
(223, 'Attendance', 'App\\Models\\Employee\\Attendance', 7, NULL, 'Attendance check in marked successfully', 'Time: 10:08:33 [ 23-12-2025 ] ', NULL, 'attendance', NULL, NULL, '2025-12-23 04:38:37', '2025-12-23 04:38:37'),
(224, 'Attendance', 'App\\Models\\Employee\\Attendance', 7, NULL, 'Attendance check out marked successfully', 'Time: 10:09:09 [ 23-12-2025 ] ', NULL, 'attendance', NULL, NULL, '2025-12-23 04:39:13', '2025-12-23 04:39:13'),
(225, 'Attendance', 'App\\Models\\Employee\\Attendance', 7, NULL, 'Attendance check in marked successfully', 'Time: 10:09:29 [ 23-12-2025 ] ', NULL, 'attendance', NULL, NULL, '2025-12-23 04:39:33', '2025-12-23 04:39:33'),
(226, 'Attendance', 'App\\Models\\Employee\\Attendance', 9, NULL, 'Attendance check in marked successfully', 'Time: 10:10:33 [ 23-12-2025 ] ', NULL, 'attendance', NULL, NULL, '2025-12-23 04:40:37', '2025-12-23 04:40:37'),
(227, 'Attendance', 'App\\Models\\Employee\\Attendance', 9, NULL, 'Attendance check out marked successfully', 'Time: 10:38:49 [ 23-12-2025 ] ', NULL, 'attendance', NULL, NULL, '2025-12-23 05:08:54', '2025-12-23 05:08:54'),
(228, 'Attendance', 'App\\Models\\Employee\\Attendance', 9, NULL, 'Attendance check in marked successfully', 'Time: 10:39:19 [ 23-12-2025 ] ', NULL, 'attendance', NULL, NULL, '2025-12-23 05:09:24', '2025-12-23 05:09:24'),
(229, 'Leave Flow', 'App\\Models\\Leave\\LeaveApplication', 19, NULL, 'Leave Request Notification', 'One leave request is waiting for your response', NULL, 'leaveapproval', NULL, NULL, '2025-12-23 06:46:37', '2025-12-23 06:46:37'),
(230, 'Leave Approval', 'App\\Models\\Leave\\LeaveApplication', 3, NULL, 'Leave Request Notification', 'Leave Request has been approved successfully', NULL, 'leaveapproval', NULL, NULL, '2025-12-23 06:47:43', '2025-12-23 06:47:43'),
(231, 'Leave Flow', 'App\\Models\\Leave\\LeaveApplication', 19, NULL, 'Leave Request Notification', 'One leave request is waiting for your response', NULL, 'leaveapproval', NULL, NULL, '2025-12-23 07:20:25', '2025-12-23 07:20:25'),
(232, 'Leave Approval', 'App\\Models\\Leave\\LeaveApplication', 3, NULL, 'Leave Request Notification', 'Leave Request has been approved successfully', NULL, 'leaveapproval', NULL, NULL, '2025-12-23 07:21:37', '2025-12-23 07:21:37');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `client_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_access_tokens`
--

INSERT INTO `oauth_access_tokens` (`id`, `user_id`, `client_id`, `name`, `scopes`, `revoked`, `created_at`, `updated_at`, `expires_at`) VALUES
('01f6a5df27c3eec8da307a0e9511a53e9f746f1cbd045bb044c3af57366c4794851ca5bff6b4940f', 3, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2025-12-18 14:23:28', '2025-12-18 14:23:28', '2026-12-18 15:23:28'),
('02d46195bc841c0630dfbdeb30cc2f4cdd4134e4d0f28c15309bb12bf0d66152c8f536a3947dcd94', 2, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-26 15:07:57', '2024-09-26 15:07:57', '2025-09-26 17:07:57'),
('0308a1707ab1df17e5ac3cfba9f2c1fe4c6955454c20a0a638a6834b0ba032902b9f117a2af616f1', 2, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-28 13:11:37', '2024-09-28 13:11:37', '2025-09-28 15:11:37'),
('0570fe2400fca73d3fc51b1334706c04d301383f4b4540e08be8282583cb0a23b9897b71e1b4b9bb', 2, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-27 14:10:52', '2024-09-27 14:10:52', '2025-09-27 16:10:52'),
('09dfb8eeac01629ffde3df46f9fce1b8185b76a217fd9e49502adf091f1e568abb114271b564cdce', 2, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-26 06:57:40', '2024-09-26 06:57:40', '2025-09-26 08:57:40'),
('0d13918480befec1fda5d85d29cf9f18b4076556598da8d5c67ffdf1273f539802179d6bf76083bc', 4, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-21 14:19:57', '2024-09-21 14:19:57', '2025-09-21 16:19:57'),
('0dbde14c6b0f76eba8ecff92ac2c234aa3d5e40d5973162dbf01064904b8c82823d1925543c040b4', 2, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-26 06:55:21', '2024-09-26 06:55:21', '2025-09-26 08:55:21'),
('0f1fbc5e991c33f2628e5dbdfcee6627832935a0dff810f2c35e14ac71c389437aa44414f72421b0', 2, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-26 09:26:34', '2024-09-26 09:26:34', '2025-09-26 11:26:34'),
('17e6cd5cc876d76557f4318f5bce67a8fac5089acd5378ddd5c8f0eb5bf15eef668ad9001ee6c31c', 2, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-26 15:02:54', '2024-09-26 15:02:54', '2025-09-26 17:02:54'),
('1845f497a19f4925614726986106d0a9f99c0d2766661f5f06a7bff982b78c1e4eaa9cadf66029da', 2, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-27 08:14:46', '2024-09-27 08:14:46', '2025-09-27 10:14:46'),
('18615b018fb9b743df5e6d013f05218c6418b79e1ba9b01bb42dc077df9a9b91bcf764e9fe0d8f84', 2, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-26 08:20:13', '2024-09-26 08:20:13', '2025-09-26 10:20:13'),
('186ec8e9c9d828d21b009cdcc891eeaf1ccee4fc07a057f207ec58dbe12e3a6ae4fb45267219df71', 4, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-20 07:04:21', '2024-09-20 07:04:21', '2025-09-20 09:04:21'),
('1aac8dd9dff36c2627fda8385d477b57b2bb18913b2466f80bcb0292f9c373789cc87d6fdc2f3635', 2, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-27 14:13:33', '2024-09-27 14:13:33', '2025-09-27 16:13:33'),
('1c77facb00cbaf09ba626d75ef2d3044524a1d39ced04afe1c3f64e5ed3b7a36939fafddb6e8a782', 6, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2025-12-23 08:58:10', '2025-12-23 08:58:10', '2026-12-23 09:58:10'),
('1cdf86b5e36b71099eb12d3e04df38e213c81f3b0d8c2d26d25da0da59037f150c92c9ad1571f9c8', 4, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-25 16:22:22', '2024-09-25 16:22:22', '2025-09-25 18:22:22'),
('1f6437d4cdf0ad4d3fb4559238ed5f52b31e95139b7dfbbdc1ac4ba76d90f460550d279725edddef', 2, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-27 13:01:19', '2024-09-27 13:01:19', '2025-09-27 15:01:19'),
('2112f9426690ebaf78203fe6671859d67f505f153da53f04ac1524f7e8fcb792c54027404c0ef044', 3, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2025-04-15 15:31:53', '2025-04-15 15:31:53', '2026-04-15 17:31:53'),
('252322b8f36cdd565ab3e2c480f51df7cb559b88c73f7c8726ac5dfbcd8dad4a2038e680e3d8b8cf', 2, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-25 15:01:27', '2024-09-25 15:01:27', '2025-09-25 17:01:27'),
('27a422379cb6b2aec757664ac480f0e26e3ff9a61e87b5b34ddbc697032247b8597e59a194450af1', 2, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-25 15:16:34', '2024-09-25 15:16:34', '2025-09-25 17:16:34'),
('2bf2aa02a45d40076ddfc20b60040893c53d52c0114f41b5869e554726099c44e3fd605ce59ff192', 1, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-20 09:09:39', '2024-09-20 09:09:39', '2025-09-20 11:09:39'),
('2ee736dbe76c0dcdab8d375ad80d0bf6ae358859fdab900d5c763db296ee55da2e15873b1898cbc9', 2, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-26 15:22:45', '2024-09-26 15:22:45', '2025-09-26 17:22:45'),
('30e7997f26792eb5834093462bc075a19f68082113518dbf44a6dcb804ae325b49fcab1ce882fe84', 2, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-26 13:07:16', '2024-09-26 13:07:16', '2025-09-26 15:07:16'),
('311281b867767063a8258c7069b647842662db4698e347c6e4cfaf05f443435ec1bb183b24d1660c', 4, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-22 11:44:48', '2024-09-22 11:44:48', '2025-09-22 13:44:48'),
('36cf763c51e89f88b9b1ace15bf9060125cf2075f8c3901065e3e59248e6fa11cd21491ae0bcc770', 2, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-26 08:04:58', '2024-09-26 08:04:58', '2025-09-26 10:04:58'),
('395ad1b492967ac3fbad4b8fee90d8648e7b8b0e381c645dba9542afec52a2af5a9acc421da7ce9c', 2, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-28 06:36:13', '2024-09-28 06:36:13', '2025-09-28 08:36:13'),
('39a5ae2a4d14b4c3ca601c41bfd6aecbf30baad12ab54bcba911888bcbc3cc97d29cb80d78febaa0', 2, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-26 08:26:53', '2024-09-26 08:26:53', '2025-09-26 10:26:53'),
('3a36c85c922bbf9458ec4dc42102ccfd2af7b37054f352f925d18c956a131fe3c23021a48c7d7706', 1, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-28 07:35:35', '2024-09-28 07:35:35', '2025-09-28 09:35:35'),
('3aa0d5e41a36f2c297c36f0ca8d42f1e43c9210be13d3491561cb85b7485c876aa05554d370169f4', 2, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-25 15:02:33', '2024-09-25 15:02:33', '2025-09-25 17:02:33'),
('3b35b3f980c04a4c8b32437c54e572fc634f1a02f99633952c14dbdbe7bdf08711633d838f92ed37', 2, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-26 08:20:56', '2024-09-26 08:20:56', '2025-09-26 10:20:56'),
('3b7e7b4e9907fcb6012475de9471ca2b53f7397c687cf9ce8f804ed20cdd5d1059f08dcf01bf716b', 2, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-26 08:53:23', '2024-09-26 08:53:23', '2025-09-26 10:53:23'),
('3ce15f564eaae2240abb25e29054573d94b32645ba9cdecb968af4f8124258cf933bcaee5900fd66', 2, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-26 08:51:07', '2024-09-26 08:51:07', '2025-09-26 10:51:07'),
('3d3635c350eed7d983daa35b02176d48c738c414470b30c6facd7e6ceaed3b7eaeefac135e3c99ae', 2, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-25 15:24:36', '2024-09-25 15:24:36', '2025-09-25 17:24:36'),
('414a8eeb59840750f7b7236b989c8c39540e446de9bc3b3f12889f0e1fd84df2f24d3ae35c527ea0', 2, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-20 09:32:26', '2024-09-20 09:32:26', '2025-09-20 11:32:26'),
('4422670d4bc6f08f30ac4bcc6d6c855abb99cef97a6ac0a270922c4b64192477f6f51597686911f3', 2, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-26 13:49:58', '2024-09-26 13:49:58', '2025-09-26 15:49:58'),
('446471c5c4f2cc3d23c81d62b2be99aac2dd4fef2c195e27a75387402290e82d4d1a0ec6f8347db7', 2, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-20 09:41:19', '2024-09-20 09:41:19', '2025-09-20 11:41:19'),
('4626289a33b80875c405a41f61686621f2cea1dea5f16d91ee73a5d4773b168e083af28f83b48ae4', 2, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-25 15:02:18', '2024-09-25 15:02:18', '2025-09-25 17:02:18'),
('47daf5aba22c58cb38a57ddcdd4abba964514ba2a292b3167f43711960712e9426bde271bac1e923', 2, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-27 07:48:57', '2024-09-27 07:48:57', '2025-09-27 09:48:57'),
('48c9e60083aac6e5e7c74ab009bea5c8624ecd656ade2c50c3e9b88ef63cd1811dd075d4a3da1275', 4, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-28 06:57:13', '2024-09-28 06:57:13', '2025-09-28 08:57:13'),
('4a738d6219287b0d74d3e5242c3f0c6baf5c2edc607ca68078e0f3d223aa0f382f86e16c1e4a1770', 4, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-20 11:08:43', '2024-09-20 11:08:43', '2025-09-20 13:08:43'),
('4c2f573a3eb8443fe8a1cc892188da198c3f2d82c5093ef96f3a12a68f423771013c5b6cbeb91ffc', 2, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-28 12:05:22', '2024-09-28 12:05:22', '2025-09-28 14:05:22'),
('50924893f9ba721b0e9b0300464473d48b3ea52543eae450882c0e93fb3647801e70142cfd7b7345', 2, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-28 11:43:47', '2024-09-28 11:43:47', '2025-09-28 13:43:47'),
('53613e2f54d75cae3685b4e239ebbd1eee6f205402781c51aaa3409f751ba1a012b25304d30b453c', 1, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-20 09:06:33', '2024-09-20 09:06:33', '2025-09-20 11:06:33'),
('53b122cda0d1bedc0f20adb97eb862f9803f3651caa774da2d55c174ef43d5097776a8d57c53ec36', 2, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-26 07:00:30', '2024-09-26 07:00:30', '2025-09-26 09:00:30'),
('5484b0271d1959ae409dee8e9f85f5f8bdbef9656fc8f9bd7b9015b96c209808fcba5968e4a81aca', 2, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-20 09:31:54', '2024-09-20 09:31:54', '2025-09-20 11:31:54'),
('55930939f89713483f76219a89aee67d9a86e5813dbaf1ea7f0ad61e87b4565f60fb4dcc4231c651', 2, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-20 09:38:49', '2024-09-20 09:38:49', '2025-09-20 11:38:49'),
('562b28e25677c5f798f9531fe4c78e3a4e17e66e13d26bb0d84931b1756bd70cdac11f73c3088444', 2, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-27 11:38:39', '2024-09-27 11:38:39', '2025-09-27 13:38:39'),
('59d0cb839a403215df654d1a94762cb4aef0db4f0edc7a71ac6b0aa3058e34f0acff6cb1df28ad90', 7, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2025-12-23 06:35:20', '2025-12-23 06:35:20', '2026-12-23 07:35:20'),
('5ab9654a046b99990745202fe2342594d5cf50fb132260d93aa7a5bffe92e898a0aa13d726c33cac', 4, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-30 12:05:58', '2024-09-30 12:05:58', '2025-09-30 14:05:58'),
('5b539e4ad56df8bff38c1654f4c5da9b35d33806ddfe926e6efb1cc879c4472596c5aa534249dfd9', 2, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-28 11:46:34', '2024-09-28 11:46:34', '2025-09-28 13:46:34'),
('5bb7f13fd00541f9cdc02c59322cbe4c55d9484a0ecaa59e6cb91b16105971ef6b2a431dac8b461d', 4, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-22 11:44:10', '2024-09-22 11:44:10', '2025-09-22 13:44:10'),
('5c54d0e72cb99b6c58949a220b21e130cfb6c5985bcb5b1e6a2547f6a3f04369003ac92e10506970', 4, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-22 11:31:51', '2024-09-22 11:31:51', '2025-09-22 13:31:51'),
('5f6eedfba46dbd67e745e69d16addfe15d144d020473a23e6b97136a67db75d2dcc2dac156a48c1a', 4, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-21 09:50:05', '2024-09-21 09:50:05', '2025-09-21 11:50:05'),
('604aca992d2c09f5114d56f3d9b8b9317fc6ace92486fa78f7a8f5b9f30d93960381688face210a1', 4, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-10-08 10:36:20', '2024-10-08 10:36:20', '2025-10-08 12:36:20'),
('605254fbe7ca77bb8e8288b37d6a86718e244693edbea417e970cfd00d4ddfd0b52c0d8785584078', 4, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-20 14:09:29', '2024-09-20 14:09:29', '2025-09-20 16:09:29'),
('631366e4b24a16e8657ba9792e48ac260b2233b2c81c76f4845d98fe8bf9cb5e4d22f4535461a5d1', 9, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2025-12-23 06:40:22', '2025-12-23 06:40:22', '2026-12-23 07:40:22'),
('6326c7dfd992bfb07d03ce56f8e5e4a3e6274fc0abea358edd469ca755ea32ae12a289e8d4c0f177', 7, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2025-12-24 19:53:02', '2025-12-24 19:53:02', '2026-12-24 20:53:02'),
('67cfe991db5bb243d8a07c8e964fece347ca3d4b45c9c012b8f90d4f1527d1149538e35790abeb84', 2, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-20 09:23:58', '2024-09-20 09:23:58', '2025-09-20 11:23:58'),
('683a7c26830f6fc7d87cc88c960a034eb047fca10c2b9aedaf25d34446cb214f243d43fb3838554f', 4, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-27 08:35:46', '2024-09-27 08:35:46', '2025-09-27 10:35:46'),
('6970509354ae6a8989fdff26472b2404df494396f09742391dfa18c23b1b74ef4e204263e75ce4f4', 2, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-20 09:38:23', '2024-09-20 09:38:23', '2025-09-20 11:38:23'),
('6af9aeb38c187430f19fd3df8ad7bc82e2127266ee41df875913a023ce5d5b57da18f7af0e61331e', 4, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-21 09:40:50', '2024-09-21 09:40:50', '2025-09-21 11:40:50'),
('6f0f1b819e32ecbdfc4dfe082dc4e3d7517195a67e372dc91969e673f1e220d293346c082728078c', 2, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-20 09:29:42', '2024-09-20 09:29:42', '2025-09-20 11:29:42'),
('701376dedab0493fabe9af1bea7263bb94d349ff759398b2c4ceab35071246e1bde63ab7e2ce76b9', 2, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-10-08 10:15:49', '2024-10-08 10:15:49', '2025-10-08 12:15:49'),
('70ec4bcef6f5a91fdb83e93f0bc2c09e293ad02e4da75969366761be970c8c22f745c09a68af5b73', 2, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-26 14:22:38', '2024-09-26 14:22:38', '2025-09-26 16:22:38'),
('73410d1c9fd3e050770ce73ba84607ca4dd151661e66704ee5cf8413808aeb43524d84fb6833af4d', 1, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-20 09:03:08', '2024-09-20 09:03:08', '2025-09-20 11:03:08'),
('7578275af12bd4226dfd2352f845a78eca8527abe95fd6eec45406ac8136473bc4c4931eb68de799', 2, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-20 09:30:44', '2024-09-20 09:30:44', '2025-09-20 11:30:44'),
('762d6c3511fc4f32a2bab921639f411b2399cb3b5f4521177760d100a46716a515c7bf3074560f4a', 2, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-10-08 10:41:38', '2024-10-08 10:41:38', '2025-10-08 12:41:38'),
('77236a7563eb2f717abbb7cb1d4b60e38d4cbd5fffb74f28b58e1262d0fdea66c190828e0fa6baf3', 2, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-26 08:23:51', '2024-09-26 08:23:51', '2025-09-26 10:23:51'),
('7a1695b81088d1bd46485a44d348d55e0b981ee2b40911f72056fc0b2ce0ff13ce9fa01eaae95b7f', 2, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-28 12:03:15', '2024-09-28 12:03:15', '2025-09-28 14:03:15'),
('7b960bf86c9580fdd65662f03c4b1545367e3dfe360da2676a4a1e2853638c534b8564f13e392f2b', 2, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-20 09:34:23', '2024-09-20 09:34:23', '2025-09-20 11:34:23'),
('7c928650a97e322fbcd67427360528dea2a5b870dd0187c5afc5cc842391277b44bc873f5c9c792b', 2, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-20 09:42:40', '2024-09-20 09:42:40', '2025-09-20 11:42:40'),
('7d237199f59271b899595b10e8a5a2b564005a4d600ce9ea8cfc35b70e97e46cceda19c73df1f658', 4, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-27 08:35:27', '2024-09-27 08:35:27', '2025-09-27 10:35:27'),
('7e42b368b47b1d90aa88ebbc7d88164499bcc2de2e29f6cb177bf157deed43fa8413b3f86ad34197', 7, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2025-12-22 17:28:11', '2025-12-22 17:28:11', '2026-12-22 18:28:11'),
('7e75ff598030f0297cc1499045943d67190b94e1dcf5aa77e7d12bc3412f6475783b462d6f5b7af7', 2, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-26 14:29:39', '2024-09-26 14:29:39', '2025-09-26 16:29:39'),
('7e93c090c2531273f38fd47d03c9716eeeb185ddd2ba5472265dc2e8962ae48d29ea1d922ffb37df', 2, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-27 07:23:10', '2024-09-27 07:23:10', '2025-09-27 09:23:10'),
('7ec24510f38727810743bbf568f28e14fc656ea2fe8917076f0c863898ea76bef6a7d6513009eb02', 2, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-28 11:25:44', '2024-09-28 11:25:44', '2025-09-28 13:25:44'),
('81d1531083ab8e4d2767b8b4d33d5933feaa6028b6ee1b8e568934ec68aee481efcad83ec0bb9e7b', 2, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-25 15:07:55', '2024-09-25 15:07:55', '2025-09-25 17:07:55'),
('83838568c979a205494e2825fa411284835275e5daea6af6c012a748fc22a65469b28a23bf9965e7', 4, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-20 14:40:23', '2024-09-20 14:40:23', '2025-09-20 16:40:23'),
('8a3cbc86bd93d2f7da661d3ce4f0dbea6b4d48987fa7016c6c057c1fe4904db107165ab3c054f6f9', 2, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-27 07:16:26', '2024-09-27 07:16:26', '2025-09-27 09:16:26'),
('8aa339dae8d7e023d03135209129a5d1537a5c56f9e6d02ab572b85e953a04b0b550eec159fba332', 4, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-20 07:06:06', '2024-09-20 07:06:06', '2025-09-20 09:06:06'),
('8d1ae11546f02a9288d6d3cf69ab64534fde3ca4d5a7ece9870c741dcaf5f98ee1ea08da5dba6218', 2, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-28 12:53:38', '2024-09-28 12:53:38', '2025-09-28 14:53:38'),
('8d75a36f4616521aac386dbaa85b4230cdd83d8dda1ec3eef643e0af823c89abdc1d331c5d6d8f7b', 2, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-26 14:29:38', '2024-09-26 14:29:38', '2025-09-26 16:29:38'),
('8ebdb824c130f9b3ff0b998a258962725a691578a29465445b7b117aef35c0cf0920fc0e79dc68e7', 4, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-21 06:24:10', '2024-09-21 06:24:10', '2025-09-21 08:24:10'),
('8eefedb8d12032f67fa2e7fe4ac3a381d168dc4635ec61c8b0fdf091cf45c21b0833e8eb2575939a', 2, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-25 15:55:49', '2024-09-25 15:55:49', '2025-09-25 17:55:49'),
('8fd6bff7aacfefc0db577275acaadc9ffa601b14ff6f9730add6873e2a7a4e5892af7301d8669e1c', 2, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-20 09:37:33', '2024-09-20 09:37:33', '2025-09-20 11:37:33'),
('92c7bca3f28d14f37744108c96b264c377d5b377ac36f4e07c7f2e7c4c627c8e3640022132226237', 3, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2025-12-19 07:28:38', '2025-12-19 07:28:38', '2026-12-19 08:28:38'),
('93b1ded3bab45c6e58ea3868e65e9cf0afb67f8ae175ae0c0071cc849ba58a9a4fc4f1ce298a2c6a', 1, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-20 09:05:12', '2024-09-20 09:05:12', '2025-09-20 11:05:12'),
('95b3ee74bdcbd3c110a029fdb6f8c7f4a082a6535e6036341adec373021822c40efc0ac7cae96bdc', 2, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-25 15:59:34', '2024-09-25 15:59:34', '2025-09-25 17:59:34'),
('9625de1271bad5e9e7f59e0954c467ebabc54cc9c56848cc5ace93a1bf379d340697126edbf14717', 6, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2025-12-23 12:38:05', '2025-12-23 12:38:05', '2026-12-23 13:38:05'),
('967a56a178335b65e0abc151ddb10aa8800ae4ccaf207efca14ad0e8c486d60443114c83ca22d715', 3, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2025-04-15 15:08:15', '2025-04-15 15:08:15', '2026-04-15 17:08:15'),
('990eee89ae34dc17dde5fc55e8dfaa6aa35e3e6fcf3d0e41433971054a4e4000e70a0fc8ddbb5ecb', 3, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2025-12-19 08:15:28', '2025-12-19 08:15:28', '2026-12-19 09:15:28'),
('9df5426bf7235fbdfb8cd0d8d9febb466cdde5ddcf25b46bca6c2fd58762f6d19fb0a019141522a0', 4, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-10-01 15:27:19', '2024-10-01 15:27:19', '2025-10-01 17:27:19'),
('9fedfb96711d12818f732faf07bdd8d1fdc37babae7a99cbb7eec817f1c26972a4e1fc41a833e023', 2, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-28 13:16:33', '2024-09-28 13:16:33', '2025-09-28 15:16:33'),
('a412e6c4e3f3727f825a7fed9dac3ce18c4d9c83bd9baa92d37f29c21588e93cf6aec427bce36b3a', 9, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2025-12-22 10:03:52', '2025-12-22 10:03:52', '2026-12-22 11:03:52'),
('a5e82f0d4f4bf7315df02a0ac6a0d26aca8fb46316b0be042f610db8b4787763032d00cfb8bd8f36', 2, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-26 14:01:21', '2024-09-26 14:01:21', '2025-09-26 16:01:21'),
('a736f81e8dea834b169f52e5eff06d85bd5e967fcaea440694b05ab6d3b22f24d75573dc20d5192e', 2, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-27 12:06:17', '2024-09-27 12:06:17', '2025-09-27 14:06:17'),
('a7924334bc37ea349902406f505f954d7a4acd9a14c85d68ff74edefdccf799d5ac3dcda2b8c609e', 2, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-27 07:29:35', '2024-09-27 07:29:35', '2025-09-27 09:29:35'),
('a86b7cb392b53580064df4bf0dcb0a7628fbe4549c8409c0ef56c0b416dd75339c19b4446d7f3393', 7, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2025-12-22 18:17:55', '2025-12-22 18:17:55', '2026-12-22 19:17:55'),
('a8d5000ed47653f01945a6483ed9098d25d152fd21a51786c8f6fb60e3fc1ad5da6a4113ff97ade9', 2, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-26 13:04:10', '2024-09-26 13:04:10', '2025-09-26 15:04:10'),
('aa37560fd6fe6ac1a8f28067e88c208323e3577e9353ea45664ebc93882733fb7981955514e2cc04', 3, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2025-04-15 14:58:10', '2025-04-15 14:58:10', '2026-04-15 16:58:10'),
('abb8a08f4a64f464030218ee6d1b5aeb76d63f577916ecdaa50e262280ae5d8012e9e9b66fa6ee9e', 3, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-27 11:37:06', '2024-09-27 11:37:06', '2025-09-27 13:37:06'),
('ad594355c3905c4fff7656473157c4418a128fe3bbd356961ce22851aa6bf5c1e1942e8b77552e08', 2, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-26 12:22:36', '2024-09-26 12:22:36', '2025-09-26 14:22:36'),
('ad944897b861ceb3b1e663c863d64e3f4e1c79c09fd49cef31a5a638117b1ba8d19192ca6b917c65', 2, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-10-08 11:37:03', '2024-10-08 11:37:03', '2025-10-08 13:37:03'),
('af784d536af16caf8218bf5778b4e7f0970d7ddf1e94c1e909f0ba6532dac3b58a3f4571af8e5461', 2, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-26 11:50:43', '2024-09-26 11:50:43', '2025-09-26 13:50:43'),
('b0626ef54bdd32338075addbc0201e50305cb03b0c9ea194a7dad958cb2e0417b2ca38088ede77b4', 4, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-12-16 11:53:27', '2024-12-16 11:53:27', '2025-12-16 12:53:27'),
('b2e1a95713e6b24d3c3a3b02e5208ced7cd0116387d962d0c78e7d89bb7911b1c14bf6c85fd3e040', 2, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-25 16:04:05', '2024-09-25 16:04:05', '2025-09-25 18:04:05'),
('b71e91072547e0d6b78ec71e660451ebad9f1c71d1bc3a2726f52529a8081413c95fa4ab5fcf7f73', 3, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2025-12-19 08:32:51', '2025-12-19 08:32:51', '2026-12-19 09:32:51'),
('b7cb12b1a5888f4dcb91dcfae490120e2e903b9f14611fce0fa4233cbe372065d4f1bfcadeffba1a', 2, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-27 08:12:28', '2024-09-27 08:12:28', '2025-09-27 10:12:28'),
('b84954714741aa68a421d1306aa1c0b84dd7d0cb30056823beec3ce3fd0cdfa732e97d2f607da410', 2, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-20 09:28:35', '2024-09-20 09:28:35', '2025-09-20 11:28:35'),
('b9df46587285a1be9297d88bfa1cd73c6e3a0f8b980ce32d5adaf7e588c1d46a9c6c8d3d5c6bd4cf', 4, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-12-09 09:29:35', '2024-12-09 09:29:35', '2025-12-09 10:29:35'),
('bbfb9a80648bd338d50af946c528cc0d696286db6da5ac027a0e82b5de7a69a6d3b37cd184e4d4c0', 2, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-27 12:30:53', '2024-09-27 12:30:53', '2025-09-27 14:30:53'),
('bc81f2ce9a6e10ea0b8565430da0dcbbff025a941dec3da9f54e04038f6b30420a32931a54a46bbc', 2, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-25 15:04:30', '2024-09-25 15:04:30', '2025-09-25 17:04:30'),
('bef380c35e66f103fa3763f4e07c6db3739afa8d16ceabb28432170c68a7729ed4700981c4f033bc', 3, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2025-04-15 09:38:03', '2025-04-15 09:38:03', '2026-04-15 11:38:03'),
('c07baa0161315057cfe30f2c5ff59bf07517f692e0e1bd85dc623684844353d3805360a9595a2011', 3, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2025-04-21 08:11:56', '2025-04-21 08:11:56', '2026-04-21 10:11:56'),
('c11947323809d4154fc7acfffa12f4452b3ec3b16c0aabcd44762984cd8247ba467105b6c78484bc', 2, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-26 10:04:45', '2024-09-26 10:04:45', '2025-09-26 12:04:45'),
('c12c646937baaec663056c1bace1d7dedb18ad1bc5960062a3ac3554dc720cfc2feb0631fc0f4b1e', 3, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-27 11:43:36', '2024-09-27 11:43:36', '2025-09-27 13:43:36'),
('c1769eab0be7bb0cce34a55f098713043f15cb8872f7a865d9280b9eb8a673fab159c7953d88a2dd', 4, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-25 15:22:15', '2024-09-25 15:22:15', '2025-09-25 17:22:15'),
('c30838cbb33d0489257d32b2c1c5aec202a9eee8ec4ba9d534e10750a311212e9be3eef784462296', 4, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-26 16:00:14', '2024-09-26 16:00:14', '2025-09-26 18:00:14'),
('c477965712ab7acdfb9e4700f25127e7a08899f3f6ccb1353f8fe086321fafe05ea6cd3cf2f86baa', 7, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2025-12-22 17:29:37', '2025-12-22 17:29:37', '2026-12-22 18:29:37'),
('c6be522bb2a1a105e65003845a342af88c23d78892f2550aceb0da511ce524d8189132bf31fc19e6', 4, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-20 10:38:33', '2024-09-20 10:38:33', '2025-09-20 12:38:33'),
('c7acb4e352cea89ff4f853bd43ca07dcb31aaf06d031811f901f07874ee49a38436b98d92c90a845', 1, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 1, '2024-09-20 09:18:57', '2024-09-20 09:18:57', '2025-09-20 11:18:57'),
('c7e5144d013c6cbdd47fa37d3b19286e5a84f49b2e4e2ca65966d6cb96373b10a64fb46feecf4fa1', 3, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-20 07:13:09', '2024-09-20 07:13:09', '2025-09-20 09:13:09'),
('c8925ee09e191de2656db3037790c3c0edd99c38ee766b13b4c27e55a848c6630c0cfdd0e3d64856', 2, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-26 08:11:59', '2024-09-26 08:11:59', '2025-09-26 10:11:59'),
('c8fae40aeae22742a5cb8497aa9c4d62545a3d600b057d9ea576703db140a7093736b9230164e2bb', 4, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-20 10:28:41', '2024-09-20 10:28:41', '2025-09-20 12:28:41'),
('cb3a48abd55311b9664d0b22249aa5b7bc19c90126496f1b8ed6d6d965df1de321a37470318ed20a', 2, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-20 09:36:32', '2024-09-20 09:36:32', '2025-09-20 11:36:32'),
('cb588a166d601114e1c26f86270206ef7897e3b9124c17e4f20914e2fe622f84d3f96c6b75c9d087', 2, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-27 15:35:43', '2024-09-27 15:35:43', '2025-09-27 17:35:43'),
('cc1ad24f2321dbc049a6924146610667bedd382369374cab5ca1b14f98f16281eb6721988604b9b5', 2, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-26 13:34:59', '2024-09-26 13:34:59', '2025-09-26 15:34:59'),
('cf45c158d95d2151cc1fd04cb631c47e96b4db66f7df16abe1ef976d2dac9edefa98bcec6ebdf0b8', 2, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-27 13:14:43', '2024-09-27 13:14:43', '2025-09-27 15:14:43'),
('cf7a4d0619a4d4c3f3c6a390b6357578ccd06596ed7fd76126f2916477fae45fed438470a55ca6e9', 3, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2025-12-18 14:29:26', '2025-12-18 14:29:26', '2026-12-18 15:29:26'),
('d18458dee4e76c9f1118a8b96fe10ec4cbd3f70712dfc142b36591baac01a1f8287964ff52d0d0ab', 4, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-28 07:32:29', '2024-09-28 07:32:29', '2025-09-28 09:32:29'),
('d4f95198be7379107bcb576d0c016d17a6c671837305345eaab55130998144e66305f6d178f4b1fc', 4, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-27 12:10:43', '2024-09-27 12:10:43', '2025-09-27 14:10:43'),
('d6a50e6b83760a61a194c7440af2fb8e34604d1140c54b60514bf3f59db1a6d3d52c4dc16a33b77e', 2, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-26 09:49:12', '2024-09-26 09:49:12', '2025-09-26 11:49:12'),
('d81a192bf4449dfbda5e0926020097746bad1dbeb7caf54fc01aa723031178d55d73285a9d794d92', 4, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-21 12:30:48', '2024-09-21 12:30:48', '2025-09-21 14:30:48'),
('d85bf5f80ddbde88baf078f614ab8847e5a4c8830b4bc6e53ff36d9cc6dde23eb56df4b72f15d130', 4, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-21 09:37:53', '2024-09-21 09:37:53', '2025-09-21 11:37:53'),
('dbcd05c8c4fee80e573eaab58b7d9187bf0315ef95e13dc7920fbb11d737c9604f78440f2ad33958', 4, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-21 14:19:57', '2024-09-21 14:19:57', '2025-09-21 16:19:57'),
('dfc32d9e313e245f77083546bfde45e0c275a742e1d36b9dc59e3452b89ad337b85a685034f07873', 2, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-20 09:42:17', '2024-09-20 09:42:17', '2025-09-20 11:42:17'),
('e17624f712d41922761f9764da64568b64b4494b983b772a4829bef1a33c5fc44d267b588aa3a6fa', 2, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-26 16:24:33', '2024-09-26 16:24:33', '2025-09-26 18:24:33'),
('e25c4978c7652877116f911f64ab28ed6855a2ddba3c2fd6bd36ab6fdd21f158389ea410e624665d', 4, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-27 12:35:58', '2024-09-27 12:35:58', '2025-09-27 14:35:58'),
('e6bf419a276d915db80ff99a6093aeaf7213ddee3518e6595d529d7cce75eda3e3dec9cb2420eac4', 2, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-27 11:52:20', '2024-09-27 11:52:20', '2025-09-27 13:52:20'),
('e8ab3e8942bae95d27022e09ecbb8d19f5c1564ebdbac1e32056d9120558073d8f5b04c8bb9b9ee4', 4, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-11-14 12:53:04', '2024-11-14 12:53:04', '2025-11-14 13:53:04'),
('e9973e301f5c6899762486c96e317d0a2303e41b1d475dba8889650365ab19fe4d9007755ad7a769', 2, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-26 07:59:02', '2024-09-26 07:59:02', '2025-09-26 09:59:02'),
('eac2115e107ff7211ca9966803c7f29d0e65ed592c4d21ce1c349b8b92fa0e8c563a46b9c5e5159f', 2, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-26 06:46:40', '2024-09-26 06:46:40', '2025-09-26 08:46:40'),
('ec436a871b8facaec75b90f2bf6ccaf28af67e5fa2896bb9f989456ee49aff891a30ac03a5af84c9', 3, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2025-04-15 15:31:53', '2025-04-15 15:31:53', '2026-04-15 17:31:53'),
('f15812f9e5ed700b7780f043e6d07e9c21fa828cced1683f6bc437c0a829bfa8cf4ac5851743f40e', 2, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-20 09:30:08', '2024-09-20 09:30:08', '2025-09-20 11:30:08'),
('f1ca35709d3c33b308e1458a93a8d00161d8d7ac59baf5fd37d205392a6f1927a89182b90e22d632', 2, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-25 15:03:04', '2024-09-25 15:03:04', '2025-09-25 17:03:04'),
('f1e4f4974306f66749008650bce25da1be40641090ee489bbb3406cfe26c66b200179412a2a31513', 2, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-20 09:31:05', '2024-09-20 09:31:05', '2025-09-20 11:31:05'),
('f3157cd7dd5afd54f473a05c060e7b81279af728c97db4e7a3bb1ffa4e55d1249f4aa31ea0e19bb1', 4, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-22 11:24:56', '2024-09-22 11:24:56', '2025-09-22 13:24:56'),
('f339f9d3405bf3af571a07e2aab5199255c06935aaebf59e5df9b531453e0a800406427fe89ddc26', 2, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-27 15:56:09', '2024-09-27 15:56:09', '2025-09-27 17:56:09'),
('f600116ed5c92794adfff96933e85325ab5905085789ea101538465fa2fb52439f636554666c6931', 3, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-27 08:37:56', '2024-09-27 08:37:56', '2025-09-27 10:37:56'),
('f7b627734f825889aa7e6540e97bff0c655cca4ea8365c8356fe5c9ad9fbb30e82f609ea77aed6f6', 4, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-20 14:34:27', '2024-09-20 14:34:27', '2025-09-20 16:34:27'),
('f9e7771e6e148be364386d9b48479226ab2a60aefa8aa37e4029ffdd1ab75b37dbd611244a58e358', 2, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-28 06:43:48', '2024-09-28 06:43:48', '2025-09-28 08:43:48'),
('fbcea6051fcff8974575b93658709eb6c11bf608ab0ae69a9cbcdf1cc48f764ba5084d97689ed756', 3, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-26 15:52:56', '2024-09-26 15:52:56', '2025-09-26 17:52:56'),
('fdf79aced19502109af70433c0efd78623e4a259f507de7e2c69ec901033c60297ad26e599fe6b9a', 2, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-27 11:20:20', '2024-09-27 11:20:20', '2025-09-27 13:20:20'),
('fe19450a14f97c8e142209984c8052533edb6596b392508e1791afb52a1edee636a46af3c95284a7', 2, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-26 08:37:03', '2024-09-26 08:37:03', '2025-09-26 10:37:03'),
('ffec0d2044514888c71e23430cd192c7120ec1ee2660c1230851275d4a2ab9134c03d13f0a612b9c', 2, '98cdb6a0-4742-44ec-beef-1d693e063cf6', 'API Token', '[]', 0, '2024-09-28 11:24:19', '2024-09-28 11:24:19', '2025-09-28 13:24:19');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `client_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `scopes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `redirect` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_clients`
--

INSERT INTO `oauth_clients` (`id`, `user_id`, `name`, `secret`, `provider`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`) VALUES
('98cdb6a0-4742-44ec-beef-1d693e063cf6', NULL, 'FAS-HRMS Personal Access Client', 'yTD9q1D45TYgom1khI6won68NPBKRGOTt9zlfeih', NULL, 'http://localhost', 1, 0, 0, '2023-03-29 06:29:56', '2023-03-29 06:29:56'),
('98cdb6a0-8675-4421-a852-d3aa387249bf', NULL, 'FAS-HRMS Password Grant Client', 'dDsPKu75XHtyj5IEp4qgT26TqEIX8Z3U1eUfFMPa', 'users', 'http://localhost', 0, 1, 0, '2023-03-29 06:29:56', '2023-03-29 06:29:56');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` bigint UNSIGNED NOT NULL,
  `client_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_personal_access_clients`
--

INSERT INTO `oauth_personal_access_clients` (`id`, `client_id`, `created_at`, `updated_at`) VALUES
(1, '98cdb6a0-4742-44ec-beef-1d693e063cf6', '2023-03-29 06:29:56', '2023-03-29 06:29:56');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `paid_status`
--

CREATE TABLE `paid_status` (
  `id` int NOT NULL,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `paid_status`
--

INSERT INTO `paid_status` (`id`, `name`, `description`, `active`, `updated_by`, `created_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'paid', 'full payment', 1, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('emp02@gmail.com', 'SWJj6dFWTjIfR4jyOnM4zOBiofZe2WUqIcUj6dUcQrvVK3kv07MjBCssvAlN70Mx', '2023-05-14 05:45:43'),
('employee2@gmail.com', 'mE6FHdhduyLonpg0z7N45YNjwy1m4GX0PPhWBdvyE2IuK77H0txVA3N7pEZYpUhA', '2023-05-15 06:33:15'),
('dev@webdesign.qa', 'hEkkYhbnNa9x955CzBJ1xw3k49ld2wptfVzOuNmobPR1GE25pgYlJBODpWgg7j8m', '2023-05-17 06:48:36'),
('hr@firstassalam.sch.qa', 'cduhJACahorsyMM5fmcg75nUczm7qKEekYrwtixB4VbUXeAfNtCwEmLRL0p4DS16', '2023-05-18 05:20:03'),
('arifh20@gmail.com', 'lv0VusvxFzXEFnklooyEt940YZjDWcgRlUMmqVseN6hmOA9jFC9o7BEqiuvfJFBl', '2023-06-12 05:41:32'),
('employee2@gmail.com', 'PvKAvrbv6EaGuUcemYgB25MfN1dtW3W7GcixGLXvngglMVvVWpSQ3BiHR8xgMPvg', '2023-06-12 08:10:34'),
('hr@firstassalam.sch.qa', '7bQPakOt1rRbtWhgV4jVOcF5GWFFHIiYAxkwcHIrt75DcsWMx6x8jxiwexvoWb2q', '2023-08-16 07:49:33'),
('g.shodry@firstassalam.sch.qa', '5j5hgkXvVGx29lByx2maoyifoeQFk7dN78IVqPc0p21iQbwrRCtMbHxm7qdBKvar', '2023-08-27 15:25:17'),
('g.shodry@firstassalam.sch.qa', 'iAWtYc8stzyIZPxcudJOMub2uHrXFJSECe4pf4rE7fDiMerD0bWZ0QszpRpQVE3v', '2023-08-31 10:41:16'),
('g.shodry@firstassalam.sch.qa', 'Jtl0GTbo96hgRyNG4r7DPsW84jnVVWe3A1nE2V5yaHeLbMB7moRLSXG0SmPrlw7U', '2023-09-11 10:08:31'),
('test2@gmail.com', 'YCGnvUCT0FTl2giTEw9sk8DCzdMbA78xIntMbLAXQ5BQcUlMnaWUP2zZ8slxxcfJ', '2023-10-13 11:45:54'),
('j.jumana@firstassalam.sch.qa', 'MklG6DbdaWjtvvZOO72OvqBXCNWDdtCzJucCObv29FAjlRcbg9BRYcOJLB0BHCXf', '2023-11-02 08:05:48'),
('t.shameer@firstassalam.sch.qa', 'cGWfM9bC9ArrBi69ewJzhuZGN2mkuDuUNTCAZ5ep2bwszMVyojf5lSgOfCfv8vNh', '2023-11-05 08:31:45'),
('t.shameer@firstassalam.sch.qa', '8IqieA04eNW1kHlRAYv3v4a64pkNrZTzVPIYgIuUOvPeuKf3kCCmC8mADQFuJSVJ', '2023-11-05 08:33:08'),
('s.abouelela@firstassalam.sch.qa', '3VfBQfpFYo32BMixflI2L34rFUn3Cgw2HTQvN2XtiRq0dYkkflVfnGSGNADcedcs', '2023-11-05 12:34:24'),
('t.shameer@firstassalam.sch.qa', 'IAgy8uTdoF4FRimtLPmzF7S6q9R159lNIjn6MyCNtfPjNcknpO9oWjptfqzB6dAN', '2023-11-07 00:45:07'),
('t.shameer@firstassalam.sch.qa', 'LpUib6M6czvut1hBhmQoW7wBvTUTdXo2ZgjpPXdbLNmCQPWjovS1Z1XaWSiowWlh', '2023-11-07 00:47:06'),
('g.shodry@firstassalam.sch.qa', 'U3hbPJt8Isl5PoBndoCrOquTGOc0rP2TqVROTxBmHjCYInzD3cWxLXG4FHQy7CUc', '2023-11-14 11:54:27'),
('s.arif@firstassalam.sch.qa', 'wPXmxo4IikHT79JQdBTpQ0Of2sS0niZ89BcFQzOTsmtYkyrkUg5eDgDMBArEUx6r', '2023-11-14 15:17:30'),
('s.arif@firstassalam.sch.qa', 'moRzGw55SMhXdah5nHxZVFOnY3WaOw4jLukeniDMXSsjYcrqthGGJUZzKVRgJ6Ri', '2023-11-14 15:27:15'),
('s.arif@firstassalam.sch.qa', '2XZ50uYUO8mlsZC3quc7ScaoCTqpDW5dA3asc3tqqN0RlKQlEWVeq88Uk0qg0Tm0', '2023-11-22 15:30:52'),
('waseem.m@firstassalam.sch.qa', 'hPOHxnEbRbwDUwyk78QZ5QIOU6S0fiNtjXGO8uBVOvxG7h2d0VG3DemE90j495rn', '2023-12-01 19:41:41'),
('sankarvp.insasoft@gmail.com', 'L3BvuLKRljauQMeR2wzKuJb4ukXOmjOGC5wq197W9PrMTJLI0401A8pW6YtkORKm', '2023-12-04 12:11:23'),
('rameshkumar2007.rad@gmail.com', '53EGbsbOSeQjsT1ZT3xZ7U7dcuP9MrqVe5th6HfVqo4fQ0lWrS4OdNWH8DcGs6dA', '2024-09-13 11:24:48'),
('rameshkumar2007.rad@gmail.com', 'tAKnQ5CyFq9YKSIiMR7NqDwkEuE3LedwvXPAzelTKO87UZjxyE5StnIr3Oewibr7', '2024-09-13 11:33:19'),
('aaa@insasoft.com', 'uDpVAEoFRi6TrjPO40L2iviOnFxnZ4TOy08kQ2yuKQS3PCaDo9aIvaNF6WMOaHLA', '2024-09-15 08:30:28'),
('aaa@insasoft.com', 'uU0XzOiQR6rkKSzYpo1evUcpMsoZphdh8IZsELYdHQrwooe7ZSrgsbI47cHSGrqV', '2024-09-17 16:54:18'),
('aaa@insasoft.com', 'MlpjyKSASZWg91Z5b2JpgUZ1LhSiJoBs1nZTKCttJoAw1zS5dCZJ4roG6kmL02pa', '2024-09-17 16:54:36'),
('aaa@insasoft.com', 'ZQFji5pFIeXy7eRRhrB524HryZSpqyBwuOyH51DNHqimqLCG2Lj30lxZyVk4aLVb', '2024-09-17 16:56:08'),
('saurav.insasoft@gmail.com', 'wLxwHOOau302jq4jYI2sNt2wOPZKASalTh1xl1uYsk9lBCYKjZ33BDfApOBDJAma', '2024-09-17 16:59:26'),
('saurav.insasoft@gmail.com', 'LTZI7RIpj5SqSgcdqs6q8Wp9YhvaMBgwPVLV9sDSZbLb8vHcTaEg05Dks7uhRCU8', '2024-09-17 17:00:18'),
('saurav.insasoft@gmail.com', 'mAaAjlened1M8uD7EFgWE43rpU8il5FTPv70toWK706pZbp5J8NoZJ8yBoMw2tFQ', '2024-09-17 17:00:46'),
('aaa@insasoft.com', 'ClhfS3UBdyEegNhDzsJxT4B4ZJ5IMpBCuYnVpwAaqu9cczuUaPMwxGdzCh0rQGS1', '2024-09-17 17:13:14'),
('aaa@insasoft.com', 'TPIdFcuPMYA2prBLjZzsYnceD6I2rEQrjLGh1sAwUoQQQeP3NeN7sk8g20SiV5Tu', '2024-09-17 17:13:48');

-- --------------------------------------------------------

--
-- Table structure for table `payment_deduction_type`
--

CREATE TABLE `payment_deduction_type` (
  `id` int NOT NULL,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_deduction_type`
--

INSERT INTO `payment_deduction_type` (`id`, `name`, `description`, `active`, `updated_by`, `created_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Unpaid', 'Unpaid', 1, NULL, NULL, NULL, NULL, NULL),
(2, 'Disciplinary', 'Disciplinary', 1, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `performance_reviews`
--

CREATE TABLE `performance_reviews` (
  `id` bigint UNSIGNED NOT NULL,
  `performance_review` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `performance_reviews`
--

INSERT INTO `performance_reviews` (`id`, `performance_review`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Quality and accuracy of work.', 1, '2024-01-24 11:10:22', '2024-01-24 11:16:43'),
(2, 'Job Knowledge and Ability', 1, '2024-01-24 11:19:51', '2024-01-24 11:19:51'),
(3, 'Efficiency', 1, '2024-01-24 11:20:03', '2024-01-24 11:20:03');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(75) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(75) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'create-employee', 'web', '2023-03-24 06:41:34', '2023-03-24 06:41:34'),
(2, 'edit-employee', 'web', '2023-03-24 06:41:34', '2023-03-24 06:41:34'),
(3, 'delete-employee', 'web', '2023-03-24 06:41:34', '2023-03-24 06:41:34'),
(4, 'master', 'web', '2023-03-24 06:41:34', '2023-03-24 06:41:34'),
(5, 'show-forms', 'web', '2023-03-24 06:41:34', '2023-03-24 06:41:34'),
(6, 'profile-update', 'web', '2023-03-24 06:41:34', '2023-03-24 06:41:34'),
(7, 'approve-leave', 'web', '2023-03-24 06:41:34', '2023-03-24 06:41:34'),
(8, 'update_employee_status', 'web', '2023-03-24 06:41:34', '2023-03-24 06:41:34'),
(9, 'employee_link', 'web', '2023-03-24 06:41:34', '2023-03-24 06:41:34'),
(10, 'view_payroll_basics', 'web', '2023-03-24 06:41:34', '2023-03-24 06:41:34'),
(11, 'view_attachments', 'web', '2023-03-24 06:41:34', '2023-03-24 06:41:34'),
(12, 'payroll_module', 'web', '2023-03-24 06:41:34', '2023-03-24 06:41:34'),
(13, 'attendance_module', 'web', '2023-03-24 06:41:34', '2023-03-24 06:41:34'),
(14, 'settings_module', 'web', '2023-03-24 06:41:34', '2023-03-24 06:41:34');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(75) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pips`
--

CREATE TABLE `pips` (
  `id` bigint UNSIGNED NOT NULL,
  `employee_id` bigint UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `staff_member` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `area_of_concern` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `Observations` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `improment_goals` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `management_support` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `activity` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `check_point_date` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type_of_follow_up` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `progress_expected` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pip_status` tinyint DEFAULT NULL,
  `employee_ackn` tinyint NOT NULL,
  `principal_ackn` tinyint NOT NULL,
  `employee_date` date NOT NULL,
  `principal_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pips`
--

INSERT INTO `pips` (`id`, `employee_id`, `date`, `staff_member`, `area_of_concern`, `Observations`, `improment_goals`, `management_support`, `activity`, `check_point_date`, `type_of_follow_up`, `progress_expected`, `notes`, `pip_status`, `employee_ackn`, `principal_ackn`, `employee_date`, `principal_date`, `created_at`, `updated_at`) VALUES
(1, 2, '2024-03-14', NULL, 'Very Good perfomance', 'Good', '[\"Test Goal\",\"Test Goal1\",\"Test Goal 3\"]', '[\"Test management\",\"Test management1\",\"Test management3\"]', '[\"Test Activity1\",\"Test Activity2\",null]', '[\"2024-08-30\",\"2024-08-30\",null]', '[\"MEETING\",\"MEETING\",null]', '[\"Test\",\"Test\",null]', '[\"Test\",\"Test\",null]', NULL, 1, 1, '2024-09-09', '2024-08-30', '2024-03-14 12:14:44', '2024-09-09 11:14:12'),
(2, 6, '2024-03-26', NULL, 'test', 'test', '[\"test\",null,null]', '[\"test\",null,null]', '[\"test\",null,null]', '[\"2024-03-26\",null,null]', '[null,null,null]', '[\"test\",null,null]', '[\"test\",null,null]', 0, 0, 1, '2024-04-29', '2024-04-29', '2024-03-26 08:01:53', '2024-04-29 10:45:44'),
(3, 5, '2024-05-09', NULL, NULL, NULL, '[null,null,null]', '[null,null,null]', '[null,null,null]', '[\"2024-04-30\",\"2024-05-10\",\"2024-04-06\"]', '[\"MEETING\",\"CALL\",\"Email\"]', '[null,null,null]', '[null,null,null]', 0, 0, 1, '2024-04-29', '2024-04-29', '2024-04-29 10:41:36', '2024-04-29 10:43:28'),
(4, 7, '2024-05-03', NULL, NULL, NULL, '[null,null,null]', '[null,null,null]', '[null,null,null]', '[null,null,null]', '[null,null,null]', '[null,null,null]', '[null,null,null]', 1, 0, 1, '2024-05-03', '2024-05-03', '2024-05-03 08:31:59', '2024-05-03 10:01:49'),
(5, 83, '2024-09-09', 'Saurav R', 'Test', 'test', '[\"Test\",null,null]', '[\"Test\",null,null]', '[\"Test Activity1\",null,null]', '[\"2024-09-09\",null,null]', '[\"Email\",null,null]', '[\"Test\",null,null]', '[\"Test\",null,null]', 1, 1, 1, '2024-09-09', '2024-09-09', '2024-09-09 12:39:15', '2024-09-09 12:40:41');

-- --------------------------------------------------------

--
-- Table structure for table `pip_appraisal_reports`
--

CREATE TABLE `pip_appraisal_reports` (
  `id` bigint UNSIGNED NOT NULL,
  `employee_id` int NOT NULL,
  `evaluation_date` date NOT NULL,
  `evaluation_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `appraisal_data` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hod_rating` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hod_rating_avg_compt` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hod_rating_avg_chart` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `principal_rating` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `principal_rating_avg_compt` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `principal_rating_avg_chart` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `future_targets_data` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `future_target_review_date` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `future_targets_recommended` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `training_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `training_due_date` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `training_recommended` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `employee_comments` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hod_comments` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `principal_comments` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pip_appraisal_reports`
--

INSERT INTO `pip_appraisal_reports` (`id`, `employee_id`, `evaluation_date`, `evaluation_type`, `appraisal_data`, `hod_rating`, `hod_rating_avg_compt`, `hod_rating_avg_chart`, `principal_rating`, `principal_rating_avg_compt`, `principal_rating_avg_chart`, `future_targets_data`, `future_target_review_date`, `future_targets_recommended`, `training_title`, `training_due_date`, `training_recommended`, `employee_comments`, `hod_comments`, `principal_comments`, `status`, `created_at`, `updated_at`) VALUES
(1, 7, '2024-04-03', 'Probationary', '[\"22\",\"23\",\"24\",\"25\",\"26\",\"27\",\"28\",\"29\",\"30\",\"31\",\"32\",\"33\",\"34\",\"35\",\"36\",\"37\",\"38\",\"39\",\"40\",\"41\",\"42\",\"43\",\"44\",\"45\"]', '[\"3\",\"3\",\"3\",\"3\",null,null,null,null,null,null,null,null,null,null,null,null,\"3\",\"3\",\"2\",\"4\",null,\"3\",null,null]', '1.125', '1.125', 'null', '0', '0', '[\"Improve stuff\",\"best controller\",null]', '[\"2024-05-03\",\"2024-05-03\",null]', '[\"HOD\",\"HOD\",\"Choose...\"]', '[\"Communtication skill\",null,null]', '[\"2024-05-03\",null,null]', '[\"HOD\",\"Choose...\",\"Choose...\"]', NULL, NULL, NULL, 0, '2024-05-03 10:09:13', '2024-05-03 10:20:03');

-- --------------------------------------------------------

--
-- Table structure for table `ppr_forms`
--

CREATE TABLE `ppr_forms` (
  `id` bigint UNSIGNED NOT NULL,
  `employee_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `review_period` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `review_date` date NOT NULL,
  `objectives` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discussion_points` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `performance_review` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `performance_review_rating` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `performance_review_feedback` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `require_improvement` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `areas_improvement` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `areas_discussion_points` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `work_environment` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `manager_action_points` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `over_all_perfamance` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `appointment_conformed` tinyint DEFAULT NULL,
  `no_conformed` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `extension_period` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `probatinary_review` tinyint NOT NULL DEFAULT '0',
  `employee_ack` tinyint NOT NULL DEFAULT '0',
  `hod_ack` tinyint NOT NULL DEFAULT '0',
  `principla_ack` tinyint NOT NULL DEFAULT '0',
  `ack_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ppr_forms`
--

INSERT INTO `ppr_forms` (`id`, `employee_id`, `review_period`, `review_date`, `objectives`, `discussion_points`, `performance_review`, `performance_review_rating`, `performance_review_feedback`, `require_improvement`, `areas_improvement`, `areas_discussion_points`, `work_environment`, `manager_action_points`, `over_all_perfamance`, `appointment_conformed`, `no_conformed`, `extension_period`, `probatinary_review`, `employee_ack`, `hod_ack`, `principla_ack`, `ack_date`, `created_at`, `updated_at`) VALUES
(1, '2', '4', '2024-08-09', '[null,null,null]', '[null,null,null]', '[\"1\",\"2\",\"3\"]', '[\"3\",\"4\",\"3\"]', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, '3', 1, 1, 1, 0, '2024-08-28', '2024-04-29 10:35:43', '2024-09-09 11:15:55');

-- --------------------------------------------------------

--
-- Table structure for table `probationary_appraisals`
--

CREATE TABLE `probationary_appraisals` (
  `id` bigint UNSIGNED NOT NULL,
  `employee_id` int NOT NULL,
  `evaluation_date` date NOT NULL,
  `evaluation_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `evaluation_period` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `appraisal_data` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hod_rating` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hod_rating_avg_compt` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hod_rating_avg_chart` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `principal_rating` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `principal_rating_avg_compt` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `principal_rating_avg_chart` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `future_targets_data` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `future_target_review_date` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `future_targets_recommended` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `training_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `training_due_date` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `training_recommended` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `employee_comments` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hod_comments` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `principal_comments` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `relationship`
--

CREATE TABLE `relationship` (
  `id` int NOT NULL,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `relationship`
--

INSERT INTO `relationship` (`id`, `name`, `active`, `updated_by`, `created_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Uncle', 1, NULL, NULL, NULL, NULL, NULL),
(2, 'Aunty', 1, NULL, NULL, NULL, NULL, NULL),
(3, 'Wife', 1, NULL, NULL, NULL, NULL, NULL),
(4, 'Husband', 1, NULL, NULL, NULL, NULL, NULL),
(5, 'Father', 1, NULL, NULL, NULL, NULL, NULL),
(6, 'Mother', 1, NULL, NULL, NULL, NULL, NULL),
(7, 'Brother', 1, NULL, NULL, NULL, NULL, NULL),
(8, 'Sister', 1, NULL, NULL, NULL, NULL, NULL),
(9, 'Grandfather', 1, NULL, NULL, NULL, NULL, NULL),
(10, 'Grandmother', 1, NULL, NULL, NULL, NULL, NULL),
(11, 'Friend', 1, NULL, NULL, NULL, NULL, NULL),
(12, 'Neighbour', 1, NULL, NULL, NULL, NULL, NULL),
(13, 'Brother-in-law', 1, NULL, NULL, NULL, NULL, NULL),
(14, 'Sister-in-law', 1, NULL, NULL, NULL, NULL, NULL),
(15, 'Cousin', 1, NULL, NULL, NULL, NULL, NULL),
(16, 'Son', 1, NULL, NULL, NULL, NULL, NULL),
(17, 'Daughter', 1, NULL, NULL, NULL, NULL, NULL),
(18, 'Spouce', 1, NULL, NULL, NULL, NULL, NULL),
(19, 'Advisor', 1, NULL, NULL, NULL, NULL, NULL),
(20, 'Nephew', 1, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `relevant_degree`
--

CREATE TABLE `relevant_degree` (
  `id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `relevant_degree`
--

INSERT INTO `relevant_degree` (`id`, `name`, `description`, `active`, `updated_by`, `created_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Master Degree', 'MDEG', 1, NULL, NULL, NULL, NULL, NULL),
(2, 'Bachelor Degree', 'BDEG', 1, NULL, NULL, NULL, NULL, NULL),
(3, 'M.Phil', 'MPHL', 1, NULL, NULL, NULL, NULL, NULL),
(4, 'Doctorate', 'DCTR', 1, NULL, NULL, NULL, NULL, NULL),
(5, 'Diploma', 'DPLM', 1, NULL, NULL, NULL, NULL, NULL),
(6, 'High School', 'HSHL', 1, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `resign_applications`
--

CREATE TABLE `resign_applications` (
  `id` bigint UNSIGNED NOT NULL,
  `employee_id` int NOT NULL,
  `resign_type` tinyint NOT NULL DEFAULT '0' COMMENT '0: Normal, 1: Termination',
  `request_date` date NOT NULL,
  `join_date` date NOT NULL,
  `last_working_date` date NOT NULL,
  `reason` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notice_period` int NOT NULL,
  `notice_period_remarks` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` enum('Requested','Pending','Approved','Rejected') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Requested'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(75) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(75) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Super-Admin', 'web', '2023-03-24 07:41:34', '2023-03-24 07:41:34'),
(2, 'Admin', 'web', '2023-03-24 07:41:34', '2023-03-24 07:41:34'),
(3, 'Hr', 'web', '2023-03-24 07:41:34', '2023-03-24 07:41:34'),
(4, 'Employee', 'web', '2023-03-24 07:41:34', '2023-03-24 07:41:34'),
(5, 'Vp', 'web', '2023-04-24 11:07:09', '2023-04-24 11:07:09'),
(6, 'Principal', 'web', '2023-04-24 11:07:09', '2023-04-24 11:07:09'),
(7, 'Accounts', 'web', '2023-04-24 11:07:09', '2023-04-24 11:10:02'),
(8, 'Executive-Admin', 'web', '2023-03-24 12:11:34', '2023-03-24 12:11:34');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_links`
--

CREATE TABLE `role_has_links` (
  `id` int NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL,
  `link_id` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `role_has_links`
--

INSERT INTO `role_has_links` (`id`, `role_id`, `link_id`, `created_at`, `updated_at`) VALUES
(21, 1, 1, '2023-11-07 11:25:57', '2023-11-07 11:25:57'),
(22, 1, 2, '2023-11-07 11:25:57', '2023-11-07 11:25:57'),
(23, 1, 39, '2023-11-07 11:25:57', '2023-11-07 11:25:57'),
(24, 1, 40, '2023-11-07 11:25:57', '2023-11-07 11:25:57'),
(25, 1, 32, '2023-11-07 11:25:57', '2023-11-07 11:25:57'),
(26, 1, 6, '2023-11-07 11:25:57', '2023-11-07 11:25:57'),
(27, 1, 7, '2023-11-07 11:25:57', '2023-11-07 11:25:57'),
(28, 1, 8, '2023-11-07 11:25:57', '2023-11-07 11:25:57'),
(29, 1, 9, '2023-11-07 11:25:57', '2023-11-07 11:25:57'),
(30, 1, 10, '2023-11-07 11:25:57', '2023-11-07 11:25:57'),
(31, 1, 14, '2023-11-07 11:25:57', '2023-11-07 11:25:57'),
(32, 1, 15, '2023-11-07 11:25:57', '2023-11-07 11:25:57'),
(33, 1, 16, '2023-11-07 11:25:57', '2023-11-07 11:25:57'),
(34, 1, 17, '2023-11-07 11:25:57', '2023-11-07 11:25:57'),
(35, 1, 18, '2023-11-07 11:25:57', '2023-11-07 11:25:57'),
(36, 1, 19, '2023-11-07 11:25:57', '2023-11-07 11:25:57'),
(37, 1, 20, '2023-11-07 11:25:57', '2023-11-07 11:25:57'),
(38, 1, 44, '2023-11-07 11:25:57', '2023-11-07 11:25:57'),
(39, 1, 21, '2023-11-07 11:25:57', '2023-11-07 11:25:57'),
(40, 1, 22, '2023-11-07 11:25:57', '2023-11-07 11:25:57'),
(41, 1, 23, '2023-11-07 11:25:57', '2023-11-07 11:25:57'),
(42, 1, 24, '2023-11-07 11:25:57', '2023-11-07 11:25:57'),
(43, 1, 33, '2023-11-07 11:25:57', '2023-11-07 11:25:57'),
(44, 1, 34, '2023-11-07 11:25:57', '2023-11-07 11:25:57'),
(45, 1, 35, '2023-11-07 11:25:57', '2023-11-07 11:25:57'),
(46, 1, 36, '2023-11-07 11:25:57', '2023-11-07 11:25:57'),
(47, 1, 38, '2023-11-07 11:25:57', '2023-11-07 11:25:57'),
(48, 1, 41, '2023-11-07 11:25:57', '2023-11-07 11:25:57'),
(49, 1, 42, '2023-11-07 11:25:57', '2023-11-07 11:25:57'),
(50, 1, 43, '2023-11-07 11:25:57', '2023-11-07 11:25:57'),
(89, 7, 1, '2023-11-07 11:27:28', '2023-11-07 11:27:28'),
(90, 7, 2, '2023-11-07 11:27:28', '2023-11-07 11:27:28'),
(91, 7, 39, '2023-11-07 11:27:28', '2023-11-07 11:27:28'),
(92, 7, 40, '2023-11-07 11:27:28', '2023-11-07 11:27:28'),
(93, 7, 30, '2023-11-07 11:27:28', '2023-11-07 11:27:28'),
(94, 7, 32, '2023-11-07 11:27:28', '2023-11-07 11:27:28'),
(95, 7, 29, '2023-11-07 11:27:28', '2023-11-07 11:27:28'),
(96, 7, 33, '2023-11-07 11:27:28', '2023-11-07 11:27:28'),
(97, 7, 34, '2023-11-07 11:27:28', '2023-11-07 11:27:28'),
(98, 7, 35, '2023-11-07 11:27:28', '2023-11-07 11:27:28'),
(99, 7, 36, '2023-11-07 11:27:28', '2023-11-07 11:27:28'),
(100, 7, 38, '2023-11-07 11:27:28', '2023-11-07 11:27:28'),
(101, 2, 1, '2023-11-07 11:25:57', '2023-11-07 11:25:57'),
(124, 1, 47, '2023-11-16 12:24:20', '2023-11-16 12:24:20'),
(125, 1, 48, '2023-11-07 11:25:57', '2023-11-07 11:25:57'),
(140, 1, 49, '2023-11-16 12:24:20', '2023-11-16 12:24:20'),
(372, 1, 54, '2024-01-23 05:52:19', '2024-01-23 05:52:19'),
(373, 1, 56, '2023-11-07 11:25:57', '2023-11-07 11:25:57'),
(449, 6, 1, '2024-02-06 12:43:50', '2024-02-06 12:43:50'),
(450, 6, 2, '2024-02-06 12:43:50', '2024-02-06 12:43:50'),
(451, 6, 39, '2024-02-06 12:43:50', '2024-02-06 12:43:50'),
(452, 6, 40, '2024-02-06 12:43:50', '2024-02-06 12:43:50'),
(453, 6, 30, '2024-02-06 12:43:50', '2024-02-06 12:43:50'),
(454, 6, 3, '2024-02-06 12:43:50', '2024-02-06 12:43:50'),
(455, 6, 5, '2024-02-06 12:43:50', '2024-02-06 12:43:50'),
(456, 6, 32, '2024-02-06 12:43:50', '2024-02-06 12:43:50'),
(457, 6, 31, '2024-02-06 12:43:50', '2024-02-06 12:43:50'),
(458, 6, 50, '2024-02-06 12:43:50', '2024-02-06 12:43:50'),
(459, 6, 51, '2024-02-06 12:43:50', '2024-02-06 12:43:50'),
(460, 6, 52, '2024-02-06 12:43:50', '2024-02-06 12:43:50'),
(461, 6, 53, '2024-02-06 12:43:50', '2024-02-06 12:43:50'),
(462, 6, 57, '2024-02-06 12:43:50', '2024-02-06 12:43:50'),
(463, 6, 29, '2024-02-06 12:43:50', '2024-02-06 12:43:50'),
(464, 6, 33, '2024-02-06 12:43:50', '2024-02-06 12:43:50'),
(465, 6, 34, '2024-02-06 12:43:50', '2024-02-06 12:43:50'),
(466, 6, 35, '2024-02-06 12:43:50', '2024-02-06 12:43:50'),
(467, 6, 36, '2024-02-06 12:43:50', '2024-02-06 12:43:50'),
(468, 6, 38, '2024-02-06 12:43:50', '2024-02-06 12:43:50'),
(501, 1, 31, '2024-03-03 06:46:57', '2024-03-03 06:46:57'),
(502, 1, 50, '2024-03-03 06:46:57', '2024-03-03 06:46:57'),
(503, 1, 51, '2024-03-03 06:46:57', '2024-03-03 06:46:57'),
(504, 1, 52, '2024-03-03 06:46:57', '2024-03-03 06:46:57'),
(505, 1, 53, '2024-03-03 06:46:57', '2024-03-03 06:46:57'),
(506, 1, 57, '2024-03-03 06:46:57', '2024-03-03 06:46:57'),
(526, 1, 58, '2024-03-14 07:36:12', '2024-03-14 07:36:12'),
(527, 1, 59, '2024-03-14 07:36:12', '2024-03-14 07:36:12'),
(528, 8, 1, '2024-04-29 10:02:21', '2024-04-29 10:02:21'),
(529, 8, 2, '2024-04-29 10:02:21', '2024-04-29 10:02:21'),
(530, 8, 39, '2024-04-29 10:02:21', '2024-04-29 10:02:21'),
(531, 8, 40, '2024-04-29 10:02:21', '2024-04-29 10:02:21'),
(532, 8, 30, '2024-04-29 10:02:21', '2024-04-29 10:02:21'),
(533, 8, 3, '2024-04-29 10:02:21', '2024-04-29 10:02:21'),
(534, 8, 5, '2024-04-29 10:02:21', '2024-04-29 10:02:21'),
(535, 8, 32, '2024-04-29 10:02:21', '2024-04-29 10:02:21'),
(536, 8, 31, '2024-04-29 10:02:21', '2024-04-29 10:02:21'),
(537, 8, 50, '2024-04-29 10:02:21', '2024-04-29 10:02:21'),
(538, 8, 51, '2024-04-29 10:02:21', '2024-04-29 10:02:21'),
(539, 8, 52, '2024-04-29 10:02:21', '2024-04-29 10:02:21'),
(540, 8, 53, '2024-04-29 10:02:21', '2024-04-29 10:02:21'),
(541, 8, 57, '2024-04-29 10:02:21', '2024-04-29 10:02:21'),
(542, 8, 33, '2024-04-29 10:02:21', '2024-04-29 10:02:21'),
(543, 8, 34, '2024-04-29 10:02:21', '2024-04-29 10:02:21'),
(544, 8, 35, '2024-04-29 10:02:21', '2024-04-29 10:02:21'),
(545, 8, 36, '2024-04-29 10:02:21', '2024-04-29 10:02:21'),
(546, 8, 38, '2024-04-29 10:02:21', '2024-04-29 10:02:21'),
(547, 8, 45, '2024-04-29 10:02:21', '2024-04-29 10:02:21'),
(581, 5, 1, '2024-05-16 12:16:06', '2024-05-16 12:16:06'),
(582, 5, 2, '2024-05-16 12:16:06', '2024-05-16 12:16:06'),
(583, 5, 39, '2024-05-16 12:16:06', '2024-05-16 12:16:06'),
(584, 5, 40, '2024-05-16 12:16:06', '2024-05-16 12:16:06'),
(585, 5, 30, '2024-05-16 12:16:06', '2024-05-16 12:16:06'),
(586, 5, 3, '2024-05-16 12:16:06', '2024-05-16 12:16:06'),
(587, 5, 5, '2024-05-16 12:16:06', '2024-05-16 12:16:06'),
(588, 5, 31, '2024-05-16 12:16:06', '2024-05-16 12:16:06'),
(589, 5, 50, '2024-05-16 12:16:06', '2024-05-16 12:16:06'),
(590, 5, 51, '2024-05-16 12:16:06', '2024-05-16 12:16:06'),
(591, 5, 52, '2024-05-16 12:16:06', '2024-05-16 12:16:06'),
(592, 5, 53, '2024-05-16 12:16:06', '2024-05-16 12:16:06'),
(593, 5, 57, '2024-05-16 12:16:06', '2024-05-16 12:16:06'),
(594, 5, 33, '2024-05-16 12:16:06', '2024-05-16 12:16:06'),
(595, 5, 34, '2024-05-16 12:16:06', '2024-05-16 12:16:06'),
(596, 5, 35, '2024-05-16 12:16:06', '2024-05-16 12:16:06'),
(597, 5, 36, '2024-05-16 12:16:06', '2024-05-16 12:16:06'),
(598, 5, 38, '2024-05-16 12:16:06', '2024-05-16 12:16:06'),
(599, 5, 59, '2024-05-16 12:16:06', '2024-05-16 12:16:06'),
(694, 3, 1, '2025-12-24 05:26:50', '2025-12-24 05:26:50'),
(695, 3, 2, '2025-12-24 05:26:50', '2025-12-24 05:26:50'),
(696, 3, 39, '2025-12-24 05:26:50', '2025-12-24 05:26:50'),
(697, 3, 40, '2025-12-24 05:26:50', '2025-12-24 05:26:50'),
(698, 3, 30, '2025-12-24 05:26:50', '2025-12-24 05:26:50'),
(699, 3, 3, '2025-12-24 05:26:50', '2025-12-24 05:26:50'),
(700, 3, 5, '2025-12-24 05:26:50', '2025-12-24 05:26:50'),
(701, 3, 4, '2025-12-24 05:26:50', '2025-12-24 05:26:50'),
(702, 3, 32, '2025-12-24 05:26:50', '2025-12-24 05:26:50'),
(703, 3, 6, '2025-12-24 05:26:50', '2025-12-24 05:26:50'),
(704, 3, 8, '2025-12-24 05:26:50', '2025-12-24 05:26:50'),
(705, 3, 9, '2025-12-24 05:26:50', '2025-12-24 05:26:50'),
(706, 3, 10, '2025-12-24 05:26:50', '2025-12-24 05:26:50'),
(707, 3, 14, '2025-12-24 05:26:50', '2025-12-24 05:26:50'),
(708, 3, 61, '2025-12-24 05:26:50', '2025-12-24 05:26:50'),
(709, 3, 33, '2025-12-24 05:26:50', '2025-12-24 05:26:50'),
(710, 3, 34, '2025-12-24 05:26:50', '2025-12-24 05:26:50'),
(711, 3, 35, '2025-12-24 05:26:50', '2025-12-24 05:26:50'),
(712, 3, 36, '2025-12-24 05:26:50', '2025-12-24 05:26:50'),
(713, 3, 38, '2025-12-24 05:26:50', '2025-12-24 05:26:50'),
(714, 3, 45, '2025-12-24 05:26:50', '2025-12-24 05:26:50'),
(715, 3, 46, '2025-12-24 05:26:50', '2025-12-24 05:26:50'),
(716, 3, 41, '2025-12-24 05:26:50', '2025-12-24 05:26:50'),
(717, 3, 49, '2025-12-24 05:26:50', '2025-12-24 05:26:50'),
(718, 3, 47, '2025-12-24 05:26:50', '2025-12-24 05:26:50'),
(719, 1, 61, '2024-03-14 07:36:12', '2024-03-14 07:36:12');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(4, 1),
(5, 1),
(7, 1),
(9, 1),
(14, 1),
(5, 2),
(7, 2),
(9, 2),
(1, 3),
(2, 3),
(3, 3),
(4, 3),
(5, 3),
(6, 3),
(7, 3),
(8, 3),
(9, 3),
(10, 3),
(11, 3),
(12, 3),
(13, 3),
(5, 4),
(5, 5),
(7, 5),
(5, 6),
(7, 6),
(9, 6),
(5, 7),
(5, 8),
(7, 8);

-- --------------------------------------------------------

--
-- Table structure for table `scfs`
--

CREATE TABLE `scfs` (
  `id` bigint UNSIGNED NOT NULL,
  `scf_date` date NOT NULL,
  `concern_from_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `employee_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `staff_member` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scf_data` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scf_ans_data` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `raising_concern` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `suggestions_made` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `breif_description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `follow_up` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `comment` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_of_concern` date DEFAULT NULL,
  `slt_member` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slt_member_ack` tinyint DEFAULT NULL,
  `pip_required` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `scfs`
--

INSERT INTO `scfs` (`id`, `scf_date`, `concern_from_number`, `employee_id`, `staff_member`, `scf_data`, `scf_ans_data`, `raising_concern`, `suggestions_made`, `breif_description`, `follow_up`, `comment`, `date_of_concern`, `slt_member`, `slt_member_ack`, `pip_required`, `created_at`, `updated_at`) VALUES
(1, '2024-03-14', NULL, '2', NULL, '[\"1\",\"2\",\"3\",\"4\",\"5\"]', '[\"gk\",null,null,null,null]', 'Test', NULL, NULL, NULL, NULL, NULL, '20', 1, 1, '2024-03-14 12:14:15', '2024-09-11 10:09:04'),
(2, '2024-03-26', NULL, '6', NULL, '[\"1\",\"2\",\"3\",\"4\",\"5\"]', '[\"test\",\"test\",\"test\",\"test\",\"test\"]', 'test', 'test', 'test', 'test', 'test', '2024-03-26', '3', 1, 1, '2024-03-26 07:59:19', '2024-03-26 07:59:32'),
(3, '2024-04-29', NULL, '5', 'Lames Hossin', '[\"1\",\"2\",\"3\",\"4\",\"5\"]', '[null,null,null,null,null]', 'me', NULL, NULL, NULL, NULL, NULL, '20', 1, 1, '2024-04-29 10:40:56', '2024-04-29 10:40:56'),
(4, '2024-05-03', NULL, '7', 'Cilem Kol Mustu', '[\"1\",\"2\",\"3\",\"4\",\"5\"]', '[\"test\",null,null,null,null]', 'test', NULL, NULL, NULL, NULL, NULL, '64', 1, 1, '2024-05-03 08:31:27', '2024-05-03 08:31:27'),
(5, '2024-09-09', NULL, '83', 'Saurav R', '[\"1\",\"2\",\"3\",\"4\",\"5\"]', '[\"Test\",\"Test\",null,null,null]', 'Test', NULL, 'Test', NULL, 'Test', '2024-09-09', '20', 1, 1, '2024-09-09 12:37:33', '2024-09-09 12:37:33'),
(6, '2024-10-15', NULL, '63', 'Saurav R', '[\"1\",\"2\",\"3\",\"4\",\"5\"]', '[\"Test Concern\",null,null,null,null]', 'Test', NULL, NULL, NULL, NULL, NULL, '20', 1, 0, '2024-10-15 08:56:11', '2024-10-15 08:56:11');

-- --------------------------------------------------------

--
-- Table structure for table `scf_data`
--

CREATE TABLE `scf_data` (
  `id` bigint UNSIGNED NOT NULL,
  `scf` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `scf_data`
--

INSERT INTO `scf_data` (`id`, `scf`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Who else is aware of the situation?', 1, '2024-01-24 03:39:32', '2024-04-29 10:55:50'),
(2, 'What is the Concern?', 1, '2024-01-24 05:16:04', '2024-01-24 05:16:04'),
(3, 'When and where was this observed?', 1, '2024-01-24 05:16:51', '2024-01-24 05:16:51'),
(4, 'What was the response of the staff member?', 1, '2024-01-24 05:17:09', '2024-01-24 05:17:09'),
(5, 'Has the staff member acted upon what was decided?', 1, '2024-01-24 05:17:29', '2024-01-24 05:17:29');

-- --------------------------------------------------------

--
-- Table structure for table `school_events`
--

CREATE TABLE `school_events` (
  `id` int NOT NULL,
  `academic_year` int NOT NULL,
  `event_title` varchar(100) NOT NULL,
  `event_details` varchar(2000) NOT NULL,
  `event_from` date NOT NULL,
  `event_to` date NOT NULL,
  `event_type` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL COMMENT 'Full Day / Single Day Custom Timing / Holiday..etc',
  `event_time_from` datetime DEFAULT NULL,
  `event_time_to` datetime DEFAULT NULL,
  `applicable_to` tinyint NOT NULL DEFAULT '0',
  `bg_color` varchar(25) DEFAULT NULL,
  `created_by` int NOT NULL,
  `updated_by` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `school_events`
--

INSERT INTO `school_events` (`id`, `academic_year`, `event_title`, `event_details`, `event_from`, `event_to`, `event_type`, `event_time_from`, `event_time_to`, `applicable_to`, `bg_color`, `created_by`, `updated_by`, `created_at`, `updated_at`, `active`) VALUES
(8, 1, 'Qatar National Day', 'Official Government Holiday', '2023-12-17', '2023-12-18', 'Holiday', '2023-12-17 00:00:00', '2023-12-17 00:00:00', 0, '#ff3a6e', 3, 3, '2023-09-26 10:29:34', '2023-09-26 10:29:34', 1),
(9, 1, 'National Sports Day', 'Official Government Holiday', '2024-02-13', '2024-02-13', 'Holiday', '2024-02-13 00:00:00', '2024-02-13 00:00:00', 0, '#3ec9d6', 3, 3, '2023-09-26 10:32:02', '2023-09-26 10:32:02', 1),
(10, 1, 'Eid Al-Fitr', 'Official Government Holiday', '2024-04-10', '2024-04-18', 'Holiday', '2024-04-10 00:00:00', '2024-04-10 00:00:00', 0, '#55ce63', 3, 3, '2023-09-26 10:35:50', '2023-09-26 10:35:50', 1),
(14, 1, 'Summer Break', 'Summer Break', '2023-06-25', '2023-08-21', 'Full Day', '2023-06-25 00:00:00', '2023-06-25 00:00:00', 1, '#13be1e', 3, 3, '2023-11-07 07:29:37', '2023-11-07 07:29:37', 1),
(15, 2, 'Test Event', 'Test data', '2024-08-25', '2024-08-25', 'Full Day', '2024-08-25 10:00:00', '2024-08-25 10:00:00', 0, '#c19ab5', 3, 3, '2024-08-24 08:31:58', '2024-08-24 08:32:35', 1),
(17, 2, 'Test Event-02', 'test', '2024-08-26', '2024-08-26', 'Full Day', '2024-08-26 09:20:00', '2024-08-26 09:20:00', 0, '#006600', 3, 3, '2024-08-24 13:51:09', '2024-08-24 13:51:09', 1),
(19, 2, 'Test Event 3', 'Test Notification', '2024-08-27', '2024-08-31', 'Full Day', '2024-08-27 18:30:00', '2024-08-27 18:30:00', 0, '#0c0066', 3, 3, '2024-08-24 14:01:21', '2024-08-24 14:01:21', 1),
(41, 2, 'Test Event 3', 'Test', '2024-10-19', '2024-10-26', 'Full Day', '2024-10-19 14:41:00', '2024-10-19 14:41:00', 0, '#006600', 3, 3, '2024-09-19 10:12:17', '2024-09-20 07:08:13', 1),
(43, 2, 'Test Event 3', 'Test', '2024-09-23', '2024-09-26', 'Full Day', '2024-09-23 15:38:00', '2024-09-23 15:38:00', 0, '#006600', 3, 3, '2024-09-19 11:08:26', '2024-09-19 11:08:26', 1),
(44, 3, 'academic anuual leave', 'anuual leave', '2025-07-03', '2025-08-23', 'Annual Leave', '2025-07-03 12:00:00', '2025-07-03 12:00:00', 1, '#006600', 3, 3, '2025-04-23 09:09:56', '2025-04-23 09:09:56', 1),
(45, 3, 'X\'mas Holiday', 'Xmas', '2025-12-25', '2025-12-25', 'Full Day', '2025-12-25 11:18:00', '2025-12-25 11:18:00', 0, '#eccf65', 3, 3, '2025-12-22 07:48:26', '2025-12-22 07:48:43', 1);

-- --------------------------------------------------------

--
-- Table structure for table `school_shift`
--

CREATE TABLE `school_shift` (
  `id` int NOT NULL,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `school_shift`
--

INSERT INTO `school_shift` (`id`, `name`, `description`, `start_time`, `end_time`, `active`, `updated_by`, `created_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '06:45-13:45', 'Morning', '06:45:00', '13:45:00', 1, NULL, NULL, NULL, NULL, NULL),
(2, '12:30-18:30', 'Evening', '12:30:00', '18:30:00', 1, NULL, NULL, NULL, NULL, NULL),
(3, '07:00-15:00', 'Admin staff Morning', '07:00:00', '14:00:00', 1, NULL, NULL, NULL, NULL, NULL),
(4, '6:20-13:45', 'Morning2', '06:20:00', '13:45:00', 1, NULL, NULL, NULL, NULL, NULL),
(5, '12:00-18:30', 'Evening 2', '12:00:00', '18:30:00', 1, NULL, NULL, NULL, NULL, NULL),
(6, '7:15-14:15', 'Morning 3', '07:15:00', '14:15:00', 1, NULL, NULL, NULL, NULL, NULL),
(7, '7:30-15:30', 'Morning4', '07:30:00', '15:30:00', 1, NULL, NULL, NULL, NULL, NULL),
(8, '12:30-15:30', 'Evening', '12:30:00', '15:30:00', 1, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `semesters`
--

CREATE TABLE `semesters` (
  `id` int NOT NULL,
  `title` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_from` date NOT NULL,
  `start_to` date NOT NULL,
  `academic_year` int NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shift_assigns`
--

CREATE TABLE `shift_assigns` (
  `id` bigint UNSIGNED NOT NULL,
  `employee_id` int NOT NULL,
  `shift_id` bigint UNSIGNED NOT NULL,
  `date_from` date NOT NULL,
  `date_end` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shift_assigns`
--

INSERT INTO `shift_assigns` (`id`, `employee_id`, `shift_id`, `date_from`, `date_end`, `created_at`, `updated_at`) VALUES
(1, 71, 3, '2025-01-01', '2025-12-31', '2023-11-16 03:08:22', '2023-12-07 11:42:20'),
(2, 2, 1, '2025-01-01', '2025-12-31', '2023-11-16 14:30:10', '2023-11-16 14:30:10'),
(5, 4, 1, '2025-01-01', '2025-12-31', '2023-12-07 12:23:01', '2023-12-07 12:23:01'),
(6, 5, 1, '2025-01-01', '2025-12-31', '2023-12-07 12:23:28', '2023-12-07 12:23:28'),
(7, 6, 1, '2025-01-01', '2025-12-31', '2023-12-07 12:23:57', '2023-12-07 12:23:57'),
(9, 83, 8, '2025-01-01', '2025-12-31', '2024-01-15 16:05:15', '2024-01-15 16:13:10'),
(11, 8, 2, '2025-01-01', '2025-12-31', '2024-04-29 11:01:28', '2024-04-29 11:01:28'),
(13, 81, 8, '2025-01-01', '2025-12-31', '2024-01-15 16:05:15', '2024-01-15 16:13:10'),
(14, 7, 2, '2025-01-01', '2025-12-31', '2024-04-29 11:01:28', '2024-04-29 11:01:28'),
(15, 1, 2, '2025-01-01', '2025-12-31', '2024-04-29 11:01:28', '2024-04-29 11:01:28');

-- --------------------------------------------------------

--
-- Table structure for table `sponsorship_status`
--

CREATE TABLE `sponsorship_status` (
  `id` int NOT NULL,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sponsorship_status`
--

INSERT INTO `sponsorship_status` (`id`, `name`, `active`, `updated_by`, `created_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Family', 1, NULL, NULL, NULL, NULL, NULL),
(2, 'School', 1, NULL, NULL, NULL, NULL, NULL),
(3, 'Company', 1, NULL, NULL, '2023-05-07 06:20:35', '2023-05-07 06:20:35', NULL),
(4, 'Father', 1, NULL, NULL, '2023-05-07 06:20:42', '2023-05-07 06:20:42', NULL),
(5, 'Husband', 1, NULL, NULL, '2023-05-07 06:20:47', '2023-05-07 06:20:47', NULL),
(6, 'Secondment', 1, NULL, NULL, '2023-05-07 06:21:02', '2023-05-07 06:21:02', NULL),
(7, 'Brother', 1, NULL, NULL, '2023-05-07 06:21:31', '2023-05-07 06:21:31', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` mediumint NOT NULL DEFAULT '0',
  `email` varchar(75) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'avatar.png',
  `device_token` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `role`, `email`, `email_verified_at`, `password`, `is_admin`, `remember_token`, `avatar`, `device_token`, `created_at`, `updated_at`, `updated_by`, `created_by`, `deleted_at`) VALUES
(1, 'Super Admin', 0, 'sadmin@admin.com', '2023-05-09 20:28:03', '$2y$10$mUWild9T/.54xqwiYc1kd.sVNi1L6pRsnHJNG5vIswsHdH.EC8Gj2', 1, NULL, 'avatar.png', NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'Administrator', 0, 'admin@admin.com', '2023-05-09 20:29:07', '$2y$10$mUWild9T/.54xqwiYc1kd.sVNi1L6pRsnHJNG5vIswsHdH.EC8Gj2', 1, NULL, 'avatar.png', NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'Mehrin MH', 0, 'hr.hrms@gmail.com', '2023-08-16 07:56:09', '$2y$10$mUWild9T/.54xqwiYc1kd.sVNi1L6pRsnHJNG5vIswsHdH.EC8Gj2', 0, NULL, '1766131513_spSE7F4Azr.jpg', NULL, '2023-08-16 07:48:26', '2025-12-19 10:05:13', NULL, NULL, NULL),
(4, 'Nadima', 0, 'aaa@insasoft.com', '2024-02-04 14:42:00', '$2y$10$3t1vbhcpm4u9YOzTVZhzguRX8vJgZpnfp/l0fSAmQEj3U6UAMFzyW', 0, NULL, '1731581949_ryTl3Im3Qy.jpg', NULL, '2023-08-27 15:22:12', '2024-11-14 12:59:09', NULL, NULL, NULL),
(6, 'Rima', 0, 'rima@insasoft.com', '2024-02-04 14:42:03', '$2y$10$mUWild9T/.54xqwiYc1kd.sVNi1L6pRsnHJNG5vIswsHdH.EC8Gj2', 0, NULL, 'avatar.png', NULL, '2023-09-10 17:31:07', '2024-02-29 07:52:42', NULL, NULL, NULL),
(7, 'Lames', 0, 'lames@insasoft.com', '2024-02-04 14:42:06', '$2y$10$mUWild9T/.54xqwiYc1kd.sVNi1L6pRsnHJNG5vIswsHdH.EC8Gj2', 0, NULL, 'avatar.png', NULL, '2023-09-10 17:31:07', '2024-02-29 07:54:40', NULL, NULL, NULL),
(8, 'Asma ', 0, 'ddd@insasoft.com', '2024-02-04 14:42:08', '$2y$10$HTZYViUoHAjpIqghc3tIuOu2x46vIlFwH7Ea.EZpOrg3/NvoYWf/S', 0, NULL, 'avatar.png', NULL, '2023-09-10 17:31:07', '2024-02-29 07:57:20', NULL, NULL, NULL),
(9, 'Cilma', 0, 'clima@insasoft.com', '2024-02-04 14:42:11', '$2y$10$mUWild9T/.54xqwiYc1kd.sVNi1L6pRsnHJNG5vIswsHdH.EC8Gj2', 0, NULL, '1766390884_qyFfOMnBoO.jpg', NULL, '2023-09-10 17:31:07', '2025-12-22 10:08:04', NULL, NULL, NULL),
(10, 'Sagun B', 0, 'prints@insasoft.com', '2024-02-04 14:42:15', '$2y$10$3ib.m1L1mblIyVhKZIN17u4DBUy1sHFjmBLDisNismzoJPWB/FvAm', 0, NULL, 'avatar.png', NULL, '2023-09-10 17:31:07', '2025-02-24 11:03:20', NULL, NULL, NULL),
(19, 'CEO', 0, 'ceo@insasoft.com', '2023-10-29 05:59:31', '$2y$10$mUWild9T/.54xqwiYc1kd.sVNi1L6pRsnHJNG5vIswsHdH.EC8Gj2', 0, NULL, 'avatar.png', NULL, '2023-09-10 17:31:08', '2023-10-29 05:59:31', NULL, NULL, NULL),
(20, 'Executive CEO', 0, 'execeo@insasoft.com', '2024-02-04 14:42:18', '$2y$10$mUWild9T/.54xqwiYc1kd.sVNi1L6pRsnHJNG5vIswsHdH.EC8Gj2', 0, NULL, 'avatar.png', NULL, '2023-09-10 17:31:08', '2023-09-19 08:08:25', NULL, NULL, NULL),
(30, 'Muhammed ', 0, 'accountant@insasoft.com', '2024-02-04 14:42:21', '$2y$10$XRDv3uWgqiZfnUKiy9BTFOckGf.QSYjhHSbSNWm0RH0A78B0BqbRK', 0, NULL, 'avatar.png', NULL, '2023-09-10 17:31:09', '2024-03-01 08:48:20', NULL, NULL, NULL),
(64, 'Executive Admin', 0, 'executiveadmin@insasoft.com', '2024-02-04 14:42:26', '$2y$10$mUWild9T/.54xqwiYc1kd.sVNi1L6pRsnHJNG5vIswsHdH.EC8Gj2', 0, NULL, 'avatar.png', NULL, '2023-09-10 17:31:11', '2023-09-18 07:01:34', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_associated_employee`
--

CREATE TABLE `user_associated_employee` (
  `id` int NOT NULL,
  `web_user_id` int NOT NULL,
  `web_email` varchar(100) NOT NULL,
  `app_email` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_device_tokens`
--

CREATE TABLE `user_device_tokens` (
  `id` int NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `device_type` varchar(25) DEFAULT NULL,
  `device_token` varchar(2000) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_device_tokens`
--

INSERT INTO `user_device_tokens` (`id`, `user_id`, `device_type`, `device_token`, `created_at`, `updated_at`, `active`) VALUES
(3, 4, 'IOS', '123345', '2024-12-16 11:53:27', '2024-12-16 11:53:27', 1),
(4, 3, 'IOS', 'fqCz7rrYgEXvpdTuT1hdSg:APA91bGKNuHS6XL1keXRwhOpJn1rgPxn0g5gSR9iL4wIrdo7CRajM7WKtmQt76bcIXbL7TqLDzXBqr5nSXyTVsHBoNQCYllT-auk1oQoIzCf8zfA5r4J_Jw', '2025-04-15 09:38:03', '2025-04-15 09:38:03', 1),
(5, 3, 'IOS', 'dSJ8HVHXlULEm1WFfkjQjU:APA91bGmV4BsnLk0FkmgauBkaSVJ2gM4HhckplWFgWgvSx4GGIbGhleAlC_FEM3vXK2arySAOO8c44EeYHO8YUuM62TXPHPWkHagMqA8jR3R_48nno2FQPQ', '2025-04-15 14:58:10', '2025-04-15 14:58:10', 1),
(6, 3, 'IOS', 'diaFdaNI1k6Hun-oSVC-ds:APA91bHljJuoDv1eJX_um8PQJHgCGOK1o6uSa3vy1Ane_QNMmorZlUlBm7w7FCB83S2hbrwmdbZdfxHVCn_8kqorBDxxL6wt_dVxYv-sciVRf9DOZOsbSIg', '2025-04-15 15:08:15', '2025-04-15 15:08:15', 1),
(8, 3, 'Android', 'dRbW-JneRaqJ4RETeRxUx1:APA91bEKlx5L3-xfLesVxo6taBCizODEWsfDfhpI_65HxmfQLdMUpNRR0lJ2LmG8RwiZXOsbAOwyKW4c2LgIa4DrifnUK2SaM1Q6Jj_p-tHpIuU1Io3G-Uk', '2025-04-15 15:31:53', '2025-04-15 15:31:53', 1),
(9, 3, 'Android', 'ec3upUN7RqW3g9ShVV6dQB:APA91bF2kDFMk7dIHkVReIyTTJIQfDRByrApAHoX24WyIWjzKlsjErZTvT5SbwR365qBzgc2Lswu5XDwBwglYPCBXwkXcsTK_nFvzmjMv_r6E7CdgjQHTrI', '2025-04-21 08:11:56', '2025-04-21 08:11:56', 1),
(11, 3, 'Android', 'e18AR2ZDR36V8_mRxo2KvZ:APA91bGGnd85gjqTyjtWdWdEhQV8X5S-nJARAi6kXGUGyr4hQkq4zTt4ZUcCqlJmU48axYfdOe82zrgrl-ST64Vr2nQhfhk-nSYRy9vNWhc1fSydvaoXTtA', '2025-12-18 14:29:26', '2025-12-18 14:29:26', 1),
(13, 3, 'Android', 'dmQBHCOiRGKO2eZ1odUjKm:APA91bGcqTn-qacz8wAw4mISj7Rs9iFr14q3mebnszYGZeoIwePkOgQSlnk28KMhPjL3JNq70ZPfuQMfLjn0OZyA-BUYZ3VQnKCrF0bS4Mj1BNPeVpKRpV8', '2025-12-19 08:15:28', '2025-12-19 08:15:28', 1),
(14, 3, 'admin', 'admin', '2025-12-19 08:32:51', '2025-12-19 08:32:51', 1),
(15, 9, 'Android', 'fsVuQ4sHQ32otDpV896FPb:APA91bHxUe4gLqGXXiGIww_qLpQL3lzXzFdWnI9dNzC1zlWnYCpxyaA0-VQ2CY4HMHn0D_guuS69ab1hSEhwvypEmRMA92zBFTivApkJoBNT76Vi0rr4cK8', '2025-12-22 10:03:52', '2025-12-22 10:03:52', 1),
(19, 7, 'Android', 'dmQBHCOiRGKO2eZ1odUjKm:APA91bGcqTn-qacz8wAw4mISj7Rs9iFr14q3mebnszYGZeoIwePkOgQSlnk28KMhPjL3JNq70ZPfuQMfLjn0OZyA-BUYZ3VQnKCrF0bS4Mj1BNPeVpKRpV8', '2025-12-23 06:35:20', '2025-12-23 06:35:20', 1),
(20, 9, 'Android', 'dmQBHCOiRGKO2eZ1odUjKm:APA91bGcqTn-qacz8wAw4mISj7Rs9iFr14q3mebnszYGZeoIwePkOgQSlnk28KMhPjL3JNq70ZPfuQMfLjn0OZyA-BUYZ3VQnKCrF0bS4Mj1BNPeVpKRpV8', '2025-12-23 06:40:22', '2025-12-23 06:40:22', 1),
(21, 6, 'Android', 'fsVuQ4sHQ32otDpV896FPb:APA91bHxUe4gLqGXXiGIww_qLpQL3lzXzFdWnI9dNzC1zlWnYCpxyaA0-VQ2CY4HMHn0D_guuS69ab1hSEhwvypEmRMA92zBFTivApkJoBNT76Vi0rr4cK8', '2025-12-23 08:58:10', '2025-12-23 08:58:10', 1),
(22, 6, 'Android', 'dmQBHCOiRGKO2eZ1odUjKm:APA91bGcqTn-qacz8wAw4mISj7Rs9iFr14q3mebnszYGZeoIwePkOgQSlnk28KMhPjL3JNq70ZPfuQMfLjn0OZyA-BUYZ3VQnKCrF0bS4Mj1BNPeVpKRpV8', '2025-12-23 12:38:05', '2025-12-23 12:38:05', 1),
(23, 7, 'Android', 'fsVuQ4sHQ32otDpV896FPb:APA91bHxUe4gLqGXXiGIww_qLpQL3lzXzFdWnI9dNzC1zlWnYCpxyaA0-VQ2CY4HMHn0D_guuS69ab1hSEhwvypEmRMA92zBFTivApkJoBNT76Vi0rr4cK8', '2025-12-24 19:53:02', '2025-12-24 19:53:02', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

CREATE TABLE `user_roles` (
  `id` int NOT NULL,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `department` int NOT NULL DEFAULT '0',
  `description` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `academic_year`
--
ALTER TABLE `academic_year`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `appraisal_applicable`
--
ALTER TABLE `appraisal_applicable`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `appraisal_data`
--
ALTER TABLE `appraisal_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `appraisal_reports`
--
ALTER TABLE `appraisal_reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `appraisal_reports_employee_id_foreign` (`employee_id`);

--
-- Indexes for table `appraisal_type`
--
ALTER TABLE `appraisal_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `approval_status`
--
ALTER TABLE `approval_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attendances`
--
ALTER TABLE `attendances`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `audits`
--
ALTER TABLE `audits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `audits_auditable_type_auditable_id_index` (`auditable_type`(191),`auditable_id`),
  ADD KEY `audits_user_id_user_type_index` (`user_id`,`user_type`(191));

--
-- Indexes for table `budget_type`
--
ALTER TABLE `budget_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contract_type`
--
ALTER TABLE `contract_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dashboard_settings`
--
ALTER TABLE `dashboard_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deductions`
--
ALTER TABLE `deductions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `deductions_employee_id_foreign` (`employee_id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `designations`
--
ALTER TABLE `designations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `earnings`
--
ALTER TABLE `earnings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `earnings_employee_id_foreign` (`employee_id`);

--
-- Indexes for table `email_decision`
--
ALTER TABLE `email_decision`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `userid` (`user_id`),
  ADD UNIQUE KEY `employee_no` (`employee_no`);

--
-- Indexes for table `employee_departments`
--
ALTER TABLE `employee_departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee_designations`
--
ALTER TABLE `employee_designations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee_emergency_details`
--
ALTER TABLE `employee_emergency_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee_files`
--
ALTER TABLE `employee_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `employee_health_informations`
--
ALTER TABLE `employee_health_informations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `employee_payroll_informations`
--
ALTER TABLE `employee_payroll_informations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `employee_status`
--
ALTER TABLE `employee_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `gratuity`
--
ALTER TABLE `gratuity`
  ADD PRIMARY KEY (`id`),
  ADD KEY `gratuity_employee_id_foreign` (`employee_id`);

--
-- Indexes for table `gratuity_status`
--
ALTER TABLE `gratuity_status`
  ADD PRIMARY KEY (`id`),
  ADD KEY `gratuity_status_gratuity_id_foreign` (`gratuity_id`);

--
-- Indexes for table `inactive_reason`
--
ALTER TABLE `inactive_reason`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inactive_status`
--
ALTER TABLE `inactive_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `insahrco_insasoft-hrm`
--
ALTER TABLE `insahrco_insasoft-hrm`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leave_applications`
--
ALTER TABLE `leave_applications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leave_application_amendments`
--
ALTER TABLE `leave_application_amendments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leave_application_changes`
--
ALTER TABLE `leave_application_changes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leave_application_status`
--
ALTER TABLE `leave_application_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leave_approval_flows`
--
ALTER TABLE `leave_approval_flows`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leave_approval_flow_steps`
--
ALTER TABLE `leave_approval_flow_steps`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_flow_steps` (`leave_approval_flow_id`);

--
-- Indexes for table `leave_types`
--
ALTER TABLE `leave_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `medical_ailment`
--
ALTER TABLE `medical_ailment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu_links`
--
ALTER TABLE `menu_links`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `moe_approval_status`
--
ALTER TABLE `moe_approval_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `monthlysalaries`
--
ALTER TABLE `monthlysalaries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `monthlysalaries_employee_id_foreign` (`employee_id`);

--
-- Indexes for table `notice_period`
--
ALTER TABLE `notice_period`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `employee_id` (`employee_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_auth_codes_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);

--
-- Indexes for table `paid_status`
--
ALTER TABLE `paid_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`(191));

--
-- Indexes for table `payment_deduction_type`
--
ALTER TABLE `payment_deduction_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `performance_reviews`
--
ALTER TABLE `performance_reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `pips`
--
ALTER TABLE `pips`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pip_appraisal_reports`
--
ALTER TABLE `pip_appraisal_reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pip_appraisal_reports_employee_id_foreign` (`employee_id`);

--
-- Indexes for table `ppr_forms`
--
ALTER TABLE `ppr_forms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `probationary_appraisals`
--
ALTER TABLE `probationary_appraisals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `probationary_appraisals_employee_id_foreign` (`employee_id`);

--
-- Indexes for table `relationship`
--
ALTER TABLE `relationship`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `relevant_degree`
--
ALTER TABLE `relevant_degree`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `resign_applications`
--
ALTER TABLE `resign_applications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `resign_applications_employee_id_foreign` (`employee_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_links`
--
ALTER TABLE `role_has_links`
  ADD PRIMARY KEY (`id`),
  ADD KEY `link_id` (`link_id`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `scfs`
--
ALTER TABLE `scfs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `scf_data`
--
ALTER TABLE `scf_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `school_events`
--
ALTER TABLE `school_events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `school_shift`
--
ALTER TABLE `school_shift`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `semesters`
--
ALTER TABLE `semesters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shift_assigns`
--
ALTER TABLE `shift_assigns`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sponsorship_status`
--
ALTER TABLE `sponsorship_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_associated_employee`
--
ALTER TABLE `user_associated_employee`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_device_tokens`
--
ALTER TABLE `user_device_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `academic_year`
--
ALTER TABLE `academic_year`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `appraisal_applicable`
--
ALTER TABLE `appraisal_applicable`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `appraisal_data`
--
ALTER TABLE `appraisal_data`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `appraisal_reports`
--
ALTER TABLE `appraisal_reports`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `appraisal_type`
--
ALTER TABLE `appraisal_type`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `approval_status`
--
ALTER TABLE `approval_status`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `attendances`
--
ALTER TABLE `attendances`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `audits`
--
ALTER TABLE `audits`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `budget_type`
--
ALTER TABLE `budget_type`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `contract_type`
--
ALTER TABLE `contract_type`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=253;

--
-- AUTO_INCREMENT for table `dashboard_settings`
--
ALTER TABLE `dashboard_settings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `deductions`
--
ALTER TABLE `deductions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `designations`
--
ALTER TABLE `designations`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `earnings`
--
ALTER TABLE `earnings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `email_decision`
--
ALTER TABLE `email_decision`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT for table `employee_departments`
--
ALTER TABLE `employee_departments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee_designations`
--
ALTER TABLE `employee_designations`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee_emergency_details`
--
ALTER TABLE `employee_emergency_details`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `employee_files`
--
ALTER TABLE `employee_files`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee_health_informations`
--
ALTER TABLE `employee_health_informations`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `employee_payroll_informations`
--
ALTER TABLE `employee_payroll_informations`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `employee_status`
--
ALTER TABLE `employee_status`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gratuity`
--
ALTER TABLE `gratuity`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `gratuity_status`
--
ALTER TABLE `gratuity_status`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `inactive_reason`
--
ALTER TABLE `inactive_reason`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inactive_status`
--
ALTER TABLE `inactive_status`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `insahrco_insasoft-hrm`
--
ALTER TABLE `insahrco_insasoft-hrm`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `leave_applications`
--
ALTER TABLE `leave_applications`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;

--
-- AUTO_INCREMENT for table `leave_application_amendments`
--
ALTER TABLE `leave_application_amendments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `leave_application_changes`
--
ALTER TABLE `leave_application_changes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `leave_application_status`
--
ALTER TABLE `leave_application_status`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=141;

--
-- AUTO_INCREMENT for table `leave_approval_flows`
--
ALTER TABLE `leave_approval_flows`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `leave_approval_flow_steps`
--
ALTER TABLE `leave_approval_flow_steps`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `leave_types`
--
ALTER TABLE `leave_types`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `medical_ailment`
--
ALTER TABLE `medical_ailment`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menu_links`
--
ALTER TABLE `menu_links`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT for table `moe_approval_status`
--
ALTER TABLE `moe_approval_status`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `monthlysalaries`
--
ALTER TABLE `monthlysalaries`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=374;

--
-- AUTO_INCREMENT for table `notice_period`
--
ALTER TABLE `notice_period`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=233;

--
-- AUTO_INCREMENT for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `paid_status`
--
ALTER TABLE `paid_status`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `payment_deduction_type`
--
ALTER TABLE `payment_deduction_type`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `performance_reviews`
--
ALTER TABLE `performance_reviews`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pips`
--
ALTER TABLE `pips`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `pip_appraisal_reports`
--
ALTER TABLE `pip_appraisal_reports`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ppr_forms`
--
ALTER TABLE `ppr_forms`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `probationary_appraisals`
--
ALTER TABLE `probationary_appraisals`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `relationship`
--
ALTER TABLE `relationship`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `relevant_degree`
--
ALTER TABLE `relevant_degree`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `resign_applications`
--
ALTER TABLE `resign_applications`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `role_has_links`
--
ALTER TABLE `role_has_links`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=720;

--
-- AUTO_INCREMENT for table `scfs`
--
ALTER TABLE `scfs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `scf_data`
--
ALTER TABLE `scf_data`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `school_events`
--
ALTER TABLE `school_events`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `school_shift`
--
ALTER TABLE `school_shift`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `semesters`
--
ALTER TABLE `semesters`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shift_assigns`
--
ALTER TABLE `shift_assigns`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `sponsorship_status`
--
ALTER TABLE `sponsorship_status`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT for table `user_associated_employee`
--
ALTER TABLE `user_associated_employee`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_device_tokens`
--
ALTER TABLE `user_device_tokens`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `user_roles`
--
ALTER TABLE `user_roles`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appraisal_reports`
--
ALTER TABLE `appraisal_reports`
  ADD CONSTRAINT `appraisal_reports_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `deductions`
--
ALTER TABLE `deductions`
  ADD CONSTRAINT `deductions_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`);

--
-- Constraints for table `earnings`
--
ALTER TABLE `earnings`
  ADD CONSTRAINT `earnings_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`);

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `userid` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `employee_files`
--
ALTER TABLE `employee_files`
  ADD CONSTRAINT `employee_files_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `employees` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `employee_health_informations`
--
ALTER TABLE `employee_health_informations`
  ADD CONSTRAINT `employee_health_informations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `employees` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `employee_payroll_informations`
--
ALTER TABLE `employee_payroll_informations`
  ADD CONSTRAINT `employee_payroll_informations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `employees` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `gratuity`
--
ALTER TABLE `gratuity`
  ADD CONSTRAINT `gratuity_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `gratuity_status`
--
ALTER TABLE `gratuity_status`
  ADD CONSTRAINT `gratuity_status_gratuity_id_foreign` FOREIGN KEY (`gratuity_id`) REFERENCES `gratuity` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `leave_approval_flow_steps`
--
ALTER TABLE `leave_approval_flow_steps`
  ADD CONSTRAINT `fk_flow_steps` FOREIGN KEY (`leave_approval_flow_id`) REFERENCES `leave_approval_flows` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `monthlysalaries`
--
ALTER TABLE `monthlysalaries`
  ADD CONSTRAINT `monthlysalaries_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`);

--
-- Constraints for table `notice_period`
--
ALTER TABLE `notice_period`
  ADD CONSTRAINT `notice_period_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pip_appraisal_reports`
--
ALTER TABLE `pip_appraisal_reports`
  ADD CONSTRAINT `pip_appraisal_reports_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `probationary_appraisals`
--
ALTER TABLE `probationary_appraisals`
  ADD CONSTRAINT `probationary_appraisals_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `resign_applications`
--
ALTER TABLE `resign_applications`
  ADD CONSTRAINT `resign_applications_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_links`
--
ALTER TABLE `role_has_links`
  ADD CONSTRAINT `role_has_links_ibfk_1` FOREIGN KEY (`link_id`) REFERENCES `menu_links` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_links_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_device_tokens`
--
ALTER TABLE `user_device_tokens`
  ADD CONSTRAINT `user_device_tokens_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
