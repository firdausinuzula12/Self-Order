-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 07, 2025 at 08:54 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `toko`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_admin`
--

CREATE TABLE `tb_admin` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','kasir') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_admin`
--

INSERT INTO `tb_admin` (`id`, `username`, `password`, `role`) VALUES
(2, 'admin', 'admin99', 'admin'),
(3, 'kasir', 'kasir99', 'kasir');

-- --------------------------------------------------------

--
-- Table structure for table `tb_daily_stock`
--

CREATE TABLE `tb_daily_stock` (
  `id_stok` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `stok_awal` int(11) NOT NULL DEFAULT 0,
  `stok_terjual` int(11) NOT NULL DEFAULT 0,
  `stok_sisa` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_daily_stock`
--

INSERT INTO `tb_daily_stock` (`id_stok`, `product_id`, `tanggal`, `stok_awal`, `stok_terjual`, `stok_sisa`, `created_at`, `updated_at`) VALUES
(1, 53, '2025-11-17', 15, 0, 15, '2025-11-17 10:53:26', '2025-11-17 12:51:39'),
(2, 42, '2025-11-17', 10, 0, 10, '2025-11-17 11:14:42', '2025-11-17 11:14:42'),
(3, 78, '2025-11-18', 15, 0, 15, '2025-11-18 22:06:58', '2025-11-18 22:06:58'),
(4, 28, '2025-11-18', 15, 0, 15, '2025-11-18 22:07:07', '2025-11-18 22:07:07'),
(5, 53, '2025-11-18', 15, 0, 15, '2025-11-18 22:07:14', '2025-11-18 22:07:14'),
(6, 76, '2025-11-18', 15, 0, 15, '2025-11-18 22:07:26', '2025-11-18 22:07:26'),
(7, 42, '2025-11-18', 15, 0, 15, '2025-11-18 22:07:39', '2025-11-18 22:07:39'),
(8, 7, '2025-11-18', 15, 0, 15, '2025-11-18 22:07:49', '2025-11-18 22:07:49'),
(9, 43, '2025-11-18', 15, 0, 15, '2025-11-18 22:08:00', '2025-11-18 22:08:00'),
(10, 48, '2025-11-18', 14, 0, 14, '2025-11-18 22:08:09', '2025-11-18 22:08:09'),
(11, 73, '2025-11-18', 15, 0, 15, '2025-11-18 22:08:20', '2025-11-18 22:08:20'),
(12, 74, '2025-11-18', 15, 0, 15, '2025-11-18 22:08:39', '2025-11-18 22:08:39'),
(13, 29, '2025-11-18', 15, 0, 15, '2025-11-18 22:08:47', '2025-11-18 22:08:47'),
(14, 9, '2025-11-18', 15, 0, 15, '2025-11-18 22:08:54', '2025-11-18 22:08:54'),
(15, 41, '2025-11-18', 15, 0, 15, '2025-11-18 22:09:03', '2025-11-18 22:09:03'),
(16, 27, '2025-11-18', 15, 0, 15, '2025-11-18 22:09:10', '2025-11-18 22:09:10'),
(17, 35, '2025-11-18', 15, 0, 15, '2025-11-18 22:09:17', '2025-11-18 22:09:17'),
(18, 8, '2025-11-18', 15, 0, 15, '2025-11-18 22:09:23', '2025-11-18 22:09:23'),
(19, 39, '2025-11-18', 15, 0, 15, '2025-11-18 22:09:29', '2025-11-18 22:09:29'),
(20, 11, '2025-11-18', 15, 0, 15, '2025-11-18 22:09:37', '2025-11-18 22:09:37'),
(21, 4, '2025-11-18', 15, 0, 15, '2025-11-18 22:09:43', '2025-11-18 22:09:43'),
(22, 24, '2025-11-18', 15, 0, 15, '2025-11-18 22:09:53', '2025-11-18 22:09:53'),
(23, 79, '2025-11-18', 15, 0, 15, '2025-11-18 22:10:00', '2025-11-18 22:10:00'),
(24, 34, '2025-11-18', 15, 0, 15, '2025-11-18 22:10:07', '2025-11-18 22:10:07'),
(25, 47, '2025-11-18', 15, 0, 15, '2025-11-18 22:10:15', '2025-11-18 22:10:15'),
(26, 45, '2025-11-18', 15, 0, 15, '2025-11-18 22:10:22', '2025-11-18 22:10:22'),
(27, 31, '2025-11-18', 15, 0, 15, '2025-11-18 22:10:31', '2025-11-18 22:10:31'),
(28, 12, '2025-11-18', 0, 0, 0, '2025-11-18 22:10:40', '2025-11-18 22:10:40'),
(29, 5, '2025-11-18', 15, 0, 15, '2025-11-18 22:10:50', '2025-11-18 22:10:50'),
(30, 33, '2025-11-18', 15, 0, 15, '2025-11-18 22:10:59', '2025-11-18 22:10:59'),
(31, 23, '2025-11-18', 15, 0, 15, '2025-11-18 22:11:08', '2025-11-18 22:11:08'),
(32, 40, '2025-11-18', 0, 0, 0, '2025-11-18 22:11:38', '2025-11-18 22:11:38'),
(33, 55, '2025-11-18', 0, 0, 0, '2025-11-18 22:11:46', '2025-11-18 22:11:46'),
(34, 36, '2025-11-18', 15, 0, 15, '2025-11-18 22:11:54', '2025-11-18 22:11:54'),
(35, 15, '2025-11-18', 15, 0, 15, '2025-11-18 22:12:03', '2025-11-18 22:12:03'),
(36, 13, '2025-11-18', 15, 0, 15, '2025-11-18 22:12:17', '2025-11-18 22:12:17'),
(37, 83, '2025-11-18', 0, 0, 0, '2025-11-18 22:12:28', '2025-11-18 22:12:28'),
(38, 90, '2025-11-18', 15, 0, 15, '2025-11-18 22:12:37', '2025-11-18 22:12:37'),
(39, 75, '2025-11-18', 15, 0, 15, '2025-11-18 22:12:45', '2025-11-18 22:12:45'),
(40, 10, '2025-11-18', 15, 0, 15, '2025-11-18 22:12:53', '2025-11-18 22:12:53'),
(41, 67, '2025-11-18', 15, 0, 15, '2025-11-18 22:13:00', '2025-11-18 22:13:00'),
(42, 80, '2025-11-18', 15, 0, 15, '2025-11-18 22:13:06', '2025-11-18 22:13:06'),
(43, 30, '2025-11-18', 15, 0, 15, '2025-11-18 22:13:20', '2025-11-18 22:13:20'),
(44, 66, '2025-11-18', 15, 0, 15, '2025-11-18 22:13:32', '2025-11-18 22:13:32'),
(45, 19, '2025-11-18', 15, 0, 15, '2025-11-18 22:13:45', '2025-11-18 22:13:45'),
(46, 82, '2025-11-18', 15, 0, 15, '2025-11-18 22:13:53', '2025-11-18 22:13:53'),
(47, 68, '2025-11-18', 15, 0, 15, '2025-11-18 22:14:04', '2025-11-18 22:14:04'),
(48, 69, '2025-11-18', 15, 0, 15, '2025-11-18 22:14:18', '2025-11-18 22:14:18'),
(49, 1, '2025-11-19', 14, 0, 14, '2025-11-18 23:06:59', '2025-11-19 00:58:51'),
(50, 2, '2025-11-19', 14, 0, 14, '2025-11-18 23:06:59', '2025-11-19 00:51:45'),
(51, 4, '2025-11-19', 14, 0, 14, '2025-11-18 23:06:59', '2025-11-19 00:50:06'),
(52, 5, '2025-11-19', 0, 0, 0, '2025-11-18 23:06:59', '2025-11-19 00:53:45'),
(53, 7, '2025-11-19', 14, 0, 14, '2025-11-18 23:06:59', '2025-11-19 00:49:40'),
(54, 8, '2025-11-19', 14, 0, 14, '2025-11-18 23:06:59', '2025-11-19 00:54:23'),
(55, 9, '2025-11-19', 14, 0, 14, '2025-11-18 23:06:59', '2025-11-19 00:55:14'),
(56, 10, '2025-11-19', 14, 0, 14, '2025-11-18 23:06:59', '2025-11-19 00:58:27'),
(57, 11, '2025-11-19', 14, 0, 14, '2025-11-18 23:06:59', '2025-11-19 00:49:48'),
(58, 12, '2025-11-19', 0, 0, 0, '2025-11-18 23:06:59', '2025-11-18 23:06:59'),
(59, 13, '2025-11-19', 14, 0, 14, '2025-11-18 23:06:59', '2025-11-19 00:54:50'),
(60, 14, '2025-11-19', 14, 0, 14, '2025-11-18 23:06:59', '2025-11-19 00:59:57'),
(61, 15, '2025-11-19', 14, 0, 14, '2025-11-18 23:06:59', '2025-11-19 00:54:32'),
(62, 16, '2025-11-19', 14, 0, 14, '2025-11-18 23:06:59', '2025-11-19 00:58:20'),
(63, 17, '2025-11-19', 0, 0, 0, '2025-11-18 23:06:59', '2025-11-19 00:51:23'),
(64, 18, '2025-11-19', 14, 0, 14, '2025-11-18 23:06:59', '2025-11-19 00:57:19'),
(65, 19, '2025-11-19', 14, 0, 14, '2025-11-18 23:06:59', '2025-11-19 00:55:23'),
(66, 20, '2025-11-19', 14, 0, 14, '2025-11-18 23:06:59', '2025-11-19 00:52:53'),
(67, 21, '2025-11-19', 14, 0, 14, '2025-11-18 23:06:59', '2025-11-19 01:01:52'),
(68, 22, '2025-11-19', 14, 0, 14, '2025-11-18 23:06:59', '2025-11-19 00:51:34'),
(69, 23, '2025-11-19', 14, 0, 14, '2025-11-18 23:06:59', '2025-11-19 00:54:07'),
(70, 24, '2025-11-19', 14, 0, 14, '2025-11-18 23:06:59', '2025-11-19 00:50:00'),
(71, 25, '2025-11-19', 14, 0, 14, '2025-11-18 23:06:59', '2025-11-19 00:59:31'),
(72, 26, '2025-11-19', 14, 0, 14, '2025-11-18 23:06:59', '2025-11-19 00:57:47'),
(73, 27, '2025-11-19', 14, 0, 14, '2025-11-18 23:06:59', '2025-11-19 00:59:19'),
(74, 28, '2025-11-19', 14, 0, 14, '2025-11-18 23:06:59', '2025-11-19 00:49:05'),
(75, 29, '2025-11-19', 14, 0, 14, '2025-11-18 23:06:59', '2025-11-19 00:56:56'),
(76, 30, '2025-11-19', 14, 0, 14, '2025-11-18 23:06:59', '2025-11-19 00:55:05'),
(77, 31, '2025-11-19', 14, 0, 14, '2025-11-18 23:06:59', '2025-11-19 00:53:37'),
(78, 32, '2025-11-19', 14, 0, 14, '2025-11-18 23:06:59', '2025-11-19 00:50:21'),
(79, 33, '2025-11-19', 0, 0, 0, '2025-11-18 23:06:59', '2025-11-19 00:53:54'),
(80, 34, '2025-11-19', 14, 0, 14, '2025-11-18 23:06:59', '2025-11-19 00:53:08'),
(81, 35, '2025-11-19', 14, 0, 14, '2025-11-18 23:06:59', '2025-11-19 00:58:57'),
(82, 36, '2025-11-19', 14, 0, 14, '2025-11-18 23:06:59', '2025-11-19 00:54:40'),
(83, 37, '2025-11-19', 0, 0, 0, '2025-11-18 23:06:59', '2025-11-18 23:06:59'),
(84, 38, '2025-11-19', 0, 0, 0, '2025-11-18 23:06:59', '2025-11-18 23:06:59'),
(85, 39, '2025-11-19', 14, 0, 14, '2025-11-18 23:06:59', '2025-11-19 00:56:02'),
(86, 40, '2025-11-19', 0, 0, 0, '2025-11-18 23:06:59', '2025-11-18 23:06:59'),
(87, 41, '2025-11-19', 14, 0, 14, '2025-11-18 23:06:59', '2025-11-19 00:59:05'),
(88, 42, '2025-11-19', 14, 0, 14, '2025-11-18 23:06:59', '2025-11-19 00:49:33'),
(89, 43, '2025-11-19', 14, 0, 14, '2025-11-18 23:06:59', '2025-11-19 00:50:14'),
(90, 44, '2025-11-19', 14, 0, 14, '2025-11-18 23:06:59', '2025-11-19 00:59:47'),
(91, 45, '2025-11-19', 14, 0, 14, '2025-11-18 23:06:59', '2025-11-19 00:53:30'),
(92, 46, '2025-11-19', 0, 0, 0, '2025-11-18 23:06:59', '2025-11-18 23:06:59'),
(93, 47, '2025-11-19', 14, 0, 14, '2025-11-18 23:06:59', '2025-11-19 00:53:18'),
(94, 48, '2025-11-19', 14, 0, 14, '2025-11-18 23:06:59', '2025-11-18 23:06:59'),
(95, 49, '2025-11-19', 0, 0, 0, '2025-11-18 23:06:59', '2025-11-18 23:06:59'),
(96, 50, '2025-11-19', 0, 0, 0, '2025-11-18 23:06:59', '2025-11-18 23:06:59'),
(97, 51, '2025-11-19', 0, 0, 0, '2025-11-18 23:06:59', '2025-11-18 23:06:59'),
(98, 52, '2025-11-19', 14, 0, 14, '2025-11-18 23:06:59', '2025-11-19 00:50:34'),
(99, 53, '2025-11-19', 14, 0, 14, '2025-11-18 23:06:59', '2025-11-19 00:49:15'),
(100, 55, '2025-11-19', 0, 0, 0, '2025-11-18 23:06:59', '2025-11-18 23:06:59'),
(101, 56, '2025-11-19', 0, 0, 0, '2025-11-18 23:06:59', '2025-11-18 23:06:59'),
(102, 66, '2025-11-19', 14, 0, 14, '2025-11-18 23:06:59', '2025-11-19 00:55:32'),
(103, 67, '2025-11-19', 14, 0, 14, '2025-11-18 23:06:59', '2025-11-19 00:56:12'),
(104, 68, '2025-11-19', 14, 0, 14, '2025-11-18 23:06:59', '2025-11-19 00:55:42'),
(105, 69, '2025-11-19', 14, 0, 14, '2025-11-18 23:06:59', '2025-11-19 00:56:36'),
(106, 70, '2025-11-19', 0, 0, 0, '2025-11-18 23:06:59', '2025-11-18 23:06:59'),
(107, 71, '2025-11-19', 14, 0, 14, '2025-11-18 23:06:59', '2025-11-19 00:57:27'),
(108, 72, '2025-11-19', 14, 0, 14, '2025-11-18 23:06:59', '2025-11-19 00:57:07'),
(109, 73, '2025-11-19', 14, 0, 14, '2025-11-18 23:06:59', '2025-11-19 00:50:42'),
(110, 74, '2025-11-19', 14, 0, 14, '2025-11-18 23:06:59', '2025-11-19 00:50:53'),
(111, 75, '2025-11-19', 14, 0, 14, '2025-11-18 23:06:59', '2025-11-19 00:58:00'),
(112, 76, '2025-11-19', 14, 0, 14, '2025-11-18 23:06:59', '2025-11-19 00:49:26'),
(113, 77, '2025-11-19', 14, 0, 14, '2025-11-18 23:06:59', '2025-11-19 00:57:35'),
(114, 78, '2025-11-19', 14, 0, 14, '2025-11-18 23:06:59', '2025-11-19 07:29:49'),
(115, 79, '2025-11-19', 14, 0, 14, '2025-11-18 23:06:59', '2025-11-19 00:54:15'),
(116, 80, '2025-11-19', 14, 0, 14, '2025-11-18 23:06:59', '2025-11-19 00:56:45'),
(117, 81, '2025-11-19', 0, 0, 0, '2025-11-18 23:06:59', '2025-11-19 00:56:24'),
(118, 82, '2025-11-19', 14, 0, 14, '2025-11-18 23:06:59', '2025-11-19 00:55:52'),
(119, 83, '2025-11-19', 0, 0, 0, '2025-11-18 23:06:59', '2025-11-18 23:06:59'),
(120, 84, '2025-11-19', 14, 0, 14, '2025-11-18 23:06:59', '2025-11-19 01:02:47'),
(121, 85, '2025-11-19', 14, 0, 14, '2025-11-18 23:06:59', '2025-11-19 01:03:01'),
(122, 86, '2025-11-19', 14, 0, 14, '2025-11-18 23:06:59', '2025-11-19 00:58:45'),
(123, 87, '2025-11-19', 14, 0, 14, '2025-11-18 23:06:59', '2025-11-19 01:03:16'),
(124, 88, '2025-11-19', 14, 0, 14, '2025-11-18 23:06:59', '2025-11-19 01:02:02'),
(125, 89, '2025-11-19', 0, 0, 0, '2025-11-18 23:06:59', '2025-11-19 00:51:13'),
(126, 90, '2025-11-19', 14, 0, 14, '2025-11-18 23:06:59', '2025-11-19 00:51:03'),
(127, 91, '2025-11-19', 14, 0, 14, '2025-11-18 23:06:59', '2025-11-19 00:58:37'),
(128, 92, '2025-11-19', 14, 0, 14, '2025-11-18 23:06:59', '2025-11-18 23:06:59'),
(129, 93, '2025-11-19', 14, 0, 14, '2025-11-18 23:06:59', '2025-11-19 00:58:07');

-- --------------------------------------------------------

--
-- Table structure for table `tb_detailpes`
--

CREATE TABLE `tb_detailpes` (
  `id_detail` int(11) NOT NULL,
  `id_pesanan` varchar(255) NOT NULL,
  `id` int(11) NOT NULL,
  `nama_produk` varchar(255) NOT NULL,
  `jumlah` int(10) NOT NULL,
  `harga` decimal(10,0) NOT NULL,
  `subtotal` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_detailpes`
--

INSERT INTO `tb_detailpes` (`id_detail`, `id_pesanan`, `id`, `nama_produk`, `jumlah`, `harga`, `subtotal`) VALUES
(1, 'P0002', 66, 'Donat Bomboloni', 2, 7000, 14000),
(2, 'P0005', 44, 'Rainbow Cake', 1, 160000, 160000),
(3, 'P0005', 32, 'Red Velvet Cookies', 2, 13000, 26000),
(4, 'P0005', 67, 'Donat Oreo', 1, 6000, 6000),
(5, 'P0005', 78, ' Meringue', 1, 10000, 10000),
(6, 'P0005', 77, 'Madeleine', 1, 15000, 15000),
(7, 'P0005', 87, 'Roti Isi Abon', 1, 13000, 13000),
(8, 'P0006', 4, 'Cappucino Bread', 1, 7000, 7000),
(9, 'P0006', 9, 'Croissant', 2, 35000, 70000),
(10, 'P0006', 67, 'Donat Oreo', 3, 6000, 18000),
(11, 'P0006', 32, 'Red Velvet Cookies', 1, 13000, 13000),
(12, 'P0006', 11, 'Brownies Panggang', 1, 25000, 25000),
(13, 'P0007', 51, 'Pain au Chocolat', 2, 22000, 44000),
(14, 'P0008', 52, 'Strawberry Cream Cheese Puff', 2, 21500, 43000),
(16, 'P0013', 25, 'Oatmeal Raisin Cookies', 2, 11000, 22000),
(17, 'P0015', 11, 'Brownies Panggang', 1, 25000, 25000),
(18, 'P0015', 25, 'Oatmeal Raisin Cookies', 2, 11000, 22000),
(19, 'P0016', 41, 'Red Velvet Cake', 1, 200000, 200000),
(20, 'P0018', 7, 'Brioche ', 2, 21000, 42000),
(21, 'P0018', 36, 'Cinnamon Sugar Cookies ', 3, 11000, 33000),
(22, 'P0019', 51, 'Pain au Chocolat', 2, 22000, 44000),
(23, 'P0019', 69, 'Donat Tiramisu', 2, 7000, 14000),
(24, 'P0020', 41, 'Red Velvet Cake', 1, 200000, 200000),
(27, 'P0023', 41, 'Red Velvet Cake', 1, 200000, 200000),
(28, 'P0025', 51, 'Pain au Chocolat', 1, 22000, 22000),
(29, 'P0025', 80, 'Donat Ubi', 2, 4000, 8000),
(30, 'P0025', 30, 'Cornflakes Cookies', 2, 10000, 20000),
(31, 'P0025', 83, 'Roti Tawar Putih', 3, 13000, 39000),
(32, 'P0025', 45, 'Cheese Cake', 1, 175000, 175000),
(33, 'P0025', 79, 'Choux Pastry', 3, 10000, 30000),
(34, 'P0026', 78, ' Meringue', 3, 10000, 30000),
(35, 'P0027', 12, 'Cheese cream Cake', 2, 45000, 90000),
(36, 'P0027', 78, ' Meringue', 2, 10000, 20000),
(37, 'P0027', 5, 'Choco Beetle', 1, 7000, 7000),
(38, 'P0027', 17, 'Roti Sobek', 1, 16000, 16000),
(39, 'P0027', 34, 'Caramel Cashew Cookies', 1, 10000, 10000),
(40, 'P0027', 80, 'Donat Ubi', 1, 4000, 4000),
(41, 'P0027', 72, 'Flaky Pastry', 1, 20000, 20000),
(42, 'P0027', 93, 'Roti Bakar', 1, 17500, 17500),
(43, 'P0027', 47, 'Carrot Cake', 1, 178000, 178000),
(44, 'P0027', 82, 'Donat Crispy', 2, 5000, 10000),
(45, 'P0028', 25, 'Oatmeal Raisin Cookies', 1, 11000, 11000),
(46, 'P0028', 71, 'Kouign Amann', 1, 18000, 18000),
(47, 'P0028', 34, 'Caramel Cashew Cookies', 1, 10000, 10000),
(48, 'P0029', 81, 'Donat Tape', 1, 4000, 4000),
(49, 'P0029', 18, 'Focaccia', 1, 22000, 22000),
(50, 'P0029', 48, 'Strawberry Shortcake', 1, 1880000, 1880000),
(51, 'P0029', 69, 'Donat Tiramisu', 3, 7000, 21000),
(52, 'P0030', 67, 'Donat Oreo', 2, 6000, 12000),
(53, 'P0030', 29, 'Double Chocolate Cookies', 1, 13000, 13000),
(54, 'P0030', 11, 'Brownies Panggang', 1, 25000, 25000),
(55, 'P0030', 77, 'Madeleine', 3, 15000, 45000),
(56, 'P0031', 5, 'Choco Beetle', 2, 7000, 14000),
(57, 'P0031', 74, 'Rough Puff Pastry', 2, 20000, 40000),
(58, 'P0031', 68, 'Donat Bomboloni Keju', 2, 6000, 12000),
(59, 'P0031', 45, 'Cheese Cake', 1, 175000, 175000),
(60, 'P0032', 15, 'Classic Opera', 1, 120000, 120000),
(61, 'P0032', 27, 'Matcha Cookies', 1, 13000, 13000),
(62, 'P0032', 24, 'Butter Cookies', 1, 8000, 8000),
(63, 'P0032', 34, 'Caramel Cashew Cookies', 1, 10000, 10000),
(64, 'P0032', 80, 'Donat Ubi', 1, 4000, 4000),
(65, 'P0032', 81, 'Donat Tape', 2, 4000, 8000),
(66, 'P0032', 71, 'Kouign Amann', 1, 18000, 18000),
(67, 'P0032', 78, ' Meringue', 1, 10000, 10000),
(68, 'P0032', 79, 'Choux Pastry', 2, 10000, 20000),
(69, 'P0032', 87, 'Roti Isi Abon', 1, 13000, 13000),
(70, 'P0032', 10, 'Roti Bagel', 1, 17000, 17000),
(71, 'P0034', 7, 'Brioche ', 1, 21000, 21000),
(72, 'P0034', 29, 'Double Chocolate Cookies', 1, 13000, 13000),
(73, 'P0035', 13, 'Coco Cake', 1, 59000, 59000),
(74, 'P0035', 67, 'Donat Oreo', 1, 6000, 6000),
(75, 'P0035', 25, 'Oatmeal Raisin Cookies', 1, 11000, 11000),
(76, 'P0037', 76, 'Beignet', 1, 15000, 15000),
(77, 'P0037', 24, 'Butter Cookies', 1, 8000, 8000),
(78, 'P0037', 41, 'Red Velvet Cake', 1, 200000, 200000),
(82, 'P0040', 66, 'Donat Bomboloni', 1, 7000, 7000),
(83, 'P0040', 30, 'Cornflakes Cookies', 1, 10000, 10000);

-- --------------------------------------------------------

--
-- Table structure for table `tb_pembayaran`
--

CREATE TABLE `tb_pembayaran` (
  `id_pesanan` varchar(50) NOT NULL,
  `metode_pembayaran` enum('Tunai') NOT NULL,
  `jumlah_bayar` decimal(10,0) NOT NULL,
  `kembalian` decimal(10,0) NOT NULL,
  `status_pembayaran` enum('Belum Dibayar','Lunas','Dibatalkan') NOT NULL,
  `tanggal_pembayaran` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_pembayaran`
--

INSERT INTO `tb_pembayaran` (`id_pesanan`, `metode_pembayaran`, `jumlah_bayar`, `kembalian`, `status_pembayaran`, `tanggal_pembayaran`) VALUES
('P0002', 'Tunai', 20000, 6000, 'Lunas', '2025-10-26 11:12:43'),
('P0005', 'Tunai', 250000, 20000, 'Lunas', '2025-10-28 06:37:01'),
('P0006', 'Tunai', 200000, 67000, 'Lunas', '2025-11-05 12:28:34'),
('P0007', 'Tunai', 50000, 6000, 'Lunas', '2025-11-05 12:39:34'),
('P0008', 'Tunai', 50000, 7000, 'Lunas', '2025-11-05 12:44:28'),
('P0013', 'Tunai', 25000, 3000, 'Lunas', '2025-11-07 01:14:09'),
('P0015', 'Tunai', 100000, 53000, 'Lunas', '2025-11-09 12:42:01'),
('P0016', 'Tunai', 200000, 0, 'Lunas', '2025-11-09 12:50:12'),
('P0018', 'Tunai', 100000, 25000, 'Lunas', '2025-11-09 13:56:12'),
('P0019', 'Tunai', 100000, 42000, 'Lunas', '2025-11-09 14:30:07'),
('P0020', 'Tunai', 200000, 0, 'Lunas', '2025-11-10 06:55:24'),
('P0023', 'Tunai', 200000, 0, 'Lunas', '2025-11-16 21:15:04'),
('P0025', 'Tunai', 300000, 6000, 'Lunas', '2025-11-16 21:15:50'),
('P0026', 'Tunai', 50000, 20000, 'Lunas', '2025-11-16 21:25:21'),
('P0027', 'Tunai', 400000, 27500, 'Lunas', '2025-11-16 21:25:39'),
('P0028', 'Tunai', 50000, 11000, 'Lunas', '2025-11-17 10:48:33'),
('P0029', 'Tunai', 1950000, 23000, 'Lunas', '2025-11-17 11:31:55'),
('P0030', 'Tunai', 100000, 5000, 'Lunas', '2025-11-17 11:32:16'),
('P0031', 'Tunai', 250000, 9000, 'Lunas', '2025-11-17 11:32:43'),
('P0032', 'Tunai', 250000, 9000, 'Lunas', '2025-11-17 11:36:18'),
('P0034', 'Tunai', 50000, 16000, 'Lunas', '2025-11-19 01:18:49'),
('P0035', 'Tunai', 80000, 4000, 'Lunas', '2025-11-19 01:29:22'),
('P0040', 'Tunai', 20000, 3000, 'Lunas', '2025-11-19 07:23:35');

-- --------------------------------------------------------

--
-- Table structure for table `tb_penarikan`
--

CREATE TABLE `tb_penarikan` (
  `id_penarikan` int(11) NOT NULL,
  `tanggal_penarikan` datetime DEFAULT current_timestamp(),
  `jumlah_penarikan` decimal(15,2) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `id` int(11) DEFAULT NULL,
  `username` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_penarikan`
--

INSERT INTO `tb_penarikan` (`id_penarikan`, `tanggal_penarikan`, `jumlah_penarikan`, `keterangan`, `id`, `username`) VALUES
(5, '2025-11-19 09:33:14', 72000.00, 'Bayar listrik', 2, ''),
(6, '2025-11-19 14:27:28', 700000.00, 'Bahan Baku', 2, '');

-- --------------------------------------------------------

--
-- Table structure for table `tb_pesanan`
--

CREATE TABLE `tb_pesanan` (
  `id_pesanan` varchar(10) NOT NULL,
  `no_antrian` int(11) NOT NULL,
  `nama_pelanggan` varchar(50) NOT NULL,
  `nama_produk` varchar(255) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `total_harga` decimal(10,0) NOT NULL,
  `metode_pembayaran` varchar(50) NOT NULL,
  `qr_path` varchar(255) DEFAULT NULL,
  `status_pesanan` enum('Pending','Lunas') NOT NULL,
  `tanggal_pemesanan` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_pesanan`
--

INSERT INTO `tb_pesanan` (`id_pesanan`, `no_antrian`, `nama_pelanggan`, `nama_produk`, `jumlah`, `total_harga`, `metode_pembayaran`, `qr_path`, `status_pesanan`, `tanggal_pemesanan`) VALUES
('P0002', 2, 'Suci Alfia', 'Donat Bomboloni', 2, 14000, 'Tunai', 'qrcodes/qr_P0002.png', 'Lunas', '2025-10-26 11:09:50'),
('P0005', 5, 'Arrohmah', 'Rainbow Cake, Red Velvet Cookies, Donat Oreo,  Meringue, Madeleine, Roti Isi Abon', 7, 230000, 'Tunai', 'qrcodes/qr_P0005.png', 'Lunas', '2025-10-28 07:34:02'),
('P0006', 6, 'Aro', 'Cappucino Bread, Croissant, Donat Oreo, Red Velvet Cookies, Brownies Panggang', 8, 133000, 'Tunai', 'qrcodes/qr_P0006.png', 'Lunas', '2025-11-05 13:26:53'),
('P0007', 7, 'ciko', 'Pain au Chocolat', 2, 44000, 'Tunai', 'qrcodes/qr_P0007.png', 'Lunas', '2025-11-05 13:39:15'),
('P0008', 8, 'Dela', 'Strawberry Cream Cheese Puff', 2, 43000, 'Tunai', 'qrcodes/qr_P0008.png', 'Lunas', '2025-11-05 13:42:40'),
('P0013', 13, 'Anis', 'Oatmeal Raisin Cookies', 2, 22000, 'Tunai', 'qrcodes/qr_P0013.png', 'Lunas', '2025-11-07 01:49:33'),
('P0015', 15, 'Putri', 'Brownies Panggang, Oatmeal Raisin Cookies', 3, 47000, 'Tunai', 'qrcodes/qr_P0015.png', 'Lunas', '2025-11-08 11:51:34'),
('P0016', 16, 'Bima', 'Red Velvet Cake', 1, 200000, 'Tunai', 'qrcodes/qr_P0016.png', 'Lunas', '2025-11-08 14:59:35'),
('P0018', 18, 'Dimas', 'Brioche , Cinnamon Sugar Cookies', 5, 75000, 'Tunai', 'qrcodes/qr_P0018.png', 'Lunas', '2025-11-09 14:55:27'),
('P0019', 19, 'anton', 'Pain au Chocolat, Donat Tiramisu', 4, 58000, 'Tunai', 'qrcodes/qr_P0019.png', 'Lunas', '2025-11-09 15:29:48'),
('P0020', 20, 'Dewi', 'Red Velvet Cake', 1, 200000, 'Tunai', 'qrcodes/qr_P0020.png', 'Lunas', '2025-11-10 03:30:41'),
('P0023', 23, 'Bima', 'Red Velvet Cake', 1, 200000, 'Tunai', 'qrcodes/qr_P0023.png', 'Lunas', '2025-11-15 06:40:21'),
('P0025', 25, 'Asti', 'Pain au Chocolat, Donat Ubi, Cornflakes Cookies, Roti Tawar Putih, Cheese Cake, Choux Pastry', 12, 294000, 'Tunai', 'qrcodes/qr_P0025.png', 'Lunas', '2025-11-16 22:14:33'),
('P0026', 26, 'Nona', ' Meringue', 3, 30000, 'Tunai', 'qrcodes/qr_P0026.png', 'Lunas', '2025-11-16 22:17:31'),
('P0027', 27, 'Antonio', 'Cheese cream Cake,  Meringue, Choco Beetle, Roti Sobek, Caramel Cashew Cookies, Donat Ubi, Flaky Pastry, Roti Bakar, Carrot Cake, Donat Crispy', 13, 372500, 'Tunai', 'qrcodes/qr_P0027.png', 'Lunas', '2025-11-16 22:24:02'),
('P0028', 28, 'Mita', 'Oatmeal Raisin Cookies, Kouign Amann, Caramel Cashew Cookies', 3, 39000, 'Tunai', 'qrcodes/qr_P0028.png', 'Lunas', '2025-11-17 11:48:10'),
('P0029', 29, 'Fajri', 'Donat Tape, Focaccia, Strawberry Shortcake, Donat Tiramisu', 6, 1927000, 'Tunai', 'qrcodes/qr_P0029.png', 'Lunas', '2025-11-17 12:28:36'),
('P0030', 30, 'Marsha', 'Donat Oreo, Double Chocolate Cookies, Brownies Panggang, Madeleine', 7, 95000, 'Tunai', 'qrcodes/qr_P0030.png', 'Lunas', '2025-11-17 12:29:36'),
('P0031', 31, 'Hana', 'Choco Beetle, Rough Puff Pastry, Donat Bomboloni Keju, Cheese Cake', 7, 241000, 'Tunai', 'qrcodes/qr_P0031.png', 'Lunas', '2025-11-17 12:30:25'),
('P0032', 32, 'Ica', 'Classic Opera, Matcha Cookies, Butter Cookies, Caramel Cashew Cookies, Donat Ubi, Donat Tape, Kouign Amann,  Meringue, Choux Pastry, Roti Isi Abon, Roti Bagel', 13, 241000, 'Tunai', 'qrcodes/qr_P0032.png', 'Lunas', '2025-11-17 12:35:57'),
('P0034', 34, 'Dani', 'Brioche , Double Chocolate Cookies', 2, 34000, 'Tunai', 'qrcodes/qr_P0034.png', 'Lunas', '2025-11-19 02:17:45'),
('P0035', 35, 'sasa', 'Coco Cake, Donat Oreo, Oatmeal Raisin Cookies', 3, 76000, 'Tunai', 'qrcodes/qr_P0035.png', 'Lunas', '2025-11-19 02:27:37'),
('P0037', 37, 'Intan', 'Beignet, Butter Cookies, Red Velvet Cake', 3, 223000, 'Tunai', NULL, 'Pending', '2025-11-19 03:19:07'),
('P0040', 40, 'firda', 'Donat Bomboloni, Cornflakes Cookies', 2, 17000, 'Tunai', 'qrcodes/qr_P0040.png', 'Lunas', '2025-11-19 08:22:03');

-- --------------------------------------------------------

--
-- Table structure for table `tb_produk`
--

CREATE TABLE `tb_produk` (
  `id` int(11) NOT NULL,
  `nama_produk` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `harga` decimal(10,0) NOT NULL,
  `stok` int(11) NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `kategori` varchar(100) NOT NULL,
  `crated_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_produk`
--

INSERT INTO `tb_produk` (`id`, `nama_produk`, `deskripsi`, `harga`, `stok`, `gambar`, `kategori`, `crated_at`) VALUES
(1, 'Roti Coklat Keju', 'Roti dengan isian coklat dan keju yang lembut, cocok untuk sarapan atau cemilan.', 15000, 14, 'Roti Coklat Keju.jpg', 'Roti', '2025-11-19 00:58:51.561701'),
(2, 'Roti Manis Kismis', 'Roti manis dengan tambahan kismis di atasnya, memberikan rasa manis yang pas.', 18000, 14, 'Roti Manis Kismis.jpg', 'Roti', '2025-11-19 03:56:08.432019'),
(4, 'Cappucino Bread', 'Roti yang lembut dan aroma khas kopi dengan dipadukan cream mocha di atasnya.', 7000, 14, 'Cappucino Bread.jpg', 'Roti', '2025-11-19 00:50:06.896445'),
(5, 'Choco Beetle', 'Roti yang lembut dengan toping kacang yang gurih.', 7000, 0, 'Choco Beetle.jpg', 'Roti', '2025-11-19 00:53:45.563160'),
(7, 'Brioche ', 'Brioche adalah roti lembut, sedikit manis, dan kaya rasa yang berasal dari Prancis. Brioche memiliki kulit gelap, emas, dan rapuh.', 21000, 13, 'Brioche.jpg', 'Roti', '2025-11-19 01:17:45.612492'),
(8, 'Ciabatta', 'Roti ciabatta adalah jenis roti asal Itali yang memiliki ciri khas kulit yang renyah, bagian dalam yang lembut dan salah satu roti yang populer dan memiliki karakteristik yang unik.', 17000, 14, 'Ciabatta.jpg', 'Roti', '2025-11-19 00:54:23.805650'),
(9, 'Croissant', 'Roti croissant adalah kue kering yang berbentuk bulan sabit dan memiliki tekstur berlapis. Croissant terkenal karena rasa gurih dan renyah diluar, serta lembut didalam.', 35000, 14, 'Croissant.jpg', 'pastry', '2025-11-19 00:55:14.490766'),
(10, 'Roti Bagel', 'Roti bagel memiliki tekstur padat dan kenyal didalam, serta kulit luarnya yang garing dan berwarna coklat muda.', 17000, 14, 'Bagel.jpg', 'Roti', '2025-11-19 00:58:27.354036'),
(11, 'Brownies Panggang', 'Brownies adalah kue coklat yang dipanggang dengan oven dan memiliki tekstur yang lembut didalam dan garing diluar.', 25000, 14, 'Brownies.jpg', 'cake', '2025-11-19 00:49:48.001341'),
(12, 'Cheese cream Cake', 'Empuknya cake dipadu dengan gurihnya keju dipadu dengan lembutnya cream. ', 45000, 0, 'Cheese Cream Cake.jpg', 'cake', '2025-11-18 22:10:40.322790'),
(13, 'Coco Cake', 'Coco Cake hadir dengan ragam olahan cokelat yang melimpah. Lapisan buttercream coklat menyelimuti kelembutan kue spons cokelat yang moist di mulut.', 59000, 13, 'Coco Cake.jpeg', 'cake', '2025-11-19 07:23:05.860376'),
(14, 'Roti Canai', 'Roti canai adalah roti pipih yang berlapis-lapis, lembut didalam, dan renyah diluar. Roti canai merupakan makanan khas Malaysia yang populer.', 15000, 14, 'Canai.jpeg', 'Roti', '2025-11-19 00:59:57.901314'),
(15, 'Classic Opera', 'Classic opera adalah kue bolu almond yang rumit dengan isian dan lapisan gula kopi dan cokelat.', 120000, 14, 'Opera.jpeg', 'cake', '2025-11-19 00:54:32.664039'),
(16, 'Mango Cheesecake', 'Mango cheesecake adalah cheesecake yang dicampur dengan buah mangga segar ini diberi lapisan cookies crumble homemade dibagian pinggirnya.', 56000, 14, 'Mango Cheesecake.jpeg', 'cake', '2025-11-19 00:58:20.318864'),
(17, 'Roti Sobek', 'Roti lembut berbentuk potongan yang bisa disobek, biasanya polos.', 16000, 0, 'Sobek.jpeg', 'Roti', '2025-11-19 00:51:23.389160'),
(18, 'Focaccia', 'Roti datar khas Italia dengan toping minyak zaitun dan rempah.', 22000, 14, 'Focaccia.jpeg', 'Roti', '2025-11-19 00:57:19.182357'),
(19, 'Donat', 'Satu kotak berisi 6 donat lembut dengan beragam topping.', 25000, 14, 'Donat.jpeg', 'Donut', '2025-11-19 00:55:23.235823'),
(20, 'Roti Kukus Thailand', 'Roti kukus Thailand adalah kudapan yang memiliki tektur yang lembut dan empuk, disajikan dalam keadaan hangat dengan berbagai macam topping manis dan gurih.', 32000, 14, 'Roti Kukus.jpg', 'Roti', '2025-11-19 00:52:53.782025'),
(21, 'Roti Gambang', 'Roti gambang adalah roti berwarna coklat dengan teksturnya agak padat. Terus, beraroma rempah, seperti kayu manis, biji pala.', 15000, 14, 'Gambang.jpg', 'Roti', '2025-11-19 01:01:52.221995'),
(22, 'Roti Pumperckel', 'Roti pumpernickel adalah roti tradisional jepang yang terbuat dari tepung gamdum hitam yang digiling kasar. Roti ini memiliki tekstur padat dan kasar berwarna coklat tua, dan terkadang hampir hitam.', 35000, 14, 'Roti Pumpernickel.jpg', 'Roti', '2025-11-19 00:51:34.788838'),
(23, 'Chocolate Chip Cookies', 'Cookies klasik dengan potongan cokelat hitam yang meleleh di mulut.', 9000, 14, 'Chocolate Chip Cookies.jpeg', 'Cookies', '2025-11-19 00:54:07.162817'),
(24, 'Butter Cookies', 'Kue kering renyah berbahan dasar mentega premium dengan rasa lembut.', 8000, 13, 'Butter Cookies.jpeg', 'Cookies', '2025-11-19 02:19:07.216721'),
(25, 'Oatmeal Raisin Cookies', 'Perpaduan gamdum utuh dan kismis manis, cocok untuk cemilan sehat.', 11000, 13, 'Oatmeal Raisin Cookies.jpeg', 'Cookies', '2025-11-19 01:27:37.712099'),
(26, 'Peanut Butter Cookies', 'Cookies gurih dan manis dengan rasa khas selai kacang.', 11000, 14, 'Panut Butter Cookies.jpeg', 'Cookies', '2025-11-19 00:57:47.871226'),
(27, 'Matcha Cookies', 'Cookies dengan rasa matcha Jepang yang khas dan aroma teh hijau.', 13000, 14, 'Matcha Cookies.jpeg', 'Cookies', '2025-11-19 00:59:19.520558'),
(28, 'Almond Crunch Cookies', 'Kue kering dengan taburan kacang almond renyah di setiap gigitan.', 14000, 14, 'Almong Crunch Cookies.jpeg', 'Cookies', '2025-11-19 00:49:05.114347'),
(29, 'Double Chocolate Cookies', 'Cookies coklat dengan tambahan choco chip ekstra untuk pecinta coklat.', 13000, 13, 'Double Chocotate Cookies.jpeg', 'Cookies', '2025-11-19 07:23:05.859601'),
(30, 'Cornflakes Cookies', 'Cookies renyah dilapisi cornflakes, cocok untuk teman teh atau kopi.', 10000, 13, 'Cornflakes Cookies.jpeg', 'Cookies', '2025-11-19 07:22:03.565279'),
(31, 'Cheese Cookies', 'Perpaduan rasa manis dan asin dari keju cheddar yang dipanggang renyah.', 9000, 14, 'Cheese Cookies.jpeg', 'Cookies', '2025-11-19 00:53:37.547911'),
(32, 'Red Velvet Cookies', 'Kue berwarna merah elegan dengan isian coklat putih di tengahnya.', 13000, 14, 'Red Velvet Cookies.jpeg', 'Cookies', '2025-11-19 00:50:21.462964'),
(33, 'Choco Mint Cookies', 'Cookies coklat dengan sensasi segar mint, cocok untuk pecinta rasa unik.', 13000, 0, 'Choco Mint Cookies.jpeg', 'Cookies', '2025-11-19 00:53:54.715453'),
(34, 'Caramel Cashew Cookies', 'Cookies manis dengan lapisan karamel dan kacang mete panggang.', 10000, 14, 'Caramel Cashew Cookies.jpeg', 'Cookies', '2025-11-19 00:53:08.568641'),
(35, 'Mocha Coffee Cookies', 'Kue kering beraroma kopi dengan sentuhan cokelat, pas untuk pecinta kopi.', 13000, 14, 'Mocha Coffee Cookies.jpeg', 'Cookies', '2025-11-19 00:58:57.849240'),
(36, 'Cinnamon Sugar Cookies ', 'Cookies renyah dengan taburan gula dan kayu manis yang harum dan manis.', 11000, 14, 'Cinnamon Sugar Cookies.jpg', 'Cookies', '2025-11-19 00:54:40.791504'),
(37, 'Rainbow Spinkle Cookies', 'Cookies warna-warni dengan topping sprinkle ceria, disukai anak-anak.', 12000, 0, 'Rainbow Sprinkle Cookies.jpeg', 'Cookies', '2025-10-20 15:01:54.435196'),
(38, 'Donat Cokelat Glaze', 'Donat empuk dengan lpisan coklat leleh di atasnya.', 6000, 0, 'Donat Coklat Glaze.jpeg', 'Donut', '2025-10-20 15:14:57.634396'),
(39, 'Donat Gula Halus', 'Donat klasik yang dilapisi gula halus, favorit sepanjang masa.', 4000, 14, 'Donat Gula Halus.jpeg', 'Donut', '2025-11-19 00:56:02.666903'),
(40, 'Chocolate Fudge Cake', 'Kue coklat lembut dengan lapisan fudge dan topping coklat leleh.', 180000, 0, 'Chocolate Fudge Cake.jpeg', 'Cake', '2025-11-18 22:11:38.471865'),
(41, 'Red Velvet Cake', 'Kue merah dengan cream cheese frosting, lembut dan manis.', 200000, 13, 'Red Velvet Cake.jpeg', 'Cake', '2025-11-19 02:19:07.217593'),
(42, 'Black Forest', 'Kue coklat dengan krim, ceri, dan taburan coklat parut.', 170000, 14, 'Black Forest.jpeg', 'Cake', '2025-11-19 00:49:33.991086'),
(43, 'Tiramisu Cake', 'Kue kopi da krim mascarpone berlapis, dilapisi cocoa powder.', 190000, 14, 'Tiramisu Cake.jpeg', 'Cake', '2025-11-19 00:50:14.362248'),
(44, 'Rainbow Cake', 'Kue berlapis warna-warni dengan krim vanila yang lembut.', 160000, 14, 'Rainbow Cake.jpeg', 'Cake', '2025-11-19 00:59:47.229920'),
(45, 'Cheese Cake', 'Kue keju creamy dengan dasar biskuit, bisa topping buah.', 175000, 14, 'Cheese Cake.jpg', 'Cake', '2025-11-19 00:53:30.187755'),
(46, 'Pandan Layer Cake', 'Kue lapis pandan dengan krim santan lembut khas Indonesia.', 160000, 0, 'Pandan Layer Cake.jpeg', 'Cake', '2025-09-01 03:19:23.673121'),
(47, 'Carrot Cake', 'Kue wortel dengan taburan kacang dan krim keju di atasnya.', 178000, 14, 'Carrot Cake.jpeg', 'Cake', '2025-11-19 00:53:18.270525'),
(48, 'Strawberry Shortcake', 'Kue vanila dengan whipped cream dan potongan stroberi segar.', 1880000, 14, 'Strawberry Short Cake.jpg', 'Cake', '2025-11-18 22:08:09.426953'),
(49, 'Mille Feuille', 'Lapis-lapis pastry renyah dengan krim vanila dan taburan gula halus.', 69000, 0, 'Mille Feuille.jpeg', 'pastry', '2025-09-01 03:21:09.305292'),
(50, 'Danish Blueberry', 'Roti lapis asal Prancis dengan tekstur renyah di luar dan lembut di dalam.', 20000, 0, 'DanishBlue.jpeg', 'Pastry', '2025-09-01 03:20:59.121466'),
(51, 'Pain au Chocolat', 'Pastry isi coklat batang khas prancis.', 22000, 0, 'Painau.jpeg', 'Pastry', '2025-11-16 21:14:33.643837'),
(52, 'Strawberry Cream Cheese Puff', 'Pastry berisi krim keju dan potongan stroberi segar.', 21500, 14, 'StrawberryCream.jpeg', 'Pastry', '2025-11-19 00:50:34.365528'),
(53, 'Apple Turnover', 'Pastry segitiga berisi apel manis dengan kayu manis dan gula.', 19000, 14, 'ApleTurnover.jpeg', 'Pastry', '2025-11-19 00:49:15.278034'),
(55, 'Cinnamon Roll', 'Roti gulung berisi kayu manis dan gula merah, diberi lapisan gula.', 18500, 0, 'CinnamonRoll.jpeg', 'Pastry', '2025-11-18 22:11:46.581677'),
(56, 'Lemon Tart', 'Tart kecil berisi custard lemon asam manis dengan crust renyah.', 20000, 0, 'LemonTart.jpeg', 'Pastry', '2025-09-01 03:21:19.123496'),
(66, 'Donat Bomboloni', 'Donat bomboloni dengan adonan lembut, diisi dengan selai cokelat leleh.', 7000, 13, 'Donat Bomboloni.jpeg', 'Donut', '2025-11-19 07:22:03.564443'),
(67, 'Donat Oreo', 'Donar dengan adonan rasa vanila, dilapisi dengan lapisan oreo dan taburan potongan oreo.', 6000, 13, 'Donat Oreo.jpeg', 'Donut', '2025-11-19 01:27:37.710971'),
(68, 'Donat Bomboloni Keju', 'Donat Bomboloni dengan adonan lembut, diisi dengan selai keju leleh.', 6000, 14, 'Donat Bomboloni Keju.jpeg', 'Donut', '2025-11-19 00:55:42.089778'),
(69, 'Donat Tiramisu', 'Donat dengan toping tiramisu dan taburan cokelat bubuk.', 7000, 14, 'Donat Tiramisu.jpeg', 'Donut', '2025-11-19 00:56:36.870963'),
(70, 'Pain Suisse ', 'Pastry asal Prancis ini serupa croissant, namun bisa diisi berbagai isian manis (cokelat, selai) atau asin (jamur).', 17000, 0, 'Pain Suisse.jpeg', 'Pastry', '2025-09-01 03:21:36.406492'),
(71, 'Kouign Amann', 'Pastry manis dan renyah asal Prancis, kaya mentega, dengan rasa manis yang khas.', 18000, 14, 'Kouign Amann.jpeg', 'Pastry', '2025-11-19 00:57:27.619429'),
(72, 'Flaky Pastry', 'Adonan pastry yang paling sederhana, mudah dibuat dan bisa diisi berbagai macam, cocok untuk eksperimen rasa.', 20000, 14, 'Flaky Pastry.jpeg', 'Pastry', '2025-11-19 00:57:07.635017'),
(73, 'Shortcrust Pastry', 'Adonan yang mudah dibuat dan tahan banting, sering digunakan untuk dasar pie atau tart.', 18000, 14, 'Shortcrust Pastry.jpeg', 'Pastry', '2025-11-19 00:50:42.890637'),
(74, 'Rough Puff Pastry', 'Perpaduan antara kue kering dan puff pastry, memberikan tekstur renyah dan gurih.', 20000, 14, 'Rough Puff Pastry.jpeg', 'Pastry', '2025-11-19 00:50:53.147939'),
(75, 'Phyllo Pastry', 'Pastry yang sangat tipis dan menyerupai kertas, bisa digunakan untuk berbagai macam hidangan, baik manis maupun asin.', 23000, 14, 'Phyllo Pastry.jpeg', 'Pastry', '2025-11-19 00:58:00.365047'),
(76, 'Beignet', 'Kue goreng lembut yang ditutupi gula halus, bisa disajikan dengan berbagai isian atau selai.', 15000, 13, 'Beignet.jpeg', 'Pastry', '2025-11-19 02:19:07.207317'),
(77, 'Madeleine', 'Kue sponge kecil yang khas dengan bentuk cangkang, cocok untuk hidangan penutup.', 15000, 14, 'Madeleine.jpeg', 'Pastry', '2025-11-19 00:57:35.191345'),
(78, ' Meringue', 'Kue kering yang dibuat dari putih telur dan gula, rasanya ringan dan manis.', 10000, 14, 'Meringue.jpeg', 'Pastry', '2025-11-19 07:29:49.561954'),
(79, 'Choux Pastry', 'Choux pastry adalah salah satu jenis pastry yang sudah sering kita jumpai dengan nama kue sus.', 10000, 14, 'Choux Pastry.jpeg', 'Pastry', '2025-11-19 07:23:05.837881'),
(80, 'Donat Ubi', 'Donat yang menggunakan adonan ubi ungu atau jala, memberikan rasa manis yang khas.', 4000, 14, 'Donat Ubi.jpeg', 'Donut', '2025-11-19 00:56:45.260899'),
(81, 'Donat Tape', 'Donat Tape dengan bahan berkualitas dan tentunya dengan tambahan tape yang bikin lembut sekali saat di gigit.', 4000, 0, 'Donat Tape.jpeg', 'Donut', '2025-11-19 00:56:24.776867'),
(82, 'Donat Crispy', 'Donat crispy adalah jenis donat yang memiliki tekstur renyah pada bagian luarnya, berbeda dengan donat biasa yang lebih lembut.', 5000, 14, 'Donat Crispy.jpeg', 'Donut', '2025-11-19 00:55:52.234763'),
(83, 'Roti Tawar Putih', 'Roti dasar yang banyak disukai, cocok untuk sandwich atau dioleskan selai.', 13000, 0, 'Roti Tawar.jpeg', 'Roti', '2025-11-18 22:12:28.556229'),
(84, 'Roti Gandum', 'Roti gandum lebih kaya serat dan gizi, cocok untuk sarapan sehat.', 13000, 14, 'Roti Gandum.jpeg', 'Roti', '2025-11-19 01:02:47.139567'),
(85, 'Roti Isi Cokelat', 'Roti lembut dengan isian cokelat leleh yang manis. ', 10000, 14, 'Roti Isi Coklat.jpeg', 'Roti', '2025-11-19 01:03:01.311451'),
(86, 'Roti Isi Keju', ' Roti dengan isian keju yang gurih dan lezat.', 12000, 14, 'Roti Isi Keju.jpeg', 'Roti', '2025-11-19 00:58:45.229757'),
(87, 'Roti Isi Abon', 'Roti dengan isian abon sapi yang gurih dan asin.', 13000, 14, 'Roti Isi Abon.jpeg', 'Roti', '2025-11-19 01:03:16.070487'),
(88, 'Roti Isi Kacang', ' Roti dengan isian kacang yang manis dan renyah. ', 12000, 14, 'Roti Isi Kacang.jpeg', 'Roti', '2025-11-19 01:02:02.486144'),
(89, 'Roti Srikaya', 'Roti manis dengan isian srikaya khas.', 21000, 0, 'Roti Srikaya.jpeg', 'Roti', '2025-11-19 00:51:13.788366'),
(90, 'Roti Susu', 'Roti yang empuk dan lembut, cocok untuk sarapan atau camilan. ', 12000, 14, 'Roti Susu.jpeg', 'Roti', '2025-11-19 00:51:03.537293'),
(91, 'Roti Isi Pisang', 'Roti dengan isian pisang yang manis dan lembut.', 14000, 14, 'Roti Isi Pisang.jpeg', 'Roti', '2025-11-19 00:58:37.585404'),
(92, 'Roti Isi Singkong', 'Roti dengan isian singkong yang manis dan gurih.', 13000, 14, 'Roti Isi Singkong.jpeg', 'Roti', '2025-10-23 05:38:22.654628'),
(93, 'Roti Bakar', 'Roti yang dipanggang dengan topping cokelat meleleh.', 17500, 14, 'Roti Bakar.jpeg', 'Roti', '2025-11-19 00:58:07.494086');

-- --------------------------------------------------------

--
-- Table structure for table `tb_review`
--

CREATE TABLE `tb_review` (
  `id_review` int(11) NOT NULL,
  `id_pesanan` varchar(20) NOT NULL,
  `nama_pelanggan` varchar(255) NOT NULL,
  `id` int(11) NOT NULL,
  `nama_produk` varchar(50) NOT NULL,
  `rating` int(11) NOT NULL,
  `komentar` text NOT NULL,
  `waktu_review` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_review`
--

INSERT INTO `tb_review` (`id_review`, `id_pesanan`, `nama_pelanggan`, `id`, `nama_produk`, `rating`, `komentar`, `waktu_review`) VALUES
(1, '0', 'Suci Alfia', 66, 'Donat Bomboloni', 4, 'Enak🥯', '2025-10-26 18:16:04'),
(2, '0', 'Dela', 52, 'Strawberry Cream Cheese Puff', 4, 'enakk😋', '2025-11-07 07:47:18'),
(3, '0', 'Bima', 41, 'Red Velvet Cake', 5, 'Semua Enak', '2025-11-09 20:07:09'),
(4, '0', 'Anis', 25, 'Oatmeal Raisin Cookies', 5, '', '2025-11-09 20:12:26'),
(5, '0', 'Anis', 25, 'Oatmeal Raisin Cookies', 5, '', '2025-11-09 20:12:34'),
(6, '0', 'Anis', 25, 'Oatmeal Raisin Cookies', 5, 'yummy', '2025-11-09 20:22:39'),
(7, '0', 'Bima', 41, 'Red Velvet Cake', 5, '', '2025-11-09 20:29:54'),
(8, '0', 'Bima', 41, 'Red Velvet Cake', 5, 'Enak lohh', '2025-11-09 20:30:06'),
(9, '0', 'Bima', 41, 'Red Velvet Cake', 5, 'Enak lohh', '2025-11-09 20:30:16'),
(10, '0', 'Bima', 41, 'Red Velvet Cake', 5, 'Enak lohh', '2025-11-09 20:30:31'),
(11, '0', 'Aro', 4, 'Cappucino Bread', 5, 'yummy', '2025-11-09 20:37:12'),
(12, '0', 'Aro', 9, 'Croissant', 5, 'yummy', '2025-11-09 20:37:12'),
(13, '0', 'Aro', 67, 'Donat Oreo', 5, 'yummy', '2025-11-09 20:37:12'),
(14, '0', 'Aro', 32, 'Red Velvet Cookies', 5, 'yummy', '2025-11-09 20:37:12'),
(15, '0', 'Aro', 11, 'Brownies Panggang', 5, 'yummy', '2025-11-09 20:37:12'),
(16, '0', 'Dani', 7, 'Brioche ', 5, '', '2025-11-19 08:58:36'),
(17, '0', 'Dani', 29, 'Double Chocolate Cookies', 5, '', '2025-11-19 08:58:36'),
(18, '0', 'firda', 66, 'Donat Bomboloni', 5, 'enak', '2025-11-19 14:31:56'),
(19, '0', 'firda', 30, 'Cornflakes Cookies', 5, 'enak', '2025-11-19 14:31:56');

-- --------------------------------------------------------

--
-- Table structure for table `tb_users`
--

CREATE TABLE `tb_users` (
  `id_pesanan` varchar(255) NOT NULL,
  `no_antrian` int(11) NOT NULL,
  `nama_pelanggan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_users`
--

INSERT INTO `tb_users` (`id_pesanan`, `no_antrian`, `nama_pelanggan`) VALUES
('P0001', 1, 'Putri '),
('P0002', 2, 'Suci Alfia'),
('P0003', 3, 'Abimayu'),
('P0004', 4, 'Dewi Asih'),
('P0005', 5, 'Arrohmah'),
('P0006', 6, 'Aro'),
('P0007', 7, 'ciko'),
('P0008', 8, 'Dela'),
('P0009', 9, 'Arta'),
('P0010', 10, 'Sonia'),
('P0011', 11, 'pida'),
('P0012', 12, 'Firda'),
('P0013', 13, 'Anis'),
('P0014', 14, 'Firdausi'),
('P0015', 15, 'Putri'),
('P0016', 16, 'Bima'),
('P0017', 17, 'Pino'),
('P0018', 18, 'Dimas'),
('P0019', 19, 'anton'),
('P0020', 20, 'Dewi'),
('P0021', 21, 'DEWI'),
('P0022', 22, 'Dewi'),
('P0023', 23, 'Bima'),
('P0024', 24, 'Fitri'),
('P0025', 25, 'Asti'),
('P0026', 26, 'Nona'),
('P0027', 27, 'Antonio'),
('P0028', 28, 'Mita'),
('P0029', 29, 'Fajri'),
('P0030', 30, 'Marsha'),
('P0031', 31, 'Hana'),
('P0032', 32, 'Ica'),
('P0033', 33, 'Suci'),
('P0034', 34, 'Dani'),
('P0035', 35, 'sasa'),
('P0036', 36, 'Martin'),
('P0037', 37, 'Intan'),
('P0038', 38, 'Damara'),
('P0039', 39, 'Sana'),
('P0040', 40, 'firda'),
('P0041', 41, 'MAPI');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_admin`
--
ALTER TABLE `tb_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_daily_stock`
--
ALTER TABLE `tb_daily_stock`
  ADD PRIMARY KEY (`id_stok`);

--
-- Indexes for table `tb_detailpes`
--
ALTER TABLE `tb_detailpes`
  ADD PRIMARY KEY (`id_detail`);

--
-- Indexes for table `tb_penarikan`
--
ALTER TABLE `tb_penarikan`
  ADD PRIMARY KEY (`id_penarikan`);

--
-- Indexes for table `tb_produk`
--
ALTER TABLE `tb_produk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_review`
--
ALTER TABLE `tb_review`
  ADD PRIMARY KEY (`id_review`);

--
-- Indexes for table `tb_users`
--
ALTER TABLE `tb_users`
  ADD PRIMARY KEY (`no_antrian`,`id_pesanan`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_admin`
--
ALTER TABLE `tb_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tb_daily_stock`
--
ALTER TABLE `tb_daily_stock`
  MODIFY `id_stok` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=130;

--
-- AUTO_INCREMENT for table `tb_detailpes`
--
ALTER TABLE `tb_detailpes`
  MODIFY `id_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `tb_penarikan`
--
ALTER TABLE `tb_penarikan`
  MODIFY `id_penarikan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tb_produk`
--
ALTER TABLE `tb_produk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT for table `tb_review`
--
ALTER TABLE `tb_review`
  MODIFY `id_review` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `tb_users`
--
ALTER TABLE `tb_users`
  MODIFY `no_antrian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
