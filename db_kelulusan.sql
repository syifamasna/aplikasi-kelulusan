-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 31, 2024 at 04:41 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_kelulusan`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `graduation_grades`
--

CREATE TABLE `graduation_grades` (
  `id` bigint(20) NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `average_subjects` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`average_subjects`)),
  `final_average` decimal(5,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_10_31_021117_create_personal_access_tokens_table', 2),
(5, '2024_11_06_033335_create_students_table', 3),
(6, '2024_11_07_023429_create_student_classes_table', 4),
(7, '2024_11_11_030357_rename_nama_kelas_to_kelas_in_student_classes', 5),
(8, '2024_11_13_011805_create_teachers_table', 6),
(9, '2024_11_13_023820_modify_guru_status_column_in_teachers_table', 7),
(10, '2024_11_13_033050_create_school_years_table', 8),
(11, '2024_11_13_035825_create_school_years_table', 9),
(12, '2024_11_14_014050_create_school_years_table', 10),
(13, '2024_11_14_020338_create_subjects_table', 11),
(14, '2024_11_14_063601_add_tujuan_pembelajaran_to_subjects_table', 12),
(15, '2024_11_14_073301_add_jk_to_students_table', 13),
(16, '2024_11_19_070354_create_users_table', 14),
(17, '2024_11_21_023445_create_permission_tables', 14),
(18, '2024_11_21_052915_remove_default_role_from_users_table', 15),
(19, '2024_11_21_053657_create_users_table', 16),
(20, '2024_11_21_054030_add_default_role_to_users_table', 17),
(21, '2024_11_21_055041_remove_default_role_from_users_table', 18),
(22, '2024_11_26_042521_create_users_table', 19),
(23, '2024_11_28_041511_add_image_to_users_table', 20),
(24, '2024_11_29_075718_add_user_id_to_student_classes', 21),
(25, '2024_12_06_020900_create_report_cards_table', 21);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(1, 'App\\Models\\User', 3),
(1, 'App\\Models\\User', 5),
(1, 'App\\Models\\User', 7),
(1, 'App\\Models\\User', 9),
(2, 'App\\Models\\User', 2),
(2, 'App\\Models\\User', 4),
(2, 'App\\Models\\User', 6),
(2, 'App\\Models\\User', 8),
(2, 'App\\Models\\User', 10);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `report_cards`
--

CREATE TABLE `report_cards` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `semester` int(11) NOT NULL,
  `tahun_ajar` varchar(255) NOT NULL,
  `sakit` int(11) DEFAULT NULL,
  `izin` int(11) DEFAULT NULL,
  `alfa` int(11) DEFAULT NULL,
  `prestasi` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`prestasi`)),
  `ket_prestasi` text DEFAULT NULL,
  `ekskul` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`ekskul`)),
  `nilai_ekskul` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`nilai_ekskul`)),
  `ket_ekskul` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`ket_ekskul`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `report_cards`
--

INSERT INTO `report_cards` (`id`, `student_id`, `semester`, `tahun_ajar`, `sakit`, `izin`, `alfa`, `prestasi`, `ket_prestasi`, `ekskul`, `nilai_ekskul`, `ket_ekskul`, `created_at`, `updated_at`) VALUES
(24, 107, 9, '2024/2025', 2, 3, NULL, '[\"Juara 2 Cerdas Cermat\",null]', '[null,null]', '\"[\\\"Pramuka\\\",null]\"', '\"[\\\"95\\\",null]\"', '\"[\\\"Sangat Baik\\\",null]\"', '2024-12-13 00:21:30', '2024-12-23 21:06:27'),
(25, 107, 7, '2022/2023', NULL, 2, 3, NULL, '', '\"[\\\"Pramuka\\\",\\\"Silat\\\"]\"', '\"[\\\"90\\\",\\\"70\\\"]\"', '\"[\\\"Sangat Baik\\\",\\\"Kurang Baik\\\"]\"', '2024-12-16 02:28:40', '2024-12-16 03:24:27'),
(31, 221, 7, '2021/2022', NULL, NULL, NULL, NULL, '', '\"[\\\"Japanese Club\\\",null]\"', '\"[\\\"7\\\",null]\"', '\"[\\\"Kurang Baik\\\",null]\"', '2024-12-17 20:06:51', '2024-12-17 20:06:51'),
(32, 221, 8, '2023/2024', 3, 2, 1, NULL, '', '\"[\\\"Badminton\\\",\\\"B. Inggris\\\"]\"', '\"[\\\"95\\\",\\\"80\\\"]\"', '\"[\\\"Sangat Baik\\\",\\\"Baik\\\"]\"', '2024-12-19 22:58:23', '2024-12-19 23:01:20'),
(33, 221, 9, '2024/2025', 2, 2, 1, NULL, '', '\"[\\\"Badminton\\\",null]\"', '\"[\\\"80\\\",null]\"', '\"[\\\"Baik\\\",null]\"', '2024-12-19 23:03:29', '2024-12-19 23:03:54'),
(34, 221, 10, '2024/2025', 1, 1, 1, '[\"Juara 2 Lomba Story Telling\",null]', '[null,null]', '\"[\\\"English Club\\\",null]\"', '\"[\\\"95\\\",null]\"', '\"[\\\"Baik\\\",null]\"', '2024-12-23 19:13:24', '2024-12-23 19:21:49'),
(35, 221, 11, '2024/2025', NULL, NULL, NULL, '[null,null]', '[null,null]', '\"[null,null]\"', '\"[null,null]\"', '\"[null,null]\"', '2024-12-24 23:50:18', '2024-12-24 23:50:18'),
(36, 221, 12, '2024/2025', NULL, NULL, NULL, '[null,null]', '[null,null]', '\"[null,null]\"', '\"[null,null]\"', '\"[null,null]\"', '2024-12-30 19:29:53', '2024-12-30 19:29:53');

-- --------------------------------------------------------

--
-- Table structure for table `report_card_subjects`
--

CREATE TABLE `report_card_subjects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `report_card_id` bigint(20) UNSIGNED NOT NULL,
  `subject_id` bigint(20) UNSIGNED NOT NULL,
  `nilai` int(11) DEFAULT NULL,
  `details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `report_card_subjects`
--

INSERT INTO `report_card_subjects` (`id`, `report_card_id`, `subject_id`, `nilai`, `details`) VALUES
(29, 24, 1, 86, '{\"target\":\"\",\"capaian\":\"\",\"aplikasi\":\"\"}'),
(30, 24, 3, 85, '{\"target\":\"\",\"capaian\":\"\",\"aplikasi\":\"\"}'),
(31, 24, 4, 90, '{\"target\":\"\",\"capaian\":\"\",\"aplikasi\":\"\"}'),
(32, 24, 5, 99, '{\"target\":\"\",\"capaian\":\"\",\"aplikasi\":\"\"}'),
(33, 24, 6, 91, '{\"target\":\"\",\"capaian\":\"\",\"aplikasi\":\"\"}'),
(34, 24, 7, 84, '{\"target\":\"\",\"capaian\":\"\",\"aplikasi\":\"\"}'),
(35, 24, 8, 85, '{\"target\":\"\",\"capaian\":\"\",\"aplikasi\":\"\"}'),
(36, 24, 9, 88, '{\"target\":\"\",\"capaian\":\"\",\"aplikasi\":\"\"}'),
(37, 24, 10, 80, '{\"target\":\"\",\"capaian\":\"\",\"aplikasi\":\"\"}'),
(38, 24, 11, 90, '{\"target\":\"\",\"capaian\":\"\",\"aplikasi\":\"\"}'),
(39, 24, 12, 99, '{\"target\":\"Lulus Tajwid Jilid 8\",\"capaian\":\"Jilid 4 Hal 40\",\"aplikasi\":\"\"}'),
(40, 24, 13, 98, '{\"target\":\"Q.S An-Naba\",\"capaian\":\"Q.S An-Naziat ayat 28\",\"aplikasi\":\"\"}'),
(41, 24, 14, 90, '{\"target\":\"Hadis 10 sd. 20\",\"capaian\":\"\",\"aplikasi\":\"\"}'),
(42, 24, 15, 91, '{\"target\":\"\",\"capaian\":\"\",\"aplikasi\":\"Ms. Office word\"}'),
(43, 25, 1, 70, ''),
(44, 25, 3, 98, ''),
(45, 25, 4, 65, ''),
(46, 25, 5, 50, ''),
(47, 25, 6, 90, ''),
(48, 25, 7, 99, ''),
(49, 25, 8, 97, ''),
(50, 25, 9, 98, ''),
(51, 25, 10, 80, ''),
(52, 25, 11, 81, ''),
(53, 25, 12, 83, ''),
(54, 25, 13, 79, ''),
(55, 25, 14, 90, ''),
(56, 25, 15, 85, ''),
(99, 31, 1, 7, '{\"target\":\"\",\"capaian\":\"\",\"aplikasi\":\"\"}'),
(100, 31, 3, 7, '{\"target\":\"\",\"capaian\":\"\",\"aplikasi\":\"\"}'),
(101, 31, 4, 7, '{\"target\":\"\",\"capaian\":\"\",\"aplikasi\":\"\"}'),
(102, 31, 5, 7, '{\"target\":\"\",\"capaian\":\"\",\"aplikasi\":\"\"}'),
(103, 31, 6, 7, '{\"target\":\"\",\"capaian\":\"\",\"aplikasi\":\"\"}'),
(104, 31, 7, 7, '{\"target\":\"\",\"capaian\":\"\",\"aplikasi\":\"\"}'),
(105, 31, 8, 7, '{\"target\":\"\",\"capaian\":\"\",\"aplikasi\":\"\"}'),
(106, 31, 9, 7, '{\"target\":\"\",\"capaian\":\"\",\"aplikasi\":\"\"}'),
(107, 31, 10, 7, '{\"target\":\"\",\"capaian\":\"\",\"aplikasi\":\"\"}'),
(108, 31, 11, 7, '{\"target\":\"\",\"capaian\":\"\",\"aplikasi\":\"\"}'),
(109, 31, 12, 77, '{\"target\":\"Lulus Tajwid Jilid 8\",\"capaian\":\"Jilid 6 Hal 35\",\"aplikasi\":\"\"}'),
(110, 31, 13, 7, '{\"target\":\"Q.S An-Naba\",\"capaian\":\"Q.S An-Naziat ayat 28\",\"aplikasi\":\"\"}'),
(111, 31, 14, 7, '{\"target\":\"Hadis 1 s.d 10\",\"capaian\":\"\",\"aplikasi\":\"\"}'),
(112, 31, 15, 7, '{\"target\":\"\",\"capaian\":\"\",\"aplikasi\":\"Ms. Office word\"}'),
(113, 32, 1, 1, '{\"target\":\"\",\"capaian\":\"\",\"aplikasi\":\"\"}'),
(114, 32, 3, 2, '{\"target\":\"\",\"capaian\":\"\",\"aplikasi\":\"\"}'),
(115, 32, 4, 3, '{\"target\":\"\",\"capaian\":\"\",\"aplikasi\":\"\"}'),
(116, 32, 5, 4, '{\"target\":\"\",\"capaian\":\"\",\"aplikasi\":\"\"}'),
(117, 32, 6, 5, '{\"target\":\"\",\"capaian\":\"\",\"aplikasi\":\"\"}'),
(118, 32, 7, 6, '{\"target\":\"\",\"capaian\":\"\",\"aplikasi\":\"\"}'),
(119, 32, 8, 7, '{\"target\":\"\",\"capaian\":\"\",\"aplikasi\":\"\"}'),
(120, 32, 9, 8, '{\"target\":\"\",\"capaian\":\"\",\"aplikasi\":\"\"}'),
(121, 32, 10, 9, '{\"target\":\"\",\"capaian\":\"\",\"aplikasi\":\"\"}'),
(122, 32, 11, 10, '{\"target\":\"\",\"capaian\":\"\",\"aplikasi\":\"\"}'),
(123, 32, 12, 11, '{\"target\":\"Lulus\",\"capaian\":\"Jilid 4\",\"aplikasi\":\"\"}'),
(124, 32, 13, 12, '{\"target\":\"Q.S Al-Alaq\",\"capaian\":\"Q.s Ad-Duha ayat 10\",\"aplikasi\":\"\"}'),
(125, 32, 14, 13, '{\"target\":\"Hadis 10 sd. 20\",\"capaian\":\"\",\"aplikasi\":\"\"}'),
(126, 32, 15, 14, '{\"target\":\"\",\"capaian\":\"\",\"aplikasi\":\"Ms. Office Power Point\"}'),
(127, 33, 1, 100, '{\"target\":\"\",\"capaian\":\"\",\"aplikasi\":\"\"}'),
(128, 33, 3, 99, '{\"target\":\"\",\"capaian\":\"\",\"aplikasi\":\"\"}'),
(129, 33, 4, 98, '{\"target\":\"\",\"capaian\":\"\",\"aplikasi\":\"\"}'),
(130, 33, 5, 98, '{\"target\":\"\",\"capaian\":\"\",\"aplikasi\":\"\"}'),
(131, 33, 6, 95, '{\"target\":\"\",\"capaian\":\"\",\"aplikasi\":\"\"}'),
(132, 33, 7, 90, '{\"target\":\"\",\"capaian\":\"\",\"aplikasi\":\"\"}'),
(133, 33, 8, 92, '{\"target\":\"\",\"capaian\":\"\",\"aplikasi\":\"\"}'),
(134, 33, 9, 94, '{\"target\":\"\",\"capaian\":\"\",\"aplikasi\":\"\"}'),
(135, 33, 10, 95, '{\"target\":\"\",\"capaian\":\"\",\"aplikasi\":\"\"}'),
(136, 33, 11, 99, '{\"target\":\"\",\"capaian\":\"\",\"aplikasi\":\"\"}'),
(137, 33, 12, 90, '{\"target\":\"Lulus\",\"capaian\":\"Jilid 6\",\"aplikasi\":\"\"}'),
(138, 33, 13, 98, '{\"target\":\"Q.S Al-Insyirah\",\"capaian\":\"Q.S Al-Asr ayat 3\",\"aplikasi\":\"\"}'),
(139, 33, 14, 89, '{\"target\":\"Hadis 1 sd. 5\",\"capaian\":\"\",\"aplikasi\":\"\"}'),
(140, 33, 15, 85, '{\"target\":\"\",\"capaian\":\"\",\"aplikasi\":\"Ms. Office Excel\"}'),
(141, 34, 1, 90, '{\"target\":\"\",\"capaian\":\"\",\"aplikasi\":\"\"}'),
(142, 34, 3, 95, '{\"target\":\"\",\"capaian\":\"\",\"aplikasi\":\"\"}'),
(143, 34, 4, 85, '{\"target\":\"\",\"capaian\":\"\",\"aplikasi\":\"\"}'),
(144, 34, 5, 80, '{\"target\":\"\",\"capaian\":\"\",\"aplikasi\":\"\"}'),
(145, 34, 6, 78, '{\"target\":\"\",\"capaian\":\"\",\"aplikasi\":\"\"}'),
(146, 34, 7, 81, '{\"target\":\"\",\"capaian\":\"\",\"aplikasi\":\"\"}'),
(147, 34, 8, 85, '{\"target\":\"\",\"capaian\":\"\",\"aplikasi\":\"\"}'),
(148, 34, 9, 90, '{\"target\":\"\",\"capaian\":\"\",\"aplikasi\":\"\"}'),
(149, 34, 10, 95, '{\"target\":\"\",\"capaian\":\"\",\"aplikasi\":\"\"}'),
(150, 34, 11, 92, '{\"target\":\"\",\"capaian\":\"\",\"aplikasi\":\"\"}'),
(151, 34, 12, 88, '{\"target\":\"Lulus Tajwid Jilid 8\",\"capaian\":\"Jilid 4 Hal 40\",\"aplikasi\":\"\"}'),
(152, 34, 13, 89, '{\"target\":\"Q.S Al-Insyirah\",\"capaian\":\"Q.S Al-Asr ayat 3\",\"aplikasi\":\"\"}'),
(153, 34, 14, 84, '{\"target\":\"Hadis 1 s.d 10\",\"capaian\":\"\",\"aplikasi\":\"\"}'),
(154, 34, 15, 90, '{\"target\":\"\",\"capaian\":\"\",\"aplikasi\":\"Ms. Office Power Point\"}'),
(155, 35, 1, 82, '{\"target\":\"\",\"capaian\":\"\",\"aplikasi\":\"\"}'),
(156, 35, 3, 85, '{\"target\":\"\",\"capaian\":\"\",\"aplikasi\":\"\"}'),
(157, 35, 4, 90, '{\"target\":\"\",\"capaian\":\"\",\"aplikasi\":\"\"}'),
(158, 35, 5, 92, '{\"target\":\"\",\"capaian\":\"\",\"aplikasi\":\"\"}'),
(159, 35, 6, 95, '{\"target\":\"\",\"capaian\":\"\",\"aplikasi\":\"\"}'),
(160, 35, 7, 88, '{\"target\":\"\",\"capaian\":\"\",\"aplikasi\":\"\"}'),
(161, 35, 8, 87, '{\"target\":\"\",\"capaian\":\"\",\"aplikasi\":\"\"}'),
(162, 35, 9, 85, '{\"target\":\"\",\"capaian\":\"\",\"aplikasi\":\"\"}'),
(163, 35, 10, 90, '{\"target\":\"\",\"capaian\":\"\",\"aplikasi\":\"\"}'),
(164, 35, 11, 91, '{\"target\":\"\",\"capaian\":\"\",\"aplikasi\":\"\"}'),
(165, 35, 12, 90, '{\"target\":\"9\",\"capaian\":\"9\",\"aplikasi\":\"\"}'),
(166, 35, 13, 85, '{\"target\":\"9\",\"capaian\":\"9\",\"aplikasi\":\"\"}'),
(167, 35, 14, 91, '{\"target\":\"9\",\"capaian\":\"\",\"aplikasi\":\"\"}'),
(168, 35, 15, 88, '{\"target\":\"\",\"capaian\":\"\",\"aplikasi\":\"9\"}'),
(169, 36, 1, 85, '{\"target\":null,\"capaian\":null,\"aplikasi\":null}'),
(170, 36, 3, 81, '{\"target\":null,\"capaian\":null,\"aplikasi\":null}'),
(171, 36, 4, 82, '{\"target\":null,\"capaian\":null,\"aplikasi\":null}'),
(172, 36, 5, 83, '{\"target\":null,\"capaian\":null,\"aplikasi\":null}'),
(173, 36, 6, 84, '{\"target\":null,\"capaian\":null,\"aplikasi\":null}'),
(174, 36, 7, 85, '{\"target\":null,\"capaian\":null,\"aplikasi\":null}'),
(175, 36, 8, 85, '{\"target\":null,\"capaian\":null,\"aplikasi\":null}'),
(176, 36, 9, 80, '{\"target\":null,\"capaian\":null,\"aplikasi\":null}'),
(177, 36, 10, 90, '{\"target\":null,\"capaian\":null,\"aplikasi\":null}'),
(178, 36, 11, 99, '{\"target\":null,\"capaian\":null,\"aplikasi\":null}'),
(179, 36, 12, 91, '{\"target\":\"Lulus Tajwid Jilid 8\",\"capaian\":\"Jilid 6 Hal 35\",\"aplikasi\":null}'),
(180, 36, 13, 85, '{\"target\":\"Q.S Al-Insyirah\",\"capaian\":\"Q.S Al-Asr ayat 3\",\"aplikasi\":null}'),
(181, 36, 14, 88, '{\"target\":\"Hadis 10 sd. 20\",\"capaian\":null,\"aplikasi\":null}'),
(182, 36, 15, 90, '{\"target\":null,\"capaian\":null,\"aplikasi\":\"Ms. Office word\"}');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'api', '2024-11-20 19:41:38', '2024-11-20 19:41:38'),
(2, 'guru', 'api', '2024-11-20 19:41:38', '2024-11-20 19:41:38');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `school_years`
--

CREATE TABLE `school_years` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tahun_ajar` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `school_years`
--

