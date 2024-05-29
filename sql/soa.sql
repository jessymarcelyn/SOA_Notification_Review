-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 29, 2024 at 06:02 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

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
-- Table structure for table `notifikasi`
--

CREATE TABLE `notifikasi` (
  `id_notif` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `tipe_notif` varchar(20) NOT NULL,
  `judul` varchar(50) NOT NULL,
  `deskripsi` varchar(100) NOT NULL,
  `timestamp_masuk` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `timestamp_announce` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` tinyint(1) NOT NULL,
  `link` varchar(20) DEFAULT NULL,
  `foto` blob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `notifikasi`
--

INSERT INTO `notifikasi` (`id_notif`, `id_user`, `tipe_notif`, `judul`, `deskripsi`, `timestamp_masuk`, `timestamp_announce`, `status`, `link`, `foto`) VALUES
(1, 1, 'promo', 'Hotel Bumi Diskon 50%', 'Dapatkan promo special menginap 2 malam dengan diskon 50%', '2024-05-29 10:57:19', '2024-05-29 10:57:19', 0, NULL, NULL),
(2, 2, 'promo', 'Tiket Taman Safari Promo!!', 'Ajak orang tersayang mengunjungi Taman Safari Prigen pada tanggal 1 Juni dengan harga special hanya ', '2024-05-29 10:59:06', '2024-05-29 10:59:06', 0, NULL, NULL),
(3, 1, 'pembayaran', 'Pembayaran melalui Gopay berhasil', 'Pembayaran utnuk transaksi T001 menggunakan gopay telah berhasil.', '2024-05-29 11:00:40', '2024-05-29 11:00:40', 0, NULL, NULL),
(4, 1, 'pembayaran', 'Pembayaran melalui Kartu Kredit berhasil', 'Pembayaran utnuk transaksi T001 menggunakan Kartu Kredit Bank BCA telah berhasil', '2024-05-29 11:01:24', '2024-05-29 11:01:24', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id_pembayaran` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_pesanan` int(11) NOT NULL,
  `timestamp` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE current_timestamp(),
  `sub_total` int(11) NOT NULL,
  `pajak` int(11) NOT NULL,
  `total_bayar` int(11) NOT NULL,
  `jenis_pembayaran` varchar(20) NOT NULL,
  `nama_penyedia` varchar(20) DEFAULT NULL,
  `nomer_kartu` varchar(16) DEFAULT NULL,
  `nomer_rekening` varchar(12) DEFAULT NULL,
  `nomer_telp` varchar(11) DEFAULT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pembayaran`
--

INSERT INTO `pembayaran` (`id_pembayaran`, `id_user`, `id_pesanan`, `timestamp`, `sub_total`, `pajak`, `total_bayar`, `jenis_pembayaran`, `nama_penyedia`, `nomer_kartu`, `nomer_rekening`, `nomer_telp`, `status`) VALUES
(1, 1, 1, '2024-05-29 10:46:32', 1000000, 100000, 1100000, 'kartu_kredit', '', '1231234564321234', NULL, NULL, 'success'),
(2, 2, 2, '2024-05-29 10:46:41', 500000, 50000, 550000, 'kartu_kredit', '', '4569365234789023', NULL, NULL, 'success'),
(3, 3, 3, '2024-05-29 10:46:50', 300000, 30000, 330000, 'digital_payment', 'OVO', NULL, NULL, '08145829345', 'success'),
(4, 4, 4, '2024-05-29 10:46:55', 150000, 15000, 165000, 'tranfer_bank', 'BCA', NULL, '12334887542', NULL, 'success'),
(5, 5, 5, '2024-05-29 10:47:00', 250000, 25000, 275000, 'transfer_bank', 'OCBC', NULL, '345674465123', NULL, 'success');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD PRIMARY KEY (`id_notif`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id_pembayaran`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `notifikasi`
--
ALTER TABLE `notifikasi`
  MODIFY `id_notif` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id_pembayaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
