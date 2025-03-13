-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 13, 2025 at 09:46 AM
-- Server version: 10.11.10-MariaDB
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u569290000_flipsell`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `youtube` varchar(255) DEFAULT NULL,
  `whatsapp` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `socials` text DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `youtube`, `whatsapp`, `mobile`, `password`, `socials`, `instagram`, `facebook`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Super Admin1', 'admin@gmail.com', 'www.youtube.com', '+61 412 345 678', '+61 412 345 678', '$2y$12$bXUMp3yDF49GVbaDtvHgpen.JPykz/GCDnZ6qRqP0t4imbzXxe7Aq', 'www.google.com', 'www.instagram.com', 'www.facebook.com', '2025-02-05 03:39:57', '2025-02-14 09:49:09', NULL),
(2, 'Admin 2', 'admin2@gmail.co', NULL, NULL, '9898978678', '$2y$12$YfTmacP43K7QkKxoCrdgeO4rDLgUQHhc9Edn.YmTYM0EAzo0.7wkW', 'www.google.com', NULL, NULL, '2025-02-12 06:52:04', '2025-02-12 06:52:04', NULL),
(3, 'Admin 3', 'admin3@gmail.com', NULL, NULL, '87665897765', '$2y$12$aCGmcYv6i5bUcoIGCDwNg.7559w59h8JX11d/qId0XffTLcq1sQLy', 'www.google.com', NULL, NULL, '2025-02-12 06:53:03', '2025-02-12 08:17:10', '2025-02-12 08:17:10'),
(4, 'pooja admin', 'adminpj@gmail.com', NULL, NULL, '6767676767', '$2y$12$E.4aM1cU7JICB.Iu9kQD8eP1r0KuOuRTThCBMortwu.kTlEUFaxQ.', 'www.google.com', NULL, NULL, '2025-02-12 06:54:20', '2025-02-12 08:17:07', '2025-02-12 08:17:07');

-- --------------------------------------------------------

--
-- Table structure for table `ads`
--

CREATE TABLE `ads` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `add_set` varchar(255) DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `image1` text DEFAULT NULL,
  `link1` text DEFAULT NULL,
  `image2` text DEFAULT NULL,
  `link2` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ads`
--

INSERT INTO `ads` (`id`, `add_set`, `image`, `link`, `created_at`, `updated_at`, `deleted_at`, `image1`, `link1`, `image2`, `link2`) VALUES
(1, 'Home', 'https://qualcastbeta.in/flipsell/public/assets/images/1739189647_0.jpg', 'https://www.google.co.in/', '2025-02-10 06:44:07', '2025-03-05 10:51:17', NULL, 'https://qualcastbeta.in/flipsell/public/assets/images/1739353228.jpg', 'www.mac.com', 'https://qualcastbeta.in/flipsell/public/assets/images/174117187767c82ca5cfdd9.png', 'www.test2.com'),
(2, 'Plan1', 'https://qualcastbeta.in/flipsell/public/assets/images/1739353253.jpg', 'https://www.google.co.in/3', '2025-02-10 06:44:44', '2025-02-12 09:40:53', NULL, 'https://qualcastbeta.in/flipsell/public/assets/images/1739190037.jpg', 'www.test.com', 'https://qualcastbeta.in/flipsell/public/assets/images/1739190037.jpg', 'www.test1com'),
(3, 'Plan2', 'https://qualcastbeta.in/flipsell/public/assets/images/1739189684_1.jpg', 'https://www.bing.com/images/', '2025-02-10 06:44:44', '2025-02-10 06:44:44', NULL, 'https://qualcastbeta.in/flipsell/public/assets/images/1739189684_1.jpg', 'www.test.com', 'https://qualcastbeta.in/flipsell/public/assets/images/1739189684_1.jpg', 'www.test.com');

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
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `number` int(11) DEFAULT NULL,
  `category_name` varchar(255) NOT NULL,
  `sub_of` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `number`, `category_name`, `sub_of`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 7, 'Carpentry', 0, '2025-02-07 01:42:38', '2025-03-05 11:05:57', NULL),
(4, 16, 'test category', 0, '2025-02-07 03:57:04', '2025-02-07 03:57:11', '2025-02-07 03:57:11'),
(5, NULL, 'Cabinet Making', 2, '2025-02-07 04:17:43', '2025-02-07 05:21:07', NULL),
(6, 8, 'Plumbing', 0, '2025-02-07 05:01:14', '2025-03-05 11:06:05', NULL),
(7, 10, 'Electrical', 0, '2025-02-07 05:01:39', '2025-03-05 12:21:13', NULL),
(8, NULL, 'Leak Repair', 6, '2025-02-07 05:02:34', '2025-02-07 05:02:34', NULL),
(9, NULL, 'Pipe Installation', 6, '2025-02-07 05:04:41', '2025-02-07 05:04:41', NULL),
(10, NULL, 'Drain Cleaning', 6, '2025-02-07 05:10:11', '2025-02-07 06:00:47', '2025-02-07 06:00:47'),
(11, NULL, 'Custom Furniture Making', 2, '2025-02-07 05:13:21', '2025-02-07 05:13:21', NULL),
(12, 6, 'Interior Design', 0, '2025-02-07 08:10:05', '2025-03-05 11:05:52', NULL),
(13, 13, 'Test Sub Category', 12, '2025-02-07 08:10:25', '2025-02-07 08:10:36', '2025-02-07 08:10:36'),
(14, 12, 'Wiring', 7, '2025-02-14 06:32:53', '2025-02-14 06:32:53', NULL),
(15, 11, 'Photography Works', 0, '2025-02-14 06:33:32', '2025-02-14 06:33:53', '2025-02-14 06:33:53'),
(16, 5, 'Don', 0, '2025-02-17 09:25:08', '2025-03-05 11:05:46', NULL),
(17, 9, 'Delta', 16, '2025-02-17 09:25:25', '2025-02-17 09:25:25', NULL),
(18, 3, 'Rent', 0, '2025-02-19 06:41:57', '2025-03-05 11:05:35', NULL),
(19, 4, 'Wedding', 0, '2025-02-19 06:45:28', '2025-03-05 11:05:40', NULL),
(20, 4, 'Catering', 19, '2025-02-19 06:46:26', '2025-03-05 11:27:10', NULL),
(21, 3, 'Photography', 19, '2025-02-19 06:46:37', '2025-03-05 11:27:04', NULL),
(22, 2, 'Wedding Gown', 19, '2025-02-19 06:47:22', '2025-03-05 11:21:32', NULL),
(23, 2, 'Services', 0, '2025-02-19 06:48:59', '2025-03-05 11:05:30', NULL),
(24, NULL, 'Woodworking Tools', 2, '2025-03-05 02:16:30', '2025-03-05 02:18:37', '2025-03-05 02:18:37'),
(25, NULL, 'Woodworking Tools', 2, '2025-03-05 02:17:14', '2025-03-05 02:18:45', '2025-03-05 02:18:45'),
(26, 2, 'Woodworking Tools', 2, '2025-03-05 02:18:31', '2025-03-05 02:18:31', NULL),
(27, 1, 'Test Category', 0, '2025-03-05 11:00:02', '2025-03-05 11:00:02', NULL),
(28, 1, 'Makeup', 19, '2025-03-05 11:15:16', '2025-03-05 11:15:16', NULL),
(29, 2, 'DON', 0, '2025-03-06 08:14:25', '2025-03-06 08:14:25', NULL),
(30, 1, 'delta', 16, '2025-03-06 08:14:58', '2025-03-06 08:15:16', NULL),
(31, 1, 'Catering', 27, '2025-03-06 09:45:46', '2025-03-06 09:45:46', NULL),
(32, 2, 'Services', 29, '2025-03-06 09:46:50', '2025-03-06 09:46:50', NULL);

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
-- Table structure for table `job_requests`
--