INSERT INTO `school_years` (`id`, `tahun_ajar`, `created_at`, `updated_at`) VALUES
(1, '2022/2023', '2024-11-13 18:44:45', '2024-11-13 18:52:40'),
(3, '2023/2024', '2024-11-13 18:52:52', '2024-11-13 18:52:52'),
(7, '2024/2025', '2024-12-04 18:49:48', '2024-12-04 18:49:48'),
(9, '2021/2022', '2024-12-16 19:08:36', '2024-12-16 19:08:36');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('MM6YZYO6KAzKJZTxRvLY9kHKgVhDQYALpZMbPpBx', 5, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiQmhsWDdoQzk3UFRKY0s5NnA1aEtveDF4a2JEZHJqeWV3aGtISEhIUCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDU6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9ncmFkdWF0aW9uX2dyYWRlcyI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjU7fQ==', 1735616334);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nis` varchar(255) NOT NULL,
  `nisn` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `kelas` varchar(255) DEFAULT NULL,
  `jk` enum('Laki-laki','Perempuan') DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `nis`, `nisn`, `nama`, `kelas`, `jk`, `created_at`, `updated_at`) VALUES
(107, '192001007', '0133092122', 'Akhtar Byakta Candra', '6B', 'Laki-laki', '2024-11-15 01:03:10', '2024-11-15 01:03:10'),
(108, '192001008', '0137838300', 'Alessio Ardana Ismail', '6B', 'Laki-laki', '2024-11-15 01:03:10', '2024-11-15 01:03:10'),
(109, '192001020', '0132265094', 'Bianca Nayla', '6B', 'Perempuan', '2024-11-15 01:03:10', '2024-11-15 01:03:10'),
(110, '192001022', '0138266059', 'Dama Arkananta Raqilla', '6B', 'Laki-laki', '2024-11-15 01:03:11', '2024-11-15 01:03:11'),
(111, '192001023', '3121694075', 'Danendra Canon Zabir', '6B', 'Laki-laki', '2024-11-15 01:03:11', '2024-11-15 01:03:11'),
(112, '192001035', '0128794640', 'Ghaida Hudzaifah Azzahra', '6B', 'Perempuan', '2024-11-15 01:03:11', '2024-11-15 01:03:11'),
(113, '192001036', '0125507073', 'Ghazanfar Alkhalifi', '6B', 'Laki-laki', '2024-11-15 01:03:11', '2024-11-15 01:03:11'),
(114, '192001037', '0134215812', 'Gusti Sabka Yarif Tamsil', '6B', 'Laki-laki', '2024-11-15 01:03:11', '2024-11-15 01:03:11'),
(115, '192001038', '0124355913', 'Hafiz Mahendra', '6B', 'Laki-laki', '2024-11-15 01:03:11', '2024-11-15 01:03:11'),
(116, '192001040', '3128719299', 'Hatta Zakaria', '6B', 'Laki-laki', '2024-11-15 01:03:11', '2024-11-15 01:03:11'),
(117, '212203116', '0125216438', 'Jaris Ataya Finandi Aurum', '6B', 'Laki-laki', '2024-11-15 01:03:11', '2024-11-15 01:03:11'),
(118, '192001044', '3124685763', 'Jihan Syakira Shafwa Harahap', '6B', 'Perempuan', '2024-11-15 01:03:11', '2024-11-15 01:03:11'),
(119, '192001046', '0126043327', 'Kaira Namanda Rahman', '6B', 'Perempuan', '2024-11-15 01:03:11', '2024-11-15 01:03:11'),
(120, '192001049', '0138957474', 'Keisha Zafira Hadzqi', '6B', 'Perempuan', '2024-11-15 01:03:11', '2024-11-15 01:03:11'),
(121, '192001050', '0135264843', 'Khaira Tsany Haniyah', '6B', 'Perempuan', '2024-11-15 01:03:11', '2024-11-15 01:03:11'),
(122, '192001052', '0134396695', 'Kian Nugraha El Hakim', '6B', 'Laki-laki', '2024-11-15 01:03:11', '2024-11-15 01:03:11'),
(123, '192001057', '0131306172', 'Maika Verrani', '6B', 'Perempuan', '2024-11-15 01:03:11', '2024-11-15 01:03:11'),
(124, '192001060', '0122495274', 'Marisa Aini Gunawan', '6B', 'Perempuan', '2024-11-15 01:03:11', '2024-11-15 01:03:11'),
(125, '192001063', '0121660526', 'Mochammad Azriel Badil Irzam', '6B', 'Laki-laki', '2024-11-15 01:03:11', '2024-11-15 01:03:11'),
(126, '192001072', '0134992785', 'Muhammad Ghazi Rabbani', '6B', 'Laki-laki', '2024-11-15 01:03:11', '2024-11-15 01:03:11'),
(127, '192001082', '0123677450', 'Muliyantika Hasanah', '6B', 'Perempuan', '2024-11-15 01:03:12', '2024-11-15 01:03:12'),
(128, '192001093', '0136939165', 'Raffa Alfaryzqi Prasetia', '6B', 'Laki-laki', '2024-11-15 01:03:12', '2024-11-15 01:03:12'),
(129, '192001094', '0128566760', 'Raffandra Dzaky Prayogo', '6B', 'Laki-laki', '2024-11-15 01:03:12', '2024-11-15 01:03:12'),
(130, '192001095', '3129281625', 'Raffasya Alby Prabundani', '6B', 'Laki-laki', '2024-11-15 01:03:12', '2024-11-15 01:03:12'),
(131, '192001098', '3139111309', 'Raissa Hasanaty Labiba', '6B', 'Perempuan', '2024-11-15 01:03:12', '2024-11-15 01:03:12'),
(132, '192001105', '0124473423', 'Shaina Anindya Putri Septiadi', '6B', 'Perempuan', '2024-11-15 01:03:12', '2024-11-15 01:03:12'),
(133, '192001106', '0139085647', 'Syauqi Zharfan Yamani', '6B', 'Laki-laki', '2024-11-15 01:03:12', '2024-11-15 01:03:12'),
(134, '192001006', '125110010', 'Aisyah Zahira Ramadhani', '6A', 'Perempuan', '2024-11-15 01:07:47', '2024-12-03 00:36:52'),
(135, '192001009', '128970710', 'Alifiandra Rasyid Putra Anggriawan', '6A', 'Laki-laki', '2024-11-15 01:07:47', '2024-11-15 01:07:47'),
(136, '192001015', '124210237', 'Aqsazura Kinar Akbar', '6A', 'Perempuan', '2024-11-15 01:07:47', '2024-11-15 01:07:47'),
(137, '192001017', '124107962', 'Arkan Ramaditia Hayza', '6A', 'Laki-laki', '2024-11-15 01:07:47', '2024-11-15 01:07:47'),
(138, '192001018', '132396983', 'Azka Putra Feriansyah', '6A', 'Laki-laki', '2024-11-15 01:07:48', '2024-11-15 01:07:48'),
(139, '192001028', '0124417031', 'Fahri Akbar Kadarisman', '6A', 'Laki-laki', '2024-11-15 01:07:48', '2024-11-15 01:07:48'),
(140, '192001030', '0129130358', 'Faiq Arsa Pradian', '6A', 'Laki-laki', '2024-11-15 01:07:48', '2024-11-15 01:07:48'),
(141, '192001032', '0122313064', 'Fakhru Zubair Akmal', '6A', 'Laki-laki', '2024-11-15 01:07:48', '2024-11-15 01:07:48'),
(142, '192001034', '0123786079', 'Gendis Fathiyyah Lestari', '6A', 'Perempuan', '2024-11-15 01:07:48', '2024-11-15 01:07:48'),
(143, '192001041', '0129506129', 'Haydar Muhammad Alzam', '6A', 'Laki-laki', '2024-11-15 01:07:48', '2024-11-15 01:07:48'),
(144, '192001045', '3121726311', 'Kadziyah Shakila Septiansyah', '6A', 'Perempuan', '2024-11-15 01:07:48', '2024-11-15 01:07:48'),
(145, '192001056', '3137919398', 'Luthfi Ahmad Muttaqi', '6A', 'Laki-laki', '2024-11-15 01:07:48', '2024-11-15 01:07:48'),
(146, '192001059', '0137858957', 'Makkah Azka Mohammed', '6A', 'Laki-laki', '2024-11-15 01:07:48', '2024-11-15 01:07:48'),
(147, '192001062', '0132274511', 'Mirza Izzatul Arshad', '6A', 'Laki-laki', '2024-11-15 01:07:48', '2024-11-15 01:07:48'),
(148, '192001069', '0129588483', 'Muhammad Dirga Maizar Rafli', '6A', 'Laki-laki', '2024-11-15 01:07:48', '2024-11-15 01:07:48'),
(149, '192001071', '0133906562', 'Muhammad Fatih Alkina', '6A', 'Laki-laki', '2024-11-15 01:07:48', '2024-11-15 01:07:48'),
(150, '192001073', '0135266656', 'Muhammad Hilmi Almujahid', '6A', 'Laki-laki', '2024-11-15 01:07:48', '2024-11-15 01:07:48'),
(151, '192001074', '0123722565', 'Muhammad Kaysan Kenzie Tigus', '6A', 'Laki-laki', '2024-11-15 01:07:48', '2024-11-15 01:07:48'),
(152, '192001079', '0137183308', 'Muhammad Shabiy \nArfan Ar Rifai', '6A', 'Laki-laki', '2024-11-15 01:07:48', '2024-11-15 01:07:48'),
(153, '192001084', '0122592264', 'Naifa Alecia Nonci', '6A', 'Perempuan', '2024-11-15 01:07:48', '2024-11-15 01:07:48'),
(154, '192001089', '0134128958', 'Naurah Chantika Salsabilla', '6A', 'Perempuan', '2024-11-15 01:07:48', '2024-11-15 01:07:48'),
(155, '192001091', '0136830908', 'Quinnara Adni Shakeela', '6A', 'Perempuan', '2024-11-15 01:07:48', '2024-11-15 01:07:48'),
(156, '192001097', '0129609631', 'Raisa Salsabila', '6A', 'Perempuan', '2024-11-15 01:07:48', '2024-11-15 01:07:48'),
(157, '192001100', '0122607178', 'Rayyan Syazwan Nafiz', '6A', 'Laki-laki', '2024-11-15 01:07:49', '2024-11-15 01:07:49'),
(158, '192001109', '0137322751', 'Yumi Faizia Hanifah', '6A', 'Perempuan', '2024-11-15 01:07:49', '2024-11-15 01:07:49'),
(159, '192001111', '0126623541', 'Zahrania Dawiyah', '6A', 'Perempuan', '2024-11-15 01:07:49', '2024-11-15 01:07:49'),
(160, '192001112', '0126861651', 'Zahrayya Kamila Latisha', '6A', 'Perempuan', '2024-11-15 01:07:49', '2024-11-15 01:07:49'),
(161, '192001001', '0139321761', 'Affan Ahsan Nurindra', '6C', 'Laki-laki', '2024-11-15 01:09:18', '2024-11-15 01:09:18'),
(162, '192001011', '0125957496', 'Althaf Syamil Arrasyid', '6C', 'Laki-laki', '2024-11-15 01:09:18', '2024-11-15 01:09:18'),
(163, '192001014', '0135649577', 'Aqilah Zahirah Kazhimah', '6C', 'Perempuan', '2024-11-15 01:09:18', '2024-11-15 01:09:18'),
(164, '212203113', '132461049', 'Aracelia Calysta', '6C', 'Perempuan', '2024-11-15 01:09:18', '2024-11-15 01:09:18'),
(165, '192001019', '0138933336', 'Bagas Audric Indratama', '6C', 'Laki-laki', '2024-11-15 01:09:18', '2024-11-15 01:09:18'),
(166, '192001021', '0129428252', 'Daffa Alvaro Aryasatya', '6C', 'Laki-laki', '2024-11-15 01:09:18', '2024-11-15 01:09:18'),
(167, '192001024', '3132616098', 'Dhiya Akhtar Harimurthi', '6C', 'Laki-laki', '2024-11-15 01:09:18', '2024-11-15 01:09:18'),
(168, '192001027', '3128325858', 'Fadli Aseffa Kiarad', '6C', 'Laki-laki', '2024-11-15 01:09:18', '2024-11-15 01:09:18'),
(169, '192001031', '0123091777', 'Fakhri Zuhair Akram', '6C', 'Laki-laki', '2024-11-15 01:09:18', '2024-11-15 01:09:18'),
(170, '192001047', '0136160814', 'Kayumi Puteri Mutiara', '6C', 'Perempuan', '2024-11-15 01:09:18', '2024-11-15 01:09:18'),
(171, '192001048', '0131263583', 'Keenand Athaya Adhyatama', '6C', 'Laki-laki', '2024-11-15 01:09:18', '2024-11-15 01:09:18'),
(172, '192001051', '0128365849', 'Khayla Belvania Charnie', '6C', 'Perempuan', '2024-11-15 01:09:18', '2024-11-15 01:09:18'),
(173, '192001053', '0136770985', 'Kinan Akhtar Mahera', '6C', 'Laki-laki', '2024-11-15 01:09:18', '2024-11-15 01:09:18'),
(174, '192001054', '0121106546', 'Kinanthi Ayunda Putri', '6C', 'Perempuan', '2024-11-15 01:09:18', '2024-11-15 01:09:18'),
(175, '192001055', '0124808384', 'Lizayani Ramadhina Putri', '6C', 'Perempuan', '2024-11-15 01:09:18', '2024-11-15 01:09:18'),
(176, '192001066', '0135154633', 'Muhammad Arham Zunnurain Rifai', '6C', 'Laki-laki', '2024-11-15 01:09:19', '2024-11-15 01:09:19'),
(177, '192001068', '0134872138', 'Muhammad Azmi Taqiyyuddin', '6C', 'Laki-laki', '2024-11-15 01:09:19', '2024-11-15 01:09:19'),
(178, '192001076', '0137336255', 'Muhammad Rafardhan Athaya', '6C', 'Laki-laki', '2024-11-15 01:09:19', '2024-11-15 01:09:19'),
(179, '192001077', '0136225885', 'Muhammad Rasya Athaya', '6C', 'Laki-laki', '2024-11-15 01:09:19', '2024-11-15 01:09:19'),
(180, '192001085', '0123985812', 'Najwa Aisyah Zahra Wibisono', '6C', 'Perempuan', '2024-11-15 01:09:19', '2024-11-15 01:09:19'),
(181, '192001096', '0138478412', 'Raisa Nacita Budiawan', '6C', 'Perempuan', '2024-11-15 01:09:19', '2024-11-15 01:09:19'),
(182, '192001101', '0132871208', 'Razka Faeyza Al-Abyaz', '6C', 'Laki-laki', '2024-11-15 01:09:19', '2024-11-15 01:09:19'),
(183, '192001102', '0135664432', 'Riani Adhystiara Witandra', '6C', 'Perempuan', '2024-11-15 01:09:19', '2024-11-15 01:09:19'),
(184, '192001103', '0128735945', 'Salsabila Agni Sopian', '6C', 'Perempuan', '2024-11-15 01:09:19', '2024-11-15 01:09:19'),
(185, '192001104', '0132047456', 'Sayyid Zabdan Syafiq', '6C', 'Laki-laki', '2024-11-15 01:09:19', '2024-11-15 01:09:19'),
(186, '192001107', '0131008109', 'Yaqdhan Rakha Assaid', '6C', 'Laki-laki', '2024-11-15 01:09:19', '2024-11-15 01:09:19'),
(187, '192001108', '0122106417', 'Yasmine Zainiyah Ahmad', '6C', 'Perempuan', '2024-11-15 01:09:19', '2024-11-15 01:09:19'),
(188, '192001002', '0128228465', 'Afia Zahra Qanita Menoadji', '6D', 'Perempuan', '2024-11-15 01:10:18', '2024-11-15 01:10:18'),
(189, '192001003', '3132680095', 'Ahmad Alhawarizmi', '6D', 'Laki-laki', '2024-11-15 01:10:18', '2024-11-15 01:10:18'),
(190, '192001004', '0138946501', 'Ahmad Athallah Budiman', '6D', 'Laki-laki', '2024-11-15 01:10:19', '2024-11-15 01:10:19'),
(192, '192001010', '0126315475', 'Alma Nurizza Tampubolon', '6D', 'Perempuan', '2024-11-15 01:10:19', '2024-11-15 01:10:19'),
(193, '192001012', '0139063316', 'Anisa Zafira Anum', '6D', 'Perempuan', '2024-11-15 01:10:19', '2024-11-15 01:10:19'),
(194, '192001013', '3139107517', 'Aqila Hanifah', '6D', 'Perempuan', '2024-11-15 01:10:19', '2024-11-15 01:10:19'),
(195, '192001016', '0125381963', 'Arif Rahman Hakim', '6D', 'Laki-laki', '2024-11-15 01:10:19', '2024-11-15 01:10:19'),
(196, '192001025', '3135132532', 'Dyah Deryn Anindya', '6D', 'Perempuan', '2024-11-15 01:10:19', '2024-11-15 01:10:19'),
(197, '192001026', '0126616512', 'El Azzam Dzaky Khoiruddin', '6D', 'Laki-laki', '2024-11-15 01:10:19', '2024-11-15 01:10:19'),
(198, '192001029', '0137383000', 'Fahryan Nabil Wibisana', '6D', 'Laki-laki', '2024-11-15 01:10:19', '2024-11-15 01:10:19'),
(199, '192001033', '3134626714', 'Fathiyah Hilwah Aliyah', '6D', 'Perempuan', '2024-11-15 01:10:19', '2024-11-15 01:10:19'),
(200, '192001039', '3128146950', 'Halim Abbasy', '6D', 'Laki-laki', '2024-11-15 01:10:19', '2024-11-15 01:10:19'),
(201, '192001042', '3139146726', 'Hayumi Azzahra Harsyaputri', '6D', 'Perempuan', '2024-11-15 01:10:19', '2024-11-15 01:10:19'),
(202, '192001043', '0132158299', 'Jeffry Alexander Ferdy Kraus', '6D', 'Laki-laki', '2024-11-15 01:10:19', '2024-11-15 01:10:19'),
(203, '192001058', '0126509160', 'Maisyanova Ayrazka Albana', '6D', 'Perempuan', '2024-11-15 01:10:19', '2024-11-15 01:10:19'),
(204, '192001064', '0136172325', 'Muhamad Hanif Amrullah', '6D', 'Laki-laki', '2024-11-15 01:10:19', '2024-11-15 01:10:19'),
(205, '192001065', '3131797166', 'Muhammad Alfatih', '6D', 'Laki-laki', '2024-11-15 01:10:19', '2024-11-15 01:10:19'),
(206, '192001067', '0128193322', 'Muhammad Arkan Oktrakiya', '6D', 'Laki-laki', '2024-11-15 01:10:19', '2024-11-15 01:10:19'),
(207, '192001070', '0134590254', 'Muhammad Fathir Radinka', '6D', 'Laki-laki', '2024-11-15 01:10:20', '2024-11-15 01:10:20'),
(208, '192001075', '0137893578', 'Muhammad Kenzie Azka', '6D', 'Laki-laki', '2024-11-15 01:10:20', '2024-11-15 01:10:20'),
(209, '192001081', '0123633504', 'Muhammad Syabil Izfanaya', '6D', 'Laki-laki', '2024-11-15 01:10:20', '2024-11-15 01:10:20'),
(210, '192001086', '0138088207', 'Natasya Kayla Lathiifah', '6D', 'Perempuan', '2024-11-15 01:10:20', '2024-11-15 01:10:20'),
(211, '192001087', '3125385793', 'Naufal Dzaky Kurniawan', '6D', 'Laki-laki', '2024-11-15 01:10:20', '2024-11-15 01:10:20'),
(212, '192001090', '0139938654', 'Pranajarafa Dzakwan Fadhlurrohman', '6D', 'Laki-laki', '2024-11-15 01:10:20', '2024-11-15 01:10:20'),
(213, '192001092', '0138164866', 'Rachel Sabita Humaira', '6D', 'Perempuan', '2024-11-15 01:10:20', '2024-11-15 01:10:20'),
(218, '192001110', '0121425793', 'Zahran Ibrahim Hernanda', '6D', 'Laki-laki', '2024-12-04 20:51:04', '2024-12-04 20:51:04'),
(219, '192001005', '0137060260', 'Aila Syifa Raihana Sihombing', '6D', 'Perempuan', '2024-12-04 20:53:37', '2024-12-04 20:53:37'),
(221, '1', '0076633459', 'Syifa Khairunisa Masna', '5A', 'Perempuan', '2024-12-16 19:07:32', '2024-12-23 19:38:11');

