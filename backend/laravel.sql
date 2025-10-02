-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 02, 2025 at 05:42 AM
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
-- Database: `laravel`
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

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel_cache_doe@gmail.com|127.0.0.1', 'i:2;', 1753957211),
('laravel_cache_doe@gmail.com|127.0.0.1:timer', 'i:1753957211;', 1753957211),
('laravel_cache_golden.dooley@example.com|127.0.0.1', 'i:1;', 1753959531),
('laravel_cache_golden.dooley@example.com|127.0.0.1:timer', 'i:1753959531;', 1753959531);

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
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `shop_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `shop_id`, `created_at`, `updated_at`) VALUES
(1, 'Electronic', 1, '2025-07-29 09:08:15', '2025-07-29 09:08:15'),
(2, 'Clothing', 1, '2025-07-29 09:17:02', '2025-07-29 09:17:02'),
(3, 'Books', 1, '2025-07-29 09:17:44', '2025-07-29 09:17:44'),
(4, 'Home Appliances', 1, '2025-07-29 09:17:58', '2025-07-29 09:17:58'),
(5, 'Painting things', 1, '2025-07-29 09:19:54', '2025-07-29 09:19:54'),
(10, 'Mobile Accessories', 1, '2025-07-29 09:26:56', '2025-07-29 09:26:56'),
(11, 'Phone Cases & Covers', 1, '2025-07-29 09:27:25', '2025-07-29 09:27:25'),
(12, 'Chargers & Cables', 1, '2025-07-29 09:27:36', '2025-07-29 09:27:36'),
(13, 'Phone Batteries', 1, '2025-07-29 09:27:48', '2025-07-29 09:27:48'),
(14, 'Home Accessories', 1, '2025-07-29 09:42:58', '2025-07-29 09:42:58'),
(16, 'Laptops', 2, '2025-07-29 09:56:35', '2025-07-29 09:56:35'),
(17, 'Mobile Phones', 2, '2025-07-29 09:56:50', '2025-07-29 09:56:50'),
(18, 'Mobile Accessories', 2, '2025-07-29 09:57:03', '2025-07-29 09:57:03'),
(19, 'Computer Accessories', 2, '2025-07-29 09:57:16', '2025-07-29 09:57:16'),
(20, 'Home Appliances', 2, '2025-07-29 09:57:27', '2025-07-29 09:57:27'),
(21, 'Clothing - Men', 2, '2025-07-29 09:57:43', '2025-07-29 09:57:43'),
(22, 'Clothing - Women', 2, '2025-07-29 09:57:58', '2025-07-29 09:57:58'),
(23, 'Health & Beauty', 2, '2025-07-29 09:58:12', '2025-07-29 09:58:12'),
(24, 'Groceries', 2, '2025-07-29 09:58:25', '2025-07-29 09:58:25'),
(26, 'Sedans', 4, '2025-07-30 22:26:08', '2025-07-30 22:26:08'),
(27, 'SUVs', 4, '2025-07-30 22:26:20', '2025-07-30 22:26:20'),
(28, 'Trucks', 4, '2025-07-30 22:26:33', '2025-07-30 22:26:33'),
(29, 'Electric Vehicles (EVs)', 4, '2025-07-30 22:26:47', '2025-07-30 22:26:47'),
(30, 'Luxury Cars', 4, '2025-07-30 22:27:01', '2025-07-30 22:27:01'),
(31, 'Compact / Hatchbacks', 4, '2025-07-30 22:27:12', '2025-07-30 22:27:12'),
(32, 'Sports Cars', 4, '2025-07-30 22:27:23', '2025-07-30 22:27:23'),
(33, 'Mobile Accessories', 4, '2025-07-31 08:54:59', '2025-07-31 08:54:59');

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
(4, '2025_06_21_145734_create_shops_table', 1),
(5, '2025_06_21_145908_create_categories_table', 1),
(6, '2025_06_21_150332_create_products_table', 1),
(7, '2025_06_21_151303_create_orders_table', 1),
(8, '2025_06_21_151525_create_order_details_table', 1),
(9, '2025_06_22_153547_add_columns_to_users_table', 1),
(10, '2025_06_23_140240_create_permission_tables', 1),
(11, '2025_07_13_121948_create_personal_access_tokens_table', 1);

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
(1, 'App\\Models\\User', 2),
(1, 'App\\Models\\User', 3),
(1, 'App\\Models\\User', 4),
(1, 'App\\Models\\User', 6),
(2, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 7),
(2, 'App\\Models\\User', 8),
(2, 'App\\Models\\User', 10),
(3, 'App\\Models\\User', 5),
(3, 'App\\Models\\User', 9),
(3, 'App\\Models\\User', 11),
(3, 'App\\Models\\User', 12),
(3, 'App\\Models\\User', 13),
(3, 'App\\Models\\User', 14),
(3, 'App\\Models\\User', 15),
(3, 'App\\Models\\User', 16),
(3, 'App\\Models\\User', 17),
(3, 'App\\Models\\User', 18);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `no` varchar(255) NOT NULL,
  `delivery_date` text DEFAULT NULL,
  `remark` decimal(10,2) NOT NULL,
  `user_code` varchar(255) NOT NULL DEFAULT '0',
  `pics` varchar(255) DEFAULT NULL,
  `types` varchar(255) DEFAULT NULL,
  `colors` varchar(255) DEFAULT NULL,
  `status` enum('accepted','rejected') NOT NULL DEFAULT 'accepted',
  `shop_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` longtext DEFAULT NULL,
  `price` int(11) NOT NULL,
  `types` varchar(255) DEFAULT NULL,
  `colors` varchar(255) DEFAULT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `name` text NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 2, 'auth_token', '71cb42be15cbb4b4faa4af1fac98488891bc7092ef8a49bb09530b8ae1e9a72b', '[\"*\"]', NULL, NULL, '2025-07-24 09:44:44', '2025-07-24 09:44:44'),
(2, 'App\\Models\\User', 11, 'auth_token', '00635d024b483dca5c22bfb77f7e93f6c8ea33aabf845dacd364f9706a6f5d33', '[\"*\"]', '2025-07-24 09:56:06', NULL, '2025-07-24 09:54:26', '2025-07-24 09:56:06'),
(3, 'App\\Models\\User', 12, 'auth_token', 'd2728bab87650c0dfbebe17d66941b65f2349eac2844eb6528573de43e441f4c', '[\"*\"]', '2025-07-24 10:03:30', NULL, '2025-07-24 10:00:13', '2025-07-24 10:03:30'),
(4, 'App\\Models\\User', 13, 'auth_token', 'ffa4cd1dd98e168c07889f6bd7a6b0982b3d831956af3dff7fbcdd30828690f9', '[\"*\"]', '2025-07-24 19:04:22', NULL, '2025-07-24 18:56:58', '2025-07-24 19:04:22'),
(5, 'App\\Models\\User', 14, 'auth_token', '3e3875c40b2fd4175e917c184d468631c48459ef2567006928a4d7fd7fc547f2', '[\"*\"]', '2025-07-24 19:09:11', NULL, '2025-07-24 19:06:28', '2025-07-24 19:09:11'),
(6, 'App\\Models\\User', 14, 'auth_token', '8c98676525a8f88ce6a284c8c8f0766312a10bf1217ac6200ff1acf2dbd03045', '[\"*\"]', '2025-07-24 19:09:28', NULL, '2025-07-24 19:09:26', '2025-07-24 19:09:28'),
(7, 'App\\Models\\User', 15, 'auth_token', 'a9d25685f0e79ced95ebb404c82e1d2d62f0e746b752b33c3434d7ea4a14a346', '[\"*\"]', NULL, NULL, '2025-07-24 19:34:43', '2025-07-24 19:34:43'),
(8, 'App\\Models\\User', 15, 'auth_token', 'ee384f4eb7792465665c0049c20b4159b6d4836466035e4218842451258514ba', '[\"*\"]', '2025-07-24 19:35:04', NULL, '2025-07-24 19:34:57', '2025-07-24 19:35:04'),
(9, 'App\\Models\\User', 15, 'auth_token', '1e62922850ce9c1551c46697e9e8b6409b8fcad6c04d3e83ed60d7a1afcb72d4', '[\"*\"]', '2025-07-25 23:00:33', NULL, '2025-07-25 00:30:55', '2025-07-25 23:00:33'),
(10, 'App\\Models\\User', 16, 'auth_token', 'e59607dc5da5295395b73a7ad9310a3eac75b240d1954d89a827bf5439e94b07', '[\"*\"]', NULL, NULL, '2025-07-25 23:15:32', '2025-07-25 23:15:32'),
(11, 'App\\Models\\User', 16, 'auth_token', '1760d7c1b112da51601d70b4e8216697d7f938a9256b8e11377625a875b74b5e', '[\"*\"]', '2025-07-27 18:39:40', NULL, '2025-07-25 23:15:45', '2025-07-27 18:39:40'),
(12, 'App\\Models\\User', 16, 'auth_token', '7dc076491650c91391eaccab8fdcfece880344894d5b944c51faab9121b191f7', '[\"*\"]', '2025-07-28 00:02:32', NULL, '2025-07-28 00:02:27', '2025-07-28 00:02:32'),
(13, 'App\\Models\\User', 17, 'auth_token', '7f707174aa4a8b3e278f779d6e720069735d9c5b9768ac0c2eeb34089856989c', '[\"*\"]', '2025-07-30 21:51:47', NULL, '2025-07-28 00:12:25', '2025-07-30 21:51:47'),
(14, 'App\\Models\\User', 18, 'auth_token', 'c8735d8a116139e124d830e69b8275e88db8de47535bddcf2935518734fe27f0', '[\"*\"]', '2025-07-31 03:36:03', NULL, '2025-07-30 21:52:43', '2025-07-31 03:36:03'),
(15, 'App\\Models\\User', 11, 'auth_token', '97133ab0c3a007ea0832acbd81b63967b22d8c74ab157603aa19be7c747072c8', '[\"*\"]', '2025-08-01 20:43:02', NULL, '2025-07-31 09:05:06', '2025-08-01 20:43:02');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `discount` int(11) NOT NULL DEFAULT 0,
  `pics` text DEFAULT NULL,
  `video` text DEFAULT NULL,
  `types` text DEFAULT NULL,
  `colors` text DEFAULT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `shop_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `discount`, `pics`, `video`, `types`, `colors`, `stock`, `category_id`, `shop_id`, `created_at`, `updated_at`) VALUES