CREATE TABLE `job_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `budget` decimal(10,2) DEFAULT NULL,
  `category_id` int(11) NOT NULL,
  `subcategory_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `flexible` tinyint(1) NOT NULL DEFAULT 0,
  `looking_for` varchar(255) NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `tags` varchar(255) DEFAULT NULL,
  `distance_limit` decimal(10,2) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `business_id` int(11) DEFAULT NULL,
  `accepted_time` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `job_date` datetime DEFAULT NULL,
  `job_date_flexible` int(1) NOT NULL DEFAULT 0,
  `address` text DEFAULT NULL,
  `image_1` varchar(255) DEFAULT NULL,
  `image_2` varchar(255) DEFAULT NULL,
  `image_3` varchar(255) DEFAULT NULL,
  `full_screen_image` int(1) NOT NULL DEFAULT 0,
  `connect_type` varchar(255) DEFAULT NULL,
  `location_langitude` varchar(255) DEFAULT NULL,
  `location_longitude` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `job_requests`
--

INSERT INTO `job_requests` (`id`, `budget`, `category_id`, `subcategory_id`, `description`, `flexible`, `looking_for`, `location`, `tags`, `distance_limit`, `user_id`, `status`, `business_id`, `accepted_time`, `created_at`, `updated_at`, `job_date`, `job_date_flexible`, `address`, `image_1`, `image_2`, `image_3`, `full_screen_image`, `connect_type`, `location_langitude`, `location_longitude`) VALUES
(1, 1000.00, 2, 3, 'For wedding photos', 1, 'Photographer', 'Edappally', 'Not very urgent', 10.00, 4, 1, 41, NULL, '2025-03-01 06:49:19', '2025-03-08 18:34:52', '2025-02-28 09:30:00', 1, 'Test house, Kochi, Edappally', '', '', '', 0, 'Call', NULL, NULL),
(2, 1000.00, 1, 1, 'For wedding photos', 1, 'Photographer', 'Edappally', 'Not very urgent', 10.00, 4, 0, NULL, NULL, '2025-03-01 06:51:00', '2025-03-01 06:51:00', '2025-02-28 09:30:00', 1, 'Test house, Kochi, Edappally', '', '', '', 0, 'Call', NULL, NULL),
(3, 1000.00, 1, 1, 'For wedding photos', 1, 'Photographer', 'Edappally', 'Not very urgent', 10.00, 4, 0, NULL, NULL, '2025-03-01 07:31:08', '2025-03-01 07:31:08', '2025-02-28 09:30:00', 1, 'Test house, Kochi, Edappally', '', '', '', 0, 'Call', NULL, NULL),
(4, 10005.00, 1, 3, 'For wedding photos', 1, 'Photographer', 'Edappally', 'Not very urgent', 10.00, 4, 0, NULL, NULL, '2025-03-01 11:51:26', '2025-03-01 11:51:26', '2025-02-28 09:30:00', 1, 'Test house, Kochi, Edappally', '', '', '', 0, 'Call', '212323', '132334'),
(5, 1000.00, 1, 1, 'For wedding photos', 1, 'Photographer', 'Edappally', 'Not very urgent', 10.00, 4, 0, NULL, NULL, '2025-03-02 11:58:17', '2025-03-02 11:58:17', '2025-02-28 09:30:00', 1, 'Test house, Kochi, Edappally', '', '', '', 0, 'Call', NULL, NULL),
(6, 1000.00, 1, 1, 'For wedding photos', 1, 'Photographer', 'Edappally', 'Not very urgent', 10.00, 4, 0, NULL, NULL, '2025-03-06 17:41:14', '2025-03-06 17:41:14', '2025-02-28 09:30:00', 1, 'Test house, Kochi, Edappally', '', '', '', 0, 'Call', NULL, NULL),
(7, 1000.00, 1, 1, 'For wedding photos', 1, 'Photographer', 'Edappally', 'Not very urgent', 10.00, 4, 0, NULL, NULL, '2025-03-06 18:07:51', '2025-03-06 18:07:51', '2025-02-28 09:30:00', 1, 'Test house, Kochi, Edappally', '', '', '', 0, NULL, NULL, NULL),
(8, 1000.00, 1, 1, 'For wedding photos', 1, 'Photographer', 'Edappally', 'Not very urgent', 10.00, 4, 0, NULL, NULL, '2025-03-06 18:07:52', '2025-03-06 18:07:52', '2025-02-28 09:30:00', 1, 'Test house, Kochi, Edappally', '', '', '', 0, NULL, NULL, NULL),
(9, 1000.00, 1, 1, 'For wedding photos', 1, 'Photographer', 'Edappally', 'Not very urgent', 10.00, 4, 0, NULL, NULL, '2025-03-06 18:11:05', '2025-03-06 18:11:05', '2025-02-28 09:30:00', 1, 'Test house, Kochi, Edappally', '', '', '', 0, NULL, NULL, NULL),
(10, 1000.00, 1, 1, 'For wedding photos', 1, 'Photographer', 'Edappally', 'Not very urgent', 10.00, 4, 0, NULL, NULL, '2025-03-06 18:11:33', '2025-03-06 18:11:33', '2025-02-28 09:30:00', 1, 'Test house, Kochi, Edappally', '', '', '', 0, NULL, NULL, NULL),
(11, 1000.00, 1, 1, 'For wedding photos', 1, 'Photographer', 'Edappally', 'Not very urgent', 10.00, 4, 0, NULL, NULL, '2025-03-06 18:11:34', '2025-03-06 18:11:34', '2025-02-28 09:30:00', 1, 'Test house, Kochi, Edappally', '', '', '', 0, NULL, NULL, NULL),
(12, 1000.00, 1, 1, 'For wedding photos', 1, 'Photographer', 'Edappally', 'Not very urgent', 10.00, 4, 0, NULL, NULL, '2025-03-06 18:11:52', '2025-03-06 18:11:52', '2025-02-28 09:30:00', 1, 'Test house, Kochi, Edappally', '', '', '', 0, NULL, NULL, NULL),
(13, 1000.00, 1, 1, 'For wedding photos', 1, 'Photographer', 'Edappally', 'Not very urgent', 10.00, 4, 0, NULL, NULL, '2025-03-06 18:12:08', '2025-03-06 18:12:08', '2025-02-28 09:30:00', 1, 'Test house, Kochi, Edappally', '', '', '', 0, NULL, NULL, '222'),
(14, 1000.00, 1, 1, 'For wedding photos', 1, 'Photographer', 'Edappally', 'Not very urgent', 10.00, 4, 0, NULL, NULL, '2025-03-06 18:12:09', '2025-03-06 18:12:09', '2025-02-28 09:30:00', 1, 'Test house, Kochi, Edappally', '', '', '', 0, NULL, NULL, '222'),
(15, 1000.00, 1, 1, 'For wedding photos', 1, 'Photographer', 'Edappally', 'Not very urgent', 10.00, 4, 0, NULL, NULL, '2025-03-06 18:12:22', '2025-03-06 18:12:22', '2025-02-28 09:30:00', 1, 'Test house, Kochi, Edappally', '', '', '', 0, NULL, NULL, '222'),
(16, 1000.00, 1, 1, 'For wedding photos', 1, 'Photographer', 'Edappally', 'Not very urgent', 10.00, 4, 0, NULL, NULL, '2025-03-06 18:12:23', '2025-03-06 18:12:23', '2025-02-28 09:30:00', 1, 'Test house, Kochi, Edappally', '', '', '', 0, NULL, NULL, '222'),
(17, 1000.00, 1, 1, 'For wedding photos', 1, 'Photographer', 'Edappally', 'Not very urgent', 10.00, 4, 0, NULL, NULL, '2025-03-06 18:14:47', '2025-03-06 18:14:47', '2025-02-28 09:30:00', 1, 'Test house, Kochi, Edappally', '', '', '', 0, NULL, NULL, '222'),
(18, 1000.00, 1, 1, 'For wedding photos', 1, 'Photographer', 'Edappally', 'Not very urgent', 10.00, 4, 0, NULL, NULL, '2025-03-06 18:14:48', '2025-03-06 18:14:48', '2025-02-28 09:30:00', 1, 'Test house, Kochi, Edappally', '', '', '', 0, NULL, NULL, '222'),
(19, 1000.00, 1, 1, 'For wedding photos', 1, 'Photographer', 'Edappally', 'Not very urgent', 10.00, 4, 0, NULL, NULL, '2025-03-06 18:14:49', '2025-03-06 18:14:49', '2025-02-28 09:30:00', 1, 'Test house, Kochi, Edappally', '', '', '', 0, NULL, NULL, '222'),
(20, 1000.00, 1, 1, 'For wedding photos', 1, 'Photographer', 'Edappally', 'Not very urgent', 10.00, 4, 0, NULL, NULL, '2025-03-06 18:14:50', '2025-03-06 18:14:50', '2025-02-28 09:30:00', 1, 'Test house, Kochi, Edappally', '', '', '', 0, NULL, NULL, '222'),
(21, 1000.00, 1, 1, 'For wedding photos', 1, 'Photographer', 'Edappally', 'Not very urgent', 10.00, 4, 0, NULL, NULL, '2025-03-06 18:14:57', '2025-03-06 18:14:57', '2025-02-28 09:30:00', 1, 'Test house, Kochi, Edappally', '', '', '', 0, 'call', NULL, '222'),
(22, 1000.00, 1, 1, 'For wedding photos', 1, 'Photographer', 'Edappally', 'Not very urgent', 10.00, 4, 0, NULL, NULL, '2025-03-06 18:14:58', '2025-03-06 18:14:58', '2025-02-28 09:30:00', 1, 'Test house, Kochi, Edappally', '', '', '', 0, 'call', NULL, '222'),
(23, 1000.00, 1, 1, 'For wedding photos', 1, 'Photographer', 'Edappally', 'Not very urgent', 10.00, 4, 0, NULL, NULL, '2025-03-06 18:17:55', '2025-03-06 18:17:55', '2025-02-28 09:30:00', 1, 'Test house, Kochi, Edappally', '', '', '', 0, 'call', NULL, '222'),
(24, 1000.00, 1, 1, 'For wedding photos', 1, 'Photographer', 'Edappally', 'Not very urgent', 10.00, 4, 0, NULL, NULL, '2025-03-06 18:18:13', '2025-03-06 18:18:13', '2025-02-28 09:30:00', 1, 'Test house, Kochi, Edappally', '', '', '', 0, 'call', NULL, '222'),
(25, 1000.00, 1, 1, 'For wedding photos', 1, 'Photographer', 'Edappally', 'Not very urgent', 10.00, 4, 0, NULL, NULL, '2025-03-06 18:18:18', '2025-03-08 18:18:18', '2025-02-28 09:30:00', 1, 'Test house, Kochi, Edappally', '', '', '', 0, 'call', '10.975971951215806', '76.22493195397942'),
(26, 1000.00, 1, 1, 'For wedding photos', 1, 'Photographer', 'Edappally', 'Not very urgent', 10.00, 4, 0, NULL, NULL, '2025-03-06 18:18:44', '2025-03-06 18:18:44', '2025-02-28 09:30:00', 1, 'Test house, Kochi, Edappally', '', '', '', 0, 'call', NULL, '222'),
(27, 1000.00, 1, 1, 'For wedding photos', 1, 'Photographer', 'Edappally', 'Not very urgent', 10.00, 4, 0, NULL, NULL, '2025-03-06 18:25:12', '2025-03-06 18:25:12', '2025-02-28 09:30:00', 1, 'Test house, Kochi, Edappally', '', '', '', 0, 'call', NULL, '222'),
(28, 122.00, 2, 5, 'wwwwwwww', 0, 'okkk', 'WWK Arena, Bürgermeister-Ulrich-Straße, Augsburg-Universitätsviertel, Germany', 'Okkk', 67.00, 4, 0, NULL, NULL, '2025-03-06 18:25:28', '2025-03-06 18:25:28', '2025-03-06 23:24:32', 0, 'Rrrrr', '', '', '', 1, 'call', NULL, '10.886418'),
(29, 122.00, 2, 5, 'wwwwwwww', 0, 'okkk', 'WWK Arena, Bürgermeister-Ulrich-Straße, Augsburg-Universitätsviertel, Germany', 'Okkk', 67.00, 4, 0, NULL, NULL, '2025-03-06 18:25:29', '2025-03-06 18:25:29', '2025-03-06 23:24:32', 0, 'Rrrrr', '', '', '', 1, 'call', NULL, '10.886418'),
(30, 122.00, 2, 5, 'wwwwwwww', 0, 'okkk', 'WWK Arena, Bürgermeister-Ulrich-Straße, Augsburg-Universitätsviertel, Germany', 'Okkk', 67.00, 4, 0, NULL, NULL, '2025-03-06 18:25:30', '2025-03-06 18:25:30', '2025-03-06 23:24:32', 0, 'Rrrrr', '', '', '', 1, 'call', NULL, '10.886418'),
(31, 122.00, 2, 5, 'wwwwwwww', 0, 'okkk', 'WWK Arena, Bürgermeister-Ulrich-Straße, Augsburg-Universitätsviertel, Germany', 'Okkk', 67.00, 4, 0, NULL, NULL, '2025-03-06 18:25:30', '2025-03-06 18:25:30', '2025-03-06 23:24:32', 0, 'Rrrrr', '', '', '', 1, 'call', NULL, '10.886418'),
(32, 1000.00, 1, 1, 'For wedding photos', 1, 'Photographer', 'Edappally', 'Not very urgent', 10.00, 4, 0, NULL, NULL, '2025-03-06 18:33:34', '2025-03-06 18:33:34', '2025-02-28 09:30:00', 1, 'Test house, Kochi, Edappally', '', '', '', 0, 'call', NULL, '222'),
(33, 1000.00, 1, 1, 'For wedding photos', 1, 'Photographer', 'Edappally', 'Not very urgent', 10.00, 4, 0, NULL, NULL, '2025-03-06 18:34:06', '2025-03-06 18:34:06', '2025-02-28 09:30:00', 1, 'Test house, Kochi, Edappally', '', '', '', 0, 'call', NULL, '222'),
(34, 1000.00, 1, 1, 'For wedding photos', 1, 'Photographer', 'Edappally', 'Not very urgent', 10.00, 4, 0, NULL, NULL, '2025-03-06 18:41:03', '2025-03-06 18:41:03', '2025-02-28 09:30:00', 1, 'Test house, Kochi, Edappally', '', '', '', 0, 'call', NULL, '222'),
(35, 1000.00, 1, 1, 'For wedding photos', 1, 'Photographer', 'Edappally', 'Not very urgent', 10.00, 4, 0, NULL, NULL, '2025-03-06 18:41:17', '2025-03-06 18:41:17', '2025-02-28 09:30:00', 1, 'Test house, Kochi, Edappally', '', '', '', 0, 'call', NULL, '222'),
(36, 1000.00, 1, 1, 'For wedding photos', 1, 'Photographer', 'Edappally', 'Not very urgent', 10.00, 10, 0, NULL, NULL, '2025-03-06 18:42:07', '2025-03-06 18:42:07', '2025-02-28 09:30:00', 1, 'Test house, Kochi, Edappally', '', '', '', 0, 'call', NULL, '222'),
(37, 1000.00, 1, 1, 'For wedding photos', 1, 'Photographer', 'Edappally', 'Not very urgent', 10.00, 10, 0, NULL, NULL, '2025-03-06 18:42:08', '2025-03-06 18:42:08', '2025-02-28 09:30:00', 1, 'Test house, Kochi, Edappally', '', '', '', 0, 'call', NULL, '222'),
(38, 1000.00, 1, 1, 'For wedding photos', 1, 'Photographer', 'Edappally', 'Not very urgent', 10.00, 4, 0, NULL, NULL, '2025-03-06 18:42:16', '2025-03-06 18:42:16', '2025-02-28 09:30:00', 1, 'Test house, Kochi, Edappally', '', '', '', 0, 'call', NULL, '222'),
(39, 1000.00, 1, 1, 'For wedding photos', 1, 'Photographer', 'Edappally', 'Not very urgent', 10.00, 4, 0, NULL, NULL, '2025-03-06 18:42:17', '2025-03-06 18:42:17', '2025-02-28 09:30:00', 1, 'Test house, Kochi, Edappally', '', '', '', 0, 'call', NULL, '222'),
(40, 1000.00, 1, 1, 'For wedding photos', 1, 'Photographer', 'Edappally', 'Not very urgent', 10.00, 10, 0, NULL, NULL, '2025-03-06 18:44:03', '2025-03-06 18:44:03', '2025-02-28 09:30:00', 1, 'Test house, Kochi, Edappally', '', '', '', 0, 'call', NULL, '222'),
(41, 1000.00, 1, 1, 'For wedding photos', 1, 'Photographer', 'Edappally', 'Not very urgent', 10.00, 10, 0, NULL, NULL, '2025-03-06 18:44:03', '2025-03-06 18:44:03', '2025-02-28 09:30:00', 1, 'Test house, Kochi, Edappally', '', '', '', 0, 'call', NULL, '222'),
(42, 1000.00, 1, 1, 'For wedding photos', 1, 'Photographer', 'Edappally', 'Not very urgent', 10.00, 10, 0, NULL, NULL, '2025-03-06 18:44:15', '2025-03-06 18:44:15', '2025-02-28 09:30:00', 1, 'Test house, Kochi, Edappally', '', '', '', 0, 'call', NULL, '222'),
(43, 1000.00, 1, 1, 'For wedding photos', 1, 'Photographer', 'Edappally', 'Not very urgent', 10.00, 10, 0, NULL, NULL, '2025-03-06 18:44:29', '2025-03-06 18:44:29', '2025-02-28 09:30:00', 1, 'Test house, Kochi, Edappally', '', '', '', 0, 'call', NULL, '222'),
(44, 1000.00, 1, 1, 'For wedding photos', 1, 'Photographer', 'Edappally', 'Not very urgent', 10.00, 10, 0, NULL, NULL, '2025-03-06 18:44:48', '2025-03-06 18:44:48', '2025-02-28 09:30:00', 1, 'Test house, Kochi, Edappally', '', '', '', 0, 'call', NULL, '222'),
(45, 1000.00, 1, 1, 'For wedding photos', 1, 'Photographer', 'Edappally', 'Not very urgent', 10.00, 10, 0, NULL, NULL, '2025-03-06 18:45:00', '2025-03-06 18:45:00', '2025-02-28 09:30:00', 1, 'Test house, Kochi, Edappally', '', '', '', 0, 'call', NULL, '222'),
(46, 1000.00, 1, 1, 'For wedding photos', 1, 'Photographer', 'Edappally', 'Not very urgent', 10.00, 4, 0, NULL, NULL, '2025-03-06 18:50:33', '2025-03-06 18:50:33', '2025-02-28 09:30:00', 1, 'Test house, Kochi, Edappally', '', '', '', 0, 'call', NULL, '222'),
(47, 1000.00, 1, 1, 'For wedding photos', 1, 'Photographer', 'Edappally', 'Not very urgent', 10.00, 4, 0, NULL, NULL, '2025-03-06 18:57:22', '2025-03-06 18:57:22', '2025-02-28 09:30:00', 1, 'Test house, Kochi, Edappally', '', '', '', 0, 'call', NULL, '222'),
(48, 122.00, 2, 5, 'wwwwwwww', 0, 'okkk', 'WWK Arena, Bürgermeister-Ulrich-Straße, Augsburg-Universitätsviertel, Germany', 'Okkk', 67.00, 4, 0, NULL, NULL, '2025-03-06 19:02:10', '2025-03-06 19:02:10', '2025-03-06 23:24:32', 0, 'Rrrrr', '', '', '', 1, 'call', NULL, '10.886418'),
(49, 122.00, 2, 5, 'wwwwwwww', 0, 'okkk', 'WWK Arena, Bürgermeister-Ulrich-Straße, Augsburg-Universitätsviertel, Germany', 'Okkk', 67.00, 4, 0, NULL, NULL, '2025-03-06 19:02:11', '2025-03-06 19:02:11', '2025-03-06 23:24:32', 0, 'Rrrrr', '', '', '', 1, 'call', NULL, '10.886418'),
(50, 122.00, 2, 5, 'wwwwwwww', 0, 'okkk', 'WWK Arena, Bürgermeister-Ulrich-Straße, Augsburg-Universitätsviertel, Germany', 'Okkk', 67.00, 10, 0, NULL, NULL, '2025-03-06 19:03:03', '2025-03-06 19:03:03', '2025-03-06 23:24:32', 0, 'Rrrrr', '', '', '', 1, 'call', NULL, '10.886418'),
(51, 122.00, 2, 5, 'wwwwwwww', 0, 'okkk', 'WWK Arena, Bürgermeister-Ulrich-Straße, Augsburg-Universitätsviertel, Germany', 'Okkk', 67.00, 4, 0, NULL, NULL, '2025-03-06 19:05:57', '2025-03-06 19:05:57', '2025-03-06 23:24:32', 0, 'Rrrrr', '', '', '', 1, 'call', NULL, '10.886418'),
(52, 122.00, 2, 5, 'wwwwwwww', 0, 'okkk', 'WWK Arena, Bürgermeister-Ulrich-Straße, Augsburg-Universitätsviertel, Germany', 'Okkk', 67.00, 4, 0, NULL, NULL, '2025-03-06 19:06:04', '2025-03-06 19:06:04', '2025-03-06 23:24:32', 0, 'Rrrrr', '', '', '', 1, 'call', NULL, '10.886418'),
(53, 122.00, 2, 5, 'wwwwwwww', 0, 'okkk', 'WWK Arena, Bürgermeister-Ulrich-Straße, Augsburg-Universitätsviertel, Germany', 'Okkk', 67.00, 4, 0, NULL, NULL, '2025-03-06 19:06:05', '2025-03-06 19:06:05', '2025-03-06 23:24:32', 0, 'Rrrrr', '', '', '', 1, 'call', NULL, '10.886418'),
(54, 122.00, 2, 5, 'wwwwwwww', 0, 'okkk', 'WWK Arena, Bürgermeister-Ulrich-Straße, Augsburg-Universitätsviertel, Germany', 'Okkk', 67.00, 4, 0, NULL, NULL, '2025-03-06 19:06:16', '2025-03-06 19:06:16', '2025-03-06 23:24:32', 0, 'Rrrrr', '', '', '', 0, 'call', NULL, '10.886418'),
(55, 122.00, 2, 5, 'wwwwwwww', 0, 'okkk', 'WWK Arena, Bürgermeister-Ulrich-Straße, Augsburg-Universitätsviertel, Germany', 'Okkk', 67.00, 4, 0, NULL, NULL, '2025-03-06 19:06:17', '2025-03-06 19:06:17', '2025-03-06 23:24:32', 0, 'Rrrrr', '', '', '', 0, 'call', NULL, '10.886418'),
(56, 122.00, 2, 5, 'wwwwwwww', 0, 'okkk', 'WWK Arena, Bürgermeister-Ulrich-Straße, Augsburg-Universitätsviertel, Germany', 'Okkk', 67.00, 4, 0, NULL, NULL, '2025-03-06 19:06:39', '2025-03-06 19:06:39', '2025-03-06 23:24:32', 0, 'Rrrrr', '', '', '', 0, 'call', NULL, '10.886418'),
(57, 122.00, 2, 5, 'wwwwwwww', 0, 'okkk', 'WWK Arena, Bürgermeister-Ulrich-Straße, Augsburg-Universitätsviertel, Germany', 'Okkk', 67.00, 4, 0, NULL, NULL, '2025-03-06 19:06:47', '2025-03-06 19:06:47', '2025-03-06 23:24:32', 0, 'Rrrrr', '', '', '', 0, 'call', NULL, '10.886418'),
(58, 122.00, 2, 5, 'wwwwwwww', 0, 'okkk', 'WWK Arena, Bürgermeister-Ulrich-Straße, Augsburg-Universitätsviertel, Germany', 'Okkk', 67.00, 4, 0, NULL, NULL, '2025-03-06 19:06:48', '2025-03-06 19:06:48', '2025-03-06 23:24:32', 0, 'Rrrrr', '', '', '', 0, 'call', NULL, '10.886418'),
(59, 122.00, 2, 5, 'wwwwwwww', 0, 'okkk', 'WWK Arena, Bürgermeister-Ulrich-Straße, Augsburg-Universitätsviertel, Germany', 'Okkk', 67.00, 10, 0, NULL, NULL, '2025-03-06 19:07:33', '2025-03-06 19:07:33', '2025-03-06 23:24:32', 0, 'Rrrrr', '', '', '', 0, 'call', NULL, '10.886418'),
(60, 122.00, 2, 5, 'wwwwwwww', 0, 'okkk', 'WWK Arena, Bürgermeister-Ulrich-Straße, Augsburg-Universitätsviertel, Germany', 'Okkk', 67.00, 10, 0, NULL, NULL, '2025-03-06 19:07:35', '2025-03-06 19:07:35', '2025-03-06 23:24:32', 0, 'Rrrrr', '', '', '', 0, 'call', NULL, '10.886418'),
(61, 122.00, 2, 5, 'wwwwwwww', 0, 'okkk', 'WWK Arena, Bürgermeister-Ulrich-Straße, Augsburg-Universitätsviertel, Germany', 'Okkk', 67.00, 10, 0, NULL, NULL, '2025-03-06 19:10:33', '2025-03-06 19:10:33', '2025-03-06 23:24:32', 0, 'Rrrrr', '', '', '', 1, 'call', NULL, '10.886418'),
(62, 122.00, 2, 5, 'wwwwwwww', 0, 'okkk', 'WWK Arena, Bürgermeister-Ulrich-Straße, Augsburg-Universitätsviertel, Germany', 'Okkk', 67.00, 10, 0, NULL, NULL, '2025-03-06 19:10:34', '2025-03-06 19:10:34', '2025-03-06 23:24:32', 0, 'Rrrrr', '', '', '', 1, 'call', NULL, '10.886418'),
(63, 1000.00, 1, 1, 'For wedding photos', 1, 'Photographer', 'Edappally', 'Not very urgent', 10.00, 4, 0, NULL, NULL, '2025-03-06 19:12:49', '2025-03-06 19:12:49', '2025-02-28 09:30:00', 1, 'Test house, Kochi, Edappally', '', '', '', 0, 'call', NULL, '222'),
(64, 1000.00, 1, 1, 'For wedding photos', 1, 'Photographer', 'Edappally', 'Not very urgent', 10.00, 4, 0, NULL, NULL, '2025-03-06 19:13:26', '2025-03-06 19:13:26', '2025-02-28 09:30:00', 1, 'Test house, Kochi, Edappally', '', '/uploads/images/67c9f3d6bcc1c.png', '/uploads/images/67c9f3d6bcf36.png', 0, 'call', NULL, '222'),
(65, 1000.00, 1, 1, 'For wedding photos', 1, 'Photographer', 'Edappally', 'Not very urgent', 10.00, 4, 0, NULL, NULL, '2025-03-06 19:13:27', '2025-03-06 19:13:27', '2025-02-28 09:30:00', 1, 'Test house, Kochi, Edappally', '', '/uploads/images/67c9f3d7f078e.png', '/uploads/images/67c9f3d7f0947.png', 0, 'call', NULL, '222'),
(66, 777.00, 2, 5, 'wwwww', 1, 'nsks', '22 Bishopsgate, London, UK', 'Eeeeee', 90.00, 10, 0, NULL, NULL, '2025-03-06 19:23:59', '2025-03-06 19:23:59', '2025-03-07 00:39:53', 1, 'Eeeeeee', '', '', '', 1, 'call', NULL, '-0.0830479'),
(67, 1222.00, 2, 5, 'ddddddd', 0, 'okkkkk', 'Twentytwo, Bishopsgate, London, UK', 'ddddd', 56.00, 10, 0, NULL, NULL, '2025-03-06 19:28:07', '2025-03-06 19:28:07', '2025-03-07 00:39:53', 0, 'ddddd', '', '', '', 0, 'whatsapp', NULL, '-0.0830479'),
(68, 1200.00, 2, 5, 'okkssssss', 1, 'Select', 'Idukki, Kerala, India', 'tag', 51.00, 10, 0, NULL, NULL, '2025-03-06 19:30:55', '2025-03-06 19:30:55', '2025-03-07 00:59:12', 1, 'Kerala', '', '', '', 1, 'call', NULL, '76.9297354'),
(69, 1200.00, 2, 5, 'okkssssss', 1, 'Select', 'Idukki, Kerala, India', 'tag', 51.00, 10, 0, NULL, NULL, '2025-03-06 19:30:55', '2025-03-06 19:30:55', '2025-03-07 00:59:12', 1, 'Kerala', '', '', '', 1, 'call', NULL, '76.9297354'),
(70, 787878.00, 2, 5, 'jdjkldkljd', 0, 'klkllkd', 'dhjdfhdrgwetwet, Farnsworth Street, Houston, TX, USA', 'iwuuwiue', 31.00, 10, 0, NULL, NULL, '2025-03-06 19:47:36', '2025-03-06 19:47:36', '2025-03-07 01:06:14', 0, 'kjhdhkdjkdh', '', '', '', 1, 'call', NULL, '-95.370012'),
(71, 544.00, 6, 8, 'bvvbbcbvc', 1, 'fgfgfg', 'dhjdfhdrgwetwet, Farnsworth Street, Houston, TX, USA', 'bbvbbvv', 28.00, 10, 0, NULL, NULL, '2025-03-06 19:48:51', '2025-03-06 19:48:51', '2025-03-07 01:06:14', 1, 'fgffggfdg', '', '', '', 1, 'whatsapp', NULL, '-95.370012'),
(72, 2333.00, 6, 8, 'fgffgfgfg', 0, 'fdfdfdfdf', 'HH1A Linh Dam, Phố Linh Đường, Hoàng Liệt, Hoàng Mai, Hanoi, Vietnam', 'ggfgffg', 57.00, 10, 0, NULL, NULL, '2025-03-06 19:53:53', '2025-03-06 19:53:53', '2025-03-07 01:21:57', 0, 'gfggfgfg', '', '', '', 0, 'call', NULL, '105.8259604'),
(73, 1200.00, 2, 5, 'klmdsld;lsd;', 1, 'ddhsjhhsdhsjhd', 'HH1A Linh Đàm, Phố Linh Đường, Hoàng Liệt, Hoàng Mai, Hanoi, Vietnam', 'sklmlkmdkllsd', 89.00, 10, 0, NULL, NULL, '2025-03-06 19:59:43', '2025-03-06 19:59:43', '2025-03-07 01:21:57', 1, 'dmsllsjdlkjsldj', '', '', '', 1, 'whatsapp', NULL, '105.8259604'),
(74, 1200.00, 2, 11, 'mdmskldmsldlksdl', 0, 'sklsk', 'HH1A Linh Đàm, Phố Linh Đường, Tổ dân phố số 63, Hoàng Liệt, Hoàng Mai, Hanoi, Vietnam', 'snllndklsdklsnkldlkd', 65.00, 10, 0, NULL, NULL, '2025-03-06 20:02:35', '2025-03-06 20:02:35', '2025-03-07 01:21:57', 0, 'nsnkldslkdmklsd', '', '', '', 1, 'call', NULL, '105.8383368'),
(75, 1200.00, 6, 8, 'Plumber', 1, 'Plumber', 'Edappal, Kerala, India', 'Work', 80.00, 10, 0, NULL, NULL, '2025-03-07 15:41:40', '2025-03-07 15:41:40', '2025-03-07 21:08:56', 1, 'Kerala', '', '', '', 1, 'call', NULL, '76.0076374'),
(76, 10005.00, 1, 3, 'For wedding photos', 1, 'Photographer', 'Edappally', 'Not very urgent', 10.00, 4, 0, NULL, NULL, '2025-03-08 06:46:40', '2025-03-08 06:46:40', '2025-02-28 09:30:00', 1, 'Test house, Kochi, Edappally', '', '', '', 0, 'Call', '212323', '132334'),
(77, 1000.00, 1, 1, 'For wedding photos', 1, 'Photographer', 'Edappally', 'Not very urgent', 10.00, 4, 0, NULL, NULL, '2025-03-11 17:02:46', '2025-03-11 17:02:46', '2025-02-28 09:30:00', 1, 'Test house, Kochi, Edappally', '', '/uploads/images/67d06cb6aa667.png', '/uploads/images/67d06cb6aa87f.png', 0, 'call', NULL, '222'),
(78, 1000.00, 1, 1, 'For wedding photos', 1, 'Photographer', 'Edappally', 'Not very urgent', 10.00, 4, 0, NULL, NULL, '2025-03-11 17:02:50', '2025-03-11 17:02:50', '2025-02-28 09:30:00', 1, 'Test house, Kochi, Edappally', '', '/uploads/images/67d06cba41ed1.png', '/uploads/images/67d06cba4207c.png', 0, 'call', NULL, '222'),
(79, 1000.00, 1, 1, 'For wedding photos', 1, 'Photographer', 'Edappally', 'Not very urgent', 10.00, 4, 0, NULL, NULL, '2025-03-11 17:03:03', '2025-03-11 17:03:03', '2025-02-28 09:30:00', 1, 'Test house, Kochi, Edappally', '', '/uploads/images/67d06cc75eb9d.png', '/uploads/images/67d06cc75f026.png', 0, 'call', NULL, '222'),
(80, 1000.00, 1, 1, 'For wedding photos', 1, 'Photographer', 'Edappally', 'Not very urgent', 10.00, 4, 0, NULL, NULL, '2025-03-11 17:03:20', '2025-03-11 17:03:20', '2025-02-28 09:30:00', 1, 'Test house, Kochi, Edappally', '', '/uploads/images/67d06cd8518cb.png', '/uploads/images/67d06cd851a8a.png', 0, 'call', NULL, '222'),
(81, 1000.00, 1, 1, 'For wedding photos', 1, 'Photographer', 'Edappally', 'Not very urgent', 10.00, 4, 0, NULL, NULL, '2025-03-11 17:03:23', '2025-03-11 17:03:23', '2025-02-28 09:30:00', 1, 'Test house, Kochi, Edappally', '', '/uploads/images/67d06cdb8084d.png', '/uploads/images/67d06cdb809ed.png', 0, 'call', NULL, '222'),
(82, 1000.00, 1, 1, 'For wedding photos', 1, 'Photographer', 'Edappally', 'Not very urgent', 10.00, 10, 0, NULL, NULL, '2025-03-11 17:03:54', '2025-03-11 17:03:54', '2025-02-28 09:30:00', 1, 'Test house, Kochi, Edappally', '', '/uploads/images/67d06cfad98cd.png', '/uploads/images/67d06cfad9ace.png', 0, 'call', NULL, '222'),
(83, 1000.00, 1, 1, 'For wedding photos', 1, 'Photographer', 'Edappally', 'Not very urgent', 10.00, 10, 0, NULL, NULL, '2025-03-11 17:03:56', '2025-03-11 17:03:56', '2025-02-28 09:30:00', 1, 'Test house, Kochi, Edappally', '', '/uploads/images/67d06cfc1eec0.png', '/uploads/images/67d06cfc1f0b9.png', 0, 'call', NULL, '222'),
(84, 1000.00, 1, 1, 'For wedding photos', 1, 'Photographer', 'Edappally', 'Not very urgent', 10.00, 10, 0, NULL, NULL, '2025-03-11 17:03:58', '2025-03-11 17:03:58', '2025-02-28 09:30:00', 1, 'Test house, Kochi, Edappally', '', '/uploads/images/67d06cfea3cac.png', '/uploads/images/67d06cfea3e6c.png', 0, 'call', NULL, '222');

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `country_name` varchar(255) NOT NULL,
  `country_code` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`id`, `country_name`, `country_code`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'India', '+91', '2025-02-06 06:18:00', '2025-02-14 06:31:33', NULL),
