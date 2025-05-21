-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 21, 2025 at 06:22 PM
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
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `report_card_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `average_subjects` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `final_average` decimal(5,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `graduation_grades`
--

INSERT INTO `graduation_grades` (`id`, `student_id`, `report_card_ids`, `average_subjects`, `final_average`, `created_at`, `updated_at`) VALUES
(2, 134, '\"[37,45,46,79]\"', '\"{\\\"1\\\":85.5,\\\"3\\\":89.75,\\\"4\\\":90.25,\\\"5\\\":90.75,\\\"6\\\":88.5,\\\"7\\\":85.75,\\\"8\\\":86.25,\\\"9\\\":86.25,\\\"10\\\":85,\\\"11\\\":85.25}\"', 87.33, '2025-01-04 09:44:45', '2025-01-29 20:07:07'),
(3, 135, '\"[55,56,57,63]\"', '\"{\\\"1\\\":86.5,\\\"3\\\":87.5,\\\"4\\\":88,\\\"5\\\":86.75,\\\"6\\\":87.75,\\\"7\\\":87.5,\\\"8\\\":87.75,\\\"9\\\":91.75,\\\"10\\\":91.75,\\\"11\\\":91.5}\"', 88.68, '2025-01-05 19:05:09', '2025-01-22 22:04:10'),
(12, 197, '\"[67,68,69,70]\"', '\"{\\\"1\\\":95.25,\\\"3\\\":92.5,\\\"4\\\":89,\\\"5\\\":89.75,\\\"6\\\":91.75,\\\"7\\\":89,\\\"8\\\":89.5,\\\"9\\\":94.75,\\\"10\\\":91,\\\"11\\\":93.75}\"', 91.63, '2025-01-23 20:03:48', '2025-01-23 20:03:48');

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
(25, '2024_12_06_020900_create_report_cards_table', 21),
(26, '2025_05_15_140658_update_ppdb_grades_table_for_totals', 22);

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
-- Table structure for table `ppdb_grades`
--

CREATE TABLE `ppdb_grades` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `report_card_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`report_card_ids`)),
  `total_score` int(11) DEFAULT NULL,
  `total_average` decimal(5,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ppdb_grades`
--

INSERT INTO `ppdb_grades` (`id`, `student_id`, `report_card_ids`, `total_score`, `total_average`, `created_at`, `updated_at`) VALUES
(9, 134, '\"[37,45,46,77,78]\"', 2217, 443.40, '2025-05-15 08:31:54', '2025-05-21 08:23:35'),
(10, 197, '[66,67,68,69,82]', 2233, 446.60, '2025-05-18 23:46:23', '2025-05-18 23:46:23'),
(12, 182, '[71,72,73,74,75]', 2289, 457.80, '2025-05-21 09:20:05', '2025-05-21 09:20:05');

-- --------------------------------------------------------

--
-- Table structure for table `report_cards`
--

CREATE TABLE `report_cards` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `semester` enum('Level 1 Semester 1','Level 1 Semester 2','Level 2 Semester 1','Level 2 Semester 2','Level 3 Semester 1','Level 3 Semester 2','Level 4 Semester 1','Level 4 Semester 2','Level 5 Semester 1','Level 5 Semester 2','Level 6 Semester 1','Level 6 Semester 2') NOT NULL,
  `tahun_ajar` varchar(255) NOT NULL,
  `sakit` int(11) DEFAULT NULL,
  `izin` int(11) DEFAULT NULL,
  `alfa` int(11) DEFAULT NULL,
  `prestasi` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`prestasi`)),
  `ket_prestasi` text DEFAULT NULL,
  `catatan` text DEFAULT NULL,
  `ekskul` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `nilai_ekskul` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `ket_ekskul` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `report_cards`
--

INSERT INTO `report_cards` (`id`, `student_id`, `semester`, `tahun_ajar`, `sakit`, `izin`, `alfa`, `prestasi`, `ket_prestasi`, `catatan`, `ekskul`, `nilai_ekskul`, `ket_ekskul`, `created_at`, `updated_at`) VALUES
(37, 134, 'Level 6 Semester 1', '2023/2024', 2, 3, 1, '[]', '[]', NULL, '\"[null,null]\"', '\"[null,null]\"', '\"[null,null]\"', '2025-01-02 21:23:59', '2025-01-21 02:44:38'),
(45, 134, 'Level 5 Semester 1', '2022/2023', 2, 2, NULL, '[\"Juara 3 Kompetisi Silat\"]', '[]', NULL, '\"[null,null]\"', '\"[null,null]\"', '\"[null,null]\"', '2025-01-06 23:00:40', '2025-01-12 23:53:25'),
(46, 134, 'Level 5 Semester 2', '2023/2024', NULL, NULL, NULL, '[]', '[]', NULL, '\"[null,null]\"', '\"[null,null]\"', '\"[null,null]\"', '2025-01-06 23:01:49', '2025-01-12 23:55:03'),
(47, 136, 'Level 5 Semester 1', '2023/2024', NULL, NULL, NULL, '[null,null]', '[null,null]', NULL, '\"[null,null]\"', '\"[null,null]\"', '\"[null,null]\"', '2025-01-06 23:52:20', '2025-01-06 23:52:20'),
(48, 136, 'Level 5 Semester 2', '2023/2024', NULL, NULL, NULL, '[null,null]', '[null,null]', NULL, '\"[null,null]\"', '\"[null,null]\"', '\"[null,null]\"', '2025-01-06 23:54:14', '2025-01-06 23:54:14'),
(49, 136, 'Level 6 Semester 1', '2023/2024', NULL, NULL, NULL, '[null,null]', '[null,null]', NULL, '\"[null,null]\"', '\"[null,null]\"', '\"[null,null]\"', '2025-01-06 23:58:12', '2025-01-06 23:58:12'),
(55, 135, 'Level 6 Semester 2', '2024/2025', NULL, NULL, NULL, '[\"Juara 1 Lomba Story Telling\",\"Juara 2 Cerdas Cermat\",\"Juara 3 Karate\"]', '[\"Kece badai\",\"lanjutkan!!\"]', NULL, NULL, NULL, NULL, '2025-01-12 03:31:34', '2025-01-21 01:33:14'),
(56, 135, 'Level 6 Semester 1', '2023/2024', NULL, NULL, NULL, '[]', '[]', NULL, NULL, NULL, NULL, '2025-01-12 03:53:35', '2025-01-12 03:53:35'),
(57, 135, 'Level 5 Semester 2', '2023/2024', NULL, NULL, NULL, '[\"Juara 1 Cerdas Cermat\",\"Juara 2 Lomba Story Telling\",\"Juara 3 Karate\"]', '[]', NULL, NULL, NULL, NULL, '2025-01-12 03:54:39', '2025-01-21 01:34:01'),
(59, 135, 'Level 4 Semester 2', '2022/2023', NULL, NULL, NULL, '[\"Juara 1 Lomba MTQ\",\"Juara 2 Lomba Story Telling\",\"Juara 1 Cerdas Cermat\"]', '[\"Tingkat provinsi\"]', NULL, NULL, NULL, NULL, '2025-01-12 20:08:04', '2025-01-12 20:14:54'),
(60, 135, 'Level 4 Semester 1', '2021/2022', NULL, NULL, NULL, '[\"Juara 1 Lomba Story Telling\",\"Juara 3 Karate\"]', '[]', NULL, NULL, NULL, NULL, '2025-01-12 20:15:53', '2025-01-12 20:16:21'),
(62, 136, 'Level 4 Semester 2', '2022/2023', NULL, NULL, NULL, '[]', '[]', NULL, NULL, NULL, NULL, '2025-01-21 01:10:14', '2025-01-21 01:10:14'),
(63, 135, 'Level 5 Semester 1', '2022/2023', 1, 1, 1, '[\"Juara 1 Kompetisi Matematika\"]', '[]', 'Perkembangan anak sangat baik', NULL, NULL, NULL, '2025-01-21 01:30:46', '2025-01-21 01:32:02'),
(64, 165, 'Level 4 Semester 1', '2021/2022', 2, 1, NULL, '[\"Juara 1 Lomba MTQ\"]', '[]', NULL, NULL, NULL, NULL, '2025-01-21 01:43:38', '2025-01-21 01:43:38'),
(66, 197, 'Level 4 Semester 2', '2022/2023', NULL, NULL, NULL, '[]', '[]', NULL, NULL, NULL, NULL, '2025-01-23 19:58:36', '2025-01-23 19:58:36'),
(67, 197, 'Level 5 Semester 1', '2022/2023', NULL, NULL, NULL, '[]', '[]', NULL, NULL, NULL, NULL, '2025-01-23 20:01:07', '2025-01-23 20:01:07'),
(68, 197, 'Level 5 Semester 2', '2023/2024', NULL, NULL, NULL, '[]', '[]', NULL, NULL, NULL, NULL, '2025-01-23 20:02:07', '2025-01-23 20:02:07'),
(69, 197, 'Level 6 Semester 1', '2023/2024', NULL, NULL, NULL, '[]', '[]', NULL, NULL, NULL, NULL, '2025-01-23 20:02:54', '2025-01-23 20:02:54'),
(70, 197, 'Level 6 Semester 2', '2024/2025', NULL, NULL, NULL, '[]', '[]', NULL, NULL, NULL, NULL, '2025-01-23 20:03:36', '2025-01-23 20:03:36'),
(71, 182, 'Level 4 Semester 1', '2021/2022', NULL, NULL, NULL, '[\"Juara 3 Lomba Story Telling\"]', '[]', NULL, NULL, NULL, NULL, '2025-01-29 13:11:54', '2025-05-21 09:19:48'),
(72, 182, 'Level 4 Semester 2', '2022/2023', NULL, NULL, NULL, '[]', '[]', NULL, NULL, NULL, NULL, '2025-01-29 13:35:10', '2025-01-29 13:35:10'),
(73, 182, 'Level 5 Semester 1', '2022/2023', NULL, NULL, NULL, '[]', '[]', NULL, NULL, NULL, NULL, '2025-01-29 13:35:49', '2025-01-29 13:35:49'),
(74, 182, 'Level 5 Semester 2', '2023/2024', NULL, NULL, NULL, '[]', '[]', NULL, NULL, NULL, NULL, '2025-01-29 13:36:33', '2025-01-29 13:36:33'),
(75, 182, 'Level 6 Semester 1', '2023/2024', NULL, NULL, NULL, '[]', '[]', NULL, NULL, NULL, NULL, '2025-01-29 13:37:11', '2025-01-29 13:37:11'),
(77, 134, 'Level 4 Semester 1', '2021/2022', NULL, NULL, NULL, '[]', '[]', NULL, NULL, NULL, NULL, '2025-01-29 19:18:32', '2025-01-29 19:18:32'),
(78, 134, 'Level 4 Semester 2', '2022/2023', NULL, NULL, NULL, '[]', '[]', NULL, NULL, NULL, NULL, '2025-01-29 19:19:01', '2025-01-29 19:19:01'),
(79, 134, 'Level 6 Semester 2', '2024/2025', NULL, NULL, NULL, '[]', '[]', NULL, NULL, NULL, NULL, '2025-01-29 20:00:18', '2025-01-29 20:00:18'),
(80, 137, 'Level 6 Semester 2', '2024/2025', NULL, NULL, NULL, '[]', '[]', NULL, NULL, NULL, NULL, '2025-02-03 19:44:44', '2025-02-03 19:44:44'),
(81, 213, 'Level 4 Semester 2', '2022/2023', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-02-05 19:15:52', '2025-02-09 02:47:07'),
(82, 197, 'Level 4 Semester 1', '2021/2022', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-02-13 23:17:44', '2025-02-13 23:17:44');

-- --------------------------------------------------------

--
-- Table structure for table `report_card_subjects`
--

CREATE TABLE `report_card_subjects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `report_card_id` bigint(20) UNSIGNED NOT NULL,
  `subject_id` bigint(20) UNSIGNED NOT NULL,
  `nilai` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `report_card_subjects`
--

INSERT INTO `report_card_subjects` (`id`, `report_card_id`, `subject_id`, `nilai`) VALUES
(183, 37, 1, 85),
(184, 37, 3, 86),
(185, 37, 4, 87),
(186, 37, 5, 88),
(187, 37, 6, 89),
(188, 37, 7, 90),
(189, 37, 8, 86),
(190, 37, 9, 87),
(191, 37, 10, 85),
(192, 37, 11, 85),
(295, 45, 1, 80),
(296, 45, 3, 86),
(297, 45, 4, 87),
(298, 45, 5, 88),
(299, 45, 6, 90),
(300, 45, 7, 84),
(301, 45, 8, 85),
(302, 45, 9, 80),
(303, 45, 10, 81),
(304, 45, 11, 82),
(309, 46, 1, 87),
(310, 46, 3, 89),
(311, 46, 4, 90),
(312, 46, 5, 92),
(313, 46, 6, 85),
(314, 46, 7, 82),
(315, 46, 8, 80),
(316, 46, 9, 83),
(317, 46, 10, 85),
(318, 46, 11, 87),
(323, 47, 1, 85),
(324, 47, 3, 87),
(325, 47, 4, 88),
(326, 47, 5, 89),
(327, 47, 6, 90),
(328, 47, 7, 87),
(329, 47, 8, 88),
(330, 47, 9, 80),
(331, 47, 10, 86),
(332, 47, 11, 85),
(337, 48, 1, 80),
(338, 48, 3, 86),
(339, 48, 4, 87),
(340, 48, 5, 88),
(341, 48, 6, 90),
(342, 48, 7, 83),
(343, 48, 8, 84),
(344, 48, 9, 100),
(345, 48, 10, 86),
(346, 48, 11, 86),
(351, 49, 1, 87),
(352, 49, 3, 86),
(353, 49, 4, 85),
(354, 49, 5, 80),
(355, 49, 6, 83),
(356, 49, 7, 82),
(357, 49, 8, 84),
(358, 49, 9, 85),
(359, 49, 10, 87),
(360, 49, 11, 88),
(420, 55, 1, 85),
(421, 55, 3, 86),
(422, 55, 4, 85),
(423, 55, 5, 87),
(424, 55, 6, 90),
(425, 55, 7, 84),
(426, 55, 8, 88),
(427, 55, 9, 89),
(428, 55, 10, 90),
(429, 55, 11, 89),
(430, 56, 1, 87),
(431, 56, 3, 88),
(432, 56, 4, 89),
(433, 56, 5, 90),
(434, 56, 6, 88),
(435, 56, 7, 90),
(436, 56, 8, 92),
(437, 56, 9, 95),
(438, 56, 10, 90),
(439, 56, 11, 93),
(440, 57, 1, 87),
(441, 57, 3, 88),
(442, 57, 4, 89),
(443, 57, 5, 85),
(444, 57, 6, 84),
(445, 57, 7, 86),
(446, 57, 8, 80),
(447, 57, 9, 90),
(448, 57, 10, 92),
(449, 57, 11, 88),
(460, 59, 1, 87),
(461, 59, 3, 89),
(462, 59, 4, 90),
(463, 59, 5, 85),
(464, 59, 6, 84),
(465, 59, 7, 88),
(466, 59, 8, 87),
(467, 59, 9, 90),
(468, 59, 10, 92),
(469, 59, 11, 85),
(470, 60, 1, 80),
(471, 60, 3, 85),
(472, 60, 4, 84),
(473, 60, 5, 83),
(474, 60, 6, 81),
(475, 60, 7, 80),
(476, 60, 8, 86),
(477, 60, 9, 89),
(478, 60, 10, 93),
(479, 60, 11, 85),
(490, 62, 1, 90),
(491, 62, 3, 95),
(492, 62, 4, 92),
(493, 62, 5, 90),
(494, 62, 6, 85),
(495, 62, 7, 89),
(496, 62, 8, 90),
(497, 62, 9, 92),
(498, 62, 10, 99),
(499, 62, 11, 95),
(500, 63, 1, 87),
(501, 63, 3, 88),
(502, 63, 4, 89),
(503, 63, 5, 85),
(504, 63, 6, 89),
(505, 63, 7, 90),
(506, 63, 8, 91),
(507, 63, 9, 93),
(508, 63, 10, 95),
(509, 63, 11, 96),
(510, 64, 1, 87),
(511, 64, 3, 88),
(512, 64, 4, 89),
(513, 64, 5, 85),
(514, 64, 6, 84),
(515, 64, 7, 83),
(516, 64, 8, 80),
(517, 64, 9, 89),
(518, 64, 10, 90),
(519, 64, 11, 92),
(542, 66, 1, 89),
(543, 66, 3, 88),
(544, 66, 4, 87),
(545, 66, 5, 90),
(546, 66, 6, 91),
(547, 66, 7, 95),
(548, 66, 8, 93),
(549, 66, 9, 99),
(550, 66, 10, 98),
(551, 66, 11, 89),
(552, 67, 1, 89),
(553, 67, 3, 87),
(554, 67, 4, 88),
(555, 67, 5, 85),
(556, 67, 6, 92),
(557, 67, 7, 89),
(558, 67, 8, 85),
(559, 67, 9, 95),
(560, 67, 10, 91),
(561, 67, 11, 90),
(562, 68, 1, 95),
(563, 68, 3, 94),
(564, 68, 4, 90),
(565, 68, 5, 89),
(566, 68, 6, 97),
(567, 68, 7, 89),
(568, 68, 8, 90),
(569, 68, 9, 94),
(570, 68, 10, 92),
(571, 68, 11, 90),
(572, 69, 1, 98),
(573, 69, 3, 95),
(574, 69, 4, 88),
(575, 69, 5, 89),
(576, 69, 6, 85),
(577, 69, 7, 87),
(578, 69, 8, 90),
(579, 69, 9, 92),
(580, 69, 10, 89),
(581, 69, 11, 95),
(582, 70, 1, 99),
(583, 70, 3, 94),
(584, 70, 4, 90),
(585, 70, 5, 96),
(586, 70, 6, 93),
(587, 70, 7, 91),
(588, 70, 8, 93),
(589, 70, 9, 98),
(590, 70, 10, 92),
(591, 70, 11, 100),
(592, 71, 1, 87),
(593, 71, 3, 89),
(594, 71, 4, 88),
(595, 71, 5, 90),
(596, 71, 6, 84),
(597, 71, 7, 88),
(598, 71, 8, 92),
(599, 71, 9, 95),
(600, 71, 10, 90),
(601, 71, 11, 85),
(602, 72, 1, 94),
(603, 72, 3, 90),
(604, 72, 4, 91),
(605, 72, 5, 93),
(606, 72, 6, 89),
(607, 72, 7, 90),
(608, 72, 8, 92),
(609, 72, 9, 94),
(610, 72, 10, 95),
(611, 72, 11, 90),
(612, 73, 1, 90),
(613, 73, 3, 95),
(614, 73, 4, 94),
(615, 73, 5, 93),
(616, 73, 6, 90),
(617, 73, 7, 91),
(618, 73, 8, 90),
(619, 73, 9, 90),
(620, 73, 10, 91),
(621, 73, 11, 92),
(622, 74, 1, 93),
(623, 74, 3, 94),
(624, 74, 4, 92),
(625, 74, 5, 91),
(626, 74, 6, 90),
(627, 74, 7, 90),
(628, 74, 8, 91),
(629, 74, 9, 92),
(630, 74, 10, 90),
(631, 74, 11, 93),
(632, 75, 1, 94),
(633, 75, 3, 93),
(634, 75, 4, 95),
(635, 75, 5, 97),
(636, 75, 6, 93),
(637, 75, 7, 90),
(638, 75, 8, 94),
(639, 75, 9, 95),
(640, 75, 10, 96),
(641, 75, 11, 95),
(652, 77, 1, 89),
(653, 77, 3, 87),
(654, 77, 4, 88),
(655, 77, 5, 90),
(656, 77, 6, 95),
(657, 77, 7, 89),
(658, 77, 8, 90),
(659, 77, 9, 91),
(660, 77, 10, 90),
(661, 77, 11, 92),
(662, 78, 1, 90),
(663, 78, 3, 91),
(664, 78, 4, 92),
(665, 78, 5, 94),
(666, 78, 6, 92),
(667, 78, 7, 90),
(668, 78, 8, 98),
(669, 78, 9, 96),
(670, 78, 10, 94),
(671, 78, 11, 94),
(672, 79, 1, 90),
(673, 79, 3, 98),
(674, 79, 4, 97),
(675, 79, 5, 95),
(676, 79, 6, 90),
(677, 79, 7, 87),
(678, 79, 8, 94),
(679, 79, 9, 95),
(680, 79, 10, 89),
(681, 79, 11, 87),
(682, 80, 1, 75),
(683, 80, 3, 78),
(684, 80, 4, 89),
(685, 80, 5, 80),
(686, 80, 6, 86),
(687, 80, 7, 85),
(688, 80, 8, 89),
(689, 80, 9, 90),
(690, 80, 10, 92),
(691, 80, 11, 100),
(692, 81, 1, 88),
(693, 81, 3, 81),
(694, 81, 4, 87),
(695, 81, 5, 90),
(696, 81, 6, 75),
(697, 81, 7, 78),
(698, 81, 8, 82),
(699, 81, 9, 92),
(700, 81, 10, 89),
(701, 81, 11, 80),
(703, 82, 1, 89),
(704, 82, 3, 87),
(705, 82, 4, 88),
(706, 82, 5, 80),
(707, 82, 6, 83),
(708, 82, 7, 89),
(709, 82, 8, 90),
(710, 82, 9, 92),
(711, 82, 10, 91),
(712, 82, 11, 90);

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
-- Table structure for table `school_profiles`
--

CREATE TABLE `school_profiles` (
  `id` bigint(20) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `npsn` int(20) NOT NULL,
  `kode_pos` int(20) NOT NULL,
  `telepon` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `website` varchar(255) NOT NULL,
  `kepsek` varchar(255) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `school_profiles`
--

INSERT INTO `school_profiles` (`id`, `nama`, `npsn`, `kode_pos`, `telepon`, `alamat`, `email`, `website`, `kepsek`, `logo`, `created_at`, `updated_at`) VALUES
(1, 'SIT Aliya', 20219975, 16117, '02518422129', 'Jl. Gardu Raya, RT.03/RW.11, Bubulak, Kec. Bogor Bar., Kota Bogor, Jawa Barat', 'sitaliya01@gmail.com', 'https://sitaliya.sch.id/', 'Luluk Dianarini, S.TP, M.Pd.', 'school_logos/mal5ITG7glGYMV7g4CNG18kQXPG3yLJwq5GrTkV7.png', NULL, '2025-02-10 13:00:22');

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
('gcSA0see4mxhSwmWvKVSuS5PDuz1c5hmovBW6zaw', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidm0xZktvOWtabGpnT0JQNGZ3aXAzcUUwYlZ4Z3NMS21YcWpmVWladyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMS9sb2dpbiI7fX0=', 1747844513);

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
  `ttl` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `nis`, `nisn`, `nama`, `kelas`, `jk`, `ttl`, `created_at`, `updated_at`) VALUES
(107, '192001007', '0133092122', 'Akhtar Byakta Candra', '6B', 'Laki-laki', NULL, '2024-11-15 01:03:10', '2024-11-15 01:03:10'),
(108, '192001008', '0137838300', 'Alessio Ardana Ismail', '6B', 'Laki-laki', NULL, '2024-11-15 01:03:10', '2024-11-15 01:03:10'),
(109, '192001020', '0132265094', 'Bianca Nayla', '6B', 'Perempuan', NULL, '2024-11-15 01:03:10', '2024-11-15 01:03:10'),
(110, '192001022', '0138266059', 'Dama Arkananta Raqilla', '6B', 'Laki-laki', NULL, '2024-11-15 01:03:11', '2024-11-15 01:03:11'),
(111, '192001023', '3121694075', 'Danendra Canon Zabir', '6B', 'Laki-laki', NULL, '2024-11-15 01:03:11', '2024-11-15 01:03:11'),
(112, '192001035', '0128794640', 'Ghaida Hudzaifah Azzahra', '6B', 'Perempuan', NULL, '2024-11-15 01:03:11', '2024-11-15 01:03:11'),
(113, '192001036', '0125507073', 'Ghazanfar Alkhalifi', '6B', 'Laki-laki', NULL, '2024-11-15 01:03:11', '2024-11-15 01:03:11'),
(114, '192001037', '0134215812', 'Gusti Sabka Yarif Tamsil', '6B', 'Laki-laki', NULL, '2024-11-15 01:03:11', '2024-11-15 01:03:11'),
(115, '192001038', '0124355913', 'Hafiz Mahendra', '6B', 'Laki-laki', NULL, '2024-11-15 01:03:11', '2024-11-15 01:03:11'),
(116, '192001040', '3128719299', 'Hatta Zakaria', '6B', 'Laki-laki', NULL, '2024-11-15 01:03:11', '2024-11-15 01:03:11'),
(117, '212203116', '0125216438', 'Jaris Ataya Finandi Aurum', '6B', 'Laki-laki', NULL, '2024-11-15 01:03:11', '2024-11-15 01:03:11'),
(118, '192001044', '3124685763', 'Jihan Syakira Shafwa Harahap', '6B', 'Perempuan', NULL, '2024-11-15 01:03:11', '2024-11-15 01:03:11'),
(119, '192001046', '0126043327', 'Kaira Namanda Rahman', '6B', 'Perempuan', NULL, '2024-11-15 01:03:11', '2024-11-15 01:03:11'),
(120, '192001049', '0138957474', 'Keisha Zafira Hadzqi', '6B', 'Perempuan', NULL, '2024-11-15 01:03:11', '2024-11-15 01:03:11'),
(121, '192001050', '0135264843', 'Khaira Tsany Haniyah', '6B', 'Perempuan', NULL, '2024-11-15 01:03:11', '2024-11-15 01:03:11'),
(122, '192001052', '0134396695', 'Kian Nugraha El Hakim', '6B', 'Laki-laki', NULL, '2024-11-15 01:03:11', '2024-11-15 01:03:11'),
(123, '192001057', '0131306172', 'Maika Verrani', '6B', 'Perempuan', NULL, '2024-11-15 01:03:11', '2024-11-15 01:03:11'),
(124, '192001060', '0122495274', 'Marisa Aini Gunawan', '6B', 'Perempuan', NULL, '2024-11-15 01:03:11', '2024-11-15 01:03:11'),
(125, '192001063', '0121660526', 'Mochammad Azriel Badil Irzam', '6B', 'Laki-laki', NULL, '2024-11-15 01:03:11', '2024-11-15 01:03:11'),
(126, '192001072', '0134992785', 'Muhammad Ghazi Rabbani', '6B', 'Laki-laki', NULL, '2024-11-15 01:03:11', '2024-11-15 01:03:11'),
(127, '192001082', '0123677450', 'Muliyantika Hasanah', '6B', 'Perempuan', NULL, '2024-11-15 01:03:12', '2024-11-15 01:03:12'),
(128, '192001093', '0136939165', 'Raffa Alfaryzqi Prasetia', '6B', 'Laki-laki', NULL, '2024-11-15 01:03:12', '2024-11-15 01:03:12'),
(129, '192001094', '0128566760', 'Raffandra Dzaky Prayogo', '6B', 'Laki-laki', NULL, '2024-11-15 01:03:12', '2024-11-15 01:03:12'),
(130, '192001095', '3129281625', 'Raffasya Alby Prabundani', '6B', 'Laki-laki', NULL, '2024-11-15 01:03:12', '2024-11-15 01:03:12'),
(131, '192001098', '3139111309', 'Raissa Hasanaty Labiba', '6B', 'Perempuan', NULL, '2024-11-15 01:03:12', '2024-11-15 01:03:12'),
(132, '192001105', '0124473423', 'Shaina Anindya Putri Septiadi', '6B', 'Perempuan', NULL, '2024-11-15 01:03:12', '2024-11-15 01:03:12'),
(133, '192001106', '0139085647', 'Syauqi Zharfan Yamani', '6B', 'Laki-laki', NULL, '2024-11-15 01:03:12', '2024-11-15 01:03:12'),
(134, '192001006', '125110010', 'Aisyah Zahira Ramadhani', '6A', 'Perempuan', 'Bogor, 11 Juli 2013', '2024-11-15 01:07:47', '2025-02-09 01:36:55'),
(135, '192001009', '128970710', 'Alifiandra Rasyid Putra Anggriawan', '6A', 'Laki-laki', NULL, '2024-11-15 01:07:47', '2024-11-15 01:07:47'),
(136, '192001015', '124210237', 'Aqsazura Kinar Akbar', '6A', 'Perempuan', NULL, '2024-11-15 01:07:47', '2024-11-15 01:07:47'),
(137, '192001017', '124107962', 'Arkan Ramaditia Hayza', '6A', 'Laki-laki', NULL, '2024-11-15 01:07:47', '2024-11-15 01:07:47'),
(138, '192001018', '132396983', 'Azka Putra Feriansyah', '6A', 'Laki-laki', NULL, '2024-11-15 01:07:48', '2024-11-15 01:07:48'),
(139, '192001028', '0124417031', 'Fahri Akbar Kadarisman', '6A', 'Laki-laki', NULL, '2024-11-15 01:07:48', '2024-11-15 01:07:48'),
(140, '192001030', '0129130358', 'Faiq Arsa Pradian', '6A', 'Laki-laki', NULL, '2024-11-15 01:07:48', '2024-11-15 01:07:48'),
(141, '192001032', '0122313064', 'Fakhru Zubair Akmal', '6A', 'Laki-laki', NULL, '2024-11-15 01:07:48', '2024-11-15 01:07:48'),
(142, '192001034', '0123786079', 'Gendis Fathiyyah Lestari', '6A', 'Perempuan', NULL, '2024-11-15 01:07:48', '2024-11-15 01:07:48'),
(143, '192001041', '0129506129', 'Haydar Muhammad Alzam', '6A', 'Laki-laki', NULL, '2024-11-15 01:07:48', '2024-11-15 01:07:48'),
(144, '192001045', '3121726311', 'Kadziyah Shakila Septiansyah', '6A', 'Perempuan', NULL, '2024-11-15 01:07:48', '2024-11-15 01:07:48'),
(145, '192001056', '3137919398', 'Luthfi Ahmad Muttaqi', '6A', 'Laki-laki', NULL, '2024-11-15 01:07:48', '2024-11-15 01:07:48'),
(146, '192001059', '0137858957', 'Makkah Azka Mohammed', '6A', 'Laki-laki', NULL, '2024-11-15 01:07:48', '2024-11-15 01:07:48'),
(147, '192001062', '0132274511', 'Mirza Izzatul Arshad', '6A', 'Laki-laki', NULL, '2024-11-15 01:07:48', '2024-11-15 01:07:48'),
(148, '192001069', '0129588483', 'Muhammad Dirga Maizar Rafli', '6A', 'Laki-laki', NULL, '2024-11-15 01:07:48', '2024-11-15 01:07:48'),
(149, '192001071', '0133906562', 'Muhammad Fatih Alkina', '6A', 'Laki-laki', NULL, '2024-11-15 01:07:48', '2024-11-15 01:07:48'),
(150, '192001073', '0135266656', 'Muhammad Hilmi Almujahid', '6A', 'Laki-laki', NULL, '2024-11-15 01:07:48', '2024-11-15 01:07:48'),
(151, '192001074', '0123722565', 'Muhammad Kaysan Kenzie Tigus', '6A', 'Laki-laki', NULL, '2024-11-15 01:07:48', '2024-11-15 01:07:48'),
(152, '192001079', '0137183308', 'Muhammad Shabiy \nArfan Ar Rifai', '6A', 'Laki-laki', NULL, '2024-11-15 01:07:48', '2024-11-15 01:07:48'),
(153, '192001084', '0122592264', 'Naifa Alecia Nonci', '6A', 'Perempuan', NULL, '2024-11-15 01:07:48', '2024-11-15 01:07:48'),
(154, '192001089', '0134128958', 'Naurah Chantika Salsabilla', '6A', 'Perempuan', NULL, '2024-11-15 01:07:48', '2024-11-15 01:07:48'),
(155, '192001091', '0136830908', 'Quinnara Adni Shakeela', '6A', 'Perempuan', NULL, '2024-11-15 01:07:48', '2024-11-15 01:07:48'),
(156, '192001097', '0129609631', 'Raisa Salsabila', '6A', 'Perempuan', NULL, '2024-11-15 01:07:48', '2024-11-15 01:07:48'),
(157, '192001100', '0122607178', 'Rayyan Syazwan Nafiz', '6A', 'Laki-laki', NULL, '2024-11-15 01:07:49', '2024-11-15 01:07:49'),
(158, '192001109', '0137322751', 'Yumi Faizia Hanifah', '6A', 'Perempuan', NULL, '2024-11-15 01:07:49', '2024-11-15 01:07:49'),
(159, '192001111', '0126623541', 'Zahrania Dawiyah', '6A', 'Perempuan', NULL, '2024-11-15 01:07:49', '2024-11-15 01:07:49'),
(160, '192001112', '0126861651', 'Zahrayya Kamila Latisha', '6A', 'Perempuan', NULL, '2024-11-15 01:07:49', '2024-11-15 01:07:49'),
(161, '192001001', '0139321761', 'Affan Ahsan Nurindra', '6C', 'Laki-laki', NULL, '2024-11-15 01:09:18', '2024-11-15 01:09:18'),
(162, '192001011', '0125957496', 'Althaf Syamil Arrasyid', '6C', 'Laki-laki', NULL, '2024-11-15 01:09:18', '2024-11-15 01:09:18'),
(163, '192001014', '0135649577', 'Aqilah Zahirah Kazhimah', '6C', 'Perempuan', NULL, '2024-11-15 01:09:18', '2024-11-15 01:09:18'),
(164, '212203113', '132461049', 'Aracelia Calysta', '6C', 'Perempuan', NULL, '2024-11-15 01:09:18', '2024-11-15 01:09:18'),
(165, '192001019', '0138933336', 'Bagas Audric Indratama', '6C', 'Laki-laki', NULL, '2024-11-15 01:09:18', '2024-11-15 01:09:18'),
(166, '192001021', '0129428252', 'Daffa Alvaro Aryasatya', '6C', 'Laki-laki', NULL, '2024-11-15 01:09:18', '2024-11-15 01:09:18'),
(167, '192001024', '3132616098', 'Dhiya Akhtar Harimurthi', '6C', 'Laki-laki', NULL, '2024-11-15 01:09:18', '2024-11-15 01:09:18'),
(168, '192001027', '3128325858', 'Fadli Aseffa Kiarad', '6C', 'Laki-laki', NULL, '2024-11-15 01:09:18', '2024-11-15 01:09:18'),
(169, '192001031', '0123091777', 'Fakhri Zuhair Akram', '6C', 'Laki-laki', NULL, '2024-11-15 01:09:18', '2024-11-15 01:09:18'),
(170, '192001047', '0136160814', 'Kayumi Puteri Mutiara', '6C', 'Perempuan', NULL, '2024-11-15 01:09:18', '2024-11-15 01:09:18'),
(171, '192001048', '0131263583', 'Keenand Athaya Adhyatama', '6C', 'Laki-laki', NULL, '2024-11-15 01:09:18', '2024-11-15 01:09:18'),
(172, '192001051', '0128365849', 'Khayla Belvania Charnie', '6C', 'Perempuan', NULL, '2024-11-15 01:09:18', '2024-11-15 01:09:18'),
(173, '192001053', '0136770985', 'Kinan Akhtar Mahera', '6C', 'Laki-laki', NULL, '2024-11-15 01:09:18', '2024-11-15 01:09:18'),
(174, '192001054', '0121106546', 'Kinanthi Ayunda Putri', '6C', 'Perempuan', NULL, '2024-11-15 01:09:18', '2024-11-15 01:09:18'),
(175, '192001055', '0124808384', 'Lizayani Ramadhina Putri', '6C', 'Perempuan', NULL, '2024-11-15 01:09:18', '2024-11-15 01:09:18'),
(176, '192001066', '0135154633', 'Muhammad Arham Zunnurain Rifai', '6C', 'Laki-laki', NULL, '2024-11-15 01:09:19', '2024-11-15 01:09:19'),
(177, '192001068', '0134872138', 'Muhammad Azmi Taqiyyuddin', '6C', 'Laki-laki', NULL, '2024-11-15 01:09:19', '2024-11-15 01:09:19'),
(178, '192001076', '0137336255', 'Muhammad Rafardhan Athaya', '6C', 'Laki-laki', NULL, '2024-11-15 01:09:19', '2024-11-15 01:09:19'),
(179, '192001077', '0136225885', 'Muhammad Rasya Athaya', '6C', 'Laki-laki', NULL, '2024-11-15 01:09:19', '2024-11-15 01:09:19'),
(180, '192001085', '0123985812', 'Najwa Aisyah Zahra Wibisono', '6C', 'Perempuan', NULL, '2024-11-15 01:09:19', '2024-11-15 01:09:19'),
(181, '192001096', '0138478412', 'Raisa Nacita Budiawan', '6C', 'Perempuan', NULL, '2024-11-15 01:09:19', '2024-11-15 01:09:19'),
(182, '192001101', '0132871208', 'Razka Faeyza Al-Abyaz', '6C', 'Laki-laki', NULL, '2024-11-15 01:09:19', '2024-11-15 01:09:19'),
(183, '192001102', '0135664432', 'Riani Adhystiara Witandra', '6C', 'Perempuan', NULL, '2024-11-15 01:09:19', '2024-11-15 01:09:19'),
(184, '192001103', '0128735945', 'Salsabila Agni Sopian', '6C', 'Perempuan', NULL, '2024-11-15 01:09:19', '2024-11-15 01:09:19'),
(185, '192001104', '0132047456', 'Sayyid Zabdan Syafiq', '6C', 'Laki-laki', NULL, '2024-11-15 01:09:19', '2024-11-15 01:09:19'),
(186, '192001107', '0131008109', 'Yaqdhan Rakha Assaid', '6C', 'Laki-laki', NULL, '2024-11-15 01:09:19', '2024-11-15 01:09:19'),
(187, '192001108', '0122106417', 'Yasmine Zainiyah Ahmad', '6C', 'Perempuan', NULL, '2024-11-15 01:09:19', '2024-11-15 01:09:19'),
(188, '192001002', '0128228465', 'Afia Zahra Qanita Menoadji', '6D', 'Perempuan', NULL, '2024-11-15 01:10:18', '2024-11-15 01:10:18'),
(189, '192001003', '3132680095', 'Ahmad Alhawarizmi', '6D', 'Laki-laki', NULL, '2024-11-15 01:10:18', '2024-11-15 01:10:18'),
(190, '192001004', '0138946501', 'Ahmad Athallah Budiman', '6D', 'Laki-laki', NULL, '2024-11-15 01:10:19', '2024-11-15 01:10:19'),
(192, '192001010', '0126315475', 'Alma Nurizza Tampubolon', '6D', 'Perempuan', NULL, '2024-11-15 01:10:19', '2024-11-15 01:10:19'),
(193, '192001012', '0139063316', 'Anisa Zafira Anum', '6D', 'Perempuan', NULL, '2024-11-15 01:10:19', '2024-11-15 01:10:19'),
(194, '192001013', '3139107517', 'Aqila Hanifah', '6D', 'Perempuan', NULL, '2024-11-15 01:10:19', '2024-11-15 01:10:19'),
(195, '192001016', '0125381963', 'Arif Rahman Hakim', '6D', 'Laki-laki', NULL, '2024-11-15 01:10:19', '2024-11-15 01:10:19'),
(196, '192001025', '3135132532', 'Dyah Deryn Anindya', '6D', 'Perempuan', NULL, '2024-11-15 01:10:19', '2024-11-15 01:10:19'),
(197, '192001026', '0126616512', 'El Azzam Dzaky Khoiruddin', '6D', 'Laki-laki', NULL, '2024-11-15 01:10:19', '2024-11-15 01:10:19'),
(198, '192001029', '0137383000', 'Fahryan Nabil Wibisana', '6D', 'Laki-laki', NULL, '2024-11-15 01:10:19', '2024-11-15 01:10:19'),
(199, '192001033', '3134626714', 'Fathiyah Hilwah Aliyah', '6D', 'Perempuan', NULL, '2024-11-15 01:10:19', '2024-11-15 01:10:19'),
(200, '192001039', '3128146950', 'Halim Abbasy', '6D', 'Laki-laki', NULL, '2024-11-15 01:10:19', '2024-11-15 01:10:19'),
(201, '192001042', '3139146726', 'Hayumi Azzahra Harsyaputri', '6D', 'Perempuan', NULL, '2024-11-15 01:10:19', '2024-11-15 01:10:19'),
(202, '192001043', '0132158299', 'Jeffry Alexander Ferdy Kraus', '6D', 'Laki-laki', NULL, '2024-11-15 01:10:19', '2024-11-15 01:10:19'),
(203, '192001058', '0126509160', 'Maisyanova Ayrazka Albana', '6D', 'Perempuan', NULL, '2024-11-15 01:10:19', '2024-11-15 01:10:19'),
(204, '192001064', '0136172325', 'Muhamad Hanif Amrullah', '6D', 'Laki-laki', NULL, '2024-11-15 01:10:19', '2024-11-15 01:10:19'),
(205, '192001065', '3131797166', 'Muhammad Alfatih', '6D', 'Laki-laki', NULL, '2024-11-15 01:10:19', '2024-11-15 01:10:19'),
(206, '192001067', '0128193322', 'Muhammad Arkan Oktrakiya', '6D', 'Laki-laki', NULL, '2024-11-15 01:10:19', '2024-11-15 01:10:19'),
(207, '192001070', '0134590254', 'Muhammad Fathir Radinka', '6D', 'Laki-laki', NULL, '2024-11-15 01:10:20', '2024-11-15 01:10:20'),
(208, '192001075', '0137893578', 'Muhammad Kenzie Azka', '6D', 'Laki-laki', NULL, '2024-11-15 01:10:20', '2024-11-15 01:10:20'),
(209, '192001081', '0123633504', 'Muhammad Syabil Izfanaya', '6D', 'Laki-laki', NULL, '2024-11-15 01:10:20', '2024-11-15 01:10:20'),
(210, '192001086', '0138088207', 'Natasya Kayla Lathiifah', '6D', 'Perempuan', NULL, '2024-11-15 01:10:20', '2024-11-15 01:10:20'),
(211, '192001087', '3125385793', 'Naufal Dzaky Kurniawan', '6D', 'Laki-laki', NULL, '2024-11-15 01:10:20', '2024-11-15 01:10:20'),
(212, '192001090', '0139938654', 'Pranajarafa Dzakwan Fadhlurrohman', '6D', 'Laki-laki', NULL, '2024-11-15 01:10:20', '2024-11-15 01:10:20'),
(213, '192001092', '0138164866', 'Rachel Sabita Humaira', '6D', 'Perempuan', NULL, '2024-11-15 01:10:20', '2024-11-15 01:10:20'),
(218, '192001110', '0121425793', 'Zahran Ibrahim Hernanda', '6D', 'Laki-laki', NULL, '2024-12-04 20:51:04', '2024-12-04 20:51:04'),
(219, '192001005', '0137060260', 'Aila Syifa Raihana Sihombing', '6D', 'Perempuan', NULL, '2024-12-04 20:53:37', '2024-12-04 20:53:37');

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
(1, '6A', 'Siska Maryana Dewi S.Si.,S.Pd.', NULL, '2025-02-09 00:36:55'),
(2, '6B', 'Gunawan, S.Kom', NULL, '2025-02-09 00:38:04'),
(3, '6C', 'Irma Oktaviana Majid, S.Pt', NULL, '2025-02-09 00:38:18'),
(4, '6D', 'Asep Rudini Setiawan, S.Pi.,M.Pd', NULL, '2025-02-09 00:38:37');

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
(11, 'Bahasa Arab', '...', '2024-11-13 23:29:48', '2024-11-13 23:30:02');

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
(5, 'Admin', 'admin@aliya.com', '$2y$12$h0PrOiGr9DgCdQqYXdtm/.F8P1QkByI.8KxukvD5zzHkhS./6CUSi', 'admin', '2024-11-28 21:19:28', '2025-01-21 01:12:59', 'images/logo.png', NULL),
(6, 'Wali Kelas 6C', 'walas6c@aliya.com', '$2y$12$oUHM9cKP/T9ZZYWaeKRKHu5eLaV3wQg/PmmI9h1MOREpysBGcyA3.', 'user', '2024-11-28 21:22:50', '2024-11-28 21:41:26', NULL, '6C'),
(7, 'Wali Kelas 6D', 'walas6d@aliya.com', '$2y$12$Lf4SZeE/RodUsAr068Hpp.diZxzS/3O/7eOcmFO4bbenM1J9rVYku', 'user', '2024-11-28 21:23:11', '2024-11-28 21:23:11', NULL, '6D');

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
-- Indexes for table `ppdb_grades`
--
ALTER TABLE `ppdb_grades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`);

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
-- Indexes for table `school_profiles`
--
ALTER TABLE `school_profiles`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

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
-- AUTO_INCREMENT for table `ppdb_grades`
--
ALTER TABLE `ppdb_grades`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `report_cards`
--
ALTER TABLE `report_cards`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT for table `report_card_subjects`
--
ALTER TABLE `report_card_subjects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=733;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `school_profiles`
--
ALTER TABLE `school_profiles`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `school_years`
--
ALTER TABLE `school_years`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=255;

--
-- AUTO_INCREMENT for table `student_classes`
--
ALTER TABLE `student_classes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

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
-- Constraints for table `ppdb_grades`
--
ALTER TABLE `ppdb_grades`
  ADD CONSTRAINT `ppdb_grades_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

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