-- --------------------------------------------------------

--
-- Table structure for table `student_classes`
--

CREATE TABLE `student_classes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kelas` varchar(255) NOT NULL,
  `nama_guru` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `student_classes`
--

INSERT INTO `student_classes` (`id`, `kelas`, `nama_guru`, `created_at`, `updated_at`) VALUES
(1, '6A', '', NULL, '2024-11-14 22:23:34'),
(2, '6B', '', NULL, NULL),
(3, '6C', '', NULL, NULL),
(4, '6D', '', NULL, NULL),
(13, '5A', NULL, '2024-12-16 19:07:18', '2024-12-27 03:13:28'),
(14, '5B', NULL, '2024-12-24 00:47:05', '2024-12-27 03:13:38'),
(15, '5C', NULL, '2024-12-27 03:13:03', '2024-12-27 03:13:03');

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `guru_mapel` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `nama`, `guru_mapel`, `created_at`, `updated_at`) VALUES
(1, 'Pendidikan Agama Islam dan Budi Pekerti', '...', '2024-11-13 20:09:32', '2024-11-13 20:11:12'),
(3, 'Pendidikan Pancasila', '...', '2024-11-13 23:26:30', '2024-11-13 23:26:30'),
(4, 'Bahasa Indonesia', '...', '2024-11-13 23:26:45', '2024-11-13 23:26:45'),
(5, 'Matematika', NULL, '2024-11-13 23:26:54', '2024-12-27 03:20:00'),
(6, 'Ilmu Pengetahuan Alam dan Sosial', NULL, '2024-11-13 23:27:22', '2024-12-27 03:19:48'),
(7, 'Pendidikan Jasmani, Olahraga dan Kesehatan', '...', '2024-11-13 23:27:52', '2024-11-13 23:28:05'),
(8, 'Seni Budaya dan Prakarya', '...', '2024-11-13 23:28:20', '2024-11-13 23:28:20'),
(9, 'Bahasa Inggris', '...', '2024-11-13 23:28:35', '2024-11-13 23:28:35'),
(10, 'Bahasa dan Sastra Sunda', '...', '2024-11-13 23:29:26', '2024-11-13 23:29:26'),
(11, 'Bahasa Arab', '...', '2024-11-13 23:29:48', '2024-11-13 23:30:02'),
(12, 'Al-Qur\'an Metode Ummi', '-', '2024-11-13 23:39:06', '2024-11-13 23:39:06'),
(13, 'Tahfiz', '-', '2024-11-13 23:39:14', '2024-11-13 23:39:21'),
(14, 'Hadis', '-', '2024-11-13 23:39:38', '2024-11-13 23:39:38'),
(15, 'Informatika (Komputer)', '-', '2024-11-13 23:39:58', '2024-11-13 23:39:58');

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `nip` varchar(255) NOT NULL,
  `jk_guru` enum('Laki-laki','Perempuan') NOT NULL,
  `guru_status` enum('Guru Aktif','Wali Kelas') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`id`, `nama`, `nip`, `jk_guru`, `guru_status`, `created_at`, `updated_at`) VALUES