(2, 'Japan', '+81', '2025-02-06 06:18:30', '2025-02-14 06:31:48', NULL),
(3, 'Kazakhstan', '+7', '2025-02-06 06:34:46', '2025-02-14 06:31:59', NULL),
(4, 'tesyt', '+8', '2025-02-07 01:22:58', '2025-02-07 01:25:18', '2025-02-07 01:25:18'),
(5, 'Pakistan', '+92', '2025-02-07 08:08:58', '2025-02-07 08:09:03', '2025-02-07 08:09:03');

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
(4, '2025_02_05_084247_add_fields_to_users_table', 2),
(5, '2025_02_05_084755_create_admins_table', 3),
(6, '2025_02_05_104215_create_categories_table', 4),
(7, '2025_02_05_104445_create_payments_table', 5),
(8, '2025_02_05_105025_create_job_requests_table', 6),
(9, '2025_02_05_110648_create_locations_table', 7),
(10, '2025_02_05_110846_create_plans_table', 8),
(11, '2025_02_05_111025_create_subscriptions_table', 9),
(12, '2025_02_05_111145_add_user_id_to_service_providers_table', 10),
(13, '2025_02_06_052735_add_soft_deletes_to_plans_table', 11),
(14, '2025_02_06_061953_change_location_column_type_in_users_table', 12),
(15, '2025_02_07_063618_add_soft_deletes_to_locations_table', 13),
(16, '2025_02_07_071142_remove_sub_of_foreign_key_from_categories', 14),
(17, '2025_02_07_092502_add_deleted_at_to_categories_table', 15),
(18, '2025_02_10_045510_add_status_and_business_image_to_service_providers_table', 16),
(19, '2025_02_10_105909_create_ads_table', 17),
(20, '2025_02_12_065106_change_socials_column_in_admins_table', 18),
(21, '2025_02_12_080035_add_deleted_at_to_admins_table', 19),
(22, '2025_02_12_083950_add_instagram_and_facebook_to_admins_table', 20),
(23, '2025_02_12_085826_drop_user_id_from_ads_table', 21),
(24, '2025_02_12_090053_add_image_columns_to_ads_table', 22),
(25, '2025_02_14_083530_add_verification_status_to_users_table', 23),
(26, '2025_02_14_094100_add_youtube_whatsapp_to_admins_table', 24),
(27, '2025_02_28_105420_add_currency_and_symbol_to_plans_table', 25),
(28, '2025_02_05_135849_create_personal_access_tokens_table', 26),
(29, '2025_02_19_051839_modify_category_subcategory_to_json', 26),
(30, '2025_02_28_113825_make_email_nullable_in_users_table', 27),
(31, '2025_03_01_102357_add_add_set_to_ads_table', 28),
(32, '2025_03_01_113243_update_job_requests_table', 29),
(33, '2025_03_05_081325_add_country_id_to_users_table', 30),
(34, '2025_03_05_105311_add_number_to_categories_table', 31),
(35, '2025_03_10_105913_create_requests_update_table', 32),
(36, '2025_03_10_110907_add_job_id_to_requests_update_table', 33),
(37, '2025_03_13_052915_create_subcategories_table', 34);

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
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `amount_paid` decimal(10,2) NOT NULL,
  `status` int(11) NOT NULL,
  `payment_gateway_id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `currency` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `amount_paid`, `status`, `payment_gateway_id`, `user_id`, `currency`, `created_at`, `updated_at`) VALUES
(1, 9.99, 1, 'PAY-ABCD1234EFGH5678\n', 2, 'AUD', '2025-02-07 11:40:48', '2025-02-07 11:40:48');

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
-- Table structure for table `plans`
--

CREATE TABLE `plans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `plan_name` varchar(255) NOT NULL,
  `month_no` int(11) NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `currency` varchar(10) NOT NULL DEFAULT 'USD',
  `symbol` varchar(255) NOT NULL DEFAULT '$',
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `plans`
--