(45, 'Swift Car', 'Model 2022', 200000.00, 1, NULL, NULL, '200,500', NULL, 123, 29, 4, '2025-08-01 19:37:16', '2025-08-01 19:37:16'),
(47, 'Luxus', 'Luxus is the best', 250000.00, 10, NULL, NULL, 'car', NULL, 15, 30, 4, '2025-08-01 19:44:13', '2025-08-01 19:44:13'),
(49, 'ROG Laptop', 'ROG Gaming Laptop CPU 8 core and performance is good', 2500.00, 1, NULL, NULL, '\"Laptop\"', NULL, 100, 16, 2, '2025-08-01 19:53:12', '2025-08-01 19:53:12'),
(50, 'Macbook', '512 G and generation 12 and core 9 processor CPU', 3000.00, 10, NULL, NULL, NULL, NULL, 100, 16, 2, '2025-08-01 19:56:51', '2025-08-01 19:56:51'),
(51, 'I phone 14 pro max', '256 G  battery 480', 2500.00, 20, NULL, NULL, NULL, NULL, 50, 17, 2, '2025-08-01 20:00:02', '2025-08-01 20:00:02'),
(52, 'Samsung phone', '128 G and Ram 8', 2000.00, 15, NULL, NULL, NULL, NULL, 100, 17, 2, '2025-08-01 20:01:14', '2025-08-01 20:01:14'),
(53, 'Phone Cover', 'asdfgh', 16.00, 1, '\"product_pics\\/WqYPA53VJLqYekn80Zvbqk1HfNB9gLQgjotqfLVB.jpg\"', NULL, NULL, NULL, 122, 23, 1, '2025-08-01 20:42:47', '2025-08-01 20:57:56');

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
(1, 'admin', 'web', '2025-07-24 08:38:42', '2025-07-24 08:38:42'),
(2, 'admin', 'web', '2025-07-24 08:38:42', '2025-07-24 08:38:42'),
(3, 'customer', 'web', '2025-07-24 08:38:42', '2025-07-24 08:38:42');

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
('4pxDsIpQaswSUuYpyRpxIyJ5zqkDSoZ3bClSO4cs', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoic0l5d1FaMXdvSDdrNmp1WWJhUmI1eHZnZWRyYWdLN0hSNWhlZlVjQiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9vcmRlciI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7czo0OiJhdXRoIjthOjE6e3M6MjE6InBhc3N3b3JkX2NvbmZpcm1lZF9hdCI7aToxNzUzOTU5NTQ3O319', 1753961219),
('HbQkGnNrzxQUz1XsNke37u9j2HLGrIghivx2Bfxp', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36 Edg/138.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiS00wcGVOQzlaVWJaaG8wRFI4cWM0NEpiTUpSZ3ZDQmo0Zk9Ka1NnZiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1753959475),
('n7EjgeDW1AzYTdssXABuw8GdngzThn1teha6r1ed', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWXFVOHdUVGs3S2NUaGhkNWc3a3NhOGpMdmxndWtBTG40WUtic2RRWCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9vcmRlciI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1753974914),
('qocMC0r0wznGcxccZNbWfgqVD9ybsU3aysRNlcov', 10, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:141.0) Gecko/20100101 Firefox/141.0', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiR045NDg3UWJWRnIzRjVkbzBkQkRHOWp4M1VKMGlrbWt2MFRsZ0NhQyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9jYXRlZ29yeSI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjEwO3M6NDoiYXV0aCI7YToxOntzOjIxOiJwYXNzd29yZF9jb25maXJtZWRfYXQiO2k6MTc1Mzk3NTM0NDt9fQ==', 1753975910),
('TuZrDrLP6M06YItm47dLRXh8EszH9gD7rsPy0yGd', 8, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:141.0) Gecko/20100101 Firefox/141.0', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiaml4ZlRvQnRncXF5VEo2WmpqRnFsR2pWeWJaQ21aekxvcWY0ek1sNCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjk6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9wcm9kdWN0Ijt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6ODtzOjQ6ImF1dGgiO2E6MTp7czoyMToicGFzc3dvcmRfY29uZmlybWVkX2F0IjtpOjE3NTQxMDEyNzI7fX0=', 1754102436),
('U7N3yT9DuFXyVXO4RDtg3S43RxJL6nHk3LfcrPDV', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiMkZwZjg4R1VnSGkxdUVnajY2Tlk5T1FhUmVtRHh4Rzc0Qmg0U3ViRiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9wcm9kdWN0LzUzL2VkaXQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO3M6NDoiYXV0aCI7YToxOntzOjIxOiJwYXNzd29yZF9jb25maXJtZWRfYXQiO2k6MTc1NDEwNDIzODt9fQ==', 1754106063);

-- --------------------------------------------------------

--
-- Table structure for table `shops`
--

CREATE TABLE `shops` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `profile_pic` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `social_links` varchar(255) DEFAULT NULL,
  `street` varchar(255) DEFAULT NULL,
  `unit` varchar(255) DEFAULT NULL,
  `address` varchar(255) NOT NULL,
  `postal_code` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shops`
--

INSERT INTO `shops` (`id`, `name`, `profile_pic`, `description`, `social_links`, `street`, `unit`, `address`, `postal_code`, `phone`, `created_at`, `updated_at`, `user_id`) VALUES
(1, 'Electronic', 'storage/shops/Electronic/Electronic.jpg', 'this is a description', NULL, '73street', '11', '3455', '3455', '09873736211', '2025-07-29 09:01:17', '2025-07-29 09:59:38', 1),
(2, 'Shopfinity', 'storage/shops/Shopfinity/Shopfinity.jpg', 'Welcome to Shopfinity, where shopping meets convenience and variety! We offer a wide selection of quality products across multiple categories—from electronics and mobile accessories to fashion, beauty, home essentials, and more. Whether you\'re looking for the latest gadgets, stylish apparel, or everyday household items, Shopfinity brings it all to your fingertips at affordable prices.  Enjoy a seamless shopping experience with fast delivery, secure payments, and 24/7 customer support. At Shopfinity, we’re committed to delivering value, trust, and satisfaction with every order.', NULL, '62street 107/108', '25', 'Mandalay', '3333', '0987654321', '2025-07-29 09:55:48', '2025-07-29 09:55:48', 8),
(3, 'SwiftBuy', 'storage/shops/SwiftBuy/SwiftBuy.jpg', 'welcome to SWiftBuy', NULL, '19 street', '46', '553344', '553344', '0987654321', '2025-07-30 22:04:22', '2025-07-30 22:07:42', 7),
(4, 'Velocity Auto Hub', 'storage/shops/VelocityAutoHub/VelocityAutoHub.jpg', 'welcome to  Ev car shop', '\"https:\\/\\/ev.com\\/yourpage\"', 'MaharVandula street', '56', 'Yangon , Myanmar.', '5544', '0987654321', '2025-07-30 22:18:53', '2025-07-30 22:18:53', 10);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `default_address` varchar(255) DEFAULT NULL,
  `phone` varchar(255) NOT NULL,
  `profile_pic` varchar(255) DEFAULT NULL,
  `user_code` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `default_address`, `phone`, `profile_pic`, `user_code`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Prof. Conor Gerhold', 'predovic.nicholas@example.net', '95539 Tatum Camp Suite 746\nPort Wellingtonbury, VT 69595-6274', '1-312-618-3087', 'https://picsum.photos/200/300', 'osp-QjKD-Prof. Conor Gerhold', '2025-07-24 08:38:44', '$2y$12$uiGiCD55MJWhfyPdEVmaoOq6xazIbRJjRzfPDGwtlCHKUAywl1lqW', 'J1Xeu2H3c5wiDvkZwo12wUyte3KEmoaLDwiDeA9ongLDmNFvG0ULS4TS38DH', '2025-07-24 08:38:45', '2025-07-24 08:38:45'),
(2, 'Anastacio Nikolaus', 'ssteuber@example.com', '93449 Nash Tunnel Apt. 357\nBartellhaven, IA 94039', '870-587-2914', 'https://picsum.photos/200/300', 'osp-x3g1-Anastacio Nikolaus', '2025-07-24 08:38:45', '$2y$12$uiGiCD55MJWhfyPdEVmaoOq6xazIbRJjRzfPDGwtlCHKUAywl1lqW', 'y8nxRRHMHgI3ooDzJcIZaFKxHw7Ch8B2NcJ4f7q6AtrCIJsSlox1DyfWu7DN', '2025-07-24 08:38:45', '2025-07-24 08:38:45'),
(3, 'Hank Mante', 'dubuque.angel@example.org', '395 Leffler Port Suite 162\nGutkowskiside, LA 21351-6407', '(703) 761-9224', 'https://picsum.photos/200/300', 'osp-Ucga-Hank Mante', '2025-07-24 08:38:45', '$2y$12$uiGiCD55MJWhfyPdEVmaoOq6xazIbRJjRzfPDGwtlCHKUAywl1lqW', '9Z9CPaWAZz', '2025-07-24 08:38:45', '2025-07-24 08:38:45'),
(4, 'Nicolette Klocko', 'leffertz@example.com', '151 Berniece Islands Suite 627\nSoledadmouth, NJ 06083', '904.710.9826', 'https://picsum.photos/200/300', 'osp-FdiP-Nicolette Klocko', '2025-07-24 08:38:45', '$2y$12$uiGiCD55MJWhfyPdEVmaoOq6xazIbRJjRzfPDGwtlCHKUAywl1lqW', 'HfvHvQsvOm', '2025-07-24 08:38:45', '2025-07-24 08:38:45'),
(5, 'Prof. Roselyn Feil I', 'zcremin@example.net', '73111 Miracle Union\nLake Elmer, ME 40038-3177', '+1.432.471.3380', 'https://picsum.photos/200/300', 'osp-iAAf-Prof. Roselyn Feil I', '2025-07-24 08:38:45', '$2y$12$uiGiCD55MJWhfyPdEVmaoOq6xazIbRJjRzfPDGwtlCHKUAywl1lqW', 'RVVah9kauA', '2025-07-24 08:38:45', '2025-07-24 08:38:45'),
(6, 'Jackie Reichert', 'vluettgen@example.org', '4682 Bergstrom Vista Suite 242\nEast Jazmyn, DC 09156', '1-213-313-5801', 'https://picsum.photos/200/300', 'osp-QwM7-Jackie Reichert', '2025-07-24 08:38:45', '$2y$12$uiGiCD55MJWhfyPdEVmaoOq6xazIbRJjRzfPDGwtlCHKUAywl1lqW', '1YRikxuoAa', '2025-07-24 08:38:45', '2025-07-24 08:38:45'),
(7, 'Ms. Brandyn Watsica', 'fbednar@example.net', '92288 Alivia Stream Apt. 330\nJarenfort, SC 00768-1957', '+1-216-700-3519', 'https://picsum.photos/200/300', 'osp-9qXv-Ms. Brandyn Watsica', '2025-07-24 08:38:45', '$2y$12$uiGiCD55MJWhfyPdEVmaoOq6xazIbRJjRzfPDGwtlCHKUAywl1lqW', 'QLBSrM0FxJAjqybAVLMQjQlit7WFVxI7M8HR00BeusIgBTJCI4AkCChy6mEN', '2025-07-24 08:38:45', '2025-07-24 08:38:45'),
(8, 'Timothy Abbott', 'mcdermott.alvah@example.com', '7718 Immanuel Lock\nPort Sylvan, OH 17651', '+1-689-903-1081', 'https://picsum.photos/200/300', 'osp-u6Tb-Timothy Abbott', '2025-07-24 08:38:45', '$2y$12$uiGiCD55MJWhfyPdEVmaoOq6xazIbRJjRzfPDGwtlCHKUAywl1lqW', '9HJ58unHPcRlWDAKxcvsO7zrSItdE9mc2RhdCg3wCnTG2sqWafurpcRPMRLm', '2025-07-24 08:38:45', '2025-07-24 08:38:45'),
(9, 'Hilton Wolff', 'flo79@example.org', '56237 Jamel Ferry\nO\'Haraland, OH 92720-5043', '(817) 943-2522', 'https://picsum.photos/200/300', 'osp-JgbJ-Hilton Wolff', '2025-07-24 08:38:45', '$2y$12$uiGiCD55MJWhfyPdEVmaoOq6xazIbRJjRzfPDGwtlCHKUAywl1lqW', '5m4liSc4GcshwnqugYpWaDj7amrekRWBArQM0pdMFHAOBROi84sqKUJTiiXX', '2025-07-24 08:38:45', '2025-07-24 08:38:45'),
(10, 'Yessenia Hudson', 'flatley.emma@example.org', '6243 Antoinette Haven Apt. 279\nBartellview, PA 34442-3882', '+1-915-703-2839', 'https://picsum.photos/200/300', 'osp-H31n-Yessenia Hudson', '2025-07-24 08:38:45', '$2y$12$uiGiCD55MJWhfyPdEVmaoOq6xazIbRJjRzfPDGwtlCHKUAywl1lqW', 'bgvmwfW5lmY9YkbAIXDGmfeLAQmPzZeXbGoON8dLgmq39ZFHk23YrKr27gEb', '2025-07-24 08:38:45', '2025-07-24 08:38:45'),
(11, 'thura', 'thura@gmail.com', NULL, '09873736211', NULL, 'osp-V7kT-thura', NULL, '$2y$12$ylSGZj9EfV3P.YdieY6gj.hAsy1DX2rFiwDDQcTyoU7k5BtYWYNMW', NULL, '2025-07-24 09:54:26', '2025-07-24 09:54:26'),
(12, 'Paing Soe Lin', 'paingsoelin@gmail.com', NULL, '09873736211', NULL, 'osp-W4XQ-Paing Soe Lin', NULL, '$2y$12$okZe8kACjB/iYD/DJ/e9..3JRxnEtrR97bU3nVT0TLsNLoU7zc1L2', NULL, '2025-07-24 10:00:13', '2025-07-24 10:00:13'),
(13, 'mgmg', 'mgmg@gmail.com', NULL, '1234567890', NULL, 'osp-fQUK-mgmg', NULL, '$2y$12$buJbTJVmqTqqXz.2hfzaYOK19kOaOmZhe9EDFC0pdlpl03xsLFnLq', NULL, '2025-07-24 18:56:57', '2025-07-24 18:56:57'),
(14, 'thuthu', 'thuthu@gmail.com', NULL, '0987654321', NULL, 'osp-GySP-thuthu', NULL, '$2y$12$JRKZ0fUM31wsgYzNTUDHfO8y8N529/sLqOrmNLwptYuUymWfOaa7a', NULL, '2025-07-24 19:06:28', '2025-07-24 19:06:28'),
(15, 'aung', 'aung@gmail.com', NULL, '0987654321', NULL, 'osp-Zr8x-aung', NULL, '$2y$12$5lvXN4ijmeWdLwk75rFJDOyS1KZg4QtrKIKKeh3gvJ2C.kGS5V5LK', NULL, '2025-07-24 19:34:42', '2025-07-24 19:34:42'),
(16, 'ayeaye', 'ayeaye@gmail.com', NULL, '09873736211', NULL, 'osp-3ywX-ayeaye', NULL, '$2y$12$plkmxsnr/urOw6OFFyafxOr4Woi35hxCcr5zmAQ8l5YRb73UM9mkO', NULL, '2025-07-25 23:15:32', '2025-07-25 23:15:32'),
(17, 'toetoe', 'toetoe@gmail.com', NULL, '0987654321', NULL, 'osp-Txd6-toetoe', NULL, '$2y$12$oNoOFAgOJnvZ6goLbWkYAOVj6LV/sI1Hq8vCwRp5D/MJw.a0TSPxG', NULL, '2025-07-28 00:12:25', '2025-07-28 00:12:25'),
(18, 'Joe', 'Joe@gmail.com', NULL, '09123456789', NULL, 'osp-NWZg-Joe', NULL, '$2y$12$tuFGM5OgrTFVNGZNCf8T/O2QBQTJTM2SxoCepiklgE1GI3FaCQOFO', NULL, '2025-07-30 21:52:43', '2025-07-30 21:52:43');

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
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

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
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `shops`
--
ALTER TABLE `shops`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `shops`
--
ALTER TABLE `shops`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

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
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