(2, 'Raka Al Isya', '123456789', 'Laki-laki', 'Wali Kelas', '2024-11-12 20:10:05', '2024-11-12 20:26:18'),
(4, 'Aditya', '123', 'Laki-laki', 'Wali Kelas', '2024-11-13 20:46:06', '2024-11-13 20:46:06');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `class_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `created_at`, `updated_at`, `image`, `class_id`) VALUES
(3, 'Wali Kelas 6B', 'walas6b@aliya.com', '$2y$12$PvfqVg8u4EwgZDVCzQdE4OvigzN6iU7t6jijp2HjNVAcBYHGuc8AG', 'user', '2024-11-27 20:35:42', '2024-12-01 20:24:25', NULL, '6B'),
(4, 'Wali Kelas 6A', 'walas6a@aliya.com', '$2y$12$MvWYPcMgJFjEsSz9.QoIN.LETkgwnSgRluRw6sbTz0zab/efYPtmi', 'user', '2024-11-27 20:51:38', '2024-12-27 01:36:24', NULL, '6A'),
(5, 'Admin', 'admin@aliya.com', '$2y$12$h0PrOiGr9DgCdQqYXdtm/.F8P1QkByI.8KxukvD5zzHkhS./6CUSi', 'admin', '2024-11-28 21:19:28', '2024-12-27 01:58:27', 'images/logo.png', NULL),
(6, 'Wali Kelas 6C', 'walas6c@aliya.com', '$2y$12$oUHM9cKP/T9ZZYWaeKRKHu5eLaV3wQg/PmmI9h1MOREpysBGcyA3.', 'user', '2024-11-28 21:22:50', '2024-11-28 21:41:26', NULL, '6C'),
(7, 'Wali Kelas 6D', 'walas6d@aliya.com', '$2y$12$Lf4SZeE/RodUsAr068Hpp.diZxzS/3O/7eOcmFO4bbenM1J9rVYku', 'user', '2024-11-28 21:23:11', '2024-11-28 21:23:11', NULL, '6D'),
(16, 'Wali Kelas 5A', 'walas5a@aliya.com', '$2y$12$IN6J0AwH9Ej8dKzb009LU.h4QcwRLYJLu3HE3HcbLJPyFyRPNtA9a', 'user', '2024-12-24 00:43:03', '2024-12-27 03:07:18', NULL, '5A'),
(24, 'Wali Kelas 5B', 'walas5b@aliya.com', '$2y$12$/tsskAzszU621MmYVrrhseOlKleo6GymWyCdyn7GVLq9XjbyMump2', 'user', '2024-12-27 03:00:52', '2024-12-27 03:00:52', NULL, '5B');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `graduation_grades`
--
ALTER TABLE `graduation_grades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
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
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

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
-- Indexes for table `report_cards`
--
ALTER TABLE `report_cards`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `tahun_ajar` (`tahun_ajar`);