INSERT INTO `plans` (`id`, `plan_name`, `month_no`, `price`, `currency`, `symbol`, `description`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Basic Plan', 3, 9.99, 'USD', '$', 'Get access to essential\r\nfeatures and limited resources. \r\nPerfect for beginners.', '2025-02-05 12:11:59', '2025-03-06 09:44:59', NULL),
(2, 'Standard Plan', 6, 19.99, 'USD', '$', 'Enjoy additional features, increased limits, and priority support. Suitable for regular users.', '2025-02-05 07:00:33', '2025-02-14 07:38:24', NULL),
(3, 'Premium Plan', 12, 29.99, 'USD', '$', 'Full access to all features, unlimited resources, and premium support. Best for professionals.', '2025-02-05 07:01:18', '2025-02-14 07:38:38', NULL),
(4, 'test', 1, 100.00, 'USD', '$', 'test', '2025-02-06 00:00:09', '2025-02-06 00:00:17', '2025-02-06 00:00:17'),
(5, 'Test plan2', 2, 100.00, 'USD', '$', 'test', '2025-02-07 08:09:27', '2025-02-07 08:09:44', '2025-02-07 08:09:44');

-- --------------------------------------------------------

--
-- Table structure for table `requests_update`
--

CREATE TABLE `requests_update` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `job_id` bigint(20) UNSIGNED NOT NULL,
  `business_id` bigint(20) UNSIGNED NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `accepted_time` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `requests_update`
--

INSERT INTO `requests_update` (`id`, `job_id`, `business_id`, `status`, `accepted_time`, `created_at`, `updated_at`) VALUES
(1, 1, 10, 1, '2025-03-10 18:37:38', '2025-03-10 18:37:38', '2025-03-10 18:37:38'),
(2, 1, 10, 1, '2025-03-11 16:57:59', '2025-03-11 16:57:59', '2025-03-11 16:57:59');

-- --------------------------------------------------------

--
-- Table structure for table `service_providers`
--

CREATE TABLE `service_providers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`category_id`)),
  `subcategory_id` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`subcategory_id`)),
  `website` varchar(255) DEFAULT NULL,
  `business_image` varchar(255) DEFAULT NULL,
  `business_name` varchar(255) DEFAULT NULL,
  `business_phone` varchar(255) DEFAULT NULL,
  `business_email` varchar(255) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `reg_document` varchar(255) DEFAULT NULL,
  `gst_number` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `service_providers`
--

INSERT INTO `service_providers` (`id`, `category_id`, `subcategory_id`, `website`, `business_image`, `business_name`, `business_phone`, `business_email`, `status`, `reg_document`, `gst_number`, `created_at`, `updated_at`, `user_id`) VALUES
(1, '6', '10', 'https://www.google.com/', 'https://qualcastbeta.in/flipsell/public/assets/images/plum.jpg', NULL, NULL, NULL, 1, 'https://qualcastbeta.in/flipsell/public/assets/images/regi.jpg', '123232', '2025-02-07 11:35:03', '2025-02-19 06:54:53', 2),
(5, '[2]', '[5]', 'https://example.com', 'http://127.0.0.1:8000/assets/images/1740723783_Admin-Login-Logo.png', 'jk', '5454323234', 'jk@gmail.com', 0, 'http://127.0.0.1:8000/assets/images/1740728953_flask.png', '1234567890', '2025-02-20 06:32:09', '2025-02-28 02:19:13', 4),
(6, '[1]', '[5,1]', 'www.google.com', NULL, 'jk', '5454323234', 'jk@gmail.com', 0, NULL, '1228833', '2025-02-28 11:50:19', '2025-02-28 11:50:19', 42),
(7, '[27]', '[31]', 'https://www.abc', NULL, NULL, '0909090909', NULL, 0, 'https://qualcastbeta.in/flipsell-main/public/assets/images/1741710699_Screenshot_1739952416.png', NULL, '2025-03-11 16:31:39', '2025-03-11 16:32:23', 45),
(8, '[1]', NULL, 'www.google.com', NULL, 'jk', '5454323234', 'use@gmail.com', 0, NULL, '1228833', '2025-03-13 09:27:02', '2025-03-13 09:27:02', 47);

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
('nXdqo1QcKRr1aa8PW29ZZfdw28pUXNqUInqNjALr', NULL, '59.88.97.201', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiaWg1Z2FESkxBckRmZkIyRjlHVmJ0WEVZaW9yNVREOElaYWxKTGdDRCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTA6Imh0dHBzOi8vcXVhbGNhc3RiZXRhLmluL2ZsaXBzZWxsL3B1YmxpYy9hZG1pbmxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1741841203),
('tMSVrmz8strzU6CSmbag4Y1KzGmh5FxzFziYEj5Y', NULL, '59.88.97.201', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36 Edg/134.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoicDlqUnpSeEdRREE1QmdEUnZxTkJEa0pTUDBYOUFQZWN6elU5THpMbSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTU6Imh0dHBzOi8vcXVhbGNhc3RiZXRhLmluL2ZsaXBzZWxsL3B1YmxpYy9hZG1pbi9kYXNoYm9hcmQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUyOiJsb2dpbl9hZG1pbl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1741843349);

-- --------------------------------------------------------

--
-- Table structure for table `subcategories`
--

CREATE TABLE `subcategories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `subcategory` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `chosen` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subcategories`
--

INSERT INTO `subcategories` (`id`, `subcategory`, `user_id`, `chosen`, `created_at`, `updated_at`) VALUES
(1, '9', 47, 1, '2025-03-13 09:27:02', '2025-03-13 09:27:02');

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

CREATE TABLE `subscriptions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `plan_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `payment_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subscriptions`
--

INSERT INTO `subscriptions` (`id`, `plan_id`, `user_id`, `start_date`, `end_date`, `payment_id`, `created_at`, `updated_at`) VALUES
(2, 1, 2, '2025-02-07', '2025-04-07', 1, '2025-02-07 11:40:27', '2025-02-07 11:40:27');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `location_latitude` decimal(8,2) DEFAULT NULL,
  `location_longitude` decimal(8,2) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `verification_image1` varchar(255) DEFAULT NULL,
  `verification_image2` varchar(255) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `verification_status` varchar(255) NOT NULL DEFAULT 'pending',
  `usertype` tinyint(4) NOT NULL DEFAULT 0,
  `country_id` bigint(20) UNSIGNED DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `login_otp` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `mobile`, `location`, `location_latitude`, `location_longitude`, `image`, `verification_image1`, `verification_image2`, `status`, `verification_status`, `usertype`, `country_id`, `email_verified_at`, `password`, `login_otp`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Jancy Ray', 'jancy@gmail.com', '8787878656', '1', NULL, NULL, 'https://qualcastbeta.in/flipsell/public/assets/images/lady.jpg', 'https://qualcastbeta.in/flipsell/public/assets/images/dummy.jpg', 'https://qualcastbeta.in/flipsell/public/assets/images/dummy.jpg', 1, 'accepted', 0, 1, NULL, 'password123', NULL, NULL, '2025-02-06 06:21:19', '2025-03-06 05:21:51'),
(2, 'Robin Lee', 'robin@gmail.com', '78787878673', '1', NULL, NULL, 'https://qualcastbeta.in/flipsell/public/assets/images/lady.jpg', 'https://qualcastbeta.in/flipsell/public/assets/images/dummy.jpg', 'https://qualcastbeta.in/flipsell/public/assets/images/dummy.jpg', 0, 'pending', 1, 1, NULL, 'robin123', NULL, NULL, '2025-02-07 11:33:34', '2025-02-14 10:07:28'),
(4, 'Pooja', 'puu@gmail.com', '8989898989', 'New York', 41.71, -74.01, 'https://qualcastbeta.in/flipsell-main/public/assets/images/image/1740829992_OIP (1).jpeg', 'https://qualcastbeta.in/flipsell-main/public/assets/images/verification_image1/1740829992_biology.png', 'http://127.0.0.1:8000/assets/images/1740723946_Admin-logo.png', 1, 'pending', 1, 1, NULL, '$2y$12$ORXh7e4f98VqJ0SXEmitz.Qe81o/e/b7IelAAS.y/HasK1euHHORq', '1234', NULL, '2025-02-20 06:25:53', '2025-02-28 11:35:09'),
(5, 'Guest user', '', '6111111111', NULL, NULL, NULL, NULL, NULL, NULL, 0, 'pending', 0, 1, NULL, '$2y$12$Z90xCg4EhR.smUpII7Cqw.zZ8w8e/yhMJV7rSzw5LMsFebcGetHci', '1234', NULL, '2025-02-28 08:16:12', '2025-02-28 08:16:12'),
(9, 'pj', 'jiya@gmail.com', '8978675444', 'North Paravur', 123454.33, 768902.70, NULL, 'https://qualcastbeta.in/flipsell-main/public/assets/images/1740901515_Screenshot 2025-02-15 at 4.00.56 PM.png', 'https://qualcastbeta.in/flipsell-main/public/assets/images/1740901515_Screenshot 2025-02-15 at 4.00.56 PM.png', 1, 'pending', 1, 1, NULL, '$2y$12$n/WuC7ZEb88QZUmuhx8Ote/IfKXvSVXQEnaqztZLmFBJFR2yFeLjO', '1234', NULL, '2025-02-28 11:45:14', '2025-03-03 04:55:22'),
(10, 'Test', 'test@gmail.com', '7306621874', 'Edapally, Kochi, Kerala, India', 90.00, 10.00, 'https://qualcastbeta.in/flipsell-main/public/assets/images/1740846227_selfie_image', 'https://qualcastbeta.in/flipsell-main/public/assets/images/1740901795_verification_image1', 'https://qualcastbeta.in/flipsell-main/public/assets/images/1740901795_verification_image2', 1, 'pending', 0, 1, NULL, '$2y$12$RfBqd7B0/BMDfXhjbsh8V.7jLtQScqfpTF6zmyMk.lM923KrxfZp.', '1234', NULL, '2025-02-28 11:48:08', '2025-03-11 16:55:33'),
(35, 'Guest user', NULL, '9812312121', NULL, NULL, NULL, NULL, NULL, NULL, 0, 'pending', 0, 1, NULL, '$2y$12$CnbaMFwwj.O9GP0H/E5W.uiDUk/fzGcIdykNtUIjlJQMH0P2hbSRa', '1234', NULL, '2025-03-03 04:56:39', '2025-03-03 04:56:39'),
(36, 'Guest user', NULL, '0000000000', NULL, NULL, NULL, NULL, NULL, NULL, 0, 'pending', 0, 1, NULL, '$2y$12$Q3281.WIgCPi0EInmLGnq.mpxfwA4Im7Jrl8Zc9o218BI8F5RzLj.', '1234', NULL, '2025-03-03 05:07:56', '2025-03-03 05:49:21'),
(37, 'Guest user', NULL, '9847408976', NULL, NULL, NULL, NULL, NULL, NULL, 0, 'pending', 0, 1, NULL, '$2y$12$jqO0ZlqVmCRRxUyCbSpiSO.V9QEpslW6LHadFhEEPWxSDcqflDOHy', '1234', NULL, '2025-03-03 05:37:50', '2025-03-03 05:37:50'),
(38, 'Guest user', NULL, '7837878783', NULL, NULL, NULL, NULL, NULL, NULL, 0, 'pending', 0, 1, NULL, '$2y$12$TWXdQxuBvCIUztEDfwdVh.9zdAHqVxgxZ3Zvmr9o9I9cmJJaas952', '1234', NULL, '2025-03-03 05:38:03', '2025-03-03 05:38:03'),
(39, 'Guest user', NULL, '3333456765', NULL, NULL, NULL, NULL, NULL, NULL, 0, 'pending', 0, 1, NULL, '$2y$12$KCdBK2ViHiQtZ3YWYLst9OvEACqQlkspKXdJfS1GaY/ditkK4.jDy', '1234', NULL, '2025-03-03 05:49:44', '2025-03-03 05:49:44'),
(40, 'Sibin', 'sibin@gmail.com', '8129663223', 'Ernakulam, Kerala, India', 9.98, 76.30, 'https://qualcastbeta.in/flipsell-main/public/assets/images/1741363009_selfie_image', 'https://qualcastbeta.in/flipsell-main/public/assets/images/1741363023_verification_image1', 'https://qualcastbeta.in/flipsell-main/public/assets/images/1741363023_verification_image2', 1, 'pending', 0, 1, NULL, '$2y$12$sr.prMiWqH0HVOxzAUfyhuxBAljHj7twza/4eGkvHG2SV2tT85sCq', '1234', NULL, '2025-03-07 15:55:10', '2025-03-07 15:57:03'),
(41, 'Guest user', NULL, '8129669160', NULL, NULL, NULL, NULL, NULL, NULL, 0, 'pending', 0, 1, NULL, '$2y$12$jSkvQK2twobLWPbTV.fk3OHdSxWLDkme4MiCMBxKbHW7XXcKPHDAS', '1234', NULL, '2025-03-08 16:46:51', '2025-03-08 16:46:51'),
(42, 'Guest user', NULL, '9633517362', NULL, 10.98, 76.22, NULL, NULL, NULL, 0, 'pending', 0, 1, NULL, '$2y$12$KpFHKZ/KYiZzUoR5ZHHkJuJX7PPcVnr.qAXedhpvLML34ui1kEcki', '1234', NULL, '2025-03-08 17:49:03', '2025-03-08 17:49:03'),
(43, 'Guest user', NULL, '7306621873', NULL, NULL, NULL, NULL, NULL, NULL, 0, 'pending', 0, 1, NULL, '$2y$12$o7qhYFFFWMMaSlQ7/4SIbuL7uiBXThg17JgR5WUBGwC90s7dRLxI6', '1234', NULL, '2025-03-10 18:21:59', '2025-03-10 18:21:59'),
(44, 'Guest user', NULL, '7883777333', NULL, NULL, NULL, NULL, NULL, NULL, 0, 'pending', 0, 1, NULL, '$2y$12$s1DNwQaz8ZmWY1CdsYADteq4xKT9krLSYru/IQZcpLzhLL6U3t9Fa', '1234', NULL, '2025-03-11 16:18:47', '2025-03-11 16:18:47'),
(45, 'LIBIN', 'l@gmail.com', '3667646476', 'Edappally, Kochi, Kerala, India', 10.03, 76.31, 'https://qualcastbeta.in/flipsell-main/public/assets/images/1741710896_selfie_image', 'https://qualcastbeta.in/flipsell-main/public/assets/images/1741710907_verification_image1', 'https://qualcastbeta.in/flipsell-main/public/assets/images/1741710907_verification_image2', 1, 'pending', 1, 1, NULL, '$2y$12$nuudWKBNDhOjhM5UEP46YOr39Z61p7IMrZm5Bs4frxPp06ag5RglK', '1234', NULL, '2025-03-11 16:25:06', '2025-03-11 16:35:07'),
(46, 'Guest user', NULL, '8988989898', NULL, NULL, NULL, NULL, NULL, NULL, 0, 'pending', 0, 1, NULL, '$2y$12$HsADW2JWCHwBkry21Jvf/OMbHBUnjgxu0oxHEMpAXBMpMOa0n.0oq', '1234', NULL, '2025-03-11 16:41:23', '2025-03-11 16:41:23'),
(47, 'pooja teset', 'ooja@gmail.com', '0987765432', 'North Paravur', 123454.33, 768902.70, NULL, NULL, NULL, 1, 'pending', 1, 2, NULL, '$2y$12$8mPKE5fE4ajsMc2k6et/Qe4ti8MwMiH19FI7ujY6n2Mvvca0YkSRu', '1234', NULL, '2025-03-13 09:25:58', '2025-03-13 09:27:02');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_email_unique` (`email`);

--
-- Indexes for table `ads`
--
ALTER TABLE `ads`
  ADD PRIMARY KEY (`id`);

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
  ADD PRIMARY KEY (`id`),
  ADD KEY `categories_sub_of_foreign` (`sub_of`);

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
-- Indexes for table `job_requests`
--
ALTER TABLE `job_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `job_requests_user_id_foreign` (`user_id`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_user_id_foreign` (`user_id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `plans`
--
ALTER TABLE `plans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `requests_update`
--
ALTER TABLE `requests_update`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `service_providers`
--
ALTER TABLE `service_providers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `service_providers_user_id_foreign` (`user_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `subcategories`
--
ALTER TABLE `subcategories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subcategories_user_id_foreign` (`user_id`);

--
-- Indexes for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subscriptions_plan_id_foreign` (`plan_id`),
  ADD KEY `subscriptions_user_id_foreign` (`user_id`),
  ADD KEY `subscriptions_payment_id_foreign` (`payment_id`);

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
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ads`
--
ALTER TABLE `ads`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

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
-- AUTO_INCREMENT for table `job_requests`
--
ALTER TABLE `job_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `plans`
--
ALTER TABLE `plans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `requests_update`
--
ALTER TABLE `requests_update`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `service_providers`
--
ALTER TABLE `service_providers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `subcategories`
--
ALTER TABLE `subcategories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `subscriptions`
--
ALTER TABLE `subscriptions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `job_requests`
--
ALTER TABLE `job_requests`
  ADD CONSTRAINT `job_requests_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `service_providers`
--
ALTER TABLE `service_providers`
  ADD CONSTRAINT `service_providers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `subcategories`
--
ALTER TABLE `subcategories`
  ADD CONSTRAINT `subcategories_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD CONSTRAINT `subscriptions_payment_id_foreign` FOREIGN KEY (`payment_id`) REFERENCES `payments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `subscriptions_plan_id_foreign` FOREIGN KEY (`plan_id`) REFERENCES `plans` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `subscriptions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
