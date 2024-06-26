-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 20, 2024 at 10:26 AM
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
-- Table structure for table `bankbca`
--

CREATE TABLE `bankbca` (
  `id` int(100) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `no_rek` varchar(255) NOT NULL,
  `pin` varchar(255) NOT NULL,
  `no_telp` varchar(14) NOT NULL,
  `saldo` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bankbca`
--

INSERT INTO `bankbca` (`id`, `nama`, `no_rek`, `pin`, `no_telp`, `saldo`) VALUES
(1, 'Nathalia Devita', '8630320624', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', '2147483647', 5680009),
(2, 'Jessys Marcelyn', '127566092', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', '2147483647', 7654100),
(4, 'Nathalia', '8630320333', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', '081211366021', 5680009),
(5, 'Rina', '5379412348874917', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', '08123123', 100000);

-- --------------------------------------------------------

--
-- Table structure for table `bankmandiri`
--

CREATE TABLE `bankmandiri` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `no_rek` varchar(255) NOT NULL,
  `pin` varchar(255) NOT NULL,
  `no_telp` varchar(14) NOT NULL,
  `saldo` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `gopay`
--

CREATE TABLE `gopay` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `nomor_telepon` varchar(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  `pin` varchar(100) NOT NULL,
  `saldo` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `gopay`
--

INSERT INTO `gopay` (`id`, `nama`, `nomor_telepon`, `email`, `pin`, `saldo`) VALUES
(1, 'ninu', '08123456789', 'n@gmail.com', '714327DF6D36BCC6DA5431A0B797594805FFB3277ACC1DEFD36C5E88626C4428', '50000'),
(2, 'beno', '08112233445', 'be@gmail.com', '96CAE35CE8A9B0244178BF28E4966C2CE1B8385723A96A6B838858CDD6CA0A1E', '20000'),
(5, 'sasa', '08585858585', 'sa@gmail.com', '96CAE35CE8A9B0244178BF28E4966C2CE1B8385723A96A6B838858CDD6CA0A1E', '100000');

-- --------------------------------------------------------

--
-- Table structure for table `kartu`
--

CREATE TABLE `kartu` (
  `id_kartu` int(11) NOT NULL,
  `nama` varchar(25) NOT NULL,
  `nomer_kartu` varchar(255) NOT NULL,
  `cvv` varchar(255) NOT NULL,
  `expired_year` int(4) NOT NULL,
  `expired_month` int(2) NOT NULL,
  `limit_maks` decimal(10,0) NOT NULL,
  `limit_terpakai` decimal(10,0) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kartu`
--

INSERT INTO `kartu` (`id_kartu`, `nama`, `nomer_kartu`, `cvv`, `expired_year`, `expired_month`, `limit_maks`, `limit_terpakai`, `status`) VALUES
(25, 'Jessy', '85df00411f072d601b21fc2e6db9e83e01d04d11169bc7f306e13d6b4c57e99b', '114bd151f8fb0c58642d2170da4ae7d7c57977260ac2cc8905306cab6b2acabc', 2029, 6, '1000000', '0', 1),
(26, 'Rina', 'e85acad0a469f9166744a79a1c9d33a11f735abca10f328b48ebbce3c10e75a8', 'f747870ae666c39b589f577856a0f7198b3b81269cb0326de86d8046f2cf72db', 2026, 5, '2000000', '0', 1),
(28, 'Hendra', '6993cf0cc46026086a561a3feba3dc8a6a593d32ab31d1e8b802ca51b4f3de19', '8ede6b26343305e05c3c0029f4e830d4e8c2016869a9d1cd97b100b2a16dfd1c', 2022, 3, '2000000', '0', 0),
(29, 'Santi', '855229ffcc832335b086c46feb926e6f4e013759a199c9d777ac51bb38a2533a', '793733573a1dfd14a2e889a11b2ad7b6981de29df813863b528dc1ae99416eeb', 2025, 2, '1000000', '0', 0),
(30, 'Andi', 'd688838fa7ab493a5e310dc529cdb4206da5edf97dafed3d297c8ff86ba64164', '30e26cef13a6dbbf0e3035f8c16f55670f4e468e97ac7dad43798621da636abf', 2025, 2, '1000000', '1000000', 1),
(31, 'Ariel', 'cd269b73fc92a164d9ae60ff2678db03c0eb21b597f3ebd20ecb4266ef720556', '182dc6b90f1c9cd913c39a6b5506f582caba9ddeadafe32f5bdbac25efd705ac', 2027, 1, '1000000', '800000', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notifikasi`
--

CREATE TABLE `notifikasi` (
  `id_notif` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_pesanan` int(11) NOT NULL,
  `tipe_notif` varchar(20) NOT NULL,
  `judul` varchar(50) NOT NULL,
  `deskripsi` varchar(100) NOT NULL,
  `timestamp_masuk` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `timestamp_announce` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` tinyint(1) NOT NULL,
  `link` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `notifikasi`
--

INSERT INTO `notifikasi` (`id_notif`, `id_user`, `id_pesanan`, `tipe_notif`, `judul`, `deskripsi`, `timestamp_masuk`, `timestamp_announce`, `status`, `link`) VALUES
(1, 1, 0, 'info', 'Perubah jadwal pesawat', 'Dapatkan promo special menginap 2 malam dengan diskon 50%', '2024-06-19 11:32:01', '2024-06-19 11:32:01', 1, NULL),
(2, 2, 0, 'info', 'Checkin pesawat', 'Ajak orang tersayang mengunjungi Taman Safari Prigen pada tanggal 1 Juni dengan harga special hanya ', '2024-06-16 20:14:53', '2024-06-16 20:14:53', 0, NULL),
(3, 1, 0, 'pembayaran', 'Pembayaran melalui Gopay berhasil', 'Pembayaran utnuk transaksi T001 menggunakan gopay telah berhasil.', '2024-06-19 11:26:45', '2024-06-19 11:26:45', 1, NULL),
(4, 1, 0, 'pembayaran', 'Pembayaran melalui Kartu Kredit berhasil', 'Pembayaran utnuk transaksi T001 menggunakan Kartu Kredit Bank BCA telah berhasil', '2024-06-19 11:26:46', '2024-06-19 11:26:46', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ovo`
--

CREATE TABLE `ovo` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `nomor_telepon` varchar(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  `pin` varchar(100) NOT NULL,
  `saldo` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ovo`
--

INSERT INTO `ovo` (`id`, `nama`, `nomor_telepon`, `email`, `pin`, `saldo`) VALUES
(1, 'ninu', '08123456789', 'n@gmail.com', '714327DF6D36BCC6DA5431A0B797594805FFB3277ACC1DEFD36C5E88626C4428', '50000'),
(2, 'beno', '08112233445', 'be@gmail.com', '96CAE35CE8A9B0244178BF28E4966C2CE1B8385723A96A6B838858CDD6CA0A1E', '20000'),
(5, 'sasa', '08585858585', 'sa@gmail.com', '96CAE35CE8A9B0244178BF28E4966C2CE1B8385723A96A6B838858CDD6CA0A1E', '100000');

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
(1, 1, 1, '2024-05-30 15:47:52', 1000000, 100000, 1100000, 'kartu_kredit', '', '1231234564321234', NULL, NULL, 'failed'),
(2, 2, 2, '2024-05-29 10:46:41', 500000, 50000, 550000, 'kartu_kredit', '', '4569365234789023', NULL, NULL, 'success'),
(3, 3, 3, '2024-05-29 10:46:50', 300000, 30000, 330000, 'digital_payment', 'OVO', NULL, NULL, '08145829345', 'success'),
(4, 4, 4, '2024-05-29 10:46:55', 150000, 15000, 165000, 'tranfer_bank', 'BCA', NULL, '12334887542', NULL, 'success'),
(5, 5, 5, '2024-05-29 10:47:00', 250000, 25000, 275000, 'transfer_bank', 'OCBC', NULL, '345674465123', NULL, 'success');

-- --------------------------------------------------------

--
-- Table structure for table `transaksigopay`
--

CREATE TABLE `transaksigopay` (
  `id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `nomor_telepon` varchar(15) NOT NULL,
  `nominal` decimal(10,0) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transaksigopay`
--

INSERT INTO `transaksigopay` (`id`, `timestamp`, `nomor_telepon`, `nominal`, `status`) VALUES
(2, '2024-06-08 10:36:22', '08123456789', '12000', 1),
(3, '2024-06-09 11:38:35', '08112233445', '10000', 1),
(4, '2024-06-09 11:39:29', '08112233445', '20000', 1),
(5, '2024-06-09 11:39:46', '08585858585', '30000', 0),
(6, '2024-06-09 11:39:55', '08123456789', '30000', 0);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transaksiovo`
--

INSERT INTO `transaksiovo` (`id`, `timestamp`, `nomor_telepon`, `nominal`, `status`) VALUES
(2, '2024-06-08 10:36:22', '08123456789', '12000', 1),
(3, '2024-06-09 11:38:35', '08112233445', '10000', 1),
(4, '2024-06-09 11:39:29', '08112233445', '20000', 1),
(5, '2024-06-09 11:39:46', '08585858585', '30000', 0),
(6, '2024-06-09 11:39:55', '08123456789', '30000', 0);

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_kartu`
--

CREATE TABLE `transaksi_kartu` (
  `id_transaksi` int(11) NOT NULL,
  `timestamp` datetime NOT NULL,
  `nomer_kartu` varchar(255) NOT NULL,
  `nominal` decimal(10,0) NOT NULL,
  `status` varchar(10) NOT NULL,
  `otp` varchar(255) NOT NULL,
  `otp_timestamp` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transaksi_kartu`
--

INSERT INTO `transaksi_kartu` (`id_transaksi`, `timestamp`, `nomer_kartu`, `nominal`, `status`, `otp`, `otp_timestamp`) VALUES
(27, '2024-06-10 21:58:53', 'e85acad0a469f9166744a79a1c9d33a11f735abca10f328b48ebbce3c10e75a8', '200000', 'ongoing', 'JPzywtpjhp/TaTZWRKNYeYigE1Um1g==', '2024-06-10 22:06:14'),
(28, '2024-06-10 22:09:11', 'e85acad0a469f9166744a79a1c9d33a11f735abca10f328b48ebbce3c10e75a8', '200000', '1', 'RiLcrkwjf/Ll9HyVr58bHzsRUpEb4Q==', '2024-06-10 22:09:11'),
(29, '2024-06-10 22:10:22', 'e85acad0a469f9166744a79a1c9d33a11f735abca10f328b48ebbce3c10e75a8', '200000', '1', '3/Tb+qSinZR9ytXOIV2ykRtAz+bxYQ==', '2024-06-10 22:10:22'),
(30, '2024-06-10 22:10:55', 'e85acad0a469f9166744a79a1c9d33a11f735abca10f328b48ebbce3c10e75a8', '200000', 'success', 'ZBrqu4Eb7ku2ysSQkFnPBv187zjNdA==', '2024-06-10 22:10:55'),
(31, '2024-06-19 22:46:48', '85df00411f072d601b21fc2e6db9e83e01d04d11169bc7f306e13d6b4c57e99b', '200000', 'ongoing', 'vujkAO1XkChnuyAyxGStZOgE89+gQg==', '2024-06-19 22:46:48'),
(32, '2024-06-19 22:48:31', '85df00411f072d601b21fc2e6db9e83e01d04d11169bc7f306e13d6b4c57e99b', '200000', 'ongoing', 'Ae+be4nA5J+BSfGUxeY5JgMf9tmlXg==', '2024-06-19 22:48:31'),
(33, '2024-06-19 22:48:54', '85df00411f072d601b21fc2e6db9e83e01d04d11169bc7f306e13d6b4c57e99b', '200000', 'ongoing', 'NhldX4eQkPtDCfU5NU37L9hDrmHpFg==', '2024-06-19 22:48:54'),
(34, '2024-06-19 22:49:39', '85df00411f072d601b21fc2e6db9e83e01d04d11169bc7f306e13d6b4c57e99b', '200000', 'ongoing', 'NMpvw+90VKF5XmbJswfxYA7GxnGKzg==', '2024-06-19 22:49:39'),
(35, '2024-06-19 22:50:28', '85df00411f072d601b21fc2e6db9e83e01d04d11169bc7f306e13d6b4c57e99b', '200000', 'ongoing', '5P8tAdNeiMLtHYWnkLGeSwzjtbFkVA==', '2024-06-19 22:50:28'),
(36, '2024-06-19 22:53:01', '85df00411f072d601b21fc2e6db9e83e01d04d11169bc7f306e13d6b4c57e99b', '200000', 'ongoing', 'x4NBz3lFbZbEePff10vDIVedrrD4OA==', '2024-06-19 22:53:01'),
(37, '2024-06-19 22:53:48', '85df00411f072d601b21fc2e6db9e83e01d04d11169bc7f306e13d6b4c57e99b', '200000', 'ongoing', 'DXP4fVMeb5bzVYzvVlaIqSrGtEH8Cw==', '2024-06-19 22:53:48'),
(38, '2024-06-19 22:56:11', '85df00411f072d601b21fc2e6db9e83e01d04d11169bc7f306e13d6b4c57e99b', '200000', 'ongoing', '/6g/PYGn+fjLtDYTdNWNUJdbi6V6bw==', '2024-06-19 22:56:11'),
(39, '2024-06-19 22:58:16', '85df00411f072d601b21fc2e6db9e83e01d04d11169bc7f306e13d6b4c57e99b', '200000', 'ongoing', 'ybpb/CXa1FTAFiNjN4DBKIvMw+YcoA==', '2024-06-19 22:58:16'),
(40, '2024-06-19 23:26:53', '85df00411f072d601b21fc2e6db9e83e01d04d11169bc7f306e13d6b4c57e99b', '200000', 'ongoing', '7I3ZQKWtazwudP8r16uFMp+G9mfCng==', '2024-06-19 23:26:53');

-- --------------------------------------------------------

--
-- Table structure for table `transbca`
--

CREATE TABLE `transbca` (
  `id` int(11) NOT NULL,
  `timestamp_trans` datetime NOT NULL,
  `no_telp` varchar(255) NOT NULL,
  `nominal` double NOT NULL,
  `status` varchar(25) NOT NULL,
  `va` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transbca`
--

INSERT INTO `transbca` (`id`, `timestamp_trans`, `no_telp`, `nominal`, `status`, `va`) VALUES
(1, '2024-06-08 11:05:07', '492194c3a6d05c54a88c400c6d31af8f57bf332965e546f5f6ff9e77adc71fa5', 1000000, 'ongoing', '0'),
(2, '2024-06-08 16:32:07', '492194c3a6d05c54a88c400c6d31af8f57bf332965e546f5f6ff9e77adc71fa5', 500968, 'failed', '0'),
(3, '2024-06-08 11:08:45', '492194c3a6d05c54a88c400c6d31af8f57bf332965e546f5f6ff9e77adc71fa5', 3568000, 'ongoing', '2147483647'),
(4, '2024-06-08 11:12:12', '492194c3a6d05c54a88c400c6d31af8f57bf332965e546f5f6ff9e77adc71fa5', 350000, 'ongoing', '2147483647'),
(5, '2024-06-10 15:10:20', '492194c3a6d05c54a88c400c6d31af8f57bf332965e546f5f6ff9e77adc71fa5', 569000, 'success', '2147483647'),
(6, '2024-06-10 15:15:19', '492194c3a6d05c54a88c400c6d31af8f57bf332965e546f5f6ff9e77adc71fa5', 213003, 'success', '2147483647'),
(7, '2024-06-10 20:26:57', 'c612d647f84b2ce77cff50c3a9f54c5ea806a987429542744fcda2afb694f392', 3213103, 'success', '2147483647'),
(8, '2024-06-10 20:27:45', '83492322', 0, 'success', '0'),
(9, '2024-06-20 15:10:52', '081211366021', 10000, 'ongoing', '2147483647'),
(10, '2024-06-20 15:13:34', '081211366021', 10000, 'ongoing', '2147483647'),
(11, '2024-06-20 15:14:39', '081211366021', 10000, 'ongoing', '2147483647'),
(12, '2024-06-20 15:14:58', '081211366021', 10000, 'ongoing', '2147483647'),
(13, '2024-06-20 15:15:27', '081211366021', 10000, 'ongoing', '2147483647'),
(14, '2024-06-20 15:17:48', '081211366021', 10000, 'ongoing', '2147483647'),
(15, '2024-06-20 15:20:14', '081211366021', 10000, 'ongoing', '2147483647'),
(16, '2024-06-20 15:21:15', '081211366021', 10000, 'ongoing', '2147483647'),
(17, '2024-06-20 15:23:44', '081211366021', 10000, 'ongoing', '122081211366');

-- --------------------------------------------------------

--
-- Table structure for table `transmandiri`
--

CREATE TABLE `transmandiri` (
  `id_trans` int(11) NOT NULL,
  `timestamp_trans` datetime NOT NULL,
  `no_telp` varchar(255) NOT NULL,
  `nominal` double NOT NULL,
  `status` varchar(25) NOT NULL,
  `va` int(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transmandiri`
--

INSERT INTO `transmandiri` (`id_trans`, `timestamp_trans`, `no_telp`, `nominal`, `status`, `va`) VALUES
(1, '2024-06-08 13:51:48', '582abf25bdcdaf616c7f2db9bf5cb5f078c5eec5d694784491f8759d9b869848', 176000, 'ongoing', 2147483647),
(2, '2024-06-08 13:52:13', 'd120ea13d9d5531d29ca6469f3d2b789093d6984acb4465d8c6a286a6de66a2f', 6780000, 'ongoing', 2147483647),
(3, '2024-06-08 16:06:08', '0439cc00ae56fc6fed61b5cbbcb4deafd10acb3f725b7ddeca634c0109ca9dab', 241000, 'failed', 2147483647),
(4, '2024-06-08 14:05:30', 'd41add8e9ea4e55a8df5745f75db4df33366b36cf8edf0ffc91522063d223da1', 32425300, 'ongoing', 2147483647),
(5, '2024-06-08 14:30:41', '4abe0465b548346e831074f206c8e974a66d832e7e8edaa4f0ac42a772f3212f', 6500892, 'ongoing', 2147483647),
(6, '2024-06-08 15:55:23', '92e373bfc13a21f56b5e80045d160210dd07494ed2d25a67116626fbdd121ed6', 8343100, 'success', 2147483647),
(7, '2024-06-08 16:05:45', 'e89f082d41ba2e8d33315a4cebf45439a0845309b40d5b486547a864cfd2150e', 7864000, 'success', 2147483647),
(8, '2024-06-08 16:08:51', 'b49c9530d73f1c0eeb52282df06da3f9b606f9ddbbd1440d980e52f9c49193cb', 1000000, 'failed', 2147483647);

-- --------------------------------------------------------

--
-- Table structure for table `trans_pembayaran`
--

CREATE TABLE `trans_pembayaran` (
  `id_pembayaran` int(100) NOT NULL,
  `id_pesanan` int(100) NOT NULL,
  `id_pesanan2` int(100) DEFAULT NULL,
  `id_transaksi` int(100) NOT NULL,
  `total_transaksi` double NOT NULL,
  `timestamp` datetime NOT NULL,
  `jenis_pembayaran` varchar(100) NOT NULL,
  `nama_penyedia` varchar(100) NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `trans_pembayaran`
--

INSERT INTO `trans_pembayaran` (`id_pembayaran`, `id_pesanan`, `id_pesanan2`, `id_transaksi`, `total_transaksi`, `timestamp`, `jenis_pembayaran`, `nama_penyedia`, `status`) VALUES
(23, 100, 0, 432, 0, '2024-06-08 19:25:10', 'Transfer Bank', 'Mandiri', 'ongoing'),
(44, 67, 0, 2112, 0, '2024-06-08 16:40:31', 'Transfer', 'Mandiri', 'failed'),
(45, 0, 2147483647, 0, 269, '2024-06-15 00:17:45', '', '', 'initial'),
(46, 0, NULL, 0, 269, '2024-06-15 00:19:53', '', '', 'initial'),
(47, 0, NULL, 0, 269, '2024-06-15 00:20:39', '', '', 'initial'),
(48, 1213, NULL, 2, 269, '2024-06-15 00:21:11', '', '', 'mmm'),
(49, 1, NULL, 0, 100000, '2024-06-19 14:00:18', '', '', 'initial'),
(50, 1, NULL, 0, 100000, '2024-06-19 14:00:18', '', '', 'initial'),
(51, 1, NULL, 0, 100000, '2024-06-19 14:00:29', '', '', 'initial'),
(52, 1, NULL, 0, 100000, '2024-06-19 14:00:33', '', '', 'initial'),
(53, 1, NULL, 0, 100000, '2024-06-19 14:00:45', '', '', 'initial'),
(54, 1, NULL, 0, 100000, '2024-06-19 14:01:30', '', '', 'initial'),
(55, 1, NULL, 0, 100000, '2024-06-19 14:05:01', '', '', 'initial'),
(56, 1, NULL, 0, 100000, '2024-06-19 14:06:37', '', '', 'initial'),
(57, 1, NULL, 0, 100000, '2024-06-19 14:06:58', '', '', 'initial'),
(58, 1, NULL, 0, 100000, '2024-06-19 14:11:17', '', '', 'initial'),
(59, 1, NULL, 0, 100000, '2024-06-19 14:11:29', '', '', 'initial'),
(60, 1, NULL, 0, 100000, '2024-06-19 14:16:51', '', '', 'initial'),
(61, 1, NULL, 0, 100000, '2024-06-19 14:17:31', '', '', 'initial'),
(62, 1, 2, 0, 200000, '2024-06-19 14:18:14', '', '', 'initial'),
(63, 1, NULL, 0, 100000, '2024-06-19 14:18:14', '', '', 'initial'),
(64, 1, 2, 0, 200000, '2024-06-19 14:18:32', '', '', 'initial'),
(65, 1, NULL, 0, 100000, '2024-06-19 14:25:16', '', '', 'initial'),
(66, 1, 2, 0, 200000, '2024-06-19 14:25:16', '', '', 'initial'),
(67, 1, NULL, 0, 100000, '2024-06-19 14:25:16', '', '', 'initial'),
(68, 1, NULL, 0, 100000, '2024-06-19 14:25:16', '', '', 'initial'),
(69, 1, 2, 0, 200000, '2024-06-19 14:25:16', '', '', 'initial'),
(70, 1, 2, 0, 200000, '2024-06-19 14:25:16', '', '', 'initial'),
(71, 1, 2, 0, 200000, '2024-06-19 14:25:23', '', '', 'initial'),
(72, 1, 2, 0, 200000, '2024-06-19 14:25:38', '', '', 'initial'),
(73, 1, NULL, 0, 100000, '2024-06-19 14:26:55', '', '', 'initial'),
(74, 1, NULL, 0, 100000, '2024-06-19 17:33:07', '', '', 'initial'),
(75, 1, NULL, 0, 100000, '2024-06-19 17:33:44', '', '', 'initial'),
(76, 1, NULL, 0, 100000, '2024-06-19 17:34:25', '', '', 'initial'),
(77, 1, NULL, 0, 100000, '2024-06-19 17:41:13', '', '', 'initial'),
(78, 1, NULL, 0, 100000, '2024-06-19 20:00:55', '', '', 'initial'),
(79, 1, NULL, 0, 100000, '2024-06-19 20:01:01', '', '', 'initial'),
(80, 1, NULL, 0, 100000, '2024-06-19 20:02:00', '', '', 'initial'),
(81, 1, NULL, 0, 100000, '2024-06-19 20:02:16', '', '', 'initial'),
(82, 1, NULL, 0, 100000, '2024-06-19 20:08:07', '', '', 'initial'),
(83, 1, NULL, 0, 100000, '2024-06-19 20:13:28', '', '', 'initial'),
(84, 1, NULL, 0, 100000, '2024-06-19 20:17:27', '', '', 'initial'),
(85, 1, NULL, 0, 100000, '2024-06-19 20:19:57', '', '', 'initial'),
(86, 1, NULL, 0, 100000, '2024-06-19 20:21:26', '', '', 'initial'),
(87, 1, NULL, 0, 100000, '2024-06-19 20:21:56', '', '', 'initial'),
(88, 0, NULL, 0, 269, '2024-06-19 20:22:40', '', '', 'initial'),
(89, 1, NULL, 0, 100000, '2024-06-19 20:25:22', '', '', 'initial'),
(90, 1, NULL, 0, 100000, '2024-06-19 20:25:51', '', '', 'initial'),
(91, 1, 2, 0, 200000, '2024-06-19 20:26:13', '', '', 'initial'),
(92, 1, NULL, 0, 100000, '2024-06-19 20:47:58', '', '', 'initial'),
(93, 1, NULL, 0, 100000, '2024-06-19 20:47:58', '', '', 'initial'),
(94, 1, NULL, 0, 100000, '2024-06-19 20:47:58', '', '', 'initial'),
(95, 1, NULL, 0, 100000, '2024-06-19 20:48:02', '', '', 'initial'),
(96, 1, NULL, 0, 100000, '2024-06-19 20:50:09', '', '', 'initial'),
(97, 1, NULL, 0, 100000, '2024-06-19 21:14:50', '', '', 'initial'),
(98, 1, NULL, 0, 100000, '2024-06-19 21:24:32', '', '', 'initial'),
(99, 1, NULL, 0, 100000, '2024-06-19 21:25:32', '', '', 'initial'),
(100, 1, NULL, 0, 100000, '2024-06-19 21:34:35', '', '', 'initial'),
(101, 1, NULL, 0, 100000, '2024-06-19 21:36:43', '', '', 'initial'),
(102, 1, NULL, 0, 100000, '2024-06-19 21:37:24', '', '', 'initial');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bankbca`
--
ALTER TABLE `bankbca`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `no_rek` (`no_rek`);

--
-- Indexes for table `bankmandiri`
--
ALTER TABLE `bankmandiri`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `no_rek` (`no_rek`);

--
-- Indexes for table `gopay`
--
ALTER TABLE `gopay`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kartu`
--
ALTER TABLE `kartu`
  ADD PRIMARY KEY (`id_kartu`);

--
-- Indexes for table `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD PRIMARY KEY (`id_notif`);

--
-- Indexes for table `ovo`
--
ALTER TABLE `ovo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id_pembayaran`);

--
-- Indexes for table `transaksigopay`
--
ALTER TABLE `transaksigopay`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaksiovo`
--
ALTER TABLE `transaksiovo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaksi_kartu`
--
ALTER TABLE `transaksi_kartu`
  ADD PRIMARY KEY (`id_transaksi`);

--
-- Indexes for table `transbca`
--
ALTER TABLE `transbca`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transmandiri`
--
ALTER TABLE `transmandiri`
  ADD PRIMARY KEY (`id_trans`);

--
-- Indexes for table `trans_pembayaran`
--
ALTER TABLE `trans_pembayaran`
  ADD PRIMARY KEY (`id_pembayaran`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bankbca`
--
ALTER TABLE `bankbca`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `bankmandiri`
--
ALTER TABLE `bankmandiri`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gopay`
--
ALTER TABLE `gopay`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `kartu`
--
ALTER TABLE `kartu`
  MODIFY `id_kartu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `notifikasi`
--
ALTER TABLE `notifikasi`
  MODIFY `id_notif` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ovo`
--
ALTER TABLE `ovo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id_pembayaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `transaksigopay`
--
ALTER TABLE `transaksigopay`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `transaksiovo`
--
ALTER TABLE `transaksiovo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `transaksi_kartu`
--
ALTER TABLE `transaksi_kartu`
  MODIFY `id_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `transbca`
--
ALTER TABLE `transbca`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `transmandiri`
--
ALTER TABLE `transmandiri`
  MODIFY `id_trans` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `trans_pembayaran`
--
ALTER TABLE `trans_pembayaran`
  MODIFY `id_pembayaran` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