--
-- Indexes for table `report_card_subjects`
--
ALTER TABLE `report_card_subjects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `report_card_id` (`report_card_id`),
  ADD KEY `subject_id` (`subject_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `school_years`
--
ALTER TABLE `school_years`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `school_years_tahun_ajar_unique` (`tahun_ajar`),
  ADD UNIQUE KEY `tahun_ajar` (`tahun_ajar`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kelas` (`kelas`);

--
-- Indexes for table `student_classes`
--
ALTER TABLE `student_classes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kelas` (`kelas`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `id_2` (`id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `class_id` (`class_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `graduation_grades`
--
ALTER TABLE `graduation_grades`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `report_cards`
--
ALTER TABLE `report_cards`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `report_card_subjects`
--
ALTER TABLE `report_card_subjects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=183;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `school_years`
--
ALTER TABLE `school_years`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=223;

--
-- AUTO_INCREMENT for table `student_classes`
--
ALTER TABLE `student_classes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `graduation_grades`
--
ALTER TABLE `graduation_grades`
  ADD CONSTRAINT `graduation_grades_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

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
-- Constraints for table `report_cards`
--
ALTER TABLE `report_cards`
  ADD CONSTRAINT `report_cards_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `report_cards_ibfk_2` FOREIGN KEY (`tahun_ajar`) REFERENCES `school_years` (`tahun_ajar`) ON DELETE CASCADE;

--
-- Constraints for table `report_card_subjects`
--
ALTER TABLE `report_card_subjects`
  ADD CONSTRAINT `report_card_subjects_ibfk_1` FOREIGN KEY (`report_card_id`) REFERENCES `report_cards` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `report_card_subjects_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`kelas`) REFERENCES `student_classes` (`kelas`) ON DELETE SET NULL;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `student_classes` (`kelas`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
