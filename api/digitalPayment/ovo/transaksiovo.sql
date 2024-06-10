-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 10, 2024 at 10:18 AM
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
-- Database: `soa`
--

-- --------------------------------------------------------

--
-- Table structure for table `transaksiovo`
--

CREATE TABLE `transaksiovo` (
  `id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `nomor_telepon` varchar(15) NOT NULL,
  `nominal` decimal(10,0) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaksiovo`
--

INSERT INTO `transaksiovo` (`id`, `timestamp`, `nomor_telepon`, `nominal`, `status`) VALUES
(2, '2024-06-08 10:36:22', '08123456789', 12000, 1),
(3, '2024-06-09 11:38:35', '08112233445', 10000, 1),
(4, '2024-06-09 11:39:29', '08112233445', 20000, 1),
(5, '2024-06-09 11:39:46', '08585858585', 30000, 0),
(6, '2024-06-09 11:39:55', '08123456789', 30000, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `transaksiovo`
--
ALTER TABLE `transaksiovo`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `transaksiovo`
--
ALTER TABLE `transaksiovo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
