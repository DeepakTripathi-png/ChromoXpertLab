-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 05, 2025 at 05:09 AM
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
-- Database: `chromoxpert_new`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `appointment_code` varchar(255) DEFAULT NULL,
  `lab_id` bigint(20) DEFAULT NULL,
  `referee_doctor_id` bigint(20) DEFAULT NULL,
  `appointment_date` date DEFAULT NULL,
  `appointment_time` time DEFAULT NULL,
  `pet_id` bigint(20) DEFAULT NULL,
  `petowner_id` bigint(20) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL,
  `discount` decimal(10,2) DEFAULT NULL,
  `gst` decimal(10,2) DEFAULT 0.00,
  `total` decimal(10,2) DEFAULT NULL,
  `paid_amount` decimal(10,2) DEFAULT NULL,
  `due_amount` decimal(10,2) DEFAULT NULL,
  `payment_mode` varchar(255) DEFAULT NULL,
  `transaction_id` varchar(255) DEFAULT NULL,
  `payment_status` enum('Pending','Completed','Failed') DEFAULT NULL,
  `payment_date` datetime DEFAULT NULL,
  `created_ip_address` varchar(255) DEFAULT NULL,
  `modified_ip_address` varchar(255) DEFAULT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  `modified_by` bigint(20) DEFAULT NULL,
  `status` enum('active','delete','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `appointment_code`, `lab_id`, `referee_doctor_id`, `appointment_date`, `appointment_time`, `pet_id`, `petowner_id`, `notes`, `subtotal`, `discount`, `gst`, `total`, `paid_amount`, `due_amount`, `payment_mode`, `transaction_id`, `payment_status`, `payment_date`, `created_ip_address`, `modified_ip_address`, `created_by`, `modified_by`, `status`, `created_at`, `updated_at`) VALUES
(1, 'APT001', 1, 1, '2025-09-18', '13:33:00', 3, 1, 'NA', 1000.00, 100.00, NULL, 900.00, NULL, NULL, 'Cash', NULL, 'Pending', '2025-09-18 00:00:00', '127.0.0.1', '127.0.0.1', 1, 1, 'active', '2025-09-18 02:30:49', '2025-09-18 02:30:49'),
(2, 'APT002', 1, 1, '2025-09-18', '18:00:00', 3, 1, 'NA', 200.00, NULL, NULL, 200.00, NULL, NULL, 'Cash', '1233', 'Pending', '2025-09-18 00:00:00', '127.0.0.1', NULL, 1, NULL, 'active', '2025-09-18 07:30:48', '2025-09-18 07:30:48'),
(3, 'APT003', 1, 1, '2025-09-22', '10:20:00', 3, 1, NULL, 900.00, NULL, NULL, 900.00, NULL, NULL, 'Cash', NULL, 'Completed', '2025-09-22 00:00:00', '127.0.0.1', NULL, 1, NULL, 'active', '2025-09-21 23:17:53', '2025-09-21 23:17:53'),
(4, 'APT004', 1, 1, '2025-09-22', '12:10:00', 3, 1, NULL, 900.00, 50.00, NULL, 850.00, NULL, NULL, 'Cash', NULL, 'Completed', '2025-09-22 00:00:00', '127.0.0.1', NULL, 1, NULL, 'active', '2025-09-21 23:34:26', '2025-09-21 23:34:26'),
(5, 'APT005', 1, 1, '2025-09-22', '13:49:00', 3, 1, NULL, 1700.00, 100.00, NULL, 1600.00, NULL, NULL, 'Cash', NULL, 'Completed', '2025-09-22 13:49:00', '127.0.0.1', NULL, 1, NULL, 'active', '2025-09-22 02:49:42', '2025-09-22 02:49:42'),
(6, 'APT006', 1, 1, '2025-09-22', '15:06:00', 3, 1, NULL, 900.00, 50.00, NULL, 850.00, 700.00, 150.00, 'Cash', NULL, 'Pending', '2025-09-22 15:06:00', '127.0.0.1', NULL, 1, NULL, 'active', '2025-09-22 04:08:02', '2025-09-22 04:08:02'),
(7, 'APT007', 1, 1, '2025-09-22', '15:06:00', 3, 1, NULL, 900.00, 50.00, NULL, 850.00, 700.00, 150.00, 'Cash', NULL, 'Pending', '2025-09-22 15:06:00', '127.0.0.1', NULL, 1, NULL, 'active', '2025-09-22 04:09:46', '2025-09-22 04:09:46'),
(8, 'APT008', 1, 1, '2025-09-22', '16:30:00', 3, 1, NULL, 900.00, 50.00, NULL, 850.00, 700.00, 150.00, 'UPI', '1233', 'Completed', '2025-09-22 16:30:00', '127.0.0.1', NULL, 1, NULL, 'active', '2025-09-22 05:31:58', '2025-09-22 05:31:58'),
(9, 'APT009', 1, 1, '2025-09-22', '17:37:00', 3, 1, NULL, 900.00, 50.00, NULL, 850.00, 600.00, 250.00, 'Card', NULL, 'Pending', '2025-09-22 17:37:00', '127.0.0.1', NULL, 1, NULL, 'active', '2025-09-22 06:39:24', '2025-09-22 06:39:24'),
(10, 'APT010', 1, 1, '2025-09-23', '10:57:00', 3, 1, NULL, 2500.00, 100.00, NULL, 2400.00, 2400.00, 0.00, 'Cash', NULL, 'Completed', '2025-09-23 10:57:00', '127.0.0.1', NULL, 1, NULL, 'active', '2025-09-22 23:58:30', '2025-09-22 23:58:30'),
(11, 'APT011', 1, 1, '2025-09-23', '16:00:00', 3, 1, NULL, 4300.00, 300.00, NULL, 4000.00, 4000.00, 0.00, 'Cash', NULL, 'Completed', '2025-09-23 16:58:00', '127.0.0.1', NULL, 1, NULL, 'active', '2025-09-23 05:59:57', '2025-09-23 05:59:58'),
(12, 'APT012', 1, 1, '2025-09-24', '12:55:00', 14, 11, NULL, 1700.00, 100.00, NULL, 1600.00, 1600.00, 0.00, 'Cash', NULL, 'Completed', '2025-09-24 12:55:00', '127.0.0.1', NULL, 1, NULL, 'active', '2025-09-24 01:56:30', '2025-09-24 01:56:30'),
(13, 'APT013', 1, 1, '2025-09-24', '12:55:00', 14, 11, NULL, 1700.00, 100.00, NULL, 1600.00, 1600.00, 0.00, 'Cash', NULL, 'Completed', '2025-09-24 12:55:00', '127.0.0.1', NULL, 1, NULL, 'active', '2025-09-24 02:04:26', '2025-09-24 02:04:26'),
(14, 'APT014', 1, 1, '2025-09-24', '12:55:00', 14, 11, NULL, 1700.00, 100.00, NULL, 1600.00, 1600.00, 0.00, 'Cash', NULL, 'Completed', '2025-09-24 12:55:00', '127.0.0.1', NULL, 1, NULL, 'active', '2025-09-24 02:11:04', '2025-09-24 02:11:04'),
(15, 'APT015', 1, 1, '2025-09-24', '12:55:00', 14, 11, NULL, 1700.00, 100.00, NULL, 1600.00, 1600.00, 0.00, 'Cash', NULL, 'Completed', '2025-09-24 12:55:00', '127.0.0.1', NULL, 1, NULL, 'active', '2025-09-24 02:11:43', '2025-09-24 02:11:43'),
(16, 'APT016', 1, 1, '2025-09-24', '12:55:00', 14, 11, NULL, 1700.00, 100.00, NULL, 1600.00, 1600.00, 0.00, 'Cash', NULL, 'Completed', '2025-09-24 12:55:00', '127.0.0.1', NULL, 1, NULL, 'active', '2025-09-24 02:12:18', '2025-09-24 02:12:18'),
(17, 'APT017', 1, 1, '2025-09-24', '12:55:00', 14, 11, NULL, 1700.00, 100.00, NULL, 1600.00, 1600.00, 0.00, 'Cash', NULL, 'Completed', '2025-09-24 12:55:00', '127.0.0.1', NULL, 1, NULL, 'active', '2025-09-24 02:13:44', '2025-09-24 02:13:44'),
(18, 'APT018', 1, 1, '2025-09-24', '12:55:00', 14, 11, NULL, 1700.00, 100.00, NULL, 1600.00, 1600.00, 0.00, 'Cash', NULL, 'Completed', '2025-09-24 12:55:00', '127.0.0.1', NULL, 1, NULL, 'active', '2025-09-24 02:22:45', '2025-09-24 02:22:45'),
(19, 'APT019', 1, 1, '2025-09-24', '12:55:00', 14, 11, NULL, 1700.00, 100.00, NULL, 1600.00, 1600.00, 0.00, 'Cash', NULL, 'Completed', '2025-09-24 12:55:00', '127.0.0.1', NULL, 1, NULL, 'active', '2025-09-24 03:30:09', '2025-09-24 03:30:09'),
(20, 'APT020', 1, 1, '2025-09-24', '12:55:00', 14, 11, NULL, 1700.00, 100.00, NULL, 1600.00, 1600.00, 0.00, 'Cash', NULL, 'Completed', '2025-09-24 12:55:00', '127.0.0.1', NULL, 1, NULL, 'active', '2025-09-24 03:34:22', '2025-09-24 03:34:22'),
(21, 'APT021', 1, 1, '2025-09-24', '12:55:00', 14, 11, NULL, 1700.00, 100.00, NULL, 1600.00, 1600.00, 0.00, 'Cash', NULL, 'Completed', '2025-09-24 12:55:00', '127.0.0.1', NULL, 1, NULL, 'active', '2025-09-24 03:35:50', '2025-09-24 03:35:50'),
(22, 'APT022', 1, 1, '2025-09-24', '12:55:00', 14, 11, NULL, 1700.00, 100.00, NULL, 1600.00, 1600.00, 0.00, 'Cash', NULL, 'Completed', '2025-09-24 12:55:00', '127.0.0.1', NULL, 1, NULL, 'active', '2025-09-24 03:36:53', '2025-09-24 03:36:53'),
(23, 'APT023', 1, 1, '2025-09-24', '12:55:00', 14, 11, NULL, 1700.00, 100.00, NULL, 1600.00, 1600.00, 0.00, 'Cash', NULL, 'Completed', '2025-09-24 12:55:00', '127.0.0.1', NULL, 1, NULL, 'active', '2025-09-24 03:37:17', '2025-09-24 03:37:17'),
(24, 'APT024', 1, 1, '2025-09-26', '10:50:00', 3, 1, NULL, 900.00, NULL, NULL, 900.00, 900.00, 0.00, 'Cash', NULL, 'Completed', '2025-09-26 10:50:00', '127.0.0.1', NULL, 1, NULL, 'active', '2025-09-25 23:51:12', '2025-09-25 23:51:12'),
(25, 'APT025', 1, 1, '2025-09-26', '11:26:00', 3, 1, NULL, 900.00, NULL, NULL, 900.00, 900.00, 0.00, 'Cash', NULL, 'Completed', '2025-09-26 11:26:00', '127.0.0.1', NULL, 1, NULL, 'active', '2025-09-26 00:27:25', '2025-09-26 00:27:25'),
(26, 'APT026', 1, 1, '2025-09-26', '11:38:00', 3, 1, NULL, 900.00, NULL, NULL, 900.00, 900.00, 0.00, 'Cash', NULL, 'Pending', '2025-09-26 11:38:00', '127.0.0.1', NULL, 1, NULL, 'active', '2025-09-26 00:39:49', '2025-09-26 00:39:49'),
(27, 'APT027', 1, 1, '2025-09-26', '11:38:00', 3, 1, NULL, 900.00, NULL, NULL, 900.00, 900.00, 0.00, 'Cash', NULL, 'Pending', '2025-09-26 11:38:00', '127.0.0.1', NULL, 1, NULL, 'active', '2025-09-26 00:47:02', '2025-09-26 00:47:02'),
(28, 'APT028', 1, 1, '2025-09-26', '11:47:00', 3, 1, NULL, 900.00, NULL, NULL, 900.00, 900.00, 0.00, 'Cash', NULL, 'Completed', '2025-09-26 11:47:00', '127.0.0.1', NULL, 1, NULL, 'active', '2025-09-26 00:47:53', '2025-09-26 00:47:54'),
(29, 'APT029', 1, 1, '2025-09-26', '11:47:00', 3, 1, NULL, 900.00, NULL, NULL, 900.00, 900.00, 0.00, 'Cash', NULL, 'Completed', '2025-09-26 11:47:00', '127.0.0.1', NULL, 1, NULL, 'active', '2025-09-26 00:48:45', '2025-09-26 00:48:45'),
(30, 'APT030', 1, 1, '2025-09-26', '11:50:00', 3, 1, NULL, 900.00, NULL, NULL, 900.00, 900.00, 0.00, 'Cash', NULL, 'Completed', '2025-09-26 11:50:00', '127.0.0.1', NULL, 1, NULL, 'active', '2025-09-26 00:51:02', '2025-09-26 00:51:02'),
(31, 'APT031', 1, 1, '2025-09-26', '12:51:00', 3, 1, NULL, 900.00, NULL, NULL, 900.00, 900.00, 0.00, 'Cash', NULL, 'Completed', '2025-09-26 12:51:00', '127.0.0.1', NULL, 1, NULL, 'active', '2025-09-26 01:51:57', '2025-09-26 01:51:57'),
(32, 'APT032', 1, 1, '2025-09-26', '12:52:00', 3, 1, NULL, 900.00, NULL, NULL, 900.00, 900.00, 0.00, 'Cash', NULL, 'Completed', '2025-09-26 12:52:00', '127.0.0.1', NULL, 1, NULL, 'active', '2025-09-26 01:53:24', '2025-09-26 01:53:24'),
(33, 'APT033', 1, 1, '2025-09-30', '16:08:00', 3, 1, NULL, 1700.00, 200.00, NULL, 1500.00, 1500.00, 0.00, 'Cash', NULL, 'Pending', '2025-09-30 16:08:00', '127.0.0.1', NULL, 1, NULL, 'active', '2025-09-30 05:09:19', '2025-09-30 05:09:19'),
(34, 'APT034', 1, 1, '2025-10-15', '15:00:00', 3, 1, NULL, 1700.00, 100.00, NULL, 1600.00, 1600.00, 0.00, 'Cash', NULL, 'Completed', '2025-10-06 15:44:00', '127.0.0.1', NULL, 1, NULL, 'active', '2025-10-06 04:44:49', '2025-10-06 04:44:49'),
(35, 'APT035', 1, 1, '2025-10-06', '15:46:00', 3, 1, NULL, 2500.00, 100.00, NULL, 2400.00, 2400.00, 0.00, 'Cash', NULL, 'Completed', '2025-10-06 15:46:00', '127.0.0.1', NULL, 1, NULL, 'active', '2025-10-06 04:47:41', '2025-10-06 04:47:41'),
(36, 'APT036', 1, 1, '2025-10-06', '15:55:00', 3, 1, 'NA', 1900.00, 100.00, NULL, 1800.00, 1800.00, 0.00, 'Cash', NULL, 'Completed', '2025-10-06 15:00:00', '127.0.0.1', NULL, 1, NULL, 'active', '2025-10-06 04:56:44', '2025-10-06 04:56:44'),
(37, 'APT037', 1, 1, '2025-10-06', '16:14:00', 3, 1, NULL, 1900.00, 100.00, NULL, 1800.00, 1800.00, 0.00, 'Cash', NULL, 'Completed', '2025-10-06 16:14:00', '127.0.0.1', NULL, 1, NULL, 'active', '2025-10-06 05:15:23', '2025-10-06 05:15:23'),
(38, 'APT038', 1, 1, '2025-10-09', '15:08:00', 3, 1, NULL, 1100.00, 100.00, NULL, 1000.00, 1000.00, 0.00, 'Cash', '1233', 'Completed', '2025-10-09 15:08:00', '127.0.0.1', NULL, NULL, NULL, 'active', '2025-10-09 04:09:05', '2025-10-09 04:09:05'),
(39, 'APT039', 1, 1, '2025-10-10', '15:41:00', 3, 1, NULL, 800.00, 100.00, NULL, 700.00, 700.00, 0.00, 'Cash', NULL, 'Completed', '2025-10-10 15:41:00', '127.0.0.1', NULL, 1, NULL, 'active', '2025-10-10 04:42:20', '2025-10-10 04:42:20'),
(40, 'APT040', 1, 1, '2025-10-12', '10:00:00', 3, 1, NULL, 1700.00, 100.00, NULL, 1600.00, 1600.00, 0.00, 'Cash', NULL, 'Completed', '2025-10-11 10:58:00', '127.0.0.1', NULL, 1, NULL, 'active', '2025-10-11 00:08:08', '2025-10-11 00:08:08'),
(41, 'APT041', 1, 1, '2025-10-11', '11:00:00', 3, 1, NULL, 1000.00, 50.00, NULL, 950.00, 950.00, 0.00, 'Cash', NULL, 'Completed', '2025-10-11 11:08:00', '127.0.0.1', NULL, 1, NULL, 'active', '2025-10-11 00:09:57', '2025-10-11 00:09:57'),
(42, 'APT042', 1, 1, '2025-10-11', '13:18:00', 3, 1, NULL, 2500.00, 0.00, NULL, 2500.00, 2500.00, 0.00, 'Cash', NULL, 'Completed', '2025-10-11 13:18:00', '127.0.0.1', NULL, 1, NULL, 'active', '2025-10-11 02:19:22', '2025-10-11 02:19:22'),
(43, 'APT043', 1, 1, '2025-10-13', '18:22:00', 3, 1, NULL, 900.00, 0.00, NULL, 900.00, 900.00, 0.00, 'Cash', NULL, 'Completed', '2025-10-13 18:22:00', '127.0.0.1', NULL, 1, NULL, 'active', '2025-10-13 07:22:30', '2025-10-13 07:22:30'),
(44, 'APT044', 1, 1, '2025-10-14', '10:43:00', 3, 1, NULL, 0.00, 0.00, NULL, 0.00, 0.00, 0.00, 'Cash', NULL, 'Completed', '2025-10-14 10:43:00', '127.0.0.1', NULL, 1, NULL, 'active', '2025-10-13 23:44:55', '2025-10-13 23:44:55'),
(45, 'APT045', 1, 1, '2025-10-16', '11:52:00', 15, 13, NULL, 200.00, 5.00, NULL, 195.00, 195.00, 0.00, 'Cash', NULL, 'Pending', '2025-10-15 11:52:00', '127.0.0.1', NULL, 4, NULL, 'active', '2025-10-15 00:54:06', '2025-10-15 00:54:06'),
(46, 'APT046', 2, 1, '2025-10-16', '12:30:00', 17, 14, NULL, 100.00, 5.00, NULL, 95.00, 95.00, 0.00, 'Cash', NULL, 'Completed', '2025-10-15 12:02:00', '127.0.0.1', NULL, 6, NULL, 'active', '2025-10-15 01:03:42', '2025-10-15 01:03:42'),
(47, 'APT047', 2, 1, '2025-10-15', '12:20:00', 17, 14, NULL, 100.00, 0.00, NULL, 100.00, 100.00, 0.00, 'Cash', NULL, 'Completed', '2025-10-15 12:20:00', '127.0.0.1', NULL, 6, NULL, 'active', '2025-10-15 01:20:30', '2025-10-15 01:20:30'),
(48, 'APT048', 2, 1, '2025-10-15', '14:19:00', 18, 15, NULL, 100.00, 0.00, NULL, 100.00, 100.00, 0.00, 'Cash', NULL, 'Completed', '2025-10-15 14:19:00', '127.0.0.1', NULL, 6, NULL, 'active', '2025-10-15 03:28:24', '2025-10-15 03:28:24'),
(49, 'APT049', 1, 1, '2025-10-22', '17:00:00', 15, 13, NULL, 900.00, 0.00, NULL, 900.00, 900.00, 0.00, 'Cash', NULL, 'Completed', '2025-10-16 17:39:00', '127.0.0.1', NULL, 4, NULL, 'active', '2025-10-16 06:40:43', '2025-10-16 06:40:43'),
(50, 'APT050', 1, 1, '2025-10-28', '09:36:00', 15, 13, NULL, 900.00, 0.00, NULL, 900.00, 900.00, 0.00, 'Cash', NULL, 'Completed', '2025-10-17 09:36:00', '127.0.0.1', NULL, 4, NULL, 'active', '2025-10-16 22:37:31', '2025-10-16 22:37:31'),
(51, 'APT051', 1, 1, '2025-10-17', '09:56:00', 15, 13, NULL, 900.00, 0.00, NULL, 900.00, 900.00, 0.00, 'Cash', NULL, 'Completed', '2025-10-17 09:56:00', '127.0.0.1', NULL, 4, NULL, 'active', '2025-10-16 22:57:09', '2025-10-16 22:57:09'),
(52, 'APT052', 1, 1, '2025-10-17', '10:52:00', 15, 13, NULL, 900.00, 0.00, NULL, 900.00, 900.00, 0.00, 'Cash', NULL, 'Completed', '2025-10-17 10:51:00', '127.0.0.1', NULL, 4, NULL, 'active', '2025-10-16 23:52:24', '2025-10-16 23:52:24'),
(53, 'APT053', 1, 1, '2025-10-17', '12:16:00', 15, 13, NULL, 900.00, 0.00, NULL, 900.00, 900.00, 0.00, 'Cash', NULL, 'Completed', '2025-10-17 12:16:00', '127.0.0.1', NULL, 4, NULL, 'active', '2025-10-17 01:18:47', '2025-10-17 01:18:47'),
(54, 'APT054', 1, 1, '2025-10-25', '12:00:00', 15, 13, NULL, 900.00, 0.00, NULL, 900.00, 900.00, 0.00, 'Cash', NULL, 'Completed', '2025-10-17 12:43:00', '127.0.0.1', NULL, 4, NULL, 'active', '2025-10-17 01:45:12', '2025-10-17 01:45:12'),
(55, 'APT055', 1, 1, '2025-10-17', '12:57:00', 15, 13, NULL, 900.00, 0.00, NULL, 900.00, 900.00, 0.00, 'Cash', NULL, 'Completed', '2025-10-17 12:57:00', '127.0.0.1', NULL, 4, NULL, 'active', '2025-10-17 01:58:55', '2025-10-17 01:58:55'),
(56, 'APT056', 1, 1, '2025-10-30', '14:09:00', 16, 13, NULL, 100.00, 0.00, NULL, 100.00, 100.00, 0.00, 'Cash', NULL, 'Completed', '2025-10-17 14:09:00', '127.0.0.1', NULL, 4, NULL, 'active', '2025-10-17 03:10:43', '2025-10-17 03:10:44'),
(57, 'APT057', 1, 1, '2025-10-23', '14:54:00', 15, 13, NULL, 900.00, 0.00, NULL, 900.00, 900.00, 0.00, 'Cash', NULL, 'Completed', '2025-10-17 14:54:00', '127.0.0.1', NULL, 4, NULL, 'active', '2025-10-17 03:56:10', '2025-10-17 03:56:10'),
(58, 'APT058', 2, 1, '2025-10-27', '16:08:00', 3, 1, NULL, 900.00, 0.00, NULL, 900.00, 900.00, 0.00, 'Card', NULL, 'Pending', '2025-10-27 16:08:00', '127.0.0.1', NULL, 1, NULL, 'active', '2025-10-27 05:13:30', '2025-10-27 05:13:30'),
(59, 'APT059', 1, 1, '2025-10-28', '15:04:00', 3, 1, NULL, 900.00, 0.00, 5.00, 992.25, 992.25, 0.00, 'Cash', NULL, 'Completed', '2025-10-28 15:04:00', '127.0.0.1', NULL, 1, NULL, 'active', '2025-10-28 04:06:42', '2025-10-28 04:06:42'),
(60, NULL, 2, 1, '2025-10-28', '17:00:00', 3, 1, NULL, 2500.00, 5.00, 0.00, 2495.00, 2495.00, 0.00, 'Cash', NULL, 'Completed', '2025-10-28 17:00:00', '127.0.0.1', NULL, 1, NULL, 'active', '2025-10-28 06:01:58', '2025-10-28 06:01:58'),
(61, 'APT061', 2, 1, '2025-10-28', '17:00:00', 3, 1, NULL, 2500.00, 5.00, 0.00, 2495.00, 2495.00, 0.00, 'Cash', NULL, 'Completed', '2025-10-28 17:00:00', '127.0.0.1', NULL, 1, NULL, 'active', '2025-10-28 06:04:36', '2025-10-28 06:04:36'),
(62, 'APT062', 1, 1, '2025-10-28', '18:42:00', 20, 19, NULL, 900.00, 0.00, 0.00, 900.00, 900.00, 0.00, 'Cash', NULL, 'Completed', '2025-10-28 18:42:00', '127.0.0.1', NULL, 4, NULL, 'active', '2025-10-28 07:45:59', '2025-10-28 07:45:59'),
(63, 'APT063', 3, 3, '2025-10-28', '18:56:00', 3, 1, NULL, 900.00, 0.00, 0.00, 900.00, 900.00, 0.00, 'Cash', NULL, 'Completed', '2025-10-28 18:56:00', '127.0.0.1', NULL, 1, NULL, 'active', '2025-10-28 07:56:52', '2025-10-28 07:56:52'),
(64, 'APT064', 1, 2, '2025-10-29', '10:12:00', 3, 1, NULL, 900.00, 0.00, 0.00, 900.00, 900.00, 0.00, 'Cash', NULL, 'Completed', '2025-10-29 10:12:00', '127.0.0.1', NULL, 1, NULL, 'active', '2025-10-28 23:13:18', '2025-10-28 23:13:18');

-- --------------------------------------------------------

--
-- Table structure for table `appointment_tests`
--

CREATE TABLE `appointment_tests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `appointment_id` bigint(20) DEFAULT NULL,
  `test_id` bigint(20) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `appointment_tests`
--

INSERT INTO `appointment_tests` (`id`, `appointment_id`, `test_id`, `price`, `created_at`, `updated_at`) VALUES
(1, 1, 4, NULL, '2025-09-18 02:30:50', '2025-09-18 02:30:50'),
(2, 1, 3, NULL, '2025-09-18 02:30:50', '2025-09-18 02:30:50'),
(3, 2, 4, NULL, '2025-09-18 07:30:49', '2025-09-18 07:30:49'),
(4, 3, 2, NULL, '2025-09-21 23:17:53', '2025-09-21 23:17:53'),
(5, 4, 2, NULL, '2025-09-21 23:34:26', '2025-09-21 23:34:26'),
(6, 5, 2, NULL, '2025-09-22 02:49:42', '2025-09-22 02:49:42'),
(7, 5, 3, NULL, '2025-09-22 02:49:42', '2025-09-22 02:49:42'),
(8, 6, 2, NULL, '2025-09-22 04:08:02', '2025-09-22 04:08:02'),
(9, 7, 2, NULL, '2025-09-22 04:09:46', '2025-09-22 04:09:46'),
(10, 8, 2, NULL, '2025-09-22 05:31:58', '2025-09-22 05:31:58'),
(11, 9, 2, NULL, '2025-09-22 06:39:24', '2025-09-22 06:39:24'),
(12, 10, 2, NULL, '2025-09-22 23:58:30', '2025-09-22 23:58:30'),
(13, 10, 3, NULL, '2025-09-22 23:58:30', '2025-09-22 23:58:30'),
(14, 10, 5, NULL, '2025-09-22 23:58:30', '2025-09-22 23:58:30'),
(15, 11, 2, NULL, '2025-09-23 05:59:58', '2025-09-23 05:59:58'),
(16, 11, 3, NULL, '2025-09-23 05:59:58', '2025-09-23 05:59:58'),
(17, 11, 4, NULL, '2025-09-23 05:59:58', '2025-09-23 05:59:58'),
(18, 11, 5, NULL, '2025-09-23 05:59:58', '2025-09-23 05:59:58'),
(19, 11, 6, NULL, '2025-09-23 05:59:58', '2025-09-23 05:59:58'),
(20, 11, 10, NULL, '2025-09-23 05:59:58', '2025-09-23 05:59:58'),
(21, 12, 2, NULL, '2025-09-24 01:56:30', '2025-09-24 01:56:30'),
(22, 12, 3, NULL, '2025-09-24 01:56:30', '2025-09-24 01:56:30'),
(23, 13, 2, NULL, '2025-09-24 02:04:26', '2025-09-24 02:04:26'),
(24, 13, 3, NULL, '2025-09-24 02:04:26', '2025-09-24 02:04:26'),
(25, 14, 2, NULL, '2025-09-24 02:11:04', '2025-09-24 02:11:04'),
(26, 14, 3, NULL, '2025-09-24 02:11:04', '2025-09-24 02:11:04'),
(27, 15, 2, NULL, '2025-09-24 02:11:43', '2025-09-24 02:11:43'),
(28, 15, 3, NULL, '2025-09-24 02:11:43', '2025-09-24 02:11:43'),
(29, 16, 2, NULL, '2025-09-24 02:12:18', '2025-09-24 02:12:18'),
(30, 16, 3, NULL, '2025-09-24 02:12:18', '2025-09-24 02:12:18'),
(31, 17, 2, NULL, '2025-09-24 02:13:44', '2025-09-24 02:13:44'),
(32, 17, 3, NULL, '2025-09-24 02:13:44', '2025-09-24 02:13:44'),
(33, 18, 2, NULL, '2025-09-24 02:22:45', '2025-09-24 02:22:45'),
(34, 18, 3, NULL, '2025-09-24 02:22:45', '2025-09-24 02:22:45'),
(35, 19, 2, NULL, '2025-09-24 03:30:09', '2025-09-24 03:30:09'),
(36, 19, 3, NULL, '2025-09-24 03:30:09', '2025-09-24 03:30:09'),
(37, 20, 2, NULL, '2025-09-24 03:34:22', '2025-09-24 03:34:22'),
(38, 20, 3, NULL, '2025-09-24 03:34:22', '2025-09-24 03:34:22'),
(39, 21, 2, NULL, '2025-09-24 03:35:50', '2025-09-24 03:35:50'),
(40, 21, 3, NULL, '2025-09-24 03:35:50', '2025-09-24 03:35:50'),
(41, 22, 2, NULL, '2025-09-24 03:36:53', '2025-09-24 03:36:53'),
(42, 22, 3, NULL, '2025-09-24 03:36:53', '2025-09-24 03:36:53'),
(43, 23, 2, NULL, '2025-09-24 03:37:17', '2025-09-24 03:37:17'),
(44, 23, 3, NULL, '2025-09-24 03:37:17', '2025-09-24 03:37:17'),
(45, 24, 2, NULL, '2025-09-25 23:51:12', '2025-09-25 23:51:12'),
(46, 25, 12, NULL, '2025-09-26 00:27:25', '2025-09-26 00:27:25'),
(47, 26, 2, NULL, '2025-09-26 00:39:49', '2025-09-26 00:39:49'),
(48, 27, 2, NULL, '2025-09-26 00:47:02', '2025-09-26 00:47:02'),
(49, 28, 2, NULL, '2025-09-26 00:47:54', '2025-09-26 00:47:54'),
(50, 29, 2, NULL, '2025-09-26 00:48:45', '2025-09-26 00:48:45'),
(51, 30, 2, NULL, '2025-09-26 00:51:02', '2025-09-26 00:51:02'),
(52, 31, 2, NULL, '2025-09-26 01:51:57', '2025-09-26 01:51:57'),
(53, 32, 2, NULL, '2025-09-26 01:53:24', '2025-09-26 01:53:24'),
(54, 33, 2, NULL, '2025-09-30 05:09:19', '2025-09-30 05:09:19'),
(55, 33, 3, NULL, '2025-09-30 05:09:19', '2025-09-30 05:09:19'),
(56, 34, 2, NULL, '2025-10-06 04:44:49', '2025-10-06 04:44:49'),
(57, 34, 10, NULL, '2025-10-06 04:44:49', '2025-10-06 04:44:49'),
(58, 35, 2, NULL, '2025-10-06 04:47:41', '2025-10-06 04:47:41'),
(59, 35, 3, NULL, '2025-10-06 04:47:41', '2025-10-06 04:47:41'),
(60, 35, 5, NULL, '2025-10-06 04:47:41', '2025-10-06 04:47:41'),
(61, 36, 2, NULL, '2025-10-06 04:56:44', '2025-10-06 04:56:44'),
(62, 36, 3, NULL, '2025-10-06 04:56:44', '2025-10-06 04:56:44'),
(63, 36, 4, NULL, '2025-10-06 04:56:44', '2025-10-06 04:56:44'),
(64, 37, 2, NULL, '2025-10-06 05:15:23', '2025-10-06 05:15:23'),
(65, 37, 3, NULL, '2025-10-06 05:15:23', '2025-10-06 05:15:23'),
(66, 37, 4, NULL, '2025-10-06 05:15:23', '2025-10-06 05:15:23'),
(67, 38, 2, NULL, '2025-10-09 04:09:05', '2025-10-09 04:09:05'),
(68, 38, 4, NULL, '2025-10-09 04:09:05', '2025-10-09 04:09:05'),
(69, 39, 13, NULL, '2025-10-10 04:42:20', '2025-10-10 04:42:20'),
(70, 40, 3, NULL, '2025-10-11 00:08:08', '2025-10-11 00:08:08'),
(71, 40, 2, NULL, '2025-10-11 00:08:08', '2025-10-11 00:08:08'),
(72, 41, 4, NULL, '2025-10-11 00:09:57', '2025-10-11 00:09:57'),
(73, 41, 5, NULL, '2025-10-11 00:09:57', '2025-10-11 00:09:57'),
(74, 42, 2, NULL, '2025-10-11 02:19:22', '2025-10-11 02:19:22'),
(75, 42, 4, NULL, '2025-10-11 02:19:22', '2025-10-11 02:19:22'),
(76, 42, 5, NULL, '2025-10-11 02:19:22', '2025-10-11 02:19:22'),
(77, 42, 6, NULL, '2025-10-11 02:19:22', '2025-10-11 02:19:22'),
(78, 43, 2, NULL, '2025-10-13 07:22:30', '2025-10-13 07:22:30'),
(79, 44, 2, NULL, '2025-10-13 23:44:55', '2025-10-13 23:44:55'),
(80, 44, 4, NULL, '2025-10-13 23:44:55', '2025-10-13 23:44:55'),
(81, 45, 4, NULL, '2025-10-15 00:54:06', '2025-10-15 00:54:06'),
(82, 46, 4, NULL, '2025-10-15 01:03:42', '2025-10-15 01:03:42'),
(83, 47, 2, NULL, '2025-10-15 01:20:30', '2025-10-15 01:20:30'),
(84, 47, 4, NULL, '2025-10-15 01:20:30', '2025-10-15 01:20:30'),
(85, 48, 2, NULL, '2025-10-15 03:28:24', '2025-10-15 03:28:24'),
(86, 48, 4, NULL, '2025-10-15 03:28:24', '2025-10-15 03:28:24'),
(87, 49, 2, NULL, '2025-10-16 06:40:43', '2025-10-16 06:40:43'),
(88, 50, 2, NULL, '2025-10-16 22:37:31', '2025-10-16 22:37:31'),
(89, 51, 2, NULL, '2025-10-16 22:57:09', '2025-10-16 22:57:09'),
(90, 52, 2, NULL, '2025-10-16 23:52:24', '2025-10-16 23:52:24'),
(91, 53, 2, NULL, '2025-10-17 01:18:47', '2025-10-17 01:18:47'),
(92, 54, 2, NULL, '2025-10-17 01:45:12', '2025-10-17 01:45:12'),
(93, 55, 2, NULL, '2025-10-17 01:58:55', '2025-10-17 01:58:55'),
(94, 56, 2, NULL, '2025-10-17 03:10:44', '2025-10-17 03:10:44'),
(95, 56, 4, NULL, '2025-10-17 03:10:44', '2025-10-17 03:10:44'),
(96, 57, 2, NULL, '2025-10-17 03:56:11', '2025-10-17 03:56:11'),
(97, 58, 2, NULL, '2025-10-27 05:13:31', '2025-10-27 05:13:31'),
(98, 59, 2, NULL, '2025-10-28 04:06:42', '2025-10-28 04:06:42'),
(99, 61, 2, NULL, '2025-10-28 06:04:36', '2025-10-28 06:04:36'),
(100, 61, 4, NULL, '2025-10-28 06:04:36', '2025-10-28 06:04:36'),
(101, 61, 5, NULL, '2025-10-28 06:04:36', '2025-10-28 06:04:36'),
(102, 61, 6, NULL, '2025-10-28 06:04:36', '2025-10-28 06:04:36'),
(103, 62, 2, NULL, '2025-10-28 07:45:59', '2025-10-28 07:45:59'),
(104, 63, 2, NULL, '2025-10-28 07:56:52', '2025-10-28 07:56:52'),
(105, 64, 2, NULL, '2025-10-28 23:13:18', '2025-10-28 23:13:18');

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

CREATE TABLE `branches` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `branch_code` varchar(255) DEFAULT NULL,
  `type` enum('branch','collection_center','hospital') DEFAULT NULL,
  `branch_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `role_id` bigint(20) UNSIGNED DEFAULT NULL,
  `last_login` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `country_id` bigint(20) DEFAULT NULL,
  `state_id` bigint(20) DEFAULT NULL,
  `city_id` bigint(20) DEFAULT NULL,
  `pincode` varchar(255) DEFAULT NULL,
  `branch_logo_name` varchar(255) DEFAULT NULL,
  `branch_logo_path` varchar(255) DEFAULT NULL,
  `lab_incharge` bigint(20) DEFAULT NULL,
  `created_ip_address` varchar(255) DEFAULT NULL,
  `modified_ip_address` varchar(255) DEFAULT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  `modified_by` bigint(20) DEFAULT NULL,
  `status` enum('active','delete','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `branches`
--

INSERT INTO `branches` (`id`, `user_id`, `branch_code`, `type`, `branch_name`, `email`, `password`, `mobile`, `role_id`, `last_login`, `remember_token`, `address`, `country_id`, `state_id`, `city_id`, `pincode`, `branch_logo_name`, `branch_logo_path`, `lab_incharge`, `created_ip_address`, `modified_ip_address`, `created_by`, `modified_by`, `status`, `created_at`, `updated_at`) VALUES
(1, 4, 'BR001', 'branch', 'PandrPur Lab Deepak', 'branch@gmail.com', NULL, '+919173185601', NULL, '2025-10-09 12:46:41', NULL, 'Bair Amad Karari1', 1, 20, 523, '212216', 'download (1).jpeg', 'images/branches/zq6yXfxtfV3yuZ0TUKf1qYFhpFPDTKrdLi71bG2h.jpg', 2, '127.0.0.1', '127.0.0.1', 1, 1, 'active', '2025-09-02 06:28:13', '2025-10-09 07:16:41'),
(2, 6, 'BR002', 'branch', 'New testing Branch', 'branch1@gmail.com', NULL, '+917318560008', NULL, NULL, NULL, 'Bair Amad Karari', 1, 29, 360, '212216', NULL, NULL, 2, '127.0.0.1', NULL, 1, NULL, 'active', '2025-10-14 00:25:12', '2025-10-14 00:25:12'),
(3, 22, 'BR003', 'branch', 'Xyz Branch', 'xyzbranch@gmail.com', NULL, '+917318555555', NULL, NULL, NULL, 'Bair Amad Karari', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '127.0.0.1', NULL, 1, NULL, 'active', '2025-10-23 22:40:39', '2025-10-23 22:40:39'),
(4, 23, 'BR004', 'collection_center', 'First Collection center', 'fisrtcollectioncenter@gmail.com', NULL, '+917318900000', NULL, NULL, NULL, 'Bair Amad Karari', NULL, NULL, NULL, NULL, 'pngtree-laboratory-logo-png-image_4356386 (1).jpg', 'images/branches/Baz2TnKNaZi7OS6GshP9PiGi5eVfMHKlf8wlkyVC.jpg', NULL, '127.0.0.1', NULL, 1, NULL, 'active', '2025-10-24 00:13:09', '2025-10-24 00:13:09'),
(5, 24, 'BR005', 'collection_center', 'First Collection center 1', 'collection_center@gmail.com', NULL, '+917318560108', NULL, NULL, NULL, 'Bair Amad Karari', NULL, NULL, NULL, NULL, 'deepu.png', 'images/branches/ITyuMRl2ClOUGllp4wziQ1nB1vtGG0PzNm0GKQXz.png', NULL, '127.0.0.1', NULL, 1, NULL, 'active', '2025-10-27 07:16:10', '2025-10-27 07:16:10');

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `city_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `state_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`city_id`, `name`, `state_id`) VALUES
(1, 'Port Blair', 1),
(2, 'Adoni', 2),
(3, 'Amaravati', 2),
(4, 'Anantapur', 2),
(5, 'Chandragiri', 2),
(6, 'Chittoor', 2),
(7, 'Dowlaiswaram', 2),
(8, 'Eluru', 2),
(9, 'Guntur', 2),
(10, 'Kadapa', 2),
(11, 'Kakinada', 2),
(12, 'Kurnool', 2),
(13, 'Machilipatnam', 2),
(14, 'Nagarjunakoṇḍa', 2),
(15, 'Rajahmundry', 2),
(16, 'Srikakulam', 2),
(17, 'Tirupati', 2),
(18, 'Vijayawada', 2),
(19, 'Visakhapatnam', 2),
(20, 'Vizianagaram', 2),
(21, 'Yemmiganur', 2),
(22, 'Itanagar', 3),
(23, 'Dhuburi', 4),
(24, 'Dibrugarh', 4),
(25, 'Dispur', 4),
(26, 'Guwahati', 4),
(27, 'Jorhat', 4),
(28, 'Nagaon', 4),
(29, 'Sivasagar', 4),
(30, 'Silchar', 4),
(31, 'Tezpur', 4),
(32, 'Tinsukia', 4),
(33, 'Ara', 5),
(34, 'Barauni', 5),
(35, 'Begusarai', 5),
(36, 'Bettiah', 5),
(37, 'Bhagalpur', 5),
(38, 'Bihar Sharif', 5),
(39, 'Bodh Gaya', 5),
(40, 'Buxar', 5),
(41, 'Chapra', 5),
(42, 'Darbhanga', 5),
(43, 'Dehri', 5),
(44, 'Dinapur Nizamat', 5),
(45, 'Gaya', 5),
(46, 'Hajipur', 5),
(47, 'Jamalpur', 5),
(48, 'Katihar', 5),
(49, 'Madhubani', 5),
(50, 'Motihari', 5),
(51, 'Munger', 5),
(52, 'Muzaffarpur', 5),
(53, 'Patna', 5),
(54, 'Purnia', 5),
(55, 'Pusa', 5),
(56, 'Saharsa', 5),
(57, 'Samastipur', 5),
(58, 'Sasaram', 5),
(59, 'Sitamarhi', 5),
(60, 'Siwan', 5),
(61, 'Chandigarh', 6),
(62, 'Ambikapur', 7),
(63, 'Bhilai', 7),
(64, 'Bilaspur', 7),
(65, 'Dhamtari', 7),
(66, 'Durg', 7),
(67, 'Jagdalpur', 7),
(68, 'Raipur', 7),
(69, 'Rajnandgaon', 7),
(70, 'Daman', 8),
(71, 'Diu', 8),
(72, 'Silvassa', 8),
(73, 'Delhi', 9),
(74, 'New Delhi', 9),
(75, 'Madgaon', 10),
(76, 'Panaji', 10),
(77, 'Ahmadabad', 11),
(78, 'Amreli', 11),
(79, 'Bharuch', 11),
(80, 'Bhavnagar', 11),
(81, 'Bhuj', 11),
(82, 'Dwarka', 11),
(83, 'Gandhinagar', 11),
(84, 'Godhra', 11),
(85, 'Jamnagar', 11),
(86, 'Junagadh', 11),
(87, 'Kandla', 11),
(88, 'Khambhat', 11),
(89, 'Kheda', 11),
(90, 'Mahesana', 11),
(91, 'Morbi', 11),
(92, 'Nadiad', 11),
(93, 'Navsari', 11),
(94, 'Okha', 11),
(95, 'Palanpur', 11),
(96, 'Patan', 11),
(97, 'Porbandar', 11),
(98, 'Rajkot', 11),
(99, 'Surat', 11),
(100, 'Surendranagar', 11),
(101, 'Valsad', 11),
(102, 'Veraval', 11),
(103, 'Ambala', 12),
(104, 'Bhiwani', 12),
(105, 'Chandigarh', 12),
(106, 'Faridabad', 12),
(107, 'Firozpur Jhirka', 12),
(108, 'Gurugram', 12),
(109, 'Hansi', 12),
(110, 'Hisar', 12),
(111, 'Jind', 12),
(112, 'Kaithal', 12),
(113, 'Karnal', 12),
(114, 'Kurukshetra', 12),
(115, 'Panipat', 12),
(116, 'Pehowa', 12),
(117, 'Rewari', 12),
(118, 'Rohtak', 12),
(119, 'Sirsa', 12),
(120, 'Sonipat', 12),
(121, 'Bilaspur', 13),
(122, 'Chamba', 13),
(123, 'Dalhousie', 13),
(124, 'Dharmshala', 13),
(125, 'Hamirpur', 13),
(126, 'Kangra', 13),
(127, 'Kullu', 13),
(128, 'Mandi', 13),
(129, 'Nahan', 13),
(130, 'Shimla', 13),
(131, 'Una', 13),
(132, 'Anantnag', 14),
(133, 'Baramula', 14),
(134, 'Doda', 14),
(135, 'Gulmarg', 14),
(136, 'Jammu', 14),
(137, 'Kathua', 14),
(138, 'Punch', 14),
(139, 'Rajouri', 14),
(140, 'Srinagar', 14),
(141, 'Udhampur', 14),
(142, 'Bokaro', 15),
(143, 'Chaibasa', 15),
(144, 'Deoghar', 15),
(145, 'Dhanbad', 15),
(146, 'Dumka', 15),
(147, 'Giridih', 15),
(148, 'Hazaribag', 15),
(149, 'Jamshedpur', 15),
(150, 'Jharia', 15),
(151, 'Rajmahal', 15),
(152, 'Ranchi', 15),
(153, 'Saraikela', 15),
(154, 'Badami', 16),
(155, 'Ballari', 16),
(156, 'Bengaluru', 16),
(157, 'Belagavi', 16),
(158, 'Bhadravati', 16),
(159, 'Bidar', 16),
(160, 'Chikkamagaluru', 16),
(161, 'Chitradurga', 16),
(162, 'Davangere', 16),
(163, 'Halebid', 16),
(164, 'Hassan', 16),
(165, 'Hubballi-Dharwad', 16),
(166, 'Kalaburagi', 16),
(167, 'Kolar', 16),
(168, 'Madikeri', 16),
(169, 'Mandya', 16),
(170, 'Mangaluru', 16),
(171, 'Mysuru', 16),
(172, 'Raichur', 16),
(173, 'Shivamogga', 16),
(174, 'Shravanabelagola', 16),
(175, 'Shrirangapattana', 16),
(176, 'Tumakuru', 16),
(177, 'Vijayapura', 16),
(178, 'Alappuzha', 17),
(179, 'Vatakara', 17),
(180, 'Idukki', 17),
(181, 'Kannur', 17),
(182, 'Kochi', 17),
(183, 'Kollam', 17),
(184, 'Kottayam', 17),
(185, 'Kozhikode', 17),
(186, 'Mattancheri', 17),
(187, 'Palakkad', 17),
(188, 'Thalassery', 17),
(189, 'Thiruvananthapuram', 17),
(190, 'Thrissur', 17),
(191, 'Kargil', 18),
(192, 'Leh', 18),
(193, 'Balaghat', 19),
(194, 'Barwani', 19),
(195, 'Betul', 19),
(196, 'Bharhut', 19),
(197, 'Bhind', 19),
(198, 'Bhojpur', 19),
(199, 'Bhopal', 19),
(200, 'Burhanpur', 19),
(201, 'Chhatarpur', 19),
(202, 'Chhindwara', 19),
(203, 'Damoh', 19),
(204, 'Datia', 19),
(205, 'Dewas', 19),
(206, 'Dhar', 19),
(207, 'Dr. Ambedkar Nagar (Mhow)', 19),
(208, 'Guna', 19),
(209, 'Gwalior', 19),
(210, 'Hoshangabad', 19),
(211, 'Indore', 19),
(212, 'Itarsi', 19),
(213, 'Jabalpur', 19),
(214, 'Jhabua', 19),
(215, 'Khajuraho', 19),
(216, 'Khandwa', 19),
(217, 'Khargone', 19),
(218, 'Maheshwar', 19),
(219, 'Mandla', 19),
(220, 'Mandsaur', 19),
(221, 'Morena', 19),
(222, 'Murwara', 19),
(223, 'Narsimhapur', 19),
(224, 'Narsinghgarh', 19),
(225, 'Narwar', 19),
(226, 'Neemuch', 19),
(227, 'Nowgong', 19),
(228, 'Orchha', 19),
(229, 'Panna', 19),
(230, 'Raisen', 19),
(231, 'Rajgarh', 19),
(232, 'Ratlam', 19),
(233, 'Rewa', 19),
(234, 'Sagar', 19),
(235, 'Sarangpur', 19),
(236, 'Satna', 19),
(237, 'Sehore', 19),
(238, 'Seoni', 19),
(239, 'Shahdol', 19),
(240, 'Shajapur', 19),
(241, 'Sheopur', 19),
(242, 'Shivpuri', 19),
(243, 'Ujjain', 19),
(244, 'Vidisha', 19),
(281, 'Imphal', 21),
(282, 'Cherrapunji', 22),
(283, 'Shillong', 22),
(284, 'Aizawl', 23),
(285, 'Lunglei', 23),
(286, 'Kohima', 24),
(287, 'Mon', 24),
(288, 'Phek', 24),
(289, 'Wokha', 24),
(290, 'Zunheboto', 24),
(291, 'Balangir', 25),
(292, 'Baleshwar', 25),
(293, 'Baripada', 25),
(294, 'Bhubaneshwar', 25),
(295, 'Brahmapur', 25),
(296, 'Cuttack', 25),
(297, 'Dhenkanal', 25),
(298, 'Kendujhar', 25),
(299, 'Konark', 25),
(300, 'Koraput', 25),
(301, 'Paradip', 25),
(302, 'Phulabani', 25),
(303, 'Puri', 25),
(304, 'Sambalpur', 25),
(305, 'Udayagiri', 25),
(306, 'Karaikal', 26),
(307, 'Mahe', 26),
(308, 'Puducherry', 26),
(309, 'Yanam', 26),
(310, 'Amritsar', 27),
(311, 'Batala', 27),
(312, 'Chandigarh', 27),
(313, 'Faridkot', 27),
(314, 'Firozpur', 27),
(315, 'Gurdaspur', 27),
(316, 'Hoshiarpur', 27),
(317, 'Jalandhar', 27),
(318, 'Kapurthala', 27),
(319, 'Ludhiana', 27),
(320, 'Nabha', 27),
(321, 'Patiala', 27),
(322, 'Rupnagar', 27),
(323, 'Sangrur', 27),
(324, 'Abu', 28),
(325, 'Ajmer', 28),
(326, 'Alwar', 28),
(327, 'Amer', 28),
(328, 'Barmer', 28),
(329, 'Beawar', 28),
(330, 'Bharatpur', 28),
(331, 'Bhilwara', 28),
(332, 'Bikaner', 28),
(333, 'Bundi', 28),
(334, 'Chittaurgarh', 28),
(335, 'Churu', 28),
(336, 'Dhaulpur', 28),
(337, 'Dungarpur', 28),
(338, 'Ganganagar', 28),
(339, 'Hanumangarh', 28),
(340, 'Jaipur', 28),
(341, 'Jaisalmer', 28),
(342, 'Jalor', 28),
(343, 'Jhalawar', 28),
(344, 'Jhunjhunu', 28),
(345, 'Jodhpur', 28),
(346, 'Kishangarh', 28),
(347, 'Kota', 28),
(348, 'Merta', 28),
(349, 'Nagaur', 28),
(350, 'Nathdwara', 28),
(351, 'Pali', 28),
(352, 'Phalodi', 28),
(353, 'Pushkar', 28),
(354, 'Sawai Madhopur', 28),
(355, 'Shahpura', 28),
(356, 'Sikar', 28),
(357, 'Sirohi', 28),
(358, 'Tonk', 28),
(359, 'Udaipur', 28),
(360, 'Gangtok', 29),
(361, 'Gyalshing', 29),
(362, 'Lachung', 29),
(363, 'Mangan', 29),
(364, 'Arcot', 30),
(365, 'Chengalpattu', 30),
(366, 'Chennai', 30),
(367, 'Chidambaram', 30),
(368, 'Coimbatore', 30),
(369, 'Cuddalore', 30),
(370, 'Dharmapuri', 30),
(371, 'Dindigul', 30),
(372, 'Erode', 30),
(373, 'Kanchipuram', 30),
(374, 'Kanniyakumari', 30),
(375, 'Kodaikanal', 30),
(376, 'Kumbakonam', 30),
(377, 'Madurai', 30),
(378, 'Mamallapuram', 30),
(379, 'Nagappattinam', 30),
(380, 'Nagercoil', 30),
(381, 'Palayamkottai', 30),
(382, 'Pudukkottai', 30),
(383, 'Rajapalayam', 30),
(384, 'Ramanathapuram', 30),
(385, 'Salem', 30),
(386, 'Thanjavur', 30),
(387, 'Tiruchchirappalli', 30),
(388, 'Tirunelveli', 30),
(389, 'Tiruppur', 30),
(390, 'Thoothukudi', 30),
(391, 'Udhagamandalam', 30),
(392, 'Vellore', 30),
(393, 'Hyderabad', 31),
(394, 'Karimnagar', 31),
(395, 'Khammam', 31),
(396, 'Mahbubnagar', 31),
(397, 'Nizamabad', 31),
(398, 'Sangareddi', 31),
(399, 'Warangal', 31),
(400, 'Agartala', 32),
(401, 'Agra', 33),
(402, 'Aligarh', 33),
(403, 'Amroha', 33),
(404, 'Ayodhya', 33),
(405, 'Azamgarh', 33),
(406, 'Bahraich', 33),
(407, 'Ballia', 33),
(408, 'Banda', 33),
(409, 'Bara Banki', 33),
(410, 'Bareilly', 33),
(411, 'Basti', 33),
(412, 'Bijnor', 33),
(413, 'Bithur', 33),
(414, 'Budaun', 33),
(415, 'Bulandshahr', 33),
(416, 'Deoria', 33),
(417, 'Etah', 33),
(418, 'Etawah', 33),
(419, 'Faizabad', 33),
(420, 'Farrukhabad-cum-Fatehgarh', 33),
(421, 'Fatehpur', 33),
(422, 'Fatehpur Sikri', 33),
(423, 'Ghaziabad', 33),
(424, 'Ghazipur', 33),
(425, 'Gonda', 33),
(426, 'Gorakhpur', 33),
(427, 'Hamirpur', 33),
(428, 'Hardoi', 33),
(429, 'Hathras', 33),
(430, 'Jalaun', 33),
(431, 'Jaunpur', 33),
(432, 'Jhansi', 33),
(433, 'Kannauj', 33),
(434, 'Kanpur', 33),
(435, 'Lakhimpur', 33),
(436, 'Lalitpur', 33),
(437, 'Lucknow', 33),
(438, 'Mainpuri', 33),
(439, 'Mathura', 33),
(440, 'Meerut', 33),
(441, 'Mirzapur-Vindhyachal', 33),
(442, 'Moradabad', 33),
(443, 'Muzaffarnagar', 33),
(444, 'Partapgarh', 33),
(445, 'Pilibhit', 33),
(446, 'Prayagraj', 33),
(447, 'Rae Bareli', 33),
(448, 'Rampur', 33),
(449, 'Saharanpur', 33),
(450, 'Sambhal', 33),
(451, 'Shahjahanpur', 33),
(452, 'Sitapur', 33),
(453, 'Sultanpur', 33),
(454, 'Tehri', 33),
(455, 'Varanasi', 33),
(456, 'Almora', 34),
(457, 'Dehra Dun', 34),
(458, 'Haridwar', 34),
(459, 'Mussoorie', 34),
(460, 'Nainital', 34),
(461, 'Pithoragarh', 34),
(462, 'Alipore', 35),
(463, 'Alipur Duar', 35),
(464, 'Asansol', 35),
(465, 'Baharampur', 35),
(466, 'Bally', 35),
(467, 'Balurghat', 35),
(468, 'Bankura', 35),
(469, 'Baranagar', 35),
(470, 'Barasat', 35),
(471, 'Barrackpore', 35),
(472, 'Basirhat', 35),
(473, 'Bhatpara', 35),
(474, 'Bishnupur', 35),
(475, 'Budge Budge', 35),
(476, 'Burdwan', 35),
(477, 'Chandernagore', 35),
(478, 'Darjeeling', 35),
(479, 'Diamond Harbour', 35),
(480, 'Dum Dum', 35),
(481, 'Durgapur', 35),
(482, 'Halisahar', 35),
(483, 'Haora', 35),
(484, 'Hugli', 35),
(485, 'Ingraj Bazar', 35),
(486, 'Jalpaiguri', 35),
(487, 'Kalimpong', 35),
(488, 'Kamarhati', 35),
(489, 'Kanchrapara', 35),
(490, 'Kharagpur', 35),
(491, 'Cooch Behar', 35),
(492, 'Kolkata', 35),
(493, 'Krishnanagar', 35),
(494, 'Malda', 35),
(495, 'Midnapore', 35),
(496, 'Murshidabad', 35),
(497, 'Nabadwip', 35),
(498, 'Palashi', 35),
(499, 'Panihati', 35),
(500, 'Purulia', 35),
(501, 'Raiganj', 35),
(502, 'Santipur', 35),
(503, 'Shantiniketan', 35),
(504, 'Shrirampur', 35),
(505, 'Siliguri', 35),
(506, 'Siuri', 35),
(507, 'Tamluk', 35),
(508, 'Titagarh', 35),
(509, 'Ahmednagar', 20),
(510, 'Akola', 20),
(511, 'Amravati', 20),
(512, 'Aurangabad', 20),
(513, 'Beed', 20),
(514, 'Bhandara', 20),
(515, 'Buldhana', 20),
(516, 'Chandrapur', 20),
(517, 'Dhule', 20),
(518, 'Gadchiroli', 20),
(519, 'Gondia', 20),
(520, 'Hingoli', 20),
(521, 'Jalgaon', 20),
(522, 'Jalna', 20),
(523, 'Kolhapur', 20),
(524, 'Latur', 20),
(525, 'Mumbai City', 20),
(526, 'Mumbai Suburban', 20),
(527, 'Nagpur', 20),
(528, 'Nanded', 20),
(529, 'Nandurbar', 20),
(530, 'Nashik', 20),
(531, 'Osmanabad', 20),
(532, 'Palghar', 20),
(533, 'Parbhani', 20),
(534, 'Pune', 20),
(535, 'Raigad', 20),
(536, 'Ratnagiri', 20),
(537, 'Sangli', 20),
(538, 'Satara', 20),
(539, 'Sindhudurg', 20),
(540, 'Solapur', 20),
(541, 'Thane', 20),
(542, 'Wardha', 20),
(543, 'Washim', 20),
(544, 'Yavatmal', 20);

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `country_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`country_id`, `name`) VALUES
(1, 'India');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `department_name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `department_head` bigint(20) DEFAULT NULL,
  `created_ip_address` varchar(255) DEFAULT NULL,
  `modified_ip_address` varchar(255) DEFAULT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  `modified_by` bigint(20) DEFAULT NULL,
  `status` enum('active','delete','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `code`, `department_name`, `description`, `email`, `mobile`, `department_head`, `created_ip_address`, `modified_ip_address`, `created_by`, `modified_by`, `status`, `created_at`, `updated_at`) VALUES
(1, 'DEPT001', 'Pathology', NULL, 'ddh@gmail.com', '+917318560108', 14, '127.0.0.1', '127.0.0.1', 1, 1, 'inactive', '2025-09-15 23:39:13', '2025-09-15 23:39:13'),
(2, 'DEPT002', 'Radiology', NULL, 'ddh@gmail.com', '+917318560108', 14, '127.0.0.1', NULL, 1, NULL, 'active', '2025-09-15 23:39:41', '2025-09-15 23:39:41'),
(3, 'DEPT003', 'Cardiology', NULL, 'ddh@gmail.com', '+917318560108', 14, '127.0.0.1', NULL, 1, NULL, 'active', '2025-09-15 23:40:09', '2025-09-15 23:40:09'),
(4, 'DEPT004', 'Microbiology', NULL, 'ddh@gmail.com', '+917318560108', 14, '127.0.0.1', NULL, 1, NULL, 'active', '2025-09-15 23:41:30', '2025-09-15 23:41:30'),
(5, 'DEPT005', 'Biochemistry', NULL, 'ddh@gmail.com', '+917318560108', 14, '127.0.0.1', NULL, 1, NULL, 'active', '2025-09-15 23:43:47', '2025-09-15 23:43:47'),
(6, 'DEPT006', 'Radiology12', 'dxas', NULL, NULL, NULL, '127.0.0.1', '127.0.0.1', 1, 1, 'inactive', '2025-10-27 07:51:04', '2025-10-27 07:51:04'),
(7, 'DEPT007', 'Radiology3', 'Heello', NULL, NULL, NULL, '127.0.0.1', NULL, 1, NULL, 'active', '2025-10-27 08:59:21', '2025-10-27 08:59:21'),
(8, 'DEPT008', 'ashdgjagsdgjasgj', 'szfdZFDAF', NULL, NULL, NULL, '127.0.0.1', NULL, 1, NULL, 'active', '2025-10-27 09:00:38', '2025-10-27 09:00:38'),
(9, 'DEPT009', 'Department Name', 'Description1', NULL, NULL, NULL, '127.0.0.1', '127.0.0.1', 1, 1, 'delete', '2025-10-27 09:09:02', '2025-10-27 09:12:42');

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
-- Table structure for table `general_settings`
--

CREATE TABLE `general_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `address` longtext DEFAULT NULL,
  `map_link` longtext DEFAULT NULL,
  `facebook_url` varchar(255) DEFAULT NULL,
  `linkedin_url` varchar(255) DEFAULT NULL,
  `instagram_url` varchar(255) DEFAULT NULL,
  `twitter_url` varchar(255) DEFAULT NULL,
  `skype_url` varchar(255) DEFAULT NULL,
  `created_ip_address` varchar(255) DEFAULT NULL,
  `modified_ip_address` varchar(255) DEFAULT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  `modified_by` bigint(20) DEFAULT NULL,
  `status` enum('active','delete','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `general_settings`
--

INSERT INTO `general_settings` (`id`, `email`, `mobile`, `address`, `map_link`, `facebook_url`, `linkedin_url`, `instagram_url`, `twitter_url`, `skype_url`, `created_ip_address`, `modified_ip_address`, `created_by`, `modified_by`, `status`, `created_at`, `updated_at`) VALUES
(1, 'admin@gmail.com', '07318560108', 'Bair Amad Karari', NULL, NULL, NULL, NULL, NULL, NULL, '127.0.0.1', NULL, 1, NULL, 'active', '2025-08-11 06:33:23', '2025-08-11 06:33:23');

-- --------------------------------------------------------

--
-- Table structure for table `internal_doctors`
--

CREATE TABLE `internal_doctors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `doctor_name` varchar(255) DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `role_id` bigint(20) UNSIGNED DEFAULT NULL,
  `last_login` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `doctor_image_name` varchar(255) DEFAULT NULL,
  `doctor_image_path` varchar(255) DEFAULT NULL,
  `doctor_sign_name` varchar(255) DEFAULT NULL,
  `doctor_sign_path` varchar(255) DEFAULT NULL,
  `created_ip_address` varchar(255) DEFAULT NULL,
  `modified_ip_address` varchar(255) DEFAULT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  `modified_by` bigint(20) DEFAULT NULL,
  `status` enum('active','delete','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `internal_doctors`
--

INSERT INTO `internal_doctors` (`id`, `user_id`, `code`, `doctor_name`, `gender`, `email`, `password`, `mobile`, `role_id`, `last_login`, `remember_token`, `address`, `doctor_image_name`, `doctor_image_path`, `doctor_sign_name`, `doctor_sign_path`, `created_ip_address`, `modified_ip_address`, `created_by`, `modified_by`, `status`, `created_at`, `updated_at`) VALUES
(5, 7, 'ID0013', 'xyz', 'Male', 'doctor@gmail.com', NULL, '+917318560108', NULL, '2025-10-08 11:55:23', NULL, 'Bair Amad Karari', NULL, 'images/internal_doctors/AURP5Wbf2WfknZgmdjqwzvPeIRYfbuLOnPokaLQ5.jpg', NULL, NULL, '127.0.0.1', NULL, 1, NULL, 'active', '2025-09-30 01:25:52', '2025-10-08 06:25:23'),
(7, 8, 'ID0007', 'Testing Doctor', 'Male', 'doctor1@gmail.com', NULL, '+917318560908', NULL, NULL, NULL, 'Bair Amad Karari', NULL, 'images/internal_doctors/AURP5Wbf2WfknZgmdjqwzvPeIRYfbuLOnPokaLQ5.jpg', NULL, NULL, '127.0.0.1', NULL, 1, NULL, 'active', '2025-10-14 00:40:49', '2025-10-14 00:40:49'),
(8, 9, 'ID0008', 'Doctor Three', 'Male', 'doctor3@gmail.com', NULL, '+917318560709', NULL, NULL, NULL, 'Bair Amad Karari', NULL, NULL, NULL, NULL, '127.0.0.1', NULL, 1, NULL, 'active', '2025-10-14 02:06:26', '2025-10-14 02:06:26'),
(9, 10, 'ID0009', 'Doctor Four', 'Male', 'doctor4@gmail.com', NULL, '+918318560108', NULL, NULL, NULL, 'Bair Amad Karari', NULL, NULL, NULL, NULL, '127.0.0.1', NULL, 1, NULL, 'active', '2025-10-14 03:19:41', '2025-10-14 03:19:41'),
(10, 25, 'ID0010', 'sdsadasd', 'Male', 'sdfdskjhjh@gmail.com', NULL, '9807660108', NULL, NULL, NULL, 'Bair Amad Karari', NULL, NULL, NULL, NULL, '127.0.0.1', NULL, 1, NULL, 'active', '2025-10-28 05:43:50', '2025-10-28 05:43:50');

-- --------------------------------------------------------

--
-- Table structure for table `master_admins`
--

CREATE TABLE `master_admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_type` varchar(255) DEFAULT NULL,
  `user_id` varchar(255) DEFAULT NULL,
  `user_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `mobile_no` varchar(255) DEFAULT NULL,
  `role_id` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `user_profile_image_path` varchar(255) DEFAULT NULL,
  `user_profile_image_name` varchar(255) DEFAULT NULL,
  `fcm_token` varchar(255) DEFAULT NULL,
  `access_token` varchar(255) DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `otp` bigint(20) DEFAULT NULL,
  `status` enum('active','delete','inactive') NOT NULL DEFAULT 'active',
  `created_ip_address` varchar(255) DEFAULT NULL,
  `modified_ip_address` varchar(255) DEFAULT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  `modified_by` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `master_admins`
--

INSERT INTO `master_admins` (`id`, `user_type`, `user_id`, `user_name`, `email`, `password`, `mobile_no`, `role_id`, `address`, `user_profile_image_path`, `user_profile_image_name`, `fcm_token`, `access_token`, `last_login`, `remember_token`, `otp`, `status`, `created_ip_address`, `modified_ip_address`, `created_by`, `modified_by`, `created_at`, `updated_at`) VALUES
(1, 'system', '1', 'ChromoXpert', 'admin@gmail.com', '$2y$10$InJ0GHoOaHXJHMuEYqTMye.t5E4QfWDrzNLW/pltguVNM/OZCpFUm', NULL, '1', NULL, NULL, NULL, NULL, NULL, '2025-10-11 04:14:45', NULL, NULL, 'active', NULL, NULL, NULL, NULL, NULL, '2025-10-10 22:44:45'),
(26, 'system', '5', 'Admin', 'admin1@gmail.com', '$2y$10$hagGL2ikhRRnKCuub5hxJuGQ4cOgXtcepMBH9EvdnpWIbQNRIxHnO', '9792159492', '6', 'Bair Amad Karari', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', '127.0.0.1', NULL, 1, NULL, '2025-10-14 00:05:27', '2025-10-14 00:05:27'),
(29, 'system', '47', 'subadmin', 'subadmin@gmail.com', '$2y$10$aisX29MH5gK1OKc/130ajerhj8yb6CWHrsoMf17BhRaA4.b12oz2O', '7668560108', '10', 'Bair Amad Karari', 'public/images/profile_images/deepu (1).png', 'deepu (1).png', NULL, NULL, NULL, NULL, NULL, 'active', '127.0.0.1', '127.0.0.1', 1, 1, '2025-10-29 05:14:23', '2025-10-29 23:04:14'),
(30, 'system', '48', 'xyz', 'xyz234@gmail.com', '$2y$10$G9c8H0990bBxcO4LRsEWYeFJQkveQtntXKmSOwYsKleiwHbuNQ1aK', '73185606633', '11', 'Bair Amad Karari', 'public/images/profile_images/deepu (1).png', 'deepu (1).png', NULL, NULL, NULL, NULL, NULL, 'active', '127.0.0.1', '127.0.0.1', 1, 1, '2025-10-29 05:18:11', '2025-10-29 23:03:27');

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
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2023_07_05_075239_create_master_admins_table', 1),
(6, '2023_07_13_034312_create_general_settings_table', 1),
(7, '2023_08_22_102532_create_role_privileges_table', 1),
(8, '2023_08_28_112847_create_visual_settings_table', 1),
(10, '2025_09_01_045614_create_petparents_table', 2),
(11, '2025_09_01_112932_create_referee_doctors_table', 3),
(12, '2025_09_02_050059_create_internal_doctors_table', 4),
(13, '2025_09_02_093535_create_branches_table', 5),
(15, '2025_09_03_072046_create_departments_table', 6),
(16, '2025_09_04_061330_create_pets_table', 7),
(19, '2025_09_05_080749_create_parameter_options_table', 8),
(27, '2025_09_05_080633_create_test_parameters_table', 11),
(28, '2025_09_10_122330_create_appointments_table', 12),
(29, '2025_09_11_115035_create_appointment_tests_table', 13),
(30, '2025_09_12_113402_add_transaction_details_to_appointments_table', 14),
(32, '2025_09_05_080504_create_tests_table', 15),
(33, '2025_09_17_124719_create_test_results_table', 16),
(34, '2025_09_22_090944_add_test_for_to_tests_table', 16),
(35, '2025_09_22_091720_add_paid_amount_to_appointments_table', 17),
(36, '2025_09_23_070550_add_signed_columns_to_test_results_table', 18),
(37, '2025_09_23_124538_create_test_result_components_table', 19),
(38, '2025_09_26_112205_create_test_profiles_table', 20),
(39, '2025_09_26_112226_create_test_profile_tests_table', 20),
(40, '2025_09_29_070120_add_profile_code_and_description_to_test_profiles_table', 21),
(41, '2025_09_29_122714_add_price_2_to_tests_table', 22),
(42, '2025_09_30_065120_update_internal_doctors_for_auth', 23),
(43, '2025_09_30_065123_update_branches_for_auth', 23),
(44, '2025_10_01_070520_add_branch_and_doctor_to_appointments_table', 24),
(45, '2025_10_09_062020_create_sessions_table', 25),
(47, '2014_10_12_000000_create_users_table', 26),
(49, '2025_10_24_040027_add_type_to_branches_table', 27),
(50, '2025_10_24_093905_create_sample_collections_table', 28),
(51, '2025_10_28_054015_add_assigned_to_doctor_id_to_test_results_table', 29),
(52, '2025_10_28_115430_add_gst_to_tests_table', 30),
(53, '2025_10_28_120732_add_total_price_to_tests_table', 31),
(54, '2025_10_30_053000_add_doctor_approval_to_test_results', 32),
(55, '2025_11_04_050124_add_otp_columns_to_users_table', 33);

-- --------------------------------------------------------

--
-- Table structure for table `parameter_options`
--

CREATE TABLE `parameter_options` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `parameter_id` bigint(20) DEFAULT NULL,
  `option_value` varchar(255) NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_ip_address` varchar(255) DEFAULT NULL,
  `modified_ip_address` varchar(255) DEFAULT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  `modified_by` bigint(20) DEFAULT NULL,
  `status` enum('active','delete','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `parameter_options`
--

INSERT INTO `parameter_options` (`id`, `parameter_id`, `option_value`, `sort_order`, `created_ip_address`, `modified_ip_address`, `created_by`, `modified_by`, `status`, `created_at`, `updated_at`) VALUES
(1, 12, 'Option 1', 0, '127.0.0.1', '127.0.0.1', 1, 1, 'active', '2025-09-18 00:22:42', '2025-10-28 07:31:32'),
(2, 12, 'option 2', 1, '127.0.0.1', '127.0.0.1', 1, 1, 'active', '2025-09-18 00:22:42', '2025-10-28 07:31:32'),
(3, 16, 'Normal', 0, '127.0.0.1', '127.0.0.1', 1, 1, 'active', '2025-09-22 04:17:06', '2025-10-28 07:31:07'),
(4, 16, 'abnormal', 1, '127.0.0.1', '127.0.0.1', 1, 1, 'active', '2025-09-22 04:17:06', '2025-10-28 07:31:07'),
(5, 20, 'Normal', 0, '127.0.0.1', '127.0.0.1', 1, 1, 'active', '2025-09-22 04:19:01', '2025-10-28 07:30:43'),
(6, 20, 'abnormal', 1, '127.0.0.1', '127.0.0.1', 1, 1, 'active', '2025-09-22 04:19:01', '2025-10-28 07:30:43'),
(7, 24, 'option 1', 0, '127.0.0.1', '127.0.0.1', 1, 1, 'active', '2025-09-22 04:23:30', '2025-10-28 07:30:13'),
(8, 24, 'option 1', 1, '127.0.0.1', '127.0.0.1', 1, 1, 'active', '2025-09-22 04:23:30', '2025-10-28 07:30:13'),
(9, 32, 'option 1', 0, '127.0.0.1', '127.0.0.1', 1, 1, 'active', '2025-09-22 04:29:26', '2025-10-28 06:55:45'),
(10, 32, 'option 1', 1, '127.0.0.1', '127.0.0.1', 1, 1, 'active', '2025-09-22 04:29:26', '2025-10-28 06:55:45'),
(11, 36, 'option 1', 0, '127.0.0.1', '127.0.0.1', 1, 1, 'active', '2025-09-22 04:38:28', '2025-10-28 06:56:30'),
(12, 36, 'option 2', 1, '127.0.0.1', '127.0.0.1', 1, 1, 'active', '2025-09-22 04:38:28', '2025-10-28 06:56:30'),
(13, 42, 'Option 1', 0, '127.0.0.1', '127.0.0.1', 1, 1, 'active', '2025-09-26 00:26:40', '2025-10-28 06:57:10'),
(14, 42, 'Option 2', 1, '127.0.0.1', '127.0.0.1', 1, 1, 'active', '2025-09-26 00:26:40', '2025-10-28 06:57:10');

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
-- Table structure for table `petparents`
--

CREATE TABLE `petparents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `user_id` bigint(255) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `created_ip_address` varchar(255) DEFAULT NULL,
  `modified_ip_address` varchar(255) DEFAULT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  `modified_by` bigint(20) DEFAULT NULL,
  `status` enum('active','delete','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `petparents`
--

INSERT INTO `petparents` (`id`, `code`, `user_id`, `name`, `gender`, `email`, `mobile`, `address`, `created_ip_address`, `modified_ip_address`, `created_by`, `modified_by`, `status`, `created_at`, `updated_at`) VALUES
(1, 'PP0001', 0, 'Deepak Pet Parent', 'Male', 'deepalpetparent@gmail.com', '+917318560108', 'Bair Amad Karari', '127.0.0.1', '127.0.0.1', 1, 1, 'active', '2025-09-01 04:33:00', '2025-09-01 04:33:00'),
(3, 'PP0003', 0, 'Deepak Tripathi', 'Male', 'deepak1@gmail.com', '+917318560109', 'Bair Amad Karari', '127.0.0.1', NULL, 1, NULL, 'active', '2025-09-15 00:48:12', '2025-09-15 00:48:12'),
(5, 'PP0005', 0, 'Deep', NULL, 'deep1@gmail.com', '7318560110', 'Bair Amad Karari', '127.0.0.1', NULL, 1, NULL, 'active', '2025-09-24 00:32:20', '2025-09-24 00:32:20'),
(8, 'PP0008', 0, 'Ankit', NULL, 'ankit@gmail.com', '7318569800', 'Bair Amad Karari', '127.0.0.1', NULL, 1, NULL, 'active', '2025-09-24 00:57:58', '2025-09-24 00:57:58'),
(10, 'PP0010', 0, 'Shiv', NULL, 'shiv@gnmail.com', '7218560108', 'Bair Amad Karari', '127.0.0.1', NULL, 1, NULL, 'active', '2025-09-24 01:18:57', '2025-09-24 01:18:57'),
(11, 'PP0011', 0, 'Satyam Ojha', NULL, 'snojha@gmail.com', '1234567890', 'Bair Amad Karari', '127.0.0.1', NULL, 1, NULL, 'active', '2025-09-24 01:32:04', '2025-09-24 01:32:04'),
(12, 'PP0012', 11, 'Testing', 'Male', 'testingpetparenr@gmail.com', '1234567899', NULL, '127.0.0.1', NULL, 1, NULL, 'active', '2025-10-14 05:20:22', '2025-10-14 05:20:22'),
(13, 'PP0013', 12, 'Pet parent Added by Branch', 'Male', 'petparent1@gmail.com', '8888560108', 'Bair Amad Karari', '127.0.0.1', NULL, 4, NULL, 'active', '2025-10-14 05:45:40', '2025-10-14 05:45:40'),
(14, 'PP0014', 13, 'Pet Parent One', 'Male', 'petparent230@gmail.com', '7318569999', 'Bair Amad Karari', '127.0.0.1', NULL, 6, NULL, 'active', '2025-10-14 06:34:29', '2025-10-14 06:34:29'),
(15, 'PP0015', 14, 'Pet Owner of new testing Branch', NULL, 'asdsad@gmail.com', '7318999999', 'Bair Amad Karari', '127.0.0.1', NULL, 6, NULL, 'active', '2025-10-15 03:27:34', '2025-10-15 03:27:34'),
(16, 'PP0016', 15, 'xzczxcxz', NULL, 'zxczxc@gmail.com', '0018560108', 'Bair Amad Karari', '127.0.0.1', NULL, 6, NULL, 'active', '2025-10-15 03:30:42', '2025-10-15 03:30:42'),
(17, 'PP0017', 19, 'testing', 'Male', 'testing@gmail.com', '7311111108', 'Bair Amad Karari', '127.0.0.1', NULL, 4, NULL, 'active', '2025-10-17 03:09:41', '2025-10-17 03:09:41'),
(18, 'PP0018', 26, 'sdsadsa', 'Male', 'sasadsa@gmail.com', '6633560108', 'Bair Amad Karari', '127.0.0.1', NULL, 1, NULL, 'active', '2025-10-28 05:49:24', '2025-10-28 05:49:24'),
(19, 'PP0019', 27, 'jsajdsaj', NULL, 'fghgfhfg@gmail.com', '6712345678', 'Bair Amad Karari', '127.0.0.1', NULL, 4, NULL, 'active', '2025-10-28 07:44:16', '2025-10-28 07:44:16'),
(20, 'PP0020', 28, 'Testing owner', NULL, 'hello@gmail.com', '7318589000', 'Bair Amad Karari', '127.0.0.1', NULL, 4, NULL, 'active', '2025-10-28 07:53:36', '2025-10-28 07:53:36'),
(21, 'PP0021', 29, 'hjsahdjkhsadkh', NULL, 'khassah@gmail.com', '7398760108', 'Bair Amad Karari', '127.0.0.1', NULL, 1, NULL, 'active', '2025-10-28 07:58:08', '2025-10-28 07:58:08'),
(22, 'PP0022', 30, 'edfswe', NULL, 'wqeqwewq@gmail.com', '9792159493', 'Bair Amad Karari', '127.0.0.1', NULL, 1, NULL, 'active', '2025-10-28 08:07:50', '2025-10-28 08:07:50'),
(23, 'PP0023', 31, 'sadsaas', NULL, 'saadsad@gmail.com', '7366560133', 'Bair Amad Karari', '127.0.0.1', NULL, 1, NULL, 'active', '2025-10-28 08:18:24', '2025-10-28 08:18:24'),
(24, 'PP0024', 32, 'Hello Owner', NULL, 'hello12@gmail.com', '7373730108', 'Bair Amad Karari', '127.0.0.1', NULL, 1, NULL, 'active', '2025-10-28 08:28:23', '2025-10-28 08:28:23'),
(25, 'PP0025', 33, 'Hesasdas', NULL, 'sdfdsf@gmail.com', '7318561167', 'Bair Amad Karari', '127.0.0.1', NULL, 1, NULL, 'active', '2025-10-28 08:35:48', '2025-10-28 08:35:48'),
(26, 'PP0026', 34, 'dxfsdfd', NULL, 'rdfgdfgd@gmail.com', '7318566338', 'Bair Amad Karari', '127.0.0.1', NULL, 1, NULL, 'active', '2025-10-28 08:42:33', '2025-10-28 08:42:33'),
(27, 'PP0027', 36, 'zxcZXSDs', NULL, 'sdfdsfsdf@gmail.com', '9873185601', 'Bair Amad Karari', '127.0.0.1', NULL, 1, NULL, 'active', '2025-10-28 08:53:08', '2025-10-28 08:53:08'),
(28, 'PP0028', 38, 'jdjajd', NULL, 'ksdhfkhsdjh@gmail.com', '7316630108', 'Bair Amad Karari', '127.0.0.1', NULL, 1, NULL, 'active', '2025-10-28 09:05:50', '2025-10-28 09:05:50'),
(29, 'PP0029', 40, 'sddsfsdf', NULL, 'khkjhj@gmail.com', '7366560338', 'Bair Amad Karari', '127.0.0.1', NULL, 1, NULL, 'active', '2025-10-28 09:17:54', '2025-10-28 09:17:54'),
(30, 'PP0030', 41, 'sdzfsfsd', NULL, 'fhdfgdfg@gmail.com', '7366527108', 'Bair Amad Karari', '127.0.0.1', NULL, 1, NULL, 'active', '2025-10-28 09:27:11', '2025-10-28 09:27:11'),
(31, 'PP0031', 42, 'qwdwqe', NULL, 'sdjdskjsakh@gmail.com', '7318560108', 'Bair Amad Karari', '127.0.0.1', NULL, 1, NULL, 'active', '2025-10-28 09:28:46', '2025-10-28 09:28:46'),
(32, 'PP0032', 43, 'jsdfksdfhksdhhjksdf', NULL, 'ksdkkdsfasdk@gmail.com', '7663356010', 'Bair Amad Karari', '127.0.0.1', NULL, 1, NULL, 'active', '2025-10-28 09:30:56', '2025-10-28 09:30:56'),
(33, 'PP0033', 44, 'sdsd', NULL, 'sadsad@gmail.com', '7369885601', 'Bair Amad Karari', '127.0.0.1', NULL, 1, NULL, 'active', '2025-10-28 09:32:10', '2025-10-28 09:32:10'),
(34, 'PP0034', 45, 'sdfdfdsf', 'Male', 'sdfsdfsfd@gmail.com', '7318565558', 'Bair Amad Karari', '127.0.0.1', '127.0.0.1', 1, 1, 'active', '2025-10-28 09:33:39', '2025-10-29 05:23:24'),
(35, 'PP0035', 46, 'sdsaidiasdiohasd', 'Male', 'kjaskjashdkj@gmail.com', '7781856010', 'Bair Amad Karari', '127.0.0.1', '127.0.0.1', 1, 1, 'active', '2025-10-28 09:36:12', '2025-10-29 04:33:21'),
(36, 'PP0049', 49, 'Deepak Tripathi', 'male', 'xyz@gmail.com', '7318560109', NULL, '127.0.0.1', NULL, NULL, NULL, 'active', '2025-11-04 07:24:09', '2025-11-04 07:24:09');

-- --------------------------------------------------------

--
-- Table structure for table `pets`
--

CREATE TABLE `pets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pet_code` varchar(255) DEFAULT NULL,
  `pet_parent_id` bigint(20) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `species` varchar(255) DEFAULT NULL,
  `breed` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `age` varchar(255) DEFAULT NULL,
  `weight` varchar(255) DEFAULT NULL,
  `image_name` varchar(255) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `created_ip_address` varchar(255) DEFAULT NULL,
  `modified_ip_address` varchar(255) DEFAULT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  `modified_by` bigint(20) DEFAULT NULL,
  `status` enum('active','delete','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pets`
--

INSERT INTO `pets` (`id`, `pet_code`, `pet_parent_id`, `name`, `species`, `breed`, `type`, `gender`, `dob`, `age`, `weight`, `image_name`, `image_path`, `created_ip_address`, `modified_ip_address`, `created_by`, `modified_by`, `status`, `created_at`, `updated_at`) VALUES
(1, 'PET001', 1, 'Jacy1', 'Feline', 'Birman', 'Dog', 'Female', '2025-06-30', '2 months 5 days', '2.5', 'download (2).jpeg', 'images/pets/uHW3C7TWlvfpos75o2KhJLswvpVxp9BQO4Dmh5xu.jpg', '127.0.0.1', '127.0.0.1', 1, 1, 'delete', '2025-09-04 02:33:53', '2025-09-04 05:03:11'),
(2, 'PET002', 1, 'Deepak', 'Feline', 'Persian', 'Dog', 'Male', '2025-08-20', '15 days', '2', 'download (2).jpeg', 'images/pets/2XKvifin4MfnPUQj7jx4nbl5U60BH95RvHsDQEFf.jpg', '127.0.0.1', '127.0.0.1', 1, 1, 'delete', '2025-09-04 02:50:56', '2025-09-04 02:50:56'),
(3, 'PET003', 1, 'Tommy', 'Canine', 'Labrador ', 'Dog', 'Male', '2025-07-20', '1 month 15 days', '10', 'download (2).jpeg', 'images/pets/64Vv5mxTAcZ8qcuNito2FTNObXtvORJxsjpSrSs4.jpg', '127.0.0.1', NULL, 1, NULL, 'active', '2025-09-04 04:54:23', '2025-09-04 04:54:23'),
(4, 'PET004', 2, 'Deepak ka pet', 'Canine', 'Golden ', 'Dog', 'Male', '2025-07-11', '2 months', '34', 'download (2).jpeg', 'images/pets/GwOQgad5Vp0uZzrcRyhMcJnULdMnA6yrvL9UhGyp.jpg', '127.0.0.1', '127.0.0.1', 1, 1, 'delete', '2025-09-11 05:22:21', '2025-09-11 05:22:21'),
(5, 'PET005', 3, 'Pet1', 'Feline', 'Siamese', 'Dog', 'Male', '2025-05-01', '4 months 14 days', '80', 'download (2).jpeg', 'images/pets/zOEkSxNKElNiyWxtH2wwsoKAUPMBAENvXMbBIpXr.jpg', '127.0.0.1', NULL, 1, NULL, 'active', '2025-09-15 00:50:07', '2025-09-15 00:50:07'),
(6, 'PET006', 3, 'Pet2', 'Avian', 'Birman', 'Cat', 'Male', '2025-07-15', '2 months', '30', 'download (2).jpeg', 'images/pets/3WyGk3KJHmHbxG07Y9EelYeGwWG2fjdBg8oXC0hJ.jpg', '127.0.0.1', NULL, 1, NULL, 'active', '2025-09-15 00:50:58', '2025-09-15 00:50:58'),
(7, 'PET007', 4, 'John', 'Canine', 'Labrador Retriever', 'Dog', 'Male', '2025-08-04', '1 month 20 days', '10', NULL, NULL, '127.0.0.1', NULL, 1, NULL, 'active', '2025-09-24 00:23:25', '2025-09-24 00:23:25'),
(8, 'PET008', 5, 'John', 'Canine', 'Bulldog', 'Dog', 'Male', '2025-08-01', '1 month 23 days', '30', NULL, NULL, '127.0.0.1', NULL, 1, NULL, 'active', '2025-09-24 00:32:20', '2025-09-24 00:32:20'),
(9, 'PET009', 6, 'john', 'Canine', 'Poodle', 'Dog', 'Male', '2025-09-02', '22 days', '4', NULL, NULL, '127.0.0.1', NULL, 1, NULL, 'active', '2025-09-24 00:40:23', '2025-09-24 00:40:23'),
(10, 'PET010', 7, 'Vikky', 'Canine', 'Golden Retriever', 'Dog', 'Male', '2025-09-02', '22 days', '5', NULL, NULL, '127.0.0.1', NULL, 1, NULL, 'active', '2025-09-24 00:50:18', '2025-09-24 00:50:18'),
(11, 'PET011', 8, 'Jacky', 'Canine', 'Rottweiler', 'Dog', 'Male', '2025-09-01', '23 days', '40', NULL, NULL, '127.0.0.1', NULL, 1, NULL, 'active', '2025-09-24 00:57:59', '2025-09-24 00:57:59'),
(12, 'PET012', 9, 'Tom', 'Canine', 'Boxer', 'Dog', 'Male', '2025-08-10', '1 month 14 days', '5', NULL, NULL, '127.0.0.1', NULL, 1, NULL, 'active', '2025-09-24 01:11:13', '2025-09-24 01:11:13'),
(13, 'PET013', 10, 'Captain', 'Canine', 'Poodle', 'Dog', 'Male', '2025-09-08', '16 days', '3', NULL, NULL, '127.0.0.1', NULL, 1, NULL, 'active', '2025-09-24 01:18:57', '2025-09-24 01:18:57'),
(14, 'PET014', 11, 'Kalu', 'Canine', 'Yorkshire Terrier', 'Dog', 'Male', '2025-09-01', '23 days', '4', NULL, NULL, '127.0.0.1', NULL, 1, NULL, 'active', '2025-09-24 01:32:04', '2025-09-24 01:32:04'),
(15, 'PET015', 13, 'Dogy', 'Canine', 'Labrador Retriever', 'Dog', 'Male', '2025-06-01', '4 months 13 days', '5', NULL, NULL, '127.0.0.1', NULL, 4, NULL, 'active', '2025-10-14 06:05:01', '2025-10-14 06:05:01'),
(16, 'PET016', 13, 'Doges', 'Feline', 'British Shorthair', 'Dog', 'Male', '2025-07-01', '3 months 13 days', '10', NULL, NULL, '127.0.0.1', '127.0.0.1', 4, 4, 'active', '2025-10-14 06:06:30', '2025-10-14 06:06:30'),
(17, 'PET017', 14, 'Lussy', 'Canine', 'Bulldog', 'Dog', 'Female', '2025-03-01', '7 months 13 days', '5', 'This may contain_ a small dog wearing a medical hat and holding a needle in it\'s mouth.png', 'images/pets/GZjVLeL5RtqTaIhyLKTtQAOyUo7M6Dml1v2WYn6z.png', '127.0.0.1', NULL, 6, NULL, 'active', '2025-10-14 06:35:26', '2025-10-14 06:35:27'),
(18, 'PET018', 15, 'hjsdfjasd', 'Canine', 'Yorkshire Terrier', 'Dog', 'Male', '2025-08-19', '1 month 26 days', '5', NULL, NULL, '127.0.0.1', NULL, 6, NULL, 'active', '2025-10-15 03:27:34', '2025-10-15 03:27:34'),
(19, 'PET019', 16, 'sfdsdfdsgsdg', 'Canine', 'Poodle', 'Dog', 'Male', '2025-09-14', '1 month 1 day', '15', NULL, NULL, '127.0.0.1', NULL, 6, NULL, 'active', '2025-10-15 03:30:42', '2025-10-15 03:30:42'),
(20, 'PET020', 19, 'khkSDKHkd', 'Feline', 'Siamese', 'Cat', 'Male', '2025-10-21', '7 days', '5', NULL, NULL, '127.0.0.1', NULL, 4, NULL, 'active', '2025-10-28 07:44:16', '2025-10-28 07:44:16'),
(21, 'PET021', 20, 'asdasd', 'Canine', 'Bulldog', 'Dog', 'Male', '2025-10-08', '20 days', '5', NULL, NULL, '127.0.0.1', NULL, 4, NULL, 'active', '2025-10-28 07:53:36', '2025-10-28 07:53:36'),
(22, 'PET022', 21, 'testingpet', 'Feline', 'British Shorthair', 'Cat', 'Male', '2025-10-12', '16 days', '4', NULL, NULL, '127.0.0.1', NULL, 1, NULL, 'active', '2025-10-28 07:58:08', '2025-10-28 07:58:08'),
(23, 'PET023', 22, 'Test', 'Feline', 'Ragdoll', 'Cat', 'Male', '2025-10-16', '12 days', '5', NULL, NULL, '127.0.0.1', NULL, 1, NULL, 'active', '2025-10-28 08:07:50', '2025-10-28 08:07:50'),
(24, 'PET024', 23, 'asdsdsa', 'Canine', 'Beagle', 'Cat', 'Male', '2025-10-21', '7 days', '3', NULL, NULL, '127.0.0.1', NULL, 1, NULL, 'active', '2025-10-28 08:18:24', '2025-10-28 08:18:24'),
(25, 'PET025', 24, 'wwqaasd', 'Canine', 'Bulldog', 'Dog', 'Male', '2025-10-21', '7 days', '5', NULL, NULL, '127.0.0.1', NULL, 1, NULL, 'active', '2025-10-28 08:28:23', '2025-10-28 08:28:23'),
(26, 'PET026', 25, 'kjkjkjjk', 'Canine', 'Poodle', 'Cat', 'Male', '2025-10-15', '13 days', '5', NULL, NULL, '127.0.0.1', NULL, 1, NULL, 'active', '2025-10-28 08:35:48', '2025-10-28 08:35:48'),
(27, 'PET027', 26, 'asdasd', 'Feline', 'Bengal', 'Dog', 'Male', '2025-10-08', '20 days', '5', NULL, NULL, '127.0.0.1', NULL, 1, NULL, 'active', '2025-10-28 08:42:33', '2025-10-28 08:42:33'),
(28, 'PET028', 27, 'wdssadsasa', 'Canine', 'Rottweiler', 'Cat', 'Male', '2025-10-14', '14 days', '5', NULL, NULL, '127.0.0.1', NULL, 1, NULL, 'active', '2025-10-28 08:53:08', '2025-10-28 08:53:08'),
(29, 'PET029', 28, 'asdsa', 'Feline', 'Ragdoll', 'Cat', 'Male', '2025-10-14', '14 days', '4', NULL, NULL, '127.0.0.1', NULL, 1, NULL, 'active', '2025-10-28 09:05:50', '2025-10-28 09:05:50'),
(30, 'PET030', 29, 'ijsadjklsaj', 'Canine', 'Poodle', 'Dog', 'Male', '2025-10-21', '7 days', '6', NULL, NULL, '127.0.0.1', NULL, 1, NULL, 'active', '2025-10-28 09:17:54', '2025-10-28 09:17:54'),
(31, 'PET031', 29, 'ijsadjklsaj', 'Canine', 'Poodle', 'Dog', 'Male', '2025-10-21', '7 days', '6', NULL, NULL, '127.0.0.1', NULL, 1, NULL, 'active', '2025-10-28 09:17:55', '2025-10-28 09:17:55'),
(32, 'PET032', 30, 'jdiwedkj', 'Canine', 'Poodle', 'Dog', 'Male', '2025-10-15', '13 days', '4', NULL, NULL, '127.0.0.1', NULL, 1, NULL, 'active', '2025-10-28 09:27:11', '2025-10-28 09:27:11'),
(33, 'PET033', 30, 'jdiwedkj', 'Canine', 'Poodle', 'Dog', 'Male', '2025-10-15', '13 days', '4', NULL, NULL, '127.0.0.1', NULL, 1, NULL, 'active', '2025-10-28 09:27:11', '2025-10-28 09:27:11'),
(34, 'PET034', 31, 'Hello this is Depak', 'Feline', 'Scottish Fold', 'Cat', 'Male', '2025-10-21', '7 days', '3', NULL, NULL, '127.0.0.1', NULL, 1, NULL, 'active', '2025-10-28 09:28:46', '2025-10-28 09:28:46'),
(35, 'PET035', 31, 'Hello this is Depak', 'Feline', 'Scottish Fold', 'Cat', 'Male', '2025-10-21', '7 days', '3', NULL, NULL, '127.0.0.1', NULL, 1, NULL, 'active', '2025-10-28 09:28:47', '2025-10-28 09:28:47'),
(36, 'PET036', 32, 'lkasdlksaj', 'Canine', 'Rottweiler', 'Dog', 'Male', '2025-10-08', '20 days', '4', NULL, NULL, '127.0.0.1', NULL, 1, NULL, 'active', '2025-10-28 09:30:56', '2025-10-28 09:30:56'),
(37, 'PET037', 32, 'lkasdlksaj', 'Canine', 'Rottweiler', 'Dog', 'Male', '2025-10-08', '20 days', '4', NULL, NULL, '127.0.0.1', NULL, 1, NULL, 'active', '2025-10-28 09:30:57', '2025-10-28 09:30:57'),
(38, 'PET038', 33, 'asdas', 'Feline', 'Siamese', 'Cat', 'Male', '2025-10-21', '7 days', '40', NULL, NULL, '127.0.0.1', NULL, 1, NULL, 'active', '2025-10-28 09:32:10', '2025-10-28 09:32:10'),
(39, 'PET039', 33, 'asdas', 'Feline', 'Siamese', 'Cat', 'Male', '2025-10-21', '7 days', '40', NULL, NULL, '127.0.0.1', NULL, 1, NULL, 'active', '2025-10-28 09:32:11', '2025-10-28 09:32:11'),
(40, 'PET040', 34, 'iasdasd', 'Canine', 'Poodle', 'Dog', 'Male', '2025-10-07', '21 days', '5', NULL, NULL, '127.0.0.1', NULL, 1, NULL, 'active', '2025-10-28 09:33:39', '2025-10-28 09:33:39'),
(41, 'PET041', 34, 'iasdasd', 'Canine', 'Poodle', 'Dog', 'Male', '2025-10-07', '21 days', '5', NULL, NULL, '127.0.0.1', NULL, 1, NULL, 'active', '2025-10-28 09:33:39', '2025-10-28 09:33:39'),
(42, 'PET042', 35, 'kladslksadl', 'Feline', 'Ragdoll', 'Dog', 'Male', '2025-10-21', '7 days', '4', NULL, NULL, '127.0.0.1', NULL, 1, NULL, 'active', '2025-10-28 09:36:12', '2025-10-28 09:36:12'),
(43, 'PET043', 35, 'kladslksadl', 'Feline', 'Ragdoll', 'Dog', 'Male', '2025-10-21', '7 days', '4', NULL, NULL, '127.0.0.1', NULL, 1, NULL, 'active', '2025-10-28 09:36:13', '2025-10-28 09:36:13'),
(44, 'PET044', 29, 'assdasdsad', 'Canine', 'Bulldog', 'Dog', 'Male', '2025-10-07', '21 days', '5', NULL, NULL, '127.0.0.1', NULL, 1, NULL, 'active', '2025-10-28 09:44:44', '2025-10-28 09:44:44'),
(45, 'PET045', 29, 'assdasdsad', 'Canine', 'Bulldog', 'Dog', 'Male', '2025-10-07', '21 days', '5', NULL, NULL, '127.0.0.1', NULL, 1, NULL, 'active', '2025-10-28 09:44:46', '2025-10-28 09:44:46');

-- --------------------------------------------------------

--
-- Table structure for table `referee_doctors`
--

CREATE TABLE `referee_doctors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `doctor_name` varchar(255) DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `commission_percent` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `created_ip_address` varchar(255) DEFAULT NULL,
  `modified_ip_address` varchar(255) DEFAULT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  `modified_by` bigint(20) DEFAULT NULL,
  `status` enum('active','delete','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `referee_doctors`
--

INSERT INTO `referee_doctors` (`id`, `code`, `doctor_name`, `gender`, `email`, `mobile`, `commission_percent`, `address`, `created_ip_address`, `modified_ip_address`, `created_by`, `modified_by`, `status`, `created_at`, `updated_at`) VALUES
(1, 'RD0001', 'Dr Deepak More', 'Male', 'drmore@gmail.com', '+917318560108', '5', 'Bair Amad Karari', '127.0.0.1', '127.0.0.1', 1, 1, 'active', '2025-09-01 06:24:18', '2025-09-01 06:35:46'),
(2, 'RD0002', 'Dr Deepu', 'Male', 'drdeepu@gmail.com', '+917318560100', '5', 'Bair Amad Karari', '127.0.0.1', '127.0.0.1', 1, 1, 'active', '2025-09-09 05:37:57', '2025-09-09 05:38:28'),
(3, 'RD0003', 'Branch Referee Doctor1', 'Male', 'branchrefereedoctor@gmail.com', '7318564111', NULL, 'Bair Amad Karari', '127.0.0.1', '127.0.0.1', 4, 4, 'active', '2025-10-16 00:01:22', '2025-10-16 00:11:00'),
(4, 'RD0004', 'testing1 Referee Doctor', 'Male', 'testing1@gmail.com', '7300000000', NULL, 'Bair Amad Karari', '127.0.0.1', NULL, 4, NULL, 'active', '2025-10-16 01:41:16', '2025-10-16 01:41:16'),
(5, 'RD0005', 'Dr More', 'Male', 'ghfcgdf@gmail.com', '1235678900', '5', 'Bair Amad Karari', '127.0.0.1', NULL, 1, NULL, 'active', '2025-10-28 05:47:05', '2025-10-28 05:47:05');

-- --------------------------------------------------------

--
-- Table structure for table `role_privileges`
--

CREATE TABLE `role_privileges` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_name` varchar(255) DEFAULT NULL,
  `privileges` text DEFAULT NULL,
  `created_ip_address` varchar(255) DEFAULT NULL,
  `modified_ip_address` varchar(255) DEFAULT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  `modified_by` bigint(20) DEFAULT NULL,
  `status` enum('active','delete','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_privileges`
--

INSERT INTO `role_privileges` (`id`, `role_name`, `privileges`, `created_ip_address`, `modified_ip_address`, `created_by`, `modified_by`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'dashboard_view,appointments_view,appointments_add,appointments_edit,appointments_delete,appointments_status_change,reports_view,branch_view,branch_add,branch_edit,branch_delete,branch_status_change,departments_view,departments_add,departments_edit,departments_delete,departments_status_change,doctors_view,doctors_add,doctors_edit,doctors_delete,doctors_status_change,internal_doctors_view,internal_doctors_add,internal_doctors_edit,internal_doctors_delete,internal_doctors_status_change,referee_doctors_view,referee_doctors_add,referee_doctors_edit,referee_doctors_delete,referee_doctors_status_change,pet_owners_view,pet_owners_add,pet_owners_edit,pet_owners_delete,pet_owners_status_change,pet_view,pet_add,pet_edit,pet_delete,pet_status_change,test_view,test_add,test_edit,test_delete,test_status_change,revenue_view,system_users_view,user_view,user_add,user_edit,user_delete,user_status_change,role_privileges_view,role_privileges_add,role_privileges_edit,role_privileges_delete,role_privileges_status_change,settings_view,general_setting_view,general_setting_add,general_setting_edit,visual_setting_view,visual_setting_add,visual_setting_edit,change_password_view,change_password_edit,notifications_view,logout_view,sample_view,sample_add,sample_edit,sample_delete,sample_status_change', NULL, '127.0.0.1', NULL, 1, 'active', NULL, '2025-09-08 04:06:27'),
(6, 'Admin', 'dashboard_view,appointments_view,reports_view', '127.0.0.1', NULL, 1, NULL, 'active', '2025-10-14 00:02:59', '2025-10-14 00:02:59'),
(7, 'Branch Super Admin', 'dashboard_view,new_registration_view,new_registration_add,new_registration_edit,new_registration_delete,new_registration_status_change,reports_view,reports_add,reports_edit,reports_delete,reports_status_change,pet_parent_view,pet_parent_add,pet_parent_edit,pet_parent_delete,pet_parent_status_change,pets_view,pets_add,pets_edit,pets_delete,pets_status_change,referee_doctors_view,referee_doctors_add,referee_doctors_edit,referee_doctors_delete,referee_doctors_status_change,system_users_view,users_view,users_add,users_edit,users_delete,users_status_change,role_privileges_view,role_privileges_add,role_privileges_edit,role_privileges_delete,role_privileges_status_change,notifications_view,logout_view,sample_view,sample_add,sample_edit,sample_delete,sample_status_change', '127.0.0.1', NULL, NULL, NULL, 'active', '2025-10-16 10:47:37', '2025-10-16 10:47:37'),
(8, 'Receptionist', 'new_registration_view,new_registration_add,new_registration_edit,new_registration_delete,new_registration_status_change,reports_view,reports_add,reports_edit,reports_delete,reports_status_change', '127.0.0.1', '127.0.0.1', 4, 4, 'active', '2025-10-16 05:44:49', '2025-10-17 02:09:18'),
(9, 'Lab Tech', 'reports_view,reports_add,reports_edit,reports_delete,reports_status_change,notifications_view,logout_view', '127.0.0.1', '127.0.0.1', 4, 4, 'active', '2025-10-17 03:34:58', '2025-10-17 04:17:37'),
(10, 'SubAdmin', 'dashboard_view', '127.0.0.1', NULL, 1, NULL, 'active', '2025-10-29 05:12:49', '2025-10-29 05:12:49'),
(11, 'Acontant', 'dashboard_view,revenue_view', '127.0.0.1', NULL, 1, NULL, 'active', '2025-10-29 05:17:12', '2025-10-29 05:17:12');

-- --------------------------------------------------------

--
-- Table structure for table `sample_collections`
--

CREATE TABLE `sample_collections` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sample_code` varchar(255) DEFAULT NULL,
  `appointment_id` bigint(20) DEFAULT NULL,
  `sample_type` varchar(255) DEFAULT NULL,
  `collection_source_id` bigint(20) DEFAULT NULL,
  `destination_lab_id` bigint(20) DEFAULT NULL,
  `status` enum('Pending','Collected','In Transit','Received','Processing','Analyzed','Reported','Completed','Cancelled','Rejected','delete') NOT NULL DEFAULT 'Pending',
  `collection_date` date DEFAULT NULL,
  `collection_time` time DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_ip_address` varchar(255) DEFAULT NULL,
  `modified_ip_address` varchar(255) DEFAULT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  `modified_by` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sample_collections`
--

INSERT INTO `sample_collections` (`id`, `sample_code`, `appointment_id`, `sample_type`, `collection_source_id`, `destination_lab_id`, `status`, `collection_date`, `collection_time`, `notes`, `created_ip_address`, `modified_ip_address`, `created_by`, `modified_by`, `created_at`, `updated_at`) VALUES
(1, 'SC001', 47, 'Urine', 2, 1, 'delete', '2025-10-27', '10:52:00', 'This is not applicableeeeeeee', '127.0.0.1', '127.0.0.1', 1, 1, '2025-10-24 07:49:47', '2025-10-26 23:52:37'),
(2, 'SC002', 48, 'Stool', 2, 1, 'delete', '2025-10-25', '23:04:00', 'NA', '127.0.0.1', '127.0.0.1', 1, 1, '2025-10-25 12:04:23', '2025-10-25 12:04:23'),
(3, 'SC003', 2, 'Stool', 1, 1, 'delete', '2025-10-30', '13:35:00', 'NA', '127.0.0.1', '127.0.0.1', 4, 4, '2025-10-27 02:31:57', '2025-10-27 02:31:57'),
(4, 'SC004', 4, 'Stool', 1, 1, 'delete', '2025-10-27', '13:36:00', 'NA', '127.0.0.1', '127.0.0.1', 4, 1, '2025-10-27 02:37:03', '2025-10-27 02:37:03'),
(5, 'SC005', 52, 'Blood', 1, 1, 'delete', '2025-10-27', '15:00:00', 'NA', '127.0.0.1', '127.0.0.1', 4, 4, '2025-10-27 02:46:58', '2025-10-27 02:46:58'),
(6, 'SC006', 42, 'Blood', 1, 1, 'Pending', '2025-10-27', '15:53:00', 'NA', '127.0.0.1', NULL, 4, NULL, '2025-10-27 04:54:38', '2025-10-27 04:54:38'),
(7, 'SC007', 39, 'Stool', 1, 2, 'Pending', '2025-10-27', '15:54:00', 'NA', '127.0.0.1', NULL, 4, NULL, '2025-10-27 04:55:10', '2025-10-27 04:55:10'),
(8, 'SC008', 45, 'Saliva', 1, 2, 'Pending', '2025-10-27', '17:32:00', 'NA', '127.0.0.1', NULL, 4, NULL, '2025-10-27 06:33:15', '2025-10-27 06:33:15');

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
('eQwox95Yiac6O9ZhnPyOYCWnallOpag4mVa0ceZF', 7, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiOXI1OFI0OEVISmFlY0t2SnIyWUJNZWZGQ1J6S1hUUGxpM3lZemJ5bCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo0NzoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2FkbWluL3JlcG9ydHMvdmlldy9UUjAwNTQiO31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czozMzoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2Zyb250L3Rlc3RzIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo2MDoibG9naW5fbWFzdGVyX2FkbWluc181OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Nzt9', 1762260664),
('NXERAiOzA8Bfej0mg6mLlX6qaOz6l273Tj9IuHkE', 4, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'YTo3OntzOjY6Il90b2tlbiI7czo0MDoia0pUQWpmQk0yQjJpeTRUYjBVSWl0R3l4TDFFaDcwcFpIMHV3dWxCbSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjQ7czo1MzoibG9naW5fYnJhbmNoXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6NDtzOjEzOiJCcmFuY2hBZG1pbiolIjtpOjQ7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozMToiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2FkbWluLzQwNCI7fX0=', 1762253965),
('T0TjN82kZjQHwQ4JDAlR2IUj690MlV15emkX7eG5', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiclNnOVh6OEIxVURpOEhZVmd2cjF0RnNqbnJqNndtaVoyN1NtS3lHbSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9mcm9udC90ZXN0cyI7fX0=', 1762260987);

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE `states` (
  `state_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `country_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `states`
--

INSERT INTO `states` (`state_id`, `name`, `country_id`) VALUES
(1, 'Andaman and Nicobar Islands (union territory)', 1),
(2, 'Andhra Pradesh', 1),
(3, 'Arunachal Pradesh', 1),
(4, 'Assam', 1),
(5, 'Bihar', 1),
(6, 'Chandigarh (union territory)', 1),
(7, 'Chhattisgarh', 1),
(8, 'Dadra and Nagar Haveli and Daman and Diu (union territory)', 1),
(9, 'Delhi (national capital territory)', 1),
(10, 'Goa', 1),
(11, 'Gujarat', 1),
(12, 'Haryana', 1),
(13, 'Himachal Pradesh', 1),
(14, 'Jammu and Kashmir (union territory)', 1),
(15, 'Jharkhand', 1),
(16, 'Karnataka', 1),
(17, 'Kerala', 1),
(18, 'Ladakh (union territory)', 1),
(19, 'Madhya Pradesh', 1),
(20, 'Maharashtra', 1),
(21, 'Manipur', 1),
(22, 'Meghalaya', 1),
(23, 'Mizoram', 1),
(24, 'Nagaland', 1),
(25, 'Odisha', 1),
(26, 'Puducherry (union territory)', 1),
(27, 'Punjab', 1),
(28, 'Rajasthan', 1),
(29, 'Sikkim', 1),
(30, 'Tamil Nadu', 1),
(31, 'Telangana', 1),
(32, 'Tripura', 1),
(33, 'Uttar Pradesh', 1),
(34, 'Uttarakhand', 1),
(35, 'West Bengal', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tests`
--

CREATE TABLE `tests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `test_code` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `short_name` varchar(255) DEFAULT NULL,
  `department_id` bigint(20) DEFAULT NULL,
  `sample_type` varchar(255) DEFAULT NULL,
  `test_for` varchar(255) DEFAULT NULL,
  `base_price` decimal(10,2) NOT NULL,
  `gst` decimal(10,2) DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  `precautions` text DEFAULT NULL,
  `created_ip_address` varchar(255) DEFAULT NULL,
  `modified_ip_address` varchar(255) DEFAULT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  `modified_by` bigint(20) DEFAULT NULL,
  `status` enum('active','delete','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tests`
--

INSERT INTO `tests` (`id`, `test_code`, `name`, `short_name`, `department_id`, `sample_type`, `test_for`, `base_price`, `gst`, `total_price`, `precautions`, `created_ip_address`, `modified_ip_address`, `created_by`, `modified_by`, `status`, `created_at`, `updated_at`) VALUES
(1, 'TC001', 'Deepak Tripathi', 'CBC', 1, 'Blood', 'all', 600.00, 5.00, 630.00, 'Na', '127.0.0.1', '127.0.0.1', NULL, 1, 'active', '2025-09-16 00:21:22', '2025-10-28 07:33:44'),
(2, 'TC002', 'Test1', 'CBC', 2, 'Blood', 'all', 900.00, 0.00, 900.00, 'NA', '127.0.0.1', '127.0.0.1', NULL, 1, 'active', '2025-09-16 02:05:35', '2025-10-28 07:32:29'),
(3, 'TC003', 'Test2', 'CBC', 2, 'Blood', 'all', 800.00, 0.00, 800.00, 'NA', '127.0.0.1', '127.0.0.1', NULL, 1, 'active', '2025-09-16 02:06:23', '2025-10-28 07:31:58'),
(4, 'TC004', 'Test23', '23', 5, 'Blood', 'all', 200.00, 5.00, 210.00, 'NA', '127.0.0.1', '127.0.0.1', NULL, 1, 'active', '2025-09-18 00:22:42', '2025-10-28 07:31:32'),
(5, 'TC005', 'Test', 'Tst', 1, 'Blood', 'all', 800.00, 5.00, 840.00, 'NA', '127.0.0.1', '127.0.0.1', NULL, 1, 'active', '2025-09-22 04:17:06', '2025-10-28 07:31:07'),
(6, 'TC006', 'Test For Female', 'Female', 1, 'Blood', 'all', 800.00, 5.00, 840.00, 'NA', '127.0.0.1', '127.0.0.1', NULL, 1, 'active', '2025-09-22 04:19:01', '2025-10-28 07:30:43'),
(7, 'TC007', 'Test For Female 1', 'Femaile 1', 1, 'Blood', 'all', 700.00, 5.00, 735.00, 'NA', '127.0.0.1', '127.0.0.1', NULL, 1, 'active', '2025-09-22 04:23:30', '2025-10-28 07:30:13'),
(8, 'TC008', 'Test Female 3', 'Female 3', 1, 'Blood', 'all', 800.00, 5.00, 840.00, 'NA', '127.0.0.1', '127.0.0.1', NULL, 1, 'active', '2025-09-22 04:27:15', '2025-10-28 07:29:45'),
(9, 'TC009', 'test For  male', 'TFM', 1, 'Blood', 'all', 900.00, 5.00, 945.00, 'NA', '127.0.0.1', '127.0.0.1', NULL, 1, 'active', '2025-09-22 04:29:26', '2025-10-28 06:55:44'),
(10, 'TC010', 'Test1 for male', 't1M', 1, 'Plasma', 'pets', 800.00, 5.00, 840.00, 'NA', '127.0.0.1', '127.0.0.1', NULL, 1, 'active', '2025-09-22 04:38:28', '2025-10-28 06:56:30'),
(11, 'TC011', 'Deepak Tetting Test', 'CBC', 1, 'Blood', 'all', 900.00, 5.00, 945.00, 'NA', '127.0.0.1', '127.0.0.1', NULL, 1, 'active', '2025-09-22 04:42:37', '2025-10-28 06:56:50'),
(12, 'TC012', 'Options Testing Test', 'OTT', 1, 'Blood', 'all', 900.00, 0.00, 900.00, 'NA', '127.0.0.1', '127.0.0.1', NULL, 1, 'active', '2025-09-26 00:26:40', '2025-10-28 06:57:10'),
(13, 'TC013', 'Complete Blood Count', 'CBC', 1, 'Blood', 'pets', 800.00, 0.00, 800.00, 'NA', '127.0.0.1', '127.0.0.1', NULL, 1, 'active', '2025-10-10 04:40:06', '2025-10-28 06:57:39'),
(14, 'TC014', 'Tetst123', 'tetetuASas', 1, 'Serum', 'pets', 600.00, 5.00, 630.00, 'NA', '127.0.0.1', '127.0.0.1', 1, 1, 'active', '2025-10-27 09:04:26', '2025-10-28 06:58:09'),
(15, 'TC015', 'Test', 'asd', 2, 'Serum', 'pets', 100.00, 5.00, 105.00, 'NA', '127.0.0.1', '127.0.0.1', 1, 1, 'active', '2025-10-28 01:45:35', '2025-10-28 06:58:32'),
(16, 'TC016', 'Test', 'Test123', 2, 'Plasma', 'pets', 551.25, 5.00, 578.81, 'NA', '127.0.0.1', '127.0.0.1', 1, 1, 'active', '2025-10-28 06:21:43', '2025-10-28 06:55:13'),
(17, 'TC017', 'Test', 'Test123', 3, 'Plasma', 'pets', 551.25, 5.00, 578.81, 'NA', '127.0.0.1', '127.0.0.1', 1, 1, 'active', '2025-10-28 06:28:43', '2025-10-28 06:59:04'),
(18, 'TC018', 'asdasd', 'asadas', 7, 'Plasma', 'pets', 500.00, 10.00, 550.00, 'NA', '127.0.0.1', '127.0.0.1', 1, 1, 'active', '2025-10-28 06:50:40', '2025-10-28 06:54:48');

-- --------------------------------------------------------

--
-- Table structure for table `test_parameters`
--

CREATE TABLE `test_parameters` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `test_id` bigint(20) DEFAULT NULL,
  `row_type` enum('component','title') NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `unit` varchar(255) DEFAULT NULL,
  `result_type` enum('text','select') NOT NULL DEFAULT 'text',
  `reference_range` text DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_ip_address` varchar(255) DEFAULT NULL,
  `modified_ip_address` varchar(255) DEFAULT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  `modified_by` bigint(20) DEFAULT NULL,
  `status` enum('active','delete','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `test_parameters`
--

INSERT INTO `test_parameters` (`id`, `test_id`, `row_type`, `name`, `title`, `unit`, `result_type`, `reference_range`, `sort_order`, `created_ip_address`, `modified_ip_address`, `created_by`, `modified_by`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'title', NULL, 'Hemoglobin', NULL, 'text', NULL, 0, '127.0.0.1', '127.0.0.1', 1, 1, 'active', '2025-09-16 00:21:22', '2025-10-28 07:33:44'),
(2, 1, 'component', 'wwwere', NULL, 'g/dl', 'text', '13.0-17.0', 1, '127.0.0.1', '127.0.0.1', 1, 1, 'active', '2025-09-16 00:21:22', '2025-10-28 07:33:44'),
(3, 2, 'title', NULL, 'Hemoglobin', NULL, 'text', NULL, 0, '127.0.0.1', '127.0.0.1', 1, 1, 'active', '2025-09-16 02:05:35', '2025-10-28 07:32:29'),
(4, 2, 'component', 'wwwere', NULL, 'g/dl', 'text', '13.0-17.0', 1, '127.0.0.1', '127.0.0.1', 1, 1, 'active', '2025-09-16 02:05:35', '2025-10-28 07:32:29'),
(5, 2, 'title', NULL, 'RBC Count', NULL, 'text', NULL, 2, '127.0.0.1', '127.0.0.1', 1, 1, 'active', '2025-09-16 02:05:35', '2025-10-28 07:32:29'),
(6, 2, 'component', 'ASDasd', NULL, 'mill/cumm', 'text', '4.5-5.5', 3, '127.0.0.1', '127.0.0.1', 1, 1, 'active', '2025-09-16 02:05:35', '2025-10-28 07:32:29'),
(7, 3, 'title', NULL, 'Hemoglobin', NULL, 'text', NULL, 0, '127.0.0.1', '127.0.0.1', 1, 1, 'active', '2025-09-16 02:06:23', '2025-10-28 07:33:17'),
(8, 3, 'component', 'Volume', NULL, 'g/dl', 'text', '13.0-17.0', 1, '127.0.0.1', '127.0.0.1', 1, 1, 'active', '2025-09-16 02:06:23', '2025-10-28 07:33:17'),
(9, 3, 'title', NULL, 'aewasdasd', NULL, 'text', NULL, 2, '127.0.0.1', '127.0.0.1', 1, 1, 'active', '2025-09-16 02:06:23', '2025-10-28 07:33:17'),
(10, 3, 'component', 'zxczx', NULL, 'mill/cumm', 'text', '4.5-5.5', 3, '127.0.0.1', '127.0.0.1', 1, 1, 'active', '2025-09-16 02:06:23', '2025-10-28 07:33:17'),
(11, 4, 'title', NULL, 'Hemoglobin', NULL, 'text', NULL, 0, '127.0.0.1', '127.0.0.1', 1, 1, 'active', '2025-09-18 00:22:42', '2025-10-28 07:31:32'),
(12, 4, 'component', 'wwwere', NULL, 'g/dl', 'select', '13.0-17.0', 1, '127.0.0.1', '127.0.0.1', 1, 1, 'active', '2025-09-18 00:22:42', '2025-10-28 07:31:32'),
(13, 5, 'title', NULL, 'Hemoglobin', NULL, 'text', NULL, 0, '127.0.0.1', '127.0.0.1', 1, 1, 'active', '2025-09-22 04:17:06', '2025-10-28 07:31:07'),
(14, 5, 'component', 'wwwere', NULL, 'g/dl', 'text', '13.0-17.0', 1, '127.0.0.1', '127.0.0.1', 1, 1, 'active', '2025-09-22 04:17:06', '2025-10-28 07:31:07'),
(15, 5, 'title', NULL, 'aewasdasd', NULL, 'text', NULL, 2, '127.0.0.1', '127.0.0.1', 1, 1, 'active', '2025-09-22 04:17:06', '2025-10-28 07:31:07'),
(16, 5, 'component', 'ASDasd', NULL, 'mill/cumm', 'select', '4.5-5.5', 3, '127.0.0.1', '127.0.0.1', 1, 1, 'active', '2025-09-22 04:17:06', '2025-10-28 07:31:07'),
(17, 6, 'title', NULL, 'Hemoglobin', NULL, 'text', NULL, 0, '127.0.0.1', '127.0.0.1', 1, 1, 'active', '2025-09-22 04:19:01', '2025-10-28 07:30:43'),
(18, 6, 'component', 'wwwere', NULL, 'g/dl', 'text', '13.0-17.0', 1, '127.0.0.1', '127.0.0.1', 1, 1, 'active', '2025-09-22 04:19:01', '2025-10-28 07:30:43'),
(19, 6, 'title', NULL, 'aewasdasd', NULL, 'text', NULL, 2, '127.0.0.1', '127.0.0.1', 1, 1, 'active', '2025-09-22 04:19:01', '2025-10-28 07:30:43'),
(20, 6, 'component', 'zxczx', NULL, 'mill/cumm', 'select', '4.5-5.5', 3, '127.0.0.1', '127.0.0.1', 1, 1, 'active', '2025-09-22 04:19:01', '2025-10-28 07:30:43'),
(21, 7, 'title', NULL, 'Hemoglobin', NULL, 'text', NULL, 0, '127.0.0.1', '127.0.0.1', 1, 1, 'active', '2025-09-22 04:23:30', '2025-10-28 07:30:13'),
(22, 7, 'component', 'dsfds', NULL, 'g/dl', 'text', '13.0-17.0', 1, '127.0.0.1', '127.0.0.1', 1, 1, 'active', '2025-09-22 04:23:30', '2025-10-28 07:30:13'),
(23, 7, 'title', NULL, 'aewasdasd', NULL, 'text', NULL, 2, '127.0.0.1', '127.0.0.1', 1, 1, 'active', '2025-09-22 04:23:30', '2025-10-28 07:30:13'),
(24, 7, 'component', 'ASDasd', NULL, 'mill/cumm', 'select', '4.5-5.5', 3, '127.0.0.1', '127.0.0.1', 1, 1, 'active', '2025-09-22 04:23:30', '2025-10-28 07:30:13'),
(25, 8, 'title', NULL, 'Hemoglobin', NULL, 'text', NULL, 0, '127.0.0.1', '127.0.0.1', 1, 1, 'active', '2025-09-22 04:27:15', '2025-10-28 07:29:45'),
(26, 8, 'component', 'Volume', NULL, 'g/dl', 'text', '13.0-17.0', 1, '127.0.0.1', '127.0.0.1', 1, 1, 'active', '2025-09-22 04:27:15', '2025-10-28 07:29:45'),
(27, 8, 'title', NULL, 'aewasdasd', NULL, 'text', NULL, 2, '127.0.0.1', '127.0.0.1', 1, 1, 'active', '2025-09-22 04:27:15', '2025-10-28 07:29:45'),
(28, 8, 'component', 'ASDasd', NULL, 'mill/cumm', 'text', '4.5-5.5', 3, '127.0.0.1', '127.0.0.1', 1, 1, 'active', '2025-09-22 04:27:15', '2025-10-28 07:29:45'),
(29, 9, 'title', NULL, 'Hemoglobin', NULL, 'text', NULL, 0, '127.0.0.1', '127.0.0.1', 1, 1, 'active', '2025-09-22 04:29:26', '2025-10-28 06:55:44'),
(30, 9, 'component', 'Volume', NULL, 'g/dl', 'text', '13.0-17.0', 1, '127.0.0.1', '127.0.0.1', 1, 1, 'active', '2025-09-22 04:29:26', '2025-10-28 06:55:44'),
(31, 9, 'title', NULL, 'aewasdasd', NULL, 'text', NULL, 2, '127.0.0.1', '127.0.0.1', 1, 1, 'active', '2025-09-22 04:29:26', '2025-10-28 06:55:44'),
(32, 9, 'component', 'ASDasd', NULL, 'mill/cumm', 'select', '4.5-5.5', 3, '127.0.0.1', '127.0.0.1', 1, 1, 'active', '2025-09-22 04:29:26', '2025-10-28 06:55:45'),
(33, 10, 'title', NULL, 'Hemoglobin', NULL, 'text', NULL, 0, '127.0.0.1', '127.0.0.1', 1, 1, 'active', '2025-09-22 04:38:28', '2025-10-28 06:56:30'),
(34, 10, 'component', 'Volume', NULL, 'g/dl', 'text', '13.0-17.0', 1, '127.0.0.1', '127.0.0.1', 1, 1, 'active', '2025-09-22 04:38:28', '2025-10-28 06:56:30'),
(35, 10, 'title', NULL, 'RBC Count', NULL, 'text', NULL, 2, '127.0.0.1', '127.0.0.1', 1, 1, 'active', '2025-09-22 04:38:28', '2025-10-28 06:56:30'),
(36, 10, 'component', 'ASDasd', NULL, 'mill/cumm', 'select', '4.5-5.5', 3, '127.0.0.1', '127.0.0.1', 1, 1, 'active', '2025-09-22 04:38:28', '2025-10-28 06:56:30'),
(37, 11, 'title', NULL, 'Hemoglobin', NULL, 'text', NULL, 0, '127.0.0.1', '127.0.0.1', 1, 1, 'active', '2025-09-22 04:42:38', '2025-10-28 06:56:50'),
(38, 11, 'component', 'dsfds', NULL, 'g/dl', 'text', '13.0-17.0', 1, '127.0.0.1', '127.0.0.1', 1, 1, 'active', '2025-09-22 04:42:38', '2025-10-28 06:56:50'),
(39, 11, 'title', NULL, 'RBC Count', NULL, 'text', NULL, 2, '127.0.0.1', '127.0.0.1', 1, 1, 'active', '2025-09-22 04:42:38', '2025-10-28 06:56:50'),
(40, 11, 'component', 'ASDasd', NULL, 'mill/cumm', 'text', '4.5-5.5', 3, '127.0.0.1', '127.0.0.1', 1, 1, 'active', '2025-09-22 04:42:38', '2025-10-28 06:56:50'),
(41, 12, 'title', NULL, 'Hemoglobin', NULL, 'text', NULL, 0, '127.0.0.1', '127.0.0.1', 1, 1, 'active', '2025-09-26 00:26:40', '2025-10-28 06:57:10'),
(42, 12, 'component', 'Uric Acid', NULL, 'ml', 'select', '13.0-17.0', 1, '127.0.0.1', '127.0.0.1', 1, 1, 'active', '2025-09-26 00:26:40', '2025-10-28 06:57:10'),
(43, 13, 'component', 'Hemoglobin', NULL, 'g/dL', 'text', '9.5 - 15', 0, '127.0.0.1', '127.0.0.1', 1, 1, 'active', '2025-10-10 04:40:06', '2025-10-28 06:57:39'),
(44, 13, 'component', 'Total RBC', NULL, 'x 10^12 /L', 'text', '6 -10', 1, '127.0.0.1', '127.0.0.1', 1, 1, 'active', '2025-10-10 04:40:06', '2025-10-28 06:57:39'),
(45, 13, 'component', 'PCV (HCT)', NULL, '%', 'text', '29 - 45', 2, '127.0.0.1', '127.0.0.1', 1, 1, 'active', '2025-10-10 04:40:06', '2025-10-28 06:57:39'),
(46, 13, 'component', 'RDWc', NULL, '%', 'text', NULL, 3, '127.0.0.1', '127.0.0.1', 1, 1, 'active', '2025-10-10 04:40:06', '2025-10-28 06:57:39'),
(47, 13, 'title', NULL, 'RBC Indices', NULL, 'text', NULL, 4, '127.0.0.1', '127.0.0.1', 1, 1, 'active', '2025-10-10 04:40:06', '2025-10-28 06:57:39'),
(48, 13, 'component', 'MCV', NULL, 'fl', 'text', '41 – 54', 5, '127.0.0.1', '127.0.0.1', 1, 1, 'active', '2025-10-10 04:40:06', '2025-10-28 06:57:39'),
(49, 13, 'component', 'MCH', NULL, 'pg', 'text', '13.3 – 17.5', 6, '127.0.0.1', '127.0.0.1', 1, 1, 'active', '2025-10-10 04:40:06', '2025-10-28 06:57:39'),
(50, 13, 'component', 'MCHC', NULL, 'g/dL', 'text', '31 – 36', 7, '127.0.0.1', '127.0.0.1', 1, 1, 'active', '2025-10-10 04:40:06', '2025-10-28 06:57:39'),
(51, 13, 'component', 'Total WBC', NULL, 'x 10^3 / µl', 'text', '5.5 – 19.5', 8, '127.0.0.1', '127.0.0.1', 1, 1, 'active', '2025-10-10 04:40:06', '2025-10-28 06:57:39'),
(52, 13, 'title', NULL, 'Differential Leukocyte Count', NULL, 'text', NULL, 9, '127.0.0.1', '127.0.0.1', 1, 1, 'active', '2025-10-10 04:40:06', '2025-10-28 06:57:39'),
(53, 13, 'component', 'Neutrophils', NULL, '%', 'text', '35-75', 10, '127.0.0.1', '127.0.0.1', 1, 1, 'active', '2025-10-10 04:40:06', '2025-10-28 06:57:39'),
(54, 13, 'component', 'Eosinophils', NULL, '%', 'text', '2 - 12', 11, '127.0.0.1', '127.0.0.1', 1, 1, 'active', '2025-10-10 04:40:06', '2025-10-28 06:57:39'),
(55, 13, 'component', 'Lymphocyte', NULL, '%', 'text', '20 – 55', 12, '127.0.0.1', '127.0.0.1', 1, 1, 'active', '2025-10-10 04:40:06', '2025-10-28 06:57:39'),
(56, 13, 'component', 'Monocytes', NULL, '%', 'text', '01 - 04', 13, '127.0.0.1', '127.0.0.1', 1, 1, 'active', '2025-10-10 04:40:06', '2025-10-28 06:57:39'),
(57, 13, 'component', 'Basophils', NULL, '%', 'text', '0.0 - 0.0', 14, '127.0.0.1', '127.0.0.1', 1, 1, 'active', '2025-10-10 04:40:06', '2025-10-28 06:57:39'),
(58, 13, 'title', NULL, 'Peripheral Blood Smear', NULL, 'text', NULL, 15, '127.0.0.1', '127.0.0.1', 1, 1, 'active', '2025-10-10 04:40:06', '2025-10-28 06:57:39'),
(59, 13, 'component', 'Platelets', NULL, '/ µl', 'text', '300000 – 800000', 16, '127.0.0.1', '127.0.0.1', 1, 1, 'active', '2025-10-10 04:40:06', '2025-10-28 06:57:39'),
(60, 13, 'component', 'PDW', NULL, '%', 'text', NULL, 17, '127.0.0.1', '127.0.0.1', 1, 1, 'active', '2025-10-10 04:40:06', '2025-10-28 06:57:39'),
(61, 13, 'component', 'MPV', NULL, 'fl', 'text', '-', 18, '127.0.0.1', '127.0.0.1', 1, 1, 'active', '2025-10-10 04:40:06', '2025-10-28 06:57:39'),
(62, 13, 'component', 'Platelets on Smear', NULL, NULL, 'text', NULL, 19, '127.0.0.1', '127.0.0.1', 1, 1, 'active', '2025-10-10 04:40:06', '2025-10-28 06:57:39'),
(63, 13, 'component', 'RBC Morphology', NULL, NULL, 'text', NULL, 20, '127.0.0.1', '127.0.0.1', 1, 1, 'active', '2025-10-10 04:40:06', '2025-10-28 06:57:39'),
(64, 13, 'component', 'Blood Parasite', NULL, NULL, 'text', NULL, 21, '127.0.0.1', '127.0.0.1', 1, 1, 'active', '2025-10-10 04:40:06', '2025-10-28 06:57:39'),
(65, 13, 'component', 'Method', NULL, NULL, 'text', NULL, 22, '127.0.0.1', '127.0.0.1', 1, 1, 'active', '2025-10-10 04:40:06', '2025-10-28 06:57:39'),
(66, 14, 'component', 'Hello This is  test', NULL, 'g/dl', 'text', '13.0-17.0', 0, '127.0.0.1', '127.0.0.1', 1, 1, 'active', '2025-10-27 09:04:26', '2025-10-28 06:58:09'),
(67, 14, 'component', 'Total RBC', NULL, 'mg/dl', 'text', '6 -10', 1, '127.0.0.1', '127.0.0.1', 1, 1, 'active', '2025-10-27 09:04:26', '2025-10-28 06:58:09'),
(68, 15, 'component', 'sadas', NULL, 'g/dl', 'text', '13.0-17.0', 0, '127.0.0.1', '127.0.0.1', 1, 1, 'active', '2025-10-28 01:45:35', '2025-10-28 06:58:32'),
(69, 16, 'title', NULL, 'Hemoglobin', NULL, 'text', NULL, 0, '127.0.0.1', '127.0.0.1', 1, 1, 'active', '2025-10-28 06:21:43', '2025-10-28 06:55:13'),
(70, 16, 'component', 'Hemoglobin', NULL, 'mg/dl', 'text', '9.5 - 15', 1, '127.0.0.1', '127.0.0.1', 1, 1, 'active', '2025-10-28 06:21:43', '2025-10-28 06:55:13'),
(71, 17, 'title', NULL, 'asdsa', NULL, 'text', NULL, 0, '127.0.0.1', '127.0.0.1', 1, 1, 'active', '2025-10-28 06:28:43', '2025-10-28 06:59:04'),
(72, 17, 'component', 'Volume', NULL, 'g/dL', 'text', '9.5 - 15', 1, '127.0.0.1', '127.0.0.1', 1, 1, 'active', '2025-10-28 06:28:43', '2025-10-28 06:59:04'),
(73, 18, 'title', NULL, 'Hemoglobin', NULL, 'text', NULL, 0, '127.0.0.1', '127.0.0.1', 1, 1, 'active', '2025-10-28 06:50:40', '2025-10-28 06:54:48'),
(74, 18, 'component', 'Component', NULL, 'g/dL', 'text', '6 -10', 1, '127.0.0.1', '127.0.0.1', 1, 1, 'active', '2025-10-28 06:50:40', '2025-10-28 06:54:48');

-- --------------------------------------------------------

--
-- Table structure for table `test_profiles`
--

CREATE TABLE `test_profiles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `profile_code` varchar(255) DEFAULT NULL,
  `profile_price` decimal(10,2) NOT NULL,
  `profile_description` text DEFAULT NULL,
  `created_ip_address` varchar(255) DEFAULT NULL,
  `modified_ip_address` varchar(255) DEFAULT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  `modified_by` bigint(20) DEFAULT NULL,
  `status` enum('active','delete','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `test_profiles`
--

INSERT INTO `test_profiles` (`id`, `name`, `profile_code`, `profile_price`, `profile_description`, `created_ip_address`, `modified_ip_address`, `created_by`, `modified_by`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Testing Profile', NULL, 1100.00, NULL, '127.0.0.1', '127.0.0.1', NULL, 1, 'active', '2025-09-26 07:10:46', '2025-09-26 07:10:46'),
(2, 'Deepak', NULL, 900.00, NULL, '127.0.0.1', '127.0.0.1', NULL, NULL, 'active', '2025-09-28 23:53:50', '2025-09-29 01:01:52'),
(3, 'Profile Testing Name', 'Test', 900.00, 'This description', '127.0.0.1', NULL, NULL, NULL, 'active', '2025-09-29 02:06:48', '2025-09-29 02:06:48'),
(4, 'Testing Profile', 'Code 1', 100.00, 'This is For testing only', '127.0.0.1', NULL, NULL, NULL, 'active', '2025-10-11 00:34:17', '2025-10-11 00:34:17'),
(5, 'Test Profile for amount testing', 'Test', 2500.00, 'This is For testing only', '127.0.0.1', NULL, NULL, NULL, 'active', '2025-10-11 02:04:13', '2025-10-11 02:04:13');

-- --------------------------------------------------------

--
-- Table structure for table `test_profile_tests`
--

CREATE TABLE `test_profile_tests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `test_profile_id` bigint(20) NOT NULL,
  `test_id` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `test_profile_tests`
--

INSERT INTO `test_profile_tests` (`id`, `test_profile_id`, `test_id`, `created_at`, `updated_at`) VALUES
(1, 1, 2, '2025-09-26 07:10:46', '2025-09-26 07:10:46'),
(2, 1, 4, '2025-09-26 07:10:46', '2025-09-26 07:10:46'),
(5, 2, 2, '2025-09-29 01:01:52', '2025-09-29 01:01:52'),
(6, 3, 2, '2025-09-29 02:06:48', '2025-09-29 02:06:48'),
(7, 4, 2, '2025-10-11 00:34:17', '2025-10-11 00:34:17'),
(8, 4, 4, '2025-10-11 00:34:17', '2025-10-11 00:34:17'),
(9, 5, 2, '2025-10-11 02:04:13', '2025-10-11 02:04:13'),
(10, 5, 4, '2025-10-11 02:04:13', '2025-10-11 02:04:13'),
(11, 5, 5, '2025-10-11 02:04:13', '2025-10-11 02:04:13'),
(12, 5, 6, '2025-10-11 02:04:13', '2025-10-11 02:04:13');

-- --------------------------------------------------------

--
-- Table structure for table `test_results`
--

CREATE TABLE `test_results` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `test_result_code` varchar(255) DEFAULT NULL,
  `appointment_id` bigint(20) DEFAULT NULL,
  `test_id` bigint(20) DEFAULT NULL,
  `priority` enum('Low','Medium','High') NOT NULL DEFAULT 'Medium',
  `status` enum('pending','completed','approved','rejected') NOT NULL DEFAULT 'pending',
  `doctor_approval_status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `doctor_approved_at` timestamp NULL DEFAULT NULL,
  `doctor_rejection_comment` text DEFAULT NULL,
  `admin_approved` tinyint(1) NOT NULL DEFAULT 0,
  `rejection_reason` text DEFAULT NULL,
  `admin_approved_at` timestamp NULL DEFAULT NULL,
  `admin_approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `signed_by_id` bigint(20) UNSIGNED DEFAULT NULL,
  `assigned_to_doctor_id` bigint(20) DEFAULT NULL,
  `assigned_at` timestamp NULL DEFAULT NULL,
  `assigned_by` bigint(20) DEFAULT NULL,
  `signed_date` datetime DEFAULT NULL,
  `done` enum('yes','no') NOT NULL DEFAULT 'no',
  `created_ip_address` varchar(255) DEFAULT NULL,
  `modified_ip_address` varchar(255) DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `modified_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `test_results`
--

INSERT INTO `test_results` (`id`, `test_result_code`, `appointment_id`, `test_id`, `priority`, `status`, `doctor_approval_status`, `doctor_approved_at`, `doctor_rejection_comment`, `admin_approved`, `rejection_reason`, `admin_approved_at`, `admin_approved_by`, `comment`, `signed_by_id`, `assigned_to_doctor_id`, `assigned_at`, `assigned_by`, `signed_date`, `done`, `created_ip_address`, `modified_ip_address`, `created_by`, `modified_by`, `created_at`, `updated_at`) VALUES
(1, 'TR0008', 8, 2, 'Medium', 'pending', 'pending', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, '2025-09-22 05:31:58', '2025-09-22 05:31:58'),
(2, 'TR0009', 9, 2, 'Medium', 'pending', 'pending', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, '2025-09-22 06:39:24', '2025-09-22 06:39:24'),
(3, 'TR0010', 10, 2, 'Medium', 'pending', 'pending', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, '2025-09-22 23:58:30', '2025-09-22 23:58:30'),
(4, 'TR0010', 10, 3, 'Medium', 'pending', 'pending', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, '2025-09-22 23:58:30', '2025-09-22 23:58:30'),
(5, 'TR0010', 10, 5, 'Medium', 'pending', 'pending', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, '2025-09-22 23:58:30', '2025-09-22 23:58:30'),
(6, 'TR0011', 11, 2, 'Medium', 'completed', 'pending', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'yes', NULL, '127.0.0.1', NULL, NULL, '2025-09-23 05:59:58', '2025-09-23 06:32:18'),
(7, 'TR0011', 11, 3, 'Medium', 'pending', 'pending', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, '2025-09-23 05:59:58', '2025-09-23 05:59:58'),
(8, 'TR0011', 11, 4, 'Medium', 'pending', 'pending', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, '2025-09-23 05:59:58', '2025-09-23 05:59:58'),
(9, 'TR0011', 11, 5, 'Medium', 'pending', 'pending', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, '2025-09-23 05:59:58', '2025-09-23 05:59:58'),
(10, 'TR0011', 11, 6, 'Medium', 'pending', 'pending', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, '2025-09-23 05:59:58', '2025-09-23 05:59:58'),
(11, 'TR0011', 11, 10, 'Medium', 'pending', 'pending', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, '2025-09-23 05:59:58', '2025-09-23 05:59:58'),
(12, 'TR0012', 12, 2, 'Medium', 'pending', 'pending', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, '2025-09-24 01:56:30', '2025-09-24 01:56:30'),
(13, 'TR0012', 12, 3, 'Medium', 'pending', 'pending', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, '2025-09-24 01:56:30', '2025-09-24 01:56:30'),
(14, 'TR0013', 13, 2, 'Medium', 'pending', 'pending', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, '2025-09-24 02:04:26', '2025-09-24 02:04:26'),
(15, 'TR0013', 13, 3, 'Medium', 'pending', 'pending', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, '2025-09-24 02:04:26', '2025-09-24 02:04:26'),
(16, 'TR0014', 14, 2, 'Medium', 'pending', 'pending', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, '2025-09-24 02:11:04', '2025-09-24 02:11:04'),
(17, 'TR0014', 14, 3, 'Medium', 'pending', 'pending', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, '2025-09-24 02:11:04', '2025-09-24 02:11:04'),
(18, 'TR0015', 15, 2, 'Medium', 'pending', 'pending', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, '2025-09-24 02:11:43', '2025-09-24 02:11:43'),
(19, 'TR0015', 15, 3, 'Medium', 'pending', 'pending', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, '2025-09-24 02:11:43', '2025-09-24 02:11:43'),
(20, 'TR0016', 16, 2, 'Medium', 'pending', 'pending', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 9, '2025-11-03 00:03:59', 1, NULL, 'no', NULL, NULL, NULL, NULL, '2025-09-24 02:12:18', '2025-11-03 00:03:59'),
(21, 'TR0016', 16, 3, 'Medium', 'pending', 'pending', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 9, '2025-11-03 00:03:59', 1, NULL, 'no', NULL, NULL, NULL, NULL, '2025-09-24 02:12:18', '2025-11-03 00:03:59'),
(22, 'TR0017', 17, 2, 'Medium', 'completed', 'pending', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'yes', NULL, '127.0.0.1', NULL, NULL, '2025-09-24 02:13:44', '2025-09-24 04:03:39'),
(23, 'TR0017', 17, 3, 'Medium', 'completed', 'pending', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'yes', NULL, '127.0.0.1', NULL, NULL, '2025-09-24 02:13:44', '2025-09-24 04:05:40'),
(24, 'TR0018', 18, 2, 'Medium', 'pending', 'pending', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, '2025-09-24 02:22:45', '2025-09-24 02:22:45'),
(25, 'TR0018', 18, 3, 'Medium', 'pending', 'pending', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, '2025-09-24 02:22:45', '2025-09-24 02:22:45'),
(26, 'TR0019', 19, 2, 'Medium', 'pending', 'pending', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, '2025-09-24 03:30:09', '2025-09-24 03:30:09'),
(27, 'TR0019', 19, 3, 'Medium', 'pending', 'pending', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, '2025-09-24 03:30:09', '2025-09-24 03:30:09'),
(28, 'TR0020', 20, 2, 'Medium', 'pending', 'pending', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, '2025-09-24 03:34:22', '2025-09-24 03:34:22'),
(29, 'TR0020', 20, 3, 'Medium', 'pending', 'pending', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, '2025-09-24 03:34:22', '2025-09-24 03:34:22'),
(30, 'TR0021', 21, 2, 'Medium', 'pending', 'pending', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, '2025-09-24 03:35:50', '2025-09-24 03:35:50'),
(31, 'TR0021', 21, 3, 'Medium', 'pending', 'pending', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, '2025-09-24 03:35:50', '2025-09-24 03:35:50'),
(32, 'TR0022', 22, 2, 'Medium', 'pending', 'pending', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, '2025-09-24 03:36:53', '2025-09-24 03:36:53'),
(33, 'TR0022', 22, 3, 'Medium', 'pending', 'pending', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, '2025-09-24 03:36:53', '2025-09-24 03:36:53'),
(34, 'TR0023', 23, 2, 'Medium', 'pending', 'pending', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, '2025-09-24 03:37:17', '2025-09-24 03:37:17'),
(35, 'TR0023', 23, 3, 'Medium', 'pending', 'pending', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, '2025-09-24 03:37:18', '2025-09-24 03:37:18'),
(36, 'TR0024', 24, 2, 'Medium', 'pending', 'pending', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, '2025-09-25 23:51:12', '2025-09-25 23:51:12'),
(37, 'TR0025', 25, 12, 'Medium', 'pending', 'pending', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, '2025-09-26 00:27:25', '2025-09-26 00:27:25'),
(38, 'TR0026', 26, 2, 'Medium', 'pending', 'pending', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, '2025-09-26 00:39:49', '2025-09-26 00:39:49'),
(39, 'TR0027', 27, 2, 'Medium', 'pending', 'pending', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, '2025-09-26 00:47:02', '2025-09-26 00:47:02'),
(40, 'TR0028', 28, 2, 'Medium', 'pending', 'pending', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, '2025-09-26 00:47:54', '2025-09-26 00:47:54'),
(41, 'TR0029', 29, 2, 'Medium', 'pending', 'pending', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, '2025-09-26 00:48:45', '2025-09-26 00:48:45'),
(42, 'TR0030', 30, 2, 'Medium', 'pending', 'pending', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, '2025-09-26 00:51:02', '2025-09-26 00:51:02'),
(43, 'TR0031', 31, 2, 'Medium', 'pending', 'pending', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, '2025-09-26 01:51:57', '2025-09-26 01:51:57'),
(44, 'TR0032', 32, 2, 'Medium', 'pending', 'pending', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, '2025-09-26 01:53:24', '2025-09-26 01:53:24'),
(45, 'TR0033', 33, 2, 'Medium', 'pending', 'pending', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, '2025-09-30 05:09:19', '2025-09-30 05:09:19'),
(46, 'TR0033', 33, 3, 'Medium', 'pending', 'pending', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, '2025-09-30 05:09:19', '2025-09-30 05:09:19'),
(47, 'TR0034', 34, 2, 'Medium', 'completed', 'pending', NULL, NULL, 0, NULL, NULL, NULL, 'NA', NULL, NULL, NULL, NULL, NULL, 'yes', NULL, '127.0.0.1', NULL, NULL, '2025-10-06 04:44:49', '2025-10-08 01:24:57'),
(48, 'TR0034', 34, 10, 'Medium', 'pending', 'pending', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, '2025-10-06 04:44:49', '2025-10-06 04:44:49'),
(49, 'TR0035', 35, 2, 'Medium', 'pending', 'pending', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, '2025-10-06 04:47:41', '2025-10-06 04:47:41'),
(50, 'TR0035', 35, 3, 'Medium', 'pending', 'pending', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, '2025-10-06 04:47:41', '2025-10-06 04:47:41'),
(51, 'TR0035', 35, 5, 'Medium', 'pending', 'pending', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, '2025-10-06 04:47:41', '2025-10-06 04:47:41'),
(52, 'TR0036', 36, 2, 'Medium', 'pending', 'pending', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, '2025-10-06 04:56:44', '2025-10-06 04:56:44'),
(53, 'TR0036', 36, 3, 'Medium', 'pending', 'pending', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, '2025-10-06 04:56:44', '2025-10-06 04:56:44'),
(54, 'TR0036', 36, 4, 'Medium', 'pending', 'pending', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, '2025-10-06 04:56:44', '2025-10-06 04:56:44'),
(55, 'TR0037', 37, 2, 'Medium', 'pending', 'pending', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, '2025-10-06 05:15:23', '2025-10-06 05:15:23'),
(56, 'TR0037', 37, 3, 'Medium', 'pending', 'pending', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, '2025-10-06 05:15:23', '2025-10-06 05:15:23'),
(57, 'TR0037', 37, 4, 'Medium', 'pending', 'pending', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, '2025-10-06 05:15:23', '2025-10-06 05:15:23'),
(58, 'TR0038', 38, 2, 'Medium', 'pending', 'approved', '2025-10-30 05:31:31', 'This report is not correct', 0, NULL, NULL, NULL, NULL, NULL, 5, '2025-10-29 01:50:52', 4, NULL, 'no', NULL, NULL, NULL, NULL, '2025-10-09 04:09:05', '2025-10-30 05:31:31'),
(59, 'TR0038', 38, 4, 'Medium', 'pending', 'approved', '2025-10-30 05:31:31', 'This report is not correct', 0, NULL, NULL, NULL, NULL, NULL, 5, '2025-10-29 01:50:53', 4, NULL, 'no', NULL, NULL, NULL, NULL, '2025-10-09 04:09:05', '2025-10-30 05:31:31'),
(60, 'TR0039', 39, 13, 'Medium', 'completed', 'pending', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'yes', NULL, '127.0.0.1', NULL, NULL, '2025-10-10 04:42:20', '2025-10-10 04:47:56'),
(61, 'TR0040', 40, 3, 'Medium', 'pending', 'approved', '2025-11-04 05:24:54', NULL, 0, NULL, NULL, NULL, NULL, NULL, 5, '2025-11-04 05:23:48', 4, NULL, 'no', NULL, NULL, NULL, NULL, '2025-10-11 00:08:08', '2025-11-04 05:24:54'),
(62, 'TR0040', 40, 2, 'Medium', 'pending', 'approved', '2025-11-04 05:24:54', NULL, 0, NULL, NULL, NULL, NULL, NULL, 5, '2025-11-04 05:23:48', 4, NULL, 'no', NULL, NULL, NULL, NULL, '2025-10-11 00:08:08', '2025-11-04 05:24:54'),
(63, 'TR0041', 41, 4, 'Medium', 'pending', 'pending', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, '2025-10-11 00:09:57', '2025-10-11 00:09:57'),
(64, 'TR0041', 41, 5, 'Medium', 'pending', 'pending', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, '2025-10-11 00:09:57', '2025-10-11 00:09:57'),
(65, 'TR0042', 42, 2, 'Medium', 'pending', 'pending', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, '2025-10-11 02:19:22', '2025-10-11 02:19:22'),
(66, 'TR0042', 42, 4, 'Medium', 'pending', 'pending', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, '2025-10-11 02:19:22', '2025-10-11 02:19:22'),
(67, 'TR0042', 42, 5, 'Medium', 'pending', 'pending', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, '2025-10-11 02:19:22', '2025-10-11 02:19:22'),
(68, 'TR0042', 42, 6, 'Medium', 'pending', 'pending', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, '2025-10-11 02:19:22', '2025-10-11 02:19:22'),
(69, 'TR0043', 43, 2, 'Medium', 'pending', 'pending', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, '2025-10-13 07:22:30', '2025-10-13 07:22:30'),
(70, 'TR0044', 44, 2, 'Medium', 'pending', 'pending', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, '2025-10-13 23:44:55', '2025-10-13 23:44:55'),
(71, 'TR0044', 44, 4, 'Medium', 'pending', 'pending', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, '2025-10-13 23:44:55', '2025-10-13 23:44:55'),
(72, 'TR0045', 45, 4, 'Medium', 'pending', 'pending', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, '2025-10-15 00:54:06', '2025-10-15 00:54:06'),
(73, 'TR0046', 46, 4, 'Medium', 'pending', 'pending', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, '2025-10-15 01:03:42', '2025-10-15 01:03:42'),
(74, 'TR0047', 47, 2, 'Medium', 'completed', 'pending', NULL, NULL, 0, NULL, NULL, NULL, 'No Comments', NULL, NULL, NULL, NULL, NULL, 'yes', NULL, '127.0.0.1', NULL, 6, '2025-10-15 01:20:30', '2025-10-15 01:42:44'),
(75, 'TR0047', 47, 4, 'Medium', 'completed', 'pending', NULL, NULL, 0, NULL, NULL, NULL, 'Yes comments', NULL, NULL, NULL, NULL, NULL, 'yes', NULL, '127.0.0.1', NULL, 6, '2025-10-15 01:20:30', '2025-10-15 01:42:59'),
(76, 'TR0048', 48, 2, 'Medium', 'pending', 'pending', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, '2025-10-15 03:28:24', '2025-10-15 03:28:24'),
(77, 'TR0048', 48, 4, 'Medium', 'pending', 'pending', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, '2025-10-15 03:28:24', '2025-10-15 03:28:24'),
(78, 'TR0049', 49, 2, 'Medium', 'pending', 'pending', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, '2025-10-16 06:40:43', '2025-10-16 06:40:43'),
(79, 'TR0050', 50, 2, 'Medium', 'pending', 'pending', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no', NULL, NULL, 4, NULL, '2025-10-16 22:37:31', '2025-10-16 22:37:31'),
(80, 'TR0051', 51, 2, 'Medium', 'pending', 'pending', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, '2025-10-16 22:57:09', '2025-10-16 22:57:09'),
(81, 'TR0052', 52, 2, 'Medium', 'pending', 'pending', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, '2025-10-16 23:52:24', '2025-10-16 23:52:24'),
(82, 'TR0053', 53, 2, 'Medium', 'pending', 'pending', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, '2025-10-17 01:18:47', '2025-10-17 01:18:47'),
(83, 'TR0054', 54, 2, 'Medium', 'completed', 'approved', '2025-10-30 04:21:33', NULL, 1, NULL, '2025-11-03 03:26:49', 1, NULL, 1, 8, '2025-11-03 00:03:49', 1, '2025-11-03 11:51:31', 'no', NULL, NULL, NULL, NULL, '2025-10-17 01:45:12', '2025-11-03 06:21:31'),
(84, 'TR0055', 55, 2, 'Medium', 'completed', 'rejected', NULL, 'Hello This  is rejected for testing purpose', 0, NULL, NULL, NULL, 'NA', NULL, 5, '2025-10-29 00:12:50', 1, NULL, 'yes', NULL, '127.0.0.1', NULL, 4, '2025-10-17 01:58:55', '2025-10-30 06:14:05'),
(85, 'TR0056', 56, 2, 'Medium', 'completed', 'rejected', NULL, 'hjghjg', 1, NULL, NULL, NULL, NULL, 1, 5, '2025-10-29 00:12:28', 1, '2025-11-03 12:44:02', 'no', NULL, NULL, NULL, NULL, '2025-10-17 03:10:44', '2025-11-03 07:14:02'),
(86, 'TR0056', 56, 4, 'Medium', 'completed', 'rejected', NULL, 'hjghjg', 1, NULL, NULL, NULL, NULL, 1, 5, '2025-10-29 00:12:28', 1, '2025-11-03 12:44:02', 'no', NULL, NULL, NULL, NULL, '2025-10-17 03:10:44', '2025-11-03 07:14:02'),
(87, 'TR0057', 57, 2, 'Medium', 'completed', 'approved', '2025-10-30 06:13:19', NULL, 1, NULL, NULL, NULL, NULL, 1, 5, '2025-10-29 00:10:08', 1, '2025-11-03 12:45:15', 'no', NULL, NULL, NULL, NULL, '2025-10-17 03:56:11', '2025-11-03 07:15:15'),
(88, 'TR0058', 58, 2, 'Medium', 'pending', 'pending', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 8, '2025-10-28 23:59:56', 1, NULL, 'no', NULL, NULL, NULL, NULL, '2025-10-27 05:13:31', '2025-10-28 23:59:56'),
(89, 'TR0059', 59, 2, 'Medium', 'pending', 'pending', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 7, '2025-10-29 01:39:34', 4, NULL, 'no', NULL, NULL, NULL, NULL, '2025-10-28 04:06:42', '2025-10-29 01:39:34'),
(90, 'TR0061', 61, 2, 'Medium', 'pending', 'approved', '2025-10-30 07:44:27', 'NA', 0, NULL, NULL, NULL, NULL, NULL, 5, '2025-10-28 23:04:16', 1, NULL, 'no', NULL, NULL, NULL, NULL, '2025-10-28 06:04:36', '2025-10-30 07:44:27'),
(91, 'TR0061', 61, 4, 'Medium', 'pending', 'approved', '2025-10-30 07:44:27', 'NA', 0, NULL, NULL, NULL, NULL, NULL, 5, '2025-10-28 23:04:16', 1, NULL, 'no', NULL, NULL, NULL, NULL, '2025-10-28 06:04:36', '2025-10-30 07:44:27'),
(92, 'TR0061', 61, 5, 'Medium', 'pending', 'approved', '2025-10-30 07:44:27', 'NA', 0, NULL, NULL, NULL, NULL, NULL, 5, '2025-10-28 23:04:16', 1, NULL, 'no', NULL, NULL, NULL, NULL, '2025-10-28 06:04:36', '2025-10-30 07:44:27'),
(93, 'TR0061', 61, 6, 'Medium', 'pending', 'approved', '2025-10-30 07:44:27', 'NA', 0, NULL, NULL, NULL, NULL, NULL, 5, '2025-10-28 23:04:16', 1, NULL, 'no', NULL, NULL, NULL, NULL, '2025-10-28 06:04:36', '2025-10-30 07:44:27'),
(94, 'TR0062', 62, 2, 'Medium', 'pending', 'pending', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 9, '2025-10-28 23:04:05', 1, NULL, 'no', NULL, NULL, NULL, NULL, '2025-10-28 07:45:59', '2025-10-28 23:04:05'),
(95, 'TR0063', 63, 2, 'Medium', 'pending', 'approved', '2025-10-30 02:04:27', NULL, 0, NULL, NULL, NULL, NULL, 7, 5, '2025-10-29 00:09:50', 1, '2025-10-30 13:13:23', 'no', NULL, NULL, NULL, NULL, '2025-10-28 07:56:52', '2025-10-30 07:43:23'),
(96, 'TR0064', 64, 2, 'Medium', 'pending', 'pending', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 7, '2025-10-29 01:50:00', 4, NULL, 'no', NULL, NULL, NULL, NULL, '2025-10-28 23:13:18', '2025-10-29 01:50:00');

-- --------------------------------------------------------

--
-- Table structure for table `test_result_components`
--

CREATE TABLE `test_result_components` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `test_result_id` bigint(20) NOT NULL,
  `component_id` bigint(20) NOT NULL,
  `result` text DEFAULT NULL,
  `result_status` enum('normal','abnormal','critical') DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `test_result_components`
--

INSERT INTO `test_result_components` (`id`, `test_result_id`, `component_id`, `result`, `result_status`, `created_at`, `updated_at`) VALUES
(1, 22, 4, '15.0', 'normal', '2025-09-24 03:46:43', '2025-09-24 04:03:39'),
(2, 22, 6, '6.0', 'abnormal', '2025-09-24 03:46:43', '2025-09-24 04:03:39'),
(3, 23, 8, '18', 'abnormal', '2025-09-24 04:05:40', '2025-09-24 04:05:40'),
(4, 23, 10, '4.7', 'normal', '2025-09-24 04:05:40', '2025-09-24 04:05:40'),
(5, 47, 4, '15.0', 'normal', '2025-10-08 01:24:57', '2025-10-08 01:24:57'),
(6, 47, 6, '6.0', 'abnormal', '2025-10-08 01:24:57', '2025-10-08 01:24:57'),
(7, 60, 43, '11.6', NULL, '2025-10-10 04:47:56', '2025-10-10 04:47:56'),
(8, 60, 44, '5.62', NULL, '2025-10-10 04:47:56', '2025-10-10 04:47:56'),
(9, 60, 45, '24.4', NULL, '2025-10-10 04:47:56', '2025-10-10 04:47:56'),
(10, 60, 46, '18.0', NULL, '2025-10-10 04:47:56', '2025-10-10 04:47:56'),
(11, 60, 48, '20.5', NULL, '2025-10-10 04:47:56', '2025-10-10 04:47:56'),
(12, 60, 49, '47.5', NULL, '2025-10-10 04:47:56', '2025-10-10 04:47:56'),
(13, 60, 50, '18.0', NULL, '2025-10-10 04:47:56', '2025-10-10 04:47:56'),
(14, 60, 51, '10.68', NULL, '2025-10-10 04:47:56', '2025-10-10 04:47:56'),
(15, 60, 53, '54', NULL, '2025-10-10 04:47:56', '2025-10-10 04:47:56'),
(16, 60, 54, '08', NULL, '2025-10-10 04:47:56', '2025-10-10 04:47:56'),
(17, 60, 55, '32', NULL, '2025-10-10 04:47:56', '2025-10-10 04:47:56'),
(18, 60, 56, '06', NULL, '2025-10-10 04:47:56', '2025-10-10 04:47:56'),
(19, 60, 57, '00', NULL, '2025-10-10 04:47:56', '2025-10-10 04:47:56'),
(20, 60, 59, '345000', NULL, '2025-10-10 04:47:56', '2025-10-10 04:47:56'),
(21, 60, 60, '15.1', NULL, '2025-10-10 04:47:56', '2025-10-10 04:47:56'),
(22, 60, 61, '9.7', NULL, '2025-10-10 04:47:56', '2025-10-10 04:47:56'),
(23, 60, 62, 'Adequate', NULL, '2025-10-10 04:47:56', '2025-10-10 04:47:56'),
(24, 60, 63, 'Normocytic Normochromic', NULL, '2025-10-10 04:47:56', '2025-10-10 04:47:56'),
(25, 60, 64, 'Not Detected', NULL, '2025-10-10 04:47:56', '2025-10-10 04:47:56'),
(26, 60, 65, 'Fully Automated Five Part Veterinary', NULL, '2025-10-10 04:47:56', '2025-10-10 04:50:39'),
(27, 74, 4, '15.0', NULL, '2025-10-15 01:42:44', '2025-10-15 01:42:44'),
(28, 74, 6, '6.0', NULL, '2025-10-15 01:42:44', '2025-10-15 01:42:44'),
(29, 75, 12, 'Option 1', NULL, '2025-10-15 01:42:59', '2025-10-15 01:42:59'),
(30, 84, 4, '15.0', 'normal', '2025-10-17 02:09:54', '2025-10-17 02:09:54'),
(31, 84, 6, '6.0', 'abnormal', '2025-10-17 02:09:54', '2025-10-17 02:09:54');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('admin','branch','doctor','petparent') NOT NULL DEFAULT 'admin',
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `status` enum('active','delete','inactive') NOT NULL DEFAULT 'active',
  `last_login` datetime DEFAULT NULL,
  `role_id` bigint(20) DEFAULT NULL,
  `created_ip_address` varchar(255) DEFAULT NULL,
  `modified_ip_address` varchar(255) DEFAULT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  `modified_by` bigint(20) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `otp` varchar(6) DEFAULT NULL,
  `otp_expires_at` timestamp NULL DEFAULT NULL,
  `otp_attempts` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `type`, `name`, `email`, `email_verified_at`, `password`, `mobile`, `address`, `status`, `last_login`, `role_id`, `created_ip_address`, `modified_ip_address`, `created_by`, `modified_by`, `remember_token`, `otp`, `otp_expires_at`, `otp_attempts`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'Super Admin', 'admin@gmail.com', NULL, '$2y$10$Zp7pqPfZu76kCPXIgAu5UusUJ5soHFLyo8MQ/M86c9RSVnVaP7wgK', NULL, NULL, 'active', '2025-11-04 08:39:31', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, '2025-11-04 03:09:31'),
(4, 'branch', 'Branch', 'branch@gmail.com', NULL, '$2y$10$InJ0GHoOaHXJHMuEYqTMye.t5E4QfWDrzNLW/pltguVNM/OZCpFUm', NULL, NULL, 'active', '2025-11-04 10:53:11', 7, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL, '2025-11-04 05:23:11'),
(5, 'admin', 'Admin', 'admin1@gmail.com', NULL, '$2y$10$z.0KExO7aBARVMJ78rYHXOWrY5mIvqAC5ZS3S2t55XNyZOUP/3pVa', '9792159492', 'Bair Amad Karari', 'active', '2025-10-14 05:35:38', 6, '127.0.0.1', NULL, 1, NULL, NULL, NULL, NULL, 0, '2025-10-14 00:05:27', '2025-10-14 00:05:38'),
(6, 'branch', 'New testing Branch', 'branch1@gmail.com', NULL, '$2y$10$Dav6.k5MUFn5Wto2HSAGO.Ui7t4aEgs9tHEsMd0.De.qlYk3qR8nu', '+917318560008', 'Bair Amad Karari', 'active', '2025-10-17 07:17:16', 7, '127.0.0.1', NULL, 1, NULL, NULL, NULL, NULL, 0, '2025-10-14 00:25:12', '2025-10-17 01:47:16'),
(7, 'doctor', 'Doctor', 'doctor@gmail.com', NULL, '$2y$10$Dav6.k5MUFn5Wto2HSAGO.Ui7t4aEgs9tHEsMd0.De.qlYk3qR8nu', '+917318560008', 'Bair Amad Karari', 'active', '2025-11-04 10:50:11', NULL, '127.0.0.1', NULL, 1, NULL, NULL, NULL, NULL, 0, '2025-10-14 00:25:12', '2025-11-04 05:20:11'),
(8, 'doctor', 'Testing Doctor', 'doctor1@gmail.com', NULL, '$2y$10$Dav6.k5MUFn5Wto2HSAGO.Ui7t4aEgs9tHEsMd0.De.qlYk3qR8nu', '+917318560908', 'Bair Amad Karari', 'active', '2025-10-14 07:32:05', NULL, '127.0.0.1', NULL, 1, NULL, NULL, NULL, NULL, 0, '2025-10-14 00:40:49', '2025-10-14 02:02:05'),
(9, 'doctor', 'Doctor Three', 'doctor3@gmail.com', NULL, '$2y$10$Nt1OWL/SAeTu52pbSjzgxu3Vu1EqLH6fNEyDnyogcExm5kCB.sdIS', '+917318560709', 'Bair Amad Karari', 'active', NULL, NULL, '127.0.0.1', NULL, 1, NULL, NULL, NULL, NULL, 0, '2025-10-14 02:06:26', '2025-10-14 02:06:26'),
(10, 'doctor', 'Doctor Four', 'doctor4@gmail.com', NULL, '$2y$10$Nt1OWL/SAeTu52pbSjzgxu3Vu1EqLH6fNEyDnyogcExm5kCB.sdIS', '+918318560108', 'Bair Amad Karari', 'active', '2025-10-14 08:50:32', NULL, '127.0.0.1', NULL, 1, NULL, NULL, NULL, NULL, 0, '2025-10-14 03:19:41', '2025-10-14 03:20:32'),
(11, 'petparent', 'Testing', 'testingpetparenr@gmail.com', NULL, '$2y$10$6IYMlm8./sj3j78C6qH06up6kwnByCrHYWN2VPSGKpK0ovkBr1p9u', '1234567899', NULL, 'active', NULL, NULL, '127.0.0.1', NULL, 1, NULL, NULL, NULL, NULL, 0, '2025-10-14 05:20:22', '2025-10-14 05:20:22'),
(12, 'petparent', 'Pet parent Added by Branch', 'petparent1@gmail.com', NULL, '$2y$10$a4RS/lbbWPK7rYuACiGc/OTuoNvc3uxLn5dkuNsnrxE9waVKSd4Ui', '8888560108', 'Bair Amad Karari', 'active', NULL, NULL, '127.0.0.1', NULL, 4, NULL, NULL, NULL, NULL, 0, '2025-10-14 05:45:40', '2025-10-14 05:45:40'),
(13, 'petparent', 'Pet Parent One', 'petparent230@gmail.com', NULL, '$2y$10$dOoq5lX93mlmOMBu4B0Mi.l7pJTN/qD47BqAVLl1.sHanJmUg8d82', '7318569999', 'Bair Amad Karari', 'active', NULL, NULL, '127.0.0.1', NULL, 6, NULL, NULL, NULL, NULL, 0, '2025-10-14 06:34:29', '2025-10-14 06:34:29'),
(14, 'petparent', 'Pet Owner of new testing Branch', 'asdsad@gmail.com', NULL, '$2y$10$CGUYSkNz4.8n.hYhmSKXv.iEWaos5Im1KE7kZL0mofykc905RB5ea', '7318999999', 'Bair Amad Karari', 'active', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-10-15 03:27:34', '2025-10-15 03:27:34'),
(15, 'petparent', 'xzczxcxz', 'zxczxc@gmail.com', NULL, '$2y$10$a..IBfQpw5zaEMnGBZGpQuhitoZHWbwvdaV3nsVEJLgHGwl88.AfC', '0018560108', 'Bair Amad Karari', 'active', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-10-15 03:30:42', '2025-10-15 03:30:42'),
(16, 'branch', 'Branch Receptionist', 'branchrec@gmail.com', NULL, '$2y$10$wmkyVRWyy29hwXlmsInEc.LId2HNk3r0NEVNTIFOYrcUIIDdtbxgG', '7300560108', 'Bair Amad Karari', 'active', '2025-10-16 11:16:56', 8, '127.0.0.1', NULL, 4, NULL, NULL, NULL, NULL, 0, '2025-10-16 05:46:20', '2025-10-16 05:46:56'),
(17, 'branch', 'Branch Receptionist1', 'branchrec1@gmail.com', NULL, '$2y$10$gYpptFedFKLBvBszOl2dPu1YolnXQ6CtBCkWTujqxEZBSaVtIp3We', '7000560108', 'Bair Amad Karari', 'active', '2025-10-17 04:48:18', 8, '127.0.0.1', NULL, 4, NULL, NULL, NULL, NULL, 0, '2025-10-16 06:13:31', '2025-10-16 23:18:18'),
(18, 'branch', 'Branch Receptionist2', 'branchrec2@gmail.com', NULL, '$2y$10$.Yb4/tBEIp5tKZz7tTW0nuwleoxej9ru/hjG1adTiWYP9KFn8hcH.', '7718560108', 'Bair Amad Karari', 'active', '2025-10-17 07:13:14', 8, '127.0.0.1', NULL, 4, NULL, NULL, NULL, NULL, 0, '2025-10-17 01:42:58', '2025-10-17 01:43:14'),
(19, 'petparent', 'testing', 'testing@gmail.com', NULL, '$2y$10$AVdKzz2gb0hBS5Ns3Oh44evICTDiOFdkcn34Rv4aumlsu3ShJfQ12', '7311111108', 'Bair Amad Karari', 'active', NULL, NULL, '127.0.0.1', NULL, 4, NULL, NULL, NULL, NULL, 0, '2025-10-17 03:09:41', '2025-10-17 03:09:41'),
(21, 'branch', 'Lab Tech', 'labtech@gmail.com', NULL, '$2y$10$370oweQZ.bxNze0i3WvxCOtoZQyCams5IbgQsEf963dEiyFEivMSu', '9999560108', 'Bair Amad Karari', 'active', '2025-10-17 09:48:50', 9, '127.0.0.1', '127.0.0.1', 4, 4, NULL, NULL, NULL, 0, '2025-10-17 03:54:23', '2025-10-17 04:18:50'),
(22, 'branch', 'Xyz Branch', 'xyzbranch@gmail.com', NULL, '$2y$10$MzGGGPvlN/pKeTvUqo1iHOjEPJpEalh75qprctjFu/ZnjntmQ0k.i', '+917318555555', 'Bair Amad Karari', 'active', NULL, NULL, '127.0.0.1', NULL, 1, NULL, NULL, NULL, NULL, 0, '2025-10-23 22:40:39', '2025-10-23 22:40:39'),
(23, 'branch', 'First Collection center', 'fisrtcollectioncenter@gmail.com', NULL, '$2y$10$jV26SPp9mUMjQt1l00KtAenCdliGKONIbiB7E9xguFhDtZcpmqMQy', '+917318900000', 'Bair Amad Karari', 'active', NULL, NULL, '127.0.0.1', NULL, 1, NULL, NULL, NULL, NULL, 0, '2025-10-24 00:13:09', '2025-10-24 00:13:09'),
(24, 'branch', 'First Collection center 1', 'collection_center@gmail.com', NULL, '$2y$10$regXGr6Aaj7L8z1c6B7I8enQPzIOy8nb5HwVn6ylaN8oyxTW7A9M6', '+917318560108', 'Bair Amad Karari', 'active', NULL, NULL, '127.0.0.1', NULL, 1, NULL, NULL, NULL, NULL, 0, '2025-10-27 07:16:10', '2025-10-27 07:16:10'),
(25, 'doctor', 'sdsadasd', 'sdfdskjhjh@gmail.com', NULL, '$2y$10$I.whr.d9.AwNtHRyfyL5aejzj4mR98Dyz5DT/ups2rL2LhfnQ89uK', '9807660108', 'Bair Amad Karari', 'active', NULL, NULL, '127.0.0.1', NULL, 1, NULL, NULL, NULL, NULL, 0, '2025-10-28 05:43:50', '2025-10-28 05:43:50'),
(26, 'petparent', 'sdsadsa', 'sasadsa@gmail.com', NULL, '$2y$10$C3TQsmwe/IGxR9wi5aTIMO7kSwSeMGHeIpxe3LP0bHdvIY0R/.aVu', '6633560108', 'Bair Amad Karari', 'active', NULL, NULL, '127.0.0.1', NULL, 1, NULL, NULL, NULL, NULL, 0, '2025-10-28 05:49:24', '2025-10-28 05:49:24'),
(27, 'petparent', 'jsajdsaj', 'fghgfhfg@gmail.com', NULL, '$2y$10$6WgC5FUw7UCMHvSkCSrhOOO6PQZmR9AF2NLWI4IERyiLUIOwrYLNO', '6712345678', 'Bair Amad Karari', 'active', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-10-28 07:44:16', '2025-10-28 07:44:16'),
(28, 'petparent', 'Testing owner', 'hello@gmail.com', NULL, '$2y$10$pPvcd0IyFkbcmJm7P7A7DOyfQNWdwE0TTvgQo9U16zJ8xoTcm9rs6', '7318589000', 'Bair Amad Karari', 'active', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-10-28 07:53:36', '2025-10-28 07:53:36'),
(29, 'petparent', 'hjsahdjkhsadkh', 'khassah@gmail.com', NULL, '$2y$10$hA1L0X2XjJfRFYbd0Aw7g.hV9lyeu9xVscNulGNC.QiWiZE4zSIqG', '7398760108', 'Bair Amad Karari', 'active', NULL, NULL, '127.0.0.1', NULL, 1, NULL, NULL, NULL, NULL, 0, '2025-10-28 07:58:08', '2025-10-28 07:58:08'),
(30, 'petparent', 'edfswe', 'wqeqwewq@gmail.com', NULL, '$2y$10$YXq.kXdxvDZnY.xtsd0DQ.QDUj6AkqoyEfMClMqraKMXU/bdJAA4y', '9792159493', 'Bair Amad Karari', 'active', NULL, NULL, '127.0.0.1', NULL, 1, NULL, NULL, NULL, NULL, 0, '2025-10-28 08:07:50', '2025-10-28 08:07:50'),
(31, 'petparent', 'sadsaas', 'saadsad@gmail.com', NULL, '$2y$10$GKzMOfpnTBsH8j/Gosgb2evCIAYLurKxYS0.LCI04xpeaLbXLeOYy', '7366560133', 'Bair Amad Karari', 'active', NULL, NULL, '127.0.0.1', NULL, 1, NULL, NULL, NULL, NULL, 0, '2025-10-28 08:18:24', '2025-10-28 08:18:24'),
(32, 'petparent', 'Hello Owner', 'hello12@gmail.com', NULL, '$2y$10$oPc7yi4BdMVUlwk4CKs1IeY.EwDu2oUiCGgfPLisjdWS36q053Y4S', '7373730108', 'Bair Amad Karari', 'active', NULL, NULL, '127.0.0.1', NULL, 1, NULL, NULL, NULL, NULL, 0, '2025-10-28 08:28:23', '2025-10-28 08:28:23'),
(33, 'petparent', 'Hesasdas', 'sdfdsf@gmail.com', NULL, '$2y$10$Y9S1P5tOqNSENpI5g0BthOj8O4ssnr9I1uZxIgLJgfwGZOWCeRHDG', '7318561167', 'Bair Amad Karari', 'active', NULL, NULL, '127.0.0.1', NULL, 1, NULL, NULL, NULL, NULL, 0, '2025-10-28 08:35:48', '2025-10-28 08:35:48'),
(34, 'petparent', 'dxfsdfd', 'rdfgdfgd@gmail.com', NULL, '$2y$10$swZ9AxP5DXflYiwMIVj3Au5hbjo.3Rs9h0xEUHD3NM2CM0qKSNISu', '7318566338', 'Bair Amad Karari', 'active', NULL, NULL, '127.0.0.1', NULL, 1, NULL, NULL, NULL, NULL, 0, '2025-10-28 08:42:33', '2025-10-28 08:42:33'),
(36, 'petparent', 'zxcZXSDs', 'sdfdsfsdf@gmail.com', NULL, '$2y$10$26dZ57COkkzCiLzXn7jHW.vjkUAnPfSg7lPDqhttx4K2Uyenpd5iG', '9873185601', 'Bair Amad Karari', 'active', NULL, NULL, '127.0.0.1', NULL, 1, NULL, NULL, NULL, NULL, 0, '2025-10-28 08:53:08', '2025-10-28 08:53:08'),
(38, 'petparent', 'jdjajd', 'ksdhfkhsdjh@gmail.com', NULL, '$2y$10$Y4Tb7T5BBkaJ/jH3XTVqJ.8aG2EH1oDgvKeCl.qTsu0XtHTTW7Tby', '7316630108', 'Bair Amad Karari', 'active', NULL, NULL, '127.0.0.1', NULL, 1, NULL, NULL, NULL, NULL, 0, '2025-10-28 09:05:50', '2025-10-28 09:05:50'),
(40, 'petparent', 'sddsfsdf', 'khkjhj@gmail.com', NULL, '$2y$10$vxVyenTpfR9JD6CLwxWSseerHap28hB9Swp/TBeZrROUmAvMdGes.', '7366560338', 'Bair Amad Karari', 'active', NULL, NULL, '127.0.0.1', NULL, 1, NULL, NULL, NULL, NULL, 0, '2025-10-28 09:17:54', '2025-10-28 09:17:54'),
(41, 'petparent', 'sdzfsfsd', 'fhdfgdfg@gmail.com', NULL, '$2y$10$wKlxFRp4i2BbvQzYMTwC7.euZKrNdbfPrdJwSsveaIdAUty3wyLxK', '7366527108', 'Bair Amad Karari', 'active', NULL, NULL, '127.0.0.1', NULL, 1, NULL, NULL, NULL, NULL, 0, '2025-10-28 09:27:11', '2025-10-28 09:27:11'),
(42, 'petparent', 'qwdwqe', 'sdjdskjsakh@gmail.com', NULL, '$2y$10$HVvz8vt5BQXYhUKR2ByRv.yg9dLy0Qd5gTPTbatotnGpmuPMEEIpq', '7318560108', 'Bair Amad Karari', 'active', NULL, NULL, '127.0.0.1', NULL, 1, NULL, NULL, NULL, NULL, 0, '2025-10-28 09:28:46', '2025-10-28 09:28:46'),
(43, 'petparent', 'jsdfksdfhksdhhjksdf', 'ksdkkdsfasdk@gmail.com', NULL, '$2y$10$MKrHAMJzBcZFy7NwkHgrNeB.5dongodKJKIMlMCgyK9YAV/2M/Pq6', '7663356010', 'Bair Amad Karari', 'active', NULL, NULL, '127.0.0.1', NULL, 1, NULL, NULL, NULL, NULL, 0, '2025-10-28 09:30:56', '2025-10-28 09:30:56'),
(44, 'petparent', 'sdsd', 'sadsad@gmail.com', NULL, '$2y$10$84HFBcXHqFrbQL9nRr4sTOudqlBRuhZ9suBJuVm6YR6bjhwsI1obO', '7369885601', 'Bair Amad Karari', 'active', NULL, NULL, '127.0.0.1', NULL, 1, NULL, NULL, NULL, NULL, 0, '2025-10-28 09:32:10', '2025-10-28 09:32:10'),
(45, 'petparent', 'sdfdfdsf', 'sdfsdfsfd@gmail.com', NULL, '$2y$10$S0RCcmWfO109AVUGkeIbpusE3K3I65RqHDHA712sCynfRhpkLP9qm', '7318565558', 'Bair Amad Karari', 'active', NULL, NULL, '127.0.0.1', '127.0.0.1', 1, 1, NULL, NULL, NULL, 0, '2025-10-28 09:33:39', '2025-10-29 05:23:24'),
(46, 'petparent', 'sdsaidiasdiohasd', 'kjaskjashdkj@gmail.com', NULL, '$2y$10$hynkyF8lbuRdygoTYMRrOeExQl6hE81dQ7mtn0nm3j5r.cK3qZLSW', '7781856010', 'Bair Amad Karari', 'active', NULL, NULL, '127.0.0.1', '127.0.0.1', 1, 1, NULL, NULL, NULL, 0, '2025-10-28 09:36:12', '2025-10-29 04:33:21'),
(47, 'admin', 'subadmin', 'subadmin@gmail.com', NULL, '$2y$10$g1al8CUUwgCdEx0pZJBCbOueVKdYrz6I3wetHLQkgmxXC/JhHVa5i', '7668560108', 'Bair Amad Karari', 'active', '2025-10-29 10:44:45', 10, '127.0.0.1', '127.0.0.1', 1, 1, NULL, NULL, NULL, 0, '2025-10-29 05:14:23', '2025-10-29 23:04:14'),
(48, 'admin', 'xyz', 'xyz234@gmail.com', NULL, '$2y$10$qn4Kz5qcjRZQskkJngFbKu8Txv7wQJYaDVrfuc9S04DwlKX3JxmRO', '73185606633', 'Bair Amad Karari', 'active', '2025-10-29 10:48:45', 11, '127.0.0.1', '127.0.0.1', 1, 1, NULL, NULL, NULL, 0, '2025-10-29 05:18:11', '2025-10-29 23:03:27'),
(49, 'petparent', 'Deepak Tripathi', 'xyz@gmail.com', NULL, '$2y$10$UupvhlYosXp0kKghYyACTOv06w9uRn0IlMZIBUIiRxh9T9yOQBwaO', '7318560109', NULL, 'active', '2025-11-04 12:54:50', NULL, '127.0.0.1', NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-11-04 07:24:09', '2025-11-04 07:24:50');

-- --------------------------------------------------------

--
-- Table structure for table `visual_settings`
--

CREATE TABLE `visual_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `logo_image_path` varchar(255) DEFAULT NULL,
  `logo_image_name` varchar(255) DEFAULT NULL,
  `mini_logo_image_path` varchar(255) DEFAULT NULL,
  `mini_logo_image_name` varchar(255) DEFAULT NULL,
  `logo_email_image_path` varchar(255) DEFAULT NULL,
  `logo_email_image_name` varchar(255) DEFAULT NULL,
  `favicon_image_path` varchar(255) DEFAULT NULL,
  `favicon_image_name` varchar(255) DEFAULT NULL,
  `created_ip_address` varchar(255) DEFAULT NULL,
  `modified_ip_address` varchar(255) DEFAULT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  `modified_by` bigint(20) DEFAULT NULL,
  `status` enum('active','delete','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `visual_settings`
--

INSERT INTO `visual_settings` (`id`, `logo_image_path`, `logo_image_name`, `mini_logo_image_path`, `mini_logo_image_name`, `logo_email_image_path`, `logo_email_image_name`, `favicon_image_path`, `favicon_image_name`, `created_ip_address`, `modified_ip_address`, `created_by`, `modified_by`, `status`, `created_at`, `updated_at`) VALUES
(1, 'public/images/visuals/logo (4).png', 'logo (4).png', 'public/images/visuals/logo (5).png', 'logo (5).png', 'public/images/visuals/logo (4).png', 'logo (4).png', 'public/images/visuals/logo (5).png', 'logo (5).png', '127.0.0.1', NULL, 1, NULL, 'active', '2025-10-06 05:44:37', '2025-10-06 05:44:37');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `appointment_tests`
--
ALTER TABLE `appointment_tests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`city_id`),
  ADD KEY `state_id` (`state_id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`country_id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `departments_code_unique` (`code`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `general_settings`
--
ALTER TABLE `general_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `internal_doctors`
--
ALTER TABLE `internal_doctors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master_admins`
--
ALTER TABLE `master_admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `parameter_options`
--
ALTER TABLE `parameter_options`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `petparents`
--
ALTER TABLE `petparents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pets`
--
ALTER TABLE `pets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pets_pet_code_unique` (`pet_code`);

--
-- Indexes for table `referee_doctors`
--
ALTER TABLE `referee_doctors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_privileges`
--
ALTER TABLE `role_privileges`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sample_collections`
--
ALTER TABLE `sample_collections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`),
  ADD KEY `sessions_user_id_index` (`user_id`);

--
-- Indexes for table `states`
--
ALTER TABLE `states`
  ADD PRIMARY KEY (`state_id`),
  ADD KEY `country_id` (`country_id`);

--
-- Indexes for table `tests`
--
ALTER TABLE `tests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `test_parameters`
--
ALTER TABLE `test_parameters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `test_profiles`
--
ALTER TABLE `test_profiles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `test_profile_tests`
--
ALTER TABLE `test_profile_tests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `test_results`
--
ALTER TABLE `test_results`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `test_result_components`
--
ALTER TABLE `test_result_components`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `visual_settings`
--
ALTER TABLE `visual_settings`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `appointment_tests`
--
ALTER TABLE `appointment_tests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT for table `branches`
--
ALTER TABLE `branches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `city_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=545;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `country_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `general_settings`
--
ALTER TABLE `general_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `internal_doctors`
--
ALTER TABLE `internal_doctors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `master_admins`
--
ALTER TABLE `master_admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `parameter_options`
--
ALTER TABLE `parameter_options`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `petparents`
--
ALTER TABLE `petparents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `pets`
--
ALTER TABLE `pets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `referee_doctors`
--
ALTER TABLE `referee_doctors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `role_privileges`
--
ALTER TABLE `role_privileges`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `sample_collections`
--
ALTER TABLE `sample_collections`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `states`
--
ALTER TABLE `states`
  MODIFY `state_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `tests`
--
ALTER TABLE `tests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `test_parameters`
--
ALTER TABLE `test_parameters`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `test_profiles`
--
ALTER TABLE `test_profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `test_profile_tests`
--
ALTER TABLE `test_profile_tests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `test_results`
--
ALTER TABLE `test_results`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT for table `test_result_components`
--
ALTER TABLE `test_result_components`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `visual_settings`
--
ALTER TABLE `visual_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cities`
--
ALTER TABLE `cities`
  ADD CONSTRAINT `cities_ibfk_1` FOREIGN KEY (`state_id`) REFERENCES `states` (`state_id`);

--
-- Constraints for table `states`
--
ALTER TABLE `states`
  ADD CONSTRAINT `states_ibfk_1` FOREIGN KEY (`country_id`) REFERENCES `countries` (`country_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
